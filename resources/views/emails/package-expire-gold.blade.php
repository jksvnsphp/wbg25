<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Gold Package is About to Expire</title>
<style>
    body { font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background:#f8f9fa;margin:0;padding:0; }
    .email-wrapper { max-width:650px;margin:30px auto;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.05); }
    .header { background:linear-gradient(90deg,#ffc107,#ffb300);color:#fff;text-align:center;padding:25px; }
    .content { padding:30px;color:#333;line-height:1.7; }
    .info-box { background:#fffbea;border-left:4px solid #ffc107;padding:15px 20px;border-radius:6px;margin:15px 0; }
    .cta-button { display:inline-block;background:#ffc107;color:#000;padding:10px 20px;border-radius:5px;text-decoration:none;font-weight:600; }
    .footer { background:#f1f1f1;color:#777;font-size:13px;text-align:center;padding:15px; }
</style>
</head>
<body>
<div class="email-wrapper">
<div class="header">
    <h2>💛 Your Gold Package is About to Expire</h2>
</div>
<div class="content">
    <p>Dear <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
    <p>Your <strong>Gold Package</strong> on <strong>World Business Guide – WBG24.com</strong> will expire on <strong>{{ $expiry_date ?? '—' }}</strong>.</p>
    <p>We truly value your presence in our B2B & B2C Marketplace and want to help you continue growing your business.</p>

    <div class="info-box">
        <p>🔹 Current Package: Gold</p>
        <p>🔹 Expiration Date: {{ $expiry_date ?? '—' }}</p>
    </div>

    <p>Renew now to keep enjoying:</p>
    <ul>
        <li>✅ Enhanced visibility on WBG24</li>
        <li>✅ Priority business listings</li>
        <li>✅ Direct buyer inquiries</li>
    </ul>

    <p style="text-align:center;">
        <a href="{{ $renewal_link ?? '#' }}" class="cta-button">Renew Gold Package</a>
    </p>

    <p>Need help? Contact <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
    <p>With Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
</div>
<div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
