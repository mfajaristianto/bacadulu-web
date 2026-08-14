@extends('layouts.app')

@section('content')
<style>
  /* --- CUSTOM STYLING 3D --- */
  .cover-3d-wrapper {
    background: linear-gradient(135deg, #FBF9F5 0%, #F1EDE4 100%);
    border: 1px solid #EAE7DF;
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0 20px 40px -15px rgba(27, 36, 83, 0.08);
  }
  .book3d-box {
    position: relative;
    width: 220px;
    height: 295px;
    transform-style: preserve-3d;
    transform: rotateY(-24deg);
    transition: transform 0.4s ease;
  }
  .cover-3d-wrapper:hover .book3d-box { transform: rotateY(-8deg); }
  .book-face { position: absolute; top: 0; }
  .book-face.front { width: 220px; height: 295px; transform: translateZ(14px); padding: 24px; display: flex; flex-direction: column; justify-content: flex-end; color: #FFFFFF; box-shadow: 14px 20px 35px rgba(18, 25, 59, 0.35); }
  .book-face.pages { width: 28px; height: 289px; right: 0; top: 3px; background: repeating-linear-gradient(to bottom, #fdfcf9 0 2px, #eae5da 2px 3px); transform-origin: right; transform: rotateY(90deg); }
  .book-face.spine { width: 28px; height: 289px; left: 0; top: 3px; transform-origin: left; transform: rotateY(-90deg); filter: brightness(0.72); }
</style>

<div class="max-w-6xl mx-auto px-6 py-14 lg:px-8">
    <!-- Tombol Kembali dengan Efek Interaktif -->
<div class="mb-8">
    <a href="{{ route('portofolio.bookstore') }}" 
       class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 shadow-[2px_2px_0px_0px_rgba(239,88,67,0.3)] hover:shadow-[4px_4px_0px_0px_rgba(239,88,67,0.3)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-300 ease-out font-bold text-slate-700 hover:text-orange-600">
        <span class="text-lg transition-transform group-hover:translate-x-[-4px] duration-300">←</span>
        <span>KEMBALI KE KATALOG</span>
    </a>
</div>

    <!-- Grid Utama: Menggunakan items-start -->
    <div class="grid gap-8 lg:grid-cols-12 items-start">
        
        <!-- KOLOM KIRI: Dibuat Sticky agar ikut turun mendampingi teks panjang di kanan -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">
            <div class="cover-3d-wrapper">
                <div class="book3d-box">
                    <div class="book-face spine" style="background: #EF5843;"></div>
                    <div class="book-face pages"></div>
                    <div class="book-face front" style="{{ $book->cover ? 'background-image:url(\'' . asset('storage/' . $book->cover) . '\'); background-size:cover; background-position:center;' : 'background:#EF5843;' }}">
                        @if(!$book->cover)
                            <div style="font-family:'Poppins',sans-serif;font-weight:700;font-size:18px;">{{ $book->title }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Bibliografi: Diperbaiki susunannya agar rapi ke bawah (tidak renggang di tengah) -->
            <div class="border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Informasi Bibliografi</h3>
                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="block font-semibold text-slate-400 uppercase text-[10px]">Judul Buku</span>
                        <span class="font-medium text-slate-800 text-sm">{{ $book->title }}</span>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-400 uppercase text-[10px]">Penulis</span>
                        <span class="font-medium text-slate-800 text-sm">{{ $book->author }}</span>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-400 uppercase text-[10px]">Penerbit</span>
                        <span class="font-medium text-slate-800 text-sm">{{ $book->publisher }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100">
                        <div>
                            <span class="block font-semibold text-slate-400 uppercase text-[10px]">Tahun</span>
                            <span class="font-medium text-slate-800">{{ $book->publish_year ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block font-semibold text-slate-400 uppercase text-[10px]">ISBN</span>
                            <span class="font-medium text-slate-800">{{ $book->isbn ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Detail, Harga, Deskripsi Panjang -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200/80 p-8 shadow-sm">
                <span class="inline-block bg-orange-50 text-orange-700 text-xs font-bold uppercase px-3 py-1 border border-orange-200">Bookstore Detail</span>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3">{{ $book->title }}</h1>
                <p class="text-base text-slate-500 font-medium">Oleh <span class="text-slate-800 font-semibold">{{ $book->author }}</span></p>

                <div class="grid grid-cols-2 gap-4 my-6">
                    <div class="border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs text-slate-400 uppercase font-bold">Halaman</div>
                        <div class="text-xl font-bold">{{ $book->pages ?? '-' }}</div>
                    </div>
                    <div class="border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs text-slate-400 uppercase font-bold">Kategori</div>
                        <div class="text-xl font-bold capitalize">{{ $book->category ?? 'Umum' }}</div>
                    </div>
                </div>

                <div class="border-t border-b py-5 my-6">
                    <div class="text-xs text-slate-400 uppercase font-bold">Harga Penjualan</div>
                    <div class="text-3xl font-extrabold text-slate-900 mt-1">Rp {{ number_format($book->effective_price, 0, ',', '.') }}</div>
                </div>

                <div class="space-y-3">
                    <h2 class="text-lg font-bold border-b pb-2">Sinopsis & Deskripsi</h2>
                    <div class="text-slate-600 leading-relaxed text-sm lg:text-base space-y-4 whitespace-pre-line">
                        {{ $book->description ?? 'Belum ada deskripsi.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection