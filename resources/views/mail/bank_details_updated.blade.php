<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Bank Details Have Been Successfully Saved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            background: #ffffff;
            margin: 40px auto;
            padding: 30px;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #004aad;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            font-size: 20px;
            font-weight: bold;
        }
        .body {
            margin-top: 20px;
            line-height: 1.6;
            font-size: 15px;
        }
        .footer {
            margin-top: 25px;
            font-size: 13px;
            color: #777;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li::before {
            content: "✔ ";
            color: green;
        }
        a {
            color: #004aad;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">World Business Guide – WBG24.com</div>

        <div class="body">
            <p>Dear {{ $user->name ?? 'User' }},</p>

            <p>We confirm that your bank details have been successfully saved on 
               <strong>World Business Guide – WBG24.com</strong>.</p>

            <p><strong>Saved Details:</strong></p>
            <ul>
                <li>Account Holder Name: {{ $bank->account_holder ?? 'N/A' }}</li>
                <li>Bank Name: {{ $bank->bank_name ?? 'N/A' }}</li>
                <li>Last 4 Digits of Account Number: 
                    {{ substr($bank->iban ?? 'XXXX', -4) }}
                </li>
                <li>IFSC/SWIFT Code: 
                    {{ substr($bank->bic ?? 'XXXX', 0, 4) . '****' }}
                </li>
            </ul>

            <p>For security reasons, only partial details are shown. 
               If you did not authorize this update, please review your account 
               immediately or contact our support team at 
               <a href="mailto:Support@WorldBusinessGuide.com">
               Support@WorldBusinessGuide.com</a>.</p>

            <p>With best regards,<br>
            <strong>World Business Guide – WBG24.com</strong><br>
            Your International Market</p>
        </div>

        <div class="footer">
            © {{ date('Y') }} World Business Guide – WBG24.com. All Rights Reserved.
        </div>
    </div>
</body>
</html>
