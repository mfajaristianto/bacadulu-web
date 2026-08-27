@php
    $informasiTerbaru = \App\Models\Information::query()
        ->latest()
        ->take(6)
        ->get();
@endphp

{{-- ================================================================
     INFORMASI & AGENDA
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 2v3M16 2v3M4 9h16M5 4h14a1 1 0 011 1v15H4V5a1 1 0 011-1z"/>
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
                        <strong>{{ str_pad($informasiTerbaru->count(), 2, '0', STR_PAD_LEFT) }}</strong>
                        <span>Update Terbaru</span>
                    </div>
                @endif

                <a href="{{ route('informasi') }}" class="bd-activity-all">
                    Semua Informasi
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
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
                <span>Update Baca Dulu</span>
                <h3>Belum ada informasi terbaru.</h3>
                <p>Kegiatan dan informasi terbaru akan tampil di bagian ini.</p>
            </div>

        @else

            {{-- =====================================================
                 CAROUSEL
            ====================================================== --}}
            <div class="bd-activity-showcase">
                <div class="bd-activity-stage">

                    @foreach($informasiTerbaru as $index => $item)
                        @php
                            $judul = $item->title ?? $item->judul ?? 'Informasi Baca Dulu';
                            $gambar = !empty($item->image) ? asset('storage/' . $item->image) : null;
                            $kategori = $item->category ?? $item->type ?? 'Informasi';
                            $tanggal = $item->created_at
                                ? $item->created_at->translatedFormat('d M Y')
                                : null;
                            $nomor = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
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
                                        <img src="{{ asset('img/bacadulu-logo.jpg') }}" alt="">
                                        <span>Baca Dulu</span>
                                    </div>
                                @endif

                                <span class="bd-activity-card-number">
                                    {{ $nomor }}
                                </span>
                            </div>

                            <div class="bd-activity-card-body">
                                <div class="bd-activity-card-meta">
                                    <span>{{ $kategori }}</span>

                                    @if($tanggal)
                                        <i></i>
                                        <time>{{ $tanggal }}</time>
                                    @endif
                                </div>

                                <h3>{{ $judul }}</h3>

                                <div class="bd-activity-card-bottom">
                                    <span>Lihat Informasi</span>

                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    @endforeach

                </div>

                {{-- CONTROLS --}}
                <div class="bd-activity-controls">
                    <button
                        type="button"
                        id="bdActivityPrev"
                        class="bd-activity-nav"
                        aria-label="Informasi sebelumnya"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                    </button>

                    <div class="bd-activity-counter">
                        <strong id="bdActivityCurrent">01</strong>
                        <span>/</span>
                        <span>{{ str_pad($informasiTerbaru->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <button
                        type="button"
                        id="bdActivityNext"
                        class="bd-activity-nav bd-activity-nav-next"
                        aria-label="Informasi berikutnya"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- =====================================================
                 ACTIVE INFORMATION PREVIEW
            ====================================================== --}}
            <div class="bd-activity-details">

                @foreach($informasiTerbaru as $index => $item)
                    @php
                        $judul = $item->title ?? $item->judul ?? 'Informasi Baca Dulu';

                        $url = !empty($item->slug)
                            ? url('/information/' . $item->slug)
                            : route('informasi');

                        $deskripsi = $item->excerpt
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

                        $kategori = $item->category ?? $item->type ?? 'Informasi';

                        $tanggal = $item->created_at
                            ? $item->created_at->translatedFormat('d M Y')
                            : null;

                        $nomor = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    @endphp

                    <article
                        class="bd-activity-detail {{ $index === 0 ? 'is-active' : '' }}"
                        data-activity-detail="{{ $index }}"
                        style="{{ $index === 0 ? '' : 'display:none;' }}"
                    >
                        <div class="bd-activity-detail-index">
                            <span>{{ $nomor }}</span>
                            <small>Update</small>
                        </div>

                        <div class="bd-activity-detail-main">
                            <div class="bd-activity-detail-top">
                                <div class="bd-activity-detail-meta">
                                    <span>{{ $kategori }}</span>

                                    @if($tanggal)
                                        <i></i>
                                        <time>{{ $tanggal }}</time>
                                    @endif
                                </div>

                                <span class="bd-activity-detail-active">
                                    <i></i>
                                    Sedang Ditampilkan
                                </span>
                            </div>

                            <h3>{{ $judul }}</h3>

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
                                <span>Baca Selengkapnya</span>

                                <span class="bd-activity-detail-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </article>
                @endforeach

            </div>

            {{-- FOOTER --}}
            <footer class="bd-activity-footer">
                <div class="bd-activity-footer-note">
                    <span></span>
                    Pilih kartu atau gunakan tombol panah untuk melihat update lainnya.
                </div>

                <a href="{{ route('informasi') }}">
                    Lihat Semua Informasi

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </a>
            </footer>

        @endif
    </div>
</section>

{{-- ================================================================
     CTA PENERBITAN BARU
================================================================ --}}
<section class="bd-publish-section" id="publish-cta">
    <div class="bd-publish-container">
        <div class="bd-publish-card">

            <div class="bd-publish-grid" aria-hidden="true"></div>
            <div class="bd-publish-glow bd-publish-glow-one" aria-hidden="true"></div>
            <div class="bd-publish-glow bd-publish-glow-two" aria-hidden="true"></div>

            <span class="bd-publish-watermark" id="bdPublishWatermark" aria-hidden="true">
                01
            </span>

            {{-- LEFT --}}
            <div class="bd-publish-copy">
                <div class="bd-publish-kicker">
                    <span class="bd-publish-kicker-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>
                    </span>

                    <span>Penerbitan Buku</span>
                </div>

                <h2>
                    Siap mengubah naskah Anda
                    <span>menjadi sebuah buku?</span>
                </h2>

                <p>
                    Dari naskah awal hingga siap diterbitkan. Baca Dulu membantu
                    proses editing, layout, desain sampul, ISBN, HAKI,
                    pencetakan hingga distribusi dalam satu alur penerbitan.
                </p>

                <div class="bd-publish-trust">
                    <div class="bd-publish-trust-item">
                        <span class="bd-publish-trust-dot"></span>
                        <span>Pendampingan penerbitan</span>
                    </div>

                    <div class="bd-publish-trust-item">
                        <span class="bd-publish-trust-dot"></span>
                        <span>Cetak & digital</span>
                    </div>

                    <div class="bd-publish-trust-item">
                        <span class="bd-publish-trust-dot"></span>
                        <span>ISBN & HAKI</span>
                    </div>
                </div>
            </div>

            {{-- SERVICES --}}
            <div class="bd-publish-services">

                <button
                    type="button"
                    class="bd-publish-service is-active"
                    data-publish-service
                    data-number="01"
                >
                    <span class="bd-publish-service-number">01</span>

                    <div class="bd-publish-service-copy">
                        <strong>Editing</strong>
                        <small>Penyuntingan dan pemeriksaan naskah</small>
                    </div>

                    <span class="bd-publish-service-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>

                    <span class="bd-publish-service-progress"></span>
                </button>

                <button
                    type="button"
                    class="bd-publish-service"
                    data-publish-service
                    data-number="02"
                >
                    <span class="bd-publish-service-number">02</span>

                    <div class="bd-publish-service-copy">
                        <strong>Layout & Cover</strong>
                        <small>Penataan isi dan desain sampul buku</small>
                    </div>

                    <span class="bd-publish-service-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>

                    <span class="bd-publish-service-progress"></span>
                </button>

                <button
                    type="button"
                    class="bd-publish-service"
                    data-publish-service
                    data-number="03"
                >
                    <span class="bd-publish-service-number">03</span>

                    <div class="bd-publish-service-copy">
                        <strong>ISBN & HAKI</strong>
                        <small>Administrasi dan legalitas penerbitan</small>
                    </div>

                    <span class="bd-publish-service-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>

                    <span class="bd-publish-service-progress"></span>
                </button>

                <button
                    type="button"
                    class="bd-publish-service"
                    data-publish-service
                    data-number="04"
                >
                    <span class="bd-publish-service-number">04</span>

                    <div class="bd-publish-service-copy">
                        <strong>Cetak & E-book</strong>
                        <small>Produksi buku fisik dan format digital</small>
                    </div>

                    <span class="bd-publish-service-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>

                    <span class="bd-publish-service-progress"></span>
                </button>

            </div>

            {{-- ACTION --}}
            <div class="bd-publish-action">
                <div class="bd-publish-action-head">
                    <span class="bd-publish-action-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 15a4 4 0 01-4 4H8l-5 3V7a4 4 0 014-4h10a4 4 0 014 4v8z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5"/>
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
                    Ceritakan kebutuhan penerbitan Anda. Tim kami akan membantu
                    menentukan proses yang paling sesuai untuk naskah Anda.
                </p>

                <a
                    href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku."
                    target="_blank"
                    rel="noopener noreferrer"
                    class="bd-publish-button"
                >
                    <span>Konsultasi Sekarang</span>

                    <span class="bd-publish-button-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </a>

                <div class="bd-publish-action-footer">
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>
                    </span>

                    Respon konsultasi melalui WhatsApp
                </div>
            </div>

        </div>
    </div>
</section>

<style>
/* ================================================================
   ROOT INFORMASI
================================================================ */
.bd-activity-section{
    --navy:#21194E;
    --orange:#EF5843;
    --yellow:#F7AA35;
    --text:#25252D;
    --muted:#777982;
    --line:rgba(33,25,78,.10);
    position:relative;
    width:100%;
    overflow:hidden;
    padding:92px 0 82px;
    background:#F4F1EB;
    color:var(--text)
}

.bd-activity-section *,
.bd-publish-section *{
    box-sizing:border-box
}

.bd-activity-section a,
.bd-publish-section a{
    text-decoration:none
}

.bd-activity-accent{
    position:absolute;
    pointer-events:none
}

.bd-activity-accent-left{
    top:0;
    left:0;
    width:420px;
    height:100%;
    background:linear-gradient(90deg,rgba(239,88,67,.065),transparent 72%)
}

.bd-activity-accent-right{
    right:-180px;
    bottom:-200px;
    width:430px;
    height:430px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.065),transparent 70%)
}

.bd-activity-container{
    position:relative;
    z-index:2;
    width:min(calc(100% - 48px),1280px);
    margin:0 auto
}

/* ================================================================
   HEADER
================================================================ */
.bd-activity-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:55px
}

