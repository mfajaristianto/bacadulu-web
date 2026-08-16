{{--
    baca-informasi.blade.php
    Menampilkan maksimal 5 informasi terbaru dari database dalam bentuk slider horizontal (bisa digeser).
--}}

@php
    // Mengambil maksimal 5 informasi terbaru dari database
    $artikel = \App\Models\Information::latest()
                ->take(5)
                ->get();
@endphp

<section id="baca-informasi" class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <div class="w-10 h-1 bg-orange-500 rounded mb-3"></div>
                <h2 class="text-3xl font-extrabold text-slate-900">Baca Informasi</h2>
            </div>
            <!-- Mengarah ke rute informasi -->
            <a href="{{ route('informasi') }}"
               class="mt-4 md:mt-0 inline-flex items-center gap-2 text-sm font-bold text-orange-600 border border-orange-400 rounded-full px-5 py-2.5
                      hover:bg-orange-500 hover:text-white hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                <span>View All Articles</span>
                <svg class="w-4 h-4 stroke-current stroke-2" fill="none" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($artikel->isEmpty())
            <div class="text-center py-12 bg-slate-50 border border-slate-200 rounded-2xl col-span-full">
                <p class="text-slate-500 text-sm font-medium">Belum ada informasi yang diterbitkan.</p>
            </div>
        @else
            <!-- Container Slider (Bisa Digeser ke Kanan/Kiri) -->
            <div class="flex gap-6 overflow-x-auto pb-6 pt-2 no-scrollbar snap-x snap-mandatory scroll-smooth">
                @foreach ($artikel as $i => $a)
                    @php
                        $url = isset($a->slug) ? url('/information/' . $a->slug) : route('informasi');
                        $imageUrl = $a->image ? asset('storage/' . $a->image) : null;
                    @endphp

                    <!-- Kartu Utama (Lebar responsif, flex-shrink 0 agar tidak gepeng) -->
                    <div class="group bg-white border border-slate-100 rounded-2xl overflow-hidden
                                hover:-translate-y-2 hover:shadow-2xl hover:border-orange-500/30
                                transition-all duration-500 flex flex-col justify-between
                                min-w-[280px] sm:min-w-[340px] md:min-w-[380px] max-w-[380px] flex-shrink-0 snap-start"
                         data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">

                        <!-- 1. BAGIAN GAMBAR -->
                        <a href="{{ $url }}" class="aspect-[16/10] bg-slate-100 overflow-hidden relative block">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $a->title ?? $a->judul ?? 'Informasi' }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm p-4 text-center">
                                    {{ $a->title ?? $a->judul ?? 'Informasi' }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        </a>

                        <!-- BAGIAN KONTEN TEKS -->
                        <div class="p-5 flex flex-col flex-grow justify-between">
                            <div>
                                <span class="inline-block text-[11px] font-semibold text-orange-700 bg-orange-50 px-3 py-1 rounded-full mb-3">
                                    Informasi
                                  </span>
                                <h3 class="text-base font-bold text-slate-900 leading-snug mb-2 line-clamp-2">
                                    {{ $a->title ?? $a->judul ?? '-' }}
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed mb-6 line-clamp-3">
                                    {{ $a->excerpt ?? Str::limit(strip_tags($a->content ?? $a->deskripsi ?? ''), 100) }}
                                </p>
                            </div>

                            <!-- 2. TOMBOL BACA SELENGKAPNYA -->
                            <div>
                                <a href="{{ $url }}" 
                                   class="inline-flex items-center justify-center w-full text-sm font-bold text-purple-700 bg-purple-100 hover:bg-purple-200 py-3 rounded-xl transition-all duration-300 shadow-sm">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- CSS Tambahan untuk Menyembunyikan Scrollbar tapi Tetap Bisa Digeser -->
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 600, easing: 'ease-out-cubic' });
</script>