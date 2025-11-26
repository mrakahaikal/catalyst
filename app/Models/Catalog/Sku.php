<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sku extends Model
{
    protected $fillable = ['product_id', 'code', 'price', 'stock'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi many-to-many ke OptionValues lewat tabel pivot sku_values
    // Contoh: SKU-001 terhubung ke "Merah" dan "XL"
    public function values(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductOptionValue::class,
            'sku_values',
            'sku_id',
            'product_option_value_id'
        );
    }
}
