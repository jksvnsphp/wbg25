<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Received on Tender</title>
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
            color: #555;
        }
        .content h1 {
            color: #f41909;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .offer-details {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .offer-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .offer-details span {
            font-weight: bold;
            color: #f41909;
        }
        .tender-image {
            text-align: center;
            margin: 20px 0;
        }
        .tender-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            background-color: #f41909;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
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
            <p>Hello {{ $seller_name }},</p>
            <p>{{ $seller_message }}</p>
            <div class="offer-details">
                <p>Tender Name: <span>{{ $tenderName}}</span></p>
                <p>Tender Price: <span>${{ number_format($tenderPrice, 2) }}</span></p>
                <p>Offer Price: <span>${{ number_format($offer_price, 2) }}</span></p>
                <p>Offer By: <span>{{ $user_name }}</span></p>
                <p>Mail Id: <span>{{ $user_email }}</span></p>
            </div>
            <div class="tender-image">
                <img src="{{ $image }}" alt="Tender Image">
            </div>
            <a href="{{ $btnUrl }}" class="button">{{ $btnText }}</a>
        </div>
        <div class="footer">
            © {{ date('Y') }} WBG24. All rights reserved.
        </div>
    </div>
</body>
</html>
