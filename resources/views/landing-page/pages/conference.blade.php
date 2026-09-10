@extends('layouts.app')

@section('title', 'Baca Conference - Baca Dulu')

@section('barba-namespace', 'conference')

@section('content')

@php
    $conferenceItems = method_exists($conferences, 'items')
        ? collect($conferences->items())
        : collect($conferences);

    $totalConferences = method_exists($conferences, 'total')
        ? $conferences->total()
        : $conferenceItems->count();
@endphp

<style>
.bd-conference{
    --bdc-navy:#241B52;
    --bdc-orange:#D96A2B;
    --bdc-orange-dark:#C94F35;
    --bdc-gold:#F0A52E;
    --bdc-text:#2F3640;
    --bdc-body:#5F636B;
    --bdc-muted:#777B84;
    --bdc-line:#E9E2DA;
    --bdc-soft:#FFF8F1;
    --bdc-soft-2:#FFFCF8;

    width:100%;
    min-height:100vh;
    overflow-x:hidden;
    padding-bottom:76px;

    background:
        linear-gradient(
            180deg,
            #FFFFFF 0,
            #FFFFFF 360px,
            #FFF9F4 100%
        );

    color:var(--bdc-text);

    font-family:
        'Inter',
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        'Segoe UI',
        sans-serif;
}

.bd-conference *,
.bd-conference *::before,
.bd-conference *::after{
    box-sizing:border-box;
}

.bd-conference a{
    text-decoration:none;
}

.bd-conference-shell{
    width:min(calc(100% - 72px),1180px);
    margin:0 auto;
}

.bd-conference-sr-only{
    position:absolute!important;
    width:1px!important;
    height:1px!important;
    padding:0!important;
    margin:-1px!important;
    overflow:hidden!important;
    clip:rect(0,0,0,0)!important;
    white-space:nowrap!important;
    border:0!important;
}

/* =========================================================
   BRAND
========================================================= */

.bd-conference-brandbar{
    min-height:72px;
    display:flex;
    align-items:center;
    border-bottom:1px solid var(--bdc-line);
}

.bd-conference-brand{
    display:inline-flex;
    align-items:center;
    gap:11px;
}

.bd-conference-brand-mark{
    width:7px;
    height:27px;
    flex:0 0 7px;
    background:var(--bdc-orange);
}

.bd-conference-brand-name{
    color:var(--bdc-navy);
    font-family:Georgia,'Times New Roman',serif;
    font-size:21px;
    line-height:1;
    font-weight:700;
}

.bd-conference-brand-type{
    color:#8D8993;
    font-size:10px;
    line-height:1;
    font-weight:700;
    letter-spacing:.11em;
    text-transform:uppercase;
}

/* =========================================================
   HERO
========================================================= */

.bd-conference-hero{
    position:relative;
    max-width:920px;
    margin:0 auto;
    padding:66px 20px 47px;
    text-align:center;
}

.bd-conference-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:32px;
    padding:7px 13px;

    border:1px solid rgba(217,106,43,.18);
    border-radius:999px;

    background:var(--bdc-soft);
    color:var(--bdc-orange-dark);

    font-size:11px;
    font-weight:800;
    letter-spacing:.09em;
    text-transform:uppercase;
}

.bd-conference-eyebrow-dot{
    width:7px;
    height:7px;
    flex:0 0 7px;
    border-radius:50%;
    background:var(--bdc-orange);
    box-shadow:0 0 0 4px rgba(217,106,43,.10);
}

.bd-conference-title{
    max-width:860px;
    margin:20px auto 0;

    color:var(--bdc-navy);

    font-family:Georgia,'Times New Roman',serif;
    font-size:clamp(38px,4.7vw,60px);
    font-weight:700;
    line-height:1.06;
    letter-spacing:-.035em;
}

.bd-conference-title-accent{
    color:var(--bdc-orange);
}

.bd-conference-description{
    max-width:690px;
    margin:20px auto 0;

    color:var(--bdc-body);

    font-size:14px;
    line-height:1.8;
}

.bd-conference-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    min-height:30px;
    margin-top:20px;
    padding:6px 11px;

    border:1px solid var(--bdc-line);
    border-radius:999px;

    background:#fff;
    color:var(--bdc-muted);

    font-size:11px;
    font-weight:700;
}

.bd-conference-count strong{
    color:var(--bdc-navy);
}

/* =========================================================
   SECTION HEADING
========================================================= */

.bd-conference-list-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:24px;

    padding:28px 0 22px;
    border-top:1px solid var(--bdc-line);
}

