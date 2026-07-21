<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Baca Dulu - Platform Penerbitan Modern</title>
    
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN (Jalan Pintas biar langsung bisa dipake) -->
    <script src="https://cdn.tailwindcss.com"></script>
    

    <!-- Konfigurasi Tambahan untuk Warna Oranye -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            500: '#f97316',
                            600: '#ea580c',
                        }
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-50 text-slate-900 flex flex-col m-0 p-0 font-sans antialiased selection:bg-orange-500 selection:text-white">

    <!-- Komponen Navbar Utama -->
    <x-navbar />

    <!-- Area Konten Utama -->x
    <main class="flex-grow w-full block h-auto clear-both">
        @yield('content')
    </main>

    <!-- Komponen Footer Utama -->
    <x-footer />

</body>
</html>