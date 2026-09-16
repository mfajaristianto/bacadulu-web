@extends('layouts.admin')

@section('content')
@php
    $publisherBadge = match($book->publisher_status) {
        'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'rejected' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-amber-200 bg-amber-50 text-amber-700',
    };
@endphp

<div class="mx-auto max-w-5xl px-4 py-8">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-[.16em] text-orange-600">Baca Publisher</p>
            <h1 class="text-3xl font-bold text-slate-900">Cek & Edit Buku</h1>
            <p class="mt-1 text-sm text-slate-500">Periksa metadata sebelum buku di-approve untuk halaman Publisher.</p>
        </div>

        <span class="inline-flex w-fit rounded-full border px-3 py-1.5 text-xs font-bold uppercase {{ $publisherBadge }}">
            Publisher: {{ $book->publisher_status ?: 'pending' }}
        </span>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
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

    <div class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Sumber</span>
            <div class="mt-1 font-semibold text-slate-800">{{ $book->source ?: 'manual' }}</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">External ID</span>
            <div class="mt-1 break-all font-semibold text-slate-800">{{ $book->external_id ?: '-' }}</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Bookstore</span>
            <div class="mt-1 font-semibold text-slate-800">{{ ucfirst($book->store_status ?: 'pending') }}</div>
        </div>
    </div>

    @if($book->has_pending_sync && !empty($book->pending_api_payload))
        <section class="mb-5 overflow-hidden rounded-2xl border border-violet-200 bg-violet-50/60 shadow-sm">
            <div class="border-b border-violet-100 bg-white/70 px-5 py-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[.16em] text-violet-600">Update dari API</span>
                        <h2 class="mt-1 text-lg font-bold text-slate-900">Perubahan BacaPublisher menunggu review</h2>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">
                            Sync tidak langsung menimpa edit admin. Cek perbedaannya, lalu terapkan atau abaikan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('admin.publishers.api-update.apply', $book->slug) }}" method="POST" onsubmit="return confirm('Terapkan metadata terbaru dari BacaPublisher? Status Publisher akan kembali Pending untuk direview.')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-xl bg-violet-600 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-violet-700">
                                Terapkan Update API
                            </button>
                        </form>

                        <form action="{{ route('admin.publishers.api-update.ignore', $book->slug) }}" method="POST" onsubmit="return confirm('Abaikan update ini dan pertahankan data edit admin?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-xl border border-violet-200 bg-white px-4 py-2.5 text-xs font-semibold text-violet-700 transition hover:bg-violet-100">
                                Abaikan Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="p-5">
                @if(!empty($pendingApiDiff))
                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach($pendingApiDiff as $diff)
                            <div class="rounded-xl border border-violet-100 bg-white p-4">
                                <div class="text-[10px] font-bold uppercase tracking-wide text-violet-500">{{ $diff['label'] }}</div>
                                <div class="mt-3 grid gap-3 text-xs">
                                    <div>
                                        <span class="font-semibold text-slate-400">Sekarang</span>
                                        <div class="mt-1 break-words leading-relaxed text-slate-700">
                                            {{ \Illuminate\Support\Str::limit(trim(strip_tags((string) ($diff['current'] ?? '-'))) ?: '-', 220) }}
                                        </div>
                                    </div>
                                    <div class="border-t border-slate-100 pt-3">
                                        <span class="font-semibold text-violet-500">Dari Publisher</span>
                                        <div class="mt-1 break-words leading-relaxed text-slate-900">
                                            {{ \Illuminate\Support\Str::limit(trim(strip_tags((string) ($diff['incoming'] ?? '-'))) ?: '-', 220) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-600">Snapshot API berubah, tetapi tidak ada perubahan pada field utama yang ditampilkan.</p>
                @endif

                @if(!empty($book->pending_api_payload['source_url']))
                    <a
                        href="{{ $book->pending_api_payload['source_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-4 inline-flex text-xs font-semibold text-violet-700 hover:underline"
                    >
                        Buka katalog asli di BacaPublisher ↗
                    </a>
                @endif
            </div>
        </section>
    @endif

    <form method="POST" action="{{ route('admin.publishers.update', $book->slug) }}" enctype="multipart/form-data" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        @csrf
        @method('PUT')
        <div class="h-1 bg-gradient-to-r from-orange-600 via-orange-500 to-amber-400"></div>

        <div class="space-y-6 p-6 md:p-7">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Judul Buku</label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', $book->author) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Jenis / Kategori Buku</label>
                    <input type="text" name="category" value="{{ old('category', $book->category) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Tahun Terbit</label>
                    <input type="number" name="publish_year" min="1900" max="{{ now()->year + 2 }}" value="{{ old('publish_year', $book->publish_year) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Jumlah Halaman</label>
                    <input type="number" name="pages" min="1" value="{{ old('pages', $book->pages) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Ukuran Buku</label>
                    <input type="text" name="size" value="{{ old('size', $book->size) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">
                </div>
            </div>

            <div>
                @include('admin.partials.rich-text-editor', [
                    'name' => 'description',
                    'label' => 'Sinopsis / Deskripsi',
                    'value' => old('description', $book->description),
                ])
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cover Buku</label>

                @if($book->cover)
                    <div class="mb-4 inline-flex max-w-sm rounded-2xl border border-slate-200 bg-slate-50 p-3">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="max-h-72 w-auto max-w-full object-contain">
                    </div>
                @endif

                <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:font-semibold file:text-orange-700">
                <p class="mt-2 text-xs text-slate-400">Kosongkan jika cover tidak ingin diganti. File cover tidak dipotong atau dikompres ulang saat upload.</p>
            </div>

            @if($book->publisher_review_note)
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <strong>Catatan review:</strong> {{ $book->publisher_review_note }}
                </div>
            @endif

            <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Perubahan</button>
                <a href="{{ route('admin.publishers.index') }}" class="rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Kembali</a>
            </div>
        </div>
    </form>

    <div class="mt-5 flex flex-wrap gap-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        @if($book->publisher_status !== 'approved')
            <form action="{{ route('admin.publishers.approve', $book->slug) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">Approve Publisher</button>
            </form>
        @endif

        @if($book->publisher_status !== 'rejected')
            <form action="{{ route('admin.publishers.reject', $book->slug) }}" method="POST" onsubmit="return confirm('Reject buku ini dari Publisher?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-xl bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100">Reject</button>
            </form>
        @else
            <form action="{{ route('admin.publishers.pending', $book->slug) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-xl bg-amber-50 px-5 py-2.5 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">Kembalikan ke Pending</button>
            </form>
        @endif

        <a href="{{ route('admin.books.edit', $book->slug) }}" class="rounded-xl border border-indigo-200 bg-indigo-50 px-5 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100">
            Atur Harga & Stok Bookstore
        </a>
    </div>
</div>
@endsection
