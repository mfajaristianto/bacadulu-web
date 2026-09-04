@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">

        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2">
                    <span class="h-[3px] w-7 rounded-full bg-orange-500"></span>
                    <span class="text-[10px] font-bold uppercase tracking-[.14em] text-orange-600">
                        Katalog Baca
                    </span>
                </div>

                <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">
                    Tambah Conference
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                    Tambahkan seri conference yang akan ditampilkan pada halaman Baca Conference.
                </p>
            </div>

            <a
                href="{{ route('admin.conferences.index') }}"
                class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
            >
                ← Kembali
            </a>
        </div>


        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="mb-2 text-sm font-bold text-red-700">
                    Data belum dapat disimpan
                </p>

                <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form
            method="POST"
            action="{{ route('admin.conferences.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">

                <div class="space-y-6">

                    {{-- IDENTITAS --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h2 class="text-base font-extrabold text-slate-900">
                                Identitas Conference
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Nama dan edisi akan digabungkan otomatis, misalnya INACEMBA #1 atau SINDU #2.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-[minmax(0,1fr)_180px]">
                            <div>
                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Nama Conference
                                    <span class="text-orange-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: INACEMBA"
                                    required
                                    autofocus
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >
                            </div>

                            <div>
                                <label
                                    for="edition"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Edisi
                                    <span class="text-orange-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edition"
                                    name="edition"
                                    value="{{ old('edition') }}"
                                    placeholder="Contoh: #1"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >
                            </div>
                        </div>


                        <div class="mt-4 rounded-xl border border-[#F1EAE5] bg-[#FFF9F5] px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">
                                Contoh tampilan
                            </p>

                            <p
                                id="conferenceNamePreview"
                                class="mt-1 text-sm font-extrabold text-[#241B52]"
                            >
                                Nama Conference #Edisi
                            </p>
                        </div>
                    </section>


                    {{-- DESKRIPSI --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-4">
                            <h2 class="text-base font-extrabold text-slate-900">
                                Deskripsi Conference
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Jelaskan secara singkat fokus atau cakupan conference.
                            </p>
                        </div>

                        @include('admin.partials.rich-text-editor', [
                            'name' => 'description',
                            'label' => 'Deskripsi',
                            'value' => old('description')
                        ])
                    </section>


                    {{-- LINKS --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h2 class="text-base font-extrabold text-slate-900">
                                Tautan Conference
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Kedua link ini akan menjadi tombol pada halaman publik.
                            </p>
                        </div>

                        <div class="space-y-5">

                            <div>
                                <label
                                    for="conference_url"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    URL Conference
                                </label>

                                <input
                                    type="url"
                                    id="conference_url"
                                    name="conference_url"
                                    value="{{ old('conference_url') }}"
                                    placeholder="https://..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                                <div class="mt-2 flex items-center gap-2">
                                    <span class="rounded-md bg-[#FFF7EF] px-2 py-1 text-[10px] font-bold text-[#241B52]">
                                        Tombol
                                    </span>

                                    <span class="text-[11px] text-slate-400">
                                        Lihat Conference
                                    </span>
                                </div>
                            </div>


                            <div>
                                <label
                                    for="proceeding_url"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    URL Prosiding
                                </label>

                                <input
                                    type="url"
                                    id="proceeding_url"
                                    name="proceeding_url"
                                    value="{{ old('proceeding_url') }}"
                                    placeholder="https://..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                                <div class="mt-2 flex items-center gap-2">
                                    <span class="rounded-md bg-[#FFF4D9] px-2 py-1 text-[10px] font-bold text-[#241B52]">
                                        Tombol
                                    </span>

                                    <span class="text-[11px] text-slate-400">
                                        Lihat Prosiding
                                    </span>
                                </div>
                            </div>

                        </div>
                    </section>

                </div>


                {{-- POSTER --}}
                <aside class="space-y-5">
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:sticky lg:top-6">
                        <div class="mb-4">
                            <h2 class="text-sm font-extrabold text-slate-900">
                                Poster Conference
                            </h2>

                            <p class="mt-1 text-[11px] leading-relaxed text-slate-500">
                                Poster ini akan tampil pada kartu Baca Conference.
                            </p>
                        </div>


                        <div class="mb-4 flex min-h-[285px] items-center justify-center overflow-hidden rounded-xl border border-dashed border-slate-300 bg-slate-50 p-3">

                            <div id="posterPlaceholder" class="px-5 text-center">
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
                                    Preview poster
                                </p>

                                <p class="mt-1 text-[10px] leading-relaxed text-slate-400">
                                    Poster akan muncul di sini setelah dipilih.
                                </p>
                            </div>


                            <img
                                id="posterPreview"
                                src=""
                                alt="Preview poster"
                                class="hidden max-h-[320px] max-w-full object-contain"
                            >

                        </div>


                        <label
                            for="poster"
                            class="mb-2 block text-xs font-bold text-slate-700"
                        >
                            Pilih Poster
                        </label>

                        <input
                            type="file"
                            id="poster"
                            name="poster"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-50 file:px-3 file:py-2 file:text-xs file:font-bold file:text-orange-700 hover:file:bg-orange-100"
                        >

                        <p class="mt-2 text-[10px] leading-relaxed text-slate-400">
                            JPG, PNG, atau WebP. Maksimal 6 MB.
                        </p>
                    </section>
                </aside>

            </div>


            <div class="mt-6 flex flex-col-reverse gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <a
                    href="{{ route('admin.conferences.index') }}"
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

                    Simpan Conference
                </button>
            </div>

        </form>

    </div>
</div>


<script>
(() => {
    const name = document.getElementById('name');
    const edition = document.getElementById('edition');
    const namePreview = document.getElementById('conferenceNamePreview');

    const updateNamePreview = () => {
        const conferenceName = name?.value.trim() || 'Nama Conference';
        const conferenceEdition = edition?.value.trim() || '#Edisi';

        if (namePreview) {
            namePreview.textContent = `${conferenceName} ${conferenceEdition}`;
        }
    };

    name?.addEventListener('input', updateNamePreview);
    edition?.addEventListener('input', updateNamePreview);
    updateNamePreview();


    const input = document.getElementById('poster');
    const preview = document.getElementById('posterPreview');
    const placeholder = document.getElementById('posterPlaceholder');

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