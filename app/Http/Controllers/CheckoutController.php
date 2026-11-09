<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $user = Auth::user();
        $shippingFee = (float) config('ecloria.shipping_fee', 30);
        $freeThreshold = (float) config('ecloria.free_shipping_threshold', 500);

        return view('checkout.index', compact('cart', 'user', 'shippingFee', 'freeThreshold'));
    }

    public function store(Request $request, OrderService $orderService): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:30',
            'delivery_method' => 'required|in:delivery,store_pickup',
            'payment_method' => 'required|in:cash_on_delivery,payment_at_store',
            'shipping_city' => 'required|string|max:100',
            'shipping_address' => 'required_if:delivery_method,delivery|nullable|string|max:255',
            'shipping_postal_code' => 'nullable|string|max:20',
            'customer_note' => 'nullable|string|max:1000',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product');

        try {
            $order = $orderService->createOrder($cart, $validated);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(string $orderNumber): View
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items', 'payment')
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
