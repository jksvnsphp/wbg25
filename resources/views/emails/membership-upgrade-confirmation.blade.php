<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Upgrade Confirmation - WBG24</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; background:#f4f4f4; margin:0; padding:0; }
        .email-container{ max-width:600px; margin:20px auto; background:#fff; padding:20px;
            border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,.1); }
        .email-header{ background:#2E2B70; padding:20px; text-align:center;
            color:#fff; border-radius:8px 8px 0 0; }
        .email-header h1{ margin:0; }
        .email-body{ padding:20px; color:#555; }
        .btn{ display:inline-block; padding:12px 20px; background:#2E2B70; color:#fff;
            text-decoration:none; font-weight:bold; border-radius:6px; margin-top:10px; }
        ul { padding-left:18px; }
        .footer{ text-align:center; font-size:12px; color:#999; margin-top:25px; }
    </style>
</head>

<body>

<div class="email-container">

    <div class="email-header">
        <h1>Membership Upgrade Successful</h1>
    </div>

    <div class="email-body">

        <p>Dear {{ $user_name }},</p>

        <p>
            We are pleased to inform you that your Membership Package on 
            <strong>World Business Guide – WBG24.com</strong> has been successfully upgraded.
        </p>

        <h3>New Package Details</h3>
        <ul>
            <li><strong>Plan Name:</strong> {{ $package_name }}</li>
            <li><strong>Activation Date:</strong> {{ $activation_date }}</li>
            <li><strong>Expiry Date:</strong> {{ $expiry_date }}</li>
            <li><strong>New Benefits:</strong> {{ $benefits }}</li>
        </ul>

        <p>
            You now have access to enhanced features and exclusive benefits designed to help grow your Business 
            on the global marketplace.
        </p>

        <p style="text-align:center;">
            <a href="{{ url('/login') }}" class="btn">Access My Account</a>
        </p>

        <p>
            If you have any questions, please contact us at
            <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
        </p>

        <p>
            With Best Regards,<br>
            <strong>World Business Guide – WBG24.com Team</strong>
        </p>
    </div>

    <div class="footer">
        © {{ date('Y') }} WBG24. All rights reserved.
    </div>

</div>

</body>
</html>
