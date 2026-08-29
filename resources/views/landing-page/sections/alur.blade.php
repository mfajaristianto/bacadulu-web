@php
    $steps = [
        [
            'title' => 'Kirim Naskah',
            'desc' => 'Kirim draf lengkap naskah dalam format dokumen untuk dilakukan pemeriksaan awal.',
            'icon' => 'upload',
        ],
        [
            'title' => 'Penyuntingan & Layout',
            'desc' => 'Naskah melalui proses penyuntingan, desain sampul, dan penataan isi buku.',
            'icon' => 'edit',
        ],
        [
            'title' => 'ISBN & HAKI',
            'desc' => 'Pengurusan ISBN resmi serta perlindungan hak kekayaan intelektual sesuai kebutuhan.',
            'icon' => 'shield',
        ],
        [
            'title' => 'Cetak & Distribusi',
            'desc' => 'Buku siap dicetak dan didistribusikan dalam format fisik maupun digital.',
            'icon' => 'package',
        ],
    ];
@endphp

<section id="alur" class="bd-process-section">

    {{-- =========================================================
         DECORATION
    ========================================================== --}}
    <div class="bd-process-bg-grid" aria-hidden="true"></div>
    <div class="bd-process-glow bd-process-glow-one" aria-hidden="true"></div>
    <div class="bd-process-glow bd-process-glow-two" aria-hidden="true"></div>

    <div class="bd-process-container">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="bd-process-header" data-bd-reveal="up">

            <div class="bd-process-eyebrow">
                <span class="bd-process-eyebrow-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 12h16M14 6l6 6-6 6"
                        />
                    </svg>
                </span>

                <span>Proses Penerbitan</span>
            </div>

            <h2>
                Alur Mudah
                <span>Menerbitkan Buku</span>
            </h2>

            <p>
                Ikuti perjalanan naskah mulai dari pengiriman,
                penyuntingan, pengurusan legalitas hingga buku
                siap dicetak dan didistribusikan.
            </p>

        </header>

        {{-- =====================================================
             PROCESS STAGE
        ====================================================== --}}
        <div class="bd-process-stage">

            {{-- =================================================
                 DESKTOP PROGRESS RAIL
            ================================================== --}}
            <div class="bd-process-rail">

                <div class="bd-process-track">
                    <div class="bd-process-progress"></div>
                </div>

                <div class="bd-process-nodes">

                    @foreach($steps as $index => $step)

                        <div class="bd-process-node-wrap">

                            <div
                                class="bd-process-node"
                                data-process-node
                            >

                                <span class="bd-process-node-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <span class="bd-process-node-icon">

                                    @if($step['icon'] === 'upload')

                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 16V4"></path>
                                            <path d="M7 9l5-5 5 5"></path>
                                            <path d="M5 20h14"></path>
                                        </svg>

                                    @elseif($step['icon'] === 'edit')

                                        <svg viewBox="0 0 24 24">
                                            <path d="M4 20l4.5-1L19 8.5 15.5 5 5 15.5 4 20z"></path>
                                            <path d="M13.5 7l3.5 3.5"></path>
                                        </svg>

                                    @elseif($step['icon'] === 'shield')

                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z"></path>
                                            <path d="M9 12l2 2 4-4"></path>
                                        </svg>

                                    @else

                                        <svg viewBox="0 0 24 24">
                                            <path d="M3 7l9-4 9 4-9 4-9-4z"></path>
                                            <path d="M3 7v10l9 4 9-4V7"></path>
                                            <path d="M12 11v10"></path>
                                        </svg>

                                    @endif

                                </span>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- =================================================
                 CARDS
            ================================================== --}}
            <div class="bd-process-list">

                @foreach($steps as $index => $step)

                    <div
                        class="bd-process-item"
                        data-process-item
                    >

                        {{-- MOBILE CONNECTOR --}}
                        <div
                            class="bd-process-mobile-connector"
                            aria-hidden="true"
                        >
                            <span></span>
                        </div>

                        <article class="bd-process-card">

                            {{-- =====================================
                                 TOP
                            ====================================== --}}
                            <div class="bd-process-card-top">

                                <div class="bd-process-mobile-head">

                                    <span class="bd-process-mobile-icon">

                                        @if($step['icon'] === 'upload')

                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 16V4"></path>
                                                <path d="M7 9l5-5 5 5"></path>
                                                <path d="M5 20h14"></path>
                                            </svg>

                                        @elseif($step['icon'] === 'edit')

                                            <svg viewBox="0 0 24 24">
                                                <path d="M4 20l4.5-1L19 8.5 15.5 5 5 15.5 4 20z"></path>
                                                <path d="M13.5 7l3.5 3.5"></path>
                                            </svg>

                                        @elseif($step['icon'] === 'shield')

                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z"></path>
                                                <path d="M9 12l2 2 4-4"></path>
                                            </svg>

                                        @else

                                            <svg viewBox="0 0 24 24">
                                                <path d="M3 7l9-4 9 4-9 4-9-4z"></path>
                                                <path d="M3 7v10l9 4 9-4V7"></path>
                                                <path d="M12 11v10"></path>
                                            </svg>

                                        @endif

                                    </span>

                                    <span class="bd-process-mobile-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                </div>

                                <div class="bd-process-desktop-card-head">

                                    <span class="bd-process-status">
                                        Tahap {{ $index + 1 }}
                                    </span>

                                    <span class="bd-process-mini-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                </div>

                            </div>

                            {{-- =====================================
                                 CONTENT
                            ====================================== --}}
                            <div class="bd-process-card-content">

                                <span class="bd-process-mobile-status">
                                    Tahap {{ $index + 1 }}
                                </span>

                                <h3 class="bd-process-title">
                                    {{ $step['title'] }}
                                </h3>

                                <p class="bd-process-description">
                                    {{ $step['desc'] }}
                                </p>

                            </div>

                            {{-- =====================================
                                 CHECK
                            ====================================== --}}
                            <span class="bd-process-check">

                                <svg viewBox="0 0 24 24">
                                    <path d="M8 12l3 3 5-6"></path>
                                </svg>

                            </span>

                            {{-- DECORATIVE NUMBER --}}
                            <span
                                class="bd-process-card-watermark"
                                aria-hidden="true"
                            >
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>

                        </article>

                    </div>

                @endforeach

            </div>

            {{-- =================================================
                 DESKTOP SCROLL HINT
            ================================================== --}}
            <div class="bd-process-scroll-hint">

                <span class="bd-process-scroll-mouse">
                    <span class="bd-process-scroll-wheel"></span>
                </span>

                <div class="bd-process-scroll-copy">
                    <strong>Scroll untuk mengikuti proses</strong>
                    <small>
                        Tahap akan aktif mengikuti perjalanan scroll Anda
                    </small>
                </div>

                <svg
                    class="bd-process-scroll-arrow"
                    viewBox="0 0 24 24"
                >
                    <path d="M12 5v14"></path>
                    <path d="M7 14l5 5 5-5"></path>
                </svg>

            </div>

            {{-- =================================================
                 TOUCH INFO
            ================================================== --}}
            <div class="bd-process-touch-hint">

                <span class="bd-process-touch-dot"></span>

                <span>
                    Scroll ke bawah untuk mengikuti setiap tahap
                </span>

            </div>

        </div>

    </div>

