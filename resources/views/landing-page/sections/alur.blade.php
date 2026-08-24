@php
$steps=[
    [
        'title'=>'Kirim Naskah',
        'desc'=>'Kirim draf lengkap naskah dalam format dokumen untuk dilakukan pemeriksaan awal.',
        'icon'=>'upload'
    ],
    [
        'title'=>'Penyuntingan & Layout',
        'desc'=>'Naskah melalui proses penyuntingan, desain sampul, dan penataan isi buku.',
        'icon'=>'edit'
    ],
    [
        'title'=>'ISBN & HAKI',
        'desc'=>'Pengurusan ISBN resmi serta perlindungan hak kekayaan intelektual sesuai kebutuhan.',
        'icon'=>'shield'
    ],
    [
        'title'=>'Cetak & Distribusi',
        'desc'=>'Buku siap dicetak dan didistribusikan dalam format fisik maupun digital.',
        'icon'=>'package'
    ]
];
@endphp

<section id="alur" class="bd-process-section relative py-24 bg-white overflow-hidden">
    <div class="bd-section-glow bg-orange-400 -right-44 top-20"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="text-center max-w-3xl mx-auto mb-14" data-bd-reveal="up">
            <div class="inline-flex items-center gap-2 text-orange-600">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 12h16M14 6l6 6-6 6"/>
                </svg>
                <span class="text-xs font-bold tracking-widest uppercase">Proses Penerbitan</span>
            </div>

            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">
                Alur Mudah Menerbitkan Buku
            </h2>

            <p class="text-slate-500 text-sm mt-3">
                Ikuti perjalanan naskah dari tahap pengiriman hingga menjadi buku yang siap diterbitkan dan didistribusikan.
            </p>
        </div>

        <div class="bd-process-stage">
            <div class="bd-process-track">
                <div class="bd-process-progress"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                @foreach($steps as $i=>$step)
                    <div class="bd-process-item">
                        <article data-bd-tilt class="bd-process-card h-full relative p-6 rounded-2xl bg-slate-50 border border-slate-100">

                            <span class="bd-process-number absolute right-5 top-4">
                                {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                            </span>

                            <div class="bd-process-icon bd-depth-2">
                                @if($step['icon']==='upload')
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 16V4M7 9l5-5 5 5M5 20h14"/>
                                    </svg>
                                @elseif($step['icon']==='edit')
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 20l4.5-1L19 8.5 15.5 5 5 15.5 4 20zM13.5 7l3.5 3.5"/>
                                    </svg>
                                @elseif($step['icon']==='shield')
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3zM9 12l2 2 4-4"/>
                                    </svg>
                                @else
                                    <svg viewBox="0 0 24 24">
                                        <path d="M3 7l9-4 9 4-9 4-9-4zM3 7v10l9 4 9-4V7M12 11v10"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="bd-process-status">Tahap {{ $i+1 }}</div>

                            <h3 class="relative text-slate-800 font-bold text-base mt-3 mb-2 bd-depth-2">
                                {{ $step['title'] }}
                            </h3>

                            <p class="relative text-xs text-slate-500 leading-relaxed bd-depth-1">
                                {{ $step['desc'] }}
                            </p>

                            <div class="bd-process-check">
                                <svg viewBox="0 0 24 24">
                                    <path d="M8 12l3 3 5-6"/>
                                </svg>
                            </div>

                        </article>
                    </div>
                @endforeach
            </div>

            <div class="bd-process-scroll-hint hidden lg:flex">
                <span>Scroll untuk mengikuti proses</span>
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M7 14l5 5 5-5"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<style>
.bd-process-section{position:relative}
.bd-process-stage{position:relative;padding:34px 0 20px}

.bd-process-track{
    position:absolute;
    z-index:1;
    left:8%;
    right:8%;
    top:67px;
    height:3px;
    overflow:hidden;
    border-radius:999px;
    background:#E8EAF0
}

.bd-process-progress{
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,#EF5843,#F7AA35);
    transform:scaleX(0);
    transform-origin:left center
}

.bd-process-item{
    position:relative;
    transform-origin:center center;
    will-change:transform,opacity
}

.bd-process-card{
    min-height:235px;
    overflow:hidden;
    transform-style:preserve-3d;
    transition:border-color .3s ease,box-shadow .3s ease,background .3s ease
}

.bd-process-card::before{
    content:"";
    position:absolute;
    width:160px;
    height:160px;
    right:-100px;
    bottom:-100px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.12),transparent 70%);
    pointer-events:none
}

.bd-process-number{
    color:#CBD5E1;
    font-size:44px;
    line-height:1;
    font-weight:900;
    transition:color .3s ease
}

.bd-process-icon{
    position:relative;
    z-index:2;
    width:48px;
    height:48px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:14px;
    color:#EF5843;
    background:#FFF1E8;
    box-shadow:0 8px 20px rgba(239,88,67,.08)
}

.bd-process-icon svg{
    width:23px;
    height:23px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round
}

.bd-process-status{
    position:relative;
    z-index:2;
    width:max-content;
    margin-top:18px;
    padding:4px 8px;
    border-radius:999px;
    color:#C2410C;
    background:#FFF7ED;
    font-size:8px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.6px
}

.bd-process-check{
    position:absolute;
    right:17px;
    bottom:16px;
    width:24px;
    height:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    color:#fff;
    background:linear-gradient(135deg,#EF5843,#F7AA35);
    opacity:.2;
    transform:scale(.7)
}

.bd-process-check svg{
    width:13px;
    height:13px;
    fill:none;
    stroke:currentColor;
    stroke-width:2.3
}

.bd-process-scroll-hint{
    align-items:center;
    justify-content:center;
    gap:7px;
    margin-top:28px;
    color:#94A3B8;
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.8px
}

.bd-process-scroll-hint svg{
    width:14px;
    height:14px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    animation:bdProcessArrow 1.5s ease-in-out infinite
}

@keyframes bdProcessArrow{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(5px)}
}

@media(max-width:1023px){
    .bd-process-stage{padding-top:0}
    .bd-process-track{display:none}
    .bd-process-card{min-height:220px}
}

@media(max-width:767px){
    .bd-process-card{min-height:205px}
}

@media(prefers-reduced-motion:reduce){
    .bd-process-scroll-hint svg{animation:none}
}
</style>