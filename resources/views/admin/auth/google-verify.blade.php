<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Verifikasi Google | Baca Dulu
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
            background: #f4f1eb;
            color: #21194e;
            font-family:
                Inter,
                Arial,
                Helvetica,
                sans-serif;
        }

        .google-verify {
            width: 100%;
            max-width: 460px;
        }

        .google-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(33, 25, 78, .10);
            border-radius: 24px;
            box-shadow:
                0 22px 65px
                rgba(33, 25, 78, .10);
        }

        .google-header {
            position: relative;
            padding: 32px;
            background: #21194e;
        }

        .google-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .google-eyebrow {
            margin-bottom: 8px;
            color: #ef5843;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .google-header h1 {
            margin: 0;
            max-width: 280px;
            color: #ffffff;
            font-size: 26px;
            line-height: 1.2;
        }

        .google-logo {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            overflow: hidden;
            padding: 4px;
            background: #ffffff;
            border-radius: 14px;
        }

        .google-logo img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        .google-body {
            padding: 32px;
        }

        .google-body > p {
            margin: 0;
            color: #77727b;
            font-size: 14px;
            line-height: 1.75;
        }

        .google-info {
            margin-top: 24px;
            padding: 18px;
            background: #f8f6f2;
            border: 1px solid #ebe7e1;
            border-radius: 15px;
        }

        .google-info strong {
            display: block;
            margin-bottom: 7px;
            color: #21194e;
            font-size: 13px;
        }

        .google-info p {
            margin: 0;
            color: #77727b;
            font-size: 12px;
            line-height: 1.65;
        }

        .google-button {
            width: 100%;
            min-height: 55px;
            margin-top: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;

            border: 0;
            border-radius: 13px;

            background: #21194e;
            color: #ffffff;

            font-size: 13px;
            font-weight: 700;
            text-decoration: none;

            transition:
                transform .18s ease,
                background .18s ease;
        }

        .google-button:hover {
            background: #302765;
            transform: translateY(-1px);
        }

        .google-icon {
            width: 26px;
            height: 26px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ffffff;
            color: #21194e;

            border-radius: 7px;

            font-size: 14px;
            font-weight: 900;
        }

        .security-note {
            display: flex;
            gap: 10px;
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid #eeeaf0;
        }

        .security-dot {
            width: 7px;
            height: 7px;
            flex: 0 0 7px;
            margin-top: 5px;
            background: #ef5843;
            border-radius: 50%;
        }

        .security-note p {
            margin: 0;
            color: #96919a;
            font-size: 10.5px;
            line-height: 1.65;
        }

        .error {
            margin-bottom: 20px;
            padding: 13px 15px;
            background: #fff1ef;
            border-left: 3px solid #ef5843;
            border-radius: 8px;
            color: #a43f32;
            font-size: 12px;
            line-height: 1.5;
        }

        @media(max-width:520px) {
            .google-header,
            .google-body {
                padding: 25px;
            }

            .google-header h1 {
                font-size: 23px;
            }

            .google-logo {
                width: 52px;
                height: 52px;
                flex-basis: 52px;
            }
        }
    </style>
</head>


<body>

    <main class="google-verify">

        <section class="google-card">

            <header class="google-header">

                <div class="google-header-row">

                    <div>

                        <div class="google-eyebrow">
                            Baca Dulu Security
                        </div>

                        <h1>
                            Verifikasi Identitas Google
                        </h1>

                    </div>


                    <div class="google-logo">

                        <img
                            src="{{ asset('img/bacadulu-logo.jpg') }}"
                            alt="Logo Baca Dulu"
                        >

                    </div>

                </div>

            </header>


            <div class="google-body">

                @if(session('error'))

                    <div class="error">
                        {{ session('error') }}
                    </div>

                @endif


                <p>
                    Password admin telah berhasil diverifikasi.
                    Sebelum kode OTP dikirim, pilih akun Google
                    pribadi Anda untuk mencatat identitas orang
                    yang melakukan permintaan login.
                </p>


                <div class="google-info">

                    <strong>
                        Gunakan akun Google milik Anda sendiri
                    </strong>

                    <p>
                        Jangan menggunakan akun Google milik
                        orang lain. Nama dan alamat Gmail yang
                        dipilih akan dicantumkan pada email
                        keamanan OTP Baca Dulu.
                    </p>

                </div>


                <a
                    href="{{ route('admin.google.redirect') }}"
                    class="google-button"
                >

                    <span class="google-icon">
                        G
                    </span>

                    <span>
                        Lanjutkan dengan Google
                    </span>

                </a>


                <div class="security-note">

                    <span class="security-dot"></span>

                    <p>
                        Google akan menampilkan pilihan akun.
                        Pilih akun Gmail Anda sendiri.
                        Setelah identitas berhasil diverifikasi,
                        kode OTP akan dikirim ke alamat email
                        keamanan Admin Baca Dulu.
                    </p>

                </div>

            </div>

        </section>

    </main>

</body>

</html>