@extends('layouts.app')

@section('title', 'Informasi Terbaru - Baca Dulu')

@section('content')

<style>
.information-page {
    --navy: #241B52;
    --orange: #EF5843;
    --orange-dark: #C6432F;
    --gold: #F7AA35;
    --text: #334155;
    --muted: #6B7280;
    --border: #E7E9EE;
    --cream: #FBF9F5;
    width: 100%;
    min-height: 100vh;
    overflow-x: hidden;
    background:
        radial-gradient(circle at 100% 0, rgba(239, 88, 67, .08), transparent 28%),
        #F8FAFC;
    color: var(--navy);
    font-family: 'Inter', sans-serif;
}

.information-page *,
.information-page *::before,
.information-page *::after {
    box-sizing: border-box;
}

.information-container {
    width: min(calc(100% - 64px), 1500px);
    margin: 0 auto;
}

/* HERO */
.information-hero {
    position: relative;
    padding: 70px 0 48px;
    overflow: hidden;
    border-top: 3px solid var(--orange);
    background: #fff;
}

.information-hero::after {
    content: "";
    position: absolute;
    width: 420px;
    height: 420px;
    right: -160px;
    top: -230px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(247, 170, 53, .18),
        rgba(239, 88, 67, .05) 48%,
        transparent 70%
    );
    pointer-events: none;
}

.information-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
}

.information-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 30px;
    padding: 6px 12px;
    border: 1px solid #FED7AA;
    border-radius: 999px;
    background: #FFF7ED;
    color: #C2410C;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.information-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--orange);
}

.information-heading {
    max-width: 720px;
    margin: 17px 0 10px;
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-size: clamp(36px, 4vw, 52px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -1.3px;
}

.information-subtitle {
    max-width: 650px;
    margin: 0;
    color: var(--muted);
    font-size: 14px;
    line-height: 1.75;
}

/* SECTION */
.information-section {
    padding: 48px 0 70px;
}

.information-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 26px;
}

.information-head-title {
    min-width: 0;
}

.information-title-row {
    display: flex;
    align-items: center;
    gap: 9px;
}

.information-title-marker {
    width: 9px;
    height: 9px;
    flex-shrink: 0;
    border-radius: 3px;
    background: linear-gradient(135deg, var(--orange), var(--gold));
}

.information-title-row h2 {
    margin: 0;
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 750;
}

.information-head-title p {
    margin: 6px 0 0 18px;
    color: var(--muted);
    font-size: 11px;
}

.information-page-info {
    flex-shrink: 0;
    padding: 10px 14px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: #fff;
    color: var(--muted);
    font-size: 10px;
    font-weight: 700;
}

.information-page-info strong {
    color: var(--navy);
}

/* GRID */
.information-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 18px;
    align-items: stretch;
}

.information-card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    height: 100%;
    overflow: hidden;
    border: 1px solid var(--border);
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(36, 27, 82, .05);
    transition:
        transform .28s ease,
        border-color .28s ease,
        box-shadow .28s ease;
}

.information-card:hover {
    transform: translateY(-5px);
    border-color: rgba(239, 88, 67, .28);
    box-shadow: 0 18px 38px rgba(36, 27, 82, .10);
}

/* IMAGE */
.information-image-link {
    position: relative;
    display: block;
    width: 100%;
    height: 215px;
    overflow: hidden;
    background: linear-gradient(135deg, #F8FAFC, #EEF2F7);
}

.information-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

.information-card:hover .information-image {
    transform: scale(1.035);
}

.information-placeholder {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 9px;
    padding: 20px;
    color: var(--navy);
    background:
        radial-gradient(circle at 50% 45%, rgba(247, 170, 53, .15), transparent 35%),
        var(--cream);
}

.information-placeholder.show {
    display: flex;
}

.information-placeholder svg {
    width: 36px;
    height: 36px;
    fill: none;
    stroke: var(--orange);
    stroke-width: 1.6;
}

.information-placeholder span {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.information-image-label {
    position: absolute;
    left: 12px;
    bottom: 12px;
    z-index: 3;
    display: inline-flex;
    align-items: center;
    min-height: 27px;
    padding: 5px 10px;
    border-radius: 999px;
    color: #C2410C;
    background: rgba(255, 247, 237, .95);
    backdrop-filter: blur(7px);
    font-size: 8px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .04em;
}

/* BODY */
.information-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    padding: 17px;
}

.information-meta {
    display: flex;
    align-items: center;
    gap: 7px;
    min-height: 17px;
    margin-bottom: 8px;
    color: #94A3B8;
    font-size: 9px;
    font-weight: 600;
}

.information-meta-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--orange);
}

