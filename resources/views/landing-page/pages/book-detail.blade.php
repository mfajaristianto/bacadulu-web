@extends('layouts.app')

@section('title',$book->title.' - Baca Dulu')

@section('content')

<style>
.book-detail-page{--navy:#241B52;--orange:#EF5843;--orange-dark:#C6432F;--gold:#F7AA35;--muted:#64748B;--border:#E2E8F0;--cream:#FBF9F5;--ease:cubic-bezier(.22,1,.36,1);min-height:100vh;background:linear-gradient(180deg,#fff,#FCFBF8);color:var(--navy)}
.book-detail-page *{box-sizing:border-box}

/* BACK */
.detail-back{display:inline-flex;align-items:center;gap:8px;padding:10px 15px;border:1px solid #E2E8F0;border-radius:10px;color:#475569!important;background:#fff;font-size:10px;font-weight:800;box-shadow:0 4px 12px rgba(36,27,82,.04);transition:transform .25s var(--ease),box-shadow .25s ease,color .25s ease,border-color .25s ease}
.detail-back svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;transition:transform .25s ease}
.detail-back:hover{transform:translateY(-2px);border-color:rgba(239,88,67,.28);color:var(--orange)!important;box-shadow:0 10px 20px rgba(36,27,82,.07)}
.detail-back:hover svg{transform:translateX(-3px)}

/* REVEAL */
.detail-reveal{opacity:0;filter:blur(3px);transform:translateY(30px);transition:opacity .72s var(--ease),transform .72s var(--ease),filter .72s ease;transition-delay:var(--delay,0ms)}
.detail-reveal.detail-visible{opacity:1;filter:none;transform:none}

/* COVER */
.cover-3d-wrapper{position:relative;display:flex;align-items:center;justify-content:center;padding:45px 20px;overflow:hidden;background:linear-gradient(135deg,#FBF9F5 0%,#F1EDE4 100%);border:1px solid #EAE7DF;border-radius:19px;box-shadow:0 18px 38px -15px rgba(27,36,83,.09);perspective:1200px;isolation:isolate}
.cover-3d-wrapper::before{content:"";position:absolute;width:190px;height:42px;left:50%;bottom:26px;z-index:0;border-radius:50%;background:rgba(36,27,82,.13);filter:blur(13px);transform:translateX(-50%)}
.cover-3d-wrapper::after{content:"";position:absolute;width:230px;height:230px;right:-110px;top:-100px;z-index:0;border-radius:50%;background:radial-gradient(circle,rgba(247,170,53,.21),transparent 68%);pointer-events:none;animation:detailGlow 8s ease-in-out infinite}
.book3d-box{position:relative;z-index:2;width:220px;height:295px;transform-style:preserve-3d;animation:detailBookIdle 6.5s ease-in-out infinite;will-change:transform}
.cover-3d-wrapper:hover .book3d-box{animation-play-state:paused}
.detail-book-face{position:absolute;top:0}
.detail-book-front{width:220px;height:295px;padding:24px;display:flex;flex-direction:column;justify-content:flex-end;color:#fff;background-size:cover;background-position:center;background-repeat:no-repeat;transform:translateZ(14px);border-radius:3px 9px 9px 3px;box-shadow:14px 20px 35px rgba(18,25,59,.35);transition:box-shadow .35s ease}
.cover-3d-wrapper:hover .detail-book-front{box-shadow:18px 25px 42px rgba(18,25,59,.4)}
.detail-book-pages{width:28px;height:289px;right:0;top:3px;background:repeating-linear-gradient(to bottom,#FDFCF9 0 2px,#EAE5DA 2px 3px);transform-origin:right;transform:rotateY(90deg)}
.detail-book-spine{width:28px;height:289px;left:0;top:3px;background:linear-gradient(180deg,#EF5843,#D94F38);transform-origin:left;transform:rotateY(-90deg);filter:brightness(.72)}

/* BIBLIOGRAPHY */
.bibliography-card{padding:22px;border:1px solid #E2E8F0;border-radius:15px;background:#fff;box-shadow:0 4px 14px rgba(36,27,82,.035);transition:transform .3s var(--ease),box-shadow .3s ease,border-color .3s ease}
.bibliography-card:hover{transform:translateY(-3px);border-color:rgba(239,88,67,.2);box-shadow:0 15px 30px rgba(36,27,82,.07)}
.bibliography-title{margin:0 0 16px;padding-bottom:10px;border-bottom:1px solid #E2E8F0;color:#0F172A;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1px}
.biblio-list{display:flex;flex-direction:column;gap:13px}
.biblio-label{display:block;margin-bottom:2px;color:#94A3B8;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.4px}
.biblio-value{color:#334155;font-size:12px;font-weight:600}
.biblio-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-top:12px;border-top:1px solid #F1F5F9}

/* MAIN PANEL */
.detail-main-card{position:relative;padding:32px;overflow:hidden;border:1px solid rgba(226,232,240,.9);border-radius:17px;background:#fff;box-shadow:0 5px 18px rgba(36,27,82,.04);transition:box-shadow .35s ease}
.detail-main-card::before{content:"";position:absolute;width:220px;height:220px;right:-130px;top:-140px;border-radius:50%;background:radial-gradient(circle,rgba(239,88,67,.07),transparent 70%);pointer-events:none}
.detail-main-card:hover{box-shadow:0 16px 38px rgba(36,27,82,.065)}
.detail-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border:1px solid #FED7AA;border-radius:999px;color:#C2410C;background:#FFF7ED;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.4px}
.detail-badge svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:1.8}
.detail-title{max-width:820px;margin:13px 0 0;color:#0F172A;font-family:'Poppins',sans-serif;font-size:clamp(28px,3.2vw,42px);font-weight:800;line-height:1.18;letter-spacing:-.7px}
.detail-author{margin:8px 0 0;color:#64748B;font-size:14px;font-weight:500}
.detail-author strong{color:#334155}

/* INFO CARDS */
.detail-info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin:25px 0}
.detail-info-box{position:relative;padding:15px;border:1px solid #E2E8F0;border-radius:11px;background:#F8FAFC;transition:transform .25s var(--ease),background .25s ease,border-color .25s ease}
.detail-info-box:hover{transform:translateY(-3px);border-color:#FED7AA;background:#FFFBF7}
.detail-info-box small{display:block;color:#94A3B8;font-size:9px;font-weight:800;text-transform:uppercase}
.detail-info-box strong{display:block;margin-top:4px;color:#241B52;font-size:17px;font-weight:800}

/* FORMAT */
.format-area{margin:25px 0;padding:25px 0;border-top:1px solid #E2E8F0;border-bottom:1px solid #E2E8F0}
.format-area-title{color:#94A3B8;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.5px}
.format-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px;margin-top:14px}
.detail-format-card{position:relative;display:flex;flex-direction:column;padding:20px;overflow:hidden;border-radius:14px;transition:transform .3s var(--ease),box-shadow .3s ease,border-color .3s ease}
.detail-format-card::after{content:"";position:absolute;inset:0;opacity:0;pointer-events:none;background:linear-gradient(115deg,transparent 24%,rgba(255,255,255,.36) 45%,transparent 65%);transform:translateX(-130%)}
.detail-format-card:hover{transform:translateY(-5px);box-shadow:0 14px 25px rgba(36,27,82,.08)}
.detail-format-card:hover::after{opacity:1;animation:detailShine .9s ease forwards}
.detail-format-card.print{border:1px solid #FED7AA;background:#FFF7ED}
.detail-format-card.ebook{border:1px solid #C7D2FE;background:#EEF2FF}
.detail-format-label{display:inline-flex;align-items:center;gap:6px;width:max-content;margin-bottom:14px;padding:5px 10px;border-radius:999px;font-size:10px;font-weight:800}
.detail-format-label svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:1.8}
.detail-format-card.print .detail-format-label{color:#C2410C;background:#FFEDD5}
.detail-format-card.ebook .detail-format-label{color:#4338CA;background:#E0E7FF}
.old-price{height:17px;color:#94A3B8;font-size:11px;text-decoration:line-through}
.current-price{margin-top:3px;color:#241B52;font-size:24px;line-height:1.2;font-weight:800}
.discount-badge{display:inline-flex;width:max-content;margin-top:8px;padding:4px 8px;border-radius:6px;background:#FEE2E2;color:#DC2626;font-size:9px;font-weight:800}
.add-format-button{position:relative;display:flex;align-items:center;justify-content:center;gap:7px;width:100%;min-height:44px;margin-top:18px;padding:10px 14px;overflow:hidden;border:none;border-radius:9px;color:#fff;font-size:11px;font-weight:800;cursor:pointer;transition:transform .2s ease,opacity .2s ease}
.add-format-button svg{position:relative;z-index:2;width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8}
.add-format-button span{position:relative;z-index:2}
.add-format-button::before{content:"";position:absolute;inset:0;background:linear-gradient(110deg,transparent 20%,rgba(255,255,255,.32) 48%,transparent 75%);transform:translateX(-130%)}
.add-format-button:hover::before{animation:detailButtonShine .7s ease forwards}
.add-format-button:hover{transform:translateY(-2px)}
.add-format-button:active{transform:scale(.98)}
.detail-format-card.print .add-format-button{background:linear-gradient(135deg,#EF5843,#F7AA35)}
.detail-format-card.ebook .add-format-button{background:linear-gradient(135deg,#4338CA,#6366F1)}
.add-format-button:disabled{opacity:.7;cursor:default}

/* FEEDBACK */
.cart-feedback{display:none;align-items:center;justify-content:space-between;gap:12px;margin-top:16px;padding:13px 15px;border:1px solid #BBF7D0;border-radius:10px;background:#F0FDF4;color:#166534;font-size:11px;font-weight:700;animation:feedbackIn .35s var(--ease)}
.cart-feedback.show{display:flex}
.cart-feedback a{color:#15803D!important;font-weight:800;text-decoration:underline}

/* DESCRIPTION */
.description-section{padding-top:3px}
.description-title{display:flex;align-items:center;gap:8px;margin:0 0 13px;padding-bottom:10px;border-bottom:1px solid #E2E8F0;color:#0F172A;font-size:16px;font-weight:800}
.description-title svg{width:17px;height:17px;fill:none;stroke:var(--orange);stroke-width:1.7}
.description-text{color:#475569;font-size:14px;line-height:1.85;white-space:pre-line}

/* ANIMATION */
@keyframes detailBookIdle{0%,100%{transform:rotateY(-24deg) translateY(0)}50%{transform:rotateY(-17deg) translateY(-7px)}}
@keyframes detailGlow{0%,100%{transform:translate3d(0,0,0)}50%{transform:translate3d(-18px,20px,0)}}
@keyframes detailShine{from{transform:translateX(-130%)}to{transform:translateX(130%)}}
@keyframes detailButtonShine{from{transform:translateX(-130%)}to{transform:translateX(130%)}}
@keyframes feedbackIn{from{opacity:0;transform:translateY(7px)}to{opacity:1;transform:none}}

@media(max-width:767px){
    .format-grid{grid-template-columns:1fr}
    .detail-main-card{padding:23px}
    .detail-info-grid{grid-template-columns:1fr 1fr}
    .description-text{font-size:13px}
}

@media(prefers-reduced-motion:reduce){
    .detail-reveal{opacity:1!important;filter:none!important;transform:none!important;transition:none!important}
    .book3d-box,.cover-3d-wrapper::after{animation:none!important}
    .detail-format-card,.detail-info-box,.bibliography-card{transform:none!important}
}
</style>

<div class="book-detail-page">

    <div class="max-w-6xl mx-auto px-6 py-14 lg:px-8">

        {{-- BACK --}}
        <div class="mb-8 detail-reveal">

            <a href="{{ route('portofolio.bookstore') }}" class="detail-back">
                <svg viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
                Kembali ke Katalog
            </a>

        </div>

        <div class="grid gap-8 lg:grid-cols-12 items-start">

            {{-- LEFT --}}
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                {{-- COVER --}}
                <div class="cover-3d-wrapper detail-reveal">

                    <div class="book3d-box" id="detailBook3d">

                        <div class="detail-book-face detail-book-spine"></div>

                        <div class="detail-book-face detail-book-pages"></div>

                        <div
                            class="detail-book-face detail-book-front"
                            style="
                                @if($book->cover)
                                    background-image:url('{{ asset('storage/'.$book->cover) }}');
                                @else
                                    background:linear-gradient(135deg,#EF5843,#F7AA35);
                                @endif
                            "
                        >

                            @if(!$book->cover)
                                <div>
                                    <div style="font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;line-height:1.35;">
                                        {{ $book->title }}
                                    </div>

                                    <div style="margin-top:7px;font-size:11px;opacity:.85;">
                                        {{ $book->author }}
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- BIBLIOGRAPHY --}}
                <div class="bibliography-card detail-reveal">

                    <h3 class="bibliography-title">
                        Informasi Bibliografi
                    </h3>

                    <div class="biblio-list">

                        <div>
                            <span class="biblio-label">Judul Buku</span>
                            <span class="biblio-value">{{ $book->title }}</span>
                        </div>

                        <div>
                            <span class="biblio-label">Penulis</span>
                            <span class="biblio-value">{{ $book->author }}</span>
                        </div>

                        <div>
                            <span class="biblio-label">Penerbit</span>
                            <span class="biblio-value">{{ $book->publisher ?: 'Baca Dulu' }}</span>
                        </div>

                        <div class="biblio-grid">
                            <div>
                                <span class="biblio-label">Tahun</span>
                                <span class="biblio-value">{{ $book->publish_year ?? '-' }}</span>
                            </div>

                            <div>
                                <span class="biblio-label">ISBN</span>
                                <span class="biblio-value">{{ $book->isbn ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="biblio-grid">
                            <div>
                                <span class="biblio-label">Halaman</span>
                                <span class="biblio-value">{{ $book->pages ?? '-' }}</span>
                            </div>

                            <div>
                                <span class="biblio-label">Ukuran</span>
                                <span class="biblio-value">{{ $book->size ?? '-' }}</span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="lg:col-span-8">

                <div class="detail-main-card detail-reveal">

                    <span class="detail-badge">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>
                        Bookstore Detail
                    </span>

                    <h1 class="detail-title">
                        {{ $book->title }}
                    </h1>

                    <p class="detail-author">
                        Oleh <strong>{{ $book->author }}</strong>
                    </p>

                    {{-- QUICK INFO --}}
                    <div class="detail-info-grid">

                        <div class="detail-info-box">
                            <small>Halaman</small>
                            <strong>{{ $book->pages ?? '-' }}</strong>
                        </div>

                        <div class="detail-info-box">
                            <small>Kategori</small>
                            <strong>{{ $book->category ?? 'Umum' }}</strong>
                        </div>

                    </div>

                    {{-- FORMAT --}}
                    <div class="format-area">

                        <div class="format-area-title">
                            Pilih Format Buku
                        </div>

                        <div class="format-grid">

                            {{-- PRINT --}}
                            @if($book->has_print && $book->print_price !== null)

                                <div class="detail-format-card print">

                                    <span class="detail-format-label">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                                        </svg>
                                        Buku Cetak
                                    </span>

                                    @if($book->has_active_print_discount)

                                        <div class="old-price">
                                            Rp {{ number_format((float)$book->print_price,0,',','.') }}
                                        </div>

                                    @else

                                        <div class="old-price" style="text-decoration:none">
                                            &nbsp;
                                        </div>

                                    @endif

                                    <div class="current-price">
                                        Rp {{ number_format((float)$book->effective_print_price,0,',','.') }}
                                    </div>

                                    @if($book->has_active_print_discount)

                                        <span class="discount-badge">
                                            Diskon {{ number_format((float)$book->print_discount_percent,0) }}%
                                        </span>

                                    @endif

                                    <button
                                        type="button"
                                        class="add-format-button detail-add-cart"
                                        data-key="book-{{ $book->id }}-print"
                                        data-book-id="{{ $book->id }}"
                                        data-format="Buku Cetak"
                                        data-title="{{ $book->title }}"
                                        data-author="{{ $book->author }}"
                                        data-publisher="{{ $book->publisher }}"
                                        data-price="{{ (float)$book->effective_print_price }}"
                                        data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}"
                                    >
                                        <svg viewBox="0 0 24 24">
                                            <circle cx="9" cy="20" r="1"/>
                                            <circle cx="18" cy="20" r="1"/>
                                            <path d="M3 4h2l2.4 10.2a2 2 0 002 1.5h7.8a2 2 0 002-1.5L21 7H6"/>
                                        </svg>
                                        <span>Tambah Buku Cetak</span>
                                    </button>

                                </div>

                            @endif

                            {{-- EBOOK --}}
                            @if($book->has_ebook && $book->ebook_price !== null)

                                <div class="detail-format-card ebook">

                                    <span class="detail-format-label">
                                        <svg viewBox="0 0 24 24">
                                            <rect x="5" y="3" width="14" height="18" rx="2"/>
                                            <path d="M9 7h6M9 11h6"/>
                                        </svg>
                                        E-book
                                    </span>

                                    @if($book->has_active_ebook_discount)

                                        <div class="old-price">
                                            Rp {{ number_format((float)$book->ebook_price,0,',','.') }}
                                        </div>

                                    @else

                                        <div class="old-price" style="text-decoration:none">
                                            &nbsp;
                                        </div>

                                    @endif

                                    <div class="current-price">
                                        Rp {{ number_format((float)$book->effective_ebook_price,0,',','.') }}
                                    </div>

                                    @if($book->has_active_ebook_discount)

                                        <span class="discount-badge">
                                            Diskon {{ number_format((float)$book->ebook_discount_percent,0) }}%
                                        </span>

                                    @endif

                                    <button
                                        type="button"
                                        class="add-format-button detail-add-cart"
                                        data-key="book-{{ $book->id }}-ebook"
                                        data-book-id="{{ $book->id }}"
                                        data-format="E-book"
                                        data-title="{{ $book->title }}"
                                        data-author="{{ $book->author }}"
                                        data-publisher="{{ $book->publisher }}"
                                        data-price="{{ (float)$book->effective_ebook_price }}"
                                        data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}"
                                    >
                                        <svg viewBox="0 0 24 24">
                                            <circle cx="9" cy="20" r="1"/>
                                            <circle cx="18" cy="20" r="1"/>
                                            <path d="M3 4h2l2.4 10.2a2 2 0 002 1.5h7.8a2 2 0 002-1.5L21 7H6"/>
                                        </svg>
                                        <span>Tambah E-book</span>
                                    </button>

                                </div>

                            @endif

                        </div>

                        @if(!$book->has_print && !$book->has_ebook)

                            <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
                                Format buku belum tersedia.
                            </div>

                        @endif

                        <div id="cartFeedback" class="cart-feedback">

                            <span id="cartFeedbackText">
                                Produk ditambahkan ke keranjang.
                            </span>

                            <a href="{{ route('portofolio.bookstore') }}">
                                Buka Bookstore
                            </a>

                        </div>

                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="description-section">

                        <h2 class="description-title">
                            <svg viewBox="0 0 24 24">
                                <path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5"/>
                            </svg>
                            Sinopsis & Deskripsi
                        </h2>

                        <div class="description-text">
                            {{ $book->description ?? 'Belum ada deskripsi.' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    const CART_KEY='bacadulu_cart';
    const reduceMotion=window.matchMedia('(prefers-reduced-motion:reduce)').matches;

    const feedback=document.getElementById('cartFeedback');
    const feedbackText=document.getElementById('cartFeedbackText');
    const coverWrapper=document.querySelector('.cover-3d-wrapper');
    const book3d=document.getElementById('detailBook3d');

    /* REVEAL */
    const reveals=[...document.querySelectorAll('.detail-reveal')];

    reveals.forEach((el,index)=>{
        el.style.setProperty('--delay',`${Math.min(index,5)*80}ms`);
    });

    if(!reduceMotion){
        const observer=new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    entry.target.classList.add('detail-visible');
                }else{
                    entry.target.classList.remove('detail-visible');
                }
            });
        },{
            threshold:.08,
            rootMargin:'0px 0px -5% 0px'
        });

        reveals.forEach(el=>observer.observe(el));
    }else{
        reveals.forEach(el=>el.classList.add('detail-visible'));
    }

    /* 3D BOOK POINTER */
    if(!reduceMotion&&coverWrapper&&book3d){
        coverWrapper.addEventListener('pointermove',event=>{
            if(window.innerWidth<768)return;

            const rect=coverWrapper.getBoundingClientRect();
            const x=(event.clientX-rect.left)/rect.width;
            const y=(event.clientY-rect.top)/rect.height;

            const rx=(.5-y)*4;
            const ry=-18+(x-.5)*9;

            book3d.style.animationPlayState='paused';
            book3d.style.transform=
                `rotateX(${rx}deg) rotateY(${ry}deg) translateY(-5px)`;
        });

        coverWrapper.addEventListener('pointerleave',()=>{
            book3d.style.transform='';
            book3d.style.animationPlayState='';
        });
    }

    /* CART */
    function normalizeCart(data){
        if(!Array.isArray(data))return[];

        return data.map((item,index)=>{
            let title=String(item.title??'');
            let format=item.format??'Buku';

            if(!item.format&&title.toLowerCase().includes('e-book')){
                format='E-book';
            }

            if(!item.format&&title.toLowerCase().includes('cetak')){
                format='Buku Cetak';
            }

            return{
                key:String(item.key??item.productKey??`legacy-${item.id??index}-${index}`),
                bookId:item.bookId??item.id??null,
                title:title.replace(/\s*-\s*(Buku Cetak|E-book)$/i,''),
                format,
                author:String(item.author??''),
                publisher:String(item.publisher??''),
                cover:String(item.cover??''),
                price:Number(item.price??0),
                qty:Math.max(1,Number(item.qty??1))
            };
        }).filter(item=>item.title!==''&&item.price>0);
    }

    function loadCart(){
        try{
            const result=JSON.parse(localStorage.getItem(CART_KEY)||'[]');
            return normalizeCart(result);
        }catch(error){
            return[];
        }
    }

    function saveCart(cart){
        localStorage.setItem(CART_KEY,JSON.stringify(cart));
    }

    function addToCart(button){
        const product={
            key:button.dataset.key,
            bookId:button.dataset.bookId,
            title:button.dataset.title??'',
            format:button.dataset.format??'Buku',
            author:button.dataset.author??'',
            publisher:button.dataset.publisher??'',
            cover:button.dataset.cover??'',
            price:Number(button.dataset.price??0),
            qty:1
        };

        if(!product.key||!product.title||product.price<=0){
            return;
        }

        const cart=loadCart();
        const existing=cart.find(item=>item.key===product.key);

        if(existing){
            existing.qty++;
        }else{
            cart.push(product);
        }

        saveCart(cart);

        if(feedback){
            feedback.classList.remove('show');
            void feedback.offsetWidth;
            feedback.classList.add('show');
        }

        if(feedbackText){
            feedbackText.textContent=
                `${product.format} berhasil ditambahkan ke keranjang.`;
        }

        const span=button.querySelector('span');
        const original=span?.textContent??'Tambah ke Keranjang';

        if(span){
            span.textContent='✓ Ditambahkan';
        }

        button.disabled=true;

        setTimeout(()=>{
            if(span){
                span.textContent=original;
            }

            button.disabled=false;
        },1000);
    }

    document.querySelectorAll('.detail-add-cart').forEach(button=>{
        button.addEventListener('click',()=>{
            addToCart(button);
        });
    });
});
</script>

@endsection