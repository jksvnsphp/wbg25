<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Your Password</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f7f7f7; color:#222; margin:0; padding:0;}
        .container { max-width:600px; margin:30px auto; background:#fff; border-radius:6px; padding:24px; box-shadow:0 2px 6px rgba(0,0,0,0.06);}
        .btn { display:inline-block; padding:12px 20px; border-radius:6px; text-decoration:none; font-weight:600; }
        .btn-primary { background:#1d6fff; color:#fff; }
        .muted { color:#666; font-size:13px; }
        .footer { font-size:12px; color:#888; margin-top:18px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Your Password</h2>

        <p>Dear {{ $user->name ?? $user->email }},</p>

        <p>We received a request to reset your password for your World Business Guide (WBG24.com) account. If you initiated this request, please click the button below to set a new password:</p>

        <p style="text-align:center; margin:22px 0;">
            <a href="{{ $resetUrl }}" class="btn btn-primary" target="_blank" rel="noopener">🔗 Reset Password</a>
        </p>

        <p class="muted">
            For security reasons, this link will expire in <strong>{{ $expiresMinutes }} minutes</strong>.
        </p>

        <p>If you did not request a password reset, you can safely ignore this email or contact our support team immediately.</p>

        <p>Need assistance? Reach us at <a href="mailto:Support@WorldBusinessGuide.com">Support@WorldBusinessGuide.com</a>.</p>

        <p>With best regards,<br>
        <strong>World Business Guide - WBG24.com</strong><br>
        Your international market</p>

        <div class="footer">
            <p>This email was sent to {{ $user->email }}. If you didn’t request this, no further action is required.</p>
        </div>
    </div>
</body>
</html>