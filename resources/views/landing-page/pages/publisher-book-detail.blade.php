@extends('layouts.app')

@section('title', $book->title . ' - Baca Publisher')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap');


.bd-book-detail {
    --navy: #241B52;
    --orange: #EF5843;

    --body: #5C626D;
    --muted: #959AA4;

    --line: #E6E8EC;
    --soft: #F6F7F8;

    min-height: 100vh;

    padding:
        37px 0
        70px;

    background: #FFFFFF;

    font-family: 'Inter', sans-serif;
}

.bd-book-detail-shell {
    width: min(
        calc(100% - 72px),
        1200px
    );

    margin-inline: auto;
}


/* BACK */

.bd-book-detail-back {
    display: inline-flex;
    align-items: center;

    gap: 8px;

    margin-bottom: 28px;

    color: #6B7079 !important;

    font-size: 10px;
    font-weight: 650;

    text-decoration: none !important;
}

.bd-book-detail-back:hover {
    color: var(--orange) !important;
}

.bd-book-detail-back svg {
    width: 15px;
    height: 15px;

    fill: none;
    stroke: currentColor;

    stroke-width: 1.7;
}


/* HERO */

.bd-book-detail-hero {
    display: grid;

    grid-template-columns:
        360px
        minmax(0, 1fr);

    gap: 65px;

    align-items: start;

    padding-bottom: 45px;

    border-bottom: 1px solid var(--line);
}

.bd-book-detail-cover {
    width: 100%;

    aspect-ratio: 3 / 4.2;

    overflow: hidden;

    background: var(--soft);

    box-shadow:
        0 18px 40px
        rgba(36,27,82,.10);
}

.bd-book-detail-cover img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}

.bd-book-detail-cover-empty {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: var(--navy);
}

.bd-book-detail-cover-empty span {
    width: 9px;
    height: 9px;

    background: var(--orange);
}


/* CONTENT */

.bd-book-detail-kicker {
    display: flex;
    align-items: center;

    gap: 8px;

    margin-bottom: 12px;

    color: var(--orange);

    font-size: 8px;
    font-weight: 800;

    letter-spacing: .13em;

    text-transform: uppercase;
}

.bd-book-detail-kicker::before {
    content: "";

    width: 20px;
    height: 2px;

    background: var(--orange);
}

.bd-book-detail-title {
    max-width: 730px;

    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: clamp(
        34px,
        4.5vw,
        58px
    );

    font-weight: 600;

    line-height: 1.08;

    letter-spacing: -.05em;
}

.bd-book-detail-author {
    margin-top: 14px;

    color: #4D535D;

    font-size: 13px;
    font-weight: 650;
}


/* STATUS */

.bd-book-detail-status {
    display: inline-flex;
    align-items: center;

    gap: 7px;

    margin-top: 18px;

    color: #348259;

    font-size: 9px;
    font-weight: 750;

    letter-spacing: .04em;

    text-transform: uppercase;
}

.bd-book-detail-status::before {
    content: "";

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #47A873;
}


/* META */

.bd-book-detail-meta {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    margin-top: 28px;

    border-top: 1px solid var(--line);
}

.bd-book-detail-meta-item {
    min-height: 75px;

    padding:
        15px 20px
        14px 0;

    border-bottom: 1px solid var(--line);
}

.bd-book-detail-meta-item:nth-child(odd) {
    margin-right: 20px;

    border-right: 1px solid var(--line);
}

.bd-book-detail-meta-label {
    color: var(--muted);

    font-size: 8px;
    font-weight: 700;

    letter-spacing: .08em;

    text-transform: uppercase;
}

.bd-book-detail-meta-value {
    margin-top: 6px;

    color: var(--navy);

    font-size: 12px;
    font-weight: 650;

    line-height: 1.5;

    overflow-wrap: anywhere;
}


/* DESCRIPTION */

.bd-book-detail-description {
    display: grid;

    grid-template-columns:
        210px
        minmax(0, 720px);

    gap: 60px;

    padding:
        42px 0
        10px;
}

.bd-book-detail-description-title {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;

    font-size: 21px;
    font-weight: 600;

    letter-spacing: -.03em;
}

.bd-book-detail-description-content {
    color: #4E5560;

    font-size: 13px;

    line-height: 1.85;
}

.bd-book-detail-description-content p {
    margin:
        0 0
        16px;
}

.bd-book-detail-description-content img {
    max-width: 100%;
    height: auto;
}


/* MOBILE */

