@extends('layouts.app')

@section('title', 'Baca Informasi - Baca Dulu')

@section('content')

@php
    $pinnedInformation = $pinnedInformation ?? null;

    $latestInformations = isset($latestInformations)
        ? collect($latestInformations)
        : (isset($informations) ? collect($informations->items())->take(3) : collect());

    $allInformations = isset($allInformations)
        ? collect($allInformations)
        : collect();

    $totalInformations = $totalInformations
        ?? (isset($informations) ? $informations->total() : $latestInformations->count());

    $lastUpdateText = '-';

    if (!empty($lastUpdate)) {
        $lastUpdateText = \Illuminate\Support\Carbon::parse($lastUpdate)
            ->timezone('Asia/Jakarta')
            ->translatedFormat('d M Y');
    } elseif ($latestInformations->first()?->created_at) {
        $lastUpdateText = $latestInformations->first()
            ->created_at
            ->timezone('Asia/Jakarta')
            ->translatedFormat('d M Y');
    }
@endphp

<style>
.bd-information{
    --navy:#241B52;
    --navy-soft:#332A63;
    --orange:#EF5843;
    --orange-soft:#F2753D;
    --gold:#F7AA35;
    --cream:#FFF8EE;
    --warm:#FFFCF8;
    --text:#29292B;
    --muted:#727680;
    --soft:#999CA3;
    --border:#EAE4DD;
    --white:#FFFFFF;
    min-height:100vh;
    overflow:hidden;
    background:#fff;
    color:var(--text);
    font-family:'Inter',sans-serif;
}
.bd-information *,
.bd-information *::before,
.bd-information *::after{box-sizing:border-box}
.bd-information a{text-decoration:none}
.bd-info-shell{width:min(calc(100% - 40px),1080px);margin-inline:auto}

/* HERO */
.bd-info-hero{
    position:relative;
    padding:48px 0 31px;
    overflow:hidden;
    border-bottom:1px solid #F0ECE7;
    background:
        radial-gradient(circle at 91% 15%,rgba(247,170,53,.11),transparent 24%),
        radial-gradient(circle at 4% 100%,rgba(239,88,67,.055),transparent 22%),
        #fff;
}
.bd-info-hero::after{
    content:"";
    position:absolute;
    width:260px;
    height:260px;
    right:-145px;
    top:-130px;
    border:1px solid rgba(239,88,67,.08);
    border-radius:50%;
    box-shadow:0 0 0 38px rgba(247,170,53,.025),0 0 0 76px rgba(239,88,67,.018);
    pointer-events:none;
}
.bd-info-hero-layout{
    position:relative;
    z-index:2;
    display:grid;
    grid-template-columns:minmax(0,1fr) 145px;
    gap:45px;
    align-items:end;
}
.bd-info-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:9px;
    margin-bottom:11px;
    color:var(--orange);
    font-size:8px;
    font-weight:850;
    letter-spacing:.16em;
    text-transform:uppercase;
}
.bd-info-eyebrow::before{
    content:"";
    width:25px;
    height:3px;
    border-radius:99px;
    background:linear-gradient(90deg,var(--orange),var(--gold));
}
.bd-info-title{
    max-width:650px;
    margin:0 0 11px;
    color:var(--navy);
    font-family:'Poppins',sans-serif;
    font-size:clamp(36px,4vw,52px);
    font-weight:750;
    line-height:1.07;
    letter-spacing:-.045em;
}
.bd-info-title span{
    background:linear-gradient(90deg,var(--orange),var(--orange-soft),var(--gold));
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
}
.bd-info-description{
    max-width:565px;
    margin:0;
    color:var(--muted);
    font-size:11px;
    line-height:1.75;
}
.bd-info-stat{text-align:right}
.bd-info-stat strong{
    display:block;
    color:var(--orange);
    font-family:'Poppins',sans-serif;
    font-size:36px;
    font-weight:750;
    line-height:1;
    letter-spacing:-.05em;
}
.bd-info-stat span{
    display:block;
    margin-top:5px;
    color:var(--navy);
    font-size:7.5px;
    font-weight:850;
    letter-spacing:.1em;
    text-transform:uppercase;
}
.bd-info-stat small{
    display:block;
    margin-top:6px;
    color:var(--soft);
    font-size:7px;
}
.bd-info-spectrum{
    width:100%;
    height:3px;
    margin-top:25px;
    transform-origin:left;
    background:linear-gradient(90deg,var(--orange),var(--orange-soft),var(--gold),rgba(247,170,53,0));
}

