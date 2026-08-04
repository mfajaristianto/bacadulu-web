<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen flex">
        <aside class="w-72 bg-slate-900 text-white p-6 hidden lg:block">
            <div class="mb-8">
                <h2 class="text-xl font-bold">Admin CMS</h2>
                <p class="text-sm text-slate-400">Kelola konten website</p>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Dashboard</a>
                <a href="{{ route('admin.informations.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Informasi</a>
                <a href="{{ route('admin.journals.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Jurnal</a>
                <a href="{{ route('admin.conferences.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Konferensi</a>
                <a href="{{ route('admin.publishers.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Publisher</a>
                <a href="{{ route('admin.data-articles.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Data Artikel</a>
                <form method="POST" action="{{ route('admin.logout') }}" class="pt-4">
                    @csrf
                    <button type="submit" class="w-full rounded bg-orange-600 px-3 py-2 text-left">Logout</button>
                </form>
            </nav>
        </aside>
        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
