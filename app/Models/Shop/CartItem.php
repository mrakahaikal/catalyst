<?php

namespace App\Models\Shop;

use App\Models\Catalog\Product;
use App\Models\Catalog\Sku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'sku_id', 'quantity', 'options'];

    protected $casts = [
        'options' => 'array', // Otomatis jadi array/object saat diakses
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}
