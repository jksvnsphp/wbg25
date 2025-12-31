<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Seller Upgrade is Successful – Start Selling Today!</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 650px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, #0056b3, #007bff);
            color: #fff;
            padding: 25px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
        }
        .content {
            padding: 30px;
            color: #333;
            line-height: 1.7;
        }
        .content h2 {
            color: #0056b3;
            margin-top: 0;
        }
        .info-box {
            background: #f1f5ff;
            border-left: 4px solid #007bff;
            padding: 15px 20px;
            border-radius: 6px;
            margin: 15px 0;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 15px;
        }
        .cta-button {
            display: inline-block;
            background: #007bff;
            color: #fff !important;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            transition: background 0.3s ease;
        }
        .cta-button:hover {
            background: #0056b3;
        }
        .footer {
            background: #f1f1f1;
            padding: 15px 20px;
            text-align: center;
            color: #777;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>🎉 Your Seller Upgrade is Successful!</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $name ?? 'User' }}</strong>,</p>

            <p>Congratulations! Your upgrade from <strong>Buyer</strong> to <strong>Seller</strong> on 
               <strong>World Business Guide (WBG24.com)</strong> has been successfully completed.</p>

            <div class="info-box">
                <p>🔹 <strong>Account Type:</strong> Seller</p>
                <p>🔹 <strong>Package:</strong> {{ $package ?? 'Basic' }}</p>
                <p>🔹 <strong>Seller Dashboard:</strong> 
                    <a href="{{ $dashboardLink ?? '#' }}" style="color:#007bff; text-decoration:none;">
                        {{ $dashboardLink ?? 'Click here' }}
                    </a>
                </p>
            </div>

            <h2>✨ Your Seller Benefits Include:</h2>
            <ul>
                <li>✅ List and Showcase Your Products Globally</li>
                <li>✅ Participate in B2B & B2C Tenders and Quotations</li>
                <li>✅ Connect with Verified Buyers Worldwide</li>
                <li>✅ Create Your Own Storefront Subdomain</li>
                <li>✅ Access Exclusive Marketing & Lead Tools</li>
            </ul>

            <p>Start exploring your new Seller Dashboard and take your business to new heights!</p>

            <p style="text-align:center;">
                <a href="{{ $dashboardLink ?? '#' }}" class="cta-button">Go to Seller Dashboard</a>
            </p>

            <p>If you need any assistance, feel free to contact our support team at 
                <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
            </p>

            <p>With Best Regards,<br>
            <strong>World Business Guide – WBG24.com Team</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} World Business Guide – WBG24.com. All Rights Reserved.
        </div>
    </div>
</body>
</html>
