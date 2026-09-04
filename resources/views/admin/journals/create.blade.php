@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50">

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-2 flex items-center gap-2">
                    <span class="h-[3px] w-7 rounded-full bg-orange-500"></span>

                    <span class="text-[10px] font-bold uppercase tracking-[.14em] text-orange-600">
                        Katalog Baca
                    </span>
                </div>

                <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">
                    Tambah Jurnal
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                    Tambahkan informasi jurnal yang nantinya ditampilkan pada katalog Baca Jurnal.
                </p>

            </div>


            <a
                href="{{ route('admin.journals.index') }}"
                class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
            >
                ← Kembali
            </a>

        </div>


        {{-- =====================================================
             ERRORS
        ====================================================== --}}
        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="mb-2 flex items-center gap-2 text-sm font-bold text-red-700">

                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-xs">
                        !
                    </span>

                    Data belum dapat disimpan

                </div>

                <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('admin.journals.store') }}"
            enctype="multipart/form-data"
            id="journalForm"
        >

            @csrf


            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">


                {{-- =====================================================
                     LEFT
                ====================================================== --}}
                <div class="space-y-6">


                    {{-- =================================================
                         INFORMASI UTAMA
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="mb-5">

                            <h2 class="text-base font-extrabold text-slate-900">
                                Informasi Jurnal
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Isi nama jurnal dan nomor ISSN jika sudah tersedia.
                            </p>

                        </div>


                        <div class="space-y-5">

                            <div>

                                <label
                                    for="judul"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Nama Jurnal
                                    <span class="text-orange-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="judul"
                                    name="judul"
                                    value="{{ old('judul') }}"
                                    required
                                    autofocus
                                    placeholder="Contoh: MIX Jurnal Ilmiah Manajemen"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                            </div>


                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                <div>

                                    <label
                                        for="e_issn"
                                        class="mb-2 block text-sm font-bold text-slate-700"
                                    >
                                        E-ISSN
                                    </label>

                                    <input
                                        type="text"
                                        id="e_issn"
                                        name="e_issn"
                                        value="{{ old('e_issn') }}"
                                        placeholder="Contoh: 2798-6691"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                    >

                                    <p class="mt-1.5 text-[11px] text-slate-400">
                                        ISSN versi elektronik.
                                    </p>

                                </div>


                                <div>

                                    <label
                                        for="p_issn"
                                        class="mb-2 block text-sm font-bold text-slate-700"
                                    >
                                        P-ISSN
                                    </label>

                                    <input
                                        type="text"
                                        id="p_issn"
                                        name="p_issn"
                                        value="{{ old('p_issn') }}"
                                        placeholder="Contoh: 2338-1234"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                    >

                                    <p class="mt-1.5 text-[11px] text-slate-400">
                                        ISSN versi cetak jika tersedia.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         WEBSITE
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="mb-5 flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F3F0FA] text-[#241B52]">

                                <svg
                                    viewBox="0 0 24 24"
                                    class="h-4 w-4 fill-none stroke-current"
                                    stroke-width="1.8"
                                >
                                    <path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1"/>
                                    <path d="M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.1-1.1"/>
                                </svg>

                            </div>

                            <div>

                                <h2 class="text-base font-extrabold text-slate-900">
                                    Website Jurnal
                                </h2>

                                <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                    Link ini digunakan pada dua tombol di halaman publik.
                                </p>

                            </div>

                        </div>


                        <div class="space-y-5">

                            <div>

                                <label
                                    for="journal_url"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    URL Jurnal
                                </label>

                                <input
                                    type="url"
                                    id="journal_url"
                                    name="journal_url"
                                    value="{{ old('journal_url') }}"
                                    placeholder="https://journal.bacadulu.net/index.php/nama-jurnal"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                                <div class="mt-2 flex items-center gap-2">

                                    <span class="rounded-md bg-[#FFF7EF] px-2 py-1 text-[10px] font-bold text-[#241B52]">
                                        Tombol
                                    </span>

                                    <span class="text-[11px] text-slate-400">
                                        Lihat Jurnal
                                    </span>

                                </div>

                            </div>


                            <div>

                                <label
                                    for="current_issue_url"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    URL Edisi Terkini
                                </label>

                                <input
                                    type="url"
                                    id="current_issue_url"
                                    name="current_issue_url"
                                    value="{{ old('current_issue_url') }}"
                                    placeholder="https://journal.bacadulu.net/index.php/nama-jurnal/issue/current"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                                <div class="mt-2 flex items-center gap-2">

                                    <span class="rounded-md bg-[#FFF4D9] px-2 py-1 text-[10px] font-bold text-[#241B52]">
                                        Tombol
                                    </span>

                                    <span class="text-[11px] text-slate-400">
                                        Edisi Terkini
                                    </span>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="mb-4">

                            <h2 class="text-base font-extrabold text-slate-900">
                                Deskripsi Jurnal
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Tulis gambaran singkat mengenai fokus, scope, atau karakter jurnal.
                            </p>

                        </div>

                        @include('admin.partials.rich-text-editor', [
                            'name' => 'deskripsi',
                            'label' => 'Deskripsi',
                            'value' => old('deskripsi')
                        ])

                    </section>

                </div>


                {{-- =====================================================
                     RIGHT
                ====================================================== --}}
                <aside class="space-y-5">


                    {{-- =================================================
                         COVER
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="mb-4">

                            <h2 class="text-sm font-extrabold text-slate-900">
                                Cover Jurnal
                            </h2>

                            <p class="mt-1 text-[11px] leading-relaxed text-slate-500">
                                Upload cover atau identitas visual jurnal.
                            </p>

                        </div>


                        <div
                            id="coverPreviewBox"
                            class="mb-4 flex min-h-[250px] items-center justify-center overflow-hidden rounded-xl border border-dashed border-slate-300 bg-slate-50"
                        >

                            <div
                                id="coverPlaceholder"
                                class="px-5 text-center"
                            >

                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-orange-50 text-orange-500">

                                    <svg
                                        viewBox="0 0 24 24"
                                        class="h-5 w-5 fill-none stroke-current"
                                        stroke-width="1.7"
                                    >
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="m21 15-5-5L5 21"/>
                                    </svg>

                                </div>

                                <p class="text-xs font-bold text-slate-600">
                                    Preview cover
                                </p>

                                <p class="mt-1 text-[10px] leading-relaxed text-slate-400">
                                    Cover akan muncul di sini setelah dipilih.
                                </p>

                            </div>


                            <img
                                id="coverPreview"
                                src=""
                                alt="Preview cover"
                                class="hidden max-h-[300px] w-auto max-w-full object-contain"
                            >

                        </div>


                        <label
                            for="gambar"
                            class="mb-2 block text-xs font-bold text-slate-700"
                        >
                            Pilih Cover
                        </label>

                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-50 file:px-3 file:py-2 file:text-xs file:font-bold file:text-orange-700 hover:file:bg-orange-100"
                        >

                        <p class="mt-2 text-[10px] leading-relaxed text-slate-400">
                            JPG, PNG, atau WebP. Maksimal 4 MB.
                        </p>

                    </section>


                    {{-- =================================================
                         CHECKLIST
                    ================================================== --}}
                    <section class="rounded-2xl border border-[#EEE9F6] bg-[#F8F6FC] p-5">

                        <h3 class="text-xs font-extrabold text-[#241B52]">
                            Sebelum disimpan
                        </h3>

                        <div class="mt-4 space-y-3 text-[11px] text-slate-600">

                            <div class="flex gap-2">
                                <span class="font-bold text-orange-500">✓</span>
                                Nama jurnal sudah benar
                            </div>

                            <div class="flex gap-2">
                                <span class="font-bold text-orange-500">✓</span>
                                ISSN diisi jika tersedia
                            </div>

                            <div class="flex gap-2">
                                <span class="font-bold text-orange-500">✓</span>
                                Link jurnal mengarah ke website yang benar
                            </div>

                            <div class="flex gap-2">
                                <span class="font-bold text-orange-500">✓</span>
                                Cover jurnal sudah sesuai
                            </div>

                        </div>

                    </section>

                </aside>

            </div>


            {{-- =====================================================
                 ACTION
            ====================================================== --}}
            <div class="mt-6 flex flex-col-reverse gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('admin.journals.index') }}"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-slate-100 px-5 text-sm font-bold text-slate-600 transition hover:bg-slate-200"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-orange-600 px-6 text-sm font-extrabold text-white shadow-sm transition hover:bg-orange-700"
                >

                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4 fill-none stroke-current"
                        stroke-width="2"
                    >
                        <path d="M5 12l4 4L19 6"/>
                    </svg>

                    Simpan Jurnal

                </button>

            </div>

        </form>

    </div>

</div>


<script>
(() => {
    const input = document.getElementById('gambar');
    const preview = document.getElementById('coverPreview');
    const placeholder = document.getElementById('coverPlaceholder');

    if (!input || !preview || !placeholder) return;

    let objectUrl = null;

    input.addEventListener('change', () => {
        const file = input.files?.[0];

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }

        if (!file) {
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            return;
        }

        objectUrl = URL.createObjectURL(file);

        preview.src = objectUrl;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    });
})();
</script>

@endsection