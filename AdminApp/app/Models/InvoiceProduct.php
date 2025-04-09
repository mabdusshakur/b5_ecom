<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable = ['quantity', 'price', 'size', 'color', 'product_id', 'invoice_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
