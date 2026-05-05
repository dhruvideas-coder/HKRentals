<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price_per_day', 'deposit_percentage', 'total_quantity',
        'image', 'color', 'material', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
