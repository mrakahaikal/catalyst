<?php

namespace App\Models\Catalog;

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
        'brand_id', 'name', 'slug', 'sku', 'description',
        'price', 'compare_at_price', 'cost_price', 'stock',
        'is_visible', 'has_variants', 'product_type',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_visible' => 'boolean',
        'has_variants' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    // Relasi ke Definisi Opsi (Warna, Size)
    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    // Relasi ke Barang Fisik (SKU)
    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }
}
