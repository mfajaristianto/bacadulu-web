@php
    $informasiTerbaru = \App\Models\Information::query()
        ->latest()
        ->take(6)
        ->get();
@endphp


{{-- ================================================================
     INFORMASI
================================================================ --}}
<section id="baca-informasi" class="bd-activity-section">

    <div class="bd-activity-accent bd-activity-accent-left" aria-hidden="true"></div>
    <div class="bd-activity-accent bd-activity-accent-right" aria-hidden="true"></div>


    <div class="bd-activity-container">

        {{-- HEADER --}}
        <header class="bd-activity-header">

            <div class="bd-activity-heading">

                <div class="bd-activity-eyebrow">

                    <span class="bd-activity-eyebrow-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 2v3M16 2v3M4 9h16M5 4h14a1 1 0 011 1v15H4V5a1 1 0 011-1z"
                            />
                        </svg>

                    </span>

                    <span>
                        Informasi & Agenda
                    </span>

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
                            {{ str_pad($informasiTerbaru->count(), 2, '0', STR_PAD_LEFT) }}
                        </strong>

                        <span>
                            Update Terbaru
                        </span>

                    </div>

                @endif


                <a
                    href="{{ route('informasi') }}"
                    class="bd-activity-all"
                >

                    Semua Informasi

                    <span>

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
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


        <div class="bd-activity-header-line">
            <span></span>
        </div>


        @if($informasiTerbaru->isEmpty())

            <div class="bd-activity-empty">

                <span>
                    Update Baca Dulu
                </span>

                <h3>
                    Belum ada informasi terbaru.
                </h3>

                <p>
                    Kegiatan dan informasi terbaru akan tampil di bagian ini.
                </p>

            </div>

        @else

            {{-- =====================================================
                 SHOWCASE
            ====================================================== --}}
            <div class="bd-activity-showcase">

                <div
                    class="bd-activity-stage"
                    id="bdActivityStage"
                >

                    @foreach($informasiTerbaru as $index => $item)

                        @php
                            $judul =
                                $item->title
                                ?? $item->judul
                                ?? 'Informasi Baca Dulu';

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
                            class="
                                bd-activity-card
                                {{ $index === 0 ? 'is-active' : '' }}
                            "
                            data-activity-card
                            data-index="{{ $index }}"
                        >

                            <div class="bd-activity-card-media">

                                @if($gambar)

                                    <img
                                        src="{{ $gambar }}"
                                        alt="{{ $judul }}"
                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                    >

                                    <div class="bd-activity-card-placeholder bd-info-error-fallback">

                                        <img
                                            src="{{ asset('img/bacadulu-logo.jpg') }}"
                                            alt=""
                                        >

                                        <span>
                                            Baca Dulu
                                        </span>

                                    </div>

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

                                    <svg viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
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

                    <div class="bd-activity-counter">

                        <strong id="bdActivityCurrent">
                            01
                        </strong>

                        <span>/</span>

                        <span>
                            {{ str_pad($informasiTerbaru->count(), 2, '0', STR_PAD_LEFT) }}
                        </span>

                    </div>


                    <div class="bd-activity-nav-group">

                        <button
                            type="button"
                            id="bdActivityPrev"
                            class="bd-activity-nav"
                            aria-label="Informasi sebelumnya"
                        >
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 18l-6-6 6-6"
                                />
                            </svg>
                        </button>


                        <button
                            type="button"
                            id="bdActivityNext"
                            class="bd-activity-nav bd-activity-nav-next"
                            aria-label="Informasi berikutnya"
                        >
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 18l6-6-6-6"
                                />
                            </svg>
                        </button>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 DETAIL ACTIVE
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
                                180
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
                        class="
                            bd-activity-detail
                            {{ $index === 0 ? 'is-active' : '' }}
                        "
                        data-activity-detail="{{ $index }}"
                        style="{{ $index === 0 ? '' : 'display:none;' }}"
                    >

                        <div class="bd-activity-detail-index">

                            <span>
                                {{ $nomor }}
                            </span>

                            <small>
                                Update
                            </small>

                        </div>


                        <div class="bd-activity-detail-main">

                            <div class="bd-activity-detail-top">

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


                                <span class="bd-activity-detail-active">

                                    <i></i>

                                    Sedang Ditampilkan

                                </span>

                            </div>


                            <h3>
                                {{ $judul }}
                            </h3>


                            @if(!empty($deskripsi))

                                <p class="bd-activity-detail-description">
                                    {{ $deskripsi }}
                                </p>

                            @endif

                        </div>


                        <div class="bd-activity-detail-action">

                            <span class="bd-activity-detail-action-label">
                                Informasi Selengkapnya
                            </span>


                            <a href="{{ $url }}">

                                <span>
                                    Baca Selengkapnya
                                </span>

                                <span class="bd-activity-detail-arrow">

                                    <svg viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 12h14M13 6l6 6-6 6"
                                        />
                                    </svg>

                                </span>

                            </a>

                        </div>

                    </article>

                @endforeach

            </div>


            <footer class="bd-activity-footer">

                <div class="bd-activity-footer-note">

                    <span></span>

                    Geser kartu atau gunakan tombol panah
                    untuk melihat update lainnya.

                </div>


                <a href="{{ route('informasi') }}">

                    Lihat Semua Informasi

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
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
================================================================ --}}
<section
    class="bd-publish-section"
    id="publish-cta"
