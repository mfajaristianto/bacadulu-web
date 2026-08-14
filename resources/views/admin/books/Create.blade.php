@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Buku Baru</h1>

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 border border-red-400 p-4 text-red-700 text-sm">
            <p class="font-semibold mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 shadow-sm space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Jual (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Buku</label>
                <input type="text" name="category" value="{{ old('category') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <!-- Bagian Diskon Baru (Checkbox, Persen, dan Harga Final) -->
        <div class="space-y-3 border p-4 rounded-lg bg-slate-50">
            <div>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input id="has_discount" type="checkbox" name="has_discount" value="1" {{ old('has_discount') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                    <span>Berikan diskon</span>
                </label>
            </div>

            <div id="discount_section" class="grid grid-cols-2 gap-4" style="display: none;">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Diskon (%) - Maks 70%</label>
                    <input id="discount_percent" type="number" name="discount_percent" value="{{ old('discount_percent', 0) }}" max="70" min="0" class="w-full rounded border border-slate-300 p-2 text-sm" placeholder="Contoh: 20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Setelah Diskon (Rp)</label>
                    <input id="final_price_display" type="text" class="w-full rounded border border-slate-200 bg-slate-200 p-2 text-sm font-bold text-orange-600" readonly>
                    <input id="discounted_price" type="hidden" name="discounted_price" value="{{ old('discounted_price') }}">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah Halaman</label>
                <input type="number" name="pages" value="{{ old('pages') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tahun Terbit</label>
                <input type="number" name="publish_year" value="{{ old('publish_year') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Ukuran Buku</label>
            <input type="text" name="size" value="{{ old('size') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Sinopsis / Deskripsi Buku</label>
            <textarea name="description" rows="6" class="w-full rounded border border-slate-300 p-2 text-sm">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Upload Cover Buku</label>
            <input type="file" name="cover" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
        </div>

        <div class="flex justify-between gap-2 pt-4">
            <a href="{{ route('admin.books.index') }}" class="rounded border px-4 py-2 text-sm text-slate-600">Batal</a>
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-sm text-white font-semibold hover:bg-orange-700">Simpan Buku</button>
        </div>
    </form>
</div>

<script>
    const priceInput = document.querySelector('input[name="price"]');
    const discountCheckbox = document.getElementById('has_discount');
    const discountSection = document.getElementById('discount_section');
    const percentInput = document.getElementById('discount_percent');
    const finalPriceDisplay = document.getElementById('final_price_display');
    const finalPriceInput = document.getElementById('discounted_price');

    function calculateDiscount() {
        if (!discountCheckbox.checked) return;

        let price = parseFloat(priceInput.value) || 0;
        let percent = parseFloat(percentInput.value) || 0;

        if (percent > 70) {
            percent = 70;
            percentInput.value = 70;
        }
        if (percent < 0) {
            percent = 0;
            percentInput.value = 0;
        }

        let discountAmount = (price * percent) / 100;
        let finalPrice = price - discountAmount;

        finalPriceDisplay.value = Math.round(finalPrice);
        finalPriceInput.value = Math.round(finalPrice);
    }

    function updateDiscountRow() {
        if (!discountCheckbox) return;
        discountSection.style.display = discountCheckbox.checked ? 'grid' : 'none';
        if (discountCheckbox.checked) {
            calculateDiscount();
        }
    }

    if (discountCheckbox) {
        discountCheckbox.addEventListener('change', updateDiscountRow);
        percentInput.addEventListener('input', calculateDiscount);
        priceInput.addEventListener('input', calculateDiscount);
        updateDiscountRow();
    }
</script>
@endsection