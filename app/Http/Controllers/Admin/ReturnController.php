<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBatch;
use App\Models\ProductReturn;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = ProductReturn::with('order', 'user')->latest()->paginate(15);
        return view('admin.returns.index', compact('returns'));
    }

    public function show(ProductReturn $return)
    {
        $return->load('order', 'user', 'items.orderItem');
        return view('admin.returns.show', compact('return'));
    }

    public function updateStatus(Request $request, ProductReturn $return)
    {
        $validated = $request->validate([
            'return_status' => 'required|in:approved,rejected,received,refunded,cancelled',
        ]);

        DB::transaction(function () use ($return, $validated) {
            $newStatus = $validated['return_status'];
            $updates = ['return_status' => $newStatus];

            if ($newStatus === 'approved' || $newStatus === 'rejected') {
                $updates['reviewed_by'] = Auth::id();
                $updates['reviewed_at'] = now();
            }

            if ($newStatus === 'received') {
                $updates['received_at'] = now();

                // إرجاع المنتجات للمخزون (غير اللي صالحين)
                foreach ($return->items as $item) {
                    if (! $item->restockable) continue;

                    $orderItem = $item->orderItem;
                    // نختارو Batch موجود ديال هاد المنتج
                    $batch = ProductBatch::where('product_id', $orderItem->product_id)
                        ->where('quantity_remaining', '>', 0)
                        ->orderBy('expiry_date')
                        ->first();

                    if ($batch) {
                        $batch->increment('quantity_remaining', $item->quantity);
                        $orderItem->product()->increment('stock_quantity', $item->quantity);

                        StockMovement::create([
                            'product_id' => $orderItem->product_id,
                            'product_batch_id' => $batch->id,
                            'return_item_id' => $item->id,
                            'movement_type' => 'return',
                            'direction' => 'in',
                            'quantity' => $item->quantity,
                            'created_by' => Auth::id(),
                            'notes' => "Retour {$return->return_number}",
                        ]);
                    }
                }
            }

            $return->update($updates);
        });

        return back()->with('success', 'Statut du retour mis à jour.');
    }
}
