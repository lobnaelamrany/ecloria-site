<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'sku',
        'name_fr',
        'name_en',
        'name_de',
        'slug',
        'description_fr',
        'description_en',
        'description_de',
        'price',
        'stock_quantity',
        'low_stock_threshold',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'low_stock_threshold' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // ==========================================
    // Relations
    // ==========================================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_products')
                    ->withPivot('created_at');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(ProductBatch::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // ==========================================
    // Accessors
    // ==========================================

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        $field = 'name_' . $locale;
        // إلا ما كانتش الترجمة، كنرجعو للفرنسية
        return $this->$field ?? $this->name_fr ?? 'Produit';
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        $field = 'description_' . $locale;
        return $this->$field ?? $this->description_fr;
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return 'https://via.placeholder.com/400x533?text=ÉCLORIA';
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function hasActivePromotion(): bool
    {
        return $this->promotions()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->exists();
    }

    public function getActiveDiscountAttribute(): ?object
    {
        $promotions = $this->promotions()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->get();

        if ($promotions->isEmpty()) {
            return null;
        }

        $bestDiscount = null;
        $maxDiscountValue = 0;

        foreach ($promotions as $promo) {
            $discountAmount = $promo->discount_type === 'percentage'
                ? $this->price * ($promo->discount_value / 100)
                : $promo->discount_value;

            $discountAmount = min($discountAmount, $this->price);

            if ($discountAmount > $maxDiscountValue) {
                $maxDiscountValue = $discountAmount;
                $bestDiscount = (object) [
                    'promotion' => $promo,
                    'amount' => $discountAmount,
                    'final_price' => $this->price - $discountAmount,
                ];
            }
        }

        return $bestDiscount;
    }

    // ==========================================
    // Helpers
    // ==========================================

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }
}
