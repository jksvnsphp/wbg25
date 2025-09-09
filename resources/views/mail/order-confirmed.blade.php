<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
            background-color: #2E2B70;
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
            color: #2E2B70;
        }

        .order-items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .order-items th,
        .order-items td {
            text-align: left;
            padding: 10px;
            border: 1px solid #dddddd;
        }

        .order-items img {
            max-width: 50px;
            border-radius: 4px;
        }

        .order-summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }

        .order-summary p {
            font-weight: bold;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
        }

        .footer a {
            color: #2E2B70;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="email-header">
            <h1>Order Confirmation</h1>
        </div>

        <div class="order-details">
            <p>Dear {{ $user_name }},</p>
            <p>Thank you for your order! We're excited to inform you that your order has been successfully placed.</p>

            <h2>Order Summary</h2>
            <div class="order-items">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_items as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->product_name }}">
                                </td>
                                <td>
                                    <a href="{{ url($item->slug) }}" style="color: #2E2B70; text-decoration: none;">
                                        {{ $item->product_name }}
                                    </a>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>€{{ number_format($item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="order-summary">
                <p><strong>Order Number:</strong> {{ $order_number }}</p>
                <p><strong>Total Amount:</strong> €{{ number_format($total_amount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
                <p><strong>Shipping Cost:</strong> €{{ number_format($shipping_cost, 2) }}</p>
                <p><strong>Shipping Address:</strong> {{ $shipping_address }}</p>
            </div>

            <p>If you have any questions or need assistance with your order, please feel free to <a
                    href="mailto:support@wbg24.com">contact us</a>.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} WBG24. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
