<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, OrderItem $orderItem): RedirectResponse
    {
        // تأكد أن الطلب ديال المستخدم و تم توصيله
        $order = $orderItem->order;
        if ($order->user_id !== Auth::id() || ! $order->canBeReturned()) {
            abort(403);
        }

        // تأكد ما كاينش تقييم سابق
        if ($orderItem->review()->exists()) {
            return back()->with('error', 'Vous avez déjà évalué ce produit.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $orderItem->product_id,
            'order_item_id' => $orderItem->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Merci pour votre avis !');
    }
}
