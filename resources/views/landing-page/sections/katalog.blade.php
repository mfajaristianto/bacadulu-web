@php
$bukuTerbaru=\App\Models\Book::query()->latest()->take(5)->get();
@endphp

<section id="katalog" class="bd-catalog-section py-20 bg-slate-50 overflow-hidden">
    <div class="bd-section-glow bg-orange-400 -left-44 top-16"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-10" data-bd-reveal="up">
            <div>
                <div class="flex items-center gap-2 text-orange-600">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                    </svg>

                    <span class="text-xs font-bold tracking-widest uppercase">
                        Academic Bookstore
                    </span>
                </div>

                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">
                    Terbitan Terbaru Kami
                </h2>

                <p class="text-slate-500 text-sm mt-2">
                    Jelajahi koleksi buku terbaru BacaDulu dalam format cetak maupun digital.
                </p>
            </div>

            <a href="{{ route('portofolio.bookstore') }}"
               class="inline-flex items-center gap-2 text-orange-600 font-bold text-sm hover:gap-3 transition-all">
                Lihat Seluruh Koleksi

                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($bukuTerbaru->isEmpty())

            <div class="text-center py-12 bg-white border border-slate-200 rounded-2xl text-slate-500">
                Belum ada buku terbaru.
            </div>

        @else

            <div class="bd-catalog-stage">

                <div class="bd-book-slider">

                    @foreach($bukuTerbaru as $i=>$b)
                        @php
                        $cover=$b->cover?asset('storage/'.$b->cover):null;

                        $front=$cover
                            ?"background-image:url('{$cover}')"
                            :"background:linear-gradient(145deg,#EF5843,#F7AA35)";
                        @endphp

                        <div class="bd-book-slide" data-bd-catalog-item>

                            <article data-bd-tilt class="bd-home-book">

                                <div class="bd-home-book-cover">

                                    <div class="bd-book-stage">

                                        <div class="bd-book-shadow"></div>

                                        <div class="bd-book-model">
                                            <div class="bd-book-model-spine"></div>
                                            <div class="bd-book-model-pages"></div>

                                            <div class="bd-book-model-front" style="{{ $front }}">
                                                @if(!$b->cover)
                                                    <div>
                                                        <strong>
                                                            {{ \Illuminate\Support\Str::limit($b->title,35) }}
                                                        </strong>
                                                        <small>{{ $b->author }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="bd-book-shine"></div>
                                    </div>

                                    <span class="bd-book-number">
                                        {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                                    </span>

                                </div>

                                <div class="bd-home-book-info">

                                    <span class="text-[8px] font-bold uppercase tracking-wider text-slate-400">
                                        {{ $b->category??'Buku' }}
                                    </span>

                                    <h3>{{ $b->title }}</h3>

                                    <p>{{ $b->author }}</p>

                                    <div class="bd-format-list">

                                        <div class="bd-format bd-print">
                                            <div class="bd-format-title">
                                                <svg viewBox="0 0 24 24">
                                                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                                                </svg>
                                                Buku Cetak
                                            </div>

                                            @if($b->has_print&&$b->print_price!==null)

                                                @if($b->has_active_print_discount)
                                                    <del>
                                                        IDR {{ number_format((float)$b->print_price,2,',','.') }}
                                                    </del>
                                                @else
                                                    <del>&nbsp;</del>
                                                @endif

                                                <strong>
                                                    IDR {{ number_format((float)$b->effective_print_price,2,',','.') }}
                                                </strong>

                                                <small>
                                                    {{ $b->has_active_print_discount
                                                        ?'-'.number_format((float)$b->print_discount_percent,0).'%'
                                                        :' '
                                                    }}
                                                </small>

                                            @else
                                                <em>Tidak tersedia</em>
                                            @endif
                                        </div>

                                        <div class="bd-format bd-ebook">
                                            <div class="bd-format-title">
                                                <svg viewBox="0 0 24 24">
                                                    <rect x="5" y="3" width="14" height="18" rx="2"/>
                                                    <path d="M9 7h6M9 11h6"/>
                                                </svg>
                                                E-book
                                            </div>

                                            @if($b->has_ebook&&$b->ebook_price!==null)

                                                @if($b->has_active_ebook_discount)
                                                    <del>
                                                        IDR {{ number_format((float)$b->ebook_price,2,',','.') }}
                                                    </del>
                                                @else
                                                    <del>&nbsp;</del>
                                                @endif

                                                <strong>
                                                    IDR {{ number_format((float)$b->effective_ebook_price,2,',','.') }}
                                                </strong>

                                                <small>
                                                    {{ $b->has_active_ebook_discount
                                                        ?'-'.number_format((float)$b->ebook_discount_percent,0).'%'
                                                        :' '
                                                    }}
                                                </small>

                                            @else
                                                <em>Tidak tersedia</em>
                                            @endif
                                        </div>

                                    </div>

                                    <a href="{{ route('portofolio.bookstore.show',['book'=>$b->slug]) }}"
                                       class="bd-book-detail">
                                        Lihat Detail

                                        <svg viewBox="0 0 24 24">
                                            <path d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>

                                </div>

                            </article>

                        </div>
                    @endforeach

                </div>

                <div class="bd-catalog-footer">

                    <div class="bd-catalog-line"></div>

                    <div class="bd-catalog-actions">

                        <button type="button"
                                class="bd-catalog-nav"
                                data-catalog-prev
                                aria-label="Buku sebelumnya">
                            <svg viewBox="0 0 24 24">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>

                        <button type="button"
                                class="bd-catalog-nav"
                                data-catalog-next
                                aria-label="Buku berikutnya">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>

                    </div>

                </div>

            </div>

        @endif

    </div>
</section>

<style>
.bd-catalog-section{position:relative}
.bd-catalog-stage{position:relative;width:100%}

.bd-book-slider{
    display:flex;
    gap:20px;
    width:100%;
    overflow-x:auto;
    padding:15px 5px 30px;
    scroll-snap-type:x mandatory;
    scrollbar-width:none;
    overscroll-behavior-x:contain
}

.bd-book-slider::-webkit-scrollbar{display:none}

.bd-book-slide{
    flex:0 0 270px;
    scroll-snap-align:start;
    perspective:1200px;
    will-change:transform,opacity
}

.bd-home-book{
    width:270px;
    min-width:270px;
    overflow:hidden;
    background:#fff;
    border:1px solid #E7E9EE;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(36,27,82,.055);
    transform-style:preserve-3d;
    transition:border-color .35s ease,box-shadow .35s ease
}

.bd-home-book:hover{
    border-color:rgba(239,88,67,.32);
    box-shadow:0 25px 55px rgba(36,27,82,.13)
}

.bd-home-book-cover{
    position:relative;
    height:240px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    background:
        radial-gradient(circle at 50% 38%,rgba(247,170,53,.11),transparent 31%),
        linear-gradient(145deg,#FBF9F5,#F0EBE1);
    perspective:1000px
}

.bd-book-stage{
    position:relative;
    width:150px;
    height:195px;
    display:flex;
    align-items:center;
    justify-content:center;
    transform-style:preserve-3d;
    will-change:transform
}

.bd-book-model{
    position:relative;
    width:126px;
    height:174px;
    transform-style:preserve-3d;
    animation:bdCatalogBook 5.5s ease-in-out infinite;
    z-index:3
}

.bd-book-model-front{
    position:absolute;
    inset:0;
    padding:12px;
    display:flex;
    align-items:flex-end;
    color:#fff;
    background-size:cover!important;
    background-position:center!important;
    border-radius:3px 7px 7px 3px;
    transform:translateZ(9px);
    box-shadow:12px 17px 26px rgba(15,23,42,.26)
}

.bd-book-model-front strong{
    display:block;
    font-size:10px;
    line-height:1.3
}

.bd-book-model-front small{
    display:block;
    margin-top:4px;
    font-size:7px
}

.bd-book-model-spine{
    position:absolute;
    left:0;
    top:2px;
    width:18px;
    height:170px;
    background:#C6432F;
    transform-origin:left;
    transform:rotateY(-90deg)
}

.bd-book-model-pages{
    position:absolute;
    right:0;
    top:2px;
    width:18px;
    height:170px;
    background:repeating-linear-gradient(
        to bottom,
        #fff 0 2px,
        #EAE5DA 2px 3px
    );
    transform-origin:right;
    transform:rotateY(90deg)
}

.bd-book-shadow{
    position:absolute;
    z-index:1;
    width:105px;
    height:24px;
    bottom:1px;
    left:24px;
    border-radius:50%;
    background:rgba(15,23,42,.17);
    filter:blur(12px);
    transform:rotate(-3deg)
}

.bd-book-shine{
    position:absolute;
    z-index:5;
    top:-30%;
    left:20%;
    width:35px;
    height:160%;
    opacity:0;
    pointer-events:none;
    background:linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,.65),
        transparent
    );
    transform:rotate(17deg)
}

.bd-book-number{
    position:absolute;
    right:18px;
    top:14px;
    color:rgba(36,27,82,.12);
    font-size:32px;
    line-height:1;
    font-weight:900
}

.bd-home-book-info{
    padding:15px;
    display:flex;
    flex-direction:column
}

.bd-home-book-info>h3{
    height:40px;
    margin:5px 0 2px;
    overflow:hidden;
    color:#241B52;
    font-size:13px;
    font-weight:800;
    line-height:1.45;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical
}

.bd-home-book-info>p{
    height:16px;
    margin-bottom:9px;
    overflow:hidden;
    color:#64748B;
    font-size:10px;
    white-space:nowrap;
    text-overflow:ellipsis
}

.bd-format-list{
    display:grid;
    grid-template-rows:repeat(2,72px);
    gap:7px
}

.bd-format{
    padding:7px 10px;
    border-radius:9px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    overflow:hidden
}

.bd-print{
    background:#FFF7ED;
    border:1px solid #FED7AA
}

.bd-ebook{
    background:#EEF2FF;
    border:1px solid #C7D2FE
}

.bd-format-title{
    display:flex;
    align-items:center;
    gap:5px;
    font-size:8px;
    font-weight:800;
    text-transform:uppercase
}

.bd-format-title svg{
    width:12px;
    height:12px;
    flex-shrink:0;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8
}

.bd-print .bd-format-title{color:#C2410C}
.bd-ebook .bd-format-title{color:#4338CA}

.bd-format del{
    height:11px;
    overflow:hidden;
    color:#94A3B8;
    font-size:7px;
    white-space:nowrap
}

.bd-format strong{
    display:block;
    overflow:hidden;
    color:#241B52;
    font-size:10px;
    line-height:16px;
    font-weight:800;
    white-space:nowrap
}

.bd-format small{
    height:9px;
    color:#DC2626;
    font-size:7px;
    font-weight:800
}

.bd-format em{
    height:31px;
    display:flex;
    align-items:center;
    color:#94A3B8;
    font-size:10px;
    font-style:normal
}

.bd-book-detail{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    margin-top:10px;
    padding:9px;
    border:1px solid #EF5843;
    border-radius:8px;
    color:#C6432F!important;
    font-size:9px;
    font-weight:800;
    transition:.25s ease
}

.bd-book-detail svg{
    width:12px;
    height:12px;
    fill:none;
    stroke:currentColor;
    stroke-width:2
}

.bd-book-detail:hover{
    gap:8px;
    background:#EF5843;
    color:#fff!important
}

.bd-catalog-footer{
    display:flex;
    align-items:center;
    gap:20px;
    margin-top:3px
}

.bd-catalog-line{
    flex:1;
    height:2px;
    border-radius:999px;
    background:linear-gradient(
        90deg,
        #EF5843,
        #F7AA35 40%,
        #E2E8F0
    )
}

.bd-catalog-actions{
    display:flex;
    align-items:center;
    gap:7px
}

.bd-catalog-nav{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid #E2E8F0;
    border-radius:11px;
    color:#241B52;
    background:#fff;
    cursor:pointer;
    transition:.25s ease
}

.bd-catalog-nav:hover{
    color:#fff;
    border-color:#EF5843;
    background:#EF5843;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(239,88,67,.17)
}

.bd-catalog-nav svg{
    width:16px;
    height:16px;
    fill:none;
    stroke:currentColor;
    stroke-width:2
}

@keyframes bdCatalogBook{
    0%,100%{
        transform:rotateY(-19deg) translateY(0)
    }

    50%{
        transform:rotateY(5deg) translateY(-8px)
    }
}

@media(max-width:640px){
    .bd-book-slide{
        flex-basis:225px
    }

    .bd-home-book{
        width:225px;
        min-width:225px
    }

    .bd-home-book-cover{
        height:220px
    }

    .bd-format strong{
        font-size:9px
    }

    .bd-catalog-actions{
        display:none
    }
}

@media(prefers-reduced-motion:reduce){
    .bd-book-model{
        animation:none
    }
}
</style>