<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login — Baca Dulu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-6">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

            {{-- Logo --}}
            <div class="text-center mb-8">

                <div
                    class="mx-auto mb-4 w-14 h-14 rounded-2xl
                           bg-gradient-to-br from-orange-500 to-amber-400
                           flex items-center justify-center
                           text-white font-black text-xl shadow-lg"
                >
                    BD
                </div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Selamat Datang
                </h1>

                <p class="text-sm text-slate-500 mt-2">
                    Masuk untuk menulis artikel dan berkomentar.
                </p>

            </div>


            {{-- Error --}}
            @if(session('error'))

                <div class="mb-5 rounded-xl bg-red-50 border border-red-200
                            px-4 py-3 text-sm text-red-700">

                    {{ session('error') }}

                </div>

            @endif


            {{-- Google Login --}}
            <a
                href="{{ route('google.login') }}"
                class="w-full flex items-center justify-center gap-3
                       border border-slate-300
                       bg-white
                       hover:bg-slate-50
                       text-slate-800
                       font-semibold
                       rounded-xl
                       px-5 py-3.5
                       transition
                       shadow-sm"
            >

                {{-- Google Icon --}}
                <svg
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                >
                    <path
                        fill="#4285F4"
                        d="M21.35 12.23c0-.79-.07-1.55-.2-2.27H12v4.3h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.7 2.91-4.2 2.91-7.42z"
                    />

                    <path
                        fill="#34A853"
                        d="M12 21.75c2.63 0 4.84-.87 6.45-2.35l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.29v2.53A9.75 9.75 0 0 0 12 21.75z"
                    />

                    <path
                        fill="#FBBC05"
                        d="M6.54 13.84A5.86 5.86 0 0 1 6.23 12c0-.64.11-1.26.31-1.84V7.63H3.29A9.75 9.75 0 0 0 2.25 12c0 1.57.38 3.06 1.04 4.37l3.25-2.53z"
                    />

                    <path
                        fill="#EA4335"
                        d="M12 6.13c1.43 0 2.71.49 3.72 1.45l2.79-2.79C16.83 3.17 14.63 2.25 12 2.25a9.75 9.75 0 0 0-8.71 5.38l3.25 2.53C7.31 7.85 9.46 6.13 12 6.13z"
                    />
                </svg>

                Masuk dengan Google

            </a>


            <div class="flex items-center gap-4 my-7">

                <div class="h-px bg-slate-200 flex-1"></div>

                

                <div class="h-px bg-slate-200 flex-1"></div>

            </div>


            <p class="text-center text-xs text-slate-500 leading-relaxed">

                Dengan masuk, kamu dapat menulis artikel,
                melihat status tulisan, dan memberikan komentar
                pada artikel pengguna lain.

            </p>

        </div>


        <div class="text-center mt-6">

            <a
                href="{{ route('home') }}"
                class="text-sm text-slate-500 hover:text-orange-600 transition"
            >
                ← Kembali ke halaman utama
            </a>

        </div>

    </div>

</body>

</html>