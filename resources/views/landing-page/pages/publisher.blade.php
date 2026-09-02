@extends('layouts.app')

@section('title', 'Baca Publisher - Baca Dulu')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | TOTAL BOOKS
    |--------------------------------------------------------------------------
    */

    $totalBooks = method_exists($books, 'total')
        ? $books->total() + ($featuredBook ? 1 : 0)
        : $books->count() + ($featuredBook ? 1 : 0);


    /*
    |--------------------------------------------------------------------------
    | STORAGE ASSET RESOLVER
    |--------------------------------------------------------------------------
    |
    | Ini sengaja dibuat fleksibel supaya logo publisher tetap muncul
    | walaupun path di database pernah tersimpan dalam format berbeda.
    |
    */

    $resolveStorageAsset = function ($path) {

        if (empty($path)) {
            return null;
        }

        $path = trim(
            str_replace(
                '\\',
                '/',
                $path
            )
        );

        if (
            \Illuminate\Support\Str::startsWith(
                $path,
                [
                    'http://',
                    'https://',
                    '//',
                ]
            )
        ) {
            return $path;
        }

        $path = ltrim(
            $path,
            '/'
        );

        if (
            \Illuminate\Support\Str::startsWith(
                $path,
                'public/'
            )
        ) {
            $path = substr(
                $path,
                strlen('public/')
            );
        }

        if (
            \Illuminate\Support\Str::startsWith(
                $path,
                'storage/'
            )
        ) {
            $path = substr(
                $path,
                strlen('storage/')
            );
        }

        return asset(
            'storage/' . $path
        );
    };


    /*
    |--------------------------------------------------------------------------
    | HERO BOOKS
    |--------------------------------------------------------------------------
    */

    $heroBooks = collect();

    if ($featuredBook) {
        $heroBooks->push(
            $featuredBook
        );
    }

    foreach ($books->take(2) as $heroBook) {

        $heroBooks->push(
            $heroBook
        );

    }
@endphp


<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap');


/* =========================================================
   ROOT
========================================================= */

.bd-publisher {
    --navy: #241B52;
    --navy-deep: #17132E;

    --orange: #EF5843;
    --orange-soft: #FFF1ED;

    --ink: #17181C;
    --body: #595F69;
    --muted: #9197A1;

    --line: #E7E8EC;
    --soft: #F7F7F5;
    --warm: #FAF8F4;

    width: 100%;

    min-height: 100vh;

    overflow: hidden;

    background: #FFFFFF;

    color: var(--ink);

    font-family: 'Inter', sans-serif;
}

.bd-publisher *,
.bd-publisher *::before,
.bd-publisher *::after {
    box-sizing: border-box;
}

.bd-publisher-shell {
    width: min(
        calc(100% - 72px),
        1360px
    );

    margin-inline: auto;
}


/* =========================================================
   HERO
========================================================= */

.bd-publisher-hero {
    position: relative;

    min-height: 590px;

    display: flex;
    align-items: center;

    padding:
        55px 0;

    overflow: hidden;

    border-bottom: 1px solid var(--line);

    background: #FFFFFF;
}

.bd-publisher-hero::before {
    content: "";

    position: absolute;

    top: -220px;
    right: -170px;

    width: 510px;
    height: 510px;

    border: 1px solid rgba(36,27,82,.07);
    border-radius: 50%;

    pointer-events: none;
}

.bd-publisher-hero::after {
    content: "";

    position: absolute;

    right: 11%;
    bottom: -100px;

    width: 230px;
    height: 230px;

    border: 1px solid rgba(239,88,67,.09);
    border-radius: 50%;

    pointer-events: none;
}

.bd-publisher-hero-grid {
    position: relative;

    z-index: 3;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        560px;

    gap: 65px;

    align-items: center;
}


/* =========================================================
   HERO COPY
========================================================= */

.bd-publisher-eyebrow {
    display: flex;
    align-items: center;

    gap: 9px;

    margin-bottom: 16px;

    color: var(--orange);

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .15em;

    text-transform: uppercase;
}

.bd-publisher-eyebrow::before {
    content: "";

    width: 27px;
    height: 2px;

    background: var(--orange);
}

.bd-publisher-hero-title {
    max-width: 700px;

    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        45px,
        5.4vw,
        74px
    );

    font-weight: 600;

    line-height: 1.02;

    letter-spacing: -.055em;
}

.bd-publisher-hero-title span {
    color: var(--orange);
}

.bd-publisher-hero-description {
    max-width: 555px;

    margin:
        22px 0
        0;

    color: var(--body);

    font-size: 13px;

    line-height: 1.8;
}

.bd-publisher-hero-bottom {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 24px;

    margin-top: 27px;
}

.bd-publisher-scroll-link {
    min-height: 44px;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    padding:
        0 17px;

    border: 1px solid var(--navy);

    background: var(--navy);

    color: #FFFFFF !important;

    font-size: 10px;
    font-weight: 750;

    text-decoration: none !important;

    transition:
        transform .25s ease,
        background .25s ease;
}

