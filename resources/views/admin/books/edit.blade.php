@extends('layouts.admin')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | ISBN LEGACY
    |--------------------------------------------------------------------------
    |
    | Buku lama yang hanya memiliki satu format bisa memakai ISBN lama
    | sebagai fallback.
    |
    | Jika buku lama punya Cetak + E-Book, ISBN lama tidak dimasukkan
    | otomatis ke kedua field.
    |
    */

    $displayPrintIsbn =
        $book->print_isbn;

    $displayEbookIsbn =
        $book->ebook_isbn;


    if (
        !$book->print_isbn &&
        !$book->ebook_isbn &&
        $book->isbn
    ) {

        if (
            $book->has_print &&
            !$book->has_ebook
        ) {
            $displayPrintIsbn =
                $book->isbn;
        }


        if (
            $book->has_ebook &&
            !$book->has_print
        ) {
            $displayEbookIsbn =
                $book->isbn;
        }

    }

@endphp


<div class="mx-auto max-w-4xl px-4 py-8">

    {{-- HEADER --}}
    <div class="mb-6">

        <p class="text-xs font-bold uppercase tracking-wider text-orange-600">
            Bookstore
        </p>

        <h1 class="mt-1 text-2xl font-bold text-slate-900">
            Edit Buku
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Perbarui informasi, format, harga dan stok buku.
        </p>

    </div>


    {{-- ERROR --}}
    @if($errors->any())

        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <p class="mb-2 font-semibold">
                Terjadi kesalahan:
            </p>

            <ul class="list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>

    @endif


    <form
        action="{{ route('admin.books.update', $book->slug) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >
        @csrf
        @method('PUT')


        {{-- =====================================================
             INFORMASI UMUM
        ====================================================== --}}

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-5">

                <p class="text-xs font-bold uppercase tracking-wider text-orange-600">
                    Informasi Dasar
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    Informasi Buku
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Data umum yang digunakan untuk seluruh format buku.
                </p>

            </div>


            <div class="space-y-5">

                {{-- TITLE --}}
                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Judul Buku
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $book->title) }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                    >

                </div>


                {{-- AUTHOR + PUBLISHER --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div>

                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Penulis
                        </label>

                        <input
                            type="text"
                            name="author"
                            value="{{ old('author', $book->author) }}"
                            required
                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                        >

                    </div>


                    <div>

                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Penerbit
                        </label>

                        <input
                            type="text"
                            name="publisher"
                            value="{{ old('publisher', $book->publisher) }}"
                            required
                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                        >

                    </div>

                </div>


                {{-- CATEGORY + PAGE + YEAR --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                    <div>

                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Kategori Buku
                        </label>

                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $book->category) }}"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                        >

                    </div>


                    <div>

                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Jumlah Halaman
                        </label>

                        <input
                            type="number"
                            name="pages"
                            min="1"
                            value="{{ old('pages', $book->pages) }}"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                        >

                    </div>


                    <div>

                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Tahun Terbit
                        </label>

                        <input
                            type="number"
                            name="publish_year"
                            min="1900"
                            max="{{ now()->year + 2 }}"
                            value="{{ old('publish_year', $book->publish_year) }}"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                        >

                    </div>

                </div>


                {{-- DESCRIPTION --}}
                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Sinopsis / Deskripsi Buku
                    </label>

                    <textarea
                        name="description"
                        rows="6"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                    >{{ old('description', $book->description) }}</textarea>

                </div>


                {{-- CURRENT COVER --}}
                @if($book->cover)

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <p class="mb-3 text-xs font-semibold text-slate-500">
                            Cover saat ini
                        </p>

                        <img
                            src="{{ asset('storage/' . $book->cover) }}"
                            alt="{{ $book->title }}"
                            class="h-44 w-auto rounded-lg object-cover shadow-sm"
                        >

                    </div>

                @endif


                {{-- COVER --}}
                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Upload Cover Baru
                    </label>

                    <input
                        type="file"
                        name="cover"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2 text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-orange-700 hover:file:bg-orange-100"
                    >

                    <p class="mt-1.5 text-[10px] text-slate-400">
                        Kosongkan jika cover tidak ingin diganti.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             FORMAT
        ====================================================== --}}

        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-6">

            <div class="mb-4">

                <p class="text-xs font-bold uppercase tracking-wider text-orange-600">
                    Format Tersedia
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    Pilih Format Buku
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Buku dapat tersedia sebagai Buku Cetak, E-Book, atau keduanya.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- PRINT --}}
                <label
                    id="print_format_card"
                    class="cursor-pointer rounded-xl border border-slate-200 bg-white p-4 transition hover:border-orange-300"
                >

                    <div class="flex items-start gap-3">

                        <input
                            id="has_print"
                            type="checkbox"
                            name="has_print"
                            value="1"
                            @checked(old(
                                'has_print',
                                $book->has_print ? 1 : 0
                            ))
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                        >

                        <div>

                            <div class="font-bold text-slate-900">
                                📚 Buku Cetak
                            </div>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                ISBN, ukuran, harga dan stok buku fisik.
                            </p>

                        </div>

                    </div>

                </label>


                {{-- EBOOK --}}
                <label
                    id="ebook_format_card"
                    class="cursor-pointer rounded-xl border border-slate-200 bg-white p-4 transition hover:border-indigo-300"
                >

                    <div class="flex items-start gap-3">

                        <input
                            id="has_ebook"
                            type="checkbox"
                            name="has_ebook"
                            value="1"
                            @checked(old(
                                'has_ebook',
                                $book->has_ebook ? 1 : 0
                            ))
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        >

                        <div>

                            <div class="font-bold text-slate-900">
                                💻 E-Book
                            </div>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                ISBN dan harga buku digital.
                            </p>

                        </div>

                    </div>

                </label>

            </div>

        </section>


        {{-- =====================================================
             CETAK
        ====================================================== --}}

        <section
            id="print_section"
            class="space-y-5 rounded-2xl border border-orange-200 bg-orange-50 p-6"
            style="display:none;"
        >

            <div>

                <p class="text-xs font-bold uppercase tracking-wider text-orange-600">
                    Format Fisik
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    📚 Buku Cetak
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Ukuran buku hanya digunakan pada format fisik.
                </p>

            </div>


            {{-- ISBN + SIZE --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        ISBN Buku Cetak
                    </label>

                    <input
                        type="text"
                        name="print_isbn"
                        value="{{ old('print_isbn', $displayPrintIsbn) }}"
                        placeholder="Contoh: 978-xxx-xxx-xxx-x"
                        class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                    >

                </div>


                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Ukuran Buku
                    </label>

                    <input
                        type="text"
                        name="size"
                        value="{{ old('size', $book->size) }}"
                        placeholder="Contoh: 14 × 20 cm"
                        class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                    >

                    <p class="mt-1 text-[10px] text-slate-500">
                        Tidak digunakan saat Buku Cetak dinonaktifkan.
                    </p>

                </div>

            </div>


            {{-- PRICE --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Harga Buku Cetak
                </label>

                <div class="flex overflow-hidden rounded-xl border border-orange-200 bg-white focus-within:border-orange-500 focus-within:ring-4 focus-within:ring-orange-100">

                    <span class="flex items-center border-r border-orange-100 bg-orange-50 px-3 text-xs font-bold text-orange-600">
                        IDR
                    </span>

                    <input
                        id="print_price_display"
                        type="text"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder="0,00"
                        class="w-full border-0 p-2.5 text-sm font-semibold text-slate-800 outline-none focus:ring-0"
                    >

                    <input
                        id="print_price"
                        type="hidden"
                        name="print_price"
                        value="{{ old('print_price', $book->print_price) }}"
                    >

                </div>

            </div>


            {{-- STOCK --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Stok Buku Cetak
                </label>

                <input
                    type="number"
                    name="print_stock"
                    min="0"
                    max="1000000"
                    step="1"
                    value="{{ old(
                        'print_stock',
                        $book->print_stock ?? 0
                    ) }}"
                    class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-800 outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                >

                <p class="mt-1 text-[10px] text-slate-500">
                    Perubahan angka dicatat sebagai penyesuaian stok.
                </p>

            </div>


            {{-- DISCOUNT --}}
            <div class="border-t border-orange-200 pt-4">

                <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">

                    <input
                        id="has_print_discount"
                        type="checkbox"
                        name="has_print_discount"
                        value="1"
                        @checked(old(
                            'has_print_discount',
                            $book->print_discounted_price !== null
                                ? 1
                                : 0
                        ))
                        class="h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <span>
                        Berikan diskon Buku Cetak
                    </span>

                </label>

            </div>


            <div
                id="print_discount_section"
                class="grid grid-cols-1 gap-4 md:grid-cols-2"
                style="display:none;"
            >

                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Diskon Buku Cetak (%)
                    </label>

                    <input
                        id="print_discount_percent"
                        type="number"
                        name="print_discount_percent"
                        step="0.01"
                        min="0"
                        max="70"
                        value="{{ old(
                            'print_discount_percent',
                            $book->print_discount_percent ?? 0
                        ) }}"
                        class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2.5 text-sm"
                    >

                </div>


                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Harga Setelah Diskon
                    </label>

                    <div class="flex overflow-hidden rounded-xl border border-orange-200 bg-white">

                        <span class="flex items-center border-r border-orange-100 bg-orange-50 px-3 text-xs font-bold text-orange-600">
                            IDR
                        </span>

                        <input
                            id="print_final_price"
                            type="text"
                            readonly
                            class="w-full border-0 bg-white p-2.5 text-sm font-bold text-orange-600 outline-none"
                        >

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             EBOOK
        ====================================================== --}}

        <section
            id="ebook_section"
            class="space-y-5 rounded-2xl border border-indigo-200 bg-indigo-50 p-6"
            style="display:none;"
        >

            <div>

                <p class="text-xs font-bold uppercase tracking-wider text-indigo-600">
                    Format Digital
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    💻 E-Book
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    E-Book tidak membutuhkan ukuran fisik dan stok cetak.
                </p>

            </div>


            {{-- ISBN --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                    ISBN E-Book
                </label>

                <input
                    type="text"
                    name="ebook_isbn"
                    value="{{ old('ebook_isbn', $displayEbookIsbn) }}"
                    placeholder="Contoh: 978-xxx-xxx-xxx-x"
                    class="w-full rounded-xl border border-indigo-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                >

            </div>


            {{-- PRICE --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Harga E-Book
                </label>

                <div class="flex overflow-hidden rounded-xl border border-indigo-200 bg-white focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-100">

                    <span class="flex items-center border-r border-indigo-100 bg-indigo-50 px-3 text-xs font-bold text-indigo-600">
                        IDR
                    </span>

                    <input
                        id="ebook_price_display"
                        type="text"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder="0,00"
                        class="w-full border-0 p-2.5 text-sm font-semibold text-slate-800 outline-none focus:ring-0"
                    >

                    <input
                        id="ebook_price"
                        type="hidden"
                        name="ebook_price"
                        value="{{ old(
                            'ebook_price',
                            $book->ebook_price
                        ) }}"
                    >

                </div>

            </div>


            {{-- DISCOUNT --}}
            <div class="border-t border-indigo-200 pt-4">

                <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">

                    <input
                        id="has_ebook_discount"
                        type="checkbox"
                        name="has_ebook_discount"
                        value="1"
                        @checked(old(
                            'has_ebook_discount',
                            $book->ebook_discounted_price !== null
                                ? 1
                                : 0
                        ))
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                    >

                    <span>
                        Berikan diskon E-Book
                    </span>

                </label>

            </div>


            <div
                id="ebook_discount_section"
                class="grid grid-cols-1 gap-4 md:grid-cols-2"
                style="display:none;"
            >

                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Diskon E-Book (%)
                    </label>

                    <input
                        id="ebook_discount_percent"
                        type="number"
                        name="ebook_discount_percent"
                        step="0.01"
                        min="0"
                        max="70"
                        value="{{ old(
                            'ebook_discount_percent',
                            $book->ebook_discount_percent ?? 0
                        ) }}"
                        class="w-full rounded-xl border border-indigo-200 bg-white px-3 py-2.5 text-sm"
                    >

                </div>


                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Harga Setelah Diskon
                    </label>

                    <div class="flex overflow-hidden rounded-xl border border-indigo-200 bg-white">

                        <span class="flex items-center border-r border-indigo-100 bg-indigo-50 px-3 text-xs font-bold text-indigo-600">
                            IDR
                        </span>

                        <input
                            id="ebook_final_price"
                            type="text"
                            readonly
                            class="w-full border-0 bg-white p-2.5 text-sm font-bold text-indigo-600 outline-none"
                        >

                    </div>

                </div>

            </div>

        </section>


        {{-- SAVE --}}
        <div class="flex items-center justify-between gap-3">

            <a
                href="{{ route('admin.books.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>


    {{-- =====================================================
         STOCK MANAGEMENT
    ====================================================== --}}

    @if($book->has_print)

        <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-2">

            {{-- RESTOCK --}}
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">

                <div class="mb-4">

                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">
                        Tambah Stok
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-slate-900">
                        Stok saat ini: {{ (int) $book->print_stock }} buku
                    </h2>

                    <p class="mt-1 text-xs text-slate-600">
                        Gunakan saat ada cetak ulang atau stok baru masuk.
                    </p>

                </div>


                <form
                    action="{{ route('admin.books.stock.add', $book->slug) }}"
                    method="POST"
                    class="space-y-3"
                >
                    @csrf

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        max="1000000"
                        required
                        placeholder="Jumlah stok masuk"
                        class="w-full rounded border border-emerald-200 bg-white p-2.5 text-sm"
                    >

                    <input
                        type="text"
                        name="note"
                        maxlength="500"
                        placeholder="Catatan, mis. cetak ulang 50 eksemplar"
                        class="w-full rounded border border-emerald-200 bg-white p-2.5 text-sm"
                    >

                    <button
                        type="submit"
                        class="w-full rounded bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700"
                    >
                        + Tambah Stok
                    </button>

                </form>

            </div>


            {{-- SALE --}}
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-5 shadow-sm">

                <div class="mb-4">

                    <p class="text-xs font-bold uppercase tracking-wide text-rose-700">
                        Catat Penjualan
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-slate-900">
                        Kurangi stok setelah CS mengonfirmasi
                    </h2>

                    <p class="mt-1 text-xs text-slate-600">
                        Checkout WhatsApp tidak mengurangi stok otomatis.
                    </p>

                </div>


                <form
                    action="{{ route('admin.books.stock.sale', $book->slug) }}"
                    method="POST"
                    class="space-y-3"
                >
                    @csrf

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        max="{{ max(1, (int) $book->print_stock) }}"
                        required
                        placeholder="Jumlah terjual"
                        class="w-full rounded border border-rose-200 bg-white p-2.5 text-sm"
                        {{ (int) $book->print_stock < 1 ? 'disabled' : '' }}
                    >

                    <input
                        type="text"
                        name="note"
                        maxlength="500"
                        placeholder="Catatan, mis. order via WhatsApp"
                        class="w-full rounded border border-rose-200 bg-white p-2.5 text-sm"
                        {{ (int) $book->print_stock < 1 ? 'disabled' : '' }}
                    >

                    <button
                        type="submit"
                        class="w-full rounded px-4 py-2.5 text-sm font-bold text-white {{ (int) $book->print_stock > 0 ? 'bg-rose-600 hover:bg-rose-700' : 'cursor-not-allowed bg-slate-400' }}"
                        {{ (int) $book->print_stock < 1 ? 'disabled' : '' }}
                    >
                        Catat Penjualan
                    </button>

                </form>

            </div>

        </div>


        {{-- STOCK HISTORY --}}
        <div class="mt-6 rounded-xl border bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between gap-3">

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Riwayat Stok
                    </p>

                    <h2 class="mt-1 text-lg font-bold text-slate-900">
                        Pergerakan Stok Buku Cetak
                    </h2>

                </div>


                <span
                    class="rounded-full px-3 py-1 text-xs font-bold {{ (int) $book->print_stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}"
                >
                    {{
                        (int) $book->print_stock > 0
                            ? 'Tersedia: ' . $book->print_stock
                            : 'Stok Habis'
                    }}
                </span>

            </div>


            <div class="mt-4 overflow-x-auto">

                <table class="w-full min-w-[680px] text-left text-sm">

                    <thead class="border-b bg-slate-50 text-xs uppercase text-slate-500">

                        <tr>

                            <th class="p-3">
                                Waktu
                            </th>

                            <th class="p-3">
                                Jenis
                            </th>

                            <th class="p-3">
                                Perubahan
                            </th>

                            <th class="p-3">
                                Sebelum → Sesudah
                            </th>

                            <th class="p-3">
                                Admin
                            </th>

                            <th class="p-3">
                                Catatan
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse($book->stockMovements->take(30) as $movement)

                            <tr>

                                <td class="p-3 text-slate-500">

                                    {{
                                        $movement->created_at
                                            ?->timezone('Asia/Jakarta')
                                            ->format('d M Y H:i')
                                    }}

                                </td>


                                <td class="p-3 font-semibold text-slate-700">

                                    {{
                                        match($movement->type) {
                                            'initial' => 'Stok Awal',
                                            'restock' => 'Tambah Stok',
                                            'sale' => 'Penjualan',
                                            default => 'Penyesuaian'
                                        }
                                    }}

                                </td>


                                <td
                                    class="p-3 font-bold {{ $movement->quantity_change >= 0 ? 'text-emerald-600' : 'text-rose-600' }}"
                                >

                                    {{
                                        $movement->quantity_change >= 0
                                            ? '+'
                                            : ''
                                    }}{{ $movement->quantity_change }}

                                </td>


                                <td class="p-3 text-slate-600">

                                    {{ $movement->stock_before }}

                                    →

                                    {{ $movement->stock_after }}

                                </td>


                                <td class="p-3 text-slate-600">

                                    {{ $movement->user?->name ?? 'Sistem' }}

                                </td>


                                <td class="p-3 text-slate-500">

                                    {{ $movement->note ?: '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="p-6 text-center text-slate-400"
                                >
                                    Belum ada riwayat stok.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @endif

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | FORMAT IDR
    |--------------------------------------------------------------------------
    */

    function formatIDR(value, decimal = true) {

        return new Intl.NumberFormat(
            'id-ID',
            {
                minimumFractionDigits:
                    decimal ? 2 : 0,

                maximumFractionDigits:
                    decimal ? 2 : 0
            }
        ).format(
            Number(value || 0)
        );

    }


    function parseIDR(value) {

        let text =
            String(value || '').trim();


        if (text.includes(',')) {

            text =
                text.split(',')[0];

        }


        text =
            text
                .replace(/\./g, '')
                .replace(/[^\d]/g, '');


        return text
            ? Number(text)
            : 0;

    }


    function setupMoneyInput(
        display,
        raw
    ) {

        const initial =
            Number(raw.value || 0);


        if (initial > 0) {

            display.value =
                formatIDR(initial);

        }


        display.addEventListener(
            'focus',
            function () {

                const value =
                    Number(raw.value || 0);


                this.value =
                    value > 0
                        ? formatIDR(
                            value,
                            false
                        )
                        : '';


                setTimeout(() => {

                    this.setSelectionRange(
                        this.value.length,
                        this.value.length
                    );

                }, 0);

            }
        );


        display.addEventListener(
            'input',
            function () {

                const value =
                    parseIDR(
                        this.value
                    );


                raw.value =
                    value > 0
                        ? value
                        : '';


                this.value =
                    value > 0
                        ? formatIDR(
                            value,
                            false
                        )
                        : '';


                raw.dispatchEvent(
                    new Event(
                        'input'
                    )
                );

            }
        );


        display.addEventListener(
            'blur',
            function () {

                const value =
                    Number(
                        raw.value || 0
                    );


                this.value =
                    value > 0
                        ? formatIDR(value)
                        : '';

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT
    |--------------------------------------------------------------------------
    */

    function setupFormat(config) {

        const available =
            document.getElementById(
                config.available
            );

        const card =
            document.getElementById(
                config.card
            );

        const section =
            document.getElementById(
                config.section
            );

        const rawPrice =
            document.getElementById(
                config.price
            );

        const displayPrice =
            document.getElementById(
                config.displayPrice
            );

        const discount =
            document.getElementById(
                config.discount
            );

        const discountSection =
            document.getElementById(
                config.discountSection
            );

        const percent =
            document.getElementById(
                config.percent
            );

        const finalPrice =
            document.getElementById(
                config.finalPrice
            );


        setupMoneyInput(
            displayPrice,
            rawPrice
        );


        function calculate() {

            const base =
                Number(
                    rawPrice.value || 0
                );


            let pct =
                parseFloat(
                    percent.value
                ) || 0;


            pct =
                Math.min(
                    70,
                    Math.max(
                        0,
                        pct
                    )
                );


            percent.value =
                pct;


            const result =
                base -
                (
                    base *
                    pct /
                    100
                );


            finalPrice.value =
                base > 0
                    ? formatIDR(result)
                    : '';

        }


        function updateDiscount() {

            const enabled =
                available.checked &&
                discount.checked;


            discountSection.style.display =
                enabled
                    ? 'grid'
                    : 'none';


            percent.disabled =
                !enabled;


            percent.required =
                enabled;


            if (enabled) {

                calculate();

            } else {

                finalPrice.value =
                    '';

            }

        }


        function updateFormat() {

            const enabled =
                available.checked;


            section.style.display =
                enabled
                    ? 'block'
                    : 'none';


            section
                .querySelectorAll(
                    'input, select, textarea'
                )
                .forEach(function (field) {

                    field.disabled =
                        !enabled;

                });


            displayPrice.required =
                enabled;


            card.classList.toggle(
                config.activeBorder,
                enabled
            );


            card.classList.toggle(
                config.activeBackground,
                enabled
            );


            updateDiscount();

        }


        available.addEventListener(
            'change',
            updateFormat
        );


        discount.addEventListener(
            'change',
            updateDiscount
        );


        rawPrice.addEventListener(
            'input',
            calculate
        );


        percent.addEventListener(
            'input',
            calculate
        );


        updateFormat();


        if (available.checked) {

            calculate();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CETAK
    |--------------------------------------------------------------------------
    */

    setupFormat({
        available:
            'has_print',

        card:
            'print_format_card',

        section:
            'print_section',

        price:
            'print_price',

        displayPrice:
            'print_price_display',

        discount:
            'has_print_discount',

        discountSection:
            'print_discount_section',

        percent:
            'print_discount_percent',

        finalPrice:
            'print_final_price',

        activeBorder:
            'border-orange-400',

        activeBackground:
            'bg-orange-50'
    });


    /*
    |--------------------------------------------------------------------------
    | EBOOK
    |--------------------------------------------------------------------------
    */

    setupFormat({
        available:
            'has_ebook',

        card:
            'ebook_format_card',

        section:
            'ebook_section',

        price:
            'ebook_price',

        displayPrice:
            'ebook_price_display',

        discount:
            'has_ebook_discount',

        discountSection:
            'ebook_discount_section',

        percent:
            'ebook_discount_percent',

        finalPrice:
            'ebook_final_price',

        activeBorder:
            'border-indigo-400',

        activeBackground:
            'bg-indigo-50'
    });

});
</script>

@endsection