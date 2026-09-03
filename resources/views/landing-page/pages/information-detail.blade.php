@extends('layouts.app')

@section('title', $information->title . ' - Baca Dulu')

@section('content')

@php
    $publishedDate = $information->created_at
        ? $information->created_at
            ->timezone('Asia/Jakarta')
            ->translatedFormat('d F Y')
        : null;

    $hasImage = !empty($information->image);
@endphp


<style>
/* =========================================================
   BACA DULU
   INFORMATION DETAIL
========================================================= */

.bd-detail {
    --navy: #241B52;
    --orange: #EF5843;
    --gold: #F7AA35;

    --ink: #19191D;
    --body: #505661;
    --muted: #8B9099;
    --line: #E7E8EC;
    --soft: #F7F8FA;

    position: relative;

    min-height: 100vh;

    overflow-x: hidden;

    background: #FFFFFF;
    color: var(--ink);

    font-family: 'Poppins', sans-serif;
}

.bd-detail *,
.bd-detail *::before,
.bd-detail *::after {
    box-sizing: border-box;
}

.bd-detail a {
    text-decoration: none;
}

.bd-detail-container {
    width: min(
        calc(100% - 64px),
        1200px
    );

    margin-inline: auto;
}


/* =========================================================
   READING PROGRESS
========================================================= */

.bd-detail-progress {
    position: fixed;

    z-index: 999;

    top: 0;
    left: 0;

    width: 100%;
    height: 3px;

    pointer-events: none;
}

.bd-detail-progress-bar {
    width: 0;
    height: 100%;

    background: var(--orange);

    transform-origin: left center;
}


/* =========================================================
   TOP NAV
========================================================= */

.bd-detail-nav {
    position: relative;

    z-index: 10;

    border-bottom: 1px solid var(--line);

    background: rgba(255,255,255,.96);
}

.bd-detail-nav-inner {
    min-height: 58px;

    display: flex;
    align-items: center;
}

.bd-detail-back {
    display: inline-flex;
    align-items: center;

    gap: 9px;

    color: #747983 !important;

    font-size: 11px;
    font-weight: 600;

    transition:
        color .25s ease;
}

.bd-detail-back svg {
    width: 17px;
    height: 17px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;

    transition:
        transform .3s cubic-bezier(.22,1,.36,1);
}

.bd-detail-back:hover {
    color: var(--orange) !important;
}

.bd-detail-back:hover svg {
    transform: translateX(-4px);
}


/* =========================================================
   HERO
========================================================= */

.bd-detail-hero {
    position: relative;

    padding:
        46px 0
        43px;

    overflow: hidden;
}

.bd-detail-hero-grid {
    position: relative;

    z-index: 3;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        370px;

    gap: 62px;

    align-items: center;
}

.bd-detail-hero-grid.no-image {
    grid-template-columns: minmax(0, 820px);
}


/* =========================================================
   DECORATION
========================================================= */

.bd-detail-decoration {
    position: absolute;

    inset: 0;

    z-index: 0;

    pointer-events: none;

    overflow: hidden;
}

.bd-detail-ring {
    position: absolute;

    width: 240px;
    height: 240px;

    right: -80px;
    top: -115px;

    border: 1px solid rgba(36,27,82,.08);
    border-radius: 50%;
}

.bd-detail-ring::before {
    content: "";

    position: absolute;

    width: 150px;
    height: 150px;

    left: 44px;
    top: 44px;

    border: 1px solid rgba(239,88,67,.11);
    border-radius: 50%;
}

.bd-detail-ring::after {
    content: "";

    position: absolute;

    width: 7px;
    height: 7px;

    left: 29px;
    bottom: 38px;

    border-radius: 50%;

    background: var(--orange);
}

.bd-detail-decor-line {
    position: absolute;

    width: 110px;
    height: 2px;

    left: -45px;
    bottom: 39px;

    background: rgba(239,88,67,.18);
}


/* =========================================================
   HERO COPY
========================================================= */

.bd-detail-copy {
    position: relative;

    min-width: 0;

    padding-left: 22px;
}

.bd-detail-copy::before {
    content: "";

    position: absolute;

    top: 4px;
    bottom: 4px;
    left: 0;

    width: 3px;

    border-radius: 999px;

    background:
        linear-gradient(
            180deg,
            var(--orange) 0%,
            var(--orange) 52%,
            rgba(239,88,67,.10) 52%,
            rgba(239,88,67,.10) 100%
        );
}

