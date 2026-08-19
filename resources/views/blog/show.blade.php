@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
  <article class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-3xl font-bold text-slate-900">{{ $post->title }}</h1>
        <div class="text-sm text-slate-500 mt-2">
          oleh <span class="font-medium text-slate-700">{{ $post->author ?? 'Admin Utama' }}</span> · {{ $post->created_at->format('d M Y') }} · <span class="font-semibold text-orange-600">{{ $post->category }}</span>
        </div>
      </div>
      <div class="flex items-center gap-2">
        @auth
          @if(auth()->id() === $post->user_id)
            <a href="{{ route('blog.edit', $post->slug) }}" class="px-3 py-1 border rounded text-sm hover:bg-gray-50">Edit</a>
            <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
              @csrf
              @method('DELETE')
              <button class="px-3 py-1 bg-red-50 text-red-600 rounded text-sm hover:bg-red-100">Hapus</button>
            </form>
          @endif
        @endauth
      </div>
    </div>
    <div class="prose max-w-none mt-6 text-slate-800">{!! $post->content !!}</div>
  </article>

  <section class="mt-8">
    <h3 class="text-xl font-semibold text-slate-800">Komentar ({{ $post->comments->count() }})</h3>

    @auth
      <form action="{{ route('post.comment.store', $post->id) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="content" rows="4" class="w-full rounded-lg border border-gray-200 p-3 focus:ring-2 focus:ring-orange-500 focus:outline-none" placeholder="Tulis komentar...">{{ old('content') }}</textarea>
        @error('content')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
        <div class="mt-2 text-right">
            <button class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition">Kirim Komentar</button>
        </div>
      </form>
    @else
      <p class="mt-4 text-sm text-slate-500">Silakan <a href="{{ route('login') }}" class="text-orange-600 underline font-medium">login</a> untuk memberi komentar.</p>
    @endauth

    <div class="mt-6 space-y-4">
      @forelse($post->comments as $comment)
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center justify-between">
            <div>
              <div class="text-sm font-semibold text-slate-800">{{ $comment->user->name ?? 'User' }}</div>
              <div class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
          </div>
          <div class="mt-2 text-slate-700 text-sm">{{ $comment->content }}</div>
        </div>
      @empty
        <p class="text-gray-500 italic text-sm">Belum ada komentar.</p>
      @endforelse
    </div>
  </section>
</div>
@endsection