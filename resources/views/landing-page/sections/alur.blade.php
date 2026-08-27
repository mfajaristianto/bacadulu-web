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

<section id="alur" class="bd-process-section relative py-24 bg-white">
    <div class="bd-section-glow bg-orange-400 -right-44 top-20"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        {{-- HEADER --}}
        <div class="text-center max-w-3xl mx-auto mb-14" data-bd-reveal="up">
            <div class="inline-flex items-center gap-2 text-orange-600">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 12h16M14 6l6 6-6 6"/>
                </svg>

                <span class="text-xs font-bold tracking-widest uppercase">
                    Proses Penerbitan
                </span>
            </div>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mt-3 tracking-tight">
                Alur Mudah Menerbitkan Buku
            </h2>

            <p class="text-slate-500 text-sm sm:text-base mt-4 leading-relaxed">
                Ikuti perjalanan naskah dari tahap pengiriman hingga menjadi buku
                yang siap diterbitkan dan didistribusikan.
            </p>
        </div>

        <div class="bd-process-stage">

            {{-- DESKTOP RAIL --}}
            <div class="bd-process-rail hidden lg:block">
                <div class="bd-process-track">
                    <div class="bd-process-progress"></div>
                </div>

                <div class="bd-process-nodes">
                    @foreach($steps as $i=>$step)
                        <div class="bd-process-node-wrap">
                            <div class="bd-process-node" data-process-node>

                                <span class="bd-process-node-number">
                                    {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                                </span>

                                <div class="bd-process-node-icon">
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

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">

                @foreach($steps as $i=>$step)
                    <div class="bd-process-item" data-process-item>

                        <article class="bd-process-card">

                            {{-- MOBILE --}}
                            <div class="bd-process-mobile-head lg:hidden">
                                <div class="bd-process-mobile-icon">

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

                                <span class="bd-process-mobile-number">
                                    {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <div class="bd-process-card-top">
                                <div class="bd-process-status">
                                    Tahap {{ $i+1 }}
                                </div>

                                <span class="bd-process-mini-number hidden lg:block">
                                    {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <h3 class="bd-process-title">
                                {{ $step['title'] }}
                            </h3>

                            <p class="bd-process-description">
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

            {{-- SCROLL HINT --}}
            <div class="bd-process-scroll-hint hidden lg:flex">

                <span class="bd-process-scroll-mouse">
                    <span class="bd-process-scroll-wheel"></span>
                </span>

                <div class="bd-process-scroll-copy">
                    <strong>Scroll untuk mengikuti proses</strong>
                    <small>Gerakkan scroll untuk berpindah ke tahap berikutnya</small>
                </div>

                <svg class="bd-process-scroll-arrow" viewBox="0 0 24 24">
                    <path d="M12 5v14M7 14l5 5 5-5"/>
                </svg>

            </div>

        </div>
    </div>
</section>

<style>
.bd-process-section{
    position:relative;
    overflow:clip
}

.bd-process-stage{
    position:relative
}

/* =====================================================
   PROCESS RAIL
===================================================== */
.bd-process-rail{
    position:relative;
    padding-top:10px;
    margin-bottom:26px
}

.bd-process-track{
    position:absolute;
    z-index:1;
    left:12.5%;
    right:12.5%;
    top:41px;
    height:3px;
    overflow:hidden;
    border-radius:999px;
    background:#E8EDF3
}

.bd-process-progress{
    position:absolute;
    inset:0;
    transform:scaleX(0);
    transform-origin:left center;
    border-radius:999px;
    background:linear-gradient(90deg,#EF5843 0%,#F9733F 48%,#F7AA35 100%);
    box-shadow:0 0 20px rgba(239,88,67,.24);
    will-change:transform
}

.bd-process-nodes{
    position:relative;
    z-index:2;
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr))
}

.bd-process-node-wrap{
    display:flex;
    justify-content:center
}

.bd-process-node{
    position:relative;
    width:66px;
    height:66px
}

.bd-process-node-icon{
    width:66px;
    height:66px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:20px;
    color:#EF5843;
    background:#FFF7ED;
    border:2px solid #FED7AA;
    box-shadow:0 8px 22px rgba(15,23,42,.045),0 0 0 7px #fff;
    transition:
        color .35s ease,
        background .35s ease,
        border-color .35s ease,
        box-shadow .35s ease,
        transform .35s ease
}

.bd-process-node-icon svg{
    width:27px;
    height:27px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.9;
    stroke-linecap:round;
    stroke-linejoin:round
}

.bd-process-node-number{
    position:absolute;
    z-index:5;
    top:-10px;
    right:-12px;
    min-width:30px;
    height:30px;
    padding:0 6px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:999px;
    color:#C2410C;
    background:#FFEDD5;
    border:2px solid #fff;
    font-size:10px;
    line-height:1;
    font-weight:900;
    box-shadow:0 5px 14px rgba(15,23,42,.09);
    transition:
        color .35s ease,
        background .35s ease,
        transform .35s ease
}

/* ACTIVE SVG */
.bd-process-node.is-active .bd-process-node-icon{
    color:#fff;
    background:#EF5843;
    border-color:#EF5843;
    transform:scale(1.08);
    box-shadow:
        0 14px 30px rgba(239,88,67,.26),
        0 0 0 7px #fff
}

.bd-process-node.is-active .bd-process-node-number{
    color:#fff;
    background:#EF5843;
    transform:scale(1.08)
}

/* COMPLETED SVG */
.bd-process-node.is-complete .bd-process-node-icon{
    color:#fff;
    background:#241B52;
    border-color:#241B52;
    transform:scale(1)
}

.bd-process-node.is-complete .bd-process-node-number{
    color:#fff;
    background:#241B52
}

/* =====================================================
   CARD
===================================================== */
.bd-process-item{
    position:relative;
    opacity:.48;
    transform:translateY(12px) scale(.985);
    transition:opacity .4s ease,transform .4s ease;
    will-change:transform,opacity
}

.bd-process-card{
    position:relative;
    height:100%;
    min-height:245px;
    padding:26px;
    overflow:hidden;
    border-radius:22px;
    border:1px solid #E8EDF3;
    background:linear-gradient(145deg,#fff 0%,#FAFBFC 72%,#F8FAFC 100%);
    box-shadow:0 7px 24px rgba(15,23,42,.035);
    transition:
        border-color .4s ease,
        box-shadow .4s ease,
        background .4s ease
}

.bd-process-card::before{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    right:-105px;
    bottom:-110px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(239,88,67,.12),transparent 68%);
    pointer-events:none
}

.bd-process-card::after{
    content:"";
    position:absolute;
    left:0;
    top:0;
    bottom:0;
    width:3px;
    border-radius:3px;
    background:linear-gradient(180deg,#EF5843,#F7AA35);
    transform:scaleY(0);
    transform-origin:top center;
    opacity:0;
    transition:transform .4s ease,opacity .4s ease
}

/* ACTIVE CARD */
.bd-process-item.is-active{
    opacity:1;
    transform:translateY(-5px) scale(1)
}

.bd-process-item.is-active .bd-process-card{
    border-color:rgba(239,88,67,.34);
    background:#fff;
    box-shadow:0 20px 42px rgba(36,27,82,.10)
}

.bd-process-item.is-active .bd-process-card::after{
    opacity:1;
    transform:scaleY(1)
}

/* COMPLETED CARD */
.bd-process-item.is-complete{
    opacity:.84;
    transform:translateY(0) scale(1)
}

.bd-process-item.is-complete .bd-process-card{
    border-color:rgba(36,27,82,.12);
    box-shadow:0 10px 27px rgba(36,27,82,.055)
}

.bd-process-item.is-complete .bd-process-check,
.bd-process-item.is-active .bd-process-check{
    opacity:1;
    transform:scale(1)
}

/* =====================================================
   CARD CONTENT
===================================================== */
.bd-process-card-top{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:18px
}

.bd-process-status{
    width:max-content;
    padding:6px 10px;
    border-radius:999px;
    color:#C2410C;
    background:#FFF3E9;
    font-size:9px;
    line-height:1;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.65px
}

.bd-process-mini-number{
    color:#D7DEE8;
    font-size:29px;
    line-height:1;
    font-weight:900;
    letter-spacing:-1.5px;
    transition:color .35s ease
}

.bd-process-item.is-active .bd-process-mini-number{
    color:#EF5843
}

.bd-process-item.is-complete .bd-process-mini-number{
    color:#241B52
}

.bd-process-title{
    position:relative;
    z-index:2;
    margin-bottom:10px;
    color:#1E293B;
    font-size:18px;
    line-height:1.3;
    font-weight:800;
    letter-spacing:-.3px
}

.bd-process-description{
    position:relative;
    z-index:2;
    max-width:95%;
    color:#64748B;
    font-size:13px;
    line-height:1.75
}

.bd-process-check{
    position:absolute;
    z-index:3;
    right:20px;
    bottom:19px;
    width:27px;
    height:27px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    color:#fff;
    background:linear-gradient(135deg,#EF5843,#F7AA35);
    opacity:.14;
    transform:scale(.72);
    box-shadow:0 7px 18px rgba(239,88,67,.16);
    transition:opacity .35s ease,transform .35s ease
}

.bd-process-check svg{
    width:14px;
    height:14px;
    fill:none;
    stroke:currentColor;
    stroke-width:2.4;
    stroke-linecap:round;
    stroke-linejoin:round
}

/* =====================================================
   MOBILE
===================================================== */
.bd-process-mobile-head{
    position:relative;
    z-index:2;
    align-items:center;
    justify-content:space-between;
    margin-bottom:18px
}

.bd-process-mobile-icon{
    width:50px;
    height:50px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:15px;
    color:#EF5843;
    background:#FFF0E8;
    box-shadow:0 8px 20px rgba(239,88,67,.08)
}

.bd-process-mobile-icon svg{
    width:23px;
    height:23px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.9;
    stroke-linecap:round;
    stroke-linejoin:round
}

.bd-process-mobile-number{
    color:#CBD5E1;
    font-size:35px;
    line-height:1;
    font-weight:900;
    letter-spacing:-2px
}

/* =====================================================
   SCROLL HINT
===================================================== */
.bd-process-scroll-hint{
    position:relative;
    width:max-content;
    margin:34px auto 0;
    padding:11px 16px 11px 12px;
    align-items:center;
    gap:12px;
    border-radius:999px;
    border:1px solid rgba(234,88,12,.22);
    color:#C2410C;
    background:rgba(255,247,237,.94);
    box-shadow:0 10px 28px rgba(234,88,12,.09);
    backdrop-filter:blur(10px);
    animation:bdProcessHintFloat 2.5s ease-in-out infinite
}

.bd-process-scroll-copy{
    display:flex;
    flex-direction:column;
    gap:2px
}

.bd-process-scroll-copy strong{
    color:#C2410C;
    font-size:10.5px;
    line-height:1.2;
    font-weight:850;
    text-transform:uppercase;
    letter-spacing:.7px
}

.bd-process-scroll-copy small{
    color:#9A6B56;
    font-size:9px;
    line-height:1.3;
    font-weight:500
}

.bd-process-scroll-mouse{
    position:relative;
    width:26px;
    height:36px;
    display:block;
    flex:0 0 auto;
    border:2px solid rgba(234,88,12,.48);
    border-radius:999px
}

.bd-process-scroll-wheel{
    position:absolute;
    top:7px;
    left:50%;
    width:3px;
    height:7px;
    border-radius:999px;
    background:#EA580C;
    transform:translateX(-50%);
    animation:bdProcessWheel 1.45s ease-in-out infinite
}

.bd-process-scroll-arrow{
    width:18px;
    height:18px;
    flex:0 0 auto;
    fill:none;
    stroke:#EA580C;
    stroke-width:1.9;
    stroke-linecap:round;
    stroke-linejoin:round;
    animation:bdProcessArrow 1.45s ease-in-out infinite
}

@keyframes bdProcessWheel{
    0%{
        opacity:0;
        transform:translate(-50%,0)
    }
    25%{opacity:1}
    70%{opacity:1}
    100%{
        opacity:0;
        transform:translate(-50%,9px)
    }
}

@keyframes bdProcessArrow{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(5px)}
}

@keyframes bdProcessHintFloat{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(4px)}
}

/* =====================================================
   RESPONSIVE
===================================================== */
@media(max-width:1023px){
    .bd-process-mobile-head{display:flex}
    .bd-process-card{min-height:225px}
    .bd-process-item{
        opacity:1;
        transform:none
    }
}

@media(max-width:767px){
    .bd-process-section{
        padding-top:72px;
        padding-bottom:72px
    }

    .bd-process-card{
        min-height:215px;
        padding:22px;
        border-radius:19px
    }

    .bd-process-title{font-size:17px}
    .bd-process-description{font-size:12.5px}
}

@media(prefers-reduced-motion:reduce){
    .bd-process-scroll-hint,
    .bd-process-scroll-wheel,
    .bd-process-scroll-arrow{
        animation:none
    }
}
</style>