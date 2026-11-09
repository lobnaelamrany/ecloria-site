<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // التصنيفات النشطة (5 الأولى)
        $categories = Category::where('is_active', true)
            ->limit(5)
            ->get();

        // المنتجات المميزة (آخر 8 منتجات نشطة، مع Eager Loading)
        $featuredProducts = Product::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with('category', 'brand') // ← مهم باش ما يكونش N+1 Query
            ->latest()
            ->limit(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