.bd-conference-list-kicker{
    display:block;
    margin-bottom:6px;

    color:var(--bdc-orange);

    font-size:11px;
    font-weight:800;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-conference-list-head h2{
    margin:0;

    color:var(--bdc-navy);

    font-family:Georgia,'Times New Roman',serif;
    font-size:30px;
    line-height:1.15;
    font-weight:700;
    letter-spacing:-.025em;
}

.bd-conference-list-head p{
    max-width:420px;
    margin:0;

    color:var(--bdc-muted);

    font-size:13px;
    line-height:1.7;
}

/* =========================================================
   GRID
========================================================= */

.bd-conference-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:24px;
}

/* =========================================================
   CARD
========================================================= */

.bd-conference-card{
    --conference-tone-1:#241B52;
    --conference-tone-2:#6A3156;
    --conference-accent:#D96A2B;
    --conference-accent-soft:#FFF3EA;

    position:relative;
    min-width:0;
    overflow:hidden;

    border:1px solid rgba(36,27,82,.10);
    border-radius:20px;

    background:#fff;
    box-shadow:0 10px 30px rgba(36,27,82,.06);

    transition:
        transform .28s ease,
        box-shadow .28s ease,
        border-color .28s ease;
}

.bd-conference-card::after{
    content:"";
    position:absolute;
    z-index:6;
    left:0;
    top:24px;
    bottom:24px;

    width:4px;

    border-radius:0 4px 4px 0;
    background:var(--conference-accent);

    transform:scaleY(0);
    transform-origin:center;

    transition:transform .28s ease;
}

.bd-conference-card.is-palette-ready{
    border-color:
        color-mix(
            in srgb,
            var(--conference-accent) 22%,
            #E9E2DA
        );
}

/* =========================================================
   CARD TOP — WARNA MENGIKUTI POSTER
========================================================= */

.bd-conference-card-top{
    position:relative;
    isolation:isolate;

    display:grid;
    grid-template-columns:102px minmax(0,1fr);
    gap:24px;
    align-items:center;

    min-height:178px;
    margin:10px;
    padding:24px 25px;

    overflow:hidden;
    border-radius:14px;

    background:
        radial-gradient(
            circle at 92% 8%,
            rgba(255,255,255,.18),
            transparent 34%
        ),
        linear-gradient(
            135deg,
            var(--conference-tone-1) 0%,
            var(--conference-tone-2) 100%
        );
}

.bd-conference-card-poster-bg{
    position:absolute;
    z-index:-3;
    inset:-30px;

    background-position:center;
    background-size:cover;

    filter:
        blur(28px)
        saturate(1.18)
        contrast(1.03);

    transform:scale(1.16);
    opacity:.24;
}

.bd-conference-card-top::before{
    content:"";
    position:absolute;
    z-index:-2;
    inset:0;

    background:
        linear-gradient(
            90deg,
            rgba(10,12,24,.38) 0%,
            rgba(10,12,24,.22) 48%,
            rgba(10,12,24,.13) 100%
        );
}

.bd-conference-card-top::after{
    content:"";
    position:absolute;
    z-index:-1;
    right:-65px;
    top:-80px;

    width:190px;
    height:190px;

    border:1px solid rgba(255,255,255,.18);
    border-radius:50%;

    box-shadow:
        0 0 0 36px rgba(255,255,255,.035);
}

/* =========================================================
   POSTER
========================================================= */

.bd-conference-poster-wrap{
    position:relative;
    z-index:2;

    width:92px;
    margin:0 auto;
}

.bd-conference-poster-wrap::before{
    content:"";
    position:absolute;
    z-index:-1;
    left:7px;
    top:7px;

    width:92px;
    aspect-ratio:3/4;

    border:1px solid rgba(255,255,255,.28);
    border-radius:7px;

    background:rgba(255,255,255,.12);
}

.bd-conference-poster{
    width:92px;
    aspect-ratio:3/4;

    overflow:hidden;

    border:1px solid rgba(255,255,255,.45);
    border-radius:7px;

    background:#fff;
    box-shadow:0 14px 30px rgba(15,11,31,.32);
}

.bd-conference-poster img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
}

.bd-conference-poster-fallback{
    width:100%;
    height:100%;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:10px;

    background:
        linear-gradient(
            145deg,
            #FFF8F1,
            #FFFFFF
        );

    color:var(--bdc-navy);

    font-size:9px;
    line-height:1.35;
    font-weight:800;
    text-align:center;
}

/* =========================================================
   CARD TITLE
========================================================= */