.bd-activity-heading{
    max-width:760px
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
    text-transform:uppercase
}

.bd-activity-eyebrow-icon{
    width:30px;
    height:30px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:rgba(239,88,67,.09)
}

.bd-activity-eyebrow-icon svg{
    width:14px;
    height:14px
}

.bd-activity-heading h2{
    margin:0;
    color:var(--navy);
    font-size:clamp(38px,4.5vw,57px);
    line-height:1.02;
    font-weight:820;
    letter-spacing:-.052em
}

.bd-activity-heading h2 span{
    color:var(--orange)
}

.bd-activity-heading p{
    max-width:620px;
    margin:15px 0 0;
    color:var(--muted);
    font-size:11px;
    line-height:1.75
}

.bd-activity-header-action{
    display:flex;
    align-items:center;
    gap:25px;
    flex-shrink:0
}

.bd-activity-total{
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    padding-right:23px;
    border-right:1px solid var(--line)
}

.bd-activity-total strong{
    color:var(--orange);
    font-size:20px;
    line-height:1;
    font-weight:900
}

.bd-activity-total span{
    margin-top:4px;
    color:#99979E;
    font-size:7px;
    font-weight:750;
    letter-spacing:.08em;
    text-transform:uppercase
}

.bd-activity-all{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--navy)!important;
    font-size:9px;
    font-weight:850
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
    transition:.25s ease
}

