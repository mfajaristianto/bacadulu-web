@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-12">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">
            Tulis Artikel Baru
        </h1>

        <p class="text-gray-500 mt-2">
            Bagikan tulisanmu kepada pembaca BacaDulu.
        </p>
    </div>


    {{-- ERROR VALIDASI --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-5 text-red-700">

            <strong>
                Artikel belum bisa dikirim:
            </strong>

            <ul class="mt-2 list-disc list-inside text-sm">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- SUCCESS --}}
    @if (session('success'))

        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-5 text-green-700">

            {{ session('success') }}

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('blog.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6"
    >

        @csrf


        {{-- JUDUL --}}
        <div class="mb-6">

            <label
                for="title"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Judul Artikel
            </label>

            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Masukkan judul artikel..."
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                required
            >

            @error('title')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- NAMA PENULIS --}}
        <div class="mb-6">

            <label
                for="author"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Nama Penulis
            </label>

            <input
                id="author"
                type="text"
                value="{{ auth()->user()->name }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 bg-gray-100 text-gray-600"
                disabled
            >

            {{-- Tidak perlu sebenarnya, karena controller
                 mengambil nama dari auth()->user() --}}

        </div>


        {{-- KATEGORI --}}
        <div class="mb-6">

            <label
                for="category"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Kategori
            </label>

            <select
                id="category"
                name="category"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                required
            >

                <option value="">
                    -- Pilih Kategori --
                </option>

                @foreach([
                    'Kesehatan',
                    'Sosial',
                    'Ekonomi',
                    'Teknik'
                ] as $cat)

                    <option
                        value="{{ $cat }}"
                        {{ old('category') === $cat ? 'selected' : '' }}
                    >
                        {{ $cat }}
                    </option>

                @endforeach

            </select>

            @error('category')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- GAMBAR ARTIKEL --}}
        <div class="mb-6">

            <label
                for="image"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Gambar Artikel
            </label>

            <input
                id="image"
                type="file"
                name="image"
                accept="image/jpeg,image/png,image/webp"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 bg-white text-sm"
            >

            <p class="text-xs text-gray-500 mt-2">
                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
            </p>

            @error('image')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ISI ARTIKEL --}}
        <div class="mb-6">

            <label
                for="content"
                class="block text-sm font-semibold text-slate-800 mb-2"
            >
                Isi Artikel
            </label>

            <input
                id="content"
                type="hidden"
                name="content"
                value="{{ old('content') }}"
            >

            <trix-editor
                input="content"
                class="prose border border-gray-300 rounded-lg min-h-[300px] p-4"
            ></trix-editor>

            @error('content')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- BUTTON --}}
        <div class="flex justify-end">

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow transition"
            >

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Kirim Artikel

            </button>

        </div>

    </form>

</div>

@endsection