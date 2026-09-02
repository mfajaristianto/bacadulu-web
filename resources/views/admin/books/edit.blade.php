@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">Edit Buku</h1>

    @if($errors->any())
        <div class="mb-5 rounded-lg bg-red-100 border border-red-400 p-4 text-red-700 text-sm">
            <p class="font-semibold mb-2">Terjadi kesalahan validasi:</p>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update',$book->slug) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku</label>
            <input type="text" name="title" value="{{ old('title',$book->title) }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author',$book->author) }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher',$book->publisher) }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        {{-- FORMAT --}}
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
            <h2 class="font-bold text-slate-900">Format Buku</h2>
            <p class="mt-1 mb-4 text-xs text-slate-500">Buku dapat dijual dalam bentuk Cetak dan E-book sekaligus.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-start gap-3 rounded-xl border bg-white p-4 cursor-pointer hover:border-orange-300 transition">
                    <input id="has_print" type="checkbox" name="has_print" value="1" {{ old('has_print',$book->has_print?1:0)?'checked':'' }} class="mt-1 h-4 w-4">
                    <div>
                        <div class="font-bold">📚 Buku Cetak</div>
                        <div class="text-xs text-slate-500">Buku fisik</div>
                    </div>
                </label>

                <label class="flex items-start gap-3 rounded-xl border bg-white p-4 cursor-pointer hover:border-indigo-300 transition">
                    <input id="has_ebook" type="checkbox" name="has_ebook" value="1" {{ old('has_ebook',$book->has_ebook?1:0)?'checked':'' }} class="mt-1 h-4 w-4">
                    <div>
                        <div class="font-bold">💻 E-book</div>
                        <div class="text-xs text-slate-500">Buku digital</div>
                    </div>
                </label>
            </div>
        </div>

        {{-- PRINT --}}
        <div id="print_section" class="rounded-xl border border-orange-200 bg-orange-50 p-5 space-y-4" style="display:none;">
            <div>
                <h2 class="font-bold">📚 Buku Cetak</h2>
                <p class="text-xs text-slate-500 mt-1">Atur harga Buku Cetak.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Harga Buku Cetak</label>
                <div class="flex overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-100">
                    <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3 text-xs font-bold text-slate-500">IDR</span>
                    <input id="print_price_display" type="text" inputmode="numeric" autocomplete="off" placeholder="0,00" class="w-full border-0 p-2.5 font-semibold text-slate-800 outline-none focus:ring-0">
                    <input id="print_price" type="hidden" name="print_price" value="{{ old('print_price',$book->print_price) }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Stok Buku Cetak</label>
                <input
                    type="number"
                    name="print_stock"
                    min="0"
                    max="1000000"
                    step="1"
                    value="{{ old('print_stock', $book->print_stock ?? 0) }}"
                    class="w-full rounded border border-slate-300 bg-white p-2.5 font-semibold text-slate-800"
                >
                <p class="mt-1 text-[10px] text-slate-500">
                    Perubahan angka di sini dicatat sebagai penyesuaian stok. Untuk transaksi harian, gunakan panel stok di bawah.
                </p>
            </div>

            <label class="inline-flex items-center gap-2">
                <input id="has_print_discount" type="checkbox" name="has_print_discount" value="1" {{ old('has_print_discount',$book->print_discounted_price!==null?1:0)?'checked':'' }}>
                <span class="font-semibold text-sm">Berikan diskon Buku Cetak</span>
            </label>

            <div id="print_discount_section" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display:none;">
                <div>
                    <label class="block text-sm font-semibold mb-1">Diskon (%)</label>
                    <input id="print_discount_percent" type="number" step="0.01" min="0" max="70" name="print_discount_percent" value="{{ old('print_discount_percent',$book->print_discount_percent??0) }}" class="w-full rounded border border-slate-300 p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Harga Setelah Diskon</label>
                    <div class="flex overflow-hidden rounded-lg border border-orange-200 bg-white">
                        <span class="flex items-center border-r border-orange-100 bg-orange-50 px-3 text-xs font-bold text-orange-600">IDR</span>
                        <input id="print_final_price" type="text" readonly class="w-full border-0 bg-white p-2.5 font-bold text-orange-600 outline-none">
                    </div>
                </div>
            </div>
        </div>

        {{-- EBOOK --}}
        <div id="ebook_section" class="rounded-xl border border-indigo-200 bg-indigo-50 p-5 space-y-4" style="display:none;">
            <div>
                <h2 class="font-bold">💻 E-book</h2>
                <p class="text-xs text-slate-500 mt-1">Atur harga E-book.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Harga E-book</label>
                <div class="flex overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-100">
                    <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3 text-xs font-bold text-slate-500">IDR</span>
                    <input id="ebook_price_display" type="text" inputmode="numeric" autocomplete="off" placeholder="0,00" class="w-full border-0 p-2.5 font-semibold text-slate-800 outline-none focus:ring-0">
                    <input id="ebook_price" type="hidden" name="ebook_price" value="{{ old('ebook_price',$book->ebook_price) }}">
                </div>
            </div>

            <label class="inline-flex items-center gap-2">
                <input id="has_ebook_discount" type="checkbox" name="has_ebook_discount" value="1" {{ old('has_ebook_discount',$book->ebook_discounted_price!==null?1:0)?'checked':'' }}>
                <span class="font-semibold text-sm">Berikan diskon E-book</span>
            </label>

            <div id="ebook_discount_section" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display:none;">
                <div>
                    <label class="block text-sm font-semibold mb-1">Diskon (%)</label>
                    <input id="ebook_discount_percent" type="number" step="0.01" min="0" max="70" name="ebook_discount_percent" value="{{ old('ebook_discount_percent',$book->ebook_discount_percent??0) }}" class="w-full rounded border border-slate-300 p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Harga Setelah Diskon</label>
                    <div class="flex overflow-hidden rounded-lg border border-indigo-200 bg-white">
                        <span class="flex items-center border-r border-indigo-100 bg-indigo-50 px-3 text-xs font-bold text-indigo-600">IDR</span>
                        <input id="ebook_final_price" type="text" readonly class="w-full border-0 bg-white p-2.5 font-bold text-indigo-600 outline-none">
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Kategori</label>
            <input type="text" name="category" value="{{ old('category',$book->category) }}" class="w-full rounded border border-slate-300 p-2">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Jumlah Halaman</label>
                <input type="number" min="1" name="pages" value="{{ old('pages',$book->pages) }}" class="w-full rounded border border-slate-300 p-2">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn',$book->isbn) }}" class="w-full rounded border border-slate-300 p-2">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Tahun Terbit</label>
                <input type="number" name="publish_year" value="{{ old('publish_year',$book->publish_year) }}" class="w-full rounded border border-slate-300 p-2">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Ukuran Buku</label>
            <input type="text" name="size" value="{{ old('size',$book->size) }}" class="w-full rounded border border-slate-300 p-2">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Sinopsis / Deskripsi</label>
            <textarea name="description" rows="6" class="w-full rounded border border-slate-300 p-2">{{ old('description',$book->description) }}</textarea>
        </div>

        @if($book->cover)
            <div class="rounded-xl border bg-slate-50 p-4">
                <p class="text-sm text-slate-500 mb-2">Cover saat ini:</p>
                <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="h-40 w-auto rounded-lg object-cover">
            </div>
        @endif

        <div>
            <label class="block text-sm font-semibold mb-1">Upload Cover Baru</label>
            <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" class="w-full text-sm text-slate-500">
        </div>

        <div class="flex justify-between pt-4">
            <a href="{{ route('admin.books.index') }}" class="rounded border px-4 py-2 text-sm">Batal</a>
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-white font-semibold hover:bg-orange-700">Simpan Perubahan</button>
        </div>
    </form>

    @if($book->has_print)
        <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                <div class="mb-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">Tambah Stok</p>
                    <h2 class="mt-1 text-xl font-bold text-slate-900">Stok saat ini: {{ (int) $book->print_stock }} buku</h2>
                    <p class="mt-1 text-xs text-slate-600">Gunakan saat ada cetak ulang atau stok baru masuk.</p>
                </div>

                <form action="{{ route('admin.books.stock.add', $book->slug) }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="number" name="quantity" min="1" max="1000000" required placeholder="Jumlah stok masuk" class="w-full rounded border border-emerald-200 bg-white p-2.5 text-sm">
                    <input type="text" name="note" maxlength="500" placeholder="Catatan (opsional), mis. cetak ulang 50 eksemplar" class="w-full rounded border border-emerald-200 bg-white p-2.5 text-sm">
                    <button type="submit" class="w-full rounded bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">+ Tambah Stok</button>
                </form>
            </div>

            <div class="rounded-xl border border-rose-200 bg-rose-50 p-5 shadow-sm">
                <div class="mb-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-rose-700">Catat Penjualan</p>
                    <h2 class="mt-1 text-xl font-bold text-slate-900">Kurangi stok setelah CS mengonfirmasi</h2>
                    <p class="mt-1 text-xs text-slate-600">Checkout WhatsApp tidak mengurangi stok. Catat di sini setelah pesanan benar-benar dikonfirmasi.</p>
                </div>

                <form action="{{ route('admin.books.stock.sale', $book->slug) }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="number" name="quantity" min="1" max="{{ max(1, (int) $book->print_stock) }}" required placeholder="Jumlah terjual" class="w-full rounded border border-rose-200 bg-white p-2.5 text-sm" {{ (int) $book->print_stock < 1 ? 'disabled' : '' }}>
                    <input type="text" name="note" maxlength="500" placeholder="Catatan (opsional), mis. order via WhatsApp" class="w-full rounded border border-rose-200 bg-white p-2.5 text-sm" {{ (int) $book->print_stock < 1 ? 'disabled' : '' }}>
                    <button type="submit" class="w-full rounded px-4 py-2.5 text-sm font-bold text-white {{ (int) $book->print_stock > 0 ? 'bg-rose-600 hover:bg-rose-700' : 'bg-slate-400 cursor-not-allowed' }}" {{ (int) $book->print_stock < 1 ? 'disabled' : '' }}>Catat Penjualan</button>
                </form>
            </div>
        </div>

        <div class="mt-6 rounded-xl border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Riwayat Stok</p>
                    <h2 class="mt-1 text-lg font-bold text-slate-900">Pergerakan stok Buku Cetak</h2>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-bold {{ (int) $book->print_stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                    {{ (int) $book->print_stock > 0 ? 'Tersedia: '.$book->print_stock : 'Stok Habis' }}
                </span>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full min-w-[680px] text-left text-sm">
                    <thead class="border-b bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Jenis</th>
                            <th class="p-3">Perubahan</th>
                            <th class="p-3">Sebelum → Sesudah</th>
                            <th class="p-3">Admin</th>
                            <th class="p-3">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($book->stockMovements->take(30) as $movement)
                            <tr>
                                <td class="p-3 text-slate-500">{{ $movement->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                                <td class="p-3 font-semibold text-slate-700">{{ match($movement->type) { 'initial' => 'Stok Awal', 'restock' => 'Tambah Stok', 'sale' => 'Penjualan', default => 'Penyesuaian' } }}</td>
                                <td class="p-3 font-bold {{ $movement->quantity_change >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $movement->quantity_change >= 0 ? '+' : '' }}{{ $movement->quantity_change }}</td>
                                <td class="p-3 text-slate-600">{{ $movement->stock_before }} → {{ $movement->stock_after }}</td>
                                <td class="p-3 text-slate-600">{{ $movement->user?->name ?? 'Sistem' }}</td>
                                <td class="p-3 text-slate-500">{{ $movement->note ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-6 text-center text-slate-400">Belum ada riwayat stok.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    function formatIDR(value,decimal=true){
        const number=Number(value||0);
        return new Intl.NumberFormat('id-ID',{
            minimumFractionDigits:decimal?2:0,
            maximumFractionDigits:decimal?2:0
        }).format(number);
    }

    function parseIDR(value){
        let text=String(value||'').trim();
        if(text.includes(',')) text=text.split(',')[0];
        text=text.replace(/\./g,'').replace(/[^\d]/g,'');
        return text?Number(text):0;
    }

    function setupMoneyInput(display,raw){
        const initial=Number(raw.value||0);
        if(initial>0) display.value=formatIDR(initial,true);

        display.addEventListener('focus',function(){
            const value=Number(raw.value||0);
            this.value=value>0?formatIDR(value,false):'';
            setTimeout(()=>this.setSelectionRange(this.value.length,this.value.length),0);
        });

        display.addEventListener('input',function(){
            const value=parseIDR(this.value);
            raw.value=value>0?value:'';
            this.value=value>0?formatIDR(value,false):'';
            raw.dispatchEvent(new Event('input'));
        });

        display.addEventListener('blur',function(){
            const value=Number(raw.value||0);
            this.value=value>0?formatIDR(value,true):'';
        });
    }

    function setupFormat(config){
        const available=document.getElementById(config.available);
        const section=document.getElementById(config.section);
        const rawPrice=document.getElementById(config.price);
        const displayPrice=document.getElementById(config.displayPrice);
        const discount=document.getElementById(config.discount);
        const discountSection=document.getElementById(config.discountSection);
        const percent=document.getElementById(config.percent);
        const finalPrice=document.getElementById(config.finalPrice);

        setupMoneyInput(displayPrice,rawPrice);

        function calculate(){
            const base=Number(rawPrice.value||0);
            let pct=parseFloat(percent.value)||0;
            pct=Math.min(70,Math.max(0,pct));
            percent.value=pct;
            const result=base-(base*pct/100);
            finalPrice.value=base>0?formatIDR(result,true):'';
        }

        function updateDiscount(){
            const enabled=available.checked&&discount.checked;
            discountSection.style.display=enabled?'grid':'none';
            percent.disabled=!enabled;
            percent.required=enabled;
            if(enabled) calculate();
            else finalPrice.value='';
        }

        function updateFormat(){
            const enabled=available.checked;
            section.style.display=enabled?'block':'none';
            rawPrice.disabled=!enabled;
            displayPrice.disabled=!enabled;
            displayPrice.required=enabled;
            discount.disabled=!enabled;
            if(!enabled) discount.checked=false;
            updateDiscount();
        }

        available.addEventListener('change',updateFormat);
        discount.addEventListener('change',updateDiscount);
        rawPrice.addEventListener('input',calculate);
        percent.addEventListener('input',calculate);

        updateFormat();
        if(available.checked) calculate();
    }

    setupFormat({
        available:'has_print',
        section:'print_section',
        price:'print_price',
        displayPrice:'print_price_display',
        discount:'has_print_discount',
        discountSection:'print_discount_section',
        percent:'print_discount_percent',
        finalPrice:'print_final_price'
    });

    setupFormat({
        available:'has_ebook',
        section:'ebook_section',
        price:'ebook_price',
        displayPrice:'ebook_price_display',
        discount:'has_ebook_discount',
        discountSection:'ebook_discount_section',
        percent:'ebook_discount_percent',
        finalPrice:'ebook_final_price'
    });
});
</script>
@endsection