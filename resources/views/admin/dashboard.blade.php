@extends('layouts.admin')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA DASHBOARD
    |--------------------------------------------------------------------------
    |
    | Gunakan fallback 0 supaya dashboard tetap aman apabila controller
    | belum mengirim semua statistik.
    |
    */

    $totalPosts = $stats['posts'] ?? 0;
    $pendingPosts = $stats['pending_posts'] ?? 0;
    $approvedPosts = $stats['approved_posts'] ?? 0;
    $rejectedPosts = $stats['rejected_posts'] ?? 0;

    $totalInformations = $stats['informations'] ?? 0;
    $totalJournals = $stats['journals'] ?? 0;
    $totalEvents = $stats['events'] ?? 0;
    $totalBooks = $stats['books'] ?? 0;
@endphp


<div class="space-y-8">


    {{-- =========================================================
         HERO / WELCOME
    ========================================================== --}}
    <section
        class="relative overflow-hidden rounded-3xl bg-[#170F38] px-6 py-8 text-white shadow-xl lg:px-10 lg:py-10"
    >

        {{-- Decorative circles --}}
        <div
            class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-[#EF5843]/20 blur-2xl"
        ></div>

        <div
            class="absolute -bottom-32 right-32 h-72 w-72 rounded-full bg-[#F7AA35]/10 blur-3xl"
        ></div>

        <div
            class="absolute right-10 top-10 h-32 w-32 rounded-full border border-white/10"
        ></div>

        <div
            class="absolute right-20 top-20 h-16 w-16 rounded-full border border-white/10"
        ></div>


        <div class="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

            <div class="max-w-2xl">

                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-slate-300">

                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                    Sistem Admin Aktif

                </div>


                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">

                    Selamat datang kembali, Admin 👋

                </h1>


                <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">

                    Pantau konten, kelola artikel, dan pastikan seluruh
                    publikasi Baca Dulu berjalan dengan baik.

                </p>

            </div>


            {{-- Quick Action --}}
            <div class="shrink-0">

                <a
                    href="{{ route('admin.posts.index') }}"
                    class="group inline-flex items-center gap-3 rounded-xl bg-white px-5 py-3.5 text-sm font-bold text-[#170F38] shadow-lg transition hover:-translate-y-0.5 hover:bg-orange-50"
                >

                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EF5843] text-white"
                    >
                        +
                    </span>

                    Review Artikel

                    <span class="transition group-hover:translate-x-1">
                        →
                    </span>

                </a>

            </div>

        </div>

    </section>



    {{-- =========================================================
         STATISTICS
    ========================================================== --}}
    <section>

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
            <div
                class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Artikel
                        </p>

                        <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">
                            {{ $totalPosts }}
                        </p>

                    </div>


                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-[#EF5843]"
                    >
                        {{-- Document icon --}}
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
                    class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-[#EF5843] hover:text-[#C6432F]"
                >
                    Lihat semua
                    <span>→</span>
                </a>

            </div>



            {{-- PENDING --}}
            <div
                class="group rounded-2xl border border-orange-200 bg-gradient-to-br from-orange-50 to-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-orange-700">
                            Menunggu Review
                        </p>

                        <p class="mt-2 text-3xl font-extrabold tracking-tight text-orange-700">
                            {{ $pendingPosts }}
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
                            <circle cx="12" cy="12" r="9" />
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
                        class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-orange-700 hover:text-orange-900"
                    >
                        Review sekarang
                        <span>→</span>
                    </a>

                @else

                    <p class="mt-4 text-xs font-medium text-emerald-600">
                        ✓ Tidak ada artikel yang menunggu
                    </p>

                @endif

            </div>



            {{-- APPROVED --}}
            <div
                class="group rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-emerald-700">
                            Artikel Approved
                        </p>

                        <p class="mt-2 text-3xl font-extrabold tracking-tight text-emerald-700">
                            {{ $approvedPosts }}
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
                                stroke-linecap="round"
                                stroke-linejoin="round"
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
                class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Artikel Ditolak
                        </p>

                        <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">
                            {{ $rejectedPosts }}
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
                            <circle cx="12" cy="12" r="9" />
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
    <section class="grid gap-6 xl:grid-cols-3">


        {{-- =====================================================
             REVIEW ARTIKEL
        ====================================================== --}}
        <div
            class="relative overflow-hidden rounded-2xl bg-[#241B52] p-6 text-white shadow-lg xl:col-span-2"
        >

            <div
                class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-[#EF5843]/20 blur-2xl"
            ></div>


            <div class="relative">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <div class="flex items-center gap-2">

                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EF5843]">

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
                            artikel yang menunggu keputusan admin sebelum
                            dapat ditampilkan kepada publik.

                        </p>

                    </div>


                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-[#241B52] transition hover:bg-orange-50"
                    >

                        Buka Review

                        <span>
                            →
                        </span>

                    </a>

                </div>


                {{-- Progress visual --}}
                <div class="mt-7">

                    <div class="mb-2 flex items-center justify-between text-xs text-slate-400">

                        <span>
                            Status moderasi
                        </span>

                        <span>
                            {{ $totalPosts > 0 ? round(($approvedPosts / $totalPosts) * 100) : 0 }}% approved
                        </span>

                    </div>


                    <div class="h-2 overflow-hidden rounded-full bg-white/10">

                        <div
                            class="h-full rounded-full bg-gradient-to-r from-[#EF5843] to-[#F7AA35]"
                            style="width: {{ $totalPosts > 0 ? min(100, round(($approvedPosts / $totalPosts) * 100)) : 0 }}%"
                        ></div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
             WEBSITE CONTENT
        ====================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-5">

                <h2 class="text-lg font-bold text-slate-900">
                    Konten Website
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Akses cepat pengelolaan konten.
                </p>

            </div>


            <div class="space-y-3">


                {{-- Informasi --}}
                <a
                    href="{{ route('admin.informations.index') }}"
                    class="group flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-orange-200 hover:bg-orange-50"
                >

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9" />
                                <path
                                    stroke-linecap="round"
                                    d="M12 11v5M12 8h.01"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-bold text-slate-800">
                                Informasi
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ $totalInformations }} data
                            </p>

                        </div>

                    </div>


                    <span class="text-slate-400 transition group-hover:translate-x-1 group-hover:text-orange-600">
                        →
                    </span>

                </a>


                {{-- Jurnal --}}
                <a
                    href="{{ route('admin.journals.index') }}"
                    class="group flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-orange-200 hover:bg-orange-50"
                >

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 text-purple-600">

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
                                    d="M6 4h12M6 8h12M6 12h8M6 16h8M6 20h12"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-bold text-slate-800">
                                Jurnal
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ $totalJournals }} data
                            </p>

                        </div>

                    </div>


                    <span class="text-slate-400 transition group-hover:translate-x-1 group-hover:text-orange-600">
                        →
                    </span>

                </a>


                {{-- Event --}}
                <a
                    href="{{ route('admin.events.index') }}"
                    class="group flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-orange-200 hover:bg-orange-50"
                >

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600">

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
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

                        </div>

                        <div>

                            <p class="text-sm font-bold text-slate-800">
                                Event
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ $totalEvents }} data
                            </p>

                        </div>

                    </div>


                    <span class="text-slate-400 transition group-hover:translate-x-1 group-hover:text-orange-600">
                        →
                    </span>

                </a>


                {{-- Buku --}}
                <a
                    href="{{ route('admin.books.index') }}"
                    class="group flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-orange-200 hover:bg-orange-50"
                >

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">

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
                                    d="M5 4h11a3 3 0 013 3v13H8a3 3 0 01-3-3V4z"
                                />
                                <path
                                    stroke-linecap="round"
                                    d="M8 4v16"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-bold text-slate-800">
                                Buku
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ $totalBooks }} data
                            </p>

                        </div>

                    </div>


                    <span class="text-slate-400 transition group-hover:translate-x-1 group-hover:text-orange-600">
                        →
                    </span>

                </a>


            </div>

        </div>

    </section>



    {{-- =========================================================
         QUICK ACCESS
    ========================================================== --}}
    <section>

        <div class="mb-4">

            <h2 class="text-lg font-bold text-slate-900">
                Quick Access
            </h2>

            <p class="text-sm text-slate-500">
                Shortcut untuk pekerjaan admin sehari-hari.
            </p>

        </div>


        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">


            {{-- Blogging --}}
            <a
                href="{{ route('admin.posts.index') }}"
                class="group rounded-2xl border border-orange-200 bg-orange-50 p-4 transition hover:-translate-y-1 hover:bg-orange-100 hover:shadow-md"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EF5843] text-white">

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
                            d="M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"
                        />
                        <path
                            stroke-linecap="round"
                            d="M8 7h8M8 11h8M8 15h5"
                        />
                    </svg>

                </div>

                <p class="mt-3 text-sm font-bold text-slate-900">
                    Artikel
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Review blog
                </p>

            </a>


            {{-- Informasi --}}
            <a
                href="{{ route('admin.informations.index') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-4 transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-md"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <span class="text-lg font-bold">
                        i
                    </span>

                </div>

                <p class="mt-3 text-sm font-bold text-slate-900">
                    Informasi
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Kelola informasi
                </p>

            </a>


            {{-- Jurnal --}}
            <a
                href="{{ route('admin.journals.index') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-4 transition hover:-translate-y-1 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">

                    <span class="text-lg">
                        ◈
                    </span>

                </div>

                <p class="mt-3 text-sm font-bold text-slate-900">
                    Jurnal
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Kelola jurnal
                </p>

            </a>


            {{-- Event --}}
            <a
                href="{{ route('admin.events.index') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-4 transition hover:-translate-y-1 hover:border-amber-200 hover:shadow-md"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                    <span class="text-lg">
                        ◷
                    </span>

                </div>

                <p class="mt-3 text-sm font-bold text-slate-900">
                    Event
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Kelola event
                </p>

            </a>


            {{-- Konferensi --}}
            <a
                href="{{ route('admin.conferences.index') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-4 transition hover:-translate-y-1 hover:border-pink-200 hover:shadow-md"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-50 text-pink-600">

                    <span class="text-lg">
                        ◉
                    </span>

                </div>

                <p class="mt-3 text-sm font-bold text-slate-900">
                    Konferensi
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Kelola konferensi
                </p>

            </a>


            {{-- Buku --}}
            <a
                href="{{ route('admin.books.index') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-4 transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <span class="text-lg">
                        ▣
                    </span>

                </div>

                <p class="mt-3 text-sm font-bold text-slate-900">
                    Buku
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Kelola bookstore
                </p>

            </a>


        </div>

    </section>



    {{-- =========================================================
         FOOTER NOTE
    ========================================================== --}}
    <div
        class="flex flex-col gap-2 border-t border-slate-200 pt-6 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between"
    >

        <p>
            Baca Dulu Admin CMS
        </p>

        <p>
            Kelola dengan rapi. Publikasikan dengan percaya diri.
        </p>

    </div>


</div>

@endsection