>

    <div class="bd-publish-container">

        <div class="bd-publish-card">

            <div class="bd-publish-grid" aria-hidden="true"></div>

            <div class="bd-publish-glow bd-publish-glow-one" aria-hidden="true"></div>

            <div class="bd-publish-glow bd-publish-glow-two" aria-hidden="true"></div>


            <span
                class="bd-publish-watermark"
                id="bdPublishWatermark"
                aria-hidden="true"
            >
                01
            </span>


            {{-- COPY --}}
            <div class="bd-publish-copy">

                <div class="bd-publish-kicker">

                    <span class="bd-publish-kicker-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
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
                    <span class="bd-publish-title-main">
                        Siap mengubah naskah Anda
                    </span>

                    <span class="bd-publish-title-second">
                        menjadi sebuah buku?
                    </span>
                </h2>


                <p>
                    Dari naskah awal hingga siap diterbitkan.
                    Baca Dulu membantu proses editing, layout,
                    desain sampul, ISBN, HAKI, pencetakan hingga distribusi.
                </p>


                <div class="bd-publish-trust">

                    <div class="bd-publish-trust-item">
                        <i></i>
                        <span>Pendampingan penerbitan</span>
                    </div>

                    <div class="bd-publish-trust-item">
                        <i></i>
                        <span>Cetak & digital</span>
                    </div>

                    <div class="bd-publish-trust-item">
                        <i></i>
                        <span>ISBN & HAKI</span>
                    </div>

                </div>

            </div>


            {{-- SERVICES --}}
            <div class="bd-publish-services">

                @foreach([
                    ['01','Editing','Penyuntingan dan pemeriksaan naskah'],
                    ['02','Layout & Cover','Penataan isi dan desain sampul buku'],
                    ['03','ISBN & HAKI','Administrasi dan legalitas penerbitan'],
                    ['04','Cetak & E-book','Produksi buku fisik dan digital']
                ] as $index => $service)

                    <button
                        type="button"
                        class="
                            bd-publish-service
                            {{ $index === 0 ? 'is-active' : '' }}
                        "
                        data-publish-service
                        data-number="{{ $service[0] }}"
                    >

                        <span class="bd-publish-service-number">
                            {{ $service[0] }}
                        </span>

                        <span class="bd-publish-service-copy">

                            <strong>
                                {{ $service[1] }}
                            </strong>

                            <small>
                                {{ $service[2] }}
                            </small>

                        </span>

                        <span class="bd-publish-service-progress"></span>

                    </button>

                @endforeach

            </div>


            {{-- ACTION --}}
            <div class="bd-publish-action">

                <div class="bd-publish-action-head">

                    <span class="bd-publish-action-icon">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 15a4 4 0 01-4 4H8l-5 3V7a4 4 0 014-4h10a4 4 0 014 4v8z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 10h8M8 14h5"
                            />
                        </svg>

                    </span>


                    <div>

                        <span class="bd-publish-action-label">
                            Mulai Penerbitan
                        </span>

                        <span class="bd-publish-action-status">
                            <i></i>
                            Konsultasi tersedia
                        </span>

                    </div>

                </div>


                <h3>
                    Punya naskah yang siap dikembangkan?
                </h3>


                <p>
                    Ceritakan kebutuhan penerbitan Anda.
                    Tim kami akan membantu menentukan proses yang
                    paling sesuai untuk naskah Anda.
                </p>


                <a
                    href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku."
                    target="_blank"
                    rel="noopener noreferrer"
                    class="bd-publish-button"
                >

                    <span>
                        Konsultasi Sekarang
                    </span>

                    <span class="bd-publish-button-arrow">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14M13 6l6 6-6 6"
                            />
                        </svg>

                    </span>

                </a>


                <div class="bd-publish-action-footer">
                    Respon konsultasi melalui WhatsApp
                </div>

            </div>

        </div>

    </div>

</section>


<style>
/* ================================================================
   INFORMATION
================================================================ */
.bd-activity-section{
    --navy:#21194E;
    --orange:#EF5843;
    --yellow:#F7AA35;

    position:relative;

    width:100%;
    max-width:100%;

    overflow-x:clip;

    padding:76px 0 70px;

    background:#F4F1EB;
    color:#25252D;
}

.bd-activity-section *,
.bd-publish-section *{
    box-sizing:border-box;
}

.bd-activity-section a,
.bd-publish-section a{
    text-decoration:none;
}

.bd-activity-accent{
    position:absolute;
    pointer-events:none;
}

.bd-activity-accent-left{
    left:0;
    top:0;

    width:420px;
    height:100%;

    background:
        linear-gradient(
            90deg,
            rgba(239,88,67,.055),
            transparent 72%
        );
}

.bd-activity-accent-right{
    width:430px;
    height:430px;

    right:-190px;
    bottom:-210px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.055),
            transparent 70%
        );
}

.bd-activity-container{
    position:relative;

    z-index:2;

    width:min(calc(100% - 56px),1380px);

    margin:0 auto;
}


/* HEADER */
.bd-activity-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;

    gap:45px;
}

.bd-activity-heading{
    max-width:720px;
}

