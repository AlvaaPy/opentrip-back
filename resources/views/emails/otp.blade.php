<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        /* Reset dasar */
        body, h1, p {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f2f3f8;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .email-container {
            max-width: 550px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid #eaeaea;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }
        .subheader {
            font-size: 14px;
            color: #777777;
            margin-bottom: 30px;
        }
        .message {
            font-size: 16px;
            color: #555555;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        .otp-code {
            display: inline-block;
            font-size: 28px;
            color: #ffffff;
            font-weight: bold;
            background-color: #4CAF50;
            padding: 15px 30px;
            border-radius: 8px;
            letter-spacing: 3px;
            margin: 20px 0;
        }
        .validity {
            font-size: 14px;
            color: #999999;
            margin-top: 15px;
        }
        .footer {
            font-size: 12px;
            color: #aaaaaa;
            margin-top: 30px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer-link {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">Kode Verifikasi Anda</div>
        <div class="subheader">Pastikan kode ini hanya digunakan oleh Anda</div>
        <div class="message">Silakan gunakan kode OTP di bawah ini untuk menyelesaikan proses verifikasi Anda:</div>
        <div class="otp-code">{{ $otp }}</div>
        <div class="validity">Kode ini berlaku selama 10 menit.</div>
        <div class="footer">
            <p>&copy; 2024 Permata Wisata. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
