@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-8">
    <div class="mb-6">
        <p class="mb-1 text-xs font-bold uppercase tracking-[.16em] text-orange-600">Baca Publisher</p>
        <h1 class="text-3xl font-bold text-slate-900">Tambah Buku Publisher</h1>
        <p class="mt-1 text-sm text-slate-500">
            Buku manual juga disimpan sebagai Pending terlebih dahulu agar alurnya sama dengan data API nanti.
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
        action="{{ route('admin.publishers.store') }}"
        enctype="multipart/form-data"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        @csrf
        <div class="h-1 bg-gradient-to-r from-orange-600 via-orange-500 to-amber-400"></div>

        <div class="space-y-6 p-6 md:p-7">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Judul Buku</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Penulis</label>
                    <input type="text" name="author" value="{{ old('author') }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher', 'Baca Dulu') }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Jenis / Kategori Buku</label>
                    <input type="text" name="category" value="{{ old('category', 'Umum') }}" placeholder="Monograf, Referensi, Buku Ajar, Umum..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Tahun Terbit</label>
                    <input type="number" name="publish_year" min="1900" max="{{ now()->year + 2 }}" value="{{ old('publish_year') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Jumlah Halaman</label>
                    <input type="number" name="pages" min="1" value="{{ old('pages') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Ukuran Buku</label>
                    <input type="text" name="size" value="{{ old('size') }}" placeholder="Contoh: 14 × 20 cm" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>
            </div>

            <div>
                @include('admin.partials.rich-text-editor', [
                    'name' => 'description',
                    'label' => 'Sinopsis / Deskripsi',
                    'value' => old('description'),
                ])
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cover Buku</label>
                <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:font-semibold file:text-orange-700">
                <p class="mt-2 text-xs text-slate-400">JPG, JPEG, PNG, atau WebP. Maksimal 8 MB. File asli disimpan tanpa resize paksa.</p>
            </div>

            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-xs leading-relaxed text-amber-800">
                Setelah disimpan, status Publisher dan Bookstore sama-sama <strong>Pending</strong>.
                Approve Publisher dilakukan dari menu ini. Harga, format, dan stok diatur dari Kelola Bookstore sebelum Bookstore di-approve.
            </div>

            <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">Simpan sebagai Pending</button>
                <a href="{{ route('admin.publishers.index') }}" class="rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
