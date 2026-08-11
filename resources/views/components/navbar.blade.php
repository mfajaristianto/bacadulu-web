<nav class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-100" id="main-navbar">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20 gap-4">
      
      <!-- 1. AREA LOGO -->
      <div class="flex-shrink-0 flex items-center">
        <a href="{{ route('home') }}" class="flex items-center !no-underline">
          <img src="{{ asset('img/images.jpg') }}" alt="Logo Baca Dulu" class="h-14 w-auto object-contain">
        </a>
      </div>

      <!-- 2. KOLOM SEARCH (Hanya muncul saat berada di halaman Blogging) -->
      @if(request()->routeIs('blog.*'))
      <div class="flex-1 max-w-md hidden md:block">
        <form action="{{ route('search') }}" method="GET" class="relative">
          <input type="text" name="q" placeholder="Cari artikel..." class="w-full bg-gray-100 text-sm text-gray-700 rounded-full pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white border border-transparent focus:border-orange-350 transition">
          <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </button>
        </form>
      </div>
      @endif

      <!-- 3. NAVIGATION LINKS (Desktop Menu Kiri/Tengah) -->
      <div class="hidden lg:flex items-center space-x-1 text-sm font-bold">
        <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg transition duration-200 !no-underline {{ request()->is('/') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">
            Home
        </a>

        <!-- Tentang Kami -->
        <div class="relative group">
          <button class="px-3 py-2 rounded-lg !text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50] transition duration-200 flex items-center gap-1 focus:outline-none !no-underline font-bold whitespace-nowrap">
            <span>Tentang Kami</span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="absolute left-0 hidden group-hover:block bg-white shadow-xl rounded-lg mt-0 py-2 w-52 border border-gray-100 z-50">
            <a href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Team BacaDulu</a>
            <a href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Nilai Perusahaan</a>
            <a href="{{ route('tentang.dewan-redaksi') }}#visi-misi" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Visi & Misi</a>
          </div>
        </div>

        <!-- Katalog Baca -->
        <div class="relative group">
          <button class="px-3 py-2 rounded-lg !text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50] transition duration-200 flex items-center gap-1 focus:outline-none !no-underline font-bold whitespace-nowrap">
            <span>Katalog Baca</span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="absolute left-0 hidden group-hover:block bg-white shadow-xl rounded-lg mt-0 py-2 w-56 border border-gray-100 z-50">
            <a href="{{ route('informasi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Informasi</a>
            <a href="{{ route('konsultasi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Konsultasi</a>
            <a href="{{ route('jurnal') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Jurnal</a>
            <a href="{{ route('conference') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Conference</a>
            <a href="{{ route('publisher') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Publisher</a>
          </div>
        </div>

        <a href="{{ route('portofolio.bookstore') }}" class="px-3 py-2 rounded-lg transition duration-200 !no-underline whitespace-nowrap {{ request()->routeIs('portofolio.bookstore') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">Bookstore</a>
        <a href="{{ route('blog.index') }}" class="px-3 py-2 rounded-lg transition duration-200 !no-underline whitespace-nowrap {{ request()->routeIs('blog.*') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">Blogging</a>
        <a href="{{ route('haki.index') }}" class="px-3 py-2 rounded-lg transition duration-200 !no-underline whitespace-nowrap {{ request()->routeIs('haki.index') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">HAKI</a>
      </div>

      <!-- 4. AREA KANAN (Dinamis: Berubah total jika berada di halaman Blogging) -->
      <div class="hidden md:flex items-center gap-3">
        @if(request()->routeIs('blog.*'))
            <!-- TAMPILAN KHUSUS HALAMAN BLOGGING -->
            <a href="{{ auth()->check() ? route('blog.create') : route('login') }}" class="flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-gray-700 hover:text-orange-600 transition !no-underline whitespace-nowrap">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
              Tulis
            </a>

            @auth
              <!-- Notifikasi -->
              <button class="text-gray-500 hover:text-gray-700 focus:outline-none p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
              </button>

              <!-- Ikon Profil Lingkaran (Inisial Nama) -->
              <a href="{{ route('user.profile', auth()->id()) }}" class="flex items-center !no-underline" title="Profil Saya">
                <div class="w-9 h-9 rounded-full bg-orange-600 text-white flex items-center justify-center font-bold text-sm shadow-sm hover:bg-orange-700 transition">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
              </a>
            @else
              <a href="{{ route('login') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-lg transition !no-underline whitespace-nowrap shadow-sm">
                Masuk
              </a>
            @endauth
        @else
            <!-- TAMPILAN NORMAL (Selain halaman blog) -->
            <a href="https://wa.me/6281315717719" target="_blank" class="bg-[#f05a42] hover:bg-[#d94f38] !text-white px-3 py-2 rounded-full text-xs font-bold shadow-md transition !no-underline whitespace-nowrap">
              Kirim Naskah
            </a>
        @endif
      </div>

      <!-- HAMBURGER (Mobile Toggle) -->
      <div class="flex items-center md:hidden">
        <button type="button" onclick="toggleMobileMenu()" class="!text-gray-600 focus:outline-none">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white shadow-inner">
    <div class="px-4 py-3 space-y-2 font-bold text-sm">
      
      @if(request()->routeIs('blog.*'))
      <!-- Search Mobile (Khusus Blog) -->
      <form action="{{ route('search') }}" method="GET" class="pb-2">
        <input type="text" name="q" placeholder="Cari artikel..." class="w-full bg-gray-100 text-sm text-gray-700 rounded-full px-4 py-2 focus:outline-none border border-gray-200">
      </form>
      @endif

      <a href="{{ route('home') }}" class="block text-gray-600 py-2 px-3 !no-underline">Home</a>
      
      <div class="border-t pt-2">
        <span class="text-[11px] text-gray-400 uppercase block px-3 mb-1">Tentang Kami</span>
        <a href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu" class="block text-gray-600 py-1.5 px-6 !no-underline">Team BacaDulu</a>
        <a href="{{ route('tentang.dewan-redaksi') }}#visi-misi" class="block text-gray-600 py-1.5 px-6 !no-underline">Visi & Misi</a>
        <a href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan" class="block text-gray-600 py-1.5 px-6 !no-underline">Nilai Perusahaan</a>
      </div>

      <div class="border-t pt-2">
        <span class="text-[11px] text-gray-400 uppercase block px-3 mb-1">Katalog Baca</span>
        <a href="{{ route('informasi') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Baca Informasi</a>
        <a href="{{ route('articles') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Baca Artikel</a>
        <a href="{{ route('konsultasi') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Baca Konsultasi</a>
        <a href="{{ route('jurnal') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Baca Jurnal</a>
        <a href="{{ route('conference') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Baca Conference</a>
        <a href="{{ route('publisher') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Baca Publisher</a>
      </div>

      <a href="{{ route('portofolio.bookstore') }}" class="block text-gray-600 py-2 px-3 !no-underline border-t pt-2">Bookstore</a>
      <a href="{{ route('blog.index') }}" class="block text-gray-600 py-2 px-3 !no-underline border-t pt-2">Blogging</a>
      <a href="{{ route('haki.index') }}" class="block text-gray-600 py-2 px-3 !no-underline border-t pt-2">HAKI</a>

      <div class="border-t pt-2 space-y-2">
        @if(request()->routeIs('blog.*'))
          <a href="{{ auth()->check() ? route('blog.create') : route('login') }}" class="block text-orange-600 py-2 px-3 !no-underline font-bold">Tulis Artikel</a>
          
          @auth
            <a href="{{ route('user.profile', auth()->id()) }}" class="block text-gray-600 py-2 px-3 !no-underline">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
              @csrf
              <button type="submit" class="w-full text-left text-red-600 font-bold">Logout</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="block text-orange-600 py-2 px-3 !no-underline font-bold">Masuk / Login (Email)</a>
          @endauth
        @endif
      </div>

      <div class="border-t pt-2 flex flex-col space-y-2 pb-2">
        <a href="https://wa.me/6281315717719" target="_blank" class="bg-[#f05a42] text-center text-white py-2 rounded-lg text-sm shadow-md !no-underline">Kirim Naskah</a>
      </div>
    </div>
  </div>
</nav>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }
</script>