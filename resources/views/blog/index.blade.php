@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
  <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- SIDEBAR ALA KOMPASIANA (Kiri) -->
    <div class="lg:col-span-1 space-y-6">
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sticky top-24">
        
        <!-- Menu Utama -->
        <div class="space-y-1">
          <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold {{ empty(request('menu')) && empty(request('category')) ? 'bg-[#1e1e50]/10 text-[#1e1e50]' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Home
          </a>
          
          <a href="{{ route('blog.index', ['menu' => 'komunitas']) }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold {{ request('menu') == 'komunitas' ? 'bg-[#1e1e50]/10 text-[#1e1e50]' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Komunitas
          </a>

          <a href="{{ route('blog.index', ['menu' => 'event']) }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold {{ request('menu') == 'event' ? 'bg-[#1e1e50]/10 text-[#1e1e50]' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Event
          </a>
        </div>

        <hr class="my-4 border-gray-100">

        <!-- Kategori (Sosial, Ekonomi, Teknik, Kesehatan) -->
        <div class="px-3 mb-2 text-xs font-bold uppercase tracking-wider text-gray-400">
          Kategori
        </div>
        <div class="space-y-1">
          @foreach(['Sosial', 'Ekonomi', 'Teknik', 'Kesehatan'] as $cat)
            <a href="{{ route('blog.index', ['category' => $cat]) }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ (isset($category) && $category === $cat) ? 'bg-[#1e1e50]/10 text-[#1e1e50] font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
              {{ $cat }}
            </a>
          @endforeach
        </div>

      </div>
    </div>

    <!-- KONTEN UTAMA BLOG (Kanan) -->
    <div class="lg:col-span-3">
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold text-slate-800">
            @if(request('menu') == 'komunitas')
              Rubrik Komunitas
            @elseif(request('menu') == 'event')
              Rubrik Event
            @elseif(!empty($category))
              Kategori: {{ $category }}
            @else
              Artikel Terbaru
            @endif
          </h1>

          @auth
            <a href="{{ route('blog.create') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded shadow transition">Tulis Artikel</a>
          @endauth
        </div>

        <!-- List Artikel -->
        <div class="space-y-6">
          @forelse($posts as $post)
            <article class="p-5 border border-gray-100 rounded-xl hover:shadow-md transition bg-white">
              <h2 class="text-xl font-semibold">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-slate-900 hover:text-orange-600 transition">{{ $post->title }}</a>
              </h2>
              <div class="text-sm text-slate-500 mt-1">
                {{ $post->user->name ?? 'Penulis' }} · {{ $post->created_at->format('d M Y') }} · <span class="font-medium text-orange-600">{{ $post->category }}</span>
              </div>
              <p class="mt-3 text-slate-700 text-sm leading-relaxed">{{ Str::limit(strip_tags($post->content), 200) }}</p>
            </article>
          @empty
            <div class="text-center py-12">
              <p class="text-gray-500 italic">Belum ada artikel ditemukan untuk kategori atau menu ini.</p>
            </div>
          @endforelse
        </div>

        <div class="mt-6">{{ $posts->links() }}</div>

      </div>
    </div>

  </div>
</div>
@endsection