<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'customer_name', 'customer_email', 'customer_phone',
        'customer_address', 'event_date', 'total_amount', 'traveling_cost',
        'distance_km', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getFormattedIdAttribute(): string
    {
        return 'SKR-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'bg-amber-100 text-amber-700',
            'confirmed' => 'bg-brand-100 text-brand-700',
            'active'    => 'bg-green-100 text-green-700',
            'completed' => 'bg-neutral-100 text-neutral-600',
            'cancelled' => 'bg-red-100 text-red-600',
            default     => 'bg-neutral-100 text-neutral-500',
        };
    }
}