/* COMMON SECTION */
.bd-info-section{position:relative;padding:47px 0}
.bd-info-section + .bd-info-section{border-top:1px solid #F3EFEA}
.bd-info-section.is-soft{
    background:
        radial-gradient(circle at 0 50%,rgba(247,170,53,.065),transparent 24%),
        #FFFCF8;
}
.bd-info-section-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:25px;
    width:min(100%,1000px);
    margin:0 auto 20px;
}
.bd-info-section-kicker{
    display:block;
    margin-bottom:4px;
    color:var(--orange);
    font-size:7.5px;
    font-weight:850;
    letter-spacing:.14em;
    text-transform:uppercase;
}
.bd-info-section-head h2{
    margin:0;
    color:var(--navy);
    font-family:'Poppins',sans-serif;
    font-size:22px;
    font-weight:700;
    line-height:1.25;
    letter-spacing:-.025em;
}
.bd-info-section-head p{
    max-width:330px;
    margin:0;
    color:var(--muted);
    font-size:8.5px;
    line-height:1.6;
    text-align:right;
}

/* PINNED */
.bd-info-pinned-wrap{width:min(100%,900px);margin-inline:auto}
.bd-info-pinned{
    position:relative;
    display:grid;
    grid-template-columns:minmax(270px,340px) minmax(0,1fr);
    min-height:230px;
    overflow:hidden;
    border:1px solid rgba(239,88,67,.19);
    border-radius:18px;
    background:#fff;
    box-shadow:0 15px 40px rgba(36,27,82,.065);
}
.bd-info-pinned::before{
    content:"";
    position:absolute;
    z-index:5;
    top:0;
    left:0;
    right:0;
    height:3px;
    background:linear-gradient(90deg,var(--orange),var(--orange-soft),var(--gold));
}
.bd-info-pinned-media{
    position:relative;
    min-height:230px;
    overflow:hidden;
    background:linear-gradient(145deg,var(--orange),var(--gold));
}
.bd-info-pinned-media img{
    position:absolute;
    inset:0;
    z-index:2;
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
    transition:transform .65s cubic-bezier(.22,1,.36,1);
}
.bd-info-pinned:hover .bd-info-pinned-media img{transform:scale(1.035)}
.bd-info-image-fallback{
    position:absolute;
    inset:0;
    display:grid;
    place-items:center;
    background:linear-gradient(135deg,var(--orange),var(--orange-soft),var(--gold));
}
.bd-info-image-fallback span{
    color:#fff;
    font-size:9px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}
.bd-info-pinned-body{
    position:relative;
    display:flex;
    flex-direction:column;
    justify-content:center;
    min-width:0;
    padding:27px 29px;
}
.bd-info-pin-label{
    display:inline-flex;
    align-items:center;
    gap:7px;
    width:max-content;
    margin-bottom:11px;
    padding:6px 9px;
    border:1px solid rgba(239,88,67,.15);
    border-radius:999px;
    color:var(--orange);
    background:#FFF5EC;
    font-size:7px;
    font-weight:850;
    letter-spacing:.09em;
    text-transform:uppercase;
}
.bd-info-pin-label svg{
    width:12px;
    height:12px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}
.bd-info-pinned-meta{
    display:flex;
    align-items:center;
    gap:7px;
    margin-bottom:7px;
    color:#999CA2;
    font-size:7px;
    font-weight:700;
}
.bd-info-pinned-meta span:first-child{color:var(--orange);text-transform:uppercase;letter-spacing:.08em}
.bd-info-dot{width:3px;height:3px;border-radius:50%;background:var(--gold)}
.bd-info-pinned-title{
    margin:0;
    color:var(--navy);
    font-family:'Poppins',sans-serif;
    font-size:21px;
    font-weight:720;
    line-height:1.35;
    letter-spacing:-.025em;
}
.bd-info-pinned-excerpt{
    max-width:480px;
    margin:10px 0 17px;
    color:var(--muted);
    font-size:9.5px;
    line-height:1.68;
    display:-webkit-box;
    overflow:hidden;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
}
.bd-info-pinned-link{
    display:inline-flex;
    align-items:center;
    gap:9px;
    width:max-content;
    color:var(--navy)!important;
    font-size:8px;
    font-weight:850;
}
.bd-info-pinned-link span{
    width:27px;
    height:27px;
    display:grid;
    place-items:center;
    border-radius:8px;
    color:#fff;
    background:linear-gradient(135deg,var(--orange),var(--gold));
    transition:transform .25s ease;
}
.bd-info-pinned-link svg{
    width:12px;
    height:12px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.9;
}
.bd-info-pinned-link:hover span{transform:translateX(3px)}

