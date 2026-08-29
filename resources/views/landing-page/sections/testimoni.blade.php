@php
    $testimoniItems = [
        [
            'image' => asset('img/Bentara.jpg'),
            'name' => 'Bentara Campus',
            'label' => 'Kolaborasi Pendidikan',
            'alt' => 'Dokumentasi Bentara Campus',
        ],
        [
            'image' => asset('img/Bina.jpg'),
            'name' => 'Bina Cendikia',
            'label' => 'Kolaborasi Penerbitan',
            'alt' => 'Dokumentasi Bina Cendikia',
        ],
        [
            'image' => asset('img/Fdi.jpg'),
            'name' => 'FDI Partners',
            'label' => 'Kolaborasi Profesional',
            'alt' => 'Dokumentasi FDI Partners',
        ],
        [
            'image' => asset('img/Kadin.jpg'),
            'name' => 'KADIN',
            'label' => 'Kolaborasi Institusi',
            'alt' => 'Dokumentasi KADIN',
        ],
        [
            'image' => asset('img/Fermartian.jpg'),
            'name' => 'Fermartian',
            'label' => 'Kolaborasi Mitra',
            'alt' => 'Dokumentasi Fermartian',
        ],
    ];
@endphp


<section id="testimoni" class="bd-testi-section">

    {{-- =========================================================
         BACKGROUND DECORATION
    ========================================================== --}}
    <div class="bd-testi-grid" aria-hidden="true"></div>

    <div class="bd-testi-glow bd-testi-glow-left" aria-hidden="true"></div>

    <div class="bd-testi-glow bd-testi-glow-right" aria-hidden="true"></div>


    <div class="bd-testi-container">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="bd-testi-header" data-bd-reveal="up">

            <div class="bd-testi-heading">

                <div class="bd-testi-eyebrow">

                    <span class="bd-testi-eyebrow-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7 17h4l2-4V7H7v10z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 17h4l2-4V7h-6v10z"
                            />
                        </svg>

                    </span>

                    <span>
                        Cerita Mitra
                    </span>

                </div>


                <h2>
                    Kepercayaan yang
                    <span>tumbuh bersama.</span>
                </h2>


                <p>
                    Dokumentasi, pengalaman, dan bentuk kepercayaan
                    dari mitra yang telah berkolaborasi bersama Baca Dulu.
                </p>

            </div>


            <div class="bd-testi-header-status">

                <div class="bd-testi-header-count">

                    <strong id="bdTestiHeaderCurrent">
                        01
                    </strong>

                    <span>/</span>

                    <span>
                        {{ str_pad(count($testimoniItems), 2, '0', STR_PAD_LEFT) }}
                    </span>

                </div>


                <div class="bd-testi-header-progress">
                    <span></span>
                </div>

            </div>

        </header>


        {{-- =====================================================
             CAROUSEL
        ====================================================== --}}
        <div class="bd-testi-showcase" data-bd-reveal="zoom">

            <div
                class="bd-testi-stage"
                id="bdTestiStage"
            >

                @foreach($testimoniItems as $index => $item)

                    <article
                        class="
                            bd-testi-card
                            {{ $index === 0 ? 'is-active' : '' }}
                        "
                        data-testi-card
                        data-index="{{ $index }}"
                    >

                        <button
                            type="button"
                            class="bd-testi-card-button"
                            data-testi-open="{{ $index }}"
                            aria-label="Lihat dokumentasi {{ $item['name'] }}"
                        >

                            <div class="bd-testi-media">

                                <img
                                    src="{{ $item['image'] }}"
                                    alt="{{ $item['alt'] }}"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    draggable="false"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                >


                                <div class="bd-testi-image-fallback">

                                    <small>
                                        Baca Dulu
                                    </small>

                                    <strong>
                                        {{ $item['name'] }}
                                    </strong>

                                </div>


                                <div class="bd-testi-media-overlay"></div>


                                {{-- TOP --}}
                                <div class="bd-testi-card-top">

                                    <span class="bd-testi-card-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>


                                    <span class="bd-testi-expand">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8 3H3v5M16 3h5v5M8 21H3v-5M16 21h5v-5"
                                            />
                                        </svg>

                                    </span>

                                </div>


                                {{-- CAPTION --}}
                                <div class="bd-testi-caption">

                                    <span>
                                        {{ $item['label'] }}
                                    </span>

                                    <strong>
                                        {{ $item['name'] }}
                                    </strong>

                                </div>

                            </div>

                        </button>

                    </article>

                @endforeach

            </div>


            {{-- =================================================
                 CONTROLS
            ================================================== --}}
            <div class="bd-testi-controls">

                <button
                    type="button"
                    id="bdTestiPrev"
                    class="bd-testi-nav"
                    aria-label="Testimoni sebelumnya"
                >

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 18l-6-6 6-6"
                        />
                    </svg>

                </button>


                <div class="bd-testi-dots">

                    @foreach($testimoniItems as $index => $item)

                        <button
                            type="button"
                            class="
                                bd-testi-dot
                                {{ $index === 0 ? 'is-active' : '' }}
                            "
                            data-testi-dot="{{ $index }}"
                            aria-label="Testimoni {{ $index + 1 }}"
                        >
                            <span></span>
                        </button>

                    @endforeach

                </div>


                <div class="bd-testi-counter">

                    <strong id="bdTestiCurrent">
                        01
                    </strong>

                    <span>
                        /
                        {{ str_pad(count($testimoniItems), 2, '0', STR_PAD_LEFT) }}
                    </span>

                </div>


                <button
                    type="button"
                    id="bdTestiNext"
                    class="
                        bd-testi-nav
                        bd-testi-nav-next
                    "
                    aria-label="Testimoni berikutnya"
                >

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 18l6-6-6-6"
                        />
                    </svg>

                </button>

            </div>


            {{-- =================================================
                 ACTIVE INFO
            ================================================== --}}
            <div class="bd-testi-info">

                <div class="bd-testi-info-number">

                    <span>
                        TESTIMONI
                    </span>

                    <strong id="bdTestiInfoNumber">
                        01
                    </strong>

                </div>


                <div class="bd-testi-info-copy">

                    <span id="bdTestiInfoLabel">
                        {{ $testimoniItems[0]['label'] }}
                    </span>

                    <h3 id="bdTestiInfoName">
                        {{ $testimoniItems[0]['name'] }}
                    </h3>

                </div>


                <div class="bd-testi-info-note">

                    <span></span>

                    <p>
                        Dokumentasi kolaborasi dan kepercayaan
                        bersama Baca Dulu.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         LIGHTBOX
    ========================================================== --}}
    <div
        class="bd-testi-lightbox"
        id="bdTestiLightbox"
        aria-hidden="true"
    >

        <button
            type="button"
            id="bdTestiLightboxClose"
            class="bd-testi-lightbox-close"
            aria-label="Tutup gambar"
        >

            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>

        </button>


        <div class="bd-testi-lightbox-content">

            <img
                id="bdTestiLightboxImage"
                src=""
                alt=""
            >

        </div>

    </div>

</section>


<style>
/* ================================================================
   ROOT
================================================================ */
.bd-testi-section{
    --navy:#241B52;
    --orange:#EF5843;
    --gold:#F7AA35;

    position:relative;

    width:100%;
    max-width:100%;

    padding:
        72px 0 68px;

    overflow:hidden;

    background:
        linear-gradient(
            180deg,
            #F5F2EC 0%,
            #F4F1EB 100%
        );

    color:#25252D;
}


.bd-testi-section *,
.bd-testi-section *::before,
.bd-testi-section *::after{
    box-sizing:border-box;
}


/* ================================================================
   FULL WIDTH BACKGROUND
================================================================ */
.bd-testi-grid{
    position:absolute;

    inset:0;

    pointer-events:none;

    opacity:.34;

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

    background-size:
        52px 52px;
}


.bd-testi-glow{
    position:absolute;

    border-radius:50%;

    pointer-events:none;
}


.bd-testi-glow-left{
    width:430px;
    height:430px;

    left:-260px;
    top:70px;

    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.11),
            transparent 68%
        );
}


.bd-testi-glow-right{
    width:480px;
    height:480px;

    right:-280px;
    bottom:-260px;

    background:
        radial-gradient(
            circle,
            rgba(247,170,53,.09),
            transparent 70%
        );
}


/* ================================================================
   CONTAINER
   Lebih lebar dibanding sebelumnya.
================================================================ */
.bd-testi-container{
    position:relative;

    z-index:2;

    width:
        min(
            calc(100% - 64px),
            1440px
        );

    margin:
        0 auto;
}


/* ================================================================
   HEADER
================================================================ */
.bd-testi-header{
    width:
        min(
            100%,
            1180px
        );

    margin:
        0 auto 26px;

    display:flex;

    align-items:flex-end;

    justify-content:
        space-between;

    gap:35px;

    padding-bottom:21px;

    border-bottom:
        1px solid
        rgba(36,27,82,.10);
}


.bd-testi-heading{
    max-width:670px;
}


.bd-testi-eyebrow{
    display:flex;

    align-items:center;

    gap:8px;

    margin-bottom:10px;

    color:
        var(--orange);

    font-size:8px;

    font-weight:850;

    letter-spacing:.15em;

    text-transform:uppercase;
}


.bd-testi-eyebrow-icon{
    width:27px;
    height:27px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:8px;

    background:
        rgba(239,88,67,.09);
}


.bd-testi-eyebrow-icon svg{
    width:13px;
    height:13px;
}


.bd-testi-heading h2{
    margin:0;

    color:
        var(--navy);

    font-size:
        clamp(
            31px,
            3.3vw,
            44px
        );

    line-height:1.04;

    font-weight:850;

    letter-spacing:-.048em;
}


.bd-testi-heading h2 span{
    color:
        var(--orange);
}


.bd-testi-heading p{
    max-width:570px;

    margin:
        11px 0 0;

    color:#777982;

    font-size:10px;

    line-height:1.7;
}


/* ================================================================
   HEADER STATUS
================================================================ */
.bd-testi-header-status{
    display:flex;

    align-items:center;

    gap:14px;

    flex:
        0 0 auto;
}


.bd-testi-header-count{
    display:flex;

    align-items:baseline;

    gap:4px;

    color:#AAA6AE;

    font-size:7px;

    font-weight:850;
}


