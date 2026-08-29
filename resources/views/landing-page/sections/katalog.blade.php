<!DOCTYPE html>
<html
    lang="id"
    class="h-full"
    data-baca-device="desktop"
    data-baca-input="fine"
>
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    {{-- =========================================================
         GLOBAL DEVICE DETECTOR
         Dijalankan secepat mungkin sebelum CSS/component render.
    ========================================================== --}}
    <script>
    (function () {
        'use strict';

        function detectBacaDevice() {
            const html =
                document.documentElement;

            const viewportWidth =
                window.innerWidth
                ||
                html.clientWidth
                ||
                1024;

            const viewportHeight =
                window.innerHeight
                ||
                html.clientHeight
                ||
                768;

            const screenWidth =
                window.screen?.width
                ||
                viewportWidth;

            const screenHeight =
                window.screen?.height
                ||
                viewportHeight;

            const shortSide =
                Math.min(
                    screenWidth,
                    screenHeight
                );

            const longSide =
                Math.max(
                    screenWidth,
                    screenHeight
                );

            const coarsePointer =
                window.matchMedia(
                    '(pointer: coarse)'
                ).matches;

            const finePointer =
                window.matchMedia(
                    '(pointer: fine)'
                ).matches;

            const noHover =
                window.matchMedia(
                    '(hover: none)'
                ).matches;

            const canHover =
                window.matchMedia(
                    '(hover: hover)'
                ).matches;

            const maxTouchPoints =
                navigator.maxTouchPoints
                ||
                0;

            /*
            |--------------------------------------------------------------------------
            | INPUT UTAMA
            |--------------------------------------------------------------------------
            |
            | coarse/noHover:
            | mayoritas HP/tablet.
            |
            | maxTouchPoints:
            | hanya menunjukkan device bisa disentuh.
            | Laptop touchscreen masih bisa tetap dianggap desktop.
            |
            */

            const touchPrimary =
                coarsePointer
                ||
                noHover;

            const touchCapable =
                touchPrimary
                ||
                maxTouchPoints > 0;

            let type =
                'desktop';

            /*
            |--------------------------------------------------------------------------
            | PHONE
            |--------------------------------------------------------------------------
            |
            | shortSide digunakan agar HP dengan "Desktop Site"
            | tetap dianggap phone walaupun viewport browser melebar.
            |
            */

            if (
                touchPrimary
                &&
                shortSide <= 600
            ) {
                type =
                    'phone';
            }

            /*
            |--------------------------------------------------------------------------
            | TABLET / IPAD
            |--------------------------------------------------------------------------
            */

            else if (
                touchPrimary
                &&
                shortSide > 600
                &&
                shortSide <= 1100
                &&
                longSide <= 1700
            ) {
                type =
                    'tablet';
            }

            /*
            |--------------------------------------------------------------------------
            | FALLBACK VIEWPORT
            |--------------------------------------------------------------------------
            |
            | Berguna untuk DevTools responsive maupun browser biasa.
            |
            */

            else if (
                viewportWidth <= 767
            ) {
                type =
                    'phone';
            }

            else if (
                viewportWidth <= 1023
            ) {
                type =
                    'tablet';
            }

            /*
            |--------------------------------------------------------------------------
            | DESKTOP / LAPTOP
            |--------------------------------------------------------------------------
            */

            else {
                type =
                    'desktop';
            }

            /*
            |--------------------------------------------------------------------------
            | INPUT MODE
            |--------------------------------------------------------------------------
            |
            | Laptop/PC dengan mouse:
            | fine
            |
            | HP/iPad:
            | touch
            |
            */

            const input =
                type === 'desktop'
                &&
                finePointer
                &&
                canHover

                    ? 'fine'

                    : 'touch';

            return {
                type,
                input,

                phone:
                    type === 'phone',

                tablet:
                    type === 'tablet',

                desktop:
                    type === 'desktop',

                touch:
                    input === 'touch',

                finePointer:
                    input === 'fine',

                touchPrimary,
                touchCapable,

                coarsePointer,
                canHover,
                noHover,
                maxTouchPoints,

                viewportWidth,
                viewportHeight,

                screenWidth,
                screenHeight,

                shortSide,
                longSide
            };
        }

        function applyBacaDevice() {
            const html =
                document.documentElement;

            const previousType =
                window.BacaDevice
                    ?.type
                ||
                null;

            const previousInput =
                window.BacaDevice
                    ?.input
                ||
                null;

            const device =
                detectBacaDevice();

            /*
            |--------------------------------------------------------------------------
            | GLOBAL JS OBJECT
            |--------------------------------------------------------------------------
            |
            | Bisa dipakai semua JS:
            |
            | window.BacaDevice.phone
            | window.BacaDevice.tablet
            | window.BacaDevice.desktop
            | window.BacaDevice.touch
            | window.BacaDevice.finePointer
            |
            */

            window.BacaDevice =
                device;

            /*
            |--------------------------------------------------------------------------
            | HTML DATA ATTRIBUTE
            |--------------------------------------------------------------------------
            |
            | Bisa langsung dipakai CSS:
            |
            | html[data-baca-device="phone"]
            | html[data-baca-device="tablet"]
            | html[data-baca-device="desktop"]
            |
            | html[data-baca-input="touch"]
            | html[data-baca-input="fine"]
            |
            */

            html.setAttribute(
                'data-baca-device',
                device.type
            );

            html.setAttribute(
                'data-baca-input',
                device.input
            );

            /*
            |--------------------------------------------------------------------------
            | OPTIONAL CLASS
            |--------------------------------------------------------------------------
            */

            html.classList.toggle(
                'bd-device-phone',
                device.phone
            );

            html.classList.toggle(
                'bd-device-tablet',
                device.tablet
            );

            html.classList.toggle(
                'bd-device-desktop',
                device.desktop
            );

            html.classList.toggle(
                'bd-input-touch',
                device.touch
            );

            html.classList.toggle(
                'bd-input-fine',
                device.finePointer
            );

            /*
            |--------------------------------------------------------------------------
            | EVENT
            |--------------------------------------------------------------------------
            |
            | Component lain bisa mendengar:
            |
            | window.addEventListener(
            |     'baca:devicechange',
            |     ...
            | )
            |
            */

            if (
                previousType !== device.type
                ||
                previousInput !== device.input
            ) {
                window.dispatchEvent(
                    new CustomEvent(
                        'baca:devicechange',
                        {
                            detail:
                                device
                        }
                    )
                );
            }

            return device;
        }

        /*
        |--------------------------------------------------------------------------
        | GLOBAL FUNCTIONS
        |--------------------------------------------------------------------------
        */

        window.detectBacaDevice =
            detectBacaDevice;

        window.applyBacaDevice =
            applyBacaDevice;

        /*
        |--------------------------------------------------------------------------
        | INITIAL DETECTION
        |--------------------------------------------------------------------------
        |
        | Jalankan langsung agar CSS tidak sempat salah mode.
        |
        */

        applyBacaDevice();

        /*
        |--------------------------------------------------------------------------
        | RESIZE
        |--------------------------------------------------------------------------
        */

        let resizeTimer =
            null;

        window.addEventListener(
            'resize',
            function () {
                clearTimeout(
                    resizeTimer
                );

                resizeTimer =
                    setTimeout(
                        function () {
                            applyBacaDevice();
                        },
                        120
                    );
            },
            {
                passive:true
            }
        );

        /*
        |--------------------------------------------------------------------------
        | ROTATE HP / IPAD
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'orientationchange',
            function () {
                setTimeout(
                    function () {
                        applyBacaDevice();
                    },
                    180
                );
            },
            {
                passive:true
            }
        );

        /*
        |--------------------------------------------------------------------------
        | BACK/FORWARD CACHE
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'pageshow',
            function () {
                applyBacaDevice();
            }
        );
    })();
    </script>

    <title>
        @yield(
            'title',
            'Baca Dulu - Platform Penerbitan Modern'
        )
    </title>

    {{-- =========================================================
         FONT
    ========================================================== --}}
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

    {{-- =========================================================
         ROUTE YANG MEMBUTUHKAN BOOTSTRAP
    ========================================================== --}}
    @php
        $useBootstrap =
            request()->routeIs(
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

    {{-- =========================================================
         VITE
    ========================================================== --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{-- =========================================================
         GLOBAL DEVICE FOUNDATION
    ========================================================== --}}
    <style>
        /*
        |--------------------------------------------------------------------------
        | BASIC
        |--------------------------------------------------------------------------
        */

        html,
        body{
            width:100%;
            max-width:100%;
            min-height:100%;
        }

        html{
            overflow-x:hidden;
        }

        body{
            margin:0;
            padding:0;

            overflow-x:hidden;
        }

        *,
        *::before,
        *::after{
            box-sizing:border-box;
        }

        img,
        video,
        canvas,
        svg{
            max-width:100%;
        }

        /*
        |--------------------------------------------------------------------------
        | PHONE
        |--------------------------------------------------------------------------
        */

        html[data-baca-device="phone"]{
            --bd-device-content-padding:16px;
            --bd-device-section-space:62px;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        html[data-baca-device="tablet"]{
            --bd-device-content-padding:24px;
            --bd-device-section-space:76px;
        }

        /*
        |--------------------------------------------------------------------------
        | DESKTOP
        |--------------------------------------------------------------------------
        */

        html[data-baca-device="desktop"]{
            --bd-device-content-padding:32px;
            --bd-device-section-space:92px;
        }

        /*
        |--------------------------------------------------------------------------
        | TOUCH
        |--------------------------------------------------------------------------
        |
        | Target sentuh minimal dibuat nyaman.
        |
        */

        html[data-baca-input="touch"] button,
        html[data-baca-input="touch"] a{
            -webkit-tap-highlight-color:
                transparent;
        }

        /*
        |--------------------------------------------------------------------------
        | FINE POINTER
        |--------------------------------------------------------------------------
        */

        html[data-baca-input="fine"]{
            --bd-hover-enabled:1;
        }

        /*
        |--------------------------------------------------------------------------
        | REDUCED MOTION
        |--------------------------------------------------------------------------
        */

        @media(
            prefers-reduced-motion:reduce
        ){
            html{
                scroll-behavior:auto!important;
            }
        }
    </style>

    {{-- =========================================================
         BOOTSTRAP OVERRIDE
    ========================================================== --}}
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
                --bs-link-color-rgb:
                    36,27,82;
            }

            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

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

                padding:
                    0 12px;

                border:
                    1px solid #E5E7EB;

                border-radius:
                    10px!important;

                background:#fff;

                color:#241B52;

                font-size:13px;
                font-weight:600;

                text-decoration:none;

                box-shadow:none!important;

                transition:
                    all .2s ease;
            }

            .pagination .page-link:hover{
                background:#FFF5F2;

                border-color:#EF5843;

                color:#EF5843;
            }

            .pagination
            .page-item.active
            .page-link{
                background:#241B52;

                border-color:#241B52;

                color:#fff;
            }

            .pagination
            .page-item.disabled
            .page-link{
                background:#F8FAFC;

                border-color:#E5E7EB;

                color:#9CA3AF;
            }

            /*
            |--------------------------------------------------------------------------
            | FORM
            |--------------------------------------------------------------------------
            */

            .form-control:focus,
            .form-select:focus{
                border-color:#EF5843;

                box-shadow:
                    0 0 0 .2rem
                    rgba(239,88,67,.15);
            }

            /*
            |--------------------------------------------------------------------------
            | NAVBAR
            |--------------------------------------------------------------------------
            */

            #main-navbar{
                font-family:
                    'Inter',
                    sans-serif;
            }

            #main-navbar a{
                text-decoration:none;
            }

            #main-navbar button{
                font-family:
                    'Inter',
                    sans-serif;
            }

            /*
            |--------------------------------------------------------------------------
            | CARD
            |--------------------------------------------------------------------------
            */

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

    {{-- =========================================================
         BARBA PAGE TRANSITION
    ========================================================== --}}
    <style>
        [data-barba="container"]{
            position:relative;

            width:100%;
            max-width:100%;
        }

        /*
        |--------------------------------------------------------------------------
        | ROUTE WIPE
        |--------------------------------------------------------------------------
        */

        #bdRouteWipe{
            position:fixed;

            inset:0;

            z-index:99999;

            visibility:hidden;

            pointer-events:none;

            overflow:hidden;
        }

        #bdRouteWipe
        .bd-route-wipe-panel{
            position:absolute;

            inset:0;

            transform:
                scaleX(0);

            transform-origin:
                left center;

            will-change:
                transform;

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

        #bdRouteWipe
        .bd-route-wipe-edge{
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
        |--------------------------------------------------------------------------
        | TOUCH DEVICE
        |--------------------------------------------------------------------------
        |
        | Route wipe tetap bisa dipakai.
        | Tapi transform berat component jangan dipaksakan dari sini.
        |
        */

        html[data-baca-input="touch"]
        #bdRouteWipe
        .bd-route-wipe-panel{
            will-change:
                auto;
        }

        /*
        |--------------------------------------------------------------------------
        | REDUCED MOTION
        |--------------------------------------------------------------------------
        */

        @media(
            prefers-reduced-motion:reduce
        ){
            #bdRouteWipe{
                display:none!important;
            }

            [data-barba="container"]{
                transform:none!important;

                opacity:1!important;
            }
        }
    </style>

    {{-- =========================================================
         TRIX
    ========================================================== --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/trix@2.1.15/dist/trix.css"
    >

    <script
        src="https://unpkg.com/trix@2.1.15/dist/trix.umd.min.js"
        defer
    ></script>

    @stack('styles')
</head>

<body
    data-barba="wrapper"
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

    {{-- =========================================================
         NAVBAR
         Di luar Barba container.
    ========================================================== --}}
    <x-navbar />

    {{-- =========================================================
         MAIN
    ========================================================== --}}
    <main
        class="
            flex-grow
            w-full
            max-w-full
        "
    >

        {{-- =====================================================
             BARBA CONTAINER
        ====================================================== --}}
        <div
            data-barba="container"
            data-barba-namespace="@yield('barba-namespace','default')"
            data-page-title="@yield('title','Baca Dulu - Platform Penerbitan Modern')"
        >

            {{-- =================================================
                 FLASH SUCCESS
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
                 FLASH ERROR
            ================================================== --}}
            @if(session('error'))

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
                            bg-red-50
                            border
                            border-red-200
                            p-4
                            text-sm
                            text-red-800
                        "
                    >
                        {{ session('error') }}
                    </div>
                </div>

            @endif

            {{-- =================================================
                 FLASH WARNING
            ================================================== --}}
            @if(session('warning'))

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
                            bg-amber-50
                            border
                            border-amber-200
                            p-4
                            text-sm
                            text-amber-800
                        "
                    >
                        {{ session('warning') }}
                    </div>
                </div>

            @endif

            @yield('content')
        </div>
    </main>

    {{-- =========================================================
         FOOTER
         Tetap di luar Barba container.
    ========================================================== --}}
    <x-footer />

    {{-- =========================================================
         BARBA TRANSITION LAYER
    ========================================================== --}}
    <div
        id="bdRouteWipe"
        aria-hidden="true"
    >
        <div class="bd-route-wipe-panel">
            <span
                class="bd-route-wipe-edge"
            ></span>
        </div>
    </div>

    {{-- =========================================================
         BOOTSTRAP JS
    ========================================================== --}}
    @if($useBootstrap)

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        ></script>

    @endif

    @stack('scripts')
</body>
</html>