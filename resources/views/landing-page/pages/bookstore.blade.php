@extends('layouts.app')

@section('title', 'Bookstore - Baca Dulu')
@section('barba-namespace', 'bookstore')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | IKAPI
    |--------------------------------------------------------------------------
    | Isi nomor anggota di sini setelah nomor resmi diterima.
    | Contoh:
    | $ikapiMemberNumber = '12345/IKAPI/2026';
    */
    $ikapiMemberNumber = null;

    /*
    |--------------------------------------------------------------------------
    | Dokumen IKAPI
    |--------------------------------------------------------------------------
    | Dokumen pertama menggunakan:
    | public/img/serti_ikapi.jpeg
    |
    | Slot dokumen kedua sudah disiapkan:
    | public/img/serti_ikapi_2.jpeg
    |
    | Dokumen hanya akan tampil jika filenya benar-benar ada.
    */
    $ikapiDocuments = collect([
        [
            'title' => 'Sertifikat IKAPI',
            'description' => 'Sertifikat keanggotaan Baca Dulu Publisher pada Ikatan Penerbit Indonesia.',
            'image' => 'img/serti_ikapi.jpeg',
        ],
        [
            'title' => 'Dokumen IKAPI',
            'description' => 'Dokumen pendukung keanggotaan Baca Dulu Publisher.',
            'image' => 'img/serti_ikapi_2.jpeg',
        ],
    ])->filter(
        fn ($document) => file_exists(public_path($document['image']))
    )->values();
@endphp

<style>

/* =========================================================
   EMPTY CART
========================================================= */

.cart-empty{
    min-height:300px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:32px 24px;
    color:#64748b;
}

.cart-empty-icon{
    width:64px;
    height:64px;
    border-radius:18px;
    background:#fff7ed;
    border:1px solid #fed7aa;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:18px;
    color:#f97316;
}

.cart-empty-icon svg{
    width:28px;
    height:28px;
    display:block;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.cart-empty strong{
    display:block;
    font-size:15px;
    font-weight:700;
    color:#1e293b;
    margin-bottom:6px;
}

.cart-empty span{
    display:block;
    max-width:260px;
    font-size:13px;
    line-height:1.6;
    color:#94a3b8;
}


/* =========================================================
   CART PRODUCT ITEM
========================================================= */

.cart-product{
    display:grid;
    grid-template-columns:90px minmax(0,1fr);
    gap:16px;
    padding:18px 0;
    border-bottom:1px solid #e2e8f0;
}

.cart-product-cover{
    width:90px;
    height:125px;
    border-radius:10px;
    overflow:hidden;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    position:relative;
}

.cart-product-cover img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.cart-cover-placeholder{
    position:absolute;
    inset:0;
    display:none;
    align-items:center;
    justify-content:center;
    background:#fff7ed;
    color:#f97316;
}

.cart-cover-placeholder.show{
    display:flex;
}

.cart-cover-placeholder svg{
    width:30px;
    height:30px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.cart-product-info{
    min-width:0;
}

.cart-product-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:8px;
}

.cart-format{
    display:inline-flex;
    align-items:center;
    padding:4px 9px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

.cart-format.print{
    background:#fff7ed;
    color:#ea580c;
}

.cart-format.ebook{
    background:#eef2ff;
    color:#4f46e5;
}

.cart-remove{
    border:0;
    background:transparent;
    color:#94a3b8;
    cursor:pointer;
    font-size:16px;
    padding:2px 5px;
}

.cart-remove:hover{
    color:#ef4444;
}

.cart-product-title{
    margin:0;
    font-size:15px;
    line-height:1.4;
    font-weight:700;
    color:#1e293b;
}

.cart-product-meta{
    margin:5px 0 0;
    font-size:12px;
    line-height:1.5;
    color:#94a3b8;
}

.cart-unit-price{
    margin-top:10px;
    font-size:13px;
    font-weight:600;
    color:#475569;
}

.cart-book-actions{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:8px;
    margin-top:11px;
}

.cart-synopsis-toggle,
.cart-detail-link{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    min-height:31px;
    padding:6px 9px;
    border-radius:8px;
    font-size:10.5px;
    font-weight:750;
    line-height:1;
    text-decoration:none;
    cursor:pointer;
    transition:.18s ease;
}

.cart-synopsis-toggle{
    border:1px solid #fed7aa;
    color:#c2410c;
    background:#fff7ed;
}

.cart-synopsis-toggle:hover{
    border-color:#fb923c;
    background:#ffedd5;
}

.cart-detail-link{
    border:1px solid #e2e8f0;
    color:#475569!important;
    background:#fff;
}

.cart-detail-link:hover{
    border-color:#cbd5e1;
    background:#f8fafc;
    color:#1e293b!important;
}

.cart-synopsis{
    display:none;
    margin-top:10px;
    padding:11px 12px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    background:#fff;
    color:#64748b;
    font-size:11px;
    line-height:1.65;
}

.cart-synopsis.show{
    display:block;
}

.cart-synopsis strong{
    display:block;
    margin-bottom:5px;
    color:#334155;
    font-size:10.5px;
}

.cart-synopsis-empty{
    font-style:italic;
    color:#94a3b8;
}

.cart-product-bottom{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:12px;
    margin-top:14px;
}

.qty-control{
    display:inline-flex;
    align-items:center;
    border:1px solid #e2e8f0;
    border-radius:9px;
    overflow:hidden;
    background:#fff;
}

.qty-control button{
    width:32px;
    height:32px;
    border:0;
    background:#fff;
    color:#334155;
    cursor:pointer;
    font-size:16px;
}

.qty-control button:hover{
    background:#fff7ed;
    color:#ea580c;
}

.qty-control span{
    min-width:30px;
    text-align:center;
    font-size:13px;
    font-weight:700;
    color:#1e293b;
}

.cart-subtotal-label{
    font-size:10px;
    color:#94a3b8;
    text-align:right;
}

.cart-subtotal{
    margin-top:2px;
    font-size:14px;
    font-weight:800;
    color:#1e293b;
    text-align:right;
}

@media (max-width:640px){
    .cart-product{
        grid-template-columns:72px minmax(0,1fr);
        gap:12px;
    }

    .cart-product-cover{
        width:72px;
        height:100px;
    }

    .cart-product-bottom{
        align-items:center;
    }
}


/* =========================================================
   BOOKSTORE ROOT
========================================================= */

.bookstore-page{
    --navy:#241B52;
    --orange:#EF5843;
    --orange-dark:#C6432F;
    --gold:#F7AA35;
    --cream:#FBF9F5;
    --muted:#6B7280;
    --border:#EAE7DF;

    --ikapi-deep:#0B2545;
    --ikapi-blue:#134074;
    --ikapi-light:#5B9BD5;
    --ikapi-soft:#DCEAF7;

    --gradient:linear-gradient(135deg,#EF5843,#F7AA35);
    --ease:cubic-bezier(.22,1,.36,1);

    width:100%;
    min-height:100vh;
    overflow-x:hidden;
    background:#fff;
    color:var(--navy);
    font-family:'Inter',sans-serif;
}

.bookstore-page *,
.bookstore-page *::before,
.bookstore-page *::after{
    box-sizing:border-box;
}

.bookstore-page a{
    text-decoration:none;
    color:inherit;
}

.store-wrap{
    position:relative;
    width:100%;
    max-width:1500px;
    margin:auto;
    padding:0 32px;
}


/* =========================================================
   HERO
========================================================= */

.store-hero{
    position:relative;
    min-height:465px;
    display:flex;
    align-items:center;
    padding:62px 0 54px;
    overflow:hidden;
    isolation:isolate;
    background:
        radial-gradient(circle at 88% 10%,rgba(91,155,213,.10),transparent 27%),
        radial-gradient(circle at 7% 85%,rgba(247,170,53,.07),transparent 25%),
        #fff;
}

.store-hero::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    z-index:5;
    height:4px;
    background:var(--gradient);
}

.store-hero::after{
    content:"";
    position:absolute;
    width:390px;
    height:390px;
    right:-240px;
    bottom:-245px;
    border-radius:50%;
    border:1px solid rgba(91,155,213,.10);
    box-shadow:
        0 0 0 45px rgba(91,155,213,.025),
        0 0 0 90px rgba(19,64,116,.018);
    pointer-events:none;
}

.store-ambient-canvas{
    position:absolute;
    inset:0;
    z-index:0;
    width:100%;
    height:100%;
    opacity:.70;
    pointer-events:none;
}

.store-hero .store-wrap{
    z-index:2;
}

.store-hero-grid{
    display:grid;
    grid-template-columns:minmax(0,1.12fr) minmax(350px,.88fr);
    align-items:center;
    gap:clamp(48px,6vw,100px);
}

.store-hero-copy{
    min-width:0;
}

.eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:16px;
    padding:7px 14px;
    border:1px solid rgba(239,88,67,.08);
    border-radius:999px;
    background:#FFF1E4;
    color:var(--orange-dark);
    font-size:11px;
    font-weight:700;
}

.eyebrow-icon{
    width:15px;
    height:15px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.store-hero h1{
    max-width:760px;
    margin:0 0 14px;
    color:var(--navy);
    font-family:'Poppins',sans-serif;
    font-size:clamp(34px,4vw,52px);
    font-weight:750;
    line-height:1.12;
    letter-spacing:-1px;
}

.hero-description{
    max-width:680px;
    margin:0;
    color:var(--muted);
    font-size:14px;
    line-height:1.7;
}

.hero-stats{
    display:flex;
    flex-wrap:wrap;
    gap:34px;
    margin-top:28px;
}

.hero-stat{
    position:relative;
    min-width:140px;
    padding-left:14px;
    border-left:2px solid var(--border);
}

.hero-stat::before{
    content:"";
    position:absolute;
    left:-4px;
    top:0;
    width:6px;
    height:6px;
    border-radius:50%;
    background:var(--orange);
    box-shadow:0 0 0 5px rgba(239,88,67,.08);
}

.hero-stat strong{
    display:block;
    font-family:'Poppins',sans-serif;
    font-size:21px;
    font-weight:750;
}

.hero-stat span{
    color:var(--muted);
    font-size:10px;
}


/* =========================================================
   IKAPI MEMBERSHIP
========================================================= */

.ikapi-area{
    position:relative;
    min-width:0;
    display:flex;
    justify-content:flex-end;
}

.ikapi-card{
    position:relative;
    width:min(100%,430px);
    min-height:274px;
    padding:24px;
    overflow:hidden;

    border:1px solid rgba(19,64,116,.15);
    border-radius:22px;

    background:
        radial-gradient(
            circle at 100% 0,
            rgba(91,155,213,.17),
            transparent 30%
        ),
        linear-gradient(
            145deg,
            #FFFFFF 0%,
            #FAFCFE 52%,
            #EEF6FC 100%
        );

    box-shadow:
        0 24px 58px rgba(11,37,69,.10),
        0 4px 14px rgba(19,64,116,.04);

    animation:
        ikapiCardEnter .9s
        cubic-bezier(.16,1,.3,1)
        .15s both;
}

.ikapi-card::before{
    content:"";
    position:absolute;
    width:215px;
    height:215px;
    top:-135px;
    right:-95px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(91,155,213,.27),
            rgba(19,64,116,.08) 57%,
            transparent 73%
        );

    pointer-events:none;
}

.ikapi-card::after{
    content:"";
    position:absolute;
    z-index:7;

    top:-45%;
    left:-75%;

    width:42%;
    height:195%;

    opacity:0;
    transform:rotate(18deg);

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(220,234,247,.78),
            transparent
        );

    pointer-events:none;

    animation:
        ikapiCardShine
        5.8s ease-in-out
        1.8s infinite;
}