.bd-testi-header-count strong{
    color:
        var(--orange);

    font-size:18px;
}


.bd-testi-header-progress{
    width:70px;

    height:1px;

    overflow:hidden;

    background:
        rgba(36,27,82,.12);
}


.bd-testi-header-progress span{
    display:block;

    width:34%;

    height:100%;

    background:
        var(--orange);
}


/* ================================================================
   SHOWCASE
================================================================ */
.bd-testi-showcase{
    position:relative;
}


/* ================================================================
   STAGE
================================================================ */
.bd-testi-stage{
    position:relative;

    width:100%;

    height:370px;

    overflow:hidden;

    perspective:1300px;
}


/* ================================================================
   CARD
================================================================ */
.bd-testi-card{
    --testi-x:0px;
    --testi-scale:1;
    --testi-rotate:0deg;

    position:absolute;

    left:50%;
    top:8px;

    width:310px;
    height:340px;

    opacity:0;

    visibility:hidden;

    pointer-events:none;

    transform:
        translateX(-50%)
        translateX(var(--testi-x))
        scale(var(--testi-scale))
        rotateY(var(--testi-rotate));

    transform-origin:center;

    transition:
        transform .52s
        cubic-bezier(.22,.8,.25,1),
        opacity .42s ease;

    will-change:
        transform,
        opacity;
}


.bd-testi-card.is-active{
    pointer-events:auto;
}


.bd-testi-card-button{
    width:100%;
    height:100%;

    display:block;

    padding:0;

    border:0;

    border-radius:22px;

    background:transparent;

    text-align:left;

    cursor:pointer;
}


/* ================================================================
   IMAGE
================================================================ */
.bd-testi-media{
    position:relative;

    width:100%;
    height:100%;

    overflow:hidden;

    border:
        1px solid
        rgba(36,27,82,.09);

    border-radius:22px;

    background:#fff;

    box-shadow:
        0 17px 38px
        rgba(36,27,82,.10);

    transition:
        border-color .25s ease,
        box-shadow .25s ease;
}


.bd-testi-card.is-active
.bd-testi-media{
    border-color:
        rgba(239,88,67,.20);

    box-shadow:
        0 24px 48px
        rgba(36,27,82,.14);
}


.bd-testi-media > img{
    width:100%;
    height:100%;

    display:block;

    padding:9px;

    object-fit:contain;

    object-position:center;

    background:#fff;

    border-radius:21px;

    transition:
        transform .45s ease;
}


/* ================================================================
   FALLBACK
================================================================ */
.bd-testi-image-fallback{
    position:absolute;

    inset:0;

    display:none;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    gap:8px;

    padding:20px;

    color:#fff;

    text-align:center;

    background:
        linear-gradient(
            145deg,
            #241B52,
            #332875
        );
}


.bd-testi-image-fallback small{
    color:
        var(--gold);

    font-size:7px;

    font-weight:850;

    letter-spacing:.15em;

    text-transform:uppercase;
}


.bd-testi-image-fallback strong{
    font-size:20px;
}


/* ================================================================
   OVERLAY
================================================================ */
.bd-testi-media-overlay{
    position:absolute;

    inset:0;

    pointer-events:none;

    background:
        linear-gradient(
            180deg,
            transparent 55%,
            rgba(17,12,49,.04) 68%,
            rgba(17,12,49,.82) 100%
        );
}


/* ================================================================
   CARD TOP
================================================================ */
.bd-testi-card-top{
    position:absolute;

    z-index:5;

    left:13px;
    right:13px;
    top:13px;

    display:flex;

    align-items:center;

    justify-content:
        space-between;
}


.bd-testi-card-number{
    min-width:37px;
    height:27px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:
        0 8px;

    border-radius:8px;

    color:
        var(--orange);

    background:
        rgba(255,255,255,.96);

    font-size:8px;

    font-weight:900;

    box-shadow:
        0 5px 14px
        rgba(0,0,0,.07);
}


.bd-testi-expand{
    width:30px;
    height:30px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:50%;

    color:
        var(--navy);

    background:
        rgba(255,255,255,.94);

    opacity:.86;
}


.bd-testi-expand svg{
    width:13px;
    height:13px;
}


/* ================================================================
   CAPTION
================================================================ */
.bd-testi-caption{
    position:absolute;

    z-index:5;

    left:18px;
    right:18px;
    bottom:17px;
}


.bd-testi-caption span{
    display:block;

    margin-bottom:5px;

    color:
        rgba(255,255,255,.68);

    font-size:6px;

    font-weight:850;

    letter-spacing:.14em;

    text-transform:uppercase;
}


.bd-testi-caption strong{
    display:block;

    color:#fff;

    font-size:17px;

    line-height:1.2;

    font-weight:850;

    letter-spacing:-.025em;
}


/* ================================================================
   CONTROLS
================================================================ */
.bd-testi-controls{
    width:
        min(
            100%,
            700px
        );

    margin:
        3px auto 0;

    display:grid;

    grid-template-columns:
        auto 1fr auto auto;

    align-items:center;

    gap:12px;
}


.bd-testi-nav{
    width:42px;
    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:0;

    border:
        1px solid
        rgba(36,27,82,.13);

    border-radius:12px;

    color:
        var(--navy);

    background:#fff;

    cursor:pointer;

    transition:
        transform .2s ease,
        background .2s ease,
        color .2s ease,
        border-color .2s ease;
}


.bd-testi-nav-next{
    color:#fff;

    border-color:
        var(--navy);

    background:
        var(--navy);
}


.bd-testi-nav svg{
    width:14px;
    height:14px;
}


/* ================================================================
   DOTS
================================================================ */
.bd-testi-dots{
    display:flex;

    align-items:center;

    justify-content:center;

    gap:4px;
}


.bd-testi-dot{
    width:22px;
    height:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:0;

    border:0;

    background:transparent;

    cursor:pointer;
}


.bd-testi-dot span{
    width:13px;
    height:2px;

    display:block;

    border-radius:999px;

    background:
        rgba(36,27,82,.18);

    transition:
        width .25s ease,
        background .25s ease;
}


.bd-testi-dot.is-active span{
    width:22px;

    background:
        var(--orange);
}


/* ================================================================
   COUNTER
================================================================ */
.bd-testi-counter{
    min-width:54px;

    display:flex;

    align-items:baseline;

    justify-content:center;

    gap:4px;

    color:#AAA7AE;

    font-size:7px;

    font-weight:850;
}


.bd-testi-counter strong{
    color:
        var(--orange);

    font-size:15px;
}


/* ================================================================
   INFO
================================================================ */
.bd-testi-info{
    width:
        min(
            100%,
            820px
        );

    margin:
        20px auto 0;

    display:grid;

    grid-template-columns:
        74px
        minmax(0,1fr)
        minmax(200px,.72fr);

    align-items:center;

    gap:20px;

    padding:
        14px 17px;

    border:
        1px solid
        rgba(36,27,82,.08);

    border-radius:16px;

    background:
        rgba(255,255,255,.66);

    box-shadow:
        0 9px 25px
        rgba(36,27,82,.035);
}


.bd-testi-info-number{
    min-height:50px;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    gap:2px;

    border:
        1px solid
        rgba(36,27,82,.07);

    border-radius:11px;

    background:#fff;
}


.bd-testi-info-number span{
    color:#AAA6AE;

    font-size:5px;

    font-weight:850;

    letter-spacing:.12em;
}


.bd-testi-info-number strong{
    color:
        var(--orange);

    font-size:17px;
}


.bd-testi-info-copy{
    min-width:0;
}


.bd-testi-info-copy > span{
    display:block;

    color:
        var(--orange);

    font-size:6px;

    font-weight:850;

    letter-spacing:.12em;

    text-transform:uppercase;
}


.bd-testi-info-copy h3{
    margin:
        4px 0 0;

    color:
        var(--navy);

    font-size:19px;

    line-height:1.15;

    font-weight:850;

    letter-spacing:-.03em;

    overflow-wrap:anywhere;
}


.bd-testi-info-note{
    min-width:0;

    display:flex;

    align-items:flex-start;

    gap:8px;

    padding-left:18px;

    border-left:
        1px solid
        rgba(36,27,82,.08);
}


.bd-testi-info-note > span{
    width:5px;
    height:5px;

    flex:
        0 0 auto;

    margin-top:4px;

    border-radius:50%;

    background:
        var(--orange);
}


.bd-testi-info-note p{
    margin:0;

    color:#89868F;

    font-size:7px;

    line-height:1.55;
}


/* ================================================================
   DESKTOP HOVER
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-testi-card.is-active:hover
.bd-testi-media > img{
    transform:
        scale(1.018);
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-testi-nav:hover{
    transform:
        translateY(-2px);

    border-color:
        rgba(239,88,67,.4);
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-testi-nav-next:hover{
    color:#fff;

    border-color:
        var(--orange);

    background:
        var(--orange);
}


/* ================================================================
   LARGE DESKTOP
================================================================ */
@media(min-width:1500px){

    html[data-baca-device="desktop"]
    .bd-testi-container{
        width:
            min(
                calc(100% - 80px),
                1440px
            );
    }

}


/* ================================================================
   LAPTOP KECIL
================================================================ */
@media(
    min-width:1024px
)
and
(
    max-width:1199px
){

    html[data-baca-device="desktop"]
    .bd-testi-section{
        padding:
            65px 0 62px;
    }


    html[data-baca-device="desktop"]
    .bd-testi-container{
        width:
            calc(100% - 42px);
    }


    html[data-baca-device="desktop"]
    .bd-testi-stage{
        height:350px;
    }


    html[data-baca-device="desktop"]
    .bd-testi-card{
        width:290px;

        height:320px;
    }

}


/* ================================================================
   TABLET
================================================================ */
html[data-baca-device="tablet"]
.bd-testi-section{
    padding:
        66px 0 62px;
}


html[data-baca-device="tablet"]
.bd-testi-container{
    width:100%;

    padding:
        0 24px;
}


html[data-baca-device="tablet"]
.bd-testi-header{
    width:100%;
}


html[data-baca-device="tablet"]
.bd-testi-heading h2{
    font-size:
        clamp(
            32px,
            5vw,
            40px
        );
}


html[data-baca-device="tablet"]
.bd-testi-stage{
    height:340px;
}


html[data-baca-device="tablet"]
.bd-testi-card{
    width:275px;
    height:310px;
}


html[data-baca-device="tablet"]
.bd-testi-info{
    grid-template-columns:
        68px
        minmax(0,1fr);
}


html[data-baca-device="tablet"]
.bd-testi-info-note{
    grid-column:2;

    padding:
        10px 0 0;

    border-left:0;

    border-top:
        1px solid
        rgba(36,27,82,.08);
}


/* ================================================================
   PHONE / HP+
================================================================ */
html[data-baca-device="phone"]
.bd-testi-section{
    padding:
        58px 0 56px;
}


html[data-baca-device="phone"]
.bd-testi-container{
    width:100%;

    padding:
        0 16px;
}


/* HEADER */
html[data-baca-device="phone"]
.bd-testi-header{
    width:100%;

    flex-direction:column;

    align-items:flex-start;

    gap:14px;

    margin-bottom:20px;

    padding-bottom:17px;
}


html[data-baca-device="phone"]
.bd-testi-heading{
    width:100%;
}


html[data-baca-device="phone"]
.bd-testi-heading h2{
    max-width:360px;

    font-size:
        clamp(
            31px,
            8.8vw,
            39px
        );
}


html[data-baca-device="phone"]
.bd-testi-heading p{
    max-width:370px;

    font-size:9.5px;
}


html[data-baca-device="phone"]
.bd-testi-header-status{
    width:100%;

    justify-content:
        space-between;
}


/* ================================================================
   PHONE STAGE = NATIVE SWIPE
================================================================ */
html[data-baca-device="phone"]
.bd-testi-stage{
    width:
        calc(100% + 16px);

    height:auto;

    display:flex;

    gap:12px;

    margin-right:-16px;

    padding:
        3px 16px
        15px 0;

    overflow-x:auto;

    overflow-y:hidden;

    perspective:none;

    scroll-snap-type:
        x mandatory;

    scrollbar-width:none;

    -webkit-overflow-scrolling:
        touch;

    overscroll-behavior-x:
        contain;
}


html[data-baca-device="phone"]
.bd-testi-stage::-webkit-scrollbar{
    display:none;
}


html[data-baca-device="phone"]
.bd-testi-card{
    position:relative!important;

    left:auto!important;

    top:auto!important;

    flex:
        0 0 min(
            76vw,
            285px
        );

    width:
        min(
            76vw,
            285px
        );

    height:
        min(
            88vw,
            330px
        );

    transform:none!important;

    opacity:1!important;

    visibility:visible!important;

    pointer-events:auto!important;

    scroll-snap-align:start;

    scroll-snap-stop:always;
}


html[data-baca-device="phone"]
.bd-testi-card-button,
html[data-baca-device="phone"]
.bd-testi-media{
    border-radius:19px;
}


html[data-baca-device="phone"]
.bd-testi-media > img{
    border-radius:18px;
}


html[data-baca-device="phone"]
.bd-testi-caption strong{
    font-size:15px;
}


/* CONTROLS */
html[data-baca-device="phone"]
.bd-testi-controls{
    width:100%;

    grid-template-columns:
        1fr auto auto;

    gap:9px;

    margin-top:3px;
}


html[data-baca-device="phone"]
.bd-testi-dots{
    display:none;
}


html[data-baca-device="phone"]
.bd-testi-counter{
    justify-content:flex-start;

    margin-right:auto;
}


html[data-baca-device="phone"]
.bd-testi-nav{
    width:44px;
    height:44px;
}


/* INFO */
html[data-baca-device="phone"]
.bd-testi-info{
    width:100%;

    grid-template-columns:1fr;

    gap:10px;

    margin-top:18px;

    padding:14px;
}


html[data-baca-device="phone"]
.bd-testi-info-number{
    width:max-content;

    min-width:65px;

    min-height:38px;

    flex-direction:row;

    gap:5px;

    padding:
        0 9px;
}


html[data-baca-device="phone"]
.bd-testi-info-copy h3{
    font-size:18px;
}


html[data-baca-device="phone"]
.bd-testi-info-note{
    grid-column:auto;

    padding:
        10px 0 0;

    border-left:0;

    border-top:
        1px solid
        rgba(36,27,82,.08);
}


/* ================================================================
   SMALL PHONE
================================================================ */
@media(max-width:390px){

    html[data-baca-device="phone"]
    .bd-testi-container{
        padding:
            0 14px;
    }


    html[data-baca-device="phone"]
    .bd-testi-stage{
        width:
            calc(100% + 14px);

        margin-right:-14px;

        padding-right:14px;
    }


    html[data-baca-device="phone"]
    .bd-testi-card{
        flex-basis:
            min(
                78vw,
                270px
            );

        width:
            min(
                78vw,
                270px
            );

        height:
            min(
                91vw,
                315px
            );
    }


    html[data-baca-device="phone"]
    .bd-testi-heading h2{
        font-size:31px;
    }

}


/* ================================================================
   LIGHTBOX
================================================================ */
.bd-testi-lightbox{
    position:fixed;

    inset:0;

    z-index:99999;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:30px;

    opacity:0;

    visibility:hidden;

    pointer-events:none;

    background:
        rgba(13,9,35,.90);

    backdrop-filter:
        blur(11px);

    transition:
        opacity .22s ease,
        visibility .22s ease;
}


.bd-testi-lightbox.is-open{
    opacity:1;

    visibility:visible;

    pointer-events:auto;
}


.bd-testi-lightbox-content{
    width:
        min(
            100%,
            920px
        );

    max-height:
        calc(100dvh - 70px);

    display:flex;

    align-items:center;

    justify-content:center;
}


.bd-testi-lightbox-content img{
    display:block;

    max-width:100%;

    max-height:
        calc(100dvh - 70px);

    width:auto;
    height:auto;

    padding:8px;

    object-fit:contain;

    border-radius:16px;

    background:#fff;

    box-shadow:
        0 28px 75px
        rgba(0,0,0,.4);
}


.bd-testi-lightbox-close{
    position:absolute;

    z-index:5;

    right:22px;
    top:22px;

    width:44px;
    height:44px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:0;

    border:
        1px solid
        rgba(255,255,255,.18);

    border-radius:50%;

    color:#fff;

    background:
        rgba(255,255,255,.10);

    cursor:pointer;
}


.bd-testi-lightbox-close svg{
    width:18px;
    height:18px;
}


/* ================================================================
   MODAL
================================================================ */
body.bd-testi-modal-open{
    overflow:hidden;
}


/* ================================================================
   REDUCED MOTION
================================================================ */
@media(prefers-reduced-motion:reduce){

    .bd-testi-card,
    .bd-testi-media,
    .bd-testi-media > img,
    .bd-testi-nav,
    .bd-testi-dot span{
        transition:none!important;
    }

}
</style>


