<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    /**
     * إنشاء طلب جديد من السلة.
     *
     * @throws ValidationException
     */
    public function createOrder(Cart $cart, array $data): Order
    {
        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Votre panier est vide.',
            ]);
        }

        return DB::transaction(function () use ($cart, $data) {
            $subtotal = 0;
            $totalDiscount = 0;

            /** @var CartItem $item */
            foreach ($cart->items as $item) {
                $product = $item->product;
                $linePrice = $product->price * $item->quantity;
                $subtotal += $linePrice;

                // حساب الخصم ديال هاد المنتج (الترقيات)
                $discount = $this->calculateDiscount($product, $item->quantity);
                $totalDiscount += $discount;
            }

            $shippingFee = $this->calculateShippingFee($subtotal, $data['delivery_method']);
            $total = $subtotal - $totalDiscount + $shippingFee;

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $cart->user_id,
                'order_status' => 'pending',
                'delivery_method' => $data['delivery_method'],
                'address_id' => $data['address_id'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'shipping_city' => $data['shipping_city'],
                'shipping_address' => $data['shipping_address'] ?? null,
                'shipping_postal_code' => $data['shipping_postal_code'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'shipping_fee' => $shippingFee,
                'total_amount' => $total,
                'customer_note' => $data['customer_note'] ?? null,
            ]);

            /** @var CartItem $item */
            foreach ($cart->items as $item) {
                $product = $item->product;

                if ($product->stock_quantity < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "Stock insuffisant pour « {$product->name} ».",
                    ]);
                }

                $itemDiscount = $this->calculateDiscount($product, $item->quantity);
                $lineTotal = ($product->price * $item->quantity) - $itemDiscount;

                /** @var OrderItem $orderItem */
                $orderItem = $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->price,
                    'quantity' => $item->quantity,
                    'discount_amount' => $itemDiscount,
                    'line_total' => $lineTotal,
                ]);

                $this->deductStockWithFEFO($product, $item->quantity, $orderItem);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'amount' => $total,
                'refunded_amount' => 0,
            ]);

            $cart->items()->delete();

            return $order;
        });
    }

    /**
     * حساب الخصم ديال منتج بناءً على الترقيات النشطة.
     */
    private function calculateDiscount(Product $product, int $quantity): float
    {
        $now = now();

        $promotions = $product->promotions()
            ->where('is_active', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now)
            ->get();

        if ($promotions->isEmpty()) {
            return 0;
        }

        $maxDiscountPerUnit = 0;

        foreach ($promotions as $promotion) {
            $discountPerUnit = $promotion->discount_type === 'percentage'
                ? $product->price * ($promotion->discount_value / 100)
                : $promotion->discount_value;

            $discountPerUnit = min($discountPerUnit, $product->price);
            $maxDiscountPerUnit = max($maxDiscountPerUnit, $discountPerUnit);
        }

        return $maxDiscountPerUnit * $quantity;
    }

    private function calculateShippingFee(float $subtotal, string $deliveryMethod): float
    {
        if ($deliveryMethod === 'store_pickup') {
            return 0;
        }

        return (float) config('ecloria.shipping_fee', 30);
    }

    /**
     * إنقاص المخزون بـ FEFO (First Expired, First Out).
     */
    private function deductStockWithFEFO(Product $product, int $quantity, OrderItem $orderItem): void
    {
        $remaining = $quantity;

        /** @var \Illuminate\Database\Eloquent\Collection<int, ProductBatch> $batches */
        $batches = ProductBatch::whereProductId($product->id)
            ->where('quantity_remaining', '>', 0)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>=', now()->toDateString());
            })
            ->orderByRaw('expiry_date IS NULL, expiry_date ASC')
            ->get();

        if ($batches->sum('quantity_remaining') < $quantity) {
            throw ValidationException::withMessages([
                'cart' => "Stock en lots insuffisant pour « {$product->name} ».",
            ]);
        }

        /** @var ProductBatch $batch */
        foreach ($batches as $batch) {
            if ($remaining <= 0) {
                break;
            }

            $take = min($remaining, (int) $batch->getAttribute('quantity_remaining'));

            $batch->decrement('quantity_remaining', $take);
            $remaining -= $take;

            StockMovement::create([
                'product_id' => $product->id,
                'product_batch_id' => $batch->id,
                'order_item_id' => $orderItem->id,
                'movement_type' => 'sale',
                'direction' => 'out',
                'quantity' => $take,
                'created_by' => Auth::id(),
                'notes' => "Vente — Commande {$orderItem->order->order_number}",
            ]);
        }

        $product->decrement('stock_quantity', $quantity);
    }

    private function generateOrderNumber(): string
    {
        $prefix = config('ecloria.order_prefix', 'ORD');
        $date = now()->format('Ymd');

        /** @var Order|null $lastOrder */
        $lastOrder = Order::where('order_number', 'like', "{$prefix}-{$date}-%")
            ->orderByDesc('id')
            ->first();

        $sequence = 1;
        if ($lastOrder) {
            $parts = explode('-', $lastOrder->getAttribute('order_number'));
            $sequence = (int) end($parts) + 1;
        }

        return sprintf('%s-%s-%04d', $prefix, $date, $sequence);
    }
}
