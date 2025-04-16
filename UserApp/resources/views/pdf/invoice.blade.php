<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice {{ $order['order_number'] }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .company-info {
            margin-bottom: 20px;
            text-align: center;
        }

        .company-info h2 {
            margin: 0;
            font-size: 18px;
            color: #555;
        }

        .invoice-info,
        .customer-info,
        .shipping-info {
            margin-bottom: 30px;
        }

        .invoice-info p,
        .customer-info p,
        .shipping-info p {
            margin: 5px 0;
        }

        h3 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            color: #333;
        }

        .totals {
            float: right;
            width: 300px;
        }

        .totals table {
            border: none;
        }

        .totals td {
            border: none;
            padding: 5px 10px;
        }

        .totals tr:last-child td {
            font-weight: bold;
            border-top: 2px solid #ddd;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE</h1>
        </div>

        <div class="invoice-info">
            <p><strong>Invoice Number:</strong> {{ $order['order_number'] }}</p>
            <p><strong>Date:</strong> {{ $order['date'] }}</p>
            <p><strong>Payment Status:</strong> {{ $order['payment_status'] }}</p>
            <p><strong>Delivery Status:</strong> {{ $order['delivery_status'] }}</p>
        </div>

        <div class="customer-info">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order['customer_details']['name'] }}</p>
            <p><strong>Phone:</strong> {{ $order['customer_details']['phone'] }}</p>
            <p><strong>Address:</strong> {{ $order['customer_details']['address'] }}</p>
            <p><strong>State:</strong> {{ $order['customer_details']['state'] }}</p>
            <p><strong>Country:</strong> {{ $order['customer_details']['country'] }}</p>
            <p><strong>Post Code:</strong> {{ $order['customer_details']['postCode'] }}</p>
        </div>

        <div class="shipping-info">
            <h3>Shipping Information</h3>
            <p><strong>Name:</strong> {{ $order['shipping_details']['name'] }}</p>
            <p><strong>Phone:</strong> {{ $order['shipping_details']['phone'] }}</p>
            <p><strong>Address:</strong> {{ $order['shipping_details']['address'] }}</p>
            <p><strong>City:</strong> {{ $order['shipping_details']['city'] }}</p>
            <p><strong>State:</strong> {{ $order['shipping_details']['state'] }}</p>
            <p><strong>Country:</strong> {{ $order['shipping_details']['country'] }}</p>
            <p><strong>Post Code:</strong> {{ $order['shipping_details']['postCode'] }}</p>
        </div>

        <h3>Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order['products'] as $product)
                    <tr>
                        <td>{{ $product['title'] }}</td>
                        <td>${{ $product['price'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ $product['size'] }}</td>
                        <td>{{ $product['color'] }}</td>
                        <td>${{ $product['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Total Amount:</td>
                    <td>${{ $order['amount'] }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
        </div>
    </div>
</body>

</html>