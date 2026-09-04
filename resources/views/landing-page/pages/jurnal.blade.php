@extends('layouts.app')

@section('title', 'Baca Jurnal - Baca Dulu')

@section('content')

@php
    $journalItems = method_exists($jurnals, 'items')
        ? collect($jurnals->items())
        : collect($jurnals);

    $totalJournals = method_exists($jurnals, 'total')
        ? $jurnals->total()
        : $journalItems->count();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap');

.bd-journal{
    --navy:#241B52;
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

.bd-journal *,
.bd-journal *::before,
.bd-journal *::after{box-sizing:border-box}

.bd-journal a{text-decoration:none}

.bd-journal-shell{
    width:min(calc(100% - 72px),1260px);
    margin:auto;
}

/* BRAND */
.bd-journal-brandbar{
    min-height:72px;
    display:flex;
    align-items:center;
    border-bottom:1px solid var(--line);
}

.bd-journal-brand{
    display:inline-flex;
    align-items:center;
    gap:11px;
}

.bd-journal-brand-mark{
    width:7px;
    height:27px;
    flex:0 0 7px;
    background:var(--orange);
}

.bd-journal-brand-name{
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:21px;
    font-weight:600;
}

.bd-journal-brand-type{
    color:var(--muted);
    font-size:10px;
    font-weight:600;
    letter-spacing:.1em;
    text-transform:uppercase;
}

/* HERO */
.bd-journal-hero{
    max-width:930px;
    margin:0 auto;
    padding:58px 20px 43px;
    text-align:center;
}

.bd-journal-title{
    max-width:900px;
    margin:0 auto;
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:clamp(40px,4.5vw,62px);
    font-weight:600;
    line-height:1.04;
    letter-spacing:-.045em;
}

.bd-journal-word{
    display:inline-block;
    margin-right:.13em;
}

.bd-journal-description{
    max-width:650px;
    margin:18px auto 0;
    color:var(--body);
    font-size:12px;
    line-height:1.8;
}

.bd-journal-count{
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

.bd-journal-count-dot{
    width:6px;
    height:6px;
    border-radius:50%;
    background:var(--orange);
    box-shadow:0 0 0 4px rgba(239,88,67,.11);
}

/* DIVIDER */
.bd-journal-divider{
    position:relative;
    height:1px;
    margin-bottom:26px;
    background:var(--line);
}

.bd-journal-divider-fill{
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
.bd-journal-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:22px;
}

/* CARD */
.bd-journal-card{
    position:relative;
    min-width:0;
    overflow:hidden;
    border:1px solid rgba(36,27,82,.09);
    border-radius:15px;
    background:#fff;
    box-shadow:0 8px 24px rgba(36,27,82,.055);
    will-change:transform,opacity;
}

.bd-journal-card::before{
    content:"";
    position:absolute;
    z-index:5;
    left:0;
    top:0;
    bottom:0;
    width:4px;
    background:var(--orange);
    transform:scaleY(0);
    transform-origin:center;
    transition:transform .3s ease;
}

.bd-journal-card:hover::before{transform:scaleY(1)}

/* CARD TOP */
.bd-journal-card-top{
    position:relative;
    z-index:1;
    display:grid;
    grid-template-columns:88px minmax(0,1fr);
    gap:20px;
    align-items:center;
    min-height:142px;
    margin:10px;
    padding:18px 21px;
    overflow:hidden;
    border-radius:10px;
    background:var(--orange);
}

.bd-journal-card-top::before,
.bd-journal-card-top::after{
    content:"";
    position:absolute;
    border:1px solid rgba(255,255,255,.15);
    border-radius:50%;
}

.bd-journal-card-top::before{
    right:-55px;
    top:-65px;
    width:150px;
    height:150px;
}

.bd-journal-card-top::after{
    right:-18px;
    bottom:-65px;
    width:115px;
    height:115px;
}

/* COVER */
.bd-journal-cover-wrap{
    position:relative;
    z-index:2;
    width:78px;
}

.bd-journal-cover-wrap::after{
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

.bd-journal-cover{
    width:78px;
    aspect-ratio:3/4;
    overflow:hidden;
    border-radius:4px;
    background:#fff;
    box-shadow:0 10px 23px rgba(64,24,18,.22);
}

.bd-journal-cover img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
}

.bd-journal-cover-fallback{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:8px;
    background:#fff;
    color:var(--navy);
    font-size:7px;
    font-weight:700;
    text-align:center;
}

/* NAME */
.bd-journal-name-wrap{
    position:relative;
    z-index:2;
    min-width:0;
}

.bd-journal-type{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-bottom:8px;
    color:rgba(255,255,255,.72);
    font-size:7px;
    font-weight:700;
    letter-spacing:.13em;
    text-transform:uppercase;
}

.bd-journal-type::before{
    content:"";
    width:5px;
    height:5px;
    border-radius:50%;
    background:var(--gold);
}

.bd-journal-card-name{
    margin:0;
    color:#fff;
    font-family:'Fraunces',serif;
    font-size:clamp(18px,1.55vw,24px);
    font-weight:600;
    line-height:1.16;
    letter-spacing:-.025em;
}

/* BODY */
.bd-journal-card-body{
    padding:4px 21px 20px;
}

.bd-journal-issn{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:18px;
    padding:10px 0 13px;
    border-bottom:1px solid var(--line);
    color:#716B78;
    font-size:10px;
}

.bd-journal-issn-item{
    display:inline-flex;
    align-items:center;
    gap:5px;
}

.bd-journal-issn strong{
    color:var(--navy);
    font-size:9px;
}

.bd-journal-card-description{
    min-height:72px;
    margin:14px 0 17px;
    overflow:hidden;
    color:var(--body);
    font-size:10.5px;
    line-height:1.7;
    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
}

/* BUTTON */
.bd-journal-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
}

.bd-journal-button{
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

.bd-journal-button svg{
    width:13px;
    height:13px;
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-journal-button-secondary{
    border:1px solid var(--cream-border);
    background:var(--cream);
    color:var(--navy)!important;
}

.bd-journal-button-secondary:hover{
    background:var(--cream-hover);
}

.bd-journal-button-primary{
    border:1px solid var(--gold);
    background:var(--gold);
    color:var(--navy)!important;
}

.bd-journal-button-primary:hover{
    background:var(--gold-hover);
}

.bd-journal-button-disabled{
    border:1px solid #EEEAEF;
    background:#F5F3F5;
    color:#B7B1BA!important;
}

/* EMPTY */
.bd-journal-empty{
    padding:65px 20px;
    border-top:1px solid var(--line);
    border-bottom:1px solid var(--line);
    color:var(--muted);
    text-align:center;
    font-size:11px;
}

.bd-journal-pagination{margin-top:30px}

/* INITIAL */
.bd-journal-brand-reveal,
.bd-journal-hero-reveal,
.bd-journal-card{opacity:0}

.bd-journal-hero-reveal{transform:translateY(18px)}

@media(max-width:800px){
    .bd-journal-shell{width:calc(100% - 40px)}
    .bd-journal-hero{padding:45px 16px 36px}
    .bd-journal-grid{grid-template-columns:1fr}
}

@media(max-width:600px){
    .bd-journal-shell{width:calc(100% - 30px)}
    .bd-journal-brand-type{display:none}
    .bd-journal-hero{padding:38px 5px 31px}
    .bd-journal-title{font-size:38px}
    .bd-journal-description{font-size:11px}
    .bd-journal-card-top{
        grid-template-columns:68px minmax(0,1fr);
        gap:14px;
        min-height:118px;
        margin:8px;
        padding:14px;
    }
    .bd-journal-cover,
    .bd-journal-cover-wrap{width:62px}
    .bd-journal-cover-wrap::after{
        width:62px;
        left:5px;
        top:5px;
    }
    .bd-journal-card-name{font-size:17px}
    .bd-journal-card-body{padding:3px 15px 16px}
    .bd-journal-card-description{min-height:0}
    .bd-journal-actions{grid-template-columns:1fr}
}

@media(prefers-reduced-motion:reduce){
    .bd-journal-brand-reveal,
    .bd-journal-hero-reveal,
    .bd-journal-card{
        opacity:1!important;
        transform:none!important;
    }
}
</style>


<section class="bd-journal" id="bdJournalPage">

    <div class="bd-journal-shell">

        {{-- BRAND --}}
        <div class="bd-journal-brandbar">
            <div class="bd-journal-brand bd-journal-brand-reveal">
                <span class="bd-journal-brand-mark"></span>
                <span class="bd-journal-brand-name">BacaDulu</span>
                <span class="bd-journal-brand-type">Journal</span>
            </div>
        </div>


        {{-- HERO --}}
        <header class="bd-journal-hero bd-journal-hero-reveal">

            <h1 class="bd-journal-title" id="bdJournalTitle">
                Ruang Publikasi untuk Pengetahuan yang Terus Bertumbuh.
            </h1>

            <p class="bd-journal-description">
                Temukan jurnal ilmiah dalam ekosistem BacaDulu sebagai ruang publikasi, referensi, dan penyebaran pengetahuan untuk mendukung riset yang berkualitas dan berdampak.
            </p>

            <div class="bd-journal-count">
                <span class="bd-journal-count-dot"></span>
                {{ $totalJournals }} jurnal tersedia
            </div>

        </header>


        {{-- DIVIDER --}}
        <div class="bd-journal-divider">
            <div class="bd-journal-divider-fill" id="bdJournalDivider"></div>
        </div>


        {{-- GRID --}}
        @if($journalItems->isNotEmpty())

            <div class="bd-journal-grid">

                @foreach($journalItems as $jurnal)

                    <article class="bd-journal-card" data-journal-card>

                        <div class="bd-journal-card-top">

                            <div class="bd-journal-cover-wrap">

                                <div class="bd-journal-cover">

                                    @if(!empty($jurnal->gambar))

                                        <img
                                            src="{{ asset('storage/' . $jurnal->gambar) }}"
                                            alt="{{ $jurnal->judul }}"
                                            loading="lazy"
                                            decoding="async"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='flex';
                                            "
                                        >

                                        <div
                                            class="bd-journal-cover-fallback"
                                            style="display:none;"
                                        >
                                            BacaDulu Journal
                                        </div>

                                    @else

                                        <div class="bd-journal-cover-fallback">
                                            BacaDulu Journal
                                        </div>

                                    @endif

                                </div>

                            </div>


                            <div class="bd-journal-name-wrap">

                                <div class="bd-journal-type">
                                    Scientific Journal
                                </div>

                                <h2 class="bd-journal-card-name">
                                    {{ $jurnal->judul }}
                                </h2>

                            </div>

                        </div>


                        <div class="bd-journal-card-body">

                            <div class="bd-journal-issn">

                                <span class="bd-journal-issn-item">
                                    <strong>E-ISSN:</strong>
                                    {{ $jurnal->e_issn ?: '-' }}
                                </span>

                                <span class="bd-journal-issn-item">
                                    <strong>P-ISSN:</strong>
                                    {{ $jurnal->p_issn ?: '-' }}
                                </span>

                            </div>


                            <div class="bd-journal-card-description">
                                {{
                                    \Illuminate\Support\Str::limit(
                                        trim(
                                            strip_tags(
                                                $jurnal->deskripsi ?? ''
                                            )
                                        ),
                                        260
                                    )
                                    ?: 'Deskripsi jurnal belum tersedia.'
                                }}
                            </div>


                            <div class="bd-journal-actions">

                                @if(!empty($jurnal->journal_url))

                                    <a
                                        href="{{ $jurnal->journal_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="bd-journal-button bd-journal-button-secondary js-journal-button"
                                    >
                                        <span>Lihat Jurnal</span>

                                        <svg viewBox="0 0 24 24">
                                            <path d="M7 17L17 7"/>
                                            <path d="M8 7h9v9"/>
                                        </svg>
                                    </a>

                                @else

                                    <span class="bd-journal-button bd-journal-button-disabled">
                                        Lihat Jurnal
                                    </span>

                                @endif


                                @if(!empty($jurnal->current_issue_url))

                                    <a
                                        href="{{ $jurnal->current_issue_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="bd-journal-button bd-journal-button-primary js-journal-button"
                                    >
                                        <span>Edisi Terkini</span>

                                        <svg viewBox="0 0 24 24">
                                            <path d="M5 12h14"/>
                                            <path d="m14 7 5 5-5 5"/>
                                        </svg>
                                    </a>

                                @else

                                    <span class="bd-journal-button bd-journal-button-disabled">
                                        Edisi Terkini
                                    </span>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="bd-journal-empty">
                Belum ada jurnal yang tersedia.
            </div>

        @endif


        @if(method_exists($jurnals, 'hasPages') && $jurnals->hasPages())
            <div class="bd-journal-pagination">
                {{ $jurnals->links() }}
            </div>
        @endif

    </div>

</section>


<script>
(() => {
    const page=document.getElementById('bdJournalPage');
    if(!page)return;

    const reduced=window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const resolveGsap=()=>{
        const candidates=[window.bdGsap,window.bdGsap?.gsap,window.gsap,window.GSAP];
        return candidates.find(item=>item&&typeof item.to==='function'&&typeof item.fromTo==='function'&&typeof item.timeline==='function')||null;
    };

    const splitTitle=()=>{
        const title=document.getElementById('bdJournalTitle');
        if(!title||title.dataset.split==='1')return[];

        const text=title.textContent.trim().replace(/\s+/g,' ');
        title.dataset.split='1';
        title.setAttribute('aria-label',text);

        title.innerHTML=text
            .split(' ')
            .map(word=>`<span class="bd-journal-word" aria-hidden="true">${word}</span>`)
            .join(' ');

        return [...title.querySelectorAll('.bd-journal-word')];
    };

    if(reduced){
        page.querySelectorAll('.bd-journal-brand-reveal,.bd-journal-hero-reveal,.bd-journal-card')
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

                page.querySelectorAll('.bd-journal-brand-reveal,.bd-journal-hero-reveal,.bd-journal-card')
                    .forEach(el=>{
                        el.style.opacity='1';
                        el.style.transform='none';
                    });
            }
            return;
        }

        clearInterval(waiter);

        const brand=page.querySelector('.bd-journal-brand-reveal');

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

        const hero=page.querySelector('.bd-journal-hero-reveal');

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

        const divider=document.getElementById('bdJournalDivider');

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

        const cards=[...page.querySelectorAll('[data-journal-card]')];

        const observer=new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(!entry.isIntersecting)return;

                const card=entry.target;

                if(card.dataset.animated==='1')return;
                card.dataset.animated='1';

                const cover=card.querySelector('.bd-journal-cover-wrap');
                const name=card.querySelector('.bd-journal-name-wrap');
                const body=card.querySelector('.bd-journal-card-body');

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

                if(cover){
                    tl.fromTo(
                        cover,
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

                if(name){
                    tl.fromTo(
                        name,
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
                        '-=.20'
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
                const cover=card.querySelector('.bd-journal-cover-wrap');

                card.addEventListener('mouseenter',()=>{
                    gsap.to(card,{
                        y:-5,
                        duration:.28,
                        ease:'power2.out',
                        overwrite:'auto'
                    });

                    if(cover){
                        gsap.to(cover,{
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

                    if(cover){
                        gsap.to(cover,{
                            y:0,
                            x:0,
                            duration:.38,
                            ease:'power3.out',
                            overwrite:'auto'
                        });
                    }
                });
            });

            page.querySelectorAll('.js-journal-button').forEach(button=>{
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