@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-bold mb-4">Tulis Artikel Baru</h1>

  <form action="{{ route('blog.store') }}" method="POST">
    @csrf
    <div class="mb-4">
      <label class="block font-semibold">Judul</label>
      <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded border p-2">
    </div>
    <div class="mb-4">
      <label class="block font-semibold">Kategori</label>
      <select name="category" class="w-full rounded border p-2">
        @foreach(['Kesehatan','Sosial','Ekonomi','Teknik'] as $cat)
          <option value="{{ $cat }}" {{ old('category')===$cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-4">
      <label class="block font-semibold">Isi</label>
      <input id="content" type="hidden" name="content" value="{{ old('content') }}">
      <trix-editor input="content" class="prose"></trix-editor>
    </div>
    <div class="text-right"><button class="px-4 py-2 bg-orange-600 text-white rounded">Terbitkan</button></div>
  </form>
</div>
@endsection