.information-title {
    min-height: 44px;
    max-height: 44px;
    margin: 0;
    overflow: hidden;
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 700;
    line-height: 1.55;
    overflow-wrap: anywhere;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.information-description {
    min-height: 60px;
    max-height: 60px;
    margin: 9px 0 0;
    overflow: hidden;
    color: var(--muted);
    font-size: 11px;
    line-height: 1.75;
    overflow-wrap: anywhere;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.information-action {
    margin-top: auto;
    padding-top: 17px;
}

.information-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
    min-height: 40px;
    padding: 9px 13px;
    border: 1px solid #FED7AA;
    border-radius: 10px;
    background: #FFF7ED;
    color: var(--orange-dark) !important;
    font-size: 10px;
    font-weight: 800;
    text-decoration: none !important;
    transition:
        background .2s ease,
        color .2s ease,
        border-color .2s ease;
}

.information-button svg {
    width: 15px;
    height: 15px;
    flex-shrink: 0;
    fill: none;
    stroke: currentColor;
    stroke-width: 2;
    transition: transform .2s ease;
}

.information-button:hover {
    border-color: var(--orange);
    background: var(--orange);
    color: #fff !important;
}

.information-button:hover svg {
    transform: translateX(3px);
}

/* EMPTY */
.information-empty {
    grid-column: 1 / -1;
    padding: 65px 25px;
    border: 1px dashed #CBD5E1;
    border-radius: 18px;
    background: #fff;
    text-align: center;
}

.information-empty-icon {
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    border-radius: 50%;
    background: #FFF7ED;
    color: var(--orange);
}

.information-empty-icon svg {
    width: 26px;
    height: 26px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.7;
}

.information-empty h3 {
    margin: 0;
    color: var(--navy);
    font-size: 17px;
    font-weight: 800;
}

.information-empty p {
    margin: 7px 0 0;
    color: var(--muted);
    font-size: 11px;
}

/* PAGINATION */
.information-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 38px;
}

.information-pagination a,
.information-pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    height: 42px;
    padding: 0 11px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: #fff;
    color: var(--navy) !important;
    font-size: 11px;
    font-weight: 800;
    text-decoration: none;
    transition:
        border-color .2s ease,
        color .2s ease,
        background .2s ease;
}

.information-pagination a:hover {
    border-color: var(--orange);
    color: var(--orange) !important;
}

.information-pagination .active {
    border-color: var(--navy);
    background: var(--navy);
    color: #fff !important;
}

.information-pagination .disabled {
    background: #F8FAFC;
    color: #CBD5E1 !important;
}

/* RESPONSIVE */
@media (max-width: 1199px) {
    .information-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 767px) {
    .information-container {
        width: calc(100% - 34px);
    }

    .information-hero {
        padding: 52px 0 40px;
    }

    .information-heading {
        font-size: 35px;
    }

    .information-subtitle {
        font-size: 12px;
    }

    .information-section {
        padding: 38px 0 55px;
    }

    .information-section-head {
        align-items: flex-start;
        flex-direction: column;
        gap: 14px;
    }

    .information-title-row h2 {
        font-size: 21px;
    }

    .information-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
    }

    .information-image-link {
        height: 190px;
    }

    .information-pagination a,
    .information-pagination span {
        min-width: 44px;
        height: 44px;
    }
}

@media (max-width: 480px) {
    .information-container {
        width: calc(100% - 30px);
    }

    .information-heading {
        font-size: 31px;
    }

    .information-grid {
        grid-template-columns: 1fr;
    }

    .information-image-link {
        height: 225px;
    }
}
</style>