.ikapi-card-head{
    position:relative;
    z-index:3;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:14px;
    margin-bottom:22px;
}

.ikapi-card-kicker{
    display:inline-flex;
    align-items:center;
    gap:8px;

    color:var(--ikapi-blue);

    font-size:8px;
    font-weight:800;
    letter-spacing:.14em;
    text-transform:uppercase;
}

.ikapi-card-kicker::before{
    content:"";

    width:22px;
    height:2px;

    border-radius:999px;

    background:
        linear-gradient(
            90deg,
            var(--ikapi-deep),
            var(--ikapi-blue),
            var(--ikapi-light)
        );
}

.ikapi-status{
    display:inline-flex;
    align-items:center;
    gap:7px;

    color:#5E748B;

    font-size:8px;
    font-weight:700;
}

.ikapi-status-dot{
    position:relative;

    width:7px;
    height:7px;

    border-radius:50%;

    background:var(--ikapi-light);

    box-shadow:
        0 0 0 3px
        rgba(91,155,213,.12);
}

.ikapi-status-dot::before{
    content:"";

    position:absolute;
    inset:-4px;

    border:1px solid rgba(91,155,213,.42);
    border-radius:50%;

    animation:
        ikapiBluePulse
        2.4s ease-out infinite;
}

.ikapi-main{
    position:relative;
    z-index:3;

    display:grid;
    grid-template-columns:118px minmax(0,1fr);

    align-items:center;
    gap:20px;
}

.ikapi-logo-box{
    position:relative;

    width:118px;
    height:118px;

    display:flex;
    align-items:center;
    justify-content:center;

    overflow:hidden;

    border:1px solid rgba(19,64,116,.14);
    border-radius:18px;

    background:
        linear-gradient(
            145deg,
            #FFFFFF,
            #F4F9FD
        );

    box-shadow:
        0 11px 26px
        rgba(11,37,69,.09);

    animation:
        ikapiLogoFloat
        4.2s ease-in-out infinite;
}

.ikapi-logo-box::before{
    content:"";

    position:absolute;

    width:78px;
    height:78px;

    left:-32px;
    bottom:-39px;

    border-radius:50%;

    background:
        rgba(91,155,213,.14);
}

.ikapi-logo-box::after{
    content:"";

    position:absolute;
    inset:7px;

    border:
        1px solid
        rgba(91,155,213,.11);

    border-radius:13px;

    pointer-events:none;
}

.ikapi-logo{
    position:relative;
    z-index:2;

    width:84%;
    height:84%;

    display:block;

    object-fit:contain;
}

.ikapi-info{
    min-width:0;
}

.ikapi-member-label{
    display:block;

    margin-bottom:2px;

    color:var(--ikapi-blue);

    font-size:11px;
    font-weight:700;
}

.ikapi-name{
    display:inline-block;

    margin:0;

    font-family:'Poppins',sans-serif;

    font-size:clamp(36px,3.5vw,47px);
    font-weight:800;

    line-height:1;
    letter-spacing:-.055em;

    background:
        linear-gradient(
            90deg,
            #0B2545 0%,
            #134074 24%,
            #5B9BD5 48%,
            #134074 72%,
            #0B2545 100%
        );

    background-size:240% auto;

    -webkit-background-clip:text;
    background-clip:text;

    color:transparent;

    animation:
        ikapiOceanText
        4.5s linear infinite;
}

.ikapi-full-name{
    max-width:210px;

    margin:8px 0 0;

    color:#526B83;

    font-size:10px;
    font-weight:600;

    line-height:1.5;
}

/* =========================================================
   IKAPI MEMBER NUMBER
========================================================= */

.ikapi-member-number{
    position:relative;
    z-index:3;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;

    margin-top:15px;
    padding:11px 12px;

    border:1px solid rgba(19,64,116,.11);
    border-radius:12px;

    background:rgba(255,255,255,.68);
}

.ikapi-member-number-copy{
    min-width:0;
}

.ikapi-member-number-label{
    display:block;

    margin-bottom:3px;

    color:#7C90A4;

    font-size:7px;
    font-weight:800;
    letter-spacing:.09em;
    text-transform:uppercase;
}

.ikapi-member-number strong{
    display:block;

    color:var(--ikapi-deep);

    font-size:10px;
    font-weight:800;

    overflow-wrap:anywhere;
}

.ikapi-member-number.is-pending strong{
    color:#8193A4;
    font-size:8.5px;
    font-weight:700;
}

.ikapi-member-number-icon{
    width:30px;
    height:30px;

    display:grid;
    place-items:center;

    flex:0 0 30px;

    border-radius:9px;

    color:var(--ikapi-blue);
    background:rgba(220,234,247,.72);
}

.ikapi-member-number-icon svg{
    width:14px;
    height:14px;

    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}


/* =========================================================
   IKAPI DOCUMENTS
========================================================= */

.ikapi-documents{
    position:relative;
    z-index:3;

    margin-top:18px;
    padding-top:16px;

    border-top:1px solid rgba(19,64,116,.11);
}

.ikapi-documents-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:12px;

    margin-bottom:11px;
}

.ikapi-documents-head strong{
    display:block;
    color:var(--ikapi-deep);
    font-size:10.5px;
    font-weight:800;
}

