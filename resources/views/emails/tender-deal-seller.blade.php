<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deal Confirmed – RFQ/Tender #{{ $tender_id ?? '' }}</title>
<style>
    body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background:#f8f9fa; margin:0; padding:0; }
    .email-wrapper { max-width:650px; margin:30px auto; background:#fff; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.05); }
    .header { background:linear-gradient(90deg,#007bff,#00bfff); color:#fff; text-align:center; padding:25px; }
    .content { padding:30px; color:#333; line-height:1.7; }
    .info-box { background:#f1f5ff; border-left:4px solid #007bff; padding:15px 20px; border-radius:6px; margin:15px 0; }
    .cta-button { display:inline-block; background:#007bff; color:#fff; padding:10px 20px; border-radius:5px; text-decoration:none; font-weight:600; }
    .footer { background:#f1f1f1; color:#777; font-size:13px; text-align:center; padding:15px; }
</style>
</head>
<body>
<div class="email-wrapper">
    <div class="header">
        <h2>🎉 Congratulations! Your Deal Is Confirmed</h2>
    </div>
    <div class="content">
        <p>Dear <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
        <p>Great news! Your Offer has been accepted by the Buyer, and your Deal for RFQ/Tender <strong>#{{ $tender_id ?? '' }}</strong> is now confirmed.</p>

        <div class="info-box">
            <p>🔹 <strong>RFQ/Tender Title:</strong> {{ $tender_title ?? '—' }}</p>
            <p>🔹 <strong>Buyer:</strong> {{ $buyer_name ?? '—' }}</p>
            <p>🔹 <strong>Final Deal Amount:</strong> {{ $final_price ?? '—' }}</p>
            <p>🔹 <strong>Confirmation Date:</strong> {{ $confirmation_date ?? now()->format('d M Y') }}</p>
        </div>

        <p><strong>Next Steps:</strong></p>
        <ul>
            <li>✔ Connect with the Buyer to finalize Payment and Shipping.</li>
            <li>✔ Ensure all agreed Terms are met for a smooth Transaction.</li>
            <li>✔ Track and manage your Deal in your Dashboard.</li>
        </ul>

        <p style="text-align:center;">
            <a href="{{ $dashboard_link ?? '#' }}" class="cta-button">Manage Deal</a>
        </p>

        <p>For any Assistance, contact us at <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
        <p>Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
    </div>
    <div class="footer">&copy; {{ date('Y') }} WBG24.com – All Rights Reserved.</div>
</div>
</body>
</html>
