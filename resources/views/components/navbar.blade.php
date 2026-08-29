@php
    $isBloggingArea =
        request()->routeIs('blog.*')
        || request()->routeIs('event.*')
        || request()->routeIs('community.*');
@endphp

<nav id="main-navbar" class="bd-navbar">

    <div class="bd-navbar-container">

        <div class="bd-navbar-row">

            {{-- =====================================================
                 LOGO AREA
                 Desktop = 25%
            ====================================================== --}}
            <div class="bd-navbar-brand-area">

                <a
                    href="{{ route('home') }}"
                    class="bd-navbar-logo"
                >
                    <img
                        src="{{ asset('img/images.jpg') }}"
                        alt="Logo Baca Dulu"
                    >
                </a>

            </div>


            {{-- =====================================================
                 DESKTOP MENU AREA
                 Desktop = 75%
            ====================================================== --}}
            <div
                class="
                    bd-navbar-desktop-zone
                    {{ $isBloggingArea ? 'has-account' : '' }}
                "
            >

                {{-- HOME --}}
                <div class="bd-nav-slot">

                    <a
                        href="{{ route('home') }}"
                        class="
                            bd-nav-link
                            {{ request()->is('/') ? 'is-active' : '' }}
                        "
                    >
                        Home
                    </a>

                </div>


                {{-- TENTANG KAMI --}}
                <div class="bd-nav-slot">

                    <div class="bd-nav-dropdown">

                        <button
                            type="button"
                            class="bd-nav-link bd-nav-dropdown-trigger"
                        >
                            <span>
                                Tentang Kami
                            </span>

                            <svg viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>


                        <div class="bd-nav-dropdown-menu">

                            <a
                                href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu"
                            >
                                Team BacaDulu
                            </a>

                            <a
                                href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan"
                            >
                                Nilai Perusahaan
                            </a>

                            <a
                                href="{{ route('tentang.dewan-redaksi') }}#visi-misi"
                            >
                                Visi & Misi
                            </a>

                        </div>

                    </div>

                </div>


                {{-- KATALOG BACA --}}
                <div class="bd-nav-slot">

                    <div class="bd-nav-dropdown">

                        <button
                            type="button"
                            class="bd-nav-link bd-nav-dropdown-trigger"
                        >
                            <span>
                                Katalog Baca
                            </span>

                            <svg viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>


                        <div class="bd-nav-dropdown-menu bd-nav-dropdown-wide">

                            <a href="{{ route('informasi') }}">
                                Baca Informasi
                            </a>

                            <a href="{{ route('konsultasi') }}">
                                Baca Konsultasi
                            </a>

                            <a href="{{ route('jurnal') }}">
                                Baca Jurnal
                            </a>

                            <a href="{{ route('conference') }}">
                                Baca Conference
                            </a>

                            <a href="{{ route('publisher') }}">
                                Baca Publisher
                            </a>

                        </div>

                    </div>

                </div>


                {{-- BOOKSTORE --}}
                <div class="bd-nav-slot">

                    <a
                        href="{{ route('portofolio.bookstore') }}"
                        class="
                            bd-nav-link
                            {{ request()->routeIs('portofolio.bookstore*') ? 'is-active' : '' }}
                        "
                    >
                        Bookstore
                    </a>

                </div>


                {{-- BLOGGING --}}
                <div class="bd-nav-slot">

                    <a
                        href="{{ route('blog.index') }}"
                        class="
                            bd-nav-link
                            {{ $isBloggingArea ? 'is-active' : '' }}
                        "
                    >
                        Blogging
                    </a>

                </div>


                {{-- HAKI --}}
                <div class="bd-nav-slot">

                    <a
                        href="{{ route('haki.index') }}"
                        class="
                            bd-nav-link
                            {{ request()->routeIs('haki.*') ? 'is-active' : '' }}
                        "
                    >
                        HAKI
                    </a>

                </div>


                {{-- KIRIM NASKAH --}}
                <div class="bd-nav-slot bd-nav-submit-slot">

                    <a
                        href="https://wa.me/6285139461070"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="bd-nav-submit"
                    >
                        Kirim Naskah
                    </a>

                </div>


                {{-- =================================================
                     ACCOUNT
                     Hanya area Blogging
                ================================================== --}}
                @if($isBloggingArea)

                    <div class="bd-nav-slot bd-nav-account-slot">

                        @auth

                            <div class="bd-nav-profile">

                                <button
                                    type="button"
                                    class="bd-nav-profile-trigger"
                                >

                                    <img
                                        src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                        alt="{{ auth()->user()->name }}"
                                    >

                                    <span>
                                        {{ auth()->user()->name }}
                                    </span>

                                    <svg viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7"/>
                                    </svg>

                                </button>


                                <div class="bd-nav-profile-menu">

                                    @if(auth()->user()->is_admin)

                                        <a href="{{ route('admin.dashboard') }}">
                                            Panel Admin
                                        </a>

                                    @endif


                                    <a href="{{ route('blog.myPosts') }}">
                                        Artikel Saya
                                    </a>


                                    <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <button type="submit">
                                            Logout
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="bd-nav-login"
                            >
                                Login
                            </a>

                        @endauth

                    </div>

                @endif

            </div>


            {{-- =====================================================
                 MOBILE BUTTON
            ====================================================== --}}
            <button
                type="button"
                id="mobile-menu-button"
                class="bd-mobile-menu-button"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Buka menu"
            >

                <svg
                    id="hamburger-icon"
                    viewBox="0 0 24 24"
                >
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>


                <svg
                    id="close-icon"
                    class="is-hidden"
                    viewBox="0 0 24 24"
                >
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>

            </button>

        </div>

    </div>


    {{-- =========================================================
         MOBILE MENU
    ========================================================== --}}
    <div
        id="mobile-menu"
        class="bd-mobile-menu"
    >

        <div class="bd-mobile-menu-inner">

            {{-- HOME --}}
            <a
                href="{{ route('home') }}"
                class="
                    bd-mobile-main-link
                    {{ request()->is('/') ? 'is-active' : '' }}
                "
            >
                Home
            </a>


            {{-- TENTANG --}}
            <div class="bd-mobile-section">

                <span class="bd-mobile-label">
                    Tentang Kami
                </span>

                <a href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu">
                    Team BacaDulu
                </a>

                <a href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan">
                    Nilai Perusahaan
                </a>

                <a href="{{ route('tentang.dewan-redaksi') }}#visi-misi">
                    Visi & Misi
                </a>

            </div>


            {{-- KATALOG --}}
            <div class="bd-mobile-section">

                <span class="bd-mobile-label">
                    Katalog Baca
                </span>

                <a href="{{ route('informasi') }}">
                    Baca Informasi
                </a>

                <a href="{{ route('konsultasi') }}">
                    Baca Konsultasi
                </a>

                <a href="{{ route('jurnal') }}">
                    Baca Jurnal
                </a>

                <a href="{{ route('conference') }}">
                    Baca Conference
                </a>

                <a href="{{ route('publisher') }}">
                    Baca Publisher
                </a>

            </div>


            {{-- MAIN MOBILE --}}
            <div
                class="
                    bd-mobile-section
                    bd-mobile-main-menu
                "
            >

                <a
                    href="{{ route('portofolio.bookstore') }}"
                    class="{{ request()->routeIs('portofolio.bookstore*') ? 'is-active' : '' }}"
                >
                    Bookstore
                </a>


                <a
                    href="{{ route('blog.index') }}"
                    class="{{ $isBloggingArea ? 'is-active' : '' }}"
                >
                    Blogging
                </a>


                <a
                    href="{{ route('haki.index') }}"
                    class="{{ request()->routeIs('haki.*') ? 'is-active' : '' }}"
                >
                    HAKI
                </a>

            </div>


            {{-- MOBILE ACTIONS --}}
            <div class="bd-mobile-actions">

                <a
                    href="https://wa.me/6285139461070"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="bd-mobile-submit"
                >
                    Kirim Naskah
                </a>


                @if($isBloggingArea)

                    @auth

                        <div class="bd-mobile-user">

                            <img
                                src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                alt="{{ auth()->user()->name }}"
                            >

                            <div>

                                <strong>
                                    {{ auth()->user()->name }}
                                </strong>

                                <span>
                                    Akun Baca Dulu
                                </span>

                            </div>

                        </div>


                        @if(auth()->user()->is_admin)

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="bd-mobile-secondary"
                            >
                                Panel Admin
                            </a>

                        @endif


                        <a
                            href="{{ route('blog.myPosts') }}"
                            class="bd-mobile-secondary"
                        >
                            Artikel Saya
                        </a>


                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="bd-mobile-logout"
                            >
                                Logout
                            </button>

                        </form>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="bd-mobile-login"
                        >
                            Login
                        </a>

                    @endauth

                @endif

            </div>

        </div>

    </div>

