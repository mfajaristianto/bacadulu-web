@php
$testimoni=[
    ['image'=>asset('img/cta1.jpg'),'alt'=>'Testimoni Baca Dulu 1'],
    ['image'=>asset('img/cta2.jpg'),'alt'=>'Testimoni Baca Dulu 2'],
    ['image'=>asset('img/cta3.jpg'),'alt'=>'Testimoni Baca Dulu 3'],
    ['image'=>asset('img/waa.jpg'),'alt'=>'Testimoni Baca Dulu 4'],
    ['image'=>asset('img/ajar.jpg'),'alt'=>'Testimoni Baca Dulu 5'],
    ['image'=>asset('img/Bentara.jpg'),'alt'=>'Testimoni Baca Dulu 6'],
    ['image'=>asset('img/Fdi.jpg'),'alt'=>'Testimoni Baca Dulu 7'],
];
@endphp

<section id="testimoni" class="bdt-section">

    <div class="bdt-glow bdt-glow-one"></div>
    <div class="bdt-glow bdt-glow-two"></div>

    <div class="bdt-container">

        {{-- HEADER --}}
        <div class="bdt-header" data-bdt-reveal>

            <div class="bdt-header-content">

                <div class="bdt-eyebrow">
                    <span class="bdt-eyebrow-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M8.5 12l2.2 2.2L15.8 9"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                    </span>

                    <span>Pengalaman Penulis</span>
                </div>

                <h2>
                    Cerita dari Mereka yang
                    <span>Percaya pada Baca Dulu</span>
                </h2>

                <p>
                    Pengalaman penulis dan mitra yang telah melalui proses
                    penerbitan dan kolaborasi bersama Baca Dulu.
                </p>

            </div>

            <div class="bdt-header-actions">

                <button
                    type="button"
                    class="bdt-nav"
                    id="bdtPrev"
                    aria-label="Testimoni sebelumnya"
                >
                    <svg viewBox="0 0 24 24">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>

                <button
                    type="button"
                    class="bdt-nav"
                    id="bdtNext"
                    aria-label="Testimoni berikutnya"
                >
                    <svg viewBox="0 0 24 24">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>

            </div>

        </div>

        {{-- CAROUSEL --}}
        <div class="bdt-carousel" data-bdt-reveal>

            <div class="bdt-viewport" id="bdtViewport">

                <div class="bdt-track" id="bdtTrack">

                    @foreach($testimoni as $index=>$item)

                        <article class="bdt-slide">

                            <button
                                type="button"
                                class="bdt-card"
                                data-bdt-image="{{ $item['image'] }}"
                                aria-label="Buka testimoni {{ $index+1 }}"
                            >

                                <div class="bdt-card-image">

                                    <img
                                        src="{{ $item['image'] }}"
                                        alt="{{ $item['alt'] }}"
                                        loading="lazy"
                                    >

                                    <div class="bdt-card-overlay">

                                        <div class="bdt-view">
                                            <svg viewBox="0 0 24 24">
                                                <circle cx="11" cy="11" r="7"/>
                                                <path d="M20 20l-4-4"/>
                                                <path d="M11 8v6M8 11h6"/>
                                            </svg>
                                        </div>

                                    </div>

                                    <div class="bdt-shine"></div>

                                </div>

                                <div class="bdt-card-bottom">

                                    <div class="bdt-verified">
                                        <svg viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M8.5 12l2.2 2.2L15.8 9"/>
                                        </svg>

                                        <span>Testimoni Penulis</span>
                                    </div>

                                    <span class="bdt-index">
                                        {{ str_pad($index+1,2,'0',STR_PAD_LEFT) }}
                                    </span>

                                </div>

                            </button>

                        </article>

                    @endforeach

                </div>

            </div>

            {{-- PROGRESS --}}
            <div class="bdt-progress-row">

                <div class="bdt-progress">
                    <span id="bdtProgress"></span>
                </div>

                <div class="bdt-counter">
                    <span id="bdtCurrent">01</span>
                    <span>/</span>
                    <span>{{ str_pad(count($testimoni),2,'0',STR_PAD_LEFT) }}</span>
                </div>

            </div>

        </div>

    </div>

    {{-- LIGHTBOX --}}
    <div class="bdt-lightbox" id="bdtLightbox" aria-hidden="true">

        <button
            type="button"
            class="bdt-lightbox-overlay"
            data-bdt-close
            aria-label="Tutup gambar"
        ></button>

        <div class="bdt-lightbox-content">

            <button
                type="button"
                class="bdt-lightbox-close"
                data-bdt-close
                aria-label="Tutup"
            >
                <svg viewBox="0 0 24 24">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>

            <img
                src=""
                id="bdtLightboxImage"
                alt="Testimoni Baca Dulu"
            >

        </div>

    </div>

