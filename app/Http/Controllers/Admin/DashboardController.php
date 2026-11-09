<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('order_status', '!=', 'cancelled')->sum('total_amount'),
            'total_products' => Product::where('is_active', true)->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'low_stock_products' => Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
