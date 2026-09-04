@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-2 flex items-center gap-2">

                    <span class="h-[3px] w-7 rounded-full bg-orange-500"></span>

                    <span class="text-[10px] font-bold uppercase tracking-[.14em] text-orange-600">
                        Katalog Baca
                    </span>

                </div>

                <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">
                    Kelola Jurnal
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                    Kelola jurnal, cover, ISSN, deskripsi, dan tautan website yang tampil pada halaman Baca Jurnal.
                </p>

            </div>


            <a
                href="{{ route('admin.journals.create') }}"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-orange-600 px-5 text-sm font-extrabold text-white shadow-sm transition hover:bg-orange-700"
            >

                <svg
                    viewBox="0 0 24 24"
                    class="h-4 w-4 fill-none stroke-current"
                    stroke-width="2"
                    stroke-linecap="round"
                >
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>

                Tambah Jurnal

            </a>

        </div>


        {{-- =====================================================
             SUCCESS
        ====================================================== --}}
        @if(session('success'))

            <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">

                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4 fill-none stroke-current"
                        stroke-width="2.2"
                    >
                        <path d="M5 12l4 4L19 6"/>
                    </svg>

                </div>

                <div>

                    <p class="text-sm font-bold text-emerald-700">
                        Berhasil
                    </p>

                    <p class="mt-1 text-xs text-emerald-600">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        {{-- =====================================================
             SUMMARY
        ====================================================== --}}
        <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <p class="text-[10px] font-bold uppercase tracking-[.1em] text-slate-400">
                    Total Jurnal
                </p>

                <p class="mt-2 text-2xl font-extrabold text-[#241B52]">
                    {{ $jurnals->count() }}
                </p>

            </div>


            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <p class="text-[10px] font-bold uppercase tracking-[.1em] text-slate-400">
                    Ada Cover
                </p>

                <p class="mt-2 text-2xl font-extrabold text-[#241B52]">
                    {{ $jurnals->whereNotNull('gambar')->count() }}
                </p>

            </div>


            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <p class="text-[10px] font-bold uppercase tracking-[.1em] text-slate-400">
                    URL Jurnal
                </p>

                <p class="mt-2 text-2xl font-extrabold text-[#241B52]">
                    {{ $jurnals->whereNotNull('journal_url')->count() }}
                </p>

            </div>


            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <p class="text-[10px] font-bold uppercase tracking-[.1em] text-slate-400">
                    Edisi Terkini
                </p>

                <p class="mt-2 text-2xl font-extrabold text-[#241B52]">
                    {{ $jurnals->whereNotNull('current_issue_url')->count() }}
                </p>

            </div>

        </div>


        {{-- =====================================================
             EMPTY
        ====================================================== --}}
        @if($jurnals->isEmpty())

            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-50 text-orange-500">

                    <svg
                        viewBox="0 0 24 24"
                        class="h-6 w-6 fill-none stroke-current"
                        stroke-width="1.7"
                    >
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>

                </div>

                <h2 class="mt-4 text-base font-extrabold text-slate-800">
                    Belum ada jurnal
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-500">
                    Tambahkan jurnal pertama agar dapat ditampilkan pada halaman Baca Jurnal.
                </p>

                <a
                    href="{{ route('admin.journals.create') }}"
                    class="mt-5 inline-flex min-h-10 items-center justify-center rounded-lg bg-orange-600 px-4 text-sm font-bold text-white hover:bg-orange-700"
                >
                    Tambah Jurnal
                </a>

            </div>

        @else


            {{-- =====================================================
                 DESKTOP TABLE
            ====================================================== --}}
            <div class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:block">

                <div class="border-b border-slate-200 px-5 py-4">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <h2 class="text-sm font-extrabold text-slate-800">
                                Daftar Jurnal
                            </h2>

                            <p class="mt-1 text-[11px] text-slate-400">
                                Cover yang tampil di sini adalah cover yang digunakan pada halaman publik.
                            </p>

                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-bold text-slate-500">
                            {{ $jurnals->count() }} jurnal
                        </span>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="w-[105px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Cover
                                </th>

                                <th class="min-w-[240px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Jurnal
                                </th>

                                <th class="min-w-[170px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    ISSN
                                </th>

                                <th class="min-w-[150px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Website
                                </th>

                                <th class="min-w-[190px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Deskripsi
                                </th>

                                <th class="w-[150px] px-5 py-3 text-right text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @foreach($jurnals as $jurnal)

                                <tr class="transition hover:bg-slate-50/80">


                                    {{-- =================================================
                                         COVER
                                    ================================================== --}}
                                    <td class="px-5 py-4 align-middle">

                                        @if($jurnal->gambar)

                                            <a
                                                href="{{ asset('storage/' . $jurnal->gambar) }}"
                                                target="_blank"
                                                class="group relative block w-fit"
                                                title="Buka cover asli"
                                            >

                                                <img
                                                    src="{{ asset('storage/' . $jurnal->gambar) }}"
                                                    alt="{{ $jurnal->judul }}"
                                                    class="h-[86px] w-[64px] rounded-md border border-slate-200 bg-white object-cover shadow-sm transition group-hover:scale-[1.03]"
                                                >

                                                <span class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-[#241B52] text-white shadow-sm">

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        class="h-2.5 w-2.5 fill-none stroke-current"
                                                        stroke-width="2"
                                                    >
                                                        <path d="M7 17L17 7"/>
                                                        <path d="M8 7h9v9"/>
                                                    </svg>

                                                </span>

                                            </a>

                                        @else

                                            <div class="flex h-[86px] w-[64px] flex-col items-center justify-center rounded-md border border-dashed border-slate-300 bg-slate-50 px-2 text-center">

                                                <svg
                                                    viewBox="0 0 24 24"
                                                    class="mb-1 h-4 w-4 fill-none stroke-slate-400"
                                                    stroke-width="1.6"
                                                >
                                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                    <path d="m3 16 5-5 4 4 3-3 6 6"/>
                                                </svg>

                                                <span class="text-[8px] font-bold leading-tight text-slate-400">
                                                    Belum ada cover
                                                </span>

                                            </div>

                                        @endif

                                    </td>


                                    {{-- =================================================
                                         JURNAL
                                    ================================================== --}}
                                    <td class="px-5 py-4 align-middle">

                                        <p class="max-w-[280px] text-sm font-extrabold leading-snug text-slate-800">
                                            {{ $jurnal->judul }}
                                        </p>

                                        <div class="mt-2 flex flex-wrap gap-2">

                                            @if($jurnal->gambar)

                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-bold text-emerald-600">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                                    Cover tersedia

                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-[9px] font-bold text-amber-600">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                                    Cover kosong

                                                </span>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- =================================================
                                         ISSN
                                    ================================================== --}}
                                    <td class="px-5 py-4 align-middle">

                                        <div class="space-y-2">

                                            <div>

                                                <span class="text-[9px] font-bold uppercase tracking-[.08em] text-slate-400">
                                                    E-ISSN
                                                </span>

                                                <p class="mt-0.5 text-xs font-bold text-[#241B52]">
                                                    {{ $jurnal->e_issn ?: '-' }}
                                                </p>

                                            </div>


                                            <div>

                                                <span class="text-[9px] font-bold uppercase tracking-[.08em] text-slate-400">
                                                    P-ISSN
                                                </span>

                                                <p class="mt-0.5 text-xs font-bold text-[#241B52]">
                                                    {{ $jurnal->p_issn ?: '-' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- =================================================
                                         WEBSITE
                                    ================================================== --}}
                                    <td class="px-5 py-4 align-middle">

                                        <div class="space-y-2">

                                            @if($jurnal->journal_url)

                                                <a
                                                    href="{{ $jurnal->journal_url }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#FFF7EF] px-2.5 py-1.5 text-[10px] font-bold text-[#241B52] transition hover:bg-[#FFF0E7]"
                                                >

                                                    Lihat Jurnal

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        class="h-3 w-3 fill-none stroke-current"
                                                        stroke-width="2"
                                                    >
                                                        <path d="M7 17L17 7"/>
                                                        <path d="M8 7h9v9"/>
                                                    </svg>

                                                </a>

                                            @else

                                                <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1.5 text-[10px] font-bold text-slate-400">
                                                    URL jurnal kosong
                                                </span>

                                            @endif


                                            @if($jurnal->current_issue_url)

                                                <a
                                                    href="{{ $jurnal->current_issue_url }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#FFF4D9] px-2.5 py-1.5 text-[10px] font-bold text-[#241B52] transition hover:bg-[#FBE7B6]"
                                                >

                                                    Edisi Terkini

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        class="h-3 w-3 fill-none stroke-current"
                                                        stroke-width="2"
                                                    >
                                                        <path d="M5 12h14"/>
                                                        <path d="m14 7 5 5-5 5"/>
                                                    </svg>

                                                </a>

                                            @else

                                                <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1.5 text-[10px] font-bold text-slate-400">
                                                    Edisi kosong
                                                </span>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- =================================================
                                         DESCRIPTION
                                    ================================================== --}}
                                    <td class="px-5 py-4 align-middle">

                                        <p class="max-w-[240px] text-xs leading-relaxed text-slate-500">

                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    trim(
                                                        strip_tags(
                                                            $jurnal->deskripsi ?? ''
                                                        )
                                                    ),
                                                    100
                                                )
                                                ?: 'Deskripsi belum tersedia.'
                                            }}

                                        </p>

                                    </td>


                                    {{-- =================================================
                                         ACTION
                                    ================================================== --}}
                                    <td class="px-5 py-4 align-middle">

                                        <div class="flex items-center justify-end gap-2">

                                            <a
                                                href="{{ route('admin.journals.edit', $jurnal) }}"
                                                class="inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg bg-[#F3F0FA] px-3 text-[10px] font-extrabold text-[#241B52] transition hover:bg-[#EAE5F5]"
                                            >

                                                <svg
                                                    viewBox="0 0 24 24"
                                                    class="h-3.5 w-3.5 fill-none stroke-current"
                                                    stroke-width="1.8"
                                                >
                                                    <path d="M12 20h9"/>
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                                </svg>

                                                Edit

                                            </a>


                                            <form
                                                action="{{ route('admin.journals.destroy', $jurnal) }}"
                                                method="POST"
                                                class="inline"
                                            >

                                                @csrf
                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg bg-red-50 px-3 text-[10px] font-extrabold text-red-600 transition hover:bg-red-100"
                                                    onclick="return confirm('Hapus jurnal {{ addslashes($jurnal->judul) }}? Data yang dihapus tidak dapat dikembalikan.')"
                                                >

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        class="h-3.5 w-3.5 fill-none stroke-current"
                                                        stroke-width="1.8"
                                                    >
                                                        <path d="M3 6h18"/>
                                                        <path d="M8 6V4h8v2"/>
                                                        <path d="M19 6l-1 14H6L5 6"/>
                                                        <path d="M10 11v5"/>
                                                        <path d="M14 11v5"/>
                                                    </svg>

                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =====================================================
                 MOBILE / TABLET CARDS
            ====================================================== --}}
            <div class="grid grid-cols-1 gap-4 lg:hidden">

                @foreach($jurnals as $jurnal)

                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="flex gap-4 p-4">

                            {{-- COVER --}}
                            <div class="shrink-0">

                                @if($jurnal->gambar)

                                    <a
                                        href="{{ asset('storage/' . $jurnal->gambar) }}"
                                        target="_blank"
                                    >

                                        <img
                                            src="{{ asset('storage/' . $jurnal->gambar) }}"
                                            alt="{{ $jurnal->judul }}"
                                            class="h-[112px] w-[82px] rounded-lg border border-slate-200 object-cover shadow-sm"
                                        >

                                    </a>

                                @else

                                    <div class="flex h-[112px] w-[82px] flex-col items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 px-2 text-center">

                                        <svg
                                            viewBox="0 0 24 24"
                                            class="mb-2 h-5 w-5 fill-none stroke-slate-400"
                                            stroke-width="1.6"
                                        >
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <path d="m3 16 5-5 4 4 3-3 6 6"/>
                                        </svg>

                                        <span class="text-[8px] font-bold leading-tight text-slate-400">
                                            Belum ada cover
                                        </span>

                                    </div>

                                @endif

                            </div>


                            {{-- INFO --}}
                            <div class="min-w-0 flex-1">

                                <h2 class="text-sm font-extrabold leading-snug text-slate-800">
                                    {{ $jurnal->judul }}
                                </h2>


                                <div class="mt-3 flex flex-wrap gap-2">

                                    <span class="rounded-md bg-slate-100 px-2 py-1 text-[9px] font-bold text-slate-500">
                                        E-ISSN {{ $jurnal->e_issn ?: '-' }}
                                    </span>

                                    <span class="rounded-md bg-slate-100 px-2 py-1 text-[9px] font-bold text-slate-500">
                                        P-ISSN {{ $jurnal->p_issn ?: '-' }}
                                    </span>

                                </div>


                                <p class="mt-3 text-[11px] leading-relaxed text-slate-500">

                                    {{
                                        \Illuminate\Support\Str::limit(
                                            trim(
                                                strip_tags(
                                                    $jurnal->deskripsi ?? ''
                                                )
                                            ),
                                            100
                                        )
                                        ?: 'Deskripsi belum tersedia.'
                                    }}

                                </p>

                            </div>

                        </div>


                        {{-- LINKS --}}
                        <div class="grid grid-cols-2 gap-2 border-t border-slate-100 px-4 py-3">

                            @if($jurnal->journal_url)

                                <a
                                    href="{{ $jurnal->journal_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex min-h-9 items-center justify-center rounded-lg bg-[#FFF7EF] px-2 text-[10px] font-bold text-[#241B52]"
                                >
                                    Lihat Jurnal ↗
                                </a>

                            @else

                                <span class="flex min-h-9 items-center justify-center rounded-lg bg-slate-100 px-2 text-[10px] font-bold text-slate-400">
                                    URL kosong
                                </span>

                            @endif


                            @if($jurnal->current_issue_url)

                                <a
                                    href="{{ $jurnal->current_issue_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex min-h-9 items-center justify-center rounded-lg bg-[#F7AA35] px-2 text-[10px] font-bold text-[#241B52]"
                                >
                                    Edisi Terkini ↗
                                </a>

                            @else

                                <span class="flex min-h-9 items-center justify-center rounded-lg bg-slate-100 px-2 text-[10px] font-bold text-slate-400">
                                    Edisi kosong
                                </span>

                            @endif

                        </div>


                        {{-- ACTION --}}
                        <div class="flex gap-2 border-t border-slate-100 bg-slate-50 px-4 py-3">

                            <a
                                href="{{ route('admin.journals.edit', $jurnal) }}"
                                class="flex min-h-9 flex-1 items-center justify-center rounded-lg bg-[#241B52] px-3 text-[10px] font-extrabold text-white"
                            >
                                Edit Jurnal
                            </a>


                            <form
                                action="{{ route('admin.journals.destroy', $jurnal) }}"
                                method="POST"
                                class="flex-1"
                            >

                                @csrf
                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="min-h-9 w-full rounded-lg bg-red-50 px-3 text-[10px] font-extrabold text-red-600"
                                    onclick="return confirm('Hapus jurnal {{ addslashes($jurnal->judul) }}? Data yang dihapus tidak dapat dikembalikan.')"
                                >
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</div>

@endsection