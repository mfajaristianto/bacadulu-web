@extends('layouts.app')

@section('title', 'Baca Conference - Baca Dulu')

@section('content')

@php
    $conferenceItems = method_exists($conferences, 'items')
        ? collect($conferences->items())
        : collect($conferences);

    $totalConferences = method_exists($conferences, 'total')
        ? $conferences->total()
        : $conferenceItems->count();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap');

.bd-conference{
    --navy:#241B52;
    --navy-soft:#30266B;
    --orange:#EF5843;
    --gold:#F7AA35;
    --gold-hover:#EDA02C;
    --cream:#FFF7EF;
    --cream-hover:#FFF0E7;
    --cream-border:#F1E2D7;
    --body:#645F6E;
    --muted:#96929C;
    --line:#E8E7EC;
    width:100%;
    min-height:100vh;
    overflow-x:hidden;
    padding-bottom:64px;
    background:linear-gradient(180deg,#fff 0,#fff 360px,#FFF9F5 100%);
    color:#1D1A27;
    font-family:'Inter',sans-serif;
}

.bd-conference *,
.bd-conference *::before,
.bd-conference *::after{box-sizing:border-box}

.bd-conference a{text-decoration:none}

.bd-conference-shell{
    width:min(calc(100% - 72px),1260px);
    margin:auto;
}

/* BRAND */
.bd-conference-brandbar{
    min-height:72px;
    display:flex;
    align-items:center;
    border-bottom:1px solid var(--line);
}

.bd-conference-brand{
    display:inline-flex;
    align-items:center;
    gap:11px;
}

.bd-conference-brand-mark{
    width:7px;
    height:27px;
    flex:0 0 7px;
    background:var(--orange);
}

.bd-conference-brand-name{
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:21px;
    font-weight:600;
}

.bd-conference-brand-type{
    color:var(--muted);
    font-size:10px;
    font-weight:600;
    letter-spacing:.1em;
    text-transform:uppercase;
}

/* HERO */
.bd-conference-hero{
    max-width:900px;
    margin:0 auto;
    padding:58px 20px 43px;
    text-align:center;
}

.bd-conference-title{
    max-width:850px;
    margin:0 auto;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:clamp(40px,4.5vw,62px);
    font-weight:600;
    line-height:1.04;
    letter-spacing:-.045em;
}

.bd-conference-word{
    display:inline-block;
    margin-right:.13em;
}

.bd-conference-description{
    max-width:650px;
    margin:18px auto 0;
    color:var(--body);
    font-size:12px;
    line-height:1.8;
}

.bd-conference-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:16px;
    color:var(--muted);
    font-size:8px;
    font-weight:700;
    letter-spacing:.09em;
    text-transform:uppercase;
}

.bd-conference-count-dot{
    width:6px;
    height:6px;
    border-radius:50%;
    background:var(--orange);
    box-shadow:0 0 0 4px rgba(239,88,67,.11);
}

/* DIVIDER */
.bd-conference-divider{
    position:relative;
    height:1px;
    margin-bottom:26px;
    background:var(--line);
}

.bd-conference-divider-fill{
    position:absolute;
    left:50%;
    top:0;
    width:105px;
    height:1px;
    background:var(--orange);
    transform:translateX(-50%);
    transform-origin:center;
}

/* GRID */
.bd-conference-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:22px;
}

/* CARD */
.bd-conference-card{
    position:relative;
    overflow:hidden;
    border:1px solid rgba(36,27,82,.09);
    border-radius:15px;
    background:#fff;
    box-shadow:0 8px 24px rgba(36,27,82,.055);
    will-change:transform,opacity;
}

.bd-conference-card::before{
    content:"";
    position:absolute;
    z-index:5;
    left:0;
    top:0;
    bottom:0;
    width:4px;
    background:var(--gold);
    transform:scaleY(0);
    transform-origin:center;
    transition:transform .3s ease;
}

.bd-conference-card:hover::before{transform:scaleY(1)}

