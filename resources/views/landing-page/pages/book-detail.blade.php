@extends('layouts.app')

@section('title',$book->title.' - Baca Dulu')
@section('barba-namespace','book-detail')

@section('content')

{{-- seluruh halaman detail --}}

<style>
.book-detail-page{--navy:#241B52;--orange:#EF5843;--orange-dark:#C6432F;--gold:#F7AA35;--muted:#64748B;--border:#E2E8F0;--cream:#FBF9F5;--ease:cubic-bezier(.22,1,.36,1);min-height:100vh;background:linear-gradient(180deg,#fff,#FCFBF8);color:var(--navy)}
.book-detail-page *{box-sizing:border-box}

.detail-back{display:inline-flex;align-items:center;gap:8px;padding:10px 15px;border:1px solid #E2E8F0;border-radius:10px;color:#475569!important;background:#fff;font-size:10px;font-weight:800;box-shadow:0 4px 12px rgba(36,27,82,.04);transition:box-shadow .25s ease,color .25s ease,border-color .25s ease}
.detail-back svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2}
.detail-back:hover{border-color:rgba(239,88,67,.28);color:var(--orange)!important;box-shadow:0 10px 20px rgba(36,27,82,.07)}

.cover-3d-wrapper{position:relative;display:flex;align-items:center;justify-content:center;min-height:400px;padding:45px 20px;overflow:hidden;background:linear-gradient(135deg,#FBF9F5,#F1EDE4);border:1px solid #EAE7DF;border-radius:19px;box-shadow:0 18px 38px -15px rgba(27,36,83,.09);perspective:1200px;isolation:isolate}
.cover-3d-wrapper::before{content:"";position:absolute;width:190px;height:42px;left:50%;bottom:26px;border-radius:50%;background:rgba(36,27,82,.13);filter:blur(13px);transform:translateX(-50%)}
.cover-3d-wrapper::after{content:"";position:absolute;width:230px;height:230px;right:-110px;top:-100px;border-radius:50%;background:radial-gradient(circle,rgba(247,170,53,.18),transparent 68%);pointer-events:none}
.detail-book-motion{position:relative;z-index:2;transform-style:preserve-3d;will-change:transform}
.book3d-box{position:relative;width:220px;height:295px;transform-style:preserve-3d;animation:detailBookIdle 7s ease-in-out infinite}
.detail-book-face{position:absolute;top:0}
.detail-book-front{width:220px;height:295px;padding:24px;display:flex;flex-direction:column;justify-content:flex-end;color:#fff;background-size:cover;background-position:center;background-repeat:no-repeat;transform:translateZ(14px);border-radius:3px 9px 9px 3px;box-shadow:14px 20px 35px rgba(18,25,59,.35)}
.detail-book-pages{width:28px;height:289px;right:0;top:3px;background:repeating-linear-gradient(to bottom,#FDFCF9 0 2px,#EAE5DA 2px 3px);transform-origin:right;transform:rotateY(90deg)}
.detail-book-spine{width:28px;height:289px;left:0;top:3px;background:linear-gradient(180deg,#EF5843,#D94F38);transform-origin:left;transform:rotateY(-90deg);filter:brightness(.72)}

.bibliography-card{padding:22px;border:1px solid #E2E8F0;border-radius:15px;background:#fff;box-shadow:0 4px 14px rgba(36,27,82,.035);transition:box-shadow .3s ease,border-color .3s ease}
.bibliography-card:hover{border-color:rgba(239,88,67,.2);box-shadow:0 15px 30px rgba(36,27,82,.07)}
.bibliography-title{margin:0 0 16px;padding-bottom:10px;border-bottom:1px solid #E2E8F0;color:#0F172A;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1px}
.biblio-list{display:flex;flex-direction:column;gap:13px}
.biblio-label{display:block;margin-bottom:2px;color:#94A3B8;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.4px}
.biblio-value{color:#334155;font-size:12px;font-weight:600}
.biblio-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-top:12px;border-top:1px solid #F1F5F9}

.detail-main-card{position:relative;padding:32px;overflow:hidden;border:1px solid rgba(226,232,240,.9);border-radius:17px;background:#fff;box-shadow:0 5px 18px rgba(36,27,82,.04)}
.detail-main-card::before{content:"";position:absolute;width:220px;height:220px;right:-130px;top:-140px;border-radius:50%;background:radial-gradient(circle,rgba(239,88,67,.07),transparent 70%);pointer-events:none}
.detail-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border:1px solid #FED7AA;border-radius:999px;color:#C2410C;background:#FFF7ED;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.4px}
.detail-badge svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:1.8}
.detail-title{max-width:820px;margin:13px 0 0;color:#0F172A;font-family:'Poppins',sans-serif;font-size:clamp(28px,3.2vw,42px);font-weight:800;line-height:1.18;letter-spacing:-.7px}
.detail-author{margin:8px 0 0;color:#64748B;font-size:14px;font-weight:500}
.detail-author strong{color:#334155}

.detail-info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin:25px 0}
.detail-info-box{padding:15px;border:1px solid #E2E8F0;border-radius:11px;background:#F8FAFC;transition:background .25s ease,border-color .25s ease}
.detail-info-box:hover{border-color:#FED7AA;background:#FFFBF7}
.detail-info-box small{display:block;color:#94A3B8;font-size:9px;font-weight:800;text-transform:uppercase}
.detail-info-box strong{display:block;margin-top:4px;color:#241B52;font-size:17px;font-weight:800}

.format-area{margin:25px 0;padding:25px 0;border-top:1px solid #E2E8F0;border-bottom:1px solid #E2E8F0}
.format-area-title{color:#94A3B8;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.5px}
.format-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px;margin-top:14px}
.detail-format-card{position:relative;display:flex;flex-direction:column;padding:20px;overflow:hidden;border-radius:14px}
.detail-format-card.print{border:1px solid #FED7AA;background:#FFF7ED}
.detail-format-card.ebook{border:1px solid #C7D2FE;background:#EEF2FF}
.detail-format-label{display:inline-flex;align-items:center;gap:6px;width:max-content;margin-bottom:14px;padding:5px 10px;border-radius:999px;font-size:10px;font-weight:800}
.detail-format-label svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:1.8}
.detail-format-card.print .detail-format-label{color:#C2410C;background:#FFEDD5}
.detail-format-card.ebook .detail-format-label{color:#4338CA;background:#E0E7FF}
.old-price{height:17px;color:#94A3B8;font-size:11px;text-decoration:line-through}
.current-price{margin-top:3px;color:#241B52;font-size:24px;line-height:1.2;font-weight:800}
.discount-badge{display:inline-flex;width:max-content;margin-top:8px;padding:4px 8px;border-radius:6px;background:#FEE2E2;color:#DC2626;font-size:9px;font-weight:800}

.add-format-button{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;min-height:44px;margin-top:18px;padding:10px 14px;border:0;border-radius:9px;color:#fff;font-size:11px;font-weight:800;cursor:pointer}
.add-format-button svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8}
.detail-format-card.print .add-format-button{background:linear-gradient(135deg,#EF5843,#F7AA35)}
.detail-format-card.ebook .add-format-button{background:linear-gradient(135deg,#4338CA,#6366F1)}
.add-format-button:disabled{opacity:.7;cursor:default}

.cart-feedback{display:none;align-items:center;justify-content:space-between;gap:12px;margin-top:16px;padding:13px 15px;border:1px solid #BBF7D0;border-radius:10px;background:#F0FDF4;color:#166534;font-size:11px;font-weight:700}
.cart-feedback.show{display:flex}
.cart-feedback a{color:#15803D!important;font-weight:800;text-decoration:underline}

.description-section{padding-top:3px}
.description-title{margin:0 0 13px;padding-bottom:10px;border-bottom:1px solid #E2E8F0;color:#0F172A;font-size:16px;font-weight:800}
.description-text{color:#475569;font-size:14px;line-height:1.85;white-space:pre-line}

@keyframes detailBookIdle{
    0%,100%{transform:rotateY(-18deg) translateY(0)}
    50%{transform:rotateY(-14deg) translateY(-4px)}
}

@media(max-width:767px){
    .format-grid{grid-template-columns:1fr}
    .detail-main-card{padding:23px}
    .detail-info-grid{grid-template-columns:1fr 1fr}
    .description-text{font-size:13px}
}
@media(max-width:480px){
    .detail-info-grid{grid-template-columns:1fr}
}
@media(prefers-reduced-motion:reduce){
    .book3d-box{animation:none!important}
}
</style>

<div class="book-detail-page">
<div class="max-w-6xl mx-auto px-6 py-14 lg:px-8">

    <div class="mb-8" data-detail-intro>
        <a href="{{ route('portofolio.bookstore') }}" class="detail-back">
            <svg viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
            Kembali ke Katalog
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-12 items-start">
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
            <div class="cover-3d-wrapper" data-detail-intro>
                <div class="detail-book-motion">
                    <div class="book3d-box" id="detailBook3d">
                        <div class="detail-book-face detail-book-spine"></div>
                        <div class="detail-book-face detail-book-pages"></div>

                        <div class="detail-book-face detail-book-front"
                            style="@if($book->cover)background-image:url('{{ asset('storage/'.$book->cover) }}');@else background:linear-gradient(135deg,#EF5843,#F7AA35);@endif">

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
            </div>

            <div class="bibliography-card" data-detail-intro>
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

        <div class="lg:col-span-8">
            <div class="detail-main-card" data-detail-intro>
                <span class="detail-badge">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                    </svg>
                    Bookstore Detail
                </span>

                <h1 class="detail-title">{{ $book->title }}</h1>

                <p class="detail-author">
                    Oleh <strong>{{ $book->author }}</strong>
                </p>

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

                <div class="format-area">
                    <div class="format-area-title">
                        Pilih Format Buku
                    </div>

                    <div class="format-grid">
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
                                        IDR {{ number_format((float)$book->print_price,2,',','.') }}
                                    </div>
                                @else
                                    <div class="old-price" style="text-decoration:none">&nbsp;</div>
                                @endif

                                <div class="current-price">
                                    IDR {{ number_format((float)$book->effective_print_price,2,',','.') }}
                                </div>

                                @if($book->has_active_print_discount)
                                    <span class="discount-badge">
                                        Diskon {{ number_format((float)$book->print_discount_percent,0) }}%
                                    </span>
                                @endif

                                <button type="button"
                                    class="add-format-button detail-add-cart"
                                    data-key="book-{{ $book->id }}-print"
                                    data-book-id="{{ $book->id }}"
                                    data-format="Buku Cetak"
                                    data-title="{{ $book->title }}"
                                    data-author="{{ $book->author }}"
                                    data-publisher="{{ $book->publisher }}"
                                    data-price="{{ (float)$book->effective_print_price }}"
                                    data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}">

                                    <svg viewBox="0 0 24 24">
                                        <circle cx="9" cy="20" r="1"/>
                                        <circle cx="18" cy="20" r="1"/>
                                        <path d="M3 4h2l2.4 10.2a2 2 0 002 1.5h7.8a2 2 0 002-1.5L21 7H6"/>
                                    </svg>

                                    <span>Tambah Buku Cetak</span>
                                </button>
                            </div>
                        @endif

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
                                        IDR {{ number_format((float)$book->ebook_price,2,',','.') }}
                                    </div>
                                @else
                                    <div class="old-price" style="text-decoration:none">&nbsp;</div>
                                @endif

                                <div class="current-price">
                                    IDR {{ number_format((float)$book->effective_ebook_price,2,',','.') }}
                                </div>

                                @if($book->has_active_ebook_discount)
                                    <span class="discount-badge">
                                        Diskon {{ number_format((float)$book->ebook_discount_percent,0) }}%
                                    </span>
                                @endif

                                <button type="button"
                                    class="add-format-button detail-add-cart"
                                    data-key="book-{{ $book->id }}-ebook"
                                    data-book-id="{{ $book->id }}"
                                    data-format="E-book"
                                    data-title="{{ $book->title }}"
                                    data-author="{{ $book->author }}"
                                    data-publisher="{{ $book->publisher }}"
                                    data-price="{{ (float)$book->effective_ebook_price }}"
                                    data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}">

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

                <div class="description-section" data-detail-scroll>
                    <h2 class="description-title">
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
document.addEventListener('DOMContentLoaded',()=>{
    const root=document.querySelector('.book-detail-page');
    if(!root||root.dataset.motionReady==='1')return;
    root.dataset.motionReady='1';

    const gsap=window.bdGsap||null;
    const reduceMotion=window.matchMedia('(prefers-reduced-motion:reduce)').matches;
    const CART_KEY='bacadulu_cart';

    /* INTRO BERGANTIAN */
    if(gsap&&!reduceMotion){
        const intro=root.querySelectorAll('[data-detail-intro]');

        gsap.fromTo(intro,{
            opacity:0,
            y:28
        },{
            opacity:1,
            y:0,
            duration:.7,
            stagger:.09,
            ease:'power4.out'
        });

        const main=root.querySelector('.detail-main-card');

        if(main){
            const badge=main.querySelector('.detail-badge');
            const title=main.querySelector('.detail-title');
            const author=main.querySelector('.detail-author');
            const info=main.querySelectorAll('.detail-info-box');

            const tl=gsap.timeline({
                delay:.25,
                defaults:{ease:'power3.out'}
            });

            if(badge)tl.from(badge,{opacity:0,y:9,duration:.38});
            if(title)tl.from(title,{opacity:0,y:18,duration:.55},'-=.17');
            if(author)tl.from(author,{opacity:0,y:9,duration:.42},'-=.28');

            if(info.length){
                tl.from(info,{
                    opacity:0,
                    y:14,
                    duration:.42,
                    stagger:.055
                },'-=.18');
            }
        }
    }

    /* POINTER 3D - WRAPPER, BUKAN BOOK */
    const stage=root.querySelector('.cover-3d-wrapper');
    const motion=root.querySelector('.detail-book-motion');

    if(gsap&&!reduceMotion&&stage&&motion){
        gsap.set(motion,{
            transformPerspective:1100,
            transformStyle:'preserve-3d'
        });

        const rx=gsap.quickTo(motion,'rotationX',{
            duration:.48,
            ease:'power3.out'
        });

        const ry=gsap.quickTo(motion,'rotationY',{
            duration:.48,
            ease:'power3.out'
        });

        const x=gsap.quickTo(motion,'x',{
            duration:.48,
            ease:'power3.out'
        });

        const y=gsap.quickTo(motion,'y',{
            duration:.48,
            ease:'power3.out'
        });

        stage.addEventListener('pointermove',e=>{
            if(window.innerWidth<768)return;

            const rect=stage.getBoundingClientRect();
            const px=(e.clientX-rect.left)/rect.width-.5;
            const py=(e.clientY-rect.top)/rect.height-.5;

            ry(px*7);
            rx(-py*4);
            x(px*3);
            y(py*2-2);
        });

        stage.addEventListener('pointerleave',()=>{
            rx(0);
            ry(0);
            x(0);
            y(0);
        });
    }

    /* FORMAT REVEAL */
    if(gsap&&!reduceMotion){
        const format=root.querySelector('.format-grid');
        const description=root.querySelector('[data-detail-scroll]');

        const observer=new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(!entry.isIntersecting)return;

                observer.unobserve(entry.target);

                if(entry.target===format){
                    gsap.fromTo(format.querySelectorAll('.detail-format-card'),{
                        opacity:0,
                        y:24
                    },{
                        opacity:1,
                        y:0,
                        duration:.55,
                        stagger:.08,
                        ease:'power3.out'
                    });
                }else{
                    gsap.fromTo(entry.target,{
                        opacity:0,
                        y:20
                    },{
                        opacity:1,
                        y:0,
                        duration:.6,
                        ease:'power3.out'
                    });
                }
            });
        },{threshold:.1});

        if(format)observer.observe(format);
        if(description)observer.observe(description);
    }

    /* CART */
    const normalizeCart=data=>{
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
        }).filter(item=>item.title&&item.price>0);
    };

    const loadCart=()=>{
        try{
            return normalizeCart(JSON.parse(localStorage.getItem(CART_KEY)||'[]'));
        }catch{
            return[];
        }
    };

    root.addEventListener('click',e=>{
        const button=e.target.closest('.detail-add-cart');
        if(!button)return;

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

        if(!product.key||!product.title||product.price<=0)return;

        const cart=loadCart();
        const existing=cart.find(item=>item.key===product.key);

        if(existing)existing.qty++;
        else cart.push(product);

        localStorage.setItem(CART_KEY,JSON.stringify(cart));

        const feedback=root.querySelector('#cartFeedback');
        const feedbackText=root.querySelector('#cartFeedbackText');

        if(feedback){
            feedback.classList.add('show');

            if(gsap&&!reduceMotion){
                gsap.fromTo(feedback,{
                    opacity:0,
                    y:8
                },{
                    opacity:1,
                    y:0,
                    duration:.3,
                    ease:'power3.out'
                });
            }
        }

        if(feedbackText){
            feedbackText.textContent=
                `${product.format} berhasil ditambahkan ke keranjang.`;
        }

        const text=button.querySelector('span');
        const old=text?.textContent||'Tambah ke Keranjang';

        if(text)text.textContent='✓ Ditambahkan';
        button.disabled=true;

        if(gsap&&!reduceMotion){
            gsap.fromTo(button,{
                scale:.97
            },{
                scale:1,
                duration:.28,
                ease:'back.out(1.7)'
            });
        }

        setTimeout(()=>{
            if(text)text.textContent=old;
            button.disabled=false;
        },850);
    });
});
</script>

@endsection