</nav>


<style>
/* ================================================================
   ROOT
================================================================ */
.bd-navbar{
    --navy:#241B52;
    --orange:#EF5843;

    position:sticky;
    top:0;
    z-index:1000;

    width:100%;
    max-width:100%;

    border-bottom:
        1px solid #F1F1F4;

    background:
        rgba(255,255,255,.98);

    box-shadow:
        0 3px 14px
        rgba(36,27,82,.045);

    backdrop-filter:
        blur(14px);
}


.bd-navbar *,
.bd-navbar *::before,
.bd-navbar *::after{
    box-sizing:border-box;
}


.bd-navbar a{
    text-decoration:none;
}


/* ================================================================
   CONTAINER
================================================================ */
.bd-navbar-container{
    width:
        min(
            calc(100% - 40px),
            1760px
        );

    margin:
        0 auto;
}


/* ================================================================
   ROW DEFAULT
================================================================ */
.bd-navbar-row{
    width:100%;
    min-width:0;

    height:82px;

    display:flex;

    align-items:center;

    gap:16px;
}


/* ================================================================
   BRAND
================================================================ */
.bd-navbar-brand-area{
    display:flex;

    align-items:center;

    min-width:0;
}


.bd-navbar-logo{
    display:flex;

    align-items:center;

    flex:
        0 0 auto;
}


