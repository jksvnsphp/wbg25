<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Confirmed – Your Order is Now Processing!</title>
<style>
body { font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background:#f8f9fa;margin:0;padding:0; }
.email-wrapper { max-width:650px;margin:30px auto;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.05); }
.header { background:linear-gradient(90deg,#007bff,#00bfff);color:#fff;text-align:center;padding:25px; }
.content { padding:30px;color:#333;line-height:1.7; }
.info-box { background:#f1f5ff;border-left:4px solid #007bff;padding:15px 20px;border-radius:6px;margin:15px 0; }
.footer { background:#f1f1f1;color:#777;font-size:13px;text-align:center;padding:15px; }
</style>
</head>
<body>
<div class="email-wrapper">
<div class="header">
    <h2>💳 Payment Confirmed – Your Order is Now Processing!</h2>
</div>
<div class="content">
    <p>Dear <strong>{{ $buyer_name ?? 'Buyer' }}</strong>,</p>
    <p>We’ve received your payment for Order <strong>#{{ $order_id ?? '—' }}</strong>. The Seller is now preparing your order for shipment.</p>

    <div class="info-box">
        <p>🔹 <strong>Product:</strong> {{ $product_name ?? '—' }}</p>
        <p>🔹 <strong>Quantity:</strong> {{ $quantity ?? '—' }}</p>
        <p>🔹 <strong>Seller:</strong> {{ $seller_name ?? '—' }}</p>
        <p>🔹 <strong>Payment Status:</strong> ✅ Paid</p>
        <p>🔹 <strong>Estimated Shipping Date:</strong> {{ $shipping_date ?? now()->addDays(2)->format('d M Y') }}</p>
    </div>

    <p>You’ll receive another update once your order is shipped.</p>
    <p>For queries, contact your Seller or <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
    <p>Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
</div>
<div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
