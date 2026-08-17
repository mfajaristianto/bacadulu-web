<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Konfirmasi Admin - Baca Dulu</title>

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
            background: linear-gradient(135deg, #34d399, #10b981);
        }

        .blob-2 {
            width: 420px;
            height: 420px;
            bottom: -150px;
            right: -120px;
            background: linear-gradient(135deg, #6ee7b7, #059669);
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
        .entrance-delay-2 { animation-delay: 0.2s; }

        @keyframes checkPulse {
            0%, 100% { box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 10px 35px -3px rgba(16, 185, 129, 0.65); }
        }

        .check-pulse {
            animation: checkPulse 2.5s ease-in-out infinite;
        }

        @keyframes checkDraw {
            from { stroke-dashoffset: 24; }
            to { stroke-dashoffset: 0; }
        }

        .check-icon path {
            stroke-dasharray: 24;
            stroke-dashoffset: 24;
            animation: checkDraw 0.6s ease 0.3s forwards;
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

        .input-field {
            transition: all 0.25s ease;
        }

        .input-field:focus {
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

        .confirm-card {
            transition: box-shadow 0.3s ease;
        }

        .confirm-card:hover {
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.18);
        }

        .trust-badge {
            transition: transform 0.3s ease;
        }

        .trust-badge:hover {
            transform: scale(1.08) rotate(-4deg);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 relative overflow-hidden">

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="w-full max-w-md relative z-10">

        <div class="text-center mb-8 entrance">
            <div class="check-pulse inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-600 text-white shadow-lg transition-transform duration-300 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="check-icon w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>

            <h1 class="mt-4 text-2xl font-bold text-slate-900">OTP Berhasil Diverifikasi</h1>
            <p class="mt-2 text-sm text-slate-500">Satu langkah lagi untuk masuk ke Admin CMS.</p>
        </div>

        <div class="confirm-card bg-white rounded-2xl shadow-xl border border-slate-200 p-8 entrance entrance-delay-1 {{ session('error') ? 'shake-error' : '' }}">

            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900">Konfirmasi identitas</h2>
                <p class="text-sm text-slate-500 mt-2">
                    Masukkan kembali email dan password admin untuk menyelesaikan proses login.
                </p>
            </div>

            @if (session('error'))
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.confirm.submit') }}" class="space-y-5" id="confirmForm">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Admin</label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </span>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            required
                            autocomplete="email"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none"
                        >
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </span>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="input-field w-full pl-11 pr-11 py-3 rounded-xl border border-slate-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none"
                        >

                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 transition">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eyeOffIcon" class="hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="w-full py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 active:scale-[0.98] text-white font-semibold transition-all duration-200 shadow-lg shadow-slate-900/10 hover:shadow-xl hover:shadow-emerald-500/20 flex items-center justify-center gap-2">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Konfirmasi & Masuk</span>
                </button>
            </form>

            <div class="mt-6 p-4 rounded-xl bg-green-50 border border-green-100 entrance entrance-delay-2">
                <div class="flex gap-3">
                    <div class="trust-badge flex-shrink-0 w-9 h-9 rounded-lg bg-white flex items-center justify-center text-emerald-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <p class="text-xs text-green-800 leading-relaxed">
                        Setelah berhasil masuk, perangkat ini akan
                        <strong>dipercaya selama 1 tahun</strong>.
                        Login berikutnya dari perangkat ini tidak memerlukan OTP lagi.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', isPassword);
            eyeOffIcon.classList.toggle('hidden', !isPassword);
        });

        const confirmForm = document.getElementById('confirmForm');
        const submitBtn = document.getElementById('submitBtn');
        confirmForm.addEventListener('submit', function () {
            submitBtn.classList.add('btn-submitting');
            submitBtn.disabled = true;
        });
    </script>

</body>
</html>