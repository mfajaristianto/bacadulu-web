@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Publisher</h1>

    <form method="POST" action="{{ route('admin.publishers.update', $publisher) }}" enctype="multipart/form-data" class="space-y-4 rounded-xl border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $publisher->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            @include('admin.partials.rich-text-editor', ['name' => 'about', 'label' => 'Tentang', 'value' => old('about', $publisher->about)])
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Logo / Cover</label>
            <input type="file" name="logo_or_cover" class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 text-white">Simpan</button>
            <a href="{{ route('admin.publishers.index') }}" class="rounded bg-slate-200 px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
