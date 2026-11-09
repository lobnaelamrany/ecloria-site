<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductReturn;
use App\Models\ReturnItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function index(): View
    {
        $returns = ProductReturn::whereUserId(Auth::id())
            ->with('order', 'items')
            ->latest()
            ->paginate(10);

        return view('returns.index', compact('returns'));
    }

    public function create(Order $order): View
    {
        // تأكد أن الطلب ديال المستخدم و قابل للإرجاع
        if ($order->user_id !== Auth::id() || ! $order->canBeReturned()) {
            abort(403);
        }

        $order->load('items');

        return view('returns.create', compact('order'));
    }

    public function store(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id() || ! $order->canBeReturned()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.item_condition' => 'required|in:unopened,opened,damaged,other',
        ]);

        // إنشاء رقم الإرجاع
        $prefix = 'RET';
        $date = now()->format('Ymd');
        $lastReturn = ProductReturn::where('return_number', 'like', "{$prefix}-{$date}-%")->orderByDesc('id')->first();
        $sequence = 1;
        if ($lastReturn) {
            $parts = explode('-', $lastReturn->return_number);
            $sequence = (int) end($parts) + 1;
        }
        $returnNumber = sprintf('%s-%s-%04d', $prefix, $date, $sequence);

        $return = ProductReturn::create([
            'return_number' => $returnNumber,
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'return_status' => 'requested',
            'reason' => $validated['reason'],
        ]);

        foreach ($validated['items'] as $item) {
            $orderItem = $order->items()->find($item['order_item_id']);
            if (! $orderItem) continue;

            $return->items()->create([
                'order_item_id' => $orderItem->id,
                'quantity' => $item['quantity'],
                'item_condition' => $item['item_condition'],
                'restockable' => $item['item_condition'] === 'unopened',
                'refund_amount' => $orderItem->unit_price * $item['quantity'],
            ]);
        }

        return redirect()->route('returns.index')->with('success', 'Demande de retour créée.');
    }
}
