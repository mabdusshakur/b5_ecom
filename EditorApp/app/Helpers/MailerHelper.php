<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class MailerHelper
{
    public static function sendOrderStatusEmail($order, $userEmail)
    {
        try {
            Mail::send('emails.order-status', [
                'order' => $order,
                'payment_status' => $order['payment_status'],
                'delivery_status' => $order['delivery_status'],
            ], function ($message) use ($userEmail, $order) {
                $message->to($userEmail)->subject('Order Status Update - #' . $order['order_number']);
            });
        } catch (\Throwable $th) {
            \Log::error('dd', [$th->getMessage()]);
        }
    }
}