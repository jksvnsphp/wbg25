<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Profile Has Been Successfully Updated</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
            color: #333;
        }
        .container {
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #1a237e;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li::before {
            content: "✔ ";
            color: #4CAF50;
        }
        a {
            color: #1a73e8;
            text-decoration: none;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Profile Has Been Successfully Updated</h2>

    <p>Dear {{ $user->first_name }},</p>

    <p>We would like to confirm that your profile details on <strong>World Business Guide - WBG24.com</strong> have been successfully updated.</p>

    <p><strong>Updated Information Includes:</strong></p>
    <ul>
        <li>Name: {{ $user->first_name }} {{ $user->last_name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Company Name: {{ $user->company_name ?? 'N/A' }}</li>
        <li>Other Changes: Address or Contact Details</li>
    </ul>

    <p>If you did not make this change, please review your account settings or contact our Support Team immediately at 
        <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
    </p>

    <p>With Best Regards,<br>
    <strong>World Business Guide - WBG24.com</strong><br>
    <em>Your International Market</em></p>

    <div class="footer">
        &copy; {{ date('Y') }} World Business Guide - All rights reserved.
    </div>
</div>
</body>
</html>
