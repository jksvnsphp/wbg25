<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Silver Package is Expiring Soon</title>
<style>
    body { font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background:#f8f9fa;margin:0;padding:0; }
    .email-wrapper { max-width:650px;margin:30px auto;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.05); }
    .header { background:linear-gradient(90deg,#6c757d,#adb5bd);color:#fff;text-align:center;padding:25px; }
    .content { padding:30px;color:#333;line-height:1.7; }
    .info-box { background:#f1f5ff;border-left:4px solid #6c757d;padding:15px 20px;border-radius:6px;margin:15px 0; }
    .cta-button { display:inline-block;background:#6c757d;color:#fff;padding:10px 20px;border-radius:5px;text-decoration:none;font-weight:600; }
    .footer { background:#f1f1f1;color:#777;font-size:13px;text-align:center;padding:15px; }
</style>
</head>
<body>
<div class="email-wrapper">
<div class="header">
    <h2>⚠️ Your Silver Package is Expiring Soon</h2>
</div>
<div class="content">
    <p>Dear <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
    <p>We hope you’re enjoying the benefits of your <strong>Silver Package</strong> on <strong>World Business Guide – WBG24.com</strong>.</p>
    <p>This is a friendly reminder that your Package will expire on <strong>{{ $expiry_date ?? '—' }}</strong>.</p>

    <div class="info-box">
        <p>🔹 Current Package: Silver</p>
        <p>🔹 Expiration Date: {{ $expiry_date ?? '—' }}</p>
    </div>

    <p>Renew now to continue uninterrupted access to your Business Profile, Inquiries, and Networking Opportunities.</p>

    <p style="text-align:center;">
        <a href="{{ $renewal_link ?? '#' }}" class="cta-button">Renew My Package</a>
    </p>

    <p>For assistance, contact us at <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
    <p>With Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
</div>
<div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
