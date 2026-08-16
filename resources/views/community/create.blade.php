@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-slate-800 mb-8">Buat Komunitas Baru</h1>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4 text-red-700">
            <strong>Ada kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        @csrf

        {{-- Nama Komunitas --}}
        <div class="mb-6">
            <label for="name" class="block font-semibold text-slate-900 mb-2">
                Nama Komunitas <span class="text-red-600">*</span>
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: Komunitas Programmer Indonesia"
                class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                required
            >
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-6">
            <label for="description" class="block font-semibold text-slate-900 mb-2">
                Deskripsi <span class="text-red-600">*</span>
            </label>
            <textarea
                id="description"
                name="description"
                rows="6"
                placeholder="Jelaskan apa yang akan dibahas di komunitas ini..."
                class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                required
            >{{ old('description') }}</textarea>
            <p class="text-xs text-slate-500 mt-1">Minimal 10 karakter</p>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Icon/Cover --}}
        <div class="mb-6">
            <label for="icon" class="block font-semibold text-slate-900 mb-2">
                Icon/Cover Komunitas
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-400 transition">
                <input
                    id="icon"
                    type="file"
                    name="icon"
                    accept="image/*"
                    class="hidden"
                    onchange="document.getElementById('icon-preview').src = URL.createObjectURL(this.files[0])"
                >
                <label for="icon" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <p class="text-slate-600 font-medium">Klik untuk upload atau drag & drop</p>
                    <p class="text-xs text-slate-500 mt-1">PNG, JPG, GIF (Max 2MB)</p>
                </label>
                <img id="icon-preview" style="display: none;" class="mt-4 mx-auto h-40 rounded-lg">
            </div>
            @error('icon')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Info Alert --}}
        <div class="mb-6 rounded-lg bg-blue-50 border border-blue-200 p-4 text-blue-700">
            <p class="text-sm">
                <strong>ℹ️ Perhatian:</strong> Komunitas Anda akan ditampilkan dengan status <strong>"Menunggu Persetujuan"</strong> sampai admin menyetujuinya. Anda bisa melihat status komunitas di halaman komunitas saya.
            </p>
        </div>

        {{-- Submit Button --}}
        <div class="flex gap-4">
            <a href="{{ route('community.index') }}" class="px-6 py-3 border border-gray-300 text-slate-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button
                type="submit"
                class="px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition"
            >
                Buat Komunitas
            </button>
        </div>
    </form>
</div>
@endsection
