<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Images Have Been Successfully Uploaded</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f7fa; color: #333; }
        .container { background: #fff; margin: 40px auto; padding: 30px; max-width: 600px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #004aad; color: #fff; text-align: center; padding: 15px; font-size: 18px; border-radius: 10px 10px 0 0; }
        .body { margin-top: 20px; line-height: 1.6; }
        .footer { margin-top: 25px; text-align: center; font-size: 13px; color: #777; }
        ul { list-style: none; padding: 0; }
        li::before { content: "✔ "; color: green; }
        a { color: #004aad; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">World Business Guide – WBG24.com</div>

        <div class="body">
            <p>Dear {{ $user->first_name }},</p>

            <p>We confirm that your Profile/Store Images have been successfully uploaded on <strong>World Business Guide – WBG24.com</strong>.</p>

            <p><strong>Uploaded Images:</strong></p>
            <ul>
                <li>Profile Picture: ✅ Successfully Updated</li>
                <li>Store Images: ✅ {{ $uploadedImagesCount }} Uploaded</li>
            </ul>

            <p>If you did not upload these images or notice any discrepancies, please review your account settings or contact our support team at 
                <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.
            </p>

            <p>With best regards,<br>
            <strong>World Business Guide – WBG24.com</strong><br>
            Your International Market</p>
        </div>

        <div class="footer">
            © {{ date('Y') }} World Business Guide – WBG24.com. All rights reserved.
        </div>
    </div>
</body>
</html>
