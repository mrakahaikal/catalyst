<?php

namespace App\Models\Order;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'payment_status', 'shipping_status',
        'currency', 'subtotal', 'tax_amount', 'shipping_price', 'discount_amount', 'grand_total',
        'shipping_method', 'payment_method', 'notes',
        'shipping_address', 'billing_address',
        'paid_at', 'shipped_at',
    ];

    protected $casts = [
        'shipping_address' => 'array', // PENTING: JSON cast
        'billing_address' => 'array',  // PENTING: JSON cast
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
