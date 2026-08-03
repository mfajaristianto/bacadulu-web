<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

@php
    $artikel = [
        [
            'kategori' => 'Bisnis',
            'title'    => 'Strategi Mengelola Keuangan untuk Pemula',
            'excerpt'  => 'Pelajari langkah-langkah dasar dalam mengatur keuangan pribadi dan bisnis Anda dengan lebih efektif.',
            'image'    => 'cta1.jpg',
            'url'      => url('information'),
        ],
        [
            'kategori' => 'Penelitian',
            'title'    => 'Cara Menulis Jurnal Ilmiah yang Berkualitas',
            'excerpt'  => 'Panduan lengkap untuk mahasiswa dan peneliti dalam menyusun publikasi ilmiah yang terstandarisasi.',
            'image'    => 'cta2.jpg',
            'url'      => url('information'),
        ],
        [
            'kategori' => 'Teknologi',
            'title'    => 'Pemanfaatan AI dalam Dunia Akademik',
            'excerpt'  => 'Bagaimana kecerdasan buatan dapat membantu penelitian dan proses pembelajaran di era digital.',
            'image'    => 'cta3.jpg',
            'url'      => url('information'),
        ],
    ];
@endphp

<section id="baca-informasi" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <div class="w-10 h-1 bg-orange-500 rounded mb-3"></div>
                <h2 class="text-3xl font-extrabold text-slate-900">Baca Informasi</h2>
            </div>
            <!-- Mengarah ke rute information -->
            <a href="{{ url('information') }}"
               class="mt-4 md:mt-0 inline-flex items-center gap-2 text-sm font-bold text-orange-600 border border-orange-400 rounded-full px-5 py-2.5
                      hover:bg-orange-500 hover:text-white hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <span>View All Articles</span>
                <svg class="w-4 h-4 stroke-current stroke-2" fill="none" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($artikel as $i => $a)
                <!-- Kartu Utama (Bukan Link Lagi) -->
                <div class="group bg-white border border-slate-100 rounded-2xl overflow-hidden
                            hover:-translate-y-2 hover:shadow-2xl hover:border-orange-500/30
                            transition-all duration-500 flex flex-col justify-between"
                     data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">

                    <!-- 1. BAGIAN GAMBAR (Bisa Di-klik) -->
                    <a href="{{ $a['url'] }}" class="aspect-[16/10] bg-slate-100 overflow-hidden relative block">
                        <img src="{{ asset('img/' . $a['image']) }}"
                             alt="{{ $a['title'] }}"
                             onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(135deg,#f97316,#7c3aed)';"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    </a>

                    <!-- BAGIAN KONTEN TEKS -->
                    <div class="p-5 flex flex-col flex-grow justify-between">
                        <div>
                            <span class="inline-block text-[11px] font-semibold text-orange-700 bg-orange-50 px-3 py-1 rounded-full mb-3">
                                {{ $a['kategori'] }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 leading-snug mb-2">
                                {{ $a['title'] }}
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed mb-6">
                                {{ $a['excerpt'] }}
                            </p>
                        </div>

                        <!-- 2. TOMBOL BACA SELENGKAPNYA (Bisa Di-klik) -->
                        <div>
                            <a href="{{ $a['url'] }}" 
                               class="inline-flex items-center justify-center w-full text-sm font-bold text-purple-700 bg-purple-100 hover:bg-purple-200 py-3 rounded-xl transition-all duration-300 shadow-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 600, easing: 'ease-out-cubic' });
</script>