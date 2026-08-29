@extends('layouts.app')

@section('title',$book->title.' - Baca Dulu')
@section('barba-namespace','book-detail')

@section('content')

<style>
.book-detail-page{
    --navy:#241B52;
    --orange:#EF5843;
    --gold:#F7AA35;
    --muted:#64748B;
    --border:#E2E8F0;
    --cream:#FBF9F5;
    width:100%;
    min-height:100vh;
    overflow-x:hidden;
    background:linear-gradient(180deg,#fff,#FCFBF8);
    color:var(--navy)
}
.book-detail-page *{box-sizing:border-box}

.detail-page-wrap{
    width:min(calc(100% - 48px),1152px);
    margin:0 auto;
    padding:56px 0
}

.detail-back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:42px;
    padding:10px 15px;
    border:1px solid #E2E8F0;
    border-radius:10px;
    color:#475569!important;
    background:#fff;
    font-size:10px;
    font-weight:800;
    box-shadow:0 4px 12px rgba(36,27,82,.04)
}
.detail-back svg{
    width:15px;
    height:15px;
    fill:none;
    stroke:currentColor;
    stroke-width:2
}

.detail-layout{
    display:grid;
    grid-template-columns:minmax(280px,1fr) minmax(0,2fr);
    gap:32px;
    align-items:start;
    margin-top:30px
}
.detail-side{
    display:flex;
    flex-direction:column;
    gap:24px
}

@media(min-width:1024px){
    .detail-side{
        position:sticky;
        top:100px
    }
}

.cover-3d-wrapper{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:400px;
    padding:45px 20px;
    overflow:hidden;
    background:linear-gradient(135deg,#FBF9F5,#F1EDE4);
    border:1px solid #EAE7DF;
    border-radius:19px;
    box-shadow:0 18px 38px -15px rgba(27,36,83,.09);
    perspective:1200px;
    isolation:isolate
}
.cover-3d-wrapper::before{
    content:"";
    position:absolute;
    width:190px;
    height:42px;
    left:50%;
    bottom:26px;
    border-radius:50%;
    background:rgba(36,27,82,.13);
    filter:blur(13px);
    transform:translateX(-50%)
}
.cover-3d-wrapper::after{
    content:"";
    position:absolute;
    width:230px;
    height:230px;
    right:-110px;
    top:-100px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(247,170,53,.18),transparent 68%);
    pointer-events:none
}