.bd-activity-eyebrow{
    display:flex;
    align-items:center;

    gap:8px;

    margin-bottom:10px;

    color:var(--orange);

    font-size:8px;
    font-weight:850;

    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-activity-eyebrow-icon{
    width:28px;
    height:28px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:8px;

    background:rgba(239,88,67,.09);
}

.bd-activity-eyebrow-icon svg{
    width:13px;
    height:13px;
}

.bd-activity-heading h2{
    margin:0;

    color:var(--navy);

    font-size:clamp(33px,3.7vw,48px);
    line-height:1.03;

    font-weight:850;

    letter-spacing:-.05em;
}

.bd-activity-heading h2 span{
    color:var(--orange);
}

.bd-activity-heading p{
    max-width:600px;

    margin:12px 0 0;

    color:#777982;

    font-size:10px;
    line-height:1.7;
}

.bd-activity-header-action{
    display:flex;
    align-items:center;

    gap:20px;

    flex:0 0 auto;
}

.bd-activity-total{
    display:flex;
    flex-direction:column;
    align-items:flex-end;

    padding-right:20px;

    border-right:1px solid rgba(33,25,78,.1);
}

.bd-activity-total strong{
    color:var(--orange);

    font-size:18px;
}

.bd-activity-total span{
    margin-top:3px;

    color:#99979E;

    font-size:6px;
    font-weight:750;

    text-transform:uppercase;
}

.bd-activity-all{
    display:flex;
    align-items:center;

    gap:9px;

    color:var(--navy)!important;

    font-size:8px;
    font-weight:850;
}

.bd-activity-all > span{
    width:31px;
    height:31px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(33,25,78,.13);
    border-radius:50%;

    background:#fff;
    color:var(--orange);
}

.bd-activity-all svg{
    width:12px;
    height:12px;
}

.bd-activity-header-line{
    position:relative;

    height:1px;

    margin:25px 0 21px;

    background:rgba(33,25,78,.1);
}

.bd-activity-header-line span{
    position:absolute;

    left:0;
    top:0;

    width:76px;
    height:1px;

    background:var(--orange);
}


/* SHOWCASE */
.bd-activity-showcase{
    position:relative;

    width:100%;
    max-width:100%;

    overflow:hidden;
}

.bd-activity-stage{
    position:relative;

    width:100%;
    height:390px;

    overflow:hidden;

    perspective:1200px;
}


/* CARDS */
.bd-activity-card{
    position:absolute;

    left:50%;
    top:15px;

    width:286px;
    height:350px;

    display:flex;
    flex-direction:column;

    padding:0;

    overflow:hidden;

    border:1px solid rgba(33,25,78,.1);
    border-radius:21px;

    background:#fff;
    color:inherit;

    text-align:left;

    box-shadow:
        0 14px 32px
        rgba(33,25,78,.08);

    cursor:pointer;
}

.bd-activity-card.is-active{
    border-color:rgba(239,88,67,.18);

    box-shadow:
        0 20px 44px
        rgba(33,25,78,.13);
}

.bd-activity-card-media{
    position:relative;

    width:100%;
    height:210px;

    flex:0 0 auto;

    overflow:hidden;

    background:#EEECE7;
}

.bd-activity-card-media > img{
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

    gap:9px;

    background:#F0EEE9;
}

.bd-info-error-fallback{
    display:none;
}

.bd-activity-card-placeholder img{
    width:52px;
    height:52px;

    object-fit:contain;

    border-radius:9px;
}

.bd-activity-card-placeholder span{
    color:#99979F;

    font-size:7px;
    font-weight:800;

    text-transform:uppercase;
}

.bd-activity-card-number{
    position:absolute;

    left:12px;
    top:12px;

    min-width:38px;
    height:28px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 8px;

    border-radius:8px;

    background:#fff;
    color:var(--orange);

    font-size:8px;
    font-weight:900;
}

.bd-activity-card-body{
    flex:1;

    display:flex;
    flex-direction:column;

    padding:16px;
}

.bd-activity-card-meta{
    display:flex;
    align-items:center;

    gap:5px;

    color:#99979F;

    font-size:6px;
    font-weight:750;

    text-transform:uppercase;
}

.bd-activity-card-meta > span{
    color:var(--orange);
}

.bd-activity-card-meta i{
    width:3px;
    height:3px;

    border-radius:50%;

    background:#CECBD0;
}

.bd-activity-card-body h3{
    margin:8px 0 0;

    overflow:hidden;

    color:var(--navy);

    font-size:13px;
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

    margin-top:auto;
    padding-top:12px;

    border-top:1px solid rgba(33,25,78,.08);

    color:#8A8891;

    font-size:7px;
    font-weight:800;
}

.bd-activity-card-bottom svg{
    width:11px;
    height:11px;

    color:var(--orange);
}


/* CONTROLS */
.bd-activity-controls{
    width:min(100%,680px);

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:13px;

    margin:8px auto 0;
}

.bd-activity-counter{
    min-width:70px;

    display:flex;
    align-items:baseline;

    gap:5px;

    color:#A4A1A8;

    font-size:8px;
    font-weight:800;
}

.bd-activity-counter strong{
    color:var(--orange);

    font-size:18px;
}

.bd-activity-nav-group{
    display:flex;
    align-items:center;

    gap:7px;

    margin-left:auto;
}

.bd-activity-nav{
    width:43px;
    height:43px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0;

    border:1px solid rgba(33,25,78,.13);
    border-radius:11px;

    background:#fff;
    color:var(--navy);

    cursor:pointer;
}

.bd-activity-nav-next{
    border-color:var(--navy);

    background:var(--navy);
    color:#fff;
}

.bd-activity-nav svg{
    width:14px;
    height:14px;
}


/* DETAILS */
.bd-activity-details{
    width:min(100%,1040px);

    margin:28px auto 0;
}

.bd-activity-detail{
    display:grid;

    grid-template-columns:
        76px
        minmax(0,1fr)
        215px;

    align-items:center;

    gap:23px;

    padding:18px;

    overflow:hidden;

    border:1px solid rgba(33,25,78,.09);
    border-radius:17px;

    background:rgba(255,255,255,.72);

    box-shadow:
        0 10px 30px
        rgba(33,25,78,.04);
}

.bd-activity-detail-index{
    min-height:98px;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    gap:4px;

    border:1px solid rgba(33,25,78,.08);
    border-radius:13px;

    background:#fff;
}

.bd-activity-detail-index span{
    color:var(--orange);

    font-size:21px;
    font-weight:900;
}

.bd-activity-detail-index small{
    color:#A19EA7;

    font-size:6px;
    font-weight:850;

    text-transform:uppercase;
}

.bd-activity-detail-main{
    min-width:0;
}

.bd-activity-detail-top{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:14px;

    margin-bottom:7px;
}

.bd-activity-detail-meta{
    display:flex;
    align-items:center;

    gap:6px;

    color:#99979F;

    font-size:7px;
    font-weight:800;

    text-transform:uppercase;
}

.bd-activity-detail-meta > span{
    color:var(--orange);
}

.bd-activity-detail-meta i{
    width:3px;
    height:3px;

    border-radius:50%;

    background:#CBC8CF;
}

.bd-activity-detail-active{
    display:flex;
    align-items:center;

    gap:5px;

    padding:4px 7px;

    border-radius:999px;

    background:#F4F1EB;
    color:#777380;

    font-size:6px;
    font-weight:800;

    text-transform:uppercase;
}

.bd-activity-detail-active i{
    width:5px;
    height:5px;

    border-radius:50%;

    background:#22C55E;
}

.bd-activity-detail-main h3{
    max-width:650px;

    margin:0;

    overflow:hidden;

    color:var(--navy);

    font-size:clamp(18px,1.8vw,25px);
    line-height:1.15;

    font-weight:850;

    text-overflow:ellipsis;
    white-space:nowrap;
}

.bd-activity-detail-description{
    max-width:680px;

    margin:8px 0 0;

    overflow:hidden;

    color:#777982;

    font-size:9px;
    line-height:1.6;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}

.bd-activity-detail-action{
    display:flex;
    flex-direction:column;
    justify-content:center;

    padding-left:20px;

    border-left:1px solid rgba(33,25,78,.08);
}

.bd-activity-detail-action-label{
    margin-bottom:9px;

    color:#8E8A96;

    font-size:7px;
    font-weight:850;

    text-transform:uppercase;
}

.bd-activity-detail-action > a{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:12px;

    color:var(--navy)!important;

    font-size:10px;
    font-weight:850;
}

.bd-activity-detail-arrow{
    width:36px;
    height:36px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex:0 0 auto;

    border-radius:50%;

    background:var(--orange);
    color:#fff;
}

.bd-activity-detail-arrow svg{
    width:13px;
    height:13px;
}


/* FOOTER */
.bd-activity-footer{
    width:min(100%,1040px);

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:20px;

    margin:0 auto;

    padding-top:15px;
}

.bd-activity-footer-note{
    display:flex;
    align-items:center;

    gap:7px;

    color:#A09EA5;

    font-size:7px;
}

.bd-activity-footer-note > span{
    width:5px;
    height:5px;

    border-radius:50%;

    background:var(--orange);
}

.bd-activity-footer a{
    display:flex;
    align-items:center;

    gap:6px;

    color:var(--orange)!important;

    font-size:8px;
    font-weight:850;
}

.bd-activity-footer svg{
    width:11px;
    height:11px;
}


/* ================================================================
   TOUCH INFORMATION
   Hanya active card.
================================================================ */
html[data-baca-input="touch"]
.bd-activity-stage{
    height:auto;

    overflow:hidden;

    perspective:none;
}

html[data-baca-input="touch"]
.bd-activity-card{
    position:relative;

    left:auto;
    top:auto;

    width:min(100%,320px);
    height:365px;

    margin:0 auto;

    transform:none!important;

    opacity:1!important;
    visibility:visible!important;

    filter:none!important;
}

html[data-baca-input="touch"]
.bd-activity-card:not(.is-active){
    display:none;
}

html[data-baca-input="touch"]
.bd-activity-card.is-active{
    display:flex;
}


/* ================================================================
   PHONE INFORMATION
================================================================ */
html[data-baca-device="phone"]
.bd-activity-section{
    padding:56px 0 54px;
}

html[data-baca-device="phone"]
.bd-activity-container{
    width:100%;

    padding:0 16px;
}

html[data-baca-device="phone"]
.bd-activity-header{
    flex-direction:column;
    align-items:flex-start;

    gap:15px;
}

html[data-baca-device="phone"]
.bd-activity-heading h2{
    font-size:32px;
}

html[data-baca-device="phone"]
.bd-activity-heading p{
    font-size:9.5px;
}

html[data-baca-device="phone"]
.bd-activity-header-action{
    width:100%;

    justify-content:space-between;
}

html[data-baca-device="phone"]
.bd-activity-total{
    align-items:flex-start;

    padding:0;
    border:0;
}

html[data-baca-device="phone"]
.bd-activity-header-line{
    margin:19px 0;
}

html[data-baca-device="phone"]
.bd-activity-card{
    width:min(100%,295px);

    height:355px;
}

html[data-baca-device="phone"]
.bd-activity-card-media{
    height:215px;
}

html[data-baca-device="phone"]
.bd-activity-controls{
    width:min(100%,295px);

    margin-top:12px;
}

html[data-baca-device="phone"]
.bd-activity-nav{
    width:45px;
    height:45px;
}

html[data-baca-device="phone"]
.bd-activity-details{
    width:100%;

    margin-top:22px;
}

html[data-baca-device="phone"]
.bd-activity-detail{
    grid-template-columns:1fr;

    gap:11px;

    padding:15px;
}

html[data-baca-device="phone"]
.bd-activity-detail-index{
    width:max-content;

    min-width:65px;
    min-height:39px;

    flex-direction:row;

    padding:0 9px;
}

html[data-baca-device="phone"]
.bd-activity-detail-index span{
    font-size:17px;
}

html[data-baca-device="phone"]
.bd-activity-detail-top{
    flex-wrap:wrap;

    gap:7px;
}

html[data-baca-device="phone"]
.bd-activity-detail-main h3{
    max-width:100%;

    overflow:visible;

    font-size:19px;

    text-overflow:clip;
    white-space:normal;

    overflow-wrap:anywhere;
}

html[data-baca-device="phone"]
.bd-activity-detail-description{
    max-width:100%;

    font-size:9px;

    -webkit-line-clamp:3;
}

html[data-baca-device="phone"]
.bd-activity-detail-action{
    width:100%;

    padding:12px 0 0;

    border-left:0;
    border-top:1px solid rgba(33,25,78,.08);
}

html[data-baca-device="phone"]
.bd-activity-detail-action > a{
    width:100%;

    white-space:normal;
}

html[data-baca-device="phone"]
.bd-activity-footer{
    width:100%;

    flex-direction:column;
    align-items:flex-start;

    gap:10px;
}


/* ================================================================
   CTA
================================================================ */
.bd-publish-section{
    --navy:#21194E;
    --orange:#EF5843;
    --yellow:#F7AA35;

    position:relative;

    width:100%;
    max-width:100%;

    overflow-x:clip;

    padding:0 0 76px;

    background:#F4F1EB;
}

.bd-publish-container{
    width:min(calc(100% - 56px),1380px);

    margin:0 auto;
}

.bd-publish-card{
    position:relative;

    isolation:isolate;

    display:grid;

    grid-template-columns:
        minmax(0,1.1fr)
        minmax(230px,.65fr)
        minmax(285px,.74fr);

    align-items:center;

    gap:38px;

    min-height:385px;

    padding:46px;

    overflow:hidden;

    border-radius:27px;

    background:
        radial-gradient(
            circle at 92% 18%,
            rgba(105,86,178,.16),
            transparent 28%
        ),
        linear-gradient(
            135deg,
            #21194E,
            #251D58
        );

    box-shadow:
        0 25px 60px
        rgba(33,25,78,.15);
}

.bd-publish-grid{
    position:absolute;

    z-index:-4;

    inset:0;

    opacity:.05;

    pointer-events:none;

    background-image:
        linear-gradient(rgba(255,255,255,.12) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.12) 1px,transparent 1px);

    background-size:54px 54px;
}

