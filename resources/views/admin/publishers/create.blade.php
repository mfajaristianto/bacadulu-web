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
        <div class="js-form-error-summary mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
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

                @include('admin.partials.book-contributors', ['book' => $book ?? null])

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

            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5">
                <label class="mb-2 block text-sm font-semibold text-slate-700">PDF Preview Buku <span class="font-normal text-slate-400">(opsional)</span></label>
                <input id="preview_pdf_input" type="file" name="preview_pdf" accept="application/pdf,.pdf" data-preview-pdf-input class="block w-full rounded-xl border border-indigo-100 bg-white px-3 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:font-semibold file:text-indigo-700">
                <p class="mt-2 text-xs leading-relaxed text-slate-500">Upload PDF contoh isi buku untuk tombol <strong>Preview Buku</strong>. <strong>Maksimal 50 MB.</strong> File ini terpisah dari file e-book yang dijual.</p>
                <div data-preview-pdf-feedback class="mt-3 hidden rounded-xl border px-3 py-2 text-xs font-semibold"></div>
                @error('preview_pdf')
                    <div data-preview-pdf-server-error class="mt-3 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-xs leading-relaxed text-amber-800">
                Setelah disimpan, status Publisher dan Bookstore sama-sama <strong>Pending</strong>.
                Approve Publisher dilakukan dari menu ini. Harga, format, dan stok diatur dari Kelola Bookstore sebelum Bookstore di-approve.
            </div>

            <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-5">
                <button type="submit" data-save-button class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700 disabled:cursor-not-allowed disabled:opacity-60">Simpan sebagai Pending</button>
                <a href="{{ route('admin.publishers.index') }}" class="rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Batal</a>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('[data-publisher-book-form]');
    const input = document.querySelector('[data-preview-pdf-input]');
    const feedback = document.querySelector('[data-preview-pdf-feedback]');
    const saveButton = form?.querySelector('[data-save-button]');
    const maxBytes = 50 * 1024 * 1024;

    const showFeedback = (message, type) => {
        if (!feedback) return;
        feedback.textContent = message;
        feedback.classList.remove('hidden', 'border-red-200', 'bg-red-50', 'text-red-700', 'border-emerald-200', 'bg-emerald-50', 'text-emerald-700');
        if (type === 'error') {
            feedback.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
        } else {
            feedback.classList.add('border-emerald-200', 'bg-emerald-50', 'text-emerald-700');
        }
    };

    const validatePdf = () => {
        const file = input?.files?.[0];
        if (!file) {
            feedback?.classList.add('hidden');
            return true;
        }

        const lowerName = file.name.toLowerCase();
        const looksPdf = lowerName.endsWith('.pdf') && (!file.type || file.type === 'application/pdf' || file.type === 'application/x-pdf');

        if (!looksPdf) {
            showFeedback('File gagal dipilih: gunakan file PDF (.pdf).', 'error');
            return false;
        }

        if (file.size > maxBytes) {
            showFeedback('File terlalu besar. PDF preview maksimal 50 MB.', 'error');
            return false;
        }

        const sizeMb = (file.size / 1024 / 1024).toFixed(file.size >= 1024 * 1024 ? 2 : 3);
        showFeedback(`PDF siap diupload: ${file.name} (${sizeMb} MB).`, 'success');
        return true;
    };

    input?.addEventListener('change', validatePdf);

    form?.addEventListener('submit', function (event) {
        if (!validatePdf()) {
            event.preventDefault();
            feedback?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        if (saveButton) {
            saveButton.disabled = true;
            saveButton.textContent = 'Menyimpan...';
        }
    });

    const serverError = document.querySelector('[data-preview-pdf-server-error]');
    const errorSummary = document.querySelector('.js-form-error-summary');
    if (serverError) {
        serverError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else if (errorSummary) {
        errorSummary.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});
</script>

@endsection
