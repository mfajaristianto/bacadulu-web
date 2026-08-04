@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Kelola Publisher</h1>
            <p class="text-slate-600">Daftar publisher yang tersedia.</p>
        </div>
        <a href="{{ route('admin.publishers.create') }}" class="rounded bg-orange-600 px-4 py-2 text-white">Tambah</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-xl border bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Tentang</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publishers as $publisher)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $publisher->name }}</td>
                        <td class="px-4 py-3">{{ Str::limit(strip_tags($publisher->about), 80) }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.publishers.edit', $publisher) }}" class="text-blue-600 mr-3">Edit</a>
                            <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Hapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