.bd-publish-glow{
    position:absolute;

    z-index:-3;

    border-radius:50%;

    pointer-events:none;
}

.bd-publish-glow-one{
    width:340px;
    height:340px;

    left:-190px;
    bottom:-235px;

    background:
        radial-gradient(
            circle,
            rgba(239,88,67,.2),
            transparent 68%
        );
}

.bd-publish-glow-two{
    width:370px;
    height:370px;

    right:-170px;
    top:-240px;

    background:
        radial-gradient(
            circle,
            rgba(247,170,53,.13),
            transparent 70%
        );
}

.bd-publish-watermark{
    position:absolute;

    z-index:-1;

    right:30%;
    bottom:-50px;

    color:rgba(255,255,255,.026);

    font-size:180px;
    font-weight:900;

    pointer-events:none;
}


/* COPY */
.bd-publish-copy{
    min-width:0;
}

.bd-publish-kicker{
    display:flex;
    align-items:center;

    gap:9px;

    color:var(--yellow);

    font-size:8px;
    font-weight:850;

    text-transform:uppercase;
}

.bd-publish-kicker-icon{
    width:34px;
    height:34px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:10px;

    background:rgba(247,170,53,.09);
}

.bd-publish-kicker-icon svg{
    width:16px;
    height:16px;
}

