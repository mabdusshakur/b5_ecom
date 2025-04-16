<?php

namespace App\Helpers;

use App\Models\Invoice;
use App\Models\SSLCommerzCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class SSLCommerz
{

    static function InitiatePayment($profile, $products, $payable, $tran_id, $user_email): JsonResponse | array
    {
        try {
            $ssl = SSLCommerzCredential::first();
            $response = Http::asForm()->post($ssl->init_url, [
                "store_id" => $ssl->store_id,
                "store_passwd" => $ssl->store_password,
                "total_amount" => $payable,
                "currency" => $ssl->currency,
                "tran_id" => $tran_id,
                "success_url" => rtrim($ssl->success_url, '/') . "?tran_id=" . $tran_id,
                "fail_url" => rtrim($ssl->fail_url, '/') . "?tran_id=" . $tran_id,
                "cancel_url" => rtrim($ssl->cancel_url, '/') . "?tran_id=" . $tran_id,
                "ipn_url" => $ssl->ipn_url,
                "cus_name" => $profile->cus_name,
                "cus_email" => $user_email,
                "cus_add1" => $profile->cus_add,
                "cus_add2" => $profile->cus_add,
                "cus_city" => $profile->cus_add,
                "cus_state" => $profile->cus_state,
                "cus_postcode" => $profile->cus_postcode,
                "cus_country" => $profile->cus_country,
                "cus_phone" => $profile->cus_phone,
                "cus_fax" => $profile->cus_fax,
                "shipping_method" => "YES",
                "ship_name" => $profile->ship_name,
                "ship_add1" => $profile->ship_add,
                "ship_add2" => $profile->ship_add,
                "ship_city" => $profile->ship_city,
                "ship_state" => $profile->ship_state,
                "ship_country" => $profile->ship_country,
                "ship_postcode" => $profile->ship_postcode,
                "product_name" => $products['name'],
                "product_category" => $products['category'],
                "product_profile" => $products['brand'],
                "product_amount" => $payable,
            ]);
            return $response->json('desc');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json('SSLCommerz Helper Error: ' . $th->getMessage());
        }

    }

    static function InitiateSuccess($tran_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Success']);
        return 1;
    }

    static function InitiateFail($tran_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Fail']);
        return 1;
    }

    static function InitiateCancel($tran_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Cancel']);
        return 1;
    }

    static function InitiateIPN($tran_id, $status, $val_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => $status, 'val_id' => $val_id]);
        return 1;
    }
}