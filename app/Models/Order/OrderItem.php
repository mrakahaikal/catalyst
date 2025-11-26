<?php

namespace App\Models\Order;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'sku_id',
        'product_name', 'variant_name',
        'unit_price', 'quantity', 'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        // Nullable karena produk master bisa aja dihapus (soft delete),
        // tapi history order gak boleh error.
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
