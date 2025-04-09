<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SSLCommerzCredential;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SslCommerzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SSLCommerzCredential::updateOrCreate([
            'id' => 1,
        ], [
            'store_id' => 'your_store_id',
            'store_password' => 'your_store_password',
            'currency' => 'BDT',
            'success_url' => 'http://localhost:8000/success',
            'fail_url' => 'http://localhost:8000/fail',
            'cancel_url' => 'http://localhost:8000/cancel',
            'ipn_url' => 'http://localhost:8000/ipn',
            'init_url' => 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php',
        ]);
    }
}