<div class="information-page">

    <section class="information-hero">
        <div class="information-container">
            <div class="information-hero-content">

                <span class="information-badge">
                    <span class="information-badge-dot"></span>
                    Pusat Informasi
                </span>

                <h1 class="information-heading">
                    Informasi Terbaru
                </h1>

                <p class="information-subtitle">
                    Pengumuman, berita, dan informasi penting
                    seputar layanan Baca Dulu.
                </p>

            </div>
        </div>
    </section>

    <section
        class="information-section"
        id="informasi-list"
    >
        <div class="information-container">

            <div class="information-section-head">

                <div class="information-head-title">
                    <div class="information-title-row">
                        <span class="information-title-marker"></span>

                        <h2>
                            Informasi & Pengumuman
                        </h2>
                    </div>

                    <p>
                        Maksimal 5 informasi ditampilkan pada setiap halaman.
                    </p>
                </div>

                @if($informations->total() > 0)
                    <div class="information-page-info">
                        Halaman
                        <strong>
                            {{ $informations->currentPage() }}
                        </strong>
                        dari
                        <strong>
                            {{ $informations->lastPage() }}
                        </strong>
                    </div>
                @endif

            </div>

            <div class="information-grid">

                @forelse($informations as $info)

                    @php
                        $description = \Illuminate\Support\Str::limit(
                            trim(
                                html_entity_decode(
                                    strip_tags($info->content ?? '')
                                )
                            ),
                            125
                        );

                        $date = $info->created_at
                            ? $info->created_at
                                ->timezone('Asia/Jakarta')
                                ->translatedFormat('d M Y')
                            : null;
                    @endphp

                    <article class="information-card">

                        <a
                            href="{{ route('informasi.show', ['information' => $info->slug]) }}"
                            class="information-image-link"
                            aria-label="Baca {{ $info->title }}"
                        >

                            @if($info->image)

                                <img
                                    src="{{ asset('storage/' . $info->image) }}"
                                    alt="{{ $info->title }}"
                                    class="information-image"
                                    loading="lazy"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.classList.add('show');
                                    "
                                >

                                <div class="information-placeholder">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M5 4h14v16H5z"/>
                                        <path d="M8 8h8M8 12h8M8 16h5"/>
                                    </svg>

                                    <span>Baca Dulu</span>
                                </div>

                            @else

                                <div class="information-placeholder show">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M5 4h14v16H5z"/>
                                        <path d="M8 8h8M8 12h8M8 16h5"/>
                                    </svg>

                                    <span>Baca Dulu</span>
                                </div>

                            @endif

                            <span class="information-image-label">
                                Informasi
                            </span>

                        </a>

                        <div class="information-body">

                            @if($date)
                                <div class="information-meta">
                                    <span>Update</span>

                                    <span class="information-meta-dot"></span>

                                    <time>
                                        {{ $date }}
                                    </time>
                                </div>
                            @endif

                            <h2 class="information-title">
                                {{ $info->title }}
                            </h2>

                            <p class="information-description">
                                {{ $description ?: 'Klik untuk membaca informasi selengkapnya.' }}
                            </p>

                            <div class="information-action">
                                <a
                                    href="{{ route('informasi.show', ['information' => $info->slug]) }}"
                                    class="information-button"
                                >
                                    <span>
                                        Baca Selengkapnya
                                    </span>

                                    <svg viewBox="0 0 24 24">
                                        <path d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </article>

                @empty

                    <div class="information-empty">

                        <div class="information-empty-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M5 4h14v16H5z"/>
                                <path d="M8 8h8M8 12h8M8 16h5"/>
                            </svg>
                        </div>

                        <h3>
                            Belum Ada Informasi
                        </h3>

                        <p>
                            Informasi terbaru Baca Dulu akan tampil di halaman ini.
                        </p>

                    </div>

                @endforelse

            </div>

            @if($informations->hasPages())

                @php
                    $startPage = max(
                        1,
                        $informations->currentPage() - 2
                    );

                    $endPage = min(
                        $informations->lastPage(),
                        $informations->currentPage() + 2
                    );
                @endphp

                <nav
                    class="information-pagination"
                    aria-label="Navigasi halaman informasi"
                >

                    @if($informations->onFirstPage())
                        <span class="disabled">
                            ‹
                        </span>
                    @else
                        <a
                            href="{{ $informations->previousPageUrl() }}#informasi-list"
                            aria-label="Halaman sebelumnya"
                        >
                            ‹
                        </a>
                    @endif

                    @if($startPage > 1)

                        <a href="{{ $informations->url(1) }}#informasi-list">
                            1
                        </a>

                        @if($startPage > 2)
                            <span class="disabled">
                                ...
                            </span>
                        @endif

                    @endif

                    @for($page = $startPage; $page <= $endPage; $page++)

                        @if($page === $informations->currentPage())

                            <span class="active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $informations->url($page) }}#informasi-list">
                                {{ $page }}
                            </a>

                        @endif

                    @endfor

                    @if($endPage < $informations->lastPage())

                        @if($endPage < $informations->lastPage() - 1)
                            <span class="disabled">
                                ...
                            </span>
                        @endif

                        <a href="{{ $informations->url($informations->lastPage()) }}#informasi-list">
                            {{ $informations->lastPage() }}
                        </a>

                    @endif

                    @if($informations->hasMorePages())

                        <a
                            href="{{ $informations->nextPageUrl() }}#informasi-list"
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

</div>

@endsection