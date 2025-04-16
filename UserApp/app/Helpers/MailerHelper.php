<?php

namespace App\Helpers;

use Mail;
use App\Mail\verifyMailer;
use Illuminate\Support\Facades\URL;

class MailerHelper {

    public static function sendOtp($to){
        try {
            $otp = rand(1000,9999);
            Mail::to($to)->send(new verifyMailer($otp));
            return $otp;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function sendOrderPlaceEmail($order, $userEmail){
        $paymentUrl = URL::route('payment.methods', [
            'payment_methods' => $order['payment_methods'],
            'payable' => $order['amount'],
            'vat' => $order['vat'],
            'total' => $order['total'],
            'order_id' => $order['id'],
        ]);

        Mail::send('emails.order-placed', [
            'order' => $order,
            'paymentUrl' => $paymentUrl,
        ], function ($message) use ($userEmail, $order) {
            $message->to($userEmail)->subject('Order Placed Successfully - #' . $order['order_number']);
        });
    }

    public static function sendPaymentStatusEmail($order, $userEmail)
    {
        Mail::send('emails.payment-status', [
            'order' => $order,
            'payment_status' => $order['payment_status'],
            'delivery_status' => $order['delivery_status'],
        ], function($message) use ($userEmail, $order) {
            $message->to($userEmail)->subject('Order Placed Successfully - #' . $order['order_number']);
        });
    }

}