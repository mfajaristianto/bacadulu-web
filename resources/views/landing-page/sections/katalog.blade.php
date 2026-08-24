@php
    $bukuTerbaru = \App\Models\Book::query()
        ->latest()
        ->take(5)
        ->get();

    $jumlahBukuTerbaru = $bukuTerbaru->count();
@endphp


{{-- ================================================================
     TERBITAN TERBARU BACA DULU
================================================================ --}}

<section
    id="katalog"
    class="bd-editorial-books"
>

    {{-- BACKGROUND GRID --}}
    <div
        class="bd-editorial-grid-bg"
        aria-hidden="true"
    ></div>


    {{-- ORANGE ACCENTS --}}
    <div
        class="bd-orange-accent bd-orange-accent-left"
        aria-hidden="true"
    ></div>

    <div
        class="bd-orange-accent bd-orange-accent-right"
        aria-hidden="true"
    ></div>


    <div class="bd-editorial-container">


        {{-- =========================================================
             HEADER
        ========================================================== --}}

        <header class="bd-editorial-header">

            <div class="bd-editorial-heading">

                <div class="bd-editorial-kicker">

                    <span class="bd-editorial-kicker-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                            />
                        </svg>

                    </span>


                    <span>
                        Baca Dulu Bookstore
                    </span>

                </div>


                <h2>
                    Terbitan Terbaru
                </h2>


                <p>
                    Temukan buku terbaru pilihan Baca Dulu dalam format cetak
                    maupun digital untuk menemani perjalanan membaca Anda.
                </p>

            </div>


            <div class="bd-editorial-header-right">

                @if(!$bukuTerbaru->isEmpty())

                    <div class="bd-editorial-counter">

                        <span
                            class="bd-current-number"
                            id="bdEditorialCurrent"
                        >
                            01
                        </span>

                        <span class="bd-counter-divider">
                            /
                        </span>

                        <span>
                            {{ str_pad(
                                $jumlahBukuTerbaru,
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </span>

                    </div>

                @endif


                <a
                    href="{{ route('portofolio.bookstore') }}"
                    class="bd-editorial-all"
                >

                    <span>
                        Seluruh Koleksi
                    </span>


                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14M13 6l6 6-6 6"
                        />
                    </svg>

                </a>

            </div>

        </header>



        {{-- =========================================================
             EMPTY STATE
        ========================================================== --}}

        @if($bukuTerbaru->isEmpty())

            <div class="bd-editorial-empty">

                <span>
                    Katalog
                </span>


                <h3>
                    Belum ada terbitan terbaru.
                </h3>


                <p>
                    Koleksi terbaru akan ditampilkan di bagian ini.
                </p>

            </div>


        @else


            {{-- =====================================================
                 MAIN LAYOUT
            ====================================================== --}}

            <div
                class="bd-editorial-layout"
                id="bdEditorialLayout"
            >


                {{-- =================================================
                     FEATURED BOOK
                ================================================== --}}

                <div class="bd-feature-stage">

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


                            $category = $b->category
                                ?? 'Buku';

                        @endphp


                        <article
                            class="bd-feature-panel {{ $index === 0 ? 'is-active' : '' }}"
                            data-feature-panel="{{ $index }}"
                            style="{{ $index === 0 ? '' : 'display:none;' }}"
                        >


                            {{-- =========================================
                                 COVER
                            ========================================== --}}

                            <div class="bd-feature-cover-wrap">

                                <div class="bd-feature-cover-frame">


                                    {{-- NOMOR DI POJOK KIRI ATAS --}}

                                    <div class="bd-feature-cover-number">
                                        {{ $bookNumber }}
                                    </div>


                                    <a
                                        href="{{ route(
                                            'portofolio.bookstore.show',
                                            [
                                                'book' => $b->slug
                                            ]
                                        ) }}"
                                        class="bd-feature-cover-link"
                                        aria-label="Lihat detail {{ $b->title }}"
                                    >

                                        @if($cover)

                                            <img
                                                src="{{ $cover }}"
                                                alt="{{ $b->title }}"
                                                class="bd-feature-cover"
                                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                            >

                                        @else

                                            <div class="bd-feature-placeholder">

                                                <span class="bd-placeholder-brand">
                                                    Baca Dulu
                                                </span>


                                                <div>

                                                    <strong>
                                                        {{ \Illuminate\Support\Str::limit(
                                                            $b->title,
                                                            60
                                                        ) }}
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

                                    <span>
                                        Terbitan {{ $bookNumber }}
                                    </span>

                                </div>

                            </div>



                            {{-- =========================================
                                 BOOK CONTENT
                            ========================================== --}}

                            <div class="bd-feature-copy">


                                {{-- CATEGORY --}}

                                <div class="bd-feature-category">
                                    {{ $category }}
                                </div>



                                {{-- TITLE --}}

                                <h3>
                                    {{ $b->title }}
                                </h3>



                                {{-- AUTHOR --}}

                                <p class="bd-feature-author">

                                    <span>
                                        Oleh
                                    </span>

                                    {{ $b->author }}

                                </p>



                                {{-- DIVIDER --}}

                                <div class="bd-feature-divider"></div>



                                {{-- FORMAT LABEL --}}

                                <div class="bd-feature-format-label">
                                    Pilihan Format
                                </div>



                                {{-- =====================================
                                     PRICING
                                ====================================== --}}

                                <div class="bd-feature-pricing">


                                    {{-- =================================
                                         PRINT
                                    ================================== --}}

                                    <div class="bd-price-item">

                                        <div class="bd-price-type">

                                            <span class="bd-price-icon">

                                                <svg
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                                                    />
                                                </svg>

                                            </span>


                                            <div>

                                                <span>
                                                    Buku Cetak
                                                </span>

                                                <small>
                                                    Physical Edition
                                                </small>

                                            </div>

                                        </div>


                                        <div class="bd-price-value">

                                            @if(
                                                $b->has_print
                                                &&
                                                $b->print_price !== null
                                            )

                                                @if($b->has_active_print_discount)

                                                    <div class="bd-old-price">

                                                        IDR
                                                        {{ number_format(
                                                            (float) $b->print_price,
                                                            2,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </div>

                                                @endif


                                                <div class="bd-current-price-row">

                                                    <strong>

                                                        IDR
                                                        {{ number_format(
                                                            (float) $b->effective_print_price,
                                                            2,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </strong>


                                                    @if($b->has_active_print_discount)

                                                        <span class="bd-price-discount">

                                                            -{{ number_format(
                                                                (float) $b->print_discount_percent,
                                                                0
                                                            ) }}%

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



                                    {{-- =================================
                                         EBOOK
                                    ================================== --}}

                                    <div class="bd-price-item">

                                        <div class="bd-price-type">

                                            <span class="bd-price-icon">

                                                <svg
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                >

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

                                                <span>
                                                    E-book
                                                </span>

                                                <small>
                                                    Digital Edition
                                                </small>

                                            </div>

                                        </div>


                                        <div class="bd-price-value">

                                            @if(
                                                $b->has_ebook
                                                &&
                                                $b->ebook_price !== null
                                            )

                                                @if($b->has_active_ebook_discount)

                                                    <div class="bd-old-price">

                                                        IDR
                                                        {{ number_format(
                                                            (float) $b->ebook_price,
                                                            2,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </div>

                                                @endif


                                                <div class="bd-current-price-row">

                                                    <strong>

                                                        IDR
                                                        {{ number_format(
                                                            (float) $b->effective_ebook_price,
                                                            2,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </strong>


                                                    @if($b->has_active_ebook_discount)

                                                        <span class="bd-price-discount">

                                                            -{{ number_format(
                                                                (float) $b->ebook_discount_percent,
                                                                0
                                                            ) }}%

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



                                {{-- =====================================
                                     ACTION
                                ====================================== --}}

                                <div class="bd-feature-action-row">

                                    <a
                                        href="{{ route(
                                            'portofolio.bookstore.show',
                                            [
                                                'book' => $b->slug
                                            ]
                                        ) }}"
                                        class="bd-feature-detail"
                                    >

                                        <span>
                                            Lihat Detail Buku
                                        </span>


                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
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



                {{-- =================================================
                     BOOK INDEX
                ================================================== --}}

                <aside class="bd-book-index">

                    <div class="bd-index-header">

                        <span>
                            Terbitan
                        </span>


                        <strong>
                            {{ $jumlahBukuTerbaru }} Buku
                        </strong>

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
                                        >

                                    @else

                                        <div class="bd-index-thumb-fallback">
                                            BD
                                        </div>

                                    @endif

                                </div>


                                <div class="bd-index-copy">

                                    <strong>
                                        {{ \Illuminate\Support\Str::limit(
                                            $b->title,
                                            46
                                        ) }}
                                    </strong>


                                    <span>
                                        {{ $b->author }}
                                    </span>

                                </div>


                                <span class="bd-index-arrow">

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
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



                    {{-- =============================================
                         NAVIGATION
                    ============================================== --}}

                    <div class="bd-index-footer">

                        <div class="bd-index-nav">

                            <button
                                type="button"
                                id="bdEditorialPrev"
                                aria-label="Buku sebelumnya"
                            >

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
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

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
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



{{-- ================================================================
     STYLE
================================================================ --}}

<style>

    /* ============================================================
       ROOT
    ============================================================ */

    .bd-editorial-books {

        --bd-navy:
            #241B52;

        --bd-orange:
            #EF5843;

        --bd-orange-dark:
            #C84735;

        --bd-text:
            #27272D;

        --bd-muted:
            #737580;

        --bd-line:
            rgba(36, 27, 82, .07);

        --bd-border:
            rgba(36, 27, 82, .10);


        position:
            relative;

        width:
            100%;

        overflow:
            hidden;

        padding:
            94px 0 96px;

        background:
            #FFFFFF;

        color:
            var(--bd-text);

    }



    /* ============================================================
       GRID BACKGROUND
       Seperti section Nilai Baca Dulu
    ============================================================ */

    .bd-editorial-grid-bg {

        position:
            absolute;

        inset:
            0;

        z-index:
            0;

        pointer-events:
            none;

        background-image:

            linear-gradient(
                rgba(36, 27, 82, .040) 1px,
                transparent 1px
            ),

            linear-gradient(
                90deg,
                rgba(36, 27, 82, .040) 1px,
                transparent 1px
            );

        background-size:
            38px 38px;

        opacity:
            .70;

    }



    /* ============================================================
       ORANGE ACCENTS
    ============================================================ */

    .bd-orange-accent {

        position:
            absolute;

        z-index:
            0;

        border-radius:
            999px;

        pointer-events:
            none;

        filter:
            blur(8px);

    }


    .bd-orange-accent-left {

        width:
            470px;

        height:
            470px;

        top:
            -250px;

        left:
            -190px;

        background:
            radial-gradient(
                circle,
                rgba(239, 88, 67, .13) 0%,
                rgba(239, 88, 67, .07) 32%,
                rgba(239, 88, 67, .025) 52%,
                transparent 72%
            );

    }


    .bd-orange-accent-right {

        width:
            520px;

        height:
            520px;

        right:
            -230px;

        bottom:
            -270px;

        background:
            radial-gradient(
                circle,
                rgba(239, 88, 67, .11) 0%,
                rgba(247, 170, 53, .055) 34%,
                transparent 72%
            );

    }



    /* ============================================================
       CONTAINER
    ============================================================ */

    .bd-editorial-container {

        position:
            relative;

        z-index:
            2;

        width:
            min(
                calc(100% - 48px),
                1320px
            );

        margin:
            0 auto;

    }



    /* ============================================================
       HEADER
    ============================================================ */

    .bd-editorial-header {

        display:
            flex;

        align-items:
            flex-end;

        justify-content:
            space-between;

        gap:
            48px;

        margin-bottom:
            38px;

        padding-bottom:
            26px;

        border-bottom:
            1px solid
            rgba(239, 88, 67, .15);

    }


    .bd-editorial-heading {

        max-width:
            700px;

    }



    /* ============================================================
       KICKER
    ============================================================ */

    .bd-editorial-kicker {

        display:
            flex;

        align-items:
            center;

        gap:
            9px;

        margin-bottom:
            13px;

        color:
            var(--bd-orange);

        font-size:
            9px;

        font-weight:
            850;

        letter-spacing:
            .16em;

        text-transform:
            uppercase;

    }


    .bd-editorial-kicker-icon {

        width:
            28px;

        height:
            28px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            9px;

        background:
            rgba(239, 88, 67, .085);

    }


    .bd-editorial-kicker-icon svg {

        width:
            13px;

        height:
            13px;

    }



    /* ============================================================
       HEADER TITLE
    ============================================================ */

    .bd-editorial-heading h2 {

        margin:
            0;

        color:
            var(--bd-navy);

        font-size:
            clamp(
                35px,
                4vw,
                51px
            );

        line-height:
            1.05;

        font-weight:
            800;

        letter-spacing:
            -.045em;

    }


    .bd-editorial-heading p {

        max-width:
            600px;

        margin:
            15px 0 0;

        color:
            var(--bd-muted);

        font-size:
            13px;

        line-height:
            1.75;

    }



    /* ============================================================
       HEADER RIGHT
    ============================================================ */

    .bd-editorial-header-right {

        display:
            flex;

        align-items:
            center;

        gap:
            24px;

        flex-shrink:
            0;

    }


    .bd-editorial-counter {

        display:
            flex;

        align-items:
            baseline;

        gap:
            5px;

        color:
            #A5A3AA;

        font-size:
            9px;

        font-weight:
            800;

    }


    .bd-current-number {

        color:
            var(--bd-orange);

        font-size:
            17px;

    }


    .bd-counter-divider {

        color:
            #D1CFD2;

    }



    /* ============================================================
       ALL COLLECTION
    ============================================================ */

    .bd-editorial-all {

        display:
            inline-flex;

        align-items:
            center;

        gap:
            9px;

        padding:
            0 0 5px;

        border-bottom:
            1px solid
            rgba(239, 88, 67, .34);

        color:
            var(--bd-orange-dark) !important;

        font-size:
            10px;

        font-weight:
            800;

    }


    .bd-editorial-all svg {

        width:
            14px;

        height:
            14px;

        transition:
            transform .22s ease;

    }


    .bd-editorial-all:hover svg {

        transform:
            translateX(3px);

    }



    /* ============================================================
       LAYOUT
    ============================================================ */

    .bd-editorial-layout {

        display:
            grid;

        grid-template-columns:
            minmax(0, 1fr)
            335px;

        gap:
            24px;

        align-items:
            stretch;

    }



    /* ============================================================
       FEATURE STAGE
    ============================================================ */

    .bd-feature-stage {

        position:
            relative;

        min-width:
            0;

        padding:
            44px;

        overflow:
            hidden;

        border:
            1px solid
            rgba(239, 88, 67, .13);

        border-radius:
            32px;

        background:
            rgba(255, 255, 255, .92);

        box-shadow:
            0 18px 45px
            rgba(36, 27, 82, .055);

    }


    .bd-feature-stage::before {

        content:
            "";

        position:
            absolute;

        width:
            240px;

        height:
            240px;

        left:
            -100px;

        bottom:
            -115px;

        border-radius:
            999px;

        background:
            radial-gradient(
                circle,
                rgba(239, 88, 67, .08),
                transparent 68%
            );

        pointer-events:
            none;

    }



    /* ============================================================
       FEATURE PANEL
    ============================================================ */

    .bd-feature-panel {

        position:
            relative;

        z-index:
            2;

        display:
            grid;

        grid-template-columns:
            300px
            minmax(0, 1fr);

        gap:
            58px;

        align-items:
            center;

        min-height:
            500px;

    }



    /* ============================================================
       COVER WRAP
    ============================================================ */

    .bd-feature-cover-wrap {

        min-width:
            0;

    }


    .bd-feature-cover-frame {

        position:
            relative;

        width:
            274px;

        margin:
            0 auto;

        padding:
            18px;

        border:
            1px solid
            rgba(239, 88, 67, .12);

        border-radius:
            27px;

        background:
            rgba(255,255,255,.95);

        box-shadow:
            0 14px 36px
            rgba(36, 27, 82, .07);

    }



    /* ============================================================
       NUMBER
       KIRI ATAS GRID COVER
    ============================================================ */

    .bd-feature-cover-number {

        position:
            absolute;

        top:
            12px;

        left:
            12px;

        z-index:
            8;

        min-width:
            44px;

        height:
            32px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        padding:
            0 10px;

        border:
            1px solid
            rgba(239, 88, 67, .17);

        border-radius:
            11px;

        background:
            rgba(255,255,255,.96);

        color:
            var(--bd-orange);

        font-size:
            10px;

        line-height:
            1;

        font-weight:
            900;

        letter-spacing:
            .08em;

        box-shadow:
            0 6px 15px
            rgba(36,27,82,.07);

    }



    /* ============================================================
       COVER
    ============================================================ */

    .bd-feature-cover-link {

        position:
            relative;

        z-index:
            2;

        display:
            block;

        width:
            238px;

        height:
            335px;

        margin:
            0 auto;

    }


    .bd-feature-cover {

        display:
            block;

        width:
            100%;

        height:
            100%;

        object-fit:
            cover;

        object-position:
            center;

        border-radius:
            17px;

        box-shadow:
            8px 13px 27px
            rgba(31,27,55,.15);

        will-change:
            transform;

    }



    /* ============================================================
       PLACEHOLDER
    ============================================================ */

    .bd-feature-placeholder {

        width:
            100%;

        height:
            100%;

        display:
            flex;

        flex-direction:
            column;

        justify-content:
            space-between;

        padding:
            24px;

        border-radius:
            17px;

        background:
            var(--bd-orange);

        color:
            #FFFFFF;

        box-shadow:
            8px 13px 27px
            rgba(31,27,55,.15);

    }


    .bd-placeholder-brand {

        font-size:
            7px;

        font-weight:
            850;

        letter-spacing:
            .18em;

        text-transform:
            uppercase;

        opacity:
            .76;

    }


    .bd-feature-placeholder strong {

        display:
            block;

        font-size:
            18px;

        line-height:
            1.3;

        font-weight:
            800;

    }


    .bd-feature-placeholder small {

        display:
            block;

        margin-top:
            9px;

        font-size:
            9px;

        opacity:
            .78;

    }



    /* ============================================================
       CAPTION
    ============================================================ */

    .bd-feature-cover-caption {

        width:
            238px;

        display:
            flex;

        align-items:
            center;

        gap:
            8px;

        margin:
            14px auto 0;

        color:
            #94919A;

        font-size:
            7.5px;

        font-weight:
            800;

        letter-spacing:
            .10em;

        text-transform:
            uppercase;

    }


    .bd-caption-line {

        width:
            20px;

        height:
            1.5px;

        flex-shrink:
            0;

        background:
            var(--bd-orange);

    }



    /* ============================================================
       COPY
    ============================================================ */

    .bd-feature-copy {

        min-width:
            0;

    }


    .bd-feature-category {

        display:
            inline-flex;

        align-items:
            center;

        min-height:
            31px;

        padding:
            0 12px;

        border:
            1px solid
            rgba(239, 88, 67, .12);

        border-radius:
            9px;

        background:
            rgba(239, 88, 67, .065);

        color:
            var(--bd-orange);

        font-size:
            8px;

        font-weight:
            850;

        letter-spacing:
            .15em;

        text-transform:
            uppercase;

    }


    .bd-feature-copy h3 {

        max-width:
            590px;

        margin:
            15px 0 0;

        color:
            var(--bd-navy);

        font-size:
            clamp(
                28px,
                3vw,
                42px
            );

        line-height:
            1.12;

        font-weight:
            800;

        letter-spacing:
            -.04em;

    }


    .bd-feature-author {

        margin:
            14px 0 0;

        color:
            #666873;

        font-size:
            12px;

        font-weight:
            650;

    }


    .bd-feature-author span {

        margin-right:
            5px;

        color:
            #AAAAAF;

        font-weight:
            500;

    }



    /* ============================================================
       DIVIDER
    ============================================================ */

    .bd-feature-divider {

        width:
            100%;

        height:
            1px;

        margin:
            28px 0 23px;

        background:
            rgba(36,27,82,.09);

    }


    .bd-feature-format-label {

        margin-bottom:
            10px;

        color:
            #9A98A0;

        font-size:
            8px;

        font-weight:
            800;

        letter-spacing:
            .14em;

        text-transform:
            uppercase;

    }



    /* ============================================================
       PRICING
    ============================================================ */

    .bd-feature-pricing {

        border-top:
            1px solid
            rgba(36,27,82,.09);

    }


    .bd-price-item {

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            20px;

        min-height:
            78px;

        padding:
            14px 0;

        border-bottom:
            1px solid
            rgba(36,27,82,.09);

    }



    /* ============================================================
       PRICE TYPE
    ============================================================ */

    .bd-price-type {

        display:
            flex;

        align-items:
            center;

        gap:
            11px;

        min-width:
            0;

    }


    .bd-price-icon {

        width:
            34px;

        height:
            34px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        flex-shrink:
            0;

        border-radius:
            10px;

        background:
            rgba(239,88,67,.07);

        color:
            var(--bd-orange);

    }


    .bd-price-icon svg {

        width:
            16px;

        height:
            16px;

    }


    .bd-price-type > div > span {

        display:
            block;

        color:
            var(--bd-navy);

        font-size:
            11px;

        font-weight:
            800;

    }


    .bd-price-type small {

        display:
            block;

        margin-top:
            3px;

        color:
            #A2A0A7;

        font-size:
            7.5px;

    }



    /* ============================================================
       PRICE VALUE
    ============================================================ */

    .bd-price-value {

        min-width:
            150px;

        text-align:
            right;

    }


    .bd-old-price {

        margin-bottom:
            3px;

        color:
            #AAA8AD;

        font-size:
            8px;

        text-decoration:
            line-through;

    }


    .bd-current-price-row {

        display:
            flex;

        align-items:
            center;

        justify-content:
            flex-end;

        gap:
            7px;

    }


    .bd-price-value strong {

        color:
            var(--bd-navy);

        font-size:
            13px;

        font-weight:
            850;

    }


    .bd-price-discount {

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        min-height:
            22px;

        padding:
            0 7px;

        border-radius:
            7px;

        background:
            rgba(239, 88, 67, .08);

        color:
            var(--bd-orange);

        font-size:
            7px;

        font-weight:
            850;

    }


    .bd-not-available {

        color:
            #A8A6AC;

        font-size:
            9px;

        font-weight:
            650;

    }



    /* ============================================================
       DETAIL BUTTON
    ============================================================ */

    .bd-feature-action-row {

        margin-top:
            25px;

    }


    .bd-feature-detail {

        display:
            inline-flex;

        align-items:
            center;

        gap:
            10px;

        min-height:
            44px;

        padding:
            0 17px;

        border:
            1px solid
            var(--bd-navy);

        border-radius:
            11px;

        background:
            var(--bd-navy);

        color:
            #FFFFFF !important;

        font-size:
            9px;

        font-weight:
            800;

        transition:
            border-color .2s ease,
            background .2s ease;

    }


    .bd-feature-detail:hover {

        border-color:
            var(--bd-orange);

        background:
            var(--bd-orange);

    }


    .bd-feature-detail svg {

        width:
            14px;

        height:
            14px;

    }



    /* ============================================================
       SIDEBAR
    ============================================================ */

    .bd-book-index {

        display:
            flex;

        flex-direction:
            column;

        overflow:
            hidden;

        border:
            1px solid
            rgba(239, 88, 67, .12);

        border-radius:
            27px;

        background:
            rgba(255, 255, 255, .93);

        box-shadow:
            0 15px 40px
            rgba(36,27,82,.045);

    }



    /* ============================================================
       INDEX HEADER
    ============================================================ */

    .bd-index-header {

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            15px;

        padding:
            19px 20px;

        border-bottom:
            1px solid
            rgba(36,27,82,.08);

    }


    .bd-index-header span {

        color:
            #9B99A0;

        font-size:
            7.5px;

        font-weight:
            850;

        letter-spacing:
            .15em;

        text-transform:
            uppercase;

    }


    .bd-index-header strong {

        color:
            var(--bd-navy);

        font-size:
            9px;

        font-weight:
            850;

    }



    /* ============================================================
       INDEX LIST
    ============================================================ */

    .bd-index-list {

        flex:
            1;

    }


    .bd-index-item {

        position:
            relative;

        width:
            100%;

        min-height:
            98px;

        display:
            grid;

        grid-template-columns:
            26px
            52px
            minmax(0, 1fr)
            18px;

        align-items:
            center;

        gap:
            11px;

        padding:
            14px 16px;

        border:
            0;

        border-bottom:
            1px solid
            rgba(36,27,82,.07);

        background:
            transparent;

        color:
            inherit;

        text-align:
            left;

        cursor:
            pointer;

        transition:
            background .22s ease;

    }


    .bd-index-item:last-child {

        border-bottom:
            0;

    }


    .bd-index-item:hover {

        background:
            rgba(239, 88, 67, .025);

    }


    .bd-index-item.is-active {

        background:
            rgba(239, 88, 67, .055);

    }


    .bd-index-item.is-active::before {

        content:
            "";

        position:
            absolute;

        top:
            13px;

        bottom:
            13px;

        left:
            0;

        width:
            3px;

        border-radius:
            0 999px 999px 0;

        background:
            var(--bd-orange);

    }



    /* ============================================================
       INDEX NUMBER
    ============================================================ */

    .bd-index-number {

        color:
            #AAA8AE;

        font-size:
            8px;

        font-weight:
            900;

    }


    .bd-index-item.is-active
    .bd-index-number {

        color:
            var(--bd-orange);

    }



    /* ============================================================
       INDEX THUMB
    ============================================================ */

    .bd-index-thumb {

        width:
            47px;

        height:
            64px;

        overflow:
            hidden;

        border-radius:
            10px;

        background:
            #F2F1EE;

    }


    .bd-index-thumb img {

        display:
            block;

        width:
            100%;

        height:
            100%;

        object-fit:
            cover;

    }


    .bd-index-thumb-fallback {

        width:
            100%;

        height:
            100%;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        background:
            var(--bd-orange);

        color:
            #FFFFFF;

        font-size:
            8px;

        font-weight:
            900;

    }



    /* ============================================================
       INDEX COPY
    ============================================================ */

    .bd-index-copy {

        min-width:
            0;

    }


    .bd-index-copy strong {

        display:
            -webkit-box;

        overflow:
            hidden;

        color:
            var(--bd-navy);

        font-size:
            10px;

        line-height:
            1.42;

        font-weight:
            750;

        -webkit-line-clamp:
            2;

        -webkit-box-orient:
            vertical;

    }


    .bd-index-copy span {

        display:
            block;

        margin-top:
            4px;

        overflow:
            hidden;

        color:
            #8D8C93;

        font-size:
            8px;

        text-overflow:
            ellipsis;

        white-space:
            nowrap;

    }



    /* ============================================================
       INDEX ARROW
    ============================================================ */

    .bd-index-arrow {

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        color:
            #AAA8AE;

    }


    .bd-index-arrow svg {

        width:
            13px;

        height:
            13px;

    }


    .bd-index-item.is-active
    .bd-index-arrow {

        color:
            var(--bd-orange);

    }



    /* ============================================================
       SIDEBAR FOOTER
    ============================================================ */

    .bd-index-footer {

        display:
            flex;

        justify-content:
            flex-end;

        padding:
            15px 16px 17px;

        border-top:
            1px solid
            rgba(36,27,82,.08);

    }


    .bd-index-nav {

        display:
            flex;

        gap:
            7px;

    }


    .bd-index-nav button {

        width:
            39px;

        height:
            39px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        padding:
            0;

        border:
            1px solid
            rgba(36,27,82,.12);

        border-radius:
            11px;

        background:
            #FFFFFF;

        color:
            var(--bd-navy);

        cursor:
            pointer;

        transition:
            border-color .2s ease,
            background .2s ease,
            color .2s ease;

    }


    .bd-index-nav button:hover {

        border-color:
            rgba(239,88,67,.45);

    }


    .bd-index-nav
    .bd-index-nav-primary {

        border-color:
            var(--bd-navy);

        background:
            var(--bd-navy);

        color:
            #FFFFFF;

    }


    .bd-index-nav
    .bd-index-nav-primary:hover {

        border-color:
            var(--bd-orange);

        background:
            var(--bd-orange);

    }


    .bd-index-nav svg {

        width:
            14px;

        height:
            14px;

    }



    /* ============================================================
       EMPTY
    ============================================================ */

    .bd-editorial-empty {

        padding:
            65px 30px;

        border:
            1px solid
            rgba(239, 88, 67, .12);

        border-radius:
            28px;

        background:
            rgba(255,255,255,.92);

        text-align:
            center;

    }


    .bd-editorial-empty > span {

        color:
            var(--bd-orange);

        font-size:
            8px;

        font-weight:
            850;

        letter-spacing:
            .16em;

        text-transform:
            uppercase;

    }


    .bd-editorial-empty h3 {

        margin:
            9px 0 0;

        color:
            var(--bd-navy);

        font-size:
            20px;

    }


    .bd-editorial-empty p {

        margin:
            7px 0 0;

        color:
            var(--bd-muted);

        font-size:
            11px;

    }



    /* ============================================================
       LAPTOP
    ============================================================ */

    @media(max-width:1150px) {

        .bd-editorial-layout {

            grid-template-columns:
                minmax(0, 1fr)
                290px;

        }


        .bd-feature-stage {

            padding:
                35px;

        }


        .bd-feature-panel {

            grid-template-columns:
                240px
                minmax(0,1fr);

            gap:
                42px;

        }


        .bd-feature-cover-frame {

            width:
                220px;

        }


        .bd-feature-cover-link {

            width:
                184px;

            height:
                270px;

        }


        .bd-feature-cover-caption {

            width:
                184px;

        }

    }



    /* ============================================================
       TABLET
    ============================================================ */

    @media(max-width:920px) {

        .bd-editorial-layout {

            grid-template-columns:
                minmax(0,1fr);

        }


        .bd-index-list {

            display:
                flex;

            overflow-x:
                auto;

            scrollbar-width:
                none;

        }


        .bd-index-list::-webkit-scrollbar {

            display:
                none;

        }


        .bd-index-item {

            flex:
                0 0 270px;

            border-right:
                1px solid
                rgba(36,27,82,.07);

            border-bottom:
                0;

        }


        .bd-index-item.is-active::before {

            top:
                auto;

            left:
                14px;

            right:
                14px;

            bottom:
                0;

            width:
                auto;

            height:
                3px;

            border-radius:
                999px 999px 0 0;

        }


        .bd-index-footer {

            display:
                none;

        }

    }



    /* ============================================================
       MOBILE
    ============================================================ */

    @media(max-width:700px) {

        .bd-editorial-books {

            padding:
                62px 0;

        }


        .bd-editorial-container {

            width:
                min(
                    calc(100% - 30px),
                    1320px
                );

        }


        .bd-editorial-header {

            align-items:
                flex-start;

            flex-direction:
                column;

            gap:
                22px;

            margin-bottom:
                28px;

        }


        .bd-editorial-heading h2 {

            font-size:
                34px;

        }


        .bd-editorial-heading p {

            font-size:
                12px;

        }


        .bd-editorial-header-right {

            width:
                100%;

            justify-content:
                space-between;

        }


        .bd-feature-stage {

            padding:
                24px 18px 27px;

            border-radius:
                25px;

        }


        .bd-feature-panel {

            grid-template-columns:
                minmax(0,1fr);

            gap:
                34px;

            min-height:
                0;

        }


        .bd-feature-cover-frame {

            width:
                min(
                    70vw,
                    255px
                );

            padding:
                14px;

            border-radius:
                23px;

        }


        .bd-feature-cover-link {

            width:
                100%;

            height:
                auto;

            aspect-ratio:
                2 / 2.82;

        }


        .bd-feature-cover {

            border-radius:
                15px;

        }


        .bd-feature-cover-caption {

            width:
                min(
                    65vw,
                    220px
                );

        }


        .bd-feature-copy h3 {

            font-size:
                29px;

        }


        .bd-price-item {

            align-items:
                flex-start;

        }


        .bd-price-value {

            min-width:
                120px;

        }


        .bd-book-index {

            border-radius:
                23px;

        }

    }



    /* ============================================================
       SMALL MOBILE
    ============================================================ */

    @media(max-width:440px) {

        .bd-editorial-header-right {

            align-items:
                flex-start;

            flex-direction:
                column;

            gap:
                14px;

        }


        .bd-price-item {

            align-items:
                flex-start;

            flex-direction:
                column;

            gap:
                12px;

        }


        .bd-price-value {

            min-width:
                0;

            text-align:
                left;

        }


        .bd-current-price-row {

            justify-content:
                flex-start;

        }


        .bd-index-item {

            flex-basis:
                240px;

        }

    }



    /* ============================================================
       REDUCED MOTION
    ============================================================ */

    @media(prefers-reduced-motion:reduce) {

        .bd-editorial-books *,
        .bd-editorial-books *::before,
        .bd-editorial-books *::after {

            scroll-behavior:
                auto !important;

        }

    }

</style>



{{-- ================================================================
     GSAP
================================================================ --}}

@once

<script
    src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"
></script>

<script
    src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"
></script>

@endonce



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const section =
            document.getElementById(
                'katalog'
            );


        if (
            !section
        ) {

            return;

        }



        /* =========================================================
           ELEMENTS
        ========================================================== */

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


        const previousButton =
            document.getElementById(
                'bdEditorialPrev'
            );


        const nextButton =
            document.getElementById(
                'bdEditorialNext'
            );


        const currentNumber =
            document.getElementById(
                'bdEditorialCurrent'
            );


        const reduceMotion =
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;


        const hasGSAP =
            typeof window.gsap !==
            'undefined';


        const hasScrollTrigger =
            typeof window.ScrollTrigger !==
            'undefined';


        let activeIndex =
            0;


        let animating =
            false;



        /* =========================================================
           REGISTER GSAP
        ========================================================== */

        if (
            hasGSAP &&
            hasScrollTrigger
        ) {

            gsap.registerPlugin(
                ScrollTrigger
            );

        }



        /* =========================================================
           INTRO REVEAL
        ========================================================== */

        if (
            hasGSAP &&
            hasScrollTrigger &&
            !reduceMotion
        ) {

            const introTimeline =
                gsap.timeline({

                    scrollTrigger: {

                        trigger:
                            section,

                        start:
                            'top 82%',

                        once:
                            true

                    },

                    defaults: {

                        ease:
                            'power3.out'

                    }

                });


            introTimeline

                .from(
                    '.bd-editorial-kicker',
                    {

                        autoAlpha:
                            0,

                        y:
                            9,

                        duration:
                            .38

                    }
                )

                .from(
                    '.bd-editorial-heading h2',
                    {

                        autoAlpha:
                            0,

                        y:
                            17,

                        duration:
                            .58

                    },
                    '-=.16'
                )

                .from(
                    '.bd-editorial-heading p',
                    {

                        autoAlpha:
                            0,

                        y:
                            11,

                        duration:
                            .45

                    },
                    '-=.32'
                )

                .from(
                    '.bd-editorial-header-right',
                    {

                        autoAlpha:
                            0,

                        x:
                            10,

                        duration:
                            .42

                    },
                    '-=.32'
                )

                .from(
                    '.bd-feature-stage',
                    {

                        autoAlpha:
                            0,

                        y:
                            16,

                        duration:
                            .58

                    },
                    '-=.16'
                )

                .from(
                    '.bd-book-index',
                    {

                        autoAlpha:
                            0,

                        x:
                            14,

                        duration:
                            .52

                    },
                    '-=.43'
                )

                .from(
                    '.bd-index-item',
                    {

                        autoAlpha:
                            0,

                        x:
                            7,

                        duration:
                            .32,

                        stagger:
                            .04

                    },
                    '-=.28'
                );

        }



        /* =========================================================
           BACKGROUND ACCENT MOTION
           Sangat subtle
        ========================================================== */

        if (
            hasGSAP &&
            !reduceMotion
        ) {

            gsap.to(
                '.bd-orange-accent-left',
                {

                    x:
                        18,

                    y:
                        12,

                    duration:
                        9,

                    repeat:
                        -1,

                    yoyo:
                        true,

                    ease:
                        'sine.inOut'

                }
            );


            gsap.to(
                '.bd-orange-accent-right',
                {

                    x:
                        -14,

                    y:
                        -10,

                    duration:
                        10,

                    repeat:
                        -1,

                    yoyo:
                        true,

                    ease:
                        'sine.inOut'

                }
            );

        }



        /* =========================================================
           UPDATE UI
        ========================================================== */

        function updateUI() {

            indexButtons.forEach(
                function (
                    button,
                    index
                ) {

                    button.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );

                }
            );


            if (
                currentNumber
            ) {

                currentNumber.textContent =
                    String(
                        activeIndex + 1
                    )
                    .padStart(
                        2,
                        '0'
                    );

            }

        }



        /* =========================================================
           SIMPLE SWITCH
        ========================================================== */

        function simpleSwitch(
            nextIndex
        ) {

            panels.forEach(
                function (
                    panel,
                    index
                ) {

                    panel.style.display =
                        index === nextIndex
                            ? 'grid'
                            : 'none';


                    panel.classList.toggle(
                        'is-active',
                        index === nextIndex
                    );

                }
            );


            activeIndex =
                nextIndex;


            updateUI();

        }



        /* =========================================================
           SWITCH BOOK GSAP
        ========================================================== */

        function switchBook(
            nextIndex,
            direction = 1
        ) {

            if (
                animating ||
                nextIndex === activeIndex ||
                !panels[nextIndex]
            ) {

                return;

            }


            if (
                !hasGSAP ||
                reduceMotion
            ) {

                simpleSwitch(
                    nextIndex
                );


                return;

            }


            animating =
                true;


            const currentPanel =
                panels[
                    activeIndex
                ];


            const nextPanel =
                panels[
                    nextIndex
                ];


            const currentCover =
                currentPanel.querySelector(
                    '.bd-feature-cover-wrap'
                );


            const currentCopy =
                currentPanel.querySelectorAll(
                    '.bd-feature-copy > *'
                );


            const nextCover =
                nextPanel.querySelector(
                    '.bd-feature-cover-wrap'
                );


            const nextCopy =
                nextPanel.querySelectorAll(
                    '.bd-feature-copy > *'
                );


            const distance =
                direction > 0
                    ? 16
                    : -16;


            const timeline =
                gsap.timeline({

                    onComplete:
                        function () {

                            activeIndex =
                                nextIndex;


                            currentPanel.classList.remove(
                                'is-active'
                            );


                            nextPanel.classList.add(
                                'is-active'
                            );


                            updateUI();


                            animating =
                                false;

                        }

                });



            /* CURRENT OUT */

            timeline.to(
                currentCover,
                {

                    autoAlpha:
                        0,

                    x:
                        -distance,

                    duration:
                        .22,

                    ease:
                        'power2.in'

                }
            );


            timeline.to(
                currentCopy,
                {

                    autoAlpha:
                        0,

                    y:
                        -7,

                    duration:
                        .17,

                    stagger:
                        .01,

                    ease:
                        'power2.in'

                },
                '<'
            );



            /* SWAP */

            timeline.set(
                currentPanel,
                {

                    display:
                        'none'

                }
            );


            timeline.set(
                nextPanel,
                {

                    display:
                        'grid'

                }
            );



            /* NEW COVER */

            timeline.fromTo(
                nextCover,
                {

                    autoAlpha:
                        0,

                    x:
                        distance

                },
                {

                    autoAlpha:
                        1,

                    x:
                        0,

                    duration:
                        .38,

                    ease:
                        'power3.out'

                }
            );



            /* NEW COPY */

            timeline.fromTo(
                nextCopy,
                {

                    autoAlpha:
                        0,

                    y:
                        11

                },
                {

                    autoAlpha:
                        1,

                    y:
                        0,

                    duration:
                        .34,

                    stagger:
                        .028,

                    ease:
                        'power3.out'

                },
                '<.03'
            );

        }



        /* =========================================================
           INDEX CLICK
        ========================================================== */

        indexButtons.forEach(
            function (
                button,
                index
            ) {

                button.addEventListener(
                    'click',
                    function () {

                        const direction =
                            index >
                            activeIndex
                                ? 1
                                : -1;


                        switchBook(
                            index,
                            direction
                        );

                    }
                );

            }
        );



        /* =========================================================
           PREVIOUS
        ========================================================== */

        previousButton
            ?.addEventListener(
                'click',
                function () {

                    let next =
                        activeIndex - 1;


                    if (
                        next < 0
                    ) {

                        next =
                            panels.length - 1;

                    }


                    switchBook(
                        next,
                        -1
                    );

                }
            );



        /* =========================================================
           NEXT
        ========================================================== */

        nextButton
            ?.addEventListener(
                'click',
                function () {

                    let next =
                        activeIndex + 1;


                    if (
                        next >= panels.length
                    ) {

                        next =
                            0;

                    }


                    switchBook(
                        next,
                        1
                    );

                }
            );



        /* =========================================================
           COVER HOVER
        ========================================================== */

        if (
            hasGSAP &&
            !reduceMotion &&
            window.matchMedia(
                '(hover:hover) and (pointer:fine)'
            ).matches
        ) {

            panels.forEach(
                function (
                    panel
                ) {

                    const link =
                        panel.querySelector(
                            '.bd-feature-cover-link'
                        );


                    const cover =
                        panel.querySelector(
                            '.bd-feature-cover'
                        );


                    if (
                        !link ||
                        !cover
                    ) {

                        return;

                    }


                    link.addEventListener(
                        'mouseenter',
                        function () {

                            gsap.to(
                                cover,
                                {

                                    y:
                                        -4,

                                    scale:
                                        1.01,

                                    duration:
                                        .32,

                                    ease:
                                        'power2.out'

                                }
                            );

                        }
                    );


                    link.addEventListener(
                        'mouseleave',
                        function () {

                            gsap.to(
                                cover,
                                {

                                    y:
                                        0,

                                    scale:
                                        1,

                                    duration:
                                        .40,

                                    ease:
                                        'power3.out'

                                }
                            );

                        }
                    );

                }
            );

        }



        /* =========================================================
           INDEX HOVER
        ========================================================== */

        if (
            hasGSAP &&
            !reduceMotion &&
            window.matchMedia(
                '(hover:hover) and (pointer:fine)'
            ).matches
        ) {

            indexButtons.forEach(
                function (
                    button
                ) {

                    const copy =
                        button.querySelector(
                            '.bd-index-copy'
                        );


                    button.addEventListener(
                        'mouseenter',
                        function () {

                            if (
                                button.classList.contains(
                                    'is-active'
                                )
                            ) {

                                return;

                            }


                            gsap.to(
                                copy,
                                {

                                    x:
                                        3,

                                    duration:
                                        .18,

                                    ease:
                                        'power2.out'

                                }
                            );

                        }
                    );


                    button.addEventListener(
                        'mouseleave',
                        function () {

                            gsap.to(
                                copy,
                                {

                                    x:
                                        0,

                                    duration:
                                        .26,

                                    ease:
                                        'power3.out'

                                }
                            );

                        }
                    );

                }
            );

        }



        /* =========================================================
           BUTTON PRESS
        ========================================================== */

        if (
            hasGSAP &&
            !reduceMotion
        ) {

            [
                previousButton,
                nextButton
            ]
            .filter(Boolean)
            .forEach(
                function (
                    button
                ) {

                    button.addEventListener(
                        'pointerdown',
                        function () {

                            gsap.to(
                                button,
                                {

                                    scale:
                                        .92,

                                    duration:
                                        .07

                                }
                            );

                        }
                    );


                    button.addEventListener(
                        'pointerup',
                        function () {

                            gsap.to(
                                button,
                                {

                                    scale:
                                        1,

                                    duration:
                                        .18,

                                    ease:
                                        'power2.out'

                                }
                            );

                        }
                    );


                    button.addEventListener(
                        'pointerleave',
                        function () {

                            gsap.to(
                                button,
                                {

                                    scale:
                                        1,

                                    duration:
                                        .18

                                }
                            );

                        }
                    );

                }
            );

        }



        /* =========================================================
           INITIAL
        ========================================================== */

        updateUI();



        /* =========================================================
           REFRESH
        ========================================================== */

        if (
            hasScrollTrigger &&
            !reduceMotion
        ) {

            window.setTimeout(
                function () {

                    ScrollTrigger.refresh();

                },
                180
            );

        }

    }
);

</script>   