</section>

<style>
/* ================================================================
   ROOT
================================================================ */
.bd-process-section{
    --process-navy:#241B52;
    --process-orange:#EF5843;
    --process-gold:#F7AA35;
    --process-text:#20212A;
    --process-muted:#737785;
    --process-line:#E8E9EE;

    position:relative;
    width:100%;
    max-width:100%;
    padding:96px 0 90px;
    overflow:hidden;
    background:
        linear-gradient(
            180deg,
            #FFFFFF 0%,
            #FCFBF9 100%
        );
}

.bd-process-section *,
.bd-process-section *::before,
.bd-process-section *::after{
    box-sizing:border-box;
}

.bd-process-container{
    position:relative;
    z-index:2;
    width:min(calc(100% - 48px),1280px);
    margin:0 auto;
}

/* ================================================================
   BACKGROUND
================================================================ */
.bd-process-bg-grid{
    position:absolute;
    inset:0;
    opacity:.24;
    pointer-events:none;

    background-image:
        linear-gradient(
            rgba(36,27,82,.025) 1px,
            transparent 1px
        ),
        linear-gradient(
            90deg,
            rgba(36,27,82,.025) 1px,
            transparent 1px
        );

    background-size:48px 48px;

    -webkit-mask-image:
        linear-gradient(
            180deg,
            transparent,
            #000 16%,
            #000 82%,
            transparent
        );

    mask-image:
        linear-gradient(
            180deg,
            transparent,
            #000 16%,
            #000 82%,
            transparent
        );
}

.bd-process-glow{
    position:absolute;
    border-radius:50%;
    pointer-events:none;
    filter:blur(2px);
}

.bd-process-glow-one{
    width:380px;
    height:380px;
    right:-240px;
    top:80px;

    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.10),
            transparent 68%
        );
}

.bd-process-glow-two{
    width:320px;
    height:320px;
    left:-220px;
    bottom:-100px;

    background:
        radial-gradient(
            circle,
            rgba(247,170,53,.08),
            transparent 70%
        );
}

/* ================================================================
   HEADER
================================================================ */
.bd-process-header{
    width:min(100%,740px);
    margin:0 auto 58px;
    text-align:center;
}

.bd-process-eyebrow{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;

    color:var(--process-orange);

    font-size:9px;
    line-height:1;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-process-eyebrow-icon{
    width:36px;
    height:36px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:12px;

    color:#fff;

    background:
        linear-gradient(
            135deg,
            var(--process-orange),
            #F47743
        );

    box-shadow:
        0 10px 24px rgba(239,88,67,.17);
}

.bd-process-eyebrow-icon svg{
    width:16px;
    height:16px;
}

.bd-process-header h2{
    margin:19px 0 0;

    color:var(--process-text);

    font-size:clamp(37px,4vw,56px);
    line-height:1.02;
    font-weight:850;
    letter-spacing:-.055em;
}

.bd-process-header h2 span{
    display:block;
    color:var(--process-navy);
}

.bd-process-header p{
    width:min(100%,620px);
    margin:19px auto 0;

    color:var(--process-muted);

    font-size:12px;
    line-height:1.75;
}

/* ================================================================
   STAGE
================================================================ */
.bd-process-stage{
    position:relative;
    width:100%;
}

/* ================================================================
   DESKTOP RAIL
================================================================ */
.bd-process-rail{
    position:relative;
    display:none;
    padding:12px 0 0;
    margin-bottom:30px;
}

.bd-process-track{
    position:absolute;
    z-index:1;

    top:44px;
    left:12.5%;
    right:12.5%;

    height:3px;

    overflow:hidden;

    border-radius:999px;

    background:#E9E9EE;
}

.bd-process-progress{
    position:absolute;
    inset:0;

    transform:scaleX(0);
    transform-origin:left center;

    border-radius:999px;

    background:
        linear-gradient(
            90deg,
            var(--process-orange),
            var(--process-gold)
        );

    box-shadow:
        0 0 20px rgba(239,88,67,.22);

    will-change:transform;
}

.bd-process-nodes{
    position:relative;
    z-index:2;

    display:grid;
    grid-template-columns:
        repeat(4,minmax(0,1fr));
}

.bd-process-node-wrap{
    display:flex;
    justify-content:center;
}

.bd-process-node{
    position:relative;
    width:70px;
    height:70px;
}

.bd-process-node-icon{
    width:70px;
    height:70px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:2px solid #F2C8BC;
    border-radius:22px;

    color:var(--process-orange);

    background:#FFF8F5;

    box-shadow:
        0 8px 20px rgba(25,21,54,.04),
        0 0 0 7px #fff;

    transition:
        color .3s ease,
        background .3s ease,
        border-color .3s ease,
        box-shadow .3s ease,
        transform .3s ease;
}

.bd-process-node-icon svg{
    width:28px;
    height:28px;

    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-process-node-number{
    position:absolute;
    z-index:3;

    top:-9px;
    right:-12px;

    min-width:31px;
    height:31px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 6px;

    border:2px solid #fff;
    border-radius:999px;

    color:#C84735;

    background:#FFECE7;

    font-size:9px;
    line-height:1;
    font-weight:900;

    box-shadow:
        0 5px 15px rgba(36,27,82,.09);

    transition:
        color .3s ease,
        background .3s ease,
        transform .3s ease;
}

.bd-process-node.is-active
.bd-process-node-icon{
    color:#fff;
    border-color:var(--process-orange);

    background:
        linear-gradient(
            135deg,
            var(--process-orange),
            #F27743
        );

    transform:scale(1.08);

    box-shadow:
        0 15px 32px rgba(239,88,67,.25),
        0 0 0 7px #fff;
}

.bd-process-node.is-active
.bd-process-node-number{
    color:#fff;
    background:var(--process-orange);
    transform:scale(1.08);
}

.bd-process-node.is-complete
.bd-process-node-icon{
    color:#fff;
    border-color:var(--process-navy);
    background:var(--process-navy);
}

.bd-process-node.is-complete
.bd-process-node-number{
    color:#fff;
    background:var(--process-navy);
}

/* ================================================================
   CARD LIST
================================================================ */
.bd-process-list{
    position:relative;

    display:grid;

    grid-template-columns:
        repeat(4,minmax(0,1fr));

    gap:20px;
}

.bd-process-item{
    position:relative;
    min-width:0;

    opacity:.48;

    transform:
        translateY(12px)
        scale(.985);

    transition:
        opacity .35s ease,
        transform .35s ease;
}

.bd-process-card{
    position:relative;

    width:100%;
    height:100%;
    min-height:250px;

    padding:26px;

    overflow:hidden;

    border:1px solid #E8E9EE;
    border-radius:22px;

    background:
        linear-gradient(
            145deg,
            #fff 0%,
            #FBFBFC 100%
        );

    box-shadow:
        0 7px 25px rgba(36,27,82,.035);

    transition:
        border-color .35s ease,
        box-shadow .35s ease,
        background .35s ease;
}

.bd-process-card::before{
    content:"";

    position:absolute;

    width:180px;
    height:180px;

    right:-110px;
    bottom:-115px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.12),
            transparent 68%
        );

    pointer-events:none;
}

