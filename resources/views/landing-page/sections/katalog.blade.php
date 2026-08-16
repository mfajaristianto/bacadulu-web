{{--
    katalog.blade.php
    Menampilkan maksimal 5 buku terbaru dengan mode slide horizontal.
--}}

@php
    // Mengambil 5 buku terbaru dari database
    $bukuTerbaru = \App\Models\Book::latest()->take(5)->get();
@endphp

<section id="katalog" class="py-24 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <span class="text-orange-600 text-xs font-bold tracking-widest uppercase">Academic Bookstore</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Terbitan Terbaru Kami</h2>
            </div>
            <a href="{{ route('portofolio.bookstore') }}" class="text-orange-600 hover:text-orange-700 font-bold text-sm flex items-center gap-1 transition-all duration-200 mt-4 md:mt-0">
                <span>Lihat Seluruh Koleksi</span>
                <svg class="w-4 h-4 stroke-current stroke-2" fill="none" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($bukuTerbaru->isEmpty())
            <div class="text-center py-12 bg-white border border-slate-200 rounded-2xl">
                <p class="text-slate-500 text-sm font-medium">Belum ada buku terbaru yang ditambahkan oleh admin.</p>
            </div>
        @else
            <!-- Container Slider (Horizontal Scroll) -->
            <div class="flex gap-6 overflow-x-auto pb-8 pt-2 no-scrollbar snap-x snap-mandatory scroll-smooth">
                @foreach ($bukuTerbaru as $b)
                    @php
                        $baseColor = '#EF5843';
                        $coverUrl = $b->cover ? asset('storage/' . $b->cover) : null;
                        $spineStyle = "width:10px;background:{$baseColor};filter:brightness(.7);transform-origin:left;transform:rotateY(-90deg);";
                        $frontStyle = $coverUrl 
                            ? "transform:translateZ(5px); background-image:url('{$coverUrl}'); background-size:cover; background-position:center;"
                            : "transform:translateZ(5px); background:{$baseColor};";
                    @endphp

                    <!-- Card dengan lebar tetap agar slider berfungsi -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex flex-col justify-between group hover:border-orange-500/20 hover:shadow-lg transition-all duration-300 min-w-[260px] max-w-[260px] flex-shrink-0 snap-start">

                        <div class="aspect-[3/4] bg-slate-100 rounded-xl overflow-hidden mb-4 shadow-sm flex items-center justify-center relative" style="perspective:900px;">
                            <div class="kbook3d relative" style="width:72%;height:84%;transform-style:preserve-3d;">
                                <div class="absolute top-0 right-0 h-full kbook3d-pages"></div>
                                <div class="absolute top-0 left-0 h-full" style="{{ $spineStyle }}"></div>
                                <div class="absolute inset-0 rounded-sm shadow-xl flex items-end p-3" style="{{ $frontStyle }}">
                                    @if(!$b->cover)
                                        <span class="text-[9px] font-black text-white uppercase tracking-wider drop-shadow">{{ Str::limit($b->title, 28) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <span class="text-[9px] text-slate-400 uppercase tracking-widest">{{ $b->category ?? 'Buku' }}</span>
                            <h3 class="text-sm font-bold text-slate-800 mt-1 group-hover:text-orange-600 transition-colors duration-200 line-clamp-1">{{ $b->title }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $b->author }}</p>
                            <div class="flex justify-between items-center mt-3 pt-2 border-t border-slate-100">
                                <span class="text-xs font-extrabold text-orange-600">Rp {{ number_format($b->effective_price, 0, ',', '.') }}</span>
                                <a href="{{ route('portofolio.bookstore.show', $b->slug) }}" class="text-[9px] bg-slate-100 group-hover:bg-orange-500 group-hover:text-white px-2.5 py-1 rounded-rounded-md text-slate-700 transition-colors duration-200">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
    
    /* Muter pelan */
    @keyframes kbookWobble {
        0%, 100% { transform: rotateY(-22deg); }
        50%      { transform: rotateY(10deg); }
    }
    .kbook3d { animation: kbookWobble 7s ease-in-out infinite; }
    .group:hover .kbook3d { animation-play-state: paused; transform: rotateY(-4deg) scale(1.05); }

    /* Hide scrollbar */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>