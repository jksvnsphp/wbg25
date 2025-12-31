<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update on Your RFQ/Tender Counter Offer!</title>
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .email-wrapper { max-width: 650px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow: hidden; }
        .header { background: linear-gradient(90deg, #17a2b8, #00c6ff); color: #fff; padding: 25px; text-align: center; }
        .content { padding: 30px; color: #333; line-height: 1.7; }
        .info-box { background: #e6f9ff; border-left: 4px solid #00c6ff; padding: 15px 20px; border-radius: 6px; margin: 15px 0; }
        .cta-button { display: inline-block; background: #00c6ff; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: 600; margin-top: 15px; }
        .footer { background: #f1f1f1; padding: 15px; text-align: center; color: #777; font-size: 13px; }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="header">
        <h2>🔔 Update on Your RFQ/Tender Counter Offer!</h2>
    </div>
    <div class="content">
        <p>Dear <strong>{{ $buyer_name ?? 'Buyer' }}</strong> & <strong>{{ $seller_name ?? 'Seller' }}</strong>,</p>
        <p>We’d like to update you about the RFQ/Tender <strong>{{ $tender_id ?? '—' }}</strong> Counter Offer process.</p>

        <div class="info-box">
            <p>🔹 <strong>Buyer:</strong> {{ $buyer_name ?? '—' }}</p>
            <p>🔹 <strong>Seller:</strong> {{ $seller_name ?? '—' }}</p>
            <p>🔹 <strong>RFQ/Tender Title:</strong> {{ $tender_title ?? '—' }}</p>
            <p>🔹 <strong>Current Counter Offer Amount:</strong> {{ $counter_price ?? '—' }}</p>
            <p>🔹 <strong>Current Offer Status:</strong> {{ $status ?? 'Pending' }}</p>
            <p>🔹 <strong>Last Updated:</strong> {{ $updated_at ?? now()->format('d M Y') }}</p>
        </div>

        <p><strong>Next Steps:</strong></p>
        <ul>
            <li>✔ If accepted, proceed to finalize the transaction.</li>
            <li>✔ If rejected, Sellers may submit a revised offer.</li>
            <li>✔ Keep communicating for a smooth deal.</li>
        </ul>

        <p style="text-align:center;">
            <a href="{{ $dashboard_link ?? '#' }}" class="cta-button">Manage RFQ/Tender</a>
        </p>

        <p>Need help? Contact <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>
        <p>With Best Regards,<br><strong>World Business Guide – WBG24.com</strong></p>
    </div>
    <div class="footer">&copy; {{ date('Y') }} World Business Guide – WBG24.com. All Rights Reserved.</div>
</div>
</body>
</html>
