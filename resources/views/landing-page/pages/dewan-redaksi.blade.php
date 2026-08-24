@extends('layouts.app')

@section('content')

{{-- ================================================================
     TEAM BACA DULU
================================================================ --}}

<section
    id="team-bacadulu"
    class="scroll-mt-20 team-section"
>

    @php
        $teamMembers = config('team.members', []);
        $teamTotal   = count($teamMembers);
    @endphp


    <div class="team-container">

        {{-- ========================================================
             HEADER
        ========================================================= --}}

        <div class="team-header">

            <div class="team-eyebrow">

                BACA DULU

                <span class="team-eyebrow-dot"></span>

                {{ str_pad($teamTotal, 2, '0', STR_PAD_LEFT) }} PEOPLE

            </div>


            <h1 class="team-title">
                Our Team
            </h1>


            <p class="team-subtitle">
                Orang-orang di balik ide, karya, dan perjalanan Baca Dulu.
            </p>

        </div>



        {{-- ========================================================
             CAROUSEL
        ========================================================= --}}

        @if($teamTotal > 0)

            <div
                id="bd-team-carousel"
                class="team-carousel"
                data-total="{{ $teamTotal }}"
            >

                {{-- ====================================================
                     STAGE
                ===================================================== --}}

                <div class="team-stage">

                    @foreach($teamMembers as $index => $item)

                        @php

                            $position =
                                $item['jabatan']
                                ?? '';


                            if (is_array($position)) {

                                $position =
                                    implode(
                                        ' • ',
                                        $position
                                    );
                            }


                            $initials =
                                collect(
                                    explode(
                                        ' ',
                                        $item['nama']
                                    )
                                )
                                ->filter()
                                ->map(
                                    fn ($word) =>
                                        mb_substr(
                                            $word,
                                            0,
                                            1
                                        )
                                )
                                ->take(2)
                                ->implode('');

                        @endphp


                        <a
                            href="{{ route(
                                'team.show',
                                $item['slug']
                            ) }}"
                            class="team-person-card"
                            data-team-index="{{ $index }}"
                            aria-label="Lihat profil {{ $item['nama'] }}"
                        >


                            {{-- =========================================
                                 IMAGE
                            ========================================== --}}

                            <div class="team-person-image">

                                <img
                                    src="{{ asset($item['img']) }}"
                                    alt="{{ $item['nama'] }}"
                                    draggable="false"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >


                                {{-- FALLBACK --}}
                                <div
                                    class="team-photo-fallback"
                                    style="display:none;"
                                >
                                    {{ $initials }}
                                </div>

                            </div>



                            {{-- =========================================
                                 OVERLAY
                            ========================================== --}}

                            <div class="team-photo-overlay"></div>



                            {{-- =========================================
                                 SIDE NAME
                            ========================================== --}}

                            <div class="team-side-information">

                                <span class="team-side-name">
                                    {{ $item['nama'] }}
                                </span>

                            </div>



                            {{-- =========================================
                                 ACTIVE INFORMATION
                            ========================================== --}}

                            <div class="team-active-information">

                                @if(!empty($position))

                                    <p class="team-active-role">
                                        {{ $position }}
                                    </p>

                                @endif


                                <h2 class="team-active-name">
                                    {{ $item['nama'] }}
                                </h2>


                                <div class="team-active-line"></div>


                                <div class="team-active-actions">

                                    <span class="team-profile-text">

                                        Lihat Profil

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 12h14M13 6l6 6-6 6"
                                            />

                                        </svg>

                                    </span>


                                    @if(!empty($item['scholar']))

                                        <span class="team-scholar-dot"></span>

                                        <span class="team-scholar-text">
                                            Google Scholar
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>



                {{-- ====================================================
                     CONTROLS
                ===================================================== --}}

                <div class="team-controls">


                    {{-- =============================================
                         COUNTER
                    ============================================== --}}

                    <div class="team-counter">

                        <span id="team-current-number">
                            01
                        </span>


                        <span class="team-counter-slash">
                            /
                        </span>


                        <span>
                            {{ str_pad(
                                $teamTotal,
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </span>

                    </div>



                    {{-- =============================================
                         PROGRESS
                    ============================================== --}}

                    <div class="team-progress">

                        @foreach($teamMembers as $index => $item)

                            <span
                                class="team-progress-item {{ $index === 0 ? 'is-active' : '' }}"
                                data-progress-index="{{ $index }}"
                            ></span>

                        @endforeach

                    </div>



                    {{-- =============================================
                         ARROW
                    ============================================== --}}

                    <div class="team-arrow-wrapper">

                        <button
                            type="button"
                            id="team-prev"
                            class="team-arrow"
                            aria-label="Anggota sebelumnya"
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


                        <button
                            type="button"
                            id="team-next"
                            class="team-arrow team-arrow-dark"
                            aria-label="Anggota berikutnya"
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

                </div>



                {{-- ====================================================
                     NAVIGATION HINT
                ===================================================== --}}

                <div class="team-interaction-hint">

                    <span class="team-hint-line"></span>

                    <span>
                        USE ARROWS
                    </span>

                    <span class="team-hint-line"></span>

                </div>

            </div>


        @else

            <div class="team-empty">
                Data Team Baca Dulu belum tersedia.
            </div>

        @endif

    </div>

</section>



{{-- ================================================================
     NILAI-NILAI PERUSAHAAN
================================================================ --}}

<section
    id="nilai-perusahaan"
    class="scroll-mt-20 relative py-24 w-full bg-slate-50 overflow-hidden"
>

    <div
        class="
            absolute
            top-1/2
            left-1/2
            -translate-x-1/2
            -translate-y-1/2
            w-[600px]
            h-[600px]
            bg-orange-100/40
            rounded-full
            blur-3xl
            -z-10
        "
    ></div>


    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-16">

            <span
                class="
                    inline-block
                    text-orange-600
                    text-xs
                    font-bold
                    uppercase
                    tracking-widest
                    mb-3
                "
            >
                Yang Kami Pegang Teguh
            </span>


            <h2
                class="
                    text-4xl
                    md:text-5xl
                    font-extrabold
                    text-slate-900
                    mb-3
                "
            >

                Nilai-Nilai

                <span class="text-orange-600">
                    Bacadulu
                </span>

            </h2>


            <div
                class="
                    w-16
                    h-1
                    bg-orange-500
                    mx-auto
                    rounded-full
                "
            ></div>

        </div>



        @php

            $nilai = [

                [
                    'judul' =>
                        'Objektif Dan Netral',

                    'desc' =>
                        'Kami menyajikan informasi tanpa bias untuk mendukung keputusan yang lebih baik.',

                    'icon' =>
                        'M5 13l4 4L19 7',
                ],

                [
                    'judul' =>
                        'Up To Date',

                    'desc' =>
                        'Informasi dan data yang kami sajikan selalu terkini dan relevan dengan perkembangan terbaru.',

                    'icon' =>
                        'M13 10V3L4 14h7v7l9-11h-7z',
                ],

                [
                    'judul' =>
                        'Valid Dan Akurat',

                    'desc' =>
                        'Setiap konten melalui proses verifikasi untuk memastikan validitas dan akurasi data.',

                    'icon' =>
                        'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0',
                ],

            ];

        @endphp



        <div
            class="
                grid
                grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-3
                gap-6
            "
        >

            @foreach($nilai as $n)

                <div
                    class="
                        fade-in-card
                        bg-white/60
                        backdrop-blur-lg
                        rounded-2xl
                        border
                        border-orange-100
                        p-8
                        text-center
                        shadow-md
                        shadow-orange-900/5
                        hover:shadow-xl
                        hover:-translate-y-1
                        transition-all
                        duration-300
                    "
                >

                    <div
                        class="
                            w-14
                            h-14
                            mx-auto
                            mb-5
                            rounded-2xl
                            bg-orange-500/10
                            flex
                            items-center
                            justify-center
                        "
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="
                                w-7
                                h-7
                                text-orange-600
                            "
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="{{ $n['icon'] }}"
                            />

                        </svg>

                    </div>


                    <h3
                        class="
                            font-bold
                            text-slate-900
                            mb-2
                        "
                    >
                        {{ $n['judul'] }}
                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                        "
                    >
                        {{ $n['desc'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>



{{-- ================================================================
     VISI & MISI
================================================================ --}}

<section
    id="visi-misi"
    class="
        scroll-mt-20
        py-24
        bg-white
        relative
        overflow-hidden
    "
>

    <div
        class="
            absolute
            top-0
            -right-32
            w-96
            h-96
            bg-orange-100/50
            rounded-full
            blur-3xl
            -z-10
        "
    ></div>


    <div
        class="
            absolute
            bottom-0
            -left-32
            w-80
            h-80
            bg-orange-50
            rounded-full
            blur-3xl
            -z-10
        "
    ></div>


    <div
        class="
            max-w-7xl
            mx-auto
            px-6
            lg:px-8
        "
    >

        <div
            class="
                grid
                grid-cols-1
                lg:grid-cols-12
                gap-12
                items-center
            "
        >


            {{-- =====================================================
                 LEFT
            ====================================================== --}}

            <div class="lg:col-span-5">

                <span
                    class="
                        text-orange-600
                        text-xs
                        font-bold
                        tracking-widest
                        uppercase
                    "
                >
                    Our Purpose
                </span>


                <h2
                    class="
                        text-3xl
                        sm:text-4xl
                        font-extrabold
                        text-slate-900
                        mt-2
                    "
                >
                    Visi & Misi Kami
                </h2>


                <p
                    class="
                        text-slate-500
                        text-sm
                        mt-4
                        leading-relaxed
                    "
                >
                    Kami hadir untuk menjembatani ide-ide cemerlang akademisi
                    dan para penulis hebat dengan pembaca di seluruh penjuru
                    negeri melalui platform literasi modern.
                </p>


                <div
                    class="
                        mt-8
                        border-l-4
                        border-orange-500
                        pl-4
                        italic
                        text-slate-600
                        text-sm
                    "
                >
                    "Membaca membuka jendela dunia, menulis membangun jembatan peradaban."
                </div>

            </div>



            {{-- =====================================================
                 RIGHT
            ====================================================== --}}

            <div
                class="
                    lg:col-span-7
                    flex
                    flex-col
                    gap-6
                "
            >


                {{-- VISI --}}
                <div
                    class="
                        bg-white/70
                        backdrop-blur-xl
                        p-6
                        rounded-2xl
                        border
                        border-white/60
                        shadow-lg
                        shadow-orange-900/5
                        hover:shadow-xl
                        hover:shadow-orange-900/10
                        hover:-translate-y-0.5
                        transition-all
                        duration-300
                    "
                >

                    <h3
                        class="
                            text-lg
                            font-bold
                            text-slate-900
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <span class="text-orange-500 text-xl">
                            🎯
                        </span>

                        Visi Kami

                    </h3>


                    <p
                        class="
                            text-xs
                            text-slate-500
                            mt-2
                            leading-relaxed
                        "
                    >
                        Menjadi penyedia utama pendidikan dan pelatihan berbasis
                        informasi yang berkualitas, membangun budaya literasi
                        yang kuat untuk mendukung pembelajaran berkelanjutan,
                        serta menjadi pusat referensi unggulan dalam pengembangan
                        literasi dan keahlian melalui pelatihan berbasis data.
                    </p>

                </div>



                {{-- MISI --}}
                <div
                    class="
                        bg-white/70
                        backdrop-blur-xl
                        p-6
                        rounded-2xl
                        border
                        border-white/60
                        shadow-lg
                        shadow-orange-900/5
                        hover:shadow-xl
                        hover:shadow-orange-900/10
                        hover:-translate-y-0.5
                        transition-all
                        duration-300
                    "
                >

                    <h3
                        class="
                            text-lg
                            font-bold
                            text-slate-900
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <span class="text-orange-500 text-xl">
                            ⚡
                        </span>

                        Misi Kami

                    </h3>


                    <ul
                        class="
                            text-xs
                            text-slate-500
                            mt-2
                            space-y-2
                            list-disc
                            list-inside
                            leading-relaxed
                        "
                    >

                        <li>
                            Menyediakan informasi yang objektif dan netral.
                        </li>

                        <li>
                            Menyediakan informasi yang up to date atau terkini.
                        </li>

                        <li>
                            Menyediakan informasi yang valid dan akurat.
                        </li>

                        <li>
                            Menyediakan data dan informasi yang dapat digunakan
                            dalam pengambilan keputusan bagi berbagai stakeholder.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ================================================================
     STYLE + SCRIPT
================================================================ --}}

@push('scripts')

<style>

    html {
        scroll-behavior: smooth;
    }


    /* ============================================================
       TEAM
    ============================================================ */

    .team-section {

        position: relative;

        width: 100%;

        overflow: hidden;

        padding:
            74px 0 82px;

        background:
            radial-gradient(
                circle at 50% 77%,
                rgba(239, 88, 67, .065),
                transparent 34%
            ),
            #f8f7f2;

    }


    .team-container {

        width: 100%;

        max-width: 1260px;

        margin: 0 auto;

        padding:
            0 24px;

    }



    /* ============================================================
       HEADER
    ============================================================ */

    .team-header {

        position: relative;

        z-index: 20;

        text-align: center;

        margin-bottom:
            16px;

    }


    .team-eyebrow {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        margin-bottom:
            11px;

        color:
            #928980;

        font-size:
            9px;

        line-height:
            1;

        font-weight:
            800;

        letter-spacing:
            .24em;

        text-transform:
            uppercase;

    }


    .team-eyebrow-dot {

        width: 4px;

        height: 4px;

        border-radius:
            999px;

        background:
            #ef5843;

    }


    .team-title {

        margin: 0;

        color:
            #171717;

        font-size:
            clamp(
                32px,
                3.2vw,
                47px
            );

        line-height:
            1;

        font-weight:
            900;

        letter-spacing:
            -.05em;

    }


    .team-subtitle {

        max-width:
            430px;

        margin:
            11px auto 0;

        color:
            #98918b;

        font-size:
            11px;

        line-height:
            1.6;

    }



    /* ============================================================
       CAROUSEL
    ============================================================ */

    .team-carousel {

        position: relative;

        width: 100%;

        user-select: none;

        -webkit-user-select: none;

    }


    .team-stage {

        position: relative;

        width: 100%;

        height:
            510px;

        perspective:
            1500px;

        overflow: hidden;

    }



    /* ============================================================
       PERSON CARD
    ============================================================ */

    .team-person-card {

        --x: 0px;
        --y: 0px;
        --scale: 1;
        --rotate: 0deg;
        --opacity: 1;

        position: absolute;

        top:
            36px;

        left:
            50%;

        width:
            268px;

        height:
            392px;

        overflow:
            hidden;

        border-radius:
            26px;

        background:
            #252525;

        box-shadow:
            0 18px 42px
            rgba(15,23,42,.09);

        transform:
            translateX(
                calc(
                    -50% + var(--x)
                )
            )
            translateY(
                var(--y)
            )
            scale(
                var(--scale)
            )
            rotateY(
                var(--rotate)
            );

        opacity:
            var(--opacity);

        transform-origin:
            center center;

        transition:
            transform
            .68s
            cubic-bezier(.22,1,.36,1),

            opacity
            .48s ease,

            box-shadow
            .45s ease;

        text-decoration:
            none !important;

        will-change:
            transform,
            opacity;

        -webkit-tap-highlight-color:
            transparent;

    }


    .team-person-card.is-active {

        border-radius:
            30px;

        box-shadow:
            0 30px 65px
            rgba(15,23,42,.20);

    }



    /* ============================================================
       IMAGE
    ============================================================ */

    .team-person-image {

        position:
            absolute;

        inset:
            0;

        width:
            100%;

        height:
            100%;

        overflow:
            hidden;

        border-radius:
            inherit;

        background:
            #292929;

    }


    .team-person-image img {

        display:
            block;

        width:
            100%;

        height:
            100%;

        object-fit:
            cover;

        object-position:
            center center;

        pointer-events:
            none;

        transform:
            scale(1.035);

        filter:
            grayscale(1)
            saturate(0)
            brightness(.68)
            contrast(1.04);

        transition:
            filter .58s
            cubic-bezier(.22,1,.36,1),

            transform .70s
            cubic-bezier(.22,1,.36,1);

    }


    .team-person-card.is-active
    .team-person-image img {

        transform:
            scale(1);

        filter:
            grayscale(0)
            saturate(.95)
            brightness(.96)
            contrast(1.02);

    }



    /* ============================================================
       FALLBACK
    ============================================================ */

    .team-photo-fallback {

        position:
            absolute;

        inset:
            0;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            inherit;

        background:
            linear-gradient(
                145deg,
                #373737,
                #202020
            );

        color:
            rgba(255,255,255,.72);

        font-size:
            40px;

        font-weight:
            900;

        letter-spacing:
            -.05em;

    }



    /* ============================================================
       OVERLAY
    ============================================================ */

    .team-photo-overlay {

        position:
            absolute;

        inset:
            0;

        z-index:
            2;

        border-radius:
            inherit;

        pointer-events:
            none;

        background:
            linear-gradient(
                180deg,
                rgba(0,0,0,.01) 0%,
                rgba(0,0,0,.03) 48%,
                rgba(0,0,0,.83) 100%
            );

        transition:
            background .45s ease;

    }


    .team-person-card:not(.is-active)
    .team-photo-overlay {

        background:
            linear-gradient(
                180deg,
                rgba(0,0,0,.11) 0%,
                rgba(0,0,0,.13) 45%,
                rgba(0,0,0,.82) 100%
            );

    }



    /* ============================================================
       ACTIVE INFORMATION
    ============================================================ */

    .team-active-information {

        position:
            absolute;

        z-index:
            4;

        left:
            21px;

        right:
            21px;

        bottom:
            21px;

        color:
            white;

        opacity:
            0;

        transform:
            translateY(12px);

        transition:
            opacity .30s ease,

            transform .44s
            cubic-bezier(.22,1,.36,1);

        pointer-events:
            none;

    }


    .team-person-card.is-active
    .team-active-information {

        opacity:
            1;

        transform:
            translateY(0);

    }


    .team-active-role {

        margin:
            0 0 5px;

        color:
            rgba(255,255,255,.70);

        font-size:
            9px;

        font-weight:
            500;

        line-height:
            1.4;

    }


    .team-active-name {

        margin:
            0;

        color:
            white;

        font-size:
            18px;

        line-height:
            1.12;

        font-weight:
            800;

        letter-spacing:
            -.025em;

    }


    .team-active-line {

        width:
            30px;

        height:
            2px;

        margin-top:
            9px;

        border-radius:
            999px;

        background:
            #ef5843;

    }


    .team-active-actions {

        display:
            flex;

        align-items:
            center;

        gap:
            7px;

        margin-top:
            10px;

        opacity:
            .84;

    }


    .team-profile-text,
    .team-scholar-text {

        display:
            inline-flex;

        align-items:
            center;

        gap:
            5px;

        color:
            rgba(255,255,255,.85);

        font-size:
            8px;

        line-height:
            1;

        font-weight:
            600;

    }


    .team-profile-text svg {

        width:
            10px;

        height:
            10px;

    }


    .team-scholar-dot {

        width:
            2px;

        height:
            2px;

        border-radius:
            999px;

        background:
            rgba(255,255,255,.62);

    }



    /* ============================================================
       SIDE INFORMATION
    ============================================================ */

    .team-side-information {

        position:
            absolute;

        z-index:
            4;

        left:
            17px;

        right:
            17px;

        bottom:
            18px;

        opacity:
            .68;

        transition:
            opacity .3s ease;

    }


    .team-side-name {

        display:
            block;

        color:
            rgba(255,255,255,.76);

        font-size:
            8px;

        font-weight:
            600;

        line-height:
            1.3;

    }


    .team-person-card.is-active
    .team-side-information {

        opacity:
            0;

    }



    /* ============================================================
       CONTROLS
    ============================================================ */

    .team-controls {

        position:
            relative;

        z-index:
            50;

        display:
            grid;

        grid-template-columns:
            1fr auto 1fr;

        align-items:
            center;

        width:
            100%;

        max-width:
            720px;

        margin:
            -25px auto 0;

    }



    /* ============================================================
       COUNTER
    ============================================================ */

    .team-counter {

        justify-self:
            start;

        display:
            flex;

        align-items:
            center;

        gap:
            5px;

        color:
            #948b84;

        font-size:
            9px;

        font-weight:
            700;

        letter-spacing:
            .08em;

    }


    #team-current-number {

        color:
            #ef5843;

    }


    .team-counter-slash {

        opacity:
            .4;

    }



    /* ============================================================
       PROGRESS
    ============================================================ */

    .team-progress {

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            5px;

    }


    .team-progress-item {

        display:
            block;

        width:
            16px;

        height:
            1px;

        background:
            #dad4ce;

        border-radius:
            999px;

        transition:
            width .42s ease,
            background .42s ease;

    }


    .team-progress-item.is-active {

        width:
            35px;

        height:
            2px;

        background:
            #ef5843;

    }



    /* ============================================================
       ARROW
    ============================================================ */

    .team-arrow-wrapper {

        justify-self:
            end;

        display:
            flex;

        align-items:
            center;

        gap:
            8px;

    }


    .team-arrow {

        width:
            38px;

        height:
            38px;

        padding:
            0;

        border:
            1px solid #d9d3cd;

        border-radius:
            999px;

        background:
            rgba(255,255,255,.40);

        color:
            #766e68;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        cursor:
            pointer;

        transition:
            transform .25s ease,
            background .25s ease,
            border-color .25s ease,
            color .25s ease,
            box-shadow .25s ease;

    }


    .team-arrow svg {

        width:
            15px;

        height:
            15px;

    }


    .team-arrow:hover {

        transform:
            translateY(-2px);

        background:
            white;

        border-color:
            #bbb3ac;

        box-shadow:
            0 7px 17px
            rgba(15,23,42,.07);

    }


    .team-arrow-dark {

        border-color:
            #191919;

        background:
            #191919;

        color:
            white;

        box-shadow:
            0 8px 18px
            rgba(15,23,42,.13);

    }


    .team-arrow-dark:hover {

        color:
            white;

        background:
            #ef5843;

        border-color:
            #ef5843;

        box-shadow:
            0 9px 20px
            rgba(239,88,67,.22);

    }



    /* ============================================================
       HINT
    ============================================================ */

    .team-interaction-hint {

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            10px;

        margin-top:
            16px;

        color:
            #aaa19b;

        font-size:
            7px;

        line-height:
            1;

        font-weight:
            800;

        letter-spacing:
            .20em;

    }


    .team-hint-line {

        width:
            17px;

        height:
            1px;

        background:
            #d8d1cb;

    }



    /* ============================================================
       EMPTY
    ============================================================ */

    .team-empty {

        max-width:
            620px;

        margin:
            50px auto;

        padding:
            50px 24px;

        text-align:
            center;

        border:
            1px solid #e7e3df;

        border-radius:
            24px;

        color:
            #928a84;

        font-size:
            13px;

    }



    /* ============================================================
       FADE
    ============================================================ */

    .fade-in-card {

        opacity:
            0;

        transform:
            translateY(30px);

        transition:
            opacity .6s ease-out,
            transform .6s ease-out;

    }


    .fade-in-card.visible {

        opacity:
            1;

        transform:
            translateY(0);

    }



    /* ============================================================
       TABLET
    ============================================================ */

    @media (max-width: 1023px) {

        .team-section {

            padding:
                62px 0 70px;

        }


        .team-stage {

            height:
                465px;

        }


        .team-person-card {

            width:
                244px;

            height:
                358px;

            border-radius:
                24px;

        }


        .team-person-card.is-active {

            border-radius:
                28px;

        }


        .team-controls {

            max-width:
                590px;

        }

    }



    /* ============================================================
       MOBILE
    ============================================================ */

    @media (max-width: 639px) {

        .team-container {

            padding:
                0 14px;

        }


        .team-section {

            padding:
                52px 0 58px;

        }


        .team-eyebrow {

            font-size:
                8px;

        }


        .team-title {

            font-size:
                31px;

        }


        .team-subtitle {

            max-width:
                290px;

            font-size:
                10px;

        }


        .team-header {

            margin-bottom:
                7px;

        }


        .team-stage {

            height:
                410px;

            margin-left:
                -14px;

            width:
                calc(
                    100% + 28px
                );

        }


        .team-person-card {

            top:
                30px;

            width:
                218px;

            height:
                326px;

            border-radius:
                22px;

        }


        .team-person-card.is-active {

            border-radius:
                26px;

        }


        .team-active-name {

            font-size:
                15px;

        }


        .team-active-role {

            font-size:
                8px;

        }


        .team-controls {

            max-width:
                100%;

            grid-template-columns:
                auto 1fr auto;

            gap:
                12px;

            margin-top:
                -12px;

            padding:
                0 3px;

        }


        .team-progress {

            gap:
                4px;

        }


        .team-progress-item {

            width:
                9px;

        }


        .team-progress-item.is-active {

            width:
                22px;

        }


        .team-arrow {

            width:
                34px;

            height:
                34px;

        }


        .team-interaction-hint {

            margin-top:
                13px;

        }

    }



    /* ============================================================
       REDUCED MOTION
    ============================================================ */

    @media (prefers-reduced-motion: reduce) {

        .team-person-card,
        .team-person-image img,
        .team-active-information,
        .team-progress-item {

            transition:
                none !important;

        }

    }

</style>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | TEAM CAROUSEL
        |--------------------------------------------------------------------------
        */

        const carousel =
            document.getElementById(
                'bd-team-carousel'
            );


        if (carousel) {

            const cards =
                Array.from(
                    carousel.querySelectorAll(
                        '[data-team-index]'
                    )
                );


            const progressItems =
                Array.from(
                    carousel.querySelectorAll(
                        '[data-progress-index]'
                    )
                );


            const prevButton =
                document.getElementById(
                    'team-prev'
                );


            const nextButton =
                document.getElementById(
                    'team-next'
                );


            const currentNumber =
                document.getElementById(
                    'team-current-number'
                );


            const total =
                cards.length;


            let activeIndex =
                0;



            /*
            |--------------------------------------------------------------------------
            | LOOP OFFSET
            |--------------------------------------------------------------------------
            */

            function getOffset(
                index
            ) {

                let offset =
                    index -
                    activeIndex;


                const half =
                    total / 2;


                if (
                    offset >
                    half
                ) {

                    offset -=
                        total;

                }


                if (
                    offset <
                    -half
                ) {

                    offset +=
                        total;

                }


                return offset;

            }



            /*
            |--------------------------------------------------------------------------
            | POSISI CARD
            |--------------------------------------------------------------------------
            */

            function getCardSettings(
                offset
            ) {

                const absolute =
                    Math.abs(
                        offset
                    );


                const width =
                    window.innerWidth;


                let step =
                    183;


                if (
                    width <
                    640
                ) {

                    step =
                        143;


                } else if (
                    width <
                    1024
                ) {

                    step =
                        164;

                }



                /*
                |--------------------------------------------------------------------------
                | ACTIVE
                |--------------------------------------------------------------------------
                */

                if (
                    absolute === 0
                ) {

                    return {

                        x:
                            0,

                        y:
                            0,

                        scale:
                            1,

                        rotate:
                            0,

                        opacity:
                            1,

                        z:
                            50,

                    };

                }



                /*
                |--------------------------------------------------------------------------
                | SIDE 1
                |--------------------------------------------------------------------------
                */

                if (
                    absolute === 1
                ) {

                    return {

                        x:
                            offset *
                            step,

                        y:
                            22,

                        scale:
                            .91,

                        rotate:
                            offset > 0
                                ? -2.7
                                : 2.7,

                        opacity:
                            .96,

                        z:
                            35,

                    };

                }



                /*
                |--------------------------------------------------------------------------
                | SIDE 2
                |--------------------------------------------------------------------------
                */

                if (
                    absolute === 2
                ) {

                    return {

                        x:
                            offset *
                            (
                                step -
                                12
                            ),

                        y:
                            40,

                        scale:
                            .82,

                        rotate:
                            offset > 0
                                ? -4
                                : 4,

                        opacity:
                            .80,

                        z:
                            25,

                    };

                }



                /*
                |--------------------------------------------------------------------------
                | SIDE 3
                |--------------------------------------------------------------------------
                */

                if (
                    absolute === 3
                ) {

                    return {

                        x:
                            offset *
                            (
                                step -
                                18
                            ),

                        y:
                            55,

                        scale:
                            .74,

                        rotate:
                            offset > 0
                                ? -5
                                : 5,

                        opacity:
                            .53,

                        z:
                            15,

                    };

                }



                /*
                |--------------------------------------------------------------------------
                | HIDDEN
                |--------------------------------------------------------------------------
                */

                return {

                    x:
                        offset *
                        step,

                    y:
                        65,

                    scale:
                        .69,

                    rotate:
                        0,

                    opacity:
                        0,

                    z:
                        1,

                };

            }



            /*
            |--------------------------------------------------------------------------
            | RENDER
            |--------------------------------------------------------------------------
            */

            function renderCarousel() {

                cards.forEach(
                    function (
                        card,
                        index
                    ) {

                        const offset =
                            getOffset(
                                index
                            );


                        const settings =
                            getCardSettings(
                                offset
                            );


                        card
                            .style
                            .setProperty(
                                '--x',
                                `${settings.x}px`
                            );


                        card
                            .style
                            .setProperty(
                                '--y',
                                `${settings.y}px`
                            );


                        card
                            .style
                            .setProperty(
                                '--scale',
                                settings.scale
                            );


                        card
                            .style
                            .setProperty(
                                '--rotate',
                                `${settings.rotate}deg`
                            );


                        card
                            .style
                            .setProperty(
                                '--opacity',
                                settings.opacity
                            );


                        card.style.zIndex =
                            settings.z;


                        card
                            .classList
                            .toggle(
                                'is-active',
                                offset === 0
                            );

                    }
                );



                /*
                |--------------------------------------------------------------------------
                | PROGRESS
                |--------------------------------------------------------------------------
                */

                progressItems.forEach(
                    function (
                        item,
                        index
                    ) {

                        item
                            .classList
                            .toggle(
                                'is-active',
                                index ===
                                activeIndex
                            );

                    }
                );



                /*
                |--------------------------------------------------------------------------
                | NUMBER
                |--------------------------------------------------------------------------
                */

                if (
                    currentNumber
                ) {

                    currentNumber
                        .textContent =
                            String(
                                activeIndex + 1
                            )
                            .padStart(
                                2,
                                '0'
                            );

                }

            }



            /*
            |--------------------------------------------------------------------------
            | GO TO
            |--------------------------------------------------------------------------
            */

            function goTo(
                index
            ) {

                if (
                    total <=
                    0
                ) {

                    return;

                }


                activeIndex =
                    (
                        index +
                        total
                    )
                    %
                    total;


                renderCarousel();

            }



            /*
            |--------------------------------------------------------------------------
            | NEXT
            |--------------------------------------------------------------------------
            */

            function next() {

                goTo(
                    activeIndex +
                    1
                );

            }



            /*
            |--------------------------------------------------------------------------
            | PREVIOUS
            |--------------------------------------------------------------------------
            */

            function previous() {

                goTo(
                    activeIndex -
                    1
                );

            }



            /*
            |--------------------------------------------------------------------------
            | ARROW ONLY NAVIGATION
            |--------------------------------------------------------------------------
            |
            | Tidak ada:
            |
            | - mouse wheel
            | - page scroll navigation
            | - drag
            | - swipe
            | - keyboard navigation
            |
            | Team hanya berpindah melalui arrow.
            |
            |--------------------------------------------------------------------------
            */

            if (
                prevButton
            ) {

                prevButton
                    .addEventListener(
                        'click',
                        previous
                    );

            }


            if (
                nextButton
            ) {

                nextButton
                    .addEventListener(
                        'click',
                        next
                    );

            }



            /*
            |--------------------------------------------------------------------------
            | INACTIVE CARD
            |--------------------------------------------------------------------------
            |
            | Agar kartu samping tidak langsung membuka profil.
            | Profile hanya bisa dibuka dari card yang sedang di tengah.
            |
            |--------------------------------------------------------------------------
            */

            cards.forEach(
                function (
                    card
                ) {

                    card
                        .addEventListener(
                            'click',
                            function (
                                event
                            ) {

                                const index =
                                    Number(
                                        card
                                            .dataset
                                            .teamIndex
                                    );


                                if (
                                    index !==
                                    activeIndex
                                ) {

                                    event.preventDefault();

                                }

                            }
                        );

                }
            );



            /*
            |--------------------------------------------------------------------------
            | RESPONSIVE
            |--------------------------------------------------------------------------
            */

            let resizeTimer;


            window
                .addEventListener(
                    'resize',
                    function () {

                        clearTimeout(
                            resizeTimer
                        );


                        resizeTimer =
                            window.setTimeout(
                                renderCarousel,
                                120
                            );

                    }
                );



            /*
            |--------------------------------------------------------------------------
            | INITIAL
            |--------------------------------------------------------------------------
            */

            renderCarousel();

        }



        /*
        |--------------------------------------------------------------------------
        | FADE IN NILAI
        |--------------------------------------------------------------------------
        */

        const valueCards =
            document
                .querySelectorAll(
                    '.fade-in-card'
                );


        if (
            'IntersectionObserver'
            in window
        ) {

            const observer =
                new IntersectionObserver(
                    function (
                        entries
                    ) {

                        entries.forEach(
                            function (
                                entry,
                                index
                            ) {

                                if (
                                    entry
                                        .isIntersecting
                                ) {

                                    setTimeout(
                                        function () {

                                            entry
                                                .target
                                                .classList
                                                .add(
                                                    'visible'
                                                );

                                        },
                                        index *
                                        80
                                    );


                                    observer
                                        .unobserve(
                                            entry.target
                                        );

                                }

                            }
                        );

                    },
                    {
                        threshold:
                            .12
                    }
                );


            valueCards
                .forEach(
                    function (
                        card
                    ) {

                        observer.observe(
                            card
                        );

                    }
                );


        } else {

            valueCards
                .forEach(
                    function (
                        card
                    ) {

                        card
                            .classList
                            .add(
                                'visible'
                            );

                    }
                );

        }

    }
);

</script>

@endpush

@endsection