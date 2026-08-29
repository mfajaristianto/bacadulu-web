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

        {{-- HEADER --}}
        <header class="bd-editorial-header">

            <div class="bd-editorial-heading">

                <div class="bd-editorial-kicker">

                    <span class="bd-editorial-kicker-icon">
                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
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
                    Temukan buku terbaru pilihan Baca Dulu dalam format cetak
                    maupun digital untuk menemani perjalanan membaca Anda.
                </p>

            </div>

            <div class="bd-editorial-header-right">

                @if(!$bukuTerbaru->isEmpty())

                    <div class="bd-editorial-counter">
                        <strong id="bdEditorialCurrent">01</strong>
                        <span>/</span>
                        <span>
                            {{ str_pad($jumlahBukuTerbaru, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                @endif

                <a
                    href="{{ route('portofolio.bookstore') }}"
                    class="bd-editorial-all"
                >
                    <span>Seluruh Koleksi</span>

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
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

                <h3>
                    Belum ada terbitan terbaru.
                </h3>

                <p>
                    Koleksi terbaru akan ditampilkan di bagian ini.
                </p>

            </div>

        @else

            <div class="bd-editorial-layout">

                {{-- =====================================================
                     FEATURE BOOK
                ====================================================== --}}
                <div
                    class="bd-feature-stage"
                    id="bdFeatureStage"
                >

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
                            class="
                                bd-feature-panel
                                {{ $index === 0 ? 'is-active' : '' }}
                            "
                            data-feature-panel="{{ $index }}"
                            style="{{ $index === 0 ? '' : 'display:none;' }}"
                        >

                            {{-- COVER --}}
                            <div class="bd-feature-cover-wrap">

                                <div class="bd-feature-cover-frame">

                                    <span class="bd-feature-cover-number">
                                        {{ $bookNumber }}
                                    </span>

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

                                                <span class="bd-placeholder-brand">
                                                    Baca Dulu
                                                </span>

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

                                                <span class="bd-placeholder-brand">
                                                    Baca Dulu
                                                </span>

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


                            {{-- COPY --}}
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


                                <span class="bd-feature-format-label">
                                    Pilihan Format
                                </span>


                                <div class="bd-feature-pricing">

                                    {{-- CETAK --}}
                                    <div class="bd-price-item">

                                        <div class="bd-price-type">

                                            <span class="bd-price-icon">
                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">
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
                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.7">
                                                    <rect
                                                        x="5"
                                                        y="3"
                                                        width="14"
                                                        height="18"
                                                        rx="2"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        d="M9 7h6M9 11h6"
                                                    />
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

                                        <span>
                                            Lihat Detail Buku
                                        </span>

                                        <svg viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">
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


                {{-- =====================================================
                     INDEX DESKTOP
                ====================================================== --}}
                <aside class="bd-book-index">

                    <div class="bd-index-header">
                        <span>Terbitan</span>
                        <strong>{{ $jumlahBukuTerbaru }} Buku</strong>
                    </div>


                    <div class="bd-index-list">

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
                                class="
                                    bd-index-item
                                    {{ $index === 0 ? 'is-active' : '' }}
                                "
                                data-book-index="{{ $index }}"
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

                                    <svg viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
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


                    {{-- =================================================
                         CONTROLS
                    ================================================== --}}
                    <div class="bd-index-footer">

                        <div class="bd-index-mobile-label">

                            <strong id="bdEditorialMobileCurrent">
                                01
                            </strong>

                            <span>/</span>

                            <span>
                                {{ str_pad($jumlahBukuTerbaru, 2, '0', STR_PAD_LEFT) }}
                            </span>

                        </div>


                        <div class="bd-index-nav">

                            <button
                                type="button"
                                id="bdEditorialPrev"
                                aria-label="Buku sebelumnya"
                            >
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
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
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
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
    --navy:#241B52;
    --orange:#EF5843;
    --orange-dark:#C84735;
    --muted:#737580;

    position:relative;
    width:100%;
    max-width:100%;
    overflow-x:clip;

    padding:86px 0 88px;

    background:#fff;
    color:#27272D;
}

.bd-editorial-books *{
    box-sizing:border-box;
}

.bd-editorial-grid-bg{
    position:absolute;
    inset:0;
    pointer-events:none;
    opacity:.58;

    background-image:
        linear-gradient(rgba(36,27,82,.035) 1px,transparent 1px),
        linear-gradient(90deg,rgba(36,27,82,.035) 1px,transparent 1px);

    background-size:42px 42px;
}

.bd-orange-accent{
    position:absolute;
    pointer-events:none;
    border-radius:50%;
}

.bd-orange-accent-left{
    width:470px;
    height:470px;

    left:-220px;
    top:-270px;

    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.11),
            transparent 70%
        );
}