.bd-process-card::after{
    content:"";

    position:absolute;

    left:0;
    top:0;
    bottom:0;

    width:3px;

    border-radius:3px;

    background:
        linear-gradient(
            180deg,
            var(--process-orange),
            var(--process-gold)
        );

    transform:scaleY(0);
    transform-origin:top;

    opacity:0;

    transition:
        transform .35s ease,
        opacity .35s ease;
}

/* ================================================================
   CARD ACTIVE
================================================================ */
.bd-process-item.is-active{
    opacity:1;

    transform:
        translateY(-5px)
        scale(1);
}

.bd-process-item.is-active
.bd-process-card{
    border-color:
        rgba(239,88,67,.30);

    background:#fff;

    box-shadow:
        0 20px 45px rgba(36,27,82,.10);
}

.bd-process-item.is-active
.bd-process-card::after{
    opacity:1;
    transform:scaleY(1);
}

.bd-process-item.is-complete{
    opacity:.84;

    transform:
        translateY(0)
        scale(1);
}

.bd-process-item.is-complete
.bd-process-card{
    border-color:
        rgba(36,27,82,.13);

    box-shadow:
        0 10px 28px rgba(36,27,82,.055);
}

/* ================================================================
   CARD TOP
================================================================ */
.bd-process-card-top{
    position:relative;
    z-index:3;
}

.bd-process-mobile-head{
    display:none;
}

.bd-process-desktop-card-head{
    display:flex;
    align-items:center;
    justify-content:space-between;

    margin-bottom:20px;
}

.bd-process-status{
    width:max-content;

    padding:6px 10px;

    border-radius:999px;

    color:#C84735;

    background:#FFF0EB;

    font-size:8px;
    line-height:1;
    font-weight:850;

    letter-spacing:.07em;
    text-transform:uppercase;
}

.bd-process-mini-number{
    color:#D7D9E1;

    font-size:29px;
    line-height:1;
    font-weight:900;

    letter-spacing:-.07em;

    transition:
        color .3s ease;
}

.bd-process-item.is-active
.bd-process-mini-number{
    color:var(--process-orange);
}

.bd-process-item.is-complete
.bd-process-mini-number{
    color:var(--process-navy);
}

