<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #ff6600;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            color: #ff6600;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }
        .content .credentials {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .content .credentials p {
            margin: 0;
        }
        .footer {
            background-color: #f7f7f7;
            color: #666666;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to WBG24</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Your account has been created. Here are your credentials:</p>
            <div class="credentials">
                <p><strong>Username:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> {{ $user->fpassword }}</p>
            </div>
            <p>Please log in and change your password immediately.</p>
            <p>Thank you!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} WBG24. All rights reserved.
        </div>
    </div>
</body>
</html>
