<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin - Baca Dulu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            min-height: 100%;
            scroll-behavior: smooth;
        }

        body {
            min-height: 100%;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;

            /*
            |--------------------------------------------------------------------------
            | PENTING
            |--------------------------------------------------------------------------
            | Jangan pakai overflow:hidden karena halaman tidak bisa discroll.
            */
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* =========================================================
           BACKGROUND BLOBS
        ========================================================== */

        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.35;
            z-index: 0;
            pointer-events: none;
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

        .blob-3 {
            width: 260px;
            height: 260px;
            top: 40%;
            right: 8%;
            background: linear-gradient(135deg, #fca5a5, #f97316);
            animation-delay: 4s;
        }

        @keyframes float {
            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(20px, -25px) scale(1.05);
            }
        }

        /* =========================================================
           ENTRANCE
        ========================================================== */

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .entrance {
            animation: fadeSlideUp 0.7s ease both;
        }

        .entrance-delay-1 {
            animation-delay: 0.1s;
        }

        .entrance-delay-2 {
            animation-delay: 0.2s;
        }

        .entrance-delay-3 {
            animation-delay: 0.3s;
        }

        /* =========================================================
           LOGO
        ========================================================== */

        @keyframes logoPulse {
            0%,
            100% {
                box-shadow:
                    0 10px 28px -8px
                    rgba(249, 115, 22, 0.30);
            }

            50% {
                box-shadow:
                    0 13px 35px -8px
                    rgba(249, 115, 22, 0.50);
            }
        }

        .logo-pulse {
            animation: logoPulse 2.5s ease-in-out infinite;
        }

        .brand-logo {
            width: 92px;
            height: 92px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto;
            padding: 8px;

            overflow: hidden;

            border: 1px solid rgba(249, 115, 22, 0.14);
            border-radius: 24px;

            background: #ffffff;

            transition: transform 0.3s ease;
        }

        .brand-logo:hover {
            transform: translateY(-2px) scale(1.04);
        }

        .brand-logo img {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: contain;
            object-position: center;

            border-radius: 16px;
        }

        /* =========================================================
           SHAKE ERROR
        ========================================================== */

        @keyframes shake {
            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-8px);
            }

            40% {
                transform: translateX(8px);
            }

            60% {
                transform: translateX(-6px);
            }

            80% {
                transform: translateX(6px);
            }
        }

        .shake-error {
            animation: shake 0.5s ease;
        }

        /* =========================================================
           INPUT
        ========================================================== */

        .input-field {
            transition: all 0.25s ease;
        }

        .input-field:focus {
            transform: translateY(-1px);
        }

        /* =========================================================
           BUTTON LOADING
        ========================================================== */

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
            to {
                transform: rotate(360deg);
            }
        }

        .btn-submitting .btn-spinner {
            display: inline-block;
        }

        .btn-submitting .btn-text {
            opacity: 0.7;
        }

        /* =========================================================
           LOGIN CARD
        ========================================================== */

        .login-card {
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .login-card:hover {
            box-shadow:
                0 25px 50px -12px
                rgba(15, 23, 42, 0.18);
        }

        /* =========================================================
           PASSWORD ICON
        ========================================================== */

        #eyeIcon,
        #eyeOffIcon {
            transition: opacity 0.15s ease;
        }

        /* =========================================================
           RESPONSIVE HEIGHT
        ========================================================== */

        @media (max-height: 800px) {
            .login-page-wrapper {
                align-items: flex-start;
            }

            .brand-logo {
                width: 76px;
                height: 76px;
                border-radius: 20px;
            }

            .login-brand {
                margin-bottom: 20px;
            }
        }

        @media (max-height: 650px) {
            .login-page-wrapper {
                padding-top: 24px;
                padding-bottom: 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .blob,
            .entrance,
            .logo-pulse,
            .shake-error {
                animation: none !important;
            }
        }
    </style>
</head>


<body class="bg-slate-100">

    {{-- =========================================================
         BACKGROUND
    ========================================================== --}}

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>


    {{-- =========================================================
         PAGE WRAPPER
    ========================================================== --}}

    <main
        class="
            login-page-wrapper
            relative
            z-10
            min-h-screen
            w-full
            flex
            items-center
            justify-center
            px-4
            py-8
            md:py-10
        "
    >

        <div class="w-full max-w-md">

            {{-- =====================================================
                 LOGO / BRAND
            ====================================================== --}}

            <div class="login-brand text-center mb-8 entrance">

                <div class="brand-logo logo-pulse">

                    <img
                        src="{{ asset('img/bacadulu-logo.jpg') }}"
                        alt="Logo Baca Dulu"
                    >

                </div>


                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    Baca Dulu
                </h1>


                <p class="mt-1 text-slate-500">
                    Admin CMS
                </p>

            </div>


            {{-- =====================================================
                 LOGIN CARD
            ====================================================== --}}

            <div
                class="
                    login-card
                    bg-white
                    rounded-2xl
                    shadow-xl
                    border
                    border-slate-200
                    p-8
                    entrance
                    entrance-delay-1
                    {{ $errors->any() || session('error') ? 'shake-error' : '' }}
                "
            >

                {{-- =================================================
                     HEADER
                ================================================== --}}

                <div class="mb-7">

                    <h2 class="text-2xl font-bold text-slate-900">
                        Selamat datang kembali
                    </h2>


                    <p class="text-sm text-slate-500 mt-2">
                        Masuk menggunakan akun admin kamu.
                    </p>

                </div>


                {{-- =================================================
                     VALIDATION ERROR
                ================================================== --}}

                @if($errors->any())

                    <div
                        class="
                            mb-5
                            rounded-xl
                            bg-red-50
                            border
                            border-red-200
                            px-4
                            py-3
                            text-sm
                            text-red-700
                            flex
                            items-start
                            gap-2
                        "
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 flex-shrink-0 mt-0.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                            />
                        </svg>


                        <div>

                            @foreach($errors->all() as $error)

                                <p>
                                    {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- =================================================
                     SESSION ERROR
                ================================================== --}}

                @if(session('error'))

                    <div
                        class="
                            mb-5
                            rounded-xl
                            bg-red-50
                            border
                            border-red-200
                            px-4
                            py-3
                            text-sm
                            text-red-700
                            flex
                            items-start
                            gap-2
                        "
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 flex-shrink-0 mt-0.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                            />
                        </svg>


                        <span>
                            {{ session('error') }}
                        </span>

                    </div>

                @endif


                {{-- =================================================
                     FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('admin.login') }}"
                    class="space-y-5"
                    id="loginForm"
                >

                    @csrf


                    {{-- =================================================
                         EMAIL
                    ================================================== --}}

                    <div>

                        <label
                            for="email"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Email Admin
                        </label>


                        <div class="relative">

                            <span
                                class="
                                    absolute
                                    inset-y-0
                                    left-0
                                    flex
                                    items-center
                                    pl-4
                                    text-slate-400
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                                    />
                                </svg>

                            </span>


                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="admin@example.com"

                                class="
                                    input-field
                                    w-full
                                    pl-11
                                    pr-4
                                    py-3
                                    rounded-xl
                                    border
                                    border-slate-300
                                    focus:border-orange-500
                                    focus:ring-2
                                    focus:ring-orange-200
                                    outline-none
                                "
                            >

                        </div>

                    </div>


                    {{-- =================================================
                         PASSWORD
                    ================================================== --}}

                    <div>

                        <label
                            for="password"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Password
                        </label>


                        <div class="relative">

                            <span
                                class="
                                    absolute
                                    inset-y-0
                                    left-0
                                    flex
                                    items-center
                                    pl-4
                                    text-slate-400
                                "
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                                    />
                                </svg>

                            </span>


                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"

                                class="
                                    input-field
                                    w-full
                                    pl-11
                                    pr-11
                                    py-3
                                    rounded-xl
                                    border
                                    border-slate-300
                                    focus:border-orange-500
                                    focus:ring-2
                                    focus:ring-orange-200
                                    outline-none
                                "
                            >


                            <button
                                type="button"
                                id="togglePassword"
                                class="
                                    absolute
                                    inset-y-0
                                    right-0
                                    flex
                                    items-center
                                    pr-4
                                    text-slate-400
                                    hover:text-slate-600
                                    transition
                                "
                            >

                                <svg
                                    id="eyeIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>


                                <svg
                                    id="eyeOffIcon"
                                    class="hidden w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                                    />
                                </svg>

                            </button>

                        </div>

                    </div>


                    {{-- =================================================
                         REMEMBER
                    ================================================== --}}

                    <div class="flex items-center justify-between">

                        <label
                            class="
                                flex
                                items-center
                                gap-2
                                cursor-pointer
                                group
                            "
                        >

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"

                                class="
                                    w-4
                                    h-4
                                    rounded
                                    border-slate-300
                                    text-orange-500
                                    focus:ring-orange-400
                                    transition-transform
                                    group-hover:scale-110
                                "
                            >


                            <span
                                class="
                                    text-sm
                                    text-slate-600
                                    group-hover:text-slate-900
                                    transition
                                "
                            >
                                Ingat saya
                            </span>

                        </label>

                    </div>


                    {{-- =================================================
                         BUTTON
                    ================================================== --}}

                    <button
                        type="submit"
                        id="submitBtn"

                        class="
                            w-full
                            py-3.5
                            rounded-xl
                            bg-slate-900
                            hover:bg-slate-800
                            active:scale-[0.98]
                            text-white
                            font-semibold
                            transition-all
                            duration-200
                            shadow-lg
                            shadow-slate-900/10
                            hover:shadow-xl
                            hover:shadow-orange-500/20
                            flex
                            items-center
                            justify-center
                            gap-2
                        "
                    >

                        <span class="btn-spinner"></span>

                        <span class="btn-text">
                            Masuk ke Admin
                        </span>

                    </button>

                </form>


                {{-- =================================================
                     SECURITY
                ================================================== --}}

                <div
                    class="
                        mt-6
                        pt-5
                        border-t
                        border-slate-100
                        entrance
                        entrance-delay-2
                    "
                >

                    <div class="flex gap-3">

                        <div
                            class="
                                flex-shrink-0
                                w-9
                                h-9
                                rounded-lg
                                bg-orange-50
                                flex
                                items-center
                                justify-center
                                text-orange-500
                                transition-transform
                                duration-300
                                hover:scale-110
                                hover:rotate-6
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"
                                />
                            </svg>

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


            {{-- =====================================================
                 FOOTER
            ====================================================== --}}

            <p
                class="
                    text-center
                    text-xs
                    text-slate-400
                    mt-6
                    entrance
                    entrance-delay-3
                "
            >
                © {{ date('Y') }} Baca Dulu · Admin CMS
            </p>

        </div>

    </main>


    {{-- =========================================================
         SCRIPT
    ========================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | SHOW / HIDE PASSWORD
        |--------------------------------------------------------------------------
        */

        const togglePassword =
            document.getElementById('togglePassword');

        const passwordField =
            document.getElementById('password');

        const eyeIcon =
            document.getElementById('eyeIcon');

        const eyeOffIcon =
            document.getElementById('eyeOffIcon');


        if (
            togglePassword &&
            passwordField
        ) {

            togglePassword.addEventListener(
                'click',
                function () {

                    const isPassword =
                        passwordField.type === 'password';


                    passwordField.type =
                        isPassword
                            ? 'text'
                            : 'password';


                    if (eyeIcon) {

                        eyeIcon.classList.toggle(
                            'hidden',
                            isPassword
                        );

                    }


                    if (eyeOffIcon) {

                        eyeOffIcon.classList.toggle(
                            'hidden',
                            !isPassword
                        );

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | LOADING LOGIN
        |--------------------------------------------------------------------------
        */

        const loginForm =
            document.getElementById('loginForm');

        const submitBtn =
            document.getElementById('submitBtn');


        if (
            loginForm &&
            submitBtn
        ) {

            loginForm.addEventListener(
                'submit',
                function () {

                    submitBtn
                        .classList
                        .add('btn-submitting');


                    submitBtn.disabled = true;

                }
            );

        }

    </script>

</body>

</html>