<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Kode OTP Login Admin Baca Dulu
    </title>

</head>


<body
    style="
        margin:0;
        padding:0;
        background:#f3f2ef;
        font-family:Arial,Helvetica,sans-serif;
        color:#21194e;
    "
>

@php

    $googleName =
        $loginInfo['google_name']
        ?? 'Tidak diketahui';

    $googleEmail =
        $loginInfo['google_email']
        ?? 'Tidak diketahui';

    $accountName =
        $loginInfo['account_name']
        ?? 'Admin Baca Dulu';

    $accountEmail =
        $loginInfo['account_email']
        ?? '-';

    $device =
        $loginInfo['device']
        ?? 'Tidak diketahui';

    $deviceModel =
        $loginInfo['device_model']
        ?? 'Tidak diketahui';

    $operatingSystem =
        $loginInfo['os']
        ?? 'Tidak diketahui';

    $browser =
        $loginInfo['browser']
        ?? 'Tidak diketahui';

    $ipAddress =
        $loginInfo['ip']
        ?? 'Tidak diketahui';

    $loginTime =
        $loginInfo['time']
        ?? '-';

    $userAgent =
        $loginInfo['user_agent']
        ?? '-';

@endphp


<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    width="100%"
    style="
        width:100%;
        background:#f3f2ef;
    "
>

<tr>

<td
    align="center"
    style="
        padding:36px 16px;
    "
>

<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    width="100%"
    style="
        width:100%;
        max-width:620px;
        background:#ffffff;
        border:1px solid #e8e5ed;
        border-radius:18px;
    "
>


{{-- HEADER --}}
<tr>

<td
    style="
        padding:28px 34px;
        background:#21194e;
        border-radius:18px 18px 0 0;
    "
>

<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
>

<tr>

<td valign="middle">

    <div
        style="
            margin-bottom:7px;
            color:#ef5843;
            font-size:11px;
            font-weight:700;
            letter-spacing:1.4px;
            text-transform:uppercase;
        "
    >
        Baca Dulu Security
    </div>

    <h1
        style="
            margin:0;
            color:#ffffff;
            font-size:25px;
            line-height:1.25;
        "
    >
        Verifikasi Login Admin
    </h1>

</td>


<td
    align="right"
    valign="middle"
    width="70"
>

    <div
        style="
            padding:4px;
            background:#ffffff;
            border-radius:14px;
        "
    >

        <img
            src="{{ $message->embed(public_path('img/bacadulu-logo.jpg')) }}"
            alt="Baca Dulu"
            width="54"
            height="54"
            style="
                display:block;
                width:54px;
                height:54px;
                border-radius:10px;
                object-fit:cover;
            "
        >

    </div>

</td>

</tr>

</table>

</td>

</tr>



{{-- INTRO --}}
<tr>

<td
    style="
        padding:30px 34px 0;
    "
>

<p
    style="
        margin:0;
        color:#6e6c76;
        font-size:14px;
        line-height:1.7;
    "
>
    Terdapat permintaan login baru
    ke sistem Admin Baca Dulu.
    Berikut kode verifikasi dan informasi
    identitas pemohon.
</p>

</td>

</tr>



{{-- OTP --}}
<tr>

<td
    style="
        padding:25px 34px 0;
    "
>

<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="
        background:#f7f5f2;
        border:1px solid #ebe7e2;
        border-radius:14px;
    "
>

<tr>

<td
    align="center"
    style="
        padding:25px;
    "
>

<div
    style="
        margin-bottom:10px;
        color:#9a959d;
        font-size:10px;
        font-weight:700;
        letter-spacing:1.4px;
        text-transform:uppercase;
    "
>
    Kode Verifikasi
</div>


<div
    style="
        color:#21194e;
        font-size:38px;
        font-weight:800;
        letter-spacing:9px;
    "
>
    {{ $otp }}
</div>


<div
    style="
        margin-top:10px;
        color:#ef5843;
        font-size:11px;
        font-weight:700;
    "
>
    Berlaku selama 5 menit
</div>

</td>

</tr>

</table>

</td>

</tr>



{{-- GOOGLE IDENTITY --}}
<tr>

<td
    style="
        padding:31px 34px 0;
    "
>

<div
    style="
        margin-bottom:15px;
        color:#21194e;
        font-size:11px;
        font-weight:800;
        letter-spacing:1px;
        text-transform:uppercase;
    "
>
    Identitas Google Pemohon
</div>


<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    width="100%"
    style="
        border-collapse:collapse;
    "
>

<tr>

<td
    style="
        width:150px;
        padding:12px 0;
        border-bottom:1px solid #eeeaf0;
        color:#96919a;
        font-size:12px;
    "
>
    Nama Google
</td>

<td
    style="
        padding:12px 0;
        border-bottom:1px solid #eeeaf0;
        color:#21194e;
        font-size:12px;
        font-weight:700;
    "
>
    {{ $googleName }}
