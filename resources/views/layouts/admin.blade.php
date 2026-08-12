<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CMS — Baca Dulu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            500: '#EF5843',
                            600: '#C6432F',
                        },
                        gold: {
                            500: '#F7AA35',
                        },
                        navy: {
                            900: '#170F38',
                            800: '#241B52',
                        }
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --navy-deep:#170F38;
            --navy:#241B52;
            --orange:#EF5843;
            --orange-dark:#C6432F;
            --gold:#F7AA35;
            --brand-gradient: linear-gradient(135deg, var(--orange) 0%, var(--gold) 100%);
        }

        @keyframes cmsFadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .cms-page-enter {
            animation: cmsFadeUp .45s ease both;
        }

        .cms-sidebar {
            background:
                radial-gradient(circle at 15% 0%, rgba(239,88,67,0.18), transparent 55%),
                linear-gradient(180deg, var(--navy) 0%, var(--navy-deep) 100%);
        }

        .cms-logo-badge {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--brand-gradient);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 15px;
            box-shadow: 0 6px 16px rgba(239,88,67,0.35);
        }

        .cms-nav-link {
            position: relative;
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px 10px 16px;
            border-radius: 10px;
            color: #cbd5e1;
            font-size: 14.5px; font-weight: 500;
            transition: color .2s ease, background-color .25s ease, transform .2s ease;
            overflow: hidden;
        }
        .cms-nav-link .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #64748b;
            transition: background-color .25s ease, transform .25s ease;
            flex-shrink: 0;
        }
        .cms-nav-link::before{
            content:"";
            position:absolute; left:0; top:0; bottom:0; width:3px;
            background: var(--brand-gradient);
            transform: scaleY(0);
            transform-origin: center;
            transition: transform .25s ease;
            border-radius: 0 4px 4px 0;
        }
        .cms-nav-link:hover{
            color:#fff;
            background: rgba(255,255,255,0.06);
            transform: translateX(3px);
        }
        .cms-nav-link:hover .dot{
            background: var(--gold);
            transform: scale(1.3);
        }
        .cms-nav-link.active{
            color:#fff;
            background: rgba(239,88,67,0.14);
        }
        .cms-nav-link.active::before{
            transform: scaleY(1);
        }
        .cms-nav-link.active .dot{
            background: var(--orange);
            box-shadow: 0 0 0 4px rgba(239,88,67,0.18);
        }

        .cms-logout-btn{
            background: var(--brand-gradient);
            transition: filter .2s ease, transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 8px 18px rgba(239,88,67,0.25);
        }
        .cms-logout-btn:hover{
            filter: brightness(1.06);
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(239,88,67,0.32);
        }
        .cms-logout-btn:active{
            transform: translateY(0);
        }

        .cms-topbar{
            backdrop-filter: blur(6px);
            background: rgba(255,255,255,0.75);
        }

        #cms-mobile-toggle{ display:none; }

        @media (max-width: 1023.5px){
            .cms-sidebar{
                position: fixed; inset: 0 auto 0 0;
                width: 280px; z-index: 50;
                transform: translateX(-100%);
                transition: transform .3s cubic-bezier(.22,1,.36,1);
                display: block !important;
            }
            #cms-mobile-toggle:checked ~ .cms-sidebar-wrap .cms-sidebar{
                transform: translateX(0);
            }
            .cms-sidebar-overlay{
                position: fixed; inset: 0; z-index: 40;
                background: rgba(15,10,35,0.5);
                opacity: 0; pointer-events: none;
                transition: opacity .3s ease;
            }
            #cms-mobile-toggle:checked ~ .cms-sidebar-wrap .cms-sidebar-overlay{
                opacity: 1; pointer-events: auto;
            }
        }

        .cms-card{
            background:#fff; border:1px solid #E5E7EB; border-radius:16px;
            box-shadow: 0 1px 2px rgba(16,24,40,0.04);
            transition: box-shadow .25s ease;
        }
        .cms-btn-primary{
            display:inline-flex; align-items:center; gap:6px;
            background: var(--brand-gradient); color:#fff; font-weight:600; font-size:14px;
            padding:10px 20px; border-radius:10px;
            transition: filter .2s ease, transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 6px 14px rgba(239,88,67,0.25);
        }
        .cms-btn-primary:hover{
            filter: brightness(1.05);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(239,88,67,0.3);
        }
        .cms-table thead th{
            text-align:left; font-size:12.5px; font-weight:700; color:#475569;
            text-transform:uppercase; letter-spacing:.03em;
            padding:14px 20px; background:#F8FAFC; border-bottom:1px solid #E5E7EB;
        }
        .cms-table tbody td{
            padding:16px 20px; font-size:14px; color:#1e293b;
            border-bottom:1px solid #F1F5F9;
        }
        .cms-table tbody tr{
            transition: background-color .15s ease;
        }
        .cms-table tbody tr:hover{
            background:#FFF7ED;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">

    <input type="checkbox" id="cms-mobile-toggle">

    <div class="cms-sidebar-wrap min-h-screen flex">

        <label for="cms-mobile-toggle" class="cms-sidebar-overlay lg:hidden"></label>

        <aside class="cms-sidebar w-72 text-white p-6 hidden lg:block">
            <div class="mb-8 flex items-center gap-3">
                <div class="cms-logo-badge">BD</div>
                <div>
                    <h2 class="text-lg font-extrabold leading-tight">Admin Baca</h2>
                    <p class="text-xs text-slate-400">Kelola konten website</p>
                </div>
            </div>

            <nav class="space-y-1.5">
                <a href="{{ route('admin.dashboard') }}"
                   class="cms-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="dot"></span> Dashboard
                </a>
                <a href="{{ route('admin.informations.index') }}"
                   class="cms-nav-link {{ request()->routeIs('admin.informations.*') ? 'active' : '' }}">
                    <span class="dot"></span> Informasi
                </a>
                <a href="{{ route('admin.journals.index') }}"
                   class="cms-nav-link {{ request()->routeIs('admin.journals.*') ? 'active' : '' }}">
                    <span class="dot"></span> Jurnal
                </a>
                <a href="{{ route('admin.conferences.index') }}"
                   class="cms-nav-link {{ request()->routeIs('admin.conferences.*') ? 'active' : '' }}">
                    <span class="dot"></span> Konferensi
                </a>
                <a href="{{ route('admin.publishers.index') }}"
                   class="cms-nav-link {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">
                    <span class="dot"></span> Publisher
                </a>
                <a href="{{ route('admin.books.index') }}"
                   class="cms-nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <span class="dot"></span> Kelola Buku
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" class="pt-5">
                    @csrf
                    <button type="submit" class="cms-logout-btn w-full rounded-lg px-3 py-2.5 text-sm font-semibold text-white">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="cms-topbar lg:hidden sticky top-0 z-30 flex items-center justify-between px-5 py-4 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <div class="cms-logo-badge" style="width:30px;height:30px;font-size:12px;">BD</div>
                    <span class="font-bold text-sm">Admin Baca</span>
                </div>
                <label for="cms-mobile-toggle" class="cursor-pointer p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                <div class="cms-page-enter">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>