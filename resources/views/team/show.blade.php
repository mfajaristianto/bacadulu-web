@extends('layouts.app')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | SEMUA DATA TEAM
    |--------------------------------------------------------------------------
    */

    $allTeamMembers = collect(
        config('team.members', [])
    );

    /*
    |--------------------------------------------------------------------------
    | DATA MEMBER AKTIF
    |--------------------------------------------------------------------------
    */

    $name = $item['nama'] ?? 'Team Baca Dulu';
    $photo = $item['img'] ?? null;
    $bio = $item['bio'] ?? null;
    $education = $item['pendidikan'] ?? [];
    $scholar = $item['scholar'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | JABATAN
    |--------------------------------------------------------------------------
    */

    $position = $item['jabatan'] ?? null;

    if (is_array($position)) {
        $position = implode(
            ' • ',
            $position
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INITIAL FOTO FALLBACK
    |--------------------------------------------------------------------------
    */

    $initials = collect(
        preg_split(
            '/\s+/',
            trim($name)
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

    /*
    |--------------------------------------------------------------------------
    | CARI URUTAN MEMBER
    |--------------------------------------------------------------------------
    */

    $currentMemberIndex =
        $allTeamMembers->search(
            function ($member) use ($item) {

                if (
                    !empty($item['slug']) &&
                    !empty($member['slug']) &&
                    $member['slug'] === $item['slug']
                ) {
                    return true;
                }

                return
                    !empty($item['nama']) &&
                    !empty($member['nama']) &&
                    $member['nama'] === $item['nama'];
            }
        );

    /*
    |--------------------------------------------------------------------------
    | NOMOR AKTIF
    |--------------------------------------------------------------------------
    */

    $memberNumber =
        $currentMemberIndex !== false
            ? str_pad(
                $currentMemberIndex + 1,
                2,
                '0',
                STR_PAD_LEFT
            )
            : '01';

    /*
    |--------------------------------------------------------------------------
    | TOTAL ANGGOTA
    |--------------------------------------------------------------------------
    */

    $totalMemberNumber =
        str_pad(
            $allTeamMembers->count(),
            2,
            '0',
            STR_PAD_LEFT
        );
@endphp


{{-- ================================================================
     PROFILE TEAM
================================================================ --}}

<section class="bd-team-profile">

    <div class="bd-team-shell">

        {{-- =========================================================
             TOP BAR
        ========================================================== --}}

        <div class="bd-profile-topbar">

            <a
                href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu"
                class="bd-back-link"
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

                <span>
                    Kembali ke Team
                </span>
            </a>

            <div class="bd-profile-marker">
                <span class="bd-marker-line"></span>

                <span>
                    Baca Dulu
                </span>
            </div>

        </div>


        {{-- =========================================================
             HERO PROFILE
        ========================================================== --}}

        <div class="bd-profile-hero">

            {{-- PHOTO --}}
            <div class="bd-profile-photo-wrap">

                <div class="bd-profile-photo">

                    @if($photo)

                        <img
                            src="{{ asset($photo) }}"
                            alt="{{ $name }}"
                            onerror="
                                this.style.display='none';
                                this.nextElementSibling.style.display='flex';
                            "
                        >

                        <div
                            class="bd-profile-photo-fallback"
                            style="display:none;"
                        >
                            {{ $initials }}
                        </div>

                    @else

                        <div
                            class="bd-profile-photo-fallback"
                            style="display:flex;"
                        >
                            {{ $initials }}
                        </div>

                    @endif

                </div>

                <div class="bd-photo-caption">
                    <span class="bd-caption-dot"></span>
                    Team Baca Dulu
                </div>

            </div>


            {{-- IDENTITY --}}
            <div class="bd-profile-heading">

                <div class="bd-profile-eyebrow">
                    Team Baca Dulu
                </div>

                <h1>
                    {{ $name }}
                </h1>

                @if(!empty($position))
                    <p class="bd-profile-position">
                        {{ $position }}
                    </p>
                @endif

                <div class="bd-profile-rule"></div>

                <p class="bd-profile-intro">
                    Bagian dari orang-orang yang bekerja di balik Baca Dulu,
                    membawa pengalaman dan perspektifnya dalam membangun
                    ekosistem literasi, publikasi, dan pengetahuan.
                </p>

                {{-- ACTION --}}
                <div class="bd-profile-actions">

                    @if($scholar)

                        <a
                            href="{{ $scholar }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="bd-scholar-button"
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
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>

                            Google Scholar

                            <svg
                                class="bd-action-arrow"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 17L17 7M8 7h9v9"
                                />
                            </svg>
                        </a>

                    @endif

                    <a
                        href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu"
                        class="bd-outline-button"
                    >
                        Lihat Semua Team
                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
             CONTENT
        ========================================================== --}}

        <div
            class="{{ !empty($education)
                ? 'bd-profile-content bd-profile-content-with-aside'
                : 'bd-profile-content'
            }}"
        >

            {{-- BIOGRAPHY --}}
            <main class="bd-profile-main">

                {{-- NOMOR URUT --}}
                <div class="bd-section-number">

                    <span class="bd-current-member-number">
                        {{ $memberNumber }}
                    </span>

                    <span class="bd-member-number-divider">
                        /
                    </span>

                    <span class="bd-total-member-number">
                        {{ $totalMemberNumber }}
                    </span>

                </div>

                {{-- HEADING --}}
                <div class="bd-section-heading">

                    <span>
                        Profil
                    </span>

                    <h2>
                        Biografi Singkat
                    </h2>

                </div>

                {{-- BIO --}}
                <div class="bd-biography">

                    @if(!empty($bio))

                        <p>
                            {{ $bio }}
                        </p>

                    @else

                        <p class="bd-empty-text">
                            Biografi anggota tim ini belum tersedia.
                        </p>

                    @endif

                </div>

            </main>


            {{-- EDUCATION --}}
            @if(!empty($education))

                <aside class="bd-profile-aside">

                    <div class="bd-aside-label">
                        <span class="bd-aside-dot"></span>
                        Pendidikan
                    </div>

                    <div class="bd-education-list">

                        @foreach($education as $index => $educationItem)

                            <div class="bd-education-item">

                                <span class="bd-education-number">
                                    {{ str_pad(
                                        $index + 1,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </span>

                                <p>
                                    {{ $educationItem }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                </aside>

            @endif

        </div>


        {{-- =========================================================
             CLOSING
        ========================================================== --}}

        <div class="bd-profile-closing">

            <div>

                <span class="bd-closing-label">
                    Team Baca Dulu
                </span>

                <h3>
                    Setiap orang membawa perspektif yang berbeda.
                </h3>

            </div>

            <a
                href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu"
                class="bd-closing-link"
            >
                Temui anggota lainnya

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
            </a>

        </div>

    </div>

</section>


@push('scripts')

<style>

/* ================================================================
   ROOT
================================================================ */

.bd-team-profile{
    --bd-orange:#ef5843;
    --bd-orange-dark:#cf4735;
    --bd-orange-soft:#fff3ee;
    --bd-navy:#1e1e50;
    --bd-text:#1e293b;
    --bd-muted:#64748b;
    --bd-line:#e8e8e5;
    --bd-bg:#f8f8f6;

    width:100%;
    min-height:calc(100vh - 80px);
    padding:54px 0 84px;
    background:var(--bd-bg);
}

.bd-team-shell{
    width:min(calc(100% - 40px),1120px);
    margin:0 auto;
}


/* ================================================================
   TOP BAR
================================================================ */

.bd-profile-topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    margin-bottom:34px;
}

.bd-back-link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:#64748b;
    font-size:12px;
    font-weight:700;
    text-decoration:none;
    transition:color .2s ease;
}

.bd-back-link svg{
    width:17px;
    height:17px;
    transition:transform .2s ease;
}

.bd-back-link:hover{
    color:var(--bd-orange);
}

.bd-back-link:hover svg{
    transform:translateX(-3px);
}

.bd-profile-marker{
    display:flex;
    align-items:center;
    gap:9px;
    color:#a09a95;
    font-size:9px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.20em;
}

.bd-marker-line{
    width:25px;
    height:2px;
    border-radius:999px;
    background:var(--bd-orange);
}


/* ================================================================
   HERO
================================================================ */

.bd-profile-hero{
    position:relative;
    display:grid;
    grid-template-columns:minmax(260px,365px) minmax(0,1fr);
    gap:clamp(42px,7vw,90px);
    align-items:center;
    padding:52px;
    overflow:hidden;
    border:1px solid #e7e7e3;
    border-radius:30px;
    background:#ffffff;
    box-shadow:0 18px 55px rgba(30,30,80,.055);
}

.bd-profile-hero::before{
    content:"";
    position:absolute;
    top:0;
    left:52px;
    width:58px;
    height:4px;
    border-radius:0 0 999px 999px;
    background:var(--bd-orange);
}


/* ================================================================
   PHOTO
================================================================ */

.bd-profile-photo-wrap{
    min-width:0;
}

.bd-profile-photo{
    position:relative;
    width:100%;
    aspect-ratio:4 / 5;
    overflow:hidden;
    border-radius:24px;
    background:#eeeeeb;
}

.bd-profile-photo img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center;
    filter:saturate(.92) contrast(1.015);
    transition:transform .7s cubic-bezier(.22,1,.36,1);
}

.bd-profile-photo:hover img{
    transform:scale(1.025);
}

.bd-profile-photo-fallback{
    position:absolute;
    inset:0;
    align-items:center;
    justify-content:center;
    background:#fff3ee;
    color:var(--bd-orange);
    font-size:48px;
    font-weight:900;
    letter-spacing:-.05em;
}

.bd-photo-caption{
    display:flex;
    align-items:center;
    gap:8px;
    margin-top:13px;
    color:#929292;
    font-size:10px;
    font-weight:700;
    letter-spacing:.09em;
    text-transform:uppercase;
}

.bd-caption-dot{
    width:6px;
    height:6px;
    border-radius:50%;
    background:var(--bd-orange);
}


/* ================================================================
   HEADING
================================================================ */

.bd-profile-heading{
    min-width:0;
}

.bd-profile-eyebrow{
    margin-bottom:13px;
    color:var(--bd-orange);
    font-size:10px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.20em;
}

.bd-profile-heading h1{
    max-width:650px;
    margin:0;
    color:var(--bd-navy);
    font-size:clamp(32px,4vw,54px);
    line-height:1.05;
    font-weight:900;
    letter-spacing:-.045em;
    overflow-wrap:break-word;
}

.bd-profile-position{
    max-width:640px;
    margin:17px 0 0;
    color:#5c6576;
    font-size:14px;
    line-height:1.7;
    font-weight:600;
}

.bd-profile-rule{
    width:44px;
    height:3px;
    margin:25px 0;
    border-radius:999px;
    background:var(--bd-orange);
}

.bd-profile-intro{
    max-width:600px;
    margin:0;
    color:#727987;
    font-size:13px;
    line-height:1.8;
}


/* ================================================================
   ACTION
================================================================ */

.bd-profile-actions{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    margin-top:29px;
}

.bd-scholar-button,
.bd-outline-button{
    min-height:43px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:0 16px;
    border-radius:11px;
    font-size:11px;
    line-height:1;
    font-weight:800;
    text-decoration:none;
    transition:
        background .2s ease,
        border .2s ease,
        color .2s ease,
        transform .2s ease;
}

.bd-scholar-button{
    border:1px solid var(--bd-orange);
    background:var(--bd-orange);
    color:white;
}

.bd-scholar-button svg{
    width:15px;
    height:15px;
}

.bd-scholar-button .bd-action-arrow{
    width:13px;
    height:13px;
    opacity:.7;
}

.bd-scholar-button:hover{
    color:white;
    background:var(--bd-orange-dark);
    border-color:var(--bd-orange-dark);
    transform:translateY(-1px);
}

.bd-outline-button{
    border:1px solid #deded9;
    background:white;
    color:#566071;
}

.bd-outline-button:hover{
    border-color:#f0b5aa;
    background:#fff8f5;
    color:var(--bd-orange-dark);
}


/* ================================================================
   CONTENT
================================================================ */

.bd-profile-content{
    display:grid;
    grid-template-columns:minmax(0,1fr);
    gap:26px;
    margin-top:26px;
}

.bd-profile-content-with-aside{
    grid-template-columns:
        minmax(0,1.55fr)
        minmax(280px,.65fr);
}


/* ================================================================
   BIOGRAPHY CARD
================================================================ */

.bd-profile-main{
    position:relative;
    min-width:0;
    padding:40px 42px 44px;
    border:1px solid var(--bd-line);
    border-radius:24px;
    background:white;
}


/* ================================================================
   NOMOR MEMBER
================================================================ */

.bd-section-number{
    position:absolute;
    top:38px;
    right:40px;
    display:flex;
    align-items:baseline;
    gap:5px;
    line-height:1;
    user-select:none;
}

.bd-current-member-number{
    color:var(--bd-orange);
    font-size:29px;
    font-weight:900;
    letter-spacing:-.055em;
}

.bd-member-number-divider{
    color:#d8d6d2;
    font-size:14px;
    font-weight:500;
}

.bd-total-member-number{
    color:#aaa6a1;
    font-size:11px;
    font-weight:800;
    letter-spacing:.04em;
}


/* ================================================================
   SECTION HEADING
================================================================ */

.bd-section-heading span{
    display:block;
    color:var(--bd-orange);
    font-size:9px;
    line-height:1;
    font-weight:900;
    letter-spacing:.18em;
    text-transform:uppercase;
}

.bd-section-heading h2{
    margin:7px 0 0;
    color:var(--bd-navy);
    font-size:25px;
    line-height:1.2;
    font-weight:850;
    letter-spacing:-.025em;
}


/* ================================================================
   BIO TEXT
   SUDAH DIBENERIN
================================================================ */

.bd-biography{
    width:100%;
    max-width:none;
    margin-top:27px;
}

.bd-biography p{
    width:100%;
    max-width:none;
    margin:0;
    color:#525c6d;
    font-size:15px;
    line-height:1.95;

    text-align:justify;
    text-align-last:left;

    white-space:normal;

    overflow-wrap:break-word;
    word-break:normal;
}

.bd-biography p + p{
    margin-top:16px;
}

.bd-biography .bd-empty-text{
    color:#a1a7b0;
    font-style:italic;
    text-align:left;
}


/* ================================================================
   EDUCATION
================================================================ */

.bd-profile-aside{
    min-width:0;
    padding:32px;
    border:1px solid var(--bd-line);
    border-radius:24px;
    background:#fff;
}

.bd-aside-label{
    display:flex;
    align-items:center;
    gap:8px;
    padding-bottom:20px;
    border-bottom:1px solid #efefec;
    color:var(--bd-navy);
    font-size:13px;
    font-weight:800;
}

.bd-aside-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:var(--bd-orange);
}

.bd-education-list{
    margin-top:8px;
}

.bd-education-item{
    display:grid;
    grid-template-columns:28px minmax(0,1fr);
    gap:11px;
    padding:17px 0;
    border-bottom:1px solid #f0efed;
}

.bd-education-item:last-child{
    border-bottom:0;
    padding-bottom:0;
}

.bd-education-number{
    padding-top:3px;
    color:var(--bd-orange);
    font-size:9px;
    font-weight:900;
    letter-spacing:.08em;
}

.bd-education-item p{
    margin:0;
    color:#606979;
    font-size:12px;
    line-height:1.7;
    overflow-wrap:break-word;
}


/* ================================================================
   CLOSING
================================================================ */

.bd-profile-closing{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:30px;
    margin-top:26px;
    padding:35px 40px;
    border-radius:24px;
    background:var(--bd-navy);
}

.bd-closing-label{
    display:block;
    color:#ff9a87;
    font-size:9px;
    font-weight:900;
    letter-spacing:.19em;
    text-transform:uppercase;
}

.bd-profile-closing h3{
    max-width:520px;
    margin:8px 0 0;
    color:white;
    font-size:20px;
    line-height:1.35;
    font-weight:800;
}

.bd-closing-link{
    display:inline-flex;
    align-items:center;
    gap:9px;
    color:white;
    font-size:11px;
    font-weight:800;
    white-space:nowrap;
    text-decoration:none;
    transition:color .2s ease;
}

.bd-closing-link svg{
    width:17px;
    height:17px;
    transition:transform .2s ease;
}

.bd-closing-link:hover{
    color:#ffad9d;
}

.bd-closing-link:hover svg{
    transform:translateX(4px);
}


/* ================================================================
   ANIMATION
================================================================ */

@keyframes bdProfileReveal{
    from{
        opacity:0;
        transform:translateY(12px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

.bd-profile-hero{
    animation:bdProfileReveal .55s ease both;
}

.bd-profile-content{
    animation:bdProfileReveal .55s ease .08s both;
}

.bd-profile-closing{
    animation:bdProfileReveal .55s ease .13s both;
}


/* ================================================================
   TABLET
================================================================ */

@media(max-width:900px){

    .bd-profile-hero{
        grid-template-columns:
            minmax(220px,300px)
            minmax(0,1fr);

        gap:36px;
        padding:38px;
    }

    .bd-profile-content-with-aside{
        grid-template-columns:minmax(0,1fr);
    }

    .bd-profile-aside{
        padding:28px 32px;
    }

}


/* ================================================================
   MOBILE
================================================================ */

@media(max-width:700px){

    .bd-team-profile{
        padding:32px 0 55px;
    }

    .bd-team-shell{
        width:min(
            calc(100% - 28px),
            1120px
        );
    }

    .bd-profile-topbar{
        margin-bottom:22px;
    }

    .bd-profile-marker{
        display:none;
    }

    .bd-profile-hero{
        grid-template-columns:minmax(0,1fr);
        gap:28px;
        padding:22px;
        border-radius:23px;
    }

    .bd-profile-hero::before{
        left:22px;
    }

    .bd-profile-photo{
        width:min(
            100%,
            360px
        );

        margin:0 auto;
        aspect-ratio:4 / 4.7;
        border-radius:20px;
    }

    .bd-photo-caption{
        width:min(
            100%,
            360px
        );

        margin:12px auto 0;
    }

    .bd-profile-heading h1{
        font-size:31px;
    }

    .bd-profile-position{
        font-size:13px;
    }

    .bd-profile-intro{
        font-size:12px;
    }

    .bd-profile-actions{
        align-items:stretch;
        flex-direction:column;
    }

    .bd-scholar-button,
    .bd-outline-button{
        width:100%;
    }

    .bd-profile-main{
        padding:28px 24px 32px;
        border-radius:21px;
    }

    /* NOMOR */
    .bd-section-number{
        top:27px;
        right:23px;
        gap:4px;
    }

    .bd-current-member-number{
        font-size:23px;
    }

    .bd-member-number-divider{
        font-size:11px;
    }

    .bd-total-member-number{
        font-size:9px;
    }

    .bd-section-heading h2{
        font-size:21px;
    }

    .bd-biography{
        margin-top:22px;
    }

    /*
    |--------------------------------------------------------------------------
    | BIO MOBILE
    |--------------------------------------------------------------------------
    |
    | Di desktop dibuat justify.
    | Di HP dikembalikan rata kiri supaya spasi antarkata
    | tidak melebar aneh karena layar sempit.
    |
    */

    .bd-biography p{
        font-size:14px;
        line-height:1.85;
        text-align:left;
    }

    .bd-profile-aside{
        padding:26px 24px;
        border-radius:21px;
    }

    .bd-profile-closing{
        align-items:flex-start;
        flex-direction:column;
        padding:28px 24px;
        border-radius:21px;
    }

    .bd-profile-closing h3{
        font-size:18px;
    }

}


/* ================================================================
   REDUCED MOTION
================================================================ */

@media(prefers-reduced-motion:reduce){

    .bd-profile-hero,
    .bd-profile-content,
    .bd-profile-closing{
        animation:none !important;
    }

    .bd-profile-photo img{
        transition:none !important;
    }

}

</style>

@endpush

@endsection