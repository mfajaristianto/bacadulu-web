@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Pencarian Konten</h1>

    <form method="GET" action="{{ route('search') }}" class="mb-8 flex gap-3">
        <input type="text" name="q" value="{{ old('q', $query) }}" placeholder="Cari informasi, jurnal, konferensi..." class="w-full rounded border px-4 py-3">
        <button type="submit" class="rounded bg-orange-600 px-5 py-3 text-white">Cari</button>
    </form>

    @if(!$query)
        <p class="text-slate-600">Silakan masukkan kata kunci untuk mulai mencari.</p>
    @else
        <div class="space-y-8">
            @if($informations->isNotEmpty())
                <div>
                    <h2 class="text-xl font-semibold mb-3">Informasi</h2>
                    <div class="space-y-3">
                        @foreach($informations as $item)
                            <div class="rounded border bg-white p-4 shadow-sm">
                                <a href="{{ route('admin.detail.show', ['type' => 'information', 'id' => $item->id]) }}" class="font-semibold text-orange-600">{{ $item->title }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($journals->isNotEmpty())
                <div>
                    <h2 class="text-xl font-semibold mb-3">Jurnal</h2>
                    <div class="space-y-3">
                        @foreach($journals as $item)
                            <div class="rounded border bg-white p-4 shadow-sm">
                                <a href="{{ route('admin.detail.show', ['type' => 'journal', 'id' => $item->id]) }}" class="font-semibold text-orange-600">{{ $item->judul }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($conferences->isNotEmpty())
                <div>
                    <h2 class="text-xl font-semibold mb-3">Konferensi</h2>
                    <div class="space-y-3">
                        @foreach($conferences as $item)
                            <div class="rounded border bg-white p-4 shadow-sm">
                                <a href="{{ route('admin.detail.show', ['type' => 'conference', 'id' => $item->id]) }}" class="font-semibold text-orange-600">{{ $item->title }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($publishers->isNotEmpty())
                <div>
                    <h2 class="text-xl font-semibold mb-3">Publisher</h2>
                    <div class="space-y-3">
                        @foreach($publishers as $item)
                            <div class="rounded border bg-white p-4 shadow-sm">
                                <a href="{{ route('admin.detail.show', ['type' => 'publisher', 'id' => $item->id]) }}" class="font-semibold text-orange-600">{{ $item->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($dataArticles->isNotEmpty())
                <div>
                    <h2 class="text-xl font-semibold mb-3">Data Artikel</h2>
                    <div class="space-y-3">
                        @foreach($dataArticles as $item)
                            <div class="rounded border bg-white p-4 shadow-sm">
                                <a href="{{ route('admin.detail.show', ['type' => 'data-article', 'id' => $item->id]) }}" class="font-semibold text-orange-600">{{ $item->title }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($informations->isEmpty() && $journals->isEmpty() && $conferences->isEmpty() && $publishers->isEmpty() && $dataArticles->isEmpty())
                <p class="text-slate-600">Tidak ada hasil ditemukan.</p>
            @endif
        </div>
    @endif
</div>
@endsection
