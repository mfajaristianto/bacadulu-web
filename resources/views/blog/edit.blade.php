@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-bold mb-4">Edit Artikel</h1>

  <form action="{{ route('blog.update', $post->slug) }}" method="POST" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
    @csrf
    @method('PUT')

    <div class="mb-6">
      <label class="block text-sm font-semibold text-slate-800 mb-2">Judul</label>
      <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 break-words">
      @error('title')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Penulis</label>
      <input type="text" name="author" value="{{ old('author', $post->author) }}" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Masukkan nama penulis">
    </div>

    <div class="mb-6">
      <label class="block text-sm font-semibold text-slate-800 mb-2">Kategori</label>
      <select name="category" class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        @foreach(['Kesehatan','Sosial','Ekonomi','Teknik'] as $cat)
          <option value="{{ $cat }}" {{ (old('category', $post->category)===$cat) ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-6">
      <label class="block text-sm font-semibold text-slate-800 mb-2">Isi</label>
      <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
      <trix-editor
        input="content"
        class="prose max-w-none border border-gray-300 rounded-lg min-h-[300px] p-4 break-words [overflow-wrap:anywhere]"
      ></trix-editor>
      @error('content')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex justify-between items-center">
      <div>
        <a href="{{ route('blog.show', $post->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-slate-600 hover:bg-gray-50 transition">Batal</a>
      </div>
      <div class="flex items-center gap-2">
        <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
          @csrf
          @method('DELETE')
          <button class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-semibold hover:bg-red-100 transition">Hapus</button>
        </form>
        <button class="px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm font-semibold transition">Simpan Perubahan</button>
      </div>
    </div>
  </form>
</div>
@endsection