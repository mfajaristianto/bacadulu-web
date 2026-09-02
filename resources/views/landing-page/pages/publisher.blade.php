@extends('layouts.app')

@section('title', 'Baca Publisher - Baca Dulu')

@section('content')

@php
    $totalBooks = method_exists($books, 'total')
        ? $books->total() + ($featuredBook ? 1 : 0)
        : $books->count() + ($featuredBook ? 1 : 0);
@endphp


<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap');


/* =========================================================
   PAGE
========================================================= */

.bd-pub {
    --navy: #241B52;
    --orange: #EF5843;

    --ink: #17181C;
    --body: #5C626D;
    --muted: #969BA5;

    --line: #E6E8EC;
    --soft: #F6F7F8;
    --warm: #FAF8F5;

    width: 100%;
    min-height: 100vh;

    overflow: hidden;

    background: #FFFFFF;

    color: var(--ink);

    font-family: 'Inter', sans-serif;
}

.bd-pub *,
.bd-pub *::before,
.bd-pub *::after {
    box-sizing: border-box;
}

.bd-pub-shell {
    width: min(
        calc(100% - 72px),
        1360px
    );

    margin-inline: auto;
}


/* =========================================================
   HERO
========================================================= */

.bd-pub-hero {
    position: relative;

    padding:
        60px 0
        49px;

    border-bottom: 1px solid var(--line);

    overflow: hidden;
}

.bd-pub-hero::before {
    content: "";

    position: absolute;

    width: 310px;
    height: 310px;

    right: -120px;
    top: -150px;

    border: 1px solid rgba(36, 27, 82, .08);
    border-radius: 50%;
}

.bd-pub-hero-grid {
    position: relative;

    z-index: 2;

    display: grid;

    grid-template-columns:
        minmax(0, 1.22fr)
        minmax(310px, .78fr);

    gap: 75px;

    align-items: end;
}

.bd-pub-kicker {
    display: flex;
    align-items: center;

    gap: 9px;

    margin-bottom: 13px;

    color: var(--orange);

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .14em;

    text-transform: uppercase;
}

.bd-pub-kicker::before {
    content: "";

    width: 26px;
    height: 2px;

    background: var(--orange);
}

.bd-pub-hero-title {
    max-width: 840px;

    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        44px,
        5.5vw,
        76px
    );

    font-weight: 600;

    line-height: 1.02;

    letter-spacing: -.055em;
}

.bd-pub-hero-title span {
    color: var(--orange);
}

.bd-pub-hero-description {
    max-width: 410px;

    margin: 0;

    color: var(--body);

    font-size: 13px;

    line-height: 1.8;
}

.bd-pub-hero-action {
    min-height: 44px;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    margin-top: 20px;

    color: var(--navy) !important;

    font-size: 11px;
    font-weight: 750;

    text-decoration: none !important;
}

.bd-pub-hero-action:hover {
    color: var(--orange) !important;
}

.bd-pub-hero-action svg {
    width: 15px;
    height: 15px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}

.bd-pub-summary {
    display: flex;
    align-items: baseline;

    gap: 7px;

    margin-top: 20px;
}

.bd-pub-summary strong {
    color: var(--orange);

    font-family: 'Poppins', sans-serif;

    font-size: 22px;
    font-weight: 600;
}

.bd-pub-summary span {
    color: var(--muted);

    font-size: 9px;
    font-weight: 700;

    letter-spacing: .06em;

    text-transform: uppercase;
}


/* =========================================================
   SECTION
========================================================= */

.bd-pub-section {
    padding:
        46px 0;
}

.bd-pub-section + .bd-pub-section {
    border-top: 1px solid var(--line);
}

.bd-pub-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 30px;

    margin-bottom: 26px;
}

.bd-pub-section-label {
    margin-bottom: 7px;

    color: var(--orange);

    font-size: 8px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-pub-section-title {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        27px,
        3vw,
        41px
    );

    font-weight: 600;

    line-height: 1.15;

    letter-spacing: -.04em;
}

.bd-pub-section-count {
    color: var(--muted);

    font-size: 9px;
    font-weight: 650;

    text-transform: uppercase;

    letter-spacing: .06em;
}


/* =========================================================
   FEATURED BOOK
========================================================= */

