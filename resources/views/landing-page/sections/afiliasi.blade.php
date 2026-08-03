<section id="afiliasi" class="bg-white py-20 border-t border-slate-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
      Affiliated By
    </h2>
    <div class="mx-auto mt-2 h-1 w-16 bg-orange-500 rounded"></div>
    <p class="mt-4 text-base text-slate-500 max-w-2xl mx-auto">
      BacaDulu bekerja sama dengan berbagai lembaga, instansi pemerintah, dan universitas terpercaya untuk menjamin keaslian program.
    </p>

    {{-- Data logo ditaruh di array biar gak perlu tulis 14 blok HTML berulang.
         Mau nambah/hapus logo tinggal edit array ini aja. --}}
    @php
      $affiliateLogos = [
        ['src' => 'Tut Wuri Handayani.jpg', 'alt' => 'Tut Wuri Handayani'],
        ['src' => 'BRIN.svg',               'alt' => 'Badan Riset dan Inovasi Nasional'],
        ['src' => 'Fermartian.jpg',         'alt' => 'FERMARTIAN INVESTAMA KORPORA'],
        ['src' => 'Fdi.jpg',                'alt' => 'FDI PARTNERS'],
        ['src' => 'SMKN 2.jpg',             'alt' => 'SMKN 2 JAKARTA'],
        ['src' => 'IKAPI.jpg',              'alt' => 'Ikatan Penerbit Indonesia'],
        ['src' => 'LLDIKTI.jpg',            'alt' => 'Lembaga Layanan Pendidikan Tinggi Wilayah III'],
        ['src' => 'Kemnaker.jpg',           'alt' => 'Kementerian Ketenagakerjaan Republik Indonesia'],
        ['src' => 'IAEI.jpg',               'alt' => 'Ikatan Ahli Ekonomi Islam Indonesia'],
        ['src' => 'Kadin.jpg',              'alt' => 'Kamar Dagang dan Industri Indonesia'],
        ['src' => 'INKINDO.jpg',            'alt' => 'Ikatan Nasional Konsultan Indonesia'],
        ['src' => 'Univ Boro.jpg',          'alt' => 'Universitas Borobudur'],
        ['src' => 'Bentara.jpg',            'alt' => 'Bentara Campus'],
        ['src' => 'Turnitin.jpg',           'alt' => 'Turnitin'],
        ['src' => 'Crossref.jpg',           'alt' => 'Crossref'],
      ];
    @endphp

    <div class="mt-12 affiliate-marquee-wrap">
      <div class="affiliate-marquee-track">

        {{-- Set asli (yang dibaca screen reader) --}}
        @foreach ($affiliateLogos as $logo)
          <div class="affiliate-logo-box bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300">
            <img src="{{ asset('img/' . $logo['src']) }}"
                 alt="{{ $logo['alt'] }}"
                 title="{{ $logo['alt'] }}"
                 class="max-h-16 max-w-full object-contain">
          </div>
        @endforeach

        {{-- Set duplikat, disembunyikan dari screen reader, cuma buat efek loop mulus --}}
        @foreach ($affiliateLogos as $logo)
          <div class="affiliate-logo-box bg-slate-50 p-6 rounded-xl border border-slate-200/60 flex items-center justify-center h-28 w-40 sm:w-44 md:w-48 hover:bg-white hover:border-orange-500/30 hover:shadow-md transition-all duration-300" aria-hidden="true">
            <img src="{{ asset('img/' . $logo['src']) }}"
                 alt=""
                 class="max-h-16 max-w-full object-contain">
          </div>
        @endforeach

      </div>
    </div>

  </div>
</section>

<style>
    /* Wadah luar: satu baris, kelebihan lebar disembunyikan di kiri-kanan,
       dengan fade halus di tepi biar transisinya gak keliatan "putus". */
    .affiliate-marquee-wrap {
        overflow: hidden;
        -webkit-mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
        mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
    }

    /* Track berisi 2x set logo berdampingan, lebarnya otomatis (w-max),
       lalu digeser terus-menerus ke kiri sejauh 50% (= panjang 1 set logo). */
    .affiliate-marquee-track {
        display: flex;
        width: max-content;
        gap: 1rem;
        animation: affiliateMarquee 32s linear infinite;
    }

    /* Berhenti sejenak saat kursor di atas, biar logo yang mau dilihat gak lari. */
    .affiliate-marquee-wrap:hover .affiliate-marquee-track {
        animation-play-state: paused;
    }

    .affiliate-logo-box {
        flex: 0 0 auto;
    }

    @keyframes affiliateMarquee {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    @media (prefers-reduced-motion: reduce) {
        .affiliate-marquee-track {
            animation: none;
        }
    }
</style>