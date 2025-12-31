<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shipment Update – Your Order is Now in Transit!</title>
<style>
body { font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background:#f8f9fa;margin:0;padding:0; }
.email-wrapper { max-width:650px;margin:30px auto;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.05); }
.header { background:linear-gradient(90deg,#17a2b8,#00c6ff);color:#fff;text-align:center;padding:25px; }
.content { padding:30px;color:#333;line-height:1.7; }
.info-box { background:#e6f9ff;border-left:4px solid #00c6ff;padding:15px 20px;border-radius:6px;margin:15px 0; }
.footer { background:#f1f1f1;color:#777;font-size:13px;text-align:center;padding:15px; }
</style>
</head>
<body>
<div class="email-wrapper">
<div class="header">
    <h2>🚚 Shipment Update – Your Order is Now in Transit!</h2>
</div>
<div class="content">
    <p>Dear <strong>{{ $buyer_name ?? 'Buyer' }}</strong> & <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
    <p>We are pleased to inform you that the Shipment Status for Order <strong>#{{ $order_id ?? '—' }}</strong> has been updated.</p>

    <div class="info-box">
        <p>🔹 <strong>Buyer:</strong> {{ $buyer_name ?? '—' }}</p>
        <p>🔹 <strong>Seller:</strong> {{ $seller_name ?? '—' }}</p>
        <p>🔹 <strong>Product:</strong> {{ $product_name ?? '—' }}</p>
        <p>🔹 <strong>Shipment Status:</strong> 📦 Shipped</p>
        <p>🔹 <strong>Tracking Number:</strong> {{ $tracking_number ?? '—' }}</p>
        <p>🔹 <strong>Courier Service:</strong> {{ $courier_name ?? '—' }}</p>
        <p>🔹 <strong>Estimated Delivery Date:</strong> {{ $delivery_date ?? now()->addDays(5)->format('d M Y') }}</p>
    </div>

    <p style="text-align:center;">
        <a href="{{ $tracking_link ?? '#' }}" class="cta-button">Track Shipment</a>
    </p>

    <p>For further assistance, contact <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
    <p>Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
</div>
<div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