.bd-orange-accent-right{
    width:520px;
    height:520px;

    right:-270px;
    bottom:-290px;

    background:
        radial-gradient(
            circle,
            rgba(247,170,53,.09),
            transparent 70%
        );
}

.bd-editorial-container{
    position:relative;
    z-index:2;

    width:min(calc(100% - 56px),1380px);
    margin:0 auto;
}


/* HEADER */
.bd-editorial-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:40px;

    margin-bottom:32px;
    padding-bottom:23px;

    border-bottom:1px solid rgba(239,88,67,.15);
}

.bd-editorial-heading{
    max-width:700px;
}

.bd-editorial-kicker{
    display:flex;
    align-items:center;
    gap:8px;

    margin-bottom:11px;

    color:var(--orange);

    font-size:8px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-editorial-kicker-icon{
    width:27px;
    height:27px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:8px;

    background:rgba(239,88,67,.08);
}

.bd-editorial-kicker-icon svg{
    width:13px;
    height:13px;
}

.bd-editorial-heading h2{
    margin:0;

    color:var(--navy);

    font-size:clamp(34px,3.5vw,47px);
    line-height:1.04;

    font-weight:850;
    letter-spacing:-.045em;
}

.bd-editorial-heading p{
    max-width:590px;

    margin:12px 0 0;

    color:var(--muted);

    font-size:11px;
    line-height:1.72;
}

.bd-editorial-header-right{
    display:flex;
    align-items:center;
    gap:21px;

    flex:0 0 auto;
}

.bd-editorial-counter{
    display:flex;
    align-items:baseline;
    gap:5px;

    color:#A5A3AA;

    font-size:8px;
    font-weight:800;
}

.bd-editorial-counter strong{
    color:var(--orange);
    font-size:18px;
}

.bd-editorial-all{
    display:flex;
    align-items:center;
    gap:8px;

    padding-bottom:5px;

    border-bottom:1px solid rgba(239,88,67,.32);

    color:var(--orange-dark)!important;

    font-size:9px;
    font-weight:850;

    text-decoration:none;
}

.bd-editorial-all svg{
    width:13px;
    height:13px;
}


/* LAYOUT */
.bd-editorial-layout{
    display:grid;

    grid-template-columns:
        minmax(0,1fr)
        320px;

    gap:22px;
}


/* FEATURE */
.bd-feature-stage{
    position:relative;

    min-width:0;
    overflow:hidden;

    padding:38px;

    border:1px solid rgba(239,88,67,.13);
    border-radius:28px;

    background:#fff;

    box-shadow:
        0 16px 42px
        rgba(36,27,82,.055);
}

.bd-feature-panel{
    position:relative;

    display:grid;

    grid-template-columns:
        265px
        minmax(0,1fr);

    gap:48px;

    align-items:center;

    min-height:455px;
}

.bd-feature-cover-wrap{
    min-width:0;
}

.bd-feature-cover-frame{
    position:relative;

    width:238px;

    margin:0 auto;

    padding:15px;

    border:1px solid rgba(239,88,67,.12);
    border-radius:23px;

    background:#fff;

    box-shadow:
        0 13px 32px
        rgba(36,27,82,.07);
}

.bd-feature-cover-number{
    position:absolute;

    z-index:5;

    left:10px;
    top:10px;

    min-width:40px;
    height:29px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 9px;

    border:1px solid rgba(239,88,67,.15);
    border-radius:9px;

    background:rgba(255,255,255,.96);

    color:var(--orange);

    font-size:9px;
    font-weight:900;
}

.bd-feature-cover-link{
    display:block;

    width:208px;
    height:294px;

    margin:0 auto;
}

.bd-feature-cover{
    display:block;

    width:100%;
    height:100%;

    object-fit:cover;

    border-radius:14px;

    box-shadow:
        7px 12px 24px
        rgba(31,27,55,.14);
}

.bd-feature-placeholder{
    width:100%;
    height:100%;

    flex-direction:column;
    justify-content:space-between;

    padding:22px;

    border-radius:14px;

    color:#fff;

    background:
        linear-gradient(
            145deg,
            #EF5843,
            #E97440
        );
}

.bd-feature-cover-link >
.bd-feature-placeholder:not(.bd-cover-error-fallback){
    display:flex;
}

.bd-cover-error-fallback{
    display:none;
}

.bd-placeholder-brand{
    font-size:7px;
    font-weight:850;
    letter-spacing:.16em;
    text-transform:uppercase;
}

.bd-feature-placeholder strong{
    display:block;

    font-size:17px;
    line-height:1.3;
}

.bd-feature-placeholder small{
    display:block;
    margin-top:8px;
    font-size:8px;
}

.bd-feature-cover-caption{
    width:208px;

    display:flex;
    align-items:center;
    gap:7px;

    margin:11px auto 0;

    color:#94919A;

    font-size:7px;
    font-weight:800;

    text-transform:uppercase;
}

.bd-caption-line{
    width:18px;
    height:1px;

    background:var(--orange);
}


/* FEATURE COPY */
.bd-feature-copy{
    min-width:0;
}

.bd-feature-category{
    display:inline-flex;
    align-items:center;

    min-height:29px;

    padding:0 11px;

    border-radius:8px;

    color:var(--orange);

    background:rgba(239,88,67,.065);

    font-size:7px;
    font-weight:850;

    letter-spacing:.14em;
    text-transform:uppercase;
}

.bd-feature-copy h3{
    max-width:590px;

    margin:14px 0 0;

    color:var(--navy);

    font-size:clamp(26px,2.7vw,38px);
    line-height:1.12;

    font-weight:850;
    letter-spacing:-.04em;

    overflow-wrap:anywhere;
}

.bd-feature-author{
    margin:12px 0 0;

    color:#666873;

    font-size:11px;
    font-weight:650;
}

.bd-feature-author span{
    margin-right:4px;

    color:#AAAAAF;
    font-weight:500;
}

.bd-feature-divider{
    width:100%;
    height:1px;

    margin:23px 0 19px;

    background:rgba(36,27,82,.09);
}

.bd-feature-format-label{
    display:block;

    margin-bottom:7px;

    color:#9A98A0;

    font-size:7px;
    font-weight:800;

    letter-spacing:.13em;
    text-transform:uppercase;
}

.bd-feature-pricing{
    border-top:1px solid rgba(36,27,82,.08);
}

.bd-price-item{
    min-height:68px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:16px;

    padding:11px 0;

    border-bottom:1px solid rgba(36,27,82,.08);
}

.bd-price-type{
    min-width:0;

    display:flex;
    align-items:center;

    gap:10px;
}

.bd-price-icon{
    width:31px;
    height:31px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex:0 0 31px;

    border-radius:9px;

    background:rgba(239,88,67,.07);
    color:var(--orange);
}

.bd-price-icon svg{
    width:15px;
    height:15px;
}

.bd-price-type > div > span{
    display:block;

    color:var(--navy);

    font-size:10px;
    font-weight:800;
}

.bd-price-type small{
    display:block;

    margin-top:2px;

    color:#A2A0A7;

    font-size:7px;
}

.bd-price-value{
    min-width:145px;
    text-align:right;
}

.bd-old-price{
    color:#AAA8AD;

    font-size:7px;

    text-decoration:line-through;
}

.bd-current-price-row{
    display:flex;
    align-items:center;
    justify-content:flex-end;

    gap:6px;
}

.bd-price-value strong{
    color:var(--navy);

    font-size:12px;
    font-weight:850;
}

.bd-price-discount{
    padding:4px 6px;

    border-radius:6px;

    background:rgba(239,88,67,.08);

    color:var(--orange);

    font-size:6px;
    font-weight:850;
}

.bd-not-available{
    color:#A8A6AC;

    font-size:8px;
}

.bd-feature-action-row{
    margin-top:21px;
}

.bd-feature-detail{
    min-height:43px;

    display:inline-flex;
    align-items:center;

    gap:10px;

    padding:0 16px;

    border-radius:10px;

    color:#fff!important;
    background:var(--navy);

    font-size:8px;
    font-weight:850;

    text-decoration:none;
}

.bd-feature-detail svg{
    width:13px;
    height:13px;
}


/* INDEX */
.bd-book-index{
    display:flex;
    flex-direction:column;

    overflow:hidden;

    border:1px solid rgba(239,88,67,.12);
    border-radius:24px;

    background:#fff;

    box-shadow:
        0 14px 38px
        rgba(36,27,82,.045);
}

.bd-index-header{
    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:17px 18px;

    border-bottom:1px solid rgba(36,27,82,.08);
}

.bd-index-header span{
    color:#9B99A0;

    font-size:7px;
    font-weight:850;

    text-transform:uppercase;
}

.bd-index-header strong{
    color:var(--navy);

    font-size:8px;
}

.bd-index-list{
    flex:1;
}

.bd-index-item{
    position:relative;

    width:100%;
    min-height:88px;

    display:grid;

    grid-template-columns:
        24px
        45px
        minmax(0,1fr)
        15px;

    align-items:center;

    gap:10px;

    padding:12px 14px;

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

    left:0;
    top:12px;
    bottom:12px;

    width:3px;

    border-radius:0 999px 999px 0;

    background:var(--orange);
}

.bd-index-number{
    color:#AAA8AE;

    font-size:7px;
    font-weight:900;
}

.bd-index-item.is-active
.bd-index-number{
    color:var(--orange);
}

.bd-index-thumb{
    width:42px;
    height:57px;

    overflow:hidden;

    border-radius:8px;

    background:#F2F1EE;
}

.bd-index-thumb img{
    width:100%;
    height:100%;

    display:block;

    object-fit:cover;
}

.bd-index-thumb-fallback{
    width:100%;
    height:100%;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#fff;

    background:var(--orange);

    font-size:7px;
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

    color:var(--navy);

    font-size:9px;
    line-height:1.4;

    font-weight:750;

    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}

.bd-index-copy span{
    display:block;

    margin-top:3px;

    overflow:hidden;

    color:#8D8C93;

    font-size:7px;

    text-overflow:ellipsis;
    white-space:nowrap;
}

.bd-index-arrow{
    color:#AAA8AE;
}

.bd-index-arrow svg{
    width:12px;
    height:12px;
}

.bd-index-item.is-active
.bd-index-arrow{
    color:var(--orange);
}


/* CONTROLS */
.bd-index-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:12px;

    padding:13px 14px;

    border-top:1px solid rgba(36,27,82,.08);
}

.bd-index-mobile-label{
    display:flex;
    align-items:baseline;

    gap:5px;

    color:#A19FA6;

    font-size:8px;
    font-weight:800;
}

.bd-index-mobile-label strong{
    color:var(--orange);

    font-size:17px;
}

.bd-index-nav{
    display:flex;
    align-items:center;

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
    color:var(--navy);

    cursor:pointer;
}

.bd-index-nav .bd-index-nav-primary{
    border-color:var(--navy);

    background:var(--navy);
    color:#fff;
}

.bd-index-nav svg{
    width:14px;
    height:14px;
}


/* EMPTY */
.bd-editorial-empty{
    padding:60px 25px;

    border:1px solid rgba(239,88,67,.12);
    border-radius:26px;

    text-align:center;
}

.bd-editorial-empty > span{
    color:var(--orange);

    font-size:8px;
    font-weight:850;
}

.bd-editorial-empty h3{
    margin:9px 0 0;

    color:var(--navy);

    font-size:20px;
}

.bd-editorial-empty p{
    margin:7px 0 0;

    color:var(--muted);

    font-size:11px;
}


/* ================================================================
   LAPTOP
================================================================ */
@media(max-width:1150px){

    .bd-editorial-layout{
        grid-template-columns:
            minmax(0,1fr)
            280px;
    }

    .bd-feature-stage{
        padding:30px;
    }

    .bd-feature-panel{
        grid-template-columns:
            220px
            minmax(0,1fr);

        gap:35px;
    }

    .bd-feature-cover-frame{
        width:205px;
    }

    .bd-feature-cover-link{
        width:175px;
        height:248px;
    }

    .bd-feature-cover-caption{
        width:175px;
    }
}


