<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$heading}}</title>
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
            color: #ff7f00;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .content p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        .button-container {
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background-color: #ff7f00;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #e67600;
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
            <h1>{{ $heading }}</h1>
            <p>Hello {{ $name }}</p>
            <p>{{ $message_content }}</p>
            <div class="button-container">
                <a href="{{ $url }}" class="button">Upgrade Member Package</a>
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} WBG24. All rights reserved.
        </div>
    </div>
</body>
</html>
