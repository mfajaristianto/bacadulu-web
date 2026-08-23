@php
$artikel=\App\Models\Information::query()->latest()->take(5)->get();
@endphp

<section id="baca-informasi" class="relative py-20 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-10" data-bd-reveal="up">
            <div>
                <div class="flex items-center gap-2 text-orange-600">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5"/>
                    </svg>
                    <span class="text-xs font-bold tracking-widest uppercase">Informasi Terbaru</span>
                </div>

                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Baca Informasi</h2>
                <p class="text-sm text-slate-500 mt-2">Informasi dan kabar terbaru dari BacaDulu.</p>
            </div>

            <a href="{{ route('informasi') }}" class="inline-flex items-center gap-2 text-orange-600 text-sm font-bold border border-orange-400 rounded-full px-5 py-2.5 hover:bg-orange-500 hover:text-white transition">
                Lihat Semua Artikel
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($artikel->isEmpty())
            <div class="py-12 text-center bg-white border rounded-2xl text-slate-500">Belum ada informasi yang diterbitkan.</div>
        @else
        <div class="bd-info-slider">

            @foreach($artikel as $i=>$a)
            @php
                $url=isset($a->slug)?url('/information/'.$a->slug):route('informasi');
                $image=$a->image?asset('storage/'.$a->image):null;
                $title=$a->title??$a->judul??'Informasi';
                $desc=$a->excerpt??Str::limit(strip_tags($a->content??$a->deskripsi??''),115);
            @endphp

            <div data-bd-reveal="up" data-bd-delay="{{ $i*80 }}">
                <article data-bd-tilt class="bd-info-card group">

                    <a href="{{ $url }}" class="bd-info-image">
                        @if($image)
                        <img src="{{ $image }}" alt="{{ $title }}">
                        @else
                        <div class="bd-info-placeholder">
                            <svg viewBox="0 0 24 24"><path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5"/></svg>
                            <span>{{ $title }}</span>
                        </div>
                        @endif

                        <span class="bd-info-badge">Informasi</span>
                    </a>

                    <div class="bd-info-content">
                        <div>
                            <h3>{{ $title }}</h3>
                            <p>{{ $desc }}</p>
                        </div>

                        <a href="{{ $url }}" class="bd-info-read">
                            Baca Selengkapnya
                            <svg viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                </article>
            </div>
            @endforeach

        </div>
        @endif
    </div>
</section>

<section class="relative py-20 overflow-hidden bg-[#17113A]">
    <div class="absolute inset-0 bd-cta-background"></div>

    <div class="relative max-w-6xl mx-auto px-6">
        <div data-bd-reveal="zoom">
            <div data-bd-tilt class="bd-publish-card">

                <div class="bd-depth-2">
                    <div class="inline-flex items-center gap-2 text-[#F7AA35]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-widest">Penerbitan Buku</span>
                    </div>

                    <h2 class="text-white text-3xl md:text-4xl font-black mt-3 leading-tight">
                        Siap mengubah naskah Anda menjadi buku?
                    </h2>

                    <p class="text-slate-300 text-sm leading-relaxed mt-4 max-w-2xl">
                        Konsultasikan kebutuhan editing, layout, desain sampul, ISBN, HAKI, pencetakan hingga distribusi bersama tim BacaDulu.
                    </p>

                    <div class="bd-cta-features">
                        <span>ISBN Resmi</span>
                        <span>Editing & Layout</span>
                        <span>Buku Cetak</span>
                        <span>E-book</span>
                    </div>
                </div>

                <div class="bd-publish-action bd-depth-2">

                    <div class="bd-publish-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>
                    </div>

                    <a href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku." target="_blank">
                        Konsultasi Sekarang
                        <svg viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <small>Hubungi tim BacaDulu melalui WhatsApp</small>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
