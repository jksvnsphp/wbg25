<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deal Confirmed – Tender/RFQ #{{ $tender_id ?? '' }}</title>
<style>
    body { font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background:#f8f9fa;margin:0;padding:0; }
    .email-wrapper { max-width:650px;margin:30px auto;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.05); }
    .header { background:linear-gradient(90deg,#28a745,#20c997);color:#fff;text-align:center;padding:25px; }
    .content { padding:30px;color:#333;line-height:1.7; }
    .info-box { background:#e8fff2;border-left:4px solid #28a745;padding:15px 20px;border-radius:6px;margin:15px 0; }
    .cta-button { display:inline-block;background:#28a745;color:#fff;padding:10px 20px;border-radius:5px;text-decoration:none;font-weight:600; }
    .footer { background:#f1f1f1;color:#777;font-size:13px;text-align:center;padding:15px; }
</style>
</head>
<body>
<div class="email-wrapper">
    <div class="header">
        <h2>✅ Deal Confirmed – RFQ/Tender #{{ $tender_id ?? '' }}</h2>
    </div>
    <div class="content">
        <p>Dear <strong>{{ $buyer_name ?? 'Buyer' }}</strong>,</p>
        <p>Congratulations! You have successfully finalized the Deal for RFQ/Tender <strong>#{{ $tender_id ?? '' }}</strong> with <strong>{{ $seller_name ?? 'Seller' }}</strong>.</p>

        <div class="info-box">
            <p>🔹 <strong>RFQ/Tender Title:</strong> {{ $tender_title ?? '—' }}</p>
            <p>🔹 <strong>Seller:</strong> {{ $seller_name ?? '—' }}</p>
            <p>🔹 <strong>Final Deal Amount:</strong> {{ $final_price ?? '—' }}</p>
            <p>🔹 <strong>Confirmation Date:</strong> {{ $confirmation_date ?? now()->format('d M Y') }}</p>
        </div>

        <p><strong>Next Steps:</strong></p>
        <ul>
            <li>✔ Contact the Seller to arrange Payment and Delivery.</li>
            <li>✔ Ensure all agreed Terms are followed.</li>
            <li>✔ Manage your Deal in your Dashboard.</li>
        </ul>

        <p style="text-align:center;">
            <a href="{{ $dashboard_link ?? '#' }}" class="cta-button">View Deal</a>
        </p>

        <p>Need help? Reach us at <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
        <p>Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
    </div>
    <div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
