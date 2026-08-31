<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Status Permohonan Akses - Baca Dulu</title>

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
            padding: 25px 16px;
            background:
                radial-gradient(circle at top left, rgba(239, 88, 67, .13), transparent 30%),
                radial-gradient(circle at bottom right, rgba(247, 170, 53, .11), transparent 30%),
                #f5f6fa;
            color: #241B52;
        }

        .status-wrapper {
            width: min(100%, 620px);
        }

        .status-card {
            overflow: hidden;
            border: 1px solid rgba(36, 27, 82, .08);
            border-radius: 27px;
            background: #fff;
            box-shadow: 0 25px 70px rgba(36, 27, 82, .12);
        }

        .status-top {
            height: 7px;
            background: linear-gradient(90deg, #241B52, #EF5843, #F7AA35);
        }

        .status-content {
            padding: 42px;
            text-align: center;
        }

        .status-icon {
            width: 74px;
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            border-radius: 50%;
            font-size: 28px;
            font-weight: 800;
        }

        .status-icon.pending {
            background: #fff7e8;
            color: #e49720;
        }

        .status-icon.approved {
            background: #ecfdf3;
            color: #199447;
        }

        .status-icon.rejected {
            background: #fef2f2;
            color: #d93e3e;
        }

        .status-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            margin-bottom: 15px;
            padding: 0 11px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .status-label.pending {
            background: #fff7e8;
            color: #b87512;
        }

        .status-label.approved {
            background: #ecfdf3;
            color: #178344;
        }

        .status-label.rejected {
            background: #fef2f2;
            color: #c52f2f;
        }

        h1 {
            margin: 0;
            color: #241B52;
            font-size: 29px;
            line-height: 1.2;
            letter-spacing: -.035em;
        }

        .status-description {
            max-width: 480px;
            margin: 13px auto 0;
            color: #777985;
            font-size: 12px;
            line-height: 1.75;
        }

        .approved-notice {
            margin-top: 26px;
            padding: 20px;
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            background: #f0fdf4;
            text-align: left;
        }

        .approved-notice-head {
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }

        .approved-notice-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #dcfce7;
            color: #15803d;
            font-size: 20px;
            font-weight: 800;
        }

        .approved-notice-content {
            min-width: 0;
        }

        .approved-notice-title {
            margin: 0;
            color: #166534;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.5;
        }

        .approved-notice-text {
            margin: 6px 0 0;
            color: #27804a;
            font-size: 11px;
            line-height: 1.7;
        }

        .approved-email {
            display: block;
            margin-top: 10px;
            padding: 11px 13px;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            background: #fff;
            color: #166534;
            font-size: 11px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .approved-steps {
            margin: 14px 0 0;
            padding: 13px 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .7);
            color: #32734b;
            font-size: 10px;
            line-height: 1.8;
        }

        .approved-steps strong {
            color: #166534;
        }

        .request-box {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #e8e9ef;
            border-radius: 16px;
            background: #f9fafc;
            text-align: left;
        }

        .request-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #e8e9ef;
        }

        .request-row:first-child {
            padding-top: 0;
        }

        .request-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .request-label {
            color: #9899a3;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .request-value {
            max-width: 65%;
            color: #241B52;
            font-size: 11px;
            font-weight: 700;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .flash {
            margin-top: 22px;
            padding: 13px 15px;
            border-radius: 12px;
            font-size: 11px;
            line-height: 1.6;
        }

        .flash.success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .flash.info {
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #1e40af;
        }

        .status-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 27px;
        }

        .button {
            min-height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border-radius: 11px;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
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
            margin-top: 23px;
            color: #a2a3ab;
            font-size: 9px;
            line-height: 1.7;
        }

        @media (max-width:600px) {
            .status-content {
                padding: 34px 21px;
            }

            h1 {
                font-size: 25px;
            }

            .request-row {
                flex-direction: column;
                gap: 5px;
            }

            .request-value {
                max-width: 100%;
                text-align: left;
            }

            .status-actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }

            .approved-notice {
                padding: 17px;
            }
        }
    </style>
</head>