.bd-detail-title-mask {
    overflow: hidden;
}

.bd-detail-title {
    max-width: 760px;

    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        38px,
        4.2vw,
        58px
    );

    font-weight: 600;

    line-height: 1.07;

    letter-spacing: -.045em;

    overflow-wrap: anywhere;
}


/* =========================================================
   DATE + SHARE
========================================================= */

.bd-detail-meta {
    display: flex;
    align-items: center;

    gap: 16px;

    margin-top: 22px;
}

.bd-detail-date {
    color: var(--muted);

    font-size: 11px;
    font-weight: 500;
}

.bd-detail-share {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-left: auto;

    padding: 0;

    border: 1px solid var(--line);
    border-radius: 50%;

    background: #FFFFFF;

    color: #70757E;

    cursor: pointer;

    transition:
        color .25s ease,
        border-color .25s ease,
        background .25s ease,
        transform .3s cubic-bezier(.22,1,.36,1);
}

.bd-detail-share svg {
    width: 16px;
    height: 16px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.6;
}

.bd-detail-share:hover {
    transform: translateY(-2px);

    border-color: var(--orange);

    background: var(--orange);

    color: #FFFFFF;
}


/* =========================================================
   HERO IMAGE
========================================================= */

.bd-detail-media-wrap {
    position: relative;

    padding:
        10px
        10px
        0
        0;
}

.bd-detail-media-wrap::before {
    content: "";

    position: absolute;

    z-index: 0;

    top: 0;
    right: 0;

    width: 68px;
    height: 68px;

    border-top: 2px solid var(--orange);
    border-right: 2px solid var(--orange);

    border-radius: 0 15px 0 0;

    opacity: .72;
}

.bd-detail-media-wrap::after {
    content: "";

    position: absolute;

    z-index: 0;

    right: -7px;
    bottom: -7px;

    width: 72px;
    height: 72px;

    background:
        radial-gradient(
            circle,
            rgba(36,27,82,.14) 1px,
            transparent 1.6px
        );

    background-size: 10px 10px;

    opacity: .7;
}

.bd-detail-media {
    position: relative;

    z-index: 2;

    width: 100%;
    height: 285px;

    overflow: hidden;

    border-radius: 15px;

    background: var(--soft);

    box-shadow:
        0 14px 38px
        rgba(36,27,82,.07);

    isolation: isolate;
}

.bd-detail-image {
    position: absolute;

    z-index: 1;

    inset: 0;

    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transform: scale(1.01);

    transition:
        transform .8s cubic-bezier(.22,1,.36,1);
}

.bd-detail-media:hover
.bd-detail-image {
    transform: scale(1.04);
}


/* =========================================================
   IMAGE FALLBACK
========================================================= */

.bd-detail-fallback {
    position: absolute;

    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    background:
        linear-gradient(
            135deg,
            #2B225A,
            #17132E
        );
}

.bd-detail-fallback-mark {
    width: 10px;
    height: 10px;

    background: var(--orange);
}


/* =========================================================
   ARTICLE SEPARATOR
========================================================= */

.bd-detail-separator {
    position: relative;

    height: 1px;

    background: var(--line);
}

.bd-detail-separator::before {
    content: "";

    position: absolute;

    left: 50%;

    width: 46px;
    height: 3px;

    transform: translateX(-50%);

    background: var(--orange);
}


/* =========================================================
   READING AREA
========================================================= */

.bd-detail-reading {
    position: relative;

    padding:
        48px 0
        72px;
}

.bd-detail-reading::before {
    content: "";

    position: absolute;

    width: 210px;
    height: 210px;

    left: -140px;
    top: 95px;

    border: 1px solid rgba(36,27,82,.045);
    border-radius: 50%;

    pointer-events: none;
}

.bd-detail-reading-inner {
    width: min(
        calc(100% - 64px),
        760px
    );

    margin-inline: auto;
}


/* =========================================================
   CONTENT
========================================================= */

.bd-detail-content {
    display: flow-root;

    width: 100%;
    max-width: 100%;

    color: var(--body);

    font-size: 16px;

    line-height: 1.9;

    overflow-wrap: anywhere;
}

.bd-detail-content::after {
    content: "";

    display: block;

    clear: both;
}

