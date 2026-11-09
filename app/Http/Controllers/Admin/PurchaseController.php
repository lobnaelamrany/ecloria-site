<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier', 'creator')->latest()->paginate(10);
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        return view('admin.purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity_ordered' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $prefix = 'PUR';
            $date = now()->format('Ymd');
            $lastPurchase = Purchase::where('purchase_number', 'like', "{$prefix}-{$date}-%")->orderByDesc('id')->first();
            $sequence = 1;
            if ($lastPurchase) {
                $parts = explode('-', $lastPurchase->purchase_number);
                $sequence = (int) end($parts) + 1;
            }
            $purchaseNumber = sprintf('%s-%s-%04d', $prefix, $date, $sequence);

            $totalCost = 0;
            foreach ($validated['items'] as $item) {
                $totalCost += $item['quantity_ordered'] * $item['unit_cost'];
            }

            $purchase = Purchase::create([
                'purchase_number' => $purchaseNumber,
                'supplier_id' => $validated['supplier_id'],
                'created_by' => Auth::id(),
                'purchase_status' => 'draft',
                'purchase_date' => $validated['purchase_date'],
                'total_cost' => $totalCost,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'quantity_received' => 0,
                    'unit_cost' => $item['unit_cost'],
                    'line_total' => $item['quantity_ordered'] * $item['unit_cost'],
                ]);
            }
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Achat créé (en draft).');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'creator', 'items.product');
        return view('admin.purchases.show', compact('purchase'));
    }

    public function receive(Request $request, Purchase $purchase)
    {
        if ($purchase->purchase_status === 'received') {
            return back()->with('error', 'Cet achat est déjà reçu.');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.quantity_received' => 'required|integer|min:1',
            'items.*.batch_number' => 'nullable|string|max:50',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($purchase, $validated) {
            foreach ($purchase->items as $item) {
                $qty = (int) ($validated['items'][$item->id]['quantity_received'] ?? 0);
                if ($qty <= 0) continue;

                $item->update(['quantity_received' => $qty]);

                // إنشاء batch
                $batchNumber = $validated['items'][$item->id]['batch_number'] ?? ('BATCH-' . time() . '-' . $item->id);
                $expiryDate = $validated['items'][$item->id]['expiry_date'] ?? null;

                $batch = $item->batches()->create([
                    'product_id' => $item->product_id,
                    'batch_number' => $batchNumber,
                    'expiry_date' => $expiryDate,
                    'quantity_received' => $qty,
                    'quantity_remaining' => $qty,
                    'received_at' => now(),
                ]);

                // تحديث مخزون المنتج
                $item->product()->increment('stock_quantity', $qty);

                // تسجيل حركة المخزون
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'product_batch_id' => $batch->id,
                    'purchase_item_id' => $item->id,
                    'movement_type' => 'purchase',
                    'direction' => 'in',
                    'quantity' => $qty,
                    'created_by' => Auth::id(),
                    'notes' => "Achat {$purchase->purchase_number}",
                ]);
            }

            $purchase->update([
                'purchase_status' => 'received',
                'received_at' => now(),
            ]);
        });

        return back()->with('success', 'Achat reçu, batches créés, stock mis à jour.');
    }

    public function cancel(Purchase $purchase)
    {
        if ($purchase->purchase_status === 'received') {
            return back()->with('error', 'Impossible d\'annuler un achat reçu.');
        }
        $purchase->update(['purchase_status' => 'cancelled']);
        return back()->with('success', 'Achat annulé.');
    }
}