</section>

<style>
.bdt-section{
    --navy:#241B52;
    --orange:#EF5843;
    --gold:#F7AA35;
    --muted:#64748B;
    --border:#E8E7EC;
    --ease:cubic-bezier(.22,1,.36,1);
    position:relative;
    padding:85px 0 90px;
    overflow:hidden;
    background:linear-gradient(180deg,#fff 0%,#FCFBF8 100%);
    font-family:'Inter',sans-serif;
}

.bdt-section *{
    box-sizing:border-box;
}

.bdt-container{
    position:relative;
    z-index:2;
    width:100%;
    max-width:1450px;
    margin:auto;
    padding:0 32px;
}

/* BACKGROUND */
.bdt-glow{
    position:absolute;
    border-radius:50%;
    filter:blur(120px);
    pointer-events:none;
}

.bdt-glow-one{
    width:380px;
    height:380px;
    left:-250px;
    top:50px;
    background:rgba(239,88,67,.08);
}

.bdt-glow-two{
    width:380px;
    height:380px;
    right:-230px;
    bottom:0;
    background:rgba(36,27,82,.06);
}

/* HEADER */
.bdt-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:30px;
    margin-bottom:38px;
}

.bdt-header-content{
    max-width:750px;
}

.bdt-eyebrow{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:10px;
    color:var(--orange);
}

.bdt-eyebrow-icon{
    width:26px;
    height:26px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    background:#FFF1EC;
}

.bdt-eyebrow-icon svg{
    width:14px;
    height:14px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bdt-eyebrow>span:last-child{
    font-size:10px;
    font-weight:800;
    letter-spacing:1.2px;
    text-transform:uppercase;
}

.bdt-header h2{
    margin:0;
    color:var(--navy);
    font-family:'Poppins',sans-serif;
    font-size:clamp(29px,3vw,40px);
    font-weight:800;
    line-height:1.18;
    letter-spacing:-.8px;
}

.bdt-header h2 span{
    color:var(--orange);
}

.bdt-header p{
    max-width:650px;
    margin:11px 0 0;
    color:var(--muted);
    font-size:13px;
    line-height:1.7;
}

.bdt-header-actions{
    display:flex;
    align-items:center;
    gap:8px;
}

.bdt-nav{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border:1px solid var(--border);
    border-radius:12px;
    color:var(--navy);
    background:#fff;
    cursor:pointer;
    transition:
        transform .25s var(--ease),
        color .25s ease,
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}

.bdt-nav:hover{
    transform:translateY(-2px);
    color:#fff;
    border-color:var(--orange);
    background:var(--orange);
    box-shadow:0 8px 20px rgba(239,88,67,.16);
}

.bdt-nav:active{
    transform:scale(.94);
}

.bdt-nav svg{
    width:17px;
    height:17px;
    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
}

/* CAROUSEL */
.bdt-carousel{
    position:relative;
}

.bdt-viewport{
    width:100%;
    overflow:hidden;
    padding:5px 1px 25px;
}

.bdt-track{
    display:flex;
    gap:16px;
    transition:transform .7s var(--ease);
    will-change:transform;
}

/*
|--------------------------------------------------------------------------
| DESKTOP = 5 TESTIMONI
|--------------------------------------------------------------------------
*/

.bdt-slide{
    flex:0 0 calc((100% - 64px) / 5);
    min-width:0;
}

/* CARD */
.bdt-card{
    --rx:0deg;
    --ry:0deg;
    position:relative;
    display:block;
    width:100%;
    padding:0;
    overflow:hidden;
    border:1px solid var(--border);
    border-radius:18px;
    background:#fff;
    text-align:left;
    cursor:pointer;
    box-shadow:0 5px 18px rgba(36,27,82,.045);
    transform:
        perspective(900px)
        rotateX(var(--rx))
        rotateY(var(--ry));
    transform-style:preserve-3d;
    transition:
        transform .35s var(--ease),
        box-shadow .35s ease,
        border-color .35s ease;
}

.bdt-card:hover{
    border-color:rgba(239,88,67,.25);
    box-shadow:0 18px 35px rgba(36,27,82,.1);
}

.bdt-card-image{
    position:relative;
    width:100%;
    height:300px;
    overflow:hidden;
    background:#F3F3F5;
}

.bdt-card-image img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center;
    transition:
        transform .55s var(--ease),
        filter .4s ease;
}

