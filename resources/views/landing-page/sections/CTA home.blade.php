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

                <h2>Update terbaru <span>Baca Dulu.</span></h2>

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

        <div class="bd-activity-header-line"><span></span></div>

        @if($informasiTerbaru->isEmpty())
            <div class="bd-activity-empty">
                <span>Update Baca Dulu</span>
                <h3>Belum ada informasi terbaru.</h3>
                <p>Kegiatan dan informasi terbaru akan tampil di bagian ini.</p>
            </div>
        @else
            <div class="bd-activity-showcase">
                <div class="bd-activity-stage" id="bdActivityStage">
                    @foreach($informasiTerbaru as $index => $item)
                        @php
                            $judul = $item->title ?? $item->judul ?? 'Informasi Baca Dulu';
                            $gambar = !empty($item->image) ? asset('storage/' . $item->image) : null;
                            $kategori = $item->category ?? $item->type ?? 'Informasi';
                            $tanggal = $item->created_at ? $item->created_at->translatedFormat('d M Y') : null;
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
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                    >

                                    <div class="bd-activity-card-placeholder bd-info-error-fallback">
                                        <img src="{{ asset('img/bacadulu-logo.jpg') }}" alt="">
                                        <span>Baca Dulu</span>
                                    </div>
                                @else
                                    <div class="bd-activity-card-placeholder">
                                        <img src="{{ asset('img/bacadulu-logo.jpg') }}" alt="">
                                        <span>Baca Dulu</span>
                                    </div>
                                @endif

                                <span class="bd-activity-card-number">{{ $nomor }}</span>
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

                <div class="bd-activity-controls">
                    <button type="button" id="bdActivityPrev" class="bd-activity-nav" aria-label="Informasi sebelumnya">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                    </button>

                    <div class="bd-activity-counter">
                        <strong id="bdActivityCurrent">01</strong>
                        <span>/</span>
                        <span>{{ str_pad($informasiTerbaru->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <button type="button" id="bdActivityNext" class="bd-activity-nav bd-activity-nav-next" aria-label="Informasi berikutnya">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bd-activity-details">
                @foreach($informasiTerbaru as $index => $item)
                    @php
                        $judul = $item->title ?? $item->judul ?? 'Informasi Baca Dulu';
                        $url = !empty($item->slug) ? url('/information/' . $item->slug) : route('informasi');
                        $deskripsi = $item->excerpt ?? \Illuminate\Support\Str::limit(
                            html_entity_decode(strip_tags($item->content ?? $item->deskripsi ?? '')),
                            180
                        );
                        $kategori = $item->category ?? $item->type ?? 'Informasi';
                        $tanggal = $item->created_at ? $item->created_at->translatedFormat('d M Y') : null;
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
                                <p class="bd-activity-detail-description">{{ $deskripsi }}</p>
                            @endif
                        </div>

                        <div class="bd-activity-detail-action">
                            <span class="bd-activity-detail-action-label">Informasi Selengkapnya</span>

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

            <footer class="bd-activity-footer">
                <div class="bd-activity-footer-note">
                    <span></span>
                    Geser kartu atau gunakan tombol panah untuk melihat update lainnya.
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
     CTA
================================================================ --}}
<section class="bd-publish-section" id="publish-cta">
    <div class="bd-publish-container">
        <div class="bd-publish-card">
            <div class="bd-publish-grid" aria-hidden="true"></div>
            <div class="bd-publish-glow bd-publish-glow-one" aria-hidden="true"></div>
            <div class="bd-publish-glow bd-publish-glow-two" aria-hidden="true"></div>

            <span class="bd-publish-watermark" id="bdPublishWatermark" aria-hidden="true">01</span>

            <div class="bd-publish-copy">
                <div class="bd-publish-kicker">
                    <span class="bd-publish-kicker-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>
                    </span>
                    <span>Penerbitan Buku</span>
                </div>

                <h2>
                    <span class="bd-publish-title-main">Siap mengubah naskah Anda</span>
                    <span class="bd-publish-title-second">menjadi sebuah buku?</span>
                </h2>

                <p>
                    Dari naskah awal hingga siap diterbitkan. Baca Dulu membantu proses editing,
                    layout, desain sampul, ISBN, HAKI, pencetakan hingga distribusi.
                </p>

                <div class="bd-publish-trust">
                    <div class="bd-publish-trust-item"><i></i><span>Pendampingan penerbitan</span></div>
                    <div class="bd-publish-trust-item"><i></i><span>Cetak & digital</span></div>
                    <div class="bd-publish-trust-item"><i></i><span>ISBN & HAKI</span></div>
                </div>
            </div>

            <div class="bd-publish-services">
                @foreach([
                    ['01','Editing','Penyuntingan dan pemeriksaan naskah'],
                    ['02','Layout & Cover','Penataan isi dan desain sampul buku'],
                    ['03','ISBN & HAKI','Administrasi dan legalitas penerbitan'],
                    ['04','Cetak & E-book','Produksi buku fisik dan digital']
                ] as $index => $service)
                    <button
                        type="button"
                        class="bd-publish-service {{ $index === 0 ? 'is-active' : '' }}"
                        data-publish-service
                        data-number="{{ $service[0] }}"
                    >
                        <span class="bd-publish-service-number">{{ $service[0] }}</span>

                        <span class="bd-publish-service-copy">
                            <strong>{{ $service[1] }}</strong>
                            <small>{{ $service[2] }}</small>
                        </span>

                        <span class="bd-publish-service-progress"></span>
                    </button>
                @endforeach
            </div>

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
                        <span class="bd-publish-action-label">Mulai Penerbitan</span>
                        <span class="bd-publish-action-status"><i></i>Konsultasi tersedia</span>
                    </div>
                </div>

                <h3>Punya naskah yang siap dikembangkan?</h3>

                <p>
                    Ceritakan kebutuhan penerbitan Anda. Tim kami akan membantu menentukan
                    proses yang paling sesuai untuk naskah Anda.
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
                    Respon konsultasi melalui WhatsApp
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bd-activity-section{
    --navy:#21194E;--orange:#EF5843;--yellow:#F7AA35;
    position:relative;width:100%;overflow:hidden;padding:92px 0 82px;background:#F4F1EB;color:#25252D
}
.bd-activity-section *,.bd-publish-section *{box-sizing:border-box}
.bd-activity-section a,.bd-publish-section a{text-decoration:none}
.bd-activity-accent{position:absolute;pointer-events:none}
.bd-activity-accent-left{top:0;left:0;width:420px;height:100%;background:linear-gradient(90deg,rgba(239,88,67,.065),transparent 72%)}
.bd-activity-accent-right{
    right:-180px;bottom:-200px;width:430px;height:430px;border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.065),transparent 70%)
}
.bd-activity-container{position:relative;z-index:2;width:min(calc(100% - 48px),1280px);margin:0 auto}
.bd-activity-header{display:flex;align-items:flex-end;justify-content:space-between;gap:55px}
.bd-activity-heading{max-width:760px}
.bd-activity-eyebrow{
    display:flex;align-items:center;gap:9px;margin-bottom:13px;color:var(--orange);
    font-size:9px;font-weight:850;letter-spacing:.15em;text-transform:uppercase
}
.bd-activity-eyebrow-icon{
    width:30px;height:30px;display:flex;align-items:center;justify-content:center;
    border-radius:9px;background:rgba(239,88,67,.09)
}
.bd-activity-eyebrow-icon svg{width:14px;height:14px}
.bd-activity-heading h2{
    margin:0;color:var(--navy);font-size:clamp(38px,4.5vw,57px);line-height:1.02;
    font-weight:820;letter-spacing:-.052em
}
.bd-activity-heading h2 span{color:var(--orange)}
.bd-activity-heading p{max-width:620px;margin:15px 0 0;color:#777982;font-size:11px;line-height:1.75}
.bd-activity-header-action{display:flex;align-items:center;gap:25px;flex-shrink:0}
.bd-activity-total{display:flex;flex-direction:column;align-items:flex-end;padding-right:23px;border-right:1px solid rgba(33,25,78,.1)}
.bd-activity-total strong{color:var(--orange);font-size:20px;line-height:1;font-weight:900}
.bd-activity-total span{margin-top:4px;color:#99979E;font-size:7px;font-weight:750;text-transform:uppercase}
.bd-activity-all{display:flex;align-items:center;gap:10px;color:var(--navy)!important;font-size:9px;font-weight:850}
.bd-activity-all>span{
    width:32px;height:32px;display:flex;align-items:center;justify-content:center;
    border-radius:50%;background:#fff;border:1px solid rgba(33,25,78,.13);color:var(--orange)
}
.bd-activity-all svg{width:12px;height:12px}
.bd-activity-header-line{position:relative;height:1px;margin:30px 0 26px;background:rgba(33,25,78,.1)}
.bd-activity-header-line span{position:absolute;left:0;top:0;width:84px;height:1px;background:var(--orange)}

.bd-activity-stage{position:relative;width:100%;height:455px;overflow:hidden}
.bd-activity-card{
    position:absolute;top:24px;left:50%;width:320px;height:395px;display:flex;flex-direction:column;padding:0;
    overflow:hidden;border:1px solid rgba(33,25,78,.1);border-radius:24px;background:#fff;color:inherit;
    text-align:left;box-shadow:0 15px 36px rgba(33,25,78,.08);cursor:pointer
}
.bd-activity-card.is-active{border-color:rgba(239,88,67,.18);box-shadow:0 24px 55px rgba(33,25,78,.14)}
.bd-activity-card-media{position:relative;width:100%;height:245px;flex-shrink:0;overflow:hidden;background:#EEECE7}
.bd-activity-card-media>img{width:100%;height:100%;display:block;object-fit:cover}
.bd-activity-card-placeholder{
    width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;
    gap:10px;background:#F0EEE9
}
.bd-info-error-fallback{display:none}
.bd-activity-card-placeholder img{width:58px;height:58px;object-fit:contain;border-radius:10px}
.bd-activity-card-placeholder span{color:#99979F;font-size:8px;font-weight:800;text-transform:uppercase}
.bd-activity-card-number{
    position:absolute;top:14px;left:14px;min-width:41px;height:30px;display:flex;align-items:center;
    justify-content:center;padding:0 9px;border-radius:8px;background:#fff;color:var(--orange);font-size:8px;font-weight:900
}
.bd-activity-card-body{flex:1;display:flex;flex-direction:column;padding:18px}
.bd-activity-card-meta{display:flex;align-items:center;gap:6px;color:#99979F;font-size:6.5px;font-weight:750;text-transform:uppercase}
.bd-activity-card-meta>span{color:var(--orange)}
.bd-activity-card-meta i{width:3px;height:3px;border-radius:50%;background:#CECBD0}
.bd-activity-card-body h3{
    margin:9px 0 0;overflow:hidden;color:var(--navy);font-size:15px;line-height:1.4;font-weight:800;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical
}
.bd-activity-card-bottom{
    display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:14px;
    border-top:1px solid rgba(33,25,78,.08);color:#8A8891;font-size:7.5px;font-weight:800
}
.bd-activity-card-bottom svg{width:12px;height:12px;color:var(--orange)}
.bd-activity-controls{display:flex;align-items:center;justify-content:center;gap:18px;margin-top:3px}
.bd-activity-nav{
    width:43px;height:43px;display:flex;align-items:center;justify-content:center;padding:0;
    border:1px solid rgba(33,25,78,.13);border-radius:12px;background:#fff;color:var(--navy);cursor:pointer
}
.bd-activity-nav-next{color:#fff;background:var(--navy);border-color:var(--navy)}
.bd-activity-nav svg{width:14px;height:14px}
.bd-activity-counter{min-width:65px;display:flex;align-items:baseline;justify-content:center;gap:5px;color:#A4A1A8;font-size:8px;font-weight:800}
.bd-activity-counter strong{color:var(--orange);font-size:17px}

.bd-activity-details{width:min(100%,1080px);margin:38px auto 0}
.bd-activity-detail{
    position:relative;display:grid;grid-template-columns:86px minmax(0,1fr) 230px;gap:28px;
    padding:22px;overflow:hidden;border:1px solid rgba(33,25,78,.09);border-radius:20px;
    background:rgba(255,255,255,.72);box-shadow:0 12px 35px rgba(33,25,78,.045)
}
.bd-activity-detail-index{
    min-height:122px;display:flex;flex-direction:column;align-items:center;justify-content:center;
    gap:5px;border-radius:15px;background:#fff;border:1px solid rgba(33,25,78,.08)
}
.bd-activity-detail-index span{color:var(--orange);font-size:25px;font-weight:900}
.bd-activity-detail-index small{color:#A19EA7;font-size:7px;font-weight:850;text-transform:uppercase}
.bd-activity-detail-main{min-width:0;align-self:center}
.bd-activity-detail-top{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:9px}
.bd-activity-detail-meta{display:flex;align-items:center;gap:7px;color:#99979F;font-size:7.5px;font-weight:800;text-transform:uppercase}
.bd-activity-detail-meta>span{color:var(--orange)}
.bd-activity-detail-meta i{width:3px;height:3px;border-radius:50%;background:#CBC8CF}
.bd-activity-detail-active{
    display:flex;align-items:center;gap:6px;flex-shrink:0;padding:5px 8px;border-radius:999px;
    color:#777380;background:#F4F1EB;font-size:7px;font-weight:800;text-transform:uppercase
}
.bd-activity-detail-active i{width:5px;height:5px;border-radius:50%;background:#22C55E}
.bd-activity-detail-main h3{
    max-width:650px;margin:0;color:var(--navy);font-size:clamp(20px,2vw,28px);line-height:1.15;
    font-weight:820;letter-spacing:-.035em;overflow:hidden;text-overflow:ellipsis;white-space:nowrap
}
.bd-activity-detail-description{
    max-width:690px;margin:10px 0 0;overflow:hidden;color:#777982;font-size:10px;line-height:1.65;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical
}
.bd-activity-detail-action{
    display:flex;flex-direction:column;justify-content:center;padding-left:24px;border-left:1px solid rgba(33,25,78,.08)
}
.bd-activity-detail-action-label{margin-bottom:11px;color:#8E8A96;font-size:8px;font-weight:850;text-transform:uppercase}
.bd-activity-detail-action>a{display:flex;align-items:center;justify-content:space-between;gap:15px;color:var(--navy)!important;font-size:11.5px;font-weight:850}
.bd-activity-detail-arrow{
    width:38px;height:38px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;
    border-radius:50%;color:#fff;background:var(--orange)
}
.bd-activity-detail-arrow svg{width:14px;height:14px}
.bd-activity-footer{
    width:min(100%,1080px);margin:0 auto;display:flex;align-items:center;justify-content:space-between;
    gap:25px;padding-top:18px
}
.bd-activity-footer-note{display:flex;align-items:center;gap:8px;color:#A09EA5;font-size:7px}
.bd-activity-footer-note>span{width:5px;height:5px;border-radius:50%;background:var(--orange)}
.bd-activity-footer a{display:flex;align-items:center;gap:7px;color:var(--orange)!important;font-size:8.5px;font-weight:850}
.bd-activity-footer svg{width:11px;height:11px}

/* CTA */
.bd-publish-section{
    --navy:#21194E;--orange:#EF5843;--yellow:#F7AA35;
    position:relative;padding:0 0 88px;overflow:hidden;background:#F4F1EB
}
.bd-publish-container{width:min(calc(100% - 48px),1280px);margin:0 auto}
.bd-publish-card{
    position:relative;isolation:isolate;display:grid;
    grid-template-columns:minmax(0,1.15fr) minmax(250px,.68fr) minmax(310px,.78fr);
    gap:46px;align-items:center;min-height:420px;padding:52px;overflow:hidden;border-radius:30px;
    background:radial-gradient(circle at 92% 18%,rgba(105,86,178,.16),transparent 28%),linear-gradient(135deg,#21194E,#251D58);
    box-shadow:0 28px 68px rgba(33,25,78,.16)
}
.bd-publish-grid{
    position:absolute;z-index:-4;inset:0;opacity:.05;pointer-events:none;
    background-image:linear-gradient(rgba(255,255,255,.12) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.12) 1px,transparent 1px);
    background-size:54px 54px
}
.bd-publish-glow{position:absolute;z-index:-3;border-radius:50%;pointer-events:none}
.bd-publish-glow-one{width:340px;height:340px;left:-190px;bottom:-235px;background:radial-gradient(circle,rgba(239,88,67,.2),transparent 68%)}
.bd-publish-glow-two{width:370px;height:370px;right:-170px;top:-240px;background:radial-gradient(circle,rgba(247,170,53,.13),transparent 70%)}
.bd-publish-watermark{
    position:absolute;z-index:-1;right:30%;bottom:-50px;color:rgba(255,255,255,.026);
    font-size:190px;line-height:1;font-weight:900;pointer-events:none
}
.bd-publish-copy{position:relative;z-index:2;min-width:0}
.bd-publish-kicker{display:flex;align-items:center;gap:10px;color:var(--yellow);font-size:9px;font-weight:850;text-transform:uppercase}
.bd-publish-kicker-icon{
    width:36px;height:36px;display:flex;align-items:center;justify-content:center;
    border-radius:11px;background:rgba(247,170,53,.09)
}
.bd-publish-kicker-icon svg{width:17px;height:17px}
.bd-publish-copy h2{
    margin:20px 0 0;color:#fff;font-size:clamp(35px,3.4vw,50px);line-height:1.06;
    font-weight:820;letter-spacing:-.052em
}
.bd-publish-title-main,.bd-publish-title-second{display:block}
.bd-publish-title-second{margin-top:4px;color:rgba(255,255,255,.67)}
.bd-publish-copy p{max-width:550px;margin:20px 0 0;color:rgba(255,255,255,.58);font-size:11px;line-height:1.8}
.bd-publish-trust{display:flex;flex-wrap:wrap;gap:10px 17px;margin-top:24px}
.bd-publish-trust-item{display:flex;align-items:center;gap:7px;color:rgba(255,255,255,.48);font-size:8px;font-weight:700}
.bd-publish-trust-item i{width:5px;height:5px;border-radius:50%;background:var(--orange)}

.bd-publish-services{position:relative;z-index:3;border-top:1px solid rgba(255,255,255,.11)}
.bd-publish-service{
    position:relative;width:100%;min-height:76px;display:grid;grid-template-columns:34px minmax(0,1fr);
    gap:13px;align-items:center;padding:0 3px;overflow:hidden;border:0;border-bottom:1px solid rgba(255,255,255,.11);
    background:transparent;text-align:left;cursor:pointer
}
.bd-publish-service-number{color:var(--orange);font-size:9px;font-weight:900}
.bd-publish-service-copy{min-width:0}
.bd-publish-service-copy strong{display:block;color:#fff;font-size:11px;font-weight:820}
.bd-publish-service-copy small{display:block;margin-top:5px;color:rgba(255,255,255,.4);font-size:7.5px;line-height:1.45}
.bd-publish-service-progress{
    position:absolute;left:0;right:0;bottom:-1px;height:2px;
    background:linear-gradient(90deg,var(--orange),var(--yellow));transform:scaleX(0);transform-origin:left;transition:.3s ease
}
.bd-publish-service.is-active .bd-publish-service-progress{transform:scaleX(1)}
.bd-publish-service.is-active .bd-publish-service-number{color:var(--yellow)}

.bd-publish-action{
    position:relative;z-index:3;min-width:0;min-height:300px;display:flex;flex-direction:column;
    justify-content:center;padding:29px;overflow:hidden;border:1px solid rgba(255,255,255,.13);
    border-radius:23px;background:linear-gradient(145deg,rgba(255,255,255,.075),rgba(255,255,255,.035))
}
.bd-publish-action-head{display:flex;align-items:center;gap:12px}
.bd-publish-action-icon{
    width:38px;height:38px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;
    border-radius:11px;color:var(--orange);background:rgba(239,88,67,.1)
}
.bd-publish-action-icon svg{width:17px;height:17px}
.bd-publish-action-head>div{display:flex;flex-direction:column;gap:5px}
.bd-publish-action-label{color:var(--yellow);font-size:8px;font-weight:850;text-transform:uppercase}
.bd-publish-action-status{display:flex;align-items:center;gap:6px;color:rgba(255,255,255,.4);font-size:7px}
.bd-publish-action-status i{width:5px;height:5px;border-radius:50%;background:#4ADE80}
.bd-publish-action h3{margin:22px 0 0;color:#fff;font-size:23px;line-height:1.28;font-weight:820}
.bd-publish-action>p{margin:12px 0 0;color:rgba(255,255,255,.48);font-size:9px;line-height:1.65}
.bd-publish-button{
    width:100%;min-height:52px;display:flex;align-items:center;justify-content:space-between;gap:12px;
    margin-top:23px;padding:0 11px 0 17px;border-radius:13px;background:var(--orange);color:#fff!important;
    font-size:10px;font-weight:850
}
.bd-publish-button-arrow{
    width:32px;height:32px;display:flex;align-items:center;justify-content:center;flex:0 0 auto;
    border-radius:9px;background:rgba(255,255,255,.12)
}
.bd-publish-button-arrow svg{width:13px;height:13px}
.bd-publish-action-footer{margin-top:12px;color:rgba(255,255,255,.3);font-size:7px}

/* MOBILE INFORMATION */
@media(max-width:700px),(hover:none),(pointer:coarse){
    .bd-activity-section{padding:62px 0 58px}
    .bd-activity-container{width:100%;padding:0 16px}
    .bd-activity-header{flex-direction:column;align-items:flex-start;gap:20px}
    .bd-activity-heading h2{font-size:37px}
    .bd-activity-header-action{width:100%;justify-content:space-between}
    .bd-activity-total{align-items:flex-start;padding:0;border:0}

    .bd-activity-showcase{width:calc(100% + 16px);margin-right:-16px}
    .bd-activity-stage{
        height:auto;display:flex;gap:13px;overflow-x:auto;overflow-y:hidden;
        padding:5px 16px 17px 0;scroll-snap-type:x mandatory;scrollbar-width:none;
        -webkit-overflow-scrolling:touch;touch-action:pan-x pan-y
    }
    .bd-activity-stage::-webkit-scrollbar{display:none}
    .bd-activity-card{
        position:relative!important;top:auto!important;left:auto!important;
        flex:0 0 min(82vw,300px);width:min(82vw,300px);height:375px;
        scroll-snap-align:start;scroll-snap-stop:always;
        transform:none!important;opacity:1!important;filter:none!important
    }
    .bd-activity-card-media{height:230px}
    .bd-activity-controls{width:calc(100% - 16px);justify-content:flex-end;margin-top:3px}
    .bd-activity-counter{margin-right:auto;justify-content:flex-start}
    .bd-activity-nav{width:46px;height:46px}

    .bd-activity-details{width:100%;margin-top:25px}
    .bd-activity-detail{grid-template-columns:1fr!important;gap:13px;padding:18px}
    .bd-activity-detail-index{
        width:max-content;min-width:68px;min-height:44px;flex-direction:row;padding:0 11px
    }
    .bd-activity-detail-index span{font-size:18px}
    .bd-activity-detail-top{align-items:flex-start;flex-wrap:wrap;gap:8px}
    .bd-activity-detail-main h3{
        max-width:100%;font-size:21px;line-height:1.2;white-space:normal!important;
        text-overflow:clip;overflow-wrap:anywhere
    }
    .bd-activity-detail-description{max-width:100%;font-size:10px;-webkit-line-clamp:3}
    .bd-activity-detail-action{
        grid-column:auto;width:100%;padding:15px 0 0;border-left:0;border-top:1px solid rgba(33,25,78,.08)
    }
    .bd-activity-detail-action>a{width:100%;max-width:100%;white-space:normal}
    .bd-activity-detail-action>a>span:first-child{min-width:0;white-space:normal;overflow-wrap:anywhere}
    .bd-activity-footer{width:100%;flex-direction:column;align-items:flex-start;gap:11px}
}

/* CTA TABLET */
@media(max-width:1100px){
    .bd-publish-card{grid-template-columns:minmax(0,1fr) minmax(290px,.85fr);gap:36px;padding:44px}
    .bd-publish-copy{grid-column:1}
    .bd-publish-services{grid-column:1}
    .bd-publish-action{grid-column:2;grid-row:1/3}
}

/* CTA TOUCH / MOBILE */
@media(max-width:800px),(hover:none),(pointer:coarse){
    .bd-publish-section{padding-bottom:62px}
    .bd-publish-container{width:100%;padding:0 16px}
    .bd-publish-card{grid-template-columns:1fr;gap:27px;min-height:0;padding:31px 22px;border-radius:23px}
    .bd-publish-copy,.bd-publish-services,.bd-publish-action{grid-column:1;grid-row:auto;min-width:0}
    .bd-publish-copy h2{font-size:34px}
    .bd-publish-title-main{white-space:normal}
    .bd-publish-copy p{font-size:10px}
    .bd-publish-trust{gap:9px 13px;margin-top:20px}
    .bd-publish-services{
        display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;border:0
    }
    .bd-publish-service{
        min-height:108px;display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-start;
        gap:12px;padding:14px;border:1px solid rgba(255,255,255,.1);border-radius:14px;background:rgba(255,255,255,.045)
    }
    .bd-publish-service-progress{left:14px;right:14px}
    .bd-publish-action{min-height:0;padding:23px;border-radius:19px;transform:none!important}
    .bd-publish-action h3{font-size:21px}
    .bd-publish-button{min-height:50px}
    .bd-publish-watermark{display:none}
    .bd-publish-glow{display:none}
}

@media(max-width:390px){
    .bd-activity-heading h2{font-size:34px}
    .bd-publish-card{padding:28px 18px}
    .bd-publish-copy h2{font-size:31px}
    .bd-publish-services{grid-template-columns:1fr}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const section = document.getElementById('baca-informasi');
    const publishSection = document.getElementById('publish-cta');

    if (!section || section.dataset.activityReady === '1') return;
    section.dataset.activityReady = '1';

    const cards = Array.from(section.querySelectorAll('[data-activity-card]'));
    const details = Array.from(section.querySelectorAll('[data-activity-detail]'));
    const stage = section.querySelector('#bdActivityStage');
    const prev = section.querySelector('#bdActivityPrev');
    const next = section.querySelector('#bdActivityNext');
    const counter = section.querySelector('#bdActivityCurrent');

    const gsap = window.bdGsap || null;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
    const touchLike =
        window.matchMedia('(pointer:coarse)').matches ||
        window.matchMedia('(hover:none)').matches ||
        navigator.maxTouchPoints > 0;

    let activeIndex = 0;
    let changing = false;
    let mobileTimer = null;

    function isMobileMode() {
        return touchLike || window.innerWidth <= 700;
    }

    function updateDetail(previousIndex) {
        const oldDetail = details[previousIndex];
        const newDetail = details[activeIndex];

        if (!newDetail) return;

        if (!gsap || reduceMotion || isMobileMode() || !oldDetail || oldDetail === newDetail) {
            details.forEach((detail, index) => {
                detail.style.display = index === activeIndex ? 'grid' : 'none';
                detail.classList.toggle('is-active', index === activeIndex);
            });
            return;
        }

        gsap.to(oldDetail, {
            autoAlpha: 0,
            y: -6,
            duration: .16,
            onComplete() {
                oldDetail.style.display = 'none';
                newDetail.style.display = 'grid';

                gsap.fromTo(
                    newDetail,
                    { autoAlpha: 0, y: 8 },
                    { autoAlpha: 1, y: 0, duration: .3, ease: 'power3.out' }
                );
            }
        });
    }

    function renderDesktop(animate = true) {
        if (isMobileMode()) {
            cards.forEach((card, index) => {
                if (gsap) {
                    gsap.killTweensOf(card);
                    gsap.set(card, {
                        clearProps: 'transform,x,xPercent,scale,opacity,filter,zIndex,pointerEvents'
                    });
                }

                card.classList.toggle('is-active', index === activeIndex);
            });

            return;
        }

        const width = window.innerWidth;
        const offset = width <= 1100 ? 260 : 295;
        const total = cards.length;

        cards.forEach((card, index) => {
            let relative = index - activeIndex;

            if (relative > total / 2) relative -= total;
            if (relative < -(total / 2)) relative += total;

            let x = 0;
            let scale = 1;
            let opacity = 1;
            let grayscale = 0;
            let zIndex = 6;

            if (relative === 1) {
                x = offset; scale = .86; opacity = .88; grayscale = .72; zIndex = 5;
            } else if (relative === -1) {
                x = -offset; scale = .86; opacity = .88; grayscale = .72; zIndex = 5;
            } else if (relative === 2) {
                x = offset * 1.68; scale = .7; opacity = .35; grayscale = 1; zIndex = 3;
            } else if (relative === -2) {
                x = -offset * 1.68; scale = .7; opacity = .35; grayscale = 1; zIndex = 3;
            } else if (relative !== 0) {
                x = relative > 0 ? offset * 2 : -offset * 2;
                scale = .62; opacity = 0; grayscale = 1; zIndex = 1;
            }

            card.classList.toggle('is-active', index === activeIndex);

            if (gsap && animate) {
                gsap.to(card, {
                    x,
                    xPercent: -50,
                    scale,
                    opacity,
                    filter: `grayscale(${grayscale})`,
                    zIndex,
                    duration: .5,
                    ease: 'power3.inOut',
                    overwrite: true
                });
            } else {
                card.style.transform = `translateX(-50%) translateX(${x}px) scale(${scale})`;
                card.style.opacity = opacity;
                card.style.filter = `grayscale(${grayscale})`;
                card.style.zIndex = zIndex;
            }
        });
    }

    function setActive(index, scrollMobile = true) {
        if (!cards[index] || index === activeIndex || changing) return;

        changing = true;

        const previousIndex = activeIndex;
        activeIndex = index;

        if (counter) counter.textContent = String(activeIndex + 1).padStart(2, '0');

        renderDesktop(true);
        updateDetail(previousIndex);

        if (isMobileMode() && scrollMobile) {
            cards[index].scrollIntoView({
                behavior: reduceMotion ? 'auto' : 'smooth',
                block: 'nearest',
                inline: 'start'
            });
        }

        setTimeout(() => changing = false, isMobileMode() ? 320 : 520);
    }

    cards.forEach((card, index) => {
        card.addEventListener('click', function () {
            if (index === activeIndex) {
                const link = details[activeIndex]?.querySelector('a');
                if (link) window.location.href = link.href;
                return;
            }

            setActive(index);
        });
    });

    prev?.addEventListener('click', function () {
        let index = activeIndex - 1;
        if (index < 0) index = cards.length - 1;
        setActive(index);
    });

    next?.addEventListener('click', function () {
        let index = activeIndex + 1;
        if (index >= cards.length) index = 0;
        setActive(index);
    });

    stage?.addEventListener('scroll', function () {
        if (!isMobileMode()) return;

        clearTimeout(mobileTimer);

        mobileTimer = setTimeout(function () {
            const stageRect = stage.getBoundingClientRect();
            let nearest = activeIndex;
            let distance = Infinity;

            cards.forEach((card, index) => {
                const rect = card.getBoundingClientRect();
                const currentDistance = Math.abs(rect.left - stageRect.left);

                if (currentDistance < distance) {
                    distance = currentDistance;
                    nearest = index;
                }
            });

            if (nearest !== activeIndex) {
                const previousIndex = activeIndex;
                activeIndex = nearest;

                cards.forEach((card, index) => {
                    card.classList.toggle('is-active', index === activeIndex);
                });

                if (counter) {
                    counter.textContent = String(activeIndex + 1).padStart(2, '0');
                }

                updateDetail(previousIndex);
            }
        }, 90);
    }, { passive: true });

    window.addEventListener('resize', function () {
        renderDesktop(false);
    }, { passive: true });

    /* CTA service selector */
    if (publishSection) {
        const services = Array.from(publishSection.querySelectorAll('[data-publish-service]'));
        const watermark = publishSection.querySelector('#bdPublishWatermark');

        function activateService(index) {
            services.forEach((service, i) => {
                service.classList.toggle('is-active', i === index);
            });

            if (watermark) {
                watermark.textContent = services[index]?.dataset.number || '01';
            }
        }

        services.forEach((service, index) => {
            service.addEventListener('click', () => activateService(index));

            if (!touchLike) {
                service.addEventListener('mouseenter', () => activateService(index));
            }
        });
    }

    renderDesktop(false);
});
</script>