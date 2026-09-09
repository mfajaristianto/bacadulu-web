@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700;800&display=swap');

.bd-consultation{
    /*
    |--------------------------------------------------------------------------
    | BACA DULU
    |--------------------------------------------------------------------------
    */
    --navy:#241B52;
    --orange:#D96A2B;
    --orange-dark:#C94F35;
    --gold:#F0A52E;
    --yellow:#F2C94C;

    /*
    |--------------------------------------------------------------------------
    | FERMARTIAN
    |--------------------------------------------------------------------------
    */
    --ferm:#7D3930;
    --ferm-dark:#59261F;
    --ferm-accent:#C68B45;
    --ferm-soft:#FBF4ED;
    --ferm-line:#EAD8C9;

    /*
    |--------------------------------------------------------------------------
    | FDI
    |--------------------------------------------------------------------------
    */
    --fdi:#134074;
    --fdi-dark:#0B2545;
    --fdi-light:#5B9BD5;
    --fdi-soft:#EDF5FC;
    --fdi-line:#CFE0EF;

    /*
    |--------------------------------------------------------------------------
    | GENERAL
    |--------------------------------------------------------------------------
    */
    --warm:#FFFCF8;
    --cream:#FFF8F1;
    --text:#2F3640;
    --muted:#6E737A;
    --line:#E9E2DA;

    width:100%;
    min-height:100vh;
    overflow:hidden;
    background:#fff;
    color:var(--text);
    font-family:'Inter',sans-serif;
}

.bd-consultation *,
.bd-consultation *::before,
.bd-consultation *::after{
    box-sizing:border-box;
}

.bd-consultation-shell{
    width:min(calc(100% - 72px),1180px);
    margin:0 auto;
}

/* =========================================================
   SCROLL REVEAL
========================================================= */

.bd-consultation.bd-motion-ready [data-consult-reveal]{
    opacity:0;
    transform:translate3d(0,28px,0);
    transition:
        opacity .75s cubic-bezier(.22,.8,.25,1),
        transform .75s cubic-bezier(.22,.8,.25,1);
    will-change:opacity,transform;
}

.bd-consultation.bd-motion-ready [data-consult-reveal="left"]{
    transform:translate3d(-42px,0,0);
}

.bd-consultation.bd-motion-ready [data-consult-reveal="right"]{
    transform:translate3d(42px,0,0);
}

.bd-consultation.bd-motion-ready [data-consult-reveal="zoom"]{
    transform:scale(.96);
}

.bd-consultation.bd-motion-ready [data-consult-reveal].is-visible{
    opacity:1;
    transform:none;
}

.bd-consultation [data-consult-delay="1"]{
    transition-delay:.06s;
}

.bd-consultation [data-consult-delay="2"]{
    transition-delay:.12s;
}

.bd-consultation [data-consult-delay="3"]{
    transition-delay:.18s;
}

.bd-consultation [data-consult-delay="4"]{
    transition-delay:.24s;
}

/* =========================================================
   BRAND BAR
========================================================= */

.bd-consultation-brandbar{
    min-height:72px;
    display:flex;
    align-items:center;
    border-bottom:1px solid var(--line);
}

.bd-consultation-brand{
    display:inline-flex;
    align-items:center;
    gap:11px;
}

.bd-consultation-brand-mark{
    width:7px;
    height:27px;
    flex:0 0 7px;
    background:var(--orange);
}

.bd-consultation-brand-name{
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:21px;
    font-weight:600;
}

.bd-consultation-brand-type{
    color:#96929C;
    font-size:10px;
    font-weight:700;
    letter-spacing:.11em;
    text-transform:uppercase;
}

/* =========================================================
   HERO
========================================================= */

.bd-consultation-hero{
    position:relative;
    padding:76px 0 58px;
}

.bd-consultation-hero::before{
    content:"";
    position:absolute;
    top:-190px;
    right:-140px;
    width:460px;
    height:460px;
    border-radius:50%;
    pointer-events:none;
    background:
        radial-gradient(
            circle,
            rgba(217,106,43,.16),
            rgba(217,106,43,0) 70%
        );
}

.bd-consultation-hero::after{
    content:"";
    position:absolute;
    left:-180px;
    bottom:-250px;
    width:430px;
    height:430px;
    border-radius:50%;
    pointer-events:none;
    background:
        radial-gradient(
            circle,
            rgba(36,27,82,.07),
            rgba(36,27,82,0) 70%
        );
}

.bd-consultation-hero-inner{
    position:relative;
    z-index:2;
    max-width:830px;
    margin:0 auto;
    text-align:center;
}

.bd-consultation-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:7px 13px;
    border:1px solid rgba(217,106,43,.18);
    border-radius:999px;
    background:var(--cream);
    color:var(--orange-dark);
    font-size:10px;
    font-weight:800;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-consultation-eyebrow-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:var(--orange);
}

.bd-consultation-title{
    max-width:810px;
    margin:20px auto 0;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:clamp(39px,5vw,62px);
    line-height:1.04;
    font-weight:600;
    letter-spacing:-.04em;
}

.bd-consultation-title span{
    color:var(--orange);
}

.bd-consultation-lead{
    max-width:700px;
    margin:22px auto 0;
    color:var(--muted);
    font-size:14px;
    line-height:1.8;
}

/* =========================================================
   RUANG LINGKUP
========================================================= */

.bd-consultation-focus{
    position:relative;
    z-index:2;
    padding:6px 0 72px;
}

.bd-focus-heading{
    max-width:650px;
    margin:0 auto 27px;
    text-align:center;
}

.bd-focus-heading span{
    display:block;
    margin-bottom:8px;
    color:var(--orange);
    font-size:9px;
    font-weight:800;
    letter-spacing:.12em;
    text-transform:uppercase;
}

.bd-focus-heading h2{
    margin:0;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:29px;
    line-height:1.15;
    font-weight:600;
    letter-spacing:-.025em;
}

.bd-focus-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
}

.bd-focus-card{
    min-width:0;
    min-height:146px;
    padding:21px;
    border:1px solid var(--line);
    border-radius:17px;
    background:#fff;
    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.bd-focus-icon{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:16px;
    border-radius:10px;
    background:var(--cream);
    color:var(--orange);
}

.bd-focus-icon svg{
    width:17px;
    height:17px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.7;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-focus-card h3{
    margin:0;
    color:var(--navy);
    font-size:12px;
    line-height:1.4;
    font-weight:800;
}

.bd-focus-card p{
    margin:7px 0 0;
    color:var(--muted);
    font-size:10px;
    line-height:1.65;
}

/* =========================================================
   PARTNER SECTION
========================================================= */

.bd-partners-section{
    position:relative;
    padding:74px 0;
    background:
        linear-gradient(
            180deg,
            #FFFCF8 0%,
            #FBF8F4 100%
        );
    border-top:1px solid var(--line);
    border-bottom:1px solid var(--line);
}

.bd-section-heading{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:35px;
    margin-bottom:38px;
}

.bd-section-heading-left{
    max-width:600px;
}

.bd-section-kicker{
    display:block;
    margin-bottom:8px;
    color:var(--orange);
    font-size:9px;
    font-weight:800;
    letter-spacing:.12em;
    text-transform:uppercase;
}

.bd-section-heading h2{
    margin:0;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:35px;
    line-height:1.1;
    font-weight:600;
    letter-spacing:-.03em;
}

.bd-section-heading > p{
    max-width:380px;
    margin:0;
    color:var(--muted);
    font-size:11px;
    line-height:1.75;
}

/* =========================================================
   PARTNER GRID
========================================================= */

.bd-partner-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:26px;
}

/* =========================================================
   BASE PARTNER CARD
========================================================= */

.bd-partner-card{
    position:relative;
    min-width:0;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    border-radius:22px;
    background:#fff;
    transition:
        transform .35s cubic-bezier(.22,.8,.25,1),
        box-shadow .35s ease;
}

/* =========================================================
   FERMARTIAN
========================================================= */

.bd-partner-card--fermartian{
    border:1px solid var(--ferm-line);
    border-top:4px solid var(--ferm);
    box-shadow:
        0 14px 38px rgba(89,38,31,.07);
}

.bd-partner-card--fermartian .bd-partner-top{
    background:
        radial-gradient(
            circle at 18% 10%,
            rgba(198,139,69,.14),
            transparent 45%
        ),
        linear-gradient(
            145deg,
            #FFFDFC,
            var(--ferm-soft)
        );
}

.bd-partner-card--fermartian .bd-partner-status{
    color:var(--ferm);
    border-color:rgba(125,57,48,.18);
    background:#FFFDFC;
}

.bd-partner-card--fermartian .bd-partner-category{
    color:var(--ferm);
}

.bd-partner-card--fermartian .bd-partner-divider{
    background:var(--ferm-line);
}

.bd-partner-card--fermartian .bd-partner-tag{
    background:var(--ferm-soft);
    color:var(--ferm);
    border:1px solid rgba(125,57,48,.08);
}

.bd-partner-card--fermartian .bd-partner-info{
    background:#FCF8F4;
    color:#7F625B;
}

.bd-partner-card--fermartian .bd-partner-btn{
    background:
        linear-gradient(
            135deg,
            var(--ferm-dark),
            var(--ferm) 67%,
            #985044
        );
    box-shadow:
        0 10px 25px rgba(89,38,31,.17);
}

/* =========================================================
   FDI
========================================================= */

.bd-partner-card--fdi{
    border:1px solid var(--fdi-line);
    border-top:4px solid var(--fdi);
    box-shadow:
        0 14px 38px rgba(11,37,69,.075);
}

.bd-partner-card--fdi .bd-partner-top{
    background:
        radial-gradient(
            circle at 82% 10%,
            rgba(91,155,213,.18),
            transparent 45%
        ),
        linear-gradient(
            145deg,
            #fff,
            #F1F7FC
        );
}

.bd-partner-card--fdi .bd-partner-status{
    color:var(--fdi);
    border-color:rgba(19,64,116,.17);
    background:#fff;
}

.bd-partner-card--fdi .bd-partner-category{
    color:var(--fdi);
}

.bd-partner-card--fdi .bd-partner-divider{
    background:var(--fdi-line);
}

.bd-partner-card--fdi .bd-partner-tag{
    background:var(--fdi-soft);
    color:var(--fdi);
    border:1px solid rgba(19,64,116,.07);
}

.bd-partner-card--fdi .bd-partner-info{
    background:#F3F8FC;
    color:#5D7184;
}

.bd-partner-card--fdi .bd-partner-btn{
    background:
        linear-gradient(
            135deg,
            var(--fdi-dark),
            var(--fdi)
        );
    box-shadow:
        0 10px 25px rgba(11,37,69,.18);
}

/* =========================================================
   PARTNER CONTENT
========================================================= */

.bd-partner-top{
    position:relative;
    height:225px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:38px;
    border-bottom:1px solid rgba(0,0,0,.055);
}

.bd-partner-status{
    position:absolute;
    top:17px;
    right:17px;
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 10px;
    border:1px solid;
    border-radius:999px;
    font-size:8px;
    line-height:1;
    font-weight:800;
    letter-spacing:.06em;
    text-transform:uppercase;
}

.bd-partner-status::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
    animation:bdPartnerPulse 2.1s ease-in-out infinite;
}

@keyframes bdPartnerPulse{
    0%,100%{
        transform:scale(1);
        opacity:1;
    }

    50%{
        transform:scale(.72);
        opacity:.45;
    }
}

.bd-partner-logo{
    display:block;
    width:auto;
    max-width:78%;
    max-height:124px;
    object-fit:contain;
    transform:translateZ(0);
    transition:
        transform .38s cubic-bezier(.22,.8,.25,1);
}

.bd-partner-body{
    flex:1;
    display:flex;
    flex-direction:column;
    padding:29px;
}

.bd-partner-category{
    font-size:9px;
    line-height:1.2;
    font-weight:800;
    letter-spacing:.11em;
    text-transform:uppercase;
}

.bd-partner-name{
    margin:8px 0 0;
    color:var(--navy);
    font-size:21px;
    line-height:1.25;
    font-weight:800;
    letter-spacing:-.025em;
}

.bd-partner-description{
    margin:12px 0 0;
    color:var(--muted);
    font-size:11px;
    line-height:1.75;
}

.bd-partner-divider{
    height:1px;
    margin:22px 0 19px;
}

.bd-partner-focus-title{
    margin:0;
    color:var(--navy);
    font-size:9px;
    line-height:1;
    font-weight:800;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-partner-tags{
    display:flex;
    flex-wrap:wrap;
    gap:7px;
    margin-top:11px;
}

.bd-partner-tag{
    display:inline-flex;
    align-items:center;
    min-height:29px;
    padding:5px 9px;
    border-radius:8px;
    font-size:9px;
    line-height:1.25;
    font-weight:700;
}

.bd-partner-info{
    display:flex;
    align-items:flex-start;
    gap:9px;
    margin-top:20px;
    padding:12px;
    border-radius:11px;
    font-size:9px;
    line-height:1.6;
}

.bd-partner-info svg{
    width:14px;
    height:14px;
    flex:0 0 14px;
    margin-top:1px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-partner-action{
    margin-top:auto;
    padding-top:23px;
}

.bd-partner-btn{
    width:100%;
    min-height:46px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    padding:10px 17px;
    border-radius:12px;
    color:#fff!important;
    font-size:10px;
    font-weight:800;
    text-decoration:none!important;
    transition:
        transform .22s ease,
        box-shadow .22s ease,
        filter .22s ease;
}

.bd-partner-btn svg{
    width:16px;
    height:16px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

/* =========================================================
   PROCESS
========================================================= */

.bd-process{
    padding:76px 0;
    background:#fff;
}

.bd-process-heading{
    max-width:620px;
    margin:0 auto 40px;
    text-align:center;
}

.bd-process-heading h2{
    margin:0;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:34px;
    line-height:1.15;
    font-weight:600;
    letter-spacing:-.03em;
}

.bd-process-heading p{
    margin:12px 0 0;
    color:var(--muted);
    font-size:11px;
    line-height:1.75;
}

.bd-process-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    max-width:920px;
    margin:0 auto;
    gap:18px;
}

.bd-process-card{
    position:relative;
    min-width:0;
    padding:25px;
    overflow:hidden;
    border:1px solid var(--line);
    border-radius:17px;
    background:#fff;
    transition:
        transform .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}

.bd-process-card::after{
    content:"";
    position:absolute;
    right:-30px;
    bottom:-40px;
    width:90px;
    height:90px;
    border-radius:50%;
    background:rgba(217,106,43,.045);
}

.bd-process-index{
    display:block;
    color:var(--orange);
    font-family:'Fraunces',serif;
    font-size:25px;
    line-height:1;
    font-weight:600;
}

.bd-process-card h3{
    margin:14px 0 0;
    color:var(--navy);
    font-size:12px;
    line-height:1.4;
    font-weight:800;
}

.bd-process-card p{
    position:relative;
    z-index:2;
    margin:7px 0 0;
    color:var(--muted);
    font-size:10px;
    line-height:1.65;
}

/* =========================================================
   CTA
========================================================= */

.bd-consultation-cta{
    padding:0 0 80px;
}

.bd-cta-box{
    position:relative;
    overflow:hidden;
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    align-items:center;
    gap:35px;
    padding:37px 40px;
    border-radius:22px;
    background:
        linear-gradient(
            135deg,
            #21194D,
            var(--navy)
        );
    color:#fff;
}

.bd-cta-box::before{
    content:"";
    position:absolute;
    width:260px;
    height:260px;
    right:-80px;
    top:-115px;
    border-radius:50%;
    background:rgba(240,165,46,.16);
}

.bd-cta-box::after{
    content:"";
    position:absolute;
    width:170px;
    height:170px;
    right:100px;
    bottom:-130px;
    border-radius:50%;
    border:1px solid rgba(255,255,255,.07);
}

.bd-cta-content{
    position:relative;
    z-index:2;
}

.bd-cta-content span{
    display:block;
    color:var(--yellow);
    font-size:9px;
    font-weight:800;
    letter-spacing:.12em;
    text-transform:uppercase;
}

.bd-cta-content h2{
    max-width:570px;
    margin:8px 0 0;
    font-family:'Fraunces',serif;
    font-size:28px;
    line-height:1.15;
    font-weight:500;
}

.bd-cta-content p{
    max-width:600px;
    margin:10px 0 0;
    color:rgba(255,255,255,.67);
    font-size:10px;
    line-height:1.7;
}

.bd-cta-btn{
    position:relative;
    z-index:2;
    min-height:44px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:11px 18px;
    border-radius:11px;
    background:var(--yellow);
    color:#292042!important;
    font-size:10px;
    line-height:1;
    font-weight:800;
    white-space:nowrap;
    text-decoration:none!important;
    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.bd-cta-btn svg{
    width:15px;
    height:15px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

/* =========================================================
   HOVER DESKTOP
========================================================= */

@media(hover:hover) and (pointer:fine){

    .bd-focus-card:hover{
        transform:translateY(-4px);
        border-color:rgba(217,106,43,.3);
        box-shadow:0 18px 45px rgba(36,27,82,.08);
    }

    .bd-partner-card--fermartian:hover{
        transform:translateY(-7px);
        box-shadow:
            0 28px 60px rgba(89,38,31,.14);
    }

    .bd-partner-card--fdi:hover{
        transform:translateY(-7px);
        box-shadow:
            0 28px 60px rgba(11,37,69,.15);
    }

    .bd-partner-card:hover .bd-partner-logo{
        transform:scale(1.045);
    }

    .bd-partner-btn:hover{
        transform:translateY(-2px);
        filter:brightness(1.06);
    }

    .bd-process-card:hover{
        transform:translateY(-4px);
        border-color:rgba(217,106,43,.24);
        box-shadow:0 15px 34px rgba(36,27,82,.07);
    }

    .bd-cta-btn:hover{
        transform:translateY(-2px);
        box-shadow:0 12px 28px rgba(0,0,0,.2);
    }
}

/* =========================================================
   TABLET
========================================================= */

@media(max-width:950px){

    .bd-focus-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .bd-section-heading{
        flex-direction:column;
        align-items:flex-start;
    }

    .bd-section-heading > p{
        max-width:620px;
    }

}

@media(max-width:800px){

    .bd-consultation-shell{
        width:calc(100% - 40px);
    }

    .bd-partner-grid{
        grid-template-columns:1fr;
        max-width:620px;
        margin:0 auto;
    }

    .bd-process-grid{
        grid-template-columns:1fr;
        max-width:620px;
    }

    .bd-cta-box{
        grid-template-columns:1fr;
    }

    .bd-cta-btn{
        justify-self:start;
    }

}

/* =========================================================
   PHONE
========================================================= */

@media(max-width:600px){

    .bd-consultation-shell{
        width:calc(100% - 30px);
    }

    .bd-consultation-brandbar{
        min-height:64px;
    }

    .bd-consultation-brand{
        gap:8px;
    }

    .bd-consultation-brand-mark{
        height:24px;
    }

    .bd-consultation-brand-name{
        font-size:19px;
    }

    .bd-consultation-brand-type{
        display:inline-block;
        font-size:8px;
    }

    .bd-consultation-hero{
        padding:54px 0 43px;
    }

    .bd-consultation-eyebrow{
        padding:6px 11px;
        font-size:8px;
    }

    .bd-consultation-title{
        font-size:39px;
    }

    .bd-consultation-lead{
        margin-top:18px;
        font-size:12px;
        line-height:1.75;
    }

    .bd-consultation-focus{
        padding-bottom:55px;
    }

    .bd-focus-heading h2{
        font-size:27px;
    }

    .bd-focus-grid{
        grid-template-columns:1fr;
    }

    .bd-focus-card{
        min-height:auto;
    }

    .bd-partners-section,
    .bd-process{
        padding:58px 0;
    }

    .bd-section-heading{
        margin-bottom:28px;
    }

    .bd-section-heading h2,
    .bd-process-heading h2{
        font-size:29px;
    }

    .bd-partner-top{
        height:194px;
        padding:28px;
    }

    .bd-partner-logo{
        max-width:80%;
        max-height:104px;
    }

    .bd-partner-status{
        top:13px;
        right:13px;
        font-size:7px;
    }

    .bd-partner-body{
        padding:22px;
    }

    .bd-partner-name{
        font-size:19px;
    }

    .bd-partner-description{
        font-size:10.5px;
    }

    .bd-process{
        padding-bottom:60px;
    }

    .bd-consultation-cta{
        padding-bottom:60px;
    }

    .bd-cta-box{
        padding:28px 22px;
        border-radius:18px;
    }

    .bd-cta-content h2{
        font-size:25px;
    }

    .bd-cta-btn{
        width:100%;
    }

}

/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){

    .bd-consultation *,
    .bd-consultation *::before,
    .bd-consultation *::after{
        scroll-behavior:auto!important;
        animation-duration:.01ms!important;
        animation-iteration-count:1!important;
        transition-duration:.01ms!important;
    }

    .bd-consultation.bd-motion-ready [data-consult-reveal]{
        opacity:1!important;
        transform:none!important;
    }

}
</style>


<section
    class="bd-consultation"
    id="bdConsultation"
>

    {{-- =====================================================
         BRAND
    ====================================================== --}}

    <div class="bd-consultation-shell">

        <div class="bd-consultation-brandbar">

            <div class="bd-consultation-brand">

                <span class="bd-consultation-brand-mark"></span>

                <span class="bd-consultation-brand-name">
                    BacaDulu
                </span>

                <span class="bd-consultation-brand-type">
                    Consultation
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="bd-consultation-hero">

        <div class="bd-consultation-shell">

            <div
                class="bd-consultation-hero-inner"
                data-consult-reveal="zoom"
            >

                <span class="bd-consultation-eyebrow">

                    <span class="bd-consultation-eyebrow-dot"></span>

                    Mitra Kerja Sama Profesional

                </span>


                <h1 class="bd-consultation-title">

                    Temukan Mitra Konsultasi

                    <span>
                        yang Tepat.
                    </span>

                </h1>


                <p class="bd-consultation-lead">

                    Baca Konsultasi menghadirkan mitra kerja sama profesional
                    untuk membantu kebutuhan konsultasi bisnis, properti,
                    penilaian, studi kelayakan, dan layanan advisory sesuai
                    bidang keahlian masing-masing mitra.

                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FOCUS
    ====================================================== --}}

    <section class="bd-consultation-focus">

        <div class="bd-consultation-shell">

            <div
                class="bd-focus-heading"
                data-consult-reveal
            >

                <span>
                    Ruang Lingkup
                </span>

                <h2>
                    Konsultasi profesional sesuai kebutuhan Anda.
                </h2>

            </div>


            <div class="bd-focus-grid">

                {{-- BUSINESS --}}
                <article
                    class="bd-focus-card"
                    data-consult-reveal
                    data-consult-delay="1"
                >

                    <div class="bd-focus-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M4 20V10"/>
                            <path d="M10 20V4"/>
                            <path d="M16 20v-7"/>
                            <path d="M22 20H2"/>
                        </svg>

                    </div>

                    <h3>
                        Business Advisory
                    </h3>

                    <p>
                        Konsultasi strategis untuk mendukung analisis,
                        pengembangan, dan kebutuhan bisnis.
                    </p>

                </article>


                {{-- PROPERTY --}}
                <article
                    class="bd-focus-card"
                    data-consult-reveal
                    data-consult-delay="2"
                >

                    <div class="bd-focus-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="m3 11 9-8 9 8"/>
                            <path d="M5 10v10h14V10"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>

                    </div>

                    <h3>
                        Properti &amp; Aset
                    </h3>

                    <p>
                        Pendampingan terkait properti, aset,
                        pengembangan lahan dan kebutuhan profesional terkait.
                    </p>

                </article>


                {{-- VALUATION --}}
                <article
                    class="bd-focus-card"
                    data-consult-reveal
                    data-consult-delay="3"
                >

                    <div class="bd-focus-icon">

                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v10"/>
                            <path d="M15 9.5c-.7-1-1.8-1.5-3-1.5-1.7 0-3 1-3 2.3 0 3.5 6 1.4 6 4.4 0 1.3-1.3 2.3-3 2.3-1.2 0-2.4-.5-3-1.5"/>
                        </svg>

                    </div>

                    <h3>
                        Penilaian &amp; Valuasi
                    </h3>

                    <p>
                        Layanan profesional untuk kebutuhan penilaian
                        bisnis, aset, properti dan kepentingan terkait.
                    </p>

                </article>


                {{-- FEASIBILITY --}}
                <article
                    class="bd-focus-card"
                    data-consult-reveal
                    data-consult-delay="4"
                >

                    <div class="bd-focus-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M5 3h14v18H5z"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h5"/>
                            <path d="m9 16 2 2 4-4"/>
                        </svg>

                    </div>

                    <h3>
                        Studi Kelayakan
                    </h3>

                    <p>
                        Analisis dan pendampingan untuk membantu memahami
                        kelayakan rencana usaha maupun proyek.
                    </p>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MITRA
    ====================================================== --}}

    <section class="bd-partners-section">

        <div class="bd-consultation-shell">

            <div
                class="bd-section-heading"
                data-consult-reveal
            >

                <div class="bd-section-heading-left">

                    <span class="bd-section-kicker">
                        Mitra Kerja Sama
                    </span>

                    <h2>
                        Pilih mitra sesuai kebutuhan konsultasi Anda.
                    </h2>

                </div>


                <p>
                    Setiap mitra memiliki fokus dan ruang lingkup layanan
                    yang berbeda. Kenali bidang keahliannya sebelum
                    memulai konsultasi.
                </p>

            </div>


            <div class="bd-partner-grid">

                {{-- =================================================
                     FERMARTIAN
                ================================================== --}}

                <article
                    class="bd-partner-card bd-partner-card--fermartian"
                    data-consult-reveal="left"
                >

                    <div class="bd-partner-top">

                        <span class="bd-partner-status">
                            Consultation Partner
                        </span>


                        <img
                            src="{{ asset('img/Fermartian.jpg') }}"
                            alt="PT Fermartian Investama Korpora"
                            class="bd-partner-logo"
                            loading="lazy"
                        >

                    </div>


                    <div class="bd-partner-body">

                        <span class="bd-partner-category">
                            Business &amp; Property Advisory
                        </span>


                        <h3 class="bd-partner-name">
                            PT Fermartian Investama Korpora
                        </h3>


                        <p class="bd-partner-description">
                            Mitra konsultasi profesional untuk kebutuhan
                            advisory bisnis, pengembangan properti, studi
                            kelayakan, serta pengembangan kapasitas dan
                            kebutuhan profesional lainnya sesuai ruang lingkup
                            layanan perusahaan.
                        </p>


                        <div class="bd-partner-divider"></div>


                        <p class="bd-partner-focus-title">
                            Fokus Konsultasi
                        </p>


                        <div class="bd-partner-tags">

                            <span class="bd-partner-tag">
                                Business Advisory
                            </span>

                            <span class="bd-partner-tag">
                                Property Development
                            </span>

                            <span class="bd-partner-tag">
                                Studi Kelayakan
                            </span>

                            <span class="bd-partner-tag">
                                Professional Training
                            </span>

                        </div>


                        <div class="bd-partner-info">

                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 11v5"/>
                                <path d="M12 8h.01"/>
                            </svg>

                            <span>
                                Jelaskan kebutuhan konsultasi Anda melalui
                                WhatsApp agar dapat diarahkan ke layanan
                                yang sesuai.
                            </span>

                        </div>


                        <div class="bd-partner-action">

                            <a
                                href="https://wa.me/6285159104469?text=Halo,%20saya%20mendapatkan%20informasi%20PT%20Fermartian%20Investama%20Korpora%20melalui%20BacaDulu.%20Saya%20ingin%20berkonsultasi%20mengenai%20layanan%20yang%20tersedia."
                                target="_blank"
                                rel="noopener noreferrer"
                                class="bd-partner-btn"
                            >

                                Konsultasi via WhatsApp

                                <svg viewBox="0 0 24 24">
                                    <path d="M5 12h14"/>
                                    <path d="m14 7 5 5-5 5"/>
                                </svg>

                            </a>

                        </div>

                    </div>

                </article>


                {{-- =================================================
                     FDI PARTNERS
                ================================================== --}}

                <article
                    class="bd-partner-card bd-partner-card--fdi"
                    data-consult-reveal="right"
                    data-consult-delay="1"
                >

                    <div class="bd-partner-top">

                        <span class="bd-partner-status">
                            Professional Appraiser
                        </span>


                        <img
                            src="{{ asset('img/Fdi.jpg') }}"
                            alt="FDI Partners"
                            class="bd-partner-logo"
                            loading="lazy"
                        >

                    </div>


                    <div class="bd-partner-body">

                        <span class="bd-partner-category">
                            Business &amp; Property Valuation
                        </span>


                        <h3 class="bd-partner-name">
                            FDI Partners
                        </h3>


                        <p class="bd-partner-description">
                            KJPP Ferdinand, Danar, Ichsan dan Rekan merupakan
                            kantor jasa penilai publik yang memberikan layanan
                            profesional dalam bidang penilaian bisnis,
                            properti, aset, dan kebutuhan penilaian lainnya.
                        </p>


                        <div class="bd-partner-divider"></div>


                        <p class="bd-partner-focus-title">
                            Fokus Layanan
                        </p>


                        <div class="bd-partner-tags">

                            <span class="bd-partner-tag">
                                Business Valuation
                            </span>

                            <span class="bd-partner-tag">
                                Property Valuation
                            </span>

                            <span class="bd-partner-tag">
                                Penilaian Saham
                            </span>

                            <span class="bd-partner-tag">
                                Intangible Assets
                            </span>

                            <span class="bd-partner-tag">
                                Feasibility Study
                            </span>

                            <span class="bd-partner-tag">
                                Highest &amp; Best Use
                            </span>

                        </div>


                        <div class="bd-partner-info">

                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 11v5"/>
                                <path d="M12 8h.01"/>
                            </svg>

                            <span>
                                Ruang lingkup, metode, dan pelaksanaan layanan
                                mengikuti kebutuhan penilaian serta ketentuan
                                profesional FDI Partners.
                            </span>

                        </div>


                        <div class="bd-partner-action">

                            <a
                                href="https://www.fdipartners.co.id/"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="bd-partner-btn"
                            >

                                Kunjungi FDI Partners

                                <svg viewBox="0 0 24 24">
                                    <path d="M5 12h14"/>
                                    <path d="m14 7 5 5-5 5"/>
                                </svg>

                            </a>

                        </div>

                    </div>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CARA KONSULTASI
    ====================================================== --}}

    <section class="bd-process">

        <div class="bd-consultation-shell">

            <div
                class="bd-process-heading"
                data-consult-reveal
            >

                <span class="bd-section-kicker">
                    Cara Konsultasi
                </span>

                <h2>
                    Mulai dari kebutuhan Anda.
                </h2>

                <p>
                    Pilih mitra berdasarkan bidang konsultasi yang
                    paling sesuai kemudian lanjutkan komunikasi
                    melalui kanal resmi masing-masing mitra.
                </p>

            </div>


            <div class="bd-process-grid">

                <article
                    class="bd-process-card"
                    data-consult-reveal
                    data-consult-delay="1"
                >

                    <span class="bd-process-index">
                        01
                    </span>

                    <h3>
                        Tentukan Kebutuhan
                    </h3>

                    <p>
                        Tentukan kebutuhan bisnis, properti,
                        penilaian atau studi kelayakan yang
                        ingin dikonsultasikan.
                    </p>

                </article>


                <article
                    class="bd-process-card"
                    data-consult-reveal
                    data-consult-delay="2"
                >

                    <span class="bd-process-index">
                        02
                    </span>

                    <h3>
                        Pilih Mitra
                    </h3>

                    <p>
                        Pelajari fokus layanan PT Fermartian
                        Investama Korpora atau FDI Partners
                        sesuai kebutuhan Anda.
                    </p>

                </article>


                <article
                    class="bd-process-card"
                    data-consult-reveal
                    data-consult-delay="3"
                >

                    <span class="bd-process-index">
                        03
                    </span>

                    <h3>
                        Hubungi Mitra
                    </h3>

                    <p>
                        Gunakan kanal resmi yang tersedia untuk
                        mendiskusikan kebutuhan, ruang lingkup,
                        jadwal, dan tindak lanjut layanan.
                    </p>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CTA
    ====================================================== --}}

    <section class="bd-consultation-cta">

        <div class="bd-consultation-shell">

            <div
                class="bd-cta-box"
                data-consult-reveal="zoom"
            >

                <div class="bd-cta-content">

                    <span>
                        BacaDulu Consultation
                    </span>

                    <h2>
                        Belum yakin mitra mana yang sesuai dengan kebutuhan Anda?
                    </h2>

                    <p>
                        Hubungi Baca Dulu terlebih dahulu.
                        Kami akan membantu mengarahkan kebutuhan Anda
                        ke mitra kerja sama yang relevan.
                    </p>

                </div>


                <a
                    href="{{ config('bacadulu.call_center') }}?text=Halo%20BacaDulu,%20saya%20ingin%20menanyakan%20layanan%20Baca%20Konsultasi%20dan%20mitra%20yang%20sesuai%20dengan%20kebutuhan%20saya."
                    target="_blank"
                    rel="noopener noreferrer"
                    class="bd-cta-btn"
                >

                    Hubungi Baca Dulu

                    <svg viewBox="0 0 24 24">
                        <path d="M5 12h14"/>
                        <path d="m14 7 5 5-5 5"/>
                    </svg>

                </a>

            </div>

        </div>

    </section>

