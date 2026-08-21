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
        CEK HALAMAN YANG MEMBUTUHKAN BOOTSTRAP

        Bootstrap HANYA digunakan di halaman katalog lama,
        sehingga tidak mengubah tampilan Bookstore, Blog,
        Navbar, Home, HAKI, dll.
    ====================================================== --}}

    @php

        $useBootstrap = request()->routeIs(

            'informasi*',

            'articles*',

            'konsultasi*',

            'jurnal*',

            'conference*',

            'publisher*'

        );

    @endphp


    {{-- =====================================================
        BOOTSTRAP KHUSUS KATALOG BACA
    ====================================================== --}}

    @if($useBootstrap)

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        >

    @endif


    {{-- =====================================================
        VITE / TAILWIND
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- =====================================================
        WARNA KHUSUS BACA DULU
        Override Bootstrap agar tidak biru
    ====================================================== --}}

    @if($useBootstrap)

        <style>

            /*
            |--------------------------------------------------------------------------
            | BOOTSTRAP BRAND COLOR OVERRIDE
            |--------------------------------------------------------------------------
            */

            :root {

                --bs-primary: #241B52;

                --bs-primary-rgb:
                    36, 27, 82;

                --bs-link-color:
                    #241B52;

                --bs-link-color-rgb:
                    36, 27, 82;

                --bs-link-hover-color:
                    #EF5843;

                --bs-link-hover-color-rgb:
                    239, 88, 67;

            }


            /*
            |--------------------------------------------------------------------------
            | TEXT PRIMARY
            |--------------------------------------------------------------------------
            */

            .text-primary {

                color:
                    #EF5843
                    !important;

            }


            /*
            |--------------------------------------------------------------------------
            | BACKGROUND PRIMARY
            |--------------------------------------------------------------------------
            */

            .bg-primary {

                background-color:
                    #241B52
                    !important;

            }


            /*
            |--------------------------------------------------------------------------
            | BORDER PRIMARY
            |--------------------------------------------------------------------------
            */

            .border-primary {

                border-color:
                    #241B52
                    !important;

            }


            /*
            |--------------------------------------------------------------------------
            | BUTTON PRIMARY
            |--------------------------------------------------------------------------
            */

            .btn-primary {

                --bs-btn-color:
                    #ffffff;

                --bs-btn-bg:
                    #EF5843;

                --bs-btn-border-color:
                    #EF5843;

                --bs-btn-hover-color:
                    #ffffff;

                --bs-btn-hover-bg:
                    #D94F38;

                --bs-btn-hover-border-color:
                    #D94F38;

                --bs-btn-active-color:
                    #ffffff;

                --bs-btn-active-bg:
                    #C6432F;

                --bs-btn-active-border-color:
                    #C6432F;

                background-color:
                    #EF5843
                    !important;

                border-color:
                    #EF5843
                    !important;

                color:
                    #ffffff
                    !important;

            }


            .btn-primary:hover,
            .btn-primary:focus {

                background-color:
                    #D94F38
                    !important;

                border-color:
                    #D94F38
                    !important;

                color:
                    #ffffff
                    !important;

            }


            /*
            |--------------------------------------------------------------------------
            | OUTLINE PRIMARY
            |--------------------------------------------------------------------------
            */

            .btn-outline-primary {

                color:
                    #241B52
                    !important;

                border-color:
                    #241B52
                    !important;

            }


            .btn-outline-primary:hover {

                background-color:
                    #241B52
                    !important;

                border-color:
                    #241B52
                    !important;

                color:
                    #ffffff
                    !important;

            }


            /*
            |--------------------------------------------------------------------------
            | BADGE PRIMARY
            |--------------------------------------------------------------------------
            */

            .badge.bg-primary {

                background-color:
                    #241B52
                    !important;

                color:
                    #ffffff
                    !important;

            }


            /*
            |--------------------------------------------------------------------------
            | LINK
            |--------------------------------------------------------------------------
            */

            main a:not(.btn):not(.information-button) {

                --bs-link-color-rgb:
                    36, 27, 82;

            }


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            .pagination {

                display:
                    flex;

                align-items:
                    center;

                justify-content:
                    center;

                flex-wrap:
                    wrap;

                gap:
                    7px;

                margin:
                    0;

                padding:
                    0;

            }


            .pagination .page-item {

                margin:
                    0;

            }


            .pagination .page-link {

                display:
                    flex;

                align-items:
                    center;

                justify-content:
                    center;

                min-width:
                    40px;

                height:
                    40px;

                padding:
                    0 12px;

                border:
                    1px solid #E5E7EB;

                border-radius:
                    10px
                    !important;

                background:
                    #FFFFFF;

                color:
                    #241B52;

                font-size:
                    13px;

                font-weight:
                    600;

                text-decoration:
                    none;

                box-shadow:
                    none
                    !important;

                transition:
                    all
                    0.2s
                    ease;

            }


            .pagination .page-link:hover {

                background:
                    #FFF5F2;

                border-color:
                    #EF5843;

                color:
                    #EF5843;

            }


            .pagination
            .page-item.active
            .page-link {

                background:
                    #241B52;

                border-color:
                    #241B52;

                color:
                    #FFFFFF;

            }


            .pagination
            .page-item.disabled
            .page-link {

                background:
                    #F8FAFC;

                border-color:
                    #E5E7EB;

                color:
                    #9CA3AF;

            }


            /*
            |--------------------------------------------------------------------------
            | FORM FOCUS
            |--------------------------------------------------------------------------
            */

            .form-control:focus,
            .form-select:focus {

                border-color:
                    #EF5843;

                box-shadow:
                    0 0 0 0.2rem
                    rgba(
                        239,
                        88,
                        67,
                        0.15
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | NAVBAR PROTECTION
            |--------------------------------------------------------------------------
            | Bootstrap tidak boleh mengubah navbar Tailwind.
            |--------------------------------------------------------------------------
            */

            #main-navbar {

                font-family:
                    'Inter',
                    sans-serif;

            }


            #main-navbar a {

                text-decoration:
                    none;

            }


            #main-navbar button {

                font-family:
                    'Inter',
                    sans-serif;

            }


            /*
            |--------------------------------------------------------------------------
            | CARD
            |--------------------------------------------------------------------------
            */

            .card {

                background-color:
                    #FFFFFF;

            }


            /*
            |--------------------------------------------------------------------------
            | TEXT COLORS
            |--------------------------------------------------------------------------
            */

            .text-dark {

                color:
                    #241B52
                    !important;

            }


            .text-muted {

                color:
                    #6B7280
                    !important;

            }

        </style>

    @endif


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
        STYLE PER HALAMAN
    ====================================================== --}}

    @stack('styles')


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
            CONTENT
        ================================================== --}}

        @yield('content')


    </main>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <x-footer />


    {{-- =====================================================
        BOOTSTRAP JAVASCRIPT
        HANYA HALAMAN YANG MEMBUTUHKAN
    ====================================================== --}}

    @if($useBootstrap)

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        ></script>

    @endif


    {{-- =====================================================
        SCRIPT PER HALAMAN
    ====================================================== --}}

    @stack('scripts')


</body>

</html>