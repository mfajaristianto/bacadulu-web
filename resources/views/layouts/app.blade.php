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

    {{-- CSRF TOKEN --}}
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

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
        VITE
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


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


    {{-- CUSTOM STYLE PER HALAMAN --}}
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

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-10 py-4">

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


        {{-- CONTENT HALAMAN --}}
        @yield('content')

    </main>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <x-footer />


    {{-- =====================================================
        SCRIPT PER HALAMAN
    ====================================================== --}}

    @stack('scripts')


</body>

</html>