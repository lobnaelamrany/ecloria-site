<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items', 'payment', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,collected,cancelled',
        ]);

        $newStatus = $validated['order_status'];
        $updates = ['order_status' => $newStatus];

        if ($newStatus === 'confirmed' && ! $order->confirmed_at) {
            $updates['confirmed_at'] = now();
        }
        if ($newStatus === 'delivered') {
            $updates['delivered_at'] = now();
        }
        if ($newStatus === 'collected') {
            $updates['collected_at'] = now();
        }
        if ($newStatus === 'cancelled') {
            $updates['cancelled_at'] = now();
        }

        $order->update($updates);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    public function updatePayment(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,partially_refunded,refunded',
        ]);

        $updates = ['payment_status' => $validated['payment_status']];

        if ($validated['payment_status'] === 'paid' && ! $order->payment->paid_at) {
            $updates['paid_at'] = now();
            $updates['received_by'] = Auth::id();
        }

        $order->payment->update($updates);

        return back()->with('success', 'Statut de paiement mis à jour.');
    }
}
