@extends('layouts.app')

@section('title', 'Informasi Terbaru - Baca Dulu')

@section('content')

<div class="information-page">

    <div class="container-fluid information-container">

        {{-- HEADER --}}
        <div class="row justify-content-center text-center mb-5">

            <div class="col-lg-8">

                <span class="information-badge">
                    Pusat Informasi
                </span>

                <h1 class="information-heading">
                    Informasi Terbaru
                </h1>

                <p class="information-subtitle">
                    Pengumuman dan berita penting seputar layanan.
                </p>

            </div>

        </div>


        {{-- GRID --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 g-4">

            @forelse($informations as $info)

                <div class="col">

                    <article class="information-card h-100">

                        {{-- IMAGE --}}
                        @if($info->image)

                            <div class="information-image-wrapper">

                                <img
                                    src="{{ asset('storage/' . $info->image) }}"
                                    alt="{{ $info->title }}"
                                    class="information-image"
                                >

                            </div>

                        @else

                            <div class="information-placeholder">
                                Informasi
                            </div>

                        @endif


                        <div class="information-body">

                            <div>

                                <h2 class="information-title">
                                    {{ $info->title }}
                                </h2>


                                <p class="information-description">

                                    {{
                                        \Illuminate\Support\Str::limit(
                                            strip_tags(
                                                $info->content ?? '-'
                                            ),
                                            115
                                        )
                                    }}

                                </p>

                            </div>


                            <div class="information-action">

                                <a
                                    href="{{ route('informasi.show', ['information' => $info->slug]) }}"
                                    class="information-button"
                                >
                                    Baca Selengkapnya
                                </a>

                            </div>

                        </div>

                    </article>

                </div>

            @empty

                <div class="col-12">

                    <div class="information-empty">

                        <div class="information-empty-icon">
                            📢
                        </div>

                        <h3>
                            Belum Ada Informasi
                        </h3>

                        <p>
                            Silakan tambahkan informasi melalui panel admin CMS.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($informations->hasPages())

            <div class="information-pagination">

                {{
                    $informations
                        ->onEachSide(1)
                        ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif

    </div>

</div>


<style>

    .information-page {
        width: 100%;
        min-height: 70vh;
        padding: 55px 0 70px;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .information-container {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .information-badge {
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

    .information-heading {
        margin: 15px 0 8px;
        color: #241B52;
        font-family: 'Poppins', sans-serif;
        font-size: 42px;
        font-weight: 700;
    }

    .information-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
    }

    .information-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        width: 100%;
        background: #ffffff;
        border: 1px solid #e7e9ee;
        border-radius: 17px;
        box-shadow: 0 5px 18px rgba(36, 27, 82, 0.05);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease;
    }

    .information-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(36, 27, 82, 0.12);
    }

    .information-image-wrapper {
        width: 100%;
        height: 190px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .information-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .information-card:hover .information-image {
        transform: scale(1.05);
    }

    .information-placeholder {
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
        font-weight: 700;
        font-size: 14px;
    }

    .information-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
        padding: 19px;
    }

    .information-title {
        margin: 0 0 10px;
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

    .information-description {
        margin: 0;
        color: #6b7280;
        font-size: 12.5px;
        line-height: 1.65;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .information-action {
        padding-top: 18px;
    }

    .information-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 39px;
        padding: 9px 12px;
        border-radius: 999px;
        background: #fff1ec;
        color: #d94731 !important;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .information-button:hover {
        background: #EF5843;
        color: #ffffff !important;
    }

    .information-empty {
        padding: 70px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
    }

    .information-empty-icon {
        margin-bottom: 12px;
        font-size: 38px;
    }

    .information-empty h3 {
        margin: 0 0 6px;
        color: #241B52;
        font-size: 20px;
        font-weight: 700;
    }

    .information-empty p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .information-pagination {
        display: flex;
        justify-content: center;
        margin-top: 45px;
    }

    .information-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin: 0;
    }

    .information-pagination .page-link {
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

    .information-pagination .page-link:hover {
        background: #fff5f2;
        border-color: #EF5843;
        color: #EF5843;
    }

    .information-pagination .page-item.active .page-link {
        background: #241B52;
        border-color: #241B52;
        color: #ffffff;
    }

    .information-pagination .page-item.disabled .page-link {
        background: #f8fafc;
        color: #9ca3af;
    }

    @media (max-width: 991px) {

        .information-container {
            padding: 0 24px;
        }

        .information-heading {
            font-size: 36px;
        }

    }

    @media (max-width: 575px) {

        .information-page {
            padding: 40px 0 55px;
        }

        .information-container {
            padding: 0 18px;
        }

        .information-heading {
            font-size: 30px;
        }

        .information-image-wrapper,
        .information-placeholder {
            height: 230px;
        }

    }

</style>

@endsection