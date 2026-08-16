@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Komunitas</h1>
        @auth
            <a href="{{ route('community.create') }}" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow transition">
                + Tambah Komunitas
            </a>
        @endauth
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- Communities Grid --}}
    @if($communities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($communities as $community)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
                    {{-- Icon/Cover --}}
                    <div class="h-40 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center overflow-hidden">
                        @if($community->icon)
                            <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-slate-900 mb-2 truncate">
                            <a href="{{ route('community.show', $community) }}" class="hover:text-orange-600 transition">
                                {{ $community->name }}
                            </a>
                        </h3>
                        
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $community->description }}</p>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                                </svg>
                                <span>{{ $community->members_count }} Anggota</span>
                            </div>

                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>oleh {{ $community->user->name }}</span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        @auth
                            @if($community->isMember(auth()->id()))
                                <form action="{{ route('community.leave', $community) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition">
                                        Keluar
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('community.join', $community) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                                        Bergabung
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition text-center mt-4">
                                Bergabung
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">{{ $communities->links() }}</div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-16">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada komunitas</h3>
            <p class="text-gray-500 mb-6">Jadilah yang pertama membuat komunitas.</p>
            @auth
                <a href="{{ route('community.create') }}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                    + Tambah Komunitas
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                    Login untuk Membuat Komunitas
                </a>
            @endauth
        </div>
    @endif
</div>
@endsection
