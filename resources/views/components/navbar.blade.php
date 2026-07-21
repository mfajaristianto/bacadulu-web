<nav class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-100" id="main-navbar">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 h-20 items-center">
      
      <!-- AREA LOGO -->
      <div class="col-span-3 flex items-center justify-center">
        <a href="{{ route('home') }}" class="flex items-center !no-underline">
          <img src="{{ asset('img/images.jpg') }}" alt="Logo Baca Dulu" class="h-14 w-auto object-contain">
        </a>
      </div>

      <!-- NAVIGATION LINKS (Desktop) -->
      <div class="hidden md:flex col-span-6 space-x-4 items-center justify-center text-sm font-bold">
        
        <!-- 1. HOME -->
        <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-lg transition duration-200 !no-underline {{ request()->is('/') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">
            Home
        </a>

        <!-- 2. TENTANG KAMI -->
        <div class="relative group">
          <button class="px-4 py-2.5 rounded-lg !text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50] transition duration-200 flex items-center gap-1 focus:outline-none !no-underline font-bold">
            <span>Tentang Kami</span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="absolute hidden group-hover:block bg-white shadow-xl rounded-lg mt-0 py-2 w-52 border border-gray-100 z-50">
            <a href="{{ route('tentang.dewan-redaksi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Dewan Redaksi</a>
            <a href="{{ route('tentang.visi-misi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Visi dan Misi</a>
          </div>
        </div>
        
        <!-- 3. PORTOFOLIO -->
        <div class="relative group">
          <button class="px-4 py-2.5 rounded-lg !text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50] transition duration-200 flex items-center gap-1 focus:outline-none !no-underline font-bold">
            <span>Portofolio</span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="absolute hidden group-hover:block bg-white shadow-xl rounded-lg mt-0 py-2 w-48 border border-gray-100 z-50">
            <a href="{{ route('portofolio.katalog') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Katalog</a>
            <a href="{{ route('portofolio.bookstore') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#1e1e50] !no-underline font-semibold">Bookstore</a>
          </div>
        </div>

        <!-- 4. JURNAL -->
        <a href="{{ route('jurnal') }}" class="px-4 py-2.5 rounded-lg transition duration-200 !no-underline {{ request()->routeIs('jurnal') ? 'bg-[#1e1e50]/10 !text-[#1e1e50]' : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]' }}">
            Jurnal BacaDulu
        </a>

        <!-- 5. HAKI -->
        <div class="relative group">
          <button class="px-4 py-2.5 rounded-lg !text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50] transition duration-200 flex items-center gap-1 focus:outline-none !no-underline font-bold">
            <span>HAKI</span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="absolute hidden group-hover:block bg-white shadow-xl rounded-lg mt-0 py-2 w-52 border border-gray-100 z-50">
            <a href="{{ route('haki.daftar', 'buku-ajar') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#f05a42] !no-underline font-semibold">Daftar Buku Ajar</a>
            <a href="{{ route('haki.daftar', 'buku-referensi') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#f05a42] !no-underline font-semibold">Daftar Buku Referensi</a>
            <a href="{{ route('haki.daftar', 'monograf') }}" class="block px-4 py-2 text-sm !text-gray-700 hover:bg-gray-50 hover:!text-[#f05a42] !no-underline font-semibold">Daftar Monograf</a>
          </div>
        </div>
      </div>

      <!-- ACTION BUTTONS -->
      <div class="hidden md:flex col-span-3 items-center justify-end space-x-4 pr-4">
        <a href="{{ route('cek-resi') }}" class="text-sm font-bold !text-gray-600 hover:!text-[#1e1e50] transition !no-underline">Cek Resi</a>
        <a href="https://wa.me/6281315717719" target="_blank" class="bg-[#f05a42] hover:bg-[#d94f38] !text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-md transition !no-underline">Kirim Naskah</a>
      </div>

      <!-- HAMBURGER (Mobile) -->
      <div class="flex items-center md:hidden col-span-9 justify-end pr-4">
        <button type="button" onclick="toggleMobileMenu()" class="!text-gray-600"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
      </div>
    </div>
  </div>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white shadow-inner">
    <div class="px-4 py-3 space-y-2 font-bold text-sm">
      <a href="{{ route('home') }}" class="block text-gray-600 py-2 px-3 !no-underline">Home</a>
      
      <div class="border-t pt-2">
        <span class="text-[11px] text-gray-400 uppercase block px-3 mb-1">Tentang Kami</span>
        <a href="{{ route('tentang.dewan-redaksi') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Dewan Redaksi</a>
        <a href="{{ route('tentang.visi-misi') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Visi dan Misi</a>
        <a href="{{ route('tentang.kontak') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Kontak</a>
      </div>

      <div class="border-t pt-2">
        <span class="text-[11px] text-gray-400 uppercase block px-3 mb-1">Portofolio</span>
        <a href="{{ route('portofolio.katalog') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Katalog</a>
        <a href="{{ route('portofolio.bookstore') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Bookstore</a>
      </div>

      <a href="{{ route('jurnal') }}" class="block text-gray-600 py-2 px-3 !no-underline">Jurnal BacaDulu</a>

      <div class="border-t pt-2">
        <span class="text-[11px] text-gray-400 uppercase block px-3 mb-1">HAKI</span>
        <a href="{{ route('haki.daftar', 'buku-ajar') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Daftar Buku Ajar</a>
        <a href="{{ route('haki.daftar', 'buku-referensi') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Daftar Buku Referensi</a>
        <a href="{{ route('haki.daftar', 'monograf') }}" class="block text-gray-600 py-1.5 px-6 !no-underline">Daftar Monograf</a>
      </div>
    </div>
  </div>
</nav>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }
</script>