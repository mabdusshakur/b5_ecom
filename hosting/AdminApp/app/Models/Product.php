<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'short_des', 'price', 'is_discount', 'discount_price',
        'image', 'in_stock', 'stock', 'star', 'remark', 'category_id', 'brand_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function details()
    {
        return $this->hasOne(ProductDetail::class);
    }
}
