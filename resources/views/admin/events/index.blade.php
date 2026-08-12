@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Kelola Event
            </h1>

            <p class="text-slate-600 mt-1">
                Tambahkan dan kelola event yang tampil di halaman Blogging.
            </p>
        </div>

        <a href="{{ route('admin.events.create') }}"
           class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 transition">

            + Tambah Event

        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif


    {{-- Error Message --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-red-800">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Event List --}}
    <div class="rounded-xl border bg-white shadow-sm overflow-hidden">

        @if($events->count())

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-slate-700">
                                Event
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-700">
                                Kategori
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-700">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-700">
                                Lokasi
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-700">
                                Featured
                            </th>

                            <th class="px-6 py-4 font-semibold text-slate-700 text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>


                    <tbody class="divide-y">

                        @foreach($events as $event)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- Event --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-4">

                                        @if($event->banner_image)

                                            <img
                                                src="{{ asset('storage/' . $event->banner_image) }}"
                                                alt="{{ $event->title }}"
                                                class="h-16 w-24 rounded-lg object-cover"
                                            >

                                        @else

                                            <div class="h-16 w-24 rounded-lg bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                                                No Image
                                            </div>

                                        @endif


                                        <div>

                                            <p class="font-semibold text-slate-900">
                                                {{ $event->title }}
                                            </p>

                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $event->slug }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Category --}}
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $event->category ?? '-' }}
                                </td>


                                {{-- Date --}}
                                <td class="px-6 py-4 text-slate-600">

                                    {{ $event->start_date?->format('d M Y H:i') }}

                                    @if($event->end_date)
                                        <br>
                                        <span class="text-xs text-slate-400">
                                            s/d {{ $event->end_date->format('d M Y H:i') }}
                                        </span>
                                    @endif

                                </td>


                                {{-- Location --}}
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $event->location }}
                                </td>


                                {{-- Featured --}}
                                <td class="px-6 py-4">

                                    @if($event->is_featured)

                                        <span class="inline-flex rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                            Featured
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                            Normal
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        {{-- Detail --}}
                                        <a
                                            href="{{ route('admin.events.show', $event) }}"
                                            class="rounded-lg border px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            Lihat
                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin.events.edit', $event) }}"
                                            class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                                        >
                                            Edit
                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('admin.events.destroy', $event) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus event ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700"
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


            {{-- Pagination --}}
            <div class="border-t px-6 py-4">
                {{ $events->links() }}
            </div>

        @else

            {{-- Empty State --}}
            <div class="py-16 text-center">

                <div class="text-4xl mb-4">
                    📅
                </div>

                <h2 class="text-lg font-semibold text-slate-900">
                    Belum ada event
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Belum ada event yang ditambahkan ke website.
                </p>

                <a
                    href="{{ route('admin.events.create') }}"
                    class="inline-block mt-5 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700"
                >
                    + Tambah Event
                </a>

            </div>

        @endif

    </div>

</div>
@endsection