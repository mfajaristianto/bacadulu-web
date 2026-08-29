@php
    $bukuTerbaru = \App\Models\Book::query()
        ->latest()
        ->take(5)
        ->get();

    $jumlahBukuTerbaru = $bukuTerbaru->count();
@endphp

<section id="katalog" class="bd-editorial-books">
    <div class="bd-editorial-grid-bg" aria-hidden="true"></div>
    <div class="bd-orange-accent bd-orange-accent-left" aria-hidden="true"></div>
    <div class="bd-orange-accent bd-orange-accent-right" aria-hidden="true"></div>

    <div class="bd-editorial-container">
        <header class="bd-editorial-header">
            <div class="bd-editorial-heading">
                <div class="bd-editorial-kicker">
                    <span class="bd-editorial-kicker-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                            />
                        </svg>
                    </span>
                    <span>Baca Dulu Bookstore</span>
                </div>

                <h2>Terbitan Terbaru</h2>

                <p>
                    Temukan buku terbaru pilihan Baca Dulu dalam format cetak maupun digital
                    untuk menemani perjalanan membaca Anda.
                </p>
            </div>

            <div class="bd-editorial-header-right">
                @if(!$bukuTerbaru->isEmpty())
                    <div class="bd-editorial-counter">
                        <span class="bd-current-number" id="bdEditorialCurrent">01</span>
                        <span class="bd-counter-divider">/</span>
                        <span>{{ str_pad($jumlahBukuTerbaru, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                @endif

                <a href="{{ route('portofolio.bookstore') }}" class="bd-editorial-all">
                    <span>Seluruh Koleksi</span>

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14M13 6l6 6-6 6"
                        />
                    </svg>
                </a>
            </div>
        </header>

        @if($bukuTerbaru->isEmpty())
            <div class="bd-editorial-empty">
                <span>Katalog</span>
                <h3>Belum ada terbitan terbaru.</h3>
                <p>Koleksi terbaru akan ditampilkan di bagian ini.</p>
            </div>
        @else
            <div class="bd-editorial-layout" id="bdEditorialLayout">

                {{-- FEATURED BOOK --}}
                <div class="bd-feature-stage" id="bdFeatureStage">
                    @foreach($bukuTerbaru as $index => $b)
                        @php
                            $cover = $b->cover
                                ? asset('storage/' . $b->cover)
                                : null;

                            $bookNumber = str_pad(
                                $index + 1,
                                2,
                                '0',
                                STR_PAD_LEFT
                            );

                            $category = $b->category ?? 'Buku';
                        @endphp

                        <article
                            class="bd-feature-panel {{ $index === 0 ? 'is-active' : '' }}"
                            data-feature-panel="{{ $index }}"
                            style="{{ $index === 0 ? '' : 'display:none;' }}"
                        >
                            <div class="bd-feature-cover-wrap">
                                <div class="bd-feature-cover-frame">
                                    <div class="bd-feature-cover-number">
                                        {{ $bookNumber }}
                                    </div>

                                    <a
                                        href="{{ route('portofolio.bookstore.show', ['book' => $b->slug]) }}"
                                        class="bd-feature-cover-link"
                                        aria-label="Lihat detail {{ $b->title }}"
                                    >
                                        @if($cover)
                                            <img
                                                src="{{ $cover }}"
                                                alt="{{ $b->title }}"
                                                class="bd-feature-cover"
                                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                            >

                                            <div class="bd-feature-placeholder bd-cover-error-fallback">
                                                <span class="bd-placeholder-brand">Baca Dulu</span>

                                                <div>
                                                    <strong>
                                                        {{ \Illuminate\Support\Str::limit($b->title, 60) }}
                                                    </strong>

                                                    <small>
                                                        {{ $b->author }}
                                                    </small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bd-feature-placeholder">
                                                <span class="bd-placeholder-brand">Baca Dulu</span>

                                                <div>
                                                    <strong>
                                                        {{ \Illuminate\Support\Str::limit($b->title, 60) }}
                                                    </strong>

                                                    <small>
                                                        {{ $b->author }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                <div class="bd-feature-cover-caption">
                                    <span class="bd-caption-line"></span>
                                    <span>Terbitan {{ $bookNumber }}</span>
                                </div>
                            </div>

                            <div class="bd-feature-copy">
                                <div class="bd-feature-category">
                                    {{ $category }}
                                </div>

                                <h3>
                                    {{ $b->title }}
                                </h3>

                                <p class="bd-feature-author">
                                    <span>Oleh</span>
                                    {{ $b->author }}
                                </p>

                                <div class="bd-feature-divider"></div>

                                <div class="bd-feature-format-label">
                                    Pilihan Format
                                </div>

                                <div class="bd-feature-pricing">

                                    {{-- BUKU CETAK --}}
                                    <div class="bd-price-item">
                                        <div class="bd-price-type">
                                            <span class="bd-price-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                                                    />
                                                </svg>
                                            </span>

                                            <div>
                                                <span>Buku Cetak</span>
                                                <small>Physical Edition</small>
                                            </div>
                                        </div>

                                        <div class="bd-price-value">
                                            @if($b->has_print && $b->print_price !== null)
                                                @if($b->has_active_print_discount)
                                                    <div class="bd-old-price">
                                                        IDR {{ number_format((float)$b->print_price, 2, ',', '.') }}
                                                    </div>
                                                @endif

                                                <div class="bd-current-price-row">
                                                    <strong>
                                                        IDR {{ number_format((float)$b->effective_print_price, 2, ',', '.') }}
                                                    </strong>

                                                    @if($b->has_active_print_discount)
                                                        <span class="bd-price-discount">
                                                            -{{ number_format((float)$b->print_discount_percent, 0) }}%
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="bd-not-available">
                                                    Tidak tersedia
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- EBOOK --}}
                                    <div class="bd-price-item">
                                        <div class="bd-price-type">
                                            <span class="bd-price-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                                    <rect x="5" y="3" width="14" height="18" rx="2"/>
                                                    <path stroke-linecap="round" d="M9 7h6M9 11h6"/>
                                                </svg>
                                            </span>

                                            <div>
                                                <span>E-book</span>
                                                <small>Digital Edition</small>
                                            </div>
                                        </div>

                                        <div class="bd-price-value">
                                            @if($b->has_ebook && $b->ebook_price !== null)
                                                @if($b->has_active_ebook_discount)
                                                    <div class="bd-old-price">
                                                        IDR {{ number_format((float)$b->ebook_price, 2, ',', '.') }}
                                                    </div>
                                                @endif

                                                <div class="bd-current-price-row">
                                                    <strong>
                                                        IDR {{ number_format((float)$b->effective_ebook_price, 2, ',', '.') }}
                                                    </strong>

                                                    @if($b->has_active_ebook_discount)
                                                        <span class="bd-price-discount">
                                                            -{{ number_format((float)$b->ebook_discount_percent, 0) }}%
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="bd-not-available">
                                                    Tidak tersedia
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="bd-feature-action-row">
                                    <a
                                        href="{{ route('portofolio.bookstore.show', ['book' => $b->slug]) }}"
                                        class="bd-feature-detail"
                                    >
                                        <span>Lihat Detail Buku</span>

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 12h14M13 6l6 6-6 6"
                                            />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- INDEX BUKU --}}
                <aside class="bd-book-index">
                    <div class="bd-index-header">
                        <span>Terbitan</span>
                        <strong>{{ $jumlahBukuTerbaru }} Buku</strong>
                    </div>

                    <div class="bd-index-list" id="bdEditorialIndexList">
                        @foreach($bukuTerbaru as $index => $b)
                            @php
                                $cover = $b->cover
                                    ? asset('storage/' . $b->cover)
                                    : null;

                                $bookNumber = str_pad(
                                    $index + 1,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                );
                            @endphp

                            <button
                                type="button"
                                class="bd-index-item {{ $index === 0 ? 'is-active' : '' }}"
                                data-book-index="{{ $index }}"
                                aria-label="Tampilkan {{ $b->title }}"
                            >
                                <span class="bd-index-number">
                                    {{ $bookNumber }}
                                </span>

                                <div class="bd-index-thumb">
                                    @if($cover)
                                        <img
                                            src="{{ $cover }}"
                                            alt=""
                                            loading="lazy"
                                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                        >

                                        <div class="bd-index-thumb-fallback bd-index-error-fallback">
                                            BD
                                        </div>
                                    @else
                                        <div class="bd-index-thumb-fallback">
                                            BD
                                        </div>
                                    @endif
                                </div>

                                <div class="bd-index-copy">
                                    <strong>
                                        {{ \Illuminate\Support\Str::limit($b->title, 46) }}
                                    </strong>

                                    <span>
                                        {{ $b->author }}
                                    </span>
                                </div>

                                <span class="bd-index-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </span>
                            </button>
                        @endforeach
                    </div>

                    {{-- CONTROL --}}
                    <div class="bd-index-footer">
                        <div class="bd-index-mobile-label">
                            <strong id="bdEditorialMobileCurrent">01</strong>
                            <span>
                                / {{ str_pad($jumlahBukuTerbaru, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div class="bd-index-nav">
                            <button
                                type="button"
                                id="bdEditorialPrev"
                                aria-label="Buku sebelumnya"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 18l-6-6 6-6"
                                    />
                                </svg>
                            </button>

                            <button
                                type="button"
                                id="bdEditorialNext"
                                class="bd-index-nav-primary"
                                aria-label="Buku berikutnya"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 18l6-6-6-6"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </div>
</section>

<style>
.bd-editorial-books{
    --bd-navy:#241B52;
    --bd-orange:#EF5843;
    --bd-orange-dark:#C84735;
    --bd-text:#27272D;
    --bd-muted:#737580;
    position:relative;
    width:100%;
    max-width:100%;
    overflow:hidden;
    padding:94px 0 96px;
    background:#fff;
    color:var(--bd-text);
}

.bd-editorial-books *{
    box-sizing:border-box;
}

.bd-editorial-grid-bg{
    position:absolute;
    inset:0;
    z-index:0;
    pointer-events:none;
    opacity:.7;
    background-image:
        linear-gradient(rgba(36,27,82,.04) 1px,transparent 1px),
        linear-gradient(90deg,rgba(36,27,82,.04) 1px,transparent 1px);
    background-size:38px 38px;
}

.bd-orange-accent{
    position:absolute;
    z-index:0;
    border-radius:50%;
    pointer-events:none;
    filter:blur(8px);
}

.bd-orange-accent-left{
    width:470px;
    height:470px;
    top:-250px;
    left:-190px;
    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.13),
            rgba(239,88,67,.04) 50%,
            transparent 72%
        );
}

.bd-orange-accent-right{
    width:520px;
    height:520px;
    right:-230px;
    bottom:-270px;
    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.11),
            rgba(247,170,53,.04) 45%,
            transparent 72%
        );
}

