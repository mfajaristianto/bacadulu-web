@extends('layouts.app')

@section('title', 'Baca Jurnal - Baca Dulu')

@section('barba-namespace', 'journal')

@section('content')

@php
    $journalItems = method_exists($jurnals, 'items')
        ? collect($jurnals->items())
        : collect($jurnals);

    $totalJournals = method_exists($jurnals, 'total')
        ? $jurnals->total()
        : $journalItems->count();
@endphp

<style>
.bd-journal{
    --bdj-navy:#241B52;
    --bdj-orange:#D96A2B;
    --bdj-orange-dark:#C94F35;
    --bdj-gold:#F0A52E;
    --bdj-yellow:#F2C94C;
    --bdj-text:#2F3640;
    --bdj-body:#5F636B;
    --bdj-muted:#777B84;
    --bdj-line:#E9E2DA;
    --bdj-soft:#FFF8F1;
    --bdj-soft-2:#FFFCF8;
    width:100%;
    min-height:100vh;
    overflow-x:hidden;
    padding-bottom:76px;
    background:
        linear-gradient(180deg,#FFFFFF 0,#FFFFFF 360px,#FFF9F4 100%);
    color:var(--bdj-text);
    font-family:'Inter',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}

.bd-journal *,
.bd-journal *::before,
.bd-journal *::after{
    box-sizing:border-box;
}

.bd-journal a{
    text-decoration:none;
}

.bd-journal-shell{
    width:min(calc(100% - 72px),1180px);
    margin:0 auto;
}

.bd-journal-sr-only{
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

.bd-journal-brandbar{
    min-height:72px;
    display:flex;
    align-items:center;
    border-bottom:1px solid var(--bdj-line);
}

.bd-journal-brand{
    display:inline-flex;
    align-items:center;
    gap:11px;
}

.bd-journal-brand-mark{
    width:7px;
    height:27px;
    flex:0 0 7px;
    background:var(--bdj-orange);
}

.bd-journal-brand-name{
    color:var(--bdj-navy);
    font-family:Georgia,'Times New Roman',serif;
    font-size:21px;
    line-height:1;
    font-weight:700;
}

.bd-journal-brand-type{
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

.bd-journal-hero{
    position:relative;
    max-width:920px;
    margin:0 auto;
    padding:66px 20px 47px;
    text-align:center;
}

.bd-journal-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:32px;
    padding:7px 13px;
    border:1px solid rgba(217,106,43,.18);
    border-radius:999px;
    background:var(--bdj-soft);
    color:var(--bdj-orange-dark);
    font-size:11px;
    font-weight:800;
    letter-spacing:.09em;
    text-transform:uppercase;
}

.bd-journal-eyebrow-dot{
    width:7px;
    height:7px;
    flex:0 0 7px;
    border-radius:50%;
    background:var(--bdj-orange);
    box-shadow:0 0 0 4px rgba(217,106,43,.10);
}

.bd-journal-title{
    max-width:860px;
    margin:20px auto 0;
    color:var(--bdj-navy);
    font-family:Georgia,'Times New Roman',serif;
    font-size:clamp(38px,4.7vw,60px);
    font-weight:700;
    line-height:1.06;
    letter-spacing:-.035em;
}

.bd-journal-title-accent{
    color:var(--bdj-orange);
}

.bd-journal-description{
    max-width:690px;
    margin:20px auto 0;
    color:var(--bdj-body);
    font-size:14px;
    line-height:1.8;
}

.bd-journal-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:30px;
    margin-top:20px;
    padding:6px 11px;
    border:1px solid var(--bdj-line);
    border-radius:999px;
    background:#fff;
    color:var(--bdj-muted);
    font-size:11px;
    font-weight:700;
}

.bd-journal-count strong{
    color:var(--bdj-navy);
}

/* =========================================================
   SECTION HEADING
========================================================= */

.bd-journal-list-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:24px;
    padding:28px 0 22px;
    border-top:1px solid var(--bdj-line);
}