/* CARD TOP NAVY */
.bd-conference-card-top{
    position:relative;
    display:grid;
    grid-template-columns:88px minmax(0,1fr);
    gap:20px;
    align-items:center;
    min-height:142px;
    margin:10px;
    padding:18px 21px;
    overflow:hidden;
    border-radius:10px;
    background:var(--navy);
}

.bd-conference-card-top::before,
.bd-conference-card-top::after{
    content:"";
    position:absolute;
    border:1px solid rgba(255,255,255,.10);
    border-radius:50%;
}

.bd-conference-card-top::before{
    right:-55px;
    top:-65px;
    width:150px;
    height:150px;
}

.bd-conference-card-top::after{
    right:-18px;
    bottom:-65px;
    width:115px;
    height:115px;
}

/* POSTER */
.bd-conference-poster-wrap{
    position:relative;
    z-index:2;
    width:78px;
}

.bd-conference-poster-wrap::after{
    content:"";
    position:absolute;
    z-index:-1;
    left:6px;
    top:6px;
    width:78px;
    aspect-ratio:3/4;
    border-radius:4px;
    background:var(--gold);
}

.bd-conference-poster{
    width:78px;
    aspect-ratio:3/4;
    overflow:hidden;
    border-radius:4px;
    background:#fff;
    box-shadow:0 10px 23px rgba(0,0,0,.20);
}

.bd-conference-poster img{
    width:100%;
    height:100%;
    display:block;
    object-fit:contain;
    background:#fff;
}

.bd-conference-poster-fallback{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:8px;
    color:var(--navy);
    background:#fff;
    text-align:center;
    font-size:7px;
    font-weight:700;
}

/* SERIES */
.bd-conference-series-wrap{
    position:relative;
    z-index:2;
    min-width:0;
}

.bd-conference-type{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-bottom:8px;
    color:rgba(255,255,255,.68);
    font-size:7px;
    font-weight:700;
    letter-spacing:.13em;
    text-transform:uppercase;
}

.bd-conference-type::before{
    content:"";
    width:5px;
    height:5px;
    border-radius:50%;
    background:var(--gold);
}

.bd-conference-series{
    margin:0;
    color:#fff;
    font-family:'Fraunces',serif;
    font-size:clamp(20px,1.7vw,26px);
    font-weight:600;
    line-height:1.15;
}

/* BODY */
.bd-conference-card-body{
    padding:14px 21px 20px;
}

