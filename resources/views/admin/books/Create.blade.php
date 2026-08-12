@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Buku Baru</h1>

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 shadow-sm space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku (Contoh: Jejak yang Tertinggal)</label>
            <input type="text" name="title" required class="w-full rounded border border-slate-300 p-2 text-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis (Contoh: Rani Ardhita)</label>
                <input type="text" name="author" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit (Contoh: Rekacipta Media)</label>
                <input type="text" name="publisher" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Jual (Rp)</label>
                <input type="number" name="price" placeholder="89000" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Buku</label>
                <input type="text" name="category" placeholder="Fiksi, Bisnis, Pengembangan Diri" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 items-end">
            <div>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input id="has_discount" type="checkbox" name="has_discount" value="1" class="h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                    <span>Berikan diskon</span>
                </label>
            </div>
            <div id="discounted_price_row" style="display: none;">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Diskon (Rp)</label>
                <input id="discounted_price" type="number" name="discounted_price" placeholder="75000" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Ukuran Buku</label>
                <input type="text" name="size" placeholder="14 x 21 cm" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah Halaman</label>
                <input type="number" name="pages" placeholder="240" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">ISBN</label>
                <input type="text" name="isbn" placeholder="978-602-..." class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tahun Terbit</label>
                <input type="number" name="publish_year" placeholder="2026" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Sinopsis / Deskripsi Buku</label>
            <textarea name="description" rows="5" class="w-full rounded border border-slate-300 p-2 text-sm" placeholder="Tuliskan sinopsis, fokus buku, atau detail khusus..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Upload Cover Buku (Foto)</label>
            <input type="file" name="cover" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
        </div>

        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('admin.books.index') }}" class="rounded border px-4 py-2 text-sm text-slate-600">Batal</a>
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-sm text-white font-semibold hover:bg-orange-700">Simpan Buku</button>
        </div>
    </form>
</div>
<script>
    const discountCheckbox = document.getElementById('has_discount');
    const discountRow = document.getElementById('discounted_price_row');

    function updateDiscountRow() {
        if (!discountCheckbox) return;
        discountRow.style.display = discountCheckbox.checked ? 'block' : 'none';
    }

    if (discountCheckbox) {
        discountCheckbox.addEventListener('change', updateDiscountRow);
        updateDiscountRow();
    }
</script>
@endsection