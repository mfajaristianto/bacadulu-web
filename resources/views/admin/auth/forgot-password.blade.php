<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Permohonan Akses Admin - Baca Dulu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        *{
            box-sizing:border-box;
        }

        html,body{
            margin:0;
            min-height:100%;
            font-family:'Inter',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:30px 18px;
            background:
                radial-gradient(circle at top left,rgba(239,88,67,.15),transparent 30%),
                radial-gradient(circle at bottom right,rgba(247,170,53,.12),transparent 30%),
                #f5f6fa;
            color:#241B52;
        }

        .recovery-wrapper{
            width:min(100%,820px);
        }

        .recovery-card{
            overflow:hidden;
            border:1px solid rgba(36,27,82,.08);
            border-radius:28px;
            background:#fff;
            box-shadow:0 25px 70px rgba(36,27,82,.12);
        }

        .recovery-header{
            position:relative;
            padding:38px 42px 34px;
            overflow:hidden;
            background:#241B52;
            color:#fff;
        }

        .recovery-header::after{
            content:"";
            position:absolute;
            width:230px;
            height:230px;
            top:-120px;
            right:-80px;
            border-radius:50%;
            background:rgba(239,88,67,.18);
        }

        .recovery-brand{
            position:relative;
            z-index:2;
            display:inline-flex;
            align-items:center;
            gap:10px;
            margin-bottom:28px;
            font-size:13px;
            font-weight:800;
            letter-spacing:.08em;
            text-transform:uppercase;
        }

        .recovery-brand-dot{
            width:10px;
            height:10px;
            border-radius:50%;
            background:#EF5843;
            box-shadow:18px 0 0 #F7AA35;
            margin-right:18px;
        }

        .recovery-header h1{
            position:relative;
            z-index:2;
            margin:0;
            max-width:600px;
            font-size:32px;
            line-height:1.15;
            letter-spacing:-.035em;
        }

        .recovery-header p{
            position:relative;
            z-index:2;
            max-width:610px;
            margin:13px 0 0;
            color:rgba(255,255,255,.72);
            font-size:13px;
            line-height:1.7;
        }

        .recovery-body{
            padding:38px 42px 42px;
        }

        .recovery-info{
            display:flex;
            gap:13px;
            margin-bottom:28px;
            padding:15px 17px;
            border:1px solid rgba(247,170,53,.25);
            border-radius:14px;
            background:#fffaf1;
            color:#72501c;
            font-size:12px;
            line-height:1.6;
        }

        .recovery-info-icon{
            flex:0 0 auto;
            width:25px;
            height:25px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:50%;
            background:#F7AA35;
            color:#241B52;
            font-size:12px;
            font-weight:900;
        }

        .error-box{
            margin-bottom:22px;
            padding:15px 17px;
            border:1px solid #fecaca;
            border-radius:13px;
            background:#fef2f2;
            color:#991b1b;
            font-size:12px;
            line-height:1.6;
        }

        .error-box ul{
            margin:0;
            padding-left:18px;
        }

        .flash-error{
            margin-bottom:22px;
            padding:14px 17px;
            border:1px solid #fecaca;
            border-radius:13px;
            background:#fef2f2;
            color:#991b1b;
            font-size:12px;
        }

        .form-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:19px;
        }

        .form-group{
            min-width:0;
        }

        .form-group.full{
            grid-column:1/-1;
        }

        .form-label{
            display:block;
            margin-bottom:8px;
            color:#241B52;
            font-size:11px;
            font-weight:750;
        }

        .required{
            color:#EF5843;
        }

        .form-control{
            width:100%;
            min-height:48px;
            padding:0 14px;
            border:1px solid #dde0e8;
            border-radius:12px;
            outline:none;
            background:#fff;
            color:#24242d;
            font-family:inherit;
            font-size:12px;
            transition:.2s ease;
        }

        textarea.form-control{
            min-height:115px;
            padding:13px 14px;
            resize:vertical;
            line-height:1.6;
        }

        .form-control:focus{
            border-color:#EF5843;
            box-shadow:0 0 0 4px rgba(239,88,67,.08);
        }

        .form-control[readonly]{
            background:#f6f7f9;
            color:#737580;
            cursor:not-allowed;
        }

        .field-help{
            display:block;
            margin-top:6px;
            color:#9899a2;
            font-size:9px;
            line-height:1.5;
        }

        .form-actions{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            margin-top:30px;
            padding-top:25px;
            border-top:1px solid #eeeeF2;
        }

        .back-link{
            display:inline-flex;
            align-items:center;
            gap:7px;
            color:#737580;
            font-size:11px;
            font-weight:650;
            text-decoration:none;
        }

        .back-link:hover{
            color:#241B52;
        }

        .submit-button{
            min-height:48px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            padding:0 22px;
            border:0;
            border-radius:12px;
            background:#EF5843;
            color:#fff;
            font-family:inherit;
            font-size:11px;
            font-weight:800;
            cursor:pointer;
            box-shadow:0 10px 25px rgba(239,88,67,.22);
            transition:.2s ease;
        }

        .submit-button:hover{
            background:#d94f3b;
            transform:translateY(-1px);
        }

        .security-note{
            margin-top:20px;
            text-align:center;
            color:#a0a1a9;
            font-size:9px;
            line-height:1.6;
        }

        @media(max-width:650px){
            body{
                padding:16px 12px;
            }

            .recovery-card{
                border-radius:21px;
            }

            .recovery-header{
                padding:30px 22px 27px;
            }

            .recovery-header h1{
                font-size:27px;
            }

            .recovery-body{
                padding:27px 22px 30px;
            }

            .form-grid{
                grid-template-columns:1fr;
            }

            .form-group.full{
                grid-column:auto;
            }

            .form-actions{
                flex-direction:column-reverse;
                align-items:stretch;
            }

            .submit-button{
                width:100%;
            }

            .back-link{
                justify-content:center;
            }
        }
    </style>
