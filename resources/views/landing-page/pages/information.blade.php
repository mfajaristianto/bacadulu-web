@extends('layouts.app')

@section('title', 'Informasi - Baca Dulu')

@section('content')

<style>
/* =========================================================
   BACA DULU — INFORMATION
========================================================= */

.bd-news {
    --navy: #241B52;
    --orange: #EF5843;

    --black: #171719;
    --text: #555A65;
    --muted: #898D97;
    --line: #E8E9ED;

    min-height: 100vh;

    background: #FFFFFF;
    color: var(--black);

    font-family: 'Inter', sans-serif;

    overflow-x: hidden;
}

.bd-news *,
.bd-news *::before,
.bd-news *::after {
    box-sizing: border-box;
}

.bd-news a {
    text-decoration: none;
}

.bd-news-shell {
    width: min(
        calc(100% - 72px),
        1540px
    );

    margin-inline: auto;
}


/* =========================================================
   INTRO
========================================================= */

.bd-news-intro {
    padding: 40px 0 18px;
}

.bd-news-intro-inner {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        360px;

    align-items: end;

    gap: 70px;
}

.bd-news-intro-copy {
    min-width: 0;
}

.bd-news-intro-index {
    display: flex;
    align-items: center;

    gap: 10px;

    margin-bottom: 13px;

    color: #858993;

    font-size: 9px;
    font-weight: 750;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-news-intro-index::before {
    content: "";

    width: 23px;
    height: 2px;

    flex-shrink: 0;

    background: var(--orange);
}


/* TITLE */

.bd-news-title {
    max-width: 780px;

    margin: 0;

    color: var(--navy);

    font-family:  'Poppins', sans-serif;

    font-size: clamp(
        36px,
        3.8vw,
        55px
    );

    font-weight: 580;

    line-height: 1.06;

    letter-spacing: -.045em;
}

.bd-news-title span {
    color: var(--orange);
}


/* DESCRIPTION */

.bd-news-description {
    max-width: 350px;

    margin: 0 0 4px;

    color: #747985;

    font-size: 12px;

    line-height: 1.75;
}


/* RULE */

.bd-news-intro-rule {
    width: 100%;
    height: 1px;

    margin-top: 30px;

    background: var(--line);
}


/* =========================================================
   CAROUSEL
========================================================= */

.bd-news-carousel-section {
    padding: 7px 0 65px;
}


/* HEADER */

.bd-news-carousel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 30px;

    margin-bottom: 19px;
}

.bd-news-head-left {
    display: flex;
    align-items: center;

    gap: 18px;
}

.bd-news-head-title {
    margin: 0;

    color: #171719;

    font-family: 'Poppins', sans-serif;

    font-size: 21px;
    font-weight: 500;

    line-height: 1.2;

    letter-spacing: -.025em;
}


/* VIEW ALL */

.bd-news-view {
    display: inline-flex;
    align-items: center;

    gap: 8px;

    color: #898D95 !important;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .14em;

    text-transform: uppercase;

    transition: color .25s ease;
}

.bd-news-view svg {
    width: 14px;
    height: 14px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.6;

    transition:
        transform .3s
        cubic-bezier(.22,1,.36,1);
}

.bd-news-view:hover {
    color: var(--orange) !important;
}

.bd-news-view:hover svg {
    transform: translateX(4px);
}


/* =========================================================
   ARROWS
========================================================= */

.bd-news-arrows {
    display: flex;
    align-items: center;

    gap: 2px;
}

.bd-news-arrow {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0;

    background: transparent;

    color: #222225;

    cursor: pointer;

    transition:
        color .25s ease,
        transform .2s ease;
}

.bd-news-arrow:hover {
    color: var(--orange);
}

.bd-news-arrow:active {
    transform: scale(.9);
}

.bd-news-arrow svg {
    width: 25px;
    height: 25px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.55;
}


/* =========================================================
   CAROUSEL TRACK
========================================================= */