.bdt-card:hover .bdt-card-image img{
    transform:scale(1.04);
    filter:saturate(1.03);
}

/* OVERLAY */
.bdt-card-overlay{
    position:absolute;
    inset:0;
    z-index:2;
    display:flex;
    align-items:center;
    justify-content:center;
    opacity:0;
    background:rgba(36,27,82,.08);
    transition:.3s ease;
}

.bdt-card:hover .bdt-card-overlay{
    opacity:1;
}

.bdt-view{
    width:43px;
    height:43px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(255,255,255,.55);
    border-radius:50%;
    color:#fff;
    background:rgba(36,27,82,.7);
    backdrop-filter:blur(8px);
    transform:scale(.8);
    transition:.3s var(--ease);
}

.bdt-card:hover .bdt-view{
    transform:scale(1);
}

.bdt-view svg{
    width:18px;
    height:18px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

/* SHINE */
.bdt-shine{
    position:absolute;
    z-index:2;
    top:-100%;
    left:-70%;
    width:40%;
    height:300%;
    opacity:0;
    pointer-events:none;
    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.26),
            transparent
        );
    transform:rotate(18deg);
}

.bdt-card:hover .bdt-shine{
    opacity:1;
    animation:bdtShine .9s ease forwards;
}

/* CARD BOTTOM */
.bdt-card-bottom{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding:11px 13px;
    border-top:1px solid #F1F5F9;
}

.bdt-verified{
    display:flex;
    align-items:center;
    gap:6px;
}

.bdt-verified svg{
    width:13px;
    height:13px;
    fill:none;
    stroke:#16A34A;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bdt-verified span{
    color:#64748B;
    font-size:8px;
    font-weight:700;
}

.bdt-index{
    color:#CBD5E1;
    font-size:9px;
    font-weight:900;
    letter-spacing:.8px;
}

/* PROGRESS */
.bdt-progress-row{
    display:flex;
    align-items:center;
    gap:16px;
}

.bdt-progress{
    position:relative;
    flex:1;
    height:2px;
    overflow:hidden;
    border-radius:999px;
    background:#E8E7EC;
}

.bdt-progress span{
    position:absolute;
    left:0;
    top:0;
    width:0;
    height:100%;
    border-radius:999px;
    background:linear-gradient(90deg,var(--orange),var(--gold));
}

.bdt-counter{
    display:flex;
    align-items:center;
    gap:4px;
    flex-shrink:0;
    color:#94A3B8;
    font-size:9px;
    font-weight:700;
    letter-spacing:.6px;
}

.bdt-counter span:first-child{
    color:var(--orange);
}

/* REVEAL */
[data-bdt-reveal]{
    opacity:0;
    filter:blur(3px);
    transform:translateY(32px);
    transition:
        opacity .75s ease,
        transform .75s var(--ease),
        filter .75s ease;
}

[data-bdt-reveal].bdt-visible{
    opacity:1;
    filter:none;
    transform:none;
}

/* LIGHTBOX */
.bdt-lightbox{
    position:fixed;
    inset:0;
    z-index:99999;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:30px;
    opacity:0;
    visibility:hidden;
    transition:
        opacity .3s ease,
        visibility .3s ease;
}

.bdt-lightbox.open{
    opacity:1;
    visibility:visible;
}

.bdt-lightbox-overlay{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    padding:0;
    border:0;
    background:rgba(12,9,29,.88);
    backdrop-filter:blur(10px);
    cursor:zoom-out;
}