.bd-detail-content > * {
    max-width: 100% !important;
}


/* =========================================================
   RESET BAD HTML WIDTHS/FLOATS FROM EDITOR
========================================================= */

.bd-detail-content p,
.bd-detail-content div,
.bd-detail-content section,
.bd-detail-content article {
    max-width: 100% !important;
}

.bd-detail-content p {
    margin:
        0 0
        24px;
}

.bd-detail-content > p:first-child {
    margin-top: 0;

    color: #292D35;

    font-size: 18px;

    line-height: 1.78;
}


/* =========================================================
   HEADINGS
========================================================= */

.bd-detail-content h1,
.bd-detail-content h2,
.bd-detail-content h3,
.bd-detail-content h4,
.bd-detail-content h5,
.bd-detail-content h6 {
    max-width: 100% !important;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-weight: 600;

    line-height: 1.3;

    letter-spacing: -.025em;

    overflow-wrap: anywhere;

    clear: both;
}

.bd-detail-content h1 {
    margin:
        48px 0
        17px;

    font-size: 31px;
}

.bd-detail-content h2 {
    margin:
        43px 0
        16px;

    font-size: 27px;
}

.bd-detail-content h3 {
    margin:
        36px 0
        14px;

    font-size: 22px;
}

.bd-detail-content h4 {
    margin:
        30px 0
        12px;

    font-size: 18px;
}


/* =========================================================
   LISTS
========================================================= */

.bd-detail-content ul,
.bd-detail-content ol {
    max-width: 100% !important;

    margin:
        0 0
        25px;

    padding-left: 24px;
}

.bd-detail-content ul {
    list-style: disc;
}

.bd-detail-content ol {
    list-style: decimal;
}

.bd-detail-content li {
    margin-bottom: 8px;
}


/* =========================================================
   LINK
========================================================= */

.bd-detail-content a {
    color: var(--orange) !important;

    text-decoration: underline;

    text-decoration-thickness: 1px;
    text-underline-offset: 4px;
}


/* =========================================================
   BLOCKQUOTE
========================================================= */

.bd-detail-content blockquote {
    clear: both;

    margin:
        36px 0;

    padding:
        4px 0
        4px 21px;

    border-left: 3px solid var(--orange);

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 20px;

    font-weight: 500;

    line-height: 1.55;

    letter-spacing: -.02em;
}

.bd-detail-content blockquote p {
    margin: 0;
}


/* =========================================================
   CONTENT IMAGES
========================================================= */

.bd-detail-content img {
    display: block !important;

    float: none !important;

    width: auto !important;
    max-width: 100% !important;

    height: auto !important;
    max-height: 520px;

    margin:
        31px auto !important;

    border-radius: 13px;

    object-fit: contain;
}


/* =========================================================
   FIGURE
========================================================= */

.bd-detail-content figure {
    float: none !important;

    clear: both;

    width: 100% !important;
    max-width: 100% !important;

    margin:
        32px 0 !important;
}

.bd-detail-content figure img {
    margin:
        0 auto !important;
}

.bd-detail-content figcaption {
    margin-top: 9px;

    color: #969AA3;

    font-size: 10px;

    line-height: 1.6;

    text-align: center;
}


/* =========================================================
   VIDEO
========================================================= */

.bd-detail-content iframe,
.bd-detail-content video {
    display: block;

    float: none !important;

    clear: both;

    width: 100% !important;
    max-width: 100% !important;

    min-height: 380px;

    margin:
        32px 0;

    border: 0;

    border-radius: 13px;
}


/* =========================================================
   TABLE
========================================================= */

.bd-detail-content table {
    display: block;

    clear: both;

    width: 100% !important;
    max-width: 100% !important;

    overflow-x: auto;

    margin:
        32px 0;

    border-collapse: collapse;

    font-size: 12px;
}

.bd-detail-content th,
.bd-detail-content td {
    padding:
        12px 11px;

    border-bottom: 1px solid var(--line);

    text-align: left;

    vertical-align: top;
}

.bd-detail-content th {
    color: var(--navy);

    font-weight: 800;
}


/* =========================================================
   CODE
========================================================= */

.bd-detail-content pre {
    clear: both;

    max-width: 100%;

    overflow-x: auto;

    margin:
        30px 0;

    padding: 18px;

    border: 1px solid var(--line);
    border-radius: 10px;

    background: var(--soft);
}


