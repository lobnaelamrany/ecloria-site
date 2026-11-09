<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_type',
        'discount_value',
        'starts_at',
        'ends_at',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // ==========================================
    // Relations
    // ==========================================

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function products(): BelongsToMany
{
    return $this->belongsToMany(Product::class, 'promotion_products')
                ->withPivot('created_at'); // ← بدل withTimestamps()
}
    // ==========================================
    // Helpers
    // ==========================================

    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->is_active
            && $this->starts_at <= $now
            && $this->ends_at >= $now;
    }

    // حساب السعر بعد التخفيض لمنتج معين
    public function calculateDiscountedPrice(float $originalPrice): float
    {
        $discounted = $this->discount_type === 'percentage'
            ? $originalPrice - ($originalPrice * $this->discount_value / 100)
            : $originalPrice - $this->discount_value;

        return max(0, $discounted); // لا ينزل تحت الصفر
    }
}