.bd-activity-all:hover > span{
    color:#fff;
    background:var(--orange);
    border-color:var(--orange)
}

.bd-activity-all svg{
    width:12px;
    height:12px
}

.bd-activity-header-line{
    position:relative;
    width:100%;
    height:1px;
    margin:30px 0 26px;
    overflow:hidden;
    background:var(--line)
}

.bd-activity-header-line span{
    position:absolute;
    left:0;
    top:0;
    width:84px;
    height:1px;
    background:var(--orange);
    transform-origin:left
}

/* ================================================================
   CAROUSEL
================================================================ */
.bd-activity-showcase{
    position:relative
}

.bd-activity-stage{
    position:relative;
    width:100%;
    height:455px;
    overflow:hidden
}

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
    box-shadow:0 15px 36px rgba(33,25,78,.08);
    cursor:pointer;
    transform-origin:center;
    will-change:transform,opacity,filter
}

.bd-activity-card.is-active{
    border-color:rgba(239,88,67,.18);
    box-shadow:0 24px 55px rgba(33,25,78,.14)
}

.bd-activity-card-media{
    position:relative;
    width:100%;
    height:245px;
    flex-shrink:0;
    overflow:hidden;
    background:#EEECE7
}

.bd-activity-card-media img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover
}

.bd-activity-card-placeholder{
    width:100%;
    height:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    background:#F0EEE9
}

.bd-activity-card-placeholder img{
    width:58px;
    height:58px;
    object-fit:contain;
    border-radius:10px
}

.bd-activity-card-placeholder span{
    color:#99979F;
    font-size:8px;
    font-weight:800;
    letter-spacing:.12em;
    text-transform:uppercase
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
    font-weight:900
}

.bd-activity-card-body{
    flex:1;
    display:flex;
    flex-direction:column;
    padding:18px 18px 17px
}

.bd-activity-card-meta{
    display:flex;
    align-items:center;
    gap:6px;
    color:#99979F;
    font-size:6.5px;
    font-weight:750;
    text-transform:uppercase;
    letter-spacing:.07em
}

.bd-activity-card-meta > span{
    color:var(--orange)
}

.bd-activity-card-meta i{
    display:block;
    width:3px;
    height:3px;
    border-radius:50%;
    background:#CECBD0
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
    -webkit-box-orient:vertical
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
    font-weight:800
}

.bd-activity-card-bottom svg{
    width:12px;
    height:12px;
    color:var(--orange)
}

/* ================================================================
   CONTROLS
================================================================ */
.bd-activity-controls{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:18px;
    margin-top:3px
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
    transition:.25s ease
}

.bd-activity-nav:hover{
    transform:translateY(-2px);
    border-color:rgba(239,88,67,.30)
}

.bd-activity-nav-next{
    color:#fff;
    background:var(--navy);
    border-color:var(--navy)
}

.bd-activity-nav svg{
    width:14px;
    height:14px
}

.bd-activity-counter{
    min-width:65px;
    display:flex;
    align-items:baseline;
    justify-content:center;
    gap:5px;
    color:#A4A1A8;
    font-size:8px;
    font-weight:800
}

.bd-activity-counter strong{
    color:var(--orange);
    font-size:17px
}

/* ================================================================
   ACTIVE INFORMATION PREVIEW
================================================================ */
.bd-activity-details{
    position:relative;
    width:min(100%,1080px);
    margin:38px auto 0
}

.bd-activity-detail{
    position:relative;
    display:grid;
    grid-template-columns:86px minmax(0,1fr) 230px;
    gap:28px;
    align-items:stretch;
    padding:22px;
    overflow:hidden;
    border:1px solid rgba(33,25,78,.09);
    border-radius:20px;
    background:rgba(255,255,255,.70);
    box-shadow:0 12px 35px rgba(33,25,78,.045);
    backdrop-filter:blur(10px)
}

.bd-activity-detail::before{
    content:"";
    position:absolute;
    top:22px;
    bottom:22px;
    left:0;
    width:3px;
    border-radius:0 999px 999px 0;
    background:linear-gradient(180deg,var(--orange),var(--yellow))
}

.bd-activity-detail-index{
    min-height:122px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:5px;
    border-radius:15px;
    background:#fff;
    border:1px solid rgba(33,25,78,.08)
}

.bd-activity-detail-index span{
    color:var(--orange);
    font-size:25px;
    line-height:1;
    font-weight:900
}

.bd-activity-detail-index small{
    color:#A19EA7;
    font-size:7px;
    font-weight:850;
    letter-spacing:.12em;
    text-transform:uppercase
}

.bd-activity-detail-main{
    min-width:0;
    align-self:center
}

.bd-activity-detail-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;
    margin-bottom:9px
}

.bd-activity-detail-meta{
    display:flex;
    align-items:center;
    gap:7px;
    color:#99979F;
    font-size:7.5px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase
}

.bd-activity-detail-meta > span{
    color:var(--orange)
}