/* ================================================================
   CONTENT
================================================================ */
.bd-process-card-content{
    position:relative;
    z-index:3;
}

.bd-process-mobile-status{
    display:none;
}

.bd-process-title{
    margin:0;

    color:#252631;

    font-size:18px;
    line-height:1.3;
    font-weight:820;

    letter-spacing:-.025em;
}

.bd-process-description{
    max-width:95%;
    margin:11px 0 0;

    color:#747784;

    font-size:11px;
    line-height:1.72;
}

/* ================================================================
   CHECK
================================================================ */
.bd-process-check{
    position:absolute;
    z-index:4;

    right:20px;
    bottom:20px;

    width:29px;
    height:29px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:50%;

    color:#fff;

    background:
        linear-gradient(
            135deg,
            var(--process-orange),
            var(--process-gold)
        );

    opacity:.13;
    transform:scale(.72);

    box-shadow:
        0 7px 18px rgba(239,88,67,.15);

    transition:
        opacity .3s ease,
        transform .3s ease;
}

.bd-process-check svg{
    width:14px;
    height:14px;

    fill:none;
    stroke:currentColor;
    stroke-width:2.4;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-process-item.is-active
.bd-process-check,
.bd-process-item.is-complete
.bd-process-check{
    opacity:1;
    transform:scale(1);
}

/* ================================================================
   WATERMARK
================================================================ */
.bd-process-card-watermark{
    position:absolute;

    right:-4px;
    bottom:-12px;

    color:rgba(36,27,82,.025);

    font-size:82px;
    line-height:1;
    font-weight:900;

    letter-spacing:-.09em;

    pointer-events:none;
}

/* ================================================================
   MOBILE CONNECTOR
================================================================ */
.bd-process-mobile-connector{
    display:none;
}

/* ================================================================
   DESKTOP HINT
================================================================ */
.bd-process-scroll-hint{
    display:none;

    width:max-content;

    margin:34px auto 0;

    padding:11px 17px 11px 12px;

    align-items:center;

    gap:12px;

    border:1px solid rgba(239,88,67,.20);
    border-radius:999px;

    color:#C84735;

    background:rgba(255,247,244,.94);

    box-shadow:
        0 10px 28px rgba(239,88,67,.075);

    backdrop-filter:blur(10px);

    animation:
        bdProcessHintFloat
        2.6s ease-in-out infinite;
}

.bd-process-scroll-copy{
    display:flex;
    flex-direction:column;
    gap:2px;
}

.bd-process-scroll-copy strong{
    color:#C84735;

    font-size:9px;
    line-height:1.2;
    font-weight:850;

    letter-spacing:.07em;
    text-transform:uppercase;
}

.bd-process-scroll-copy small{
    color:#9A7368;

    font-size:8px;
    line-height:1.3;
}

.bd-process-scroll-mouse{
    position:relative;

    width:25px;
    height:35px;

    flex:0 0 auto;

    border:2px solid
        rgba(239,88,67,.44);

    border-radius:999px;
}

.bd-process-scroll-wheel{
    position:absolute;

    top:7px;
    left:50%;

    width:3px;
    height:7px;

    border-radius:999px;

    background:var(--process-orange);

    transform:translateX(-50%);

    animation:
        bdProcessWheel
        1.45s ease-in-out infinite;
}

.bd-process-scroll-arrow{
    width:18px;
    height:18px;

    flex:0 0 auto;

    fill:none;
    stroke:var(--process-orange);
    stroke-width:1.9;
    stroke-linecap:round;
    stroke-linejoin:round;

    animation:
        bdProcessArrow
        1.45s ease-in-out infinite;
}

/* ================================================================
   TOUCH HINT
================================================================ */
.bd-process-touch-hint{
    display:none;

    align-items:center;
    justify-content:center;
    gap:8px;

    margin-top:26px;

    color:#92949D;

    font-size:8px;
    font-weight:650;
}

.bd-process-touch-dot{
    width:6px;
    height:6px;

    border-radius:50%;

    background:var(--process-orange);

    box-shadow:
        0 0 0 5px rgba(239,88,67,.08);
}

/* ================================================================
   ANIMATIONS
================================================================ */
@keyframes bdProcessWheel{
    0%{
        opacity:0;
        transform:translate(-50%,0);
    }

    25%{
        opacity:1;
    }

    70%{
        opacity:1;
    }

    100%{
        opacity:0;
        transform:translate(-50%,9px);
    }
}

@keyframes bdProcessArrow{
    0%,
    100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(5px);
    }
}

