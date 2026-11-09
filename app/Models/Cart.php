<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * مجموع السلة قبل الخصم (السعر الأصلي).
     */
    public function getRawSubtotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * مجموع الخصم الإجمالي (من الترقيات).
     */
    public function getTotalDiscountAttribute(): float
    {
        $totalDiscount = 0;

        foreach ($this->items as $item) {
            $product = $item->product;
            $promos = $product->promotions()
                ->where('is_active', true)
                ->where('starts_at', '<=', now())
                ->where('ends_at', '>=', now())
                ->get();

            $maxDiscount = 0;
            foreach ($promos as $promo) {
                $d = $promo->discount_type === 'percentage'
                    ? $product->price * ($promo->discount_value / 100)
                    : $promo->discount_value;
                $maxDiscount = max($maxDiscount, min($d, $product->price));
            }

            $totalDiscount += $maxDiscount * $item->quantity;
        }

        return $totalDiscount;
    }

    /**
     * المجموع النهائي بعد الخصم (بدون التوصيل).
     */
    public function getSubtotalAttribute(): float
    {
        return $this->raw_subtotal - $this->total_discount;
    }

    /**
     * عدد العناصر فـ السلة.
     */
    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}