.bd-publisher-scroll-link:hover {
    transform: translateY(-2px);

    background: var(--orange);

    border-color: var(--orange);
}

.bd-publisher-scroll-link svg {
    width: 14px;
    height: 14px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}

.bd-publisher-count {
    display: flex;
    align-items: baseline;

    gap: 7px;
}

.bd-publisher-count strong {
    color: var(--orange);

    font-family: 'Poppins', sans-serif;

    font-size: 24px;
    font-weight: 600;
}

.bd-publisher-count span {
    color: var(--muted);

    font-size: 8px;
    font-weight: 750;

    letter-spacing: .07em;

    text-transform: uppercase;
}


/* =========================================================
   HERO BOOK COMPOSITION
========================================================= */

.bd-publisher-hero-books {
    position: relative;

    width: 560px;
    height: 450px;

    margin-left: auto;
}

.bd-publisher-hero-book {
    position: absolute;

    overflow: hidden;

    background: var(--soft);

    box-shadow:
        0 18px 45px
        rgba(36,27,82,.12);

    transition:
        transform .6s
        cubic-bezier(.22,1,.36,1);
}

.bd-publisher-hero-book img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}

.bd-publisher-hero-book:nth-child(1) {
    z-index: 4;

    width: 250px;
    height: 360px;

    left: 156px;
    top: 35px;

    transform: rotate(-1deg);
}

.bd-publisher-hero-book:nth-child(2) {
    z-index: 2;

    width: 190px;
    height: 285px;

    left: 20px;
    top: 104px;

    transform: rotate(-7deg);
}

.bd-publisher-hero-book:nth-child(3) {
    z-index: 1;

    width: 190px;
    height: 285px;

    right: 9px;
    top: 91px;

    transform: rotate(7deg);
}

.bd-publisher-hero-books:hover
.bd-publisher-hero-book:nth-child(1) {
    transform:
        translateY(-8px)
        rotate(0);
}

.bd-publisher-hero-books:hover
.bd-publisher-hero-book:nth-child(2) {
    transform:
        translate(-8px, 3px)
        rotate(-9deg);
}

.bd-publisher-hero-books:hover
.bd-publisher-hero-book:nth-child(3) {
    transform:
        translate(8px, 3px)
        rotate(9deg);
}

.bd-publisher-cover-fallback {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-direction: column;

    gap: 11px;

    padding: 20px;

    background:
        linear-gradient(
            145deg,
            var(--navy),
            var(--navy-deep)
        );

    color: #FFFFFF;

    text-align: center;
}

.bd-publisher-cover-fallback::before {
    content: "";

    width: 9px;
    height: 9px;

    background: var(--orange);
}

.bd-publisher-cover-fallback span {
    max-width: 130px;

    font-size: 9px;
    font-weight: 700;

    line-height: 1.5;
}


/* =========================================================
   SECTION COMMON
========================================================= */

.bd-publisher-section {
    padding:
        49px 0;
}

.bd-publisher-section + .bd-publisher-section {
    border-top: 1px solid var(--line);
}

.bd-publisher-section-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;

    gap: 30px;

    margin-bottom: 27px;
}

.bd-publisher-section-label {
    margin-bottom: 7px;

    color: var(--orange);

    font-size: 8px;
    font-weight: 800;

    letter-spacing: .14em;

    text-transform: uppercase;
}

.bd-publisher-section-title {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        28px,
        3vw,
        42px
    );

    font-weight: 600;

    line-height: 1.15;

    letter-spacing: -.04em;
}

.bd-publisher-section-description {
    max-width: 430px;

    margin: 0;

    color: var(--body);

    font-size: 11px;

    line-height: 1.7;
}


/* =========================================================
   FEATURED PUBLICATION
========================================================= */

.bd-publisher-featured {
    display: grid;

    grid-template-columns:
        390px
        minmax(0, 1fr);

    gap: 65px;

    align-items: center;

    padding:
        28px 0
        12px;
}

.bd-publisher-featured-cover-wrap {
    display: flex;
    justify-content: center;
}

.bd-publisher-featured-cover {
    position: relative;

    width: 320px;

    aspect-ratio: 3 / 4.2;

    overflow: hidden;

    background: var(--soft);

    box-shadow:
        0 22px 50px
        rgba(36,27,82,.11);
}

.bd-publisher-featured-cover img {
    position: relative;

    z-index: 2;

    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transition:
        transform .75s
        cubic-bezier(.22,1,.36,1);
}

.bd-publisher-featured:hover
.bd-publisher-featured-cover img {
    transform: scale(1.035);
}

.bd-publisher-featured-content {
    max-width: 730px;
}

