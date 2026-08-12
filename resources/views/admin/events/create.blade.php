@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}"
           class="text-sm text-orange-600 hover:text-orange-700">
            ← Kembali ke Event
        </a>

        <h1 class="text-3xl font-bold text-slate-900 mt-3">
            Tambah Event
        </h1>

        <p class="text-slate-600 mt-1">
            Tambahkan event baru yang akan tampil di halaman Blogging.
        </p>
    </div>


    {{-- Validation Error --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-red-800">
            <p class="font-semibold mb-2">
                Ada data yang belum benar:
            </p>

            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Form --}}
    <form
        action="{{ route('admin.events.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="max-w-4xl"
    >

        @csrf


        {{-- Main Card --}}
        <div class="rounded-xl border bg-white p-6 shadow-sm">

            {{-- Judul --}}
            <div class="mb-5">
                <label
                    for="title"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Judul Event
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    placeholder="Contoh: Seminar Nasional Sustainability 2026"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500"
                >
            </div>


            {{-- Slug --}}
            <div class="mb-5">
                <label
                    for="slug"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Slug
                </label>

                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="{{ old('slug') }}"
                    placeholder="seminar-nasional-sustainability-2026"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3"
                >

                <p class="text-xs text-slate-500 mt-1">
                    Kosongkan jika ingin slug dibuat otomatis dari judul.
                </p>
            </div>


            {{-- Category + Location --}}
            <div class="grid gap-5 md:grid-cols-2 mb-5">

                {{-- Category --}}
                <div>
                    <label
                        for="category"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Kategori
                    </label>

                    <input
                        type="text"
                        id="category"
                        name="category"
                        value="{{ old('category') }}"
                        placeholder="Contoh: Seminar"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3"
                    >
                </div>


                {{-- Location --}}
                <div>
                    <label
                        for="location"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Lokasi
                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        required
                        placeholder="Contoh: Jakarta"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3"
                    >
                </div>

            </div>


            {{-- Date --}}
            <div class="grid gap-5 md:grid-cols-2 mb-5">

                {{-- Start Date --}}
                <div>
                    <label
                        for="start_date"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Tanggal & Jam Mulai
                    </label>

                    <input
                        type="datetime-local"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3"
                    >
                </div>


                {{-- End Date --}}
                <div>
                    <label
                        for="end_date"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Tanggal & Jam Selesai
                    </label>

                    <input
                        type="datetime-local"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3"
                    >
                </div>

            </div>


            {{-- Banner --}}
            <div class="mb-5">

                <label
                    for="banner_image"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Banner Event
                </label>

                <input
                    type="file"
                    id="banner_image"
                    name="banner_image"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3"
                >

                <p class="text-xs text-slate-500 mt-1">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                </p>

            </div>


            {{-- Description --}}
            <div class="mb-5">

                <label
                    for="description"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Deskripsi Event
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="8"
                    required
                    placeholder="Tuliskan informasi lengkap mengenai event..."
                    class="w-full rounded-lg border border-slate-300 px-4 py-3"
                >{{ old('description') }}</textarea>

            </div>


            {{-- Featured --}}
            <div class="mb-6">

                <label class="inline-flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        {{ old('is_featured') ? 'checked' : '' }}
                        class="rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <span>
                        <span class="block text-sm font-semibold text-slate-700">
                            Jadikan Featured Event
                        </span>

                        <span class="block text-xs text-slate-500">
                            Event ini akan menjadi event utama di halaman publik.
                        </span>
                    </span>

                </label>

            </div>


            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 border-t pt-5">

                <a
                    href="{{ route('admin.events.index') }}"
                    class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-700"
                >
                    Simpan Event
                </button>

            </div>

        </div>

    </form>

</div>
@endsection