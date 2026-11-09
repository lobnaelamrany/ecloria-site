<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReturn extends Model
{
    use HasFactory;

    // اسم الجدول (لأن Laravel سيحاول البحث عن product_returns)
    protected $table = 'returns';

    protected $fillable = [
        'return_number',
        'order_id',
        'user_id',
        'return_status',
        'reason',
        'reviewed_by',
        'reviewed_at',
        'received_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    // ==========================================
    // Relations
    // ==========================================

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }

    // ==========================================
    // Helpers
    // ==========================================

    public function canBeReviewed(): bool
    {
        return $this->return_status === 'requested';
    }

    public function canBeReceived(): bool
    {
        return $this->return_status === 'approved';
    }

    public function canBeRefunded(): bool
    {
        return $this->return_status === 'received';
    }
}
