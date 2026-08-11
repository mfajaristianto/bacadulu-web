@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-bold mb-4">Edit Artikel</h1>

  <form action="{{ route('blog.update', $post->slug) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label class="block font-semibold">Judul</label>
      <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full rounded border p-2">
    </div>
    <div class="mb-4">
      <label class="block font-semibold">Kategori</label>
      <select name="category" class="w-full rounded border p-2">
        @foreach(['Kesehatan','Sosial','Ekonomi','Teknik'] as $cat)
          <option value="{{ $cat }}" {{ (old('category', $post->category)===$cat) ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-4">
      <label class="block font-semibold">Isi</label>
      <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
      <trix-editor input="content" class="prose"></trix-editor>
    </div>
    <div class="flex justify-between items-center">
      <div>
        <a href="{{ route('blog.show', $post->slug) }}" class="px-4 py-2 border rounded">Batal</a>
      </div>
      <div class="flex items-center gap-2">
        <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
          @csrf
          @method('DELETE')
          <button class="px-4 py-2 bg-red-50 text-red-600 rounded">Hapus</button>
        </form>
        <button class="px-4 py-2 bg-orange-600 text-white rounded">Simpan Perubahan</button>
      </div>
    </div>
  </form>
</div>
@endsection
