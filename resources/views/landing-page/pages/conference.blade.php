@extends('layouts.app')

@section('title', 'Baca Conference - Baca Dulu')

@section('content')

@php
    $conferenceItems = method_exists($conferences, 'items')
        ? collect($conferences->items())->values()
        : collect($conferences)->values();

    $featuredConference = $conferenceItems->first();

    $otherConferences = $conferenceItems->skip(1);

    $totalConferences = method_exists($conferences, 'total')
        ? $conferences->total()
        : $conferenceItems->count();

    $today = \Carbon\Carbon::today('Asia/Jakarta');
@endphp


<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap');

.bd-conf {
    --navy:#241B52;
    --orange:#EF5843;
    --ink:#17181C;
    --body:#5A5F69;
    --muted:#9498A1;
    --line:#E7E8EC;
    --soft:#F6F7F9;

    width:100%;
    min-height:100vh;

    padding:43px 0 72px;

    overflow-x:hidden;

    background:#FFF;

    font-family:'Inter',sans-serif;
}

.bd-conf *,
.bd-conf *::before,
.bd-conf *::after {
    box-sizing:border-box;
}

.bd-conf-shell {
    width:min(calc(100% - 72px),1360px);

    margin:auto;
}


/* HEADER */

.bd-conf-header {
    display:grid;

    grid-template-columns:minmax(0,1fr) 370px;

    gap:65px;

    align-items:end;

    padding-bottom:29px;

    border-bottom:1px solid var(--line);
}

.bd-conf-eyebrow {
    display:flex;
    align-items:center;

    gap:9px;

    margin-bottom:9px;

    color:var(--orange);

    font-size:9px;
    font-weight:800;

    letter-spacing:.13em;

    text-transform:uppercase;
}

.bd-conf-eyebrow::before {
    content:"";

    width:23px;
    height:2px;

    background:var(--orange);
}

.bd-conf-title {
    margin:0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;

    font-size:clamp(42px,5vw,67px);

    font-weight:600;

    line-height:1;

    letter-spacing:-.05em;
}

.bd-conf-header-description {
    margin:0;

    color:var(--body);

    font-size:13px;

    line-height:1.75;
}

.bd-conf-count {
    margin-top:12px;

    color:var(--muted);

    font-size:9px;
    font-weight:700;
}


/* FEATURED */

.bd-conf-featured {
    display:grid;

    grid-template-columns:minmax(0,1.12fr) minmax(350px,.88fr);

    gap:42px;

    padding:30px 0 40px;

    border-bottom:1px solid var(--line);
}

.bd-conf-featured-media {
    position:relative;

    min-height:430px;

    overflow:hidden;

    border-radius:17px;

    background:var(--navy);
}

.bd-conf-featured-image {
    width:100%;
    height:100%;

    position:absolute;

    inset:0;

    object-fit:cover;

    transition:transform .8s cubic-bezier(.22,1,.36,1);
}

.bd-conf-featured-media:hover
.bd-conf-featured-image {
    transform:scale(1.04);
}

.bd-conf-featured-fallback {
    position:absolute;

    inset:0;

    display:flex;
    align-items:center;
    justify-content:center;

    background:var(--navy);
}

.bd-conf-featured-fallback span {
    width:9px;
    height:9px;

    background:var(--orange);
}

.bd-conf-status {
    position:absolute;

    z-index:5;

    left:15px;
    bottom:15px;

    padding:8px 13px;

    border-radius:999px;

    background:#FFF;

    color:#777B84;

    font-size:8px;
    font-weight:800;

    text-transform:uppercase;
}

.bd-conf-status.upcoming {
    color:var(--orange);
}

.bd-conf-status.today {
    background:var(--orange);

    color:#FFF;
}

.bd-conf-featured-copy {
    display:flex;
    flex-direction:column;
    justify-content:center;
}


/* DATE */

.bd-conf-date-large {
    display:flex;
    align-items:flex-start;

    gap:14px;

    margin-bottom:20px;
}

.bd-conf-day {
    color:var(--orange);

    font-family:'Poppins',sans-serif;

    font-size:clamp(54px,5vw,78px);

    font-weight:600;

    line-height:.82;

    letter-spacing:-.06em;
}

.bd-conf-date-side strong {
    display:block;

    color:var(--navy);

    font-size:11px;

    text-transform:uppercase;
}

.bd-conf-date-side span {
    color:var(--muted);

    font-size:10px;
}


/* TITLE */

.bd-conf-featured-title {
    margin:0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;

    font-size:clamp(27px,2.6vw,39px);

    font-weight:600;

    line-height:1.15;

    letter-spacing:-.035em;
}


