<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'total', 'vat', 'payable', 'cus_details', 'ship_details',
        'tran_id', 'val_id', 'delivery_status', 'payment_status', 'customer_id'
    ];

    protected $casts = [
        'cus_details' => 'array',
        'ship_details' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
