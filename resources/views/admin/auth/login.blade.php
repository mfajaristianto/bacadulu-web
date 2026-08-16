<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin - Baca Dulu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- LOGO / BRAND --}}
        <div class="text-center mb-8">

            <div class="inline-flex items-center justify-center
                        w-16 h-16 rounded-2xl
                        bg-gradient-to-br from-orange-400 to-red-500
                        text-white text-xl font-bold shadow-lg">
                BD
            </div>

            <h1 class="mt-4 text-3xl font-bold text-slate-900">
                Baca Dulu
            </h1>

            <p class="mt-1 text-slate-500">
                Admin CMS
            </p>

        </div>


        {{-- LOGIN CARD --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

            <div class="mb-7">

                <h2 class="text-2xl font-bold text-slate-900">
                    Selamat datang kembali
                </h2>

                <p class="text-sm text-slate-500 mt-2">
                    Masuk menggunakan akun admin kamu.
                </p>

            </div>


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-5 rounded-xl bg-red-50 border border-red-200
                            px-4 py-3 text-sm text-red-700">

                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>

            @endif


            {{-- SUCCESS / ERROR SESSION --}}
            @if (session('error'))

                <div class="mb-5 rounded-xl bg-red-50 border border-red-200
                            px-4 py-3 text-sm text-red-700">

                    {{ session('error') }}

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.login') }}"
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
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="admin@example.com"

                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-300
                               focus:border-orange-500
                               focus:ring-2 focus:ring-orange-200
                               outline-none transition"
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
                        placeholder="Masukkan password"

                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-300
                               focus:border-orange-500
                               focus:ring-2 focus:ring-orange-200
                               outline-none transition"
                    >

                </div>


                {{-- REMEMBER --}}
                <div class="flex items-center justify-between">

                    <label class="flex items-center gap-2 cursor-pointer">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"

                            class="w-4 h-4 rounded
                                   border-slate-300
                                   text-orange-500
                                   focus:ring-orange-400"
                        >

                        <span class="text-sm text-slate-600">
                            Ingat saya
                        </span>

                    </label>

                </div>


                {{-- BUTTON --}}
                <button
                    type="submit"

                    class="w-full py-3.5 rounded-xl
                           bg-slate-900
                           hover:bg-slate-800
                           text-white font-semibold
                           transition duration-200
                           shadow-lg shadow-slate-900/10"
                >

                    Masuk ke Admin

                </button>

            </form>


            {{-- SECURITY INFO --}}
            <div class="mt-6 pt-5 border-t border-slate-100">

                <div class="flex gap-3">

                    <div class="flex-shrink-0
                                w-9 h-9 rounded-lg
                                bg-orange-50
                                flex items-center justify-center">

                        🔐

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Login aman
                        </p>

                        <p class="text-xs text-slate-500 mt-1">
                            Perangkat baru akan diminta melakukan
                            verifikasi tambahan melalui email.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <p class="text-center text-xs text-slate-400 mt-6">
            © {{ date('Y') }} Baca Dulu · Admin CMS
        </p>

    </div>

</body>
</html>