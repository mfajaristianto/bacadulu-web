<section id="home" class="bd-hero relative w-full min-h-[640px] flex items-center overflow-hidden">
    <div class="bd-hero-bg absolute inset-0 z-0">
        <img src="{{ asset('img/home.jpg') }}" class="bd-hero-slide bd-hero-active absolute inset-0 w-full h-full object-cover" alt="">
        <img src="{{ asset('img/transisi-1.jpg') }}" class="bd-hero-slide absolute inset-0 w-full h-full object-cover" alt="">
        <img src="{{ asset('img/transisi-2.jpg') }}" class="bd-hero-slide absolute inset-0 w-full h-full object-cover" alt="">

        <div class="absolute inset-0 z-[2] bg-gradient-to-r from-black/85 via-black/62 to-black/25"></div>
        <div class="absolute inset-0 z-[3] bd-hero-grid"></div>
        <div class="bd-hero-glow absolute -right-32 top-16 z-[3] w-[430px] h-[430px] rounded-full bg-orange-500/20 blur-[120px] pointer-events-none"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-center">
        <div class="bd-hero-copy lg:col-span-7 text-white">
            <div class="bd-hero-badge inline-flex items-center gap-2 px-4 py-2 mb-5 rounded-full bg-white/10 backdrop-blur-md border border-white/15">
                <svg class="w-4 h-4 text-[#F7AA35]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                </svg>
                <span class="text-[11px] sm:text-xs font-bold">Penerbitan Buku Akademik dan Ilmiah</span>
            </div>

            <h1 class="bd-hero-title font-black text-white">
                <span class="bd-hero-line">
                    <span>Wujudkan Karya Ilmiah</span>
                </span>
                <span class="bd-hero-line">
                    <span><em>Berkualitas</em> dan Berdampak</span>
                </span>
            </h1>

            <p class="bd-hero-desc">
                Kami membantu penerbitan Buku Ajar, Buku Referensi, Monograf, Book Chapter, Jurnal Ilmiah hingga Proceeding dalam bentuk Buku Cetak maupun E-Book.
            </p>

            <a href="https://wa.me/6285139461070"
               target="_blank"
               rel="noopener noreferrer"
               class="bd-wa-btn">
                <img src="{{ asset('img/waa.jpg') }}" alt="WhatsApp" class="w-6 h-6 rounded-full object-cover">
                <span>Hubungi via WhatsApp</span>
                <svg class="bd-wa-arrow" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="hidden lg:flex lg:col-span-5 justify-center items-center">
            <div class="bd-hero-visual relative">
                <div class="bd-hero-orbit bd-orbit-one"></div>
                <div class="bd-hero-orbit bd-orbit-two"></div>

                <div class="bd-floating-book">
                    <div class="bd-book-spine"></div>
                    <div class="bd-book-pages"></div>

                    <div class="bd-book-cover">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>

                        <span>BACA DULU</span>
                        <strong>ACADEMIC<br>PUBLISHING</strong>
                        <small>ISBN • HAKI • DISTRIBUSI</small>
                    </div>
                </div>

                <div class="bd-floating-card bd-card-isbn">
                    <div class="bd-card-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M8.5 12l2.2 2.2L15.8 9"/>
                        </svg>
                    </div>
                    <div>
                        <strong>ISBN</strong>
                        <small>Perpusnas RI</small>
                    </div>
                </div>

                <div class="bd-floating-card bd-card-haki">
                    <div class="bd-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <strong>HAKI</strong>
                        <small>Perlindungan Karya</small>
                    </div>
                </div>

                <div class="bd-floating-card bd-card-ebook">
                    <div class="bd-card-icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="5" y="3" width="14" height="18" rx="2"/>
                            <path d="M9 7h6M9 11h6"/>
                        </svg>
                    </div>
                    <div>
                        <strong>E-Book</strong>
                        <small>Distribusi Digital</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bd-hero-dots absolute z-20 bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2">
        <button type="button" class="bd-hero-dot active" data-slide="0" aria-label="Slide 1"></button>
        <button type="button" class="bd-hero-dot" data-slide="1" aria-label="Slide 2"></button>
        <button type="button" class="bd-hero-dot" data-slide="2" aria-label="Slide 3"></button>
    </div>
</section>

