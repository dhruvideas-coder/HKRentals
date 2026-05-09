<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'map_location'];

    protected $casts = [
        'map_location' => 'array',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalSpentAttribute(): float
    {
        return $this->orders()->sum('total_amount');
    }

    public function getLatestOrderAttribute(): ?Order
    {
        return $this->orders()->latest()->first();
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->name));
        $initials = strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) {
            $initials .= strtoupper(substr(end($words), 0, 1));
        }
        return $initials;
    }
}