.bd-navbar-logo img{
    display:block;

    width:auto;

    height:56px;

    max-width:150px;

    object-fit:contain;
}


/* ================================================================
   DESKTOP ZONE DEFAULT
================================================================ */
.bd-navbar-desktop-zone{
    display:none;
}


/* ================================================================
   MOBILE BUTTON
================================================================ */
.bd-mobile-menu-button{
    width:46px;
    height:46px;

    margin-left:auto;

    flex:
        0 0 auto;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:0;

    border:0;

    border-radius:12px;

    background:#F7F7F9;

    color:#555563;

    cursor:pointer;
}


.bd-mobile-menu-button svg{
    width:23px;
    height:23px;

    fill:none;

    stroke:currentColor;

    stroke-width:2;

    stroke-linecap:round;

    stroke-linejoin:round;
}


.bd-mobile-menu-button .is-hidden{
    display:none;
}


/* ================================================================
   MOBILE MENU
================================================================ */
.bd-mobile-menu{
    display:none;

    width:100%;

    border-top:
        1px solid #F1F1F4;

    background:#fff;

    box-shadow:
        0 15px 28px
        rgba(36,27,82,.08);
}


.bd-mobile-menu.is-open{
    display:block;
}


.bd-mobile-menu-inner{
    width:
        min(
            calc(100% - 30px),
            760px
        );

    max-height:
        calc(100dvh - 82px);

    margin:
        0 auto;

    padding:
        15px 0 20px;

    overflow-y:auto;

    overscroll-behavior:
        contain;
}


