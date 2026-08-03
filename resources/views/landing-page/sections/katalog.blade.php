{{--
    katalog.blade.php
    Cuma section #katalog (buku) — struktur & class asli dipertahankan,
    cover buku diupgrade jadi 3D berputar dengan gambar asli (tinggal upload
    ke public/img/buku/).

    File ini berdiri sendiri, gak butuh AOS/library lain. Taruh di mana
    aja di urutan halaman kamu.
--}}

@php
    // Data buku dipakai buat isi cover 3D. "cover" = nama file gambar
    // yang nanti kamu upload ke public/img/buku/. Kalau file belum ada,
    // otomatis fallback ke gradient warna (gak bakal blank/rusak).
    $bukuTerbaru = [
        [
            'jenis'  => 'Buku Ajar',
            'title'  => 'Metodologi Penelitian Akademik',
            'author' => 'Dr. Sutedjo, M.Pd.',
            'price'  => 'Rp 89.000',
            'cover'  => 'metodologi-penelitian.jpg',
            'color'  => '#EF4444', 'colorTo' => '#7F1D1D',
        ],
        [
            'jenis'  => 'Monograf',
            'title'  => 'Penerapan AI Pada IoT',
            'author' => 'Ir. Ridwan Hakim, M.T.',
            'price'  => 'Rp 115.000',
            'cover'  => 'ai-iot.jpg',
            'color'  => '#3B82F6', 'colorTo' => '#1E3A8A',
        ],
        [
            'jenis'  => 'Buku Referensi',
            'title'  => 'Studi Kasus UMKM Era Digital',
            'author' => 'Prof. Dr. Hermawan, M.Si.',
            'price'  => 'Rp 95.000',
            'cover'  => 'umkm-digital.jpg',
            'color'  => '#10B981', 'colorTo' => '#065F46',
        ],
        [
            'jenis'  => 'Buku Ajar',
            'title'  => 'Teori Belajar Abad 21',
            'author' => 'Drs. Ahmad Yani, M.Phil.',
            'price'  => 'Rp 78.000',
            'cover'  => 'teori-belajar.jpg',
            'color'  => '#A855F7', 'colorTo' => '#581C87',
        ],
    ];

    // Style dihitung di sini (bukan dicampur langsung di HTML) supaya
    // atribut style="" di bawah cuma berisi SATU {{ }} bersih, gak
    // nyampur teks CSS mentah dengan Blade — biar linter CSS editor
    // (VS Code dkk) gak salah baca dan nganggepnya error.
    foreach ($bukuTerbaru as &$b) {
        $b['spineStyle'] = "width:10px;background:{$b['color']};filter:brightness(.7);"
            . "transform-origin:left;transform:rotateY(-90deg);";

        $coverUrl = asset('img/buku/' . $b['cover']);
        $b['frontStyle'] = "transform:translateZ(5px);"
            . "background-image:url('{$coverUrl}'), linear-gradient(135deg, {$b['color']}, {$b['colorTo']});"
            . "background-blend-mode:normal;";
    }
    unset($b);
@endphp

<section id="katalog" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <span class="text-orange-600 text-xs font-bold tracking-widest uppercase">Academic Bookstore</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Terbitan Terbaru Kami</h2>
            </div>
            <!-- Tombol diarahkan ke /portofolio/bookstore -->
            <a href="/portofolio/bookstore" class="text-orange-600 hover:text-orange-700 font-bold text-sm flex items-center gap-1 transition-all duration-200 mt-4 md:mt-0">
                <span>Lihat Seluruh Koleksi</span>
                <svg class="w-4 h-4 stroke-current stroke-2" fill="none" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($bukuTerbaru as $b)
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex flex-col justify-between group hover:border-orange-500/20 hover:shadow-lg transition-all duration-300">

                    <div class="aspect-[3/4] bg-slate-100 rounded-xl overflow-hidden mb-4 shadow-sm flex items-center justify-center relative" style="perspective:900px;">

                        {{-- Buku 3D: depan (gambar), halaman, punggung buku.
                             Muter pelan terus-menerus, melambat & mendekat
                             pas di-hover biar judulnya kebaca jelas. --}}
                        <div class="kbook3d relative" style="width:72%;height:84%;transform-style:preserve-3d;">

                            {{-- Sisi halaman (kanan) — statis, class di <style> bawah --}}
                            <div class="absolute top-0 right-0 h-full kbook3d-pages"></div>

                            {{-- Sisi punggung buku (kiri) --}}
                            <div class="absolute top-0 left-0 h-full" style="{{ $b['spineStyle'] }}"></div>

                            {{-- Sampul depan: pakai foto asli kalau ada, fallback gradient warna --}}
                            <div class="absolute inset-0 rounded-sm shadow-xl bg-cover bg-center flex items-end p-3"
                                 style="{{ $b['frontStyle'] }}">
                                <span class="text-[9px] font-black text-white uppercase tracking-wider drop-shadow">{{ Str::limit($b['title'], 28) }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <span class="text-[9px] text-slate-400 uppercase tracking-widest">{{ $b['jenis'] }}</span>
                        <h3 class="text-sm font-bold text-slate-800 mt-1 group-hover:text-orange-600 transition-colors duration-200">{{ $b['title'] }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $b['author'] }}</p>
                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-slate-100">
                            <span class="text-xs font-extrabold text-orange-600">{{ $b['price'] }}</span>
                            <span class="text-[9px] bg-slate-100 group-hover:bg-orange-500 group-hover:text-white px-2.5 py-1 rounded-md text-slate-700 transition-colors duration-200">Beli</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .kbook3d-pages {
        width: 10px;
        background: repeating-linear-gradient(to bottom, #fdfcf9 0 2px, #eae5da 2px 3px);
        transform-origin: right;
        transform: rotateY(90deg);
        box-shadow: inset -2px 0 4px rgba(0,0,0,0.12);
    }

    /* Muter pelan terus-menerus, berhenti & mendekat pas di-hover */
    @keyframes kbookWobble {
        0%, 100% { transform: rotateY(-22deg); }
        50%      { transform: rotateY(10deg); }
    }
    .kbook3d {
        animation: kbookWobble 7s ease-in-out infinite;
    }
    .group:hover .kbook3d {
        animation-play-state: paused;
        transform: rotateY(-4deg) scale(1.05);
        transition: transform .4s ease;
    }
    @media (prefers-reduced-motion: reduce) {
        .kbook3d { animation: none; transform: rotateY(-15deg); }
    }
</style>