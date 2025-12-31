<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Confirmed – Process the Order Now!</title>
<style>
body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
.email-wrapper { max-width: 650px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.header { background: linear-gradient(90deg, #28a745, #20c997); color: #fff; text-align: center; padding: 25px; }
.content { padding: 30px; color: #333; line-height: 1.7; }
.info-box { background: #f1f5ff; border-left: 4px solid #28a745; padding: 15px 20px; border-radius: 6px; margin: 15px 0; }
.cta-button { display: inline-block; background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600; }
.footer { background: #f1f1f1; color: #777; font-size: 13px; text-align: center; padding: 15px; }
</style>
</head>
<body>
<div class="email-wrapper">
<div class="header">
    <h2>✅ Payment Confirmed – Process the Order Now!</h2>
</div>
<div class="content">
    <p>Dear <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
    <p>The Payment for Order <strong>#{{ $order_id ?? '—' }}</strong> has been successfully confirmed. Please proceed with the shipment process promptly.</p>

    <div class="info-box">
        <p>🔹 <strong>Buyer:</strong> {{ $buyer_name ?? '—' }}</p>
        <p>🔹 <strong>Product:</strong> {{ $product_name ?? '—' }}</p>
        <p>🔹 <strong>Quantity:</strong> {{ $quantity ?? '—' }}</p>
        <p>🔹 <strong>Payment Status:</strong> ✅ Paid</p>
        <p>🔹 <strong>Shipping Address:</strong> {{ $shipping_address ?? '—' }}</p>
    </div>

    <p style="text-align:center;">
        <a href="{{ $dashboard_link ?? '#' }}" class="cta-button">Update Shipment Status</a>
    </p>

    <p>Ensure timely shipment and provide tracking details to the Buyer.</p>
    <p>For assistance, contact <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
    <p>Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
</div>
<div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
