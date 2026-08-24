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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
        --bs-link-hover-color-rgb:239,88,67
    }

    .text-primary{color:#EF5843!important}
    .bg-primary{background-color:#241B52!important}
    .border-primary{border-color:#241B52!important}

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
        color:#fff!important
    }

    .btn-primary:hover,.btn-primary:focus{
        background-color:#D94F38!important;
        border-color:#D94F38!important;
        color:#fff!important
    }

    .btn-outline-primary{
        color:#241B52!important;
        border-color:#241B52!important
    }

    .btn-outline-primary:hover{
        background-color:#241B52!important;
        border-color:#241B52!important;
        color:#fff!important
    }

    .badge.bg-primary{
        background-color:#241B52!important;
        color:#fff!important
    }

    main a:not(.btn):not(.information-button){
        --bs-link-color-rgb:36,27,82
    }

    .pagination{
        display:flex;
        align-items:center;
        justify-content:center;
        flex-wrap:wrap;
        gap:7px;
        margin:0;
        padding:0
    }

    .pagination .page-item{margin:0}

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
        transition:all .2s ease
    }

    .pagination .page-link:hover{
        background:#FFF5F2;
        border-color:#EF5843;
        color:#EF5843
    }

    .pagination .page-item.active .page-link{
        background:#241B52;
        border-color:#241B52;
        color:#fff
    }

    .pagination .page-item.disabled .page-link{
        background:#F8FAFC;
        border-color:#E5E7EB;
        color:#9CA3AF
    }

    .form-control:focus,.form-select:focus{
        border-color:#EF5843;
        box-shadow:0 0 0 .2rem rgba(239,88,67,.15)
    }

    #main-navbar{font-family:'Inter',sans-serif}
    #main-navbar a{text-decoration:none}
    #main-navbar button{font-family:'Inter',sans-serif}
    .card{background-color:#fff}
    .text-dark{color:#241B52!important}
    .text-muted{color:#6B7280!important}
    </style>
    @endif

    <link rel="stylesheet" href="https://unpkg.com/trix@2.1.15/dist/trix.css">
    <script src="https://unpkg.com/trix@2.1.15/dist/trix.umd.min.js" defer></script>

    @stack('styles')
</head>

<body class="min-h-full bg-slate-50 text-slate-900 flex flex-col m-0 p-0 font-sans antialiased selection:bg-orange-500 selection:text-white">

    <x-navbar />

    <main class="flex-grow w-full">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-10 py-4">
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <x-footer />

    @if($useBootstrap)
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endif

    @stack('scripts')
</body>
</html>