<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::whereUserId(Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->whereUserId(Auth::id())
            ->with('items', 'payment')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function cancel(string $orderNumber): RedirectResponse
    {
        $order = Order::where('order_number', $orderNumber)
            ->whereUserId(Auth::id())
            ->firstOrFail();

        if (! $order->isCancellable()) {
            return back()->with('error', 'Cette commande ne peut plus être annulée.');
        }

        $order->update([
            'order_status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Commande annulée.');
    }
}