.bd-activity-detail-meta i{
    width:3px;
    height:3px;
    flex:0 0 auto;
    border-radius:50%;
    background:#CBC8CF
}

.bd-activity-detail-active{
    display:inline-flex;
    align-items:center;
    gap:6px;
    flex-shrink:0;
    padding:5px 8px;
    border-radius:999px;
    color:#777380;
    background:#F4F1EB;
    font-size:7px;
    font-weight:800;
    letter-spacing:.06em;
    text-transform:uppercase
}

.bd-activity-detail-active i{
    width:5px;
    height:5px;
    border-radius:50%;
    background:#22C55E;
    box-shadow:0 0 0 3px rgba(34,197,94,.10)
}

.bd-activity-detail-main h3{
    max-width:650px;
    margin:0;
    overflow:hidden;
    color:var(--navy);
    font-size:clamp(20px,2vw,28px);
    line-height:1.15;
    font-weight:820;
    letter-spacing:-.035em;
    text-overflow:ellipsis;
    white-space:nowrap
}

.bd-activity-detail-description{
    max-width:690px;
    margin:10px 0 0;
    overflow:hidden;
    color:#777982;
    font-size:10px;
    line-height:1.65;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical
}

.bd-activity-detail-action{
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding-left:24px;
    border-left:1px solid rgba(33,25,78,.08)
}

.bd-activity-detail-action-label{
    margin-bottom:11px;
    color:#8E8A96;
    font-size:8px;
    line-height:1.2;
    font-weight:850;
    letter-spacing:.09em;
    text-transform:uppercase
}

.bd-activity-detail-action > a{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    color:var(--navy)!important;
    font-size:11.5px;
    line-height:1.3;
    font-weight:850
}

.bd-activity-detail-action > a > span:first-child{
    white-space:nowrap
}

.bd-activity-detail-arrow{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 auto;
    border-radius:50%;
    color:#fff;
    background:var(--orange);
    box-shadow:0 8px 18px rgba(239,88,67,.18);
    transition:.25s ease
}

.bd-activity-detail-arrow svg{
    width:14px;
    height:14px
}

.bd-activity-detail-action > a:hover .bd-activity-detail-arrow{
    background:var(--navy);
    transform:translateX(3px)
}

/* ================================================================
   INFORMATION FOOTER
================================================================ */
.bd-activity-footer{
    width:min(100%,1080px);
    margin:0 auto;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:25px;
    padding-top:18px
}

.bd-activity-footer-note{
    display:flex;
    align-items:center;
    gap:8px;
    color:#A09EA5;
    font-size:7px
}

.bd-activity-footer-note > span{
    width:5px;
    height:5px;
    flex:0 0 auto;
    border-radius:50%;
    background:var(--orange)
}

.bd-activity-footer a{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:var(--orange)!important;
    font-size:8.5px;
    font-weight:850
}

.bd-activity-footer svg{
    width:11px;
    height:11px
}

/* EMPTY */
.bd-activity-empty{
    padding:65px 20px;
    text-align:center
}

.bd-activity-empty > span{
    color:var(--orange);
    font-size:8px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase
}

.bd-activity-empty h3{
    margin:9px 0 0;
    color:var(--navy);
    font-size:20px
}

.bd-activity-empty p{
    margin:7px 0 0;
    color:var(--muted);
    font-size:10px
}

/* ================================================================
   CTA PENERBITAN
================================================================ */
.bd-publish-section{
    --navy:#21194E;
    --orange:#EF5843;
    --yellow:#F7AA35;
    position:relative;
    padding:0 0 88px;
    overflow:hidden;
    background:#F4F1EB
}

.bd-publish-container{
    width:min(calc(100% - 48px),1280px);
    margin:0 auto
}

.bd-publish-card{
    position:relative;
    isolation:isolate;
    display:grid;
    grid-template-columns:minmax(0,1.2fr) minmax(260px,.7fr) minmax(300px,.76fr);
    gap:48px;
    align-items:center;
    min-height:430px;
    padding:56px;
    overflow:hidden;
    border-radius:30px;
    background:
        radial-gradient(circle at 92% 18%,rgba(105,86,178,.16),transparent 28%),
        linear-gradient(135deg,#21194E 0%,#21194E 55%,#251D58 100%);
    box-shadow:0 28px 68px rgba(33,25,78,.16)
}

.bd-publish-card::before{
    content:"";
    position:absolute;
    z-index:4;
    top:56px;
    bottom:56px;
    left:0;
    width:4px;
    border-radius:0 999px 999px 0;
    background:linear-gradient(180deg,var(--orange),var(--yellow))
}

.bd-publish-grid{
    position:absolute;
    z-index:-4;
    inset:0;
    opacity:.055;
    pointer-events:none;
    background-image:
        linear-gradient(rgba(255,255,255,.12) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.12) 1px,transparent 1px);
    background-size:54px 54px;
    -webkit-mask-image:linear-gradient(90deg,transparent 4%,black 45%,black 100%);
    mask-image:linear-gradient(90deg,transparent 4%,black 45%,black 100%)
}

.bd-publish-glow{
    position:absolute;
    z-index:-3;
    border-radius:50%;
    pointer-events:none
}

.bd-publish-glow-one{
    width:340px;
    height:340px;
    left:-190px;
    bottom:-235px;
    background:radial-gradient(circle,rgba(239,88,67,.20),transparent 68%)
}

.bd-publish-glow-two{
    width:370px;
    height:370px;
    right:-170px;
    top:-240px;
    background:radial-gradient(circle,rgba(247,170,53,.13),transparent 70%)
}

