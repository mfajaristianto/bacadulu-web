<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi OTP - Baca Dulu</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- BRAND --}}
        <div class="text-center mb-8">

            <div class="inline-flex items-center justify-center
                        w-16 h-16 rounded-2xl
                        bg-gradient-to-br from-orange-400 to-red-500
                        text-white text-xl font-bold shadow-lg">
                BD
            </div>

            <h1 class="mt-4 text-2xl font-bold text-slate-900">
                Verifikasi Perangkat
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kami mendeteksi login dari perangkat baru.
            </p>

        </div>


        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

            {{-- ICON --}}
            <div class="flex justify-center mb-5">

                <div class="w-16 h-16 rounded-full bg-orange-50
                            flex items-center justify-center text-3xl">
                    🔐
                </div>

            </div>


            <h2 class="text-xl font-bold text-center text-slate-900">
                Masukkan kode OTP
            </h2>

            <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                Kode verifikasi 6 digit telah dikirim ke
                email admin yang terdaftar.
            </p>


            {{-- ERROR --}}
            @if (session('error'))

                <div class="mt-5 rounded-xl bg-red-50 border border-red-200
                            px-4 py-3 text-sm text-red-700 text-center">

                    {{ session('error') }}

                </div>

            @endif


            @if ($errors->any())

                <div class="mt-5 rounded-xl bg-red-50 border border-red-200
                            px-4 py-3 text-sm text-red-700">

                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.otp.submit') }}"
                class="mt-6"
            >

                @csrf


                <label
                    for="otp"
                    class="block text-sm font-semibold text-slate-700 mb-2 text-center"
                >
                    Kode OTP
                </label>

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

                    class="w-full text-center text-3xl
                           tracking-[0.5em]
                           font-bold
                           py-4 rounded-xl
                           border border-slate-300
                           focus:border-orange-500
                           focus:ring-2 focus:ring-orange-200
                           outline-none"

                    placeholder="••••••"
                >


                <button
                    type="submit"

                    class="w-full mt-5 py-3.5
                           rounded-xl
                           bg-slate-900
                           hover:bg-slate-800
                           text-white font-semibold
                           transition"
                >
                    Verifikasi OTP
                </button>

            </form>


            <div class="mt-6 p-4 rounded-xl bg-slate-50">

                <p class="text-xs text-slate-500 text-center leading-relaxed">
                    Kode OTP berlaku selama
                    <strong class="text-slate-700">
                        5 menit
                    </strong>.
                    Jangan berikan kode ini kepada orang lain.
                </p>

            </div>


            <div class="mt-5 text-center">

                <a
                    href="{{ route('admin.login') }}"
                    class="text-sm text-slate-500 hover:text-slate-900"
                >
                    ← Kembali ke login
                </a>

            </div>

        </div>

    </div>

</body>
</html>