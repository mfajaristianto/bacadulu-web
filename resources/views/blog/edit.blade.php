@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">
            Edit Artikel
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Admin dapat memperbaiki artikel yang dikirim oleh penulis.
        </p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
            <div class="font-semibold text-red-700 mb-2">
                Terdapat kesalahan:
            </div>

            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- FORM UPDATE --}}
    <form
        id="updatePostForm"
        action="{{ route('admin.posts.update', $post->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6"
    >

        @csrf
        @method('PUT')


        {{-- Judul --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Judul
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $post->title) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-3
                       outline-none focus:border-blue-500
                       focus:ring-2 focus:ring-blue-100"
                required
            >

            @error('title')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Penulis --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Nama Penulis
            </label>

            <input
                type="text"
                name="author"
                value="{{ old('author', $post->author) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-3
                       outline-none focus:border-blue-500
                       focus:ring-2 focus:ring-blue-100"
                required
            >

            @error('author')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Kategori --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Kategori
            </label>

            <select
                name="category"
                class="w-full rounded-lg border border-gray-300 px-4 py-3
                       outline-none focus:border-blue-500
                       focus:ring-2 focus:ring-blue-100"
                required
            >

                @foreach(['Kesehatan','Sosial','Ekonomi','Teknik'] as $cat)

                    <option
                        value="{{ $cat }}"
                        {{ old('category', $post->category) === $cat ? 'selected' : '' }}
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


        {{-- Status --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Status Artikel
            </label>

            <select
                name="status"
                class="w-full rounded-lg border border-gray-300 px-4 py-3
                       outline-none focus:border-blue-500
                       focus:ring-2 focus:ring-blue-100"
            >

                <option
                    value="pending"
                    {{ old('status', $post->status) === 'pending' ? 'selected' : '' }}
                >
                    Pending
                </option>

                <option
                    value="approved"
                    {{ old('status', $post->status) === 'approved' ? 'selected' : '' }}
                >
                    Approved
                </option>

                <option
                    value="rejected"
                    {{ old('status', $post->status) === 'rejected' ? 'selected' : '' }}
                >
                    Rejected
                </option>

            </select>

            @error('status')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Isi Artikel --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Isi Artikel
            </label>

            <input
                id="content"
                type="hidden"
                name="content"
                value="{{ old('content', $post->content) }}"
            >

            <trix-editor
                input="content"
                class="prose max-w-none border border-gray-300 rounded-lg
                       min-h-[300px] p-4 break-words
                       [overflow-wrap:anywhere]"
            ></trix-editor>

            @error('content')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- Gambar lama --}}
        @if($post->image)

            <div class="mb-6">

                <label class="block text-sm font-semibold text-slate-800 mb-2">
                    Gambar Saat Ini
                </label>

                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="max-w-xs rounded-xl border border-gray-200"
                >

            </div>

        @endif


        {{-- Upload gambar --}}
        <div class="mb-8">

            <label class="block text-sm font-semibold text-slate-800 mb-2">
                Ganti Gambar
            </label>

            <input
                type="file"
                name="image"
                accept="image/*"
                class="w-full rounded-lg border border-gray-300 px-4 py-3"
            >

            <p class="text-xs text-slate-500 mt-2">
                Kosongkan apabila tidak ingin mengganti gambar.
            </p>

            @error('image')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Tombol --}}
        <div class="flex flex-wrap justify-between items-center gap-3">

            <a
                href="{{ route('admin.posts.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg
                       text-sm font-semibold text-slate-600
                       hover:bg-gray-50 transition"
            >
                Kembali
            </a>


            <div class="flex items-center gap-2">

                <button
                    type="submit"
                    class="px-5 py-2 bg-orange-600 hover:bg-orange-700
                           text-white rounded-lg text-sm font-semibold
                           transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>


    {{-- FORM HAPUS - HARUS DI LUAR FORM UPDATE --}}
    <form
        action="{{ route('admin.posts.destroy', $post->id) }}"
        method="POST"
        class="mt-4"
        onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');"
    >

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="px-4 py-2 bg-red-50 text-red-600
                   border border-red-200 rounded-lg
                   text-sm font-semibold hover:bg-red-100 transition"
        >
            Hapus Artikel
        </button>

    </form>

</div>
@endsection