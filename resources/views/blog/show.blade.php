@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
  <article class="bg-white p-8 rounded shadow-sm">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
        <div class="text-sm text-slate-500 mt-2">oleh {{ $post->user->name ?? 'Penulis' }} · {{ $post->created_at->format('d M Y') }} · <span class="font-semibold">{{ $post->category }}</span></div>
      </div>
      <div class="flex items-center gap-2">
        @auth
          @if(auth()->id() === $post->user_id)
            <a href="{{ route('blog.edit', $post->slug) }}" class="px-3 py-1 border rounded">Edit</a>
            <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
              @csrf
              @method('DELETE')
              <button class="px-3 py-1 bg-red-50 text-red-600 rounded">Hapus</button>
            </form>
          @endif
        @endauth
      </div>
    </div>
    <div class="prose mt-6">{!! $post->content !!}</div>
  </article>

  <section class="mt-8">
    <h3 class="text-xl font-semibold">Komentar ({{ $post->comments->count() }})</h3>

    @auth
      <form action="{{ route('post.comment.store', $post->id) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="body" rows="4" class="w-full rounded border p-2" placeholder="Tulis komentar...">{{ old('body') }}</textarea>
        <div class="mt-2 text-right"><button class="px-4 py-2 bg-orange-600 text-white rounded">Kirim</button></div>
      </form>
    @else
      <p class="mt-4 text-sm text-slate-500">Silakan <a href="{{ route('login') }}">login</a> untuk memberi komentar.</p>
    @endauth

    <div class="mt-6 space-y-4">
      @foreach($post->comments as $comment)
        <div class="bg-white p-4 rounded border">
          <div class="flex items-center justify-between">
            <div>
              <div class="text-sm font-semibold">{{ $comment->user->name ?? 'User' }}</div>
              <div class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
          </div>
          <div class="mt-2 text-slate-700">{{ $comment->body }}</div>
        </div>
      @endforeach
    </div>
  </section>
</div>
@endsection
