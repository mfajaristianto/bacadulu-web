@php
    $testimoniItems = [
        ['image' => asset('img/Bentara.jpg'), 'name' => 'Bentara Campus', 'label' => 'Kolaborasi Pendidikan', 'alt' => 'Dokumentasi Bentara Campus'],
        ['image' => asset('img/Bina.jpg'), 'name' => 'Bina Cendikia', 'label' => 'Kolaborasi Penerbitan', 'alt' => 'Dokumentasi Bina Cendikia'],
        ['image' => asset('img/Fdi.jpg'), 'name' => 'FDI Partners', 'label' => 'Kolaborasi Profesional', 'alt' => 'Dokumentasi FDI Partners'],
        ['image' => asset('img/Kadin.jpg'), 'name' => 'KADIN', 'label' => 'Kolaborasi Institusi', 'alt' => 'Dokumentasi KADIN'],
        ['image' => asset('img/Fermartian.jpg'), 'name' => 'Fermartian', 'label' => 'Kolaborasi Mitra', 'alt' => 'Dokumentasi Fermartian'],
    ];

    $jumlahTestimoni = count($testimoniItems);
@endphp

<section id="testimoni" class="bd-testi">
    <div class="bd-testi-bg-grid" aria-hidden="true"></div>
    <div class="bd-testi-glow bd-testi-glow-one" aria-hidden="true"></div>
    <div class="bd-testi-glow bd-testi-glow-two" aria-hidden="true"></div>

    <div class="bd-testi-container">
        <header class="bd-testi-header">
            <div class="bd-testi-heading">
                <div class="bd-testi-kicker">
                    <span class="bd-testi-kicker-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17h4l2-4V7H7v10z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 17h4l2-4V7h-6v10z"/>
                        </svg>
                    </span>
                    <span>Cerita Mitra</span>
                </div>

                <h2>Kepercayaan yang <span>tumbuh bersama.</span></h2>

                <p>
                    Dokumentasi dan bentuk kepercayaan dari mitra yang telah
                    berkolaborasi bersama Baca Dulu.
                </p>
            </div>

            <div class="bd-testi-header-counter" aria-label="Posisi testimoni">
                <strong id="bdTestiHeaderCurrent">01</strong>
                <span>/</span>
                <span>{{ str_pad($jumlahTestimoni, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
        </header>

        <div class="bd-testi-carousel">
            <div class="bd-testi-stage" id="bdTestiStage">
                @foreach($testimoniItems as $index => $item)
                    <article
                        class="bd-testi-card {{ $index === 0 ? 'is-active' : '' }}"
                        data-testi-card="{{ $index }}"
                    >
                        <button
                            type="button"
                            class="bd-testi-card-button"
                            data-testi-open="{{ $index }}"
                            aria-label="Lihat dokumentasi {{ $item['name'] }}"
                        >
                            <div class="bd-testi-media">
                                <img
                                    src="{{ $item['image'] }}"
                                    alt="{{ $item['alt'] }}"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    draggable="false"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                >

                                <div class="bd-testi-image-fallback">
                                    <span>Baca Dulu</span>
                                    <strong>{{ $item['name'] }}</strong>
                                </div>

                                <div class="bd-testi-overlay"></div>

                                <div class="bd-testi-card-head">
                                    <span class="bd-testi-card-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <span class="bd-testi-expand">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3H3v5M16 3h5v5M8 21H3v-5M16 21h5v-5"/>
                                        </svg>
                                    </span>
                                </div>

                                <div class="bd-testi-card-caption">
                                    <span>{{ $item['label'] }}</span>
                                    <strong>{{ $item['name'] }}</strong>
                                </div>
                            </div>
                        </button>
                    </article>
                @endforeach
            </div>

            <div class="bd-testi-controls">
                <div class="bd-testi-counter">
                    <strong id="bdTestiCurrent">01</strong>
                    <span>/</span>
                    <span>{{ str_pad($jumlahTestimoni, 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="bd-testi-dots" aria-label="Pilih testimoni">
                    @foreach($testimoniItems as $index => $item)
                        <button
                            type="button"
                            class="bd-testi-dot {{ $index === 0 ? 'is-active' : '' }}"
                            data-testi-dot="{{ $index }}"
                            aria-label="Testimoni {{ $index + 1 }}"
                        >
                            <span></span>
                        </button>
                    @endforeach
                </div>

                <div class="bd-testi-nav-group">
                    <button
                        type="button"
                        id="bdTestiPrev"
                        class="bd-testi-nav"
                        aria-label="Testimoni sebelumnya"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                    </button>

                    <button
                        type="button"
                        id="bdTestiNext"
                        class="bd-testi-nav bd-testi-nav-next"
                        aria-label="Testimoni berikutnya"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bd-testi-active-info">
                <div class="bd-testi-active-number">
                    <small>TESTIMONI</small>
                    <strong id="bdTestiInfoNumber">01</strong>
                </div>

                <div class="bd-testi-active-copy">
                    <span id="bdTestiInfoLabel">
                        {{ $testimoniItems[0]['label'] }}
                    </span>

                    <h3 id="bdTestiInfoName">
                        {{ $testimoniItems[0]['name'] }}
                    </h3>
                </div>

                <p>
                    Dokumentasi kolaborasi dan kepercayaan bersama Baca Dulu.
                </p>
            </div>
        </div>
    </div>

    <div
        id="bdTestiLightbox"
        class="bd-testi-lightbox"
        aria-hidden="true"
    >
        <button
            type="button"
            id="bdTestiLightboxClose"
            class="bd-testi-lightbox-close"
            aria-label="Tutup gambar"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="bd-testi-lightbox-inner">
            <img id="bdTestiLightboxImage" src="" alt="">
        </div>
    </div>
</section>

<style>
.bd-testi{
    --navy:#241B52;
    --orange:#EF5843;
    --gold:#F7AA35;
    position:relative;
    width:100%;
    max-width:100%;
    padding:68px 0 66px;
    overflow:hidden;
    background:linear-gradient(180deg,#F5F2EC 0%,#F4F1EB 100%);
    color:#27272D;
}

.bd-testi *,
.bd-testi *::before,
.bd-testi *::after{
    box-sizing:border-box;
}

.bd-testi-bg-grid{
    position:absolute;
    inset:0;
    pointer-events:none;
    opacity:.3;
    background-image:
        linear-gradient(rgba(36,27,82,.025) 1px,transparent 1px),
        linear-gradient(90deg,rgba(36,27,82,.025) 1px,transparent 1px);
    background-size:52px 52px;
}

.bd-testi-glow{
    position:absolute;
    border-radius:50%;
    pointer-events:none;
}

.bd-testi-glow-one{
    width:430px;
    height:430px;
    left:-280px;
    top:40px;
    background:radial-gradient(circle,rgba(239,88,67,.1),transparent 70%);
}

.bd-testi-glow-two{
    width:470px;
    height:470px;
    right:-290px;
    bottom:-260px;
    background:radial-gradient(circle,rgba(247,170,53,.09),transparent 70%);
}

.bd-testi-container{
    position:relative;
    z-index:2;
    width:min(calc(100% - 56px),1380px);
    margin:0 auto;
}

.bd-testi-header{
    width:min(100%,1120px);
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:30px;
    margin:0 auto 24px;
    padding-bottom:20px;
    border-bottom:1px solid rgba(36,27,82,.1);
}

.bd-testi-heading{
    max-width:660px;
}

.bd-testi-kicker{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:9px;
    color:var(--orange);
    font-size:8px;
    font-weight:850;
    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-testi-kicker-icon{
    width:27px;
    height:27px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    background:rgba(239,88,67,.09);
}

.bd-testi-kicker-icon svg{
    width:13px;
    height:13px;
}

.bd-testi-heading h2{
    margin:0;
    color:var(--navy);
    font-size:clamp(30px,3.2vw,43px);
    line-height:1.04;
    font-weight:850;
    letter-spacing:-.045em;
}

.bd-testi-heading h2 span{
    color:var(--orange);
}

.bd-testi-heading p{
    max-width:570px;
    margin:10px 0 0;
    color:#777982;
    font-size:10px;
    line-height:1.7;
}

.bd-testi-header-counter{
    display:flex;
    align-items:baseline;
    gap:5px;
    flex:0 0 auto;
    color:#AAA7AE;
    font-size:8px;
    font-weight:800;
}

.bd-testi-header-counter strong{
    color:var(--orange);
    font-size:19px;
}

.bd-testi-carousel{
    position:relative;
    width:100%;
    max-width:100%;
    overflow:hidden;
}

.bd-testi-stage{
    position:relative;
    width:100%;
    max-width:100%;
    height:345px;
    overflow:hidden;
    perspective:1200px;
}

.bd-testi-card{
    --testi-x:0px;
    --testi-scale:1;
    --testi-rotate:0deg;
    position:absolute;
    left:50%;
    top:8px;
    width:290px;
    height:318px;
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    transform:
        translateX(-50%)
        translateX(var(--testi-x))
        scale(var(--testi-scale))
        rotateY(var(--testi-rotate));
    transform-origin:center;
    transition:
        transform .48s cubic-bezier(.22,.8,.25,1),
        opacity .38s ease;
}

.bd-testi-card.is-active{
    pointer-events:auto;
}

.bd-testi-card-button{
    display:block;
    width:100%;
    height:100%;
    padding:0;
    border:0;
    background:transparent;
    cursor:pointer;
}

.bd-testi-media{
    position:relative;
    width:100%;
    height:100%;
    overflow:hidden;
    border:1px solid rgba(36,27,82,.09);
    border-radius:20px;
    background:#fff;
    box-shadow:0 16px 36px rgba(36,27,82,.1);
}

.bd-testi-card.is-active .bd-testi-media{
    border-color:rgba(239,88,67,.2);
    box-shadow:0 22px 45px rgba(36,27,82,.14);
}

.bd-testi-media>img{
    display:block;
    width:100%;
    height:100%;
    padding:8px;
    object-fit:contain;
    object-position:center;
    background:#fff;
    border-radius:19px;
}

.bd-testi-image-fallback{
    position:absolute;
    inset:0;
    display:none;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:7px;
    padding:20px;
    color:#fff;
    text-align:center;
    background:linear-gradient(145deg,#241B52,#332875);
}

.bd-testi-image-fallback span{
    color:var(--gold);
    font-size:7px;
    font-weight:850;
    text-transform:uppercase;
}

.bd-testi-image-fallback strong{
    font-size:19px;
}

.bd-testi-overlay{
    position:absolute;
    inset:0;
    pointer-events:none;
    background:
        linear-gradient(
            180deg,
            transparent 57%,
            rgba(17,12,49,.04) 67%,
            rgba(17,12,49,.82) 100%
        );
}

.bd-testi-card-head{
    position:absolute;
    z-index:5;
    left:12px;
    right:12px;
    top:12px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.bd-testi-card-number{
    min-width:36px;
    height:27px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 8px;
    border-radius:8px;
    background:rgba(255,255,255,.96);
    color:var(--orange);
    font-size:8px;
    font-weight:900;
}

.bd-testi-expand{
    width:29px;
    height:29px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:rgba(255,255,255,.95);
    color:var(--navy);
}

.bd-testi-expand svg{
    width:12px;
    height:12px;
}

.bd-testi-card-caption{
    position:absolute;
    z-index:5;
    left:17px;
    right:17px;
    bottom:16px;
}

.bd-testi-card-caption span{
    display:block;
    margin-bottom:4px;
    color:rgba(255,255,255,.7);
    font-size:6px;
    font-weight:850;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-testi-card-caption strong{
    display:block;
    color:#fff;
    font-size:16px;
    line-height:1.2;
    font-weight:850;
}

.bd-testi-controls{
    width:min(100%,700px);
    display:grid;
    grid-template-columns:auto 1fr auto;
    align-items:center;
    gap:14px;
    margin:8px auto 0;
}

.bd-testi-counter{
    display:flex;
    align-items:baseline;
    gap:5px;
    min-width:65px;
    color:#AAA7AE;
    font-size:8px;
    font-weight:800;
}

.bd-testi-counter strong{
    color:var(--orange);
    font-size:18px;
}

.bd-testi-dots{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:4px;
}

.bd-testi-dot{
    width:21px;
    height:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border:0;
    background:transparent;
    cursor:pointer;
}

.bd-testi-dot span{
    display:block;
    width:12px;
    height:2px;
    border-radius:999px;
    background:rgba(36,27,82,.18);
    transition:.22s ease;
}

.bd-testi-dot.is-active span{
    width:21px;
    background:var(--orange);
}

.bd-testi-nav-group{
    display:flex;
    align-items:center;
    gap:7px;
}

.bd-testi-nav{
    width:43px;
    height:43px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border:1px solid rgba(36,27,82,.13);
    border-radius:11px;
    background:#fff;
    color:var(--navy);
    cursor:pointer;
}

.bd-testi-nav-next{
    border-color:var(--navy);
    background:var(--navy);
    color:#fff;
}

.bd-testi-nav svg{
    width:14px;
    height:14px;
}

.bd-testi-active-info{
    width:min(100%,800px);
    display:grid;
    grid-template-columns:68px minmax(0,1fr) minmax(190px,.7fr);
    align-items:center;
    gap:17px;
    margin:17px auto 0;
    padding:13px 15px;
    border:1px solid rgba(36,27,82,.08);
    border-radius:15px;
    background:rgba(255,255,255,.67);
}

.bd-testi-active-number{
    min-height:47px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:2px;
    border:1px solid rgba(36,27,82,.07);
    border-radius:10px;
    background:#fff;
}

.bd-testi-active-number small{
    color:#AAA6AE;
    font-size:5px;
    font-weight:850;
}

.bd-testi-active-number strong{
    color:var(--orange);
    font-size:16px;
}

.bd-testi-active-copy{
    min-width:0;
}

.bd-testi-active-copy>span{
    display:block;
    color:var(--orange);
    font-size:6px;
    font-weight:850;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-testi-active-copy h3{
    margin:3px 0 0;
    color:var(--navy);
    font-size:18px;
    line-height:1.2;
    font-weight:850;
    overflow-wrap:anywhere;
}

.bd-testi-active-info>p{
    margin:0;
    padding-left:16px;
    border-left:1px solid rgba(36,27,82,.08);
    color:#89868F;
    font-size:7px;
    line-height:1.6;
}

/* TOUCH */
html[data-baca-input="touch"] .bd-testi-stage{
    height:auto;
    overflow:hidden;
    perspective:none;
    touch-action:pan-y;
    overscroll-behavior-x:contain;
}

html[data-baca-input="touch"] .bd-testi-card{
    position:relative;
    left:auto;
    top:auto;
    width:min(100%,300px);
    height:auto;
    aspect-ratio:290/318;
    margin:0 auto;
    transform:none!important;
    opacity:1!important;
    visibility:visible!important;
    pointer-events:auto;
}

html[data-baca-input="touch"] .bd-testi-card:not(.is-active){
    display:none!important;
}

html[data-baca-input="touch"] .bd-testi-card.is-active{
    display:block!important;
}

/* PHONE */
html[data-baca-device="phone"] .bd-testi{
    padding:56px 0 55px;
}

html[data-baca-device="phone"] .bd-testi-container{
    width:100%;
    padding:0 16px;
}

html[data-baca-device="phone"] .bd-testi-header{
    width:100%;
    flex-direction:column;
    align-items:flex-start;
    gap:10px;
    margin-bottom:19px;
    padding-bottom:16px;
}

html[data-baca-device="phone"] .bd-testi-heading{
    width:100%;
}

html[data-baca-device="phone"] .bd-testi-heading h2{
    max-width:350px;
    font-size:31px;
}

html[data-baca-device="phone"] .bd-testi-heading p{
    max-width:100%;
    font-size:9.5px;
}

html[data-baca-device="phone"] .bd-testi-header-counter{
    display:none;
}

html[data-baca-device="phone"] .bd-testi-card{
    width:min(100%,285px);
}

html[data-baca-device="phone"] .bd-testi-controls{
    width:min(100%,285px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-top:12px;
}

html[data-baca-device="phone"] .bd-testi-dots{
    display:none;
}

html[data-baca-device="phone"] .bd-testi-nav-group{
    margin-left:auto;
}

html[data-baca-device="phone"] .bd-testi-nav{
    width:45px;
    height:45px;
}

html[data-baca-device="phone"] .bd-testi-active-info{
    width:100%;
    grid-template-columns:1fr;
    gap:9px;
    margin-top:17px;
    padding:13px;
}

html[data-baca-device="phone"] .bd-testi-active-number{
    width:max-content;
    min-width:65px;
    min-height:38px;
    flex-direction:row;
    gap:5px;
    padding:0 9px;
}

html[data-baca-device="phone"] .bd-testi-active-info>p{
    padding:9px 0 0;
    border-left:0;
    border-top:1px solid rgba(36,27,82,.08);
}

/* DESKTOP HOVER */
html[data-baca-device="desktop"][data-baca-input="fine"] .bd-testi-nav:hover{
    border-color:rgba(239,88,67,.4);
}

html[data-baca-device="desktop"][data-baca-input="fine"] .bd-testi-nav-next:hover{
    border-color:var(--orange);
    background:var(--orange);
}

/* LIGHTBOX */
.bd-testi-lightbox{
    position:fixed;
    inset:0;
    z-index:99999;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:24px;
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    background:rgba(13,9,35,.91);
    backdrop-filter:blur(10px);
    transition:opacity .2s ease,visibility .2s ease;
}

.bd-testi-lightbox.is-open{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
}

.bd-testi-lightbox-inner{
    width:min(100%,900px);
    display:flex;
    align-items:center;
    justify-content:center;
}

.bd-testi-lightbox-inner img{
    display:block;
    width:auto;
    height:auto;
    max-width:100%;
    max-height:calc(100dvh - 70px);
    padding:7px;
    object-fit:contain;
    border-radius:15px;
    background:#fff;
}

.bd-testi-lightbox-close{
    position:absolute;
    top:20px;
    right:20px;
    width:44px;
    height:44px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border:1px solid rgba(255,255,255,.18);
    border-radius:50%;
    background:rgba(255,255,255,.1);
    color:#fff;
    cursor:pointer;
}

.bd-testi-lightbox-close svg{
    width:18px;
    height:18px;
}

body.bd-testi-modal-open{
    overflow:hidden;
}

@media(max-width:390px){
    html[data-baca-device="phone"] .bd-testi-container{
        padding:0 14px;
    }

    html[data-baca-device="phone"] .bd-testi-heading h2{
        font-size:29px;
    }

    html[data-baca-device="phone"] .bd-testi-card,
    html[data-baca-device="phone"] .bd-testi-controls{
        width:min(100%,265px);
    }
}

@media(prefers-reduced-motion:reduce){
    .bd-testi-card,
    .bd-testi-dot span,
    .bd-testi-lightbox{
        transition:none!important;
    }
}
</style>

<script>
(function(){
    function initBacaTestimoni(){
        const section=document.getElementById('testimoni');

        if(!section||section.dataset.testiReady==='1') return;
        section.dataset.testiReady='1';

        const cards=[...section.querySelectorAll('[data-testi-card]')];
        const dots=[...section.querySelectorAll('[data-testi-dot]')];
        const openButtons=[...section.querySelectorAll('[data-testi-open]')];

        const stage=section.querySelector('#bdTestiStage');
        const prev=section.querySelector('#bdTestiPrev');
        const next=section.querySelector('#bdTestiNext');
        const current=section.querySelector('#bdTestiCurrent');
        const headerCurrent=section.querySelector('#bdTestiHeaderCurrent');
        const infoNumber=section.querySelector('#bdTestiInfoNumber');
        const infoLabel=section.querySelector('#bdTestiInfoLabel');
        const infoName=section.querySelector('#bdTestiInfoName');

        const lightbox=section.querySelector('#bdTestiLightbox');
        const lightboxImage=section.querySelector('#bdTestiLightboxImage');
        const lightboxClose=section.querySelector('#bdTestiLightboxClose');

        if(!cards.length) return;

        const items=@json($testimoniItems);
        const gsap=window.bdGsap||null;

        const reduceMotion=
            window.matchMedia('(prefers-reduced-motion:reduce)').matches;

        let activeIndex=0;
        let autoplay=null;
        let startX=0;
        let startY=0;

        function getDevice(){
            return window.BacaDevice||{
                type:
                    window.innerWidth<=767
                        ? 'phone'
                        : (
                            window.innerWidth<=1023
                                ? 'tablet'
                                : 'desktop'
                        ),
                touch:navigator.maxTouchPoints>0
            };
        }

        function isTouch(){
            const d=getDevice();

            return d.touch===true||
                d.type!=='desktop';
        }

        function updateContent(){
            const number=
                String(activeIndex+1)
                    .padStart(2,'0');

            if(current){
                current.textContent=number;
            }

            if(headerCurrent){
                headerCurrent.textContent=number;
            }

            if(infoNumber){
                infoNumber.textContent=number;
            }

            if(infoLabel&&items[activeIndex]){
                infoLabel.textContent=
                    items[activeIndex].label;
            }

            if(infoName&&items[activeIndex]){
                infoName.textContent=
                    items[activeIndex].name;
            }

            cards.forEach((card,index)=>{
                card.classList.toggle(
                    'is-active',
                    index===activeIndex
                );
            });

            dots.forEach((dot,index)=>{
                dot.classList.toggle(
                    'is-active',
                    index===activeIndex
                );
            });
        }

        function animateTouchCard(card,direction){
            if(!card||reduceMotion){
                return;
            }

            if(gsap){
                gsap.fromTo(
                    card,
                    {
                        opacity:0,
                        x:direction>0?24:-24,
                        scale:.985
                    },
                    {
                        opacity:1,
                        x:0,
                        scale:1,
                        duration:.34,
                        ease:'power3.out',
                        clearProps:'transform,opacity'
                    }
                );

                return;
            }

            card.animate(
                [
                    {
                        opacity:0,
                        transform:
                            direction>0
                                ? 'translateX(24px) scale(.985)'
                                : 'translateX(-24px) scale(.985)'
                    },
                    {
                        opacity:1,
                        transform:'translateX(0) scale(1)'
                    }
                ],
                {
                    duration:340,
                    easing:'cubic-bezier(.22,.8,.25,1)'
                }
            );
        }

        function renderTouch(direction=1,animate=false){
            cards.forEach((card,index)=>{
                card.style.display=
                    index===activeIndex
                        ? 'block'
                        : 'none';

                card.style.transform='none';
                card.style.opacity='1';
                card.style.visibility='visible';

                card.style.pointerEvents=
                    index===activeIndex
                        ? 'auto'
                        : 'none';
            });

            if(animate){
                animateTouchCard(
                    cards[activeIndex],
                    direction
                );
            }
        }

        function renderDesktop(){
            const total=cards.length;

            const offset=
                window.innerWidth<=1200
                    ? 245
                    : 270;

            cards.forEach((card,index)=>{
                card.style.display='block';

                let relative=
                    index-activeIndex;

                if(relative>total/2){
                    relative-=total;
                }

                if(relative<-(total/2)){
                    relative+=total;
                }

                let x=0;
                let scale=1;
                let rotate=0;
                let opacity=1;
                let z=10;
                let visibility='visible';
                let pointer='auto';

                if(relative===1){
                    x=offset;
                    scale=.82;
                    rotate=-7;
                    opacity=.58;
                    z=7;
                }
                else if(relative===-1){
                    x=-offset;
                    scale=.82;
                    rotate=7;
                    opacity=.58;
                    z=7;
                }
                else if(relative===2){
                    x=offset*1.6;
                    scale=.67;
                    rotate=-10;
                    opacity=.15;
                    z=3;
                }
                else if(relative===-2){
                    x=-(offset*1.6);
                    scale=.67;
                    rotate=10;
                    opacity=.15;
                    z=3;
                }
                else if(relative!==0){
                    opacity=0;
                    visibility='hidden';
                    pointer='none';
                    z=1;
                }

                card.style.setProperty(
                    '--testi-x',
                    x+'px'
                );

                card.style.setProperty(
                    '--testi-scale',
                    scale
                );

                card.style.setProperty(
                    '--testi-rotate',
                    rotate+'deg'
                );

                card.style.opacity=opacity;
                card.style.visibility=visibility;
                card.style.zIndex=z;
                card.style.pointerEvents=pointer;
            });
        }

        function render(
            direction=1,
            animate=false
        ){
            updateContent();

            if(isTouch()){
                renderTouch(
                    direction,
                    animate
                );
            }
            else{
                renderDesktop();
            }
        }

        function goTo(
            index,
            direction=1
        ){
            activeIndex=
                (
                    index+
                    cards.length
                )%
                cards.length;

            render(
                direction,
                true
            );
        }

        function previous(){
            goTo(
                activeIndex-1,
                -1
            );
        }

        function nextSlide(){
            goTo(
                activeIndex+1,
                1
            );
        }

        function stopAutoplay(){
            if(autoplay){
                clearInterval(autoplay);
                autoplay=null;
            }
        }

        function startAutoplay(){
            stopAutoplay();

            if(
                isTouch()||
                reduceMotion||
                cards.length<=1
            ){
                return;
            }

            autoplay=
                setInterval(
                    nextSlide,
                    5200
                );
        }

        prev?.addEventListener(
            'click',
            event=>{
                event.preventDefault();

                stopAutoplay();
                previous();
                startAutoplay();
            }
        );

        next?.addEventListener(
            'click',
            event=>{
                event.preventDefault();

                stopAutoplay();
                nextSlide();
                startAutoplay();
            }
        );

        dots.forEach(
            (dot,index)=>{
                dot.addEventListener(
                    'click',
                    ()=>{
                        stopAutoplay();

                        goTo(
                            index,
                            index>=activeIndex
                                ? 1
                                : -1
                        );

                        startAutoplay();
                    }
                );
            }
        );

        stage?.addEventListener(
            'touchstart',
            event=>{
                if(!isTouch()){
                    return;
                }

                const touch=
                    event.touches[0];

                startX=
                    touch.clientX;

                startY=
                    touch.clientY;
            },
            {
                passive:true
            }
        );

        stage?.addEventListener(
            'touchend',
            event=>{
                if(!isTouch()){
                    return;
                }

                const touch=
                    event.changedTouches[0];

                const dx=
                    touch.clientX-startX;

                const dy=
                    touch.clientY-startY;

                if(
                    Math.abs(dx)<42||
                    Math.abs(dx)<Math.abs(dy)
                ){
                    return;
                }

                stopAutoplay();

                if(dx<0){
                    nextSlide();
                }
                else{
                    previous();
                }

                startAutoplay();
            },
            {
                passive:true
            }
        );

        cards.forEach(
            (card,index)=>{
                card.addEventListener(
                    'click',
                    event=>{
                        if(
                            isTouch()||
                            index===activeIndex
                        ){
                            return;
                        }

                        event.preventDefault();
                        event.stopPropagation();

                        stopAutoplay();

                        goTo(
                            index,
                            index>activeIndex
                                ? 1
                                : -1
                        );

                        startAutoplay();
                    }
                );
            }
        );

        function openLightbox(index){
            if(
                !lightbox||
                !lightboxImage||
                !items[index]
            ){
                return;
            }

            lightboxImage.src=
                items[index].image;

            lightboxImage.alt=
                items[index].alt;

            lightbox.classList.add(
                'is-open'
            );

            lightbox.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body.classList.add(
                'bd-testi-modal-open'
            );

            stopAutoplay();
        }

        function closeLightbox(){
            if(!lightbox){
                return;
            }

            lightbox.classList.remove(
                'is-open'
            );

            lightbox.setAttribute(
                'aria-hidden',
                'true'
            );

            document.body.classList.remove(
                'bd-testi-modal-open'
            );

            startAutoplay();
        }

        openButtons.forEach(
            (button,index)=>{
                button.addEventListener(
                    'click',
                    event=>{
                        if(
                            !isTouch()&&
                            index!==activeIndex
                        ){
                            event.preventDefault();
                            return;
                        }

                        openLightbox(index);
                    }
                );
            }
        );

        lightboxClose?.addEventListener(
            'click',
            closeLightbox
        );

        lightbox?.addEventListener(
            'click',
            event=>{
                if(event.target===lightbox){
                    closeLightbox();
                }
            }
        );

        document.addEventListener(
            'keydown',
            event=>{
                if(event.key==='Escape'){
                    closeLightbox();
                }
            }
        );

        section.addEventListener(
            'mouseenter',
            ()=>{
                if(!isTouch()){
                    stopAutoplay();
                }
            }
        );

        section.addEventListener(
            'mouseleave',
            ()=>{
                if(!isTouch()){
                    startAutoplay();
                }
            }
        );

        window.addEventListener(
            'baca:devicechange',
            ()=>{
                render(1,false);
                startAutoplay();
            }
        );

        render(1,false);
        startAutoplay();
    }

    if(document.readyState==='loading'){
        document.addEventListener(
            'DOMContentLoaded',
            initBacaTestimoni,
            {
                once:true
            }
        );
    }
    else{
        initBacaTestimoni();
    }
})();
</script>