@media (max-width: 800px) {

    .bd-book-detail-shell {
        width:
            calc(100% - 40px);
    }

    .bd-book-detail-hero {
        grid-template-columns:
            270px
            minmax(0, 1fr);

        gap: 35px;
    }

}


@media (max-width: 640px) {

    .bd-book-detail {
        padding-top: 25px;
    }

    .bd-book-detail-shell {
        width:
            calc(100% - 30px);
    }

    .bd-book-detail-hero {
        grid-template-columns: 1fr;

        gap: 27px;
    }

    .bd-book-detail-cover {
        width: min(
            75%,
            290px
        );

        margin-inline: auto;
    }

    .bd-book-detail-title {
        font-size: 31px;
    }

    .bd-book-detail-meta {
        grid-template-columns: 1fr;
    }

    .bd-book-detail-meta-item:nth-child(odd) {
        margin-right: 0;

        border-right: 0;
    }

    .bd-book-detail-description {
        grid-template-columns: 1fr;

        gap: 16px;

        padding-top: 32px;
    }

}
</style>



<section class="bd-book-detail">

    <div class="bd-book-detail-shell">


        {{-- BACK --}}

        <a
            href="{{ url('/publisher') }}"
            class="bd-book-detail-back"
        >

            <svg viewBox="0 0 24 24">

                <path d="M19 12H5"/>

                <path d="m10 7-5 5 5 5"/>

            </svg>

            Kembali ke Baca Publisher

        </a>



        {{-- HERO --}}

        <div class="bd-book-detail-hero">


            {{-- COVER --}}

            <div class="bd-book-detail-cover">

                @if(!empty($book->cover))

                    <img
                        src="{{ asset('storage/' . $book->cover) }}"
                        alt="{{ $book->title }}"
                    >

                @else

                    <div class="bd-book-detail-cover-empty">
                        <span></span>
                    </div>

                @endif

            </div>



            {{-- INFORMATION --}}

            <div>

                <div class="bd-book-detail-kicker">
                    Terbitan Baca Publisher
                </div>


                <h1 class="bd-book-detail-title">

                    {{ $book->title }}

                </h1>


                @if(!empty($book->author))

                    <div class="bd-book-detail-author">

                        {{ $book->author }}

                    </div>

                @endif


                <div class="bd-book-detail-status">
                    Sudah Terbit
                </div>



                {{-- META --}}

                <div class="bd-book-detail-meta">


                    <div class="bd-book-detail-meta-item">

                        <div class="bd-book-detail-meta-label">
                            ISBN
                        </div>

                        <div class="bd-book-detail-meta-value">

                            {{ $book->isbn ?: '-' }}

                        </div>

                    </div>


                    <div class="bd-book-detail-meta-item">

                        <div class="bd-book-detail-meta-label">
                            Tahun Terbit
                        </div>

                        <div class="bd-book-detail-meta-value">

                            {{ $book->publish_year ?: '-' }}

                        </div>

                    </div>


                    <div class="bd-book-detail-meta-item">

                        <div class="bd-book-detail-meta-label">
                            Jumlah Halaman
                        </div>

                        <div class="bd-book-detail-meta-value">

                            @if(!empty($book->pages))

                                {{ $book->pages }} halaman

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    <div class="bd-book-detail-meta-item">

                        <div class="bd-book-detail-meta-label">
                            Jenis Buku
                        </div>

                        <div class="bd-book-detail-meta-value">

                            {{ $book->category ?: '-' }}

                        </div>

                    </div>


                    <div class="bd-book-detail-meta-item">

                        <div class="bd-book-detail-meta-label">
                            Penerbit
                        </div>

                        <div class="bd-book-detail-meta-value">

                            {{
                                $book->publisher
                                ?:
                                'BacaDulu Publisher'
                            }}

                        </div>

                    </div>


                    <div class="bd-book-detail-meta-item">

                        <div class="bd-book-detail-meta-label">
                            Status
                        </div>

                        <div class="bd-book-detail-meta-value">

                            Sudah Terbit

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- DESCRIPTION --}}

        <div class="bd-book-detail-description">

            <div>

                <h2 class="bd-book-detail-description-title">
                    Sinopsis
                </h2>

            </div>


            <div class="bd-book-detail-description-content">

                @if(!empty($book->description))

                    {!! $book->description !!}

                @else

                    <p>
                        Sinopsis buku belum tersedia.
                    </p>

                @endif

            </div>

        </div>

    </div>

</section>

@endsection