<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'order_status',
        'delivery_method',
        'address_id',
        'customer_name',
        'customer_phone',
        'shipping_city',
        'shipping_address',
        'shipping_postal_code',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'total_amount',
        'customer_note',
        'confirmed_at',
        'delivered_at',
        'collected_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'shipping_fee' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'confirmed_at' => 'datetime',
            'delivered_at' => 'datetime',
            'collected_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }
public function complaints(): HasMany
{
    return $this->hasMany(Complaint::class);
}
    // ==========================================
    // Relations
    // ==========================================
public function returns(): HasMany
{
    return $this->hasMany(ProductReturn::class);
}
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // ==========================================
    // Helpers
    // ==========================================

    public function isCancellable(): bool
    {
        return in_array($this->order_status, ['pending', 'confirmed']);
    }

    public function canBeReturned(): bool
    {
        return in_array($this->order_status, ['delivered', 'collected']);
    }
}
