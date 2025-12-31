<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Password Has Been Successfully Changed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafc;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #004aad;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .email-body {
            padding: 30px;
            font-size: 15px;
            line-height: 1.6;
        }
        .email-footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
        .btn {
            display: inline-block;
            background-color: #004aad;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #003780;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            World Business Guide – WBG24.com
        </div>
        <div class="email-body">
            <p>Dear {{ $user->name ?? 'User' }},</p>

            <p>We want to inform you that your <strong>World Business Guide – WBG24.com</strong> account password has been successfully updated.</p>

            <p>If you made this change, no further action is needed. However, if you did not request this change, please reset your password immediately using the link below and contact our support team.</p>

            <p style="text-align:center;">
                <a href="{{ route('forget.password') }}" class="btn">🔗 Reset Password</a>
            </p>

            <p>For any security concerns, reach us at 
                <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
            </p>

            <p>With best regards,<br>
            <strong>World Business Guide – WBG24.com</strong><br>
            Your International Market</p>
        </div>
        <div class="email-footer">
            © {{ date('Y') }} World Business Guide – WBG24.com. All Rights Reserved.
        </div>
    </div>
</body>
</html>
