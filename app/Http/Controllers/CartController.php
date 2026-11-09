<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function index(): View
    {
        $cart = $this->getCart();
        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        ]);

        if ($product->stock_quantity < 1) {
            return back()->with('error', 'Ce produit est en rupture de stock.');
        }

        $cart = $this->getCart();
        $quantity = (int) $request->quantity;

        /** @var \App\Models\CartItem|null $item */
        $item = $cart->items()->whereProductId($product->id)->first();

        if ($item) {
            $newQuantity = $item->quantity + $quantity;
            if ($newQuantity > $product->stock_quantity) {
                return back()->with('error', 'Quantité demandée supérieure au stock disponible.');
            }
            $item->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier !');
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->product->stock_quantity,
        ]);

        $item->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour.');
    }

    public function remove(CartItem $item): RedirectResponse
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }

    public function clear(): RedirectResponse
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }
}
