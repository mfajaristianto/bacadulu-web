@extends('layouts.admin')

@section('content')

@php
    $totalPosts = $stats['posts'] ?? 0;
    $pendingPosts = $stats['pending_posts'] ?? 0;
    $approvedPosts = $stats['approved_posts'] ?? 0;
    $rejectedPosts = $stats['rejected_posts'] ?? 0;

    $totalInformations = $stats['informations'] ?? 0;
    $totalJournals = $stats['journals'] ?? 0;
    $totalEvents = $stats['events'] ?? 0;
    $totalBooks = $stats['books'] ?? 0;
    $totalCommunities = $stats['communities'] ?? 0;

    $approvalRate = $totalPosts > 0
        ? round(($approvedPosts / $totalPosts) * 100)
        : 0;
@endphp


<style>
    @keyframes riseIn {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .rise {
        opacity: 0;
        animation: riseIn 0.5s ease forwards;
    }

    .rise-1 {
        animation-delay: .05s;
    }

    .rise-2 {
        animation-delay: .12s;
    }

    .rise-3 {
        animation-delay: .18s;
    }

    .rise-4 {
        animation-delay: .24s;
    }

    .rise-5 {
        animation-delay: .3s;
    }

    .stat-card {
        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -8px rgba(15, 23, 42, 0.12);
    }

    .quick-tile {
        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }

    .quick-tile:hover {
        transform: translateY(-3px) scale(1.015);
    }

    .quick-tile:active {
        transform: translateY(-1px) scale(0.99);
    }

    .quick-icon {
        transition: transform .3s ease;
    }

    .quick-tile:hover .quick-icon {
        transform: rotate(-6deg) scale(1.08);
    }

    .ring-progress {
        transform: rotate(-90deg);
    }

    .texture-dots {
        background-image:
            radial-gradient(
                rgba(255,255,255,0.08) 1px,
                transparent 1px
            );

        background-size: 16px 16px;
    }

    .side-nudge:hover .side-nudge-arrow {
        transform: translateX(3px);
    }

    .side-nudge-arrow {
        transition: transform .2s ease;
    }

    .count-up {
        font-variant-numeric: tabular-nums;
    }
</style>


<div class="space-y-8">


    {{-- =========================================================
         HERO / WELCOME
    ========================================================== --}}

    <section
        class="rise rise-1 relative overflow-hidden rounded-[28px] bg-[#170F38] px-6 py-9 text-white shadow-xl lg:px-10"
    >

        <div class="texture-dots absolute inset-0 opacity-40"></div>

        <div
            class="absolute -right-10 -top-16 h-64 w-64 rounded-full bg-[#EF5843]/25 blur-[70px]"
        ></div>

        <div
            class="absolute bottom-0 left-1/3 h-40 w-40 rounded-full bg-[#F7AA35]/10 blur-[60px]"
        ></div>


        <div
            class="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between"
        >

            <div class="max-w-2xl">

                <div
                    class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-slate-300"
                >

                    <span class="relative flex h-2 w-2">

                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"
                        ></span>

                        <span
                            class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"
                        ></span>

                    </span>

                    Sistem Admin Aktif

                </div>


                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Selamat datang kembali, Admin
                </h1>


                <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">
                    Pantau konten, kelola artikel, dan pastikan seluruh publikasi Baca Dulu berjalan dengan baik.
                </p>

            </div>


            <div class="shrink-0">

                <a
                    href="{{ route('admin.posts.index') }}"
                    class="group inline-flex items-center gap-3 rounded-xl bg-white px-5 py-3.5 text-sm font-bold text-[#170F38] shadow-lg transition hover:-translate-y-0.5 hover:shadow-2xl"
                >

                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EF5843] text-white transition group-hover:rotate-90 duration-300"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>

                    </span>

                    Review Artikel

                    <svg
                        class="h-4 w-4 transition group-hover:translate-x-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                        />
                    </svg>

                </a>

            </div>

        </div>

    </section>



    {{-- =========================================================
         STATISTICS
    ========================================================== --}}

    <section class="rise rise-2">

        <div class="mb-4 flex items-center justify-between">

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Ringkasan
                </h2>

                <p class="text-sm text-slate-500">
                    Gambaran singkat aktivitas website.
                </p>

            </div>

        </div>


        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">


            {{-- TOTAL ARTIKEL --}}

            <div class="stat-card rounded-2xl border border-slate-200 bg-white p-5">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Artikel
                        </p>

                        <p
                            class="count-up mt-2 text-3xl font-extrabold tracking-tight text-slate-900"
                            data-count="{{ $totalPosts }}"
                        >
                            0
                        </p>

                    </div>


                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-[#EF5843]"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h9l5 5v11a2 2 0 01-2 2z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 3v6h6M8 13h8M8 17h6"
                            />

                        </svg>

                    </div>

                </div>


                <a
                    href="{{ route('admin.posts.index') }}"
                    class="side-nudge mt-4 inline-flex items-center gap-1 text-xs font-bold text-[#EF5843] hover:text-[#C6432F]"
                >

                    Lihat semua

                    <svg
                        class="side-nudge-arrow h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                        />

                    </svg>

                </a>

            </div>



            {{-- PENDING --}}

            <div
                class="stat-card rounded-2xl border border-orange-200 bg-gradient-to-br from-orange-50 to-white p-5"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-orange-700">
                            Menunggu Review
                        </p>

                        <p
                            class="count-up mt-2 text-3xl font-extrabold tracking-tight text-orange-700"
                            data-count="{{ $pendingPosts }}"
                        >
                            0
                        </p>

                    </div>


                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500 text-white shadow-md shadow-orange-500/20"
                    >

                        <svg
                            class="h-5 w-5"
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
                                d="M12 7v5l3 2"
                            />

                        </svg>

                    </div>

                </div>


                @if($pendingPosts > 0)

                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="side-nudge mt-4 inline-flex items-center gap-1 text-xs font-bold text-orange-700 hover:text-orange-900"
                    >

                        Review sekarang

                        <svg
                            class="side-nudge-arrow h-3.5 w-3.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />

                        </svg>

                    </a>

                @else

                    <p class="mt-4 inline-flex items-center gap-1 text-xs font-medium text-emerald-600">

                        <svg
                            class="h-3.5 w-3.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5"
                            />

                        </svg>

                        Tidak ada artikel yang menunggu

                    </p>

                @endif

            </div>



            {{-- APPROVED --}}

            <div
                class="stat-card rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-white p-5"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-emerald-700">
                            Artikel Approved
                        </p>

                        <p
                            class="count-up mt-2 text-3xl font-extrabold tracking-tight text-emerald-700"
                            data-count="{{ $approvedPosts }}"
                        >
                            0
                        </p>

                    </div>


                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-md shadow-emerald-500/20"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            <path
                                d="M5 13l4 4L19 7"
                            />

                        </svg>

                    </div>

                </div>


                <p class="mt-4 text-xs font-medium text-emerald-600">
                    Artikel yang sudah diterbitkan
                </p>

            </div>



            {{-- REJECTED --}}

            <div
                class="stat-card rounded-2xl border border-slate-200 bg-white p-5"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Artikel Ditolak
                        </p>

                        <p
                            class="count-up mt-2 text-3xl font-extrabold tracking-tight text-slate-900"
                            data-count="{{ $rejectedPosts }}"
                        >
                            0
                        </p>

                    </div>


                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-500"
                    >

                        <svg
                            class="h-5 w-5"
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
                                d="M9 9l6 6M15 9l-6 6"
                            />

                        </svg>

                    </div>

                </div>


                <p class="mt-4 text-xs text-slate-500">
                    Artikel yang membutuhkan perhatian penulis
                </p>

            </div>

        </div>

    </section>



    {{-- =========================================================
         MAIN CONTENT GRID
    ========================================================== --}}

    <section class="rise rise-3 grid gap-6 xl:grid-cols-3">


        {{-- REVIEW ARTIKEL --}}

        <div
            class="relative overflow-hidden rounded-2xl bg-[#241B52] p-6 text-white shadow-lg xl:col-span-2"
        >

            <div
                class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-[#EF5843]/20 blur-2xl"
            ></div>


            <div
                class="relative flex flex-col gap-6 sm:flex-row sm:items-center"
            >

                <div class="flex shrink-0 items-center justify-center">

                    <div class="relative h-24 w-24">

                        <svg
                            class="ring-progress h-24 w-24"
                            viewBox="0 0 100 100"
                        >

                            <circle
                                cx="50"
                                cy="50"
                                r="42"
                                fill="none"
                                stroke="rgba(255,255,255,0.1)"
                                stroke-width="9"
                            />

                            <circle
                                cx="50"
                                cy="50"
                                r="42"
                                fill="none"
                                stroke="url(#ringGradient)"
                                stroke-width="9"
                                stroke-linecap="round"
                                stroke-dasharray="263.9"
                                stroke-dashoffset="{{ 263.9 - (263.9 * $approvalRate / 100) }}"
                                style="transition: stroke-dashoffset 1s ease .3s;"
                            />

                            <defs>

                                <linearGradient
                                    id="ringGradient"
                                    x1="0%"
                                    y1="0%"
                                    x2="100%"
                                    y2="100%"
                                >

                                    <stop
                                        offset="0%"
                                        stop-color="#EF5843"
                                    />

                                    <stop
                                        offset="100%"
                                        stop-color="#F7AA35"
                                    />

                                </linearGradient>

                            </defs>

                        </svg>


                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center"
                        >

                            <span class="text-xl font-extrabold">
                                {{ $approvalRate }}%
                            </span>

                            <span class="text-[10px] text-slate-400">
                                approved
                            </span>

                        </div>

                    </div>

                </div>


                <div class="flex-1">

                    <div class="flex items-center gap-2">

                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EF5843]"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                            </svg>

                        </span>


                        <h2 class="text-lg font-bold">
                            Perlu Direview
                        </h2>

                    </div>


                    <p class="mt-2 max-w-lg text-sm leading-6 text-slate-300">
                        Ada
                        <strong class="text-white">
                            {{ $pendingPosts }}
                        </strong>
                        artikel yang menunggu keputusan admin sebelum dapat ditampilkan kepada publik.
                    </p>


                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="mt-4 inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-[#241B52] transition hover:-translate-y-0.5 hover:shadow-lg"
                    >

                        Buka Review

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />

                        </svg>

                    </a>

                </div>

            </div>

        </div>



        {{-- WEBSITE CONTENT --}}

        <div
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
        >

            <div class="mb-5">

                <h2 class="text-lg font-bold text-slate-900">
                    Konten Website
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Akses cepat pengelolaan konten.
                </p>

            </div>


            <div class="space-y-2">

                @php

                    $contentLinks = [

                        [
                            'route' => 'admin.informations.index',
                            'label' => 'Informasi',
                            'count' => $totalInformations,
                            'color' => 'blue',
                            'icon' => '<circle cx="12" cy="12" r="9" /><path stroke-linecap="round" d="M12 11v5M12 8h.01" />'
                        ],

                        [
                            'route' => 'admin.journals.index',
                            'label' => 'Jurnal',
                            'count' => $totalJournals,
                            'color' => 'purple',
                            'icon' => '<path stroke-linecap="round" d="M6 4h12M6 8h12M6 12h8M6 16h8M6 20h12" />'
                        ],

                        [
                            'route' => 'admin.events.index',
                            'label' => 'Event',
                            'count' => $totalEvents,
                            'color' => 'amber',
                            'icon' => '<rect x="4" y="5" width="16" height="15" rx="2" /><path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16" />'
                        ],

                        [
                            'route' => 'admin.books.index',
                            'label' => 'Buku',
                            'count' => $totalBooks,
                            'color' => 'emerald',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 4h11a3 3 0 013 3v13H8a3 3 0 01-3-3V4z" /><path stroke-linecap="round" d="M8 4v16" />'
                        ],

                    ];

                @endphp


                @foreach($contentLinks as $link)

                    <a
                        href="{{ route($link['route']) }}"
                        class="side-nudge group flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-orange-200 hover:bg-orange-50"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-{{ $link['color'] }}-50 text-{{ $link['color'] }}-600"
                            >

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    {!! $link['icon'] !!}
                                </svg>

                            </div>


                            <div>

                                <p class="text-sm font-bold text-slate-800">
                                    {{ $link['label'] }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    {{ $link['count'] }} data
                                </p>

                            </div>

                        </div>


                        <svg
                            class="side-nudge-arrow h-4 w-4 text-slate-400 group-hover:text-orange-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />

                        </svg>

                    </a>

                @endforeach


            </div>

        </div>

    </section>



    {{-- =========================================================
         QUICK ACCESS
    ========================================================== --}}

    <section class="rise rise-4">

        <div class="mb-4">

            <h2 class="text-lg font-bold text-slate-900">
                Quick Access
            </h2>

            <p class="text-sm text-slate-500">
                Shortcut untuk pekerjaan admin sehari-hari.
            </p>

        </div>


        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7">


            @php

                $quickLinks = [

                    [
                        'route' => 'admin.posts.index',
                        'label' => 'Artikel',
                        'desc' => 'Review blog',
                        'accent' => true,
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" /><path stroke-linecap="round" d="M8 7h8M8 11h8M8 15h5" />'
                    ],

                    [
                        'route' => 'admin.communities.index',
                        'label' => 'Komunitas',
                        'desc' => 'Kelola komunitas',
                        'color' => 'orange',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />'
                    ],

                    [
                        'route' => 'admin.informations.index',
                        'label' => 'Informasi',
                        'desc' => 'Kelola informasi',
                        'color' => 'blue',
                        'icon' => '<circle cx="12" cy="12" r="9" /><path stroke-linecap="round" d="M12 11v5M12 8h.01" />'
                    ],

                    [
                        'route' => 'admin.journals.index',
                        'label' => 'Jurnal',
                        'desc' => 'Kelola jurnal',
                        'color' => 'purple',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 4h12M6 8h12M6 12h8M6 16h8M6 20h12" />'
                    ],

                    [
                        'route' => 'admin.events.index',
                        'label' => 'Event',
                        'desc' => 'Kelola event',
                        'color' => 'amber',
                        'icon' => '<rect x="4" y="5" width="16" height="15" rx="2" /><path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16" />'
                    ],

                    [
                        'route' => 'admin.conferences.index',
                        'label' => 'Konferensi',
                        'desc' => 'Kelola konferensi',
                        'color' => 'pink',
                        'icon' => '<circle cx="12" cy="12" r="8" /><circle cx="12" cy="12" r="3" />'
                    ],

                    [
                        'route' => 'admin.books.index',
                        'label' => 'Buku',
                        'desc' => 'Kelola bookstore',
                        'color' => 'emerald',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 4h11a3 3 0 013 3v13H8a3 3 0 01-3-3V4z" /><path stroke-linecap="round" d="M8 4v16" />'
                    ],

                ];

            @endphp


            @foreach($quickLinks as $q)

                <a
                    href="{{ route($q['route']) }}"
                    class="quick-tile rounded-2xl border {{ !empty($q['accent']) ? 'border-orange-200 bg-orange-50' : 'border-slate-200 bg-white' }} p-4"
                >

                    <div
                        class="quick-icon flex h-10 w-10 items-center justify-center rounded-xl {{ !empty($q['accent']) ? 'bg-[#EF5843] text-white' : 'bg-'.$q['color'].'-50 text-'.$q['color'].'-600' }}"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >

                            {!! $q['icon'] !!}

                        </svg>

                    </div>


                    <p class="mt-3 text-sm font-bold text-slate-900">
                        {{ $q['label'] }}
                    </p>


                    <p class="mt-1 text-xs text-slate-500">
                        {{ $q['desc'] }}
                    </p>

                </a>

            @endforeach

        </div>

    </section>



    {{-- =========================================================
         FOOTER NOTE
    ========================================================== --}}

    <div
        class="rise rise-5 flex flex-col gap-2 border-t border-slate-200 pt-6 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between"
    >

        <p>
            Baca Dulu Admin CMS
        </p>

        <p>
            Kelola dengan rapi. Publikasikan dengan percaya diri.
        </p>

    </div>


</div>



<script>

    // Animasi angka naik dari 0 ke nilai aslinya

    document.querySelectorAll('.count-up').forEach(function (el) {

        const target =
            parseInt(el.getAttribute('data-count'), 10) || 0;

        const duration = 900;

        const start = performance.now();


        function tick(now) {

            const progress =
                Math.min((now - start) / duration, 1);

            const eased =
                1 - Math.pow(1 - progress, 3);

            el.textContent =
                Math.round(eased * target);


            if (progress < 1) {
                requestAnimationFrame(tick);
            }

        }


        requestAnimationFrame(tick);

    });

</script>

@endsection