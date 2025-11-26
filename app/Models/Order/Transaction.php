<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'payment_gateway',
        'transaction_id',
        'payment_type',
        'amount',
        'status',
        'payload',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
