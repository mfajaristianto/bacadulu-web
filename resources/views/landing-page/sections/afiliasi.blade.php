<section id="afiliasi" class="bg-white py-20 border-t border-slate-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    
    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
      Affiliated By
    </h2>
    <div class="mx-auto mt-2 h-1 w-16 bg-orange-500 rounded"></div>
    <p class="mt-4 text-base text-slate-500 max-w-2xl mx-auto">
      BacaDulu bekerja sama dengan berbagai lembaga, instansi pemerintah, dan universitas terpercaya untuk menjamin keaslian program.
    </p>

    <!-- >>> DIUBAH TOTAL: sebelumnya 1 flex besar + lebar % pakai calc() yang rawan meleset. -->
    <!-- Sekarang: 3 baris manual (5-5-4), tiap baris flex+justify-center SENDIRI, -->
    <!-- box pakai lebar TETAP (w-40/sm:w-44/md:w-48) bukan persentase, jadi gak butuh calc() -->
    <!-- sama sekali dan gak mungkin salah hitung lagi. Di layar sempit (HP), tiap baris -->
    <!-- otomatis wrap sendiri (flex-wrap) dan tetap center karena justify-center per baris. -->

    <div class="mt-12 space-y-4">

      <!-- ===== BARIS 1 (5 logo) ===== -->
      <div class="flex flex-wrap justify-center gap-4">

        <!-- Box Logo 1 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Tut Wuri Handayani.jpg') }}" alt="Tut Wuri Handayani" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Tut Wuri Handayani
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 2 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/BRIN.svg') }}" alt="BRIN" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Badan Riset dan Inovasi Nasional
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 3 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Fermartian.jpg') }}" alt="Fermartian" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            FERMARTIAN INVESTAMA KORPORA
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 4 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Fdi.jpg') }}" alt="Fdi" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            FDI PARTNERS
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 5 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/IKAPI.jpg') }}" alt="IKAPI" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Ikatan Penerbit Indonesia
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

      </div>

      <!-- ===== BARIS 2 (5 logo) ===== -->
      <div class="flex flex-wrap justify-center gap-4">

        <!-- Box Logo 6 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/LLDIKTI.jpg') }}" alt="LLDIKTI" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            LEMBAGA LAYANAN PENDIDIKAN TINGGI WILAYAH III
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 7 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Kemnaker.jpg') }}" alt="Kemnaker" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            KEMENTERIAN KETENAGAKERJAAN REPUBLIK INDONESIA
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 8 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/IAEI.jpg') }}" alt="IAEI" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Ikatan Ahli Ekonomi Islam Indonesia
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 9 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Kadin.jpg') }}" alt="Kadin" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Kamar dagang dan Industri Indonesia
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 10 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/INKINDO.jpg') }}" alt="INKINDO" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Ikatan Nasional Konsultan Indonesia
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

      </div>

      <!-- ===== BARIS 3 (4 logo, tetap center) ===== -->
      <div class="flex flex-wrap justify-center gap-4">

        <!-- Box Logo 11 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Univ Boro.jpg') }}" alt="Univ Boro" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Universitas Borobudur
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 12 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Bentara.jpg') }}" alt="Bentara" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Bentara Campus
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 13 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Turnitin.jpg') }}" alt="Turnitin" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Turnitin
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

        <!-- Box Logo 14 -->
        <div class="group relative bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300 cursor-pointer">
          <img src="{{ asset('img/Crossref.jpg') }}" alt="Crossref" class="max-h-16 max-w-full object-contain opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
          <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block bg-slate-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-xl w-48 text-center z-30 font-sans pointer-events-none">
            Crossref
            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-[1px] border-solid border-t-slate-900 border-x-transparent border-x-4 border-b-0 border-t-4"></div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>