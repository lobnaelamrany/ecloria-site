<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('creator')->latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        $promotion = Promotion::create($validated);
$promotion->products()->syncWithPivotValues($validated['product_ids'], ['created_at' => now()]);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion créée.');
    }

    public function edit(Promotion $promotion)
    {
        $products = Product::where('is_active', true)->get();
        $selectedProducts = $promotion->products->pluck('id')->toArray();
        return view('admin.promotions.edit', compact('promotion', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $promotion->update($validated);
$promotion->products()->syncWithPivotValues($validated['product_ids'], ['created_at' => now()]);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion mise à jour.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return back()->with('success', 'Promotion supprimée.');
    }
}
