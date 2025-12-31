<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Seller Upgrade is Successful – Start Selling Today!</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f7fa; color: #333; }
        .container {
            background: #ffffff;
            margin: 40px auto;
            padding: 30px;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .header {
            background: #004aad;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 18px;
            border-radius: 10px 10px 0 0;
        }
        .body { margin-top: 20px; line-height: 1.6; }
        .footer { margin-top: 25px; text-align: center; font-size: 13px; color: #777; }
        a { color: #004aad; text-decoration: none; }
        .button {
            background: #004aad;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            World Business Guide – WBG24.com
        </div>

        <div class="body">
            <p>Dear {{ $user->first_name }},</p>

            <p>🎉 <strong>Congratulations!</strong> Your upgrade from <strong>Buyer</strong> to <strong>Seller</strong> on <strong>World Business Guide – WBG24.com</strong> is now complete.</p>

            <p>You can now showcase your products, post tenders, and connect with potential buyers worldwide.</p>

            <p><strong>Your Seller Account Details:</strong></p>
            <ul>
                <li>🔹 Account Type: Seller</li>
                <li>🔹 Package: {{ $packageName }}</li>
                <li>🔹 Dashboard Link: <a href="{{ $dashboardUrl }}" target="_blank">{{ $dashboardUrl }}</a></li>
            </ul>

            <p>📢 <strong>Start listing your products</strong> and expand your business reach today!</p>

            <p>For any assistance, feel free to contact us at 
                <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
            </p>

            <p>With Best Regards,<br>
            <strong>Your World Business Guide – WBG24.com Team</strong></p>
        </div>

        <div class="footer">
            © {{ date('Y') }} World Business Guide – WBG24.com. All rights reserved.
        </div>
    </div>
</body>
</html>
