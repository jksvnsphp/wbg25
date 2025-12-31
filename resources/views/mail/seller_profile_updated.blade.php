<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Profile Has Been Successfully Updated</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <p>Dear {{ $user->first_name }},</p>

    <p>We would like to confirm that Your Profile Details on <strong>World Business Guide - WBG24.com</strong> have been successfully updated.</p>

    <p><strong>Updated Information Includes:</strong></p>
    <ul>
        <li>✔ Name: {{ $user->first_name }} {{ $user->last_name }}</li>
        <li>✔ Email: {{ $user->email }}</li>
        <li>✔ Company Name: {{ $company->name ?? 'N/A' }}</li>
        <li>✔ Other Changes: Profile and Company details updated successfully.</li>
    </ul>

    <p>If you did not make this Change, please review Your Account Settings or contact our Support Team immediately at <a href="mailto:support@worldbusinessguide.com">support@worldbusinessguide.com</a>.</p>

    <p>With Best Regards,<br>
    <strong>World Business Guide - WBG24.com</strong><br>
    Your International Market</p>
</body>
</html>