</head>

<body>
    <div class="recovery-wrapper">
        <div class="recovery-card">

            <header class="recovery-header">
                <div class="recovery-brand">
                    <span class="recovery-brand-dot"></span>
                    Baca Dulu Admin
                </div>

                <h1>Permohonan Akses Admin</h1>

                <p>
                    Isi identitas Anda dengan benar. Permohonan ini akan disimpan
                    sebagai bukti pengajuan akses dan harus mendapatkan persetujuan
                    sebelum Anda dapat membuat password akses baru.
                </p>
            </header>

            <main class="recovery-body">

                <div class="recovery-info">
                    <span class="recovery-info-icon">i</span>

                    <div>
                        Password utama akun admin tidak akan diubah melalui proses ini.
                        Setelah permohonan disetujui, Anda akan membuat password akses
                        tambahan milik Anda sendiri.
                    </div>
                </div>

                @if(session('error'))
                    <div class="flash-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="error-box">
                        <strong>Periksa kembali data berikut:</strong>

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('admin.recovery.store') }}"
                    method="POST"
                >
                    @csrf

                    <div class="form-grid">

                        <div class="form-group full">
                            <label class="form-label">
                                Akun Admin yang Diakses
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                value="{{ $adminEmail }}"
                                readonly
                            >

                            <span class="field-help">
                                Email ini ditentukan otomatis oleh sistem dan tidak dapat diubah.
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Nama Lengkap
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="requester_name"
                                class="form-control"
                                value="{{ old('requester_name') }}"
                                maxlength="100"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Jabatan / Posisi
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="requester_position"
                                class="form-control"
                                value="{{ old('requester_position') }}"
                                maxlength="100"
                                placeholder="Contoh: Admin Website"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Email Anda
                                <span class="required">*</span>
                            </label>

                            <input
                                type="email"
                                name="requester_email"
                                class="form-control"
                                value="{{ old('requester_email') }}"
                                maxlength="150"
                                autocomplete="email"
                                required
                            >

                            <span class="field-help">
                                Nanti akan digunakan untuk mengidentifikasi pemilik akses.
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Nomor WhatsApp
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="requester_phone"
                                class="form-control"
                                value="{{ old('requester_phone') }}"
                                maxlength="30"
                                placeholder="08xxxxxxxxxx"
                                autocomplete="tel"
                                required
                            >
                        </div>

                        <div class="form-group full">
                            <label class="form-label">
                                Alasan Meminta Akses
                                <span class="required">*</span>
                            </label>

                            <textarea
                                name="reason"
                                class="form-control"
                                maxlength="1000"
                                placeholder="Jelaskan alasan Anda mengajukan akses admin..."
                                required
                            >{{ old('reason') }}</textarea>
                        </div>

                        <div class="form-group full">
                            <label class="form-label">
                                Keterangan Tambahan
                            </label>

                            <textarea
                                name="notes"
                                class="form-control"
                                maxlength="1000"
                                placeholder="Opsional"
                            >{{ old('notes') }}</textarea>
                        </div>

                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('admin.login') }}"
                            class="back-link"
                        >
                            ← Kembali ke Login
                        </a>

                        <button
                            type="submit"
                            class="submit-button"
                        >
                            Kirim Permohonan
                            <span>→</span>
                        </button>
                    </div>
                </form>

                <div class="security-note">
                    Informasi perangkat, alamat IP, dan waktu permohonan akan
                    dicatat untuk keamanan dan pertanggungjawaban akses.
                </div>

            </main>
        </div>
    </div>
</body>
</html>