.bd-conference-theme-label{
    color:var(--orange);
    font-size:7px;
    font-weight:700;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-conference-theme{
    margin:6px 0 0;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:16px;
    font-weight:600;
    line-height:1.38;
}

.bd-conference-card-description{
    min-height:58px;
    margin:11px 0 17px;
    color:var(--body);
    font-size:10.5px;
    line-height:1.7;
    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

/* BUTTONS */
.bd-conference-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
}

.bd-conference-button{
    min-height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    padding:0 13px;
    border-radius:7px;
    font-size:10px;
    font-weight:700;
}

.bd-conference-button svg{
    width:13px;
    height:13px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-conference-button-conference{
    border:1px solid var(--cream-border);
    background:var(--cream);
    color:var(--navy)!important;
}

.bd-conference-button-conference:hover{
    background:var(--cream-hover);
}

.bd-conference-button-proceeding{
    border:1px solid var(--gold);
    background:var(--gold);
    color:var(--navy)!important;
}

.bd-conference-button-proceeding:hover{
    background:var(--gold-hover);
}

.bd-conference-button-disabled{
    border:1px solid #EEEAEF;
    background:#F5F3F5;
    color:#B7B1BA!important;
}

/* EMPTY */
.bd-conference-empty{
    padding:65px 20px;
    border-top:1px solid var(--line);
    border-bottom:1px solid var(--line);
    text-align:center;
    color:var(--muted);
    font-size:11px;
}

.bd-conference-pagination{margin-top:30px}

/* ANIMATION INITIAL */
.bd-conference-brand-reveal,
.bd-conference-hero-reveal,
.bd-conference-card{opacity:0}

.bd-conference-hero-reveal{transform:translateY(18px)}

/* TABLET */
@media(max-width:800px){
    .bd-conference-shell{width:calc(100% - 40px)}
    .bd-conference-hero{padding:45px 16px 36px}
    .bd-conference-grid{grid-template-columns:1fr}
}

/* MOBILE */
@media(max-width:600px){
    .bd-conference-shell{width:calc(100% - 30px)}
    .bd-conference-brand-type{display:none}
    .bd-conference-hero{padding:38px 5px 31px}
    .bd-conference-title{font-size:38px}
    .bd-conference-description{font-size:11px}
    .bd-conference-card-top{
        grid-template-columns:68px minmax(0,1fr);
        gap:14px;
        min-height:118px;
        margin:8px;
        padding:14px;
    }
    .bd-conference-poster,
    .bd-conference-poster-wrap{width:62px}
    .bd-conference-poster-wrap::after{
        width:62px;
        left:5px;
        top:5px;
    }
    .bd-conference-series{font-size:18px}
    .bd-conference-card-body{padding:12px 15px 16px}
    .bd-conference-actions{grid-template-columns:1fr}
}

@media(prefers-reduced-motion:reduce){
    .bd-conference-brand-reveal,
    .bd-conference-hero-reveal,
    .bd-conference-card{
        opacity:1!important;
        transform:none!important;
    }
}
</style>


<section class="bd-conference" id="bdConferencePage">

    <div class="bd-conference-shell">

        {{-- BRAND --}}
        <div class="bd-conference-brandbar">
            <div class="bd-conference-brand bd-conference-brand-reveal">
                <span class="bd-conference-brand-mark"></span>
                <span class="bd-conference-brand-name">BacaDulu</span>
                <span class="bd-conference-brand-type">Conference</span>
            </div>
        </div>


        {{-- HERO --}}
        <header class="bd-conference-hero bd-conference-hero-reveal">

            <h1 class="bd-conference-title" id="bdConferenceTitle">
                Ruang Temu untuk Gagasan dan Kolaborasi Ilmiah.
            </h1>

            <p class="bd-conference-description">
                Jelajahi seri conference dan forum ilmiah dalam ekosistem BacaDulu yang mempertemukan gagasan, kolaborasi, dan publikasi untuk memperluas dampak pengetahuan.
            </p>

            <div class="bd-conference-count">
                <span class="bd-conference-count-dot"></span>
                {{ $totalConferences }} conference tersedia
            </div>

        </header>


        {{-- DIVIDER --}}
        <div class="bd-conference-divider">
            <div class="bd-conference-divider-fill" id="bdConferenceDivider"></div>
        </div>


        {{-- GRID --}}
        @if($conferenceItems->isNotEmpty())

            <div class="bd-conference-grid">

                @foreach($conferenceItems as $conference)

                    @php
                        $series = trim(
                            ($conference->name ?? '') . ' ' .
                            ($conference->edition ?? '')
                        );

                        if ($series === '') {
                            $series = $conference->title ?? 'Conference';
                        }

                        $theme = (
                            !empty($conference->name) ||
                            !empty($conference->edition)
                        )
                            ? $conference->title
                            : null;

                        $poster = !empty($conference->poster)
                            ? asset('storage/' . $conference->poster)
                            : null;
                    @endphp


                    <article
                        class="bd-conference-card"
                        data-conference-card
                    >

                        <div class="bd-conference-card-top">

                            <div class="bd-conference-poster-wrap">

                                <div class="bd-conference-poster">

                                    @if($poster)

                                        <img
                                            src="{{ $poster }}"
                                            alt="{{ $series }}"
                                            loading="lazy"
                                            decoding="async"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='flex';
                                            "
                                        >

                                        <div
                                            class="bd-conference-poster-fallback"
                                            style="display:none;"
                                        >
                                            BacaDulu Conference
                                        </div>

                                    @else

                                        <div class="bd-conference-poster-fallback">
                                            BacaDulu Conference
                                        </div>

                                    @endif

                                </div>

                            </div>


                            <div class="bd-conference-series-wrap">

                                <div class="bd-conference-type">
                                    Scientific Conference
                                </div>

                                <h2 class="bd-conference-series">
                                    {{ $series }}
                                </h2>

                            </div>

                        </div>


                        <div class="bd-conference-card-body">

                            @if($theme)

                              

                                <h3 class="bd-conference-theme">
                                    {{ $theme }}
                                </h3>

                            @endif


                            <div class="bd-conference-card-description">
                                {{
                                    \Illuminate\Support\Str::limit(
                                        trim(
                                            strip_tags(
                                                $conference->description ?? ''
                                            )
                                        ),
                                        260
                                    )
                                    ?: 'Deskripsi conference belum tersedia.'
                                }}
                            </div>


                            <div class="bd-conference-actions">

                                @if($conference->conference_url)

                                    <a
                                        href="{{ $conference->conference_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="bd-conference-button bd-conference-button-conference js-conference-button"
                                    >
                                        <span>Lihat Conference</span>

                                        <svg viewBox="0 0 24 24">
                                            <path d="M7 17L17 7"/>
                                            <path d="M8 7h9v9"/>
                                        </svg>
                                    </a>

                                @else

                                    <span class="bd-conference-button bd-conference-button-disabled">
                                        Lihat Conference
                                    </span>

                                @endif


                                @if($conference->proceeding_url)

                                    <a
                                        href="{{ $conference->proceeding_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="bd-conference-button bd-conference-button-proceeding js-conference-button"
                                    >
                                        <span>Lihat Prosiding</span>

                                        <svg viewBox="0 0 24 24">
                                            <path d="M5 12h14"/>
                                            <path d="m14 7 5 5-5 5"/>
                                        </svg>
                                    </a>

                                @else

                                    <span class="bd-conference-button bd-conference-button-disabled">
                                        Lihat Prosiding
                                    </span>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="bd-conference-empty">
                Belum ada conference yang tersedia.
            </div>

        @endif


        @if(
            method_exists($conferences, 'hasPages')
            &&
            $conferences->hasPages()
        )
            <div class="bd-conference-pagination">
                {{ $conferences->onEachSide(1)->links() }}
            </div>
        @endif

    </div>

</section>


<script>
(() => {
    const page=document.getElementById('bdConferencePage');
    if(!page)return;

    const reduced=window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const resolveGsap=()=>{
        const candidates=[window.bdGsap,window.bdGsap?.gsap,window.gsap,window.GSAP];
        return candidates.find(item=>item&&typeof item.to==='function'&&typeof item.fromTo==='function'&&typeof item.timeline==='function')||null;
    };

    const splitTitle=()=>{
        const title=document.getElementById('bdConferenceTitle');
        if(!title||title.dataset.split==='1')return[];

        const text=title.textContent.trim().replace(/\s+/g,' ');
        title.dataset.split='1';
        title.setAttribute('aria-label',text);

        title.innerHTML=text
            .split(' ')
            .map(word=>`<span class="bd-conference-word" aria-hidden="true">${word}</span>`)
            .join(' ');

        return [...title.querySelectorAll('.bd-conference-word')];
    };

    if(reduced){
        page.querySelectorAll('.bd-conference-brand-reveal,.bd-conference-hero-reveal,.bd-conference-card')
            .forEach(el=>{
                el.style.opacity='1';
                el.style.transform='none';
            });
        return;
    }

    let attempts=0;

    const waiter=setInterval(()=>{
        const gsap=resolveGsap();
        attempts++;

        if(!gsap){
            if(attempts>=60){
                clearInterval(waiter);
                page.querySelectorAll('.bd-conference-brand-reveal,.bd-conference-hero-reveal,.bd-conference-card')
                    .forEach(el=>{
                        el.style.opacity='1';
                        el.style.transform='none';
                    });
            }
            return;
        }

        clearInterval(waiter);

        const brand=page.querySelector('.bd-conference-brand-reveal');

        if(brand){
            gsap.fromTo(
                brand,
                {opacity:0,x:-12,y:0},
                {
                    opacity:1,
                    x:0,
                    y:0,
                    duration:.48,
                    ease:'power3.out',
                    clearProps:'transform'
                }
            );
        }

        const hero=page.querySelector('.bd-conference-hero-reveal');

        if(hero){
            gsap.fromTo(
                hero,
                {opacity:0,y:20},
                {
                    opacity:1,
                    y:0,
                    duration:.65,
                    ease:'power3.out'
                }
            );
        }

        const words=splitTitle();

        if(words.length){
            gsap.fromTo(
                words,
                {opacity:0,y:24},
                {
                    opacity:1,
                    y:0,
                    duration:.55,
                    stagger:.045,
                    delay:.08,
                    ease:'power3.out'
                }
            );
        }

        const divider=document.getElementById('bdConferenceDivider');

        if(divider){
            gsap.fromTo(
                divider,
                {scaleX:0},
                {
                    scaleX:1,
                    duration:.7,
                    delay:.2,
                    ease:'power3.out'
                }
            );
        }

        const cards=[...page.querySelectorAll('[data-conference-card]')];

        const observer=new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(!entry.isIntersecting)return;

                const card=entry.target;

                if(card.dataset.animated==='1')return;
                card.dataset.animated='1';

                const poster=card.querySelector('.bd-conference-poster-wrap');
                const series=card.querySelector('.bd-conference-series-wrap');
                const body=card.querySelector('.bd-conference-card-body');

                const tl=gsap.timeline();

                tl.fromTo(
                    card,
                    {opacity:0,y:26,scale:.975},
                    {
                        opacity:1,
                        y:0,
                        scale:1,
                        duration:.55,
                        ease:'power3.out'
                    }
                );

                if(poster){
                    tl.fromTo(
                        poster,
                        {opacity:0,x:-17},
                        {
                            opacity:1,
                            x:0,
                            duration:.4,
                            ease:'power3.out'
                        },
                        '-=.34'
                    );
                }

                if(series){
                    tl.fromTo(
                        series,
                        {opacity:0,x:15},
                        {
                            opacity:1,
                            x:0,
                            duration:.4,
                            ease:'power3.out'
                        },
                        '-=.32'
                    );
                }

                if(body){
                    tl.fromTo(
                        body.children,
                        {opacity:0,y:10},
                        {
                            opacity:1,
                            y:0,
                            duration:.38,
                            stagger:.05,
                            ease:'power3.out'
                        },
                        '-=.2'
                    );
                }

                observer.unobserve(card);
            });
        },{
            threshold:.15,
            rootMargin:'0px 0px -5% 0px'
        });

        cards.forEach(card=>observer.observe(card));

        if(window.matchMedia('(hover:hover) and (pointer:fine)').matches){

            cards.forEach(card=>{
                const poster=card.querySelector('.bd-conference-poster-wrap');

                card.addEventListener('mouseenter',()=>{
                    gsap.to(card,{
                        y:-5,
                        duration:.28,
                        ease:'power2.out',
                        overwrite:'auto'
                    });

                    if(poster){
                        gsap.to(poster,{
                            y:-3,
                            x:2,
                            duration:.28,
                            ease:'power2.out',
                            overwrite:'auto'
                        });
                    }
                });

                card.addEventListener('mouseleave',()=>{
                    gsap.to(card,{
                        y:0,
                        duration:.38,
                        ease:'power3.out',
                        overwrite:'auto'
                    });

                    if(poster){
                        gsap.to(poster,{
                            y:0,
                            x:0,
                            duration:.38,
                            ease:'power3.out',
                            overwrite:'auto'
                        });
                    }
                });
            });

            page.querySelectorAll('.js-conference-button').forEach(button=>{
                const icon=button.querySelector('svg');

                button.addEventListener('mouseenter',()=>{
                    gsap.to(button,{
                        y:-2,
                        duration:.2,
                        ease:'power2.out'
                    });

                    if(icon){
                        gsap.to(icon,{
                            x:2,
                            duration:.2
                        });
                    }
                });

                button.addEventListener('mouseleave',()=>{
                    gsap.to(button,{
                        y:0,
                        duration:.25,
                        ease:'power3.out'
                    });

                    if(icon){
                        gsap.to(icon,{
                            x:0,
                            duration:.25
                        });
                    }
                });
            });
        }
    },50);
})();
</script>

@endsection