<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Deal Confirmation - WBG24</title>
<style>
body{font-family:Arial,sans-serif;color:#333;background:#f4f4f4;margin:0;}
.email-container{max-width:600px;margin:20px auto;background:#fff;padding:20px;
border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,.1);}
.email-header{background:#2E2B70;padding:20px;text-align:center;color:#fff;border-radius:8px 8px 0 0;}
.email-header h1{margin:0;}
.email-body{padding:20px;color:#555;}
.btn{display:inline-block;padding:12px 20px;background:#2E2B70;color:#fff;text-decoration:none;
font-weight:bold;border-radius:6px;margin-top:10px;}
ul{padding-left:18px;}
.footer{text-align:center;color:#999;font-size:12px;margin-top:25px;}
</style>
</head>

<body>
<div class="email-container">
<div class="email-header"><h1>Deal Confirmation</h1></div>

<div class="email-body">
...same header...
<h1>Deal Confirmed</h1>

<p>Dear {{ $buyer_name }},</p>
<p>You finalized a deal for RFQ <strong>{{ $rfq_id }}</strong>.</p>

<ul>
<li><strong>Seller:</strong> {{ $seller_name }}</li>
<li><strong>Final Price:</strong> {{ $final_price }}</li>
</ul>

<p style="text-align:center;">
<a class="btn" href="{{ $buyer_dashboard_link }}">View Deal</a>
</p>


<p>For help: <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>

<p>With Best Regards,<br><strong>WBG24 Team</strong></p>
</div>

<div class="footer">© {{ date('Y') }} WBG24. All rights reserved.</div>
</div>
</body>
</html>