.bdt-lightbox-content{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    justify-content:center;
    width:min(1050px,94vw);
    max-height:88vh;
    transform:scale(.94) translateY(12px);
    transition:transform .35s var(--ease);
}

.bdt-lightbox.open .bdt-lightbox-content{
    transform:none;
}

.bdt-lightbox-content img{
    display:block;
    max-width:100%;
    max-height:88vh;
    object-fit:contain;
    border-radius:16px;
    box-shadow:0 35px 100px rgba(0,0,0,.42);
}

.bdt-lightbox-close{
    position:absolute;
    z-index:4;
    top:-17px;
    right:-17px;
    width:43px;
    height:43px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border:1px solid rgba(255,255,255,.25);
    border-radius:50%;
    color:#fff;
    background:var(--navy);
    cursor:pointer;
    transition:.25s ease;
}

.bdt-lightbox-close:hover{
    background:var(--orange);
    transform:rotate(90deg);
}

.bdt-lightbox-close svg{
    width:18px;
    height:18px;
    fill:none;
    stroke:currentColor;
    stroke-width:2;
    stroke-linecap:round;
}

/* ANIMATION */
@keyframes bdtShine{
    from{
        transform:
            rotate(18deg)
            translateX(-200%);
    }

    to{
        transform:
            rotate(18deg)
            translateX(600%);
    }
}

/*
|--------------------------------------------------------------------------
| TABLET = 3
|--------------------------------------------------------------------------
*/

@media(max-width:1100px){

    .bdt-slide{
        flex:0 0 calc((100% - 32px) / 3);
    }

    .bdt-card-image{
        height:320px;
    }

}

/*
|--------------------------------------------------------------------------
| MOBILE = 1.25
|--------------------------------------------------------------------------
*/

@media(max-width:640px){

    .bdt-section{
        padding:62px 0;
    }

    .bdt-container{
        padding:0 18px;
    }

    .bdt-header{
        align-items:flex-start;
        margin-bottom:28px;
    }

    .bdt-header h2{
        font-size:28px;
    }

    .bdt-header p{
        font-size:12px;
    }

    .bdt-header-actions{
        display:none;
    }

    .bdt-viewport{
        overflow-x:auto;
        scroll-snap-type:x mandatory;
        scrollbar-width:none;
        padding-bottom:20px;
    }

    .bdt-viewport::-webkit-scrollbar{
        display:none;
    }

    .bdt-track{
        gap:12px;
        transition:none;
        transform:none!important;
    }

    .bdt-slide{
        flex:0 0 82%;
        scroll-snap-align:start;
    }

    .bdt-card-image{
        height:360px;
    }

    .bdt-card{
        --rx:0deg!important;
        --ry:0deg!important;
    }

}

/* REDUCE MOTION */
@media(prefers-reduced-motion:reduce){

    [data-bdt-reveal]{
        opacity:1!important;
        filter:none!important;
        transform:none!important;
        transition:none!important;
    }

    .bdt-track,
    .bdt-card,
    .bdt-card-image img{
        transition:none!important;
    }

    .bdt-card{
        transform:none!important;
    }

    .bdt-shine{
        display:none;
    }

}
</style>