.bd-pub-featured {
    display: grid;

    grid-template-columns:
        minmax(300px, .72fr)
        minmax(0, 1.28fr);

    gap: 50px;

    align-items: center;

    padding:
        30px 0
        8px;
}

.bd-pub-featured-cover-wrap {
    display: flex;
    justify-content: center;

    min-width: 0;
}

.bd-pub-featured-cover {
    position: relative;

    width: min(
        100%,
        345px
    );

    aspect-ratio: 3 / 4.25;

    overflow: hidden;

    background: var(--soft);

    box-shadow:
        0 20px 45px
        rgba(36, 27, 82, .10);
}

.bd-pub-featured-cover img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transition:
        transform .75s
        cubic-bezier(.22,1,.36,1);
}

.bd-pub-featured:hover
.bd-pub-featured-cover img {
    transform: scale(1.035);
}

.bd-pub-cover-placeholder {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-direction: column;

    gap: 10px;

    background:
        linear-gradient(
            145deg,
            var(--navy),
            #17132E
        );

    color: #FFFFFF;
}

.bd-pub-cover-placeholder span:first-child {
    width: 9px;
    height: 9px;

    background: var(--orange);
}

.bd-pub-cover-placeholder span:last-child {
    font-size: 9px;
    font-weight: 750;

    letter-spacing: .08em;

    text-transform: uppercase;
}

.bd-pub-featured-content {
    max-width: 760px;
}

.bd-pub-featured-tag {
    display: flex;
    align-items: center;

    gap: 8px;

    margin-bottom: 13px;

    color: var(--orange);

    font-size: 8px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-pub-featured-tag::before {
    content: "";

    width: 20px;
    height: 2px;

    background: var(--orange);
}

.bd-pub-featured-title {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        31px,
        4vw,
        53px
    );

    font-weight: 600;

    line-height: 1.08;

    letter-spacing: -.05em;

    overflow-wrap: anywhere;
}

.bd-pub-featured-author {
    margin-top: 12px;

    color: #494F59;

    font-size: 12px;
    font-weight: 650;
}

.bd-pub-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 8px;

    margin-top: 17px;
}

.bd-pub-meta-item {
    color: var(--muted);

    font-size: 9px;
    font-weight: 650;
}

.bd-pub-meta-separator {
    width: 3px;
    height: 3px;

    border-radius: 50%;

    background: #C8CBD0;
}

.bd-pub-status {
    display: inline-flex;
    align-items: center;

    gap: 6px;

    color: #338257;

    font-size: 9px;
    font-weight: 750;
}

.bd-pub-status::before {
    content: "";

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #44A36D;
}

.bd-pub-featured-description {
    max-width: 700px;

    margin-top: 20px;

    color: var(--body);

    font-size: 13px;

    line-height: 1.8;
}

.bd-pub-detail-link {
    min-height: 42px;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    margin-top: 21px;

    color: var(--navy) !important;

    font-size: 11px;
    font-weight: 750;

    text-decoration: none !important;

    transition:
        gap .25s ease,
        color .25s ease;
}

.bd-pub-detail-link:hover {
    gap: 12px;

    color: var(--orange) !important;
}

.bd-pub-detail-link svg {
    width: 16px;
    height: 16px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}


/* =========================================================
   BOOK GRID
========================================================= */

.bd-pub-books {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    border-top: 1px solid var(--line);
}

.bd-pub-book {
    min-width: 0;

    padding:
        25px 21px
        27px 0;

    border-bottom: 1px solid var(--line);
}

.bd-pub-book:not(:nth-child(4n)) {
    margin-right: 21px;

    border-right: 1px solid var(--line);
}

.bd-pub-book-cover {
    width: 100%;

    aspect-ratio: 3 / 4.15;

    overflow: hidden;

    background: var(--soft);
}

.bd-pub-book-cover img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transition:
        transform .7s
        cubic-bezier(.22,1,.36,1);
}

.bd-pub-book:hover
.bd-pub-book-cover img {
    transform: scale(1.045);
}

.bd-pub-book-content {
    padding-top: 16px;
}

.bd-pub-book-category {
    color: var(--orange);

    font-size: 8px;
    font-weight: 750;

    letter-spacing: .07em;

    text-transform: uppercase;
}

