@extends('layouts.app')

@section('title', 'Publisher - Baca Dulu')

@section('content')

<div class="publisher-page">

    <div class="container-fluid publisher-container">

        {{-- HEADER --}}
        <div class="row justify-content-center text-center mb-5">

            <div class="col-lg-8">

                <span class="publisher-badge">
                    Penerbit
                </span>

                <h1 class="publisher-heading">
                    Baca Publisher
                </h1>

                <p class="publisher-subtitle">
                    Temukan penerbit dan mitra penerbitan yang bekerja sama dengan Baca Dulu.
                </p>

            </div>

        </div>


        {{-- GRID --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 g-4">

            @forelse($publishers as $publisher)

                <div class="col">

                    <article class="publisher-card h-100">

                        {{-- IMAGE --}}
                        @if(!empty($publisher->logo))

                            <div class="publisher-image-wrapper">

                                <img
                                    src="{{ asset('storage/' . $publisher->logo) }}"
                                    alt="{{ $publisher->name ?? 'Publisher' }}"
                                    class="publisher-image"
                                >

                            </div>

                        @elseif(!empty($publisher->image))

                            <div class="publisher-image-wrapper">

                                <img
                                    src="{{ asset('storage/' . $publisher->image) }}"
                                    alt="{{ $publisher->name ?? 'Publisher' }}"
                                    class="publisher-image"
                                >

                            </div>

                        @else

                            <div class="publisher-placeholder">

                                <span>
                                    Baca Publisher
                                </span>

                            </div>

                        @endif


                        <div class="publisher-body">

                            <h2 class="publisher-title">

                                {{
                                    $publisher->name
                                    ??
                                    $publisher->title
                                    ??
                                    'Publisher'
                                }}

                            </h2>


                            <p class="publisher-description">

                                {{
                                    \Illuminate\Support\Str::limit(
                                        strip_tags(
                                            $publisher->description ?? '-'
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

                    <div class="publisher-empty">

                        <div class="publisher-empty-icon">
                            📚
                        </div>

                        <h3>
                            Belum Ada Publisher
                        </h3>

                        <p>
                            Data publisher akan ditampilkan di sini.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($publishers->hasPages())

            <div class="publisher-pagination">

                {{
                    $publishers
                        ->onEachSide(1)
                        ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif

    </div>

</div>


<style>

    .publisher-page {
        width: 100%;
        min-height: 70vh;
        padding: 55px 0 70px;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .publisher-container {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .publisher-badge {
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

    .publisher-heading {
        margin: 15px 0 8px;
        color: #241B52;
        font-family: 'Poppins', sans-serif;
        font-size: 42px;
        font-weight: 700;
    }

    .publisher-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
    }

    .publisher-card {
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
            box-shadow 0.25s ease;
    }

    .publisher-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(36, 27, 82, 0.12);
    }

    .publisher-image-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 190px;
        padding: 18px;
        overflow: hidden;
        background: #ffffff;
        border-bottom: 1px solid #f1f1f1;
    }

    .publisher-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }

    .publisher-card:hover .publisher-image {
        transform: scale(1.04);
    }

    .publisher-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 190px;
        padding: 20px;
        color: #9ca3af;
        background: linear-gradient(
            135deg,
            #f3f4f6,
            #e5e7eb
        );
        font-size: 14px;
        font-weight: 700;
        text-align: center;
    }

    .publisher-body {
        flex: 1;
        padding: 19px;
    }

    .publisher-title {
        margin: 0 0 10px;
        color: #241B52;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.45;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .publisher-description {
        margin: 0;
        color: #6b7280;
        font-size: 12.5px;
        line-height: 1.65;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .publisher-empty {
        padding: 70px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
    }

    .publisher-empty-icon {
        margin-bottom: 12px;
        font-size: 38px;
    }

    .publisher-empty h3 {
        margin: 0 0 6px;
        color: #241B52;
        font-size: 20px;
        font-weight: 700;
    }

    .publisher-empty p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .publisher-pagination {
        display: flex;
        justify-content: center;
        margin-top: 45px;
    }

    .publisher-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin: 0;
    }

    .publisher-pagination .page-link {
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
    }

    .publisher-pagination .page-link:hover {
        background: #fff5f2;
        border-color: #EF5843;
        color: #EF5843;
    }

    .publisher-pagination .page-item.active .page-link {
        background: #241B52;
        border-color: #241B52;
        color: #ffffff;
    }

    .publisher-pagination .page-item.disabled .page-link {
        background: #f8fafc;
        color: #9ca3af;
    }

    @media (max-width: 991px) {

        .publisher-container {
            padding: 0 24px;
        }

        .publisher-heading {
            font-size: 36px;
        }

    }

    @media (max-width: 575px) {

        .publisher-page {
            padding: 40px 0 55px;
        }

        .publisher-container {
            padding: 0 18px;
        }

        .publisher-heading {
            font-size: 30px;
        }

        .publisher-image-wrapper,
        .publisher-placeholder {
            height: 230px;
        }

    }

</style>

@endsection