@extends('layouts.admin')

@section('content')

<div class="mx-auto max-w-4xl px-4 py-8">

    {{-- HEADER --}}
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-wider text-orange-600">
            Bookstore
        </p>

        <h1 class="mt-1 text-2xl font-bold text-slate-900">
            Tambah Buku Baru
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Isi informasi buku lalu pilih format yang akan tersedia di Bookstore.
        </p>
    </div>


    {{-- ERRORS --}}
    @if($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <p class="mb-2 font-semibold">
                Terjadi kesalahan:
            </p>

            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    <form
        action="{{ route('admin.books.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >
        @csrf


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
                    Data berikut berlaku untuk E-Book maupun Buku Cetak.
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
                        value="{{ old('title') }}"
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
                            value="{{ old('author') }}"
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
                            value="{{ old('publisher') }}"
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
                            value="{{ old('category') }}"
                            placeholder="Contoh: Pendidikan"
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
                            value="{{ old('pages') }}"
                            placeholder="Contoh: 180"
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
                            value="{{ old('publish_year') }}"
                            placeholder="{{ now()->year }}"
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
                    >{{ old('description') }}</textarea>

                </div>


                {{-- COVER --}}
                <div>

                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Upload Cover Buku
                    </label>

                    <input
                        type="file"
                        name="cover"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2 text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-orange-700 hover:file:bg-orange-100"
                    >

                    <p class="mt-1.5 text-[10px] text-slate-400">
                        Minimal 900 × 1200 px. Disarankan 1200 × 1600 px.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             PILIH FORMAT
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
                    Pilih Buku Cetak, E-Book, atau keduanya. Form akan menyesuaikan otomatis.
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
                            @checked(old('has_print'))
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                        >

                        <div>

                            <div class="font-bold text-slate-900">
                                📚 Buku Cetak
                            </div>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Buku fisik dengan ISBN, ukuran, harga dan stok.
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
                            @checked(old('has_ebook'))
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        >

                        <div>

                            <div class="font-bold text-slate-900">
                                💻 E-Book
                            </div>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Buku digital dengan ISBN dan harga tersendiri.
                            </p>

                        </div>

                    </div>

                </label>

            </div>

        </section>


        {{-- =====================================================
             BUKU CETAK
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
                    Informasi khusus buku fisik. Ukuran buku hanya muncul pada format ini.
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
                        value="{{ old('print_isbn') }}"
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
                        value="{{ old('size') }}"
                        placeholder="Contoh: 14 × 20 cm"
                        class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                    >

                    <p class="mt-1 text-[10px] text-slate-500">
                        Tidak digunakan untuk E-Book.
                    </p>

                </div>

            </div>


            {{-- PRINT PRICE --}}
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
                        value="{{ old('print_price') }}"
                    >

                </div>

                <p class="mt-1 text-[10px] text-slate-400">
                    Contoh: IDR 200.000,00
                </p>

            </div>


            {{-- STOCK --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Stok Awal Buku Cetak
                </label>

                <input
                    type="number"
                    name="print_stock"
                    min="0"
                    max="1000000"
                    step="1"
                    value="{{ old('print_stock', 0) }}"
                    class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-800 outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100"
                >

                <p class="mt-1 text-[10px] text-slate-500">
                    Nilai 0 otomatis ditampilkan sebagai <strong>Stok Habis</strong>.
                </p>

            </div>


            {{-- PRINT DISCOUNT --}}
            <div class="border-t border-orange-200 pt-4">

                <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">

                    <input
                        id="has_print_discount"
                        type="checkbox"
                        name="has_print_discount"
                        value="1"
                        @checked(old('has_print_discount'))
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
                        value="{{ old('print_discount_percent', 0) }}"
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
             E-BOOK
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
                    E-Book tidak membutuhkan ukuran fisik maupun stok cetak.
                </p>

            </div>


            {{-- EBOOK ISBN --}}
            <div>

                <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                    ISBN E-Book
                </label>

                <input
                    type="text"
                    name="ebook_isbn"
                    value="{{ old('ebook_isbn') }}"
                    placeholder="Contoh: 978-xxx-xxx-xxx-x"
                    class="w-full rounded-xl border border-indigo-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                >

            </div>


            {{-- EBOOK PRICE --}}
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
                        value="{{ old('ebook_price') }}"
                    >

                </div>

                <p class="mt-1 text-[10px] text-slate-400">
                    Contoh: IDR 75.000,00
                </p>

            </div>


            {{-- EBOOK DISCOUNT --}}
            <div class="border-t border-indigo-200 pt-4">

                <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-700">

                    <input
                        id="has_ebook_discount"
                        type="checkbox"
                        name="has_ebook_discount"
                        value="1"
                        @checked(old('has_ebook_discount'))
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
                        value="{{ old('ebook_discount_percent', 0) }}"
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


        {{-- ACTION --}}
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
                Simpan Buku
            </button>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | FORMAT IDR
    |--------------------------------------------------------------------------
    */

    function formatIDR(value, decimal = true) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: decimal ? 2 : 0,
            maximumFractionDigits: decimal ? 2 : 0
        }).format(Number(value || 0));
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


    function setupMoneyInput(display, raw) {

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
                        ? formatIDR(value, false)
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
                    parseIDR(this.value);

                raw.value =
                    value > 0
                        ? value
                        : '';

                this.value =
                    value > 0
                        ? formatIDR(value, false)
                        : '';

                raw.dispatchEvent(
                    new Event('input')
                );
            }
        );


        display.addEventListener(
            'blur',
            function () {

                const value =
                    Number(raw.value || 0);

                this.value =
                    value > 0
                        ? formatIDR(value)
                        : '';
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT CONTROLLER
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
                Number(rawPrice.value || 0);

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
                (base * pct / 100);

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
    | PRINT
    |--------------------------------------------------------------------------
    */

    setupFormat({
        available: 'has_print',
        card: 'print_format_card',
        section: 'print_section',
        price: 'print_price',
        displayPrice: 'print_price_display',
        discount: 'has_print_discount',
        discountSection: 'print_discount_section',
        percent: 'print_discount_percent',
        finalPrice: 'print_final_price',
        activeBorder: 'border-orange-400',
        activeBackground: 'bg-orange-50'
    });


    /*
    |--------------------------------------------------------------------------
    | EBOOK
    |--------------------------------------------------------------------------
    */

    setupFormat({
        available: 'has_ebook',
        card: 'ebook_format_card',
        section: 'ebook_section',
        price: 'ebook_price',
        displayPrice: 'ebook_price_display',
        discount: 'has_ebook_discount',
        discountSection: 'ebook_discount_section',
        percent: 'ebook_discount_percent',
        finalPrice: 'ebook_final_price',
        activeBorder: 'border-indigo-400',
        activeBackground: 'bg-indigo-50'
    });

});
</script>

@endsection