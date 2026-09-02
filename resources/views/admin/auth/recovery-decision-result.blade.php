<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil Permohonan - Baca Dulu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(239, 88, 67, .13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(247, 170, 53, .12),
                    transparent 30%
                ),
                #f5f6fa;
            color: #241B52;
        }

        .result-wrapper {
            width: min(100%, 560px);
        }

        .result-card {
            overflow: hidden;
            border: 1px solid rgba(36, 27, 82, .08);
            border-radius: 26px;
            background: #fff;
            box-shadow: 0 25px 70px rgba(36, 27, 82, .12);
        }

        .result-top {
            height: 7px;
            background: linear-gradient(
                90deg,
                #241B52,
                #EF5843,
                #F7AA35
            );
        }

        .result-content {
            padding: 42px;
            text-align: center;
        }

        .result-icon {
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 21px;
            border-radius: 50%;
            font-size: 28px;
            font-weight: 800;
        }

        .result-icon.approved {
            background: #ecfdf3;
            color: #168448;
        }

        .result-icon.rejected {
            background: #fef2f2;
            color: #c52f2f;
        }

        .result-icon.warning {
            background: #fff7e8;
            color: #c47d16;
        }

        .result-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            margin-bottom: 14px;
            padding: 0 11px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .result-label.approved {
            background: #ecfdf3;
            color: #168448;
        }

        .result-label.rejected {
            background: #fef2f2;
            color: #c52f2f;
        }

        .result-label.warning {
            background: #fff7e8;
            color: #a9670d;
        }

        h1 {
            margin: 0;
            color: #241B52;
            font-size: 27px;
            line-height: 1.3;
        }

        .result-description {
            max-width: 450px;
            margin: 12px auto 0;
            color: #777985;
            font-size: 12px;
            line-height: 1.75;
        }

        .result-box {
            margin-top: 25px;
            padding: 17px;
            border: 1px solid #e8e9ef;
            border-radius: 14px;
            background: #f9fafc;
            text-align: left;
        }

        .result-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 9px 0;
            border-bottom: 1px solid #e8e9ef;
        }

        .result-row:first-child {
            padding-top: 0;
        }

        .result-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .result-row span:first-child {
            color: #9899a3;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .result-row strong {
            max-width: 65%;
            color: #241B52;
            font-size: 11px;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .warning-box {
            margin-top: 22px;
            padding: 15px;
            border: 1px solid #fde4a7;
            border-radius: 13px;
            background: #fffaf0;
            color: #91610e;
            font-size: 11px;
            line-height: 1.7;
            text-align: left;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 17px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
        }

        .button-primary {
            border: 1px solid #241B52;
            background: #241B52;
            color: #fff;
        }

        .button-secondary {
            border: 1px solid #dddfe6;
            background: #fff;
            color: #666873;
        }

        .bottom-note {
            margin: 22px 0 0;
            color: #a2a3ab;
            font-size: 9px;
            line-height: 1.7;
        }

        @media (max-width: 600px) {
            .result-content {
                padding: 34px 21px;
            }

            h1 {
                font-size: 23px;
            }

            .result-row {
                flex-direction: column;
                gap: 5px;
            }

            .result-row strong {
                max-width: 100%;
                text-align: left;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="result-wrapper">
    <div class="result-card">

        <div class="result-top"></div>

        <main class="result-content">

            @if($notificationSent === false)

                <div class="result-icon warning">
                    !
                </div>

                <span class="result-label warning">
                    Email Gagal Dikirim
                </span>

                <h1>
                    Keputusan Belum Diselesaikan
                </h1>

                <p class="result-description">
                    Sistem belum dapat menyelesaikan keputusan karena
                    pemberitahuan ke email pemohon gagal dikirim.
                </p>

                <div class="warning-box">
                    Status permohonan telah dikembalikan menjadi
                    <strong>MENUNGGU PERSETUJUAN</strong> agar pemohon
                    tidak menerima informasi yang salah.

                    <br><br>

                    Periksa koneksi internet dan konfigurasi email,
                    kemudian coba proses keputusan kembali.
                </div>

            @elseif($recovery->status === 'approved')

                <div class="result-icon approved">
                    ✓
                </div>

                <span class="result-label approved">
                    Disetujui
                </span>

                <h1>
                    Permohonan Disetujui
                </h1>

                <p class="result-description">
                    Permohonan akses milik
                    <strong>{{ $recovery->requester_name }}</strong>
                    telah berhasil disetujui.

                    @if($notificationSent === true)
                        Pemberitahuan dan link pembuatan password
                        berhasil dikirim ke email pemohon.
                    @elseif($alreadyProcessed)
                        Permohonan ini sudah diproses sebelumnya.
                    @endif
                </p>

            @elseif($recovery->status === 'rejected')

                <div class="result-icon rejected">
                    ×
                </div>

                <span class="result-label rejected">
                    Ditolak
                </span>

                <h1>
                    Permohonan Ditolak
                </h1>

                <p class="result-description">
                    Permohonan akses milik
                    <strong>{{ $recovery->requester_name }}</strong>
                    telah ditolak.

                    @if($notificationSent === true)
                        Pemberitahuan berhasil dikirim ke email pemohon.
                    @elseif($alreadyProcessed)
                        Permohonan ini sudah diproses sebelumnya.
                    @endif
                </p>

            @else

                <div class="result-icon warning">
                    !
                </div>

                <span class="result-label warning">
                    Menunggu
                </span>

                <h1>
                    Permohonan Belum Diproses
                </h1>

                <p class="result-description">
                    Keputusan terhadap permohonan ini belum berhasil diselesaikan.
                </p>

            @endif

            <div class="result-box">

                <div class="result-row">
                    <span>Nomor</span>

                    <strong>
                        #{{ $recovery->id }}
                    </strong>
                </div>

                <div class="result-row">
                    <span>Pemohon</span>

                    <strong>
                        {{ $recovery->requester_name }}
                    </strong>
                </div>

                <div class="result-row">
                    <span>Email</span>

                    <strong>
                        {{ $recovery->requester_email }}
                    </strong>
                </div>

                <div class="result-row">
                    <span>Status</span>

                    <strong>
                        {{ strtoupper($recovery->status) }}
                    </strong>
                </div>

            </div>

            <div class="actions">

                @if($notificationSent === false && $retryUrl)
                    <a
                        href="{{ $retryUrl }}"
                        class="button button-primary"
                    >
                        Coba Proses Lagi
                    </a>
                @endif

                <a
                    href="{{ route('admin.login') }}"
                    class="button {{ $notificationSent === false && $retryUrl ? 'button-secondary' : 'button-primary' }}"
                >
                    Kembali ke Login
                </a>

            </div>

            <p class="bottom-note">
                Sistem mencatat keputusan permohonan akses dan
                kegagalan pengiriman email pada log aplikasi.
            </p>

        </main>

    </div>
</div>

</body>
</html>