@keyframes bdProcessHintFloat{
    0%,
    100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(4px);
    }
}

/* ================================================================
   REAL DESKTOP
   BUKAN CUMA VIEWPORT BESAR
================================================================ */
@media
(min-width:1024px)
and (hover:hover)
and (pointer:fine){

    .bd-process-rail{
        display:block;
    }

    .bd-process-scroll-hint{
        display:flex;
    }

    .bd-process-touch-hint{
        display:none;
    }
}

/* ================================================================
   TOUCH / TABLET

   Ini juga menangani HP yang memakai Desktop Site.
================================================================ */
@media
(max-width:1023px),
(hover:none),
(pointer:coarse){

    .bd-process-section{
        padding-top:82px;
        padding-bottom:82px;
    }

    .bd-process-stage{
        height:auto!important;
        min-height:0!important;
        transform:none!important;
    }

    .bd-process-rail{
        display:none!important;
    }

    .bd-process-scroll-hint{
        display:none!important;
    }

    .bd-process-touch-hint{
        display:flex;
    }

    .bd-process-list{
        grid-template-columns:
            repeat(2,minmax(0,1fr));

        gap:16px;
    }

    .bd-process-item{
        opacity:1;
        transform:none;
    }

    .bd-process-card{
        min-height:235px;
    }

    .bd-process-desktop-card-head{
        display:none;
    }

    .bd-process-mobile-head{
        display:flex;
        align-items:center;
        justify-content:space-between;

        margin-bottom:20px;
    }

    .bd-process-mobile-icon{
        width:52px;
        height:52px;

        display:flex;
        align-items:center;
        justify-content:center;

        border:1px solid
            rgba(239,88,67,.13);

        border-radius:16px;

        color:var(--process-orange);

        background:#FFF4EF;

        transition:
            color .3s ease,
            background .3s ease,
            transform .3s ease,
            box-shadow .3s ease;
    }

    .bd-process-mobile-icon svg{
        width:24px;
        height:24px;

        fill:none;
        stroke:currentColor;
        stroke-width:1.9;
        stroke-linecap:round;
        stroke-linejoin:round;
    }

    .bd-process-mobile-number{
        color:#D7D9E1;

        font-size:36px;
        line-height:1;
        font-weight:900;

        letter-spacing:-.08em;

        transition:
            color .3s ease;
    }

    .bd-process-mobile-status{
        display:inline-flex;

        margin-bottom:11px;

        color:#A0A2AB;

        font-size:7px;
        line-height:1;
        font-weight:800;

        letter-spacing:.1em;
        text-transform:uppercase;
    }

    .bd-process-item.is-active
    .bd-process-mobile-icon{
        color:#fff;

        background:
            linear-gradient(
                135deg,
                var(--process-orange),
                #F37843
            );

        transform:scale(1.05);

        box-shadow:
            0 12px 26px rgba(239,88,67,.20);
    }

    .bd-process-item.is-active
    .bd-process-mobile-number{
        color:var(--process-orange);
    }

    .bd-process-item.is-complete
    .bd-process-mobile-icon{
        color:#fff;
        background:var(--process-navy);
    }

    .bd-process-item.is-complete
    .bd-process-mobile-number{
        color:var(--process-navy);
    }
}

