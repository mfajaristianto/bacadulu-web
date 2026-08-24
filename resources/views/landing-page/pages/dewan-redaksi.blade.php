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

@php
    $nilai = [
        [
            'judul' => 'Objektif Dan Netral',
            'desc' => 'Kami menyajikan informasi tanpa bias untuk mendukung keputusan yang lebih baik.',
            'icon' => 'check',
        ],
        [
            'judul' => 'Up To Date',
            'desc' => 'Informasi dan data yang kami sajikan selalu terkini dan relevan dengan perkembangan terbaru.',
            'icon' => 'bolt',
        ],
        [
            'judul' => 'Valid Dan Akurat',
            'desc' => 'Setiap konten melalui proses verifikasi untuk memastikan validitas dan akurasi data.',
            'icon' => 'shield',
        ],
    ];
@endphp

<section id="nilai-perusahaan" class="scroll-mt-20 bd-values-section">
    <div class="bd-values-grid"></div>
    <div class="bd-values-orb bd-values-orb-one"></div>
    <div class="bd-values-orb bd-values-orb-two"></div>

    <div class="bd-values-container">
        <div class="bd-values-header">
            <div class="bd-values-eyebrow">
                <span class="bd-values-eyebrow-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                    </svg>
                </span>
                <span>Yang Kami Pegang Teguh</span>
            </div>

            <h2 class="bd-values-title">
                Nilai-Nilai <span>Bacadulu</span>
            </h2>

            <p class="bd-values-subtitle">
                Prinsip yang menjadi dasar dalam menyajikan informasi, membangun kepercayaan, dan memberikan manfaat kepada pembaca.
            </p>

            <div class="bd-values-title-line">
                <span></span>
            </div>
        </div>

        <div class="bd-values-cards">
            @foreach($nilai as $index => $n)
                <article class="bd-value-card" data-value-index="{{ $index }}">
                    <span class="bd-value-number">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <div class="bd-value-glow"></div>
                    <div class="bd-value-shine"></div>

                    <div class="bd-value-icon">
                        @if($n['icon'] === 'check')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12l2.7 2.7L16.5 9"/>
                            </svg>
                        @elseif($n['icon'] === 'bolt')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 2L4 14h7v8l9-12h-7V2z"/>
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                            </svg>
                        @endif
                    </div>

                    <div class="bd-value-content">
                        <h3>{{ $n['judul'] }}</h3>
                        <p>{{ $n['desc'] }}</p>
                    </div>

                    <div class="bd-value-bottom">
                        <span></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M14 7l5 5-5 5"/>
                        </svg>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>


{{-- ================================================================
     VISI & MISI
================================================================ --}}

<section id="visi-misi" class="scroll-mt-20 bd-purpose-section">
    <div class="bd-purpose-grid"></div>
    <div class="bd-purpose-orb bd-purpose-orb-one"></div>
    <div class="bd-purpose-orb bd-purpose-orb-two"></div>

    <div class="bd-purpose-container">
        <div class="bd-purpose-layout">
            <div class="bd-purpose-copy">
                <div class="bd-purpose-eyebrow">
                    <span class="bd-purpose-eyebrow-line"></span>
                    <span>Our Purpose</span>
                </div>

                <h2 class="bd-purpose-title">
                    Visi & Misi <span>Kami</span>
                </h2>

                <p class="bd-purpose-description">
                    Kami hadir untuk menjembatani ide-ide cemerlang akademisi dan para penulis hebat dengan pembaca di seluruh penjuru negeri melalui platform literasi modern.
                </p>

                <div class="bd-purpose-quote">
                    <div class="bd-purpose-quote-line"></div>
                    <div>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 11H5a4 4 0 014-4v4zm10 0h-4a4 4 0 014-4v4M5 11v6h4v-6M15 11v6h4v-6"/>
                        </svg>
                        <p>"Membaca membuka jendela dunia, menulis membangun jembatan peradaban."</p>
                    </div>
                </div>

                <div class="bd-purpose-indicator">
                    <span></span>
                    <small>Knowledge • Literacy • Impact</small>
                </div>
            </div>

            <div class="bd-purpose-cards">
                <article class="bd-purpose-card bd-vision-card">
                    <div class="bd-purpose-card-decoration"></div>

                    <div class="bd-purpose-card-head">
                        <div class="bd-purpose-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="8"/>
                                <circle cx="12" cy="12" r="3"/>
                                <path stroke-linecap="round" d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                            </svg>
                        </div>
                        <div>
                            <span>01</span>
                            <h3>Visi Kami</h3>
                        </div>
                    </div>

                    <div class="bd-purpose-card-line"></div>

                    <p>
                        Menjadi penyedia utama pendidikan dan pelatihan berbasis informasi yang berkualitas, membangun budaya literasi yang kuat untuk mendukung pembelajaran berkelanjutan, serta menjadi pusat referensi unggulan dalam pengembangan literasi dan keahlian melalui pelatihan berbasis data.
                    </p>

                    <div class="bd-purpose-card-footer">
                        <span>Vision</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M14 7l5 5-5 5"/>
                        </svg>
                    </div>
                </article>

                <article class="bd-purpose-card bd-mission-card">
                    <div class="bd-purpose-card-decoration"></div>

                    <div class="bd-purpose-card-head">
                        <div class="bd-purpose-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 2L4 14h7v8l9-12h-7V2z"/>
                            </svg>
                        </div>
                        <div>
                            <span>02</span>
                            <h3>Misi Kami</h3>
                        </div>
                    </div>

                    <div class="bd-purpose-card-line"></div>

                    <ul class="bd-mission-list">
                        <li>
                            <span class="bd-mission-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7"/>
                                </svg>
                            </span>
                            <p>Menyediakan informasi yang objektif dan netral.</p>
                        </li>
                        <li>
                            <span class="bd-mission-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7"/>
                                </svg>
                            </span>
                            <p>Menyediakan informasi yang up to date atau terkini.</p>
                        </li>
                        <li>
                            <span class="bd-mission-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7"/>
                                </svg>
                            </span>
                            <p>Menyediakan informasi yang valid dan akurat.</p>
                        </li>
                        <li>
                            <span class="bd-mission-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7"/>
                                </svg>
                            </span>
                            <p>Menyediakan data dan informasi yang dapat digunakan dalam pengambilan keputusan bagi berbagai stakeholder.</p>
                        </li>
                    </ul>

                    <div class="bd-purpose-card-footer">
                        <span>Mission</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M14 7l5 5-5 5"/>
                        </svg>
                    </div>
                </article>
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
       NILAI-NILAI & VISI MISI
    ============================================================ */

    .bd-values-section{position:relative;width:100%;padding:92px 0 100px;overflow:hidden;isolation:isolate;background:linear-gradient(180deg,#f8fafc 0%,#fffdfc 55%,#f8fafc 100%)}
    .bd-values-container{position:relative;z-index:3;width:100%;max-width:1150px;margin:0 auto;padding:0 24px}
    .bd-values-grid{position:absolute;inset:0;z-index:-3;opacity:.035;pointer-events:none;background-image:linear-gradient(#241b52 1px,transparent 1px),linear-gradient(90deg,#241b52 1px,transparent 1px);background-size:38px 38px}
    .bd-values-orb{position:absolute;z-index:-2;border-radius:999px;filter:blur(100px);pointer-events:none;will-change:transform}
    .bd-values-orb-one{width:430px;height:430px;top:-120px;left:-180px;background:rgba(239,88,67,.12)}
    .bd-values-orb-two{width:400px;height:400px;right:-190px;bottom:-150px;background:rgba(247,170,53,.13)}
    .bd-values-header{max-width:720px;margin:0 auto 50px;text-align:center}
    .bd-values-eyebrow{display:inline-flex;align-items:center;gap:8px;margin-bottom:11px;color:#ef5843;font-size:9px;line-height:1;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
    .bd-values-eyebrow-icon{width:25px;height:25px;display:flex;align-items:center;justify-content:center;border-radius:8px;background:#fff0ec}
    .bd-values-eyebrow-icon svg{width:14px;height:14px}
    .bd-values-title{margin:0;color:#171717;font-size:clamp(32px,4vw,48px);line-height:1.1;font-weight:900;letter-spacing:-.045em}
    .bd-values-title span{color:#ef5843}
    .bd-values-subtitle{max-width:590px;margin:13px auto 0;color:#7c8595;font-size:12px;line-height:1.75}
    .bd-values-title-line{width:74px;height:3px;margin:18px auto 0;overflow:hidden;border-radius:999px;background:#e8e4e1}
    .bd-values-title-line span{display:block;width:100%;height:100%;border-radius:inherit;background:linear-gradient(90deg,#ef5843,#f7aa35);transform-origin:left center}
    .bd-values-cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px;perspective:1200px}
    .bd-value-card{position:relative;min-height:250px;padding:29px 27px 25px;overflow:hidden;border:1px solid rgba(239,88,67,.14);border-radius:22px;background:rgba(255,255,255,.80);backdrop-filter:blur(14px);box-shadow:0 10px 30px rgba(36,27,82,.055);transform-style:preserve-3d;will-change:transform;transition:border-color .3s ease,box-shadow .35s ease,background .3s ease}
    .bd-value-card:hover{border-color:rgba(239,88,67,.36);background:#fff;box-shadow:0 25px 55px rgba(36,27,82,.11),0 10px 25px rgba(239,88,67,.05)}
    .bd-value-number{position:absolute;z-index:1;top:19px;right:22px;color:rgba(36,27,82,.07);font-size:44px;line-height:1;font-weight:900;letter-spacing:-.06em}
    .bd-value-glow{position:absolute;z-index:0;right:-95px;bottom:-95px;width:190px;height:190px;border-radius:50%;background:radial-gradient(circle,rgba(239,88,67,.14),transparent 68%);pointer-events:none}
    .bd-value-shine{position:absolute;z-index:6;top:-80%;left:-90px;width:36px;height:260%;opacity:0;pointer-events:none;background:linear-gradient(90deg,transparent,rgba(255,255,255,.75),transparent);transform:rotate(20deg)}
    .bd-value-icon{position:relative;z-index:3;width:54px;height:54px;display:flex;align-items:center;justify-content:center;margin-bottom:22px;border-radius:16px;color:#ef5843;background:linear-gradient(145deg,#fff3ee,#ffede7);box-shadow:0 10px 24px rgba(239,88,67,.10),inset 0 1px 0 rgba(255,255,255,.8)}
    .bd-value-icon svg{width:25px;height:25px}
    .bd-value-content{position:relative;z-index:3}
    .bd-value-content h3{margin:0 0 8px;color:#241b52;font-size:15px;line-height:1.35;font-weight:800}
    .bd-value-content p{margin:0;color:#7c8595;font-size:11px;line-height:1.75}
    .bd-value-bottom{position:absolute;z-index:3;left:27px;right:27px;bottom:20px;display:flex;align-items:center;justify-content:space-between}
    .bd-value-bottom span{width:27px;height:2px;border-radius:999px;background:#ef5843}
    .bd-value-bottom svg{width:15px;height:15px;stroke:#d5d9e0;transition:stroke .25s ease,transform .25s ease}
    .bd-value-card:hover .bd-value-bottom svg{stroke:#ef5843;transform:translateX(4px)}

    .bd-purpose-section{position:relative;width:100%;padding:100px 0;overflow:hidden;isolation:isolate;background:#fff}
    .bd-purpose-container{position:relative;z-index:3;width:100%;max-width:1180px;margin:0 auto;padding:0 24px}
    .bd-purpose-grid{position:absolute;inset:0;z-index:-3;opacity:.028;pointer-events:none;background-image:radial-gradient(circle,#241b52 1px,transparent 1px);background-size:27px 27px}
    .bd-purpose-orb{position:absolute;z-index:-2;border-radius:50%;filter:blur(105px);pointer-events:none;will-change:transform}
    .bd-purpose-orb-one{width:390px;height:390px;top:-160px;right:-170px;background:rgba(247,170,53,.14)}
    .bd-purpose-orb-two{width:380px;height:380px;bottom:-180px;left:-170px;background:rgba(239,88,67,.10)}
    .bd-purpose-layout{display:grid;grid-template-columns:minmax(0,.82fr) minmax(0,1.18fr);gap:70px;align-items:center}
    .bd-purpose-copy{position:relative}
    .bd-purpose-eyebrow{display:flex;align-items:center;gap:9px;color:#ef5843;font-size:9px;font-weight:800;letter-spacing:.2em;text-transform:uppercase}
    .bd-purpose-eyebrow-line{width:29px;height:2px;border-radius:999px;background:#ef5843}
    .bd-purpose-title{margin:12px 0 0;color:#171717;font-size:clamp(34px,4vw,50px);line-height:1.07;font-weight:900;letter-spacing:-.05em}
    .bd-purpose-title span{display:block;color:#ef5843}
    .bd-purpose-description{max-width:465px;margin:19px 0 0;color:#727d8e;font-size:12px;line-height:1.85}
    .bd-purpose-quote{position:relative;display:grid;grid-template-columns:3px 1fr;gap:15px;margin-top:30px}
    .bd-purpose-quote-line{width:3px;height:100%;min-height:68px;border-radius:999px;background:linear-gradient(180deg,#ef5843,#f7aa35);transform-origin:top center}
    .bd-purpose-quote>div:last-child{position:relative;padding:2px 0}
    .bd-purpose-quote svg{width:19px;height:19px;margin-bottom:7px;stroke:#ef5843}
    .bd-purpose-quote p{margin:0;color:#4f5968;font-size:11px;line-height:1.7;font-style:italic}
    .bd-purpose-indicator{display:flex;align-items:center;gap:9px;margin-top:28px}
    .bd-purpose-indicator span{width:8px;height:8px;border-radius:50%;background:#ef5843;box-shadow:0 0 0 5px rgba(239,88,67,.09)}
    .bd-purpose-indicator small{color:#a0a8b4;font-size:7px;font-weight:800;letter-spacing:.13em;text-transform:uppercase}
    .bd-purpose-cards{display:flex;flex-direction:column;gap:17px;perspective:1200px}
    .bd-purpose-card{position:relative;padding:25px 27px 21px;overflow:hidden;border:1px solid #ece9e6;border-radius:22px;background:rgba(255,255,255,.82);backdrop-filter:blur(16px);box-shadow:0 12px 35px rgba(36,27,82,.055);transform-style:preserve-3d;will-change:transform;transition:border-color .3s ease,box-shadow .35s ease,background .3s ease}
    .bd-purpose-card:hover{border-color:rgba(239,88,67,.30);background:#fff;box-shadow:0 26px 60px rgba(36,27,82,.11),0 10px 25px rgba(239,88,67,.045)}
    .bd-purpose-card-decoration{position:absolute;top:-75px;right:-75px;width:150px;height:150px;border:30px solid rgba(239,88,67,.025);border-radius:50%;pointer-events:none}
    .bd-purpose-card-head{position:relative;z-index:3;display:flex;align-items:center;gap:13px}
    .bd-purpose-card-icon{width:44px;height:44px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;border-radius:13px;color:#ef5843;background:#fff2ed;box-shadow:0 8px 18px rgba(239,88,67,.08)}
    .bd-purpose-card-icon svg{width:21px;height:21px}
    .bd-purpose-card-head span{display:block;margin-bottom:2px;color:#bec3cb;font-size:7px;font-weight:900;letter-spacing:.15em}
    .bd-purpose-card-head h3{margin:0;color:#241b52;font-size:16px;line-height:1.2;font-weight:800}
    .bd-purpose-card-line{width:100%;height:1px;margin:16px 0;overflow:hidden;background:#efedee}
    .bd-purpose-card-line::after{content:"";display:block;width:55px;height:100%;background:linear-gradient(90deg,#ef5843,#f7aa35)}
    .bd-purpose-card>p{position:relative;z-index:3;margin:0;color:#727d8e;font-size:10.5px;line-height:1.8}
    .bd-mission-list{position:relative;z-index:3;display:flex;flex-direction:column;gap:10px;margin:0;padding:0;list-style:none}
    .bd-mission-list li{display:flex;align-items:flex-start;gap:9px}
    .bd-mission-check{width:19px;height:19px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;margin-top:1px;border-radius:6px;color:#ef5843;background:#fff1ec}
    .bd-mission-check svg{width:11px;height:11px}
    .bd-mission-list p{margin:0;color:#727d8e;font-size:10px;line-height:1.65}
    .bd-purpose-card-footer{position:relative;z-index:3;display:flex;align-items:center;justify-content:space-between;margin-top:17px;padding-top:13px;border-top:1px solid #f1eff0}
    .bd-purpose-card-footer span{color:#b1b7c0;font-size:7px;line-height:1;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
    .bd-purpose-card-footer svg{width:14px;height:14px;stroke:#cbd0d8;transition:.25s ease}
    .bd-purpose-card:hover .bd-purpose-card-footer svg{stroke:#ef5843;transform:translateX(4px)}

    @media (max-width:1023px){
        .bd-values-cards{grid-template-columns:repeat(2,minmax(0,1fr))}
        .bd-values-cards .bd-value-card:last-child{grid-column:1/-1;max-width:520px;width:100%;margin:0 auto}
        .bd-purpose-layout{grid-template-columns:1fr;gap:45px}
        .bd-purpose-copy{max-width:650px}
        .bd-purpose-description{max-width:600px}
    }

    @media (max-width:639px){
        .bd-values-section{padding:70px 0 76px}
        .bd-values-container,.bd-purpose-container{padding:0 18px}
        .bd-values-header{margin-bottom:35px}
        .bd-values-title{font-size:32px}
        .bd-values-cards{grid-template-columns:1fr;gap:14px}
        .bd-values-cards .bd-value-card:last-child{grid-column:auto;max-width:none}
        .bd-value-card{min-height:220px;padding:25px 23px}
        .bd-value-bottom{left:23px;right:23px}
        .bd-purpose-section{padding:76px 0}
        .bd-purpose-layout{gap:35px}
        .bd-purpose-title{font-size:34px}
        .bd-purpose-card{padding:22px 20px 19px}
    }

    @media (prefers-reduced-motion:reduce){
        .bd-value-card,.bd-value-icon,.bd-purpose-card,.bd-purpose-card-icon,.bd-values-orb,.bd-purpose-orb{transform:none!important}
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
        | NILAI-NILAI + VISI MISI
        |--------------------------------------------------------------------------
        */

        const motionGsap = window.bdGsap || null;
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const valuesSection = document.getElementById('nilai-perusahaan');

        if (valuesSection && valuesSection.dataset.motionReady !== '1') {
            valuesSection.dataset.motionReady = '1';

            const cards = Array.from(valuesSection.querySelectorAll('.bd-value-card'));

            if (motionGsap && !reduceMotion) {
                const eyebrow = valuesSection.querySelector('.bd-values-eyebrow');
                const title = valuesSection.querySelector('.bd-values-title');
                const subtitle = valuesSection.querySelector('.bd-values-subtitle');
                const titleLine = valuesSection.querySelector('.bd-values-title-line span');
                const orbOne = valuesSection.querySelector('.bd-values-orb-one');
                const orbTwo = valuesSection.querySelector('.bd-values-orb-two');

                const headerTimeline = motionGsap.timeline({
                    scrollTrigger: {
                        trigger: valuesSection.querySelector('.bd-values-header'),
                        start: 'top 86%',
                        toggleActions: 'play none none reverse'
                    }
                });

                headerTimeline
                    .from(eyebrow, {opacity:0,y:18,duration:.55,ease:'power3.out'})
                    .from(title, {opacity:0,y:35,filter:'blur(5px)',duration:.8,ease:'power4.out'}, '-=.32')
                    .from(subtitle, {opacity:0,y:20,duration:.65,ease:'power3.out'}, '-=.47')
                    .fromTo(titleLine, {scaleX:0}, {scaleX:1,duration:.7,ease:'power3.out'}, '-=.43');

                motionGsap.from(cards, {
                    opacity:0,
                    y:70,
                    scale:.91,
                    rotationY:-9,
                    rotationX:4,
                    duration:.95,
                    stagger:.15,
                    ease:'power4.out',
                    scrollTrigger: {
                        trigger: valuesSection.querySelector('.bd-values-cards'),
                        start: 'top 84%',
                        toggleActions: 'play none none reverse'
                    }
                });

                cards.forEach((card,index) => {
                    const icon = card.querySelector('.bd-value-icon');
                    const number = card.querySelector('.bd-value-number');
                    const shine = card.querySelector('.bd-value-shine');

                    motionGsap.from(icon, {
                        scale:.55,
                        rotation:-16,
                        opacity:0,
                        duration:.65,
                        delay:.15 + index * .12,
                        ease:'back.out(2)',
                        scrollTrigger:{trigger:card,start:'top 84%'}
                    });

                    motionGsap.from(number, {
                        opacity:0,
                        x:18,
                        duration:.65,
                        ease:'power3.out',
                        scrollTrigger:{trigger:card,start:'top 86%'}
                    });

                    const rotationX = motionGsap.quickTo(card,'rotationX',{duration:.5,ease:'power3.out'});
                    const rotationY = motionGsap.quickTo(card,'rotationY',{duration:.5,ease:'power3.out'});

                    card.addEventListener('pointermove', event => {
                        if (window.innerWidth < 768) return;

                        const rect = card.getBoundingClientRect();
                        const x = (event.clientX - rect.left) / rect.width - .5;
                        const y = (event.clientY - rect.top) / rect.height - .5;

                        rotationY(x * 8);
                        rotationX(-y * 6);
                    });

                    card.addEventListener('pointerenter', () => {
                        if (window.innerWidth < 768) return;

                        motionGsap.to(card, {y:-7,scale:1.018,duration:.38,ease:'power3.out'});

                        if (shine) {
                            motionGsap.fromTo(shine,
                                {xPercent:-220,opacity:0},
                                {xPercent:500,opacity:.7,duration:.85,ease:'power2.out'}
                            );
                        }
                    });

                    card.addEventListener('pointerleave', () => {
                        rotationX(0);
                        rotationY(0);
                        motionGsap.to(card, {y:0,scale:1,duration:.6,ease:'elastic.out(1,.45)'});
                    });
                });

                if (orbOne) {
                    motionGsap.to(orbOne, {
                        x:70,y:100,scale:1.15,ease:'none',
                        scrollTrigger:{trigger:valuesSection,start:'top bottom',end:'bottom top',scrub:1.4}
                    });
                }

                if (orbTwo) {
                    motionGsap.to(orbTwo, {
                        x:-65,y:-85,scale:1.12,ease:'none',
                        scrollTrigger:{trigger:valuesSection,start:'top bottom',end:'bottom top',scrub:1.6}
                    });
                }
            } else {
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('bd-fallback-visible');
                        observer.unobserve(entry.target);
                    });
                },{threshold:.12});

                cards.forEach(card => observer.observe(card));
            }
        }

        const purposeSection = document.getElementById('visi-misi');

        if (purposeSection && purposeSection.dataset.motionReady !== '1') {
            purposeSection.dataset.motionReady = '1';

            if (motionGsap && !reduceMotion) {
                const copy = purposeSection.querySelector('.bd-purpose-copy');
                const cardsWrapper = purposeSection.querySelector('.bd-purpose-cards');
                const purposeCards = Array.from(purposeSection.querySelectorAll('.bd-purpose-card'));
                const quoteLine = purposeSection.querySelector('.bd-purpose-quote-line');
                const missionItems = purposeSection.querySelectorAll('.bd-mission-list li');
                const orbOne = purposeSection.querySelector('.bd-purpose-orb-one');
                const orbTwo = purposeSection.querySelector('.bd-purpose-orb-two');

                if (copy) {
                    motionGsap.from(Array.from(copy.children), {
                        opacity:0,
                        x:-55,
                        y:15,
                        filter:'blur(4px)',
                        duration:.8,
                        stagger:.1,
                        ease:'power4.out',
                        scrollTrigger:{trigger:copy,start:'top 82%',toggleActions:'play none none reverse'}
                    });
                }

                if (quoteLine) {
                    motionGsap.fromTo(quoteLine,
                        {scaleY:0},
                        {scaleY:1,duration:.8,ease:'power3.out',scrollTrigger:{trigger:quoteLine,start:'top 86%'}}
                    );
                }

                if (purposeCards.length) {
                    motionGsap.from(purposeCards, {
                        opacity:0,
                        x:75,
                        y:20,
                        scale:.94,
                        rotationY:8,
                        duration:1,
                        stagger:.18,
                        ease:'power4.out',
                        scrollTrigger:{trigger:cardsWrapper,start:'top 82%',toggleActions:'play none none reverse'}
                    });
                }

                purposeCards.forEach(card => {
                    const icon = card.querySelector('.bd-purpose-card-icon');

                    if (icon) {
                        motionGsap.from(icon, {
                            scale:.5,
                            rotation:-18,
                            opacity:0,
                            duration:.65,
                            ease:'back.out(2)',
                            scrollTrigger:{trigger:card,start:'top 84%'}
                        });
                    }

                    const rotateX = motionGsap.quickTo(card,'rotationX',{duration:.5,ease:'power3.out'});
                    const rotateY = motionGsap.quickTo(card,'rotationY',{duration:.5,ease:'power3.out'});

                    card.addEventListener('pointermove', event => {
                        if (window.innerWidth < 768) return;

                        const rect = card.getBoundingClientRect();
                        const x = (event.clientX - rect.left) / rect.width - .5;
                        const y = (event.clientY - rect.top) / rect.height - .5;

                        rotateY(x * 5);
                        rotateX(-y * 4);
                    });

                    card.addEventListener('pointerleave', () => {
                        rotateX(0);
                        rotateY(0);
                    });
                });

                if (missionItems.length) {
                    motionGsap.from(missionItems, {
                        opacity:0,
                        x:25,
                        duration:.55,
                        stagger:.09,
                        ease:'power3.out',
                        scrollTrigger:{trigger:purposeSection.querySelector('.bd-mission-card'),start:'top 72%'}
                    });
                }

                if (orbOne) {
                    motionGsap.to(orbOne, {
                        x:-80,y:120,scale:1.2,ease:'none',
                        scrollTrigger:{trigger:purposeSection,start:'top bottom',end:'bottom top',scrub:1.5}
                    });
                }

                if (orbTwo) {
                    motionGsap.to(orbTwo, {
                        x:70,y:-90,scale:1.12,ease:'none',
                        scrollTrigger:{trigger:purposeSection,start:'top bottom',end:'bottom top',scrub:1.7}
                    });
                }
            }
        }

    }
);

</script>

@endpush

@endsection