.ikapi-documents-head span{
    color:#8DA0B2;
    font-size:7.5px;
    font-weight:600;
}

.ikapi-document-grid{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:10px;

    width:100%;
    margin-inline:auto;
}

.ikapi-document-card{
    display:grid;
    grid-template-columns:78px minmax(0,1fr);
    align-items:center;
    gap:12px;

    flex:1 1 195px;
    width:100%;
    max-width:320px;
    min-width:0;

    padding:11px;

    border:1px solid rgba(19,64,116,.12);
    border-radius:13px;

    color:inherit!important;
    background:rgba(255,255,255,.82);

    font:inherit;
    text-align:left;
    cursor:pointer;

    box-shadow:0 5px 16px rgba(11,37,69,.045);

    transition:
        transform .25s ease,
        border-color .25s ease,
        background .25s ease,
        box-shadow .25s ease;
}

.ikapi-document-thumb{
    position:relative;

    width:78px;
    height:98px;

    overflow:hidden;

    border:1px solid rgba(19,64,116,.12);
    border-radius:8px;

    background:#FFFFFF;
    box-shadow:0 5px 13px rgba(11,37,69,.07);
}

.ikapi-document-thumb img{
    width:100%;
    height:100%;

    display:block;
    padding:3px;

    object-fit:contain;
    object-position:center;

    background:#FFFFFF;
}

.ikapi-document-thumb::after{
    content:"";
    position:absolute;
    inset:0;

    background:linear-gradient(
        180deg,
        transparent 52%,
        rgba(11,37,69,.52)
    );

    opacity:.10;
    transition:opacity .25s ease;
}

.ikapi-document-zoom{
    position:absolute;
    z-index:3;

    right:5px;
    bottom:5px;

    width:23px;
    height:23px;

    display:grid;
    place-items:center;

    border-radius:7px;

    color:#FFFFFF;
    background:rgba(11,37,69,.90);

    opacity:0;
    transform:translateY(3px);

    transition:
        opacity .25s ease,
        transform .25s ease;
}

.ikapi-document-zoom svg{
    width:11px;
    height:11px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.ikapi-document-copy{
    min-width:0;
}

.ikapi-document-copy strong{
    display:block;
    color:var(--ikapi-deep);
    font-size:9.5px;
    font-weight:800;
    line-height:1.35;
    overflow-wrap:anywhere;
}

.ikapi-document-copy span{
    display:block;
    margin-top:4px;
    color:#8497A9;
    font-size:7.3px;
    line-height:1.5;
}

.ikapi-document-action{
    display:inline-flex!important;
    align-items:center;
    gap:4px;
    margin-top:6px!important;
    color:var(--ikapi-blue)!important;
    font-size:7.2px!important;
    font-weight:800;
}

.ikapi-document-action svg{
    width:9px;
    height:9px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.ikapi-document-card:hover{
    transform:translateY(-2px);
    border-color:rgba(91,155,213,.34);
    background:#FFFFFF;
    box-shadow:0 10px 24px rgba(11,37,69,.08);
}

.ikapi-document-card:hover .ikapi-document-thumb::after{
    opacity:.28;
}

.ikapi-document-card:hover .ikapi-document-zoom{
    opacity:1;
    transform:translateY(0);
}

/* =========================================================
   IKAPI DOCUMENT VIEWER
========================================================= */

.ikapi-document-modal{
    position:fixed;
    z-index:9998;
    inset:0;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:22px;

    opacity:0;
    visibility:hidden;
    pointer-events:none;

    background:rgba(7,19,34,.82);
    backdrop-filter:blur(7px);

    transition:
        opacity .22s ease,
        visibility .22s ease;
}

.ikapi-document-modal.is-open{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
}

.ikapi-document-modal-card{
    width:min(100%,1000px);
    max-height:94vh;

    display:flex;
    flex-direction:column;

    overflow:hidden;

    border:1px solid rgba(220,234,247,.30);
    border-radius:18px;

    background:#FFFFFF;

    box-shadow:
        0 30px 95px
        rgba(0,0,0,.34);

    transform:translateY(12px) scale(.985);

    transition:transform .28s var(--ease);
}

.ikapi-document-modal.is-open
.ikapi-document-modal-card{
    transform:none;
}

.ikapi-document-modal-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;

    padding:13px 15px;

    border-bottom:1px solid #E8EEF3;
}

.ikapi-document-modal-title{
    min-width:0;
}

.ikapi-document-modal-title span{
    display:block;

    margin-bottom:2px;

    color:var(--ikapi-light);

    font-size:7px;
    font-weight:850;
    letter-spacing:.11em;
    text-transform:uppercase;
}

.ikapi-document-modal-title strong{
    display:block;

    color:var(--ikapi-deep);

    font-family:'Poppins',sans-serif;
    font-size:13px;
    font-weight:700;

    overflow-wrap:anywhere;
}

.ikapi-document-modal-close{
    width:35px;
    height:35px;

    display:grid;
    place-items:center;

    flex:0 0 35px;

    padding:0;

    border:1px solid #E2EAF0;
    border-radius:9px;

    color:#61778B;
    background:#F7FAFC;

    cursor:pointer;

    transition:
        color .2s ease,
        border-color .2s ease,
        background .2s ease;
}

.ikapi-document-modal-close svg{
    width:14px;
    height:14px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
}

.ikapi-document-modal-view{
    min-height:360px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:20px;

    overflow:auto;

    background:
        radial-gradient(
            circle at 50% 0,
            rgba(91,155,213,.10),
            transparent 36%
        ),
        #F3F7FA;
}

.ikapi-document-modal-view img{
    width:auto;
    max-width:100%;

    height:auto;
    max-height:78vh;

    display:block;

    margin:auto;

    border-radius:4px;

    background:#FFFFFF;

    box-shadow:
        0 14px 38px
        rgba(11,37,69,.15);

    object-fit:contain;
}

.ikapi-document-modal-foot{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;

    padding:11px 15px;

    border-top:1px solid #E8EEF3;
}

.ikapi-document-modal-foot p{
    max-width:560px;

    margin:0;

    color:#8395A6;

    font-size:7.5px;
    line-height:1.55;
}

.ikapi-document-full{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    min-height:34px;
    padding:0 11px;

    flex-shrink:0;

    border-radius:8px;

    color:#FFFFFF!important;

    background:linear-gradient(
        135deg,
        var(--ikapi-deep),
        var(--ikapi-blue)
    );

    font-size:7.5px;
    font-weight:800;
}

.ikapi-document-full svg{
    width:10px;
    height:10px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
}


@media (hover:hover) and (pointer:fine){

    .ikapi-document-card:hover{
        transform:translateY(-2px);

        border-color:rgba(91,155,213,.30);

        background:#FFFFFF;

        box-shadow:
            0 8px 20px
            rgba(11,37,69,.075);
    }

    .ikapi-document-card:hover
    .ikapi-document-thumb::after{
        opacity:.65;
    }

    .ikapi-document-card:hover
    .ikapi-document-zoom{
        opacity:1;
        transform:none;
    }

    .ikapi-document-modal-close:hover{
        color:#FFFFFF;
        border-color:var(--ikapi-deep);
        background:var(--ikapi-deep);
    }

}


@media (max-width:480px){

    .ikapi-member-number{
        margin-top:12px;
        padding:9px 10px;
    }

    .ikapi-document-grid{
        display:flex;
        flex-direction:column;
        align-items:center;
    }

    .ikapi-document-card{
        grid-template-columns:50px minmax(0,1fr);
        flex:none;
        max-width:100%;
    }

    .ikapi-document-thumb{
        width:50px;
        height:62px;
    }

    .ikapi-document-modal{
        padding:9px;
    }

    .ikapi-document-modal-card{
        border-radius:14px;
    }

    .ikapi-document-modal-head{
        padding:11px;
    }

    .ikapi-document-modal-title strong{
        font-size:11px;
    }

    .ikapi-document-modal-view{
        padding:9px;
    }

    .ikapi-document-modal-view img{
        max-height:70vh;
    }

    .ikapi-document-modal-foot{
        align-items:flex-start;
        flex-direction:column;

        padding:10px 11px;
    }

    .ikapi-document-full{
        width:100%;
        min-height:38px;
    }

}


/* =========================================================
   IKAPI MOTION
========================================================= */

@keyframes ikapiCardEnter{
    0%{
        opacity:0;
        transform:
            translate3d(46px,22px,0)
            scale(.965);
    }

    100%{
        opacity:1;
        transform:
            translate3d(0,0,0)
            scale(1);
    }
}

@keyframes ikapiLogoFloat{
    0%,
    100%{
        transform:
            translate3d(0,0,0)
            rotate(-1deg);
    }

    50%{
        transform:
            translate3d(0,-6px,0)
            rotate(1deg);
    }
}

@keyframes ikapiOceanText{
    0%{
        background-position:0% center;
    }

    100%{
        background-position:240% center;
    }
}

@keyframes ikapiBluePulse{
    0%{
        opacity:.7;
        transform:scale(.75);
    }

    75%,
    100%{
        opacity:0;
        transform:scale(1.8);
    }
}

@keyframes ikapiCardShine{
    0%,
    72%{
        left:-75%;
        opacity:0;
    }

    77%{
        opacity:.55;
    }

    90%{
        left:140%;
        opacity:0;
    }

    100%{
        left:140%;
        opacity:0;
    }
}


/* =========================================================
   SECTION
========================================================= */

.store-section{
    position:relative;
    padding:50px 0;
    overflow:hidden;
}

.catalog-section{
    background:
        radial-gradient(
            circle at 0 50%,
            rgba(247,170,53,.08),
            transparent 25%
        ),
        var(--cream);
}

.motion-divider{
    position:relative;
    width:100%;
    height:1px;
    margin-bottom:35px;
    overflow:hidden;
    background:#F1EDE7;
}

.motion-divider span{
    position:absolute;
    inset:0;

    background:
        linear-gradient(
            90deg,
            var(--orange),
            var(--gold),
            rgba(247,170,53,0)
        );

    transform-origin:left center;
}

.section-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:20px;
    margin-bottom:24px;
}

.section-head > div:first-child{
    min-width:0;
}

.section-head h2{
    display:flex;
    align-items:center;
    gap:9px;

    margin:0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;
    font-size:24px;
    font-weight:700;
}

.section-head p{
    margin:5px 0 0 20px;
    color:var(--muted);
    font-size:11px;
}

.section-tag{
    width:10px;
    height:10px;

    flex:0 0 auto;

    border-radius:3px;

    background:var(--gradient);
}


/* =========================================================
   LATEST
========================================================= */

.latest-controls{
    display:flex;
    align-items:center;
    gap:7px;
    flex-shrink:0;
}

.latest-arrow{
    display:flex;
    align-items:center;
    justify-content:center;

    width:42px;
    height:42px;

    padding:0;

    border:1px solid var(--border);
    border-radius:10px;

    color:var(--navy);
    background:#fff;

    cursor:pointer;

    transition:
        border-color .2s ease,
        color .2s ease,
        opacity .2s ease,
        transform .2s ease;
}

.latest-arrow.is-disabled,
.latest-arrow:disabled{
    opacity:.35;
    cursor:default;
}

.latest-arrow svg{
    width:15px;
    height:15px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;

    stroke-linecap:round;
    stroke-linejoin:round;
}

.latest-viewport{
    position:relative;
    width:100%;
    min-width:0;
    overflow:hidden;
}

.latest-slider{
    display:flex;
    gap:18px;

    width:100%;

    padding:2px 0 20px;

    overflow-x:auto;
    overflow-y:hidden;

    scrollbar-width:none;
    overscroll-behavior-x:contain;

    cursor:grab;
}

.latest-slider::-webkit-scrollbar{
    display:none;
}

.latest-slider.is-dragging{
    cursor:grabbing;
    user-select:none;
}

.latest-slide{
    flex:0 0 calc((100% - 72px) / 5);
    min-width:0;
}


/* =========================================================
   CATALOG
========================================================= */

.catalog-grid{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    align-items:stretch;
    gap:18px;
}

.catalog-item{
    min-width:0;
}


/* =========================================================
   BOOK CARD
========================================================= */

.book-card{
    position:relative;

    display:flex;
    flex-direction:column;

    width:100%;
    height:100%;
    min-width:0;

    overflow:hidden;

    border:1px solid var(--border);
    border-radius:17px;

    background:#fff;

    box-shadow:
        0 5px 16px
        rgba(36,27,82,.045);

    transition:
        border-color .3s ease,
        box-shadow .3s ease;
}

.book-card::after{
    content:"";

    position:absolute;
    inset:0;
    z-index:8;

    opacity:0;

    pointer-events:none;

    border-radius:inherit;

    background:
        linear-gradient(
            115deg,
            transparent 25%,
            rgba(255,255,255,.22) 45%,
            transparent 64%
        );

    transform:translateX(-120%);
}

.book-card:hover::after{
    opacity:1;
    animation:storeCardShine .8s ease forwards;
}

.cover-area{
    position:relative;

    display:flex;
    align-items:center;
    justify-content:center;

    height:225px;

    overflow:hidden;

    background:
        radial-gradient(
            circle at 50% 35%,
            rgba(247,170,53,.1),
            transparent 35%
        ),
        linear-gradient(
            180deg,
            #FBF9F5,
            #F1EDE4
        );

    perspective:900px;
}

.cover-area::before{
    content:"";

    position:absolute;

    width:145px;
    height:34px;

    left:50%;
    bottom:21px;

    border-radius:50%;

    background:
        rgba(36,27,82,.13);

    filter:blur(10px);

    transform:translateX(-50%);
}

.book-float{
    position:relative;
    z-index:2;

    transform-style:preserve-3d;

    will-change:transform;
}

.book-tilt{
    position:relative;

    transform-style:preserve-3d;

    will-change:transform;
}

.book-3d{
    position:relative;

    width:130px;
    height:180px;

    transform:rotateY(-18deg);

    transform-style:preserve-3d;
}

.book-face{
    position:absolute;
}

.book-front{
    width:130px;
    height:180px;

    display:flex;
    flex-direction:column;
    justify-content:flex-end;

    padding:12px;

    color:#fff;

    border-radius:2px 6px 6px 2px;

    transform:translateZ(9px);

    background-color:var(--orange);
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    box-shadow:
        8px 13px 22px
        rgba(18,25,59,.27);
}

.book-pages{
    top:2px;
    right:0;

    width:18px;
    height:176px;

    transform-origin:right;
    transform:rotateY(90deg);

    background:
        repeating-linear-gradient(
            to bottom,
            #FDFCF9 0 2px,
            #EAE5DA 2px 3px
        );
}

.book-spine{
    top:2px;
    left:0;

    width:18px;
    height:176px;

    transform-origin:left;
    transform:rotateY(-90deg);

    filter:brightness(.75);
}

.cover-title{
    font-size:12px;
    font-weight:700;
    line-height:1.35;
}

.cover-author{
    margin-top:4px;
    font-size:9px;
    opacity:.85;
}

.book-info{
    position:relative;
    z-index:4;

    display:flex;
    flex:1;
    flex-direction:column;

    padding:14px;

    background:#fff;
}

.book-publisher{
    height:14px;

    overflow:hidden;

    color:#8A8F9C;

    font-size:9px;
    font-weight:700;

    text-transform:uppercase;
    text-overflow:ellipsis;

    white-space:nowrap;
}

.book-title{
    min-height:40px;
    max-height:40px;

    margin:5px 0;

    overflow:hidden;

    color:var(--navy);

    font-family:'Poppins',sans-serif;
    font-size:14px;
    font-weight:600;

    line-height:1.4;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}

.book-author{
    height:17px;

    margin-bottom:10px;

    overflow:hidden;

    color:var(--muted);

    font-size:11px;

    white-space:nowrap;
    text-overflow:ellipsis;
}

.book-format-list{
    display:grid;
    grid-template-rows:repeat(2,76px);

    gap:8px;

    width:100%;

    margin:0 0 10px;
}

.format-box{
    position:relative;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:6px;

    width:100%;
    height:76px;

    padding:9px;

    overflow:hidden;

    border-radius:9px;
}

.print-format{
    border:1px solid #FED7AA;
    background:#FFF7ED;
}

.ebook-format{
    border:1px solid #C7D2FE;
    background:#EEF2FF;
}

.format-content{
    min-width:0;
    flex:1;
}

.format-label{
    display:flex;
    align-items:center;
    gap:5px;

    margin-bottom:2px;

    font-size:9px;
    font-weight:800;

    text-transform:uppercase;
}

.format-icon{
    width:12px;
    height:12px;

    flex-shrink:0;

    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
}

.print-label{
    color:#C2410C;
}

.ebook-label{
    color:#4338CA;
}

.format-old-price{
    height:12px;

    overflow:hidden;

    color:#94A3B8;

    font-size:7.5px;
    line-height:12px;

    text-decoration:line-through;

    white-space:nowrap;
}

.format-price{
    overflow:hidden;

    color:var(--navy);

    font-size:11px;
    line-height:17px;
    font-weight:800;

    white-space:nowrap;
}

.format-discount{
    display:block;

    height:12px;

    margin-top:2px;

    color:#DC2626;

    font-size:8px;
    line-height:12px;
    font-weight:800;
}

.format-discount-placeholder{
    display:block;

    height:12px;

    margin-top:2px;

    font-size:8px;
    line-height:12px;
}

.format-stock{
    display:block;

    height:12px;

    margin-top:2px;

    font-size:8px;
    line-height:12px;
    font-weight:800;
}

.available-stock{
    color:#15803D;
}

.sold-out-stock{
    color:#DC2626;
}

.format-out-of-stock{
    border-color:#FECACA;
    background:#FFF7F7;
}

.format-unavailable{
    opacity:.72;
}

.format-unavailable-text{
    height:29px;

    display:flex;
    align-items:center;

    color:#94A3B8;

    font-size:10px;
    font-weight:600;
}

.format-add{
    position:relative;

    flex-shrink:0;

    min-width:61px;
    height:35px;

    padding:0 6px;

    overflow:hidden;

    border:0;
    border-radius:8px;

    color:#fff;

    font-size:8px;
    font-weight:800;

    cursor:pointer;
}

.format-add::before{
    content:"";

    position:absolute;
    inset:0;

    background:
        linear-gradient(
            110deg,
            transparent 20%,
            rgba(255,255,255,.3) 48%,
            transparent 75%
        );

    transform:translateX(-130%);
}

.format-add:hover::before{
    animation:storeButtonShine .65s ease forwards;
}

.print-add{
    background:
        linear-gradient(
            135deg,
            #EF5843,
            #F7AA35
        );
}

.ebook-add{
    background:
        linear-gradient(
            135deg,
            #4338CA,
            #6366F1
        );
}

.unavailable-add{
    color:#64748B;
    background:#E2E8F0;
}

.unavailable-add::before{
    display:none;
}

.format-add:disabled{
    opacity:.65;
    cursor:default;
}

.detail-btn{
    position:relative;

    display:flex;
    align-items:center;
    justify-content:center;

    gap:6px;

    width:100%;
    min-height:38px;

    margin-top:auto;
    padding:7px 10px;

    overflow:hidden;

    border:1px solid var(--orange);
    border-radius:8px;

    color:var(--orange-dark)!important;
    background:#fff;

    font-size:10px;
    font-weight:700;

    transition:
        background .2s ease,
        color .2s ease;
}

.detail-btn svg{
    width:13px;
    height:13px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
}

.detail-btn:hover{
    background:var(--orange);
    color:#fff!important;
}

@keyframes storeCardShine{
    from{
        transform:translateX(-120%);
    }

    to{
        transform:translateX(120%);
    }
}

@keyframes storeButtonShine{
    from{
        transform:translateX(-130%);
    }

    to{
        transform:translateX(130%);
    }
}


/* =========================================================
   FILTER
========================================================= */

.filter-row{
    display:flex;
    flex-wrap:wrap;
    gap:8px;

    margin-bottom:25px;
}

.category-chip{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-height:36px;

    padding:7px 15px;

    border:1px solid var(--border);
    border-radius:999px;

    background:#fff;

    color:var(--navy)!important;

    font-size:10px;
    font-weight:650;
}

.category-chip.active{
    background:var(--navy);
    border-color:var(--navy);

    color:#fff!important;

    box-shadow:
        0 7px 16px
        rgba(36,27,82,.14);
}


/* =========================================================
   PAGINATION
========================================================= */

.store-pagination{
    display:flex;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;

    gap:7px;

    margin-top:35px;
}

.store-pagination a,
.store-pagination span{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:42px;
    height:42px;

    padding:0 11px;

    border:1px solid #E5E7EB;
    border-radius:9px;

    background:#fff;

    color:var(--navy)!important;

    font-size:11px;
    font-weight:700;
}

.store-pagination .active{
    background:var(--navy);
    border-color:var(--navy);

    color:#fff!important;
}

.store-pagination .disabled{
    background:#F8FAFC;
    color:#9CA3AF!important;
}

.catalog-section.catalog-is-loading .store-pagination{
    pointer-events:none;
    opacity:.55;
}

.catalog-section.catalog-is-loading #catalogGrid{
    pointer-events:none;
}

.empty-state{
    grid-column:1/-1;

    width:100%;

    padding:45px 20px;

    text-align:center;

    border:1px solid var(--border);
    border-radius:14px;

    background:#fff;

    color:var(--muted);

    font-size:12px;
}


/* =========================================================
   CTA
========================================================= */

.cta-section{
    padding:0 0 55px;
}

.cta-banner{
    position:relative;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:20px;

    padding:32px 36px;

    overflow:hidden;

    border:1px solid var(--border);
    border-radius:18px;

    background:
        linear-gradient(
            120deg,
            #FFF6EC,
            #FFE9D2
        );
}

.cta-banner::before{
    content:"";

    position:absolute;

    width:190px;
    height:190px;

    right:-80px;
    top:-90px;

    border:
        34px solid
        rgba(247,170,53,.12);

    border-radius:50%;
}

.cta-banner > div,
.cta-btn{
    position:relative;
    z-index:2;
}

.cta-banner > div{
    min-width:0;
}

.cta-banner h3{
    margin:0 0 5px;

    font-size:19px;
    font-weight:750;

    overflow-wrap:anywhere;
}

.cta-banner p{
    margin:0;

    color:var(--muted);

    font-size:11px;
    line-height:1.6;
}

.cta-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    flex-shrink:0;

    min-height:44px;

    padding:11px 20px;

    border-radius:8px;

    color:#fff!important;

    background:var(--gradient);

    font-size:11px;
    font-weight:750;
}


/* =========================================================
   CART
========================================================= */

.cart-fab{
    position:fixed;

    right:24px;
    bottom:24px;

    z-index:1200;

    display:flex;
    align-items:center;
    justify-content:center;

    width:56px;
    height:56px;

    padding:0;

    border:0;
    border-radius:50%;

    color:#fff;
    background:var(--navy);

    cursor:pointer;

    box-shadow:
        0 12px 28px
        rgba(36,27,82,.32);
}

.cart-fab svg{
    width:22px;
    height:22px;

    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
}

.cart-count{
    position:absolute;

    top:-5px;
    right:-5px;

    display:flex;
    align-items:center;
    justify-content:center;

    min-width:21px;
    height:21px;

    padding:0 5px;

    border:2px solid #fff;
    border-radius:999px;

    color:#fff;
    background:var(--orange);

    font-size:9px;
    font-weight:800;
}

.cart-count.hide{
    display:none;
}

.cart-overlay{
    position:fixed;
    inset:0;

    z-index:1300;

    opacity:0;
    visibility:hidden;

    background:
        rgba(15,23,42,.48);

    backdrop-filter:blur(3px);

    transition:.25s ease;
}

.cart-overlay.show{
    opacity:1;
    visibility:visible;
}

.cart-drawer{
    position:fixed;

    top:0;
    right:0;

    z-index:1400;

    display:flex;
    flex-direction:column;

    width:460px;
    max-width:100vw;

    height:100dvh;

    background:#fff;

    transform:translateX(100%);

    transition:
        transform .35s
        var(--ease);

    box-shadow:
        -20px 0 50px
        rgba(15,23,42,.16);
}

.cart-drawer.open{
    transform:translateX(0);
}

.cart-drawer-head{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:10px;

    padding:18px 20px;

    border-bottom:
        1px solid
        #E5E7EB;
}

.cart-heading h3{
    margin:0;

    color:var(--navy);

    font-size:20px;
    font-weight:700;
}

.cart-heading p{
    margin:2px 0 0;

    color:var(--muted);

    font-size:10px;
}

.cart-header-actions{
    display:flex;
    align-items:center;

    gap:6px;
}

.clear-cart{
    display:none;

    padding:7px 9px;

    border:1px solid #FECACA;
    border-radius:7px;

    color:#DC2626;
    background:#FEF2F2;

    font-size:9px;
    font-weight:700;

    cursor:pointer;
}

.clear-cart.show{
    display:block;
}