/* ================================================================
   MOBILE LINKS
================================================================ */
.bd-mobile-main-link,
.bd-mobile-section > a,
.bd-mobile-main-menu > a{
    display:block;

    width:100%;

    padding:
        11px 13px;

    border-radius:10px;

    color:#5F616B!important;

    font-size:13px;

    font-weight:700;
}


.bd-mobile-main-link.is-active,
.bd-mobile-main-menu > a.is-active{
    color:#1E1E50!important;

    background:
        rgba(30,30,80,.08);
}


.bd-mobile-section{
    margin-top:10px;

    padding-top:13px;

    border-top:
        1px solid #F0F0F3;
}


.bd-mobile-label{
    display:block;

    padding:
        0 13px 6px;

    color:#A0A0AA;

    font-size:9px;

    font-weight:800;

    letter-spacing:.12em;

    text-transform:uppercase;
}


.bd-mobile-section > a{
    padding-left:20px;

    font-size:12px;
}


.bd-mobile-main-menu > a{
    font-size:13px;
}


/* ================================================================
   MOBILE ACTIONS
================================================================ */
.bd-mobile-actions{
    display:flex;

    flex-direction:column;

    gap:8px;

    margin-top:13px;

    padding-top:15px;

    border-top:
        1px solid #F0F0F3;
}


.bd-mobile-submit,
.bd-mobile-login,
.bd-mobile-secondary,
.bd-mobile-logout{
    width:100%;

    min-height:46px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:
        10px 15px;

    border:0;

    border-radius:11px;

    font-size:12px;

    font-weight:800;
}


.bd-mobile-submit{
    color:#fff!important;

    background:
        var(--orange);
}


.bd-mobile-login{
    color:#fff!important;

    background:
        var(--navy);
}


.bd-mobile-secondary{
    color:#555563!important;

    background:#F4F4F7;
}


.bd-mobile-logout{
    color:#DC2626;

    background:#FEF2F2;

    cursor:pointer;
}


/* ================================================================
   MOBILE USER
================================================================ */
.bd-mobile-user{
    display:flex;

    align-items:center;

    gap:11px;

    padding:11px;

    border-radius:12px;

    background:#F7F7F9;
}


.bd-mobile-user img{
    width:42px;
    height:42px;

    flex:
        0 0 auto;

    border-radius:50%;

    object-fit:cover;
}


.bd-mobile-user div{
    min-width:0;
}


.bd-mobile-user strong{
    display:block;

    overflow:hidden;

    color:#33333D;

    font-size:12px;

    text-overflow:ellipsis;

    white-space:nowrap;
}


.bd-mobile-user span{
    display:block;

    margin-top:2px;

    color:#A0A0A8;

    font-size:9px;
}


