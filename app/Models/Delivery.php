<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'rider_id',
        'rider_name',
        'rider_contact',
        'picked_up_at',
        'delivered_at',
        'delivery_notes',
        'status',
        'payment_status',
        'payment_received_at',
    ];

    protected $casts = [
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
        'payment_received_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function rider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

    /**
     * Kunin ang contact number ng assigned rider.
     * Gamitin ang rider_contact bilang fallback.
     */
    public function getRiderPhoneAttribute(): ?string
    {
        $phone = $this->rider?->phone;

        if (filled($phone)) {
            return $phone;
        }

        return $this->rider_contact ?: null;
    }
}