.bd-conference-series-wrap{
    position:relative;
    z-index:2;
    min-width:0;
}

.bd-conference-type{
    display:inline-flex;
    align-items:center;
    gap:7px;

    margin-bottom:10px;

    color:rgba(255,255,255,.82);

    font-size:10px;
    font-weight:800;
    letter-spacing:.11em;
    text-transform:uppercase;
}

.bd-conference-type::before{
    content:"";
    width:6px;
    height:6px;
    flex:0 0 6px;

    border-radius:50%;

    background:var(--conference-accent);
    box-shadow:0 0 0 4px rgba(255,255,255,.12);
}

.bd-conference-series{
    max-width:420px;
    margin:0;

    color:#fff;

    font-family:Georgia,'Times New Roman',serif;
    font-size:clamp(23px,2.2vw,32px);
    font-weight:700;
    line-height:1.13;
    letter-spacing:-.025em;

    text-shadow:0 2px 14px rgba(0,0,0,.18);
}

/* =========================================================
   BODY
========================================================= */

.bd-conference-card-body{
    padding:10px 24px 24px;
}

.bd-conference-theme-wrap{
    padding:10px 0 16px;
    border-bottom:1px solid var(--bdc-line);
}

.bd-conference-theme-label{
    display:block;
    margin-bottom:6px;

    color:var(--conference-accent);

    font-size:10px;
    line-height:1.2;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.bd-conference-theme{
    margin:0;

    color:var(--bdc-navy);

    font-family:Georgia,'Times New Roman',serif;
    font-size:18px;
    line-height:1.45;
    font-weight:700;
}

.bd-conference-card-description-wrap{
    margin:17px 0 20px;
}

.bd-conference-card-description{
    margin:0;

    color:var(--bdc-body);

    font-size:14px;
    line-height:1.75;
}

.bd-conference-card-description:not(.is-expanded){
    display:-webkit-box;
    overflow:hidden;
    -webkit-line-clamp:4;
    -webkit-box-orient:vertical;
}

.bd-conference-readmore{
    display:inline-flex;
    align-items:center;
    gap:6px;

    min-height:34px;
    margin-top:8px;
    padding:4px 0;

    border:0;
    background:transparent;

    color:var(--conference-accent);

    font:inherit;
    font-size:12px;
    line-height:1.4;
    font-weight:800;

    cursor:pointer;
}

.bd-conference-readmore svg{
    width:14px;
    height:14px;
    flex:0 0 14px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;

    transition:transform .2s ease;
}

.bd-conference-readmore[aria-expanded="true"] svg{
    transform:rotate(180deg);
}

.bd-conference-readmore:focus-visible{
    outline:
        3px solid
        color-mix(
            in srgb,
            var(--conference-accent) 28%,
            transparent
        );

    outline-offset:4px;
    border-radius:4px;
}

/* =========================================================
   ACTIONS
========================================================= */

.bd-conference-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.bd-conference-button{
    min-height:46px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    padding:10px 15px;

    border-radius:11px;

    font-size:13px;
    line-height:1.25;
    font-weight:800;
    text-align:center;

    transition:
        transform .2s ease,
        background .2s ease,
        border-color .2s ease,
        box-shadow .2s ease;
}

.bd-conference-button svg{
    width:16px;
    height:16px;
    flex:0 0 16px;

    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-conference-button-secondary{
    border:1px solid var(--bdc-line);
    background:#fff;
    color:var(--bdc-navy)!important;
}

.bd-conference-button-primary{
    border:1px solid var(--conference-tone-1);

    background:
        linear-gradient(
            135deg,
            var(--conference-tone-1),
            var(--conference-tone-2)
        );

    color:#fff!important;
}

.bd-conference-button-disabled{
    border:1px solid #ECE9ED;
    background:#F5F3F5;
    color:#9D98A2!important;
    cursor:not-allowed;
}

.bd-conference-button:focus-visible{
    outline:3px solid rgba(217,106,43,.30);
    outline-offset:3px;
}

/* =========================================================
   EMPTY + PAGINATION
========================================================= */

.bd-conference-empty{
    padding:70px 24px;

    border:1px solid var(--bdc-line);
    border-radius:18px;

    background:#fff;
    color:var(--bdc-muted);

    text-align:center;
    font-size:14px;
}

.bd-conference-pagination{
    margin-top:34px;
}

/* =========================================================
   MOTION
========================================================= */

.bd-conference.bd-conference-motion-ready
[data-conference-reveal]{
    opacity:0;
    transform:translate3d(0,22px,0);

    transition:
        opacity .62s cubic-bezier(.22,.8,.25,1),
        transform .62s cubic-bezier(.22,.8,.25,1);
}

.bd-conference.bd-conference-motion-ready
[data-conference-reveal="left"]{
    transform:translate3d(-32px,12px,0);
}

.bd-conference.bd-conference-motion-ready
[data-conference-reveal="right"]{
    transform:translate3d(32px,12px,0);
}

.bd-conference.bd-conference-motion-ready
[data-conference-reveal].is-visible{
    opacity:1;
    transform:none;
}

.bd-conference [data-conference-delay="1"]{
    transition-delay:.07s;
}

.bd-conference [data-conference-delay="2"]{
    transition-delay:.14s;
}

.bd-conference [data-conference-delay="3"]{
    transition-delay:.21s;
}

.bd-conference [data-conference-delay="4"]{
    transition-delay:.28s;
}

/* =========================================================
   HOVER
========================================================= */

@media(hover:hover) and (pointer:fine){
    .bd-conference-card:hover{
        transform:translateY(-5px);
        border-color:rgba(36,27,82,.16);
        box-shadow:0 22px 52px rgba(36,27,82,.11);
    }

    .bd-conference-card:hover::after{
        transform:scaleY(1);
    }

    .bd-conference-button-secondary:hover{
        border-color:#D9D2DC;
        background:var(--bdc-soft-2);
        transform:translateY(-1px);
    }

    .bd-conference-button-primary:hover{
        box-shadow:0 8px 20px rgba(36,27,82,.17);
        transform:translateY(-1px);
    }
}

/* =========================================================
   TABLET
========================================================= */

@media(max-width:900px){
    .bd-conference-shell{
        width:min(calc(100% - 40px),1180px);
    }

    .bd-conference-grid{
        grid-template-columns:1fr;
    }

    .bd-conference-list-head{
        align-items:flex-start;
        flex-direction:column;
    }
}

/* =========================================================
   MOBILE
========================================================= */

@media(max-width:600px){
    .bd-conference{
        padding-bottom:58px;
    }

    .bd-conference-shell{
        width:calc(100% - 28px);
    }

    .bd-conference-brandbar{
        min-height:60px;
    }

    .bd-conference-brand-type{
        display:none;
    }

    .bd-conference-hero{
        padding:46px 4px 36px;
    }

    .bd-conference-title{
        margin-top:16px;
        font-size:36px;
    }

    .bd-conference-description{
        margin-top:15px;
        font-size:13px;
    }

    .bd-conference-list-head{
        padding:23px 0 18px;
    }

    .bd-conference-list-head h2{
        font-size:26px;
    }

    .bd-conference-card{
        border-radius:17px;
    }

    .bd-conference-card-top{
        grid-template-columns:82px minmax(0,1fr);
        gap:17px;

        min-height:150px;
        margin:8px;
        padding:18px;
    }

    .bd-conference-poster,
    .bd-conference-poster-wrap,
    .bd-conference-poster-wrap::before{
        width:74px;
    }

    .bd-conference-poster-wrap::before{
        left:5px;
        top:5px;
    }

    .bd-conference-type{
        margin-bottom:8px;
        font-size:8px;
    }

    .bd-conference-series{
        font-size:21px;
    }

    .bd-conference-card-body{
        padding:8px 17px 18px;
    }

    .bd-conference-theme{
        font-size:16px;
    }

    .bd-conference-card-description{
        font-size:13px;
    }

    .bd-conference-actions{
        grid-template-columns:1fr;
    }

    .bd-conference-button{
        min-height:48px;
        font-size:13px;
    }

    .bd-conference-readmore{
        min-height:44px;
        padding:8px 0;
        font-size:13px;
    }

    .bd-conference.bd-conference-motion-ready
    [data-conference-reveal="left"],
    .bd-conference.bd-conference-motion-ready
    [data-conference-reveal="right"]{
        transform:translate3d(0,20px,0);
    }
}

/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){
    .bd-conference *,
    .bd-conference *::before,
    .bd-conference *::after{
        scroll-behavior:auto!important;
        animation-duration:.01ms!important;
        animation-iteration-count:1!important;
        transition-duration:.01ms!important;
    }

    .bd-conference [data-conference-reveal]{
        opacity:1!important;
        transform:none!important;
    }
}
</style>

<section
    class="bd-conference"
    id="bdConferencePage"
>
    <div class="bd-conference-shell">

        <div class="bd-conference-brandbar">
            <div
                class="bd-conference-brand"
                data-conference-reveal
            >
                <span class="bd-conference-brand-mark"></span>

                <span class="bd-conference-brand-name">
                    BacaDulu
                </span>

                <span class="bd-conference-brand-type">
                    Conference
                </span>
            </div>
        </div>

        <header class="bd-conference-hero">
            <div
                class="bd-conference-eyebrow"
                data-conference-reveal
            >
                <span class="bd-conference-eyebrow-dot"></span>
                Forum & Publikasi Ilmiah
            </div>

            <h1
                class="bd-conference-title"
                data-conference-reveal
                data-conference-delay="1"
            >
                Jelajahi
                <span class="bd-conference-title-accent">
                    Conference BacaDulu.
                </span>
            </h1>

            <p
                class="bd-conference-description"
                data-conference-reveal
                data-conference-delay="2"
            >
                Temukan conference, forum ilmiah, serta publikasi
                prosiding yang tersedia dalam ekosistem BacaDulu.
            </p>

            <div
                class="bd-conference-count"
                data-conference-reveal
                data-conference-delay="3"
            >
                <strong>{{ $totalConferences }}</strong>
                conference tersedia
            </div>
        </header>

        <div
            class="bd-conference-list-head"
            data-conference-reveal
        >
            <div>
                <span class="bd-conference-list-kicker">
                    Daftar Conference
                </span>

                <h2>
                    Conference & Prosiding
                </h2>
            </div>
        </div>

        @if($conferenceItems->isNotEmpty())

            <div class="bd-conference-grid">

                @foreach($conferenceItems as $conference)

                    @php
                        $series = trim(
                            ($conference->name ?? '') . ' ' .
                            ($conference->edition ?? '')
                        );

                        if ($series === '') {
                            $series = $conference->title ?? 'Conference';
                        }

                        $theme = (
                            !empty($conference->name) ||
                            !empty($conference->edition)
                        )
                            ? ($conference->title ?? null)
                            : null;

                        $poster = !empty($conference->poster)
                            ? asset('storage/' . $conference->poster)
                            : null;

                        $description = trim(
                            strip_tags(
                                (string) ($conference->description ?? '')
                            )
                        );

                        if ($description === '') {
                            $description = 'Deskripsi conference belum tersedia.';
                        }

                        $needsReadMore =
                            \Illuminate\Support\Str::length($description) > 220;

                        $descriptionId =
                            'conference-description-' . $conference->getKey();
                    @endphp

                    <article
                        class="bd-conference-card"
                        data-conference-card
                        data-conference-reveal
                    >

                        <div class="bd-conference-card-top">

                            @if($poster)
                                <div
                                    class="bd-conference-card-poster-bg"
                                    aria-hidden="true"
                                    style="background-image:url('{{ $poster }}');"
                                ></div>
                            @endif

                            <div class="bd-conference-poster-wrap">
                                <div class="bd-conference-poster">

                                    @if($poster)

                                        <img
                                            src="{{ $poster }}"
                                            alt="Poster {{ $series }}"
                                            loading="lazy"
                                            decoding="async"
                                            data-conference-poster
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='flex';
                                            "
                                        >

                                        <div
                                            class="bd-conference-poster-fallback"
                                            style="display:none;"
                                        >
                                            BacaDulu Conference
                                        </div>

                                    @else

                                        <div class="bd-conference-poster-fallback">
                                            BacaDulu Conference
                                        </div>

                                    @endif

                                </div>
                            </div>

                            <div class="bd-conference-series-wrap">

                                <div class="bd-conference-type">
                                    Scientific Conference
                                </div>

                                <h2 class="bd-conference-series">
                                    {{ $series }}
                                </h2>

                            </div>

                        </div>

                        <div class="bd-conference-card-body">

                            @if($theme)
                                <div class="bd-conference-theme-wrap">

                                    <span class="bd-conference-theme-label">
                                        Tema Conference
                                    </span>

                                    <h3 class="bd-conference-theme">
                                        {{ $theme }}
                                    </h3>

                                </div>
                            @endif

                            <div class="bd-conference-card-description-wrap">

                                <p
                                    id="{{ $descriptionId }}"
                                    class="bd-conference-card-description"
                                >
                                    {{ $description }}
                                </p>

                                @if($needsReadMore)
                                    <button
                                        type="button"
                                        class="bd-conference-readmore"
                                        aria-expanded="false"
                                        aria-controls="{{ $descriptionId }}"
                                        data-conference-readmore
                                    >
                                        <span data-conference-readmore-label>
                                            Baca selengkapnya
                                        </span>

                                        <svg
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
                                        >
                                            <path d="m7 10 5 5 5-5"/>
                                        </svg>
                                    </button>
                                @endif

                            </div>

                            <div class="bd-conference-actions">

                                @if(!empty($conference->conference_url))

                                    <a
                                        href="{{ $conference->conference_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="
                                            bd-conference-button
                                            bd-conference-button-secondary
                                        "
                                        aria-label="Lihat conference {{ $series }} di tab baru"
                                    >
                                        <span>
                                            Lihat Conference
                                        </span>

                                        <svg
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
                                        >
                                            <path d="M7 17 17 7"/>
                                            <path d="M8 7h9v9"/>
                                        </svg>

                                        <span class="bd-conference-sr-only">
                                            Terbuka di tab baru
                                        </span>
                                    </a>

                                @else

                                    <span
                                        class="
                                            bd-conference-button
                                            bd-conference-button-disabled
                                        "
                                        aria-disabled="true"
                                    >
                                        Lihat Conference
                                    </span>

                                @endif

                                @if(!empty($conference->proceeding_url))

                                    <a
                                        href="{{ $conference->proceeding_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="
                                            bd-conference-button
                                            bd-conference-button-primary
                                        "
                                        aria-label="Lihat prosiding {{ $series }} di tab baru"
                                    >
                                        <span>
                                            Lihat Prosiding
                                        </span>

                                        <svg
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
                                        >
                                            <path d="M5 12h14"/>
                                            <path d="m14 7 5 5-5 5"/>
                                        </svg>

                                        <span class="bd-conference-sr-only">
                                            Terbuka di tab baru
                                        </span>
                                    </a>

                                @else

                                    <span
                                        class="
                                            bd-conference-button
                                            bd-conference-button-disabled
                                        "
                                        aria-disabled="true"
                                    >
                                        Lihat Prosiding
                                    </span>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div
                class="bd-conference-empty"
                data-conference-reveal
            >
                Belum ada conference yang tersedia.
            </div>

        @endif

        @if(
            method_exists($conferences, 'hasPages')
            &&
            $conferences->hasPages()
        )
            <nav
                class="bd-conference-pagination"
                aria-label="Navigasi halaman conference"
            >
                {{ $conferences->onEachSide(1)->links() }}
            </nav>
        @endif

    </div>
</section>

<script>
(function(){
    function clamp(value,min,max){
        return Math.min(
            max,
            Math.max(min,value)
        );
    }

    function rgbToHsl(r,g,b){
        r/=255;
        g/=255;
        b/=255;

        const max=Math.max(r,g,b);
        const min=Math.min(r,g,b);

        let h=0;
        let s=0;

        const l=(max+min)/2;

        if(max!==min){
            const d=max-min;

            s=l>.5
                ? d/(2-max-min)
                : d/(max+min);

            switch(max){
                case r:
                    h=(g-b)/d+(g<b?6:0);
                    break;

                case g:
                    h=(b-r)/d+2;
                    break;

                default:
                    h=(r-g)/d+4;
            }

            h/=6;
        }

        return [h,s,l];
    }

    function hslToRgb(h,s,l){
        let r;
        let g;
        let b;

        if(s===0){
            r=g=b=l;
        }else{
            const hue2rgb=(p,q,t)=>{
                if(t<0)t+=1;
                if(t>1)t-=1;
                if(t<1/6)return p+(q-p)*6*t;
                if(t<1/2)return q;
                if(t<2/3)return p+(q-p)*(2/3-t)*6;
                return p;
            };

            const q=l<.5
                ? l*(1+s)
                : l+s-l*s;

            const p=2*l-q;

            r=hue2rgb(p,q,h+1/3);
            g=hue2rgb(p,q,h);
            b=hue2rgb(p,q,h-1/3);
        }

        return [
            Math.round(r*255),
            Math.round(g*255),
            Math.round(b*255)
        ];
    }

    function rgbToCss(rgb){
        return `rgb(${rgb[0]} ${rgb[1]} ${rgb[2]})`;
    }

    function mixWithWhite(rgb,amount=.90){
        return rgb.map(channel=>
            Math.round(
                channel+
                (255-channel)*amount
            )
        );
    }

    function colorDistance(a,b){
        return Math.sqrt(
            ((a[0]-b[0])**2)+
            ((a[1]-b[1])**2)+
            ((a[2]-b[2])**2)
        );
    }

    function normalizeTone(
        rgb,
        lightnessMin,
        lightnessMax
    ){
        const [h,s,l]=rgbToHsl(...rgb);

        const normalizedS=
            clamp(s,.42,.82);

        const normalizedL=
            clamp(
                l,
                lightnessMin,
                lightnessMax
            );

        return hslToRgb(
            h,
            normalizedS,
            normalizedL
        );
    }

    function extractConferencePalette(image){
        const canvas=
            document.createElement('canvas');

        const size=42;

        canvas.width=size;
        canvas.height=size;

        const context=
            canvas.getContext(
                '2d',
                {
                    willReadFrequently:true
                }
            );

        if(!context){
            return null;
        }

        context.drawImage(
            image,
            0,
            0,
            size,
            size
        );

        const pixels=
            context.getImageData(
                0,
                0,
                size,
                size
            ).data;

        const buckets=new Map();

        for(
            let i=0;
            i<pixels.length;
            i+=16
        ){
            const alpha=pixels[i+3];

            if(alpha<210){
                continue;
            }

            const r=pixels[i];
            const g=pixels[i+1];
            const b=pixels[i+2];

            const max=
                Math.max(r,g,b);

            const min=
                Math.min(r,g,b);

            const brightness=
                (r+g+b)/3;

            const chroma=
                max-min;

            /*
             * Abaikan area hampir putih, terlalu hitam,
             * dan abu-abu datar supaya warna poster
             * yang lebih representatif terpilih.
             */
            if(
                brightness>242 ||
                brightness<18 ||
                chroma<12
            ){
                continue;
            }

            const qr=
                Math.round(r/32)*32;

            const qg=
                Math.round(g/32)*32;

            const qb=
                Math.round(b/32)*32;

            const key=
                `${qr},${qg},${qb}`;

            const current=
                buckets.get(key) ||
                {
                    count:0,
                    r:0,
                    g:0,
                    b:0
                };

            current.count+=1;
            current.r+=r;
            current.g+=g;
            current.b+=b;

            buckets.set(
                key,
                current
            );
        }

        const candidates=
            [...buckets.values()]
                .map(bucket=>{
                    const rgb=[
                        Math.round(
                            bucket.r/bucket.count
                        ),
                        Math.round(
                            bucket.g/bucket.count
                        ),
                        Math.round(
                            bucket.b/bucket.count
                        )
                    ];

                    const [,s,l]=
                        rgbToHsl(...rgb);

                    const score=
                        bucket.count *
                        (.6+s*1.6) *
                        (
                            1-
                            Math.abs(l-.5)*.45
                        );

                    return {
                        rgb,
                        score
                    };
                })
                .sort(
                    (a,b)=>
                        b.score-a.score
                );

        if(!candidates.length){
            return null;
        }

        const primary=
            candidates[0].rgb;

        let secondary=null;
        let secondaryScore=-1;

        candidates
            .slice(1,18)
            .forEach(candidate=>{
                const distance=
                    colorDistance(
                        primary,
                        candidate.rgb
                    );

                if(distance<72){
                    return;
                }

                const score=
                    candidate.score *
                    (
                        1+
                        distance/441
                    );

                if(score>secondaryScore){
                    secondaryScore=score;
                    secondary=candidate.rgb;
                }
            });

        if(!secondary){
            secondary=
                candidates[
                    Math.min(
                        1,
                        candidates.length-1
                    )
                ].rgb;
        }

        /*
         * Tone sengaja dibuat agak gelap
         * supaya judul putih tetap terbaca.
         */
        const tone1=
            normalizeTone(
                primary,
                .20,
                .33
            );

        const tone2=
            normalizeTone(
                secondary,
                .27,
                .42
            );

        const primaryHsl=
            rgbToHsl(...primary);

        const secondaryHsl=
            rgbToHsl(...secondary);

        const accentSource=
            secondaryHsl[2]>=primaryHsl[2]
                ? secondary
                : primary;

        const accent=
            normalizeTone(
                accentSource,
                .40,
                .55
            );

        const soft=
            mixWithWhite(
                accent,
                .90
            );

        return {
            tone1,
            tone2,
            accent,
            soft
        };
    }

    function applyConferencePalette(
        card,
        image
    ){
        if(
            !card ||
            !image ||
            card.dataset.paletteReady==='1'
        ){
            return;
        }

        try{
            const palette=
                extractConferencePalette(
                    image
                );

            if(!palette){
                return;
            }

            card.style.setProperty(
                '--conference-tone-1',
                rgbToCss(palette.tone1)
            );

            card.style.setProperty(
                '--conference-tone-2',
                rgbToCss(palette.tone2)
            );

            card.style.setProperty(
                '--conference-accent',
                rgbToCss(palette.accent)
            );

            card.style.setProperty(
                '--conference-accent-soft',
                rgbToCss(palette.soft)
            );

            card.dataset.paletteReady='1';
            card.classList.add(
                'is-palette-ready'
            );
        }catch(error){
            /*
             * Kalau sampling poster gagal,
             * warna default BacaDulu tetap dipakai.
             */
        }
    }

    function initConferencePalettes(page){
        if(!page){
            return;
        }

        page
            .querySelectorAll(
                '[data-conference-card]'
            )
            .forEach(card=>{
                const image=
                    card.querySelector(
                        '[data-conference-poster]'
                    );

                if(!image){
                    return;
                }

                if(
                    image.complete &&
                    image.naturalWidth>0
                ){
                    applyConferencePalette(
                        card,
                        image
                    );

                    return;
                }

                if(
                    image.dataset
                        .paletteListener==='1'
                ){
                    return;
                }

                image.dataset
                    .paletteListener='1';

                image.addEventListener(
                    'load',
                    ()=>{
                        applyConferencePalette(
                            card,
                            image
                        );
                    },
                    {
                        once:true
                    }
                );
            });
    }

    function initConferenceReadMore(page){
        if(
            !page ||
            page.dataset.readmoreReady==='1'
        ){
            return;
        }

        page.dataset.readmoreReady='1';

        page.addEventListener(
            'click',
            event=>{
                const button=
                    event.target.closest(
                        '[data-conference-readmore]'
                    );

                if(
                    !button ||
                    !page.contains(button)
                ){
                    return;
                }

                const descriptionId=
                    button.getAttribute(
                        'aria-controls'
                    );

                const description=
                    document.getElementById(
                        descriptionId
                    );

                if(!description){
                    return;
                }

                const isExpanded=
                    button.getAttribute(
                        'aria-expanded'
                    )==='true';

                const nextExpanded=
                    !isExpanded;

                button.setAttribute(
                    'aria-expanded',
                    nextExpanded
                        ? 'true'
                        : 'false'
                );

                description.classList.toggle(
                    'is-expanded',
                    nextExpanded
                );

                const label=
                    button.querySelector(
                        '[data-conference-readmore-label]'
                    );

                if(label){
                    label.textContent=
                        nextExpanded
                            ? 'Tutup'
                            : 'Baca selengkapnya';
                }
            }
        );
    }

    function initConferenceMotion(page){
        if(
            !page ||
            page.dataset.motionReady==='1'
        ){
            return;
        }

        page.dataset.motionReady='1';

        const items=
            Array.from(
                page.querySelectorAll(
                    '[data-conference-reveal]'
                )
            );

        if(!items.length){
            return;
        }

        const reduceMotion=
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

        if(
            reduceMotion ||
            !('IntersectionObserver' in window)
        ){
            items.forEach(
                item=>
                    item.classList.add(
                        'is-visible'
                    )
            );

            return;
        }

        page.classList.add(
            'bd-conference-motion-ready'
        );

        const observer=
            new IntersectionObserver(
                entries=>{
                    entries.forEach(
                        entry=>{
                            if(
                                !entry
                                    .isIntersecting
                            ){
                                return;
                            }

                            entry.target
                                .classList
                                .add(
                                    'is-visible'
                                );

                            observer
                                .unobserve(
                                    entry.target
                                );
                        }
                    );
                },
                {
                    threshold:.12,
                    rootMargin:
                        '0px 0px -6% 0px'
                }
            );

        items.forEach(
            item=>
                observer.observe(item)
        );
    }

    function initConferencePage(){
        const page=
            document.getElementById(
                'bdConferencePage'
            );

        if(!page){
            return;
        }

        initConferenceReadMore(page);
        initConferencePalettes(page);
        initConferenceMotion(page);
    }

    if(
        document.readyState===
        'loading'
    ){
        document.addEventListener(
            'DOMContentLoaded',
            initConferencePage,
            {
                once:true
            }
        );
    }else{
        initConferencePage();
    }

    window.addEventListener(
        'pageshow',
        initConferencePage
    );

    if(
        window.barba &&
        window.barba.hooks &&
        typeof window.barba.hooks.after===
            'function'
    ){
        window.barba.hooks.after(
            ()=>{
                requestAnimationFrame(
                    initConferencePage
                );
            }
        );
    }
})();
</script>

@endsection
