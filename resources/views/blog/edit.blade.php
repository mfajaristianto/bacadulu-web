@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50">

    <div class="max-w-4xl mx-auto px-6 py-10">


        {{-- ========================================================= --}}
        {{-- BACK --}}
        {{-- ========================================================= --}}

        <a
            href="{{ route('blog.show', $post->slug) }}"
            class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition mb-5 group"
        >

            <svg
                class="w-4 h-4 transition group-hover:-translate-x-0.5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Kembali ke Artikel

        </a>



        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="mb-6">

            <div class="flex items-center gap-2 mb-2">

                <span class="w-6 h-[3px] rounded-full bg-orange-500"></span>

                <span class="text-[11px] uppercase tracking-[0.16em] font-bold text-orange-600">
                    Baca Dulu Blogging
                </span>

            </div>


            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                Edit Artikel
            </h1>


            <p class="text-sm text-slate-500 mt-2">
                Perbarui artikel yang Anda tulis.
            </p>

        </div>



        {{-- ========================================================= --}}
        {{-- ERROR --}}
        {{-- ========================================================= --}}

        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">

                <p class="text-sm font-semibold text-red-700 mb-2">
                    Ada beberapa data yang perlu diperbaiki:
                </p>


                <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- FORM --}}
        {{-- ========================================================= --}}

        <form
            action="{{ route('blog.update', $post->slug) }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
        >

            @csrf
            @method('PUT')


            {{-- ===================================================== --}}
            {{-- FORM HEADER --}}
            {{-- ===================================================== --}}

            <div class="px-6 md:px-8 py-5 border-b border-slate-100">

                <h2 class="text-base font-bold text-slate-900">
                    Informasi Artikel
                </h2>


                <p class="text-xs text-slate-500 mt-1">
                    Anda hanya dapat mengedit artikel milik Anda sendiri.
                </p>

            </div>



            {{-- ===================================================== --}}
            {{-- FORM CONTENT --}}
            {{-- ===================================================== --}}

            <div class="p-6 md:p-8">


                {{-- ================================================= --}}
                {{-- TITLE --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="title"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Judul Artikel

                        <span class="text-red-500">
                            *
                        </span>
                    </label>


                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >


                    @error('title')

                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- CATEGORY --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="category"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Kategori

                        <span class="text-red-500">
                            *
                        </span>
                    </label>


                    <select
                        id="category"
                        name="category"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >

                        <option value="">
                            Pilih kategori
                        </option>


                        <option
                            value="Sosial"
                            {{ old('category', $post->category) === 'Sosial' ? 'selected' : '' }}
                        >
                            Sosial
                        </option>


                        <option
                            value="Ekonomi"
                            {{ old('category', $post->category) === 'Ekonomi' ? 'selected' : '' }}
                        >
                            Ekonomi
                        </option>


                        <option
                            value="Teknik"
                            {{ old('category', $post->category) === 'Teknik' ? 'selected' : '' }}
                        >
                            Teknik
                        </option>


                        <option
                            value="Kesehatan"
                            {{ old('category', $post->category) === 'Kesehatan' ? 'selected' : '' }}
                        >
                            Kesehatan
                        </option>

                    </select>


                    @error('category')

                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- CURRENT IMAGE --}}
                {{-- ================================================= --}}

                @if($post->image)

                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Gambar Saat Ini
                        </label>


                        <div class="rounded-xl border border-slate-200 overflow-hidden bg-slate-50">

                            <img
                                src="{{ asset('storage/' . $post->image) }}"
                                alt="{{ $post->title }}"
                                class="w-full max-h-[360px] object-cover"
                            >

                        </div>

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- NEW IMAGE --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="image"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Ganti Gambar Artikel
                    </label>


                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-600
                               file:mr-4
                               file:border-0
                               file:bg-slate-100
                               file:px-4
                               file:py-3
                               file:text-sm
                               file:font-semibold
                               file:text-slate-700
                               hover:file:bg-slate-200"
                    >


                    <p class="text-xs text-slate-400 mt-2">
                        Kosongkan jika gambar lama tetap digunakan. Maksimal 2 MB.
                    </p>


                    @error('image')

                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- CONTENT --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="content"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Isi Artikel

                        <span class="text-red-500">
                            *
                        </span>
                    </label>


                    <textarea
                        id="content"
                        name="content"
                        rows="14"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 leading-relaxed outline-none resize-y transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >{{ old('content', $post->content) }}</textarea>


                    @error('content')

                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}

                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4">

                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Status Artikel
                    </div>


                    <div class="mt-2">

                        @if($post->status === 'approved')

                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                ✓ Disetujui
                            </span>


                        @elseif($post->status === 'pending')

                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                Menunggu Persetujuan
                            </span>


                        @elseif($post->status === 'rejected')

                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                Ditolak
                            </span>

                        @endif

                    </div>


                    <p class="text-xs text-slate-400 mt-2">
                        Status publikasi hanya dapat dikelola oleh admin.
                    </p>

                </div>

            </div>



            {{-- ===================================================== --}}
            {{-- FOOTER --}}
            {{-- ===================================================== --}}

            <div class="px-6 md:px-8 py-5 border-t border-slate-100 bg-slate-50 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">

                <a
                    href="{{ route('blog.show', $post->slug) }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-100 transition"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-orange-600 text-white text-sm font-semibold hover:bg-orange-700 transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection