@extends('layouts.app')

@section('title', 'Baca Publisher - Baca Dulu')

@section('content')

@php
    $publisherBooks = collect($books ?? [])->values();

    $publisherBookData = $publisherBooks->map(function ($book) {
        return [
            'id' => $book->id ?? null,
            'title' => $book->title ?? 'Tanpa Judul',
            'author' => $book->author ?? '-',
            'year' => $book->publish_year ?? '-',
            'isbn' => $book->isbn ?? '-',
            'pages' => $book->pages ?? null,
            'category' => !empty($book->category) ? $book->category : 'Umum',
            'publisher' => !empty($book->publisher) ? $book->publisher : 'BacaDulu Publisher',
            'cover' => !empty($book->cover) ? asset('storage/' . $book->cover) : null,
            'synopsis' => !empty($book->description)
                ? strip_tags($book->description, '<p><br><strong><b><em><i><ul><ol><li>')
                : '',
        ];
    })->values();

    /*
    |--------------------------------------------------------------------------
    | COVER HERO OTOMATIS DARI DATABASE
    |--------------------------------------------------------------------------
    |
    | Hanya ambil buku yang punya cover.
    | Maksimal 4 cover untuk animasi hero.
    |
    */

    $publisherHeroBooks = $publisherBookData
        ->filter(fn ($book) => !empty($book['cover']))
        ->take(4)
        ->values();

    $heroFloatClasses = [
        'bd-float-one',
        'bd-float-two',
        'bd-float-three',
        'bd-float-four',
    ];
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap');

.bd-publisher{
    --navy:#241B52;--navy-deep:#17132E;--orange:#EF5843;--blue:#566B91;
    --plum:#80586F;--ink:#18161F;--body:#5F5B69;--muted:#96929C;
    --line:#E8E7EC;--line-strong:rgba(36,27,82,.15);
    width:100%;min-height:100vh;overflow-x:hidden;background:#fff;color:var(--ink);
    font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased;
}
.bd-publisher *,.bd-publisher *::before,.bd-publisher *::after{box-sizing:border-box}
.bd-publisher button,.bd-publisher input{font-family:inherit}
.bd-publisher a{color:inherit}
.bd-publisher :focus-visible{outline:2px solid var(--orange);outline-offset:3px}
.bd-publisher-shell{width:min(calc(100% - 72px),1260px);margin:auto}

/* BRAND */
.bd-publisher-brandbar{min-height:72px;display:flex;align-items:center;border-bottom:1px solid var(--line)}
.bd-publisher-brand{display:inline-flex;align-items:center;gap:11px}
.bd-publisher-brand-mark{width:7px;height:27px;background:var(--orange)}
.bd-publisher-brand-name{color:var(--navy);font-family:'Fraunces',serif;font-size:21px;font-weight:600}
.bd-publisher-brand-type{color:var(--muted);font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase}

/* TYPEWRITER */
.bd-typewriter{display:inline-flex;align-items:center;min-height:1.3em}
.bd-typewriter-text{display:inline-block}
.bd-typewriter-cursor{width:1px;height:1em;margin-left:4px;background:currentColor;animation:bdBlink .7s steps(1) infinite}
@keyframes bdBlink{0%,48%{opacity:1}49%,100%{opacity:0}}

/* =========================================================
   HERO
========================================================= */

.bd-publisher-hero{
    display:grid;
    grid-template-columns:minmax(0,1.08fr) minmax(350px,.92fr);
    gap:60px;
    align-items:center;
    min-height:520px;
    padding:64px 0 62px;
    border-bottom:1px solid var(--line);
}

.bd-publisher-hero-copy{max-width:760px}

.bd-publisher-eyebrow,.bd-publisher-section-eyebrow{
    color:var(--orange);font-size:9px;font-weight:700;
    letter-spacing:.14em;text-transform:uppercase;
}

.bd-publisher-eyebrow{
    display:flex;align-items:center;gap:10px;margin-bottom:17px;
}

.bd-publisher-eyebrow::before{
    content:"";width:28px;height:2px;background:var(--orange);
}

.bd-publisher-hero h1{
    max-width:710px;margin:0 0 22px;color:var(--navy);
    font-family:'Fraunces',serif;font-size:clamp(49px,5.2vw,76px);
    font-weight:500;line-height:.99;letter-spacing:-.045em;
}

.bd-publisher-hero-description{
    max-width:590px;margin:0;color:var(--body);font-size:14px;line-height:1.8;
}

.bd-word{display:inline-block;margin-right:.15em;will-change:transform,opacity}

/* =========================================================
   HERO MOTION
========================================================= */

.bd-publisher-motion{
    position:relative;
    width:100%;
    height:390px;
    perspective:1100px;
    isolation:isolate;
}

.bd-publisher-motion-orbit{
    position:absolute;
    z-index:0;
    left:50%;
    top:50%;
    width:325px;
    height:325px;
    margin:-162.5px 0 0 -162.5px;
    border:1px solid rgba(36,27,82,.1);
    border-radius:50%;
    transform-origin:center;
}

.bd-publisher-motion-orbit::before{
    content:"";
    position:absolute;
    inset:42px;
    border:1px solid rgba(36,27,82,.055);
    border-radius:50%;
}

.bd-publisher-orbit-dot{
    position:absolute;
    left:50%;
    top:-5px;
    width:10px;
    height:10px;
    border-radius:50%;
    background:var(--orange);
    transform:translateX(-50%);
    box-shadow:0 0 0 7px rgba(239,88,67,.09);
}

.bd-axis-x,.bd-axis-y{
    position:absolute;
    left:50%;
    top:50%;
    pointer-events:none;
}

.bd-axis-x{
    width:390px;
    height:1px;
    transform:translate(-50%,-50%);
    background:linear-gradient(90deg,transparent,rgba(36,27,82,.09),transparent);
}

.bd-axis-y{
    width:1px;
    height:360px;
    transform:translate(-50%,-50%);
    background:linear-gradient(180deg,transparent,rgba(36,27,82,.075),transparent);
}

/* FLOAT POSITION */
.bd-publisher-float{
    position:absolute;
    z-index:3;
    will-change:transform;
}

.bd-float-one{
    left:50%;
    top:49%;
    margin:-107px 0 0 -74px;
    z-index:5;
}

.bd-float-two{
    left:27%;
    top:54%;
    margin:-84px 0 0 -57px;
    z-index:3;
}

.bd-float-three{
    left:73%;
    top:55%;
    margin:-80px 0 0 -54px;
    z-index:3;
}

.bd-float-four{
    left:66%;
    top:30%;
    margin:-64px 0 0 -45px;
    z-index:2;
}

/* HERO BOOK */
.bd-publisher-float-book{
    position:relative;
    overflow:hidden;
    border-radius:5px;
    background:#fff;
    box-shadow:
        0 25px 48px rgba(36,27,82,.16),
        0 7px 15px rgba(36,27,82,.08);
    transform-style:preserve-3d;
}

/* SIZE MASING-MASING COVER */
.bd-float-one .bd-publisher-float-book{
    width:148px;
    height:214px;
    transform:rotate(-7deg);
}

.bd-float-two .bd-publisher-float-book{
    width:115px;
    height:168px;
    transform:rotate(-18deg);
}

.bd-float-three .bd-publisher-float-book{
    width:110px;
    height:160px;
    transform:rotate(14deg);
}

.bd-float-four .bd-publisher-float-book{
    width:90px;
    height:128px;
    transform:rotate(25deg);
}

/* COVER ASLI DATABASE */
.bd-publisher-hero-cover{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center;
    border-radius:inherit;
    pointer-events:none;
    user-select:none;
}

/* SHINE TIPIS SUPAYA TERASA BUKU FISIK */
.bd-publisher-float-book.has-cover::after{
    content:"";
    position:absolute;
    inset:0;
    pointer-events:none;
    background:
        linear-gradient(
            105deg,
            rgba(255,255,255,.17) 0%,
            rgba(255,255,255,0) 21%,
            rgba(255,255,255,0) 73%,
            rgba(255,255,255,.08) 100%
        );
}

/* SPINE TIPIS */
.bd-publisher-float-book.has-cover::before{
    content:"";
    position:absolute;
    z-index:2;
    top:0;
    bottom:0;
    left:5px;
    width:1px;
    background:rgba(255,255,255,.23);
    pointer-events:none;
}

/* FALLBACK DUMMY */
.bd-publisher-float-book.is-fallback::before{
    content:"";
    position:absolute;
    top:0;
    bottom:0;
    left:15px;
    width:1px;
    background:rgba(255,255,255,.2);
}

.bd-publisher-float-book.is-fallback::after{
    content:"";
    position:absolute;
    left:28px;
    top:18px;
    width:34px;
    height:2px;
    background:rgba(255,255,255,.44);
}