</section>


<script>
(function () {

    function initBacaConsultationMotion() {

        const section =
            document.getElementById(
                'bdConsultation'
            );

        if (
            !section ||
            section.dataset.motionReady === '1'
        ) {
            return;
        }

        section.dataset.motionReady = '1';

        const items =
            Array.from(
                section.querySelectorAll(
                    '[data-consult-reveal]'
                )
            );

        if (!items.length) {
            return;
        }

        const reduceMotion =
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

        if (
            reduceMotion ||
            !('IntersectionObserver' in window)
        ) {
            items.forEach(function (item) {
                item.classList.add(
                    'is-visible'
                );
            });

            return;
        }

        section.classList.add(
            'bd-motion-ready'
        );

        const observer =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(
                        function (entry) {

                            if (!entry.isIntersecting) {
                                return;
                            }

                            entry.target.classList.add(
                                'is-visible'
                            );

                            observer.unobserve(
                                entry.target
                            );
                        }
                    );

                },
                {
                    threshold:0.12,
                    rootMargin:
                        '0px 0px -7% 0px'
                }
            );

        items.forEach(
            function (item) {
                observer.observe(item);
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | NORMAL LOAD
    |--------------------------------------------------------------------------
    */

    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initBacaConsultationMotion,
            {
                once:true
            }
        );

    } else {

        initBacaConsultationMotion();

    }


    /*
    |--------------------------------------------------------------------------
    | BACK / FORWARD CACHE
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'pageshow',
        initBacaConsultationMotion
    );


    /*
    |--------------------------------------------------------------------------
    | BARBA SUPPORT
    |--------------------------------------------------------------------------
    */

    if (
        window.barba &&
        window.barba.hooks &&
        typeof window.barba.hooks.after ===
            'function'
    ) {

        window.barba.hooks.after(
            function () {

                requestAnimationFrame(
                    initBacaConsultationMotion
                );

            }
        );

    }

})();
</script>

@endsection