.bd-publish-watermark{
    position:absolute;
    z-index:-1;
    right:30%;
    bottom:-50px;
    color:rgba(255,255,255,.026);
    font-size:190px;
    line-height:1;
    font-weight:900;
    letter-spacing:-.08em;
    pointer-events:none;
    user-select:none
}

/* CTA COPY */
.bd-publish-copy{
    position:relative;
    z-index:2;
    max-width:590px
}

.bd-publish-kicker{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--yellow);
    font-size:9px;
    line-height:1;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase
}

.bd-publish-kicker-icon{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(247,170,53,.15);
    border-radius:11px;
    background:rgba(247,170,53,.09);
    color:var(--yellow)
}

.bd-publish-kicker-icon svg{
    width:17px;
    height:17px
}

.bd-publish-copy h2{
    max-width:590px;
    margin:20px 0 0;
    color:#fff;
    font-size:clamp(36px,3.45vw,52px);
    line-height:1.06;
    font-weight:820;
    letter-spacing:-.052em
}

.bd-publish-copy h2 span{
    display:block;
    margin-top:4px;
    color:rgba(255,255,255,.67)
}

.bd-publish-copy p{
    max-width:560px;
    margin:21px 0 0;
    color:rgba(255,255,255,.58);
    font-size:11px;
    line-height:1.82
}

.bd-publish-trust{
    display:flex;
    flex-wrap:wrap;
    gap:10px 18px;
    margin-top:25px
}

.bd-publish-trust-item{
    display:flex;
    align-items:center;
    gap:7px;
    color:rgba(255,255,255,.48);
    font-size:8px;
    font-weight:700
}

.bd-publish-trust-dot{
    width:5px;
    height:5px;
    flex:0 0 auto;
    border-radius:50%;
    background:var(--orange);
    box-shadow:0 0 0 4px rgba(239,88,67,.08)
}

/* ================================================================
   CTA SERVICES
================================================================ */
.bd-publish-services{
    position:relative;
    z-index:3;
    width:100%;
    border-top:1px solid rgba(255,255,255,.11)
}

.bd-publish-service{
    position:relative;
    width:100%;
    min-height:78px;
    display:grid;
    grid-template-columns:34px minmax(0,1fr) 24px;
    gap:14px;
    align-items:center;
    padding:0 3px;
    overflow:hidden;
    border:0;
    border-bottom:1px solid rgba(255,255,255,.11);
    outline:none;
    background:transparent;
    color:inherit;
    text-align:left;
    cursor:pointer
}

.bd-publish-service-number{
    color:var(--orange);
    font-size:9px;
    font-weight:900;
    transition:.28s ease
}

.bd-publish-service-copy{
    min-width:0
}

.bd-publish-service strong{
    display:block;
    color:#fff;
    font-size:11px;
    line-height:1.3;
    font-weight:820;
    transition:.28s ease
}

.bd-publish-service small{
    display:block;
    margin-top:5px;
    color:rgba(255,255,255,.40);
    font-size:7.5px;
    line-height:1.45
}

.bd-publish-service-arrow{
    width:24px;
    height:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--orange);
    opacity:0;
    transform:translateX(-6px);
    transition:.28s ease
}

.bd-publish-service-arrow svg{
    width:12px;
    height:12px
}

.bd-publish-service-progress{
    position:absolute;
    left:0;
    right:0;
    bottom:-1px;
    height:2px;
    background:linear-gradient(90deg,var(--orange),var(--yellow));
    transform:scaleX(0);
    transform-origin:left;
    transition:transform .38s cubic-bezier(.22,.8,.22,1)
}

.bd-publish-service:hover .bd-publish-service-progress,
.bd-publish-service.is-active .bd-publish-service-progress{
    transform:scaleX(1)
}

.bd-publish-service:hover .bd-publish-service-number,
.bd-publish-service.is-active .bd-publish-service-number{
    color:var(--yellow);
    transform:translateX(3px)
}

.bd-publish-service:hover strong,
.bd-publish-service.is-active strong{
    transform:translateX(4px)
}

.bd-publish-service:hover .bd-publish-service-arrow,
.bd-publish-service.is-active .bd-publish-service-arrow{
    opacity:1;
    transform:translateX(0)
}

/* ================================================================
   CTA ACTION
================================================================ */
.bd-publish-action{
    position:relative;
    z-index:3;
    min-height:304px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:30px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,.13);
    border-radius:24px;
    background:linear-gradient(145deg,rgba(255,255,255,.075),rgba(255,255,255,.035));
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.035),
        0 18px 45px rgba(10,7,33,.12);
    backdrop-filter:blur(12px)
}

.bd-publish-action::after{
    content:"";
    position:absolute;
    width:170px;
    height:170px;
    right:-100px;
    bottom:-115px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.15),transparent 70%);
    pointer-events:none
}

.bd-publish-action-head{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    gap:12px
}

.bd-publish-action-icon{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 auto;
    border-radius:11px;
    color:var(--orange);
    background:rgba(239,88,67,.10);
    border:1px solid rgba(239,88,67,.13)
}

.bd-publish-action-icon svg{
    width:17px;
    height:17px
}

.bd-publish-action-head > div{
    display:flex;
    flex-direction:column;
    gap:5px
}

.bd-publish-action-label{
    color:var(--yellow);
    font-size:8px;
    line-height:1;
    font-weight:850;
    letter-spacing:.12em;
    text-transform:uppercase
}

.bd-publish-action-status{
    display:flex;
    align-items:center;
    gap:6px;
    color:rgba(255,255,255,.40);
    font-size:7px;
    font-weight:700
}

.bd-publish-action-status i{
    width:5px;
    height:5px;
    border-radius:50%;
    background:#4ADE80;
    box-shadow:0 0 0 4px rgba(74,222,128,.08)
}

