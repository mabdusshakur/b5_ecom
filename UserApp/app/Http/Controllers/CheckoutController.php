<?php

namespace App\Http\Controllers;

use App\Helpers\MailerHelper;
use App\Helpers\SSLCommerz;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $customer_profile = $user->profile;

        $customer_id = $customer_profile->id;
        $user_email = $user->email;


        $customer_info = [
            'name' => $customer_profile->cus_name,
            'phone' => $customer_profile->cus_phone,
            'address' => $customer_profile->cus_add,
            'city' => $customer_profile->cus_city,
            'state' => $customer_profile->cus_state,
            'country' => $customer_profile->cus_country,
            'postCode' => $customer_profile->cus_postcode,
        ];

        $ship_info = [
            'name' => $customer_profile->ship_name,
            'phone' => $customer_profile->ship_phone,
            'address' => $customer_profile->ship_add,
            'city' => $customer_profile->ship_city,
            'state' => $customer_profile->ship_state,
            'country' => $customer_profile->ship_country,
            'postCode' => $customer_profile->ship_postcode,
        ];

        $transaction_id = uniqid();
        $delivery_status = 'Pending';
        $payment_status = 'Pending';

        $cartItems = $request->input('carts');

        $total_amount = 0;

        $products = [
            'name' => [],
            'category' => [],
            'brand' => [],
        ];

        foreach ($cartItems as $cartItem) {
            $product_id = $cartItem['id'];
            $product = Product::find($product_id);
            $productPrice = $cartItem['price'];
            $total_amount += $productPrice * $cartItem['qty'];

            array_push($products['name'], $product->title);
            array_push($products['category'], $product->category->name);
            array_push($products['brand'], $product->brand->name);
        }

        $vat = 3;
        $vat_amount = ($total_amount * $vat) / 100;
        $payable_amount = $total_amount + $vat_amount;

        $invoice = Invoice::create([
            'total' => $total_amount,
            'vat' => $vat_amount,
            'payable' => $payable_amount,
            'tran_id' => $transaction_id,
            'delivery_status' => $delivery_status,
            'payment_status' => $payment_status,
            'customer_id' => $customer_id,
            'cus_details' => json_encode($customer_info),
            'ship_details' => json_encode($ship_info),
        ]);


        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem['id']);
            $product->decrement('stock', $cartItem['qty']);
            $product->save();


            InvoiceProduct::create([
                'quantity' => $cartItem['qty'],
                'price' => $product->price,
                'product_id' => $product->id,
                'invoice_id' => $invoice->id,
                'size' => $cartItem['size'],
                'color' => $cartItem['color'],
            ]);
        }

        $paymentMethod = SSLCommerz::InitiatePayment($customer_profile, $products, $payable_amount, $transaction_id, $user_email);

        $orderDetails = [
            'id' => $invoice->id,
            'order_number' => '#' . $invoice->id,
            'date' => $invoice->created_at->format('Y-m-d'),
            'amount' => number_format($invoice->payable, 2),
            'payment_status' => $invoice->payment_status,
            'delivery_status' => $invoice->delivery_status,
            'payment_methods' => $paymentMethod,
            'vat' => $vat_amount,
            'total' => $total_amount,
            'customer_details' => json_decode($invoice->cus_details, true),
            'shipping_details' => json_decode($invoice->ship_details, true),
            'products' => $invoice->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->product->title,
                    'quantity' => $product->quantity,
                    'size' => $product->size,
                    'color' => $product->color,
                    'price' => number_format($product->price, 2),
                    'total' => number_format($product->price * $product->quantity, 2),
                ];
            }),
        ];

        MailerHelper::sendOrderPlaceEmail($orderDetails, $user_email);

        return redirect()->route('payment.methods', [
            'payment_methods' => $paymentMethod,
            'payable' => $payable_amount,
            'vat' => $vat_amount,
            'total' => $total_amount,
            'order_created' => true,
            'order_id' => $invoice->id,
        ]);
    }


    public function paymentMethods(Request $request)
    {

        return inertia('PaymentMethods', [
            'payment_methods' => $request->payment_methods,
            'payable' => $request->payable,
            'vat' => $request->vat,
            'total' => $request->total,
            'order_created' => $request->order_created ?? false,
            'order_id' => $request->order_id,
        ]);
    }


    public function paymentSuccess(Request $request)
    {
        $tran_id = $request->tran_id;
        SSLCommerz::InitiateSuccess($tran_id);

        $invoice = Invoice::where('tran_id', $tran_id)->first();
        $user = $invoice->customer->user;
        $orderDetails = [
            'id' => $invoice->id,
            'order_number' => '#' . $invoice->id,
            'date' => $invoice->created_at->format('Y-m-d'),
            'amount' => number_format($invoice->payable, 2),
            'payment_status' => 'Success',
            'delivery_status' => $invoice->delivery_status,
            'customer_details' => json_decode($invoice->cus_details, true),
            'shipping_details' => json_decode($invoice->ship_details, true),
            'products' => $invoice->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->product->title,
                    'quantity' => $product->quantity,
                    'size' => $product->size,
                    'color' => $product->color,
                    'price' => number_format($product->price, 2),
                    'total' => number_format($product->price * $product->quantity, 2),
                ];
            }),
        ];

        MailerHelper::sendPaymentStatusEmail($orderDetails, $user->email);

        return redirect()->route('dashboards.index')->with('success', 'Payment Successful');
    }


    public function paymentFailed(Request $request)
    {
        $tran_id = $request->tran_id;
        SSLCommerz::InitiateFail($tran_id);

        $invoice = Invoice::where('tran_id', $tran_id)->first();
        $user = $invoice->customer->user;
        $orderDetails = [
            'id' => $invoice->id,
            'order_number' => '#' . $invoice->id,
            'date' => $invoice->created_at->format('Y-m-d'),
            'amount' => number_format($invoice->payable, 2),
            'payment_status' => 'Fail',
            'delivery_status' => $invoice->delivery_status,
            'customer_details' => json_decode($invoice->cus_details, true),
            'shipping_details' => json_decode($invoice->ship_details, true),
            'products' => $invoice->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->product->title,
                    'quantity' => $product->quantity,
                    'size' => $product->size,
                    'color' => $product->color,
                    'price' => number_format($product->price, 2),
                    'total' => number_format($product->price * $product->quantity, 2),
                ];
            }),
        ];

        MailerHelper::sendPaymentStatusEmail($orderDetails, $user->email);


        return redirect()->route('dashboards.index')->with('error', 'Payment Failed');
    }

    public function paymentCancel(Request $request)
    {
        $tran_id = $request->tran_id;
        SSLCommerz::InitiateCancel($tran_id);

        $invoice = Invoice::where('tran_id', $tran_id)->first();
        $user = $invoice->customer->user;
        $orderDetails = [
            'id' => $invoice->id,
            'order_number' => '#' . $invoice->id,
            'date' => $invoice->created_at->format('Y-m-d'),
            'amount' => number_format($invoice->payable, 2),
            'payment_status' => 'Cancel',
            'delivery_status' => $invoice->delivery_status,
            'customer_details' => json_decode($invoice->cus_details, true),
            'shipping_details' => json_decode($invoice->ship_details, true),
            'products' => $invoice->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->product->title,
                    'quantity' => $product->quantity,
                    'size' => $product->size,
                    'color' => $product->color,
                    'price' => number_format($product->price, 2),
                    'total' => number_format($product->price * $product->quantity, 2),
                ];
            }),
        ];

        MailerHelper::sendPaymentStatusEmail($orderDetails, $user->email);

        return redirect()->route('dashboards.index')->with('error', 'Payment Cancelled');
    }
}
