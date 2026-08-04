@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Jurnal</h1>

    <form method="POST" action="{{ route('admin.journals.update', $journal) }}" enctype="multipart/form-data" class="space-y-4 rounded-xl border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $journal->judul) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            @include('admin.partials.rich-text-editor', ['name' => 'deskripsi', 'label' => 'Deskripsi', 'value' => old('deskripsi', $journal->deskripsi)])
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">File PDF</label>
            <input type="file" name="file_pdf" accept="application/pdf" class="w-full border rounded px-3 py-2">
            @if($journal->file_pdf)
                <p class="mt-2 text-sm text-slate-500">File saat ini: <a href="{{ asset('storage/' . $journal->file_pdf) }}" target="_blank" class="text-orange-600 underline">Buka file</a></p>
            @endif
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Gambar</label>
            <input type="file" name="gambar" accept="image/*" class="w-full border rounded px-3 py-2">
            @if($journal->gambar)
                <p class="mt-2 text-sm text-slate-500">File saat ini: <a href="{{ asset('storage/' . $journal->gambar) }}" target="_blank" class="text-orange-600 underline">Buka file</a></p>
            @endif
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-white">Simpan</button>
            <a href="{{ route('admin.journals.index') }}" class="rounded bg-slate-200 px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
