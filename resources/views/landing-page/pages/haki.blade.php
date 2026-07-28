@extends('layouts.app') {{-- Sesuaikan dengan layout utama kamu yang aktif saat ini --}}

@section('content')
<div class="container py-5 hki-page">

    <!-- Header Section dengan Animasi Masuk -->
    <div class="text-center mb-5 hki-fade-header">
        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">Layanan Resmi HAKI</span>
        <h1 class="fw-bold display-5 mt-3 text-dark">Pendaftaran HAKI Buku &amp; Jurnal</h1>
        <p class="text-muted lead mx-auto" style="max-width:640px;">
            Dari naskah buku ajar sampai jurnal ilmiah, satu atap untuk melindungi hak cipta karya tulis Anda secara sah dan profesional berdasarkan <span class="fw-semibold text-dark">UU No. 28 Tahun 2014</span>.
        </p>
    </div>

    <!-- Bagian Edukasi & Pecahan Hak Cipta (Penambahan Konten Edukatif) -->
    <div class="row g-4 mb-5">
        <!-- 1. Hak Cipta & Pecahan Hak -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100 hki-info-card">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center mb-3">
                        <div class="fs-3 me-3 p-2 bg-primary bg-opacity-10 rounded-3 text-primary">⚖️</div>
                        <h4 class="fw-bold text-dark mb-0">Pecahan Hak Cipta dalam Buku & Jurnal</h4>
                    </div>
                    <p class="text-muted small mb-3">Berdasarkan regulasi hak cipta, perlindungan hukum terbagi menjadi dua aspek utama yang melindungi pencipta:</p>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold text-dark mb-1">📌 Hak Moral</h6>
                        <p class="text-muted small mb-2">Hak yang melekat abadi pada diri penulis atau pencipta. Menjamin nama penulis tetap dicantumkan meskipun naskah telah dilisensikan atau diterbitkan.</p>
                    </div>

                    <div>
                        <h6 class="fw-bold text-dark mb-1">💰 Hak Ekonomi</h6>
                        <p class="text-muted small mb-1">Hak eksklusif untuk mendapatkan manfaat finansial, yang mencakup:</p>
                        <ul class="text-muted small ps-3 mb-0">
                            <li><strong class="text-dark">Hak Penerbitan:</strong> Memproduksi karya dalam bentuk cetakan.</li>
                            <li><strong class="text-dark">Hak Penggandaan:</strong> Memperbanyak naskah/buku/artikel.</li>
                            <li><strong class="text-dark">Hak Pendistribusian & Penerjemahan:</strong> Menjual, mengedarkan, atau menerjemahkan karya.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Legalitas Penunjang Lainnya -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100 hki-info-card">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center mb-3">
                        <div class="fs-3 me-3 p-2 bg-success bg-opacity-10 rounded-3 text-success">🛡️</div>
                        <h4 class="fw-bold text-dark mb-0">Legalitas Penunjang HAKI</h4>
                    </div>
                    <p class="text-muted small mb-3">Selain hak cipta utama, elemen legalitas berikut krusial untuk penguatan publikasi:</p>
                    
                    <div class="space-y-3">
                        <div class="mb-2">
                            <h6 class="fw-bold text-dark mb-1">📖 Perwajahan Karya Tulis (Tipografi)</h6>
                            <p class="text-muted small mb-0">Tata letak dan desain isi halaman buku/jurnal turut dilindungi sebagai objek Hak Cipta.</p>
                        </div>
                        <div class="mb-2">
                            <h6 class="fw-bold text-dark mb-1">🔢 ISBN / e-ISSN</h6>
                            <p class="text-muted small mb-0">Identitas resmi dari Perpusnas agar karya mudah dilacak dan diedarkan secara sah.</p>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">🏷️ Hak Merek (Trademark)</h6>
                            <p class="text-muted small mb-0">Melindungi logo dan nama badan usaha penerbit di DJKI dari tiruan pihak lain.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Apa saja yang dilindungi (Ringkasan Icon Cards) -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="p-4 h-100 rounded-4 bg-light border border-gray-100 hki-feature-box">
                <div class="fs-3 mb-2 animate-bounce-short">©️</div>
                <h6 class="fw-bold text-dark mb-1">Hak Cipta</h6>
                <p class="text-muted small mb-0">Hak moral (nama penulis melekat selamanya) dan hak ekonomi (cetak, gandakan, distribusikan, terjemahkan).</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 h-100 rounded-4 bg-light border border-gray-100 hki-feature-box">
                <div class="fs-3 mb-2 animate-bounce-short">🔢</div>
                <h6 class="fw-bold text-dark mb-1">ISBN / e-ISSN</h6>
                <p class="text-muted small mb-0">Nomor identitas resmi dari Perpusnas agar buku atau jurnal mudah dilacak dan diedarkan secara legal.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 h-100 rounded-4 bg-light border border-gray-100 hki-feature-box">
                <div class="fs-3 mb-2 animate-bounce-short">🏷️</div>
                <h6 class="fw-bold text-dark mb-1">Hak Merek</h6>
                <p class="text-muted small mb-0">Perlindungan nama dan logo penerbit di DJKI agar tidak ditiru pihak lain.</p>
            </div>
        </div>
    </div>

    <!-- Pilih Jenis Karya -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-secondary mb-1">Pilih Jenis Karya Anda</h2>
        <p class="text-muted small mb-0">Ketuk salah satu kartu untuk melanjutkan ke konsultasi.</p>
    </div>

    <div class="row g-4 mb-3">
        <div class="col-md-6 col-lg-4">
            <div class="hki-pick card h-100 border-0 shadow-sm p-4" data-label="Buku Ajar / Buku Teks" data-slug="buku-ajar">
                <span class="hki-check">✓</span>
                <div class="card-body p-0">
                    <div class="mb-3 text-primary fs-2">📖</div>
                    <h5 class="fw-bold text-dark">Buku Ajar / Buku Teks</h5>
                    <p class="text-muted small mt-2 mb-0">Panduan belajar-mengajar di sekolah atau perguruan tinggi, disusun sesuai kurikulum dan RPS.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="hki-pick card h-100 border-0 shadow-sm p-4" data-label="Buku Referensi" data-slug="buku-referensi">
                <span class="hki-check">✓</span>
                <div class="card-body p-0">
                    <div class="mb-3 text-success fs-2">📚</div>
                    <h5 class="fw-bold text-dark">Buku Referensi</h5>
                    <p class="text-muted small mt-2 mb-0">Kajian ilmiah komprehensif atas suatu bidang ilmu yang menjadi rujukan para peneliti.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="hki-pick card h-100 border-0 shadow-sm p-4" data-label="Monograf" data-slug="monograf">
                <span class="hki-check">✓</span>
                <div class="card-body p-0">
                    <div class="mb-3 text-warning fs-2">📑</div>
                    <h5 class="fw-bold text-dark">Monograf</h5>
                    <p class="text-muted small mt-2 mb-0">Karya hasil penelitian satu topik spesifik, ditulis oleh satu orang atau satu tim peneliti.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="hki-pick card h-100 border-0 shadow-sm p-4" data-label="Book Chapter (Bunga Rampai)" data-slug="book-chapter">
                <span class="hki-check">✓</span>
                <div class="card-body p-0">
                    <div class="mb-3 fs-2" style="color:#8B5CF6;">🧩</div>
                    <h5 class="fw-bold text-dark">Book Chapter (Bunga Rampai)</h5>
                    <p class="text-muted small mt-2 mb-0">Kumpulan artikel ilmiah satu tema besar, ditulis banyak penulis berbeda lalu dibukukan.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="hki-pick card h-100 border-0 shadow-sm p-4" data-label="Modul / Panduan Praktikum" data-slug="modul-praktikum">
                <span class="hki-check">✓</span>
                <div class="card-body p-0">
                    <div class="mb-3 fs-2" style="color:#0EA5E9;">🧪</div>
                    <h5 class="fw-bold text-dark">Modul / Panduan Praktikum</h5>
                    <p class="text-muted small mt-2 mb-0">Panduan teknis pembelajaran atau kerja lapangan, langkah demi langkah.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="hki-pick card h-100 border-0 shadow-sm p-4" data-label="Buku Fiksi & Non-Fiksi Umum" data-slug="fiksi-nonfiksi">
                <span class="hki-check">✓</span>
                <div class="card-body p-0">
                    <div class="mb-3 fs-2" style="color:#EC4899;">🖋️</div>
                    <h5 class="fw-bold text-dark">Buku Fiksi &amp; Non-Fiksi Umum</h5>
                    <p class="text-muted small mt-2 mb-0">Novel, kumpulan puisi, biografi, antologi esai, hingga komik.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jurnal: satu paket untuk semua bidang -->
    <div class="hki-pick hki-pick-journal card border-0 shadow-sm p-4 mb-5" data-label="Jurnal Ilmiah" data-slug="jurnal">
        <span class="hki-check">✓</span>
        <div class="card-body p-0 d-flex flex-column flex-md-row align-items-md-center gap-3">
            <div class="fs-1">📰</div>
            <div class="flex-grow-1">
                <h5 class="fw-bold text-dark mb-1">Jurnal Ilmiah</h5>
                <p class="text-muted small mb-0">Satu layanan pendaftaran untuk semua bidang ilmu &mdash; tidak perlu bingung pilih kategori, cukup satu jalur untuk artikel jurnal Anda.</p>
            </div>
        </div>
    </div>

    <!-- Keuntungan HKI -->
    <div class="bg-light rounded-4 p-5 mb-5 shadow-sm border border-gray-100 hki-info-card">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3 class="fw-bold mb-3 text-dark">Kenapa Dosen &amp; Peneliti Wajib Daftarkan HKI?</h3>
                <p class="text-muted mb-0">
                    Pendaftaran HAKI untuk buku maupun jurnal memberikan poin penting untuk pemenuhan BKD (Beban Kerja Dosen), kenaikan jabatan fungsional (Lektor, Lektor Kepala, Guru Besar), serta akreditasi institusi.
                </p>
            </div>
            <div class="col-lg-6">
                <ul class="list-unstyled mb-0 space-y-2">
                    <li class="d-flex align-items-start mb-2">
                        <span class="badge bg-success me-2 p-2">✓</span> <span>Legalitas resmi dan perlindungan hak cipta dari negara.</span>
                    </li>
                    <li class="d-flex align-items-start mb-2">
                        <span class="badge bg-success me-2 p-2">✓</span> <span>Menunjang portofolio akademik dan poin kum dosen.</span>
                    </li>
                    <li class="d-flex align-items-start mb-2">
                        <span class="badge bg-success me-2 p-2">✓</span> <span>Proses pengurusan cepat, transparan, dibantu sampai terbit.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CTA Umum -->
    <div class="bg-primary text-white rounded-4 p-5 text-center shadow hki-cta-box">
        <h3 class="fw-bold mb-3">Punya Naskah Buku atau Jurnal Siap HKI?</h3>
        <p class="mb-4 text-white-50">Konsultasikan naskah Anda bersama tim kami sekarang juga.</p>
        <a href="https://wa.me/6281315717719" target="_blank" class="btn btn-light btn-lg fw-bold text-primary px-4 shadow-sm hover-scale">Konsultasi via WhatsApp</a>
    </div>

