<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Hasil Permohonan - Baca Dulu</title>

    <style>
        *{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:#f4f5f8;
            font-family:Arial,Helvetica,sans-serif;
            color:#241B52
        }
        .card{
            width:min(100%,500px);
            padding:38px;
            border-radius:22px;
            background:#fff;
            box-shadow:0 24px 70px rgba(36,27,82,.12);
            text-align:center
        }
        .icon{
            width:72px;
            height:72px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 20px;
            border-radius:50%;
            font-size:30px;
            font-weight:900
        }
        .approved{
            background:#ecfdf3;
            color:#168448
        }
        .rejected{
            background:#fef2f2;
            color:#c52f2f
        }
        h1{
            margin:0;
            font-size:27px
        }
        p{
            margin:12px 0 0;
            color:#777985;
            font-size:13px;
            line-height:1.7
        }
    </style>
</head>

<body>

<div class="card">

    @if($recovery->status === 'approved')

        <div class="icon approved">✓</div>

        <h1>Permohonan Disetujui</h1>

        <p>
            Permohonan akses milik
            <strong>{{ $recovery->requester_name }}</strong>
            telah berhasil disetujui.
            Sistem juga telah mengirimkan pemberitahuan ke email pemohon.
        </p>

    @else

        <div class="icon rejected">×</div>

        <h1>Permohonan Ditolak</h1>

        <p>
            Permohonan akses milik
            <strong>{{ $recovery->requester_name }}</strong>
            telah ditolak.
            Sistem juga telah mengirimkan pemberitahuan ke email pemohon.
        </p>

    @endif

</div>

</body>
</html>