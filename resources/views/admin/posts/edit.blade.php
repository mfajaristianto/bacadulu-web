@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">

                <a
                    href="{{ route('admin.posts.index') }}"
                    class="hover:text-orange-600 transition"
                >
                    Artikel
                </a>

                <span>/</span>

                <span>
                    Edit Artikel
                </span>

            </div>

            <h1 class="text-3xl font-bold text-slate-900">
                Edit Artikel
            </h1>

            <p class="text-slate-600 mt-1">
                Perbarui informasi dan konten artikel yang dikirim oleh penulis.
            </p>

        </div>


        <a
            href="{{ route('admin.posts.index', ['status' => $post->status]) }}"
            class="inline-flex items-center justify-center
                   px-4 py-2.5
                   bg-white
                   border border-slate-300
                   text-slate-700
                   rounded-lg
                   text-sm font-semibold
                   hover:bg-slate-50
                   transition"
        >
            ← Kembali ke Artikel
        </a>

    </div>



    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div
            class="mb-6
                   rounded-lg
                   bg-green-100
                   text-green-700
                   border border-green-200
                   px-4 py-3"
        >
            {{ session('success') }}
        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- VALIDATION ERROR --}}
    {{-- ========================================================= --}}

    @if ($errors->any())

        <div
            class="mb-6
                   rounded-xl
                   bg-red-50
                   border border-red-200
                   px-5 py-4"
        >

            <div class="flex items-start gap-3">

                <div
                    class="w-9 h-9
                           rounded-full
                           bg-red-100
                           flex items-center
                           justify-center
                           text-red-600
                           font-bold
                           flex-shrink-0"
                >
                    !
                </div>

                <div>

                    <h3 class="font-semibold text-red-700">
                        Data belum dapat disimpan
                    </h3>

                    <p class="text-sm text-red-600 mt-1 mb-2">
                        Silakan periksa kembali data berikut.
                    </p>

                    <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- INFORMASI ARTIKEL --}}
    {{-- ========================================================= --}}

    <div
        class="bg-white
               rounded-xl
               border border-slate-200
               shadow-sm
               p-5
               mb-6"
    >

        <div class="flex items-center justify-between mb-4">

            <div>

                <h2 class="font-semibold text-slate-900">
                    Informasi Artikel
                </h2>

                <p class="text-sm text-slate-500">
                    Informasi singkat artikel yang sedang diedit.
                </p>

            </div>


            {{-- STATUS BADGE --}}

            @if($post->status === 'pending')

                <span
                    class="text-xs
                           font-semibold
                           bg-yellow-100
                           text-yellow-700
                           px-3 py-1.5
                           rounded-full"
                >
                    Menunggu Persetujuan
                </span>


            @elseif($post->status === 'approved')

                <span
                    class="text-xs
                           font-semibold
                           bg-green-100
                           text-green-700
                           px-3 py-1.5
                           rounded-full"
                >
                    Disetujui
                </span>


            @elseif($post->status === 'rejected')

                <span
                    class="text-xs
                           font-semibold
                           bg-red-100
                           text-red-700
                           px-3 py-1.5
                           rounded-full"
                >
                    Ditolak
                </span>

            @endif

        </div>


        <div
            class="grid
                   grid-cols-1
                   sm:grid-cols-2
                   lg:grid-cols-4
                   gap-4"
        >


            {{-- ID --}}

            <div class="bg-slate-50 rounded-lg px-4 py-3">

                <div class="text-xs text-slate-500 mb-1">
                    ID Artikel
                </div>

                <div class="font-semibold text-slate-900">
                    #{{ $post->id }}
                </div>

            </div>


            {{-- PENULIS --}}

            <div class="bg-slate-50 rounded-lg px-4 py-3">

                <div class="text-xs text-slate-500 mb-1">
                    Penulis
                </div>

                <div class="font-semibold text-slate-900 truncate">
                    {{ $post->author ?: '-' }}
                </div>

            </div>


            {{-- KATEGORI --}}

            <div class="bg-slate-50 rounded-lg px-4 py-3">

                <div class="text-xs text-slate-500 mb-1">
                    Kategori
                </div>

                <div class="font-semibold text-slate-900">
                    {{ $post->category }}
                </div>

            </div>


            {{-- TANGGAL --}}

            <div class="bg-slate-50 rounded-lg px-4 py-3">

                <div class="text-xs text-slate-500 mb-1">
                    Dibuat
                </div>

                <div class="font-semibold text-slate-900">
                    {{ $post->created_at?->format('d M Y') }}
                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- FORM EDIT --}}
    {{-- ========================================================= --}}

    <form
        action="{{ route('admin.posts.update', $post) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')


        <div
            class="bg-white
                   rounded-xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden"
        >


            {{-- FORM HEADER --}}

            <div
                class="px-6 py-5
                       border-b border-slate-200
                       bg-slate-50"
            >

                <h2 class="text-lg font-semibold text-slate-900">
                    Data Artikel
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Ubah informasi artikel sesuai kebutuhan.
                </p>

            </div>



            <div class="p-6">


                {{-- ================================================= --}}
                {{-- TITLE --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="title"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2"
                    >
                        Judul Artikel
                        <span class="text-red-500">*</span>
                    </label>


                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        placeholder="Masukkan judul artikel"
                        class="w-full
                               rounded-lg
                               border border-slate-300
                               bg-white
                               px-4 py-3
                               text-slate-900
                               placeholder:text-slate-400
                               outline-none
                               transition
                               focus:border-orange-500
                               focus:ring-2
                               focus:ring-orange-100"
                        required
                    >


                    @error('title')

                        <p class="text-red-600 text-sm mt-1.5">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- PENULIS + KATEGORI --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">


                    {{-- PENULIS --}}

                    <div>

                        <label
                            for="author"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2"
                        >
                            Nama Penulis
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="{{ old('author', $post->author) }}"
                            placeholder="Nama penulis"
                            class="w-full
                                   rounded-lg
                                   border border-slate-300
                                   bg-white
                                   px-4 py-3
                                   text-slate-900
                                   outline-none
                                   transition
                                   focus:border-orange-500
                                   focus:ring-2
                                   focus:ring-orange-100"
                            required
                        >


                        @error('author')

                            <p class="text-red-600 text-sm mt-1.5">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- KATEGORI --}}

                    <div>

                        <label
                            for="category"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2"
                        >
                            Kategori
                            <span class="text-red-500">*</span>
                        </label>


                        <select
                            id="category"
                            name="category"
                            class="w-full
                                   rounded-lg
                                   border border-slate-300
                                   bg-white
                                   px-4 py-3
                                   text-slate-900
                                   outline-none
                                   transition
                                   focus:border-orange-500
                                   focus:ring-2
                                   focus:ring-orange-100"
                            required
                        >

                            @foreach([
                                'Kesehatan',
                                'Sosial',
                                'Ekonomi',
                                'Teknik'
                            ] as $category)

                                <option
                                    value="{{ $category }}"
                                    {{ old('category', $post->category) === $category ? 'selected' : '' }}
                                >
                                    {{ $category }}
                                </option>

                            @endforeach

                        </select>


                        @error('category')

                            <p class="text-red-600 text-sm mt-1.5">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="status"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2"
                    >
                        Status Artikel
                        <span class="text-red-500">*</span>
                    </label>


                    <select
                        id="status"
                        name="status"
                        class="w-full
                               md:max-w-sm
                               rounded-lg
                               border border-slate-300
                               bg-white
                               px-4 py-3
                               text-slate-900
                               outline-none
                               transition
                               focus:border-orange-500
                               focus:ring-2
                               focus:ring-orange-100"
                        required
                    >

                        <option
                            value="pending"
                            {{ old('status', $post->status) === 'pending' ? 'selected' : '' }}
                        >
                            Menunggu Persetujuan
                        </option>


                        <option
                            value="approved"
                            {{ old('status', $post->status) === 'approved' ? 'selected' : '' }}
                        >
                            Disetujui
                        </option>


                        <option
                            value="rejected"
                            {{ old('status', $post->status) === 'rejected' ? 'selected' : '' }}
                        >
                            Ditolak
                        </option>

                    </select>


                    <p class="text-xs text-slate-500 mt-2">
                        Status menentukan apakah artikel ditampilkan kepada publik.
                    </p>


                    @error('status')

                        <p class="text-red-600 text-sm mt-1.5">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- CONTENT --}}
                {{-- ================================================= --}}

                <div class="mb-7">

                    <label
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2"
                    >
                        Isi Artikel
                        <span class="text-red-500">*</span>
                    </label>


                    <div
                        class="rounded-xl
                               border border-slate-300
                               overflow-hidden
                               focus-within:border-orange-500
                               focus-within:ring-2
                               focus-within:ring-orange-100
                               transition"
                    >

                        <input
                            id="content"
                            type="hidden"
                            name="content"
                            value="{{ old('content', $post->content) }}"
                        >


                        <trix-editor
                            input="content"
                            class="prose
                                   max-w-none
                                   min-h-[380px]
                                   border-0
                                   p-4
                                   focus:outline-none
                                   break-words
                                   [overflow-wrap:anywhere]"
                        ></trix-editor>

                    </div>


                    <p class="text-xs text-slate-500 mt-2">
                        Gunakan editor untuk memformat isi artikel.
                    </p>


                    @error('content')

                        <p class="text-red-600 text-sm mt-1.5">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- IMAGE --}}
                {{-- ================================================= --}}

                <div
                    class="border-t border-slate-200
                           pt-6"
                >

                    <div class="mb-4">

                        <h3 class="text-sm font-semibold text-slate-800">
                            Gambar Artikel
                        </h3>

                        <p class="text-xs text-slate-500 mt-1">
                            Gambar baru hanya diperlukan apabila ingin mengganti gambar sebelumnya.
                        </p>

                    </div>


                    <div
                        class="grid
                               grid-cols-1
                               lg:grid-cols-2
                               gap-6"
                    >


                        {{-- CURRENT IMAGE --}}

                        <div>

                            <label
                                class="block
                                       text-sm
                                       font-medium
                                       text-slate-700
                                       mb-2"
                            >
                                Gambar Saat Ini
                            </label>


                            @if ($post->image)

                                <div
                                    class="relative
                                           rounded-xl
                                           border border-slate-200
                                           bg-slate-50
                                           overflow-hidden"
                                >

                                    <img
                                        id="currentImage"
                                        src="{{ asset('storage/' . $post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="w-full
                                               h-56
                                               object-cover"
                                    >

                                </div>

                            @else

                                <div
                                    class="h-56
                                           rounded-xl
                                           border-2 border-dashed
                                           border-slate-200
                                           bg-slate-50
                                           flex flex-col
                                           items-center
                                           justify-center
                                           text-slate-400"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-10 h-10 mb-2"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M3 16l5-5 4 4 3-3 6 6M14 8h.01M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"
                                        />

                                    </svg>

                                    <span class="text-sm">
                                        Belum ada gambar
                                    </span>

                                </div>

                            @endif

                        </div>



                        {{-- UPLOAD IMAGE --}}

                        <div>

                            <label
                                for="image"
                                class="block
                                       text-sm
                                       font-medium
                                       text-slate-700
                                       mb-2"
                            >
                                Ganti Gambar
                            </label>


                            <label
                                for="image"
                                class="h-56
                                       rounded-xl
                                       border-2 border-dashed
                                       border-slate-300
                                       hover:border-orange-400
                                       bg-slate-50
                                       hover:bg-orange-50/30
                                       flex flex-col
                                       items-center
                                       justify-center
                                       cursor-pointer
                                       transition
                                       px-6
                                       text-center"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-10 h-10 text-slate-400 mb-3"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                    />

                                </svg>


                                <span class="text-sm font-semibold text-slate-700">
                                    Klik untuk memilih gambar
                                </span>


                                <span class="text-xs text-slate-500 mt-1">
                                    JPG, JPEG, PNG atau WEBP
                                </span>


                                <span class="text-xs text-slate-400 mt-1">
                                    Maksimal 2 MB
                                </span>


                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="hidden"
                                >

                            </label>


                            <div
                                id="selectedFile"
                                class="hidden
                                       mt-3
                                       text-sm
                                       text-slate-600
                                       bg-slate-50
                                       border border-slate-200
                                       rounded-lg
                                       px-3 py-2"
                            >
                            </div>


                            @error('image')

                                <p class="text-red-600 text-sm mt-1.5">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- FORM FOOTER --}}
            {{-- ================================================= --}}

            <div
                class="px-6 py-4
                       bg-slate-50
                       border-t border-slate-200
                       flex flex-col-reverse
                       sm:flex-row
                       sm:items-center
                       sm:justify-end
                       gap-3"
            >

                <a
                    href="{{ route('admin.posts.index', ['status' => $post->status]) }}"
                    class="inline-flex
                           justify-center
                           px-5 py-2.5
                           border border-slate-300
                           bg-white
                           text-slate-700
                           rounded-lg
                           text-sm
                           font-semibold
                           hover:bg-slate-100
                           transition"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex
                           items-center
                           justify-center
                           px-6 py-2.5
                           bg-orange-500
                           hover:bg-orange-600
                           text-white
                           rounded-lg
                           text-sm
                           font-semibold
                           shadow-sm
                           transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>



    {{-- ========================================================= --}}
    {{-- DANGER ZONE --}}
    {{-- ========================================================= --}}

    <div
        class="mt-8
               rounded-xl
               border border-red-200
               bg-white
               overflow-hidden"
    >

        <div
            class="px-6 py-5
                   flex flex-col
                   md:flex-row
                   md:items-center
                   md:justify-between
                   gap-4"
        >

            <div>

                <h2 class="font-semibold text-slate-900">
                    Hapus Artikel
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Menghapus artikel akan menghilangkan artikel secara permanen dari sistem.
                </p>

            </div>


            <form
                action="{{ route('admin.posts.destroy', $post) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus artikel ini? Data yang sudah dihapus tidak dapat dikembalikan.');"
            >

                @csrf
                @method('DELETE')


                <button
                    type="submit"
                    class="inline-flex
                           items-center
                           justify-center
                           px-4 py-2.5
                           bg-red-50
                           hover:bg-red-100
                           border border-red-200
                           text-red-700
                           rounded-lg
                           text-sm
                           font-semibold
                           transition"
                >
                    Hapus Artikel
                </button>

            </form>

        </div>

    </div>

</div>



{{-- ============================================================= --}}
{{-- IMAGE FILE NAME PREVIEW --}}
{{-- ============================================================= --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const imageInput = document.getElementById('image');
        const selectedFile = document.getElementById('selectedFile');

        if (!imageInput || !selectedFile) {
            return;
        }

        imageInput.addEventListener('change', function () {

            if (this.files && this.files.length > 0) {

                const file = this.files[0];

                selectedFile.textContent =
                    'Gambar dipilih: ' + file.name;

                selectedFile.classList.remove('hidden');

            } else {

                selectedFile.textContent = '';

                selectedFile.classList.add('hidden');

            }

        });

    });

</script>

@endsection