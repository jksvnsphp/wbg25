<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #f41909;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .email-header h1 {
            margin: 0;
        }
        .order-details {
            padding: 20px;
            color: #555555;
        }
        .order-details h2 {
            color: #f41909;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .product-image {
            max-width: 50px;
            height: auto;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
        }
        .footer a {
            color: #f41909;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <h1>Order Notification</h1>
        </div>

        <div class="order-details">
            <p>Dear {{ $seller_name }},</p>
            <p>You have received a new order for the product(s) listed by you.</p>
            
            <h2>Order Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_items as $item)
                        <tr>
                            <td>
                                <a href="{{ $item->slug }}" target="_blank">
                                    <img src="{{ $item->image }}" alt="{{ $item->product_name }}" class="product-image">
                                </a>
                            </td>
                            <td>
                                <a href="{{ $item->slug }}" target="_blank" style="color: #f41909; text-decoration: none;">
                                    {{ $item->product_name }}
                                </a>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>€{{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="order-summary">
                <p><strong>Order Number:</strong> {{ $order_number }}</p>
                <p><strong>Total Amount:</strong> €{{ number_format($total_amount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
                <p><strong>Buyer Name:</strong> {{ $buyer_name }}</p>
                <p><strong>Buyer Email:</strong> {{ $buyer_email }}</p>
                <p><strong>Shipping Address:</strong> {{ $shipping_address }}</p>
            </div>

            <p>If you have any questions or need assistance, please feel free to <a href="mailto:support@wbg24.com">contact us</a>.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} WBG24. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
