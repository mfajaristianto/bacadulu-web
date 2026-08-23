@php
$bukuTerbaru=\App\Models\Book::query()->latest()->take(5)->get();
@endphp

<section id="katalog" class="py-20 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-10" data-bd-reveal="up">
            <div>
                <div class="flex items-center gap-2 text-orange-600">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                    </svg>
                    <span class="text-xs font-bold tracking-widest uppercase">Academic Bookstore</span>
                </div>

                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Terbitan Terbaru Kami</h2>
                <p class="text-slate-500 text-sm mt-2">Buku terbaru yang tersedia dalam format cetak maupun digital.</p>
            </div>

            <a href="{{ route('portofolio.bookstore') }}" class="inline-flex items-center gap-2 text-orange-600 font-bold text-sm hover:gap-3 transition-all">
                Lihat Seluruh Koleksi
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($bukuTerbaru->isEmpty())
            <div class="text-center py-12 bg-white border border-slate-200 rounded-2xl text-slate-500">Belum ada buku terbaru.</div>
        @else

        <div class="bd-book-slider">
            @foreach($bukuTerbaru as $i=>$b)
            @php
                $cover=$b->cover?asset('storage/'.$b->cover):null;
                $front=$cover?"background-image:url('{$cover}')":"background:linear-gradient(145deg,#EF5843,#F7AA35)";
            @endphp

            <div data-bd-reveal="up" data-bd-delay="{{ $i*80 }}">
                <article data-bd-tilt class="bd-home-book">

                    <div class="bd-home-book-cover">
                        <div class="bd-book-model">
                            <div class="bd-book-model-spine"></div>
                            <div class="bd-book-model-pages"></div>

                            <div class="bd-book-model-front" style="{{ $front }}">
                                @if(!$b->cover)
                                <div>
                                    <strong>{{ Str::limit($b->title,35) }}</strong>
                                    <small>{{ $b->author }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bd-home-book-info">
                        <span class="text-[8px] font-bold uppercase tracking-wider text-slate-400">{{ $b->category??'Buku' }}</span>
                        <h3>{{ $b->title }}</h3>
                        <p>{{ $b->author }}</p>

                        <div class="bd-format-list">

                            <div class="bd-format bd-print">
                                <div class="bd-format-title">
                                    <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                                    Buku Cetak
                                </div>

                                @if($b->has_print&&$b->print_price!==null)
                                    @if($b->has_active_print_discount)
                                    <del>Rp {{ number_format((float)$b->print_price,0,',','.') }}</del>
                                    @else
                                    <del>&nbsp;</del>
                                    @endif

                                    <strong>Rp {{ number_format((float)$b->effective_print_price,0,',','.') }}</strong>
                                    <small>{{ $b->has_active_print_discount?'-'.number_format((float)$b->print_discount_percent,0).'%':' ' }}</small>
                                @else
                                    <em>Tidak tersedia</em>
                                @endif
                            </div>

                            <div class="bd-format bd-ebook">
                                <div class="bd-format-title">
                                    <svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 7h6M9 11h6"/></svg>
                                    E-book
                                </div>

                                @if($b->has_ebook&&$b->ebook_price!==null)
                                    @if($b->has_active_ebook_discount)
                                    <del>Rp {{ number_format((float)$b->ebook_price,0,',','.') }}</del>
                                    @else
                                    <del>&nbsp;</del>
                                    @endif

                                    <strong>Rp {{ number_format((float)$b->effective_ebook_price,0,',','.') }}</strong>
                                    <small>{{ $b->has_active_ebook_discount?'-'.number_format((float)$b->ebook_discount_percent,0).'%':' ' }}</small>
                                @else
                                    <em>Tidak tersedia</em>
                                @endif
                            </div>

                        </div>

                        <a href="{{ route('portofolio.bookstore.show',['book'=>$b->slug]) }}" class="bd-book-detail">
                            Lihat Detail
                            <svg viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                </article>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<style>
.bd-book-slider{display:flex;gap:18px;overflow-x:auto;padding:8px 4px 22px;scroll-snap-type:x mandatory;scrollbar-width:none}.bd-book-slider::-webkit-scrollbar{display:none}
.bd-home-book{width:245px;min-width:245px;overflow:hidden;background:#fff;border:1px solid #E7E9EE;border-radius:18px;box-shadow:0 6px 20px rgba(36,27,82,.05);scroll-snap-align:start;transform-style:preserve-3d}
.bd-home-book-cover{height:215px;display:flex;align-items:center;justify-content:center;background:linear-gradient(145deg,#FBF9F5,#F1EDE4);perspective:900px}
.bd-book-model{position:relative;width:120px;height:165px;transform-style:preserve-3d;animation:bdCatalogBook 6s ease-in-out infinite}
.bd-home-book:hover .bd-book-model{animation-play-state:paused}
.bd-book-model-front{position:absolute;inset:0;padding:12px;display:flex;align-items:flex-end;color:#fff;background-size:cover!important;background-position:center!important;border-radius:3px 7px 7px 3px;transform:translateZ(9px);box-shadow:10px 15px 24px rgba(15,23,42,.25)}
.bd-book-model-front strong{display:block;font-size:10px;line-height:1.3}.bd-book-model-front small{display:block;margin-top:4px;font-size:7px}
.bd-book-model-spine{position:absolute;left:0;top:2px;width:17px;height:161px;background:#C6432F;transform-origin:left;transform:rotateY(-90deg)}
.bd-book-model-pages{position:absolute;right:0;top:2px;width:17px;height:161px;background:repeating-linear-gradient(to bottom,#fff 0 2px,#EAE5DA 2px 3px);transform-origin:right;transform:rotateY(90deg)}
.bd-home-book-info{padding:14px;display:flex;flex-direction:column}
.bd-home-book-info>h3{height:40px;margin:5px 0 2px;overflow:hidden;color:#241B52;font-size:13px;font-weight:800;line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.bd-home-book-info>p{height:16px;margin-bottom:9px;overflow:hidden;color:#64748B;font-size:10px;white-space:nowrap;text-overflow:ellipsis}
.bd-format-list{display:grid;grid-template-rows:repeat(2,68px);gap:7px}
.bd-format{padding:7px 10px;border-radius:9px;display:flex;flex-direction:column;justify-content:center}
.bd-print{background:#FFF7ED;border:1px solid #FED7AA}.bd-ebook{background:#EEF2FF;border:1px solid #C7D2FE}
.bd-format-title{display:flex;align-items:center;gap:5px;font-size:8px;font-weight:800;text-transform:uppercase}.bd-format-title svg{width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:1.8}
.bd-print .bd-format-title{color:#C2410C}.bd-ebook .bd-format-title{color:#4338CA}
.bd-format del{height:11px;color:#94A3B8;font-size:7px}.bd-format strong{font-size:12px;color:#241B52}.bd-format small{height:9px;color:#DC2626;font-size:7px;font-weight:800}.bd-format em{height:31px;display:flex;align-items:center;color:#94A3B8;font-size:10px;font-style:normal}
.bd-book-detail{display:flex;align-items:center;justify-content:center;gap:5px;margin-top:9px;padding:9px;border:1px solid #EF5843;border-radius:8px;color:#C6432F!important;font-size:9px;font-weight:800;transition:.2s}.bd-book-detail svg{width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2}.bd-book-detail:hover{gap:8px;background:#EF5843;color:#fff!important}
@keyframes bdCatalogBook{0%,100%{transform:rotateY(-20deg) translateY(0)}50%{transform:rotateY(4deg) translateY(-7px)}}
</style>