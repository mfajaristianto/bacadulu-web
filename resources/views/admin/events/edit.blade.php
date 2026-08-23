@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8 max-w-4xl">

    {{-- Header --}}
    <div class="mb-6">

        <a
            href="{{ route('admin.events.index') }}"
            class="text-sm text-slate-500 hover:text-orange-600"
        >
            ← Kembali ke Event
        </a>


        <h1 class="text-3xl font-bold text-slate-900 mt-3">
            Edit Event
        </h1>


        <p class="text-slate-600 mt-1">
            Perbarui informasi event yang tampil di halaman Blogging.
        </p>

    </div>


    {{-- Validation Error --}}
    @if($errors->any())

        <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-red-800">

            <p class="font-semibold mb-2">
                Ada data yang belum benar:
            </p>


            <ul class="list-disc pl-5 text-sm">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form --}}
    <form
        action="{{ route('admin.events.update', $event) }}"
        method="POST"
        enctype="multipart/form-data"
        class="rounded-2xl border bg-white shadow-sm p-6 md:p-8"
    >

        @csrf
        @method('PUT')


        {{-- Judul --}}
        <div class="mb-6">

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
                value="{{ old('title', $event->title) }}"
                required
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
            >


            @error('title')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Slug --}}
        <div class="mb-6">

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
                value="{{ old('slug', $event->slug) }}"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
            >


            <p class="mt-1 text-xs text-slate-500">
                Slug digunakan pada alamat URL event.
            </p>


            @error('slug')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Banner Saat Ini --}}
        @if($event->banner_image)

            <div class="mb-6">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Banner Saat Ini
                </label>


                <div class="rounded-xl border border-slate-200 overflow-hidden bg-slate-50">

                    <img
                        src="{{ asset('storage/' . $event->banner_image) }}"
                        alt="{{ $event->title }}"
                        class="w-full max-h-80 object-cover"
                    >

                </div>

            </div>

        @endif


        {{-- Banner Baru --}}
        <div class="mb-6">

            <label
                for="banner_image"
                class="block text-sm font-semibold text-slate-700 mb-2"
            >
                Ganti Banner Event
            </label>


            <input
                type="file"
                id="banner_image"
                name="banner_image"
                accept=".jpg,.jpeg,.png,.webp"
                class="block w-full rounded-lg border border-slate-300 text-sm file:mr-4 file:border-0 file:bg-orange-600 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-white hover:file:bg-orange-700"
            >


            <p class="mt-1 text-xs text-slate-500">
                Kosongkan jika banner lama tetap digunakan. Maksimal 5 MB.
            </p>


            @error('banner_image')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Category --}}
        <div class="mb-6">

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
                value="{{ old('category', $event->category) }}"
                placeholder="Contoh: Workshop, Webinar, Lomba"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
            >


            @error('category')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Location --}}
        <div class="mb-6">

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
                value="{{ old('location', $event->location) }}"
                required
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
            >


            @error('location')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Date --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

            <div>

                <label
                    for="start_date"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Tanggal & Waktu Mulai
                </label>


                <input
                    type="datetime-local"
                    id="start_date"
                    name="start_date"
                    value="{{ old(
                        'start_date',
                        $event->start_date
                            ? $event->start_date->format('Y-m-d\TH:i')
                            : ''
                    ) }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                >


                @error('start_date')

                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <div>

                <label
                    for="end_date"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Tanggal & Waktu Selesai
                </label>


                <input
                    type="datetime-local"
                    id="end_date"
                    name="end_date"
                    value="{{ old(
                        'end_date',
                        $event->end_date
                            ? $event->end_date->format('Y-m-d\TH:i')
                            : ''
                    ) }}"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
                >


                <p class="mt-1 text-xs text-slate-500">
                    Boleh dikosongkan jika event hanya memiliki satu waktu.
                </p>


                @error('end_date')

                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>


        {{-- Description --}}
        <div class="mb-6">

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
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500"
            >{{ old('description', $event->description) }}</textarea>


            @error('description')

                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Featured --}}
        <div class="mb-8 rounded-xl bg-orange-50 border border-orange-100 p-4">

            <label class="flex items-start gap-3 cursor-pointer">

                <input
                    type="checkbox"
                    name="is_featured"
                    value="1"
                    {{ old(
                        'is_featured',
                        $event->is_featured
                    ) ? 'checked' : '' }}
                    class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                >


                <span>

                    <span class="block text-sm font-semibold text-slate-800">
                        Jadikan Event Unggulan
                    </span>


                    <span class="block text-xs text-slate-500 mt-1">
                        Event unggulan akan ditampilkan lebih menonjol pada halaman Event.
                    </span>

                </span>

            </label>

        </div>


        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('admin.events.index') }}"
                class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >
                Batal
            </a>


            <button
                type="submit"
                class="rounded-lg bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 transition"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection