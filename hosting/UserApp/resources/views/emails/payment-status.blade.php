<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .content {
            margin-bottom: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
        .status-success {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-fail {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-cancel {
            background-color: #f3f4f6;
            color: #374151;
        }
        .status-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .order-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Order Status Update</h1>
        <p>Your order #{{ $order['order_number'] }} status has been updated.</p>
    </div>

    <div class="content">
        <!-- Payment Status -->
        <div class="status-section">
            <h2>Payment Status</h2>
            <div class="status-badge status-{{ strtolower($payment_status) }}">
                {{ $payment_status }}
            </div>
            @if($payment_status === 'Success')
                <p>Your payment has been processed successfully.</p>
            @elseif($payment_status === 'Pending')
                <p>Your payment is being processed.</p>
            @elseif($payment_status === 'Fail')
                <p>There was an issue with your payment. Please try again or contact support.</p>
            @elseif($payment_status === 'Cancel')
                <p>Your payment was cancelled.</p>
            @endif
        </div>

        <!-- Delivery Status -->
        <div class="status-section">
            <h2>Delivery Status</h2>
            <div class="status-badge status-{{ strtolower($delivery_status) }}">
                {{ $delivery_status }}
            </div>
            @if($delivery_status === 'Pending')
                <p>Your order is being processed and will be shipped soon.</p>
            @elseif($delivery_status === 'Processing')
                <p>Your order is being prepared for shipping.</p>
            @elseif($delivery_status === 'Shipped')
                <p>Your order has been shipped and is on its way.</p>
            @elseif($delivery_status === 'Delivered')
                <p>Your order has been delivered successfully.</p>
            @elseif($delivery_status === 'Cancelled')
                <p>Your order delivery has been cancelled.</p>
            @endif
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <h3>Order Details</h3>
            <p><strong>Order Number:</strong> {{ $order['order_number'] }}</p>
            <p><strong>Date:</strong> {{ $order['date'] }}</p>
            <p><strong>Total Amount:</strong> ${{ $order['amount'] }}</p>
            
            <h4>Customer Information</h4>
            <p><strong>Name:</strong> {{ $order['customer_details']['name'] }}</p>
            <p><strong>Phone:</strong> {{ $order['customer_details']['phone'] }}</p>
            <p><strong>Address:</strong> {{ $order['customer_details']['address'] }}</p>
            
            <h4>Order Items</h4>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr style="background-color: #f3f4f6;">
                    <th style="padding: 8px; text-align: left;">Product</th>
                    <th style="padding: 8px; text-align: right;">Quantity</th>
                    <th style="padding: 8px; text-align: right;">Size</th>
                    <th style="padding: 8px; text-align: right;">Color</th>
                    <th style="padding: 8px; text-align: right;">Price</th>
                    <th style="padding: 8px; text-align: right;">Total</th>
                </tr>
                @foreach($order['products'] as $product)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 8px;">{{ $product['title'] }}</td>
                    <td style="padding: 8px; text-align: right;">{{ $product['quantity'] }}</td>
                    <td style="padding: 8px; text-align: right;">{{ $product['size'] }}</td>
                    <td style="padding: 8px; text-align: right;">{{ $product['color'] }}</td>
                    <td style="padding: 8px; text-align: right;">${{ $product['price'] }}</td>
                    <td style="padding: 8px; text-align: right;">${{ $product['total'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
    </div>
</body>
</html> 