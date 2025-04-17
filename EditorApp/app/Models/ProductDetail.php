<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = ['img1', 'img2', 'img3', 'img4', 'description', 'color', 'size', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
