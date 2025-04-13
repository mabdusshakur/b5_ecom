<?php

namespace App\Helpers;

use App\Mail\verifyMailer;
use Mail;

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

}