<style>
.bd-hero{background:#111122;perspective:1400px}
.bd-hero-bg{transform-origin:center top;will-change:transform}

.bd-hero-slide{
    z-index:0;
    opacity:0;
    transform:scale(1.08);
    filter:brightness(.62);
    transition:opacity 1.8s ease,transform 7s ease,filter 1.8s ease;
    pointer-events:none
}
.bd-hero-slide.bd-hero-active{
    z-index:1;
    opacity:1;
    transform:scale(1);
    filter:brightness(.69)
}

.bd-hero-grid{
    opacity:.055;
    background-image:
        linear-gradient(rgba(255,255,255,.3) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.3) 1px,transparent 1px);
    background-size:55px 55px;
    will-change:transform
}

.bd-hero-glow{
    animation:bdGlowFloat 7s ease-in-out infinite;
    will-change:transform
}

.bd-hero-copy{will-change:transform,opacity}

.bd-hero-title{
    max-width:760px;
    margin:0;
    font-size:clamp(36px,3.7vw,54px);
    line-height:1.09;
    letter-spacing:-1.4px
}

.bd-hero-line{
    display:block;
    overflow:hidden;
    padding-bottom:4px
}

.bd-hero-line>span{
    display:block;
    will-change:transform,opacity
}

.bd-hero-line em{
    position:relative;
    color:#FFC145;
    font-style:normal
}

.bd-hero-line em::after{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:-4px;
    height:3px;
    border-radius:999px;
    background:linear-gradient(90deg,#F7AA35,#EF5843);
    transform:scaleX(.65);
    transform-origin:left;
    opacity:.9
}

.bd-hero-desc{
    max-width:670px;
    margin:20px 0 27px;
    color:#E2E8F0;
    font-size:15px;
    line-height:1.7
}

.bd-wa-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:12px 18px 12px 12px;
    border-radius:999px;
    background:#FFC145;
    color:#111827!important;
    font-size:13px;
    font-weight:800;
    box-shadow:0 12px 28px rgba(0,0,0,.18);
    transition:background .25s ease,box-shadow .25s ease
}

.bd-wa-btn:hover{
    background:#F7AA35;
    box-shadow:0 16px 36px rgba(247,170,53,.22)
}

.bd-wa-arrow{
    width:14px;
    height:14px;
    fill:none;
    stroke:currentColor;
    stroke-width:2;
    transition:transform .25s ease
}

.bd-wa-btn:hover .bd-wa-arrow{transform:translateX(3px)}

.bd-hero-visual{
    width:460px;
    height:390px;
    perspective:1100px;
    transform-style:preserve-3d;
    will-change:transform,opacity
}

.bd-hero-orbit{
    position:absolute;
    border:1px solid rgba(255,255,255,.14);
    border-radius:50%;
    pointer-events:none
}

.bd-orbit-one{
    inset:25px 45px;
    animation:bdOrbit 14s linear infinite
}

.bd-orbit-two{
    inset:65px 85px;
    border-style:dashed;
    animation:bdOrbitReverse 19s linear infinite
}

.bd-floating-book{
    position:absolute;
    z-index:5;
    left:155px;
    top:82px;
    width:150px;
    height:205px;
    transform-style:preserve-3d;
    animation:bdHeroBook 5.5s ease-in-out infinite;
    will-change:transform
}

.bd-book-cover{
    position:absolute;
    inset:0;
    z-index:5;
    display:flex;
    flex-direction:column;
    padding:20px 17px;
    color:#fff;
    background:linear-gradient(145deg,#EF5843,#F7AA35);
    border-radius:4px 11px 11px 4px;
    transform:translateZ(12px);
    box-shadow:22px 28px 55px rgba(0,0,0,.35)
}

.bd-book-cover>span{
    margin-top:10px;
    font-size:8px;
    font-weight:800;
    letter-spacing:2px
}

.bd-book-cover strong{
    margin-top:19px;
    font-size:18px;
    line-height:1.2
}

.bd-book-cover small{
    margin-top:auto;
    font-size:7px;
    letter-spacing:1px
}

.bd-book-spine{
    position:absolute;
    top:4px;
    left:0;
    width:22px;
    height:197px;
    background:#B43E2C;
    transform-origin:left;
    transform:rotateY(-90deg)
}

.bd-book-pages{
    position:absolute;
    top:4px;
    right:0;
    width:22px;
    height:197px;
    background:repeating-linear-gradient(to bottom,#fff 0 2px,#ddd8cf 2px 3px);
    transform-origin:right;
    transform:rotateY(90deg)
}

.bd-floating-card{
    position:absolute;
    z-index:10;
    display:flex;
    align-items:center;
    gap:10px;
    width:155px;
    min-height:66px;
    padding:11px 13px;
    border:1px solid rgba(255,255,255,.7);
    border-radius:14px;
    color:#241B52;
    background:rgba(255,255,255,.96);
    backdrop-filter:blur(12px);
    box-shadow:0 14px 32px rgba(0,0,0,.18);
    animation:bdFloatingCard 4.5s ease-in-out infinite;
    will-change:transform
}

.bd-card-icon{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 32px;
    border-radius:9px;
    background:#FFF1EC;
    color:#EF5843
}

.bd-card-icon svg{
    width:18px;
    height:18px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round
}

.bd-floating-card>div:last-child{min-width:0;flex:1}
.bd-floating-card strong{display:block;color:#241B52;font-size:11px;font-weight:900;line-height:1.2}
.bd-floating-card small{display:block;margin-top:3px;color:#64748B;font-size:8px;font-weight:600;line-height:1.25;white-space:nowrap}

.bd-card-isbn{left:0;top:38px}
.bd-card-haki{right:0;top:100px;animation-delay:-1.4s}
.bd-card-ebook{left:8px;bottom:24px;animation-delay:-2.6s}

.bd-hero-dots{pointer-events:auto}

.bd-hero-dot{
    width:7px;
    height:7px;
    padding:0;
    border:0;
    border-radius:999px;
    background:rgba(255,255,255,.45);
    cursor:pointer;
    transition:.3s ease
}

.bd-hero-dot.active{
    width:25px;
    background:#FFC145
}

@keyframes bdHeroBook{
    0%,100%{transform:rotateY(-18deg) rotateX(3deg) translateY(0)}
    50%{transform:rotateY(3deg) rotateX(-2deg) translateY(-11px)}
}

@keyframes bdFloatingCard{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-8px)}
}

@keyframes bdOrbit{to{transform:rotate(360deg)}}
@keyframes bdOrbitReverse{to{transform:rotate(-360deg)}}

@keyframes bdGlowFloat{
    0%,100%{transform:translate3d(0,0,0)}
    50%{transform:translate3d(-18px,22px,0)}
}

@media(max-width:1199px){
    .bd-hero-title{font-size:44px}
    .bd-hero-desc{font-size:14px}
    .bd-hero-visual{width:400px;height:370px}
    .bd-floating-book{left:133px;top:83px;width:140px;height:195px}
    .bd-book-spine,.bd-book-pages{height:187px}
    .bd-floating-card{width:130px;min-height:60px;padding:9px 10px;gap:7px}
    .bd-card-icon{width:27px;height:27px;flex-basis:27px}
    .bd-card-icon svg{width:16px;height:16px}
    .bd-floating-card strong{font-size:10px}
    .bd-floating-card small{font-size:7px}
    .bd-card-isbn{left:0;top:40px}
    .bd-card-haki{right:0;top:105px}
    .bd-card-ebook{left:4px;bottom:25px}
}

@media(max-width:767px){
    .bd-hero{min-height:590px}
    .bd-hero-title{font-size:clamp(34px,9vw,44px);letter-spacing:-1px}
    .bd-hero-desc{font-size:14px;line-height:1.65;margin:18px 0 25px}
}

@media(prefers-reduced-motion:reduce){
    .bd-hero-slide{transition:none;transform:none}
    .bd-floating-book,.bd-floating-card,.bd-hero-orbit,.bd-hero-glow{animation:none}
}
</style>

<script>
(function(){
    function initHeroSlider(){
        const hero=document.getElementById('home');
        if(!hero||hero.dataset.sliderReady==='1')return;

        hero.dataset.sliderReady='1';

        const slides=[...hero.querySelectorAll('.bd-hero-slide')];
        const dots=[...hero.querySelectorAll('.bd-hero-dot')];

        if(slides.length<2)return;

        let index=0;
        let timer=null;
        const interval=7000;

        function showSlide(next){
            index=(next+slides.length)%slides.length;

            slides.forEach((slide,i)=>{
                slide.classList.toggle('bd-hero-active',i===index);
            });

            dots.forEach((dot,i)=>{
                dot.classList.toggle('active',i===index);
            });
        }

        function stop(){
            if(timer){
                clearInterval(timer);
                timer=null;
            }
        }

        function start(){
            stop();
            timer=setInterval(()=>{
                showSlide(index+1);
            },interval);
        }

        dots.forEach((dot,i)=>{
            dot.addEventListener('click',()=>{
                showSlide(i);
                start();
            });
        });

        document.addEventListener('visibilitychange',()=>{
            if(document.hidden)stop();
            else start();
        });

        showSlide(0);
        start();
    }

    if(document.readyState==='loading'){
        document.addEventListener('DOMContentLoaded',initHeroSlider);
    }else{
        initHeroSlider();
    }
})();
</script>