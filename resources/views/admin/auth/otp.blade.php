<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi OTP - Baca Dulu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.35;
            z-index: 0;
            animation: float 8s ease-in-out infinite;
        }

        .blob-1 {
            width: 380px;
            height: 380px;
            top: -120px;
            left: -100px;
            background: linear-gradient(135deg, #fb923c, #ef4444);
        }

        .blob-2 {
            width: 420px;
            height: 420px;
            bottom: -150px;
            right: -120px;
            background: linear-gradient(135deg, #f97316, #fbbf24);
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -25px) scale(1.05); }
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .entrance {
            animation: fadeSlideUp 0.7s ease both;
        }

        .entrance-delay-1 { animation-delay: 0.1s; }

        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4); }
            50% { box-shadow: 0 10px 35px -3px rgba(249, 115, 22, 0.65); }
        }

        .logo-pulse {
            animation: logoPulse 2.5s ease-in-out infinite;
        }

        @keyframes ringPulse {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.35); }
            70% { box-shadow: 0 0 0 12px rgba(249, 115, 22, 0); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }

        .icon-ring {
            animation: ringPulse 2s infinite;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-6px); }
            80% { transform: translateX(6px); }
        }

        .shake-error {
            animation: shake 0.5s ease;
        }

        #otp {
            transition: all 0.25s ease;
            letter-spacing: 0.5em;
        }

        #otp:focus {
            transform: translateY(-1px);
        }

        .btn-spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(255,255,255,0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-submitting .btn-spinner {
            display: inline-block;
        }

        .btn-submitting .btn-text {
            opacity: 0.7;
        }

        .otp-card {
            transition: box-shadow 0.3s ease;
        }

        .otp-card:hover {
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.18);
        }

        .countdown-track {
            height: 4px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .countdown-bar {
            height: 100%;
            background: linear-gradient(90deg, #f97316, #ef4444);
            width: 100%;
            transform-origin: left;
            animation: countdown 300s linear forwards;
        }

        @keyframes countdown {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 relative overflow-hidden">

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="w-full max-w-md relative z-10">

        <div class="text-center mb-8 entrance">
            <div class="logo-pulse inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-red-500 text-white text-xl font-bold shadow-lg transition-transform duration-300 hover:scale-110 hover:rotate-3">
                BD
            </div>
            <h1 class="mt-4 text-2xl font-bold text-slate-900">Verifikasi Perangkat</h1>
            <p class="mt-2 text-sm text-slate-500">Kami mendeteksi login dari perangkat baru.</p>
        </div>

        <div class="otp-card bg-white rounded-2xl shadow-xl border border-slate-200 p-8 entrance entrance-delay-1 {{ session('error') || $errors->any() ? 'shake-error' : '' }}">

            <div class="flex justify-center mb-5">
                <div class="icon-ring w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-bold text-center text-slate-900">Masukkan kode OTP</h2>
            <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                Kode verifikasi 6 digit telah dikirim ke email admin yang terdaftar.
            </p>

            @if (session('error'))
                <div class="mt-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 flex items-start gap-2 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.otp.submit') }}" class="mt-6" id="otpForm">
                @csrf

                <label for="otp" class="block text-sm font-semibold text-slate-700 mb-2 text-center">Kode OTP</label>

                <input
                    id="otp"
                    type="text"
                    name="otp"
                    inputmode="numeric"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    required
                    autofocus
                    autocomplete="one-time-code"
                    class="w-full text-center text-3xl font-bold py-4 rounded-xl border border-slate-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none"
                    placeholder="••••••"
                >

                <button type="submit" id="submitBtn" class="w-full mt-5 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 active:scale-[0.98] text-white font-semibold transition-all duration-200 shadow-lg shadow-slate-900/10 hover:shadow-xl hover:shadow-orange-500/20 flex items-center justify-center gap-2">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Verifikasi OTP</span>
                </button>
            </form>

            <div class="mt-6 p-4 rounded-xl bg-slate-50">
                <p class="text-xs text-slate-500 text-center leading-relaxed mb-2">
                    Kode OTP berlaku selama <strong class="text-slate-700">5 menit</strong>. Jangan berikan kode ini kepada orang lain.
                </p>
                <div class="countdown-track">
                    <div class="countdown-bar"></div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-900 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Kembali ke login
                </a>
            </div>

        </div>
    </div>

    <script>
        const otpInput = document.getElementById('otp');
        otpInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        const otpForm = document.getElementById('otpForm');
        const submitBtn = document.getElementById('submitBtn');
        otpForm.addEventListener('submit', function () {
            submitBtn.classList.add('btn-submitting');
            submitBtn.disabled = true;
        });
    </script>

</body>
</html>