<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class ReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_id',
        'order_item_id',
        'quantity',
        'item_condition',
        'restockable',
        'refund_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'restockable' => 'boolean',
            'refund_amount' => 'decimal:2',
        ];
    }

    public function productReturn(): BelongsTo
    {
        return $this->belongsTo(ProductReturn::class, 'return_id');
    }
public function stockMovements(): HasMany
{
    return $this->hasMany(StockMovement::class);
}
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