.bd-publisher-publication-kicker {
    display: flex;
    align-items: center;

    gap: 8px;

    margin-bottom: 12px;

    color: var(--orange);

    font-size: 8px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-publisher-publication-kicker::before {
    content: "";

    width: 20px;
    height: 2px;

    background: var(--orange);
}

.bd-publisher-featured-title {
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

.bd-publisher-featured-author {
    margin-top: 13px;

    color: #464C56;

    font-size: 12px;
    font-weight: 650;
}


/* =========================================================
   FEATURED META
========================================================= */

.bd-publisher-featured-meta {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    margin-top: 23px;

    border-top: 1px solid var(--line);
}

.bd-publisher-featured-meta-item {
    min-height: 67px;

    padding:
        13px 17px
        12px 0;

    border-bottom: 1px solid var(--line);
}

.bd-publisher-featured-meta-item:not(:nth-child(3n)) {
    margin-right: 17px;

    border-right: 1px solid var(--line);
}

.bd-publisher-meta-label {
    color: var(--muted);

    font-size: 7px;
    font-weight: 750;

    letter-spacing: .08em;

    text-transform: uppercase;
}

.bd-publisher-meta-value {
    margin-top: 6px;

    color: var(--navy);

    font-size: 10px;
    font-weight: 650;

    line-height: 1.45;

    overflow-wrap: anywhere;
}

.bd-publisher-status {
    color: #338258;
}

.bd-publisher-featured-description {
    max-width: 700px;

    margin-top: 19px;

    color: var(--body);

    font-size: 12px;

    line-height: 1.8;
}

.bd-publisher-detail {
    min-height: 41px;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    margin-top: 17px;

    color: var(--navy) !important;

    font-size: 10px;
    font-weight: 750;

    text-decoration: none !important;

    transition:
        gap .25s ease,
        color .25s ease;
}

.bd-publisher-detail:hover {
    gap: 12px;

    color: var(--orange) !important;
}

.bd-publisher-detail svg {
    width: 14px;
    height: 14px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}


/* =========================================================
   BOOK CATALOG
========================================================= */

.bd-publisher-book-grid {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    border-top: 1px solid var(--line);
}

.bd-publisher-book {
    min-width: 0;

    padding:
        26px 20px
        27px 0;

    border-bottom: 1px solid var(--line);
}

.bd-publisher-book:not(:nth-child(4n)) {
    margin-right: 20px;

    border-right: 1px solid var(--line);
}

.bd-publisher-book-cover {
    position: relative;

    width: 100%;

    aspect-ratio: 3 / 4.15;

    overflow: hidden;

    background: var(--soft);
}

.bd-publisher-book-cover img {
    position: relative;

    z-index: 2;

    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transition:
        transform .7s
        cubic-bezier(.22,1,.36,1);
}

.bd-publisher-book:hover
.bd-publisher-book-cover img {
    transform: scale(1.045);
}

.bd-publisher-book-content {
    padding-top: 15px;
}

.bd-publisher-book-category {
    color: var(--orange);

    font-size: 7px;
    font-weight: 800;

    letter-spacing: .08em;

    text-transform: uppercase;
}

.bd-publisher-book-title {
    margin:
        7px 0
        0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 15px;
    font-weight: 600;

    line-height: 1.35;

    letter-spacing: -.025em;
}

.bd-publisher-book-author {
    margin-top: 6px;

    color: var(--body);

    font-size: 9px;

    line-height: 1.5;
}

.bd-publisher-book-meta {
    margin-top: 12px;

    padding-top: 10px;

    border-top: 1px solid var(--line);
}

.bd-publisher-book-meta-row {
    display: flex;
    justify-content: space-between;

    gap: 11px;

    padding:
        3px 0;

    font-size: 8px;

    line-height: 1.45;
}

.bd-publisher-book-meta-label {
    color: var(--muted);
}

.bd-publisher-book-meta-value {
    max-width: 68%;

    color: #555B65;

    font-weight: 650;

    text-align: right;

    overflow-wrap: anywhere;
}

.bd-publisher-book-detail {
    display: inline-flex;
    align-items: center;

    gap: 7px;

    margin-top: 12px;

    color: var(--navy) !important;

    font-size: 9px;
    font-weight: 750;

    text-decoration: none !important;

    transition:
        color .25s ease,
        gap .25s ease;
}

.bd-publisher-book-detail:hover {
    gap: 10px;

    color: var(--orange) !important;
}

.bd-publisher-book-detail svg {
    width: 12px;
    height: 12px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}


/* =========================================================
   PUBLISHER PARTNERS
========================================================= */

.bd-publisher-partner-section {
    background: var(--warm);
}

.bd-publisher-partner-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    border-top:
        1px solid
        rgba(36,27,82,.10);
}

.bd-publisher-partner {
    min-width: 0;

    display: grid;

    grid-template-columns:
        95px
        minmax(0, 1fr);

    gap: 17px;

    align-items: center;

    min-height: 135px;

    padding:
        20px 20px
        20px 0;

    border-bottom:
        1px solid
        rgba(36,27,82,.10);
}

.bd-publisher-partner:not(:nth-child(3n)) {
    margin-right: 20px;

    border-right:
        1px solid
        rgba(36,27,82,.10);
}


/* =========================================================
   LOGO FIX
========================================================= */

.bd-publisher-partner-logo {
    position: relative;

    width: 95px;
    height: 80px;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    padding: 12px;

    background: #FFFFFF;

    border: 1px solid rgba(36,27,82,.08);

    isolation: isolate;
}

.bd-publisher-partner-logo-fallback {
    position: absolute;

    z-index: 1;

    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #FFFFFF;
}

.bd-publisher-partner-logo-fallback::before {
    content: "";

    width: 7px;
    height: 7px;

    background: var(--orange);
}

.bd-publisher-partner-logo img {
    position: relative;

    z-index: 2;

    display: block;

    max-width: 100%;
    max-height: 100%;

    width: auto;
    height: auto;

    object-fit: contain;
}

.bd-publisher-partner-name {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 13px;
    font-weight: 600;

    line-height: 1.4;
}

.bd-publisher-partner-description {
    margin-top: 5px;

    color: #727780;

    font-size: 9px;

    line-height: 1.55;

    display: -webkit-box;

    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;

    overflow: hidden;
}


/* =========================================================
   PROCESS — SMALL
========================================================= */

.bd-publisher-process {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    border-top: 1px solid var(--line);
}

.bd-publisher-process-item {
    position: relative;

    min-height: 145px;

    padding:
        20px 20px
        19px 0;

    border-bottom: 1px solid var(--line);
}

.bd-publisher-process-item:not(:last-child) {
    margin-right: 20px;

    border-right: 1px solid var(--line);
}

.bd-publisher-process-number {
    margin-bottom: 22px;

    color: #BEC2C8;

    font-family: 'Poppins', sans-serif;

    font-size: 9px;
    font-weight: 600;
}

.bd-publisher-process-title {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 14px;
    font-weight: 600;
}

.bd-publisher-process-text {
    max-width: 220px;

    margin-top: 6px;

    color: var(--body);

    font-size: 9px;

    line-height: 1.6;
}


/* =========================================================
   CTA
========================================================= */

.bd-publisher-cta {
    padding:
        48px 0;

    background: var(--navy);
}

.bd-publisher-cta-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        auto;

    gap: 40px;

    align-items: center;
}