/* LATEST */
.bd-info-latest-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:16px;
    width:min(100%,1000px);
    margin-inline:auto;
}

/* STANDARD CARD */
.bd-info-card{
    position:relative;
    display:flex;
    flex-direction:column;
    min-width:0;
    width:100%;
    max-width:323px;
    justify-self:center;
    overflow:hidden;
    border:1px solid var(--border);
    border-radius:15px;
    background:#fff;
    box-shadow:0 4px 14px rgba(36,27,82,.045);
    transition:transform .28s ease,border-color .28s ease,box-shadow .28s ease;
}
.bd-info-card::before{
    content:"";
    position:absolute;
    z-index:8;
    top:0;
    left:14px;
    right:14px;
    height:3px;
    opacity:0;
    border-radius:0 0 6px 6px;
    background:linear-gradient(90deg,var(--orange),var(--gold));
    transition:opacity .25s ease;
}
.bd-info-card:hover{
    transform:translateY(-4px);
    border-color:rgba(239,88,67,.30);
    box-shadow:0 15px 30px rgba(36,27,82,.085);
}
.bd-info-card:hover::before{opacity:1}
.bd-info-card-media{
    position:relative;
    display:block;
    aspect-ratio:16/10;
    max-height:190px;
    overflow:hidden;
    border-bottom:1px solid var(--border);
    background:#F4F1ED;
}
.bd-info-card-media img{
    position:relative;
    z-index:2;
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
    transition:transform .6s cubic-bezier(.22,1,.36,1);
}
.bd-info-card:hover .bd-info-card-media img{transform:scale(1.04)}
.bd-info-number{
    position:absolute;
    z-index:4;
    top:10px;
    right:10px;
    min-width:31px;
    height:26px;
    display:grid;
    place-items:center;
    padding:0 7px;
    border:1px solid rgba(255,255,255,.34);
    border-radius:7px;
    color:#fff;
    background:rgba(36,27,82,.64);
    backdrop-filter:blur(7px);
    font-size:7px;
    font-weight:850;
}
.bd-info-card-body{
    display:flex;
    flex:1;
    flex-direction:column;
    min-height:167px;
    padding:15px;
}
.bd-info-meta{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:6px;
    margin-bottom:7px;
    color:#999CA2;
    font-size:6.7px;
}
.bd-info-meta-category{
    color:var(--orange);
    font-weight:850;
    letter-spacing:.08em;
    text-transform:uppercase;
}
.bd-info-card-title{
    margin:0 0 7px;
    color:var(--navy);
    font-family:'Poppins',sans-serif;
    font-size:14px;
    font-weight:680;
    line-height:1.42;
    letter-spacing:-.015em;
    display:-webkit-box;
    overflow:hidden;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}
.bd-info-card-excerpt{
    margin:0 0 13px;
    color:var(--muted);
    font-size:8.7px;
    line-height:1.65;
    display:-webkit-box;
    overflow:hidden;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}
.bd-info-card-read{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-top:auto;
    padding-top:11px;
    border-top:1px solid #F0ECE8;
    color:var(--navy)!important;
    font-size:7.5px;
    font-weight:850;
}
.bd-info-card-read span:last-child{
    width:27px;
    height:27px;
    display:grid;
    place-items:center;
    border:1px solid rgba(239,88,67,.16);
    border-radius:8px;
    color:var(--orange);
    background:#FFF7EF;
    transition:background .25s ease,color .25s ease,transform .25s ease;
}
.bd-info-card-read svg{
    width:11px;
    height:11px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
}
.bd-info-card:hover .bd-info-card-read span:last-child{
    color:#fff;
    background:linear-gradient(135deg,var(--orange),var(--gold));
    transform:translateX(2px);
}

