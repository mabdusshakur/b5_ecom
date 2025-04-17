<?php

namespace App\Helpers;

use Mail;
use App\Mail\verifyMailer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class InvoiceHelper {

    public static function generatePDF($order){
        $pdf = app('dompdf.wrapper')->loadView('pdf.invoice', [
            'order' => $order,
        ]);

        $fileName = 'invoice-'. $order['order_number'] .'.pdf';
        $path = 'invoices/' . $fileName;

        Storage::put('public/' . $path, $pdf->output());

        return $path;
    }

}