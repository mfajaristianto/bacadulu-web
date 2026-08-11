@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Edit Buku</h1>

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border p-6 shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku</label>
            <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="w-full rounded border border-slate-300 p-2 text-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Diskon (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $book->price) }}" required class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga Asli / Coret (Rp)</label>
                <input type="number" name="original_price" value="{{ old('original_price', $book->original_price) }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Rating</label>
                <input type="text" name="rating" value="{{ old('rating', $book->rating) }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Buku</label>
            <input type="text" name="category" value="{{ old('category', $book->category) }}" class="w-full rounded border border-slate-300 p-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah Halaman</label>
                <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" class="w-full rounded border border-slate-300 p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Upload Cover Baru</label>
                <input type="file" name="cover" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Sinopsis / Deskripsi Buku</label>
            <textarea name="description" rows="6" class="w-full rounded border border-slate-300 p-2 text-sm">{{ old('description', $book->description) }}</textarea>
        </div>

        @if($book->cover)
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm text-slate-500 mb-2">Cover saat ini:</p>
                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->title }}" class="h-40 w-auto rounded-lg object-cover">
            </div>
        @endif

        <div class="flex justify-between gap-2 pt-4">
            <a href="{{ route('admin.books.index') }}" class="rounded border px-4 py-2 text-sm text-slate-600">Batal</a>
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-sm text-white font-semibold hover:bg-orange-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
