@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Kelola Informasi
            </h1>

            <p class="text-slate-600 mt-1">
                Daftar konten informasi website.
            </p>
        </div>

        {{-- Tombol Tambah --}}
        <a
            href="{{ route('admin.informations.create') }}"
            class="rounded-lg bg-orange-600 px-4 py-2 text-white font-semibold
                   hover:bg-orange-700 transition"
        >
            + Tambah
        </a>
    </div>


    {{-- Pesan Success --}}
    @if(session('success'))
        <div
            class="mb-4 rounded-lg border border-green-200
                   bg-green-50 p-3 text-sm text-green-700"
        >
            {{ session('success') }}
        </div>
    @endif


    {{-- Pesan Error --}}
    @if(session('error'))
        <div
            class="mb-4 rounded-lg border border-red-200
                   bg-red-50 p-3 text-sm text-red-700"
        >
            {{ session('error') }}
        </div>
    @endif


    {{-- Validasi Error --}}
    @if($errors->any())
        <div
            class="mb-4 rounded-lg border border-red-200
                   bg-red-50 p-3 text-sm text-red-700"
        >
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                {{-- Table Header --}}
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">
                            Judul
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-slate-700">
                            Konten
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-slate-700">
                            Aksi
                        </th>
                    </tr>
                </thead>


                {{-- Table Body --}}
                <tbody>

                    @forelse($informations as $item)

                        <tr class="border-t border-slate-200 hover:bg-slate-50 transition">

                            {{-- Judul --}}
                            <td class="px-4 py-3 font-medium text-slate-900">
                                {{ $item->title }}
                            </td>


                            {{-- Konten --}}
                            <td class="px-4 py-3 text-slate-600">
                                {{ Str::limit(strip_tags($item->content), 80) }}
                            </td>


                            {{-- Aksi --}}
                            <td class="px-4 py-3 whitespace-nowrap">

                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.informations.edit', ['information' => $item->id]) }}"
                                    class="text-blue-600 font-medium mr-4 hover:text-blue-800 hover:underline"
                                >
                                    Edit
                                </a>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('admin.informations.destroy', ['information' => $item->id]) }}"
                                    method="POST"
                                    class="inline"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 font-medium hover:text-red-800 hover:underline"
                                        onclick="return confirm('Apakah kamu yakin ingin menghapus informasi ini?')"
                                    >
                                        Hapus
                                    </button>
                                </form>

                            </td>

                        </tr>

                    @empty

                        {{-- Data kosong --}}
                        <tr>
                            <td
                                colspan="3"
                                class="px-4 py-8 text-center text-slate-500"
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