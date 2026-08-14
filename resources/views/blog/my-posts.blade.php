@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Artikel Saya</h1>

    <div class="space-y-4">
        @forelse($posts as $post)
        <div class="p-5 border border-gray-100 rounded-xl bg-white flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-slate-900">{{ $post->title }}</h2>
                <p class="text-sm text-slate-500">{{ $post->created_at->format('d M Y') }} · {{ $post->category }}</p>
            </div>
            @if($post->status == 'pending')
            <span class="text-xs font-semibold bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">Menunggu Persetujuan</span>
            @elseif($post->status == 'approved')
            <span class="text-xs font-semibold bg-green-100 text-green-700 px-3 py-1 rounded-full">Tayang</span>
            @else
            <span class="text-xs font-semibold bg-red-100 text-red-700 px-3 py-1 rounded-full">Ditolak</span>
            @endif
        </div>
        @empty
        <p class="text-gray-500 italic">Kamu belum menulis artikel.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $posts->links() }}</div>
</div>
@endsection