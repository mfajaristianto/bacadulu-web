@extends('layouts.admin')

@section('content')
@php
    $tabs = [
        'pending' => ['label' => 'Pending', 'count' => $counts['pending'] ?? 0],
        'approved' => ['label' => 'Approved', 'count' => $counts['approved'] ?? 0],
        'rejected' => ['label' => 'Rejected', 'count' => $counts['rejected'] ?? 0],
        'all' => ['label' => 'Semua', 'count' => $counts['all'] ?? 0],
    ];
@endphp

<div class="mx-auto max-w-7xl px-4 py-8">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-[.16em] text-orange-600">Baca Bookstore</p>
            <h1 class="text-3xl font-bold text-slate-900">Kelola Bookstore</h1>
            <p class="mt-1 max-w-2xl text-sm leading-relaxed text-slate-500">
                Atur format Buku Cetak/E-book, harga, diskon, ISBN format, dan stok. Buku dari BacaPublisher
                tetap Pending sampai data penjualan lengkap dan admin melakukan Approve.
            </p>
        </div>

        <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
            + Tambah Buku Manual
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-5 flex flex-wrap gap-2">
        @foreach($tabs as $key => $tab)
            <a
                href="{{ route('admin.books.index', ['status' => $key]) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3.5 py-2 text-sm font-semibold transition
                    {{ $status === $key
                        ? 'border-orange-600 bg-orange-600 text-white shadow-sm'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700' }}"
            >
                {{ $tab['label'] }}
                <span class="rounded-full px-2 py-0.5 text-[10px] {{ $status === $key ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                    {{ $tab['count'] }}
                </span>
            </a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Buku</th>
                        <th class="px-4 py-3 text-left">Format & Harga</th>
                        <th class="px-4 py-3 text-left">Stok Cetak</th>
                        <th class="px-4 py-3 text-center">Publisher</th>
                        <th class="px-4 py-3 text-center">Bookstore</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $book)
                        @php
                            $storeBadge = match($book->store_status) {
                                'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                default => 'border-amber-200 bg-amber-50 text-amber-700',
                            };
                            $publisherBadge = match($book->publisher_status) {
                                'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                default => 'border-slate-200 bg-slate-50 text-slate-600',
                            };
                        @endphp

                        <tr class="align-top transition hover:bg-slate-50/70">
                            <td class="px-4 py-4">
                                <div class="flex min-w-[290px] gap-3">
                                    <div class="grid h-24 w-16 shrink-0 place-items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                        @if($book->cover)
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="h-full w-full object-contain">
                                        @else
                                            <span class="px-2 text-center text-[9px] font-semibold text-slate-400">No Cover</span>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-bold leading-snug text-slate-900">{{ $book->title }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $book->author }}</div>
                                        <div class="mt-1 text-[11px] text-slate-400">{{ $book->publisher }}</div>
                                        <div class="mt-2 flex flex-wrap gap-1.5">
                                            <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-bold uppercase text-slate-500">{{ $book->source ?: 'manual' }}</span>
                                            <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-semibold text-slate-500">{{ $book->category ?: 'Umum' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="min-w-[280px] space-y-2.5">
                                    @if($book->has_print)
                                        <div class="rounded-xl border border-orange-200 bg-orange-50 p-3">
                                            <div class="mb-1 flex items-center justify-between gap-3">
                                                <span class="text-[10px] font-bold uppercase text-orange-700">Buku Cetak</span>
                                                <span class="text-[10px] text-orange-600">ISBN {{ $book->effective_print_isbn ?: '-' }}</span>
                                            </div>
                                            @if($book->print_price !== null)
                                                <div class="font-bold text-slate-900">IDR {{ number_format((float) $book->effective_print_price, 2, ',', '.') }}</div>
                                                @if($book->has_active_print_discount)
                                                    <div class="mt-1 text-xs text-slate-400 line-through">IDR {{ number_format((float) $book->print_price, 2, ',', '.') }}</div>
                                                @endif
                                            @else
                                                <span class="text-xs text-orange-700">Harga belum diisi</span>
                                            @endif
                                        </div>
                                    @endif

                                    @if($book->has_ebook)
                                        <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-3">
                                            <div class="mb-1 flex items-center justify-between gap-3">
                                                <span class="text-[10px] font-bold uppercase text-indigo-700">E-book</span>
                                                <span class="text-[10px] text-indigo-600">ISBN {{ $book->effective_ebook_isbn ?: '-' }}</span>
                                            </div>
                                            @if($book->ebook_price !== null)
                                                <div class="font-bold text-slate-900">IDR {{ number_format((float) $book->effective_ebook_price, 2, ',', '.') }}</div>
                                                @if($book->has_active_ebook_discount)
                                                    <div class="mt-1 text-xs text-slate-400 line-through">IDR {{ number_format((float) $book->ebook_price, 2, ',', '.') }}</div>
                                                @endif
                                            @else
                                                <span class="text-xs text-indigo-700">Harga belum diisi</span>
                                            @endif
                                        </div>
                                    @endif

                                    @if(!$book->has_print && !$book->has_ebook)
                                        <div class="rounded-xl border border-dashed border-amber-300 bg-amber-50 p-3 text-xs leading-relaxed text-amber-800">
                                            Format penjualan belum ditentukan. Klik <strong>Edit</strong>, pilih Buku Cetak dan/atau E-book, lalu isi harga.
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                @if($book->has_print)
                                    @if((int) $book->print_stock > 0)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">{{ (int) $book->print_stock }} tersedia</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-1 text-xs font-bold text-rose-700">Stok Habis</span>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada cetak</span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $publisherBadge }}">{{ $book->publisher_status ?: 'pending' }}</span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $storeBadge }}">{{ $book->store_status ?: 'pending' }}</span>
                                @if($book->store_review_note)
                                    <div class="mt-2 max-w-[180px] text-[10px] leading-relaxed text-red-500">{{ $book->store_review_note }}</div>
                                @endif
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex min-w-[240px] flex-wrap justify-end gap-2">
                                    <a href="{{ route('admin.books.edit', $book->slug) }}" class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">Edit Harga/Stok</a>

                                    @if($book->store_status !== 'approved')
                                        <form action="{{ route('admin.books.approve', $book->slug) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">Approve</button>
                                        </form>
                                    @endif

                                    @if($book->store_status !== 'rejected')
                                        <form action="{{ route('admin.books.reject', $book->slug) }}" method="POST" onsubmit="return confirm('Reject buku ini dari Bookstore?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">Reject</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.books.pending', $book->slug) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">Review Lagi</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.books.destroy', $book->slug) }}" method="POST" onsubmit="return confirm('Hapus master buku ini? Buku akan hilang dari Publisher dan Bookstore.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">Hapus Master</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">Tidak ada buku pada status ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