.cart-close{
    display:flex;
    align-items:center;
    justify-content:center;

    width:38px;
    height:38px;

    padding:0;

    border:0;
    border-radius:8px;

    color:#64748B;
    background:#F8FAFC;

    cursor:pointer;
}

.cart-close svg{
    width:16px;
    height:16px;

    fill:none;
    stroke:currentColor;
    stroke-width:2;
}

.cart-items{
    flex:1;

    overflow-y:auto;

    padding:12px;

    background:#F8FAFC;
}

.cart-drawer-foot{
    padding:15px 18px 18px;

    border-top:
        1px solid
        #E5E7EB;

    background:#fff;
}

.cart-summary-row,
.cart-total-row{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:15px;
}

.cart-summary-row{
    margin-bottom:5px;
}

.cart-summary-row span{
    color:var(--muted);
    font-size:11px;
}

.cart-total-row{
    margin:10px 0 13px;
    padding-top:10px;

    border-top:
        1px dashed
        #D1D5DB;
}

.cart-total-row span{
    font-size:13px;
    font-weight:700;
}

.cart-total-row strong{
    font-size:21px;
    font-weight:800;
}

.checkout-btn{
    width:100%;
    min-height:48px;

    border:0;
    border-radius:9px;

    color:#fff;
    background:#22C55E;

    font-size:12px;
    font-weight:800;

    cursor:pointer;
}

.checkout-btn:disabled{
    opacity:.45;
    cursor:not-allowed;
}

.cart-note{
    margin:8px 0 0;

    color:#94A3B8;

    font-size:8.5px;
    line-height:1.5;

    text-align:center;
}

.cart-toast{
    position:fixed;

    right:25px;
    bottom:90px;

    z-index:1500;

    max-width:320px;

    padding:11px 14px;

    opacity:0;
    visibility:hidden;

    transform:translateY(8px);

    border-radius:8px;

    color:#fff;
    background:var(--navy);

    font-size:10px;
    font-weight:700;

    transition:.2s ease;
}

.cart-toast.show{
    opacity:1;
    visibility:visible;

    transform:none;
}

.cart-toast.warning{
    background:#C2410C;
}


/* =========================================================
   DESKTOP HOVER
========================================================= */