<script>
(function(){

    function initTestimonialSlider(){

        const section=
            document.getElementById('testimoni');

        if(
            !section ||
            section.dataset.ready==='1'
        ){
            return;
        }

        section.dataset.ready='1';

        const viewport=
            document.getElementById('bdtViewport');

        const track=
            document.getElementById('bdtTrack');

        const prev=
            document.getElementById('bdtPrev');

        const next=
            document.getElementById('bdtNext');

        const progress=
            document.getElementById('bdtProgress');

        const currentText=
            document.getElementById('bdtCurrent');

        const lightbox=
            document.getElementById('bdtLightbox');

        const lightboxImage=
            document.getElementById('bdtLightboxImage');

        const closeButtons=
            section.querySelectorAll('[data-bdt-close]');

        const reduceMotion=
            window.matchMedia(
                '(prefers-reduced-motion:reduce)'
            ).matches;

        let slides=[
            ...track.querySelectorAll('.bdt-slide')
        ];

        if(!slides.length){
            return;
        }

        let index=0;
        let timer=null;
        let resizeTimer=null;
        let progressTimer=null;

        const duration=4200;


        /*
        |--------------------------------------------------------------------------
        | VISIBLE COUNT
        |--------------------------------------------------------------------------
        */

        function visibleCount(){

            if(window.innerWidth<=640){
                return 1;
            }

            if(window.innerWidth<=1100){
                return 3;
            }

            return 5;

        }


        /*
        |--------------------------------------------------------------------------
        | MAX INDEX
        |--------------------------------------------------------------------------
        */

        function maxIndex(){

            return Math.max(
                0,
                slides.length-visibleCount()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SLIDE WIDTH
        |--------------------------------------------------------------------------
        */

        function getStep(){

            if(!slides[0]){
                return 0;
            }

            const rect=
                slides[0]
                    .getBoundingClientRect();

            const style=
                window.getComputedStyle(track);

            const gap=
                parseFloat(style.gap)||0;

            return rect.width+gap;

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        function updateSlider(
            animated=true
        ){

            if(
                window.innerWidth<=640
            ){
                return;
            }

            const step=
                getStep();

            if(!animated){

                track.style.transition=
                    'none';

            }else{

                track.style.transition=
                    'transform .7s cubic-bezier(.22,1,.36,1)';

            }

            track.style.transform=
                `translate3d(-${index*step}px,0,0)`;

            if(currentText){

                currentText.textContent=
                    String(index+1)
                        .padStart(
                            2,
                            '0'
                        );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | NEXT
        |--------------------------------------------------------------------------
        */

        function nextSlide(){

            if(
                window.innerWidth<=640
            ){
                return;
            }

            const maximum=
                maxIndex();

            if(maximum<=0){
                return;
            }

            if(index>=maximum){

                index=0;

            }else{

                index++;

            }

            updateSlider();
            restartProgress();

        }


        /*
        |--------------------------------------------------------------------------
        | PREVIOUS
        |--------------------------------------------------------------------------
        */

        function prevSlide(){

            if(
                window.innerWidth<=640
            ){
                return;
            }

            const maximum=
                maxIndex();

            if(maximum<=0){
                return;
            }

            if(index<=0){

                index=maximum;

            }else{

                index--;

            }

            updateSlider();
            restartProgress();

        }


        /*
        |--------------------------------------------------------------------------
        | PROGRESS
        |--------------------------------------------------------------------------
        */

        function restartProgress(){

            if(
                reduceMotion ||
                !progress
            ){
                return;
            }

            clearTimeout(
                progressTimer
            );

            progress.style.transition=
                'none';

            progress.style.width=
                '0%';

            requestAnimationFrame(
                ()=>{

                    requestAnimationFrame(
                        ()=>{

                            progress.style.transition=
                                `width ${duration}ms linear`;

                            progress.style.width=
                                '100%';

                        }
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | AUTOPLAY
        |--------------------------------------------------------------------------
        */

        function stop(){

            if(timer){

                clearInterval(
                    timer
                );

                timer=null;

            }

            if(progress){

                progress.style.transition=
                    'none';

            }

        }


        function start(){

            stop();

            if(
                reduceMotion ||
                window.innerWidth<=640 ||
                slides.length<=visibleCount()
            ){
                return;
            }

            restartProgress();

            timer=
                setInterval(
                    nextSlide,
                    duration
                );

        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        prev?.addEventListener(
            'click',
            ()=>{

                prevSlide();
                start();

            }
        );


        next?.addEventListener(
            'click',
            ()=>{

                nextSlide();
                start();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PAUSE HOVER
        |--------------------------------------------------------------------------
        */

        viewport?.addEventListener(
            'mouseenter',
            ()=>{

                if(
                    window.innerWidth>640
                ){
                    stop();
                }

            }
        );


        viewport?.addEventListener(
            'mouseleave',
            ()=>{

                if(
                    window.innerWidth>640 &&
                    !lightbox?.classList
                        .contains('open')
                ){
                    start();
                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CARD TILT
        |--------------------------------------------------------------------------
        */

        if(!reduceMotion){

            section
                .querySelectorAll(
                    '.bdt-card'
                )
                .forEach(card=>{

                    card.addEventListener(
                        'pointermove',
                        event=>{

                            if(
                                window.innerWidth<
                                768
                            ){
                                return;
                            }

                            const rect=
                                card
                                    .getBoundingClientRect();

                            const x=
                                (
                                    event.clientX-
                                    rect.left
                                )/
                                rect.width;

                            const y=
                                (
                                    event.clientY-
                                    rect.top
                                )/
                                rect.height;

                            card.style
                                .setProperty(
                                    '--rx',
                                    `${(.5-y)*2.5}deg`
                                );

                            card.style
                                .setProperty(
                                    '--ry',
                                    `${(x-.5)*3.5}deg`
                                );

                        }
                    );

                    card.addEventListener(
                        'pointerleave',
                        ()=>{

                            card.style
                                .setProperty(
                                    '--rx',
                                    '0deg'
                                );

                            card.style
                                .setProperty(
                                    '--ry',
                                    '0deg'
                                );

                        }
                    );

                });

        }


        /*
        |--------------------------------------------------------------------------
        | LIGHTBOX
        |--------------------------------------------------------------------------
        */

        function openLightbox(
            image
        ){

            if(
                !lightbox ||
                !lightboxImage
            ){
                return;
            }

            lightboxImage.src=
                image;

            lightbox.classList
                .add(
                    'open'
                );

            lightbox.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body
                .style
                .overflow=
                'hidden';

            stop();

        }


        function closeLightbox(){

            if(!lightbox){
                return;
            }

            lightbox.classList
                .remove(
                    'open'
                );

            lightbox.setAttribute(
                'aria-hidden',
                'true'
            );

            document.body
                .style
                .overflow=
                '';

            setTimeout(
                ()=>{

                    if(
                        lightboxImage &&
                        !lightbox
                            .classList
                            .contains(
                                'open'
                            )
                    ){

                        lightboxImage.src=
                            '';

                    }

                },
                300
            );

            start();

        }


        section
            .querySelectorAll(
                '.bdt-card'
            )
            .forEach(card=>{

                card.addEventListener(
                    'click',
                    ()=>{

                        openLightbox(
                            card.dataset
                                .bdtImage
                        );

                    }
                );

            });


        closeButtons
            .forEach(button=>{

                button.addEventListener(
                    'click',
                    closeLightbox
                );

            });


        document.addEventListener(
            'keydown',
            event=>{

                if(
                    event.key===
                    'Escape' &&
                    lightbox
                        ?.classList
                        .contains(
                            'open'
                        )
                ){

                    closeLightbox();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SCROLL REVEAL
        |--------------------------------------------------------------------------
        */

        const reveals=[
            ...section.querySelectorAll(
                '[data-bdt-reveal]'
            )
        ];

        if(!reduceMotion){

            const observer=
                new IntersectionObserver(
                    entries=>{

                        entries.forEach(
                            entry=>{

                                if(
                                    entry.isIntersecting
                                ){

                                    entry.target
                                        .classList
                                        .add(
                                            'bdt-visible'
                                        );

                                }else{

                                    entry.target
                                        .classList
                                        .remove(
                                            'bdt-visible'
                                        );

                                }

                            }
                        );

                    },
                    {
                        threshold:.08,
                        rootMargin:
                            '0px 0px -5% 0px'
                    }
                );

            reveals.forEach(
                element=>
                    observer.observe(
                        element
                    )
            );

        }else{

            reveals.forEach(
                element=>
                    element.classList
                        .add(
                            'bdt-visible'
                        )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | RESIZE
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            ()=>{

                clearTimeout(
                    resizeTimer
                );

                resizeTimer=
                    setTimeout(
                        ()=>{

                            index=
                                Math.min(
                                    index,
                                    maxIndex()
                                );

                            updateSlider(
                                false
                            );

                            start();

                        },
                        150
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | TAB VISIBILITY
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'visibilitychange',
            ()=>{

                if(
                    document.hidden
                ){

                    stop();

                }else if(
                    !lightbox
                        ?.classList
                        .contains(
                            'open'
                        )
                ){

                    start();

                }

            }
        );


        updateSlider(
            false
        );

        start();

    }


    if(
        document.readyState===
        'loading'
    ){

        document.addEventListener(
            'DOMContentLoaded',
            initTestimonialSlider
        );

    }else{

        initTestimonialSlider();

    }

})();
</script>