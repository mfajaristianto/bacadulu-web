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
            <p class="mb-1 text-xs font-bold uppercase tracking-[.16em] text-orange-600">
                Baca Publisher
            </p>
            <h1 class="text-3xl font-bold text-slate-900">
                Review Buku Publisher
            </h1>
            <p class="mt-1 max-w-2xl text-sm leading-relaxed text-slate-500">
                Buku dari integrasi BacaPublisher nantinya masuk sebagai Pending. Periksa metadata,
                edit bila perlu, lalu Approve agar buku tampil di halaman Publisher.
            </p>
        </div>

        <a
            href="{{ route('admin.publishers.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
        >
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

    <div class="mb-5 rounded-2xl border border-orange-200 bg-orange-50/60 p-4">
        <div class="flex items-start gap-3">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-orange-100 text-orange-700">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 5h16v14H4z"/>
                    <path d="M8 9h8M8 13h5"/>
                </svg>
            </span>
            <div>
                <strong class="block text-sm text-slate-900">Satu master buku, dua approval</strong>
                <p class="mt-1 text-xs leading-relaxed text-slate-600">
                    Approval Publisher hanya mengatur tampil/tidaknya buku pada halaman Publisher.
                    Status Bookstore dikelola terpisah pada menu Kelola Bookstore, jadi harga dan stok tidak ikut berubah.
                </p>
            </div>
        </div>
    </div>

    <div class="mb-5 flex flex-wrap gap-2">
        @foreach($tabs as $key => $tab)
            <a
                href="{{ route('admin.publishers.index', ['status' => $key]) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3.5 py-2 text-sm font-semibold transition
                    {{ $status === $key
                        ? 'border-orange-600 bg-orange-600 text-white shadow-sm'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700' }}"
            >
                {{ $tab['label'] }}
                <span class="rounded-full px-2 py-0.5 text-[10px]
                    {{ $status === $key ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
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
                        <th class="px-4 py-3 text-left">Metadata</th>
                        <th class="px-4 py-3 text-left">Sumber</th>
                        <th class="px-4 py-3 text-center">Publisher</th>
                        <th class="px-4 py-3 text-center">Bookstore</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $book)
                        @php
                            $publisherBadge = match($book->publisher_status) {
                                'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                default => 'border-amber-200 bg-amber-50 text-amber-700',
                            };
                            $storeBadge = match($book->store_status) {
                                'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                default => 'border-slate-200 bg-slate-50 text-slate-600',
                            };
                        @endphp

                        <tr class="align-top transition hover:bg-slate-50/70">
                            <td class="px-4 py-4">
                                <div class="flex min-w-[280px] gap-3">
                                    <div class="grid h-24 w-16 shrink-0 place-items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                        @if($book->cover)
                                            <img
                                                src="{{ asset('storage/' . $book->cover) }}"
                                                alt="{{ $book->title }}"
                                                class="h-full w-full object-contain"
                                            >
                                        @else
                                            <span class="px-2 text-center text-[9px] font-semibold text-slate-400">No Cover</span>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-bold leading-snug text-slate-900">
                                            {{ $book->title }}
                                        </div>
                                        <div class="mt-1 text-xs text-slate-500">
                                            {{ $book->author }}
                                        </div>
                                        <div class="mt-2 text-[11px] text-slate-400">
                                            {{ $book->publisher }}
                                        </div>
                                        @if($book->has_pending_sync)
                                            <span class="mt-2 inline-flex rounded-full bg-violet-100 px-2 py-1 text-[10px] font-bold text-violet-700">
                                                Ada update API menunggu review
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-xs leading-relaxed text-slate-600">
                                <div class="min-w-[190px] space-y-1">
                                    <div><span class="text-slate-400">ISBN:</span> {{ $book->isbn ?: '-' }}</div>
                                    <div><span class="text-slate-400">Tahun:</span> {{ $book->publish_year ?: '-' }}</div>
                                    <div><span class="text-slate-400">Halaman:</span> {{ $book->pages ?: '-' }}</div>
                                    <div><span class="text-slate-400">Jenis:</span> {{ $book->category ?: 'Umum' }}</div>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="min-w-[130px]">
                                    <span class="inline-flex rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-slate-600">
                                        {{ $book->source ?: 'manual' }}
                                    </span>
                                    @if($book->external_id)
                                        <div class="mt-2 break-all text-[10px] text-slate-400">
                                            ID: {{ $book->external_id }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $publisherBadge }}">
                                    {{ $book->publisher_status ?: 'pending' }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $storeBadge }}">
                                    {{ $book->store_status ?: 'pending' }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex min-w-[235px] flex-wrap justify-end gap-2">
                                    <a
                                        href="{{ route('admin.publishers.edit', $book->slug) }}"
                                        class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                    >
                                        Cek / Edit
                                    </a>

                                    @if($book->publisher_status !== 'approved')
                                        <form action="{{ route('admin.publishers.approve', $book->slug) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100"
                                            >
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($book->publisher_status !== 'rejected')
                                        <form
                                            action="{{ route('admin.publishers.reject', $book->slug) }}"
                                            method="POST"
                                            onsubmit="return confirm('Reject buku ini dari Publisher? Data master buku tidak akan dihapus.')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                            >
                                                Reject
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.publishers.pending', $book->slug) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                            >
                                                Review Lagi
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if($book->publisher_review_note)
                                    <div class="mt-2 max-w-[240px] text-right text-[10px] leading-relaxed text-red-500">
                                        {{ $book->publisher_review_note }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">
                                Tidak ada buku pada status ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
