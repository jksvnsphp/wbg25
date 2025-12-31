<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Delivered – Thank You for Doing Business!</title>
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .email-wrapper {
            max-width: 650px; margin: 30px auto; background: #fff;
            border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header { background: linear-gradient(90deg, #28a745, #20c997); color: #fff; padding: 25px; text-align: center; }
        .content { padding: 30px; color: #333; line-height: 1.7; }
        .info-box { background: #e8fff2; border-left: 4px solid #28a745; padding: 15px 20px; border-radius: 6px; margin: 15px 0; }
        .footer { background: #f1f1f1; padding: 15px; text-align: center; color: #777; font-size: 13px; }
        .cta-link { color: #28a745; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h2>✅ Order Delivered – Thank You for Doing Business!</h2>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $buyer_name ?? 'Buyer' }}</strong> & <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>

            <p>We’re happy to inform you that the order <strong>{{ $order_id ?? '—' }}</strong> has been successfully delivered.</p>

            <div class="info-box">
                <p>🔹 <strong>Buyer:</strong> {{ $buyer_name ?? '—' }}</p>
                <p>🔹 <strong>Seller:</strong> {{ $seller_name ?? '—' }}</p>
                <p>🔹 <strong>Product Name:</strong> {{ $product_name ?? '—' }}</p>
                <p>🔹 <strong>Delivery Date:</strong> {{ $delivery_date ?? '—' }}</p>
            </div>

            <p>💡 <strong>For Buyers:</strong> If everything is as expected, please confirm receipt of your order and leave feedback for the seller here: 
                <a href="{{ $feedback_link ?? '#' }}" class="cta-link">Leave Feedback</a>
            </p>

            <p>💡 <strong>For Sellers:</strong> Ensure the buyer has received the product in good condition. If any issue arises, kindly assist the buyer promptly.</p>

            <p>Thank you for using <strong>World Business Guide (WBG24.com)</strong> – Your International Market!</p>

            <p>For any queries, reach out to 
                <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
            </p>

            <p>Best Regards,<br><strong>WBG24.com Team</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} World Business Guide – WBG24.com. All Rights Reserved.
        </div>
    </div>
</body>
</html>
