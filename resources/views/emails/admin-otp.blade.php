<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Login Admin BacaDulu</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial,sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:white; padding:40px; text-align:center; border-radius:12px;">

        <h2 style="margin-bottom:20px;">
            Verifikasi Kode OTP
        </h2>

        <p>
            Gunakan kode OTP berikut untuk melanjutkan login sebagai Admin BacaDulu:
        </p>

        <div style="
            margin:30px 0;
            padding:20px;
            background:#f1f1f1;
            border-radius:10px;
            font-size:36px;
            font-weight:bold;
            letter-spacing:10px;
        ">
            {{ $otp }}
        </div>

        <p>
            Kode OTP ini berlaku selama <strong>5 menit</strong>.
        </p>

        <p style="color:#777; font-size:13px;">
            Jika kamu tidak melakukan login, abaikan email ini.
        </p>

    </div>

</body>
</html>