.bd-info-slider{display:flex;gap:18px;overflow-x:auto;padding:8px 4px 22px;scroll-snap-type:x mandatory;scrollbar-width:none}.bd-info-slider::-webkit-scrollbar{display:none}
.bd-info-card{width:350px;min-width:350px;height:435px;display:flex;flex-direction:column;overflow:hidden;background:#fff;border:1px solid #E7E9EE;border-radius:18px;box-shadow:0 6px 20px rgba(15,23,42,.05);scroll-snap-align:start;transform-style:preserve-3d}
.bd-info-image{position:relative;height:205px;display:block;overflow:hidden;background:#F1F5F9}
.bd-info-image img{width:100%;height:100%;object-fit:cover;transition:transform .6s ease}.bd-info-card:hover .bd-info-image img{transform:scale(1.07)}
.bd-info-placeholder{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;padding:25px;text-align:center;color:#fff;background:linear-gradient(135deg,#EF5843,#241B52);font-weight:700}.bd-info-placeholder svg{width:30px;height:30px;fill:none;stroke:#fff;stroke-width:1.5}
.bd-info-badge{position:absolute;bottom:13px;left:14px;padding:5px 10px;border-radius:999px;background:#fff;color:#C2410C;font-size:8px;font-weight:800}
.bd-info-content{display:flex;flex:1;flex-direction:column;justify-content:space-between;padding:18px}.bd-info-content h3{color:#241B52;font-size:15px;font-weight:800;line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.bd-info-content p{margin-top:8px;color:#64748B;font-size:11px;line-height:1.65;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.bd-info-read{display:flex;align-items:center;justify-content:space-between;margin-top:15px;padding-top:13px;border-top:1px solid #F1F5F9;color:#241B52!important;font-size:10px;font-weight:800}.bd-info-read svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2}.bd-info-read:hover{color:#EF5843!important}
.bd-cta-background{background:radial-gradient(circle at 10% 20%,rgba(239,88,67,.2),transparent 30%),radial-gradient(circle at 90% 80%,rgba(247,170,53,.14),transparent 30%),linear-gradient(135deg,#17113A,#241B52)}
.bd-publish-card{display:grid;grid-template-columns:minmax(0,1fr) 270px;gap:38px;align-items:center;padding:42px 45px;border:1px solid rgba(255,255,255,.12);border-radius:28px;background:rgba(255,255,255,.06);backdrop-filter:blur(12px);box-shadow:0 25px 60px rgba(0,0,0,.2);transform-style:preserve-3d}
.bd-cta-features{display:flex;flex-wrap:wrap;gap:7px;margin-top:18px}.bd-cta-features span{padding:6px 10px;border-radius:999px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:#E2E8F0;font-size:9px;font-weight:700}
.bd-publish-action{display:flex;flex-direction:column;align-items:center;text-align:center}.bd-publish-icon{width:68px;height:68px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;border-radius:20px;background:linear-gradient(135deg,#EF5843,#F7AA35);box-shadow:0 15px 32px rgba(239,88,67,.25);animation:bdPublishFloat 4s ease-in-out infinite}.bd-publish-icon svg{width:29px;height:29px;fill:none;stroke:#fff;stroke-width:1.7}
.bd-publish-action>a{width:100%;display:flex;align-items:center;justify-content:center;gap:7px;padding:13px 18px;border-radius:999px;background:#F7AA35;color:#241B52!important;font-size:11px;font-weight:900;transition:.2s}.bd-publish-action>a svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2}.bd-publish-action>a:hover{gap:10px;background:#EF5843;color:#fff!important}.bd-publish-action small{margin-top:8px;color:#94A3B8;font-size:8px}
@keyframes bdPublishFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
@media(max-width:767px){.bd-info-card{width:285px;min-width:285px}.bd-publish-card{grid-template-columns:1fr;padding:30px 24px}.bd-publish-action{align-items:flex-start;text-align:left}.bd-publish-action>a{max-width:260px}}
</style>