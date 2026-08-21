@extends('layouts.app')

@section('title', 'Conference - Baca Dulu')

@section('content')

<div class="catalog-page">

    <div class="container-fluid catalog-container">

        {{-- HEADER --}}
        <div class="row justify-content-center text-center mb-5">

            <div class="col-lg-8">

                <span class="catalog-badge">
                    Event Ilmiah
                </span>

                <h1 class="catalog-heading">
                    Conference
                </h1>

                <p class="catalog-subtitle">
                    Informasi konferensi dan seminar ilmiah terbaru.
                </p>

            </div>

        </div>


        {{-- GRID --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 g-4">

            @forelse($conferences as $conference)

                <div class="col">

                    <article class="catalog-card h-100">

                        {{-- POSTER --}}
                        @if($conference->poster)

                            <div class="catalog-image-wrapper">

                                <img
                                    src="{{ asset('storage/' . $conference->poster) }}"
                                    alt="{{ $conference->name ?? $conference->title ?? 'Conference' }}"
                                    class="catalog-image"
                                >

                            </div>

                        @else

                            <div class="catalog-placeholder">
                                Conference
                            </div>

                        @endif


                        {{-- CONTENT --}}
                        <div class="catalog-body">

                            <h2 class="catalog-title">

                                {{
                                    $conference->name
                                    ??
                                    $conference->title
                                    ??
                                    'Conference'
                                }}

                            </h2>


                            @if($conference->event_date)

                                <div class="catalog-date">

                                    <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                        />
                                    </svg>

                                    <span>
                                        {{
                                            \Carbon\Carbon::parse(
                                                $conference->event_date
                                            )->translatedFormat('d F Y')
                                        }}
                                    </span>

                                </div>

                            @endif


                            <p class="catalog-description">

                                {{
                                    \Illuminate\Support\Str::limit(
                                        strip_tags(
                                            $conference->description ?? '-'
                                        ),
                                        120
                                    )
                                }}

                            </p>

                        </div>

                    </article>

                </div>

            @empty

                <div class="col-12">

                    <div class="catalog-empty">

                        <div class="catalog-empty-icon">
                            📅
                        </div>

                        <h3>
                            Belum Ada Conference
                        </h3>

                        <p>
                            Informasi conference akan ditampilkan di sini.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($conferences->hasPages())

            <div class="catalog-pagination">

                {{
                    $conferences
                        ->onEachSide(1)
                        ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif

    </div>

</div>


<style>

    .catalog-page {
        width: 100%;
        min-height: 70vh;
        padding: 55px 0 70px;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .catalog-container {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding-left: 40px;
        padding-right: 40px;
    }

    .catalog-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(239, 88, 67, 0.10);
        color: #c6432f;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .catalog-heading {
        margin: 15px 0 8px;
        color: #241B52;
        font-family: 'Poppins', sans-serif;
        font-size: 42px;
        font-weight: 700;
        line-height: 1.2;
    }

    .catalog-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
    }

    .catalog-card {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e7e9ee;
        border-radius: 17px;
        box-shadow: 0 5px 18px rgba(36, 27, 82, 0.05);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .catalog-card:hover {
        transform: translateY(-6px);
        border-color: rgba(239, 88, 67, 0.28);
        box-shadow: 0 16px 35px rgba(36, 27, 82, 0.12);
    }

    .catalog-image-wrapper {
        width: 100%;
        height: 190px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .catalog-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .catalog-card:hover .catalog-image {
        transform: scale(1.05);
    }

    .catalog-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 190px;
        background: linear-gradient(
            135deg,
            #f3f4f6,
            #e5e7eb
        );
        color: #9ca3af;
        font-size: 14px;
        font-weight: 700;
    }

    .catalog-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 19px;
    }

    .catalog-title {
        margin: 0 0 11px;
        color: #241B52;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .catalog-date {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 11px;
        color: #EF5843;
        font-size: 11.5px;
        font-weight: 600;
    }

    .catalog-date svg {
        flex-shrink: 0;
    }

    .catalog-description {
        margin: 0;
        color: #6b7280;
        font-size: 12.5px;
        line-height: 1.65;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .catalog-empty {
        width: 100%;
        padding: 70px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
    }

    .catalog-empty-icon {
        margin-bottom: 12px;
        font-size: 38px;
    }

    .catalog-empty h3 {
        margin: 0 0 6px;
        color: #241B52;
        font-size: 20px;
        font-weight: 700;
    }

    .catalog-empty p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .catalog-pagination {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 45px;
    }

    .catalog-pagination .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 7px;
        margin: 0;
        padding: 0;
    }

    .catalog-pagination .page-item {
        margin: 0;
    }

    .catalog-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border: 1px solid #e5e7eb;
        border-radius: 10px !important;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .catalog-pagination .page-link:hover {
        background: #fff5f2;
        border-color: #EF5843;
        color: #EF5843;
    }

    .catalog-pagination .page-item.active .page-link {
        background: #241B52;
        border-color: #241B52;
        color: #ffffff;
    }

    .catalog-pagination .page-item.disabled .page-link {
        background: #f8fafc;
        border-color: #e5e7eb;
        color: #9ca3af;
    }

    @media (max-width: 1199px) {

        .catalog-image-wrapper,
        .catalog-placeholder {
            height: 210px;
        }

    }

    @media (max-width: 991px) {

        .catalog-container {
            padding-left: 24px;
            padding-right: 24px;
        }

        .catalog-heading {
            font-size: 36px;
        }

    }

    @media (max-width: 575px) {

        .catalog-page {
            padding: 40px 0 55px;
        }

        .catalog-container {
            padding-left: 18px;
            padding-right: 18px;
        }

        .catalog-heading {
            font-size: 30px;
        }

        .catalog-subtitle {
            font-size: 14px;
        }

        .catalog-image-wrapper,
        .catalog-placeholder {
            height: 230px;
        }

    }

</style>

@endsection