.bd-news-carousel {
    position: relative;

    width: 100%;

    display: flex;

    gap: 18px;

    overflow-x: auto;
    overflow-y: hidden;

    padding-bottom: 4px;

    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;

    scrollbar-width: none;

    cursor: grab;
}

.bd-news-carousel::-webkit-scrollbar {
    display: none;
}

.bd-news-carousel.is-dragging {
    cursor: grabbing;

    scroll-behavior: auto;
    scroll-snap-type: none;

    user-select: none;
}


/* =========================================================
   NEWS CARD
========================================================= */

.bd-news-card {
    position: relative;

    flex:
        0 0
        calc((100% - 36px) / 3);

    min-width: 0;

    height: clamp(
        390px,
        30vw,
        520px
    );

    overflow: hidden;

    border-radius: 17px;

    background: #ECEEF1;

    isolation: isolate;

    scroll-snap-align: start;

    color: #FFFFFF !important;
}


/* IMAGE */

.bd-news-card-image {
    position: absolute;

    z-index: 1;

    inset: 0;

    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transform: scale(1.01);

    transition:
        transform .85s
        cubic-bezier(.22,1,.36,1);
}

.bd-news-card:hover
.bd-news-card-image {
    transform: scale(1.055);
}


/* =========================================================
   FALLBACK
========================================================= */

.bd-news-fallback {
    position: absolute;

    z-index: 0;

    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    background:
        linear-gradient(
            140deg,
            #2B2258 0%,
            #171329 100%
        );
}

.bd-news-fallback-inner {
    display: flex;
    align-items: center;

    flex-direction: column;

    gap: 11px;

    color: rgba(255,255,255,.9);
}

.bd-news-fallback-mark {
    width: 9px;
    height: 9px;

    background: var(--orange);
}

.bd-news-fallback-text {
    font-size: 9px;
    font-weight: 800;

    letter-spacing: .14em;

    text-transform: uppercase;
}


/* =========================================================
   OVERLAY
========================================================= */

.bd-news-card-overlay {
    position: absolute;

    z-index: 2;

    inset: 0;

    background:
        linear-gradient(
            180deg,
            rgba(5,7,12,.10) 0%,
            rgba(5,7,12,.03) 38%,
            rgba(5,7,12,.18) 55%,
            rgba(5,7,12,.78) 100%
        );

    pointer-events: none;
}


/* =========================================================
   CARD TYPE
========================================================= */

.bd-news-card-type {
    position: absolute;

    z-index: 4;

    top: 30px;
    left: 30px;

    display: flex;
    align-items: center;

    gap: 8px;

    color: rgba(255,255,255,.92);

    font-size: 10px;
    font-weight: 650;

    letter-spacing: .1em;

    text-transform: uppercase;
}

.bd-news-card-type::before {
    content: "";

    width: 6px;
    height: 6px;

    background: var(--orange);
}


/* =========================================================
   CARD CONTENT
========================================================= */

.bd-news-card-content {
    position: absolute;

    z-index: 4;

    left: 30px;
    right: 30px;
    bottom: 30px;
}

.bd-news-card-date {
    margin-bottom: 10px;

    color: rgba(255,255,255,.66);

    font-size: 9px;
    font-weight: 550;
}

.bd-news-card-title {
    max-width: 95%;

    margin: 0;

    color: #FFFFFF;

    font-family: 'Inter', sans-serif;

    font-size: clamp(
        19px,
        1.6vw,
        27px
    );

    font-weight: 500;

    line-height: 1.18;

    letter-spacing: -.025em;

    overflow-wrap: anywhere;

    transition:
        transform .4s
        cubic-bezier(.22,1,.36,1);
}

.bd-news-card:hover
.bd-news-card-title {
    transform: translateY(-4px);
}


/* READ MORE */