</div>

<!-- Bar konsultasi dinamis, muncul setelah kategori dipilih -->
<div id="pilihan-bar" class="hki-bar">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
        <div>
            <div class="small text-white-50">Kategori dipilih</div>
            <div class="fw-bold" id="pilihan-label">-</div>
        </div>
        <a id="pilihan-wa" href="https://wa.me/6281315717719" target="_blank" class="btn btn-light fw-bold text-dark px-4 hover-scale">
            Lanjut Konsultasi &rarr;
        </a>
    </div>
</div>

<style>
    /* Animasi Tambahan dan Peningkatan Visual */
    .hki-fade-header {
        opacity: 0;
        transform: translateY(-20px);
        animation: hkiFadeDown .6s ease forwards;
    }

    .hki-info-card, .hki-feature-box, .hki-cta-box {
        opacity: 0;
        transform: translateY(20px);
        animation: hkiFadeUp .6s ease forwards;
        animation-delay: .15s;
    }

    .hki-page .hki-pick {
        position: relative;
        cursor: pointer;
        transition: transform .3s cubic-bezier(.25, 1, .5, 1), box-shadow .3s ease, border-color .3s ease;
        border: 2px solid transparent !important;
        opacity: 0;
        animation: hkiFadeUp .5s ease forwards;
    }

    /* Delay animasi bertahap untuk card pilihan */
    .hki-page .row .col-md-6:nth-child(1) .hki-pick { animation-delay: .2s; }
    .hki-page .row .col-md-6:nth-child(2) .hki-pick { animation-delay: .25s; }
    .hki-page .row .col-md-6:nth-child(3) .hki-pick { animation-delay: .3s; }
    .hki-page .row .col-md-6:nth-child(4) .hki-pick { animation-delay: .35s; }
    .hki-page .row .col-md-6:nth-child(5) .hki-pick { animation-delay: .4s; }
    .hki-page .row .col-md-6:nth-child(6) .hki-pick { animation-delay: .45s; }
    .hki-page .hki-pick-journal { animation-delay: .5s; }

    .hki-page .hki-pick:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0,0,0,.1) !important;
    }

    .hki-feature-box {
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .hki-feature-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,.06) !important;
    }

    .hki-page .hki-pick.is-selected {
        border-color: #4F46E5 !important;
        box-shadow: 0 12px 28px rgba(79,70,229,.18) !important;
        transform: translateY(-6px) scale(1.01);
    }

    .hki-page .hki-pick .hki-check {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #4F46E5;
        color: #fff;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(.4);
        transition: opacity .2s ease, transform .2s ease;
    }

    .hki-page .hki-pick.is-selected .hki-check {
        opacity: 1;
        transform: scale(1);
        animation: hkiPop .3s ease;
    }

    .hki-bar {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        background: #111827;
        color: #fff;
        transform: translateY(100%);
        transition: transform .35s cubic-bezier(.22,1,.36,1);
        z-index: 1050;
        box-shadow: 0 -8px 24px rgba(0,0,0,.15);
    }

    .hki-bar.show {
        transform: translateY(0);
    }

    .hover-scale {
        transition: transform .2s ease;
    }
    .hover-scale:hover {
        transform: scale(1.03);
    }

    /* Keyframe Animasi */
    @keyframes hkiFadeDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes hkiFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes hkiPop {
        0% { transform: scale(.4); }
        60% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }

    @media (prefers-reduced-motion: reduce) {
        .hki-page .hki-pick, .hki-fade-header, .hki-info-card, .hki-feature-box, .hki-cta-box { 
            animation: none !important; 
            opacity: 1 !important; 
            transform: none !important;
        }
        .hki-page .hki-pick, .hki-bar, .hover-scale { transition: none !important; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var cards = document.querySelectorAll('.hki-pick');
        var bar = document.getElementById('pilihan-bar');
        var label = document.getElementById('pilihan-label');
        var waBtn = document.getElementById('pilihan-wa');
        var waNumber = '6281315717719';

        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                var already = card.classList.contains('is-selected');

                cards.forEach(function (c) { c.classList.remove('is-selected'); });

                if (already) {
                    bar.classList.remove('show');
                    return;
                }

                card.classList.add('is-selected');
                var text = card.getAttribute('data-label');
                label.textContent = text;

                var message = encodeURIComponent('Halo, saya ingin konsultasi pendaftaran HKI untuk ' + text + '.');
                waBtn.setAttribute('href', 'https://wa.me/' + waNumber + '?text=' + message);

                bar.classList.add('show');
            });
        });
    });
</script>
@endsection