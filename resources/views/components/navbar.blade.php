<nav class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-100" id="main-navbar">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20">
      
      <!-- 1. AREA LOGO -->
      <div class="flex-shrink-0 flex items-center">
        <a href="{{ route('home') }}" class="flex items-center !no-underline">
          <img src="{{ asset('img/images.jpg') }}" alt="Logo Baca Dulu" class="h-14 w-auto object-contain">
        </a>
      </div>

      <!-- 2. NAVIGATION LINKS (Desktop) -->
      <div class="hidden md:flex items-center space-x-1 lg:space-x-3 text-sm font-bold">
        
        <!-- Home -->
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
            <a href="{{ route('tentang.dewan-redaksi') }}#visi-misi" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Visi & Misi</a>
            <a href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Nilai Perusahaan</a>
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
            <a href="{{ route('articles') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Artikel</a>
            <a href="{{ route('konsultasi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Konsultasi</a>
            <a href="{{ route('jurnal') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Jurnal</a>
            <a href="{{ route('conference') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Conference</a>
            <a href="{{ route('publisher') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Baca Publisher</a>
          </div>
        </div>

        <!-- Bookstore -->
        <a href="{{ route('portofolio.bookstore') }}" class="px-3 py-2 rounded-lg transition duration-200 !no-underline whitespace-nowrap {{ request()->routeIs('portofolio.bookstore') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">
            Bookstore
        </a>

        <!-- HAKI -->
        <div class="relative group">
          <button class="px-3 py-2 rounded-lg !text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50] transition duration-200 flex items-center gap-1 focus:outline-none !no-underline font-bold whitespace-nowrap">
            <span>HAKI</span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="absolute left-0 hidden group-hover:block bg-white shadow-xl rounded-lg mt-0 py-2 w-56 border border-gray-100 z-50">
            <a href="{{ route('haki.daftar', 'buku-ajar') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#f05a42] !no-underline font-semibold whitespace-nowrap">Daftar Buku Ajar</a>
            <a href="{{ route('haki.daftar', 'buku-referensi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#f05a42] !no-underline font-semibold whitespace-nowrap">Daftar Buku Referensi</a>
            <a href="{{ route('haki.daftar', 'monograf') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#f05a42] !no-underline font-semibold whitespace-nowrap">Daftar Monograf</a>
          </div>
        </div>

        <!-- Cek Resi & Kirim Naskah -->
        <div class="flex items-center space-x-1">
          <a href="{{ route('cek-resi') }}" class="px-2 py-2 text-sm font-bold !text-gray-600 hover:!text-[#1e1e50] transition !no-underline whitespace-nowrap">
              Cek Resi
          </a>
          <a href="https://wa.me/6281315717719" target="_blank" class="bg-[#f05a42] hover:bg-[#d94f38] !text-white px-4 py-2 rounded-full text-xs font-bold shadow-md transition !no-underline whitespace-nowrap">
              Kirim Naskah
          </a>
        </div>

      </div>

      <!-- HAMBURGER (Mobile) -->
      <div class="flex items-center md:hidden">
        <button type="button" onclick="toggleMobileMenu()" class="!text-gray-600 focus:outline-none"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
      </div>
    </div>
  </div>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white shadow-inner">
    <div class="px-4 py-3 space-y-2 font-bold text-sm">
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

      <div class="border-t pt-2">
        <span class="text-[11px] text-gray-400 uppercase block px-3 mb-1">HAKI</span>
        <a href="{{ route('haki.daftar', 'buku-ajar') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Daftar Buku Ajar</a>
        <a href="{{ route('haki.daftar', 'buku-referensi') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Daftar Buku Referensi</a>
        <a href="{{ route('haki.daftar', 'monograf') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Daftar Monograf</a>
      </div>

      <div class="border-t pt-2 flex flex-col space-y-2 pb-2">
        <a href="{{ route('cek-resi') }}" class="block text-gray-600 py-1 px-3 !no-underline">Cek Resi</a>
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