.bd-publisher-cta-label {
    margin-bottom: 8px;

    color: #F1A291;

    font-size: 8px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-publisher-cta-title {
    max-width: 750px;

    margin: 0;

    color: #FFFFFF;

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        29px,
        3.6vw,
        48px
    );

    font-weight: 600;

    line-height: 1.1;

    letter-spacing: -.045em;
}

.bd-publisher-cta-link {
    min-height: 47px;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    padding:
        0 19px;

    background: var(--orange);

    color: #FFFFFF !important;

    font-size: 10px;
    font-weight: 750;

    text-decoration: none !important;
}


/* =========================================================
   EMPTY
========================================================= */

.bd-publisher-empty {
    padding:
        65px 20px;

    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);

    text-align: center;
}

.bd-publisher-empty::before {
    content: "";

    display: block;

    width: 9px;
    height: 9px;

    margin:
        0 auto
        13px;

    background: var(--orange);
}

.bd-publisher-empty h3 {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 18px;
    font-weight: 600;
}

.bd-publisher-empty p {
    margin:
        6px 0
        0;

    color: var(--muted);

    font-size: 10px;
}


/* =========================================================
   PAGINATION
========================================================= */

.bd-publisher-pagination {
    display: flex;
    justify-content: center;

    margin-top: 34px;
}

.bd-publisher-pagination .pagination {
    display: flex;
    flex-wrap: wrap;

    gap: 7px;

    margin: 0;
}

.bd-publisher-pagination .page-link {
    min-width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding:
        0 10px;

    border: 1px solid var(--line);
    border-radius: 50% !important;

    background: #FFFFFF;

    color: #555B65;

    font-size: 10px;

    box-shadow: none !important;
}

.bd-publisher-pagination
.page-item.active
.page-link {
    border-color: var(--navy);

    background: var(--navy);

    color: #FFFFFF;
}


/* =========================================================
   REVEAL
========================================================= */

