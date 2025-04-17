<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SSLCommerzCredential extends Model
{
    protected $table = "SSLcommerz_credentials";

    protected $fillable = [
        'store_id', 'store_password', 'currency', 'success_url',
        'fail_url', 'cancel_url', 'ipn_url', 'init_url'
    ];
}