.bd-publisher-float-label{
    position:absolute;
    left:29px;
    right:18px;
    bottom:23px;
    color:rgba(255,255,255,.92);
    font-family:'Fraunces',serif;
    font-size:14px;
    line-height:1.12;
}

.bd-publisher-float-label small{
    display:block;
    margin-bottom:7px;
    color:rgba(255,255,255,.54);
    font-family:'Inter',sans-serif;
    font-size:6px;
    font-weight:700;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-publisher-motion-pulse{
    position:absolute;
    z-index:6;
    right:7%;
    bottom:17%;
    width:11px;
    height:11px;
    border-radius:50%;
    background:var(--orange);
    box-shadow:0 0 0 7px rgba(239,88,67,.09);
}

/* ABOUT */
.bd-publisher-about{
    display:grid;
    grid-template-columns:220px minmax(0,1fr);
    gap:70px;
    padding:54px 0;
    border-bottom:1px solid var(--line);
}
.bd-publisher-section-label{
    padding-top:5px;color:var(--orange);font-size:9px;font-weight:700;
    letter-spacing:.12em;text-transform:uppercase;
}
.bd-publisher-about-copy{max-width:800px}
.bd-publisher-about-copy h2,.bd-publisher-section-title,.bd-publisher-catalog-title,.bd-publisher-submit h2{
    color:var(--navy);font-family:'Fraunces',serif;font-weight:500;letter-spacing:-.035em;
}
.bd-publisher-about-copy h2{
    max-width:720px;margin:0 0 20px;font-size:clamp(31px,3.2vw,45px);line-height:1.08;
}
.bd-publisher-about-copy p{
    max-width:700px;margin:0 0 12px;color:var(--body);font-size:13px;line-height:1.85;
}

/* COMMON */
.bd-publisher-section-head,.bd-publisher-catalog-head{
    display:grid;grid-template-columns:minmax(0,1fr) 340px;
    gap:50px;align-items:end;margin-bottom:34px;
}
.bd-publisher-section-eyebrow{display:block;min-height:14px;margin-bottom:9px}
.bd-publisher-section-title{
    max-width:680px;margin:0;font-size:clamp(34px,3.8vw,50px);line-height:1.04;
}
.bd-publisher-section-description{
    margin:0;color:var(--body);font-size:11px;line-height:1.8;
}

/* SERVICES */
.bd-publisher-services{padding:58px 0 60px;border-bottom:1px solid var(--line)}
.bd-publisher-service-grid{
    display:grid;grid-template-columns:repeat(4,1fr);
    border-top:1px solid var(--line);border-bottom:1px solid var(--line);
}
.bd-publisher-service{position:relative;min-height:225px;padding:27px;overflow:hidden}
.bd-publisher-service+.bd-publisher-service{border-left:1px solid var(--line)}
.bd-publisher-service-number{
    margin-bottom:35px;color:var(--orange);font-size:8px;font-weight:700;letter-spacing:.12em;
}
.bd-publisher-service h3{
    max-width:190px;margin:0 0 11px;color:var(--navy);
    font-family:'Fraunces',serif;font-size:22px;font-weight:500;line-height:1.15;
}
.bd-publisher-service p{
    max-width:210px;margin:0;color:var(--body);font-size:10px;line-height:1.7;
}
.bd-publisher-service::after{
    content:"";position:absolute;left:27px;bottom:0;width:34px;height:3px;
    background:var(--orange);transform:scaleX(0);transform-origin:left;transition:transform .3s ease;
}
.bd-publisher-service:hover::after{transform:scaleX(1)}

/* PROCESS */
.bd-publisher-process{padding:64px 0 50px;border-bottom:1px solid var(--line)}
.bd-process-layout{
    display:grid;grid-template-columns:285px minmax(0,1fr);gap:60px;align-items:start;
}
.bd-process-side{position:sticky;top:100px;padding-top:8px}
.bd-process-side .bd-publisher-section-eyebrow{margin-bottom:12px}
.bd-process-side h2{
    max-width:270px;margin:0 0 15px;color:var(--navy);
    font-family:'Fraunces',serif;font-size:34px;font-weight:500;
    line-height:1.05;letter-spacing:-.035em;
}
.bd-process-side p{
    max-width:250px;margin:0;color:var(--body);font-size:10px;line-height:1.75;
}

.bd-process-flow{position:relative}
.bd-process-track{
    position:absolute;z-index:0;left:15px;top:150px;bottom:150px;
    width:3px;border-radius:999px;background:#E5E3EA;
}
.bd-process-track-fill{
    position:absolute;z-index:1;left:15px;top:150px;bottom:150px;
    width:3px;border-radius:999px;background:var(--orange);
    transform:scaleY(.001);transform-origin:top center;will-change:transform;
}
.bd-process-step-row{
    position:relative;z-index:2;display:grid;
    grid-template-columns:90px minmax(0,1fr);
    gap:26px;align-items:center;min-height:300px;
}
.bd-process-step-row:not(:last-child) .bd-process-step{border-bottom:1px solid var(--line)}
.bd-process-marker{
    display:flex;align-items:center;gap:14px;min-width:90px;color:var(--muted);
}
.bd-process-marker-dot{
    width:32px;height:32px;flex:0 0 32px;
    border:3px solid #DAD7E1;border-radius:50%;background:#fff;
    box-shadow:0 0 0 7px #fff;
    transition:background .3s ease,border-color .3s ease,transform .3s ease,box-shadow .3s ease;
}
.bd-process-marker-number{
    color:inherit;font-family:'Fraunces',serif;font-size:18px;font-weight:500;line-height:1;
    transition:transform .3s ease,color .3s ease;
}
.bd-process-marker.active{color:var(--navy)}
.bd-process-marker.active .bd-process-marker-dot{
    background:var(--orange);border-color:var(--orange);transform:scale(1.14);
    box-shadow:0 0 0 7px #fff,0 0 0 10px rgba(239,88,67,.13);
}
.bd-process-marker.active .bd-process-marker-number{font-weight:600;transform:translateX(3px)}
.bd-process-marker.done{color:var(--navy)}
.bd-process-marker.done .bd-process-marker-dot{background:var(--navy);border-color:var(--navy)}

.bd-process-step{display:flex;align-items:center;min-height:300px;padding:42px 0}
.bd-process-step-inner{
    width:100%;display:grid;grid-template-columns:120px minmax(0,1fr);
    gap:38px;align-items:center;
}
.bd-process-big-number{
    color:rgba(36,27,82,.075);font-family:'Fraunces',serif;
    font-size:88px;line-height:1;letter-spacing:-.06em;
}
.bd-process-step-label{
    display:inline-block;margin-bottom:10px;color:var(--orange);
    font-size:8px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
}
.bd-process-step-copy h3{
    max-width:600px;margin:0 0 13px;color:var(--navy);
    font-family:'Fraunces',serif;font-size:clamp(31px,3.2vw,45px);
    font-weight:500;line-height:1.04;letter-spacing:-.035em;
}
.bd-process-step-copy p{
    max-width:680px;margin:0;color:var(--body);font-size:12px;line-height:1.8;
}

/* =========================================================
   CATALOG
========================================================= */

.bd-publisher-catalog{padding:60px 0 8px}
.bd-publisher-catalog-title{
    margin:0;font-size:clamp(37px,4vw,54px);line-height:1;
}

.bd-publisher-filterbar{
    display:flex;align-items:center;justify-content:space-between;
    gap:24px;padding:17px 0;border-top:1px solid var(--line);
    border-bottom:1px solid var(--line);
}

.bd-publisher-chips{
    display:flex;align-items:center;flex-wrap:wrap;gap:6px;
}

.bd-publisher-chip{
    min-height:36px;padding:0 14px;border:1px solid transparent;
    border-radius:3px;background:transparent;color:var(--body);
    font-size:11px;cursor:pointer;
}

.bd-publisher-chip:hover{
    border-color:var(--line-strong);color:var(--navy);
}

.bd-publisher-chip[aria-pressed="true"]{
    border-color:var(--navy);background:var(--navy);color:#fff;
}

.bd-publisher-search{width:280px;flex-shrink:0}

.bd-publisher-search input{
    width:100%;height:40px;padding:0 14px;border:1px solid var(--line);
    border-radius:3px;background:#fff;color:var(--ink);font-size:11px;outline:none;
}

.bd-publisher-search input:focus{border-color:var(--orange)}

.bd-publisher-result{
    min-height:58px;display:flex;align-items:center;color:var(--muted);font-size:10px;
}

/* GRID */
.bd-publisher-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,235px));
    justify-content:space-between;
    align-items:start;
    gap:46px 28px;
    padding:0 0 78px;
}

.bd-publisher-card{
    width:100%;max-width:235px;min-width:0;perspective:900px;
}

.bd-publisher-cover-card{
    width:100%;padding:9px;border:1px solid rgba(var(--book-rgb),.11);
    border-radius:6px;background:rgba(var(--book-rgb),.04);
    transform-style:preserve-3d;will-change:transform;
    transition:background .25s ease,border-color .25s ease;
}

.bd-publisher-cover-card:hover{
    background:rgba(var(--book-rgb),.07);
    border-color:rgba(var(--book-rgb),.18);
}

.bd-publisher-cover{
    position:relative;display:block;width:100%;aspect-ratio:3/4;
    overflow:hidden;padding:0;border:0;border-radius:3px;
    background:var(--navy);cursor:pointer;text-align:left;
    transform-style:preserve-3d;will-change:transform;
    box-shadow:0 13px 26px rgba(36,27,82,.10);
}

.bd-publisher-cover-image{
    position:absolute;inset:0;width:100%;height:100%;object-fit:cover;
}

.bd-publisher-cover-fallback{
    position:absolute;inset:0;display:flex;flex-direction:column;
    justify-content:space-between;padding:20px 18px;color:#fff;
}

.bd-publisher-cover-category{
    color:rgba(255,255,255,.65);font-size:8px;font-weight:600;
    letter-spacing:.12em;text-transform:uppercase;
}

.bd-publisher-cover-title{
    display:block;color:#fff;font-family:'Fraunces',serif;
    font-size:20px;line-height:1.13;
}

.bd-publisher-cover-author{
    display:block;margin-top:8px;color:rgba(255,255,255,.64);font-size:9px;
}

/* META */
.bd-publisher-card-meta{padding:14px 2px 0}
.bd-publisher-card-category{
    margin-bottom:6px;color:var(--orange);font-size:7px;font-weight:700;
    letter-spacing:.12em;text-transform:uppercase;
}
.bd-publisher-card-title{
    margin:0 0 5px;color:var(--navy);font-family:'Fraunces',serif;
    font-size:18px;font-weight:500;line-height:1.23;
}
.bd-publisher-card-sub{
    margin:0 0 10px;color:var(--body);font-size:9px;
}
.bd-publisher-card-link{
    display:inline-flex;align-items:center;gap:7px;min-height:28px;
    padding:0;border:0;background:transparent;color:var(--navy);
    font-size:9px;font-weight:600;cursor:pointer;
}
.bd-publisher-card-link::after{
    content:"→";color:var(--orange);font-size:13px;transition:transform .2s ease;
}
.bd-publisher-card-link:hover::after{transform:translateX(4px)}

/* CTA */
.bd-publisher-submit{
    display:grid;grid-template-columns:minmax(0,1fr) 250px;
    gap:50px;align-items:end;margin-bottom:76px;padding:48px 0;
    border-top:1px solid var(--navy);border-bottom:1px solid var(--line);
}
.bd-publisher-submit h2{
    max-width:700px;margin:0 0 13px;font-size:clamp(34px,4vw,53px);line-height:1.02;
}
.bd-publisher-submit p{
    max-width:620px;margin:0;color:var(--body);font-size:11px;line-height:1.8;
}
.bd-publisher-submit-button{
    min-height:46px;display:inline-flex;align-items:center;justify-content:space-between;
    gap:25px;padding:0 18px;border:1px solid var(--navy);
    background:var(--navy);color:#fff;text-decoration:none;font-size:10px;font-weight:600;
}
.bd-publisher-submit-button::after{content:"→";color:var(--orange);font-size:16px}

/* DRAWER */
.bd-publisher-overlay{
    position:fixed;z-index:9998;inset:0;background:rgba(22,17,48,.44);
    opacity:0;pointer-events:none;transition:opacity .28s ease;
}
.bd-publisher-overlay.open{opacity:1;pointer-events:auto}

.bd-publisher-drawer{
    position:fixed;z-index:9999;top:0;right:0;width:470px;max-width:94vw;
    height:100%;overflow-y:auto;transform:translateX(100%);
    border-left:1px solid var(--line);background:#fff;
    box-shadow:-30px 0 70px rgba(36,27,82,.14);transition:transform .35s ease;
}
.bd-publisher-drawer.open{transform:translateX(0)}

.bd-publisher-drawer-top{
    position:sticky;z-index:4;top:0;min-height:64px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 24px;border-bottom:1px solid var(--line);background:#fff;
}

.bd-publisher-drawer-label{
    color:var(--muted);font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
}

.bd-publisher-close{
    width:34px;height:34px;border:1px solid var(--line);
    border-radius:50%;background:#fff;color:var(--navy);cursor:pointer;
}

.bd-publisher-drawer-body{padding:31px 34px 48px}

.bd-publisher-drawer-book{
    display:grid;grid-template-columns:126px minmax(0,1fr);
    gap:24px;align-items:end;margin-bottom:32px;
}

.bd-publisher-drawer-cover-card{
    padding:8px;border:1px solid rgba(var(--book-rgb),.13);
    border-radius:6px;background:rgba(var(--book-rgb),.055);
}

.bd-publisher-drawer-cover{
    position:relative;width:108px;aspect-ratio:3/4;overflow:hidden;
    border-radius:2px;background:var(--navy);
}

.bd-publisher-drawer-cover img{
    width:100%;height:100%;object-fit:cover;
}

.bd-publisher-drawer-cover-fallback{
    width:100%;height:100%;display:flex;flex-direction:column;
    justify-content:space-between;padding:14px;color:#fff;
}

.bd-publisher-drawer-cover-category{font-size:7px;text-transform:uppercase}
.bd-publisher-drawer-cover-title{font-family:'Fraunces',serif;font-size:13px}
.bd-publisher-drawer-status{
    margin-bottom:9px;color:var(--orange);font-size:8px;font-weight:700;text-transform:uppercase;
}
.bd-publisher-drawer-title{
    margin:0 0 8px;color:var(--navy);font-family:'Fraunces',serif;font-size:27px;
}
.bd-publisher-drawer-author{color:var(--body);font-size:11px}

.bd-publisher-meta{
    display:grid;grid-template-columns:1fr 1fr;margin-bottom:31px;
    border-top:1px solid var(--line);border-bottom:1px solid var(--line);
}

.bd-publisher-meta-item{padding:17px 12px}
.bd-publisher-meta-label{
    display:block;margin-bottom:6px;color:var(--muted);font-size:8px;text-transform:uppercase;
}
.bd-publisher-meta-value{color:var(--ink);font-size:11px}
.bd-publisher-synopsis-label{
    margin-bottom:12px;color:var(--orange);font-size:8px;font-weight:700;text-transform:uppercase;
}
.bd-publisher-synopsis{color:var(--body);font-size:12px;line-height:1.8}
.bd-publisher-empty{
    display:none;padding:70px 20px;color:var(--muted);text-align:center;font-size:12px;
}

/* RESPONSIVE */
@media(max-width:1100px){
    .bd-publisher-grid{
        grid-template-columns:repeat(3,minmax(0,220px));
        justify-content:space-between;
    }
    .bd-publisher-card{max-width:220px}
}

@media(max-width:1000px){
    .bd-publisher-service-grid{grid-template-columns:repeat(2,1fr)}
    .bd-process-layout{grid-template-columns:230px minmax(0,1fr);gap:35px}
    .bd-process-step-inner{grid-template-columns:90px minmax(0,1fr);gap:25px}
}

@media(max-width:800px){
    .bd-publisher-shell{width:calc(100% - 40px)}
    .bd-publisher-hero{grid-template-columns:1fr}
    .bd-publisher-about,.bd-publisher-section-head,.bd-publisher-catalog-head,.bd-publisher-submit{
        grid-template-columns:1fr;
    }

    .bd-process-layout{grid-template-columns:1fr;gap:35px}
    .bd-process-side{position:relative;top:auto}
    .bd-process-side h2,.bd-process-side p{max-width:520px}
    .bd-process-step-row{
        grid-template-columns:75px minmax(0,1fr);gap:20px;min-height:280px;
    }
    .bd-process-step{min-height:280px}
    .bd-process-track,.bd-process-track-fill{left:13px;top:140px;bottom:140px}
    .bd-process-marker-dot{width:28px;height:28px;flex-basis:28px}
    .bd-process-marker-number{font-size:16px}

    .bd-publisher-grid{
        grid-template-columns:repeat(2,minmax(0,210px));
        justify-content:start;gap:42px 28px;
    }
    .bd-publisher-card{max-width:210px}
}

@media(max-width:600px){
    .bd-publisher-shell{width:calc(100% - 30px)}
    .bd-publisher-brand-type{display:none}
    .bd-publisher-hero{min-height:0;padding:45px 0 25px}
    .bd-publisher-hero h1{font-size:40px}

    .bd-publisher-motion{
        height:265px;
        transform:scale(.78);
        transform-origin:center center;
    }

    .bd-publisher-service-grid{grid-template-columns:1fr}
    .bd-publisher-filterbar{flex-direction:column;align-items:flex-start}
    .bd-publisher-search{width:100%}
    .bd-publisher-drawer{width:100%;max-width:100%}

    .bd-process-step-row{
        grid-template-columns:62px minmax(0,1fr);gap:13px;min-height:250px;
    }
    .bd-process-step{min-height:250px;padding:30px 0}
    .bd-process-track,.bd-process-track-fill{
        left:11px;top:125px;bottom:125px;width:2px;
    }
    .bd-process-marker{gap:8px}
    .bd-process-marker-dot{
        width:24px;height:24px;flex-basis:24px;border-width:2px;
        box-shadow:0 0 0 4px #fff;
    }
    .bd-process-marker.active .bd-process-marker-dot{
        box-shadow:0 0 0 4px #fff,0 0 0 7px rgba(239,88,67,.13);
    }
    .bd-process-marker-number{font-size:13px}
    .bd-process-step-inner{grid-template-columns:1fr;gap:8px}
    .bd-process-big-number{font-size:48px}
    .bd-process-step-copy h3{font-size:27px}
    .bd-process-step-copy p{font-size:10px}

    .bd-publisher-grid{
        grid-template-columns:1fr;justify-items:start;gap:38px;
    }

    .bd-publisher-card{
        width:min(72vw,215px);
        max-width:215px;
    }
}

@media(prefers-reduced-motion:reduce){
    .bd-publisher *{
        animation-duration:.001ms!important;
        animation-iteration-count:1!important;
    }
}
</style>


<section class="bd-publisher" id="bdPublisherPage">
    <div class="bd-publisher-shell">

        {{-- BRAND --}}
        <div class="bd-publisher-brandbar">
            <div class="bd-publisher-brand">
                <span class="bd-publisher-brand-mark"></span>
                <span class="bd-publisher-brand-name">BacaDulu</span>
                <span class="bd-publisher-brand-type">Publisher</span>
            </div>
        </div>


        {{-- =========================================================
             HERO
        ========================================================== --}}

        <section class="bd-publisher-hero" id="bdPublisherHero">

            <div class="bd-publisher-hero-copy">

                <div
                    class="bd-publisher-eyebrow js-typewriter"
                    data-text="Baca Publisher"
                >
                    Baca Publisher
                </div>

                <h1 class="js-word-reveal">
                    Karya yang layak diterbitkan dan dibaca lebih luas.
                </h1>

                <p class="bd-publisher-hero-description">
                    BacaDulu Publisher menerbitkan buku, monograf, referensi, dan bahan ajar melalui proses editorial yang terarah agar setiap karya memiliki kualitas, identitas, dan nilai baca yang kuat.
                </p>

            </div>


            {{-- =====================================================
                 HERO ANIMATED BOOKS
                 OTOMATIS DARI DATABASE BOOKS
            ====================================================== --}}

            <div
                class="bd-publisher-motion"
                id="bdPublisherMotion"
                aria-hidden="true"
            >

                <div
                    class="bd-publisher-motion-orbit"
                    id="bdPublisherOrbit"
                >
                    <span class="bd-publisher-orbit-dot"></span>
                </div>

                <span class="bd-axis-x"></span>
                <span class="bd-axis-y"></span>


                @if($publisherHeroBooks->isNotEmpty())

                    @foreach($publisherHeroBooks as $index => $heroBook)

                        <div
                            class="bd-publisher-float {{ $heroFloatClasses[$index] ?? 'bd-float-four' }} js-bd-float"
                        >
                            <div
                                class="bd-publisher-float-book has-cover"
                                title="{{ $heroBook['title'] }}"
                            >
                                <img
                                    src="{{ $heroBook['cover'] }}"
                                    alt="{{ $heroBook['title'] }}"
                                    class="bd-publisher-hero-cover"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    draggable="false"
                                >
                            </div>
                        </div>

                    @endforeach

                @else

                    {{-- FALLBACK JIKA DATABASE BELUM PUNYA COVER --}}

                    <div class="bd-publisher-float bd-float-two js-bd-float">
                        <div
                            class="bd-publisher-float-book is-fallback"
                            style="background:var(--orange)"
                        >
                            <div class="bd-publisher-float-label">
                                <small>BacaDulu</small>
                                Buku
                            </div>
                        </div>
                    </div>

                    <div class="bd-publisher-float bd-float-three js-bd-float">
                        <div
                            class="bd-publisher-float-book is-fallback"
                            style="background:var(--blue)"
                        >
                            <div class="bd-publisher-float-label">
                                <small>BacaDulu</small>
                                Referensi
                            </div>
                        </div>
                    </div>

                    <div class="bd-publisher-float bd-float-four js-bd-float">
                        <div
                            class="bd-publisher-float-book is-fallback"
                            style="background:var(--plum)"
                        ></div>
                    </div>

                    <div class="bd-publisher-float bd-float-one js-bd-float">
                        <div
                            class="bd-publisher-float-book is-fallback"
                            style="background:var(--navy)"
                        >
                            <div class="bd-publisher-float-label">
                                <small>BacaDulu Publisher</small>
                                Ideas become books.
                            </div>
                        </div>
                    </div>

                @endif


                <span
                    class="bd-publisher-motion-pulse"
                    id="bdPublisherPulse"
                ></span>

            </div>

        </section>


        {{-- =========================================================
             ABOUT
        ========================================================== --}}

        <section class="bd-publisher-about js-scroll-section">

            <div
                class="bd-publisher-section-label js-typewriter"
                data-text="Tentang Publisher"
            >
                Tentang Publisher
            </div>

            <div class="bd-publisher-about-copy">

                <h2 class="js-section-title">
                    Menjaga kualitas isi, identitas karya, dan pengalaman membaca.
                </h2>

                <p class="js-section-copy">
                    BacaDulu Publisher menjadi ruang penerbitan bagi karya akademik dan nonakademik, mulai dari monograf, buku ajar, referensi, hingga buku untuk pembaca umum.
                </p>

                <p class="js-section-copy">
                    Setiap naskah dipersiapkan melalui proses editorial dan penerbitan agar tidak hanya selesai dicetak, tetapi memiliki struktur, identitas, dan penyajian yang layak untuk dibaca lebih luas.
                </p>

            </div>

        </section>


        {{-- =========================================================
             SERVICES
        ========================================================== --}}

        <section
            class="bd-publisher-services js-scroll-section"
            data-mode="services"
        >

            <div class="bd-publisher-section-head">

                <div>

                    <span
                        class="bd-publisher-section-eyebrow js-typewriter"
                        data-text="Layanan Penerbitan"
                    >
                        Layanan Penerbitan
                    </span>

                    <h2 class="bd-publisher-section-title js-section-title">
                        Dari naskah menjadi buku yang siap terbit.
                    </h2>

                </div>

                <p class="bd-publisher-section-description js-section-copy">
                    Proses penerbitan disiapkan secara menyeluruh agar naskah memiliki kualitas editorial, visual, dan identitas penerbitan yang baik.
                </p>

            </div>


            <div class="bd-publisher-service-grid">

                <article class="bd-publisher-service js-service">
                    <div class="bd-publisher-service-number">01</div>
                    <h3>Editorial & Penyuntingan</h3>
                    <p>
                        Penyiapan struktur naskah, penyuntingan bahasa, proofreading, dan finalisasi sebelum produksi.
                    </p>
                </article>

                <article class="bd-publisher-service js-service">
                    <div class="bd-publisher-service-number">02</div>
                    <h3>Desain & Tata Letak</h3>
                    <p>
                        Penataan isi dan desain sampul agar buku memiliki karakter visual yang sesuai dengan isi dan pembacanya.
                    </p>
                </article>

                <article class="bd-publisher-service js-service">
                    <div class="bd-publisher-service-number">03</div>
                    <h3>ISBN & Penerbitan</h3>
                    <p>
                        Persiapan administrasi penerbitan untuk buku cetak maupun format digital sesuai kebutuhan karya.
                    </p>
                </article>

                <article class="bd-publisher-service js-service">
                    <div class="bd-publisher-service-number">04</div>
                    <h3>Cetak & Publikasi</h3>
                    <p>
                        Persiapan produksi buku sekaligus dukungan agar karya dapat hadir dan dikenal oleh pembacanya.
                    </p>
                </article>

            </div>

        </section>


        {{-- =========================================================
             PROCESS
        ========================================================== --}}

        <section
            class="bd-publisher-process"
            id="bdPublisherProcess"
        >

            <div class="bd-process-layout">

                <aside class="bd-process-side">

                    <span
                        class="bd-publisher-section-eyebrow js-process-typewriter"
                        data-text="Alur Penerbitan"
                    >
                        Alur Penerbitan
                    </span>

                    <h2>
                        Satu proses yang jelas dari awal sampai terbit.
                    </h2>

                    <p>
                        Scroll ke bawah untuk mengikuti setiap tahap penerbitan dari pengajuan naskah hingga karya resmi terbit.
                    </p>

                </aside>


                <div class="bd-process-flow">

                    <div class="bd-process-track"></div>

                    <div
                        class="bd-process-track-fill"
                        id="bdProcessTrackFill"
                    ></div>


                    @php
                        $steps = [
                            [
                                '01',
                                'Tahap Pertama',
                                'Pengajuan Naskah',
                                'Penulis mengirimkan naskah dan informasi dasar mengenai karya yang ingin diterbitkan melalui BacaDulu Publisher.'
                            ],
                            [
                                '02',
                                'Tahap Kedua',
                                'Review Naskah',
                                'Tim melakukan pemeriksaan awal untuk memahami karakter naskah, kelayakan penerbitan, serta kebutuhan pengerjaan sebelum masuk tahap editorial.'
                            ],
                            [
                                '03',
                                'Tahap Ketiga',
                                'Editorial & Penyuntingan',
                                'Naskah memasuki proses penyuntingan, proofreading, penyempurnaan struktur, dan penyesuaian penyajian agar lebih siap dibaca.'
                            ],
                            [
                                '04',
                                'Tahap Keempat',
                                'Desain & Finalisasi',
                                'Isi buku ditata, desain sampul disiapkan, metadata dilengkapi, dan keseluruhan materi difinalisasi sebelum memasuki proses penerbitan.'
                            ],
                            [
                                '05',
                                'Tahap Kelima',
                                'Buku Resmi Terbit',
                                'Karya memasuki proses penerbitan dan produksi hingga akhirnya siap hadir sebagai buku yang dapat dibaca dan dikenali oleh pembacanya.'
                            ],
                        ];
                    @endphp


                    @foreach($steps as $index => $step)

                        <div
                            class="bd-process-step-row"
                            data-process-step="{{ $index }}"
                        >

                            <div
                                class="bd-process-marker {{ $index === 0 ? 'active' : '' }}"
                                data-process-marker="{{ $index }}"
                            >
                                <span class="bd-process-marker-dot"></span>
                                <span class="bd-process-marker-number">
                                    {{ $step[0] }}
                                </span>
                            </div>


                            <article class="bd-process-step">

                                <div class="bd-process-step-inner">

                                    <div class="bd-process-big-number">
                                        {{ $step[0] }}
                                    </div>

                                    <div class="bd-process-step-copy">

                                        <span class="bd-process-step-label">
                                            {{ $step[1] }}
                                        </span>

                                        <h3>
                                            {{ $step[2] }}
                                        </h3>

                                        <p>
                                            {{ $step[3] }}
                                        </p>

                                    </div>

                                </div>

                            </article>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- =========================================================
             CATALOG
        ========================================================== --}}

        <section
            class="bd-publisher-catalog js-scroll-section"
            data-mode="catalog"
        >

            <div class="bd-publisher-catalog-head">

                <div>

                    <span
                        class="bd-publisher-section-eyebrow js-typewriter"
                        data-text="Katalog BacaDulu"
                    >
                        Katalog BacaDulu
                    </span>

                    <h2 class="bd-publisher-catalog-title js-section-title">
                        Terbitan kami.
                    </h2>

                </div>

                <p class="bd-publisher-section-description js-section-copy">
                    Jelajahi karya yang telah diterbitkan berdasarkan kategori, judul, atau nama penulis.
                </p>

            </div>


            <div class="bd-publisher-filterbar js-catalog-filter">

                <div
                    class="bd-publisher-chips"
                    id="bdPublisherChips"
                ></div>

                <div class="bd-publisher-search">

                    <input
                        type="text"
                        id="bdPublisherSearch"
                        placeholder="Cari judul atau penulis"
                        autocomplete="off"
                    >

                </div>

            </div>


            <div class="bd-publisher-result">
                <span id="bdPublisherResultCount"></span>
            </div>


            <div
                class="bd-publisher-grid"
                id="bdPublisherGrid"
            ></div>


            <div
                class="bd-publisher-empty"
                id="bdPublisherEmpty"
            >
                Tidak ada buku yang sesuai dengan pencarian.
            </div>

        </section>


        {{-- =========================================================
             CTA
        ========================================================== --}}

        <section
            class="bd-publisher-submit js-scroll-section"
            data-mode="cta"
        >

            <div>

                <span
                    class="bd-publisher-section-eyebrow js-typewriter"
                    data-text="Punya Naskah?"
                >
                    Punya Naskah?
                </span>

                <h2 class="js-section-title">
                    Mulai perjalanan penerbitan karya Anda.
                </h2>

                <p class="js-section-copy">
                    Konsultasikan naskah dan kebutuhan penerbitan untuk mengetahui proses yang sesuai dengan karya Anda.
                </p>

            </div>

            <a
                href="#"
                class="bd-publisher-submit-button js-submit-button"
            >
                Ajukan Naskah
            </a>

        </section>

    </div>