/* ================================================================
   TOUCH / TABLET
   Tidak ada horizontal index carousel.
================================================================ */
html[data-baca-input="touch"]
.bd-editorial-layout{
    grid-template-columns:1fr;
}

html[data-baca-input="touch"]
.bd-book-index{
    overflow:visible;

    border:0;

    border-radius:0;

    background:transparent;

    box-shadow:none;
}

html[data-baca-input="touch"]
.bd-index-header,
html[data-baca-input="touch"]
.bd-index-list{
    display:none;
}

html[data-baca-input="touch"]
.bd-index-footer{
    width:min(100%,680px);

    margin:12px auto 0;

    padding:12px 0 0;

    border-top:1px solid rgba(36,27,82,.09);
}


/* ================================================================
   PHONE
================================================================ */
html[data-baca-device="phone"]
.bd-editorial-books{
    padding:58px 0 60px;
}

html[data-baca-device="phone"]
.bd-editorial-container{
    width:100%;

    padding:0 16px;
}

html[data-baca-device="phone"]
.bd-editorial-header{
    flex-direction:column;
    align-items:flex-start;

    gap:15px;

    margin-bottom:22px;
    padding-bottom:18px;
}

html[data-baca-device="phone"]
.bd-editorial-heading h2{
    font-size:33px;
}

