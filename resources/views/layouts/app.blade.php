<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSRF TOKEN UNTUK AJAX / FETCH API --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Baca Dulu - Platform Penerbitan Modern</title>

    <!-- =====================================================
         GOOGLE FONTS
    ====================================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <!-- =====================================================
         VITE
    ====================================================== -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- =====================================================
         TRIX EDITOR
    ====================================================== -->
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
    class="min-h-full bg-slate-50 text-slate-900 flex flex-col m-0 p-0 font-sans antialiased selection:bg-orange-500 selection:text-white"
>

    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <x-navbar />


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main class="flex-grow w-full">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="max-w-6xl mx-auto px-6 py-4">

                <div
                    class="rounded-lg bg-green-50 border border-green-200 p-4 text-green-800"
                >
                    {{ session('success') }}
                </div>

            </div>
        @endif


        {{-- Content --}}
        @yield('content')

    </main>


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <x-footer />


    <!-- =====================================================
         STACK SCRIPTS
    ====================================================== -->

    @stack('scripts')

</body>

</html>