</td>

</tr>


<tr>

<td
    style="
        width:150px;
        padding:12px 0;
        color:#96919a;
        font-size:12px;
    "
>
    Email Google
</td>

<td
    style="
        padding:12px 0;
        color:#ef5843;
        font-size:12px;
        font-weight:800;
        word-break:break-word;
    "
>
    {{ $googleEmail }}
</td>

</tr>

</table>

</td>

</tr>



{{-- ADMIN ACCOUNT --}}
<tr>

<td
    style="
        padding:29px 34px 0;
    "
>

<div
    style="
        margin-bottom:15px;
        color:#21194e;
        font-size:11px;
        font-weight:800;
        letter-spacing:1px;
        text-transform:uppercase;
    "
>
    Akun Admin yang Diakses
</div>


<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="
        border-collapse:collapse;
    "
>

<tr>

<td
    style="
        width:150px;
        padding:12px 0;
        border-bottom:1px solid #eeeaf0;
        color:#96919a;
        font-size:12px;
    "
>
    Akun
</td>

<td
    style="
        padding:12px 0;
        border-bottom:1px solid #eeeaf0;
        color:#21194e;
        font-size:12px;
        font-weight:700;
    "
>
    {{ $accountName }}
</td>

</tr>


<tr>

<td
    style="
        width:150px;
        padding:12px 0;
        color:#96919a;
        font-size:12px;
    "
>
    Email Admin
</td>

<td
    style="
        padding:12px 0;
        color:#21194e;
        font-size:12px;
        font-weight:700;
        word-break:break-word;
    "
>
    {{ $accountEmail }}
</td>

</tr>

</table>

</td>

</tr>



{{-- DEVICE --}}
<tr>

<td
    style="
        padding:29px 34px 0;
    "
>

<div
    style="
        margin-bottom:15px;
        color:#21194e;
        font-size:11px;
        font-weight:800;
        letter-spacing:1px;
        text-transform:uppercase;
    "
>
    Informasi Perangkat
</div>


<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="
        border-collapse:collapse;
    "
>

@foreach([
    'Jenis Perangkat' => $device,
    'Model / Platform' => $deviceModel,
    'Sistem Operasi' => $operatingSystem,
    'Browser' => $browser,
    'IP Address' => $ipAddress,
    'Waktu' => $loginTime,
] as $label => $value)

<tr>

<td
    style="
        width:150px;
        padding:12px 0;
        border-bottom:1px solid #eeeaf0;
        color:#96919a;
        font-size:12px;
    "
>
    {{ $label }}
</td>

<td
    style="
        padding:12px 0;
        border-bottom:1px solid #eeeaf0;
        color:#21194e;
        font-size:12px;
        font-weight:700;
    "
>
    {{ $value }}
</td>

</tr>

@endforeach

</table>

</td>

</tr>



{{-- WARNING --}}
<tr>

<td
    style="
        padding:28px 34px 0;
    "
>

<div
    style="
        padding:17px 18px;
        background:#fff5f2;
        border-left:3px solid #ef5843;
        border-radius:8px;
    "
>

<strong
    style="
        display:block;
        margin-bottom:6px;
        color:#c84836;
        font-size:12px;
    "
>
    Tidak mengenali orang ini?
</strong>

<p
    style="
        margin:0;
        color:#716c72;
        font-size:11px;
        line-height:1.65;
    "
>
    Jangan memberikan kode OTP kepada siapa pun.
    Tanpa kode OTP ini, orang tersebut tidak dapat
    menyelesaikan proses login ke Admin Baca Dulu.
</p>

</div>

</td>

</tr>



{{-- TECHNICAL --}}
<tr>

<td
    style="
        padding:24px 34px 0;
    "
>

<div
    style="
        margin-bottom:7px;
        color:#aaa5ac;
        font-size:9px;
        font-weight:700;
        letter-spacing:.8px;
        text-transform:uppercase;
    "
>
    Informasi Teknis
</div>

<div
    style="
        padding:12px 14px;
        background:#f7f7f7;
        border-radius:8px;
        color:#99959c;
        font-family:Consolas,Monaco,monospace;
        font-size:9px;
        line-height:1.55;
        word-break:break-word;
    "
>
    {{ $userAgent }}
</div>

</td>

</tr>



{{-- FOOTER --}}
<tr>

<td
    align="center"
    style="
        padding:31px 34px 30px;
    "
>

<div
    style="
        width:40px;
        height:1px;
        margin:0 auto 14px;
        background:#ef5843;
    "
></div>

<p
    style="
        margin:0;
        color:#aaa6ad;
        font-size:10px;
        line-height:1.6;
    "
>
    Email keamanan otomatis dari
    <strong style="color:#21194e;">
        Baca Dulu
    </strong>.
    <br>
    Jangan balas email ini.
</p>

</td>

</tr>


</table>

</td>

</tr>

</table>

</body>

</html>