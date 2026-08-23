@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">
        Edit Buku
    </h1>


    @if ($errors->any())

        <div class="mb-5 rounded-lg bg-red-100 border border-red-400 p-4 text-red-700 text-sm">

            <p class="font-semibold mb-2">
                Terjadi kesalahan validasi:
            </p>

            <ul class="list-disc pl-5">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('admin.books.update', $book->slug) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-xl border p-6 shadow-sm space-y-6"
    >

        @csrf

        @method('PUT')


        {{-- =====================================================
            BASIC
        ====================================================== --}}

        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Judul Buku
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $book->title) }}"
                required
                class="w-full rounded border border-slate-300 p-2 text-sm"
            >

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Penulis
                </label>

                <input
                    type="text"
                    name="author"
                    value="{{ old('author', $book->author) }}"
                    required
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>


            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Penerbit
                </label>

                <input
                    type="text"
                    name="publisher"
                    value="{{ old('publisher', $book->publisher) }}"
                    required
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>

        </div>


        {{-- =====================================================
            FORMAT
        ====================================================== --}}

        <div class="rounded-xl border bg-slate-50 p-5">

            <h2 class="font-bold">
                Format Buku
            </h2>

            <p class="mt-1 mb-4 text-xs text-slate-500">
                Buku dapat dijual dalam bentuk Cetak dan E-book sekaligus.
            </p>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <label class="flex gap-3 rounded-xl border bg-white p-4 cursor-pointer">

                    <input
                        id="has_print"
                        type="checkbox"
                        name="has_print"
                        value="1"
                        {{ old('has_print', $book->has_print ? 1 : 0) ? 'checked' : '' }}
                    >

                    <div>

                        <div class="font-bold">
                            📚 Buku Cetak
                        </div>

                        <div class="text-xs text-slate-500">
                            Buku fisik
                        </div>

                    </div>

                </label>


                <label class="flex gap-3 rounded-xl border bg-white p-4 cursor-pointer">

                    <input
                        id="has_ebook"
                        type="checkbox"
                        name="has_ebook"
                        value="1"
                        {{ old('has_ebook', $book->has_ebook ? 1 : 0) ? 'checked' : '' }}
                    >

                    <div>

                        <div class="font-bold">
                            💻 E-book
                        </div>

                        <div class="text-xs text-slate-500">
                            Buku digital
                        </div>

                    </div>

                </label>

            </div>

        </div>


        {{-- =====================================================
            PRINT
        ====================================================== --}}

        <div
            id="print_section"
            class="rounded-xl border border-orange-200 bg-orange-50 p-5 space-y-4"
            style="display:none;"
        >

            <div>

                <h2 class="font-bold">
                    📚 Buku Cetak
                </h2>

                <p class="text-xs text-slate-500">
                    Atur harga Buku Cetak.
                </p>

            </div>


            <div>

                <label class="block text-sm font-semibold mb-1">
                    Harga Buku Cetak (Rp)
                </label>

                <input
                    id="print_price"
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="print_price"
                    value="{{ old('print_price', $book->print_price) }}"
                    class="w-full rounded border border-slate-300 p-2"
                >

            </div>


            <label class="inline-flex items-center gap-2">

                <input
                    id="has_print_discount"
                    type="checkbox"
                    name="has_print_discount"
                    value="1"
                    {{
                        old(
                            'has_print_discount',
                            $book->print_discounted_price !== null ? 1 : 0
                        )
                        ? 'checked'
                        : ''
                    }}
                >

                <span class="font-semibold text-sm">
                    Berikan diskon Buku Cetak
                </span>

            </label>


            <div
                id="print_discount_section"
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
                style="display:none;"
            >

                <div>

                    <label class="block text-sm font-semibold mb-1">
                        Diskon (%)
                    </label>

                    <input
                        id="print_discount_percent"
                        type="number"
                        step="0.01"
                        min="0"
                        max="70"
                        name="print_discount_percent"
                        value="{{ old('print_discount_percent', $book->print_discount_percent ?? 0) }}"
                        class="w-full rounded border border-slate-300 p-2"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold mb-1">
                        Harga Setelah Diskon
                    </label>

                    <input
                        id="print_final_price"
                        type="text"
                        readonly
                        class="w-full rounded border bg-white p-2 font-bold text-orange-600"
                    >

                </div>

            </div>

        </div>


        {{-- =====================================================
            EBOOK
        ====================================================== --}}

        <div
            id="ebook_section"
            class="rounded-xl border border-indigo-200 bg-indigo-50 p-5 space-y-4"
            style="display:none;"
        >

            <div>

                <h2 class="font-bold">
                    💻 E-book
                </h2>

                <p class="text-xs text-slate-500">
                    Atur harga E-book.
                </p>

            </div>


            <div>

                <label class="block text-sm font-semibold mb-1">
                    Harga E-book (Rp)
                </label>

                <input
                    id="ebook_price"
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="ebook_price"
                    value="{{ old('ebook_price', $book->ebook_price) }}"
                    class="w-full rounded border border-slate-300 p-2"
                >

            </div>


            <label class="inline-flex items-center gap-2">

                <input
                    id="has_ebook_discount"
                    type="checkbox"
                    name="has_ebook_discount"
                    value="1"
                    {{
                        old(
                            'has_ebook_discount',
                            $book->ebook_discounted_price !== null ? 1 : 0
                        )
                        ? 'checked'
                        : ''
                    }}
                >

                <span class="font-semibold text-sm">
                    Berikan diskon E-book
                </span>

            </label>


            <div
                id="ebook_discount_section"
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
                style="display:none;"
            >

                <div>

                    <label class="block text-sm font-semibold mb-1">
                        Diskon (%)
                    </label>

                    <input
                        id="ebook_discount_percent"
                        type="number"
                        step="0.01"
                        min="0"
                        max="70"
                        name="ebook_discount_percent"
                        value="{{ old('ebook_discount_percent', $book->ebook_discount_percent ?? 0) }}"
                        class="w-full rounded border border-slate-300 p-2"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold mb-1">
                        Harga Setelah Diskon
                    </label>

                    <input
                        id="ebook_final_price"
                        type="text"
                        readonly
                        class="w-full rounded border bg-white p-2 font-bold text-indigo-600"
                    >

                </div>

            </div>

        </div>


        {{-- =====================================================
            DETAIL
        ====================================================== --}}

        <div>

            <label class="block text-sm font-semibold mb-1">
                Kategori
            </label>

            <input
                type="text"
                name="category"
                value="{{ old('category', $book->category) }}"
                class="w-full rounded border border-slate-300 p-2"
            >

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>

                <label class="block text-sm font-semibold mb-1">
                    Jumlah Halaman
                </label>

                <input
                    type="number"
                    min="1"
                    name="pages"
                    value="{{ old('pages', $book->pages) }}"
                    class="w-full rounded border border-slate-300 p-2"
                >

            </div>


            <div>

                <label class="block text-sm font-semibold mb-1">
                    ISBN
                </label>

                <input
                    type="text"
                    name="isbn"
                    value="{{ old('isbn', $book->isbn) }}"
                    class="w-full rounded border border-slate-300 p-2"
                >

            </div>


            <div>

                <label class="block text-sm font-semibold mb-1">
                    Tahun Terbit
                </label>

                <input
                    type="number"
                    name="publish_year"
                    value="{{ old('publish_year', $book->publish_year) }}"
                    class="w-full rounded border border-slate-300 p-2"
                >

            </div>

        </div>


        <div>

            <label class="block text-sm font-semibold mb-1">
                Ukuran Buku
            </label>

            <input
                type="text"
                name="size"
                value="{{ old('size', $book->size) }}"
                class="w-full rounded border border-slate-300 p-2"
            >

        </div>


        <div>

            <label class="block text-sm font-semibold mb-1">
                Sinopsis / Deskripsi
            </label>

            <textarea
                name="description"
                rows="6"
                class="w-full rounded border border-slate-300 p-2"
            >{{ old('description', $book->description) }}</textarea>

        </div>


        @if($book->cover)

            <div class="rounded-xl border bg-slate-50 p-4">

                <p class="text-sm text-slate-500 mb-2">
                    Cover saat ini:
                </p>

                <img
                    src="{{ asset('storage/' . $book->cover) }}"
                    alt="{{ $book->title }}"
                    class="h-40 w-auto rounded-lg object-cover"
                >

            </div>

        @endif


        <div>

            <label class="block text-sm font-semibold mb-1">
                Upload Cover Baru
            </label>

            <input
                type="file"
                name="cover"
                accept="image/jpeg,image/png,image/webp"
                class="w-full text-sm text-slate-500"
            >

        </div>


        <div class="flex justify-between pt-4">

            <a
                href="{{ route('admin.books.index') }}"
                class="rounded border px-4 py-2 text-sm"
            >
                Batal
            </a>


            <button
                type="submit"
                class="rounded bg-orange-600 px-4 py-2 text-white font-semibold hover:bg-orange-700"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    function setupFormat(config) {

        const available =
            document.getElementById(
                config.available
            );

        const section =
            document.getElementById(
                config.section
            );

        const price =
            document.getElementById(
                config.price
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


        function calculate() {

            const base =
                parseFloat(
                    price.value
                ) || 0;


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
                Math.round(
                    result
                ).toLocaleString(
                    'id-ID'
                );
        }


        function updateDiscount() {

            const enabled =
                available.checked
                &&
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


            price.disabled =
                !enabled;


            price.required =
                enabled;


            discount.disabled =
                !enabled;


            if (!enabled) {

                discount.checked =
                    false;
            }


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


        price.addEventListener(
            'input',
            calculate
        );


        percent.addEventListener(
            'input',
            calculate
        );


        updateFormat();
    }


    setupFormat({

        available:
            'has_print',

        section:
            'print_section',

        price:
            'print_price',

        discount:
            'has_print_discount',

        discountSection:
            'print_discount_section',

        percent:
            'print_discount_percent',

        finalPrice:
            'print_final_price'

    });


    setupFormat({

        available:
            'has_ebook',

        section:
            'ebook_section',

        price:
            'ebook_price',

        discount:
            'has_ebook_discount',

        discountSection:
            'ebook_discount_section',

        percent:
            'ebook_discount_percent',

        finalPrice:
            'ebook_final_price'

    });

});

</script>

@endsection