/* EVENT INFO */

.bd-conf-event-info {
    display:flex;
    flex-wrap:wrap;

    gap:10px 18px;

    margin-top:16px;
}

.bd-conf-info-item {
    display:flex;
    align-items:center;

    gap:7px;

    color:#5E646D;

    font-size:11px;
    font-weight:600;
}

.bd-conf-info-item svg {
    width:15px;
    height:15px;

    fill:none;
    stroke:var(--orange);

    stroke-width:1.6;
}

.bd-conf-time-value {
    color:var(--orange);

    font-weight:750;
}


/* DESCRIPTION */

.bd-conf-description {
    position:relative;

    height:115px;

    margin-top:17px;

    overflow:hidden;
}

.bd-conf-description.has-overflow {
    cursor:pointer;
}

.bd-conf-description-inner {
    width:100%;
    height:100%;

    overflow:hidden;

    padding-right:8px;

    color:var(--body);

    font-size:13px;

    line-height:1.72;

    scrollbar-width:thin;
}

.bd-conf-description-inner p {
    margin:0 0 8px;
}

.bd-conf-description.is-scroll-active
.bd-conf-description-inner {
    overflow-y:auto;
}

.bd-conf-description-inner::-webkit-scrollbar {
    width:4px;
}

.bd-conf-description-inner::-webkit-scrollbar-thumb {
    border-radius:999px;

    background:rgba(36,27,82,.25);
}

