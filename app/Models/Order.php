<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'status',
        'payment_status',
        'currency',
        'subtotal',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_method',
        'delivery_address',
        'delivery_date',
        'notes',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'payment_error',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'delivery_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}