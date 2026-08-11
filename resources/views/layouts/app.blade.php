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

    <!-- Tailwind CSS CDN -->
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
    <!-- Trix editor -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" integrity="sha512-5i3b3nW7QwZ0pQfM9vDOMkMt2rtI8BGG99nmHn7+O+kO5OVwOB1p5MNDoAuCEi0aKBslrYhZWVJQGZ6j3q6C6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js" integrity="sha512-/u1m0eodIZ6wO6PvxI6Bfq5lHppZArYrusS4x+h0cYfZfbQfVIAtF+wNCz7L+G2kZZgwyU0vbzUKGwEuZ0YFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
</head>
<body class="min-h-full bg-slate-50 text-slate-900 flex flex-col m-0 p-0 font-sans antialiased selection:bg-orange-500 selection:text-white">

    <!-- Komponen Navbar Utama -->
    <x-navbar />

    <!-- Area Konten Utama (Diubah agar full width tanpa batasan) -->
    <main class="flex-grow w-full">
        @if(session('success'))
            <div class="max-w-6xl mx-auto px-6 py-4">
                <div class="rounded-lg bg-green-50 border border-green-200 p-4 text-green-800">{{ session('success') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Komponen Footer Utama -->
    <x-footer />

</body>
</html>