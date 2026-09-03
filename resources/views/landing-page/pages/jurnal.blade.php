@extends('layouts.app')

@section('title', 'Baca Jurnal - Baca Dulu')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    $journalItems = method_exists($jurnals, 'items')
        ? collect($jurnals->items())
        : collect($jurnals);

    $featuredJournal = $journalItems->first();

    $otherJournals = $journalItems->skip(1);

    $totalJournals = method_exists($jurnals, 'total')
        ? $jurnals->total()
        : $journalItems->count();
@endphp


<style>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');


/* =========================================================
   BACA DULU — BACA JURNAL
========================================================= */

.bd-journal {
    --navy: #241B52;
    --orange: #EF5843;

    --black: #121214;
    --text: #5F626A;
    --muted: #989BA2;

    --line: #E6E7EA;
    --soft: #F5F6F7;

    width: 100%;
    min-height: 100vh;

    padding: 46px 0 66px;

    background: #FFFFFF;
    color: var(--black);

    font-family: 'Manrope', sans-serif;

    overflow-x: hidden;
}

.bd-journal *,
.bd-journal *::before,
.bd-journal *::after {
    box-sizing: border-box;
}

.bd-journal a {
    text-decoration: none;
}

.bd-journal-shell {
    width: min(
        calc(100% - 72px),
        1360px
    );

    margin-inline: auto;
}


/* =========================================================
   HEADER
========================================================= */

.bd-journal-header {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        minmax(320px, 430px);

    gap: 70px;

    align-items: end;

    margin-bottom: 45px;
}


/* LEFT */

.bd-journal-header-left {
    min-width: 0;
}