.bd-editorial-container{
    position:relative;
    z-index:2;
    width:min(calc(100% - 48px),1320px);
    margin:0 auto;
}

.bd-editorial-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:48px;
    margin-bottom:38px;
    padding-bottom:26px;
    border-bottom:1px solid rgba(239,88,67,.15);
}

.bd-editorial-heading{
    max-width:700px;
}

.bd-editorial-kicker{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:13px;
    color:var(--bd-orange);
    font-size:9px;
    font-weight:850;
    letter-spacing:.16em;
    text-transform:uppercase;
}

.bd-editorial-kicker-icon{
    width:28px;
    height:28px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:rgba(239,88,67,.085);
}

.bd-editorial-kicker-icon svg{
    width:13px;
    height:13px;
}

.bd-editorial-heading h2{
    margin:0;
    color:var(--bd-navy);
    font-size:clamp(35px,4vw,51px);
    line-height:1.05;
    font-weight:800;
    letter-spacing:-.045em;
}

.bd-editorial-heading p{
    max-width:600px;
    margin:15px 0 0;
    color:var(--bd-muted);
    font-size:13px;
    line-height:1.75;
}

.bd-editorial-header-right{
    display:flex;
    align-items:center;
    gap:24px;
    flex-shrink:0;
}

.bd-editorial-counter{
    display:flex;
    align-items:baseline;
    gap:5px;
    color:#A5A3AA;
    font-size:9px;
    font-weight:800;
}

