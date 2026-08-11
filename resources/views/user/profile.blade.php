@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
  <div class="bg-white p-6 rounded shadow-sm">
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="text-sm text-slate-500">{{ $user->email }}</p>
    <h3 class="mt-6 font-semibold">Artikel oleh {{ $user->name }}</h3>
    <div class="mt-4 space-y-4">
      @foreach($user->posts as $post)
        <div class="p-4 border rounded bg-white">
          <a href="{{ route('blog.show', $post->slug) }}" class="text-lg font-semibold">{{ $post->title }}</a>
          <div class="text-sm text-slate-500">{{ $post->created_at->format('d M Y') }} · {{ $post->category }}</div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