.bd-journal-eyebrow {
    display: flex;
    align-items: center;

    gap: 9px;

    margin-bottom: 10px;

    color: var(--orange);

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-journal-eyebrow::before {
    content: "";

    width: 22px;
    height: 2px;

    background: var(--orange);
}

.bd-journal-title {
    margin: 0;

    color: var(--black);

    font-size: clamp(
        38px,
        4vw,
        57px
    );

    font-weight: 800;

    line-height: 1.03;

    letter-spacing: -.055em;
}


/* RIGHT */

.bd-journal-header-right {
    padding-bottom: 3px;
}

.bd-journal-description {
    max-width: 390px;

    margin: 0;

    color: #696C73;

    font-size: 15px;
    font-weight: 500;

    line-height: 1.65;
}

.bd-journal-count {
    display: flex;
    align-items: center;

    gap: 8px;

    margin-top: 15px;

    color: #9B9DA3;

    font-size: 9px;
    font-weight: 700;

    letter-spacing: .08em;

    text-transform: uppercase;
}

.bd-journal-count-dot {
    width: 5px;
    height: 5px;

    border-radius: 50%;

    background: var(--orange);
}


/* =========================================================
   CONTENT GRID
========================================================= */

.bd-journal-layout {
    display: grid;

    grid-template-columns:
        minmax(0, 1.23fr)
        minmax(390px, .87fr);

    gap: 48px;

    align-items: start;
}


/* =========================================================
   FEATURED
========================================================= */

.bd-journal-featured {
    min-width: 0;
}


/* =========================================================
   FEATURED IMAGE
========================================================= */

.bd-journal-featured-media {
    position: relative;

    width: 100%;

    aspect-ratio: 16 / 10;

    overflow: hidden;

    border-radius: 22px;

    background: var(--soft);

    isolation: isolate;
}

.bd-journal-featured-image {
    position: absolute;

    z-index: 1;

    inset: 0;

    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transition:
        transform .9s cubic-bezier(.22,1,.36,1);
}

.bd-journal-featured-media:hover
.bd-journal-featured-image {
    transform: scale(1.035);
}


/* =========================================================
   FEATURED FALLBACK
========================================================= */

.bd-journal-featured-fallback {
    position: absolute;

    z-index: 0;

    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-direction: column;

    gap: 11px;

    background:
        linear-gradient(
            135deg,
            #2B225D,
            #17132D
        );

    color: #FFFFFF;
}

.bd-journal-featured-fallback-dot {
    width: 9px;
    height: 9px;

    background: var(--orange);
}

.bd-journal-featured-fallback span {
    font-size: 9px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}


/* =========================================================
   FEATURED BADGES
========================================================= */

.bd-journal-featured-category {
    position: absolute;

    z-index: 3;

    left: 17px;
    bottom: 17px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 31px;

    padding: 0 14px;

    border-radius: 999px;

    background: #FFFFFF;

    color: #242426;

    font-size: 9px;
    font-weight: 750;

    letter-spacing: .01em;
}

.bd-journal-featured-status {
    position: absolute;

    z-index: 3;

    right: 17px;
    bottom: 17px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 31px;

    padding: 0 13px;

    border-radius: 999px;

    background: #FFFFFF;

    color: #55585F;

    font-size: 9px;
    font-weight: 650;
}


/* =========================================================
   FEATURED CONTENT
========================================================= */

.bd-journal-featured-content {
    padding-top: 20px;
}

.bd-journal-featured-title {
    max-width: 850px;

    margin: 0;

    color: var(--black);

    font-size: clamp(
        23px,
        2vw,
        31px
    );

    font-weight: 800;

    line-height: 1.18;

    letter-spacing: -.04em;

    overflow-wrap: anywhere;
}

.bd-journal-featured-description {
    max-width: 800px;

    margin-top: 10px;

    color: #6A6D73;

    font-size: 14px;
    font-weight: 500;

    line-height: 1.65;

    display: -webkit-box;

    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;

    overflow: hidden;
}

.bd-journal-featured-description p {
    margin: 0;
}


/* =========================================================
   FEATURED DOWNLOAD
========================================================= */

.bd-journal-featured-download {
    display: inline-flex;
    align-items: center;

    gap: 9px;

    margin-top: 17px;

    color: #161618 !important;

    font-size: 11px;
    font-weight: 800;

    transition:
        color .25s ease;
}

.bd-journal-featured-download svg {
    width: 16px;
    height: 16px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;

    transition:
        transform .3s cubic-bezier(.22,1,.36,1);
}

.bd-journal-featured-download:hover {
    color: var(--orange) !important;
}

.bd-journal-featured-download:hover svg {
    transform: translateY(3px);
}

.bd-journal-featured-unavailable {
    display: inline-block;

    margin-top: 17px;

    color: #A0A2A7;

    font-size: 10px;

    font-style: italic;
}


/* =========================================================
   RIGHT LIST
========================================================= */

.bd-journal-list {
    min-width: 0;
}


/* =========================================================
   LIST HEADER
========================================================= */

.bd-journal-list-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;

    min-height: 38px;

    margin-bottom: 6px;
}

.bd-journal-list-heading span:first-child {
    color: #8B8E95;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .12em;

    text-transform: uppercase;
}

.bd-journal-list-heading span:last-child {
    color: #A0A2A7;

    font-size: 9px;
    font-weight: 650;
}


/* =========================================================
   JOURNAL ROW
========================================================= */

.bd-journal-row {
    display: grid;

    grid-template-columns:
        108px
        minmax(0, 1fr);

    gap: 18px;

    align-items: center;

    min-height: 150px;

    padding: 20px 0;

    border-bottom: 1px solid var(--line);
}

.bd-journal-row:first-of-type {
    border-top: 1px solid var(--line);
}


/* =========================================================
   ROW IMAGE
========================================================= */

.bd-journal-row-image {
    position: relative;

    width: 108px;
    height: 108px;

    overflow: hidden;

    border-radius: 14px;

    background: var(--soft);
}

.bd-journal-row-image img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    transition:
        transform .7s cubic-bezier(.22,1,.36,1);
}

.bd-journal-row:hover
.bd-journal-row-image img {
    transform: scale(1.055);
}


/* =========================================================
   SMALL FALLBACK
========================================================= */

.bd-journal-row-fallback {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-direction: column;

    gap: 7px;

    background: var(--navy);

    color: #FFFFFF;
}

.bd-journal-row-fallback-dot {
    width: 6px;
    height: 6px;

    background: var(--orange);
}

.bd-journal-row-fallback span {
    font-size: 6px;
    font-weight: 800;

    letter-spacing: .12em;

    text-transform: uppercase;
}


