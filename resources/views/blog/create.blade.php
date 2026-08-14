@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">

    <h1 class="text-2xl font-bold mb-4">Tulis Artikel Baru</h1>

    {{-- Tampilkan semua error validasi --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4 text-red-700">
            <strong>Artikel belum bisa dikirim:</strong>

            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('blog.store') }}" method="POST">
        @csrf

        {{-- JUDUL --}}
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-1">
                Judul
            </label>

            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="w-full rounded border p-2"
                required
            >

            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- KATEGORI --}}
        <div class="mb-4">
            <label for="category" class="block font-semibold mb-1">
                Kategori
            </label>

            <select
                id="category"
                name="category"
                class="w-full rounded border p-2"
                required
            >
                <option value="">-- Pilih Kategori --</option>

                @foreach(['Kesehatan','Sosial','Ekonomi','Teknik'] as $cat)
                    <option
                        value="{{ $cat }}"
                        {{ old('category') === $cat ? 'selected' : '' }}
                    >
                        {{ $cat }}
                    </option>
                @endforeach
            </select>

            @error('category')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ISI --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">
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
                class="prose border rounded min-h-[250px]"
            ></trix-editor>

            @error('content')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button
                type="submit"
                class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700"
            >
                Kirim Artikel
            </button>
        </div>

    </form>
</div>
@endsection