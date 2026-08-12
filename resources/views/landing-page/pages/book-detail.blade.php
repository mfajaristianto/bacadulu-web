@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12 lg:px-8">
    <div class="grid gap-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/50">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/3">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->title }}" class="h-full w-full rounded-3xl object-cover">
                        @else
                            <div class="flex h-full items-center justify-center rounded-3xl bg-slate-100 text-slate-500">Tidak ada cover</div>
                        @endif
                    </div>
                    <div class="space-y-4 md:w-2/3">
                        <div class="space-y-2">
                            <span class="inline-flex rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-orange-700">Bookstore Detail</span>
                            <h1 class="text-3xl font-extrabold text-slate-900">{{ $book->title }}</h1>
                            <p class="text-sm text-slate-500">oleh {{ $book->author }} · {{ $book->publisher }}</p>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm">
                                <div class="text-slate-500">Halaman</div>
                                <div class="mt-2 text-lg font-semibold text-slate-900">{{ $book->pages ?? '—' }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm">
                                <div class="text-slate-500">Kategori</div>
                                <div class="mt-2 text-lg font-semibold text-slate-900">{{ $book->category ?? 'Umum' }}</div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                            <div class="text-slate-500 text-sm">Harga</div>
                            <div class="mt-2 flex items-center gap-4">
                                <span class="text-2xl font-bold text-slate-900">Rp {{ number_format($book->effective_price, 0, ',', '.') }}</span>
                                @if($book->has_active_discount)
                                    <span class="text-sm text-slate-500 line-through">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">Sinopsis / Deskripsi</h2>
                    <p class="mt-4 text-slate-600 leading-relaxed whitespace-pre-line">{{ $book->description ?? 'Deskripsi belum ditambahkan oleh admin.' }}</p>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Tentang Buku</h3>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div><span class="font-semibold text-slate-900">Judul:</span> {{ $book->title }}</div>
                    <div><span class="font-semibold text-slate-900">Penulis:</span> {{ $book->author }}</div>
                    <div><span class="font-semibold text-slate-900">Penerbit:</span> {{ $book->publisher }}</div>
                    <div><span class="font-semibold text-slate-900">Halaman:</span> {{ $book->pages ?? '—' }}</div>
                    <div><span class="font-semibold text-slate-900">Kategori:</span> {{ $book->category ?? 'Umum' }}</div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