.bd-current-number{
    color:var(--bd-orange);
    font-size:17px;
}

.bd-counter-divider{
    color:#D1CFD2;
}

.bd-editorial-all{
    display:inline-flex;
    align-items:center;
    gap:9px;
    padding-bottom:5px;
    border-bottom:1px solid rgba(239,88,67,.34);
    color:var(--bd-orange-dark)!important;
    font-size:10px;
    font-weight:800;
    text-decoration:none;
}

.bd-editorial-all svg{
    width:14px;
    height:14px;
    transition:transform .22s ease;
}

.bd-editorial-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 335px;
    gap:24px;
    align-items:stretch;
}

.bd-feature-stage{
    position:relative;
    min-width:0;
    padding:44px;
    overflow:hidden;
    border:1px solid rgba(239,88,67,.13);
    border-radius:32px;
    background:rgba(255,255,255,.94);
    box-shadow:0 18px 45px rgba(36,27,82,.055);
}

.bd-feature-stage::before{
    content:"";
    position:absolute;
    width:240px;
    height:240px;
    left:-100px;
    bottom:-115px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.08),transparent 68%);
    pointer-events:none;
}

.bd-feature-panel{
    position:relative;
    z-index:2;
    display:grid;
    grid-template-columns:300px minmax(0,1fr);
    gap:58px;
    align-items:center;
    min-height:500px;
}

.bd-feature-cover-wrap{
    min-width:0;
}

.bd-feature-cover-frame{
    position:relative;
    width:274px;
    margin:0 auto;
    padding:18px;
    border:1px solid rgba(239,88,67,.12);
    border-radius:27px;
    background:#fff;
    box-shadow:0 14px 36px rgba(36,27,82,.07);
}

.bd-feature-cover-number{
    position:absolute;
    top:12px;
    left:12px;
    z-index:8;
    min-width:44px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 10px;
    border:1px solid rgba(239,88,67,.17);
    border-radius:11px;
    background:rgba(255,255,255,.96);
    color:var(--bd-orange);
    font-size:10px;
    font-weight:900;
    letter-spacing:.08em;
    box-shadow:0 6px 15px rgba(36,27,82,.07);
}

.bd-feature-cover-link{
    position:relative;
    display:block;
    width:238px;
    height:335px;
    margin:0 auto;
}

.bd-feature-cover{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:17px;
    box-shadow:8px 13px 27px rgba(31,27,55,.15);
}

.bd-cover-error-fallback{
    display:none;
}

