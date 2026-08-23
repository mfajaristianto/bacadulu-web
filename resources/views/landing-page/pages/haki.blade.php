@extends('layouts.app')

@section('content')

{{-- ================= HERO / HEADER ================= --}}
<section class="scroll-mt-20 relative py-24 w-full overflow-hidden bg-gradient-to-b from-white to-orange-50/40">

    <div class="absolute top-0 -left-20 w-72 h-72 bg-orange-300/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 -right-20 w-96 h-96 bg-orange-200/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-6xl mx-auto px-6">

        <div class="text-center mb-16 fade-in-card">
            <span class="inline-block text-orange-600 text-xs font-bold uppercase tracking-widest mb-3">
                Layanan Resmi HAKI
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
                Pendaftaran HAKI <span class="text-orange-600">Buku & Jurnal</span>
            </h1>
            <div class="w-16 h-1 bg-orange-500 mx-auto rounded-full mb-4"></div>
            <p class="text-slate-500 max-w-2xl mx-auto">
                Dari naskah buku ajar sampai jurnal ilmiah, satu atap untuk melindungi hak cipta karya tulis Anda secara sah dan profesional berdasarkan
                <span class="font-semibold text-slate-800">UU No. 28 Tahun 2014</span>.
            </p>
        </div>

        {{-- ===== EDUKASI HAK CIPTA ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">

            <div class="lg:col-span-7 fade-in-card">
                <div class="h-full bg-white/70 backdrop-blur-xl rounded-2xl border border-white/60 shadow-lg shadow-orange-900/5 p-6 md:p-8 hover:shadow-xl hover:shadow-orange-900/10 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-11 h-11 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18L7 8m5-5l5 5M3 8l4-3 4 3-4 8-4-8zm10 0l4-3 4 3-4 8-4-8z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Pecahan Hak Cipta dalam Buku & Jurnal</h4>
                    </div>
                    <p class="text-slate-500 text-sm mb-4">Berdasarkan regulasi hak cipta, perlindungan hukum terbagi menjadi dua aspek utama yang melindungi pencipta:</p>

                    <div class="mb-4">
                        <h6 class="font-bold text-slate-800 text-sm mb-1">Hak Moral</h6>
                        <p class="text-slate-500 text-sm">Hak yang melekat abadi pada diri penulis atau pencipta. Menjamin nama penulis tetap dicantumkan meskipun naskah telah dilisensikan atau diterbitkan.</p>
                    </div>

                    <div>
                        <h6 class="font-bold text-slate-800 text-sm mb-1">Hak Ekonomi</h6>
                        <p class="text-slate-500 text-sm mb-2">Hak eksklusif untuk mendapatkan manfaat finansial, yang mencakup:</p>
                        <ul class="text-slate-500 text-sm space-y-1 list-disc list-inside">
                            <li><span class="font-semibold text-slate-700">Hak Penerbitan:</span> Memproduksi karya dalam bentuk cetakan.</li>
                            <li><span class="font-semibold text-slate-700">Hak Penggandaan:</span> Memperbanyak naskah/buku/artikel.</li>
                            <li><span class="font-semibold text-slate-700">Hak Pendistribusian & Penerjemahan:</span> Menjual, mengedarkan, atau menerjemahkan karya.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 fade-in-card">
                <div class="h-full bg-white/70 backdrop-blur-xl rounded-2xl border border-white/60 shadow-lg shadow-orange-900/5 p-6 md:p-8 hover:shadow-xl hover:shadow-orange-900/10 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-11 h-11 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Legalitas Penunjang HAKI</h4>
                    </div>
                    <p class="text-slate-500 text-sm mb-4">Selain hak cipta utama, elemen legalitas berikut krusial untuk penguatan publikasi:</p>

                    <div class="space-y-4">
                        <div>
                            <h6 class="font-bold text-slate-800 text-sm mb-1">Perwajahan Karya Tulis (Tipografi)</h6>
                            <p class="text-slate-500 text-sm">Tata letak dan desain isi halaman buku/jurnal turut dilindungi sebagai objek Hak Cipta.</p>
                        </div>
                        <div>
                            <h6 class="font-bold text-slate-800 text-sm mb-1">ISBN / e-ISSN</h6>
                            <p class="text-slate-500 text-sm">Identitas resmi dari Perpusnas agar karya mudah dilacak dan diedarkan secara sah.</p>
                        </div>
                        <div>
                            <h6 class="font-bold text-slate-800 text-sm mb-1">Hak Merek (Trademark)</h6>
                            <p class="text-slate-500 text-sm">Melindungi logo dan nama badan usaha penerbit di DJKI dari tiruan pihak lain.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== RINGKASAN ICON CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-20">
            @php
            $ringkasan = [
                ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'judul' => 'Hak Cipta', 'desc' => 'Hak moral (nama penulis melekat selamanya) dan hak ekonomi (cetak, gandakan, distribusikan, terjemahkan).'],
                ['icon' => 'M7 7h10M7 11h10M7 15h6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z', 'judul' => 'ISBN / e-ISSN', 'desc' => 'Nomor identitas resmi dari Perpusnas agar buku atau jurnal mudah dilacak dan diedarkan secara legal.'],
                ['icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5.586 5.586a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z', 'judul' => 'Hak Merek', 'desc' => 'Perlindungan nama dan logo penerbit di DJKI agar tidak ditiru pihak lain.'],
            ];
            @endphp
            @foreach($ringkasan as $r)
            <div class="fade-in-card bg-white/60 backdrop-blur-lg rounded-2xl border border-orange-100 p-6 text-center shadow-md shadow-orange-900/5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-orange-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $r['icon'] }}" />
                    </svg>
                </div>
                <h6 class="font-bold text-slate-900 mb-2">{{ $r['judul'] }}</h6>
                <p class="text-slate-500 text-sm">{{ $r['desc'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- ===== PILIH JENIS KARYA ===== --}}
        <div class="text-center mb-10 fade-in-card">
            <span class="inline-block text-orange-600 text-xs font-bold uppercase tracking-widest mb-3">
                Mulai Konsultasi
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Pilih Jenis Karya Anda</h2>
            <p class="text-slate-500 text-sm">Ketuk salah satu kartu untuk melanjutkan ke konsultasi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @php
            $jenisKarya = [
                ['label' => 'Buku Ajar / Buku Teks', 'slug' => 'buku-ajar', 'desc' => 'Panduan belajar-mengajar di sekolah atau perguruan tinggi, disusun sesuai kurikulum dan RPS.'],
                ['label' => 'Buku Referensi', 'slug' => 'buku-referensi', 'desc' => 'Kajian ilmiah komprehensif atas suatu bidang ilmu yang menjadi rujukan para peneliti.'],
                ['label' => 'Monograf', 'slug' => 'monograf', 'desc' => 'Karya hasil penelitian satu topik spesifik, ditulis oleh satu orang atau satu tim peneliti.'],
                ['label' => 'Book Chapter (Bunga Rampai)', 'slug' => 'book-chapter', 'desc' => 'Kumpulan artikel ilmiah satu tema besar, ditulis banyak penulis berbeda lalu dibukukan.'],
                ['label' => 'Modul / Panduan Praktikum', 'slug' => 'modul-praktikum', 'desc' => 'Panduan teknis pembelajaran atau kerja lapangan, langkah demi langkah.'],
                ['label' => 'Buku Fiksi & Non-Fiksi Umum', 'slug' => 'fiksi-nonfiksi', 'desc' => 'Novel, kumpulan puisi, biografi, antologi esai, hingga komik.'],
            ];
            @endphp

            @foreach($jenisKarya as $jk)
            <div class="hki-pick fade-in-card relative bg-white/70 backdrop-blur-xl rounded-2xl border-2 border-white/60 shadow-lg shadow-orange-900/5 p-6 cursor-pointer transition-all duration-300 hover:shadow-2xl hover:shadow-orange-900/10 hover:-translate-y-1"
                 data-label="{{ $jk['label'] }}" data-slug="{{ $jk['slug'] }}">
                <span class="hki-check absolute top-4 right-4 w-7 h-7 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center opacity-0 scale-50 transition-all duration-200">
                    ✓
                </span>
                <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h5 class="font-bold text-slate-900 mb-2">{{ $jk['label'] }}</h5>
                <p class="text-slate-500 text-sm">{{ $jk['desc'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- ===== JURNAL: SATU PAKET UNTUK SEMUA BIDANG ===== --}}
        <div class="hki-pick hki-pick-journal fade-in-card relative bg-white/70 backdrop-blur-xl rounded-2xl border-2 border-white/60 shadow-lg shadow-orange-900/5 p-6 md:p-8 cursor-pointer transition-all duration-300 hover:shadow-2xl hover:shadow-orange-900/10 mb-20"
             data-label="Jurnal Ilmiah" data-slug="jurnal">
            <span class="hki-check absolute top-4 right-4 w-7 h-7 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center opacity-0 scale-50 transition-all duration-200">
                ✓
            </span>
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-1">Jurnal Ilmiah</h5>
                    <p class="text-slate-500 text-sm">Satu layanan pendaftaran untuk semua bidang ilmu — tidak perlu bingung pilih kategori, cukup satu jalur untuk artikel jurnal Anda.</p>
                </div>
            </div>
        </div>

        {{-- ===== KENAPA WAJIB DAFTAR HKI ===== --}}
        <div class="fade-in-card bg-white/70 backdrop-blur-xl rounded-3xl border border-white/60 shadow-lg shadow-orange-900/5 p-8 md:p-12 mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">
                        Kenapa Dosen & Peneliti Wajib Daftarkan HAKI?
                    </h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Pendaftaran HAKI untuk buku maupun jurnal memberikan poin penting untuk pemenuhan BKD (Beban Kerja Dosen), kenaikan jabatan fungsional (Lektor, Lektor Kepala, Guru Besar), serta akreditasi institusi.
                    </p>
                </div>
                <div class="space-y-4">
                    @php
                    $keuntungan = [
                        'Legalitas resmi dan perlindungan hak cipta dari negara.',
                        'Menunjang portofolio akademik dan poin kum dosen.',
                        'Proses pengurusan cepat, transparan, dibantu sampai terbit.',
                    ];
                    @endphp
                    @foreach($keuntungan as $k)
                    <div class="flex items-start gap-3">
                        <span class="w-7 h-7 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">✓</span>
                        <p class="text-slate-600 text-sm">{{ $k }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===== CTA WHATSAPP ===== --}}
        <div class="fade-in-card relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700 p-10 md:p-14 text-center shadow-xl shadow-orange-900/20">
            <div class="absolute top-0 -left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 -right-10 w-72 h-72 bg-orange-900/20 rounded-full blur-3xl"></div>

            <div class="relative">
                <h3 class="text-2xl md:text-3xl font-extrabold text-white mb-3">Punya Naskah Buku atau Jurnal Siap HAKI?</h3>
                <p class="text-orange-50 mb-8 max-w-xl mx-auto">Konsultasikan naskah Anda bersama tim kami sekarang juga.</p>
                <a href="https://wa.me/6285139461070" target="_blank"
                   class="inline-flex items-center gap-3 bg-white hover:bg-orange-50 text-orange-600 px-8 py-3.5 rounded-full font-bold transition-all shadow-md hover:-translate-y-0.5">
                    Konsultasi via WhatsApp
                </a>
            </div>
        </div>

    </div>
</section>

{{-- ===== FLOATING BAR: KATEGORI DIPILIH ===== --}}
<div id="pilihan-bar" class="hki-bar fixed left-0 right-0 bottom-0 z-50 bg-slate-900/95 backdrop-blur-xl border-t border-white/10 shadow-2xl">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between flex-wrap gap-3">
        <div>
            <div class="text-xs text-orange-300 font-semibold uppercase tracking-wide">Kategori Dipilih</div>
            <div class="text-white font-bold" id="pilihan-label">-</div>
        </div>
        <a id="pilihan-wa" href="https://wa.me/6285139461070" target="_blank"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold px-5 py-3 rounded-full transition-all shadow-md hover:-translate-y-0.5">
            Lanjut Konsultasi
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>

<style>
    .fade-in-card {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .hki-pick.is-selected {
        border-color: #f97316 !important;
        box-shadow: 0 16px 32px rgba(249, 115, 22, .18) !important;
        transform: translateY(-4px);
    }

    .hki-pick.is-selected .hki-check {
        opacity: 1;
        transform: scale(1);
    }

    .hki-bar {
        transform: translateY(100%);
        transition: transform .35s cubic-bezier(.22,1,.36,1);
    }

    .hki-bar.show {
        transform: translateY(0);
    }
</style>

<script>
    (function () {
        function initHaki() {
            // Fade-in animation
            var cards = document.querySelectorAll('.fade-in-card');
            if ('IntersectionObserver' in window) {
                var cardObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry, index) {
                        if (entry.isIntersecting) {
                            setTimeout(function () {
                                entry.target.classList.add('visible');
                            }, index * 60);
                            cardObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                cards.forEach(function (card) { cardObserver.observe(card); });
            } else {
                cards.forEach(function (card) { card.classList.add('visible'); });
            }

            // Pilih kategori HKI
            var pickCards = document.querySelectorAll('.hki-pick');
            var bar = document.getElementById('pilihan-bar');
            var label = document.getElementById('pilihan-label');
            var waBtn = document.getElementById('pilihan-wa');
            var waNumber = '6281315717719';

            if (!bar || !label || !waBtn) {
                console.warn('HAKI: elemen #pilihan-bar / #pilihan-label / #pilihan-wa tidak ditemukan.');
                return;
            }

            pickCards.forEach(function (card) {
                card.addEventListener('click', function () {
                    var already = card.classList.contains('is-selected');

                    pickCards.forEach(function (c) { c.classList.remove('is-selected'); });

                    if (already) {
                        bar.classList.remove('show');
                        return;
                    }

                    card.classList.add('is-selected');
                    var text = card.getAttribute('data-label');
                    label.textContent = text;

                    var message = encodeURIComponent('Halo, saya ingin konsultasi pendaftaran HAKI untuk ' + text + '.');
                    waBtn.setAttribute('href', 'https://wa.me/' + waNumber + '?text=' + message);

                    bar.classList.add('show');
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHaki);
        } else {
            initHaki();
        }
    })();
</script>

@endsection