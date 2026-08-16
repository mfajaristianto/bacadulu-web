@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Kelola Komunitas</h1>
            <p class="text-slate-600">Setujui atau tolak pengajuan komunitas dari user.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-lg bg-green-100 text-green-700 px-4 py-3 mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tab Filter Status --}}
    <div class="flex gap-2 mb-6 flex-wrap">
        @foreach(['pending' => 'Menunggu Persetujuan', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'all' => 'Semua'] as $key => $label)
            <a href="{{ route('admin.communities.index', ['status' => $key]) }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold {{ $status == $key ? 'bg-orange-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="rounded-xl border bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600 border-b">
                <tr>
                    <th class="px-4 py-3">Nama Komunitas</th>
                    <th class="px-4 py-3">Pembuat</th>
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($communities as $community)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $community->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $community->user->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $community->members_count }}</td>
                        <td class="px-4 py-3">
                            @if($community->status == 'pending')
                                <span class="text-xs font-semibold bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">Menunggu</span>
                            @elseif($community->status == 'approved')
                                <span class="text-xs font-semibold bg-green-100 text-green-700 px-2 py-1 rounded-full">Disetujui</span>
                            @else
                                <span class="text-xs font-semibold bg-red-100 text-red-700 px-2 py-1 rounded-full">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $community->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                {{-- Approve Button --}}
                                @if($community->status == 'pending')
                                    <form action="{{ route('admin.communities.approve', $community) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded hover:bg-green-200 transition">
                                            Setujui
                                        </button>
                                    </form>
                                @endif

                                {{-- Reject Button --}}
                                @if($community->status == 'pending')
                                    <form action="{{ route('admin.communities.reject', $community) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                            Tolak
                                        </button>
                                    </form>
                                @endif

                                {{-- Edit Button --}}
                                <a href="{{ route('admin.communities.edit', $community) }}" class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                    Edit
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.communities.destroy', $community) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus komunitas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                            Tidak ada komunitas {{ $status == 'all' ? '' : 'dengan status ' . $status }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">{{ $communities->links() }}</div>
</div>
@endsection
