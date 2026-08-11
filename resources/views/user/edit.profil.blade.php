@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-12">
    <div class="bg-white p-8 rounded-xl shadow-sm border">
        <h1 class="text-2xl font-bold mb-6">Edit Profil</h1>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold">Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded border p-2">
            </div>
            <div class="mb-6">
                <label class="block font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded border p-2">
            </div>
            <div class="flex justify-between">
                <a href="{{ route('user.profile', auth()->id()) }}" class="text-gray-600">Batal</a>
                <button class="px-4 py-2 bg-orange-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection