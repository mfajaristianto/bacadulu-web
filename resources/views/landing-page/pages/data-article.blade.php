@extends('layouts.app')

@section('title', 'Data Artikel - Baca Dulu')

@section('content')

<div class="article-archive-page">

    <div class="container-fluid article-archive-container">

        {{-- HEADER --}}
        <div class="row justify-content-center text-center mb-5">

            <div class="col-lg-8">

                <span class="article-archive-badge">
                    Arsip
                </span>

                <h1 class="article-archive-heading">
                    Data Artikel
                </h1>

                <p class="article-archive-subtitle">
                    Kumpulan artikel dan publikasi pilihan.
                </p>

            </div>

        </div>


        {{-- GRID --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 g-4">

            @forelse($dataArticles as $article)

                <div class="col">

                    <article class="article-archive-card h-100">

                        @if($article->image)

                            <div class="article-archive-image-wrapper">

                                <img
                                    src="{{ asset('storage/' . $article->image) }}"
                                    alt="{{ $article->title ?? 'Artikel' }}"
                                    class="article-archive-image"
                                >

                            </div>

                        @else

                            <div class="article-archive-placeholder">
                                Artikel
                            </div>

                        @endif


                        <div class="article-archive-body">

                            <h2 class="article-archive-title">
                                {{ $article->title ?? 'Artikel' }}
                            </h2>


                            <p class="article-archive-description">

                                {{
                                    \Illuminate\Support\Str::limit(
                                        strip_tags(
                                            $article->description ?? '-'
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

                    <div class="article-archive-empty">

                        <div class="article-archive-empty-icon">
                            📄
                        </div>

                        <h3>
                            Belum Ada Data Artikel
                        </h3>

                        <p>
                            Data artikel akan ditampilkan di sini.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($dataArticles->hasPages())

            <div class="article-archive-pagination">

                {{
                    $dataArticles
                        ->onEachSide(1)
                        ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif

    </div>

</div>


<style>

    .article-archive-page {
        width: 100%;
        min-height: 70vh;
        padding: 55px 0 70px;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .article-archive-container {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .article-archive-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(36, 27, 82, 0.08);
        color: #241B52;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .article-archive-heading {
        margin: 15px 0 8px;
        color: #241B52;
        font-family: 'Poppins', sans-serif;
        font-size: 42px;
        font-weight: 700;
        line-height: 1.2;
    }

    .article-archive-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
    }

    .article-archive-card {
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

    .article-archive-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(36, 27, 82, 0.12);
    }

    .article-archive-image-wrapper {
        width: 100%;
        height: 190px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .article-archive-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .article-archive-card:hover .article-archive-image {
        transform: scale(1.05);
    }

    .article-archive-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 190px;
        color: #9ca3af;
        background: linear-gradient(
            135deg,
            #f3f4f6,
            #e5e7eb
        );
        font-weight: 700;
        font-size: 14px;
    }

    .article-archive-body {
        flex: 1;
        padding: 19px;
    }

    .article-archive-title {
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

    .article-archive-description {
        margin: 0;
        color: #6b7280;
        font-size: 12.5px;
        line-height: 1.65;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .article-archive-empty {
        padding: 70px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
    }

    .article-archive-empty-icon {
        margin-bottom: 12px;
        font-size: 38px;
    }

    .article-archive-empty h3 {
        margin: 0 0 6px;
        color: #241B52;
        font-size: 20px;
        font-weight: 700;
    }

    .article-archive-empty p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .article-archive-pagination {
        display: flex;
        justify-content: center;
        margin-top: 45px;
    }

    .article-archive-pagination .pagination {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        margin: 0;
    }

    .article-archive-pagination .page-link {
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

    .article-archive-pagination .page-link:hover {
        background: #fff5f2;
        border-color: #EF5843;
        color: #EF5843;
    }

    .article-archive-pagination .page-item.active .page-link {
        background: #241B52;
        border-color: #241B52;
        color: #ffffff;
    }

    .article-archive-pagination .page-item.disabled .page-link {
        color: #9ca3af;
        background: #f8fafc;
    }

    @media (max-width: 991px) {

        .article-archive-container {
            padding: 0 24px;
        }

        .article-archive-heading {
            font-size: 36px;
        }

    }

    @media (max-width: 575px) {

        .article-archive-page {
            padding: 40px 0 55px;
        }

        .article-archive-container {
            padding: 0 18px;
        }

        .article-archive-heading {
            font-size: 30px;
        }

        .article-archive-image-wrapper,
        .article-archive-placeholder {
            height: 230px;
        }

    }

</style>

@endsection