<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Baca Dulu - Platform Penerbitan Modern')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    @php
        $useBootstrap=request()->routeIs(
            'informasi*',
            'articles*',
            'konsultasi*',
            'jurnal*',
            'conference*',
            'publisher*'
        );
    @endphp

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

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @if($useBootstrap)
        <style>
            :root{
                --bs-primary:#241B52;
                --bs-primary-rgb:36,27,82;
                --bs-link-color:#241B52;
                --bs-link-color-rgb:36,27,82;
                --bs-link-hover-color:#EF5843;
                --bs-link-hover-color-rgb:239,88,67;
            }

            .text-primary{
                color:#EF5843!important;
            }

            .bg-primary{
                background-color:#241B52!important;
            }

            .border-primary{
                border-color:#241B52!important;
            }

            .btn-primary{
                --bs-btn-color:#fff;
                --bs-btn-bg:#EF5843;
                --bs-btn-border-color:#EF5843;
                --bs-btn-hover-color:#fff;
                --bs-btn-hover-bg:#D94F38;
                --bs-btn-hover-border-color:#D94F38;
                --bs-btn-active-color:#fff;
                --bs-btn-active-bg:#C6432F;
                --bs-btn-active-border-color:#C6432F;
                background-color:#EF5843!important;
                border-color:#EF5843!important;
                color:#fff!important;
            }

            .btn-primary:hover,
            .btn-primary:focus{
                background-color:#D94F38!important;
                border-color:#D94F38!important;
                color:#fff!important;
            }

            .btn-outline-primary{
                color:#241B52!important;
                border-color:#241B52!important;
            }

            .btn-outline-primary:hover{
                background-color:#241B52!important;
                border-color:#241B52!important;
                color:#fff!important;
            }

            .badge.bg-primary{
                background-color:#241B52!important;
                color:#fff!important;
            }

            main a:not(.btn):not(.information-button){
                --bs-link-color-rgb:36,27,82;
            }

            .pagination{
                display:flex;
                align-items:center;
                justify-content:center;
                flex-wrap:wrap;
                gap:7px;
                margin:0;
                padding:0;
            }

            .pagination .page-item{
                margin:0;
            }

            .pagination .page-link{
                display:flex;
                align-items:center;
                justify-content:center;
                min-width:40px;
                height:40px;
                padding:0 12px;
                border:1px solid #E5E7EB;
                border-radius:10px!important;
                background:#fff;
                color:#241B52;
                font-size:13px;
                font-weight:600;
                text-decoration:none;
                box-shadow:none!important;
                transition:all .2s ease;
            }

            .pagination .page-link:hover{
                background:#FFF5F2;
                border-color:#EF5843;
                color:#EF5843;
            }

            .pagination .page-item.active .page-link{
                background:#241B52;
                border-color:#241B52;
                color:#fff;
            }

            .pagination .page-item.disabled .page-link{
                background:#F8FAFC;
                border-color:#E5E7EB;
                color:#9CA3AF;
            }

            .form-control:focus,
            .form-select:focus{
                border-color:#EF5843;
                box-shadow:0 0 0 .2rem rgba(239,88,67,.15);
            }

            #main-navbar{
                font-family:'Inter',sans-serif;
            }

            #main-navbar a{
                text-decoration:none;
            }

            #main-navbar button{
                font-family:'Inter',sans-serif;
            }

            .card{
                background-color:#fff;
            }

            .text-dark{
                color:#241B52!important;
            }

            .text-muted{
                color:#6B7280!important;
            }
        </style>
    @endif

    {{-- =====================================================
        BARBA PAGE TRANSITION
        Hanya layer visual.
        Tidak membuat content opacity 0.
    ====================================================== --}}
    <style>
        html,
        body{
            width:100%;
            min-height:100%;
        }

        body{
            overflow-x:hidden;
        }

        [data-barba="container"]{
            position:relative;
            width:100%;
        }

        /*
         * Page transition overlay.
         *
         * Default benar-benar tidak terlihat.
         * GSAP hanya menghidupkannya ketika route
         * Bookstore <-> Detail berubah.
         */
        #bdRouteWipe{
            position:fixed;
            inset:0;
            z-index:99999;
            visibility:hidden;
            pointer-events:none;
            overflow:hidden;
        }

        #bdRouteWipe .bd-route-wipe-panel{
            position:absolute;
            inset:0;
            transform:scaleX(0);
            transform-origin:left center;
            will-change:transform;

            background:
                linear-gradient(
                    90deg,
                    #241B52 0%,
                    #241B52 89%,
                    #EF5843 89%,
                    #EF5843 95%,
                    #F7AA35 95%,
                    #F7AA35 100%
                );
        }

        /*
         * Garis kecil di sisi wipe supaya perpindahan
         * terasa lebih tajam/editorial.
         */
        #bdRouteWipe .bd-route-wipe-edge{
            position:absolute;
            top:0;
            right:0;
            width:4px;
            height:100%;
            opacity:.85;

            background:
                linear-gradient(
                    180deg,
                    #F7AA35,
                    #EF5843
                );
        }

        /*
         * Untuk browser/user yang memilih reduced motion.
         */
        @media(prefers-reduced-motion:reduce){
            #bdRouteWipe{
                display:none!important;
            }

            [data-barba="container"]{
                transform:none!important;
                opacity:1!important;
            }
        }
    </style>

    <link
        rel="stylesheet"
        href="https://unpkg.com/trix@2.1.15/dist/trix.css"
    >

    <script
        src="https://unpkg.com/trix@2.1.15/dist/trix.umd.min.js"
        defer>
    </script>

    @stack('styles')
</head>

<body
    data-barba="wrapper"
    class="min-h-full bg-slate-50 text-slate-900 flex flex-col m-0 p-0 font-sans antialiased selection:bg-orange-500 selection:text-white"
>

    {{-- =====================================================
        NAVBAR
        Diletakkan di luar container Barba.
        Jadi tidak dihancurkan / dibuat ulang setiap navigasi.
    ====================================================== --}}
    <x-navbar />

    {{-- =====================================================
        MAIN
    ====================================================== --}}
    <main class="flex-grow w-full">

        {{-- =================================================
            BARBA CONTAINER

            Yang diganti Barba hanya bagian ini.
            Navbar dan Footer tetap.
        ================================================== --}}
        <div
            data-barba="container"
            data-barba-namespace="@yield('barba-namespace','default')"
            data-page-title="@yield('title','Baca Dulu - Platform Penerbitan Modern')"
        >

            {{-- =============================================
                FLASH MESSAGE
                Harus berada di dalam container.
                Supaya hasil response Laravel yang baru
                ikut terbaca ketika Barba navigation.
            ============================================== --}}
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-10 py-4">
                    <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-10 py-4">
                    <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-10 py-4">
                    <div class="rounded-xl bg-amber-50 border border-amber-200 p-4 text-sm text-amber-800">
                        {{ session('warning') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- =====================================================
        FOOTER
        Sama seperti navbar: jangan masuk container Barba.
    ====================================================== --}}
    <x-footer />

    {{-- =====================================================
        BARBA TRANSITION LAYER

        Sudah disediakan di layout.
        bookstore-motion.js tinggal mengambil:
        #bdRouteWipe
        .bd-route-wipe-panel
    ====================================================== --}}
    <div
        id="bdRouteWipe"
        aria-hidden="true"
    >
        <div class="bd-route-wipe-panel">
            <span class="bd-route-wipe-edge"></span>
        </div>
    </div>

    @if($useBootstrap)
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        </script>
    @endif

    @stack('scripts')
</body>
</html>