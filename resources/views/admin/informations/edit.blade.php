@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-8">

    <div class="mb-6">
        <p class="mb-1 text-xs font-bold uppercase tracking-wider text-orange-600">
            Baca Informasi
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            Edit Informasi
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Perbarui isi dan pengaturan informasi website.
        </p>
    </div>


    @if($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form
        method="POST"
        action="{{ route('admin.informations.update', $information) }}"
        enctype="multipart/form-data"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        @csrf
        @method('PUT')

        <div class="h-1 bg-gradient-to-r from-orange-600 via-orange-500 to-amber-400"></div>


        <div class="space-y-6 p-6 md:p-7">

            {{-- Judul --}}
            <div>
                <label
                    for="title"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Judul Informasi
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $information->title) }}"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100"
                >
            </div>


            {{-- Konten --}}
            <div>
                @include('admin.partials.rich-text-editor', [
                    'name' => 'content',
                    'label' => 'Konten',
                    'value' => old('content', $information->content),
                ])
            </div>


            {{-- Gambar --}}
            <div>
                <label
                    for="image"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Gambar Informasi
                </label>


                @if($information->image)
                    <div class="mb-3 w-44 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                        <img
                            src="{{ asset('storage/' . $information->image) }}"
                            alt="{{ $information->title }}"
                            class="aspect-video w-full object-cover"
                        >
                    </div>
                @endif


                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:font-semibold file:text-orange-700"
                >

                <p class="mt-2 text-xs text-slate-400">
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>
            </div>


            {{-- PIN --}}
            <div
                class="
                    rounded-2xl border p-4
                    {{ $information->is_pinned
                        ? 'border-orange-300 bg-orange-50'
                        : 'border-slate-200 bg-slate-50'
                    }}
                "
            >

                <label
                    for="is_pinned"
                    class="flex cursor-pointer items-start gap-3"
                >
                    <input
                        type="checkbox"
                        id="is_pinned"
                        name="is_pinned"
                        value="1"
                        @checked(old('is_pinned', $information->is_pinned))
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <span>
                        <span class="flex items-center gap-2 text-sm font-bold text-slate-900">

                            <svg
                                class="h-4 w-4 text-orange-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M14 4l6 6-3 1-4 4-1 5-3-3-4 4-2-2 4-4-3-3 5-1 4-4z"/>
                            </svg>

                            Jadikan Informasi Pilihan

                            @if($information->is_pinned)
                                <span class="rounded-full bg-orange-600 px-2 py-0.5 text-[10px] font-bold text-white">
                                    AKTIF
                                </span>
                            @endif

                        </span>

                        <span class="mt-1 block text-xs leading-relaxed text-slate-500">
                            Hanya satu informasi yang dapat menjadi informasi
                            pilihan. Memilih informasi ini akan melepas pin
                            dari informasi sebelumnya.
                        </span>
                    </span>
                </label>

            </div>


            {{-- Button --}}
            <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">

                <button
                    type="submit"
                    class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.informations.index') }}"
                    class="rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                >
                    Batal
                </a>

            </div>

        </div>

    </form>

</div>
@endsection