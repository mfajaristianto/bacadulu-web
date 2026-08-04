@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto rounded-xl border bg-white p-8 shadow-sm">
    <a href="{{ route('admin.dashboard') }}" class="text-orange-600 font-semibold">← Kembali</a>
    <h1 class="text-3xl font-bold mt-4">Detail {{ ucfirst(str_replace('-', ' ', $type)) }}</h1>

    @if($type === 'information')
        <div class="mt-6 space-y-4">
            <h2 class="text-2xl font-semibold">{{ $model->title }}</h2>
            <div class="prose max-w-none">{!! $model->content !!}</div>
            @if($model->image)
                <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->title }}" class="rounded-lg max-h-80 object-cover">
            @endif
        </div>
    @elseif($type === 'journal')
        <div class="mt-6 space-y-4">
            <h2 class="text-2xl font-semibold">{{ $model->judul }}</h2>
            <p>{{ $model->deskripsi }}</p>
            @if($model->file_pdf)
                <a href="{{ asset('storage/' . $model->file_pdf) }}" class="text-orange-600 font-semibold">Buka PDF</a>
            @endif
        </div>
    @elseif($type === 'conference')
        <div class="mt-6 space-y-4">
            <h2 class="text-2xl font-semibold">{{ $model->title }}</h2>
            <p class="text-slate-600">Tanggal: {{ $model->event_date }}</p>
            <div class="prose max-w-none">{!! $model->description !!}</div>
            @if($model->poster)
                <img src="{{ asset('storage/' . $model->poster) }}" alt="{{ $model->title }}" class="rounded-lg max-h-80 object-cover">
            @endif
        </div>
    @elseif($type === 'publisher')
        <div class="mt-6 space-y-4">
            <h2 class="text-2xl font-semibold">{{ $model->name }}</h2>
            <div class="prose max-w-none">{!! $model->about !!}</div>
            @if($model->logo_or_cover)
                <img src="{{ asset('storage/' . $model->logo_or_cover) }}" alt="{{ $model->name }}" class="rounded-lg max-h-80 object-cover">
            @endif
        </div>
    @elseif($type === 'data-article')
        <div class="mt-6 space-y-4">
            <h2 class="text-2xl font-semibold">{{ $model->title }}</h2>
            <div class="prose max-w-none">{!! $model->description !!}</div>
            @if($model->image)
                <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->title }}" class="rounded-lg max-h-80 object-cover">
            @endif
        </div>
    @endif
</div>
@endsection
