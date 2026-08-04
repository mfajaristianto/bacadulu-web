@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Data Artikel</h1>

    <form method="POST" action="{{ route('admin.data-articles.update', $dataArticle) }}" enctype="multipart/form-data" class="space-y-4 rounded-xl border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $dataArticle->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            @include('admin.partials.rich-text-editor', ['name' => 'description', 'label' => 'Deskripsi', 'value' => old('description', $dataArticle->description)])
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            <input type="file" name="image" class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-white">Simpan</button>
            <a href="{{ route('admin.data-articles.index') }}" class="rounded bg-slate-200 px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
