@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Event
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Kelola event yang tampil pada halaman Blogging.
            </p>
        </div>


        <a
            href="{{ route('admin.events.create') }}"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-lg transition"
        >
            + Tambah Event
        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg bg-green-100 border border-green-200 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Event Table --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Event
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Jadwal
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Lokasi
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($events as $event)

                        <tr class="hover:bg-slate-50 transition">

                            {{-- Event --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-4">

                                    <div class="w-20 h-14 rounded-lg bg-slate-100 overflow-hidden shrink-0">

                                        @if($event->banner_image)

                                            <img
                                                src="{{ asset('storage/' . $event->banner_image) }}"
                                                alt="{{ $event->title }}"
                                                class="w-full h-full object-cover"
                                            >

                                        @else

                                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-xs font-semibold text-slate-400">
                                                No Image
                                            </div>

                                        @endif

                                    </div>


                                    <div class="min-w-0">

                                        <div class="font-semibold text-slate-900 line-clamp-2">
                                            {{ $event->title }}
                                        </div>

                                        @if($event->category)

                                            <div class="text-xs text-orange-600 mt-1">
                                                {{ $event->category }}
                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Date --}}
                            <td class="px-5 py-4 text-sm text-slate-600 whitespace-nowrap">

                                @if($event->start_date)

                                    {{ $event->start_date
                                        ->copy()
                                        ->timezone('Asia/Jakarta')
                                        ->format('d M Y H:i')
                                    }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- Location --}}
                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ $event->location }}
                            </td>


                            {{-- Featured --}}
                            <td class="px-5 py-4">

                                @if($event->is_featured)

                                    <span class="inline-flex px-3 py-1 bg-orange-50 text-orange-700 text-xs font-semibold rounded-full">
                                        Unggulan
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full">
                                        Reguler
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('event.show', $event->slug) }}"
                                        target="_blank"
                                        class="px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition"
                                    >
                                        Lihat
                                    </a>


                                    <a
                                        href="{{ route('admin.events.edit', $event) }}"
                                        class="px-3 py-2 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.events.destroy', $event) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus event ini?');"
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="px-3 py-2 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"
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
                                colspan="5"
                                class="px-5 py-14 text-center text-sm text-slate-400"
                            >
                                Belum ada event.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    @if($events->hasPages())

        <div class="mt-6">
            {{ $events->links() }}
        </div>

    @endif

</div>

@endsection