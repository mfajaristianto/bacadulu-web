<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Password Akses - Baca Dulu</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

            <div class="text-center mb-7">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-orange-500 flex items-center justify-center text-white font-bold text-xl">
                    BD
                </div>

                <h1 class="mt-4 text-2xl font-bold text-slate-900">
                    Buat Password Akses
                </h1>

                <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                    Permohonan Anda telah disetujui. Buat password pribadi yang akan digunakan untuk mengakses Admin Baca Dulu.
                </p>
            </div>

            <div class="mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-xs text-slate-500">
                    Pemilik Akses
                </div>

                <div class="font-semibold text-slate-900 mt-1">
                    {{ $recovery->requester_name }}
                </div>

                <div class="text-sm text-slate-500 mt-1">
                    {{ $recovery->requester_email }}
                </div>
            </div>

            @if(session('error'))
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ $storeUrl }}" class="space-y-5" id="passwordForm">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Password Baru
                    </label>

                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none"
                            placeholder="Masukkan password baru"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-700 transition"
                            aria-label="Tampilkan password"
                        >
                            <svg id="eyePassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>

                            <svg id="eyeOffPassword" class="hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>

                    <p class="text-xs text-slate-500 mt-2">
                        Minimal 10 karakter, terdapat huruf besar, huruf kecil, dan angka.
                    </p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                        Konfirmasi Password
                    </label>

                    <div class="relative">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none"
                            placeholder="Ulangi password baru"
                        >

                        <button
                            type="button"
                            id="toggleConfirmation"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-700 transition"
                            aria-label="Tampilkan konfirmasi password"
                        >
                            <svg id="eyeConfirmation" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>

                            <svg id="eyeOffConfirmation" class="hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 active:scale-[0.98] text-white font-semibold transition"
                >
                    Simpan Password Akses
                </button>
            </form>

            <div class="mt-6 p-4 rounded-xl bg-orange-50 border border-orange-100">
                <p class="text-xs text-orange-800 leading-relaxed">
                    Password ini hanya menambahkan akses baru untuk Anda. Password utama admin dan password akses milik orang lain tidak akan berubah.
                </p>
            </div>

        </div>
    </div>

    <script>
        function setupPasswordToggle(inputId, buttonId, eyeId, eyeOffId) {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const eye = document.getElementById(eyeId);
            const eyeOff = document.getElementById(eyeOffId);

            if (!input || !button) return;

            button.addEventListener('click', function () {
                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';
                eye.classList.toggle('hidden', isPassword);
                eyeOff.classList.toggle('hidden', !isPassword);

                button.setAttribute(
                    'aria-label',
                    isPassword ? 'Sembunyikan password' : 'Tampilkan password'
                );
            });
        }

        setupPasswordToggle(
            'password',
            'togglePassword',
            'eyePassword',
            'eyeOffPassword'
        );

        setupPasswordToggle(
            'password_confirmation',
            'toggleConfirmation',
            'eyeConfirmation',
            'eyeOffConfirmation'
        );
    </script>

</body>
</html>