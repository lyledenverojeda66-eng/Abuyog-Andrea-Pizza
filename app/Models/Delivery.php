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
        'status',
        'payment_status',
        'payment_received_at',
        'picked_up_at',
        'delivered_at',
        'delivery_notes',
        'rider_latitude',
        'rider_longitude',
        'rider_location_updated_at',
        'proof_photo',
    ];

    protected $casts = [
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
        'payment_received_at' => 'datetime',
        'rider_location_updated_at' => 'datetime',
        'rider_latitude' => 'float',
        'rider_longitude' => 'float',
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
     * Get the assigned rider's phone number.
     * Falls back to the saved rider contact number.
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