html[data-baca-device="phone"]
.bd-editorial-heading p{
    max-width:100%;

    font-size:10px;
}

html[data-baca-device="phone"]
.bd-editorial-header-right{
    width:100%;

    justify-content:space-between;
}

html[data-baca-device="phone"]
.bd-feature-stage{
    padding:19px 16px 22px;

    border-radius:21px;
}

html[data-baca-device="phone"]
.bd-feature-panel{
    grid-template-columns:1fr;

    gap:23px;

    min-height:0;
}

html[data-baca-device="phone"]
.bd-feature-cover-frame{
    width:min(63vw,230px);

    padding:12px;

    border-radius:19px;
}

html[data-baca-device="phone"]
.bd-feature-cover-link{
    width:100%;
    height:auto;

    aspect-ratio:2/2.82;
}

html[data-baca-device="phone"]
.bd-feature-cover-caption{
    width:min(60vw,205px);
}

html[data-baca-device="phone"]
.bd-feature-copy h3{
    font-size:25px;
}

html[data-baca-device="phone"]
.bd-feature-divider{
    margin:18px 0 15px;
}

html[data-baca-device="phone"]
.bd-price-item{
    min-height:64px;
}

html[data-baca-device="phone"]
.bd-feature-detail{
    width:100%;

    justify-content:space-between;

    min-height:47px;
}

html[data-baca-device="phone"]
.bd-index-footer{
    width:100%;

    margin-top:12px;
}

html[data-baca-device="phone"]
.bd-index-nav button{
    width:46px;
    height:46px;
}


