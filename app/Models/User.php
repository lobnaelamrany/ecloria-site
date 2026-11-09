<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ==========================================
    // Accessors
    // ==========================================

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    // ==========================================
    // Role helpers
    // ==========================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }
public function reviews(): HasMany
{
    return $this->hasMany(Review::class);
}

public function complaints(): HasMany
{
    return $this->hasMany(Complaint::class);
}

public function assignedComplaints(): HasMany
{
    return $this->hasMany(Complaint::class, 'assigned_to');
}

public function userNotifications(): HasMany
{
    return $this->hasMany(UserNotification::class);
}
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    // ==========================================
    // Permission helpers
    // ==========================================
public function orders(): HasMany
{
    return $this->hasMany(Order::class);
}
    public function hasPermission(string $permissionName): bool
    {
        if ($this->isAdmin()) {
            return true; // Admin يملك جميع الصلاحيات
        }

        return $this->permissions()->where('name', $permissionName)->exists();
    }
public function returns(): HasMany
{
    return $this->hasMany(ProductReturn::class);
}

public function reviewedReturns(): HasMany
{
    return $this->hasMany(ProductReturn::class, 'reviewed_by');
}
    // ==========================================
    // Relations
    // ==========================================
public function createdPurchases(): HasMany
{
    return $this->hasMany(Purchase::class, 'created_by');
}
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
public function cart(): HasOne
{
    return $this->hasOne(Cart::class);
}
public function createdPromotions(): HasMany
{
    return $this->hasMany(Promotion::class, 'created_by');
}
public function favorites(): HasMany
{
    return $this->hasMany(Favorite::class);
}
    public function permissions(): BelongsToMany
{
    return $this->belongsToMany(Permission::class, 'user_permissions')
                ->withPivot('granted_by');
}
}
