<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price_per_day', 'start_date', 'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function getRentalDaysAttribute(): int
    {
        if ($this->start_date && $this->end_date) {
            return max(1, $this->start_date->diffInDays($this->end_date) + 1);
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