<body>
    <div class="status-wrapper">
        <div class="status-card">
            <div class="status-top"></div>

            <main class="status-content">

                @if($recovery->status === 'approved')

                    <div class="status-icon approved">✓</div>

                    <span class="status-label approved">
                        Disetujui
                    </span>

                    <h1>Permohonan Disetujui</h1>

                    <p class="status-description">
                        Permohonan akses Anda telah mendapatkan persetujuan.
                        Silakan periksa email Anda untuk melanjutkan proses
                        pembuatan password akses pribadi.
                    </p>

                    <div class="approved-notice">
                        <div class="approved-notice-head">
                            <div class="approved-notice-icon">✉</div>

                            <div class="approved-notice-content">
                                <p class="approved-notice-title">
                                    Periksa Email Anda
                                </p>

                                <p class="approved-notice-text">
                                    Kami telah mengirimkan link pembuatan password
                                    akses ke email pemohon berikut:
                                </p>

                                <span class="approved-email">
                                    {{ $recovery->requester_email }}
                                </span>
                            </div>
                        </div>

                        <div class="approved-steps">
                            Cari email dengan subjek
                            <strong>"Permohonan Akses Admin Disetujui"</strong>.

                            <br>

                            Setelah email ditemukan, klik tombol
                            <strong>"Buat Password Akses"</strong>
                            untuk membuat password pribadi Anda.

                            <br>

                            Link pembuatan password memiliki batas waktu.
                            Apabila link sudah kedaluwarsa, ajukan permohonan kembali.
                        </div>
                    </div>

                @elseif($recovery->status === 'rejected')

                    <div class="status-icon rejected">×</div>

                    <span class="status-label rejected">
                        Ditolak
                    </span>

                    <h1>Permohonan Ditolak</h1>

                    <p class="status-description">
                        Permohonan akses belum dapat disetujui.
                        Hubungi pihak yang bertanggung jawab apabila Anda
                        memerlukan informasi lebih lanjut.
                    </p>

                @else

                    <div class="status-icon pending">⌛</div>

                    <span class="status-label pending">
                        Menunggu Persetujuan
                    </span>

                    <h1>Permohonan Berhasil Dikirim</h1>

                    <p class="status-description">
                        Data identifikasi Anda sudah tersimpan.
                        Sekarang permohonan sedang menunggu persetujuan
                        dari pihak yang berwenang.
                    </p>

                @endif

                @if(session('success'))
                    <div class="flash success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="flash info">
                        {{ session('info') }}
                    </div>
                @endif

                <div class="request-box">

                    <div class="request-row">
                        <span class="request-label">
                            Nomor Permohonan
                        </span>

                        <span class="request-value">
                            #{{ $recovery->id }}
                        </span>
                    </div>

                    <div class="request-row">
                        <span class="request-label">
                            Nama Pemohon
                        </span>

                        <span class="request-value">
                            {{ $recovery->requester_name }}
                        </span>
                    </div>

                    <div class="request-row">
                        <span class="request-label">
                            Jabatan
                        </span>

                        <span class="request-value">
                            {{ $recovery->requester_position }}
                        </span>
                    </div>

                    <div class="request-row">
                        <span class="request-label">
                            Email Pemohon
                        </span>

                        <span class="request-value">
                            {{ $recovery->requester_email }}
                        </span>
                    </div>

                    <div class="request-row">
                        <span class="request-label">
                            Waktu Permohonan
                        </span>

                        <span class="request-value">
                            {{ $recovery->created_at
                                ->timezone('Asia/Jakarta')
                                ->translatedFormat('d F Y, H:i') }} WIB
                        </span>
                    </div>

                    <div class="request-row">
                        <span class="request-label">
                            Status
                        </span>

                        <span class="request-value">
                            {{ strtoupper($recovery->status) }}
                        </span>
                    </div>

                </div>

                <div class="status-actions">

                    @if($recovery->status === 'pending')
                        <a
                            href="{{ url()->current() }}"
                            class="button button-primary"
                        >
                            Periksa Status
                        </a>
                    @endif

                    <a
                        href="{{ route('admin.login') }}"
                        class="button {{ $recovery->status === 'pending' ? 'button-secondary' : 'button-primary' }}"
                    >
                        Kembali ke Login
                    </a>

                </div>

                @if($recovery->status === 'pending')
                    <p class="bottom-note">
                        Jangan membagikan link permohonan ini kepada orang lain.
                        Silakan periksa kembali halaman ini setelah permohonan
                        mendapatkan persetujuan.
                    </p>
                @elseif($recovery->status === 'approved')
                    <p class="bottom-note">
                        Jangan membagikan link permohonan maupun link pembuatan
                        password kepada orang lain.
                    </p>
                @else
                    <p class="bottom-note">
                        Permohonan telah selesai diproses oleh pihak yang berwenang.
                    </p>
                @endif

            </main>
        </div>
    </div>
</body>
</html>