.bd-publish-copy h2{
    margin:17px 0 0;

    color:#fff;

    font-size:clamp(32px,3vw,44px);
    line-height:1.06;

    font-weight:850;

    letter-spacing:-.05em;
}

.bd-publish-title-main,
.bd-publish-title-second{
    display:block;
}

.bd-publish-title-second{
    margin-top:3px;

    color:rgba(255,255,255,.67);
}

.bd-publish-copy p{
    max-width:520px;

    margin:16px 0 0;

    color:rgba(255,255,255,.58);

    font-size:10px;
    line-height:1.75;
}

.bd-publish-trust{
    display:flex;
    flex-wrap:wrap;

    gap:9px 15px;

    margin-top:20px;
}

.bd-publish-trust-item{
    display:flex;
    align-items:center;

    gap:6px;

    color:rgba(255,255,255,.48);

    font-size:7px;
    font-weight:700;
}

.bd-publish-trust-item i{
    width:5px;
    height:5px;

    border-radius:50%;

    background:var(--orange);
}


/* SERVICES */
.bd-publish-services{
    border-top:1px solid rgba(255,255,255,.11);
}

.bd-publish-service{
    position:relative;

    width:100%;
    min-height:68px;

    display:grid;

    grid-template-columns:
        31px
        minmax(0,1fr);

    align-items:center;

    gap:11px;

    padding:0 3px;

    overflow:hidden;

    border:0;
    border-bottom:1px solid rgba(255,255,255,.11);

    background:transparent;

    text-align:left;

    cursor:pointer;
}