.bd-conf-description::after {
    content:"";

    position:absolute;

    left:0;
    right:0;
    bottom:0;

    height:28px;

    background:linear-gradient(transparent,#FFF);

    opacity:0;

    pointer-events:none;
}

.bd-conf-description.has-overflow:not(.is-scroll-active)::after {
    opacity:1;
}


/* OTHER */

.bd-conf-others {
    padding-top:40px;
}

.bd-conf-others-head {
    display:flex;
    align-items:flex-end;
    justify-content:space-between;

    margin-bottom:10px;
}

.bd-conf-others-title {
    margin:0;

    color:var(--ink);

    font-family:'Poppins',sans-serif;

    font-size:24px;
    font-weight:600;
}

.bd-conf-other {
    display:grid;

    grid-template-columns:45px 270px minmax(0,1fr);

    gap:28px;

    padding:30px 0;

    border-top:1px solid var(--line);
}

.bd-conf-other:last-child {
    border-bottom:1px solid var(--line);
}

.bd-conf-other-number {
    padding-top:3px;

    color:#BEC1C7;

    font-family:'Poppins',sans-serif;

    font-size:13px;
}

.bd-conf-other-media {
    width:270px;
    height:190px;

    overflow:hidden;

    border-radius:13px;

    background:var(--navy);
}

.bd-conf-other-media img {
    width:100%;
    height:100%;

    object-fit:cover;

    transition:transform .8s cubic-bezier(.22,1,.36,1);
}

.bd-conf-other:hover
.bd-conf-other-media img {
    transform:scale(1.045);
}

.bd-conf-other-copy {
    display:flex;
    justify-content:center;
    flex-direction:column;
}

.bd-conf-other-date {
    color:var(--orange);

    font-size:10px;
    font-weight:750;
}

.bd-conf-other-title {
    margin:8px 0 0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;

    font-size:clamp(20px,2vw,28px);

    font-weight:600;

    line-height:1.25;

    letter-spacing:-.03em;
}

.bd-conf-other-info {
    display:flex;
    flex-wrap:wrap;

    gap:9px 18px;

    margin-top:11px;
}

.bd-conf-other-description {
    position:relative;

    max-width:800px;
    height:75px;

    margin-top:13px;

    overflow:hidden;
}

.bd-conf-other-description.has-overflow {
    cursor:pointer;
}

.bd-conf-other-description-inner {
    width:100%;
    height:100%;

    overflow:hidden;

    padding-right:8px;

    color:var(--body);

    font-size:12px;

    line-height:1.7;

    scrollbar-width:thin;
}

.bd-conf-other-description-inner p {
    margin:0 0 7px;
}

.bd-conf-other-description.is-scroll-active
.bd-conf-other-description-inner {
    overflow-y:auto;
}

.bd-conf-other-description-inner::-webkit-scrollbar {
    width:4px;
}

.bd-conf-other-description-inner::-webkit-scrollbar-thumb {
    border-radius:999px;

    background:rgba(36,27,82,.24);
}

.bd-conf-other-description::after {
    content:"";

    position:absolute;

    bottom:0;
    left:0;
    right:0;

    height:24px;

    background:linear-gradient(transparent,#FFF);

    opacity:0;

    pointer-events:none;
}

.bd-conf-other-description.has-overflow:not(.is-scroll-active)::after {
    opacity:1;
}


/* RESPONSIVE */

@media(max-width:900px) {
    .bd-conf-featured {
        grid-template-columns:1fr;
    }

    .bd-conf-header {
        grid-template-columns:1fr;
        gap:14px;
    }

    .bd-conf-other {
        grid-template-columns:210px 1fr;
    }

    .bd-conf-other-number {
        display:none;
    }

    .bd-conf-other-media {
        width:210px;
    }
}

@media(max-width:640px) {
    .bd-conf {
        padding:28px 0 48px;
    }

    .bd-conf-shell {
        width:calc(100% - 30px);
    }

    .bd-conf-title {
        font-size:38px;
    }

    .bd-conf-featured-media {
        min-height:280px;
    }

    .bd-conf-featured-title {
        font-size:24px;
    }

    .bd-conf-other {
        grid-template-columns:1fr;

        gap:15px;

        padding:24px 0;
    }

    .bd-conf-other-media {
        width:100%;
        height:210px;
    }

    .bd-conf-other-title {
        font-size:20px;
    }
}
</style>


<section
    class="bd-conf"
    id="bdConferencePage"
>

    <div class="bd-conf-shell">


        {{-- HEADER --}}

        <header class="bd-conf-header">

            <div>

                <div class="bd-conf-eyebrow">
                    Event Ilmiah
                </div>

                <h1 class="bd-conf-title">
                    Baca Conference
                </h1>

            </div>


            <div>

                <p class="bd-conf-header-description">
                    Temukan konferensi, seminar,
                    dan kegiatan ilmiah terbaru
                    yang dipublikasikan melalui Baca Dulu.
                </p>

                <div class="bd-conf-count">

                    {{ $totalConferences }}
                    conference tersedia

                </div>

            </div>

        </header>



        {{-- FEATURED --}}

        @if($featuredConference)

            @php
                $featuredDate = $featuredConference->event_date
                    ? \Carbon\Carbon::parse($featuredConference->event_date)
                    : null;

                $featuredTime = $featuredConference->event_time
                    ? \Carbon\Carbon::parse($featuredConference->event_time)
                        ->format('H:i')
                    : null;

                $featuredStatus = '';
                $featuredStatusClass = '';

                if ($featuredDate) {
                    if ($featuredDate->isSameDay($today)) {
                        $featuredStatus = 'Hari ini';
                        $featuredStatusClass = 'today';
                    } elseif ($featuredDate->greaterThan($today)) {
                        $featuredStatus = 'Upcoming';
                        $featuredStatusClass = 'upcoming';
                    } else {
                        $featuredStatus = 'Selesai';
                    }
                }
            @endphp


            <section class="bd-conf-featured">


                <div class="bd-conf-featured-media">


                    <div class="bd-conf-featured-fallback">
                        <span></span>
                    </div>


                    @if($featuredConference->poster)

                        <img
                            src="{{ asset('storage/' . $featuredConference->poster) }}"
                            alt="{{ $featuredConference->title }}"
                            class="bd-conf-featured-image"
                        >

                    @endif


                    @if($featuredStatus)

                        <span
                            class="
                                bd-conf-status
                                {{ $featuredStatusClass }}
                            "
                        >
                            {{ $featuredStatus }}
                        </span>

                    @endif

                </div>



                <div class="bd-conf-featured-copy">


                    @if($featuredDate)

                        <div class="bd-conf-date-large">

                            <div class="bd-conf-day">

                                {{ $featuredDate->format('d') }}

                            </div>


                            <div class="bd-conf-date-side">

                                <strong>

                                    {{
                                        $featuredDate
                                            ->translatedFormat('F')
                                    }}

                                </strong>

                                <span>

                                    {{ $featuredDate->format('Y') }}

                                </span>

                            </div>

                        </div>

                    @endif


                    <h2 class="bd-conf-featured-title">

                        {{ $featuredConference->title }}

                    </h2>



                    {{-- TIME + LOCATION --}}

                    <div class="bd-conf-event-info">


                        @if($featuredTime)

                            <div class="bd-conf-info-item">

                                <svg viewBox="0 0 24 24">

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                    />

                                    <path d="M12 7v5l3 2"/>

                                </svg>


                                <span class="bd-conf-time-value">

                                    {{ $featuredTime }} WIB

                                </span>

                            </div>

                        @endif



                        @if($featuredConference->location)

                            <div class="bd-conf-info-item">

                                <svg viewBox="0 0 24 24">

                                    <path
                                        d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"
                                    />

                                    <circle
                                        cx="12"
                                        cy="10"
                                        r="2.5"
                                    />

                                </svg>


                                <span>

                                    {{ $featuredConference->location }}

                                </span>

                            </div>

                        @endif

                    </div>



                    @if($featuredConference->description)

                        <div
                            class="
                                bd-conf-description
                                js-conf-desc
                            "
                        >

                            <div class="bd-conf-description-inner">

                                {!! $featuredConference->description !!}

                            </div>

                        </div>

                    @endif

                </div>

            </section>



            {{-- CONFERENCE LAINNYA --}}

            @if($otherConferences->count())

                <section class="bd-conf-others">


                    <div class="bd-conf-others-head">

                        <h2 class="bd-conf-others-title">

                            Conference lainnya

                        </h2>

                        <span class="bd-conf-count">

                            {{ $otherConferences->count() }}
                            event

                        </span>

                    </div>



                    @foreach($otherConferences as $index => $conference)

                        @php
                            $conferenceDate = $conference->event_date
                                ? \Carbon\Carbon::parse($conference->event_date)
                                : null;

                            $conferenceTime = $conference->event_time
                                ? \Carbon\Carbon::parse($conference->event_time)
                                    ->format('H:i')
                                : null;

                            $status = '';

                            if ($conferenceDate) {
                                if ($conferenceDate->isSameDay($today)) {
                                    $status = 'Hari ini';
                                } elseif ($conferenceDate->greaterThan($today)) {
                                    $status = 'Upcoming';
                                } else {
                                    $status = 'Selesai';
                                }
                            }
                        @endphp


                        <article class="bd-conf-other">


                            <div class="bd-conf-other-number">

                                {{
                                    str_pad(
                                        $index + 1,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    )
                                }}

                            </div>



                            <div class="bd-conf-other-media">

                                @if($conference->poster)

                                    <img
                                        src="{{ asset('storage/' . $conference->poster) }}"
                                        alt="{{ $conference->title }}"
                                        loading="lazy"
                                    >

                                @endif

                            </div>



                            <div class="bd-conf-other-copy">


                                @if($conferenceDate)

                                    <div class="bd-conf-other-date">

                                        {{
                                            $conferenceDate
                                                ->translatedFormat(
                                                    'd F Y'
                                                )
                                        }}

                                        @if($status)

                                            · {{ $status }}

                                        @endif

                                    </div>

                                @endif


                                <h3 class="bd-conf-other-title">

                                    {{ $conference->title }}

                                </h3>



                                {{-- TIME + LOCATION --}}

                                <div class="bd-conf-other-info">


                                    @if($conferenceTime)

                                        <div class="bd-conf-info-item">

                                            <svg viewBox="0 0 24 24">

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="9"
                                                />

                                                <path d="M12 7v5l3 2"/>

                                            </svg>


                                            <span class="bd-conf-time-value">

                                                {{ $conferenceTime }}
                                                WIB

                                            </span>

                                        </div>

                                    @endif



                                    @if($conference->location)

                                        <div class="bd-conf-info-item">

                                            <svg viewBox="0 0 24 24">

                                                <path
                                                    d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="10"
                                                    r="2.5"
                                                />

                                            </svg>


                                            <span>

                                                {{ $conference->location }}

                                            </span>

                                        </div>

                                    @endif

                                </div>



                                @if($conference->description)

                                    <div
                                        class="
                                            bd-conf-other-description
                                            js-conf-desc
                                        "
                                    >

                                        <div class="bd-conf-other-description-inner">

                                            {!! $conference->description !!}

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </section>

            @endif

        @endif



        @if(
            method_exists($conferences, 'hasPages')
            &&
            $conferences->hasPages()
        )

            <div style="margin-top:38px;display:flex;justify-content:center;">

                {{
                    $conferences
                        ->onEachSide(1)
                        ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif

    </div>

</section>


<script>
(() => {

    const boxes =
        document.querySelectorAll(
            '#bdConferencePage .js-conf-desc'
        );


    boxes.forEach(box => {

        const content =
            box.firstElementChild;


        const checkOverflow = () => {

            box.classList.toggle(
                'has-overflow',
                content.scrollHeight >
                content.clientHeight + 2
            );

        };


        checkOverflow();


        box.addEventListener(
            'click',
            () => {

                if (
                    box.classList.contains(
                        'has-overflow'
                    )
                ) {
                    box.classList.add(
                        'is-scroll-active'
                    );
                }

            }
        );

    });

})();
</script>

@endsection