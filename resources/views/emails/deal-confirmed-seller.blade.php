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
 
<h1>New Offer Received</h1>

<p>Dear {{ $buyer_name }},</p>
<p>You have received a new offer for RFQ/Tender <strong>{{ $rfq_id }}</strong>.</p>
...same header...
<h1>Deal Confirmed</h1>

<p>Dear {{ $seller_name }},</p>
<p>Your offer has been accepted for RFQ <strong>{{ $rfq_id }}</strong>.</p>

<ul>
<li><strong>Buyer:</strong> {{ $buyer_name }}</li>
<li><strong>Final Price:</strong> {{ $final_price }}</li>
<li><strong>Date:</strong> {{ $confirm_date }}</li>
</ul>

<p style="text-align:center;">
<a class="btn" href="{{ $seller_dashboard_link }}">View Deal</a>
</p>


<p>For assistance contact: <a href="mailto:support@worldbusinessguide.com">support@worldbusinessguide.com</a></p>

<p>Regards,<br><strong>WBG24 Team</strong></p>
</div>

<div class="footer">© {{ date('Y') }} WBG24. All rights reserved.</div>
</div>
</body>
</html>