/* ================================================================
   PHONE
================================================================ */
@media(max-width:767px){

    .bd-process-section{
        padding:66px 0;
    }

    .bd-process-container{
        width:100%;
        padding-left:17px;
        padding-right:17px;
    }

    .bd-process-header{
        width:100%;
        margin-bottom:38px;
        text-align:left;
    }

    .bd-process-eyebrow{
        justify-content:flex-start;
        font-size:8px;
    }

    .bd-process-eyebrow-icon{
        width:34px;
        height:34px;
        border-radius:11px;
    }

    .bd-process-header h2{
        max-width:340px;

        margin-top:16px;

        font-size:38px;
        line-height:1.02;

        letter-spacing:-.052em;
    }

    .bd-process-header p{
        max-width:350px;

        margin:15px 0 0;

        font-size:10.5px;
        line-height:1.7;
    }

    .bd-process-list{
        display:block;
    }

    .bd-process-item{
        position:relative;

        width:100%;

        padding-left:31px;

        margin-bottom:14px;
    }

    .bd-process-item:last-child{
        margin-bottom:0;
    }

    /* VERTICAL LINE */
    .bd-process-mobile-connector{
        position:absolute;
        z-index:0;

        display:block;

        left:8px;
        top:0;
        bottom:-14px;

        width:2px;

        background:#E9E7EA;
    }

    .bd-process-item:last-child
    .bd-process-mobile-connector{
        bottom:50%;
    }

    .bd-process-mobile-connector::before{
        content:"";

        position:absolute;

        top:37px;
        left:50%;

        width:11px;
        height:11px;

        border:3px solid #fff;
        border-radius:50%;

        background:#D7D8DE;

        transform:translateX(-50%);

        box-shadow:
            0 0 0 1px #D7D8DE;

        transition:
            background .3s ease,
            box-shadow .3s ease,
            transform .3s ease;
    }

    .bd-process-mobile-connector span{
        position:absolute;

        left:0;
        top:0;

        width:100%;
        height:0;

        background:
            linear-gradient(
                180deg,
                var(--process-orange),
                var(--process-gold)
            );

        transition:
            height .4s ease;
    }

    .bd-process-item.is-active
    .bd-process-mobile-connector::before{
        background:var(--process-orange);

        box-shadow:
            0 0 0 1px var(--process-orange),
            0 0 0 5px rgba(239,88,67,.09);

        transform:
            translateX(-50%)
            scale(1.06);
    }

    .bd-process-item.is-complete
    .bd-process-mobile-connector::before{
        background:var(--process-navy);

        box-shadow:
            0 0 0 1px var(--process-navy);
    }

    .bd-process-item.is-active
    .bd-process-mobile-connector span,
    .bd-process-item.is-complete
    .bd-process-mobile-connector span{
        height:100%;
    }

    .bd-process-card{
        min-height:0;

        padding:20px;

        border-radius:18px;

        box-shadow:
            0 8px 24px rgba(36,27,82,.04);
    }

    .bd-process-mobile-head{
        margin-bottom:17px;
    }

    .bd-process-mobile-icon{
        width:47px;
        height:47px;

        border-radius:14px;
    }

    .bd-process-mobile-icon svg{
        width:22px;
        height:22px;
    }

    .bd-process-mobile-number{
        font-size:31px;
    }

    .bd-process-mobile-status{
        margin-bottom:9px;
    }

    .bd-process-title{
        font-size:18px;
        line-height:1.25;
    }

    .bd-process-description{
        max-width:calc(100% - 25px);

        margin-top:9px;

        font-size:10.5px;
        line-height:1.65;
    }

    .bd-process-check{
        right:17px;
        bottom:17px;

        width:27px;
        height:27px;
    }

    .bd-process-card-watermark{
        right:-1px;
        bottom:-8px;

        font-size:68px;
    }

    .bd-process-touch-hint{
        justify-content:flex-start;

        padding-left:31px;

        margin-top:25px;
    }
}

/* ================================================================
   SMALL PHONE
================================================================ */
@media(max-width:390px){

    .bd-process-container{
        padding-left:14px;
        padding-right:14px;
    }

    .bd-process-header h2{
        font-size:34px;
    }

    .bd-process-item{
        padding-left:28px;
    }

    .bd-process-card{
        padding:18px;
    }

    .bd-process-description{
        max-width:100%;
    }
}

/* ================================================================
   REDUCED MOTION
================================================================ */
@media(prefers-reduced-motion:reduce){

    .bd-process-scroll-hint,
    .bd-process-scroll-wheel,
    .bd-process-scroll-arrow{
        animation:none!important;
    }

    .bd-process-item,
    .bd-process-card,
    .bd-process-node-icon,
    .bd-process-node-number{
        transition:none!important;
    }
}
</style>