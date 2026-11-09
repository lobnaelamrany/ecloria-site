<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('brands.index', compact('brands'));
    }

    public function show(string $slug): View
    {
        $brand = Brand::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $brand->products()
            ->where('is_active', true)
            ->with('category')
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }
}