.bd-publish-service-number{
    color:var(--orange);

    font-size:8px;
    font-weight:900;
}

.bd-publish-service-copy{
    min-width:0;
}

.bd-publish-service-copy strong{
    display:block;

    color:#fff;

    font-size:10px;
    font-weight:820;
}

.bd-publish-service-copy small{
    display:block;

    margin-top:4px;

    color:rgba(255,255,255,.4);

    font-size:7px;
    line-height:1.4;
}

.bd-publish-service-progress{
    position:absolute;

    left:0;
    right:0;
    bottom:-1px;

    height:2px;

    transform:scaleX(0);
    transform-origin:left;

    background:
        linear-gradient(
            90deg,
            var(--orange),
            var(--yellow)
        );

    transition:transform .25s ease;
}

.bd-publish-service.is-active
.bd-publish-service-progress{
    transform:scaleX(1);
}


/* ACTION */
.bd-publish-action{
    min-width:0;

    min-height:275px;

    display:flex;
    flex-direction:column;
    justify-content:center;

    padding:25px;

    overflow:hidden;

    border:1px solid rgba(255,255,255,.13);
    border-radius:20px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.075),
            rgba(255,255,255,.035)
        );
}

.bd-publish-action-head{
    display:flex;
    align-items:center;

    gap:10px;
}

.bd-publish-action-icon{
    width:36px;
    height:36px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex:0 0 auto;

    border-radius:10px;

    background:rgba(239,88,67,.1);
    color:var(--orange);
}

.bd-publish-action-icon svg{
    width:16px;
    height:16px;
}

.bd-publish-action-head > div{
    display:flex;
    flex-direction:column;

    gap:4px;
}

.bd-publish-action-label{
    color:var(--yellow);

    font-size:7px;
    font-weight:850;

    text-transform:uppercase;
}

.bd-publish-action-status{
    display:flex;
    align-items:center;

    gap:5px;

    color:rgba(255,255,255,.4);

    font-size:6px;
}

.bd-publish-action-status i{
    width:5px;
    height:5px;

    border-radius:50%;

    background:#4ADE80;
}

.bd-publish-action h3{
    margin:18px 0 0;

    color:#fff;

    font-size:21px;
    line-height:1.28;

    font-weight:820;
}

.bd-publish-action > p{
    margin:10px 0 0;

    color:rgba(255,255,255,.48);

    font-size:8px;
    line-height:1.6;
}

.bd-publish-button{
    width:100%;
    min-height:49px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:10px;

    margin-top:19px;

    padding:0 10px 0 15px;

    border-radius:12px;

    background:var(--orange);
    color:#fff!important;

    font-size:9px;
    font-weight:850;
}

.bd-publish-button-arrow{
    width:30px;
    height:30px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex:0 0 auto;

    border-radius:8px;

    background:rgba(255,255,255,.12);
}

.bd-publish-button-arrow svg{
    width:12px;
    height:12px;
}

.bd-publish-action-footer{
    margin-top:10px;

    color:rgba(255,255,255,.3);

    font-size:6px;
}


/* CTA LAPTOP */
@media(max-width:1100px){

    .bd-publish-card{
        grid-template-columns:
            minmax(0,1fr)
            minmax(280px,.85fr);

        gap:32px;

        padding:39px;
    }

    .bd-publish-copy{
        grid-column:1;
    }

    .bd-publish-services{
        grid-column:1;
    }

    .bd-publish-action{
        grid-column:2;
        grid-row:1/3;
    }
}


/* CTA TOUCH */
html[data-baca-input="touch"]
.bd-publish-section{
    padding-bottom:58px;
}

html[data-baca-input="touch"]
.bd-publish-container{
    width:100%;

    padding:0 20px;
}

html[data-baca-input="touch"]
.bd-publish-card{
    grid-template-columns:1fr;

    gap:24px;

    min-height:0;

    padding:29px 21px;

    border-radius:21px;
}

html[data-baca-input="touch"]
.bd-publish-copy,
html[data-baca-input="touch"]
.bd-publish-services,
html[data-baca-input="touch"]
.bd-publish-action{
    grid-column:1;
    grid-row:auto;
}

html[data-baca-input="touch"]
.bd-publish-services{
    display:grid;

    grid-template-columns:
        repeat(2,minmax(0,1fr));

    gap:9px;

    border:0;
}

html[data-baca-input="touch"]
.bd-publish-service{
    min-height:100px;

    display:flex;
    flex-direction:column;
    align-items:flex-start;

    gap:10px;

    padding:13px;

    border:1px solid rgba(255,255,255,.1);
    border-radius:13px;

    background:rgba(255,255,255,.045);
}

html[data-baca-input="touch"]
.bd-publish-service-progress{
    left:13px;
    right:13px;
}

html[data-baca-input="touch"]
.bd-publish-action{
    min-height:0;

    padding:21px;

    transform:none!important;
}

html[data-baca-input="touch"]
.bd-publish-watermark,
html[data-baca-input="touch"]
.bd-publish-glow{
    display:none;
}


/* PHONE CTA */
html[data-baca-device="phone"]
.bd-publish-container{
    padding:0 16px;
}

html[data-baca-device="phone"]
.bd-publish-copy h2{
    font-size:31px;
}

html[data-baca-device="phone"]
.bd-publish-copy p{
    font-size:9px;
}

html[data-baca-device="phone"]
.bd-publish-action h3{
    font-size:19px;
}


