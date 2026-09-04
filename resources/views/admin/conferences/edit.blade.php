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
                    Edit Conference
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                    Perbarui informasi conference yang tampil pada katalog Baca Conference.
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
                    Perubahan belum dapat disimpan
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
            action="{{ route('admin.conferences.update', $conference) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')


            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">

                <div class="space-y-6">

                    {{-- IDENTITAS --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h2 class="text-base font-extrabold text-slate-900">
                                Identitas Conference
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Nama dan edisi akan tampil sebagai satu identitas conference.
                            </p>
                        </div>


                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-[minmax(0,1fr)_180px]">

                            <div>
                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Nama Conference
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $conference->name) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >
                            </div>


                            <div>
                                <label
                                    for="edition"
                                    class="mb-2 block text-sm font-bold text-slate-700"
                                >
                                    Edisi
                                </label>

                                <input
                                    type="text"
                                    id="edition"
                                    name="edition"
                                    value="{{ old('edition', $conference->edition) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >
                            </div>

                        </div>


                        <div class="mt-4 rounded-xl border border-[#F1EAE5] bg-[#FFF9F5] px-4 py-3">
                            <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">
                                Tampilan saat ini
                            </p>

                            <p
                                id="conferenceNamePreview"
                                class="mt-1 text-sm font-extrabold text-[#241B52]"
                            >
                                {{ trim(($conference->name ?? '') . ' ' . ($conference->edition ?? '')) }}
                            </p>
                        </div>
                    </section>


                    {{-- DESCRIPTION --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-4">
                            <h2 class="text-base font-extrabold text-slate-900">
                                Deskripsi Conference
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Perbarui deskripsi singkat conference bila diperlukan.
                            </p>
                        </div>

                        @include('admin.partials.rich-text-editor', [
                            'name' => 'description',
                            'label' => 'Deskripsi',
                            'value' => old('description', $conference->description)
                        ])
                    </section>


                    {{-- LINKS --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h2 class="text-base font-extrabold text-slate-900">
                                Tautan Conference
                            </h2>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Pastikan tautan mengarah ke halaman conference dan prosiding yang benar.
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
                                    value="{{ old('conference_url', $conference->conference_url) }}"
                                    placeholder="https://..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                                @if($conference->conference_url)
                                    <a
                                        href="{{ $conference->conference_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-2 inline-flex text-[11px] font-bold text-orange-600 hover:underline"
                                    >
                                        Buka Conference ↗
                                    </a>
                                @endif
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
                                    value="{{ old('proceeding_url', $conference->proceeding_url) }}"
                                    placeholder="https://..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-50"
                                >

                                @if($conference->proceeding_url)
                                    <a
                                        href="{{ $conference->proceeding_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-2 inline-flex text-[11px] font-bold text-orange-600 hover:underline"
                                    >
                                        Buka Prosiding ↗
                                    </a>
                                @endif
                            </div>

                        </div>
                    </section>

                </div>


                {{-- POSTER --}}
                <aside>
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:sticky lg:top-6">

                        <div class="mb-4">
                            <h2 class="text-sm font-extrabold text-slate-900">
                                Poster Conference
                            </h2>

                            <p class="mt-1 text-[11px] leading-relaxed text-slate-500">
                                Biarkan kosong jika poster tidak ingin diganti.
                            </p>
                        </div>


                        <div class="mb-4 flex min-h-[285px] items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-3">

                            @if($conference->poster)

                                <img
                                    id="posterPreview"
                                    src="{{ asset('storage/' . $conference->poster) }}"
                                    alt="{{ $conference->name }}"
                                    class="max-h-[320px] max-w-full object-contain"
                                >

                                <div
                                    id="posterPlaceholder"
                                    class="hidden text-center"
                                >
                                    Preview poster
                                </div>

                            @else

                                <div
                                    id="posterPlaceholder"
                                    class="px-5 text-center"
                                >
                                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-orange-50 text-orange-500">
                                        <svg
                                            viewBox="0 0 24 24"
                                            class="h-5 w-5 fill-none stroke-current"
                                            stroke-width="1.7"
                                        >
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <path d="m3 16 5-5 4 4 3-3 6 6"/>
                                        </svg>
                                    </div>

                                    <p class="text-xs font-bold text-slate-600">
                                        Belum ada poster
                                    </p>
                                </div>

                                <img
                                    id="posterPreview"
                                    src=""
                                    alt="Preview poster"
                                    class="hidden max-h-[320px] max-w-full object-contain"
                                >

                            @endif

                        </div>


                        <label
                            for="poster"
                            class="mb-2 block text-xs font-bold text-slate-700"
                        >
                            Ganti Poster
                        </label>

                        <input
                            type="file"
                            id="poster"
                            name="poster"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-50 file:px-3 file:py-2 file:text-xs file:font-bold file:text-orange-700 hover:file:bg-orange-100"
                        >


                        @if($conference->poster)
                            <a
                                href="{{ asset('storage/' . $conference->poster) }}"
                                target="_blank"
                                class="mt-3 inline-flex text-[11px] font-bold text-orange-600 hover:underline"
                            >
                                Lihat poster asli ↗
                            </a>
                        @endif

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
                    Simpan Perubahan
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


    const input = document.getElementById('poster');
    const preview = document.getElementById('posterPreview');
    const placeholder = document.getElementById('posterPlaceholder');

    if (!input || !preview || !placeholder) return;

    let objectUrl = null;

    input.addEventListener('change', () => {
        const file = input.files?.[0];

        if (!file) return;

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
        }

        objectUrl = URL.createObjectURL(file);

        preview.src = objectUrl;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    });
})();
</script>

@endsection