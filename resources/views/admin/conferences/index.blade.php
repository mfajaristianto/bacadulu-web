@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6">

        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2">
                    <span class="h-[3px] w-7 rounded-full bg-orange-500"></span>

                    <span class="text-[10px] font-bold uppercase tracking-[.14em] text-orange-600">
                        Katalog Baca
                    </span>
                </div>

                <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">
                    Kelola Conference
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Kelola nama, edisi, deskripsi, poster, dan tautan conference.
                </p>
            </div>

            <a
                href="{{ route('admin.conferences.create') }}"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-orange-600 px-5 text-sm font-extrabold text-white shadow-sm transition hover:bg-orange-700"
            >
                <svg
                    viewBox="0 0 24 24"
                    class="h-4 w-4 fill-none stroke-current"
                    stroke-width="2"
                >
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>

                Tambah Conference
            </a>
        </div>


        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif


        @if($conferences->isEmpty())

            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <h2 class="text-base font-extrabold text-slate-800">
                    Belum ada conference
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    Tambahkan conference pertama untuk ditampilkan pada katalog.
                </p>
            </div>

        @else

            <div class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:block">

                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-sm font-extrabold text-slate-800">
                        Daftar Conference
                    </h2>

                    <p class="mt-1 text-[11px] text-slate-400">
                        Poster yang tampil di sini adalah poster yang digunakan pada halaman publik.
                    </p>
                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-slate-50">
                            <tr>
                                <th class="w-[105px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Poster
                                </th>

                                <th class="min-w-[190px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Conference
                                </th>

                                <th class="min-w-[280px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Deskripsi
                                </th>

                                <th class="min-w-[170px] px-5 py-3 text-left text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Tautan
                                </th>

                                <th class="w-[150px] px-5 py-3 text-right text-[10px] font-extrabold uppercase tracking-[.08em] text-slate-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @foreach($conferences as $conference)

                                <tr class="transition hover:bg-slate-50/80">

                                    {{-- POSTER --}}
                                    <td class="px-5 py-4 align-middle">

                                        @if($conference->poster)

                                            <a
                                                href="{{ asset('storage/' . $conference->poster) }}"
                                                target="_blank"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $conference->poster) }}"
                                                    alt="{{ $conference->name }}"
                                                    class="h-[90px] w-[68px] rounded-md border border-slate-200 bg-white object-contain shadow-sm"
                                                >
                                            </a>

                                        @else

                                            <div class="flex h-[90px] w-[68px] items-center justify-center rounded-md border border-dashed border-slate-300 bg-slate-50 px-2 text-center text-[8px] font-bold text-slate-400">
                                                Belum ada poster
                                            </div>

                                        @endif

                                    </td>


                                    {{-- CONFERENCE --}}
                                    <td class="px-5 py-4 align-middle">

                                        <p class="text-sm font-extrabold text-[#241B52]">
                                            {{ $conference->name ?: 'Conference' }}
                                            {{ $conference->edition }}
                                        </p>

                                        @if($conference->poster)
                                            <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-bold text-emerald-600">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Poster tersedia
                                            </span>
                                        @else
                                            <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-[9px] font-bold text-amber-600">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                Poster kosong
                                            </span>
                                        @endif

                                    </td>


                                    {{-- DESCRIPTION --}}
                                    <td class="px-5 py-4 align-middle">

                                        <p class="max-w-[330px] text-xs leading-relaxed text-slate-500">
                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    trim(
                                                        strip_tags(
                                                            $conference->description ?? ''
                                                        )
                                                    ),
                                                    130
                                                )
                                                ?: 'Deskripsi belum tersedia.'
                                            }}
                                        </p>

                                    </td>


                                    {{-- LINKS --}}
                                    <td class="px-5 py-4 align-middle">

                                        <div class="flex flex-col items-start gap-2">

                                            @if($conference->conference_url)
                                                <a
                                                    href="{{ $conference->conference_url }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="rounded-lg bg-[#FFF7EF] px-3 py-2 text-[10px] font-bold text-[#241B52] transition hover:bg-[#FFF0E7]"
                                                >
                                                    Lihat Conference ↗
                                                </a>
                                            @else
                                                <span class="text-[10px] text-slate-400">
                                                    URL conference kosong
                                                </span>
                                            @endif


                                            @if($conference->proceeding_url)
                                                <a
                                                    href="{{ $conference->proceeding_url }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="rounded-lg bg-[#FFF4D9] px-3 py-2 text-[10px] font-bold text-[#241B52] transition hover:bg-[#FBE7B6]"
                                                >
                                                    Lihat Prosiding ↗
                                                </a>
                                            @else
                                                <span class="text-[10px] text-slate-400">
                                                    URL prosiding kosong
                                                </span>
                                            @endif

                                        </div>

                                    </td>


                                    {{-- ACTION --}}
                                    <td class="px-5 py-4 align-middle">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('admin.conferences.edit', $conference) }}"
                                                class="inline-flex min-h-9 items-center justify-center rounded-lg bg-[#F3F0FA] px-3 text-[10px] font-extrabold text-[#241B52] transition hover:bg-[#EAE5F5]"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                action="{{ route('admin.conferences.destroy', $conference) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Hapus conference ini?')"
                                                    class="min-h-9 rounded-lg bg-red-50 px-3 text-[10px] font-extrabold text-red-600 transition hover:bg-red-100"
                                                >
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


            {{-- MOBILE --}}
            <div class="grid grid-cols-1 gap-4 lg:hidden">

                @foreach($conferences as $conference)

                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="flex gap-4 p-4">

                            @if($conference->poster)

                                <img
                                    src="{{ asset('storage/' . $conference->poster) }}"
                                    alt="{{ $conference->name }}"
                                    class="h-[112px] w-[82px] shrink-0 rounded-lg border border-slate-200 object-contain shadow-sm"
                                >

                            @else

                                <div class="flex h-[112px] w-[82px] shrink-0 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 px-2 text-center text-[8px] font-bold text-slate-400">
                                    Belum ada poster
                                </div>

                            @endif


                            <div class="min-w-0 flex-1">

                                <h2 class="text-sm font-extrabold text-[#241B52]">
                                    {{ $conference->name }}
                                    {{ $conference->edition }}
                                </h2>

                                <p class="mt-3 text-[11px] leading-relaxed text-slate-500">
                                    {{
                                        \Illuminate\Support\Str::limit(
                                            trim(strip_tags($conference->description ?? '')),
                                            120
                                        )
                                        ?: 'Deskripsi belum tersedia.'
                                    }}
                                </p>

                            </div>

                        </div>


                        <div class="grid grid-cols-2 gap-2 border-t border-slate-100 p-3">

                            @if($conference->conference_url)
                                <a
                                    href="{{ $conference->conference_url }}"
                                    target="_blank"
                                    class="flex min-h-9 items-center justify-center rounded-lg bg-[#FFF7EF] text-[10px] font-bold text-[#241B52]"
                                >
                                    Conference ↗
                                </a>
                            @else
                                <span class="flex min-h-9 items-center justify-center rounded-lg bg-slate-100 text-[10px] font-bold text-slate-400">
                                    URL kosong
                                </span>
                            @endif


                            @if($conference->proceeding_url)
                                <a
                                    href="{{ $conference->proceeding_url }}"
                                    target="_blank"
                                    class="flex min-h-9 items-center justify-center rounded-lg bg-[#F7AA35] text-[10px] font-bold text-[#241B52]"
                                >
                                    Prosiding ↗
                                </a>
                            @else
                                <span class="flex min-h-9 items-center justify-center rounded-lg bg-slate-100 text-[10px] font-bold text-slate-400">
                                    Prosiding kosong
                                </span>
                            @endif

                        </div>


                        <div class="flex gap-2 border-t border-slate-100 bg-slate-50 p-3">

                            <a
                                href="{{ route('admin.conferences.edit', $conference) }}"
                                class="flex min-h-9 flex-1 items-center justify-center rounded-lg bg-[#241B52] text-[10px] font-extrabold text-white"
                            >
                                Edit
                            </a>


                            <form
                                action="{{ route('admin.conferences.destroy', $conference) }}"
                                method="POST"
                                class="flex-1"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Hapus conference ini?')"
                                    class="min-h-9 w-full rounded-lg bg-red-50 text-[10px] font-extrabold text-red-600"
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