/* ================================================================
   DESKTOP
   25% BRAND
   75% MENU
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-navbar-row{
    display:grid;

    grid-template-columns:
        25% 75%;

    gap:0;

    height:88px;
}


/* ================================================================
   LOGO AREA = 25%
   Logo sengaja agak masuk ke tengah
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-navbar-brand-area{
    width:100%;
    height:100%;

    display:flex;

    align-items:center;

    justify-content:flex-start;

    /*
    |--------------------------------------------------------------------------
    | INI YANG NGATUR POSISI LOGO
    |--------------------------------------------------------------------------
    |
    | Logo tidak nempel kiri.
    | Sedikit digeser menuju tengah area 25%.
    |
    */
    padding-left:
        clamp(
            42px,
            3.5vw,
            76px
        );

    padding-right:18px;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-navbar-logo{
    height:100%;

    display:flex;

    align-items:center;

    justify-content:center;

    /*
    |--------------------------------------------------------------------------
    | Fine adjustment
    |--------------------------------------------------------------------------
    */
    transform:
        translateX(8px);
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-navbar-logo img{
    height:58px;

    max-width:160px;
}


/* ================================================================
   MENU 75%
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-navbar-desktop-zone{
    width:100%;

    min-width:0;

    height:100%;

    display:grid;

    grid-template-columns:
        repeat(
            7,
            minmax(0,1fr)
        );

    align-items:center;
}


/* BLOGGING + ACCOUNT */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-navbar-desktop-zone.has-account{
    grid-template-columns:
        repeat(
            8,
            minmax(0,1fr)
        );
}


/* ================================================================
   MENU SLOT
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-slot{
    position:relative;

    min-width:0;

    width:100%;

    height:100%;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:
        0 5px;
}


/* ================================================================
   LINKS
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-link{
    width:100%;

    max-width:150px;

    min-width:0;

    min-height:48px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    padding:
        0 10px;

    border:0;

    border-radius:12px;

    background:transparent;

    color:#62636D!important;

    font-size:13px;

    font-weight:750;

    line-height:1;

    text-align:center;

    white-space:nowrap;

    cursor:pointer;

    transition:
        color .2s ease,
        background .2s ease,
        transform .2s ease;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-link.is-active{
    color:
        var(--navy)!important;

    background:
        rgba(36,27,82,.075);
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-link:hover{
    color:
        var(--navy)!important;

    background:#F7F7F9;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-link svg{
    width:14px;

    height:14px;

    flex:
        0 0 auto;

    fill:none;

    stroke:currentColor;

    stroke-width:2;

    transition:
        transform .2s ease;
}


/* ================================================================
   DROPDOWN
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown{
    position:relative;

    width:100%;
    height:100%;

    display:flex;

    align-items:center;

    justify-content:center;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown:hover
.bd-nav-dropdown-trigger svg{
    transform:
        rotate(180deg);
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown-menu{
    position:absolute;

    z-index:1100;

    left:50%;

    top:
        calc(50% + 34px);

    width:220px;

    padding:7px;

    opacity:0;

    visibility:hidden;

    transform:
        translate(
            -50%,
            7px
        );

    border:
        1px solid #EEEEF2;

    border-radius:13px;

    background:#fff;

    box-shadow:
        0 18px 38px
        rgba(36,27,82,.12);

    transition:
        opacity .18s ease,
        visibility .18s ease,
        transform .18s ease;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown-wide{
    width:235px;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown:hover
.bd-nav-dropdown-menu{
    opacity:1;

    visibility:visible;

    transform:
        translate(
            -50%,
            0
        );
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown-menu a{
    display:block;

    padding:
        11px 12px;

    border-radius:8px;

    color:#5E606A!important;

    font-size:11px;

    font-weight:700;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-dropdown-menu a:hover{
    color:
        var(--navy)!important;

    background:#F7F7F9;
}


/* ================================================================
   KIRIM NASKAH
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-submit-slot{
    padding:
        0 7px;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-submit{
    width:100%;

    max-width:160px;

    min-height:48px;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:
        0 15px;

    border-radius:999px;

    background:
        var(--orange);

    color:#fff!important;

    font-size:12px;

    font-weight:850;

    white-space:nowrap;

    box-shadow:
        0 7px 18px
        rgba(239,88,67,.13);

    transition:
        transform .2s ease,
        background .2s ease,
        box-shadow .2s ease;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-submit:hover{
    background:#DF4F39;

    transform:
        translateY(-1px);

    box-shadow:
        0 11px 22px
        rgba(239,88,67,.19);
}


/* ================================================================
   ACCOUNT
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-account-slot{
    padding:
        0 5px;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-login{
    width:100%;

    max-width:130px;

    min-height:46px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:999px;

    background:
        var(--navy);

    color:#fff!important;

    font-size:11px;

    font-weight:800;
}


/* ================================================================
   PROFILE
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile{
    position:relative;

    width:100%;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-trigger{
    width:100%;

    min-height:46px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:7px;

    padding:
        3px 7px 3px 3px;

    border:0;

    border-radius:999px;

    background:#F7F7F9;

    cursor:pointer;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-trigger img{
    width:38px;

    height:38px;

    flex:
        0 0 auto;

    border-radius:50%;

    object-fit:cover;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-trigger span{
    min-width:0;

    max-width:82px;

    overflow:hidden;

    color:#565861;

    font-size:10px;

    font-weight:750;

    text-overflow:ellipsis;

    white-space:nowrap;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-trigger svg{
    width:12px;

    height:12px;

    flex:
        0 0 auto;

    fill:none;

    stroke:#777985;

    stroke-width:2;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-menu{
    position:absolute;

    right:0;

    top:
        calc(100% + 9px);

    z-index:1200;

    width:190px;

    padding:7px;

    opacity:0;

    visibility:hidden;

    transform:
        translateY(6px);

    border:
        1px solid #EEEEF2;

    border-radius:13px;

    background:#fff;

    box-shadow:
        0 18px 38px
        rgba(36,27,82,.12);

    transition:
        .18s ease;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile:hover
.bd-nav-profile-menu{
    opacity:1;

    visibility:visible;

    transform:none;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-menu a,
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-menu button{
    width:100%;

    display:block;

    padding:
        10px 11px;

    border:0;

    border-radius:8px;

    color:#5E606A!important;

    background:transparent;

    font-size:11px;

    font-weight:700;

    text-align:left;

    cursor:pointer;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-menu button{
    color:#DC2626!important;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-menu a:hover{
    background:#F7F7F9;
}


html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-nav-profile-menu button:hover{
    background:#FEF2F2;
}


/* ================================================================
   HIDE MOBILE ON DESKTOP
================================================================ */
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-mobile-menu-button,
html[data-baca-device="desktop"][data-baca-input="fine"]
.bd-mobile-menu{
    display:none!important;
}


/* ================================================================
   LAPTOP 1024 - 1199
================================================================ */
@media(
    min-width:1024px
)
and
(
    max-width:1199px
){

    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-navbar-container{
        width:
            calc(100% - 20px);
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-navbar-row{
        grid-template-columns:
            22% 78%;

        height:78px;
    }


    /*
    |--------------------------------------------------------------------------
    | Logo laptop kecil
    |--------------------------------------------------------------------------
    */
    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-navbar-brand-area{
        padding-left:28px;

        padding-right:10px;
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-navbar-logo{
        transform:
            translateX(4px);
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-navbar-logo img{
        height:49px;

        max-width:125px;
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-nav-slot{
        padding:
            0 2px;
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-nav-link{
        min-height:43px;

        padding:
            0 5px;

        font-size:10.5px;

        border-radius:10px;
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-nav-link svg{
        width:11px;

        height:11px;
    }


    html[data-baca-device="desktop"][data-baca-input="fine"]
    .bd-nav-submit{
        min-height:43px;

        padding:
            0 8px;

        font-size:10px;
    }

}


/* ================================================================
   TABLET
================================================================ */
html[data-baca-device="tablet"]
.bd-navbar-row{
    height:76px;
}


html[data-baca-device="tablet"]
.bd-navbar-logo img{
    height:51px;

    max-width:138px;
}


/* ================================================================
   PHONE
================================================================ */
html[data-baca-device="phone"]
.bd-navbar-container{
    width:100%;

    padding:
        0 15px;
}


html[data-baca-device="phone"]
.bd-navbar-row{
    height:72px;
}


html[data-baca-device="phone"]
.bd-navbar-logo img{
    height:49px;

    max-width:132px;
}


html[data-baca-device="phone"]
.bd-mobile-menu-inner{
    width:100%;

    max-height:
        calc(100dvh - 72px);

    padding:
        14px 15px 19px;
}


/* ================================================================
   MOBILE MENU OPEN
================================================================ */
body.bd-menu-open{
    overflow:hidden;
}


/* ================================================================
   SMALL PHONE
================================================================ */
@media(max-width:390px){

    html[data-baca-device="phone"]
    .bd-navbar-container{
        padding:
            0 12px;
    }


    html[data-baca-device="phone"]
    .bd-navbar-logo img{
        height:45px;

        max-width:122px;
    }


    html[data-baca-device="phone"]
    .bd-mobile-menu-button{
        width:43px;

        height:43px;
    }

}
</style>


<script>
(function () {

    function initBacaNavbar() {

        const nav =
            document.getElementById(
                'main-navbar'
            );


        if (
            !nav
            ||
            nav.dataset.navReady === '1'
        ) {
            return;
        }


        nav.dataset.navReady =
            '1';


        const menu =
            nav.querySelector(
                '#mobile-menu'
            );


        const button =
            nav.querySelector(
                '#mobile-menu-button'
            );


        const hamburger =
            nav.querySelector(
                '#hamburger-icon'
            );


        const close =
            nav.querySelector(
                '#close-icon'
            );


        if (
            !menu
            ||
            !button
        ) {
            return;
        }


        /* =========================================================
           DEVICE
        ========================================================== */
        function isDesktop() {

            if (
                window.BacaDevice
            ) {

                return (
                    window.BacaDevice.type ===
                    'desktop'
                    &&
                    window.BacaDevice.input ===
                    'fine'
                );
            }


            return (
                window.matchMedia(
                    '(min-width:1024px)'
                ).matches
                &&
                window.matchMedia(
                    '(hover:hover)'
                ).matches
                &&
                window.matchMedia(
                    '(pointer:fine)'
                ).matches
            );
        }


        /* =========================================================
           MENU STATE
        ========================================================== */
        function setMenu(
            open
        ) {

            if (
                isDesktop()
            ) {
                open =
                    false;
            }


            menu.classList.toggle(
                'is-open',
                open
            );


            button.setAttribute(
                'aria-expanded',
                open
                    ? 'true'
                    : 'false'
            );


            hamburger
                ?.classList
                .toggle(
                    'is-hidden',
                    open
                );


            close
                ?.classList
                .toggle(
                    'is-hidden',
                    !open
                );


            document.body
                .classList
                .toggle(
                    'bd-menu-open',
                    open
                );
        }


        /* =========================================================
           BUTTON
        ========================================================== */
        button.addEventListener(
            'click',
            function () {

                if (
                    isDesktop()
                ) {

                    setMenu(
                        false
                    );

                    return;
                }


                setMenu(
                    !menu.classList
                        .contains(
                            'is-open'
                        )
                );
            }
        );


        /* =========================================================
           CLOSE AFTER LINK
        ========================================================== */
        menu.querySelectorAll(
            'a'
        ).forEach(
            function (
                link
            ) {

                link.addEventListener(
                    'click',
                    function () {

                        setMenu(
                            false
                        );

                    }
                );

            }
        );


        /* =========================================================
           ESC
        ========================================================== */
        document.addEventListener(
            'keydown',
            function (
                event
            ) {

                if (
                    event.key ===
                    'Escape'
                ) {

                    setMenu(
                        false
                    );

                }

            }
        );


        /* =========================================================
           CLICK OUTSIDE
        ========================================================== */
        document.addEventListener(
            'click',
            function (
                event
            ) {

                if (
                    !menu.classList
                        .contains(
                            'is-open'
                        )
                ) {
                    return;
                }


                if (
                    nav.contains(
                        event.target
                    )
                ) {
                    return;
                }


                setMenu(
                    false
                );

            }
        );


        /* =========================================================
           DEVICE CHANGE
        ========================================================== */
        window.addEventListener(
            'baca:devicechange',
            function () {

                if (
                    isDesktop()
                ) {

                    setMenu(
                        false
                    );

                }

            }
        );


        /* =========================================================
           INITIAL
        ========================================================== */
        setMenu(
            false
        );
    }


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initBacaNavbar,
            {
                once:true
            }
        );

    }
    else {

        initBacaNavbar();

    }

})();
</script>