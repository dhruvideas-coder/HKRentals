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
            $start = $this->start_date->copy()->startOfDay();
            $end   = $this->end_date->copy()->startOfDay();
            return max(1, $start->diffInDays($end) + 1);
        }
        return 1;
    }

    public function getLineTotalAttribute(): float
    {
        return $this->quantity * $this->price_per_day * $this->rental_days;
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
