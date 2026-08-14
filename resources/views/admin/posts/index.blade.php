@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Kelola Artikel</h1>
            <p class="text-slate-600">Setujui atau tolak artikel yang dikirim user.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="rounded-lg bg-green-100 text-green-700 px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tab Filter Status -->
    <div class="flex gap-2 mb-6">
        @foreach(['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'all' => 'Semua'] as $key => $label)
        <a href="{{ route('admin.posts.index', ['status' => $key]) }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold {{ $status == $key ? 'bg-orange-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="rounded-xl border bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $post->title }}</td>
                    <td class="px-4 py-3">{{ $post->category }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $post->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($post->status == 'pending')
                        <span class="text-xs font-semibold bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">Menunggu</span>
                        @elseif($post->status == 'approved')
                        <span class="text-xs font-semibold bg-green-100 text-green-700 px-2 py-1 rounded-full">Disetujui</span>
                        @else
                        <span class="text-xs font-semibold bg-red-100 text-red-700 px-2 py-1 rounded-full">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3 items-center">
                            @if($post->status !== 'approved')
                            <form action="{{ route('admin.posts.approve', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 font-semibold hover:text-green-700">Setujui</button>
                            </form>
                            @endif
                            @if($post->status !== 'rejected')
                            <form action="{{ route('admin.posts.reject', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 font-semibold hover:text-red-700">Tolak</button>
                            </form>
                            @endif
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 font-semibold hover:text-blue-700">Edit</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400">Tidak ada artikel di kategori ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $posts->appends(['status' => $status])->links() }}</div>
</div>
@endsection