/* =========================================================
   ROW CONTENT
========================================================= */

.bd-journal-row-content {
    min-width: 0;
}

.bd-journal-row-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 8px;

    margin-bottom: 8px;
}


/* CATEGORY */

.bd-journal-row-category {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 26px;

    padding: 0 10px;

    border: 1px solid #E0E1E4;
    border-radius: 999px;

    color: #73767D;

    font-size: 8px;
    font-weight: 650;
}


/* DATE */

.bd-journal-row-date {
    color: #A0A2A8;

    font-size: 9px;
    font-weight: 500;
}


/* TITLE */

.bd-journal-row-title {
    max-width: 380px;

    margin: 0;

    color: var(--black);

    font-size: clamp(
        15px,
        1.25vw,
        19px
    );

    font-weight: 800;

    line-height: 1.25;

    letter-spacing: -.025em;

    overflow-wrap: anywhere;
}


/* DOWNLOAD LINK */

.bd-journal-row-download {
    display: inline-flex;
    align-items: center;

    gap: 7px;

    margin-top: 10px;

    color: #777A81 !important;

    font-size: 9px;
    font-weight: 700;

    transition:
        color .25s ease;
}

.bd-journal-row-download svg {
    width: 13px;
    height: 13px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.6;

    transition:
        transform .25s ease;
}

.bd-journal-row-download:hover {
    color: var(--orange) !important;
}

.bd-journal-row-download:hover svg {
    transform: translateY(2px);
}

.bd-journal-row-no-file {
    display: inline-block;

    margin-top: 10px;

    color: #B0B1B5;

    font-size: 8px;

    font-style: italic;
}


/* =========================================================
   EMPTY LIST
========================================================= */

.bd-journal-list-empty {
    padding: 28px 0;

    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);

    color: #97999F;

    font-size: 11px;

    line-height: 1.6;
}


/* =========================================================
   EMPTY PAGE
========================================================= */

.bd-journal-empty {
    padding: 70px 20px;

    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);

    color: #92949A;

    text-align: center;

    font-size: 12px;
}


/* =========================================================
   PAGINATION
========================================================= */

.bd-journal-pagination {
    margin-top: 34px;
}

.bd-journal-pagination nav {
    display: flex;
    justify-content: center;
}


/* =========================================================
   ANIMATION INITIAL STATE
========================================================= */

