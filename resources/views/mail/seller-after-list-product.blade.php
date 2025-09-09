<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listed Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #f41909;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body h2 {
            color: #f41909;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .email-body p {
            margin: 10px 0;
            line-height: 1.6;
        }
        .email-body ul {
            list-style-type: none;
            padding: 0;
        }
        .email-body ul li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .email-body .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .email-body .button-container a {
            background-color: #f41909;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
        }
        .email-body .button-container a:hover {
            background-color: #d31708;
        }
        .email-footer {
            background-color: #f7f7f7;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #666;
        }
        .email-footer a {
            color: #f41909;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Product Successfully Listed!</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello,</h2>
            <p>We are thrilled to inform you that your product has been successfully listed on our platform. Here are the details of your listing:</p>

            <ul>
                <li><strong>Product Name:</strong> {{ $product['name'] }}</li>
                <li><strong>Description:</strong> {!! $product['description'] !!}</li>
                <li><strong>Price:</strong> ${{ $product['price'] }}</li>
                <li><strong>Available Quantity:</strong> {{ $product['totalQty'] }}</li>
            </ul>

            <div class="button-container">
                <a href="{{ $product['url'] }}" target="_blank">View Your Listing</a>
            </div>

            <p>If you need to make any changes to your listing, please log in to your account or contact our support team.</p>
            <p>Thank you for choosing our platform to showcase your products!</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} WBG24. All rights reserved.</p>
            <p>
                Need help? <a href="mailto:support@wbg24.com">Contact Support</a>
            </p>
        </div>
    </div>
</body>
</html>
