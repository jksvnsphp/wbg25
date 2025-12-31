<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - WBG24</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }

        .email-header {
            background-color: #2E2B70;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .email-header h1 {
            margin: 0;
        }

        .email-body {
            padding: 20px;
            color: #555;
        }

        .btn {
            display:inline-block;
            background:#2E2B70;
            color:#fff;
            padding:12px 20px;
            border-radius:6px;
            text-decoration:none;
            margin-top:12px;
            font-weight:bold;
        }

        .footer {
            text-align:center;
            font-size:12px;
            color:#999;
            margin-top:25px;
        }
    </style>
</head>

<body>

<div class="email-container">
    <div class="email-header">
        <h1>Verify Your Email</h1>
    </div>

    <div class="email-body">
        <p>Hi {{ $user_name }},</p>

        <p>
            Thank you for registering on <strong>World Business Guide – WBG24.com – Your international Market.</strong>
        </p>

        <p>
            Before you can access your account, please verify your email address:
        </p>

        <p style="text-align:center;">
            <a href="{{ $verification_url }}" class="btn">Verify My Email</a>
        </p>

        <p>This step ensures the security of your account and helps us provide the best experience.</p>

        <p>If you did not sign up, simply ignore this email.</p>

        <p>For any assistance, contact us at <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>

        <p>With friendly regards,<br><strong>WBG24 Team</strong></p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} WBG24. All Rights Reserved.
    </div>
</div>

</body>
</html>