/* SMALL PHONE */
@media(max-width:390px){

    html[data-baca-device="phone"]
    .bd-editorial-container{
        padding:0 14px;
    }

    html[data-baca-device="phone"]
    .bd-editorial-heading h2{
        font-size:30px;
    }

    html[data-baca-device="phone"]
    .bd-feature-copy h3{
        font-size:23px;
    }

    html[data-baca-device="phone"]
    .bd-price-item{
        flex-direction:column;
        align-items:flex-start;

        gap:8px;
    }

    html[data-baca-device="phone"]
    .bd-price-value{
        min-width:0;
        text-align:left;
    }

    html[data-baca-device="phone"]
    .bd-current-price-row{
        justify-content:flex-start;
    }
}


@media(prefers-reduced-motion:reduce){

    .bd-editorial-books *{
        transition:none!important;
    }
}
</style>


<script>
(function(){

    function initEditorialBooks(){

        const section =
            document.getElementById('katalog');

        if(
            !section ||
            section.dataset.editorialReady === '1'
        ){
            return;
        }

        section.dataset.editorialReady = '1';

        const panels =
            Array.from(
                section.querySelectorAll(
                    '[data-feature-panel]'
                )
            );

        const indexButtons =
            Array.from(
                section.querySelectorAll(
                    '[data-book-index]'
                )
            );

        const prev =
            section.querySelector(
                '#bdEditorialPrev'
            );

        const next =
            section.querySelector(
                '#bdEditorialNext'
            );

        const current =
            section.querySelector(
                '#bdEditorialCurrent'
            );

        const mobileCurrent =
            section.querySelector(
                '#bdEditorialMobileCurrent'
            );

        const stage =
            section.querySelector(
                '#bdFeatureStage'
            );

        if(!panels.length){
            return;
        }

        const gsap =
            window.bdGsap || null;

        const reduceMotion =
            window.matchMedia(
                '(prefers-reduced-motion:reduce)'
            ).matches;

        let activeIndex = 0;
        let busy = false;

        let startX = 0;
        let startY = 0;


        function device(){

            return (
                window.BacaDevice ||
                {
                    type:
                        window.innerWidth <= 767
                            ? 'phone'
                            : (
                                window.innerWidth <= 1023
                                    ? 'tablet'
                                    : 'desktop'
                            ),

                    touch:
                        navigator.maxTouchPoints > 0
                }
            );
        }


        function isTouch(){

            const d =
                device();

            return (
                d.touch === true ||
                d.type !== 'desktop'
            );
        }


        function updateUi(){

            const number =
                String(
                    activeIndex + 1
                ).padStart(
                    2,
                    '0'
                );

            if(current){
                current.textContent =
                    number;
            }

            if(mobileCurrent){
                mobileCurrent.textContent =
                    number;
            }

            indexButtons.forEach(
                function(button,index){

                    button.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );
                }
            );
        }


        function showBook(
            targetIndex,
            direction = 1
        ){

            if(!panels.length){
                return;
            }

            const nextIndex =
                (
                    targetIndex +
                    panels.length
                ) %
                panels.length;

            if(
                nextIndex === activeIndex ||
                busy
            ){
                return;
            }

            const oldPanel =
                panels[activeIndex];

            const newPanel =
                panels[nextIndex];

            if(
                !oldPanel ||
                !newPanel
            ){
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | TOUCH
            |--------------------------------------------------------------------------
            | Tidak ada horizontal document scroll.
            | Hanya ganti panel.
            */
            if(
                isTouch() ||
                !gsap ||
                reduceMotion
            ){

                oldPanel.style.display =
                    'none';

                oldPanel.classList.remove(
                    'is-active'
                );

                newPanel.style.display =
                    'grid';

                newPanel.classList.add(
                    'is-active'
                );

                activeIndex =
                    nextIndex;

                updateUi();

                if(
                    gsap &&
                    !reduceMotion
                ){

                    gsap.fromTo(
                        newPanel,
                        {
                            opacity:0,
                            x:
                                direction > 0
                                    ? 14
                                    : -14
                        },
                        {
                            opacity:1,
                            x:0,
                            duration:.28,
                            ease:'power2.out',
                            clearProps:
                                'transform,opacity'
                        }
                    );
                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | DESKTOP
            |--------------------------------------------------------------------------
            */

            busy = true;

            const oldCover =
                oldPanel.querySelector(
                    '.bd-feature-cover-wrap'
                );

            const oldCopy =
                oldPanel.querySelector(
                    '.bd-feature-copy'
                );

            const newCover =
                newPanel.querySelector(
                    '.bd-feature-cover-wrap'
                );

            const newCopy =
                newPanel.querySelector(
                    '.bd-feature-copy'
                );

            const tl =
                gsap.timeline({
                    onComplete:function(){

                        activeIndex =
                            nextIndex;

                        updateUi();

                        busy =
                            false;
                    }
                });

            tl.to(
                [
                    oldCover,
                    oldCopy
                ].filter(Boolean),
                {
                    opacity:0,
                    x:
                        direction > 0
                            ? -15
                            : 15,

                    duration:.18,
                    ease:'power2.in',
                    stagger:.025
                }
            );

            tl.set(
                oldPanel,
                {
                    display:'none'
                }
            );

            tl.set(
                newPanel,
                {
                    display:'grid'
                }
            );

            if(newCover){

                tl.fromTo(
                    newCover,
                    {
                        opacity:0,
                        x:
                            direction > 0
                                ? 17
                                : -17
                    },
                    {
                        opacity:1,
                        x:0,
                        duration:.33,
                        ease:'power3.out'
                    }
                );
            }

            if(newCopy){

                tl.fromTo(
                    newCopy,
                    {
                        opacity:0,
                        y:9
                    },
                    {
                        opacity:1,
                        y:0,
                        duration:.33,
                        ease:'power3.out'
                    },
                    '-=.23'
                );
            }

            tl.set(
                [
                    newCover,
                    newCopy
                ].filter(Boolean),
                {
                    clearProps:
                        'transform,opacity'
                }
            );
        }


        function goPrevious(){

            showBook(
                activeIndex - 1,
                -1
            );
        }


        function goNext(){

            showBook(
                activeIndex + 1,
                1
            );
        }


        indexButtons.forEach(
            function(button,index){

                button.addEventListener(
                    'click',
                    function(){

                        showBook(
                            index,
                            index >= activeIndex
                                ? 1
                                : -1
                        );
                    }
                );
            }
        );


        prev?.addEventListener(
            'click',
            function(event){

                event.preventDefault();
                event.stopPropagation();

                goPrevious();
            }
        );


        next?.addEventListener(
            'click',
            function(event){

                event.preventDefault();
                event.stopPropagation();

                goNext();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | SWIPE
        |--------------------------------------------------------------------------
        | Swipe pada FEATURE, bukan scroll horizontal halaman.
        */
        stage?.addEventListener(
            'touchstart',
            function(event){

                if(!isTouch()){
                    return;
                }

                const touch =
                    event.touches[0];

                startX =
                    touch.clientX;

                startY =
                    touch.clientY;
            },
            {
                passive:true
            }
        );


        stage?.addEventListener(
            'touchend',
            function(event){

                if(!isTouch()){
                    return;
                }

                const touch =
                    event.changedTouches[0];

                const dx =
                    touch.clientX -
                    startX;

                const dy =
                    touch.clientY -
                    startY;

                if(
                    Math.abs(dx) < 45 ||
                    Math.abs(dx) <
                    Math.abs(dy)
                ){
                    return;
                }

                if(dx < 0){
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


        window.addEventListener(
            'baca:devicechange',
            function(){

                panels.forEach(
                    function(panel,index){

                        panel.style.display =
                            index === activeIndex
                                ? 'grid'
                                : 'none';
                    }
                );

                updateUi();
            }
        );


        panels.forEach(
            function(panel,index){

                panel.style.display =
                    index === 0
                        ? 'grid'
                        : 'none';
            }
        );

        activeIndex = 0;

        updateUi();
    }


    if(
        document.readyState ===
        'loading'
    ){
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