.bd-journal-reveal {
    opacity: 0;

    transform: translateY(16px);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1050px) {

    .bd-journal-header {
        grid-template-columns:
            minmax(0, 1fr)
            330px;

        gap: 40px;
    }

    .bd-journal-layout {
        grid-template-columns:
            minmax(0, 1fr)
            minmax(330px, .8fr);

        gap: 30px;
    }

    .bd-journal-row {
        grid-template-columns:
            90px
            minmax(0, 1fr);

        gap: 14px;

        min-height: 130px;
    }

    .bd-journal-row-image {
        width: 90px;
        height: 90px;
    }

}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 800px) {

    .bd-journal {
        padding-top: 34px;
    }

    .bd-journal-shell {
        width:
            calc(100% - 40px);
    }

    .bd-journal-header {
        grid-template-columns: 1fr;

        gap: 15px;

        margin-bottom: 32px;
    }

    .bd-journal-description {
        max-width: 520px;
    }

    .bd-journal-layout {
        grid-template-columns: 1fr;

        gap: 42px;
    }

    .bd-journal-list {
        width: 100%;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 640px) {

    .bd-journal {
        padding:
            26px 0
            48px;
    }

    .bd-journal-shell {
        width:
            calc(100% - 30px);
    }


    /* HEADER */

    .bd-journal-header {
        margin-bottom: 25px;
    }

    .bd-journal-eyebrow {
        margin-bottom: 8px;

        font-size: 8px;
    }

    .bd-journal-title {
        font-size: 37px;

        line-height: 1.05;
    }

    .bd-journal-description {
        font-size: 12px;
    }


    /* FEATURED */

    .bd-journal-featured-media {
        aspect-ratio: 4 / 3;

        border-radius: 15px;
    }

    .bd-journal-featured-category,
    .bd-journal-featured-status {
        bottom: 11px;

        min-height: 27px;

        font-size: 8px;
    }

    .bd-journal-featured-category {
        left: 11px;
    }

    .bd-journal-featured-status {
        right: 11px;
    }

    .bd-journal-featured-content {
        padding-top: 15px;
    }

    .bd-journal-featured-title {
        font-size: 23px;
    }

    .bd-journal-featured-description {
        font-size: 11px;
    }


    /* LIST */

    .bd-journal-layout {
        gap: 32px;
    }

    .bd-journal-row {
        grid-template-columns:
            84px
            minmax(0, 1fr);

        gap: 13px;

        min-height: 0;

        padding: 15px 0;
    }

    .bd-journal-row-image {
        width: 84px;
        height: 84px;

        border-radius: 11px;
    }

    .bd-journal-row-meta {
        gap: 6px;

        margin-bottom: 6px;
    }

    .bd-journal-row-category {
        min-height: 23px;

        padding: 0 8px;

        font-size: 7px;
    }

    .bd-journal-row-date {
        font-size: 7px;
    }

    .bd-journal-row-title {
        font-size: 15px;
    }

    .bd-journal-row-download {
        margin-top: 7px;

        font-size: 8px;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .bd-journal-reveal {
        opacity: 1 !important;

        transform: none !important;
    }

    .bd-journal-featured-image,
    .bd-journal-row-image img {
        transition: none;
    }

}
</style>



<section
    class="bd-journal"
    id="bdJournalPage"
>

    <div class="bd-journal-shell">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <header
            class="
                bd-journal-header
                bd-journal-reveal
            "
        >

            <div class="bd-journal-header-left">

                <div class="bd-journal-eyebrow">
                    Baca Dulu / Journal
                </div>


                <h1 class="bd-journal-title">
                    Dari koleksi jurnal.
                </h1>

            </div>


            <div class="bd-journal-header-right">

                <p class="bd-journal-description">

                    Pilihan jurnal dan publikasi untuk
                    menambah referensi, wawasan, serta
                    pengetahuan dalam berbagai topik.

                </p>


                <div class="bd-journal-count">

                    <span class="bd-journal-count-dot"></span>

                    {{ $totalJournals }}
                    jurnal tersedia

                </div>

            </div>

        </header>



        {{-- =================================================
             CONTENT
        ================================================== --}}

        @if($featuredJournal)

            <div class="bd-journal-layout">


                {{-- =================================================
                     FEATURED
                ================================================== --}}

                <article
                    class="
                        bd-journal-featured
                        bd-journal-reveal
                    "
                >


                    <div class="bd-journal-featured-media">


                        {{-- FALLBACK --}}

                        <div class="bd-journal-featured-fallback">

                            <span
                                class="bd-journal-featured-fallback-dot"
                            ></span>

                            <span>
                                Baca Dulu Journal
                            </span>

                        </div>



                        {{-- IMAGE --}}

                        @if(!empty($featuredJournal->gambar))

                            <img
                                src="{{ asset('storage/' . $featuredJournal->gambar) }}"
                                alt="{{ $featuredJournal->judul }}"
                                class="bd-journal-featured-image"
                                loading="eager"

                                onerror="
                                    this.style.display='none';
                                "
                            >

                        @endif



                        {{-- CATEGORY --}}

                        <span class="bd-journal-featured-category">

                            Journal

                        </span>



                        {{-- STATUS --}}

                        <span class="bd-journal-featured-status">

                            PDF

                        </span>

                    </div>



                    {{-- CONTENT --}}

                    <div class="bd-journal-featured-content">


                        <h2 class="bd-journal-featured-title">

                            {{ $featuredJournal->judul }}

                        </h2>



                        <div class="bd-journal-featured-description">

                            {!! $featuredJournal->deskripsi
                                ?? $featuredJournal->content
                                ?? ''
                            !!}

                        </div>



                        {{-- DOWNLOAD --}}

                        @if(!empty($featuredJournal->file_pdf))

                            <a
                                href="{{ asset('storage/' . $featuredJournal->file_pdf) }}"
                                download="{{ \Illuminate\Support\Str::slug($featuredJournal->judul) }}.pdf"
                                class="bd-journal-featured-download"
                            >

                                Download PDF

                                <svg viewBox="0 0 24 24">

                                    <path d="M12 4v12"/>

                                    <path d="m8 12 4 4 4-4"/>

                                    <path d="M5 20h14"/>

                                </svg>

                            </a>


                        @else

                            <span class="bd-journal-featured-unavailable">

                                File PDF belum tersedia

                            </span>

                        @endif

                    </div>

                </article>



                {{-- =================================================
                     RIGHT LIST
                ================================================== --}}

                <div
                    class="
                        bd-journal-list
                        bd-journal-reveal
                    "
                >


                    <div class="bd-journal-list-heading">

                        <span>
                            Jurnal lainnya
                        </span>

                        <span>
                            {{ $otherJournals->count() }}
                            item
                        </span>

                    </div>



                    @forelse($otherJournals as $jurnal)

                        <article class="bd-journal-row">


                            {{-- IMAGE --}}

                            <div class="bd-journal-row-image">


                                @if(!empty($jurnal->gambar))

                                    <img
                                        src="{{ asset('storage/' . $jurnal->gambar) }}"
                                        alt="{{ $jurnal->judul }}"
                                        loading="lazy"

                                        onerror="
                                            this.style.display='none';
                                        "
                                    >


                                @else

                                    <div class="bd-journal-row-fallback">

                                        <span
                                            class="bd-journal-row-fallback-dot"
                                        ></span>

                                        <span>
                                            Baca Dulu
                                        </span>

                                    </div>

                                @endif

                            </div>



                            {{-- CONTENT --}}

                            <div class="bd-journal-row-content">


                                <div class="bd-journal-row-meta">

                                    <span class="bd-journal-row-category">

                                        Journal

                                    </span>


                                    @if(!empty($jurnal->created_at))

                                        <span class="bd-journal-row-date">

                                            {{ $jurnal->created_at
                                                ->timezone('Asia/Jakarta')
                                                ->translatedFormat('d M Y')
                                            }}

                                        </span>

                                    @endif

                                </div>



                                <h3 class="bd-journal-row-title">

                                    {{ $jurnal->judul }}

                                </h3>



                                @if(!empty($jurnal->file_pdf))

                                    <a
                                        href="{{ asset('storage/' . $jurnal->file_pdf) }}"
                                        download="{{ \Illuminate\Support\Str::slug($jurnal->judul) }}.pdf"
                                        class="bd-journal-row-download"
                                    >

                                        Download

                                        <svg viewBox="0 0 24 24">

                                            <path d="M12 4v12"/>

                                            <path d="m8 12 4 4 4-4"/>

                                            <path d="M5 20h14"/>

                                        </svg>

                                    </a>


                                @else

                                    <span class="bd-journal-row-no-file">

                                        PDF belum tersedia

                                    </span>

                                @endif

                            </div>

                        </article>


                    @empty

                        <div class="bd-journal-list-empty">

                            Jurnal lainnya akan tampil di sini
                            ketika tersedia.

                        </div>

                    @endforelse

                </div>

            </div>


        @else

            <div class="bd-journal-empty">

                Belum ada jurnal yang tersedia.

            </div>

        @endif



        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if(
            method_exists($jurnals, 'hasPages')
            &&
            $jurnals->hasPages()
        )

            <div class="bd-journal-pagination">

                {{ $jurnals->links() }}

            </div>

        @endif

    </div>

</section>



<script>
(() => {

    const initBdJournal = () => {

        const page =
            document.getElementById(
                'bdJournalPage'
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



        if (
            gsap &&
            !reducedMotion
        ) {

            gsap.to(
                page.querySelectorAll(
                    '.bd-journal-reveal'
                ),
                {
                    opacity: 1,

                    y: 0,

                    duration: .72,

                    stagger: .07,

                    ease: 'power3.out'
                }
            );

        } else {

            page
                .querySelectorAll(
                    '.bd-journal-reveal'
                )
                .forEach(element => {

                    element.style.opacity = '1';

                    element.style.transform = 'none';

                });

        }

    };


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initBdJournal,
            {
                once: true
            }
        );

    } else {

        initBdJournal();

    }

})();
</script>

@endsection