/* ALL INFORMATION SLIDER */
.bd-info-all-head{align-items:center}
.bd-info-slider-controls{display:flex;align-items:center;gap:8px;flex-shrink:0}
.bd-info-slider-arrow{
    width:39px;
    height:39px;
    display:grid;
    place-items:center;
    padding:0;
    border:1px solid var(--border);
    border-radius:10px;
    color:var(--navy);
    background:#fff;
    cursor:pointer;
    transition:.25s ease;
}
.bd-info-slider-arrow svg{
    width:13px;
    height:13px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.9;
}
.bd-info-slider-arrow:hover{
    color:var(--orange);
    border-color:rgba(239,88,67,.35);
    transform:translateY(-2px);
}
.bd-info-slider-arrow:disabled{opacity:.35;cursor:default;transform:none}
.bd-info-slider-counter{
    min-width:65px;
    color:#A09DA5;
    font-size:8px;
    font-weight:750;
    text-align:center;
}
.bd-info-slider-counter strong{
    color:var(--orange);
    font-size:13px;
    font-weight:850;
}
.bd-info-all-viewport{
    width:min(100%,1000px);
    margin-inline:auto;
    overflow:hidden;
}
.bd-info-all-track{
    display:flex;
    align-items:stretch;
    gap:16px;
    width:100%;
    will-change:transform;
}
.bd-info-all-card{
    flex:0 0 calc((100% - 32px)/3);
    max-width:none;
}
.bd-info-empty{
    width:min(100%,900px);
    margin:auto;
    padding:45px 20px;
    border:1px solid var(--border);
    border-radius:15px;
    color:var(--muted);
    background:#fff;
    text-align:center;
    font-size:10px;
}

/* TABLET */
@media(max-width:900px){
    .bd-info-shell{width:calc(100% - 34px)}
    .bd-info-hero-layout{gap:28px}
    .bd-info-latest-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        max-width:670px;
    }
    .bd-info-latest-grid .bd-info-card:last-child:nth-child(odd){
        grid-column:1/-1;
        justify-self:center;
    }
    .bd-info-card{max-width:327px}
    .bd-info-pinned-wrap{max-width:670px}
    .bd-info-pinned{grid-template-columns:minmax(230px,280px) minmax(0,1fr)}
    .bd-info-pinned-body{padding:23px}
    .bd-info-pinned-title{font-size:18px}
    .bd-info-all-viewport{max-width:670px}
    .bd-info-all-card{flex-basis:calc((100% - 16px)/2)}
}

/* MOBILE */
@media(max-width:640px){
    .bd-info-shell{width:calc(100% - 28px)}
    .bd-info-hero{padding:40px 0 27px}
    .bd-info-hero-layout{grid-template-columns:1fr;gap:17px}
    .bd-info-title{font-size:36px}
    .bd-info-description{font-size:10.5px}
    .bd-info-stat{text-align:left}
    .bd-info-stat strong{font-size:31px}
    .bd-info-spectrum{margin-top:21px}
    .bd-info-section{padding:37px 0}
    .bd-info-section-head{
        width:min(100%,360px);
        align-items:flex-start;
        flex-direction:column;
        gap:6px;
        margin-bottom:17px;
    }
    .bd-info-section-head p{text-align:left}
    .bd-info-pinned-wrap{max-width:360px}
    .bd-info-pinned{grid-template-columns:1fr}
    .bd-info-pinned-media{min-height:0;aspect-ratio:16/9}
    .bd-info-pinned-body{padding:20px}
    .bd-info-pinned-title{font-size:17px}
    .bd-info-latest-grid{
        grid-template-columns:1fr;
        max-width:350px;
        gap:14px;
    }
    .bd-info-latest-grid .bd-info-card:last-child:nth-child(odd){grid-column:auto}
    .bd-info-card{max-width:350px}
    .bd-info-card-media{aspect-ratio:16/9;max-height:190px}
    .bd-info-all-head{
        width:min(100%,360px);
        flex-direction:row;
        align-items:flex-end;
        gap:12px;
    }
    .bd-info-all-head p{display:none}
    .bd-info-slider-controls{margin-left:auto}
    .bd-info-all-viewport{max-width:350px}
    .bd-info-all-card{flex-basis:100%}
}

/* REDUCED MOTION */
@media(prefers-reduced-motion:reduce){
    .bd-info-pinned,
    .bd-info-card,
    .bd-info-card-media img,
    .bd-info-pinned-media img,
    .bd-info-pinned-link span,
    .bd-info-card-read span:last-child,
    .bd-info-slider-arrow{transition:none!important}
}
</style>

