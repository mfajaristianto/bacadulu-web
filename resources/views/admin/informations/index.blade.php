@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-wider text-orange-600">
                Baca Informasi
            </p>

            <h1 class="text-3xl font-bold text-slate-900">
                Kelola Informasi
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola informasi website dan tentukan informasi yang ingin diprioritaskan.
            </p>
        </div>


        <a
            href="{{ route('admin.informations.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
        >
            + Tambah Informasi
        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Error --}}
    @if(session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- Information Note --}}
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-orange-200 bg-orange-50/60 p-4">

        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-orange-100 text-orange-600">
            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M14 4l6 6-3 1-4 4-1 5-3-3-4 4-2-2 4-4-3-3 5-1 4-4z"/>
            </svg>
        </span>

        <div>
            <strong class="block text-sm text-slate-800">
                Informasi Pilihan
            </strong>

            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                Hanya satu informasi yang dapat dipin. Jika informasi baru
                dipin, informasi pilihan sebelumnya otomatis dilepas.
            </p>
        </div>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">
                            Informasi
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-slate-700">
                            Konten
                        </th>

                        <th class="px-4 py-3 text-center font-semibold text-slate-700">
                            Status
                        </th>

                        <th class="px-4 py-3 text-right font-semibold text-slate-700">
                            Aksi
                        </th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($informations as $item)

                        <tr
                            class="
                                border-t border-slate-100 transition
                                {{ $item->is_pinned
                                    ? 'bg-orange-50/50'
                                    : 'hover:bg-slate-50'
                                }}
                            "
                        >

                            {{-- Informasi --}}
                            <td class="px-4 py-4">
                                <div class="flex min-w-[220px] items-center gap-3">

                                    <div class="h-14 w-20 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-100">

                                        @if($item->image)
                                            <img
                                                src="{{ asset('storage/' . $item->image) }}"
                                                alt="{{ $item->title }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            <div class="grid h-full w-full place-items-center bg-gradient-to-br from-orange-500 to-amber-400 text-[9px] font-bold uppercase tracking-wider text-white">
                                                Baca Dulu
                                            </div>
                                        @endif

                                    </div>


                                    <div class="min-w-0">

                                        @if($item->is_pinned)
                                            <div class="mb-1 inline-flex items-center gap-1 rounded-full bg-orange-600 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-white">

                                                <svg
                                                    class="h-2.5 w-2.5"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M14 4l6 6-3 1-4 4-1 5-3-3-4 4-2-2 4-4-3-3 5-1 4-4z"/>
                                                </svg>

                                                Pinned
                                            </div>
                                        @endif


                                        <strong class="block max-w-xs text-sm font-semibold leading-snug text-slate-900">
                                            {{ $item->title }}
                                        </strong>


                                        <span class="mt-1 block text-[11px] text-slate-400">
                                            {{ $item->created_at?->timezone('Asia/Jakarta')->translatedFormat('d M Y · H:i') }}
                                        </span>

                                    </div>

                                </div>
                            </td>


                            {{-- Konten --}}
                            <td class="px-4 py-4 text-xs leading-relaxed text-slate-500">
                                <div class="max-w-sm">
                                    {{
                                        \Illuminate\Support\Str::limit(
                                            trim(strip_tags($item->content)),
                                            100
                                        )
                                    }}
                                </div>
                            </td>


                            {{-- Status --}}
                            <td class="px-4 py-4 text-center">

                                @if($item->is_pinned)
                                    <span class="inline-flex rounded-full border border-orange-200 bg-orange-50 px-2.5 py-1 text-[10px] font-bold text-orange-700">
                                        Informasi Pilihan
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[10px] font-semibold text-slate-500">
                                        Normal
                                    </span>
                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-4 py-4">

                                <div class="flex min-w-[230px] items-center justify-end gap-2">

                                    {{-- Pin / Unpin --}}
                                    <form
                                        action="{{ route('admin.informations.pin', $item) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="
                                                inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold transition
                                                {{ $item->is_pinned
                                                    ? 'border border-orange-200 bg-orange-50 text-orange-700 hover:bg-orange-100'
                                                    : 'border border-slate-200 bg-white text-slate-600 hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700'
                                                }}
                                            "
                                        >
                                            <svg
                                                class="h-3.5 w-3.5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M14 4l6 6-3 1-4 4-1 5-3-3-4 4-2-2 4-4-3-3 5-1 4-4z"/>
                                            </svg>

                                            {{ $item->is_pinned ? 'Lepas Pin' : 'Pin' }}
                                        </button>
                                    </form>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.informations.edit', $item) }}"
                                        class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                    >
                                        Edit
                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.informations.destroy', $item) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Apakah kamu yakin ingin menghapus informasi ini?')"
                                            class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="4"
                                class="px-4 py-12 text-center text-sm text-slate-500"
                            >
                                Belum ada data informasi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>
@endsection