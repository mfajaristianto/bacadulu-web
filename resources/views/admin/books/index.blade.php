@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Kelola Bookstore</h1>
            <p class="text-slate-600">Kelola Buku Cetak dan E-book yang tersedia di website.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="rounded bg-orange-600 px-4 py-2 text-white font-semibold hover:bg-orange-700">+ Tambah Buku</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded bg-green-100 border border-green-400 p-4 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b text-xs uppercase text-slate-500 font-semibold">
                    <th class="p-4">Cover</th>
                    <th class="p-4">Judul & Penulis</th>
                    <th class="p-4">Penerbit</th>
                    <th class="p-4 min-w-[300px]">Format & Harga</th>
                    <th class="p-4">Stok Cetak</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y text-sm">
                @forelse($books as $book)
                    <tr class="hover:bg-slate-50 transition">
                        {{-- COVER --}}
                        <td class="p-4">
                            @if($book->cover)
                                <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="w-12 h-16 object-cover rounded shadow">
                            @else
                                <span class="text-xs text-slate-400">No Image</span>
                            @endif
                        </td>

                        {{-- TITLE --}}
                        <td class="p-4">
                            <div class="font-bold text-slate-900">{{ $book->title }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ $book->author }}</div>
                        </td>

                        {{-- PUBLISHER --}}
                        <td class="p-4 text-slate-600">{{ $book->publisher }}</td>

                        {{-- FORMAT & PRICE --}}
                        <td class="p-4">
                            <div class="space-y-3">

                                @if($book->has_print)
                                    <div class="rounded-lg border border-orange-200 bg-orange-50 p-3">
                                        <div class="mb-2">
                                            <span class="inline-flex rounded-full bg-orange-100 px-2 py-1 text-[10px] font-bold text-orange-700">📚 BUKU CETAK</span>
                                        </div>

                                        @if($book->has_active_print_discount)
                                            <div class="text-[10px] font-semibold text-slate-400 uppercase mb-0.5">Harga Diskon</div>
                                            <div class="font-bold text-slate-900">
                                                IDR {{ number_format((float)$book->effective_print_price,2,',','.') }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-slate-400 line-through">
                                                    IDR {{ number_format((float)$book->print_price,2,',','.') }}
                                                </span>
                                                <span class="rounded bg-red-100 px-1.5 py-0.5 text-[10px] font-bold text-red-600">
                                                    -{{ number_format((float)$book->print_discount_percent,0) }}%
                                                </span>
                                            </div>
                                        @else
                                            <div class="font-bold text-slate-900">
                                                IDR {{ number_format((float)$book->print_price,2,',','.') }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if($book->has_ebook)
                                    <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-3">
                                        <div class="mb-2">
                                            <span class="inline-flex rounded-full bg-indigo-100 px-2 py-1 text-[10px] font-bold text-indigo-700">💻 E-BOOK</span>
                                        </div>

                                        @if($book->has_active_ebook_discount)
                                            <div class="text-[10px] font-semibold text-slate-400 uppercase mb-0.5">Harga Diskon</div>
                                            <div class="font-bold text-slate-900">
                                                IDR {{ number_format((float)$book->effective_ebook_price,2,',','.') }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-slate-400 line-through">
                                                    IDR {{ number_format((float)$book->ebook_price,2,',','.') }}
                                                </span>
                                                <span class="rounded bg-red-100 px-1.5 py-0.5 text-[10px] font-bold text-red-600">
                                                    -{{ number_format((float)$book->ebook_discount_percent,0) }}%
                                                </span>
                                            </div>
                                        @else
                                            <div class="font-bold text-slate-900">
                                                IDR {{ number_format((float)$book->ebook_price,2,',','.') }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if(!$book->has_print&&!$book->has_ebook)
                                    <span class="text-xs text-slate-400">Format belum ditentukan.</span>
                                @endif
                            </div>
                        </td>

                        {{-- STOCK --}}
                        <td class="p-4">
                            @if($book->has_print)
                                @if((int) $book->print_stock > 0)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                        {{ (int) $book->print_stock }} tersedia
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-1 text-xs font-bold text-rose-700">
                                        Stok Habis
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-slate-400">Tidak ada cetak</span>
                            @endif
                        </td>

                        {{-- CATEGORY --}}
                        <td class="p-4 text-slate-600">
                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                {{ $book->category??'Umum' }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.books.edit',$book->slug) }}" class="rounded bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">Edit</a>

                                <form action="{{ route('admin.books.destroy',$book->slug) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-slate-400">Belum ada data buku. Silakan tambah buku baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection