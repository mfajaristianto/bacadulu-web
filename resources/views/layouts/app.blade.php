<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >

    {{-- =====================================================
        CSRF TOKEN
    ====================================================== --}}

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    {{-- =====================================================
        TITLE
    ====================================================== --}}

    <title>
        @yield('title', 'Baca Dulu - Platform Penerbitan Modern')
    </title>


    {{-- =====================================================
        GOOGLE FONT
    ====================================================== --}}

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =====================================================
        VITE / TAILWIND
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- =====================================================
        BOOTSTRAP 5
        Dibutuhkan halaman:
        Informasi
        Artikel
        Konsultasi
        Jurnal
        Conference
        Publisher
        dan halaman lama lain yang menggunakan Bootstrap
    ====================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =====================================================
        ANIMATE.CSS
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    >


    {{-- =====================================================
        TRIX EDITOR
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://unpkg.com/trix@2.1.15/dist/trix.css"
    >

    <script
        src="https://unpkg.com/trix@2.1.15/dist/trix.umd.min.js"
        defer
    ></script>


    {{-- =====================================================
        CUSTOM STYLE PER PAGE
    ====================================================== --}}

    @stack('styles')


    {{-- =====================================================
        PENYESUAIAN BOOTSTRAP + TAILWIND
    ====================================================== --}}

    <style>

        /*
        |--------------------------------------------------------------------------
        | GLOBAL FONT
        |--------------------------------------------------------------------------
        */

        html,
        body {
            font-family: 'Inter', sans-serif;
        }


        /*
        |--------------------------------------------------------------------------
        | NAVBAR
        |--------------------------------------------------------------------------
        | Mencegah Bootstrap mengubah link navbar Tailwind.
        |--------------------------------------------------------------------------
        */

        #main-navbar a {
            text-decoration: none;
        }


        #main-navbar button {
            font-family: 'Inter', sans-serif;
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        img {
            max-width: 100%;
        }


        /*
        |--------------------------------------------------------------------------
        | LEGACY BOOTSTRAP PAGE
        |--------------------------------------------------------------------------
        */

        main .container {
            position: relative;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        .card {
            background-color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | TEXT
        |--------------------------------------------------------------------------
        */

        .text-dark {
            color: #212529 !important;
        }


        .text-muted {
            color: #6c757d !important;
        }


        /*
        |--------------------------------------------------------------------------
        | PRIMARY COLOR BACA DULU
        |--------------------------------------------------------------------------
        */

        .text-primary {
            color: #241B52 !important;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            main .container {
                max-width: 100%;
            }

        }

    </style>


</head>


<body
    class="
        min-h-full
        bg-slate-50
        text-slate-900
        flex
        flex-col
        m-0
        p-0
        font-sans
        antialiased
        selection:bg-orange-500
        selection:text-white
    "
>


    {{-- =====================================================
        NAVBAR
    ====================================================== --}}

    <x-navbar />


    {{-- =====================================================
        MAIN CONTENT
    ====================================================== --}}

    <main class="flex-grow w-full">


        {{-- =================================================
            SUCCESS MESSAGE
        ================================================== --}}

        @if(session('success'))

            <div
                class="
                    max-w-7xl
                    mx-auto
                    px-5
                    sm:px-6
                    lg:px-10
                    py-4
                "
            >

                <div
                    class="
                        rounded-xl
                        bg-green-50
                        border
                        border-green-200
                        p-4
                        text-sm
                        text-green-800
                    "
                >

                    {{ session('success') }}

                </div>

            </div>

        @endif


        {{-- =================================================
            PAGE CONTENT
        ================================================== --}}

        @yield('content')


    </main>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <x-footer />


    {{-- =====================================================
        BOOTSTRAP JAVASCRIPT
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>


    {{-- =====================================================
        SCRIPT PER PAGE
    ====================================================== --}}

    @stack('scripts')


</body>

</html>