</section>


{{-- =========================================================
     DRAWER
========================================================= --}}

<div
    class="bd-publisher-overlay"
    id="bdPublisherOverlay"
></div>

<aside
    class="bd-publisher-drawer"
    id="bdPublisherDrawer"
    aria-hidden="true"
>

    <div class="bd-publisher-drawer-top">

        <div class="bd-publisher-drawer-label">
            Detail Terbitan
        </div>

        <button
            type="button"
            class="bd-publisher-close"
            id="bdPublisherClose"
        >
            ×
        </button>

    </div>

    <div
        class="bd-publisher-drawer-body"
        id="bdPublisherDrawerBody"
    ></div>

</aside>


<script>
(() => {

    const BOOKS = @json($publisherBookData);

    const COLORS = {
        'Monograf':{hex:'#241B52',rgb:'36,27,82'},
        'Referensi':{hex:'#EF5843',rgb:'239,88,67'},
        'Buku Ajar':{hex:'#566B91',rgb:'86,107,145'},
        'Umum':{hex:'#80586F',rgb:'128,88,111'}
    };

    const FALLBACK = [
        {hex:'#241B52',rgb:'36,27,82'},
        {hex:'#EF5843',rgb:'239,88,67'},
        {hex:'#566B91',rgb:'86,107,145'},
        {hex:'#80586F',rgb:'128,88,111'}
    ];

    let gsapInstance = null;
    let activeCategory = 'Semua';
    let searchTerm = '';
    let lastFocusedElement = null;


    const escapeHtml = value => String(value ?? '')
        .replaceAll('&','&amp;')
        .replaceAll('<','&lt;')
        .replaceAll('>','&gt;')
        .replaceAll('"','&quot;')
        .replaceAll("'",'&#039;');


    const categories = [
        ...new Set(
            BOOKS
                .map(book => book.category || 'Umum')
                .filter(Boolean)
        )
    ];


    const getColor = category => {

        if (COLORS[category]) {
            return COLORS[category];
        }

        let index =
            categories.indexOf(category);

        if (index < 0) {
            index = 0;
        }

        return FALLBACK[
            index % FALLBACK.length
        ];
    };


    const resolveGsap = () => {

        const candidates = [
            window.bdGsap,
            window.bdGsap?.gsap,
            window.gsap,
            window.GSAP
        ];

        return candidates.find(item =>
            item &&
            typeof item.to === 'function' &&
            typeof item.fromTo === 'function' &&
            typeof item.timeline === 'function'
        ) || null;
    };


    /* =========================================================
       TYPEWRITER
    ========================================================= */

    const typeText = (element,gsap) => {

        if (
            !element ||
            element.dataset.typed === '1'
        ) {
            return;
        }

        const text =
            element.dataset.text ||
            element.textContent.trim();

        element.dataset.typed = '1';

        element.setAttribute(
            'aria-label',
            text
        );

        element.innerHTML = `
            <span
                class="bd-typewriter"
                aria-hidden="true"
            >
                <span class="bd-typewriter-text"></span>
                <span class="bd-typewriter-cursor"></span>
            </span>
        `;

        const output =
            element.querySelector(
                '.bd-typewriter-text'
            );

        const cursor =
            element.querySelector(
                '.bd-typewriter-cursor'
            );

        const state = {
            value:0
        };

        gsap.to(
            state,
            {
                value:text.length,
                duration:Math.max(
                    .42,
                    text.length * .032
                ),
                ease:'none',

                onUpdate:() => {

                    output.textContent =
                        text.slice(
                            0,
                            Math.round(
                                state.value
                            )
                        );

                },

                onComplete:() => {

                    output.textContent =
                        text;

                    if (cursor) {

                        gsap.to(
                            cursor,
                            {
                                opacity:0,
                                duration:.1,

                                onComplete:() =>
                                    cursor.remove()
                            }
                        );

                    }

                }
            }
        );
    };


    /* =========================================================
       HERO WORDS
    ========================================================= */

    const splitWords = element => {

        if (
            !element ||
            element.dataset.split === '1'
        ) {
            return [];
        }

        const text =
            element.textContent
                .trim()
                .replace(/\s+/g,' ');

        element.dataset.split = '1';

        element.setAttribute(
            'aria-label',
            text
        );

        element.innerHTML =
            text
                .split(' ')
                .map(word =>
                    `<span class="bd-word" aria-hidden="true">${escapeHtml(word)}</span>`
                )
                .join(' ');

        return [
            ...element.querySelectorAll(
                '.bd-word'
            )
        ];
    };


    /* =========================================================
       HERO ANIMATION
    ========================================================= */

    const animateHero = gsap => {

        const hero =
            document.getElementById(
                'bdPublisherHero'
            );

        const motion =
            document.getElementById(
                'bdPublisherMotion'
            );

        if (
            !hero ||
            !motion
        ) {
            return;
        }

        const words =
            splitWords(
                hero.querySelector(
                    '.js-word-reveal'
                )
            );

        const description =
            hero.querySelector(
                '.bd-publisher-hero-description'
            );

        const floats = [
            ...motion.querySelectorAll(
                '.js-bd-float'
            )
        ];

        const orbit =
            document.getElementById(
                'bdPublisherOrbit'
            );

        const pulse =
            document.getElementById(
                'bdPublisherPulse'
            );


        const tl =
            gsap.timeline({
                delay:.08
            });


        tl.fromTo(
            words,
            {
                opacity:0,
                y:38,
                rotationX:-22
            },
            {
                opacity:1,
                y:0,
                rotationX:0,
                duration:.7,
                stagger:.045,
                ease:'power3.out'
            }
        );


        tl.fromTo(
            description,
            {
                opacity:0,
                y:22
            },
            {
                opacity:1,
                y:0,
                duration:.55,
                ease:'power3.out'
            },
            '-=.35'
        );


        tl.call(
            () =>
                typeText(
                    hero.querySelector(
                        '.js-typewriter'
                    ),
                    gsap
                ),
            null,
            '-=.28'
        );


        /*
        |--------------------------------------------------------------------------
        | COVER DATABASE MASUK
        |--------------------------------------------------------------------------
        */

        gsap.fromTo(
            floats,
            {
                opacity:0,
                scale:.72,
                y:38,
                rotationY:-9
            },
            {
                opacity:1,
                scale:1,
                y:0,
                rotationY:0,
                duration:.9,
                stagger:.11,
                ease:'back.out(1.45)',
                delay:.18
            }
        );


        /*
        |--------------------------------------------------------------------------
        | FLOAT LOOP
        |--------------------------------------------------------------------------
        */

        floats.forEach(
            (item,index) => {

                gsap.to(
                    item,
                    {
                        y:
                            index % 2 === 0
                                ? -13
                                : 11,

                        x:
                            index % 3 === 0
                                ? 4
                                : -4,

                        duration:
                            2.6 +
                            index * .38,

                        repeat:-1,
                        yoyo:true,
                        ease:'sine.inOut'
                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | ORBIT
        |--------------------------------------------------------------------------
        */

        if (orbit) {

            gsap.to(
                orbit,
                {
                    rotation:360,
                    duration:20,
                    repeat:-1,
                    ease:'none'
                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | PULSE
        |--------------------------------------------------------------------------
        */

        if (pulse) {

            gsap.to(
                pulse,
                {
                    scale:1.55,
                    opacity:.45,
                    duration:1.3,
                    repeat:-1,
                    yoyo:true,
                    ease:'sine.inOut'
                }
            );

        }

    };


    /* =========================================================
       NORMAL SECTIONS
    ========================================================= */

    const initSectionAnimations = gsap => {

        const observer =
            new IntersectionObserver(
                entries => {

                    entries.forEach(
                        entry => {

                            if (
                                !entry.isIntersecting
                            ) {
                                return;
                            }

                            const section =
                                entry.target;

                            if (
                                section.dataset.animated === '1'
                            ) {
                                return;
                            }

                            section.dataset.animated =
                                '1';


                            const typewriter =
                                section.querySelector(
                                    '.js-typewriter'
                                );

                            const title =
                                section.querySelector(
                                    '.js-section-title'
                                );

                            const copies =
                                section.querySelectorAll(
                                    '.js-section-copy'
                                );


                            if (typewriter) {
                                typeText(
                                    typewriter,
                                    gsap
                                );
                            }


                            if (title) {

                                gsap.fromTo(
                                    title,
                                    {
                                        opacity:0,
                                        y:38
                                    },
                                    {
                                        opacity:1,
                                        y:0,
                                        duration:.7,
                                        ease:'power3.out'
                                    }
                                );

                            }


                            if (copies.length) {

                                gsap.fromTo(
                                    copies,
                                    {
                                        opacity:0,
                                        y:22
                                    },
                                    {
                                        opacity:1,
                                        y:0,
                                        duration:.58,
                                        stagger:.1,
                                        delay:.1,
                                        ease:'power3.out'
                                    }
                                );

                            }


                            if (
                                section.dataset.mode ===
                                'services'
                            ) {

                                gsap.fromTo(
                                    section.querySelectorAll(
                                        '.js-service'
                                    ),
                                    {
                                        opacity:0,
                                        y:52,
                                        scale:.95
                                    },
                                    {
                                        opacity:1,
                                        y:0,
                                        scale:1,
                                        duration:.68,
                                        stagger:.11,
                                        delay:.15,
                                        ease:'back.out(1.2)'
                                    }
                                );

                            }


                            if (
                                section.dataset.mode ===
                                'catalog'
                            ) {

                                const filter =
                                    section.querySelector(
                                        '.js-catalog-filter'
                                    );

                                if (filter) {

                                    gsap.fromTo(
                                        filter,
                                        {
                                            opacity:0,
                                            y:24
                                        },
                                        {
                                            opacity:1,
                                            y:0,
                                            duration:.55,
                                            delay:.15,
                                            ease:'power3.out'
                                        }
                                    );

                                }

                                requestAnimationFrame(
                                    () =>
                                        animateBookCards(
                                            gsap
                                        )
                                );

                            }


                            if (
                                section.dataset.mode ===
                                'cta'
                            ) {

                                const button =
                                    section.querySelector(
                                        '.js-submit-button'
                                    );

                                if (button) {

                                    gsap.fromTo(
                                        button,
                                        {
                                            opacity:0,
                                            x:45
                                        },
                                        {
                                            opacity:1,
                                            x:0,
                                            duration:.65,
                                            delay:.15,
                                            ease:'power3.out'
                                        }
                                    );

                                }

                            }


                            observer.unobserve(
                                section
                            );

                        }
                    );

                },
                {
                    threshold:.12,
                    rootMargin:'0px 0px -5% 0px'
                }
            );


        document
            .querySelectorAll(
                '.js-scroll-section'
            )
            .forEach(
                section =>
                    observer.observe(
                        section
                    )
            );
    };


    /* =========================================================
       PROCESS
    ========================================================= */

    const initProcessAnimations = gsap => {

        const process =
            document.getElementById(
                'bdPublisherProcess'
            );

        if (!process) {
            return;
        }


        const rows = [
            ...process.querySelectorAll(
                '[data-process-step]'
            )
        ];

        const markers = [
            ...process.querySelectorAll(
                '[data-process-marker]'
            )
        ];

        const fill =
            document.getElementById(
                'bdProcessTrackFill'
            );

        const typewriter =
            process.querySelector(
                '.js-process-typewriter'
            );


        const setActive = index => {

            markers.forEach(
                (marker,i) => {

                    marker.classList.toggle(
                        'active',
                        i === index
                    );

                    marker.classList.toggle(
                        'done',
                        i < index
                    );

                }
            );


            if (fill) {

                const progress =
                    rows.length <= 1
                        ? 1
                        : index /
                          (rows.length - 1);

                gsap.to(
                    fill,
                    {
                        scaleY:
                            Math.max(
                                .001,
                                progress
                            ),
                        duration:.55,
                        ease:'power2.out'
                    }
                );

            }

        };


        const headerObserver =
            new IntersectionObserver(
                entries => {

                    entries.forEach(
                        entry => {

                            if (
                                !entry.isIntersecting
                            ) {
                                return;
                            }

                            if (typewriter) {

                                typeText(
                                    typewriter,
                                    gsap
                                );

                            }

                            gsap.fromTo(
                                process.querySelectorAll(
                                    '.bd-process-side h2,.bd-process-side p'
                                ),
                                {
                                    opacity:0,
                                    y:24
                                },
                                {
                                    opacity:1,
                                    y:0,
                                    duration:.6,
                                    stagger:.09,
                                    ease:'power3.out'
                                }
                            );

                            headerObserver.disconnect();

                        }
                    );

                },
                {
                    threshold:.12
                }
            );


        headerObserver.observe(
            process
        );


        const rowObserver =
            new IntersectionObserver(
                entries => {

                    entries.forEach(
                        entry => {

                            if (
                                !entry.isIntersecting
                            ) {
                                return;
                            }

                            const row =
                                entry.target;

                            const index =
                                Number(
                                    row.dataset.processStep
                                );

                            setActive(
                                index
                            );


                            if (
                                row.dataset.animated ===
                                '1'
                            ) {
                                return;
                            }

                            row.dataset.animated =
                                '1';


                            const marker =
                                row.querySelector(
                                    '.bd-process-marker'
                                );

                            const number =
                                row.querySelector(
                                    '.bd-process-big-number'
                                );

                            const label =
                                row.querySelector(
                                    '.bd-process-step-label'
                                );

                            const title =
                                row.querySelector(
                                    'h3'
                                );

                            const copy =
                                row.querySelector(
                                    'p'
                                );

                            const direction =
                                index % 2 === 0
                                    ? 38
                                    : -38;


                            gsap.fromTo(
                                marker,
                                {
                                    opacity:0,
                                    scale:.65
                                },
                                {
                                    opacity:1,
                                    scale:1,
                                    duration:.5,
                                    ease:'back.out(1.7)'
                                }
                            );


                            gsap.fromTo(
                                number,
                                {
                                    opacity:0,
                                    scale:.72,
                                    rotation:
                                        index % 2 === 0
                                            ? -7
                                            : 7
                                },
                                {
                                    opacity:1,
                                    scale:1,
                                    rotation:0,
                                    duration:.55,
                                    ease:'back.out(1.5)'
                                }
                            );


                            gsap.fromTo(
                                label,
                                {
                                    opacity:0,
                                    y:12
                                },
                                {
                                    opacity:1,
                                    y:0,
                                    duration:.4,
                                    delay:.07,
                                    ease:'power3.out'
                                }
                            );


                            gsap.fromTo(
                                title,
                                {
                                    opacity:0,
                                    x:direction
                                },
                                {
                                    opacity:1,
                                    x:0,
                                    duration:.58,
                                    delay:.1,
                                    ease:'power3.out'
                                }
                            );


                            gsap.fromTo(
                                copy,
                                {
                                    opacity:0,
                                    y:20
                                },
                                {
                                    opacity:1,
                                    y:0,
                                    duration:.52,
                                    delay:.18,
                                    ease:'power3.out'
                                }
                            );

                        }
                    );

                },
                {
                    threshold:.4,
                    rootMargin:'-5% 0px -20% 0px'
                }
            );


        rows.forEach(
            row =>
                rowObserver.observe(
                    row
                )
        );

        setActive(0);
    };


    /* =========================================================
       BOOK COVER
    ========================================================= */

    const coverMarkup = book => {

        const color =
            getColor(
                book.category ||
                'Umum'
            );


        if (book.cover) {

            return `
                <div
                    class="bd-publisher-cover-card"
                    style="--book-rgb:${color.rgb}"
                >
                    <button
                        type="button"
                        class="bd-publisher-cover"
                        data-id="${book.id}"
                    >
                        <img
                            src="${escapeHtml(book.cover)}"
                            alt="${escapeHtml(book.title)}"
                            class="bd-publisher-cover-image"
                            loading="lazy"
                        >
                    </button>
                </div>
            `;

        }


        return `
            <div
                class="bd-publisher-cover-card"
                style="--book-rgb:${color.rgb}"
            >

                <button
                    type="button"
                    class="bd-publisher-cover"
                    data-id="${book.id}"
                    style="background:${color.hex}"
                >

                    <span
                        class="bd-publisher-cover-fallback"
                        style="background:${color.hex}"
                    >

                        <span class="bd-publisher-cover-category">
                            ${escapeHtml(book.category || 'Umum')}
                        </span>

                        <span>

                            <span class="bd-publisher-cover-title">
                                ${escapeHtml(book.title)}
                            </span>

                            <span class="bd-publisher-cover-author">
                                ${escapeHtml(book.author || '-')}
                            </span>

                        </span>

                    </span>

                </button>

            </div>
        `;
    };


    /* =========================================================
       FILTER
    ========================================================= */

    const renderChips = () => {

        const container =
            document.getElementById(
                'bdPublisherChips'
            );

        if (!container) {
            return;
        }


        container.innerHTML =
            [
                'Semua',
                ...categories
            ]
            .map(
                category => `
                    <button
                        type="button"
                        class="bd-publisher-chip"
                        data-category="${escapeHtml(category)}"
                        aria-pressed="${category === activeCategory}"
                    >
                        ${escapeHtml(category)}
                    </button>
                `
            )
            .join('');


        container
            .querySelectorAll(
                '.bd-publisher-chip'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            activeCategory =
                                button.dataset.category;

                            renderChips();
                            renderGrid();

                        }
                    );

                }
            );
    };


    /* =========================================================
       GRID
    ========================================================= */

    const renderGrid = () => {

        const grid =
            document.getElementById(
                'bdPublisherGrid'
            );

        const result =
            document.getElementById(
                'bdPublisherResultCount'
            );

        const empty =
            document.getElementById(
                'bdPublisherEmpty'
            );


        if (
            !grid ||
            !result ||
            !empty
        ) {
            return;
        }


        const query =
            searchTerm
                .trim()
                .toLocaleLowerCase(
                    'id-ID'
                );


        const filtered =
            BOOKS.filter(
                book => {

                    const category =
                        book.category ||
                        'Umum';

                    const title =
                        String(
                            book.title ||
                            ''
                        )
                        .toLocaleLowerCase(
                            'id-ID'
                        );

                    const author =
                        String(
                            book.author ||
                            ''
                        )
                        .toLocaleLowerCase(
                            'id-ID'
                        );


                    return (
                        (
                            activeCategory ===
                            'Semua' ||
                            category ===
                            activeCategory
                        )
                        &&
                        (
                            !query ||
                            title.includes(
                                query
                            ) ||
                            author.includes(
                                query
                            )
                        )
                    );

                }
            );


        result.textContent =
            `${filtered.length} judul ditemukan`;


        if (!filtered.length) {

            grid.style.display =
                'none';

            empty.style.display =
                'block';

            return;

        }


        grid.style.display =
            'grid';

        empty.style.display =
            'none';


        grid.innerHTML =
            filtered
                .map(
                    book => `
                        <article class="bd-publisher-card">

                            ${coverMarkup(book)}

                            <div class="bd-publisher-card-meta">

                                <div class="bd-publisher-card-category">
                                    ${escapeHtml(book.category || 'Umum')}
                                </div>

                                <h3 class="bd-publisher-card-title">
                                    ${escapeHtml(book.title)}
                                </h3>

                                <p class="bd-publisher-card-sub">
                                    ${escapeHtml(book.author || '-')}
                                    ·
                                    ${escapeHtml(book.year || '-')}
                                </p>

                                <button
                                    type="button"
                                    class="bd-publisher-card-link"
                                    data-id="${book.id}"
                                >
                                    Lihat detail
                                </button>

                            </div>

                        </article>
                    `
                )
                .join('');


        bindBookEvents();


        const catalog =
            document.querySelector(
                '.bd-publisher-catalog'
            );


        if (
            gsapInstance &&
            catalog?.dataset.animated ===
            '1'
        ) {

            requestAnimationFrame(
                () =>
                    animateBookCards(
                        gsapInstance
                    )
            );

        }

    };


    /* =========================================================
       BOOK REVEAL
    ========================================================= */

    const animateBookCards = gsap => {

        const cards = [
            ...document.querySelectorAll(
                '#bdPublisherGrid .bd-publisher-card'
            )
        ];


        if (!cards.length) {
            return;
        }


        gsap.killTweensOf(
            cards
        );


        gsap.fromTo(
            cards,
            {
                opacity:0,
                y:52,
                scale:.9,
                rotationY:-12,
                rotationZ:-2,
                transformOrigin:'50% 100%'
            },
            {
                opacity:1,
                y:0,
                scale:1,
                rotationY:0,
                rotationZ:0,
                duration:.72,
                stagger:.085,
                ease:'back.out(1.15)',
                clearProps:'transform'
            }
        );

    };


    /* =========================================================
       BOOK HOVER
    ========================================================= */

    const bindBookTilt = () => {

        if (!gsapInstance) {
            return;
        }


        if (
            !window.matchMedia(
                '(hover:hover) and (pointer:fine)'
            ).matches
        ) {
            return;
        }


        document
            .querySelectorAll(
                '.bd-publisher-cover-card'
            )
            .forEach(
                card => {

                    if (
                        card.dataset.tiltBound ===
                        '1'
                    ) {
                        return;
                    }


                    card.dataset.tiltBound =
                        '1';


                    const cover =
                        card.querySelector(
                            '.bd-publisher-cover'
                        );


                    if (!cover) {
                        return;
                    }


                    card.addEventListener(
                        'pointermove',
                        event => {

                            const rect =
                                card.getBoundingClientRect();

                            const x =
                                (
                                    event.clientX -
                                    rect.left
                                )
                                /
                                rect.width
                                -
                                .5;

                            const y =
                                (
                                    event.clientY -
                                    rect.top
                                )
                                /
                                rect.height
                                -
                                .5;


                            gsapInstance.to(
                                card,
                                {
                                    y:-7,
                                    rotationY:
                                        x * 8,
                                    rotationX:
                                        -y * 6,
                                    duration:.35,
                                    ease:'power2.out',
                                    overwrite:'auto'
                                }
                            );


                            gsapInstance.to(
                                cover,
                                {
                                    scale:1.025,
                                    duration:.35,
                                    ease:'power2.out',
                                    overwrite:'auto'
                                }
                            );

                        }
                    );


                    card.addEventListener(
                        'pointerleave',
                        () => {

                            gsapInstance.to(
                                card,
                                {
                                    y:0,
                                    rotationX:0,
                                    rotationY:0,
                                    duration:.55,
                                    ease:'power3.out',
                                    overwrite:'auto'
                                }
                            );


                            gsapInstance.to(
                                cover,
                                {
                                    scale:1,
                                    duration:.55,
                                    ease:'power3.out',
                                    overwrite:'auto'
                                }
                            );

                        }
                    );

                }
            );
    };


    /* =========================================================
       BOOK EVENTS
    ========================================================= */

    const bindBookEvents = () => {

        document
            .querySelectorAll(
                '#bdPublisherGrid .bd-publisher-cover,#bdPublisherGrid .bd-publisher-card-link'
            )
            .forEach(
                element => {

                    element.addEventListener(
                        'click',
                        event => {

                            openDrawer(
                                element.dataset.id,
                                event.currentTarget
                            );

                        }
                    );

                }
            );


        bindBookTilt();
    };


    /* =========================================================
       DRAWER
    ========================================================= */

    const openDrawer = (
        id,
        trigger
    ) => {

        const book =
            BOOKS.find(
                item =>
                    String(item.id) ===
                    String(id)
            );


        if (!book) {
            return;
        }


        lastFocusedElement =
            trigger;


        const drawer =
            document.getElementById(
                'bdPublisherDrawer'
            );

        const overlay =
            document.getElementById(
                'bdPublisherOverlay'
            );

        const body =
            document.getElementById(
                'bdPublisherDrawerBody'
            );

        const color =
            getColor(
                book.category ||
                'Umum'
            );


        if (
            !drawer ||
            !overlay ||
            !body
        ) {
            return;
        }


        const cover =
            book.cover

                ? `
                    <img
                        src="${escapeHtml(book.cover)}"
                        alt="${escapeHtml(book.title)}"
                    >
                `

                : `
                    <div
                        class="bd-publisher-drawer-cover-fallback"
                        style="background:${color.hex}"
                    >
                        <span class="bd-publisher-drawer-cover-category">
                            ${escapeHtml(book.category || 'Umum')}
                        </span>

                        <span class="bd-publisher-drawer-cover-title">
                            ${escapeHtml(book.title)}
                        </span>
                    </div>
                `;


        body.innerHTML = `
            <div class="bd-publisher-drawer-book">

                <div
                    class="bd-publisher-drawer-cover-card"
                    style="--book-rgb:${color.rgb}"
                >

                    <div
                        class="bd-publisher-drawer-cover"
                        style="background:${color.hex}"
                    >
                        ${cover}
                    </div>

                </div>


                <div>

                    <div class="bd-publisher-drawer-status">
                        Sudah terbit
                    </div>

                    <h2 class="bd-publisher-drawer-title">
                        ${escapeHtml(book.title)}
                    </h2>

                    <p class="bd-publisher-drawer-author">
                        ${escapeHtml(book.author || '-')}
                    </p>

                </div>

            </div>


            <div class="bd-publisher-meta">

                <div class="bd-publisher-meta-item">
                    <span class="bd-publisher-meta-label">
                        ISBN
                    </span>

                    <span class="bd-publisher-meta-value">
                        ${escapeHtml(book.isbn || '-')}
                    </span>
                </div>


                <div class="bd-publisher-meta-item">
                    <span class="bd-publisher-meta-label">
                        Tahun Terbit
                    </span>

                    <span class="bd-publisher-meta-value">
                        ${escapeHtml(book.year || '-')}
                    </span>
                </div>


                <div class="bd-publisher-meta-item">
                    <span class="bd-publisher-meta-label">
                        Halaman
                    </span>

                    <span class="bd-publisher-meta-value">
                        ${
                            book.pages
                                ? escapeHtml(book.pages) +
                                  ' halaman'
                                : '-'
                        }
                    </span>
                </div>


                <div class="bd-publisher-meta-item">
                    <span class="bd-publisher-meta-label">
                        Jenis Buku
                    </span>

                    <span class="bd-publisher-meta-value">
                        ${escapeHtml(book.category || 'Umum')}
                    </span>
                </div>


                <div class="bd-publisher-meta-item">
                    <span class="bd-publisher-meta-label">
                        Penerbit
                    </span>

                    <span class="bd-publisher-meta-value">
                        ${escapeHtml(book.publisher || 'BacaDulu Publisher')}
                    </span>
                </div>

            </div>


            <div class="bd-publisher-synopsis-label">
                Sinopsis
            </div>


            <div class="bd-publisher-synopsis">
                ${
                    book.synopsis ||
                    '<p>Sinopsis belum tersedia.</p>'
                }
            </div>
        `;


        overlay.classList.add(
            'open'
        );

        drawer.classList.add(
            'open'
        );

        drawer.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow =
            'hidden';


        if (gsapInstance) {

            gsapInstance.fromTo(
                body.children,
                {
                    opacity:0,
                    y:22
                },
                {
                    opacity:1,
                    y:0,
                    duration:.45,
                    stagger:.07,
                    ease:'power3.out'
                }
            );

        }

    };


    const closeDrawer = () => {

        document
            .getElementById(
                'bdPublisherDrawer'
            )
            ?.classList
            .remove(
                'open'
            );


        document
            .getElementById(
                'bdPublisherOverlay'
            )
            ?.classList
            .remove(
                'open'
            );


        document
            .getElementById(
                'bdPublisherDrawer'
            )
            ?.setAttribute(
                'aria-hidden',
                'true'
            );


        document.body.style.overflow =
            '';


        lastFocusedElement?.focus();

    };


    /* =========================================================
       START GSAP
    ========================================================= */

    const startAnimations = () => {

        if (
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches
        ) {
            return;
        }


        let attempts =
            0;


        const timer =
            setInterval(
                () => {

                    const gsap =
                        resolveGsap();


                    if (gsap) {

                        clearInterval(
                            timer
                        );


                        gsapInstance =
                            gsap;


                        animateHero(
                            gsap
                        );


                        initSectionAnimations(
                            gsap
                        );


                        initProcessAnimations(
                            gsap
                        );


                        bindBookTilt();


                        console.log(
                            '[Baca Publisher] GSAP aktif.'
                        );


                        return;

                    }


                    attempts++;


                    if (
                        attempts >=
                        80
                    ) {

                        clearInterval(
                            timer
                        );


                        console.warn(
                            '[Baca Publisher] GSAP tidak ditemukan.'
                        );

                    }

                },
                50
            );

    };


    /* =========================================================
       EVENTS
    ========================================================= */

    document
        .getElementById(
            'bdPublisherSearch'
        )
        ?.addEventListener(
            'input',
            event => {

                searchTerm =
                    event.target.value;

                renderGrid();

            }
        );


    document
        .getElementById(
            'bdPublisherClose'
        )
        ?.addEventListener(
            'click',
            closeDrawer
        );


    document
        .getElementById(
            'bdPublisherOverlay'
        )
        ?.addEventListener(
            'click',
            closeDrawer
        );


    document.addEventListener(
        'keydown',
        event => {

            if (
                event.key ===
                'Escape'
            ) {

                closeDrawer();

            }

        }
    );


    /* =========================================================
       BOOT
    ========================================================= */

    const boot = () => {

        renderChips();
        renderGrid();
        startAnimations();

    };


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            boot,
            {
                once:true
            }
        );

    } else {

        boot();

    }

})();
</script>

@endsection