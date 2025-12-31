<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Offer Submitted</title>
<style>
body{font-family:Arial,sans-serif;color:#333;background:#f4f4f4;margin:0;padding:0;}
.email-container{max-width:600px;margin:20px auto;background:#fff;border-radius:8px;padding:20px;box-shadow:0 4px 6px rgba(0,0,0,0.1);}
.email-header{background:#2E2B70;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0;}
.email-body{padding:20px;color:#555;}
.btn{display:inline-block;background:#2E2B70;color:#fff;padding:12px 20px;text-decoration:none;font-weight:bold;border-radius:6px;}
.footer{text-align:center;color:#999;font-size:12px;margin-top:20px;}
</style>
</head>

<body>
<div class="email-container">
<div class="email-header"><h1>Offer Submitted</h1></div>

<div class="email-body">

<p>Dear {{ $seller_name }},</p>
<p>Your offer for RFQ/Tender <strong>{{ $rfq_id }}</strong> has been successfully submitted to the Buyer.</p>

<h3>Offer Details</h3>
<ul>
<li><strong>Title:</strong> {{ $rfq_title }}</li>
<li><strong>Buyer:</strong> {{ $buyer_name }}</li>
<li><strong>Offer Amount:</strong> {{ $offer_price }}</li>
<li><strong>Submitted On:</strong> {{ $offer_date }}</li>
</ul>

<p>The buyer will review your offer and respond shortly.</p>

<p style="text-align:center;">
<a href="{{ $seller_dashboard_link }}" class="btn">View Offer</a>
</p>

<p>For assistance contact: <a href="mailto:support@worldbusinessguide.com">support@worldbusinessguide.com</a></p>

<p>Regards,<br><strong>WBG24 Team</strong></p>
</div>

<div class="footer">© {{ date('Y') }} WBG24. All rights reserved.</div>
</div>
</body>
</html>
