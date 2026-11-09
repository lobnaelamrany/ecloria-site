<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_fr',
        'name_en',
        'name_de',
        'slug',
        'description_fr',
        'description_en',
        'description_de',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Accessor: الاسم حسب اللغة الحالية، مع الرجوع إلى الفرنسية إذا لم يتوفر
    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        $field = 'name_' . $locale;
        return $this->$field ?? $this->name_fr;
    }
}
