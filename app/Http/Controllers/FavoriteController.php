<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $favorites = $user
            ->favorites()
            ->with('product.brand')
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        $userId = Auth::id();

        /** @var \App\Models\Favorite|null $favorite */
        $favorite = Favorite::whereUserId($userId)
            ->whereProductId($product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Produit retiré des favoris.');
        }

        Favorite::create([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Produit ajouté aux favoris !');
    }
}