<script>
(function () {

    function initBacaTestimoni() {

        const section =
            document.getElementById(
                'testimoni'
            );


        if (
            !section
            ||
            section.dataset.testiReady ===
            '1'
        ) {
            return;
        }


        section.dataset.testiReady =
            '1';


        const cards =
            Array.from(
                section.querySelectorAll(
                    '[data-testi-card]'
                )
            );


        const dots =
            Array.from(
                section.querySelectorAll(
                    '[data-testi-dot]'
                )
            );


        const openButtons =
            Array.from(
                section.querySelectorAll(
                    '[data-testi-open]'
                )
            );


        const stage =
            section.querySelector(
                '#bdTestiStage'
            );


        const prev =
            section.querySelector(
                '#bdTestiPrev'
            );


        const next =
            section.querySelector(
                '#bdTestiNext'
            );


        const counter =
            section.querySelector(
                '#bdTestiCurrent'
            );


        const headerCurrent =
            section.querySelector(
                '#bdTestiHeaderCurrent'
            );


        const infoNumber =
            section.querySelector(
                '#bdTestiInfoNumber'
            );


        const infoLabel =
            section.querySelector(
                '#bdTestiInfoLabel'
            );


        const infoName =
            section.querySelector(
                '#bdTestiInfoName'
            );


        const lightbox =
            section.querySelector(
                '#bdTestiLightbox'
            );


        const lightboxImage =
            section.querySelector(
                '#bdTestiLightboxImage'
            );


        const lightboxClose =
            section.querySelector(
                '#bdTestiLightboxClose'
            );


        if (
            cards.length === 0
        ) {
            return;
        }


        const items =
            @json($testimoniItems);


        let activeIndex =
            0;


        let autoplay =
            null;


        let scrollTimer =
            null;


        let resizeTimer =
            null;


        const reduceMotion =
            window.matchMedia(
                '(prefers-reduced-motion:reduce)'
            ).matches;


        /* =========================================================
           DEVICE
        ========================================================== */
        function getDevice() {

            if (
                window.BacaDevice
            ) {
                return window.BacaDevice;
            }


            return {
                type:
                    window.innerWidth <= 767
                        ? 'phone'
                        : (
                            window.innerWidth <= 1023
                                ? 'tablet'
                                : 'desktop'
                        ),

                phone:
                    window.innerWidth <= 767,

                tablet:
                    window.innerWidth > 767
                    &&
                    window.innerWidth <= 1023,

                desktop:
                    window.innerWidth >= 1024,

                touch:
                    navigator.maxTouchPoints > 0,

                input:
                    navigator.maxTouchPoints > 0
                        ? 'touch'
                        : 'fine'
            };

        }


        function isPhone() {

            const device =
                getDevice();


            return (
                device.type === 'phone'
                ||
                device.phone === true
            );

        }


        /* =========================================================
           UPDATE TEXT
        ========================================================== */
        function updateInfo() {

            const number =
                String(
                    activeIndex + 1
                ).padStart(
                    2,
                    '0'
                );


            if (counter) {
                counter.textContent =
                    number;
            }


            if (headerCurrent) {
                headerCurrent.textContent =
                    number;
            }


            if (infoNumber) {
                infoNumber.textContent =
                    number;
            }


            if (
                infoLabel
                &&
                items[activeIndex]
            ) {
                infoLabel.textContent =
                    items[activeIndex].label;
            }


            if (
                infoName
                &&
                items[activeIndex]
            ) {
                infoName.textContent =
                    items[activeIndex].name;
            }


            dots.forEach(
                function (
                    dot,
                    index
                ) {

                    dot.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );

                }
            );


            cards.forEach(
                function (
                    card,
                    index
                ) {

                    card.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );

                }
            );

        }


        /* =========================================================
           DESKTOP / TABLET RENDER
        ========================================================== */
        function renderStage() {

            if (
                isPhone()
            ) {

                cards.forEach(
                    function (
                        card
                    ) {

                        card.style.removeProperty(
                            '--testi-x'
                        );


                        card.style.removeProperty(
                            '--testi-scale'
                        );


                        card.style.removeProperty(
                            '--testi-rotate'
                        );


                        card.style.removeProperty(
                            'opacity'
                        );


                        card.style.removeProperty(
                            'visibility'
                        );


                        card.style.removeProperty(
                            'z-index'
                        );


                        card.style.removeProperty(
                            'pointer-events'
                        );

                    }
                );


                return;
            }


            const device =
                getDevice();


            const tablet =
                device.type === 'tablet'
                ||
                device.tablet === true;


            const offset =
                tablet
                    ? 235
                    : 270;


            const total =
                cards.length;


            cards.forEach(
                function (
                    card,
                    index
                ) {

                    let relative =
                        index -
                        activeIndex;


                    if (
                        relative >
                        total / 2
                    ) {
                        relative -=
                            total;
                    }


                    if (
                        relative <
                        -(total / 2)
                    ) {
                        relative +=
                            total;
                    }


                    let x =
                        0;


                    let scale =
                        1;


                    let opacity =
                        1;


                    let rotate =
                        0;


                    let z =
                        10;


                    let visibility =
                        'visible';


                    let pointerEvents =
                        'auto';


                    if (
                        relative === 0
                    ) {

                        x =
                            0;

                        scale =
                            1;

                        opacity =
                            1;

                        rotate =
                            0;

                        z =
                            10;

                    }

                    else if (
                        relative === 1
                    ) {

                        x =
                            offset;

                        scale =
                            .82;

                        opacity =
                            .62;

                        rotate =
                            -7;

                        z =
                            7;

                    }

                    else if (
                        relative === -1
                    ) {

                        x =
                            -offset;

                        scale =
                            .82;

                        opacity =
                            .62;

                        rotate =
                            7;

                        z =
                            7;

                    }

                    else if (
                        relative === 2
                    ) {

                        x =
                            offset * 1.62;

                        scale =
                            .67;

                        opacity =
                            .16;

                        rotate =
                            -10;

                        z =
                            3;

                    }

                    else if (
                        relative === -2
                    ) {

                        x =
                            -(offset * 1.62);

                        scale =
                            .67;

                        opacity =
                            .16;

                        rotate =
                            10;

                        z =
                            3;

                    }

                    else {

                        opacity =
                            0;

                        visibility =
                            'hidden';

                        pointerEvents =
                            'none';

                        z =
                            1;
                    }


                    card.style.setProperty(
                        '--testi-x',
                        x + 'px'
                    );


                    card.style.setProperty(
                        '--testi-scale',
                        scale
                    );


                    card.style.setProperty(
                        '--testi-rotate',
                        rotate + 'deg'
                    );


                    card.style.opacity =
                        opacity;


                    card.style.visibility =
                        visibility;


                    card.style.zIndex =
                        z;


                    card.style.pointerEvents =
                        pointerEvents;

                }
            );

        }


        /* =========================================================
           SET ACTIVE
        ========================================================== */
        function setActive(
            index,
            scrollPhone = true
        ) {

            activeIndex =
                (
                    index +
                    cards.length
                )
                %
                cards.length;


            updateInfo();


            renderStage();


            if (
                isPhone()
                &&
                scrollPhone
                &&
                cards[activeIndex]
            ) {

                cards[
                    activeIndex
                ].scrollIntoView(
                    {
                        behavior:
                            reduceMotion
                                ? 'auto'
                                : 'smooth',

                        block:
                            'nearest',

                        inline:
                            'start'
                    }
                );

            }

        }


        /* =========================================================
           PREV NEXT
        ========================================================== */
        prev?.addEventListener(
            'click',
            function () {

                stopAutoplay();


                setActive(
                    activeIndex - 1
                );


                startAutoplay();

            }
        );


        next?.addEventListener(
            'click',
            function () {

                stopAutoplay();


                setActive(
                    activeIndex + 1
                );


                startAutoplay();

            }
        );


        /* =========================================================
           DOT
        ========================================================== */
        dots.forEach(
            function (
                dot,
                index
            ) {

                dot.addEventListener(
                    'click',
                    function () {

                        stopAutoplay();


                        setActive(
                            index
                        );


                        startAutoplay();

                    }
                );

            }
        );


        /* =========================================================
           CARD CLICK
        ========================================================== */
        cards.forEach(
            function (
                card,
                index
            ) {

                card.addEventListener(
                    'click',
                    function (
                        event
                    ) {

                        if (
                            isPhone()
                        ) {
                            return;
                        }


                        if (
                            index !==
                            activeIndex
                        ) {

                            event.preventDefault();

                            event.stopPropagation();


                            stopAutoplay();


                            setActive(
                                index
                            );


                            startAutoplay();

                        }

                    }
                );

            }
        );


        /* =========================================================
           PHONE SCROLL DETECTION
        ========================================================== */
        stage?.addEventListener(
            'scroll',
            function () {

                if (
                    !isPhone()
                ) {
                    return;
                }


                clearTimeout(
                    scrollTimer
                );


                scrollTimer =
                    window.setTimeout(
                        function () {

                            const stageRect =
                                stage
                                    .getBoundingClientRect();


                            let nearest =
                                activeIndex;


                            let smallest =
                                Infinity;


                            cards.forEach(
                                function (
                                    card,
                                    index
                                ) {

                                    const rect =
                                        card
                                            .getBoundingClientRect();


                                    const distance =
                                        Math.abs(
                                            rect.left -
                                            stageRect.left
                                        );


                                    if (
                                        distance <
                                        smallest
                                    ) {

                                        smallest =
                                            distance;


                                        nearest =
                                            index;

                                    }

                                }
                            );


                            if (
                                nearest !==
                                activeIndex
                            ) {

                                activeIndex =
                                    nearest;


                                updateInfo();

                            }

                        },
                        90
                    );

            },
            {
                passive:true
            }
        );


        /* =========================================================
           LIGHTBOX
        ========================================================== */
        function openLightbox(
            index
        ) {

            if (
                !lightbox
                ||
                !lightboxImage
                ||
                !items[index]
            ) {
                return;
            }


            lightboxImage.src =
                items[index].image;


            lightboxImage.alt =
                items[index].alt;


            lightbox.classList.add(
                'is-open'
            );


            lightbox.setAttribute(
                'aria-hidden',
                'false'
            );


            document.body.classList.add(
                'bd-testi-modal-open'
            );


            stopAutoplay();

        }


        function closeLightbox() {

            if (
                !lightbox
            ) {
                return;
            }


            lightbox.classList.remove(
                'is-open'
            );


            lightbox.setAttribute(
                'aria-hidden',
                'true'
            );


            document.body.classList.remove(
                'bd-testi-modal-open'
            );


            window.setTimeout(
                function () {

                    if (
                        lightboxImage
                        &&
                        !lightbox.classList
                            .contains(
                                'is-open'
                            )
                    ) {

                        lightboxImage.src =
                            '';

                    }

                },
                230
            );


            startAutoplay();

        }


        openButtons.forEach(
            function (
                button,
                index
            ) {

                button.addEventListener(
                    'click',
                    function (
                        event
                    ) {

                        if (
                            !isPhone()
                            &&
                            index !==
                            activeIndex
                        ) {

                            event.preventDefault();

                            return;

                        }


                        openLightbox(
                            index
                        );

                    }
                );

            }
        );


        lightboxClose?.addEventListener(
            'click',
            closeLightbox
        );


        lightbox?.addEventListener(
            'click',
            function (
                event
            ) {

                if (
                    event.target ===
                    lightbox
                ) {

                    closeLightbox();

                }

            }
        );


        document.addEventListener(
            'keydown',
            function (
                event
            ) {

                if (
                    event.key ===
                    'Escape'
                ) {

                    closeLightbox();

                }

            }
        );


        /* =========================================================
           AUTOPLAY
           Desktop / tablet saja.
        ========================================================== */
        function stopAutoplay() {

            if (
                autoplay
            ) {

                clearInterval(
                    autoplay
                );


                autoplay =
                    null;
            }

        }


        function startAutoplay() {

            stopAutoplay();


            if (
                isPhone()
                ||
                reduceMotion
                ||
                cards.length <= 1
            ) {
                return;
            }


            autoplay =
                window.setInterval(
                    function () {

                        setActive(
                            activeIndex + 1,
                            false
                        );

                    },
                    5200
                );

        }


        /* =========================================================
           HOVER PAUSE
        ========================================================== */
        section.addEventListener(
            'mouseenter',
            function () {

                if (
                    !isPhone()
                ) {

                    stopAutoplay();

                }

            }
        );


        section.addEventListener(
            'mouseleave',
            function () {

                if (
                    !isPhone()
                ) {

                    startAutoplay();

                }

            }
        );


        /* =========================================================
           DEVICE CHANGE
        ========================================================== */
        function refreshLayout() {

            renderStage();


            startAutoplay();

        }


        window.addEventListener(
            'baca:devicechange',
            refreshLayout
        );


        window.addEventListener(
            'resize',
            function () {

                clearTimeout(
                    resizeTimer
                );


                resizeTimer =
                    window.setTimeout(
                        refreshLayout,
                        120
                    );

            },
            {
                passive:true
            }
        );


        /* =========================================================
           TAB VISIBILITY
        ========================================================== */
        document.addEventListener(
            'visibilitychange',
            function () {

                if (
                    document.hidden
                ) {

                    stopAutoplay();

                }
                else {

                    startAutoplay();

                }

            }
        );


        /* =========================================================
           INITIAL
        ========================================================== */
        updateInfo();


        renderStage();


        startAutoplay();

    }


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initBacaTestimoni,
            {
                once:true
            }
        );

    }
    else {

        initBacaTestimoni();

    }

})();
</script>