.bd-feature-placeholder{
    width:100%;
    height:100%;
    flex-direction:column;
    justify-content:space-between;
    padding:24px;
    border-radius:17px;
    background:linear-gradient(145deg,#EF5843,#E97440);
    color:#fff;
    box-shadow:8px 13px 27px rgba(31,27,55,.15);
}

.bd-feature-cover-link>.bd-feature-placeholder:not(.bd-cover-error-fallback){
    display:flex;
}

.bd-placeholder-brand{
    font-size:7px;
    font-weight:850;
    letter-spacing:.18em;
    text-transform:uppercase;
    opacity:.76;
}

.bd-feature-placeholder strong{
    display:block;
    font-size:18px;
    line-height:1.3;
    font-weight:800;
}

.bd-feature-placeholder small{
    display:block;
    margin-top:9px;
    font-size:9px;
    opacity:.78;
}

.bd-feature-cover-caption{
    width:238px;
    display:flex;
    align-items:center;
    gap:8px;
    margin:14px auto 0;
    color:#94919A;
    font-size:7.5px;
    font-weight:800;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-caption-line{
    width:20px;
    height:1.5px;
    background:var(--bd-orange);
}

.bd-feature-copy{
    min-width:0;
}

.bd-feature-category{
    display:inline-flex;
    align-items:center;
    min-height:31px;
    padding:0 12px;
    border:1px solid rgba(239,88,67,.12);
    border-radius:9px;
    background:rgba(239,88,67,.065);
    color:var(--bd-orange);
    font-size:8px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-feature-copy h3{
    max-width:590px;
    margin:15px 0 0;
    color:var(--bd-navy);
    font-size:clamp(28px,3vw,42px);
    line-height:1.12;
    font-weight:800;
    letter-spacing:-.04em;
    overflow-wrap:anywhere;
}

.bd-feature-author{
    margin:14px 0 0;
    color:#666873;
    font-size:12px;
    font-weight:650;
}

.bd-feature-author span{
    margin-right:5px;
    color:#AAAAAF;
    font-weight:500;
}

.bd-feature-divider{
    width:100%;
    height:1px;
    margin:28px 0 23px;
    background:rgba(36,27,82,.09);
}

.bd-feature-format-label{
    margin-bottom:10px;
    color:#9A98A0;
    font-size:8px;
    font-weight:800;
    letter-spacing:.14em;
    text-transform:uppercase;
}

.bd-feature-pricing{
    border-top:1px solid rgba(36,27,82,.09);
}

.bd-price-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    min-height:78px;
    padding:14px 0;
    border-bottom:1px solid rgba(36,27,82,.09);
}

.bd-price-type{
    display:flex;
    align-items:center;
    gap:11px;
    min-width:0;
}

.bd-price-icon{
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
    border-radius:10px;
    background:rgba(239,88,67,.07);
    color:var(--bd-orange);
}

.bd-price-icon svg{
    width:16px;
    height:16px;
}

.bd-price-type>div>span{
    display:block;
    color:var(--bd-navy);
    font-size:11px;
    font-weight:800;
}

.bd-price-type small{
    display:block;
    margin-top:3px;
    color:#A2A0A7;
    font-size:7.5px;
}

.bd-price-value{
    min-width:150px;
    text-align:right;
}

.bd-old-price{
    margin-bottom:3px;
    color:#AAA8AD;
    font-size:8px;
    text-decoration:line-through;
}

.bd-current-price-row{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:7px;
}

.bd-price-value strong{
    color:var(--bd-navy);
    font-size:13px;
    font-weight:850;
}

.bd-price-discount{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:22px;
    padding:0 7px;
    border-radius:7px;
    background:rgba(239,88,67,.08);
    color:var(--bd-orange);
    font-size:7px;
    font-weight:850;
}

.bd-not-available{
    color:#A8A6AC;
    font-size:9px;
    font-weight:650;
}

.bd-feature-action-row{
    margin-top:25px;
}

.bd-feature-detail{
    display:inline-flex;
    align-items:center;
    gap:10px;
    min-height:44px;
    padding:0 17px;
    border:1px solid var(--bd-navy);
    border-radius:11px;
    background:var(--bd-navy);
    color:#fff!important;
    font-size:9px;
    font-weight:800;
    text-decoration:none;
    transition:.2s ease;
}

.bd-feature-detail svg{
    width:14px;
    height:14px;
}

/* INDEX */
.bd-book-index{
    display:flex;
    flex-direction:column;
    min-width:0;
    overflow:hidden;
    border:1px solid rgba(239,88,67,.12);
    border-radius:27px;
    background:rgba(255,255,255,.94);
    box-shadow:0 15px 40px rgba(36,27,82,.045);
}

.bd-index-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    padding:19px 20px;
    border-bottom:1px solid rgba(36,27,82,.08);
}

.bd-index-header span{
    color:#9B99A0;
    font-size:7.5px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-index-header strong{
    color:var(--bd-navy);
    font-size:9px;
    font-weight:850;
}

.bd-index-list{
    flex:1;
    min-width:0;
    max-width:100%;
}

.bd-index-item{
    position:relative;
    width:100%;
    min-height:98px;
    display:grid;
    grid-template-columns:26px 52px minmax(0,1fr) 18px;
    align-items:center;
    gap:11px;
    padding:14px 16px;
    border:0;
    border-bottom:1px solid rgba(36,27,82,.07);
    background:transparent;
    text-align:left;
    cursor:pointer;
}

.bd-index-item.is-active{
    background:rgba(239,88,67,.055);
}

.bd-index-item.is-active::before{
    content:"";
    position:absolute;
    top:13px;
    bottom:13px;
    left:0;
    width:3px;
    border-radius:0 999px 999px 0;
    background:var(--bd-orange);
}

.bd-index-number{
    color:#AAA8AE;
    font-size:8px;
    font-weight:900;
}

.bd-index-item.is-active .bd-index-number{
    color:var(--bd-orange);
}

.bd-index-thumb{
    width:47px;
    height:64px;
    overflow:hidden;
    border-radius:10px;
    background:#F2F1EE;
}

.bd-index-thumb img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
}

.bd-index-thumb-fallback{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:var(--bd-orange);
    color:#fff;
    font-size:8px;
    font-weight:900;
}

.bd-index-error-fallback{
    display:none;
}

.bd-index-copy{
    min-width:0;
}

.bd-index-copy strong{
    display:-webkit-box;
    overflow:hidden;
    color:var(--bd-navy);
    font-size:10px;
    line-height:1.42;
    font-weight:750;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}

.bd-index-copy span{
    display:block;
    margin-top:4px;
    overflow:hidden;
    color:#8D8C93;
    font-size:8px;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.bd-index-arrow{
    display:flex;
    align-items:center;
    justify-content:center;
    color:#AAA8AE;
}

.bd-index-arrow svg{
    width:13px;
    height:13px;
}

.bd-index-item.is-active .bd-index-arrow{
    color:var(--bd-orange);
}

.bd-index-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:15px 16px 17px;
    border-top:1px solid rgba(36,27,82,.08);
}

.bd-index-mobile-label{
    display:none;
    align-items:baseline;
    gap:4px;
    color:#A19FA6;
    font-size:8px;
    font-weight:800;
}

.bd-index-mobile-label strong{
    color:var(--bd-orange);
    font-size:16px;
}

.bd-index-nav{
    display:flex;
    gap:7px;
    margin-left:auto;
}

.bd-index-nav button{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border:1px solid rgba(36,27,82,.12);
    border-radius:11px;
    background:#fff;
    color:var(--bd-navy);
    cursor:pointer;
}

.bd-index-nav .bd-index-nav-primary{
    border-color:var(--bd-navy);
    background:var(--bd-navy);
    color:#fff;
}

.bd-index-nav svg{
    width:14px;
    height:14px;
}

.bd-editorial-empty{
    padding:65px 30px;
    border:1px solid rgba(239,88,67,.12);
    border-radius:28px;
    background:#fff;
    text-align:center;
}

.bd-editorial-empty>span{
    color:var(--bd-orange);
    font-size:8px;
    font-weight:850;
    letter-spacing:.16em;
    text-transform:uppercase;
}

.bd-editorial-empty h3{
    margin:9px 0 0;
    color:var(--bd-navy);
    font-size:20px;
}

.bd-editorial-empty p{
    margin:7px 0 0;
    color:var(--bd-muted);
    font-size:11px;
}

/* DESKTOP HOVER */
@media(hover:hover) and (pointer:fine){
    .bd-editorial-all:hover svg{
        transform:translateX(3px);
    }

    .bd-feature-detail:hover{
        border-color:var(--bd-orange);
        background:var(--bd-orange);
    }
}

/* LAPTOP */
@media(max-width:1150px){
    .bd-editorial-layout{
        grid-template-columns:minmax(0,1fr) 290px;
    }

    .bd-feature-stage{
        padding:35px;
    }

    .bd-feature-panel{
        grid-template-columns:240px minmax(0,1fr);
        gap:42px;
    }

    .bd-feature-cover-frame{
        width:220px;
    }

    .bd-feature-cover-link{
        width:184px;
        height:270px;
    }

    .bd-feature-cover-caption{
        width:184px;
    }
}

/* TABLET + TOUCH */
@media(max-width:920px),(hover:none),(pointer:coarse){
    .bd-editorial-layout{
        grid-template-columns:1fr;
    }

    .bd-index-list{
        display:flex;
        width:100%;
        max-width:100%;
        min-width:0;
        overflow-x:auto;
        overflow-y:hidden;
        scroll-snap-type:x mandatory;
        overscroll-behavior-x:contain;
        -webkit-overflow-scrolling:touch;
        scrollbar-width:none;
    }

    .bd-index-list::-webkit-scrollbar{
        display:none;
    }

    .bd-index-item{
        flex:0 0 270px;
        width:270px;
        max-width:270px;
        scroll-snap-align:start;
        border-right:1px solid rgba(36,27,82,.07);
        border-bottom:0;
    }

    .bd-index-item.is-active::before{
        top:auto;
        left:14px;
        right:14px;
        bottom:0;
        width:auto;
        height:3px;
        border-radius:999px 999px 0 0;
    }

    .bd-index-footer{
        display:flex!important;
    }

    .bd-index-mobile-label{
        display:flex;
    }

    .bd-feature-stage{
        touch-action:pan-y;
    }
}

/* MOBILE */
@media(max-width:700px){
    .bd-editorial-books{
        padding:62px 0;
    }

    .bd-editorial-container{
        width:100%;
        padding:0 15px;
    }

    .bd-editorial-header{
        align-items:flex-start;
        flex-direction:column;
        gap:20px;
        margin-bottom:26px;
        padding-bottom:22px;
    }

    .bd-editorial-heading h2{
        font-size:35px;
    }

    .bd-editorial-heading p{
        font-size:11px;
        line-height:1.7;
    }

    .bd-editorial-header-right{
        width:100%;
        justify-content:space-between;
    }

    .bd-feature-stage{
        padding:22px 17px 25px;
        border-radius:24px;
    }

    .bd-feature-panel{
        grid-template-columns:1fr;
        gap:28px;
        min-height:0;
    }

    .bd-feature-cover-frame{
        width:min(68vw,250px);
        padding:13px;
        border-radius:22px;
    }

    .bd-feature-cover-link{
        width:100%;
        height:auto;
        aspect-ratio:2/2.82;
    }

    .bd-feature-cover-caption{
        width:min(65vw,220px);
    }

    .bd-feature-copy h3{
        font-size:28px;
        line-height:1.15;
    }

    .bd-feature-divider{
        margin:22px 0 18px;
    }

    .bd-price-item{
        min-height:70px;
    }

    .bd-feature-detail{
        width:100%;
        justify-content:space-between;
        min-height:48px;
    }

    .bd-book-index{
        border-radius:22px;
    }

    .bd-index-item{
        flex-basis:min(78vw,260px);
        width:min(78vw,260px);
        max-width:min(78vw,260px);
    }

    .bd-index-nav button{
        width:46px;
        height:46px;
    }
}

/* SMALL MOBILE */
@media(max-width:440px){
    .bd-editorial-header-right{
        align-items:flex-start;
        flex-direction:column;
        gap:12px;
    }

    .bd-feature-copy h3{
        font-size:25px;
    }

    .bd-price-item{
        align-items:flex-start;
        flex-direction:column;
        gap:10px;
    }

    .bd-price-value{
        min-width:0;
        text-align:left;
    }

    .bd-current-price-row{
        justify-content:flex-start;
    }

    .bd-index-item{
        flex-basis:235px;
        width:235px;
        max-width:235px;
    }
}

@media(prefers-reduced-motion:reduce){
    .bd-editorial-books *{
        scroll-behavior:auto!important;
        transition:none!important;
    }
}
</style>

<script>
(function(){
    function initEditorialBooks(){
        const section=document.getElementById('katalog');

        if(!section||section.dataset.editorialReady==='1'){
            return;
        }

        section.dataset.editorialReady='1';

        const panels=[
            ...section.querySelectorAll('[data-feature-panel]')
        ];

        const indexButtons=[
            ...section.querySelectorAll('[data-book-index]')
        ];

        const prev=section.querySelector('#bdEditorialPrev');
        const next=section.querySelector('#bdEditorialNext');
        const current=section.querySelector('#bdEditorialCurrent');
        const mobileCurrent=section.querySelector('#bdEditorialMobileCurrent');
        const stage=section.querySelector('#bdFeatureStage');
        const indexList=section.querySelector('#bdEditorialIndexList');

        if(!panels.length){
            return;
        }

        const gsap=window.bdGsap||null;

        const reduceMotion=
            window.matchMedia('(prefers-reduced-motion:reduce)').matches;

        function getDevice(){
            return window.BacaDevice||{
                type:
                    window.innerWidth<=767
                        ? 'phone'
                        : (
                            window.innerWidth<=1023
                                ? 'tablet'
                                : 'desktop'
                        ),
                touch:
                    window.matchMedia('(pointer:coarse)').matches
                    ||
                    window.matchMedia('(hover:none)').matches
                    ||
                    navigator.maxTouchPoints>0,
                finePointer:
                    window.matchMedia('(hover:hover) and (pointer:fine)').matches
            };
        }

        function isTouchLike(){
            const device=getDevice();

            return (
                device.touch===true
                ||
                device.type!=='desktop'
            );
        }

        function isFinePointer(){
            const device=getDevice();

            return (
                device.type==='desktop'
                &&
                device.finePointer===true
            );
        }

        let activeIndex=0;
        let busy=false;
        let startX=0;
        let startY=0;
        let resizeTimer=null;

        function centerActiveIndex(){
            if(!indexList){
                return;
            }

            const button=
                indexButtons[activeIndex];

            if(!button){
                return;
            }

            const listRect=
                indexList.getBoundingClientRect();

            const buttonRect=
                button.getBoundingClientRect();

            let target=
                indexList.scrollLeft
                +
                (
                    buttonRect.left
                    -
                    listRect.left
                )
                -
                (
                    indexList.clientWidth
                    -
                    buttonRect.width
                )
                /
                2;

            const maxScroll=
                Math.max(
                    0,
                    indexList.scrollWidth
                    -
                    indexList.clientWidth
                );

            target=
                Math.max(
                    0,
                    Math.min(
                        target,
                        maxScroll
                    )
                );

            indexList.scrollTo({
                left:target,
                top:0,
                behavior:
                    reduceMotion
                        ? 'auto'
                        : 'smooth'
            });
        }

        function updateUi(){
            indexButtons.forEach(
                (button,index)=>{
                    button.classList.toggle(
                        'is-active',
                        index===activeIndex
                    );
                }
            );

            const number=
                String(
                    activeIndex+1
                ).padStart(
                    2,
                    '0'
                );

            if(current){
                current.textContent=number;
            }

            if(mobileCurrent){
                mobileCurrent.textContent=number;
            }

            if(
                isTouchLike()
                ||
                window.innerWidth<=920
            ){
                centerActiveIndex();
            }
        }

        function clearPanelMotion(panel){
            if(!gsap||!panel){
                return;
            }

            gsap.set(
                panel,
                {
                    clearProps:
                        'opacity,visibility,x,y,scale,transform'
                }
            );
        }

        function simpleSwitch(index){
            panels.forEach(
                (panel,panelIndex)=>{
                    const active=
                        panelIndex===index;

                    panel.style.display=
                        active
                            ? 'grid'
                            : 'none';

                    panel.classList.toggle(
                        'is-active',
                        active
                    );

                    clearPanelMotion(panel);
                }
            );

            activeIndex=index;
            updateUi();
        }

        function switchBook(
            index,
            direction=1
        ){
            if(
                !panels[index]
                ||
                index===activeIndex
                ||
                busy
            ){
                return;
            }

            const oldPanel=
                panels[activeIndex];

            const newPanel=
                panels[index];

            if(
                !gsap
                ||
                reduceMotion
                ||
                isTouchLike()
            ){
                oldPanel.style.display='none';
                oldPanel.classList.remove('is-active');

                newPanel.style.display='grid';
                newPanel.classList.add('is-active');

                activeIndex=index;
                updateUi();

                if(
                    gsap
                    &&
                    !reduceMotion
                ){
                    gsap.fromTo(
                        newPanel,
                        {
                            opacity:0,
                            x:
                                direction>0
                                    ? 20
                                    : -20,
                            scale:.99
                        },
                        {
                            opacity:1,
                            x:0,
                            scale:1,
                            duration:.38,
                            ease:'power3.out',
                            clearProps:'transform,opacity'
                        }
                    );
                }

                return;
            }

            busy=true;

            const oldCover=
                oldPanel.querySelector(
                    '.bd-feature-cover-wrap'
                );

            const oldCopy=
                oldPanel.querySelector(
                    '.bd-feature-copy'
                );

            const newCover=
                newPanel.querySelector(
                    '.bd-feature-cover-wrap'
                );

            const newCopy=
                newPanel.querySelector(
                    '.bd-feature-copy'
                );

            const oldElements=
                [
                    oldCover,
                    oldCopy
                ].filter(Boolean);

            const newElements=
                [
                    newCover,
                    newCopy
                ].filter(Boolean);

            const timeline=
                gsap.timeline({
                    onComplete(){
                        activeIndex=index;
                        updateUi();
                        busy=false;
                    }
                });

            if(oldElements.length){
                timeline.to(
                    oldElements,
                    {
                        autoAlpha:0,
                        x:
                            direction>0
                                ? -16
                                : 16,
                        duration:.2,
                        ease:'power2.in',
                        stagger:.025
                    }
                );
            }

            timeline.set(
                oldPanel,
                {
                    display:'none'
                }
            );

            timeline.set(
                newPanel,
                {
                    display:'grid'
                }
            );

            if(newCover){
                timeline.fromTo(
                    newCover,
                    {
                        autoAlpha:0,
                        x:
                            direction>0
                                ? 18
                                : -18
                    },
                    {
                        autoAlpha:1,
                        x:0,
                        duration:.35,
                        ease:'power3.out'
                    }
                );
            }

            if(newCopy){
                timeline.fromTo(
                    newCopy,
                    {
                        autoAlpha:0,
                        y:10
                    },
                    {
                        autoAlpha:1,
                        y:0,
                        duration:.35,
                        ease:'power3.out'
                    },
                    '-=.25'
                );
            }

            if(newElements.length){
                timeline.set(
                    newElements,
                    {
                        clearProps:
                            'transform,opacity,visibility'
                    }
                );
            }
        }

        function goPrevious(){
            let index=
                activeIndex-1;

            if(index<0){
                index=
                    panels.length-1;
            }

            switchBook(
                index,
                -1
            );
        }

        function goNext(){
            let index=
                activeIndex+1;

            if(
                index>=
                panels.length
            ){
                index=0;
            }

            switchBook(
                index,
                1
            );
        }

        indexButtons.forEach(
            (button,index)=>{
                button.addEventListener(
                    'click',
                    ()=>{
                        if(index===activeIndex){
                            return;
                        }

                        switchBook(
                            index,
                            index>activeIndex
                                ? 1
                                : -1
                        );
                    }
                );
            }
        );

        prev?.addEventListener(
            'click',
            event=>{
                event.preventDefault();
                event.stopPropagation();
                goPrevious();
            }
        );

        next?.addEventListener(
            'click',
            event=>{
                event.preventDefault();
                event.stopPropagation();
                goNext();
            }
        );

        /* SWIPE FEATURE BOOK */
        stage?.addEventListener(
            'touchstart',
            event=>{
                if(!isTouchLike()){
                    return;
                }

                const touch=
                    event.touches[0];

                startX=
                    touch.clientX;

                startY=
                    touch.clientY;
            },
            {
                passive:true
            }
        );

        stage?.addEventListener(
            'touchend',
            event=>{
                if(!isTouchLike()){
                    return;
                }

                const touch=
                    event.changedTouches[0];

                const dx=
                    touch.clientX
                    -
                    startX;

                const dy=
                    touch.clientY
                    -
                    startY;

                if(
                    Math.abs(dx)<45
                    ||
                    Math.abs(dx)<Math.abs(dy)
                ){
                    return;
                }

                if(dx<0){
                    goNext();
                }
                else{
                    goPrevious();
                }
            },
            {
                passive:true
            }
        );

        /* COVER HOVER DESKTOP */
        if(
            gsap
            &&
            !reduceMotion
            &&
            isFinePointer()
        ){
            panels.forEach(
                panel=>{
                    const link=
                        panel.querySelector(
                            '.bd-feature-cover-link'
                        );

                    const cover=
                        panel.querySelector(
                            '.bd-feature-cover'
                        );

                    if(
                        !link
                        ||
                        !cover
                    ){
                        return;
                    }

                    link.addEventListener(
                        'mouseenter',
                        ()=>{
                            gsap.to(
                                cover,
                                {
                                    y:-4,
                                    scale:1.01,
                                    duration:.32,
                                    ease:'power2.out',
                                    overwrite:true
                                }
                            );
                        }
                    );

                    link.addEventListener(
                        'mouseleave',
                        ()=>{
                            gsap.to(
                                cover,
                                {
                                    y:0,
                                    scale:1,
                                    duration:.4,
                                    ease:'power3.out',
                                    overwrite:true
                                }
                            );
                        }
                    );
                }
            );

            indexButtons.forEach(
                button=>{
                    const copy=
                        button.querySelector(
                            '.bd-index-copy'
                        );

                    if(!copy){
                        return;
                    }

                    button.addEventListener(
                        'mouseenter',
                        ()=>{
                            if(
                                button.classList.contains(
                                    'is-active'
                                )
                            ){
                                return;
                            }

                            gsap.to(
                                copy,
                                {
                                    x:3,
                                    duration:.18,
                                    ease:'power2.out',
                                    overwrite:true
                                }
                            );
                        }
                    );

                    button.addEventListener(
                        'mouseleave',
                        ()=>{
                            gsap.to(
                                copy,
                                {
                                    x:0,
                                    duration:.26,
                                    ease:'power3.out',
                                    overwrite:true
                                }
                            );
                        }
                    );
                }
            );
        }

        /* BUTTON PRESS */
        if(
            gsap
            &&
            !reduceMotion
        ){
            [
                prev,
                next
            ]
            .filter(Boolean)
            .forEach(
                button=>{
                    button.addEventListener(
                        'pointerdown',
                        ()=>{
                            gsap.to(
                                button,
                                {
                                    scale:.92,
                                    duration:.07
                                }
                            );
                        }
                    );

                    const reset=()=>{
                        gsap.to(
                            button,
                            {
                                scale:1,
                                duration:.18,
                                ease:'power2.out'
                            }
                        );
                    };

                    button.addEventListener(
                        'pointerup',
                        reset
                    );

                    button.addEventListener(
                        'pointercancel',
                        reset
                    );

                    button.addEventListener(
                        'pointerleave',
                        reset
                    );
                }
            );
        }

        window.addEventListener(
            'resize',
            ()=>{
                clearTimeout(
                    resizeTimer
                );

                resizeTimer=
                    setTimeout(
                        ()=>{
                            updateUi();
                        },
                        140
                    );
            },
            {
                passive:true
            }
        );

        window.addEventListener(
            'baca:devicechange',
            ()=>{
                simpleSwitch(
                    activeIndex
                );
            }
        );

        simpleSwitch(0);
    }

    if(document.readyState==='loading'){
        document.addEventListener(
            'DOMContentLoaded',
            initEditorialBooks,
            {
                once:true
            }
        );
    }
    else{
        initEditorialBooks();
    }
})();
</script>