@media (hover:hover) and (pointer:fine){

    .latest-arrow:hover{
        border-color:var(--orange);
        color:var(--orange);

        transform:translateY(-1px);
    }

    .category-chip:hover{
        border-color:var(--orange);

        color:var(--orange)!important;
    }

    .ikapi-card{
        transition:
            transform .4s var(--ease),
            box-shadow .4s ease,
            border-color .4s ease;
    }

    .ikapi-card:hover{
        transform:translateY(-5px);

        border-color:
            rgba(91,155,213,.38);

        box-shadow:
            0 30px 66px rgba(11,37,69,.14),
            0 7px 20px rgba(91,155,213,.08);
    }

    .ikapi-card:hover .ikapi-logo-box{
        animation-play-state:paused;

        transform:
            translateY(-3px)
            scale(1.025);
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width:1199px){

    .store-hero-grid{
        grid-template-columns:
            minmax(0,1fr)
            350px;

        gap:42px;
    }

    .ikapi-card{
        padding:20px;
    }

    .ikapi-main{
        grid-template-columns:
            98px
            minmax(0,1fr);

        gap:16px;
    }

    .ikapi-logo-box{
        width:98px;
        height:98px;
    }

    .ikapi-name{
        font-size:38px;
    }

    .latest-slide{
        flex-basis:
            calc((100% - 36px) / 3);
    }

    .catalog-grid{
        grid-template-columns:
            repeat(3,minmax(0,1fr));
    }

}

@media (max-width:900px){

    .store-hero{
        min-height:auto;
    }

    .store-hero-grid{
        grid-template-columns:1fr;

        gap:37px;
    }

    .ikapi-area{
        justify-content:flex-start;
    }

    .ikapi-card{
        width:min(100%,540px);
    }

}


/* =========================================================
   TOUCH
========================================================= */

@media (hover:none), (pointer:coarse){

    .store-ambient-canvas{
        display:none!important;
    }

    .latest-viewport{
        overflow:hidden!important;
    }

    .latest-slider{
        overflow-x:auto!important;
        overflow-y:hidden!important;

        scroll-snap-type:
            x mandatory!important;

        scroll-behavior:
            smooth!important;

        -webkit-overflow-scrolling:
            touch!important;

        touch-action:
            pan-x pan-y!important;

        cursor:auto!important;
    }

    .latest-slide{
        scroll-snap-align:
            start!important;

        scroll-snap-stop:
            always!important;
    }

    .latest-arrow{
        width:46px!important;
        height:46px!important;
    }

    .ikapi-card::after{
        animation-duration:7s;
    }

    .ikapi-logo-box{
        animation-duration:5s;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width:767px){

    .store-wrap{
        padding:0 17px;
    }

    .store-hero{
        min-height:auto;

        padding:48px 0 40px;
    }

    .store-hero h1{
        font-size:35px;
        line-height:1.12;
    }

    .hero-description{
        font-size:12px;
    }

    .hero-stats{
        gap:20px;
        margin-top:24px;
    }

    .hero-stat{
        min-width:120px;
    }

    .ikapi-card{
        width:100%;
        min-height:auto;
    }

    .store-section{
        padding:38px 0;
    }

    .motion-divider{
        margin-bottom:28px;
    }

    .section-head{
        align-items:center;
    }

    .section-head h2{
        font-size:21px;
    }

    .section-head p{
        margin-left:19px;
    }

    .latest-slide{
        flex:0 0 min(82vw,310px);
    }

    .catalog-grid{
        grid-template-columns:
            repeat(2,minmax(0,1fr));

        gap:13px;
    }

    .filter-row{
        flex-wrap:nowrap;

        width:calc(100% + 17px);

        margin-right:-17px;
        padding-right:17px;

        overflow-x:auto;

        scrollbar-width:none;
    }

    .filter-row::-webkit-scrollbar{
        display:none;
    }

    .category-chip{
        flex:0 0 auto;
        min-height:40px;
    }

    .store-pagination{
        margin-top:27px;
    }

    .store-pagination a,
    .store-pagination span{
        min-width:44px;
        height:44px;
    }

    .cta-banner{
        align-items:flex-start;
        flex-direction:column;

        padding:25px;
    }

    .cta-btn{
        width:100%;
    }

    .cart-fab{
        right:17px;
        bottom:17px;

        width:54px;
        height:54px;
    }

    .cart-toast{
        left:16px;
        right:16px;
        bottom:82px;

        max-width:none;
    }

    .cart-drawer{
        width:100%;
    }

}

@media (max-width:480px){

    .store-wrap{
        padding:0 15px;
    }

    .store-hero h1{
        font-size:32px;
    }

    .store-hero-grid{
        gap:29px;
    }

    .ikapi-card{
        padding:17px;

        border-radius:18px;
    }

    .ikapi-card-head{
        margin-bottom:18px;
    }

    .ikapi-card-kicker{
        font-size:7px;
    }

    .ikapi-status{
        font-size:7px;
    }

    .ikapi-main{
        grid-template-columns:
            82px
            minmax(0,1fr);

        gap:14px;
    }

    .ikapi-logo-box{
        width:82px;
        height:82px;

        border-radius:14px;
    }

    .ikapi-logo-box::after{
        border-radius:10px;
    }

    .ikapi-member-label{
        font-size:10px;
    }

    .ikapi-name{
        font-size:31px;
    }

    .ikapi-full-name{
        margin-top:6px;

        font-size:8.5px;
    }

    .ikapi-documents{
        margin-top:15px;
        padding-top:14px;
    }

    .ikapi-documents-head strong{
        font-size:10px;
    }

    .ikapi-document-grid{
        gap:9px;
    }

    .ikapi-document-card{
        grid-template-columns:68px minmax(0,1fr);
        gap:10px;

        max-width:100%;
        padding:10px;
    }

    .ikapi-document-thumb{
        width:68px;
        height:86px;
    }

    .ikapi-document-copy strong{
        font-size:9px;
    }

    .ikapi-document-copy span{
        font-size:7px;
    }

    .latest-slide{
        flex-basis:86vw;
    }

    .catalog-grid{
        grid-template-columns:1fr;
    }

    .section-head{
        align-items:flex-start;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion:reduce){

    .store-ambient-canvas{
        display:none!important;
    }

    .ikapi-card,
    .ikapi-logo-box,
    .ikapi-name,
    .ikapi-status-dot::before,
    .ikapi-card::after{
        animation:none!important;
    }

}

</style>


<div class="bookstore-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="store-hero">

        <canvas
            class="store-ambient-canvas"
            data-store-ambient
            aria-hidden="true"
        ></canvas>

        <div class="store-wrap">

            <div class="store-hero-grid">

                {{-- LEFT HERO --}}
                <div class="store-hero-copy">

                    <span class="eyebrow">

                        <svg
                            class="eyebrow-icon"
                            viewBox="0 0 24 24"
                        >

                            <path
                                class="motion-draw"
                                d="M4 19.5A2.5 2.5 0 016.5 17H20"
                            />

                            <path
                                class="motion-draw"
                                d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                            />

                        </svg>

                        Toko resmi Baca Dulu

                    </span>


                    <h1>
                        Temukan buku terbitan penerbit rekan kami
                    </h1>


                    <p class="hero-description">
                        Jelajahi E-book dan Buku Cetak dari penulis
                        dan penerbit yang telah dipercaya Baca Dulu.
                    </p>


                    <div class="hero-stats">

                        <div class="hero-stat">

                            <strong
                                data-store-count="{{ $totalBooks }}"
                                data-plus="1"
                            >
                                {{ $totalBooks }}+
                            </strong>

                            <span>
                                Judul tersedia
                            </span>

                        </div>


                        <div class="hero-stat">

                            <strong
                                data-store-count="{{ $publisherCount }}"
                            >
                                {{ $publisherCount }}
                            </strong>

                            <span>
                                Penerbit rekanan
                            </span>

                        </div>

                    </div>

                </div>


                {{-- RIGHT HERO — IKAPI --}}
                <div class="ikapi-area">

                    <article
                        class="ikapi-card"
                        id="ikapiMembership"
                    >

                        <div class="ikapi-card-head">

                            <span class="ikapi-card-kicker">
                                Publishing Association
                            </span>

                            <span class="ikapi-status">
                                <span class="ikapi-status-dot"></span>
                                Member
                            </span>

                        </div>


                        <div class="ikapi-main">

                            <div class="ikapi-logo-box">

                                <img
                                    src="{{ asset('img/IKAPI.jpg') }}"
                                    alt="Logo IKAPI"
                                    class="ikapi-logo"
                                    loading="eager"
                                    onerror="this.style.display='none';"
                                >

                            </div>


                            <div class="ikapi-info">

                                <span class="ikapi-member-label">
                                    Member of
                                </span>

                                <strong class="ikapi-name">
                                    IKAPI
                                </strong>

                                <p class="ikapi-full-name">
                                    Ikatan Penerbit Indonesia
                                </p>

                            </div>

                        </div>


                        {{-- NOMOR ANGGOTA --}}
                        <div
                            class="ikapi-member-number {{ $ikapiMemberNumber ? '' : 'is-pending' }}"
                        >

                            <div class="ikapi-member-number-copy">

                                <span class="ikapi-member-number-label">
                                    Nomor Anggota IKAPI
                                </span>

                                <strong>
                                    {{ $ikapiMemberNumber ?: 'Nomor anggota akan diperbarui' }}
                                </strong>

                            </div>


                            <span class="ikapi-member-number-icon">

                                <svg viewBox="0 0 24 24">
                                    <path d="M5 4h14v16H5z"/>
                                    <path d="M8 8h8M8 12h5M8 16h6"/>
                                </svg>

                            </span>

                        </div>


                        {{-- DOKUMEN IKAPI --}}
                        @if($ikapiDocuments->isNotEmpty())

                            <div class="ikapi-documents">

                                <div class="ikapi-documents-head">

                                    <strong>
                                        Dokumen Keanggotaan
                                    </strong>

                                    <span>
                                        Klik untuk melihat
                                    </span>

                                </div>


                                <div class="ikapi-document-grid">

                                    @foreach($ikapiDocuments as $index => $document)

                                        <button
                                            type="button"
                                            class="ikapi-document-card"
                                            data-ikapi-open="{{ $index }}"
                                            aria-controls="ikapi-document-{{ $index }}"
                                            aria-label="Lihat {{ $document['title'] }}"
                                        >

                                            <span class="ikapi-document-thumb">

                                                <img
                                                    src="{{ asset($document['image']) }}"
                                                    alt="{{ $document['title'] }} Baca Dulu Publisher"
                                                    loading="lazy"
                                                >

                                                <span class="ikapi-document-zoom">

                                                    <svg viewBox="0 0 24 24">
                                                        <circle cx="11" cy="11" r="6"/>
                                                        <path d="m16 16 4 4"/>
                                                        <path d="M11 8v6M8 11h6"/>
                                                    </svg>

                                                </span>

                                            </span>


                                            <span class="ikapi-document-copy">

                                                <strong>
                                                    {{ $document['title'] }}
                                                </strong>

                                                <span>
                                                    {{ $document['description'] }}
                                                </span>

                                                <span class="ikapi-document-action">

                                                    Lihat dokumen

                                                    <svg viewBox="0 0 24 24">
                                                        <path d="M5 12h14"/>
                                                        <path d="m14 7 5 5-5 5"/>
                                                    </svg>

                                                </span>

                                            </span>

                                        </button>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </article>

                </div>
            </div>

        </div>

    </section>


    {{-- =====================================================
         TERBITAN TERBARU
    ====================================================== --}}

    @if($books->currentPage() === 1)

        <section
            class="store-section"
            data-motion-section
        >

            <div class="store-wrap">

                <div
                    class="motion-divider"
                    data-motion-divider
                >
                    <span></span>
                </div>


                <div class="section-head">

                    <div>

                        <h2>

                            <span class="section-tag"></span>

                            Terbitan terbaru

                        </h2>


                        <p>
                            Lima buku terbaru dari penerbit rekan kami
                        </p>

                    </div>


                    <div class="latest-controls">

                        <button
                            type="button"
                            class="latest-arrow"
                            id="latestPrev"
                            aria-label="Buku sebelumnya"
                        >

                            <svg viewBox="0 0 24 24">

                                <path
                                    class="motion-draw"
                                    d="M15 18l-6-6 6-6"
                                />

                            </svg>

                        </button>


                        <button
                            type="button"
                            class="latest-arrow"
                            id="latestNext"
                            aria-label="Buku berikutnya"
                        >

                            <svg viewBox="0 0 24 24">

                                <path
                                    class="motion-draw"
                                    d="M9 6l6 6-6 6"
                                />

                            </svg>

                        </button>

                    </div>

                </div>


                <div class="latest-viewport">

                    <div
                        class="latest-slider"
                        id="latestSlider"
                    >

                        @forelse($latestBooks as $book)

                            <div class="latest-slide">

                                @include('landing-page.pages.partisials', ['book' => $book])

                            </div>

                        @empty

                            <div class="empty-state">
                                Belum ada buku tersedia.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
         KATALOG
    ====================================================== --}}

    <section
        id="catalog"
        class="store-section catalog-section"
        data-motion-section
    >

        <div class="store-wrap">

            <div
                class="motion-divider"
                data-motion-divider
            >
                <span></span>
            </div>


            <div class="section-head">

                <div>

                    <h2>

                        <span class="section-tag"></span>

                        Katalog lengkap

                    </h2>


                    <p>
                        Maksimal 5 judul ditampilkan pada setiap halaman.
                    </p>

                </div>

            </div>


            <div class="filter-row">

                <a
                    href="{{ route('portofolio.bookstore') }}#catalog"
                    class="category-chip {{ $selectedCategory === 'Semua' ? 'active' : '' }}"
                >
                    Semua
                </a>


                @foreach($categories as $category)

                    <a
                        href="{{ route('portofolio.bookstore', ['category' => $category]) }}#catalog"
                        class="category-chip {{ $selectedCategory === $category ? 'active' : '' }}"
                    >
                        {{ $category }}
                    </a>

                @endforeach

            </div>


            <div
                class="catalog-grid"
                id="catalogGrid"
            >

                @forelse($books as $book)

                    <div class="catalog-item">

                        @include('landing-page.pages.partisials', ['book' => $book])

                    </div>

                @empty

                    <div class="empty-state">
                        Tidak ada buku pada kategori ini.
                    </div>

                @endforelse

            </div>


            @if($books->hasPages())

                @php
                    $startPage = max(1, $books->currentPage() - 2);
                    $endPage = min($books->lastPage(), $books->currentPage() + 2);
                @endphp


                <nav
                    class="store-pagination"
                    aria-label="Navigasi katalog buku"
                >

                    @if($books->onFirstPage())

                        <span class="disabled">
                            ‹
                        </span>

                    @else

                        <a
                            href="{{ $books->previousPageUrl() }}#catalog"
                            aria-label="Halaman sebelumnya"
                        >
                            ‹
                        </a>

                    @endif


                    @if($startPage > 1)

                        <a href="{{ $books->url(1) }}#catalog">
                            1
                        </a>


                        @if($startPage > 2)

                            <span class="disabled">
                                ...
                            </span>

                        @endif

                    @endif


                    @for($page = $startPage; $page <= $endPage; $page++)

                        @if($page === $books->currentPage())

                            <span class="active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $books->url($page) }}#catalog">
                                {{ $page }}
                            </a>

                        @endif

                    @endfor


                    @if($endPage < $books->lastPage())

                        @if($endPage < $books->lastPage() - 1)

                            <span class="disabled">
                                ...
                            </span>

                        @endif


                        <a href="{{ $books->url($books->lastPage()) }}#catalog">
                            {{ $books->lastPage() }}
                        </a>

                    @endif


                    @if($books->hasMorePages())

                        <a
                            href="{{ $books->nextPageUrl() }}#catalog"
                            aria-label="Halaman berikutnya"
                        >
                            ›
                        </a>

                    @else

                        <span class="disabled">
                            ›
                        </span>

                    @endif

                </nav>

            @endif

        </div>

    </section>


    {{-- =====================================================
         CTA
    ====================================================== --}}

    <section
        class="cta-section"
        data-motion-section
    >

        <div class="store-wrap">

            <div
                class="motion-divider"
                data-motion-divider
            >
                <span></span>
            </div>


            <div class="cta-banner">

                <div>

                    <h3>
                        Penerbit atau penulis? Jual bukumu di sini.
                    </h3>


                    <p>
                        Gabung sebagai mitra penerbit dan pasarkan
                        judul-judulmu kepada pembaca Baca Dulu.
                    </p>

                </div>


                <a
                    href="https://wa.me/6285139461070"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="cta-btn"
                >
                    Kirim Naskah
                </a>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CART FAB
    ====================================================== --}}

    <button
        type="button"
        class="cart-fab"
        id="cartFab"
        aria-label="Buka keranjang"
    >

        <svg viewBox="0 0 24 24">

            <circle cx="9" cy="20" r="1"/>

            <circle cx="18" cy="20" r="1"/>

            <path
                class="motion-draw"
                d="M3 4h2l2.4 10.2a2 2 0 002 1.5h7.8a2 2 0 002-1.5L21 7H6"
            />

        </svg>


        <span
            class="cart-count hide"
            id="cartCount"
        >
            0
        </span>

    </button>


    <div
        class="cart-overlay"
        id="cartOverlay"
    ></div>


    {{-- =====================================================
         CART DRAWER
    ====================================================== --}}

    <aside
        class="cart-drawer"
        id="cartDrawer"
    >

        <div class="cart-drawer-head">

            <div class="cart-heading">

                <h3>
                    Keranjang Anda
                </h3>

                <p id="cartHeaderCount">
                    Belum ada produk
                </p>

            </div>


            <div class="cart-header-actions">

                <button
                    type="button"
                    class="clear-cart"
                    id="clearCartBtn"
                >
                    Kosongkan
                </button>


                <button
                    type="button"
                    class="cart-close"
                    id="cartClose"
                    aria-label="Tutup keranjang"
                >

                    <svg viewBox="0 0 24 24">
                        <path d="M6 6l12 12M18 6L6 18"/>
                    </svg>

                </button>

            </div>

        </div>


        <div
            class="cart-items"
            id="cartItems"
        ></div>


        <div class="cart-drawer-foot">

            <div class="cart-summary-row">

                <span>
                    Jumlah produk
                </span>

                <strong id="cartItemCount">
                    0 item
                </strong>

            </div>


            <div class="cart-total-row">

                <span>
                    Total
                </span>

                <strong id="cartTotal">
                    IDR 0,00
                </strong>

            </div>


            <button
                type="button"
                class="checkout-btn"
                id="checkoutBtn"
                disabled
            >
                Checkout via WhatsApp
            </button>


            <p class="cart-note">
                Stok, ongkir, file E-book, dan pembayaran
                akan dikonfirmasi oleh tim Baca Dulu.
            </p>

        </div>

    </aside>


    <div
        class="cart-toast"
        id="cartToast"
    ></div>


    {{-- =====================================================
         IKAPI DOCUMENT VIEWERS
    ====================================================== --}}

    @foreach($ikapiDocuments as $index => $document)

        <div
            class="ikapi-document-modal"
            id="ikapi-document-{{ $index }}"
            data-ikapi-modal="{{ $index }}"
            role="dialog"
            aria-modal="true"
            aria-hidden="true"
            aria-labelledby="ikapi-document-title-{{ $index }}"
        >

            <div class="ikapi-document-modal-card">

                <div class="ikapi-document-modal-head">

                    <div class="ikapi-document-modal-title">

                        <span>
                            Dokumen Keanggotaan
                        </span>

                        <strong id="ikapi-document-title-{{ $index }}">
                            {{ $document['title'] }}
                        </strong>

                    </div>


                    <button
                        type="button"
                        class="ikapi-document-modal-close"
                        data-ikapi-close
                        aria-label="Tutup dokumen"
                    >
                        <svg viewBox="0 0 24 24">
                            <path d="M6 6l12 12"/>
                            <path d="M18 6L6 18"/>
                        </svg>
                    </button>

                </div>


                <div class="ikapi-document-modal-view">

                    <img
                        src="{{ asset($document['image']) }}"
                        alt="{{ $document['title'] }} Baca Dulu Publisher"
                    >

                </div>


                <div class="ikapi-document-modal-foot">

                    <p>
                        Dokumen ditampilkan dalam ukuran besar agar
                        informasi pada sertifikat dapat dibaca dengan jelas.
                    </p>


                    <a
                        href="{{ asset($document['image']) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="ikapi-document-full"
                    >
                        Buka Ukuran Penuh

                        <svg viewBox="0 0 24 24">
                            <path d="M14 5h5v5"/>
                            <path d="M10 14 19 5"/>
                            <path d="M19 14v5H5V5h5"/>
                        </svg>
                    </a>

                </div>

            </div>

        </div>

    @endforeach


    <script>
    (() => {
        const initIkapiDocuments = () => {
            const page = document.querySelector('.bookstore-page');

            if (!page || page.dataset.ikapiViewerReady === '1') {
                return;
            }

            page.dataset.ikapiViewerReady = '1';

            const openButtons = page.querySelectorAll('[data-ikapi-open]');
            const modals = page.querySelectorAll('[data-ikapi-modal]');

            let activeModal = null;
            let lastTrigger = null;

            const unlockScroll = () => {
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
            };

            const lockScroll = () => {
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';
            };

            const closeModal = modal => {
                if (!modal) {
                    return;
                }

                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');

                if (activeModal === modal) {
                    activeModal = null;
                }

                unlockScroll();

                if (lastTrigger) {
                    lastTrigger.focus({ preventScroll: true });
                }
            };

            const openModal = (modal, trigger) => {
                if (!modal) {
                    return;
                }

                if (activeModal && activeModal !== modal) {
                    closeModal(activeModal);
                }

                activeModal = modal;
                lastTrigger = trigger || null;

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');

                lockScroll();

                window.requestAnimationFrame(() => {
                    modal.querySelector('[data-ikapi-close]')?.focus({
                        preventScroll: true
                    });
                });
            };

            openButtons.forEach(button => {
                button.addEventListener('click', event => {
                    event.preventDefault();

                    const index = button.dataset.ikapiOpen;
                    const modal = page.querySelector(
                        `[data-ikapi-modal="${index}"]`
                    );

                    openModal(modal, button);
                });
            });

            modals.forEach(modal => {
                modal.querySelectorAll('[data-ikapi-close]').forEach(button => {
                    button.addEventListener('click', () => {
                        closeModal(modal);
                    });
                });

                modal.addEventListener('click', event => {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            });

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && activeModal) {
                    closeModal(activeModal);
                }
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener(
                'DOMContentLoaded',
                initIkapiDocuments,
                { once: true }
            );
        } else {
            initIkapiDocuments();
        }
    })();
    </script>

</div>

@endsection