/* SMALL PHONE */
@media(max-width:390px){

    html[data-baca-device="phone"]
    .bd-activity-container,
    html[data-baca-device="phone"]
    .bd-publish-container{
        padding-left:14px;
        padding-right:14px;
    }

    html[data-baca-device="phone"]
    .bd-activity-heading h2{
        font-size:29px;
    }

    html[data-baca-device="phone"]
    .bd-activity-card,
    html[data-baca-device="phone"]
    .bd-activity-controls{
        width:min(100%,270px);
    }

    html[data-baca-device="phone"]
    .bd-publish-card{
        padding:26px 17px;
    }

    html[data-baca-device="phone"]
    .bd-publish-copy h2{
        font-size:28px;
    }

    html[data-baca-device="phone"]
    .bd-publish-services{
        grid-template-columns:1fr;
    }
}
</style>


<script>
(function(){

    function initHomeInformation(){

        const section =
            document.getElementById(
                'baca-informasi'
            );

        const publishSection =
            document.getElementById(
                'publish-cta'
            );

        if(
            !section ||
            section.dataset.activityReady === '1'
        ){
            return;
        }

        section.dataset.activityReady =
            '1';


        const cards =
            Array.from(
                section.querySelectorAll(
                    '[data-activity-card]'
                )
            );

        const details =
            Array.from(
                section.querySelectorAll(
                    '[data-activity-detail]'
                )
            );

        const stage =
            section.querySelector(
                '#bdActivityStage'
            );

        const prev =
            section.querySelector(
                '#bdActivityPrev'
            );

        const next =
            section.querySelector(
                '#bdActivityNext'
            );

        const counter =
            section.querySelector(
                '#bdActivityCurrent'
            );

        const gsap =
            window.bdGsap || null;

        const reduceMotion =
            window.matchMedia(
                '(prefers-reduced-motion:reduce)'
            ).matches;


        let activeIndex = 0;
        let changing = false;

        let startX = 0;
        let startY = 0;


        function device(){

            return (
                window.BacaDevice ||
                {
                    type:
                        window.innerWidth <= 767
                            ? 'phone'
                            : (
                                window.innerWidth <= 1023
                                    ? 'tablet'
                                    : 'desktop'
                            ),

                    touch:
                        navigator.maxTouchPoints > 0,

                    finePointer:
                        navigator.maxTouchPoints === 0
                }
            );
        }


        function isTouch(){

            const d =
                device();

            return (
                d.touch === true ||
                d.type !== 'desktop'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DETAILS
        |--------------------------------------------------------------------------
        */
        function updateDetail(
            previousIndex
        ){

            details.forEach(
                function(detail,index){

                    detail.style.display =
                        index === activeIndex
                            ? 'grid'
                            : 'none';

                    detail.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );
                }
            );


            if(
                gsap &&
                !reduceMotion &&
                !isTouch()
            ){

                const detail =
                    details[activeIndex];

                if(detail){

                    gsap.fromTo(
                        detail,
                        {
                            opacity:0,
                            y:7
                        },
                        {
                            opacity:1,
                            y:0,
                            duration:.28,
                            ease:'power2.out',
                            clearProps:
                                'transform,opacity'
                        }
                    );
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOUCH
        |--------------------------------------------------------------------------
        */
        function renderTouch(
            direction = 1,
            animate = false
        ){

            cards.forEach(
                function(card,index){

                    if(gsap){
                        gsap.killTweensOf(card);
                    }

                    card.style.display =
                        index === activeIndex
                            ? 'flex'
                            : 'none';

                    card.style.transform =
                        'none';

                    card.style.opacity =
                        '1';

                    card.style.visibility =
                        'visible';

                    card.style.filter =
                        'none';

                    card.style.zIndex =
                        index === activeIndex
                            ? '2'
                            : '1';

                    card.style.pointerEvents =
                        index === activeIndex
                            ? 'auto'
                            : 'none';

                    card.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );
                }
            );


            if(
                animate &&
                gsap &&
                !reduceMotion
            ){

                const active =
                    cards[activeIndex];

                gsap.fromTo(
                    active,
                    {
                        opacity:.45,
                        x:
                            direction > 0
                                ? 15
                                : -15
                    },
                    {
                        opacity:1,
                        x:0,
                        duration:.28,
                        ease:'power2.out',
                        clearProps:
                            'transform,opacity'
                    }
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DESKTOP STACK
        |--------------------------------------------------------------------------
        */
        function renderDesktop(
            animate = true
        ){

            const total =
                cards.length;

            const offset =
                window.innerWidth <= 1150
                    ? 245
                    : 270;


            cards.forEach(
                function(card,index){

                    card.style.display =
                        'flex';


                    let relative =
                        index -
                        activeIndex;


                    if(
                        relative >
                        total / 2
                    ){
                        relative -= total;
                    }


                    if(
                        relative <
                        -(total / 2)
                    ){
                        relative += total;
                    }


                    let x = 0;
                    let scale = 1;
                    let opacity = 1;
                    let grayscale = 0;
                    let zIndex = 6;
                    let pointer = 'auto';


                    if(relative === 1){

                        x = offset;
                        scale = .84;
                        opacity = .80;
                        grayscale = .65;
                        zIndex = 5;
                    }

                    else if(relative === -1){

                        x = -offset;
                        scale = .84;
                        opacity = .80;
                        grayscale = .65;
                        zIndex = 5;
                    }

                    else if(relative === 2){

                        x = offset * 1.6;
                        scale = .68;
                        opacity = .28;
                        grayscale = 1;
                        zIndex = 3;
                    }

                    else if(relative === -2){

                        x = -(offset * 1.6);
                        scale = .68;
                        opacity = .28;
                        grayscale = 1;
                        zIndex = 3;
                    }

                    else if(relative !== 0){

                        opacity = 0;
                        grayscale = 1;
                        zIndex = 1;
                        pointer = 'none';
                    }


                    card.classList.toggle(
                        'is-active',
                        index === activeIndex
                    );


                    if(
                        gsap &&
                        animate &&
                        !reduceMotion
                    ){

                        gsap.to(
                            card,
                            {
                                x:x,
                                xPercent:-50,
                                scale:scale,
                                opacity:opacity,
                                filter:
                                    'grayscale(' +
                                    grayscale +
                                    ')',

                                zIndex:zIndex,
                                pointerEvents:pointer,

                                duration:.45,
                                ease:'power3.inOut',
                                overwrite:true
                            }
                        );
                    }
                    else{

                        card.style.transform =
                            'translateX(-50%) ' +
                            'translateX(' +
                            x +
                            'px) ' +
                            'scale(' +
                            scale +
                            ')';

                        card.style.opacity =
                            opacity;

                        card.style.filter =
                            'grayscale(' +
                            grayscale +
                            ')';

                        card.style.zIndex =
                            zIndex;

                        card.style.pointerEvents =
                            pointer;
                    }
                }
            );
        }


        function updateCounter(){

            if(counter){

                counter.textContent =
                    String(
                        activeIndex + 1
                    ).padStart(
                        2,
                        '0'
                    );
            }
        }


        function render(
            direction = 1,
            animate = true
        ){

            updateCounter();

            if(isTouch()){

                renderTouch(
                    direction,
                    animate
                );
            }
            else{

                renderDesktop(
                    animate
                );
            }
        }


        function setActive(
            index,
            direction = 1
        ){

            if(
                !cards.length ||
                changing
            ){
                return;
            }

            const target =
                (
                    index +
                    cards.length
                ) %
                cards.length;


            if(target === activeIndex){
                return;
            }


            changing =
                true;


            const previous =
                activeIndex;


            activeIndex =
                target;


            render(
                direction,
                true
            );


            updateDetail(
                previous
            );


            setTimeout(
                function(){

                    changing =
                        false;
                },
                isTouch()
                    ? 300
                    : 470
            );
        }


        function goPrevious(){

            setActive(
                activeIndex - 1,
                -1
            );
        }


        function goNext(){

            setActive(
                activeIndex + 1,
                1
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CARD CLICK
        |--------------------------------------------------------------------------
        */
        cards.forEach(
            function(card,index){

                card.addEventListener(
                    'click',
                    function(){

                        if(index === activeIndex){

                            const link =
                                details[
                                    activeIndex
                                ]?.querySelector(
                                    'a'
                                );

                            if(link){

                                window.location.href =
                                    link.href;
                            }

                            return;
                        }


                        setActive(
                            index,
                            index >= activeIndex
                                ? 1
                                : -1
                        );
                    }
                );
            }
        );


        prev?.addEventListener(
            'click',
            function(event){

                event.preventDefault();

                goPrevious();
            }
        );


        next?.addEventListener(
            'click',
            function(event){

                event.preventDefault();

                goNext();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | SWIPE
        |--------------------------------------------------------------------------
        */
        stage?.addEventListener(
            'touchstart',
            function(event){

                if(!isTouch()){
                    return;
                }

                const touch =
                    event.touches[0];

                startX =
                    touch.clientX;

                startY =
                    touch.clientY;
            },
            {
                passive:true
            }
        );


        stage?.addEventListener(
            'touchend',
            function(event){

                if(!isTouch()){
                    return;
                }

                const touch =
                    event.changedTouches[0];

                const dx =
                    touch.clientX -
                    startX;

                const dy =
                    touch.clientY -
                    startY;


                if(
                    Math.abs(dx) < 45 ||
                    Math.abs(dx) <
                    Math.abs(dy)
                ){
                    return;
                }


                if(dx < 0){
                    goNext();
                }
                else{
                    goPrevious();
                }
            },
            {
                passive:true
            }
        );


        /*
        |--------------------------------------------------------------------------
        | DEVICE CHANGE
        |--------------------------------------------------------------------------
        */
        window.addEventListener(
            'baca:devicechange',
            function(){

                render(
                    1,
                    false
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | CTA SERVICES
        |--------------------------------------------------------------------------
        */
        if(publishSection){

            const services =
                Array.from(
                    publishSection.querySelectorAll(
                        '[data-publish-service]'
                    )
                );

            const watermark =
                publishSection.querySelector(
                    '#bdPublishWatermark'
                );


            function activateService(index){

                services.forEach(
                    function(service,i){

                        service.classList.toggle(
                            'is-active',
                            i === index
                        );
                    }
                );


                if(watermark){

                    watermark.textContent =
                        services[index]
                            ?.dataset
                            .number
                        ||
                        '01';
                }
            }


            services.forEach(
                function(service,index){

                    service.addEventListener(
                        'click',
                        function(){

                            activateService(
                                index
                            );
                        }
                    );


                    service.addEventListener(
                        'mouseenter',
                        function(){

                            if(
                                device()
                                    .finePointer
                            ){

                                activateService(
                                    index
                                );
                            }
                        }
                    );
                }
            );
        }


        activeIndex = 0;

        updateCounter();

        updateDetail(0);

        render(
            1,
            false
        );
    }


    if(
        document.readyState ===
        'loading'
    ){

        document.addEventListener(
            'DOMContentLoaded',
            initHomeInformation,
            {
                once:true
            }
        );
    }
    else{

        initHomeInformation();
    }

})();
</script>