.detail-book-motion{
    position:relative;
    z-index:2;
    transform-style:preserve-3d
}
.book3d-box{
    position:relative;
    width:220px;
    height:295px;
    transform-style:preserve-3d;
    animation:detailBookIdle 7s ease-in-out infinite
}
.detail-book-face{position:absolute;top:0}
.detail-book-front{
    width:220px;
    height:295px;
    overflow:hidden;
    color:#fff;
    transform:translateZ(14px);
    border-radius:3px 9px 9px 3px;
    background:linear-gradient(135deg,#EF5843,#F7AA35);
    box-shadow:14px 20px 35px rgba(18,25,59,.35)
}
.detail-book-cover{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
    z-index:2
}
.detail-cover-fallback{
    position:absolute;
    inset:0;
    z-index:1;
    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    padding:24px;
    background:linear-gradient(145deg,#EF5843,#E4713F);
    color:#fff
}
.detail-cover-fallback strong{
    font-family:'Poppins',sans-serif;
    font-size:18px;
    line-height:1.35
}
.detail-cover-fallback span{
    margin-top:7px;
    font-size:11px;
    opacity:.85
}
.detail-book-pages{
    width:28px;
    height:289px;
    right:0;
    top:3px;
    background:repeating-linear-gradient(to bottom,#FDFCF9 0 2px,#EAE5DA 2px 3px);
    transform-origin:right;
    transform:rotateY(90deg)
}
.detail-book-spine{
    width:28px;
    height:289px;
    left:0;
    top:3px;
    background:linear-gradient(180deg,#EF5843,#D94F38);
    transform-origin:left;
    transform:rotateY(-90deg);
    filter:brightness(.72)
}

.bibliography-card{
    padding:22px;
    border:1px solid #E2E8F0;
    border-radius:15px;
    background:#fff;
    box-shadow:0 4px 14px rgba(36,27,82,.035)
}
.bibliography-title{
    margin:0 0 16px;
    padding-bottom:10px;
    border-bottom:1px solid #E2E8F0;
    color:#0F172A;
    font-size:10px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:1px
}
.biblio-list{display:flex;flex-direction:column;gap:13px}
.biblio-label{
    display:block;
    margin-bottom:2px;
    color:#94A3B8;
    font-size:9px;
    font-weight:700;
    text-transform:uppercase
}
.biblio-value{
    display:block;
    color:#334155;
    font-size:12px;
    font-weight:600;
    overflow-wrap:anywhere
}
.biblio-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
    padding-top:12px;
    border-top:1px solid #F1F5F9
}

.detail-main-card{
    position:relative;
    padding:32px;
    overflow:hidden;
    border:1px solid rgba(226,232,240,.9);
    border-radius:17px;
    background:#fff;
    box-shadow:0 5px 18px rgba(36,27,82,.04)
}
.detail-main-card::before{
    content:"";
    position:absolute;
    width:220px;
    height:220px;
    right:-130px;
    top:-140px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.07),transparent 70%);
    pointer-events:none
}
.detail-badge{
    position:relative;
    z-index:2;
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 10px;
    border:1px solid #FED7AA;
    border-radius:999px;
    color:#C2410C;
    background:#FFF7ED;
    font-size:9px;
    font-weight:800;
    text-transform:uppercase
}
.detail-badge svg{
    width:13px;
    height:13px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8
}
.detail-title{
    position:relative;
    z-index:2;
    max-width:820px;
    margin:13px 0 0;
    color:#0F172A;
    font-family:'Poppins',sans-serif;
    font-size:clamp(28px,3.2vw,42px);
    font-weight:800;
    line-height:1.18;
    letter-spacing:-.7px;
    overflow-wrap:anywhere
}
.detail-author{
    position:relative;
    z-index:2;
    margin:8px 0 0;
    color:#64748B;
    font-size:14px
}
.detail-author strong{color:#334155}

.detail-info-grid{
    position:relative;
    z-index:2;
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
    margin:25px 0
}
.detail-info-box{
    padding:15px;
    border:1px solid #E2E8F0;
    border-radius:11px;
    background:#F8FAFC
}
.detail-info-box small{
    display:block;
    color:#94A3B8;
    font-size:9px;
    font-weight:800;
    text-transform:uppercase
}
.detail-info-box strong{
    display:block;
    margin-top:4px;
    color:#241B52;
    font-size:17px;
    font-weight:800;
    overflow-wrap:anywhere
}

.format-area{
    position:relative;
    z-index:2;
    margin:25px 0;
    padding:25px 0;
    border-top:1px solid #E2E8F0;
    border-bottom:1px solid #E2E8F0
}
.format-area-title{
    color:#94A3B8;
    font-size:9px;
    font-weight:800;
    text-transform:uppercase
}
.format-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:15px;
    margin-top:14px
}
.detail-format-card{
    position:relative;
    display:flex;
    flex-direction:column;
    min-width:0;
    padding:20px;
    overflow:hidden;
    border-radius:14px
}
.detail-format-card.print{border:1px solid #FED7AA;background:#FFF7ED}
.detail-format-card.ebook{border:1px solid #C7D2FE;background:#EEF2FF}
.detail-format-label{
    display:inline-flex;
    align-items:center;
    gap:6px;
    width:max-content;
    max-width:100%;
    margin-bottom:14px;
    padding:5px 10px;
    border-radius:999px;
    font-size:10px;
    font-weight:800
}
.detail-format-label svg{
    width:14px;
    height:14px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8
}
.detail-format-card.print .detail-format-label{color:#C2410C;background:#FFEDD5}
.detail-format-card.ebook .detail-format-label{color:#4338CA;background:#E0E7FF}
.old-price{
    min-height:17px;
    color:#94A3B8;
    font-size:11px;
    text-decoration:line-through
}
.current-price{
    margin-top:3px;
    color:#241B52;
    font-size:24px;
    line-height:1.2;
    font-weight:800;
    overflow-wrap:anywhere
}
.discount-badge{
    display:inline-flex;
    width:max-content;
    margin-top:8px;
    padding:4px 8px;
    border-radius:6px;
    background:#FEE2E2;
    color:#DC2626;
    font-size:9px;
    font-weight:800
}
.add-format-button{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    width:100%;
    min-height:46px;
    margin-top:18px;
    padding:10px 14px;
    border:0;
    border-radius:9px;
    color:#fff;
    font-size:11px;
    font-weight:800;
    cursor:pointer
}
.add-format-button svg{
    width:16px;
    height:16px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8
}
.detail-format-card.print .add-format-button{background:linear-gradient(135deg,#EF5843,#F7AA35)}
.detail-format-card.ebook .add-format-button{background:linear-gradient(135deg,#4338CA,#6366F1)}
.add-format-button:disabled{opacity:.7;cursor:default}

.cart-feedback{
    display:none;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-top:16px;
    padding:13px 15px;
    border:1px solid #BBF7D0;
    border-radius:10px;
    background:#F0FDF4;
    color:#166534;
    font-size:11px;
    font-weight:700
}
.cart-feedback.show{display:flex}
.cart-feedback a{color:#15803D!important;font-weight:800;text-decoration:underline}

.description-section{position:relative;z-index:2;padding-top:3px}
.description-title{
    margin:0 0 13px;
    padding-bottom:10px;
    border-bottom:1px solid #E2E8F0;
    color:#0F172A;
    font-size:16px;
    font-weight:800
}
.description-text{
    color:#475569;
    font-size:14px;
    line-height:1.85;
    white-space:pre-line;
    overflow-wrap:anywhere
}

@keyframes detailBookIdle{
    0%,100%{transform:rotateY(-18deg) translateY(0)}
    50%{transform:rotateY(-14deg) translateY(-4px)}
}

/* TOUCH */
@media(hover:none),(pointer:coarse){
    .book3d-box{
        animation:none!important;
        transform:none!important
    }
    .detail-book-motion{transform:none!important}
    .cover-3d-wrapper{perspective:none}
}

/* TABLET */
@media(max-width:900px){
    .detail-layout{grid-template-columns:1fr}
    .detail-side{position:static}
    .cover-3d-wrapper{min-height:380px}
}

/* MOBILE */
@media(max-width:767px){
    .detail-page-wrap{
        width:100%;
        padding:35px 16px 48px
    }
    .detail-layout{gap:22px;margin-top:22px}
    .cover-3d-wrapper{
        min-height:340px;
        padding:30px 15px;
        border-radius:17px
    }
    .book3d-box,.detail-book-front{width:180px;height:245px}
    .detail-book-pages{width:24px;height:239px}
    .detail-book-spine{width:24px;height:239px}
    .detail-main-card{padding:23px 19px}
    .detail-title{font-size:29px}
    .format-grid{grid-template-columns:1fr}
    .detail-info-grid{grid-template-columns:1fr 1fr}
    .description-text{font-size:13px}
}

@media(max-width:480px){
    .detail-info-grid{grid-template-columns:1fr}
    .biblio-grid{grid-template-columns:1fr}
    .current-price{font-size:21px}
    .cart-feedback{align-items:flex-start;flex-direction:column}
}

@media(prefers-reduced-motion:reduce){
    .book3d-box{animation:none!important}
}
</style>

<div class="book-detail-page">
    <div class="detail-page-wrap">

        <div data-detail-intro>
            <a href="{{ route('portofolio.bookstore') }}" class="detail-back">
                <svg viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="detail-layout">
            <div class="detail-side">
                <div class="cover-3d-wrapper" data-detail-intro>
                    <div class="detail-book-motion">
                        <div class="book3d-box" id="detailBook3d">
                            <div class="detail-book-face detail-book-spine"></div>
                            <div class="detail-book-face detail-book-pages"></div>

                            <div class="detail-book-face detail-book-front">
                                @if($book->cover)
                                    <img
                                        src="{{ asset('storage/'.$book->cover) }}"
                                        alt="{{ $book->title }}"
                                        class="detail-book-cover"
                                        loading="eager"
                                        onerror="this.style.display='none';"
                                    >
                                @endif

                                <div class="detail-cover-fallback">
                                    <strong>{{ $book->title }}</strong>
                                    <span>{{ $book->author }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bibliography-card" data-detail-intro>
                    <h3 class="bibliography-title">Informasi Bibliografi</h3>

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

            <div>
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
                        <div class="format-area-title">Pilih Format Buku</div>

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
                            <span id="cartFeedbackText">Produk ditambahkan ke keranjang.</span>
                            <a href="{{ route('portofolio.bookstore') }}">Buka Bookstore</a>
                        </div>
                    </div>

                    <div class="description-section" data-detail-scroll>
                        <h2 class="description-title">Sinopsis & Deskripsi</h2>
                        <div class="description-text">
                            {{ $book->description ?? 'Belum ada deskripsi.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection