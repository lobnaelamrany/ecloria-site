<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBatch;
use App\Models\StockMovement;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        // المنتجات اللي المخزون ديالها ضعيف
        $lowStockProducts = \App\Models\Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->where('is_active', true)
            ->with('category')
            ->get();

        // الدفعات اللي قربت تنتهي (شهر الجاي)
        $expiringBatches = ProductBatch::whereNotNull('expiry_date')
            ->where('quantity_remaining', '>', 0)
            ->where('expiry_date', '<=', now()->addDays(30))
            ->with('product')
            ->orderBy('expiry_date')
            ->get();

        // إحصائيات
        $stats = [
            'total_batches' => ProductBatch::where('quantity_remaining', '>', 0)->count(),
'total_stock_value' => \App\Models\Product::sum(\Illuminate\Support\Facades\DB::raw('price * stock_quantity')),            'low_stock_count' => $lowStockProducts->count(),
            'expiring_count' => $expiringBatches->count(),
        ];

        return view('admin.stock.index', compact('lowStockProducts', 'expiringBatches', 'stats'));
    }

    public function batches(): View
    {
        $batches = ProductBatch::with('product')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.stock.batches', compact('batches'));
    }

    public function movements(): View
    {
        $movements = StockMovement::with('product', 'batch', 'creator')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.stock.movements', compact('movements'));
    }
}