.bd-pub-book-title {
    margin:
        7px 0
        0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 16px;
    font-weight: 600;

    line-height: 1.35;

    letter-spacing: -.025em;

    overflow-wrap: anywhere;
}

.bd-pub-book-author {
    margin-top: 7px;

    color: var(--body);

    font-size: 10px;

    line-height: 1.5;
}

.bd-pub-book-details {
    margin-top: 12px;

    padding-top: 11px;

    border-top: 1px solid var(--line);
}

.bd-pub-book-detail-row {
    display: flex;
    justify-content: space-between;

    gap: 12px;

    padding:
        3px 0;

    font-size: 9px;
}

.bd-pub-book-detail-label {
    color: var(--muted);
}

.bd-pub-book-detail-value {
    max-width: 65%;

    color: #555B65;

    font-weight: 650;

    text-align: right;

    overflow-wrap: anywhere;
}

.bd-pub-book-link {
    display: inline-flex;
    align-items: center;

    gap: 7px;

    margin-top: 13px;

    color: var(--navy) !important;

    font-size: 9px;
    font-weight: 750;

    text-decoration: none !important;
}

.bd-pub-book-link:hover {
    color: var(--orange) !important;
}

.bd-pub-book-link svg {
    width: 13px;
    height: 13px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}


/* =========================================================
   PROCESS
========================================================= */

.bd-pub-process {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    border-top: 1px solid var(--line);
}

.bd-pub-process-item {
    position: relative;

    min-height: 170px;

    padding:
        22px 22px
        20px 0;

    border-bottom: 1px solid var(--line);
}

.bd-pub-process-item:not(:last-child) {
    margin-right: 22px;

    border-right: 1px solid var(--line);
}

.bd-pub-process-number {
    margin-bottom: 28px;

    color: #C0C3C8;

    font-family: 'Poppins', sans-serif;

    font-size: 10px;
    font-weight: 600;
}

.bd-pub-process-title {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 15px;
    font-weight: 600;
}

.bd-pub-process-text {
    max-width: 220px;

    margin:
        7px 0
        0;

    color: var(--body);

    font-size: 10px;

    line-height: 1.65;
}


/* =========================================================
   PARTNERS
========================================================= */

.bd-pub-partners {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    border-top: 1px solid var(--line);
}

.bd-pub-partner {
    display: flex;
    align-items: center;

    gap: 15px;

    min-height: 110px;

    padding:
        16px 20px
        16px 0;

    border-bottom: 1px solid var(--line);
}

.bd-pub-partner:not(:nth-child(3n)) {
    margin-right: 20px;

    border-right: 1px solid var(--line);
}

.bd-pub-partner-logo {
    width: 66px;
    height: 66px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    padding: 8px;

    background: var(--soft);
}

.bd-pub-partner-logo img {
    width: 100%;
    height: 100%;

    object-fit: contain;
}

.bd-pub-partner-placeholder {
    width: 7px;
    height: 7px;

    background: var(--orange);
}

.bd-pub-partner-name {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 12px;
    font-weight: 600;

    line-height: 1.4;
}

.bd-pub-partner-description {
    margin-top: 4px;

    color: var(--muted);

    font-size: 9px;

    line-height: 1.5;

    display: -webkit-box;

    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;

    overflow: hidden;
}


/* =========================================================
   EMPTY
========================================================= */

.bd-pub-empty {
    padding:
        65px 20px;

    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);

    text-align: center;
}

.bd-pub-empty-mark {
    width: 9px;
    height: 9px;

    margin:
        0 auto
        13px;

    background: var(--orange);
}

.bd-pub-empty h3 {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 19px;
    font-weight: 600;
}

.bd-pub-empty p {
    margin:
        6px 0
        0;

    color: var(--muted);

    font-size: 11px;
}


/* =========================================================
   PAGINATION
========================================================= */

.bd-pub-pagination {
    display: flex;
    justify-content: center;

    margin-top: 34px;
}

.bd-pub-pagination .pagination {
    display: flex;
    flex-wrap: wrap;

    gap: 7px;

    margin: 0;
}

.bd-pub-pagination .page-link {
    min-width: 39px;
    height: 39px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid var(--line);
    border-radius: 50% !important;

    background: #FFFFFF;

    color: #555B65;

    font-size: 10px;

    box-shadow: none !important;
}

