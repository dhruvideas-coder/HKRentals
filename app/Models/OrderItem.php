<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price_per_day', 'start_date', 'end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function getRentalDaysAttribute(): int
    {
        if ($this->start_date && $this->end_date) {
            return \App\Helpers\RentalHelper::calculateDays($this->start_date, $this->end_date);
        }
        return 2;
    }

    public function getLineTotalAttribute(): float
    {
        // Price is per 2 days: 1 day=1x, 2 days=1x, 3 days=1.5x, 4 days=2x, etc.
        $multiplier = max(1, $this->rental_days / 2);
        return $this->quantity * $this->price_per_day * $multiplier;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
