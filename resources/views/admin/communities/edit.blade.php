@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Komunitas</h1>

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

    <form action="{{ route('admin.communities.update', $community) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        @csrf
        @method('PUT')

        {{-- Nama Komunitas --}}
        <div class="mb-6">
            <label for="name" class="block font-semibold text-slate-900 mb-2">
                Nama Komunitas <span class="text-red-600">*</span>
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name', $community->name) }}"
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
                class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                required
            >{{ old('description', $community->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Icon/Cover --}}
        <div class="mb-6">
            <label for="icon" class="block font-semibold text-slate-900 mb-2">
                Icon/Cover Komunitas
            </label>
            
            {{-- Current Icon --}}
            @if($community->icon)
                <div class="mb-4">
                    <p class="text-sm text-slate-600 mb-2">Icon saat ini:</p>
                    <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="h-32 rounded-lg border border-gray-200">
                </div>
            @endif

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-400 transition">
                <input
                    id="icon"
                    type="file"
                    name="icon"
                    accept="image/*"
                    class="hidden"
                    onchange="document.getElementById('icon-preview').src = URL.createObjectURL(this.files[0]); document.getElementById('icon-preview').style.display = 'block';"
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

        {{-- Info Section --}}
        <div class="mb-6 bg-slate-50 rounded-lg p-4 border border-slate-200">
            <p class="text-sm text-slate-700">
                <strong>Pembuat:</strong> {{ $community->user->name }}<br>
                <strong>Status:</strong> 
                @if($community->status == 'pending')
                    <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Menunggu</span>
                @elseif($community->status == 'approved')
                    <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Disetujui</span>
                @else
                    <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Ditolak</span>
                @endif
                <br>
                <strong>Anggota:</strong> {{ $community->members_count }}<br>
                <strong>Dibuat:</strong> {{ $community->created_at->format('d M Y H:i') }}
            </p>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-4">
            <a href="{{ route('admin.communities.index') }}" class="px-6 py-3 border border-gray-300 text-slate-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button
                type="submit"
                class="px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
