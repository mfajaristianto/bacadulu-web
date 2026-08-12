@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Event</h1>

    @if($featured)
    <a href="{{ route('event.show', $featured->slug) }}" class="block relative rounded-2xl overflow-hidden mb-12 group">
        @if($featured->banner_image)
        <img src="{{ asset('storage/' . $featured->banner_image) }}" alt="{{ $featured->title }}" class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="w-full h-80 bg-slate-800"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 p-8">
            @if($featured->category)
            <span class="inline-block bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">{{ $featured->category }}</span>
            @endif
            <h2 class="text-3xl font-extrabold text-white mb-2">{{ $featured->title }}</h2>
            <p class="text-slate-200 text-sm">
                {{ $featured->start_date->translatedFormat('d F Y') }}
                @if($featured->location) &middot; {{ $featured->location }} @endif
            </p>
        </div>
    </a>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <a href="{{ route('event.show', $event->slug) }}" class="group rounded-2xl overflow-hidden border border-slate-100 hover:shadow-lg transition-all duration-300">
            <div class="overflow-hidden h-44 bg-slate-100">
                @if($event->banner_image)
                <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @endif
            </div>
            <div class="p-5">
                @if($event->category)
                <span class="text-orange-600 text-xs font-bold uppercase tracking-wide">{{ $event->category }}</span>
                @endif
                <h3 class="text-slate-800 font-bold text-base mt-1 mb-2 line-clamp-2">{{ $event->title }}</h3>
                <p class="text-xs text-slate-500">{{ $event->start_date->translatedFormat('d F Y') }}</p>
            </div>
        </a>
        @empty
        <p class="text-slate-500 col-span-full text-center py-10">Belum ada event yang tersedia.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $events->links() }}
    </div>
</div>
@endsection