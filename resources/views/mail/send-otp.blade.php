<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            padding: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content h1 {
            color: #f41909;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .content p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        .otp {
            display: inline-block;
            font-size: 24px;
            font-weight: bold;
            color: #f41909;
            margin: 20px 0;
            background: #f9f9f9;
            padding: 10px 20px;
            border-radius: 5px;
            border: 1px dashed #f41909;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #888;
            background-color: #f3f3f3;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ env('URL_LOGO') }}" alt="WBG24">
        </div>
        <div class="content">
            <h1>Verification Code</h1>
            <p>Hello User,</p>
            <p>We have received a request to verify your identity. Please use the following Verification Code to complete the process:</p>
            <div class="otp">{{ $otp }}</div>
            <p>This Code is valid for 10 minutes. If you did not make this request, please ignore this email.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} WBG24. All rights reserved.
        </div>
    </div>
</body>
</html>
