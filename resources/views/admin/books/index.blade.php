@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Kelola Bookstore</h1>
            <p class="text-slate-600">Daftar katalog buku yang tersedia di website.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="rounded bg-orange-600 px-4 py-2 text-white font-semibold hover:bg-orange-700">+ Tambah Buku</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded bg-green-100 border border-green-400 p-4 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b text-xs uppercase text-slate-500 font-semibold">
                    <th class="p-4">Cover</th>
                    <th class="p-4">Judul & Penulis</th>
                    <th class="p-4">Penerbit</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Rating</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                @forelse($books as $book)
                    <tr>
                        <td class="p-4">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="w-12 h-16 object-cover rounded shadow">
                            @else
                                <span class="text-xs text-slate-400">No Image</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-900">{{ $book->title }}</div>
                            <div class="text-xs text-slate-500">{{ $book->author }}</div>
                        </td>
                        <td class="p-4 text-slate-600">{{ $book->publisher }}</td>
                        <td class="p-4">
                            <div class="font-semibold text-slate-900">Rp {{ number_format($book->price, 0, ',', '.') }}</div>
                            @if($book->original_price)
                                <div class="text-xs text-slate-400 line-through">Rp {{ number_format($book->original_price, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="p-4 text-orange-500 font-bold">★ {{ $book->rating }}</td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="rounded bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data buku. Silakan tambah baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection