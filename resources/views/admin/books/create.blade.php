@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Buku Baru</h1>

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

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 shadow-sm space-y-6">
        @csrf

        {{-- INFORMASI DASAR --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher') }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        {{-- FORMAT --}}
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
            <h2 class="font-bold text-slate-900">Format Buku</h2>
            <p class="mt-1 mb-4 text-xs text-slate-500">Anda dapat memilih Buku Cetak, E-book, atau keduanya sekaligus.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 cursor-pointer hover:border-orange-300 transition">
                    <input id="has_print" type="checkbox" name="has_print" value="1" {{ old('has_print')?'checked':'' }} class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                    <div>
                        <div class="font-bold text-slate-900">📚 Buku Cetak</div>
                        <div class="mt-1 text-xs text-slate-500">Buku fisik yang akan dikirim kepada pembeli.</div>
                    </div>
                </label>

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 cursor-pointer hover:border-indigo-300 transition">
                    <input id="has_ebook" type="checkbox" name="has_ebook" value="1" {{ old('has_ebook')?'checked':'' }} class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="font-bold text-slate-900">💻 E-book</div>
                        <div class="mt-1 text-xs text-slate-500">Buku digital dengan harga tersendiri.</div>
                    </div>
                </label>
            </div>
        </div>

        {{-- BUKU CETAK --}}
        <div id="print_section" class="rounded-xl border border-orange-200 bg-orange-50 p-5 space-y-4" style="display:none;">
            <div>
                <h2 class="font-bold text-slate-900">📚 Buku Cetak</h2>
                <p class="text-xs text-slate-500 mt-1">Harga dan diskon khusus Buku Cetak.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Buku Cetak</label>
                <div class="flex overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-100">
                    <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3 text-xs font-bold text-slate-500">IDR</span>
                    <input id="print_price_display" type="text" inputmode="numeric" autocomplete="off" placeholder="0,00" class="w-full border-0 p-2.5 text-sm font-semibold text-slate-800 outline-none focus:ring-0">
                    <input id="print_price" type="hidden" name="print_price" value="{{ old('print_price') }}">
                </div>
                <p class="mt-1 text-[10px] text-slate-400">Contoh: IDR 200.000,00</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stok Awal Buku Cetak</label>
                <input
                    type="number"
                    name="print_stock"
                    min="0"
                    max="1000000"
                    step="1"
                    value="{{ old('print_stock', 0) }}"
                    class="w-full rounded border border-slate-300 bg-white p-2.5 text-sm font-semibold text-slate-800"
                >
                <p class="mt-1 text-[10px] text-slate-500">
                    Hanya untuk Buku Cetak. Nilai 0 akan otomatis tampil sebagai <strong>Stok Habis</strong> di Bookstore.
                </p>
            </div>

            <div class="border-t border-orange-200 pt-4">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input id="has_print_discount" type="checkbox" name="has_print_discount" value="1" {{ old('has_print_discount')?'checked':'' }} class="h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                    <span>Berikan diskon Buku Cetak</span>
                </label>
            </div>

            <div id="print_discount_section" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display:none;">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Diskon Buku Cetak (%)</label>
                    <input id="print_discount_percent" type="number" step="0.01" min="0" max="70" name="print_discount_percent" value="{{ old('print_discount_percent',0) }}" class="w-full rounded border border-slate-300 p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Setelah Diskon</label>
                    <div class="flex overflow-hidden rounded-lg border border-orange-200 bg-white">
                        <span class="flex items-center border-r border-orange-100 bg-orange-50 px-3 text-xs font-bold text-orange-600">IDR</span>
                        <input id="print_final_price" type="text" readonly class="w-full border-0 bg-white p-2.5 text-sm font-bold text-orange-600 outline-none">
                    </div>
                </div>
            </div>
        </div>

        {{-- EBOOK --}}
        <div id="ebook_section" class="rounded-xl border border-indigo-200 bg-indigo-50 p-5 space-y-4" style="display:none;">
            <div>
                <h2 class="font-bold text-slate-900">💻 E-book</h2>
                <p class="text-xs text-slate-500 mt-1">Harga dan diskon khusus E-book.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga E-book</label>
                <div class="flex overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-100">
                    <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3 text-xs font-bold text-slate-500">IDR</span>
                    <input id="ebook_price_display" type="text" inputmode="numeric" autocomplete="off" placeholder="0,00" class="w-full border-0 p-2.5 text-sm font-semibold text-slate-800 outline-none focus:ring-0">
                    <input id="ebook_price" type="hidden" name="ebook_price" value="{{ old('ebook_price') }}">
                </div>
                <p class="mt-1 text-[10px] text-slate-400">Contoh: IDR 75.000,00</p>
            </div>

            <div class="border-t border-indigo-200 pt-4">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input id="has_ebook_discount" type="checkbox" name="has_ebook_discount" value="1" {{ old('has_ebook_discount')?'checked':'' }} class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Berikan diskon E-book</span>
                </label>
            </div>

            <div id="ebook_discount_section" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display:none;">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Diskon E-book (%)</label>
                    <input id="ebook_discount_percent" type="number" step="0.01" min="0" max="70" name="ebook_discount_percent" value="{{ old('ebook_discount_percent',0) }}" class="w-full rounded border border-slate-300 p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Setelah Diskon</label>
                    <div class="flex overflow-hidden rounded-lg border border-indigo-200 bg-white">
                        <span class="flex items-center border-r border-indigo-100 bg-indigo-50 px-3 text-xs font-bold text-indigo-600">IDR</span>
                        <input id="ebook_final_price" type="text" readonly class="w-full border-0 bg-white p-2.5 text-sm font-bold text-indigo-600 outline-none">
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Buku</label>
            <input type="text" name="category" value="{{ old('category') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah Halaman</label>
                <input type="number" min="1" name="pages" value="{{ old('pages') }}" class="w-full rounded border border-slate-300 p-2 text-sm">
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
            <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
        </div>

        <div class="flex justify-between gap-2 pt-4">
            <a href="{{ route('admin.books.index') }}" class="rounded border px-4 py-2 text-sm text-slate-600">Batal</a>
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-sm text-white font-semibold hover:bg-orange-700">Simpan Buku</button>
        </div>
    </form>
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