<div class="bd-information" id="bdInformationPage">

    {{-- HERO --}}
    <section class="bd-info-hero">
        <div class="bd-info-shell">
            <div class="bd-info-hero-layout">
                <div>
                    <div class="bd-info-eyebrow" data-info-hero>
                        Baca Dulu / Information
                    </div>

                    <h1 class="bd-info-title" data-info-hero>
                        Informasi yang
                        <span>perlu dibaca.</span>
                    </h1>

                    <p class="bd-info-description" data-info-hero>
                        Temukan kabar, agenda, pengumuman, kegiatan,
                        dan berbagai pembaruan terbaru dari Baca Dulu.
                    </p>
                </div>

                <div class="bd-info-stat" data-info-stat>
                    <strong>
                        {{ str_pad((string) $totalInformations, 2, '0', STR_PAD_LEFT) }}
                    </strong>

                    <span>Total Informasi</span>

                    <small>
                        Update · {{ $lastUpdateText }}
                    </small>
                </div>
            </div>

            <div class="bd-info-spectrum" data-info-spectrum></div>
        </div>
    </section>


    {{-- =====================================================
         PINNED INFORMATION
    ====================================================== --}}
    @if($pinnedInformation)
        @php
            $pinExcerpt = \Illuminate\Support\Str::limit(
                trim(
                    html_entity_decode(
                        strip_tags(
                            $pinnedInformation->content
                            ?? $pinnedInformation->description
                            ?? ''
                        )
                    )
                ),
                190
            );

            $pinDate = $pinnedInformation->created_at
                ? $pinnedInformation->created_at
                    ->timezone('Asia/Jakarta')
                    ->translatedFormat('d M Y')
                : null;
        @endphp

        <section class="bd-info-section">
            <div class="bd-info-shell">

                <header class="bd-info-section-head" data-info-reveal>
                    <div>
                        <span class="bd-info-section-kicker">
                            Pinned Information
                        </span>

                        <h2>
                            Informasi pilihan.
                        </h2>
                    </div>

                    <p>
                        Informasi penting yang sedang diprioritaskan
                        oleh Baca Dulu.
                    </p>
                </header>

                <div class="bd-info-pinned-wrap">
                    <article class="bd-info-pinned" data-info-pinned>

                        <a
                            href="{{ url('/information/' . $pinnedInformation->slug) }}"
                            class="bd-info-pinned-media"
                            aria-label="Baca {{ $pinnedInformation->title }}"
                        >
                            <div class="bd-info-image-fallback">
                                <span>Baca Dulu</span>
                            </div>

                            @if(!empty($pinnedInformation->image))
                                <img
                                    src="{{ asset('storage/' . $pinnedInformation->image) }}"
                                    alt="{{ $pinnedInformation->title }}"
                                    loading="eager"
                                    onerror="this.style.display='none';"
                                >
                            @endif
                        </a>

                        <div class="bd-info-pinned-body">

                            <div class="bd-info-pin-label" data-pin-label>
                                <svg viewBox="0 0 24 24">
                                    <path d="M14 4l6 6-3 1-4 4-1 5-3-3-4 4-2-2 4-4-3-3 5-1 4-4z"/>
                                </svg>

                                Dipilih Admin
                            </div>

                            <div class="bd-info-pinned-meta">
                                <span>Informasi</span>

                                @if($pinDate)
                                    <i class="bd-info-dot"></i>
                                    <time>{{ $pinDate }}</time>
                                @endif
                            </div>

                            <h2 class="bd-info-pinned-title">
                                {{ $pinnedInformation->title }}
                            </h2>

                            <p class="bd-info-pinned-excerpt">
                                {{ $pinExcerpt ?: 'Baca informasi pilihan selengkapnya dari Baca Dulu.' }}
                            </p>

                            <a
                                href="{{ url('/information/' . $pinnedInformation->slug) }}"
                                class="bd-info-pinned-link"
                            >
                                Baca Selengkapnya

                                <span>
                                    <svg viewBox="0 0 24 24">
                                        <path d="M5 12h14"/>
                                        <path d="m14 7 5 5-5 5"/>
                                    </svg>
                                </span>
                            </a>

                        </div>

                    </article>
                </div>

            </div>
        </section>
    @endif


    {{-- =====================================================
         LATEST INFORMATION
    ====================================================== --}}
    @if($latestInformations->isNotEmpty())
        <section class="bd-info-section {{ $pinnedInformation ? 'is-soft' : '' }}">
            <div class="bd-info-shell">

                <header class="bd-info-section-head" data-info-reveal>
                    <div>
                        <span class="bd-info-section-kicker">
                            Latest Update
                        </span>

                        <h2>
                            Informasi terbaru.
                        </h2>
                    </div>

                    <p>
                        Tiga pembaruan terbaru yang baru saja
                        diterbitkan oleh Baca Dulu.
                    </p>
                </header>


                <div class="bd-info-latest-grid">

                    @foreach($latestInformations as $index => $information)
                        @php
                            $excerpt = \Illuminate\Support\Str::limit(
                                trim(
                                    html_entity_decode(
                                        strip_tags(
                                            $information->content
                                            ?? $information->description
                                            ?? ''
                                        )
                                    )
                                ),
                                105
                            );

                            $date = $information->created_at
                                ? $information->created_at
                                    ->timezone('Asia/Jakarta')
                                    ->translatedFormat('d M Y')
                                : null;
                        @endphp

                        <article class="bd-info-card" data-info-latest-card>

                            <a
                                href="{{ url('/information/' . $information->slug) }}"
                                class="bd-info-card-media"
                                aria-label="Baca {{ $information->title }}"
                            >
                                <div class="bd-info-image-fallback">
                                    <span>Baca Dulu</span>
                                </div>

                                @if(!empty($information->image))
                                    <img
                                        src="{{ asset('storage/' . $information->image) }}"
                                        alt="{{ $information->title }}"
                                        loading="lazy"
                                        onerror="this.style.display='none';"
                                    >
                                @endif

                                <span class="bd-info-number">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </a>


                            <div class="bd-info-card-body">

                                <div class="bd-info-meta">
                                    <span class="bd-info-meta-category">
                                        Informasi
                                    </span>

                                    @if($date)
                                        <i class="bd-info-dot"></i>
                                        <time>{{ $date }}</time>
                                    @endif
                                </div>

                                <h3 class="bd-info-card-title">
                                    {{ $information->title }}
                                </h3>

                                <p class="bd-info-card-excerpt">
                                    {{ $excerpt ?: 'Baca informasi terbaru selengkapnya dari Baca Dulu.' }}
                                </p>

                                <a
                                    href="{{ url('/information/' . $information->slug) }}"
                                    class="bd-info-card-read"
                                >
                                    <span>Baca Selengkapnya</span>

                                    <span>
                                        <svg viewBox="0 0 24 24">
                                            <path d="M5 12h14"/>
                                            <path d="m14 7 5 5-5 5"/>
                                        </svg>
                                    </span>
                                </a>

                            </div>

                        </article>
                    @endforeach

                </div>

            </div>
        </section>
    @endif


    {{-- =====================================================
         ALL INFORMATION
    ====================================================== --}}
    @if($allInformations->isNotEmpty())
        <section class="bd-info-section {{ !$pinnedInformation ? 'is-soft' : '' }}" id="semua-informasi">

            <div class="bd-info-shell">

                <header class="bd-info-section-head bd-info-all-head" data-info-reveal>

                    <div>
                        <span class="bd-info-section-kicker">
                            Archive
                        </span>

                        <h2>
                            Semua informasi.
                        </h2>
                    </div>

                    <p>
                        Jelajahi informasi lain dari Baca Dulu.
                    </p>


                    <div class="bd-info-slider-controls">

                        <button
                            type="button"
                            class="bd-info-slider-arrow"
                            id="bdInfoPrev"
                            aria-label="Informasi sebelumnya"
                        >
                            <svg viewBox="0 0 24 24">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                        </button>


                        <div class="bd-info-slider-counter">
                            <strong id="bdInfoCurrent">
                                01
                            </strong>

                            /

                            <span id="bdInfoTotal">
                                01
                            </span>
                        </div>


                        <button
                            type="button"
                            class="bd-info-slider-arrow"
                            id="bdInfoNext"
                            aria-label="Informasi berikutnya"
                        >
                            <svg viewBox="0 0 24 24">
                                <path d="m9 6 6 6-6 6"/>
                            </svg>
                        </button>

                    </div>

                </header>


                <div
                    class="bd-info-all-viewport"
                    id="bdInfoViewport"
                >

                    <div
                        class="bd-info-all-track"
                        id="bdInfoTrack"
                    >

                        @foreach($allInformations as $index => $information)
                            @php
                                $excerpt = \Illuminate\Support\Str::limit(
                                    trim(
                                        html_entity_decode(
                                            strip_tags(
                                                $information->content
                                                ?? $information->description
                                                ?? ''
                                            )
                                        )
                                    ),
                                    100
                                );

                                $date = $information->created_at
                                    ? $information->created_at
                                        ->timezone('Asia/Jakarta')
                                        ->translatedFormat('d M Y')
                                    : null;
                            @endphp

                            <article class="bd-info-card bd-info-all-card" data-all-card>

                                <a
                                    href="{{ url('/information/' . $information->slug) }}"
                                    class="bd-info-card-media"
                                    aria-label="Baca {{ $information->title }}"
                                >
                                    <div class="bd-info-image-fallback">
                                        <span>Baca Dulu</span>
                                    </div>

                                    @if(!empty($information->image))
                                        <img
                                            src="{{ asset('storage/' . $information->image) }}"
                                            alt="{{ $information->title }}"
                                            loading="lazy"
                                            onerror="this.style.display='none';"
                                        >
                                    @endif

                                    <span class="bd-info-number">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </a>


                                <div class="bd-info-card-body">

                                    <div class="bd-info-meta">

                                        <span class="bd-info-meta-category">
                                            Informasi
                                        </span>

                                        @if($date)
                                            <i class="bd-info-dot"></i>
                                            <time>{{ $date }}</time>
                                        @endif

                                    </div>


                                    <h3 class="bd-info-card-title">
                                        {{ $information->title }}
                                    </h3>


                                    <p class="bd-info-card-excerpt">
                                        {{ $excerpt ?: 'Baca informasi selengkapnya dari Baca Dulu.' }}
                                    </p>


                                    <a
                                        href="{{ url('/information/' . $information->slug) }}"
                                        class="bd-info-card-read"
                                    >
                                        <span>
                                            Baca Selengkapnya
                                        </span>

                                        <span>
                                            <svg viewBox="0 0 24 24">
                                                <path d="M5 12h14"/>
                                                <path d="m14 7 5 5-5 5"/>
                                            </svg>
                                        </span>
                                    </a>

                                </div>

                            </article>
                        @endforeach

                    </div>

                </div>

            </div>

        </section>
    @endif


    @if(!$pinnedInformation && $latestInformations->isEmpty() && $allInformations->isEmpty())
        <section class="bd-info-section">
            <div class="bd-info-shell">
                <div class="bd-info-empty">
                    Belum ada informasi yang diterbitkan.
                </div>
            </div>
        </section>
    @endif

