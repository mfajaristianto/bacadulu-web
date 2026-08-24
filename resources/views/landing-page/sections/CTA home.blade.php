@php
    $informasiTerbaru = \App\Models\Information::query()
        ->latest()
        ->take(6)
        ->get();
@endphp


{{-- ================================================================
     INFORMASI & AGENDA
     TEAM-STYLE CARD CAROUSEL
================================================================ --}}

<section id="baca-informasi" class="bd-activity-section">

    <div class="bd-activity-accent bd-activity-accent-left" aria-hidden="true"></div>
    <div class="bd-activity-accent bd-activity-accent-right" aria-hidden="true"></div>

    <div class="bd-activity-container">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <header class="bd-activity-header">

            <div class="bd-activity-heading">

                <div class="bd-activity-eyebrow">

                    <span class="bd-activity-eyebrow-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 2v3M16 2v3M4 9h16M5 4h14a1 1 0 011 1v15H4V5a1 1 0 011-1z"
                            />
                        </svg>
                    </span>

                    <span>Informasi & Agenda</span>

                </div>

                <h2>
                    Update terbaru
                    <span>Baca Dulu.</span>
                </h2>

                <p>
                    Kegiatan, program, agenda, pengumuman, kolaborasi,
                    dan berbagai informasi terbaru dari Baca Dulu.
                </p>

            </div>


            <div class="bd-activity-header-action">

                @if(!$informasiTerbaru->isEmpty())

                    <div class="bd-activity-total">
                        <strong>
                            {{ str_pad(
                                $informasiTerbaru->count(),
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </strong>

                        <span>Update Terbaru</span>
                    </div>

                @endif


                <a href="{{ route('informasi') }}" class="bd-activity-all">

                    Semua Informasi

                    <span>
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

                </a>

            </div>

        </header>


        {{-- =========================================================
             DIVIDER
        ========================================================== --}}
        <div class="bd-activity-header-line">
            <span></span>
        </div>


        @if($informasiTerbaru->isEmpty())

            <div class="bd-activity-empty">

                <span>Update Baca Dulu</span>

                <h3>
                    Belum ada informasi terbaru.
                </h3>

                <p>
                    Kegiatan dan informasi terbaru akan tampil di bagian ini.
                </p>

            </div>

        @else

            {{-- =====================================================
                 CAROUSEL
            ====================================================== --}}
            <div class="bd-activity-showcase">

                <div class="bd-activity-stage">

                    @foreach($informasiTerbaru as $index => $item)

                        @php
                            $judul =
                                $item->title
                                ?? $item->judul
                                ?? 'Informasi Baca Dulu';

                            $url =
                                !empty($item->slug)
                                    ? url('/information/' . $item->slug)
                                    : route('informasi');

                            $gambar =
                                !empty($item->image)
                                    ? asset('storage/' . $item->image)
                                    : null;

                            $kategori =
                                $item->category
                                ?? $item->type
                                ?? 'Informasi';

                            $tanggal =
                                $item->created_at
                                    ? $item->created_at->translatedFormat('d M Y')
                                    : null;

                            $nomor =
                                str_pad(
                                    $index + 1,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                );
                        @endphp


                        <button
                            type="button"
                            class="bd-activity-card {{ $index === 0 ? 'is-active' : '' }}"
                            data-activity-card
                            data-index="{{ $index }}"
                            aria-label="Tampilkan {{ $judul }}"
                        >

                            <div class="bd-activity-card-media">

                                @if($gambar)

                                    <img
                                        src="{{ $gambar }}"
                                        alt="{{ $judul }}"
                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    >

                                @else

                                    <div class="bd-activity-card-placeholder">

                                        <img
                                            src="{{ asset('img/bacadulu-logo.jpg') }}"
                                            alt=""
                                        >

                                        <span>
                                            Baca Dulu
                                        </span>

                                    </div>

                                @endif


                                <span class="bd-activity-card-number">
                                    {{ $nomor }}
                                </span>

                            </div>


                            <div class="bd-activity-card-body">

                                <div class="bd-activity-card-meta">

                                    <span>
                                        {{ $kategori }}
                                    </span>


                                    @if($tanggal)

                                        <i></i>

                                        <time>
                                            {{ $tanggal }}
                                        </time>

                                    @endif

                                </div>


                                <h3>
                                    {{ $judul }}
                                </h3>


                                <div class="bd-activity-card-bottom">

                                    <span>
                                        Lihat Informasi
                                    </span>

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

                                </div>

                            </div>

                        </button>

                    @endforeach

                </div>


                {{-- =================================================
                     CONTROLS
                ================================================== --}}
                <div class="bd-activity-controls">

                    <button
                        type="button"
                        id="bdActivityPrev"
                        class="bd-activity-nav"
                        aria-label="Informasi sebelumnya"
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


                    <div class="bd-activity-counter">

                        <strong id="bdActivityCurrent">
                            01
                        </strong>

                        <span>/</span>

                        <span>
                            {{ str_pad(
                                $informasiTerbaru->count(),
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </span>

                    </div>


                    <button
                        type="button"
                        id="bdActivityNext"
                        class="bd-activity-nav bd-activity-nav-next"
                        aria-label="Informasi berikutnya"
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



            {{-- =====================================================
                 ACTIVE INFORMATION DETAILS
            ====================================================== --}}
            <div class="bd-activity-details">

                @foreach($informasiTerbaru as $index => $item)

                    @php
                        $judul =
                            $item->title
                            ?? $item->judul
                            ?? 'Informasi Baca Dulu';

                        $url =
                            !empty($item->slug)
                                ? url('/information/' . $item->slug)
                                : route('informasi');

                        $deskripsi =
                            $item->excerpt
                            ?? \Illuminate\Support\Str::limit(
                                html_entity_decode(
                                    strip_tags(
                                        $item->content
                                        ?? $item->deskripsi
                                        ?? ''
                                    )
                                ),
                                210
                            );

                        $kategori =
                            $item->category
                            ?? $item->type
                            ?? 'Informasi';

                        $tanggal =
                            $item->created_at
                                ? $item->created_at->translatedFormat('d M Y')
                                : null;

                        $nomor =
                            str_pad(
                                $index + 1,
                                2,
                                '0',
                                STR_PAD_LEFT
                            );
                    @endphp


                    <article
                        class="bd-activity-detail {{ $index === 0 ? 'is-active' : '' }}"
                        data-activity-detail="{{ $index }}"
                        style="{{ $index === 0 ? '' : 'display:none;' }}"
                    >

                        <div class="bd-activity-detail-number">
                            {{ $nomor }}
                        </div>


                        <div class="bd-activity-detail-main">

                            <div class="bd-activity-detail-meta">

                                <span>
                                    {{ $kategori }}
                                </span>


                                @if($tanggal)

                                    <i></i>

                                    <time>
                                        {{ $tanggal }}
                                    </time>

                                @endif

                            </div>


                            <h3>
                                {{ $judul }}
                            </h3>

                        </div>


                        <div class="bd-activity-detail-side">

                            @if(!empty($deskripsi))

                                <p>
                                    {{ $deskripsi }}
                                </p>

                            @endif


                            <a href="{{ $url }}">

                                Baca Selengkapnya

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

                    </article>

                @endforeach

            </div>


            {{-- =====================================================
                 FOOTER
            ====================================================== --}}
            <footer class="bd-activity-footer">

                <span>
                    Gunakan tombol panah untuk melihat update lainnya.
                </span>


                <a href="{{ route('informasi') }}">

                    Lihat Semua Informasi

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

            </footer>

        @endif

    </div>

</section>



{{-- ================================================================
     CTA PENERBITAN
     TETAP ADA
================================================================ --}}

<section class="bd-publish-section">

    <div class="bd-publish-container">

        <div class="bd-publish-card">

            {{-- =====================================================
                 LEFT
            ====================================================== --}}
            <div class="bd-publish-copy">

                <div class="bd-publish-kicker">

                    <span class="bd-publish-kicker-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19.5A2.5 2.5 0 016.5 17H20"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                            />
                        </svg>

                    </span>

                    <span>
                        Penerbitan Buku
                    </span>

                </div>


                <h2>
                    Siap mengubah naskah Anda
                    <span>menjadi sebuah buku?</span>
                </h2>


                <p>
                    Konsultasikan kebutuhan editing, layout, desain sampul,
                    ISBN, HAKI, pencetakan hingga distribusi bersama
                    tim Baca Dulu.
                </p>

            </div>


            {{-- =====================================================
                 SERVICES
            ====================================================== --}}
            <div class="bd-publish-services">

                <div class="bd-publish-service">
                    <span>01</span>

                    <div>
                        <strong>Editing</strong>
                        <small>Penyuntingan naskah</small>
                    </div>
                </div>


                <div class="bd-publish-service">
                    <span>02</span>

                    <div>
                        <strong>Layout & Cover</strong>
                        <small>Tata letak dan sampul</small>
                    </div>
                </div>


                <div class="bd-publish-service">
                    <span>03</span>

                    <div>
                        <strong>ISBN & HAKI</strong>
                        <small>Administrasi penerbitan</small>
                    </div>
                </div>


                <div class="bd-publish-service">
                    <span>04</span>

                    <div>
                        <strong>Cetak & E-book</strong>
                        <small>Format cetak dan digital</small>
                    </div>
                </div>

            </div>


            {{-- =====================================================
                 ACTION
            ====================================================== --}}
            <div class="bd-publish-action">

                <span class="bd-publish-action-label">
                    Mulai Penerbitan
                </span>


                <h3>
                    Konsultasikan naskah Anda bersama tim kami.
                </h3>


                <a
                    href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku."
                    target="_blank"
                    rel="noopener noreferrer"
                >

                    Konsultasi Sekarang

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


                <small>
                    Hubungi Baca Dulu melalui WhatsApp
                </small>

            </div>

        </div>

    </div>

</section>



<style>
/* ================================================================
   INFORMATION ROOT
================================================================ */

.bd-activity-section{
    --navy:#21194E;
    --orange:#EF5843;
    --orange-dark:#C84836;
    --text:#25252D;
    --muted:#777982;
    --line:rgba(33,25,78,.10);

    position:relative;
    width:100%;
    overflow:hidden;
    padding:92px 0 82px;
    background:#F4F1EB;
    color:var(--text);
}

.bd-activity-section *,
.bd-publish-section *{
    box-sizing:border-box;
}

.bd-activity-section a,
.bd-publish-section a{
    text-decoration:none;
}


/* ================================================================
   BACKGROUND
================================================================ */

.bd-activity-accent{
    position:absolute;
    pointer-events:none;
}

.bd-activity-accent-left{
    top:0;
    left:0;
    width:420px;
    height:100%;
    background:
        linear-gradient(
            90deg,
            rgba(239,88,67,.065),
            transparent 72%
        );
}

.bd-activity-accent-right{
    right:-180px;
    bottom:-200px;
    width:430px;
    height:430px;
    border-radius:50%;
    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.065),
            transparent 70%
        );
}


/* ================================================================
   CONTAINER
================================================================ */

.bd-activity-container{
    position:relative;
    z-index:2;
    width:min(calc(100% - 48px),1280px);
    margin:0 auto;
}


/* ================================================================
   HEADER
================================================================ */

.bd-activity-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:55px;
}

.bd-activity-heading{
    max-width:760px;
}

.bd-activity-eyebrow{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:13px;
    color:var(--orange);
    font-size:9px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-activity-eyebrow-icon{
    width:30px;
    height:30px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:rgba(239,88,67,.09);
}

.bd-activity-eyebrow-icon svg{
    width:14px;
    height:14px;
}

.bd-activity-heading h2{
    margin:0;
    color:var(--navy);
    font-size:clamp(38px,4.5vw,57px);
    line-height:1.02;
    font-weight:820;
    letter-spacing:-.052em;
}

.bd-activity-heading h2 span{
    color:var(--orange);
}

.bd-activity-heading p{
    max-width:620px;
    margin:15px 0 0;
    color:var(--muted);
    font-size:11px;
    line-height:1.75;
}


/* ================================================================
   HEADER ACTION
================================================================ */

.bd-activity-header-action{
    display:flex;
    align-items:center;
    gap:25px;
    flex-shrink:0;
}

.bd-activity-total{
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    padding-right:23px;
    border-right:1px solid var(--line);
}

.bd-activity-total strong{
    color:var(--orange);
    font-size:20px;
    line-height:1;
    font-weight:900;
}

.bd-activity-total span{
    margin-top:4px;
    color:#99979E;
    font-size:7px;
    font-weight:750;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.bd-activity-all{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--navy)!important;
    font-size:9px;
    font-weight:850;
}

.bd-activity-all > span{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#fff;
    border:1px solid rgba(33,25,78,.13);
    color:var(--orange);
    transition:.2s ease;
}

.bd-activity-all:hover > span{
    background:var(--orange);
    border-color:var(--orange);
    color:#fff;
}

.bd-activity-all svg{
    width:12px;
    height:12px;
}


/* ================================================================
   HEADER LINE
================================================================ */

.bd-activity-header-line{
    position:relative;
    width:100%;
    height:1px;
    margin:30px 0 26px;
    overflow:hidden;
    background:var(--line);
}

.bd-activity-header-line span{
    position:absolute;
    top:0;
    left:0;
    width:84px;
    height:1px;
    background:var(--orange);
    transform-origin:left;
}


/* ================================================================
   SHOWCASE
================================================================ */

.bd-activity-showcase{
    position:relative;
}

.bd-activity-stage{
    position:relative;
    width:100%;
    height:455px;
    overflow:hidden;
}


/* ================================================================
   CARD
================================================================ */

.bd-activity-card{
    position:absolute;
    top:24px;
    left:50%;

    width:320px;
    height:395px;

    display:flex;
    flex-direction:column;

    padding:0;
    overflow:hidden;

    border:1px solid rgba(33,25,78,.10);
    border-radius:24px;

    background:#fff;
    color:inherit;
    text-align:left;

    box-shadow:
        0 15px 36px rgba(33,25,78,.08);

    cursor:pointer;

    transform-origin:center center;
    will-change:transform,opacity,filter;
}

.bd-activity-card.is-active{
    border-color:rgba(239,88,67,.18);
    box-shadow:
        0 24px 55px rgba(33,25,78,.14);
}


/* ================================================================
   CARD IMAGE
================================================================ */

.bd-activity-card-media{
    position:relative;
    width:100%;
    height:245px;
    flex-shrink:0;
    overflow:hidden;
    background:#EEECE7;
}

.bd-activity-card-media img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.bd-activity-card-placeholder{
    width:100%;
    height:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    background:#F0EEE9;
}

.bd-activity-card-placeholder img{
    width:58px;
    height:58px;
    object-fit:contain;
    border-radius:10px;
}

.bd-activity-card-placeholder span{
    color:#99979F;
    font-size:8px;
    font-weight:800;
    letter-spacing:.12em;
    text-transform:uppercase;
}

.bd-activity-card-number{
    position:absolute;
    top:14px;
    left:14px;

    min-width:41px;
    height:30px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 9px;

    border-radius:8px;
    background:#fff;

    color:var(--orange);

    font-size:8px;
    font-weight:900;
}


/* ================================================================
   CARD CONTENT
================================================================ */

.bd-activity-card-body{
    flex:1;
    display:flex;
    flex-direction:column;
    padding:18px 18px 17px;
}

.bd-activity-card-meta{
    display:flex;
    align-items:center;
    gap:6px;

    color:#99979F;

    font-size:6.5px;
    font-weight:750;

    text-transform:uppercase;
    letter-spacing:.07em;
}

.bd-activity-card-meta > span{
    color:var(--orange);
}

.bd-activity-card-meta i{
    display:block;
    width:3px;
    height:3px;
    border-radius:50%;
    background:#CECBD0;
}

.bd-activity-card-body h3{
    margin:9px 0 0;

    overflow:hidden;

    color:var(--navy);

    font-size:15px;
    line-height:1.4;
    font-weight:800;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}

.bd-activity-card-bottom{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;

    margin-top:auto;
    padding-top:14px;

    border-top:1px solid rgba(33,25,78,.08);

    color:#8A8891;

    font-size:7.5px;
    font-weight:800;
}

.bd-activity-card-bottom svg{
    width:12px;
    height:12px;
    color:var(--orange);
}


/* ================================================================
   NAVIGATION
================================================================ */

.bd-activity-controls{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:18px;
    margin-top:3px;
}

.bd-activity-nav{
    width:41px;
    height:41px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;

    border:1px solid rgba(33,25,78,.13);
    border-radius:12px;

    background:#fff;
    color:var(--navy);

    cursor:pointer;
}

.bd-activity-nav-next{
    background:var(--navy);
    border-color:var(--navy);
    color:#fff;
}

.bd-activity-nav svg{
    width:14px;
    height:14px;
}

.bd-activity-counter{
    min-width:65px;
    display:flex;
    align-items:baseline;
    justify-content:center;
    gap:5px;
    color:#A4A1A8;
    font-size:8px;
    font-weight:800;
}

.bd-activity-counter strong{
    color:var(--orange);
    font-size:17px;
}


/* ================================================================
   DETAIL
================================================================ */

.bd-activity-details{
    margin-top:42px;
    border-top:1px solid var(--line);
    border-bottom:1px solid var(--line);
}

.bd-activity-detail{
    display:grid;
    grid-template-columns:55px minmax(0,1fr) minmax(300px,.8fr);
    gap:30px;
    align-items:start;

    padding:29px 0;
}

.bd-activity-detail-number{
    color:var(--orange);
    font-size:13px;
    font-weight:900;
}

.bd-activity-detail-meta{
    display:flex;
    align-items:center;
    gap:7px;

    margin-bottom:8px;

    color:#99979F;

    font-size:7px;
    font-weight:750;
    letter-spacing:.07em;
    text-transform:uppercase;
}

.bd-activity-detail-meta > span{
    color:var(--orange);
}

.bd-activity-detail-meta i{
    width:3px;
    height:3px;
    display:block;
    border-radius:50%;
    background:#CCC9CF;
}

.bd-activity-detail-main h3{
    max-width:620px;
    margin:0;

    color:var(--navy);

    font-size:clamp(21px,2.3vw,31px);
    line-height:1.2;
    font-weight:800;
    letter-spacing:-.035em;
}

.bd-activity-detail-side p{
    margin:0;
    color:#757883;
    font-size:9.5px;
    line-height:1.75;
}

.bd-activity-detail-side a{
    display:inline-flex;
    align-items:center;
    gap:8px;

    margin-top:14px;

    color:var(--navy)!important;

    font-size:8px;
    font-weight:850;
}

.bd-activity-detail-side a svg{
    width:11px;
    height:11px;
    color:var(--orange);
}


/* ================================================================
   INFORMATION FOOTER
================================================================ */

.bd-activity-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:25px;
    padding-top:20px;
}

.bd-activity-footer > span{
    color:#A09EA5;
    font-size:7px;
    letter-spacing:.05em;
}

.bd-activity-footer a{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:var(--orange)!important;
    font-size:8px;
    font-weight:850;
}

.bd-activity-footer svg{
    width:11px;
    height:11px;
}


/* ================================================================
   EMPTY
================================================================ */

.bd-activity-empty{
    padding:65px 20px;
    text-align:center;
}

.bd-activity-empty > span{
    color:var(--orange);
    font-size:8px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-activity-empty h3{
    margin:9px 0 0;
    color:var(--navy);
    font-size:20px;
}

.bd-activity-empty p{
    margin:7px 0 0;
    color:var(--muted);
    font-size:10px;
}


/* ================================================================
   CTA
================================================================ */

.bd-publish-section{
    --navy:#21194E;
    --orange:#EF5843;
    --yellow:#F7AA35;

    padding:0 0 80px;
    background:#F4F1EB;
}

.bd-publish-container{
    width:min(calc(100% - 48px),1280px);
    margin:0 auto;
}

.bd-publish-card{
    position:relative;

    display:grid;
    grid-template-columns:minmax(0,1fr) 265px 285px;
    gap:42px;
    align-items:center;

    padding:48px 50px;

    overflow:hidden;

    border-radius:26px;

    background:var(--navy);

    box-shadow:
        0 22px 52px rgba(33,25,78,.14);
}

.bd-publish-card::before{
    content:"";
    position:absolute;
    top:47px;
    bottom:47px;
    left:0;
    width:4px;
    border-radius:0 999px 999px 0;
    background:var(--orange);
}


/* CTA COPY */

.bd-publish-copy{
    position:relative;
    z-index:2;
}

.bd-publish-kicker{
    display:flex;
    align-items:center;
    gap:9px;
    color:var(--yellow);
    font-size:8px;
    font-weight:850;
    letter-spacing:.14em;
    text-transform:uppercase;
}

.bd-publish-kicker-icon{
    width:29px;
    height:29px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:rgba(247,170,53,.10);
}

.bd-publish-kicker-icon svg{
    width:14px;
    height:14px;
}

.bd-publish-copy h2{
    max-width:600px;
    margin:15px 0 0;

    color:#fff;

    font-size:clamp(29px,3.3vw,43px);
    line-height:1.1;
    font-weight:800;
    letter-spacing:-.045em;
}

.bd-publish-copy h2 span{
    display:block;
    color:rgba(255,255,255,.58);
}

.bd-publish-copy p{
    max-width:580px;
    margin:17px 0 0;

    color:rgba(255,255,255,.55);

    font-size:10px;
    line-height:1.75;
}


/* CTA SERVICES */

.bd-publish-services{
    position:relative;
    z-index:2;
    border-top:1px solid rgba(255,255,255,.11);
}

.bd-publish-service{
    display:grid;
    grid-template-columns:27px minmax(0,1fr);
    gap:10px;
    align-items:center;

    min-height:65px;

    border-bottom:1px solid rgba(255,255,255,.11);
}

.bd-publish-service > span{
    color:var(--orange);
    font-size:7px;
    font-weight:900;
}

.bd-publish-service strong{
    display:block;
    color:#fff;
    font-size:9px;
    font-weight:800;
}

.bd-publish-service small{
    display:block;
    margin-top:3px;
    color:rgba(255,255,255,.36);
    font-size:7px;
}


/* CTA ACTION */

.bd-publish-action{
    position:relative;
    z-index:2;

    padding:25px;

    border:1px solid rgba(255,255,255,.11);
    border-radius:19px;

    background:rgba(255,255,255,.05);
}

.bd-publish-action-label{
    display:block;
    color:var(--yellow);
    font-size:7px;
    font-weight:850;
    letter-spacing:.12em;
    text-transform:uppercase;
}

.bd-publish-action h3{
    margin:11px 0 0;
    color:#fff;
    font-size:17px;
    line-height:1.38;
    font-weight:800;
}

.bd-publish-action > a{
    width:100%;
    min-height:45px;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;

    margin-top:21px;
    padding:0 14px;

    border-radius:10px;

    background:var(--orange);
    color:#fff!important;

    font-size:9px;
    font-weight:850;
}

.bd-publish-action > a:hover{
    background:var(--yellow);
    color:var(--navy)!important;
}

.bd-publish-action > a svg{
    width:13px;
    height:13px;
}

.bd-publish-action small{
    display:block;
    margin-top:9px;
    color:rgba(255,255,255,.28);
    font-size:7px;
}


/* ================================================================
   TABLET
================================================================ */

@media(max-width:1050px){

    .bd-activity-card{
        width:295px;
        height:380px;
    }

    .bd-activity-card-media{
        height:230px;
    }

    .bd-publish-card{
        grid-template-columns:minmax(0,1fr) 275px;
    }

    .bd-publish-services{
        grid-column:1;
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .bd-publish-service:nth-child(odd){
        padding-right:15px;
        border-right:1px solid rgba(255,255,255,.11);
    }

    .bd-publish-service:nth-child(even){
        padding-left:15px;
    }

    .bd-publish-action{
        grid-column:2;
        grid-row:1 / 3;
    }

}


/* ================================================================
   MOBILE TABLET
================================================================ */

@media(max-width:800px){

    .bd-activity-header{
        align-items:flex-start;
        flex-direction:column;
        gap:22px;
    }

    .bd-activity-header-action{
        width:100%;
        justify-content:space-between;
    }

    .bd-activity-stage{
        height:425px;
    }

    .bd-activity-card{
        width:280px;
        height:365px;
    }

    .bd-activity-card-media{
        height:215px;
    }

    .bd-activity-detail{
        grid-template-columns:42px minmax(0,1fr);
    }

    .bd-activity-detail-side{
        grid-column:2;
    }

    .bd-publish-card{
        grid-template-columns:1fr;
        gap:30px;
        padding:39px 35px;
    }

    .bd-publish-services{
        grid-column:auto;
    }

    .bd-publish-action{
        grid-column:auto;
        grid-row:auto;
        max-width:450px;
    }

}


/* ================================================================
   MOBILE
================================================================ */

@media(max-width:600px){

    .bd-activity-section{
        padding:62px 0 55px;
    }

    .bd-activity-container,
    .bd-publish-container{
        width:min(calc(100% - 30px),1280px);
    }

    .bd-activity-heading h2{
        font-size:37px;
    }

    .bd-activity-header-action{
        align-items:flex-start;
        flex-direction:column;
    }

    .bd-activity-total{
        align-items:flex-start;
        padding-right:0;
        border-right:0;
    }

    .bd-activity-stage{
        height:405px;
    }

    .bd-activity-card{
        width:min(76vw,275px);
        height:350px;
        border-radius:20px;
    }

    .bd-activity-card-media{
        height:205px;
    }

    .bd-activity-details{
        margin-top:30px;
    }

    .bd-activity-detail{
        grid-template-columns:32px minmax(0,1fr);
        gap:12px;
    }

    .bd-activity-detail-main h3{
        font-size:23px;
    }

    .bd-activity-detail-side{
        grid-column:2;
    }

    .bd-activity-footer{
        align-items:flex-start;
        flex-direction:column;
        gap:10px;
    }

    .bd-publish-section{
        padding-bottom:60px;
    }

    .bd-publish-card{
        padding:33px 23px;
        border-radius:22px;
    }

    .bd-publish-copy h2{
        font-size:30px;
    }

    .bd-publish-services{
        grid-template-columns:1fr;
    }

    .bd-publish-service:nth-child(odd),
    .bd-publish-service:nth-child(even){
        padding-left:0;
        padding-right:0;
        border-right:0;
    }

    .bd-publish-action{
        max-width:none;
    }

}


/* ================================================================
   REDUCED MOTION
================================================================ */

@media(prefers-reduced-motion:reduce){

    .bd-activity-section *,
    .bd-publish-section *{
        scroll-behavior:auto!important;
    }

}
</style>



{{-- ================================================================
     GSAP
================================================================ --}}

@once
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
@endonce


<script>
document.addEventListener('DOMContentLoaded', function () {

    const section =
        document.getElementById('baca-informasi');

    const publishSection =
        document.querySelector('.bd-publish-section');

    if (!section) return;

    const cards =
        Array.from(
            section.querySelectorAll('[data-activity-card]')
        );

    const details =
        Array.from(
            section.querySelectorAll('[data-activity-detail]')
        );

    const prevButton =
        document.getElementById('bdActivityPrev');

    const nextButton =
        document.getElementById('bdActivityNext');

    const currentCounter =
        document.getElementById('bdActivityCurrent');

    const reduceMotion =
        window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

    const finePointer =
        window.matchMedia(
            '(hover:hover) and (pointer:fine)'
        ).matches;

    const hasGSAP =
        typeof window.gsap !== 'undefined';

    const hasScrollTrigger =
        typeof window.ScrollTrigger !== 'undefined';

    let activeIndex = 0;
    let changing = false;


    /* ============================================================
       REGISTER
    ============================================================ */

    if (hasGSAP && hasScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger);
    }


    /* ============================================================
       CARD POSITION HELPER
    ============================================================ */

    function getCardOffset() {

        const width = window.innerWidth;

        if (width <= 600) {
            return Math.min(width * .60, 245);
        }

        if (width <= 850) {
            return 235;
        }

        if (width <= 1100) {
            return 260;
        }

        return 295;
    }


    /* ============================================================
       RENDER CARDS
    ============================================================ */

    function renderCards(animate = true) {

        if (!cards.length) return;

        const offset = getCardOffset();
        const total = cards.length;

        cards.forEach(function (card, index) {

            let relative = index - activeIndex;

            if (relative > total / 2) {
                relative -= total;
            }

            if (relative < -(total / 2)) {
                relative += total;
            }

            let x = 0;
            let scale = 1;
            let opacity = 1;
            let grayscale = 0;
            let zIndex = 5;
            let pointerEvents = 'auto';

            if (relative === 0) {

                x = 0;
                scale = 1;
                opacity = 1;
                grayscale = 0;
                zIndex = 6;

            } else if (relative === 1) {

                x = offset;
                scale = .86;
                opacity = .88;
                grayscale = .72;
                zIndex = 5;

            } else if (relative === -1) {

                x = -offset;
                scale = .86;
                opacity = .88;
                grayscale = .72;
                zIndex = 5;

            } else if (relative === 2) {

                x = offset * 1.68;
                scale = .70;
                opacity = .35;
                grayscale = 1;
                zIndex = 3;

            } else if (relative === -2) {

                x = -(offset * 1.68);
                scale = .70;
                opacity = .35;
                grayscale = 1;
                zIndex = 3;

            } else {

                x = relative > 0
                    ? offset * 2
                    : -(offset * 2);

                scale = .62;
                opacity = 0;
                grayscale = 1;
                zIndex = 1;
                pointerEvents = 'none';

            }


            card.classList.toggle(
                'is-active',
                index === activeIndex
            );


            if (hasGSAP && !reduceMotion && animate) {

                gsap.to(card, {
                    x:x,
                    xPercent:-50,
                    scale:scale,
                    opacity:opacity,
                    filter:'grayscale(' + grayscale + ')',
                    zIndex:zIndex,
                    duration:.58,
                    ease:'power3.inOut',
                    pointerEvents:pointerEvents
                });

            } else {

                card.style.transform =
                    'translateX(-50%) translateX(' + x + 'px) scale(' + scale + ')';

                card.style.opacity =
                    opacity;

                card.style.filter =
                    'grayscale(' + grayscale + ')';

                card.style.zIndex =
                    zIndex;

                card.style.pointerEvents =
                    pointerEvents;

            }

        });

    }


    /* ============================================================
       UPDATE DETAILS
    ============================================================ */

    function updateDetails(previousIndex) {

        if (!details.length) return;

        const oldDetail =
            details[previousIndex];

        const newDetail =
            details[activeIndex];

        if (!newDetail) return;


        if (
            !hasGSAP ||
            reduceMotion ||
            !oldDetail ||
            oldDetail === newDetail
        ) {

            details.forEach(function (detail, index) {

                detail.style.display =
                    index === activeIndex
                        ? 'grid'
                        : 'none';

                detail.classList.toggle(
                    'is-active',
                    index === activeIndex
                );

            });

            return;
        }


        gsap.to(oldDetail, {
            autoAlpha:0,
            y:-8,
            duration:.19,
            ease:'power2.in',
            onComplete:function () {

                oldDetail.style.display =
                    'none';

                oldDetail.classList.remove(
                    'is-active'
                );


                newDetail.style.display =
                    'grid';

                newDetail.classList.add(
                    'is-active'
                );


                gsap.fromTo(
                    newDetail,
                    {
                        autoAlpha:0,
                        y:10
                    },
                    {
                        autoAlpha:1,
                        y:0,
                        duration:.36,
                        ease:'power3.out'
                    }
                );

            }
        });

    }


    /* ============================================================
       CHANGE ACTIVE
    ============================================================ */

    function setActive(nextIndex) {

        if (
            changing ||
            !cards[nextIndex] ||
            nextIndex === activeIndex
        ) {
            return;
        }

        changing = true;

        const previousIndex =
            activeIndex;

        activeIndex =
            nextIndex;

        if (currentCounter) {

            currentCounter.textContent =
                String(activeIndex + 1)
                    .padStart(2, '0');

        }

        renderCards(true);
        updateDetails(previousIndex);

        window.setTimeout(function () {
            changing = false;
        }, 580);

    }


    /* ============================================================
       CARD CLICK
    ============================================================ */

    cards.forEach(function (card, index) {

        card.addEventListener('click', function () {

            if (index === activeIndex) {

                const activeDetail =
                    details[activeIndex];

                const link =
                    activeDetail?.querySelector('a');

                if (link) {
                    link.click();
                }

                return;
            }

            setActive(index);

        });

    });


    /* ============================================================
       PREVIOUS
    ============================================================ */

    prevButton?.addEventListener('click', function () {

        let next =
            activeIndex - 1;

        if (next < 0) {
            next = cards.length - 1;
        }

        setActive(next);

    });


    /* ============================================================
       NEXT
    ============================================================ */

    nextButton?.addEventListener('click', function () {

        let next =
            activeIndex + 1;

        if (next >= cards.length) {
            next = 0;
        }

        setActive(next);

    });


    /* ============================================================
       RESIZE
    ============================================================ */

    let resizeTimer;

    window.addEventListener('resize', function () {

        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(function () {
            renderCards(false);
        }, 120);

    });


    /* ============================================================
       INTRO GSAP
    ============================================================ */

    if (
        hasGSAP &&
        hasScrollTrigger &&
        !reduceMotion
    ) {

        const intro =
            gsap.timeline({
                scrollTrigger:{
                    trigger:section,
                    start:'top 83%',
                    once:true
                },
                defaults:{
                    ease:'power3.out'
                }
            });

        intro
            .from('.bd-activity-eyebrow',{
                autoAlpha:0,
                y:8,
                duration:.35
            })

            .from('.bd-activity-heading h2',{
                autoAlpha:0,
                y:18,
                duration:.55
            },'-=.17')

            .from('.bd-activity-heading p',{
                autoAlpha:0,
                y:10,
                duration:.40
            },'-=.29')

            .from('.bd-activity-header-action',{
                autoAlpha:0,
                x:10,
                duration:.40
            },'-=.30')

            .from('.bd-activity-header-line span',{
                scaleX:0,
                duration:.58,
                ease:'power3.inOut'
            },'-=.18')

            .from('.bd-activity-stage',{
                autoAlpha:0,
                y:20,
                duration:.58
            },'-=.12')

            .from('.bd-activity-controls',{
                autoAlpha:0,
                y:8,
                duration:.35
            },'-=.28')

            .from('.bd-activity-details',{
                autoAlpha:0,
                y:13,
                duration:.45
            },'-=.20');

    }


    /* ============================================================
       ACTIVE CARD HOVER
    ============================================================ */

    if (
        hasGSAP &&
        !reduceMotion &&
        finePointer
    ) {

        cards.forEach(function (card) {

            const image =
                card.querySelector(
                    '.bd-activity-card-media img'
                );

            card.addEventListener(
                'mouseenter',
                function () {

                    if (
                        !card.classList.contains(
                            'is-active'
                        )
                    ) {
                        return;
                    }

                    if (image) {

                        gsap.to(image,{
                            scale:1.025,
                            duration:.4,
                            ease:'power2.out'
                        });

                    }

                }
            );


            card.addEventListener(
                'mouseleave',
                function () {

                    if (image) {

                        gsap.to(image,{
                            scale:1,
                            duration:.5,
                            ease:'power3.out'
                        });

                    }

                }
            );

        });

    }


    /* ============================================================
       NAV BUTTON PRESS
    ============================================================ */

    if (
        hasGSAP &&
        !reduceMotion
    ) {

        [prevButton, nextButton]
            .filter(Boolean)
            .forEach(function (button) {

                button.addEventListener(
                    'pointerdown',
                    function () {

                        gsap.to(button,{
                            scale:.91,
                            duration:.07
                        });

                    }
                );

                button.addEventListener(
                    'pointerup',
                    function () {

                        gsap.to(button,{
                            scale:1,
                            duration:.18,
                            ease:'power2.out'
                        });

                    }
                );

            });

    }


    /* ============================================================
       CTA INTRO
    ============================================================ */

    if (
        publishSection &&
        hasGSAP &&
        hasScrollTrigger &&
        !reduceMotion
    ) {

        const cta =
            gsap.timeline({
                scrollTrigger:{
                    trigger:publishSection,
                    start:'top 88%',
                    once:true
                },
                defaults:{
                    ease:'power3.out'
                }
            });

        cta
            .from('.bd-publish-card',{
                autoAlpha:0,
                y:20,
                duration:.60
            })

            .from('.bd-publish-copy > *',{
                autoAlpha:0,
                y:9,
                duration:.36,
                stagger:.045
            },'-=.30')

            .from('.bd-publish-service',{
                autoAlpha:0,
                x:8,
                duration:.30,
                stagger:.05
            },'-=.24')

            .from('.bd-publish-action',{
                autoAlpha:0,
                x:13,
                duration:.43
            },'-=.28');

    }


    /* ============================================================
       CTA HOVER
    ============================================================ */

    if (
        publishSection &&
        hasGSAP &&
        !reduceMotion &&
        finePointer
    ) {

        const button =
            publishSection.querySelector(
                '.bd-publish-action > a'
            );

        const arrow =
            button?.querySelector('svg');

        if (button && arrow) {

            button.addEventListener(
                'mouseenter',
                function () {

                    gsap.to(arrow,{
                        x:4,
                        duration:.18,
                        ease:'power2.out'
                    });

                }
            );

            button.addEventListener(
                'mouseleave',
                function () {

                    gsap.to(arrow,{
                        x:0,
                        duration:.28,
                        ease:'power3.out'
                    });

                }
            );

        }

    }


    /* ============================================================
       INITIAL STATE
    ============================================================ */

    renderCards(false);


    /* ============================================================
       REFRESH
    ============================================================ */

    if (
        hasScrollTrigger &&
        !reduceMotion
    ) {

        setTimeout(function () {
            ScrollTrigger.refresh();
        },180);

    }

});
</script>