.bd-journal-list-kicker{
    display:block;
    margin-bottom:6px;
    color:var(--bdj-orange);
    font-size:11px;
    font-weight:800;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-journal-list-head h2{
    margin:0;
    color:var(--bdj-navy);
    font-family:Georgia,'Times New Roman',serif;
    font-size:30px;
    line-height:1.15;
    font-weight:700;
    letter-spacing:-.025em;
}

.bd-journal-list-head p{
    max-width:420px;
    margin:0;
    color:var(--bdj-muted);
    font-size:13px;
    line-height:1.7;
}

/* =========================================================
   GRID
========================================================= */

.bd-journal-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:24px;
}

/* =========================================================
   CARD
========================================================= */

.bd-journal-card{
    --journal-tone-1:#241B52;
    --journal-tone-2:#7B3A43;
    --journal-accent:#D96A2B;
    --journal-accent-soft:#FFF3EA;
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

.bd-journal-card::after{
    content:"";
    position:absolute;
    z-index:6;
    left:0;
    top:24px;
    bottom:24px;
    width:4px;
    border-radius:0 4px 4px 0;
    background:var(--journal-accent);
    transform:scaleY(0);
    transform-origin:center;
    transition:transform .28s ease;
}

.bd-journal-card.is-palette-ready{
    border-color:color-mix(in srgb,var(--journal-accent) 22%,#E9E2DA);
}

/* =========================================================
   CARD TOP - WARNA MENGIKUTI COVER
========================================================= */

.bd-journal-card-top{
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
        radial-gradient(circle at 92% 8%,rgba(255,255,255,.18),transparent 34%),
        linear-gradient(135deg,var(--journal-tone-1) 0%,var(--journal-tone-2) 100%);
}

.bd-journal-card-cover-bg{
    position:absolute;
    z-index:-3;
    inset:-30px;
    background-position:center;
    background-size:cover;
    filter:blur(28px) saturate(1.18) contrast(1.03);
    transform:scale(1.16);
    opacity:.24;
}

.bd-journal-card-top::before{
    content:"";
    position:absolute;
    z-index:-2;
    inset:0;
    background:
        linear-gradient(
            90deg,
            rgba(10,12,24,.36) 0%,
            rgba(10,12,24,.20) 48%,
            rgba(10,12,24,.12) 100%
        );
}

.bd-journal-card-top::after{
    content:"";
    position:absolute;
    z-index:-1;
    right:-65px;
    top:-80px;
    width:190px;
    height:190px;
    border:1px solid rgba(255,255,255,.18);
    border-radius:50%;
    box-shadow:0 0 0 36px rgba(255,255,255,.035);
}

/* =========================================================
   COVER
========================================================= */

.bd-journal-cover-wrap{
    position:relative;
    z-index:2;
    width:92px;
    margin:0 auto;
}

.bd-journal-cover-wrap::before{
    content:"";
    position:absolute;
    left:7px;
    top:7px;
    z-index:-1;
    width:92px;
    aspect-ratio:3/4;
    border:1px solid rgba(255,255,255,.28);
    border-radius:7px;
    background:rgba(255,255,255,.12);
}

.bd-journal-cover{
    width:92px;
    aspect-ratio:3/4;
    overflow:hidden;
    border:1px solid rgba(255,255,255,.45);
    border-radius:7px;
    background:#fff;
    box-shadow:0 14px 30px rgba(15,11,31,.32);
}

.bd-journal-cover img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
}

.bd-journal-cover-fallback{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:10px;
    background:linear-gradient(145deg,#FFF8F1,#fff);
    color:var(--bdj-navy);
    font-size:10px;
    line-height:1.35;
    font-weight:800;
    text-align:center;
}

/* =========================================================
   CARD TITLE
========================================================= */

.bd-journal-name-wrap{
    position:relative;
    z-index:2;
    min-width:0;
}

.bd-journal-type{
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

.bd-journal-type::before{
    content:"";
    width:6px;
    height:6px;
    flex:0 0 6px;
    border-radius:50%;
    background:var(--journal-accent);
    box-shadow:0 0 0 4px rgba(255,255,255,.12);
}

.bd-journal-card-name{
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

.bd-journal-card-body{
    padding:10px 24px 24px;
}

.bd-journal-meta{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    padding:10px 0 16px;
    border-bottom:1px solid var(--bdj-line);
}

.bd-journal-meta-item{
    display:inline-flex;
    align-items:center;
    gap:7px;
    min-height:30px;
    padding:5px 9px;
    border-radius:8px;
    background:#F8F7F9;
    color:#68636F;
    font-size:12px;
    line-height:1.2;
}

.bd-journal-meta-item strong{
    color:var(--bdj-navy);
    font-size:11px;
    font-weight:800;
}

.bd-journal-card-description-wrap{
    margin:17px 0 20px;
}

.bd-journal-card-description{
    margin:0;
    color:var(--bdj-body);
    font-size:14px;
    line-height:1.75;
}

.bd-journal-card-description:not(.is-expanded){
    display:-webkit-box;
    overflow:hidden;
    -webkit-line-clamp:4;
    -webkit-box-orient:vertical;
}

.bd-journal-readmore{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:8px;
    padding:0;
    border:0;
    background:transparent;
    color:var(--journal-accent);
    font:inherit;
    font-size:12px;
    line-height:1.4;
    font-weight:800;
    cursor:pointer;
}

.bd-journal-readmore svg{
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

.bd-journal-readmore[aria-expanded="true"] svg{
    transform:rotate(180deg);
}

.bd-journal-readmore:focus-visible{
    outline:3px solid color-mix(in srgb,var(--journal-accent) 28%,transparent);
    outline-offset:4px;
    border-radius:4px;
}

/* =========================================================
   ACTIONS
========================================================= */

.bd-journal-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.bd-journal-button{
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

.bd-journal-button svg{
    width:16px;
    height:16px;
    flex:0 0 16px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-journal-button-secondary{
    border:1px solid var(--bdj-line);
    background:#fff;
    color:var(--bdj-navy)!important;
}

.bd-journal-button-primary{
    border:1px solid var(--journal-tone-1);
    background:linear-gradient(135deg,var(--journal-tone-1),var(--journal-tone-2));
    color:#fff!important;
}

.bd-journal-button-disabled{
    border:1px solid #ECE9ED;
    background:#F5F3F5;
    color:#9D98A2!important;
    cursor:not-allowed;
}

.bd-journal-button:focus-visible{
    outline:3px solid rgba(217,106,43,.30);
    outline-offset:3px;
}

/* =========================================================
   EMPTY + PAGINATION
========================================================= */

.bd-journal-empty{
    padding:70px 24px;
    border:1px solid var(--bdj-line);
    border-radius:18px;
    background:#fff;
    color:var(--bdj-muted);
    text-align:center;
    font-size:14px;
}

.bd-journal-pagination{
    margin-top:34px;
}

/* =========================================================
   MOTION - HANYA AKTIF SETELAH JS SIAP
========================================================= */

.bd-journal.bd-journal-motion-ready [data-journal-reveal]{
    opacity:0;
    transform:translate3d(0,22px,0);
    transition:
        opacity .62s cubic-bezier(.22,.8,.25,1),
        transform .62s cubic-bezier(.22,.8,.25,1);
}

.bd-journal.bd-journal-motion-ready [data-journal-reveal="left"]{
    transform:translate3d(-32px,12px,0);
}

.bd-journal.bd-journal-motion-ready [data-journal-reveal="right"]{
    transform:translate3d(32px,12px,0);
}

.bd-journal.bd-journal-motion-ready [data-journal-reveal].is-visible{
    opacity:1;
    transform:none;
}

.bd-journal [data-journal-delay="1"]{transition-delay:.07s}
.bd-journal [data-journal-delay="2"]{transition-delay:.14s}
.bd-journal [data-journal-delay="3"]{transition-delay:.21s}
.bd-journal [data-journal-delay="4"]{transition-delay:.28s}

/* =========================================================
   HOVER
========================================================= */

@media(hover:hover) and (pointer:fine){
    .bd-journal-card:hover{
        transform:translateY(-5px);
        border-color:rgba(36,27,82,.16);
        box-shadow:0 22px 52px rgba(36,27,82,.11);
    }

    .bd-journal-card:hover::after{
        transform:scaleY(1);
    }

    .bd-journal-button-secondary:hover{
        border-color:#D9D2DC;
        background:var(--bdj-soft-2);
        transform:translateY(-1px);
    }

    .bd-journal-button-primary:hover{
        background:#302662;
        box-shadow:0 8px 20px rgba(36,27,82,.17);
        transform:translateY(-1px);
    }
}

/* =========================================================
   TABLET
========================================================= */

@media(max-width:900px){
    .bd-journal-shell{
        width:calc(100% - 40px);
    }

    .bd-journal-list-head{
        align-items:flex-start;
        flex-direction:column;
    }

    .bd-journal-list-head p{
        max-width:650px;
    }

    .bd-journal-grid{
        grid-template-columns:1fr;
        max-width:720px;
        margin:0 auto;
    }
}

/* =========================================================
   MOBILE — ACCESSIBLE / LOW MOTION
========================================================= */

@media(max-width:600px){
    .bd-journal{
        padding-bottom:54px;
        overscroll-behavior-x:none;
    }

    .bd-journal-shell{
        width:calc(100% - 32px);
    }

    .bd-journal-brandbar{
        min-height:62px;
    }

    .bd-journal-brand{
        gap:8px;
    }

    .bd-journal-brand-mark{
        width:6px;
        height:23px;
        flex-basis:6px;
    }

    .bd-journal-brand-name{
        font-size:19px;
    }

    .bd-journal-brand-type{
        display:inline-block;
        font-size:9px;
        letter-spacing:.09em;
    }

    .bd-journal-hero{
        padding:43px 2px 35px;
    }

    .bd-journal-eyebrow{
        min-height:30px;
        padding:6px 11px;
        font-size:9px;
        letter-spacing:.07em;
    }

    .bd-journal-title{
        margin-top:17px;
        font-size:clamp(32px,9.2vw,36px);
        line-height:1.08;
        letter-spacing:-.03em;
    }

    .bd-journal-description{
        max-width:34rem;
        margin-top:16px;
        font-size:14px;
        line-height:1.72;
    }

    .bd-journal-count{
        min-height:34px;
        margin-top:17px;
        padding:7px 12px;
        font-size:11px;
    }

    .bd-journal-list-head{
        gap:10px;
        padding-top:22px;
        padding-bottom:18px;
    }

    .bd-journal-list-kicker{
        font-size:10px;
    }

    .bd-journal-list-head h2{
        font-size:26px;
        line-height:1.18;
    }

    .bd-journal-list-head p{
        font-size:13px;
        line-height:1.65;
    }

    .bd-journal-grid{
        gap:18px;
    }

    .bd-journal-card{
        border-radius:17px;
        box-shadow:0 8px 24px rgba(36,27,82,.07);
    }

    .bd-journal-card::after{
        top:18px;
        bottom:18px;
        width:3px;
    }

    .bd-journal-card-top{
        grid-template-columns:76px minmax(0,1fr);
        gap:16px;
        min-height:140px;
        margin:8px;
        padding:18px 16px;
        border-radius:12px;
    }

    .bd-journal-card-cover-bg{
        filter:blur(22px) saturate(1.08) contrast(1.02);
        opacity:.20;
    }

    .bd-journal-cover-wrap,
    .bd-journal-cover{
        width:70px;
    }

    .bd-journal-cover-wrap::before{
        width:70px;
        left:5px;
        top:5px;
    }

    .bd-journal-type{
        gap:6px;
        margin-bottom:7px;
        font-size:8px;
        letter-spacing:.09em;
    }

    .bd-journal-card-name{
        font-size:clamp(19px,5.6vw,22px);
        line-height:1.16;
        text-wrap:balance;
    }

    .bd-journal-card-body{
        padding:7px 16px 17px;
    }

    .bd-journal-meta{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:8px;
        padding:9px 0 14px;
    }

    .bd-journal-meta-item{
        min-width:0;
        min-height:38px;
        display:flex;
        align-items:flex-start;
        justify-content:center;
        flex-direction:column;
        gap:2px;
        padding:7px 9px;
        font-size:12px;
        overflow-wrap:anywhere;
    }

    .bd-journal-meta-item strong{
        font-size:10px;
    }

    .bd-journal-card-description-wrap{
        margin:15px 0 17px;
    }

    .bd-journal-card-description{
        font-size:14px;
        line-height:1.72;
    }

    .bd-journal-card-description:not(.is-expanded){
        -webkit-line-clamp:4;
    }

    .bd-journal-readmore{
        min-height:44px;
        margin-top:3px;
        padding:8px 2px;
        font-size:13px;
        touch-action:manipulation;
    }

    .bd-journal-readmore svg{
        width:15px;
        height:15px;
    }

    .bd-journal-actions{
        grid-template-columns:1fr;
        gap:9px;
    }

    .bd-journal-button{
        min-height:52px;
        padding:12px 16px;
        border-radius:11px;
        font-size:14px;
        touch-action:manipulation;
    }

    .bd-journal-button svg{
        width:17px;
        height:17px;
        flex-basis:17px;
    }

    /* Di layar kecil hindari gerakan horizontal kiri/kanan yang berlebihan. */
    .bd-journal.bd-journal-motion-ready [data-journal-reveal],
    .bd-journal.bd-journal-motion-ready [data-journal-reveal="left"],
    .bd-journal.bd-journal-motion-ready [data-journal-reveal="right"]{
        transform:translate3d(0,12px,0);
        transition-duration:.48s;
    }

    .bd-journal [data-journal-delay="1"]{transition-delay:.03s}
    .bd-journal [data-journal-delay="2"]{transition-delay:.06s}
    .bd-journal [data-journal-delay="3"]{transition-delay:.09s}
    .bd-journal [data-journal-delay="4"]{transition-delay:.12s}
}

/* =========================================================
   SMALL PHONE 320–360px
========================================================= */

@media(max-width:360px){
    .bd-journal-shell{
        width:calc(100% - 28px);
    }

    .bd-journal-brand-name{
        font-size:18px;
    }

    .bd-journal-brand-type{
        font-size:8px;
    }

    .bd-journal-hero{
        padding-top:38px;
    }

    .bd-journal-title{
        font-size:31px;
    }

    .bd-journal-description{
        font-size:13.5px;
    }

    .bd-journal-card-top{
        grid-template-columns:68px minmax(0,1fr);
        gap:13px;
        min-height:132px;
        padding:16px 13px;
    }

    .bd-journal-cover-wrap,
    .bd-journal-cover{
        width:62px;
    }

    .bd-journal-cover-wrap::before{
        width:62px;
    }

    .bd-journal-card-name{
        font-size:18px;
    }

    .bd-journal-meta{
        grid-template-columns:1fr;
        gap:6px;
    }

    .bd-journal-meta-item{
        min-height:36px;
        flex-direction:row;
        align-items:center;
        justify-content:flex-start;
        gap:7px;
    }

    .bd-journal-button{
        min-height:50px;
        font-size:13.5px;
    }
}

/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){
    .bd-journal *,
    .bd-journal *::before,
    .bd-journal *::after{
        animation-duration:.01ms!important;
        animation-iteration-count:1!important;
        transition-duration:.01ms!important;
        scroll-behavior:auto!important;
    }

    .bd-journal.bd-journal-motion-ready [data-journal-reveal]{
        opacity:1!important;
        transform:none!important;
    }
}
</style>

<section class="bd-journal" id="bdJournalPage">

    <div class="bd-journal-shell">

        {{-- BRAND --}}
        <div class="bd-journal-brandbar">
            <div class="bd-journal-brand" data-journal-reveal>
                <span class="bd-journal-brand-mark" aria-hidden="true"></span>
                <span class="bd-journal-brand-name">BacaDulu</span>
                <span class="bd-journal-brand-type">Journal</span>
            </div>
        </div>

        {{-- HERO --}}
        <header class="bd-journal-hero" data-journal-reveal>

            <div class="bd-journal-eyebrow">
                <span class="bd-journal-eyebrow-dot" aria-hidden="true"></span>
                Publikasi Ilmiah BacaDulu
            </div>

            <h1 class="bd-journal-title">
                Ruang publikasi untuk pengetahuan
                <span class="bd-journal-title-accent">yang terus bertumbuh.</span>
            </h1>

            <p class="bd-journal-description">
                Temukan jurnal ilmiah dalam ekosistem BacaDulu sebagai ruang publikasi,
                referensi, dan penyebaran pengetahuan untuk mendukung riset yang
                berkualitas serta mudah diakses pembaca.
            </p>

            <div class="bd-journal-count" aria-label="Jumlah jurnal tersedia">
                <strong>{{ $totalJournals }}</strong>
                <span>jurnal tersedia</span>
            </div>

        </header>

        {{-- LIST HEADING --}}
        <div class="bd-journal-list-head" data-journal-reveal>

            <div>
                <span class="bd-journal-list-kicker">Katalog Jurnal</span>
                <h2>Pilih jurnal yang ingin Anda jelajahi.</h2>
            </div>
        </div>

        {{-- GRID --}}
        @if($journalItems->isNotEmpty())

            <div class="bd-journal-grid">

                @foreach($journalItems as $index => $jurnal)

                    @php
                        $revealDirection = $index % 2 === 0 ? 'left' : 'right';

                        $journalDescription = trim(
                            preg_replace(
                                '/\s+/',
                                ' ',
                                strip_tags($jurnal->deskripsi ?? '')
                            )
                        );

                        $hasLongDescription =
                            \Illuminate\Support\Str::length($journalDescription) > 180;

                        $descriptionId =
                            'journal-description-' . ($jurnal->id ?? $index);
                    @endphp

                    <article
                        class="bd-journal-card"
                        data-journal-card
                        data-journal-reveal="{{ $revealDirection }}"
                        data-journal-delay="{{ ($index % 4) + 1 }}"
                    >

                        <div class="bd-journal-card-top">

                            @if(!empty($jurnal->gambar))
                                <div
                                    class="bd-journal-card-cover-bg"
                                    aria-hidden="true"
                                    style="background-image:url('{{ asset('storage/' . $jurnal->gambar) }}');"
                                ></div>
                            @endif

                            <div class="bd-journal-cover-wrap">

                                <div class="bd-journal-cover">

                                    @if(!empty($jurnal->gambar))

                                        <img
                                            src="{{ asset('storage/' . $jurnal->gambar) }}"
                                            alt="Cover jurnal {{ $jurnal->judul }}"
                                            data-journal-cover
                                            loading="lazy"
                                            decoding="async"
                                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                        >

                                        <div
                                            class="bd-journal-cover-fallback"
                                            style="display:none;"
                                        >
                                            BacaDulu Journal
                                        </div>

                                    @else

                                        <div class="bd-journal-cover-fallback">
                                            BacaDulu Journal
                                        </div>

                                    @endif

                                </div>

                            </div>

                            <div class="bd-journal-name-wrap">

                                <div class="bd-journal-type">
                                    Scientific Journal
                                </div>

                                <h3 class="bd-journal-card-name">
                                    {{ $jurnal->judul }}
                                </h3>

                            </div>

                        </div>

                        <div class="bd-journal-card-body">

                            <div class="bd-journal-meta" aria-label="Identitas jurnal">

                                <span class="bd-journal-meta-item">
                                    <strong>E-ISSN</strong>
                                    <span>{{ $jurnal->e_issn ?: 'Belum tersedia' }}</span>
                                </span>

                                <span class="bd-journal-meta-item">
                                    <strong>P-ISSN</strong>
                                    <span>{{ $jurnal->p_issn ?: 'Belum tersedia' }}</span>
                                </span>

                            </div>

                            <div class="bd-journal-card-description-wrap">

                                <p
                                    id="{{ $descriptionId }}"
                                    class="bd-journal-card-description"
                                >
                                    {{
                                        $journalDescription
                                        ?: 'Deskripsi jurnal belum tersedia.'
                                    }}
                                </p>

                                @if($hasLongDescription)

                                    <button
                                        type="button"
                                        class="bd-journal-readmore"
                                        data-journal-readmore
                                        aria-expanded="false"
                                        aria-controls="{{ $descriptionId }}"
                                    >
                                        <span data-journal-readmore-label>
                                            Baca selengkapnya
                                        </span>

                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="m7 10 5 5 5-5"/>
                                        </svg>
                                    </button>

                                @endif

                            </div>

                            <div class="bd-journal-actions">

                                @if(!empty($jurnal->journal_url))

                                    <a
                                        href="{{ $jurnal->journal_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="bd-journal-button bd-journal-button-secondary"
                                        aria-label="Lihat jurnal {{ $jurnal->judul }} di tab baru"
                                    >
                                        <span>Lihat Jurnal</span>

                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M7 17L17 7"/>
                                            <path d="M8 7h9v9"/>
                                        </svg>

                                        <span class="bd-journal-sr-only">
                                            Terbuka di tab baru
                                        </span>
                                    </a>

                                @else

                                    <span
                                        class="bd-journal-button bd-journal-button-disabled"
                                        aria-disabled="true"
                                    >
                                        Lihat Jurnal
                                    </span>

                                @endif

                                @if(!empty($jurnal->current_issue_url))

                                    <a
                                        href="{{ $jurnal->current_issue_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="bd-journal-button bd-journal-button-primary"
                                        aria-label="Buka edisi terkini {{ $jurnal->judul }} di tab baru"
                                    >
                                        <span>Edisi Terkini</span>

                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M5 12h14"/>
                                            <path d="m14 7 5 5-5 5"/>
                                        </svg>

                                        <span class="bd-journal-sr-only">
                                            Terbuka di tab baru
                                        </span>
                                    </a>

                                @else

                                    <span
                                        class="bd-journal-button bd-journal-button-disabled"
                                        aria-disabled="true"
                                    >
                                        Edisi Terkini
                                    </span>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="bd-journal-empty" data-journal-reveal>
                Belum ada jurnal yang tersedia.
            </div>

        @endif

        @if(method_exists($jurnals, 'hasPages') && $jurnals->hasPages())
            <nav class="bd-journal-pagination" aria-label="Navigasi halaman jurnal">
                {{ $jurnals->links() }}
            </nav>
        @endif

    </div>

</section>

<script>
(function(){
    function clamp(value,min,max){
        return Math.min(max,Math.max(min,value));
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
            Math.round(channel+(255-channel)*amount)
        );
    }

    function colorDistance(a,b){
        return Math.sqrt(
            ((a[0]-b[0])**2)+
            ((a[1]-b[1])**2)+
            ((a[2]-b[2])**2)
        );
    }

    function normalizeTone(rgb,lightnessMin,lightnessMax){
        const [h,s,l]=rgbToHsl(...rgb);
        const normalizedS=clamp(s,0.42,0.82);
        const normalizedL=clamp(l,lightnessMin,lightnessMax);
        return hslToRgb(h,normalizedS,normalizedL);
    }

    function extractJournalPalette(image){
        const canvas=document.createElement('canvas');
        const size=42;
        canvas.width=size;
        canvas.height=size;

        const context=canvas.getContext('2d',{willReadFrequently:true});

        if(!context){
            return null;
        }

        context.drawImage(image,0,0,size,size);

        const pixels=context.getImageData(0,0,size,size).data;
        const buckets=new Map();

        for(let i=0;i<pixels.length;i+=16){
            const alpha=pixels[i+3];

            if(alpha<210){
                continue;
            }

            const r=pixels[i];
            const g=pixels[i+1];
            const b=pixels[i+2];

            const max=Math.max(r,g,b);
            const min=Math.min(r,g,b);
            const brightness=(r+g+b)/3;
            const chroma=max-min;

            if(brightness>242 || brightness<18 || chroma<12){
                continue;
            }

            const qr=Math.round(r/32)*32;
            const qg=Math.round(g/32)*32;
            const qb=Math.round(b/32)*32;
            const key=`${qr},${qg},${qb}`;
            const current=buckets.get(key) || {
                count:0,
                r:0,
                g:0,
                b:0
            };

            current.count+=1;
            current.r+=r;
            current.g+=g;
            current.b+=b;
            buckets.set(key,current);
        }

        const candidates=[...buckets.values()]
            .map(bucket=>{
                const rgb=[
                    Math.round(bucket.r/bucket.count),
                    Math.round(bucket.g/bucket.count),
                    Math.round(bucket.b/bucket.count)
                ];

                const [,s,l]=rgbToHsl(...rgb);
                const score=bucket.count*(.6+s*1.6)*(1-Math.abs(l-.5)*.45);

                return {
                    rgb,
                    score
                };
            })
            .sort((a,b)=>b.score-a.score);

        if(!candidates.length){
            return null;
        }

        const primary=candidates[0].rgb;
        let secondary=null;
        let secondaryScore=-1;

        candidates.slice(1,18).forEach(candidate=>{
            const distance=colorDistance(primary,candidate.rgb);

            if(distance<72){
                return;
            }

            const score=candidate.score*(1+distance/441);

            if(score>secondaryScore){
                secondaryScore=score;
                secondary=candidate.rgb;
            }
        });

        if(!secondary){
            secondary=candidates[Math.min(1,candidates.length-1)].rgb;
        }

        const tone1=normalizeTone(primary,.21,.34);
        const tone2=normalizeTone(secondary,.28,.43);

        const primaryHsl=rgbToHsl(...primary);
        const secondaryHsl=rgbToHsl(...secondary);
        const accentSource=secondaryHsl[2]>=primaryHsl[2]
            ? secondary
            : primary;

        const accent=normalizeTone(accentSource,.40,.55);
        const soft=mixWithWhite(accent,.90);

        return {
            tone1,
            tone2,
            accent,
            soft
        };
    }

    function applyJournalPalette(card,image){
        if(!card || !image || card.dataset.paletteReady==='1'){
            return;
        }

        try{
            const palette=extractJournalPalette(image);

            if(!palette){
                return;
            }

            card.style.setProperty(
                '--journal-tone-1',
                rgbToCss(palette.tone1)
            );

            card.style.setProperty(
                '--journal-tone-2',
                rgbToCss(palette.tone2)
            );

            card.style.setProperty(
                '--journal-accent',
                rgbToCss(palette.accent)
            );

            card.style.setProperty(
                '--journal-accent-soft',
                rgbToCss(palette.soft)
            );

            card.dataset.paletteReady='1';
            card.classList.add('is-palette-ready');
        }catch(error){
            /* Bila sampling cover gagal, gradient default tetap dipakai. */
        }
    }

    function initJournalPalettes(page){
        if(!page){
            return;
        }

        page.querySelectorAll('[data-journal-card]').forEach(card=>{
            const image=card.querySelector('[data-journal-cover]');

            if(!image){
                return;
            }

            if(image.complete && image.naturalWidth>0){
                applyJournalPalette(card,image);
                return;
            }

            if(image.dataset.paletteListener==='1'){
                return;
            }

            image.dataset.paletteListener='1';

            image.addEventListener(
                'load',
                ()=>applyJournalPalette(card,image),
                {once:true}
            );
        });
    }

    function initJournalReadMore(page){
        if(!page || page.dataset.readmoreReady==='1'){
            return;
        }

        page.dataset.readmoreReady='1';

        page.addEventListener('click',event=>{
            const button=event.target.closest('[data-journal-readmore]');

            if(!button || !page.contains(button)){
                return;
            }

            const descriptionId=button.getAttribute('aria-controls');
            const description=document.getElementById(descriptionId);

            if(!description){
                return;
            }

            const isExpanded=button.getAttribute('aria-expanded')==='true';
            const nextExpanded=!isExpanded;

            button.setAttribute(
                'aria-expanded',
                nextExpanded ? 'true' : 'false'
            );

            description.classList.toggle(
                'is-expanded',
                nextExpanded
            );

            const label=button.querySelector('[data-journal-readmore-label]');

            if(label){
                label.textContent=nextExpanded
                    ? 'Tutup'
                    : 'Baca selengkapnya';
            }
        });
    }

    function initJournalPage(){
        const page=document.getElementById('bdJournalPage');

        if(!page){
            return;
        }

        initJournalReadMore(page);
        initJournalPalettes(page);

        if(page.dataset.motionReady==='1'){
            return;
        }

        page.dataset.motionReady='1';

        const items=Array.from(
            page.querySelectorAll('[data-journal-reveal]')
        );

        if(!items.length){
            return;
        }

        const reduceMotion=window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        if(reduceMotion || !('IntersectionObserver' in window)){
            items.forEach(item=>item.classList.add('is-visible'));
            return;
        }

        page.classList.add('bd-journal-motion-ready');

        const observer=new IntersectionObserver(
            entries=>{
                entries.forEach(entry=>{
                    if(!entry.isIntersecting){
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold:.12,
                rootMargin:'0px 0px -6% 0px'
            }
        );

        items.forEach(item=>observer.observe(item));
    }

    if(document.readyState==='loading'){
        document.addEventListener(
            'DOMContentLoaded',
            initJournalPage,
            {once:true}
        );
    }else{
        initJournalPage();
    }

    window.addEventListener('pageshow',initJournalPage);

    if(
        window.barba &&
        window.barba.hooks &&
        typeof window.barba.hooks.after==='function'
    ){
        window.barba.hooks.after(()=>{
            requestAnimationFrame(initJournalPage);
        });
    }
})();
</script>

@endsection