.bd-news-card-more {
    display: flex;
    align-items: center;

    gap: 8px;

    max-height: 0;

    margin-top: 0;

    overflow: hidden;

    color: rgba(255,255,255,.84);

    font-size: 9px;
    font-weight: 650;

    opacity: 0;

    transform: translateY(8px);

    transition:
        max-height .35s ease,
        margin-top .35s ease,
        opacity .35s ease,
        transform .35s ease;
}

.bd-news-card-more svg {
    width: 14px;
    height: 14px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.5;
}

.bd-news-card:hover
.bd-news-card-more {
    max-height: 28px;

    margin-top: 13px;

    opacity: 1;

    transform: translateY(0);
}


/* =========================================================
   EMPTY
========================================================= */

.bd-news-empty {
    padding: 65px 20px;

    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);

    color: var(--muted);

    font-size: 13px;

    text-align: center;
}


/* =========================================================
   PAGINATION
========================================================= */

.bd-news-pagination {
    margin-top: 30px;
}

.bd-news-pagination nav {
    display: flex;
    justify-content: center;
}


/* =========================================================
   MOTION
========================================================= */

.bd-news-reveal {
    opacity: 0;

    transform: translateY(16px);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .bd-news-intro-inner {
        grid-template-columns:
            minmax(0,1fr)
            300px;

        gap: 45px;
    }

    .bd-news-card {
        flex-basis:
            calc((100% - 18px) / 2);

        height: 470px;
    }

}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 820px) {

    .bd-news-shell {
        width: calc(100% - 40px);
    }

    .bd-news-intro-inner {
        grid-template-columns: 1fr;

        gap: 17px;
    }

    .bd-news-description {
        max-width: 500px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 640px) {

    .bd-news-shell {
        width: calc(100% - 30px);
    }


    .bd-news-intro {
        padding: 27px 0 12px;
    }

    .bd-news-intro-index {
        margin-bottom: 10px;

        font-size: 8px;
    }

    .bd-news-title {
        font-size: 34px;
        line-height: 1.08;
    }

    .bd-news-description {
        font-size: 11px;
        line-height: 1.7;
    }

    .bd-news-intro-rule {
        margin-top: 20px;
    }


    .bd-news-carousel-section {
        padding:
            5px 0
            50px;
    }

    .bd-news-carousel-head {
        margin-bottom: 15px;
    }

    .bd-news-head-left {
        gap: 10px;
    }

    .bd-news-head-title {
        font-size: 18px;
    }

    .bd-news-view {
        display: none;
    }

    .bd-news-arrow {
        width: 32px;
        height: 32px;
    }

    .bd-news-arrow svg {
        width: 22px;
        height: 22px;
    }

    .bd-news-carousel {
        gap: 12px;
    }


    .bd-news-card {
        flex-basis: 86%;

        height: 410px;

        border-radius: 14px;
    }

    .bd-news-card-type {
        top: 22px;
        left: 22px;

        font-size: 8px;
    }

    .bd-news-card-content {
        left: 22px;
        right: 22px;
        bottom: 23px;
    }

    .bd-news-card-date {
        margin-bottom: 8px;

        font-size: 8px;
    }

    .bd-news-card-title {
        font-size: 21px;

        line-height: 1.2;
    }

    .bd-news-card-more {
        display: none;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .bd-news-reveal {
        opacity: 1 !important;

        transform: none !important;
    }

    .bd-news-carousel {
        scroll-behavior: auto;
    }

    .bd-news-card-image,
    .bd-news-card-title,
    .bd-news-card-more {
        transition: none;
    }

}
</style>


<div
    class="bd-news"
    id="bdNewsPage"
>

    {{-- =====================================================
         INTRO
    ====================================================== --}}

    <section class="bd-news-intro">

        <div class="bd-news-shell">

            <div class="bd-news-intro-inner">


                <div class="bd-news-intro-copy">

                    <div
                        class="
                            bd-news-intro-index
                            bd-news-reveal
                        "
                    >
                        Informasi / Bacadulu
                    </div>


                    <h1
                        class="
                            bd-news-title
                            bd-news-reveal
                        "
                    >
                        Kabar terbaru dari
                        <span>Bacadulu.</span>
                    </h1>

                </div>


                <p
                    class="
                        bd-news-description
                        bd-news-reveal
                    "
                >
                    Temukan pengumuman, kabar kegiatan,
                    agenda, serta pembaruan terbaru dari
                    Bacadulu dalam satu tempat.
                </p>

            </div>


            <div
                class="
                    bd-news-intro-rule
                    bd-news-reveal
                "
            ></div>

        </div>

    </section>



    {{-- =====================================================
         NEWS
    ====================================================== --}}

    <section class="bd-news-carousel-section">

        <div class="bd-news-shell">


            {{-- HEADER --}}

            <div
                class="
                    bd-news-carousel-head
                    bd-news-reveal
                "
            >

                <div class="bd-news-head-left">

                    <h2 class="bd-news-head-title">
                        Latest news
                    </h2>


                    <a
                        href="#bdNewsCarousel"
                        class="bd-news-view"
                    >
                        View all

                        <svg viewBox="0 0 24 24">

                            <path d="M5 12h14"/>

                            <path d="m14 7 5 5-5 5"/>

                        </svg>

                    </a>

                </div>


                <div class="bd-news-arrows">

                    <button
                        type="button"
                        class="bd-news-arrow"
                        id="bdNewsPrev"
                        aria-label="Informasi sebelumnya"
                    >

                        <svg viewBox="0 0 24 24">

                            <path d="M19 12H5"/>

                            <path d="m10 7-5 5 5 5"/>

                        </svg>

                    </button>


                    <button
                        type="button"
                        class="bd-news-arrow"
                        id="bdNewsNext"
                        aria-label="Informasi berikutnya"
                    >

                        <svg viewBox="0 0 24 24">

                            <path d="M5 12h14"/>

                            <path d="m14 7 5 5-5 5"/>

                        </svg>

                    </button>

                </div>

            </div>



            {{-- =================================================
                 CARDS
            ================================================== --}}

            @if($informations->count())

                <div
                    class="
                        bd-news-carousel
                        bd-news-reveal
                    "
                    id="bdNewsCarousel"
                >

                    @foreach($informations as $information)

                        <a
                            href="{{ url('/information/' . $information->slug) }}"
                            class="bd-news-card"
                        >


                            {{-- FALLBACK --}}

                            <div class="bd-news-fallback">

                                <div class="bd-news-fallback-inner">

                                    <span
                                        class="bd-news-fallback-mark"
                                    ></span>

                                    <span class="bd-news-fallback-text">
                                        Bacadulu
                                    </span>

                                </div>

                            </div>



                            {{-- IMAGE --}}

                            @if(!empty($information->image))

                                <img
                                    src="{{ asset('storage/' . $information->image) }}"
                                    alt="{{ $information->title }}"
                                    class="bd-news-card-image"
                                    loading="lazy"

                                    onerror="
                                        this.style.display='none';
                                    "
                                >

                            @endif



                            {{-- OVERLAY --}}

                            <div
                                class="bd-news-card-overlay"
                            ></div>



                            {{-- CATEGORY --}}

                            <div class="bd-news-card-type">
                                Informasi
                            </div>



                            {{-- CONTENT --}}

                            <div class="bd-news-card-content">

                                <div class="bd-news-card-date">

                                    @if($information->created_at)

                                        {{ $information->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->translatedFormat('d M Y')
                                        }}

                                    @endif

                                </div>


                                <h3 class="bd-news-card-title">

                                    {{ $information->title }}

                                </h3>


                                <div class="bd-news-card-more">

                                    Baca selengkapnya

                                    <svg viewBox="0 0 24 24">

                                        <path d="M5 12h14"/>

                                        <path d="m14 7 5 5-5 5"/>

                                    </svg>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>


            @else

                <div class="bd-news-empty">

                    Belum ada informasi tersedia.

                </div>

            @endif



            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if(
                method_exists($informations, 'hasPages')
                &&
                $informations->hasPages()
            )

                <div class="bd-news-pagination">

                    {{ $informations->links() }}

                </div>

            @endif

        </div>

    </section>

</div>


<script>
(() => {

    const initBdNews = () => {

        const page =
            document.getElementById(
                'bdNewsPage'
            );


        const carousel =
            document.getElementById(
                'bdNewsCarousel'
            );


        const previousButton =
            document.getElementById(
                'bdNewsPrev'
            );


        const nextButton =
            document.getElementById(
                'bdNewsNext'
            );


        if (!page) {
            return;
        }


        /* =====================================================
           ANIMATION
        ====================================================== */

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
                    '.bd-news-reveal'
                ),
                {
                    opacity: 1,

                    y: 0,

                    duration: .72,

                    stagger: .055,

                    ease: 'power3.out'
                }
            );

        } else {

            page
                .querySelectorAll(
                    '.bd-news-reveal'
                )
                .forEach(element => {

                    element.style.opacity =
                        '1';

                    element.style.transform =
                        'none';

                });

        }


        if (!carousel) {
            return;
        }


        /* =====================================================
           SCROLL AMOUNT
        ====================================================== */

        const getScrollAmount = () => {

            const card =
                carousel.querySelector(
                    '.bd-news-card'
                );


            if (!card) {
                return 400;
            }


            const styles =
                window.getComputedStyle(
                    carousel
                );


            const gap =
                parseFloat(
                    styles.gap || 0
                );


            return (
                card.getBoundingClientRect().width
                +
                gap
            );

        };


        /* =====================================================
           NEXT
        ====================================================== */

        if (nextButton) {

            nextButton.addEventListener(
                'click',
                () => {

                    carousel.scrollBy({

                        left:
                            getScrollAmount(),

                        behavior:
                            reducedMotion
                                ? 'auto'
                                : 'smooth'

                    });

                }
            );

        }


        /* =====================================================
           PREVIOUS
        ====================================================== */

        if (previousButton) {

            previousButton.addEventListener(
                'click',
                () => {

                    carousel.scrollBy({

                        left:
                            -getScrollAmount(),

                        behavior:
                            reducedMotion
                                ? 'auto'
                                : 'smooth'

                    });

                }
            );

        }


        /* =====================================================
           DESKTOP DRAG
        ====================================================== */

        const finePointer =
            window.matchMedia(
                '(hover: hover) and (pointer: fine)'
            ).matches;


        if (!finePointer) {
            return;
        }


        let dragging = false;

        let startX = 0;

        let startScroll = 0;

        let moved = false;


        carousel.addEventListener(
            'mousedown',
            event => {

                dragging = true;

                moved = false;

                startX =
                    event.pageX;

                startScroll =
                    carousel.scrollLeft;

                carousel.classList.add(
                    'is-dragging'
                );

            }
        );


        window.addEventListener(
            'mousemove',
            event => {

                if (!dragging) {
                    return;
                }


                const distance =
                    event.pageX -
                    startX;


                if (
                    Math.abs(distance) > 5
                ) {
                    moved = true;
                }


                carousel.scrollLeft =
                    startScroll -
                    distance;

            }
        );


        window.addEventListener(
            'mouseup',
            () => {

                if (!dragging) {
                    return;
                }


                dragging = false;


                carousel.classList.remove(
                    'is-dragging'
                );

            }
        );


        carousel.addEventListener(
            'click',
            event => {

                if (!moved) {
                    return;
                }


                event.preventDefault();

                event.stopPropagation();

                moved = false;

            },
            true
        );

    };


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initBdNews,
            {
                once: true
            }
        );

    } else {

        initBdNews();

    }

})();
</script>

@endsection