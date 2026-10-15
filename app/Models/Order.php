<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'delivery_fee',
        'total_amount',
        'delivery_address',
        'contact_number',
        'delivery_method',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Customer na gumawa ng order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mga pizza item sa order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Delivery record ng order.
     */
    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }

    /**
     * Payment record ng order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Feedback at concerns na naka-link sa order.
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class, 'order_id');
    }
}