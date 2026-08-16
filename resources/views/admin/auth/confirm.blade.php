<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Konfirmasi Admin - Baca Dulu</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">

            <div class="inline-flex items-center justify-center
                        w-16 h-16 rounded-2xl
                        bg-gradient-to-br from-green-400 to-emerald-600
                        text-white text-2xl shadow-lg">
                ✓
            </div>

            <h1 class="mt-4 text-2xl font-bold text-slate-900">
                OTP Berhasil Diverifikasi
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Satu langkah lagi untuk masuk ke Admin CMS.
            </p>

        </div>


        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-slate-900">
                    Konfirmasi identitas
                </h2>

                <p class="text-sm text-slate-500 mt-2">
                    Masukkan kembali email dan password admin
                    untuk menyelesaikan proses login.
                </p>

            </div>


            @if (session('error'))

                <div class="mb-5 rounded-xl bg-red-50 border border-red-200
                            px-4 py-3 text-sm text-red-700">

                    {{ session('error') }}

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.confirm.submit') }}"
                class="space-y-5"
            >

                @csrf


                {{-- EMAIL --}}
                <div>

                    <label
                        for="email"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Email Admin
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autocomplete="email"

                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-300
                               focus:border-green-500
                               focus:ring-2 focus:ring-green-200
                               outline-none"
                    >

                </div>


                {{-- PASSWORD --}}
                <div>

                    <label
                        for="password"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"

                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-300
                               focus:border-green-500
                               focus:ring-2 focus:ring-green-200
                               outline-none"
                    >

                </div>


                <button
                    type="submit"

                    class="w-full py-3.5
                           rounded-xl
                           bg-slate-900
                           hover:bg-slate-800
                           text-white font-semibold
                           transition"
                >
                    Konfirmasi & Masuk
                </button>

            </form>


            <div class="mt-6 p-4 rounded-xl bg-green-50 border border-green-100">

                <div class="flex gap-3">

                    <div class="text-lg">
                        🛡️
                    </div>

                    <p class="text-xs text-green-800 leading-relaxed">
                        Setelah berhasil masuk, perangkat ini akan
                        <strong>dipercaya selama 1 tahun</strong>.
                        Login berikutnya dari perangkat ini tidak
                        memerlukan OTP lagi.
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>
</html>