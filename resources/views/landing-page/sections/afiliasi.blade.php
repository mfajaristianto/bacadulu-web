<section id="afiliasi" class="relative bg-white py-20 border-t border-slate-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <div data-bd-reveal="up">
            <div class="inline-flex items-center gap-2 text-orange-600">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path d="M8 12l3 3 5-6"/>
                    <path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z"/>
                </svg>

                <span class="text-xs font-bold tracking-widest uppercase">
                    Jejaring dan Afiliasi
                </span>
            </div>

            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">
                Affiliated By
            </h2>

            <div class="mx-auto mt-3 h-1 w-16 bg-orange-500 rounded"></div>

            <p class="mt-4 text-sm text-slate-500 max-w-2xl mx-auto">
                BacaDulu membangun jejaring dengan berbagai lembaga, institusi, dan mitra dalam mendukung kegiatan pendidikan dan publikasi.
            </p>
        </div>

        @php
        $affiliateLogos=[
            ['src'=>'Tut Wuri Handayani.jpg','alt'=>'Tut Wuri Handayani'],
            ['src'=>'BRIN.svg','alt'=>'Badan Riset dan Inovasi Nasional'],
            ['src'=>'Fermartian.jpg','alt'=>'FERMARTIAN INVESTAMA KORPORA'],
            ['src'=>'Fdi.jpg','alt'=>'FDI PARTNERS'],
            ['src'=>'SMKN 2.jpg','alt'=>'SMKN 2 JAKARTA'],
            ['src'=>'IKAPI.jpg','alt'=>'Ikatan Penerbit Indonesia'],
            ['src'=>'LLDIKTI.jpg','alt'=>'Lembaga Layanan Pendidikan Tinggi Wilayah III'],
            ['src'=>'Kemnaker.jpg','alt'=>'Kementerian Ketenagakerjaan Republik Indonesia'],
            ['src'=>'IAEI.jpg','alt'=>'Ikatan Ahli Ekonomi Islam Indonesia'],
            ['src'=>'Kadin.jpg','alt'=>'Kamar Dagang dan Industri Indonesia'],
            ['src'=>'INKINDO.jpg','alt'=>'Ikatan Nasional Konsultan Indonesia'],
            ['src'=>'Univ Boro.jpg','alt'=>'Universitas Borobudur'],
            ['src'=>'Bentara.jpg','alt'=>'Bentara Campus'],
            ['src'=>'Turnitin.jpg','alt'=>'Turnitin'],
            ['src'=>'Crossref.jpg','alt'=>'Crossref']
        ];
        @endphp

        <div class="bd-affiliate-wrap mt-10" data-bd-reveal="zoom">
            <div class="bd-affiliate-track">
                @foreach([0,1] as $copy)
                    @foreach($affiliateLogos as $logo)
                        <div class="bd-affiliate-logo" @if($copy) aria-hidden="true" @endif>
                            <img src="{{ asset('img/'.$logo['src']) }}"
                                 alt="{{ $copy?'':$logo['alt'] }}"
                                 title="{{ $logo['alt'] }}">
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        <div class="bd-affiliate-hint" data-bd-reveal="up" data-bd-delay="100">
        </div>
    </div>
</section>

<style>
.bd-affiliate-wrap{overflow:hidden;padding:8px 0 18px;-webkit-mask-image:linear-gradient(to right,transparent,#000 6%,#000 94%,transparent);mask-image:linear-gradient(to right,transparent,#000 6%,#000 94%,transparent)}
.bd-affiliate-track{display:flex;width:max-content;gap:16px;will-change:transform}
.bd-affiliate-logo{width:180px;height:108px;flex:0 0 auto;display:flex;align-items:center;justify-content:center;padding:20px;border:1px solid #E2E8F0;border-radius:16px;background:#F8FAFC;transition:transform .3s ease,border-color .3s ease,box-shadow .3s ease,background .3s ease}
.bd-affiliate-logo:hover{transform:perspective(700px) rotateX(4deg) rotateY(-5deg) translateY(-5px);border-color:rgba(239,88,67,.3);background:#fff;box-shadow:0 14px 28px rgba(36,27,82,.09)}
.bd-affiliate-logo img{max-width:100%;max-height:62px;object-fit:contain}

.bd-affiliate-hint{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:7px;color:#94A3B8;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.7px}
.bd-affiliate-hint svg{width:14px;height:14px;fill:none;stroke:#EF5843;stroke-width:1.8}

@media(max-width:640px){
    .bd-affiliate-logo{width:150px;height:94px;padding:16px}
    .bd-affiliate-logo img{max-height:54px}
}

@media(prefers-reduced-motion:reduce){
    .bd-affiliate-track{transform:none!important}
}
</style>