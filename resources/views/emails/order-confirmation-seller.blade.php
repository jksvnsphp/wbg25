<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received – Process Now!</title>
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .email-wrapper {
            max-width: 650px; margin: 30px auto; background: #fff;
            border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, #007bff, #00bfff);
            color: #fff; padding: 25px; text-align: center;
        }
        .content { padding: 30px; color: #333; line-height: 1.7; }
        .info-box { background: #f1f5ff; border-left: 4px solid #007bff; padding: 15px 20px; border-radius: 6px; margin: 15px 0; }
        .footer { background: #f1f1f1; padding: 15px; text-align: center; color: #777; font-size: 13px; }
        .cta-button {
            display: inline-block; background: #007bff; color: white; text-decoration: none;
            padding: 10px 20px; border-radius: 5px; font-weight: 600; margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h2>📦 New Order Received – Process Now!</h2>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
            <p>You have received a new order on <strong>World Business Guide (WBG24.com)</strong> – Your International Market.</p>
            <p>Please process it at the earliest to ensure a smooth transaction.</p>

            <div class="info-box">
                <p>🔹 <strong>Order ID:</strong> {{ $order_id ?? '—' }}</p>
                <p>🔹 <strong>Product Name:</strong> {{ $product_name ?? '—' }}</p>
                <p>🔹 <strong>Quantity:</strong> {{ $quantity ?? '—' }}</p>
                <p>🔹 <strong>Buyer:</strong> {{ $buyer_name ?? '—' }}</p>
                <p>🔹 <strong>Shipping Address:</strong> {{ $buyer_address ?? '—' }}</p>
            </div>

            <p style="text-align:center;">
                <a href="{{ $dashboard_link ?? '#' }}" class="cta-button">Manage Order</a>
            </p>

            <p>Once the buyer marks payment as complete, please ship the order promptly and provide tracking details.</p>

            <p>Need help? Contact <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
            <p>With Best Regards,<br><strong>World Business Guide – WBG24.com Team</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} World Business Guide – WBG24.com. All Rights Reserved.
        </div>
    </div>
</body>
</html>
