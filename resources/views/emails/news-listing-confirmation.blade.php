<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Confirmation - WBG24</title>
    <style>
        body { font-family: Arial, sans-serif; color:#333; background:#f4f4f4; margin:0; padding:0; }
        .email-container { max-width:600px; margin:20px auto; background:#fff; padding:20px;
            border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,.1); }
        .email-header { background:#2E2B70; padding:20px; color:#fff; text-align:center;
            border-radius:8px 8px 0 0; }
        .email-header h1 { margin:0; }
        .email-body { padding:20px; color:#555; }
        .btn { display:inline-block; background:#2E2B70; color:#fff; padding:12px 20px; text-decoration:none;
            font-weight:bold; border-radius:6px; margin-top:10px; }
        ul { padding-left: 18px; }
        .footer { text-align:center; font-size:12px; color:#999; margin-top:25px; }
    </style>
</head>

<body>

<div class="email-container">

    <div class="email-header">
        <h1>Listing Successful</h1>
    </div>

    <div class="email-body">
        <p>Dear {{ $user_name }},</p>

        <p>Great news! Your listing on <strong>World Business Guide – WBG24.com</strong> has been successfully published.</p>

        <h3>Listing Details</h3>
        <ul>
            <li><strong>Listing Type:</strong> {{ $listing_type }} <!-- Product / Tender / RFQ / News --></li>
            <li><strong>Title:</strong> {{ $listing_title }}</li>
            <li><strong>Listing ID:</strong> {{ $listing_id }}</li>
        </ul>

        <p><strong>View Listing:</strong> <a href="{{ $listing_link }}">{{ $listing_link }}</a></p>

        <p style="margin-top:15px;">
            📢 Tip: Improve visibility by uploading high-quality images and detailed descriptions.
        </p>

        <p style="text-align:center;">
            <a href="{{ $dashboard_link }}" class="btn">Go To Dashboard</a>
        </p>

        <p>For support, contact: <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a></p>

        <p>With Best Regards,<br><strong>WBG24 Team</strong></p>
    </div>

    <div class="footer">
        © {{ date('Y') }} WBG24. All rights reserved.
    </div>
</div>

</body>
</html>