/* =========================================================
   BOTTOM NAV
========================================================= */

.bd-detail-bottom {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;

    clear: both;

    width: 100%;

    margin-top: 52px;

    padding-top: 21px;

    border-top: 1px solid var(--line);
}

.bd-detail-bottom::before {
    content: "";

    position: absolute;

    top: -1px;
    left: 0;

    width: 35px;
    height: 2px;

    background: var(--orange);
}

.bd-detail-more {
    display: inline-flex;
    align-items: center;

    gap: 9px;

    color: var(--navy) !important;

    font-size: 11px;
    font-weight: 650;

    transition:
        color .25s ease;
}

.bd-detail-more svg {
    width: 17px;
    height: 17px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;

    transition:
        transform .3s cubic-bezier(.22,1,.36,1);
}

.bd-detail-more:hover {
    color: var(--orange) !important;
}

.bd-detail-more:hover svg {
    transform: translateX(-4px);
}

.bd-detail-bottom-mark {
    display: flex;
    align-items: center;

    gap: 5px;
}

.bd-detail-bottom-mark span {
    display: block;

    width: 5px;
    height: 5px;

    border-radius: 50%;
}

.bd-detail-bottom-mark span:nth-child(1) {
    background: var(--navy);
}

.bd-detail-bottom-mark span:nth-child(2) {
    background: var(--orange);
}

.bd-detail-bottom-mark span:nth-child(3) {
    background: var(--gold);
}


/* =========================================================
   SHARE TOAST
========================================================= */

.bd-detail-toast {
    position: fixed;

    z-index: 9999;

    right: 20px;
    bottom: 20px;

    padding:
        10px 14px;

    border-radius: 8px;

    background: var(--navy);

    color: #FFFFFF;

    font-size: 10px;
    font-weight: 650;

    opacity: 0;

    transform: translateY(12px);

    pointer-events: none;
}


/* =========================================================
   ANIMATION
========================================================= */

