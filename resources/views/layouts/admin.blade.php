<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin CMS — Baca Dulu</title>

    {{-- Tailwind CSS --}}
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

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>

        :root {
            --navy-deep: #170F38;
            --navy: #241B52;
            --orange: #EF5843;
            --orange-dark: #C6432F;
            --gold: #F7AA35;

            --brand-gradient:
                linear-gradient(
                    135deg,
                    var(--orange) 0%,
                    var(--gold) 100%
                );
        }


        /* =====================================================
           PAGE
        ====================================================== */

        @keyframes cmsFadeUp {

            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        .cms-page-enter {
            animation: cmsFadeUp .45s ease both;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

        .cms-sidebar {

            background:
                radial-gradient(
                    circle at 10% 0%,
                    rgba(239, 88, 67, 0.20),
                    transparent 35%
                ),

                radial-gradient(
                    circle at 100% 40%,
                    rgba(247, 170, 53, 0.08),
                    transparent 30%
                ),

                linear-gradient(
                    180deg,
                    var(--navy) 0%,
                    var(--navy-deep) 100%
                );

            border-right:
                1px solid rgba(255,255,255,.06);
        }


        /* =====================================================
           LOGO
        ====================================================== */

        .cms-logo-badge {

            width: 42px;
            height: 42px;

            border-radius: 12px;

            background:
                var(--brand-gradient);

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 900;

            color: white;

            font-size: 14px;

            box-shadow:
                0 8px 22px rgba(239,88,67,.28);
        }


        /* =====================================================
           SECTION LABEL
        ====================================================== */

        .cms-section-label {

            padding-left: 14px;

            margin-top: 22px;
            margin-bottom: 8px;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: .12em;

            text-transform: uppercase;

            color: #64748b;
        }


        /* =====================================================
           NAVIGATION
        ====================================================== */

        .cms-nav-link {

            position: relative;

            display: flex;

            align-items: center;

            gap: 11px;

            padding:
                10px 12px;

            border-radius: 11px;

            color: #cbd5e1;

            font-size: 14px;

            font-weight: 500;

            transition:
                color .2s ease,
                background-color .2s ease,
                transform .2s ease;

            overflow: hidden;
        }


        .cms-nav-link .nav-icon {

            width: 34px;
            height: 34px;

            flex-shrink: 0;

            border-radius: 9px;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                rgba(255,255,255,.04);

            color: #94a3b8;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }


        .cms-nav-link:hover {

            color: white;

            background:
                rgba(255,255,255,.055);

            transform:
                translateX(2px);
        }


        .cms-nav-link:hover .nav-icon {

            color: white;

            background:
                rgba(239,88,67,.14);
        }


        .cms-nav-link.active {

            color: white;

            background:
                linear-gradient(
                    90deg,
                    rgba(239,88,67,.18),
                    rgba(239,88,67,.06)
                );
        }


        .cms-nav-link.active::before {

            content: "";

            position: absolute;

            left: 0;

            top: 8px;
            bottom: 8px;

            width: 3px;

            border-radius:
                0 4px 4px 0;

            background:
                var(--brand-gradient);
        }


        .cms-nav-link.active .nav-icon {

            color: white;

            background:
                rgba(239,88,67,.20);

            box-shadow:
                0 0 0 1px rgba(239,88,67,.10);
        }


        /* =====================================================
           ARTICLE SPECIAL NAV
        ====================================================== */

        .cms-article-link {

            background:
                linear-gradient(
                    135deg,
                    rgba(239,88,67,.10),
                    rgba(247,170,53,.05)
                );

            border:
                1px solid rgba(239,88,67,.12);
        }


        .cms-article-link:hover {

            background:
                linear-gradient(
                    135deg,
                    rgba(239,88,67,.17),
                    rgba(247,170,53,.08)
                );
        }


        .cms-pending-badge {

            min-width: 22px;

            height: 22px;

            padding:
                0 6px;

            border-radius: 999px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            background:
                var(--orange);

            color: white;

            font-size: 10px;

            font-weight: 800;

            box-shadow:
                0 4px 10px rgba(239,88,67,.25);
        }


        /* =====================================================
           SIDEBAR DIVIDER
        ====================================================== */

        .cms-divider {

            height: 1px;

            margin:
                18px 4px;

            background:
                rgba(255,255,255,.07);
        }


        /* =====================================================
           USER AREA
        ====================================================== */

        .cms-user-box {

            border:
                1px solid rgba(255,255,255,.07);

            background:
                rgba(255,255,255,.035);

            border-radius: 14px;

            padding: 10px;
        }


        .cms-user-avatar {

            width: 34px;
            height: 34px;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                var(--brand-gradient);

            color: white;

            font-size: 12px;

            font-weight: 800;
        }


        /* =====================================================
           LOGOUT
        ====================================================== */

        .cms-logout-btn {

            background:
                var(--brand-gradient);

            transition:
                filter .2s ease,
                transform .2s ease,
                box-shadow .2s ease;

            box-shadow:
                0 8px 18px rgba(239,88,67,.22);
        }


        .cms-logout-btn:hover {

            filter:
                brightness(1.06);

            transform:
                translateY(-1px);

            box-shadow:
                0 12px 22px rgba(239,88,67,.30);
        }


        /* =====================================================
           TOPBAR
        ====================================================== */

        .cms-topbar {

            backdrop-filter:
                blur(10px);

            background:
                rgba(255,255,255,.82);
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        #cms-mobile-toggle {
            display: none;
        }


        @media (max-width: 1023.5px) {

            .cms-sidebar {

                position: fixed;

                inset:
                    0 auto 0 0;

                width: 290px;

                z-index: 50;

                transform:
                    translateX(-100%);

                transition:
                    transform .3s cubic-bezier(.22,1,.36,1);

                display: block !important;

                overflow-y: auto;
            }


            #cms-mobile-toggle:checked
            ~ .cms-sidebar-wrap
            .cms-sidebar {

                transform:
                    translateX(0);
            }


            .cms-sidebar-overlay {

                position: fixed;

                inset: 0;

                z-index: 40;

                background:
                    rgba(15,10,35,.58);

                opacity: 0;

                pointer-events: none;

                transition:
                    opacity .3s ease;
            }


            #cms-mobile-toggle:checked
            ~ .cms-sidebar-wrap
            .cms-sidebar-overlay {

                opacity: 1;

                pointer-events: auto;
            }

        }


        /* =====================================================
           MAIN CONTENT
        ====================================================== */

        .cms-main {

            background:
                #f8fafc;
        }


        /* =====================================================
           SCROLLBAR
        ====================================================== */

        .cms-sidebar::-webkit-scrollbar {

            width: 5px;
        }


        .cms-sidebar::-webkit-scrollbar-track {

            background:
                transparent;
        }


        .cms-sidebar::-webkit-scrollbar-thumb {

            background:
                rgba(255,255,255,.10);

            border-radius:
                999px;
        }

    </style>

</head>


<body class="min-h-screen bg-slate-100 text-slate-900">


    {{-- =========================================================
         MOBILE SIDEBAR TOGGLE
    ========================================================== --}}

    <input
        type="checkbox"
        id="cms-mobile-toggle"
    >


    <div class="cms-sidebar-wrap min-h-screen flex">


        {{-- =====================================================
             MOBILE OVERLAY
        ====================================================== --}}

        <label
            for="cms-mobile-toggle"
            class="cms-sidebar-overlay lg:hidden"
        ></label>



        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}

        <aside
            class="cms-sidebar w-72 shrink-0 text-white p-5 hidden lg:flex lg:flex-col"
        >


            {{-- =================================================
                 BRAND
            ================================================== --}}

            <div class="mb-7 flex items-center gap-3 px-2">

                <div class="cms-logo-badge">
                    BD
                </div>

                <div class="min-w-0">

                    <h2 class="text-base font-extrabold leading-tight">
                        Baca Dulu
                    </h2>

                    <p class="mt-0.5 text-[11px] text-slate-400">
                        Admin Content Management
                    </p>

                </div>

            </div>



            {{-- =================================================
                 NAVIGATION
            ================================================== --}}

            <nav class="flex-1 space-y-1">


                {{-- ===============================
                     UTAMA
                ================================ --}}

                <div class="cms-section-label">
                    Utama
                </div>


                {{-- Dashboard --}}

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <rect
                                x="4"
                                y="4"
                                width="6"
                                height="6"
                                rx="1"
                            />

                            <rect
                                x="14"
                                y="4"
                                width="6"
                                height="6"
                                rx="1"
                            />

                            <rect
                                x="4"
                                y="14"
                                width="6"
                                height="6"
                                rx="1"
                            />

                            <rect
                                x="14"
                                y="14"
                                width="6"
                                height="6"
                                rx="1"
                            />
                        </svg>

                    </span>

                    <span class="flex-1">
                        Dashboard
                    </span>

                </a>



                {{-- ===============================
                     BLOGGING
                ================================ --}}

                <div class="cms-section-label">
                    Blogging
                </div>


                <a
                    href="{{ route('admin.posts.index') }}"
                    class="cms-nav-link cms-article-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 4h10l4 4v12H5a2 2 0 01-2-2V6a2 2 0 012-2z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 4v5h5M8 13h8M8 17h5"
                            />

                        </svg>

                    </span>


                    <span class="flex-1">
                        Artikel
                    </span>


                    @php

                        $pendingPosts =
                            \App\Models\Post::where(
                                'status',
                                'pending'
                            )->count();

                    @endphp


                    @if($pendingPosts > 0)

                        <span class="cms-pending-badge">

                            {{ $pendingPosts > 99 ? '99+' : $pendingPosts }}

                        </span>

                    @endif

                </a>



                {{-- ===============================
                     KONTEN WEBSITE
                ================================ --}}

                <div class="cms-section-label">
                    Konten Website
                </div>


                {{-- Informasi --}}

                <a
                    href="{{ route('admin.informations.index') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.informations.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />

                            <path
                                stroke-linecap="round"
                                d="M12 11v5M12 8h.01"
                            />

                        </svg>

                    </span>

                    <span class="flex-1">
                        Informasi
                    </span>

                </a>



                {{-- Jurnal --}}

                <a
                    href="{{ route('admin.journals.index') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.journals.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                d="M6 4h12M6 8h12M6 12h8M6 16h8M6 20h12"
                            />

                        </svg>

                    </span>

                    <span class="flex-1">
                        Jurnal
                    </span>

                </a>



                {{-- Event --}}

                <a
                    href="{{ route('admin.events.index') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <rect
                                x="4"
                                y="5"
                                width="16"
                                height="15"
                                rx="2"
                            />

                            <path
                                stroke-linecap="round"
                                d="M8 3v4M16 3v4M4 10h16"
                            />

                        </svg>

                    </span>

                    <span class="flex-1">
                        Event
                    </span>

                </a>



                {{-- Konferensi --}}

                <a
                    href="{{ route('admin.conferences.index') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.conferences.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <circle
                                cx="12"
                                cy="12"
                                r="8"
                            />

                            <path
                                stroke-linecap="round"
                                d="M8 12h8M12 8v8"
                            />

                        </svg>

                    </span>

                    <span class="flex-1">
                        Konferensi
                    </span>

                </a>



                {{-- Publisher --}}

                <a
                    href="{{ route('admin.publishers.index') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14"
                            />

                            <path
                                stroke-linecap="round"
                                d="M4 19c0-1.1.9-2 2-2h14M8 7h8M8 11h6"
                            />

                        </svg>

                    </span>

                    <span class="flex-1">
                        Publisher
                    </span>

                </a>



                {{-- ===============================
                     BOOKSTORE
                ================================ --}}

                <div class="cms-section-label">
                    Bookstore
                </div>


                {{-- Buku --}}

                <a
                    href="{{ route('admin.books.index') }}"
                    class="cms-nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}"
                >

                    <span class="nav-icon">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 4h11a3 3 0 013 3v13H8a3 3 0 01-3-3V4z"
                            />

                            <path
                                stroke-linecap="round"
                                d="M8 4v16"
                            />

                        </svg>

                    </span>

                    <span class="flex-1">
                        Kelola Buku
                    </span>

                </a>


            </nav>



            {{-- =================================================
                 BOTTOM AREA
            ================================================== --}}

            <div class="mt-6">


                {{-- Divider --}}

                <div class="cms-divider"></div>



                {{-- User Info --}}

                <div class="cms-user-box mb-3">

                    <div class="flex items-center gap-3">

                        <div class="cms-user-avatar">

                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="truncate text-xs font-bold text-white">

                                {{ auth()->user()->name ?? 'Administrator' }}

                            </p>

                            <p class="truncate text-[10px] text-slate-400">

                                {{ auth()->user()->email ?? 'Admin CMS' }}

                            </p>

                        </div>

                    </div>

                </div>



                {{-- Logout --}}

                <form
                    method="POST"
                    action="{{ route('admin.logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="cms-logout-btn flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-bold text-white"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                d="M10 17l5-5-5-5"
                            />

                            <path
                                stroke-linecap="round"
                                d="M15 12H3"
                            />

                            <path
                                stroke-linecap="round"
                                d="M21 4v16"
                            />

                        </svg>

                        Logout

                    </button>

                </form>

            </div>


        </aside>



        {{-- =====================================================
             MAIN AREA
        ====================================================== --}}

        <div class="flex min-w-0 flex-1 flex-col">


            {{-- =================================================
                 MOBILE TOPBAR
            ================================================== --}}

            <header
                class="cms-topbar sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 px-5 py-4 lg:hidden"
            >

                <div class="flex items-center gap-3">

                    <div
                        class="cms-logo-badge"
                        style="width:34px;height:34px;font-size:11px;"
                    >
                        BD
                    </div>

                    <div>

                        <p class="text-sm font-extrabold text-slate-900">
                            Baca Dulu
                        </p>

                        <p class="text-[10px] text-slate-500">
                            Admin CMS
                        </p>

                    </div>

                </div>


                <label
                    for="cms-mobile-toggle"
                    class="cursor-pointer rounded-xl p-2.5 transition hover:bg-slate-100"
                >

                    <svg
                        class="h-6 w-6 text-slate-700"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                    </svg>

                </label>

            </header>



            {{-- =================================================
                 PAGE CONTENT
            ================================================== --}}

            <main class="cms-main flex-1 p-5 sm:p-6 lg:p-8">

                <div class="cms-page-enter">

                    @yield('content')

                </div>

            </main>


        </div>


    </div>


</body>

</html>