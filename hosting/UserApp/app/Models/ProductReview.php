<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = ['description', 'rating', 'product_id', 'customer_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(){
        return $this->belongsTo(CustomerProfile::class);
    }
}