.bd-publish-action h3{
    position:relative;
    z-index:2;
    max-width:290px;
    margin:22px 0 0;
    color:#fff;
    font-size:23px;
    line-height:1.28;
    font-weight:820;
    letter-spacing:-.025em
}

.bd-publish-action > p{
    position:relative;
    z-index:2;
    max-width:310px;
    margin:12px 0 0;
    color:rgba(255,255,255,.48);
    font-size:9px;
    line-height:1.65
}

.bd-publish-button{
    position:relative;
    z-index:2;
    width:100%;
    min-height:52px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    margin-top:24px;
    padding:0 11px 0 17px;
    border-radius:13px;
    background:var(--orange);
    color:#fff!important;
    font-size:10px;
    font-weight:850;
    transition:.28s ease
}

.bd-publish-button:hover{
    color:var(--navy)!important;
    background:var(--yellow);
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(247,170,53,.18)
}

.bd-publish-button-arrow{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 auto;
    border-radius:9px;
    background:rgba(255,255,255,.12)
}

.bd-publish-button-arrow svg{
    width:13px;
    height:13px
}

.bd-publish-action-footer{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    gap:7px;
    margin-top:12px;
    color:rgba(255,255,255,.30);
    font-size:7px
}

.bd-publish-action-footer > span{
    width:16px;
    height:16px;
    display:flex;
    align-items:center;
    justify-content:center
}

.bd-publish-action-footer svg{
    width:11px;
    height:11px
}

/* ================================================================
   RESPONSIVE
================================================================ */
@media(max-width:1100px){
    .bd-publish-card{
        grid-template-columns:minmax(0,1fr) minmax(280px,.82fr);
        gap:38px;
        padding:48px
    }

    .bd-publish-copy{
        grid-column:1
    }

    .bd-publish-services{
        grid-column:1
    }

    .bd-publish-action{
        grid-column:2;
        grid-row:1 / 3
    }

    .bd-publish-copy h2{
        font-size:42px
    }

    .bd-publish-watermark{
        right:15%;
        font-size:160px
    }
}

@media(max-width:900px){
    .bd-activity-detail{
        grid-template-columns:70px minmax(0,1fr)
    }

    .bd-activity-detail-action{
        grid-column:2;
        padding:16px 0 0;
        border-left:0;
        border-top:1px solid rgba(33,25,78,.08)
    }
}

@media(max-width:800px){
    .bd-activity-header{
        flex-direction:column;
        align-items:flex-start;
        gap:22px
    }

    .bd-activity-header-action{
        width:100%;
        justify-content:space-between
    }

    .bd-activity-stage{
        height:425px
    }

    .bd-activity-card{
        width:280px;
        height:365px
    }

    .bd-activity-card-media{
        height:215px
    }

    .bd-publish-card{
        grid-template-columns:1fr;
        gap:34px;
        min-height:auto;
        padding:42px 36px
    }

    .bd-publish-copy,
    .bd-publish-services,
    .bd-publish-action{
        grid-column:auto;
        grid-row:auto
    }

    .bd-publish-action{
        min-height:auto
    }

    .bd-publish-watermark{
        right:-15px;
        bottom:-35px;
        font-size:150px
    }
}

@media(max-width:600px){
    .bd-activity-section{
        padding:62px 0 55px
    }

    .bd-activity-container,
    .bd-publish-container{
        width:min(calc(100% - 30px),1280px)
    }

    .bd-activity-heading h2{
        font-size:37px
    }

    .bd-activity-header-action{
        align-items:flex-start;
        flex-direction:column
    }

    .bd-activity-total{
        align-items:flex-start;
        padding-right:0;
        border-right:0
    }

    .bd-activity-stage{
        height:405px
    }

    .bd-activity-card{
        width:min(76vw,275px);
        height:350px;
        border-radius:20px
    }

    .bd-activity-card-media{
        height:205px
    }

    .bd-activity-details{
        width:100%;
        margin-top:28px
    }

    .bd-activity-detail{
        grid-template-columns:1fr;
        gap:15px;
        padding:18px
    }

    .bd-activity-detail-index{
        width:68px;
        min-height:56px;
        flex-direction:row
    }

    .bd-activity-detail-top{
        align-items:flex-start;
        flex-direction:column;
        gap:8px
    }

    .bd-activity-detail-main h3{
        font-size:21px;
        white-space:normal
    }

    .bd-activity-detail-action{
        grid-column:auto;
        padding:15px 0 0;
        border-left:0;
        border-top:1px solid rgba(33,25,78,.08)
    }

    .bd-activity-detail-action > a{
        width:100%;
        font-size:11px
    }

    .bd-activity-footer{
        flex-direction:column;
        align-items:flex-start;
        gap:12px
    }

    .bd-publish-section{
        padding-bottom:62px
    }

    .bd-publish-card{
        gap:29px;
        padding:34px 23px;
        border-radius:23px
    }

    .bd-publish-card::before{
        top:35px;
        bottom:35px
    }

    .bd-publish-copy h2{
        margin-top:17px;
        font-size:34px
    }

    .bd-publish-copy p{
        font-size:10px
    }

    .bd-publish-trust{
        gap:9px 13px;
        margin-top:20px
    }

    .bd-publish-service{
        min-height:72px
    }

    .bd-publish-service strong{
        font-size:10.5px
    }

    .bd-publish-action{
        padding:24px;
        border-radius:19px
    }

    .bd-publish-action h3{
        font-size:21px
    }

    .bd-publish-button{
        min-height:50px
    }

    .bd-publish-watermark{
        display:none
    }
}

