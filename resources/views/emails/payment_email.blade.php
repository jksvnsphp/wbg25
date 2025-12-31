<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Information - WBG24</title>
    <style>
        body{font-family:Arial,sans-serif;color:#333;background:#f4f4f4;margin:0}
        .email-container{max-width:600px;margin:20px auto;background:#fff;border-radius:8px;padding:20px;box-shadow:0 4px 6px rgba(0,0,0,.1)}
        .email-header{background:#2E2B70;color:#fff;text-align:center;padding:20px;border-radius:8px 8px 0 0}
        .email-header h1{margin:0}
        .email-body{padding:20px;color:#555}
        .btn{display:inline-block;padding:12px 20px;background:#2E2B70;color:#fff;text-decoration:none;font-weight:bold;border-radius:6px;margin-top:10px}
        .footer{text-align:center;margin-top:30px;font-size:12px;color:#999}
    </style>
</head>

<body>
<div class="email-container">
    <div class="email-header">
        <h1>{{ $package }} Membership – Payment Required</h1>
    </div>

    <div class="email-body">
        <p>Dear {{ $user_name }},</p>

        <p>Thank you for choosing the <strong>{{ $package }} Member Package</strong> on
            <strong>World Business Guide – WBG24.com</strong>!</p>

        <h3>Payment Details</h3>
        <p><strong>Package:</strong> {{ $package }}</p>
        <p><strong>Amount:</strong> €{{ $amount }}</p>
        <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
        <p><strong>Due Date:</strong> {{ $due_date }}</p>

        <p>To complete your payment, please use the following details:</p>
        <p><strong>{{ $payment_details }}</strong></p>

        <p>
            Once your payment is confirmed, your membership benefits will be activated.
            You can then connect with global buyers, suppliers & grow your business.
        </p>

        <p style="text-align:center">
            <a class="btn" href="{{ url('/login') }}">Log In & Continue</a>
        </p>

        <p>For assistance, email: <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>

        <p>With best regards,<br><strong>WBG24 Team</strong></p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} WBG24. All Rights Reserved.
    </div>
</div>
</body>
</html>
