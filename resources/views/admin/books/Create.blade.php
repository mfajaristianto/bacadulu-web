@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">
        Tambah Buku Baru
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
        action="{{ route('admin.books.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-xl border p-6 shadow-sm space-y-6"
    >

        @csrf


        {{-- =====================================================
            INFORMASI DASAR
        ====================================================== --}}

        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Judul Buku
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
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
                    value="{{ old('author') }}"
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
                    value="{{ old('publisher') }}"
                    required
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>

        </div>


        {{-- =====================================================
            FORMAT
        ====================================================== --}}

        <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">

            <h2 class="font-bold text-slate-900">
                Format Buku
            </h2>

            <p class="mt-1 mb-4 text-xs text-slate-500">
                Anda dapat memilih Buku Cetak, E-book, atau keduanya sekaligus.
            </p>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- CETAK --}}

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 cursor-pointer">

                    <input
                        id="has_print"
                        type="checkbox"
                        name="has_print"
                        value="1"
                        {{ old('has_print') ? 'checked' : '' }}
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <div>

                        <div class="font-bold text-slate-900">
                            📚 Buku Cetak
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            Buku fisik yang akan dikirim kepada pembeli.
                        </div>

                    </div>

                </label>


                {{-- EBOOK --}}

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 cursor-pointer">

                    <input
                        id="has_ebook"
                        type="checkbox"
                        name="has_ebook"
                        value="1"
                        {{ old('has_ebook') ? 'checked' : '' }}
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <div>

                        <div class="font-bold text-slate-900">
                            💻 E-book
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            Buku digital dengan harga tersendiri.
                        </div>

                    </div>

                </label>

            </div>

        </div>


        {{-- =====================================================
            BUKU CETAK
        ====================================================== --}}

        <div
            id="print_section"
            class="rounded-xl border border-orange-200 bg-orange-50 p-5 space-y-4"
            style="display:none;"
        >

            <div>

                <h2 class="font-bold text-slate-900">
                    📚 Buku Cetak
                </h2>

                <p class="text-xs text-slate-500 mt-1">
                    Harga dan diskon khusus Buku Cetak.
                </p>

            </div>


            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Harga Buku Cetak (Rp)
                </label>

                <input
                    id="print_price"
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="print_price"
                    value="{{ old('print_price') }}"
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>


            <div class="border-t border-orange-200 pt-4">

                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">

                    <input
                        id="has_print_discount"
                        type="checkbox"
                        name="has_print_discount"
                        value="1"
                        {{ old('has_print_discount') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <span>
                        Berikan diskon Buku Cetak
                    </span>

                </label>

            </div>


            <div
                id="print_discount_section"
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
                style="display:none;"
            >

                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Diskon Buku Cetak (%)
                    </label>

                    <input
                        id="print_discount_percent"
                        type="number"
                        step="0.01"
                        min="0"
                        max="70"
                        name="print_discount_percent"
                        value="{{ old('print_discount_percent', 0) }}"
                        class="w-full rounded border border-slate-300 p-2 text-sm"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Harga Setelah Diskon
                    </label>

                    <input
                        id="print_final_price"
                        type="text"
                        readonly
                        class="w-full rounded border border-orange-200 bg-white p-2 text-sm font-bold text-orange-600"
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

                <h2 class="font-bold text-slate-900">
                    💻 E-book
                </h2>

                <p class="text-xs text-slate-500 mt-1">
                    Harga dan diskon khusus E-book.
                </p>

            </div>


            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Harga E-book (Rp)
                </label>

                <input
                    id="ebook_price"
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="ebook_price"
                    value="{{ old('ebook_price') }}"
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>


            <div class="border-t border-indigo-200 pt-4">

                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">

                    <input
                        id="has_ebook_discount"
                        type="checkbox"
                        name="has_ebook_discount"
                        value="1"
                        {{ old('has_ebook_discount') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                    >

                    <span>
                        Berikan diskon E-book
                    </span>

                </label>

            </div>


            <div
                id="ebook_discount_section"
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
                style="display:none;"
            >

                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Diskon E-book (%)
                    </label>

                    <input
                        id="ebook_discount_percent"
                        type="number"
                        step="0.01"
                        min="0"
                        max="70"
                        name="ebook_discount_percent"
                        value="{{ old('ebook_discount_percent', 0) }}"
                        class="w-full rounded border border-slate-300 p-2 text-sm"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Harga Setelah Diskon
                    </label>

                    <input
                        id="ebook_final_price"
                        type="text"
                        readonly
                        class="w-full rounded border border-indigo-200 bg-white p-2 text-sm font-bold text-indigo-600"
                    >

                </div>

            </div>

        </div>


        {{-- =====================================================
            DETAIL BUKU
        ====================================================== --}}

        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Kategori Buku
            </label>

            <input
                type="text"
                name="category"
                value="{{ old('category') }}"
                class="w-full rounded border border-slate-300 p-2 text-sm"
            >

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Jumlah Halaman
                </label>

                <input
                    type="number"
                    min="1"
                    name="pages"
                    value="{{ old('pages') }}"
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>


            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    ISBN
                </label>

                <input
                    type="text"
                    name="isbn"
                    value="{{ old('isbn') }}"
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>


            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Tahun Terbit
                </label>

                <input
                    type="number"
                    name="publish_year"
                    value="{{ old('publish_year') }}"
                    class="w-full rounded border border-slate-300 p-2 text-sm"
                >

            </div>

        </div>


        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Ukuran Buku
            </label>

            <input
                type="text"
                name="size"
                value="{{ old('size') }}"
                class="w-full rounded border border-slate-300 p-2 text-sm"
            >

        </div>


        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Sinopsis / Deskripsi Buku
            </label>

            <textarea
                name="description"
                rows="6"
                class="w-full rounded border border-slate-300 p-2 text-sm"
            >{{ old('description') }}</textarea>

        </div>


        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Upload Cover Buku
            </label>

            <input
                type="file"
                name="cover"
                accept="image/jpeg,image/png,image/webp"
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
            >

        </div>


        <div class="flex justify-between gap-2 pt-4">

            <a
                href="{{ route('admin.books.index') }}"
                class="rounded border px-4 py-2 text-sm text-slate-600"
            >
                Batal
            </a>


            <button
                type="submit"
                class="rounded bg-orange-600 px-4 py-2 text-sm text-white font-semibold hover:bg-orange-700"
            >
                Simpan Buku
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