@media(prefers-reduced-motion:reduce){
    .bd-activity-section *,
    .bd-publish-section *{
        scroll-behavior:auto!important
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const section = document.getElementById('baca-informasi');
    const publishSection = document.getElementById('publish-cta');

    if (!section) return;

    const cards = Array.from(section.querySelectorAll('[data-activity-card]'));
    const details = Array.from(section.querySelectorAll('[data-activity-detail]'));
    const prevButton = document.getElementById('bdActivityPrev');
    const nextButton = document.getElementById('bdActivityNext');
    const currentCounter = document.getElementById('bdActivityCurrent');

    const reduceMotion = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
    const finePointer = window.matchMedia('(hover:hover) and (pointer:fine)').matches;
    const gsap = window.bdGsap || window.gsap || null;

    let activeIndex = 0;
    let changing = false;

    /* ============================================================
       INFORMATION CAROUSEL
    ============================================================ */
    function getCardOffset() {
        const width = window.innerWidth;

        if (width <= 600) return Math.min(width * .60, 245);
        if (width <= 850) return 235;
        if (width <= 1100) return 260;

        return 295;
    }

    function renderCards(animate = true) {
        if (!cards.length) return;

        const offset = getCardOffset();
        const total = cards.length;

        cards.forEach(function (card, index) {
            let relative = index - activeIndex;

            if (relative > total / 2) relative -= total;
            if (relative < -(total / 2)) relative += total;

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
            } else if (relative === -1) {
                x = -offset;
                scale = .86;
                opacity = .88;
                grayscale = .72;
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
                x = relative > 0 ? offset * 2 : -(offset * 2);
                scale = .62;
                opacity = 0;
                grayscale = 1;
                zIndex = 1;
                pointerEvents = 'none';
            }

            card.classList.toggle('is-active', index === activeIndex);

            if (gsap && !reduceMotion && animate) {
                gsap.to(card, {
                    x,
                    xPercent: -50,
                    scale,
                    opacity,
                    filter: `grayscale(${grayscale})`,
                    zIndex,
                    pointerEvents,
                    duration: .58,
                    ease: 'power3.inOut',
                    overwrite: true
                });
            } else {
                card.style.transform = `translateX(-50%) translateX(${x}px) scale(${scale})`;
                card.style.opacity = opacity;
                card.style.filter = `grayscale(${grayscale})`;
                card.style.zIndex = zIndex;
                card.style.pointerEvents = pointerEvents;
            }
        });
    }

    function updateDetails(previousIndex) {
        if (!details.length) return;

        const oldDetail = details[previousIndex];
        const newDetail = details[activeIndex];

        if (!newDetail) return;

        if (!gsap || reduceMotion || !oldDetail || oldDetail === newDetail) {
            details.forEach(function (detail, index) {
                detail.style.display = index === activeIndex ? 'grid' : 'none';
                detail.classList.toggle('is-active', index === activeIndex);
            });

            return;
        }

        gsap.to(oldDetail, {
            autoAlpha: 0,
            y: -8,
            duration: .19,
            ease: 'power2.in',

            onComplete: function () {
                oldDetail.style.display = 'none';
                oldDetail.classList.remove('is-active');

                newDetail.style.display = 'grid';
                newDetail.classList.add('is-active');

                gsap.fromTo(
                    newDetail,
                    {
                        autoAlpha: 0,
                        y: 10,
                        scale: .985
                    },
                    {
                        autoAlpha: 1,
                        y: 0,
                        scale: 1,
                        duration: .38,
                        ease: 'power3.out'
                    }
                );
            }
        });
    }

    function setActive(nextIndex) {
        if (changing || !cards[nextIndex] || nextIndex === activeIndex) return;

        changing = true;

        const previousIndex = activeIndex;
        activeIndex = nextIndex;

        if (currentCounter) {
            currentCounter.textContent = String(activeIndex + 1).padStart(2, '0');
        }

        renderCards(true);
        updateDetails(previousIndex);

        setTimeout(function () {
            changing = false;
        }, 580);
    }

    cards.forEach(function (card, index) {
        card.addEventListener('click', function () {
            if (index === activeIndex) {
                const activeDetail = details[activeIndex];
                const link = activeDetail?.querySelector('a');

                if (link) link.click();

                return;
            }

            setActive(index);
        });
    });

    prevButton?.addEventListener('click', function () {
        let next = activeIndex - 1;

        if (next < 0) next = cards.length - 1;

        setActive(next);
    });

    nextButton?.addEventListener('click', function () {
        let next = activeIndex + 1;

        if (next >= cards.length) next = 0;

        setActive(next);
    });

    let resizeTimer = null;

    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(function () {
            renderCards(false);
        }, 120);
    });

    /* ============================================================
       INFORMATION INTRO
    ============================================================ */
    if (gsap && !reduceMotion) {
        const intro = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 83%',
                once: true
            },
            defaults: {
                ease: 'power3.out'
            }
        });

        intro
            .from(section.querySelector('.bd-activity-eyebrow'), {
                autoAlpha: 0,
                y: 8,
                duration: .35
            })
            .from(section.querySelector('.bd-activity-heading h2'), {
                autoAlpha: 0,
                y: 18,
                duration: .55
            }, '-=.17')
            .from(section.querySelector('.bd-activity-heading p'), {
                autoAlpha: 0,
                y: 10,
                duration: .4
            }, '-=.29')
            .from(section.querySelector('.bd-activity-header-action'), {
                autoAlpha: 0,
                x: 10,
                duration: .4
            }, '-=.3')
            .from(section.querySelector('.bd-activity-stage'), {
                autoAlpha: 0,
                y: 20,
                duration: .58
            }, '-=.2')
            .from(section.querySelector('.bd-activity-controls'), {
                autoAlpha: 0,
                y: 8,
                duration: .35
            }, '-=.28')
            .from(section.querySelector('.bd-activity-details'), {
                autoAlpha: 0,
                y: 13,
                duration: .45
            }, '-=.2');
    }

    /* ============================================================
       INFORMATION HOVER
    ============================================================ */
    if (gsap && !reduceMotion && finePointer) {
        cards.forEach(function (card) {
            const image = card.querySelector('.bd-activity-card-media img');

            card.addEventListener('mouseenter', function () {
                if (!card.classList.contains('is-active') || !image) return;

                gsap.to(image, {
                    scale: 1.025,
                    duration: .4,
                    ease: 'power2.out'
                });
            });

            card.addEventListener('mouseleave', function () {
                if (!image) return;

                gsap.to(image, {
                    scale: 1,
                    duration: .5,
                    ease: 'power3.out'
                });
            });
        });
    }

    /* ============================================================
       CTA INTRO
    ============================================================ */
    if (publishSection && gsap && !reduceMotion) {
        const publishCard = publishSection.querySelector('.bd-publish-card');
        const publishCopy = publishSection.querySelector('.bd-publish-copy');
        const publishServices = publishSection.querySelectorAll('.bd-publish-service');
        const publishAction = publishSection.querySelector('.bd-publish-action');

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: publishSection,
                start: 'top 88%',
                once: true
            },
            defaults: {
                ease: 'power3.out'
            }
        });

        tl.from(publishCard, {
            autoAlpha: 0,
            y: 28,
            scale: .98,
            duration: .7
        });

        tl.from(publishCopy.children, {
            autoAlpha: 0,
            x: -16,
            duration: .42,
            stagger: .06
        }, '-=.4');

        tl.from(publishServices, {
            autoAlpha: 0,
            x: 16,
            duration: .38,
            stagger: .07
        }, '-=.32');

        tl.from(publishAction, {
            autoAlpha: 0,
            x: 22,
            scale: .97,
            duration: .5
        }, '-=.35');
    }

    /* ============================================================
       CTA SERVICES
    ============================================================ */
    if (publishSection) {
        const publishServices = Array.from(
            publishSection.querySelectorAll('[data-publish-service]')
        );

        const watermark = publishSection.querySelector('#bdPublishWatermark');

        function activatePublishService(index) {
            publishServices.forEach(function (service, serviceIndex) {
                service.classList.toggle('is-active', serviceIndex === index);
            });

            if (!watermark) return;

            const number = publishServices[index]?.dataset.number || '01';

            if (gsap && !reduceMotion) {
                gsap.to(watermark, {
                    autoAlpha: 0,
                    y: 8,
                    duration: .12,
                    overwrite: true,

                    onComplete: function () {
                        watermark.textContent = number;

                        gsap.fromTo(
                            watermark,
                            {
                                autoAlpha: 0,
                                y: 8
                            },
                            {
                                autoAlpha: 1,
                                y: 0,
                                duration: .28,
                                ease: 'power3.out',
                                overwrite: true
                            }
                        );
                    }
                });
            } else {
                watermark.textContent = number;
            }
        }

        publishServices.forEach(function (service, index) {
            service.addEventListener('mouseenter', function () {
                if (!finePointer) return;

                activatePublishService(index);
            });

            service.addEventListener('focus', function () {
                activatePublishService(index);
            });

            service.addEventListener('click', function () {
                activatePublishService(index);
            });
        });

        /* ACTION CARD TILT */
        const publishAction = publishSection.querySelector('.bd-publish-action');

        if (gsap && !reduceMotion && finePointer && publishAction) {
            publishAction.addEventListener('pointermove', function (e) {
                const rect = publishAction.getBoundingClientRect();

                const x = (e.clientX - rect.left) / rect.width - .5;
                const y = (e.clientY - rect.top) / rect.height - .5;

                gsap.to(publishAction, {
                    rotationY: x * 2.2,
                    rotationX: -y * 1.8,
                    transformPerspective: 900,
                    duration: .5,
                    ease: 'power3.out',
                    overwrite: true
                });
            });

            publishAction.addEventListener('pointerleave', function () {
                gsap.to(publishAction, {
                    rotationY: 0,
                    rotationX: 0,
                    duration: .6,
                    ease: 'power3.out',
                    overwrite: true
                });
            });
        }

        /* BUTTON */
        const publishButton = publishSection.querySelector('.bd-publish-button');
        const publishArrow = publishSection.querySelector('.bd-publish-button-arrow');

        if (gsap && !reduceMotion && publishButton && publishArrow) {
            publishButton.addEventListener('mouseenter', function () {
                gsap.to(publishArrow, {
                    x: 3,
                    duration: .18,
                    ease: 'power2.out'
                });
            });

            publishButton.addEventListener('mouseleave', function () {
                gsap.to(publishArrow, {
                    x: 0,
                    duration: .28,
                    ease: 'power3.out'
                });
            });
        }

        /* AMBIENT GLOW */
        const glowOne = publishSection.querySelector('.bd-publish-glow-one');
        const glowTwo = publishSection.querySelector('.bd-publish-glow-two');

        if (gsap && !reduceMotion) {
            if (glowOne) {
                gsap.to(glowOne, {
                    x: 32,
                    y: -18,
                    duration: 7,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });
            }

            if (glowTwo) {
                gsap.to(glowTwo, {
                    x: -28,
                    y: 20,
                    duration: 8,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });
            }
        }
    }

    renderCards(false);
});
</script>