.bd-publisher-reveal {
    opacity: 0;

    transform: translateY(15px);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1080px) {

    .bd-publisher-hero-grid {
        grid-template-columns:
            minmax(0, 1fr)
            440px;

        gap: 40px;
    }

    .bd-publisher-hero-books {
        width: 440px;
    }

    .bd-publisher-hero-book:nth-child(1) {
        left: 115px;
    }

    .bd-publisher-hero-book:nth-child(2) {
        left: 0;
    }

    .bd-publisher-book-grid {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

    .bd-publisher-book:not(:nth-child(4n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-publisher-book:not(:nth-child(3n)) {
        margin-right: 20px;

        border-right: 1px solid var(--line);
    }

}


/* =========================================================
   TABLET PORTRAIT
========================================================= */

@media (max-width: 850px) {

    .bd-publisher-shell {
        width:
            calc(100% - 40px);
    }

    .bd-publisher-hero {
        min-height: auto;
    }

    .bd-publisher-hero-grid {
        grid-template-columns: 1fr;

        gap: 35px;
    }

    .bd-publisher-hero-books {
        width: min(
            100%,
            540px
        );

        margin-inline: auto;
    }

    .bd-publisher-featured {
        grid-template-columns:
            270px
            minmax(0, 1fr);

        gap: 35px;
    }

    .bd-publisher-featured-cover {
        width: 250px;
    }

    .bd-publisher-featured-meta {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-publisher-featured-meta-item:not(:nth-child(3n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-publisher-featured-meta-item:nth-child(odd) {
        margin-right: 15px;

        border-right: 1px solid var(--line);
    }

    .bd-publisher-book-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-publisher-book:not(:nth-child(3n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-publisher-book:nth-child(odd) {
        margin-right: 20px;

        border-right: 1px solid var(--line);
    }

    .bd-publisher-partner-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-publisher-partner:not(:nth-child(3n)) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-publisher-partner:nth-child(odd) {
        margin-right: 20px;

        border-right:
            1px solid
            rgba(36,27,82,.10);
    }

    .bd-publisher-process {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 640px) {

    .bd-publisher-shell {
        width:
            calc(100% - 30px);
    }


    /* HERO */

    .bd-publisher-hero {
        padding:
            31px 0
            36px;
    }

    .bd-publisher-hero-title {
        font-size: 39px;
    }

    .bd-publisher-hero-description {
        font-size: 11px;
    }

    .bd-publisher-hero-books {
        width: 100%;
        height: 310px;
    }

    .bd-publisher-hero-book:nth-child(1) {
        width: 165px;
        height: 240px;

        left: 50%;
        top: 18px;

        transform:
            translateX(-50%)
            rotate(-1deg);
    }

    .bd-publisher-hero-book:nth-child(2) {
        width: 125px;
        height: 185px;

        left: 3px;
        top: 67px;
    }

    .bd-publisher-hero-book:nth-child(3) {
        width: 125px;
        height: 185px;

        right: 3px;
        top: 62px;
    }

    .bd-publisher-hero-books:hover
    .bd-publisher-hero-book:nth-child(1) {
        transform:
            translateX(-50%)
            translateY(-4px)
            rotate(0);
    }


    /* SECTION */

    .bd-publisher-section {
        padding:
            36px 0;
    }

    .bd-publisher-section-head {
        align-items: flex-start;
        flex-direction: column;

        gap: 9px;
    }

    .bd-publisher-section-title {
        font-size: 28px;
    }


    /* FEATURED */

    .bd-publisher-featured {
        grid-template-columns: 1fr;

        gap: 25px;

        padding-top: 10px;
    }

    .bd-publisher-featured-cover {
        width: min(
            72%,
            275px
        );
    }

    .bd-publisher-featured-title {
        font-size: 29px;
    }

    .bd-publisher-featured-description {
        font-size: 10px;
    }


    /* BOOK GRID */

    .bd-publisher-book-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bd-publisher-book,
    .bd-publisher-book:nth-child(odd) {
        margin: 0;

        padding:
            18px 8px
            20px 0;

        border-right: 0;
    }

    .bd-publisher-book:nth-child(odd) {
        margin-right: 10px;

        border-right: 1px solid var(--line);
    }

    .bd-publisher-book-title {
        font-size: 12px;
    }

    .bd-publisher-book-meta {
        display: none;
    }


    /* PARTNER */

    .bd-publisher-partner-grid {
        grid-template-columns: 1fr;
    }

    .bd-publisher-partner,
    .bd-publisher-partner:nth-child(odd) {
        min-height: 115px;

        margin: 0;

        border-right: 0;
    }


    /* PROCESS */

    .bd-publisher-process {
        grid-template-columns: 1fr;
    }

    .bd-publisher-process-item,
    .bd-publisher-process-item:not(:last-child) {
        min-height: 0;

        margin: 0;

        padding:
            18px 0;

        border-right: 0;
    }

    .bd-publisher-process-number {
        margin-bottom: 10px;
    }


    /* CTA */

    .bd-publisher-cta-grid {
        grid-template-columns: 1fr;

        gap: 20px;
    }

    .bd-publisher-cta-title {
        font-size: 29px;
    }

    .bd-publisher-cta-link {
        width: 100%;

        justify-content: center;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .bd-publisher-reveal {
        opacity: 1 !important;

        transform: none !important;
    }

}
</style>



<div
    class="bd-publisher"
    id="bdPublisherPage"
>


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="bd-publisher-hero">

        <div class="bd-publisher-shell">

            <div class="bd-publisher-hero-grid">


                {{-- COPY --}}

                <div class="bd-publisher-reveal">

                    <div class="bd-publisher-eyebrow">

                        BacaDulu Publisher

                    </div>


                    <h1 class="bd-publisher-hero-title">

                        Buku yang telah
                        kami <span>terbitkan.</span>

                    </h1>


                    <p class="bd-publisher-hero-description">

                        Jelajahi karya yang telah diterbitkan
                        melalui BacaDulu Publisher, mulai dari
                        buku ajar, referensi, monograf,
                        hingga berbagai karya akademik
                        dan umum.

                    </p>


                    <div class="bd-publisher-hero-bottom">

                        <a
                            href="#koleksiTerbitan"
                            class="bd-publisher-scroll-link"
                        >

                            Jelajahi Terbitan

                            <svg viewBox="0 0 24 24">

                                <path d="M12 5v14"/>

                                <path d="m7 14 5 5 5-5"/>

                            </svg>

                        </a>


                        <div class="bd-publisher-count">

                            <strong>
                                {{ $totalBooks }}
                            </strong>

                            <span>
                                Karya diterbitkan
                            </span>

                        </div>

                    </div>

                </div>



                {{-- BOOK VISUAL --}}

                @if($heroBooks->count())

                    <div
                        class="
                            bd-publisher-hero-books
                            bd-publisher-reveal
                        "
                    >

                        @foreach($heroBooks as $heroBook)

                            <div class="bd-publisher-hero-book">

                                @if(!empty($heroBook->cover))

                                    <img
                                        src="{{ $resolveStorageAsset($heroBook->cover) }}"
                                        alt="{{ $heroBook->title }}"
                                        onerror="this.style.display='none';"
                                    >

                                @endif


                                <div class="bd-publisher-cover-fallback">

                                    <span>
                                        {{ $heroBook->title }}
                                    </span>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>

        </div>

    </section>



    {{-- =====================================================
         FEATURED PUBLICATION
    ====================================================== --}}

    <section
        class="bd-publisher-section"
        id="koleksiTerbitan"
    >

        <div class="bd-publisher-shell">


            <div
                class="
                    bd-publisher-section-head
                    bd-publisher-reveal
                "
            >

                <div>

                    <div class="bd-publisher-section-label">
                        Terbitan terbaru
                    </div>


                    <h2 class="bd-publisher-section-title">

                        Karya pilihan
                        Baca Publisher

                    </h2>

                </div>


                <p class="bd-publisher-section-description">

                    Portfolio buku yang telah melalui
                    proses penerbitan dan menjadi bagian
                    dari koleksi BacaDulu Publisher.

                </p>

            </div>



            @if($featuredBook)

                <article
                    class="
                        bd-publisher-featured
                        bd-publisher-reveal
                    "
                >


                    {{-- COVER --}}

                    <div class="bd-publisher-featured-cover-wrap">

                        <div class="bd-publisher-featured-cover">


                            <div class="bd-publisher-cover-fallback">

                                <span>
                                    {{ $featuredBook->title }}
                                </span>

                            </div>


                            @if(!empty($featuredBook->cover))

                                <img
                                    src="{{ $resolveStorageAsset($featuredBook->cover) }}"
                                    alt="{{ $featuredBook->title }}"
                                    onerror="this.style.display='none';"
                                >

                            @endif

                        </div>

                    </div>



                    {{-- CONTENT --}}

                    <div class="bd-publisher-featured-content">


                        <div class="bd-publisher-publication-kicker">
                            Terbitan terbaru
                        </div>


                        <h3 class="bd-publisher-featured-title">

                            {{ $featuredBook->title }}

                        </h3>


                        @if(!empty($featuredBook->author))

                            <div class="bd-publisher-featured-author">

                                {{ $featuredBook->author }}

                            </div>

                        @endif



                        <div class="bd-publisher-featured-meta">


                            <div class="bd-publisher-featured-meta-item">

                                <div class="bd-publisher-meta-label">
                                    Tahun Terbit
                                </div>

                                <div class="bd-publisher-meta-value">

                                    {{ $featuredBook->publish_year ?: '-' }}

                                </div>

                            </div>



                            <div class="bd-publisher-featured-meta-item">

                                <div class="bd-publisher-meta-label">
                                    ISBN
                                </div>

                                <div class="bd-publisher-meta-value">

                                    {{ $featuredBook->isbn ?: '-' }}

                                </div>

                            </div>



                            <div class="bd-publisher-featured-meta-item">

                                <div class="bd-publisher-meta-label">
                                    Jenis Buku
                                </div>

                                <div class="bd-publisher-meta-value">

                                    {{ $featuredBook->category ?: '-' }}

                                </div>

                            </div>



                            <div class="bd-publisher-featured-meta-item">

                                <div class="bd-publisher-meta-label">
                                    Penulis
                                </div>

                                <div class="bd-publisher-meta-value">

                                    {{ $featuredBook->author ?: '-' }}

                                </div>

                            </div>



                            <div class="bd-publisher-featured-meta-item">

                                <div class="bd-publisher-meta-label">
                                    Penerbit
                                </div>

                                <div class="bd-publisher-meta-value">

                                    {{
                                        $featuredBook->publisher
                                        ?:
                                        'BacaDulu Publisher'
                                    }}

                                </div>

                            </div>



                            <div class="bd-publisher-featured-meta-item">

                                <div class="bd-publisher-meta-label">
                                    Status
                                </div>

                                <div
                                    class="
                                        bd-publisher-meta-value
                                        bd-publisher-status
                                    "
                                >

                                    Sudah Terbit

                                </div>

                            </div>

                        </div>



                        @if(!empty($featuredBook->description))

                            <div class="bd-publisher-featured-description">

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
                                        380
                                    )
                                }}

                            </div>

                        @endif



                        <a
                            href="{{ route('publisher.books.show', $featuredBook) }}"
                            class="bd-publisher-detail"
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

                <div class="bd-publisher-empty">

                    <h3>
                        Belum ada buku diterbitkan
                    </h3>

                    <p>
                        Portfolio buku akan tampil di sini.
                    </p>

                </div>

            @endif

        </div>

    </section>



    {{-- =====================================================
         ALL BOOKS
    ====================================================== --}}

    @if($books->count())

        <section class="bd-publisher-section">

            <div class="bd-publisher-shell">


                <div
                    class="
                        bd-publisher-section-head
                        bd-publisher-reveal
                    "
                >

                    <div>

                        <div class="bd-publisher-section-label">
                            Portfolio
                        </div>


                        <h2 class="bd-publisher-section-title">
                            Semua terbitan
                        </h2>

                    </div>


                    <p class="bd-publisher-section-description">

                        Lihat informasi judul, penulis,
                        tahun penerbitan, ISBN,
                        dan kategori setiap buku.

                    </p>

                </div>



                <div class="bd-publisher-book-grid">

                    @foreach($books as $book)

                        <article
                            class="
                                bd-publisher-book
                                bd-publisher-reveal
                            "
                        >


                            {{-- COVER --}}

                            <div class="bd-publisher-book-cover">


                                <div class="bd-publisher-cover-fallback">

                                    <span>
                                        {{ $book->title }}
                                    </span>

                                </div>


                                @if(!empty($book->cover))

                                    <img
                                        src="{{ $resolveStorageAsset($book->cover) }}"
                                        alt="{{ $book->title }}"
                                        loading="lazy"
                                        onerror="this.style.display='none';"
                                    >

                                @endif

                            </div>



                            {{-- CONTENT --}}

                            <div class="bd-publisher-book-content">


                                @if(!empty($book->category))

                                    <div class="bd-publisher-book-category">

                                        {{ $book->category }}

                                    </div>

                                @endif


                                <h3 class="bd-publisher-book-title">

                                    {{ $book->title }}

                                </h3>


                                @if(!empty($book->author))

                                    <div class="bd-publisher-book-author">

                                        {{ $book->author }}

                                    </div>

                                @endif



                                <div class="bd-publisher-book-meta">


                                    <div class="bd-publisher-book-meta-row">

                                        <span class="bd-publisher-book-meta-label">
                                            Tahun
                                        </span>

                                        <span class="bd-publisher-book-meta-value">

                                            {{ $book->publish_year ?: '-' }}

                                        </span>

                                    </div>


                                    <div class="bd-publisher-book-meta-row">

                                        <span class="bd-publisher-book-meta-label">
                                            ISBN
                                        </span>

                                        <span class="bd-publisher-book-meta-value">

                                            {{ $book->isbn ?: '-' }}

                                        </span>

                                    </div>


                                    <div class="bd-publisher-book-meta-row">

                                        <span class="bd-publisher-book-meta-label">
                                            Status
                                        </span>

                                        <span class="bd-publisher-book-meta-value">

                                            Sudah Terbit

                                        </span>

                                    </div>

                                </div>



                                <a
                                    href="{{ route('publisher.books.show', $book) }}"
                                    class="bd-publisher-book-detail"
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

                    <div class="bd-publisher-pagination">

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
         PUBLISHER PARTNERS
    ====================================================== --}}

    @if($publishers->count())

        <section
            class="
                bd-publisher-section
                bd-publisher-partner-section
            "
        >

            <div class="bd-publisher-shell">


                <div
                    class="
                        bd-publisher-section-head
                        bd-publisher-reveal
                    "
                >

                    <div>

                        <div class="bd-publisher-section-label">
                            Kolaborasi
                        </div>


                        <h2 class="bd-publisher-section-title">

                            Mitra penerbitan

                        </h2>

                    </div>


                    <p class="bd-publisher-section-description">

                        Penerbit dan mitra yang menjadi
                        bagian dari jaringan penerbitan
                        Baca Dulu.

                    </p>

                </div>



                <div class="bd-publisher-partner-grid">

                    @foreach($publishers as $publisher)

                        @php
                            $publisherName =
                                $publisher->name
                                ??
                                $publisher->title
                                ??
                                'Publisher';

                            $publisherLogoPath =
                                $publisher->logo
                                ??
                                $publisher->image
                                ??
                                null;

                            $publisherLogo =
                                $resolveStorageAsset(
                                    $publisherLogoPath
                                );
                        @endphp


                        <article
                            class="
                                bd-publisher-partner
                                bd-publisher-reveal
                            "
                        >


                            {{-- LOGO --}}

                            <div class="bd-publisher-partner-logo">


                                <div class="bd-publisher-partner-logo-fallback"></div>


                                @if($publisherLogo)

                                    <img
                                        src="{{ $publisherLogo }}"
                                        alt="{{ $publisherName }}"
                                        loading="lazy"
                                        onerror="this.style.display='none';"
                                    >

                                @endif

                            </div>



                            {{-- INFO --}}

                            <div>

                                <h3 class="bd-publisher-partner-name">

                                    {{ $publisherName }}

                                </h3>


                                @if(!empty($publisher->description))

                                    <div class="bd-publisher-partner-description">

                                        {{
                                            \Illuminate\Support\Str::limit(
                                                trim(
                                                    preg_replace(
                                                        '/\s+/u',
                                                        ' ',
                                                        strip_tags(
                                                            $publisher->description
                                                        )
                                                    )
                                                ),
                                                120
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



    {{-- =====================================================
         PROCESS
    ====================================================== --}}

    <section class="bd-publisher-section">

        <div class="bd-publisher-shell">


            <div
                class="
                    bd-publisher-section-head
                    bd-publisher-reveal
                "
            >

                <div>

                    <div class="bd-publisher-section-label">
                        Menerbitkan bersama kami
                    </div>


                    <h2 class="bd-publisher-section-title">

                        Dari naskah
                        menjadi buku.

                    </h2>

                </div>


                <p class="bd-publisher-section-description">

                    Proses penerbitan disusun secara
                    bertahap agar setiap karya siap
                    memasuki portfolio penerbitan.

                </p>

            </div>



            <div class="bd-publisher-process">


                <article class="bd-publisher-process-item bd-publisher-reveal">

                    <div class="bd-publisher-process-number">
                        01
                    </div>

                    <h3 class="bd-publisher-process-title">
                        Kirim Naskah
                    </h3>

                    <div class="bd-publisher-process-text">

                        Penulis mengajukan naskah
                        untuk ditinjau.

                    </div>

                </article>



                <article class="bd-publisher-process-item bd-publisher-reveal">

                    <div class="bd-publisher-process-number">
                        02
                    </div>

                    <h3 class="bd-publisher-process-title">
                        Editorial
                    </h3>

                    <div class="bd-publisher-process-text">

                        Naskah memasuki tahap
                        penyuntingan dan review.

                    </div>

                </article>



                <article class="bd-publisher-process-item bd-publisher-reveal">

                    <div class="bd-publisher-process-number">
                        03
                    </div>

                    <h3 class="bd-publisher-process-title">
                        Produksi
                    </h3>

                    <div class="bd-publisher-process-text">

                        Layout, sampul dan kelengkapan
                        penerbitan dipersiapkan.

                    </div>

                </article>



                <article class="bd-publisher-process-item bd-publisher-reveal">

                    <div class="bd-publisher-process-number">
                        04
                    </div>

                    <h3 class="bd-publisher-process-title">
                        Terbit
                    </h3>

                    <div class="bd-publisher-process-text">

                        Buku diterbitkan dan masuk
                        ke portfolio Baca Publisher.

                    </div>

                </article>

            </div>

        </div>

    </section>



    {{-- =====================================================
         CTA
    ====================================================== --}}

    <section class="bd-publisher-cta">

        <div class="bd-publisher-shell">

            <div class="bd-publisher-cta-grid">


                <div class="bd-publisher-reveal">

                    <div class="bd-publisher-cta-label">
                        Punya naskah?
                    </div>


                    <h2 class="bd-publisher-cta-title">

                        Jadikan gagasan Anda
                        bagian dari terbitan berikutnya.

                    </h2>

                </div>


                <a
                    href="{{ url('/konsultasi') }}"
                    class="
                        bd-publisher-cta-link
                        bd-publisher-reveal
                    "
                >

                    Konsultasi Penerbitan →

                </a>

            </div>

        </div>

    </section>

</div>



<script>
(() => {

    const initPublisherPage = () => {

        const page =
            document.getElementById(
                'bdPublisherPage'
            );


        if (!page) {
            return;
        }



        /*
        |--------------------------------------------------------------------------
        | GSAP
        |--------------------------------------------------------------------------
        */

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
                    '.bd-publisher-reveal'
                ),
                {
                    opacity: 1,

                    y: 0,

                    duration: .62,

                    stagger: .025,

                    ease: 'power3.out'
                }
            );

        } else {

            page
                .querySelectorAll(
                    '.bd-publisher-reveal'
                )
                .forEach(element => {

                    element.style.opacity =
                        '1';

                    element.style.transform =
                        'none';

                });

        }



        /*
        |--------------------------------------------------------------------------
        | INTERNAL SCROLL
        |--------------------------------------------------------------------------
        */

        const link =
            page.querySelector(
                'a[href="#koleksiTerbitan"]'
            );


        const section =
            document.getElementById(
                'koleksiTerbitan'
            );


        if (
            link &&
            section
        ) {

            link.addEventListener(
                'click',
                event => {

                    event.preventDefault();


                    section.scrollIntoView({
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
            initPublisherPage,
            {
                once: true
            }
        );

    } else {

        initPublisherPage();

    }

})();
</script>

@endsection