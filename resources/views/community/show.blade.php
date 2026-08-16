@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    {{-- Success Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="mb-6 rounded-lg bg-blue-100 border border-blue-300 p-4 text-blue-700">
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header/Cover --}}
        <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center overflow-hidden">
            @if($community->icon)
                <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
            @else
                <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            @endif
        </div>

        {{-- Content --}}
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $community->name }}</h1>
                    <p class="text-sm text-slate-500 mt-2">
                        Dibuat oleh <strong>{{ $community->user->name }}</strong> pada {{ $community->created_at->format('d M Y') }}
                    </p>
                </div>
                
                {{-- Status Badge --}}
                @if($community->status === 'pending')
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-700 text-sm font-semibold rounded-full">
                        ⏳ Menunggu Persetujuan
                    </span>
                @elseif($community->status === 'approved')
                    <span class="px-4 py-2 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                        ✓ Disetujui
                    </span>
                @elseif($community->status === 'rejected')
                    <span class="px-4 py-2 bg-red-100 text-red-700 text-sm font-semibold rounded-full">
                        ✕ Ditolak
                    </span>
                @endif
            </div>

            {{-- Description --}}
            <div class="mb-8 pb-8 border-b border-gray-200">
                <p class="text-slate-700 leading-relaxed">{{ $community->description }}</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-slate-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $community->members_count }}</div>
                    <div class="text-sm text-slate-600">Anggota</div>
                </div>
                <div class="bg-slate-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $community->created_at->format('d M Y') }}</div>
                    <div class="text-sm text-slate-600">Dibuat</div>
                </div>
                <div class="bg-slate-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $community->user->name }}</div>
                    <div class="text-sm text-slate-600">Pembuat</div>
                </div>
                <div class="bg-slate-50 rounded-lg p-4 text-center">
                    @if($community->status === 'approved')
                        <div class="text-2xl font-bold text-green-600">✓</div>
                    @elseif($community->status === 'pending')
                        <div class="text-2xl font-bold text-yellow-600">⏳</div>
                    @else
                        <div class="text-2xl font-bold text-red-600">✕</div>
                    @endif
                    <div class="text-sm text-slate-600">{{ ucfirst($community->status) }}</div>
                </div>
            </div>

            {{-- Action Buttons --}}
            @if(auth()->check() && $community->isCreator(auth()->id()))
                {{-- Edit Button for Creator --}}
                <div class="flex gap-4">
                    <a href="{{ route('admin.communities.edit', $community) }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition">
                        Edit Komunitas
                    </a>
                </div>
            @else
                {{-- Join/Leave Buttons for Members --}}
                @auth
                    @if($isMember)
                        <form action="{{ route('community.leave', $community) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition">
                                Keluar dari Komunitas
                            </button>
                        </form>
                    @else
                        <form action="{{ route('community.join', $community) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                                Bergabung
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                        Login untuk Bergabung
                    </a>
                @endauth
            @endif
        </div>
    </div>

    {{-- Back Link --}}
    <div class="mt-8">
        <a href="{{ route('community.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold">
            ← Kembali ke Komunitas
        </a>
    </div>
</div>
@endsection