.bd-detail-reveal {
    opacity: 0;

    transform: translateY(14px);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 940px) {

    .bd-detail-hero-grid {
        grid-template-columns:
            minmax(0, 1fr)
            320px;

        gap: 38px;
    }

    .bd-detail-media {
        height: 255px;
    }

}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 720px) {

    .bd-detail-container,
    .bd-detail-reading-inner {
        width:
            calc(100% - 40px);
    }

    .bd-detail-hero-grid {
        grid-template-columns: 1fr;

        gap: 27px;
    }

    .bd-detail-copy {
        padding-left: 18px;
    }

    .bd-detail-media-wrap {
        width: min(
            100%,
            520px
        );
    }

    .bd-detail-media {
        height: 260px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 640px) {

    .bd-detail-container,
    .bd-detail-reading-inner {
        width:
            calc(100% - 30px);
    }


    /* NAV */

    .bd-detail-nav-inner {
        min-height: 52px;
    }


    /* HERO */

    .bd-detail-hero {
        padding:
            28px 0
            30px;
    }

    .bd-detail-copy {
        padding-left: 15px;
    }

    .bd-detail-copy::before {
        width: 2px;
    }

    .bd-detail-title {
        font-size: 33px;

        line-height: 1.08;

        letter-spacing: -.035em;
    }

    .bd-detail-meta {
        margin-top: 17px;
    }

    .bd-detail-media-wrap {
        width: 100%;

        padding:
            7px
            7px
            0
            0;
    }

    .bd-detail-media {
        height: 220px;

        border-radius: 12px;
    }

    .bd-detail-media-wrap::before {
        width: 50px;
        height: 50px;
    }

    .bd-detail-media-wrap::after {
        width: 55px;
        height: 55px;
    }


    /* DECORATION */

    .bd-detail-ring {
        width: 170px;
        height: 170px;

        right: -90px;
        top: -80px;
    }


    /* ARTICLE */

    .bd-detail-reading {
        padding:
            33px 0
            50px;
    }

    .bd-detail-content {
        font-size: 14px;

        line-height: 1.85;
    }

    .bd-detail-content > p:first-child {
        font-size: 16px;
    }

    .bd-detail-content h1 {
        font-size: 26px;
    }

    .bd-detail-content h2 {
        margin-top: 36px;

        font-size: 23px;
    }

    .bd-detail-content h3 {
        font-size: 19px;
    }

    .bd-detail-content blockquote {
        padding-left: 17px;

        font-size: 17px;
    }

    .bd-detail-content iframe,
    .bd-detail-content video {
        min-height: 220px;
    }

    .bd-detail-bottom {
        margin-top: 42px;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .bd-detail-reveal {
        opacity: 1 !important;

        transform: none !important;
    }

    .bd-detail-image {
        transition: none;
    }

}
</style>



<div
    class="bd-detail"
    id="bdInformationDetail"
>


    {{-- =====================================================
         READING PROGRESS
    ====================================================== --}}

    <div class="bd-detail-progress">

        <div
            class="bd-detail-progress-bar"
            id="bdDetailProgress"
        ></div>

    </div>



    {{-- =====================================================
         NAVIGATION
    ====================================================== --}}

    <nav class="bd-detail-nav">

        <div class="bd-detail-container">

            <div class="bd-detail-nav-inner">

                <a
                    href="{{ route('informasi') }}"
                    class="
                        bd-detail-back
                        bd-detail-reveal
                    "
                >

                    <svg viewBox="0 0 24 24">

                        <path d="M19 12H5"/>

                        <path d="m10 7-5 5 5 5"/>

                    </svg>

                    Kembali

                </a>

            </div>

        </div>

    </nav>



    {{-- =====================================================
         HERO
    ====================================================== --}}

    <header class="bd-detail-hero">


        {{-- DECORATION --}}

        <div class="bd-detail-decoration">

            <div class="bd-detail-ring"></div>

            <div class="bd-detail-decor-line"></div>

        </div>



        <div class="bd-detail-container">

            <div
                class="
                    bd-detail-hero-grid
                    {{ !$hasImage ? 'no-image' : '' }}
                "
            >


                {{-- =================================================
                     COPY
                ================================================== --}}

                <div class="bd-detail-copy">


                    <div class="bd-detail-title-mask">

                        <h1
                            class="bd-detail-title"
                            id="bdDetailTitle"
                        >

                            {{ $information->title }}

                        </h1>

                    </div>



                    <div
                        class="
                            bd-detail-meta
                            bd-detail-reveal
                        "
                    >


                        @if($publishedDate)

                            <time class="bd-detail-date">

                                {{ $publishedDate }}

                            </time>

                        @endif



                        <button
                            type="button"
                            class="bd-detail-share"
                            id="bdDetailShare"
                            aria-label="Bagikan informasi"
                            title="Bagikan"
                        >

                            <svg viewBox="0 0 24 24">

                                <circle
                                    cx="18"
                                    cy="5"
                                    r="2"
                                />

                                <circle
                                    cx="6"
                                    cy="12"
                                    r="2"
                                />

                                <circle
                                    cx="18"
                                    cy="19"
                                    r="2"
                                />

                                <path d="M8 11l8-5"/>

                                <path d="M8 13l8 5"/>

                            </svg>

                        </button>

                    </div>

                </div>



                {{-- =================================================
                     IMAGE
                ================================================== --}}

                @if($hasImage)

                    <div
                        class="
                            bd-detail-media-wrap
                            bd-detail-reveal
                        "
                    >

                        <div class="bd-detail-media">


                            <div class="bd-detail-fallback">

                                <span
                                    class="bd-detail-fallback-mark"
                                ></span>

                            </div>



                            <img
                                src="{{ asset('storage/' . $information->image) }}"
                                alt="{{ $information->title }}"
                                class="bd-detail-image"
                                loading="eager"
                                fetchpriority="high"

                                onerror="
                                    this.style.display='none';
                                "
                            >

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </header>



    {{-- =====================================================
         SEPARATOR
    ====================================================== --}}

    <div class="bd-detail-separator"></div>



    {{-- =====================================================
         ARTICLE
    ====================================================== --}}

    <main class="bd-detail-reading">

        <div class="bd-detail-reading-inner">


            {{-- =================================================
                 RAW ARTICLE CONTENT
                 IMPORTANT:
                 ONLY USER CONTENT INSIDE THIS ELEMENT
            ================================================== --}}

            <article
                class="
                    bd-detail-content
                    bd-detail-reveal
                "
            >

                {!! $information->content !!}

            </article>



            {{-- =================================================
                 BOTTOM NAVIGATION
                 OUTSIDE RAW CONTENT
                 SO FLOAT/EDITOR HTML CANNOT AFFECT IT
            ================================================== --}}

            <div
                class="
                    bd-detail-bottom
                    bd-detail-reveal
                "
            >

                <a
                    href="{{ route('informasi') }}"
                    class="bd-detail-more"
                >

                    <svg viewBox="0 0 24 24">

                        <path d="M19 12H5"/>

                        <path d="m10 7-5 5 5 5"/>

                    </svg>

                    Informasi lainnya

                </a>


                <div
                    class="bd-detail-bottom-mark"
                    aria-hidden="true"
                >

                    <span></span>
                    <span></span>
                    <span></span>

                </div>

            </div>

        </div>

    </main>



    {{-- =====================================================
         TOAST
    ====================================================== --}}

    <div
        class="bd-detail-toast"
        id="bdDetailToast"
    >

        Link berhasil disalin

    </div>

</div>



<script>
(() => {

    const initInformationDetail = () => {

        const page =
            document.getElementById(
                'bdInformationDetail'
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



        /* =====================================================
           INTRO
        ====================================================== */

        const title =
            document.getElementById(
                'bdDetailTitle'
            );


        if (
            gsap &&
            !reducedMotion
        ) {

            gsap.set(
                title,
                {
                    yPercent: 105
                }
            );


            const timeline =
                gsap.timeline({
                    defaults: {
                        ease: 'power3.out'
                    }
                });


            timeline
                .to(
                    title,
                    {
                        yPercent: 0,

                        duration: .78
                    }
                )

                .to(
                    page.querySelectorAll(
                        '.bd-detail-reveal'
                    ),
                    {
                        opacity: 1,

                        y: 0,

                        duration: .56,

                        stagger: .04
                    },
                    '-=.46'
                );

        } else {

            page
                .querySelectorAll(
                    '.bd-detail-reveal'
                )
                .forEach(element => {

                    element.style.opacity = '1';

                    element.style.transform = 'none';

                });

        }



        /* =====================================================
           READING PROGRESS
        ====================================================== */

        const progress =
            document.getElementById(
                'bdDetailProgress'
            );


        const updateProgress = () => {

            if (!progress) {
                return;
            }


            const scrollTop =
                window.scrollY ||
                document.documentElement.scrollTop;


            const scrollHeight =
                document.documentElement.scrollHeight -
                window.innerHeight;


            const percentage =
                scrollHeight > 0
                    ? Math.min(
                        100,
                        Math.max(
                            0,
                            (
                                scrollTop /
                                scrollHeight
                            ) * 100
                        )
                    )
                    : 0;


            progress.style.width =
                `${percentage}%`;

        };


        window.addEventListener(
            'scroll',
            updateProgress,
            {
                passive: true
            }
        );


        updateProgress();



        /* =====================================================
           SHARE
        ====================================================== */

        const shareButton =
            document.getElementById(
                'bdDetailShare'
            );


        const toast =
            document.getElementById(
                'bdDetailToast'
            );


        const showToast = () => {

            if (!toast) {
                return;
            }


            if (
                gsap &&
                !reducedMotion
            ) {

                gsap
                    .timeline()

                    .to(
                        toast,
                        {
                            opacity: 1,

                            y: 0,

                            duration: .22
                        }
                    )

                    .to(
                        toast,
                        {
                            opacity: 0,

                            y: 12,

                            duration: .22,

                            delay: 1.3
                        }
                    );

            } else {

                toast.style.opacity = '1';


                setTimeout(
                    () => {

                        toast.style.opacity = '0';

                    },
                    1500
                );

            }

        };


        const copyLink = async () => {

            try {

                await navigator
                    .clipboard
                    .writeText(
                        window.location.href
                    );


                showToast();

            } catch (error) {

                window.prompt(
                    'Salin link:',
                    window.location.href
                );

            }

        };


        if (shareButton) {

            shareButton.addEventListener(
                'click',
                async () => {

                    if (navigator.share) {

                        try {

                            await navigator.share({

                                title:
                                    @json(
                                        $information->title
                                    ),

                                url:
                                    window.location.href

                            });

                        } catch (error) {

                            // User membatalkan share.

                        }


                        return;
                    }


                    copyLink();

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
            initInformationDetail,
            {
                once: true
            }
        );

    } else {

        initInformationDetail();

    }

})();
</script>

@endsection