.bd-pub-pagination
.page-item.active
.page-link {
    border-color: var(--navy);

    background: var(--navy);

    color: #FFFFFF;
}


/* =========================================================
   REVEAL
========================================================= */

.bd-pub-reveal {
    opacity: 0;

    transform: translateY(15px);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1050px) {

    .bd-pub-books {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

    .bd-pub-book:not(:nth-child(4n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-pub-book:not(:nth-child(3n)) {
        margin-right: 20px;

        border-right: 1px solid var(--line);
    }

}


@media (max-width: 800px) {

    .bd-pub-shell {
        width:
            calc(100% - 40px);
    }

    .bd-pub-hero-grid {
        grid-template-columns: 1fr;

        gap: 22px;
    }

    .bd-pub-featured {
        grid-template-columns:
            260px
            minmax(0, 1fr);

        gap: 30px;
    }

    .bd-pub-books {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-pub-book:not(:nth-child(3n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-pub-book:not(:nth-child(2n)) {
        margin-right: 20px;

        border-right: 1px solid var(--line);
    }

    .bd-pub-process {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-pub-partners {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-pub-partner:not(:nth-child(3n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-pub-partner:not(:nth-child(2n)) {
        margin-right: 20px;

        border-right: 1px solid var(--line);
    }

}


@media (max-width: 640px) {

    .bd-pub-shell {
        width:
            calc(100% - 30px);
    }

    .bd-pub-hero {
        padding:
            31px 0
            36px;
    }

    .bd-pub-hero-title {
        font-size: 39px;
    }

    .bd-pub-hero-description {
        font-size: 11px;
    }

    .bd-pub-section {
        padding:
            35px 0;
    }

    .bd-pub-section-head {
        align-items: flex-start;
        flex-direction: column;

        gap: 8px;
    }


    /* FEATURED */

    .bd-pub-featured {
        grid-template-columns: 1fr;

        gap: 24px;
    }

    .bd-pub-featured-cover {
        width: min(
            75%,
            290px
        );
    }

    .bd-pub-featured-title {
        font-size: 29px;
    }

    .bd-pub-featured-description {
        font-size: 11px;
    }


    /* GRID */

    .bd-pub-books {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-pub-book,
    .bd-pub-book:not(:nth-child(2n)) {
        margin-right: 0;

        padding:
            19px 8px
            21px 0;

        border-right: 0;
    }

    .bd-pub-book:nth-child(odd) {
        margin-right: 11px;

        border-right: 1px solid var(--line);
    }

    .bd-pub-book-title {
        font-size: 13px;
    }

    .bd-pub-book-details {
        display: none;
    }


    /* PROCESS */

    .bd-pub-process {
        grid-template-columns: 1fr;
    }

    .bd-pub-process-item,
    .bd-pub-process-item:not(:last-child) {
        min-height: 0;

        margin: 0;

        padding:
            20px 0;

        border-right: 0;
    }

    .bd-pub-process-number {
        margin-bottom: 13px;
    }


    /* PARTNERS */

    .bd-pub-partners {
        grid-template-columns: 1fr;
    }

    .bd-pub-partner,
    .bd-pub-partner:not(:nth-child(2n)) {
        margin: 0;

        border-right: 0;
    }

}


@media (prefers-reduced-motion: reduce) {

    .bd-pub-reveal {
        opacity: 1 !important;

        transform: none !important;
    }

}
</style>



<div
    class="bd-pub"
    id="bdPublisherPage"
>


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="bd-pub-hero">

        <div class="bd-pub-shell">

            <div class="bd-pub-hero-grid">


                <div class="bd-pub-reveal">

                    <div class="bd-pub-kicker">
                        Baca Publisher
                    </div>


                    <h1 class="bd-pub-hero-title">

                        Karya yang kami
                        terbitkan,
                        <span>untuk dibaca lebih jauh.</span>

                    </h1>

                </div>



                <div class="bd-pub-reveal">

                    <p class="bd-pub-hero-description">

                        Jelajahi buku yang telah diterbitkan
                        melalui BacaDulu Publisher. Setiap karya
                        menjadi bagian dari perjalanan gagasan
                        penulis menuju pembacanya.

                    </p>


                    <a
                        href="#terbitan"
                        class="bd-pub-hero-action"
                    >

                        Lihat Terbitan

                        <svg viewBox="0 0 24 24">

                            <path d="M12 5v14"/>

                            <path d="m7 14 5 5 5-5"/>

                        </svg>

                    </a>


                    <div class="bd-pub-summary">

                        <strong>
                            {{ $totalBooks }}
                        </strong>

                        <span>
                            Karya diterbitkan
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         FEATURED BOOK
    ====================================================== --}}

    <section
        class="bd-pub-section"
        id="terbitan"
    >

        <div class="bd-pub-shell">


            <div
                class="
                    bd-pub-section-head
                    bd-pub-reveal
                "
            >

                <div>

                    <div class="bd-pub-section-label">
                        Portfolio Penerbitan
                    </div>


                    <h2 class="bd-pub-section-title">
                        Terbitan pilihan
                    </h2>

                </div>


                <div class="bd-pub-section-count">

                    {{ $totalBooks }}
                    buku diterbitkan

                </div>

            </div>



            @if($featuredBook)

                <article
                    class="
                        bd-pub-featured
                        bd-pub-reveal
                    "
                >


                    {{-- COVER --}}

                    <div class="bd-pub-featured-cover-wrap">

                        <div class="bd-pub-featured-cover">

                            @if(!empty($featuredBook->cover))

                                <img
                                    src="{{ asset('storage/' . $featuredBook->cover) }}"
                                    alt="{{ $featuredBook->title }}"
                                >

                            @else

                                <div class="bd-pub-cover-placeholder">

                                    <span></span>

                                    <span>
                                        Baca Publisher
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>



                    {{-- CONTENT --}}

                    <div class="bd-pub-featured-content">

                        <div class="bd-pub-featured-tag">
                            Terbitan Terbaru
                        </div>


                        <h3 class="bd-pub-featured-title">

                            {{ $featuredBook->title }}

                        </h3>


                        @if(!empty($featuredBook->author))

                            <div class="bd-pub-featured-author">

                                {{ $featuredBook->author }}

                            </div>

                        @endif



                        <div class="bd-pub-meta">


                            @if(!empty($featuredBook->publish_year))

                                <span class="bd-pub-meta-item">

                                    {{ $featuredBook->publish_year }}

                                </span>

                            @endif


                            @if(
                                !empty($featuredBook->publish_year)
                                &&
                                !empty($featuredBook->category)
                            )

                                <span class="bd-pub-meta-separator"></span>

                            @endif


                            @if(!empty($featuredBook->category))

                                <span class="bd-pub-meta-item">

                                    {{ $featuredBook->category }}

                                </span>

                            @endif


                            @if(
                                (
                                    !empty($featuredBook->publish_year)
                                    ||
                                    !empty($featuredBook->category)
                                )
                                &&
                                !empty($featuredBook->isbn)
                            )

                                <span class="bd-pub-meta-separator"></span>

                            @endif


                            @if(!empty($featuredBook->isbn))

                                <span class="bd-pub-meta-item">

                                    ISBN
                                    {{ $featuredBook->isbn }}

                                </span>

                            @endif


                            <span class="bd-pub-meta-separator"></span>


                            <span class="bd-pub-status">

                                Sudah Terbit

                            </span>

                        </div>



                        @if(!empty($featuredBook->description))

                            <div class="bd-pub-featured-description">

                                {{
                                    \Illuminate\Support\Str::limit(
                                        trim(
                                            preg_replace(
                                                '/\s+/u',
                                                ' ',
                                                strip_tags(
                                                    $featuredBook->description
                                                )
                                            )
                                        ),
                                        420
                                    )
                                }}

                            </div>

                        @endif



                        <a
                            href="{{ route('publisher.books.show', $featuredBook) }}"
                            class="bd-pub-detail-link"
                        >

                            Lihat Detail Buku

                            <svg viewBox="0 0 24 24">

                                <path d="M5 12h14"/>

                                <path d="m14 7 5 5-5 5"/>

                            </svg>

                        </a>

                    </div>

                </article>


            @else

                <div class="bd-pub-empty">

                    <div class="bd-pub-empty-mark"></div>

                    <h3>
                        Belum ada buku diterbitkan
                    </h3>

                    <p>
                        Terbitan Baca Publisher akan ditampilkan di sini.
                    </p>

                </div>

            @endif

        </div>

    </section>



    {{-- =====================================================
         ALL PUBLICATIONS
    ====================================================== --}}

    @if($books->count())

        <section class="bd-pub-section">

            <div class="bd-pub-shell">


                <div
                    class="
                        bd-pub-section-head
                        bd-pub-reveal
                    "
                >

                    <div>

                        <div class="bd-pub-section-label">
                            Koleksi
                        </div>


                        <h2 class="bd-pub-section-title">

                            Semua terbitan

                        </h2>

                    </div>

                </div>



                <div class="bd-pub-books">

                    @foreach($books as $book)

                        <article
                            class="
                                bd-pub-book
                                bd-pub-reveal
                            "
                        >


                            {{-- COVER --}}

                            <div class="bd-pub-book-cover">

                                @if(!empty($book->cover))

                                    <img
                                        src="{{ asset('storage/' . $book->cover) }}"
                                        alt="{{ $book->title }}"
                                        loading="lazy"
                                    >

                                @else

                                    <div class="bd-pub-cover-placeholder">

                                        <span></span>

                                        <span>
                                            Baca Publisher
                                        </span>

                                    </div>

                                @endif

                            </div>



                            <div class="bd-pub-book-content">


                                @if(!empty($book->category))

                                    <div class="bd-pub-book-category">

                                        {{ $book->category }}

                                    </div>

                                @endif


                                <h3 class="bd-pub-book-title">

                                    {{ $book->title }}

                                </h3>


                                @if(!empty($book->author))

                                    <div class="bd-pub-book-author">

                                        {{ $book->author }}

                                    </div>

                                @endif



                                <div class="bd-pub-book-details">


                                    <div class="bd-pub-book-detail-row">

                                        <span class="bd-pub-book-detail-label">
                                            Tahun
                                        </span>

                                        <span class="bd-pub-book-detail-value">

                                            {{ $book->publish_year ?: '-' }}

                                        </span>

                                    </div>


                                    <div class="bd-pub-book-detail-row">

                                        <span class="bd-pub-book-detail-label">
                                            ISBN
                                        </span>

                                        <span class="bd-pub-book-detail-value">

                                            {{ $book->isbn ?: '-' }}

                                        </span>

                                    </div>


                                    <div class="bd-pub-book-detail-row">

                                        <span class="bd-pub-book-detail-label">
                                            Status
                                        </span>

                                        <span class="bd-pub-book-detail-value">

                                            Sudah Terbit

                                        </span>

                                    </div>

                                </div>



                                <a
                                    href="{{ route('publisher.books.show', $book) }}"
                                    class="bd-pub-book-link"
                                >

                                    Lihat Detail

                                    <svg viewBox="0 0 24 24">

                                        <path d="M5 12h14"/>

                                        <path d="m14 7 5 5-5 5"/>

                                    </svg>

                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>



                @if($books->hasPages())

                    <div class="bd-pub-pagination">

                        {{
                            $books
                                ->onEachSide(1)
                                ->links('pagination::bootstrap-5')
                        }}

                    </div>

                @endif

            </div>

        </section>

    @endif



    {{-- =====================================================
         PROCESS
    ====================================================== --}}

    <section class="bd-pub-section">

        <div class="bd-pub-shell">


            <div
                class="
                    bd-pub-section-head
                    bd-pub-reveal
                "
            >

                <div>

                    <div class="bd-pub-section-label">
                        Di balik setiap buku
                    </div>


                    <h2 class="bd-pub-section-title">

                        Dari naskah
                        hingga terbit.

                    </h2>

                </div>

            </div>



            <div class="bd-pub-process">


                <div class="bd-pub-process-item bd-pub-reveal">

                    <div class="bd-pub-process-number">
                        01
                    </div>

                    <h3 class="bd-pub-process-title">
                        Pengajuan Naskah
                    </h3>

                    <p class="bd-pub-process-text">

                        Naskah dikirim untuk
                        dipelajari dan ditinjau
                        kelayakan penerbitannya.

                    </p>

                </div>


                <div class="bd-pub-process-item bd-pub-reveal">

                    <div class="bd-pub-process-number">
                        02
                    </div>

                    <h3 class="bd-pub-process-title">
                        Editorial
                    </h3>

                    <p class="bd-pub-process-text">

                        Naskah memasuki proses
                        penyuntingan dan penyempurnaan.

                    </p>

                </div>


                <div class="bd-pub-process-item bd-pub-reveal">

                    <div class="bd-pub-process-number">
                        03
                    </div>

                    <h3 class="bd-pub-process-title">
                        Produksi
                    </h3>

                    <p class="bd-pub-process-text">

                        Tata letak, desain sampul,
                        dan kelengkapan penerbitan
                        dipersiapkan.

                    </p>

                </div>


                <div class="bd-pub-process-item bd-pub-reveal">

                    <div class="bd-pub-process-number">
                        04
                    </div>

                    <h3 class="bd-pub-process-title">
                        Terbit
                    </h3>

                    <p class="bd-pub-process-text">

                        Buku selesai dan menjadi
                        bagian dari portfolio
                        Baca Publisher.

                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         PARTNERS
    ====================================================== --}}

    @if($publishers->count())

        <section class="bd-pub-section">

            <div class="bd-pub-shell">


                <div
                    class="
                        bd-pub-section-head
                        bd-pub-reveal
                    "
                >

                    <div>

                        <div class="bd-pub-section-label">
                            Kolaborasi
                        </div>


                        <h2 class="bd-pub-section-title">
                            Mitra penerbitan
                        </h2>

                    </div>


                    <div class="bd-pub-section-count">

                        {{ $publishers->count() }}
                        mitra

                    </div>

                </div>



                <div class="bd-pub-partners">

                    @foreach($publishers as $publisher)

                        <article
                            class="
                                bd-pub-partner
                                bd-pub-reveal
                            "
                        >


                            <div class="bd-pub-partner-logo">

                                @if(!empty($publisher->logo))

                                    <img
                                        src="{{ asset('storage/' . $publisher->logo) }}"
                                        alt="{{ $publisher->name ?? $publisher->title ?? 'Publisher' }}"
                                    >

                                @elseif(!empty($publisher->image))

                                    <img
                                        src="{{ asset('storage/' . $publisher->image) }}"
                                        alt="{{ $publisher->name ?? $publisher->title ?? 'Publisher' }}"
                                    >

                                @else

                                    <span class="bd-pub-partner-placeholder"></span>

                                @endif

                            </div>


                            <div>

                                <h3 class="bd-pub-partner-name">

                                    {{
                                        $publisher->name
                                        ??
                                        $publisher->title
                                        ??
                                        'Publisher'
                                    }}

                                </h3>


                                @if(!empty($publisher->description))

                                    <div class="bd-pub-partner-description">

                                        {{
                                            \Illuminate\Support\Str::limit(
                                                strip_tags(
                                                    $publisher->description
                                                ),
                                                100
                                            )
                                        }}

                                    </div>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</div>



<script>
(() => {

    const initPublisher = () => {

        const page =
            document.getElementById(
                'bdPublisherPage'
            );


        if (!page) {
            return;
        }


        const gsap =
            window.bdGsap || null;


        const reducedMotion =
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;



        if (
            gsap &&
            !reducedMotion
        ) {

            gsap.to(
                page.querySelectorAll(
                    '.bd-pub-reveal'
                ),
                {
                    opacity: 1,

                    y: 0,

                    duration: .62,

                    stagger: .035,

                    ease: 'power3.out'
                }
            );

        } else {

            page
                .querySelectorAll(
                    '.bd-pub-reveal'
                )
                .forEach(element => {

                    element.style.opacity = '1';

                    element.style.transform = 'none';

                });

        }



        const publicationLink =
            page.querySelector(
                'a[href="#terbitan"]'
            );


        const publicationSection =
            document.getElementById(
                'terbitan'
            );


        if (
            publicationLink &&
            publicationSection
        ) {

            publicationLink.addEventListener(
                'click',
                event => {

                    event.preventDefault();


                    publicationSection.scrollIntoView({
                        behavior:
                            reducedMotion
                                ? 'auto'
                                : 'smooth',

                        block: 'start'
                    });

                }
            );

        }

    };


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initPublisher,
            {
                once: true
            }
        );

    } else {

        initPublisher();

    }

})();
</script>

@endsection