</div>


<script>
(() => {

    const initBdInformationPage = () => {

        const page = document.getElementById('bdInformationPage');

        if (!page || page.dataset.ready === '1') {
            return;
        }

        page.dataset.ready = '1';


        const reducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;


        const gsap =
            window.bdGsap ||
            window.gsap ||
            null;


        /* =====================================================
           HERO ANIMATION
        ====================================================== */

        const heroItems =
            page.querySelectorAll(
                '[data-info-hero]'
            );

        const stat =
            page.querySelector(
                '[data-info-stat]'
            );

        const spectrum =
            page.querySelector(
                '[data-info-spectrum]'
            );


        if (!reducedMotion) {

            if (gsap) {

                const tl =
                    gsap.timeline({
                        defaults: {
                            ease: 'power3.out'
                        }
                    });


                tl.fromTo(
                    heroItems,
                    {
                        opacity: 0,
                        y: 30
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: .7,
                        stagger: .08
                    }
                );


                if (stat) {

                    tl.fromTo(
                        stat,
                        {
                            opacity: 0,
                            x: 24
                        },
                        {
                            opacity: 1,
                            x: 0,
                            duration: .6
                        },
                        '-=.42'
                    );

                }


                if (spectrum) {

                    tl.fromTo(
                        spectrum,
                        {
                            scaleX: 0
                        },
                        {
                            scaleX: 1,
                            duration: .75
                        },
                        '-=.32'
                    );

                }

            }

        }


        /* =====================================================
           SECTION REVEAL
        ====================================================== */

        if (!reducedMotion) {

            const revealElements =
                page.querySelectorAll(
                    '[data-info-reveal], [data-info-pinned], [data-info-latest-card]'
                );


            if (
                'IntersectionObserver' in window
            ) {

                const observer =
                    new IntersectionObserver(
                        entries => {

                            entries.forEach(
                                entry => {

                                    if (!entry.isIntersecting) {
                                        return;
                                    }


                                    const element =
                                        entry.target;


                                    observer.unobserve(
                                        element
                                    );


                                    if (gsap) {

                                        gsap.fromTo(
                                            element,
                                            {
                                                opacity: 0,
                                                y: 32,
                                                scale: .985
                                            },
                                            {
                                                opacity: 1,
                                                y: 0,
                                                scale: 1,
                                                duration: .7,
                                                ease: 'power3.out'
                                            }
                                        );

                                    }
                                    else if (
                                        typeof element.animate ===
                                        'function'
                                    ) {

                                        element.animate(
                                            [
                                                {
                                                    opacity: 0,
                                                    transform:
                                                        'translateY(32px) scale(.985)'
                                                },
                                                {
                                                    opacity: 1,
                                                    transform:
                                                        'translateY(0) scale(1)'
                                                }
                                            ],
                                            {
                                                duration: 700,
                                                easing:
                                                    'cubic-bezier(.16,1,.3,1)',
                                                fill: 'both'
                                            }
                                        );

                                    }

                                }
                            );

                        },
                        {
                            threshold: .10
                        }
                    );


                revealElements.forEach(
                    element => {

                        observer.observe(
                            element
                        );

                    }
                );

            }

        }


        /* =====================================================
           PIN ICON
        ====================================================== */

        const pinLabel =
            page.querySelector(
                '[data-pin-label]'
            );


        if (
            pinLabel &&
            !reducedMotion
        ) {

            const pinIcon =
                pinLabel.querySelector(
                    'svg'
                );


            if (
                pinIcon &&
                typeof pinIcon.animate ===
                'function'
            ) {

                pinIcon.animate(
                    [
                        {
                            transform:
                                'rotate(-10deg) scale(.9)'
                        },
                        {
                            transform:
                                'rotate(5deg) scale(1.08)'
                        },
                        {
                            transform:
                                'rotate(0deg) scale(1)'
                        }
                    ],
                    {
                        duration: 650,
                        delay: 450,
                        easing:
                            'cubic-bezier(.16,1,.3,1)'
                    }
                );

            }

        }


        /* =====================================================
           ALL INFORMATION SLIDER
        ====================================================== */

        const viewport =
            document.getElementById(
                'bdInfoViewport'
            );

        const track =
            document.getElementById(
                'bdInfoTrack'
            );

        const prev =
            document.getElementById(
                'bdInfoPrev'
            );

        const next =
            document.getElementById(
                'bdInfoNext'
            );

        const current =
            document.getElementById(
                'bdInfoCurrent'
            );

        const total =
            document.getElementById(
                'bdInfoTotal'
            );


        if (
            !viewport ||
            !track
        ) {
            return;
        }


        const cards =
            Array.from(
                track.querySelectorAll(
                    '[data-all-card]'
                )
            );


        if (!cards.length) {
            return;
        }


        let pageIndex = 0;
        let pageTotal = 1;
        let perView = 3;
        let resizeTimer = null;


        const getPerView = () => {

            if (
                window.innerWidth <= 640
            ) {
                return 1;
            }


            if (
                window.innerWidth <= 900
            ) {
                return 2;
            }


            return 3;

        };


        const updateCounter = () => {

            if (current) {

                current.textContent =
                    String(
                        pageIndex + 1
                    ).padStart(
                        2,
                        '0'
                    );

            }


            if (total) {

                total.textContent =
                    String(
                        pageTotal
                    ).padStart(
                        2,
                        '0'
                    );

            }


            if (prev) {

                prev.disabled =
                    pageIndex === 0;

            }


            if (next) {

                next.disabled =
                    pageIndex >=
                    pageTotal - 1;

            }

        };


        const renderSlider = (
            animate = true
        ) => {

            perView =
                getPerView();


            pageTotal =
                Math.max(
                    1,
                    Math.ceil(
                        cards.length /
                        perView
                    )
                );


            if (
                pageIndex >
                pageTotal - 1
            ) {

                pageIndex =
                    pageTotal - 1;

            }


            const firstCard =
                cards[0];


            const cardWidth =
                firstCard
                    .getBoundingClientRect()
                    .width;


            const styles =
                getComputedStyle(
                    track
                );


            const gap =
                parseFloat(
                    styles.columnGap ||
                    styles.gap ||
                    0
                );


            const step =
                (
                    cardWidth +
                    gap
                ) *
                perView;


            const x =
                -(pageIndex * step);


            if (
                gsap &&
                animate &&
                !reducedMotion
            ) {

                gsap.to(
                    track,
                    {
                        x: x,
                        duration: .58,
                        ease: 'power3.inOut',
                        overwrite: true
                    }
                );

            }
            else {

                track.style.transform =
                    `translate3d(${x}px,0,0)`;

            }


            updateCounter();

        };


        prev?.addEventListener(
            'click',
            () => {

                if (
                    pageIndex <= 0
                ) {
                    return;
                }


                pageIndex -= 1;

                renderSlider();

            }
        );


        next?.addEventListener(
            'click',
            () => {

                if (
                    pageIndex >=
                    pageTotal - 1
                ) {
                    return;
                }


                pageIndex += 1;

                renderSlider();

            }
        );


        window.addEventListener(
            'resize',
            () => {

                clearTimeout(
                    resizeTimer
                );


                resizeTimer =
                    setTimeout(
                        () => {

                            pageIndex = 0;

                            renderSlider(
                                false
                            );

                        },
                        150
                    );

            }
        );


        renderSlider(
            false
        );

    };


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initBdInformationPage,
            {
                once: true
            }
        );

    }
    else {

        initBdInformationPage();

    }

})();
</script>

@endsection