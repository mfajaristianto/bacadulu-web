import './bootstrap';
import gsap from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

gsap.registerPlugin(ScrollTrigger);

/* Digunakan juga oleh script Testimoni */
window.bdGsap=gsap;

document.addEventListener('DOMContentLoaded',()=>{

    if(window.__bdMotionReady)return;
    window.__bdMotionReady=true;

    const reduceMotion=
        window.matchMedia('(prefers-reduced-motion:reduce)').matches;

    const home=document.querySelector('.bd-home');

    /* =====================================================
       LENIS
    ===================================================== */
    const lenis=new Lenis({
        autoRaf:false,
        duration:1.1,
        smoothWheel:true,
        wheelMultiplier:.9,
        touchMultiplier:1
    });

    window.bdLenis=lenis;

    lenis.on('scroll',ScrollTrigger.update);

    gsap.ticker.add(time=>{
        lenis.raf(time*1000);
    });

    gsap.ticker.lagSmoothing(0);

    /* =====================================================
       ANCHOR
    ===================================================== */
    document.querySelectorAll('a[href^="#"]').forEach(link=>{

        link.addEventListener('click',e=>{

            const href=link.getAttribute('href');

            if(!href||href==='#')return;

            const target=document.querySelector(href);

            if(!target)return;

            e.preventDefault();

            lenis.scrollTo(target,{
                offset:-80,
                duration:1.1
            });
        });
    });

    if(!home){
        ScrollTrigger.refresh();
        return;
    }

    /* =====================================================
       REDUCED MOTION
    ===================================================== */
    if(reduceMotion){

        document.querySelectorAll('[data-bd-reveal]').forEach(el=>{

            gsap.set(el,{
                opacity:1,
                x:0,
                y:0,
                scale:1,
                filter:'none'
            });
        });

        return;
    }

    /* =====================================================
       GLOBAL REVEAL
    ===================================================== */
    document.querySelectorAll('[data-bd-reveal]').forEach(el=>{

        if(el.closest('#home'))return;

        const type=
            el.dataset.bdReveal||'up';

        const delay=
            Number(el.dataset.bdDelay||0)/1000;

        const from={
            opacity:0,
            x:0,
            y:0,
            scale:1,
            filter:'blur(4px)'
        };

        if(type==='up')from.y=42;
        if(type==='left')from.x=-48;
        if(type==='right')from.x=48;

        if(type==='zoom'){
            from.scale=.94;
            from.y=18;
        }

        gsap.fromTo(el,from,{
            opacity:1,
            x:0,
            y:0,
            scale:1,
            filter:'blur(0px)',
            duration:.85,
            delay,
            ease:'power3.out',

            scrollTrigger:{
                trigger:el,
                start:'top 88%',
                toggleActions:'play none none reverse'
            }
        });
    });

    /* =====================================================
       HERO
    ===================================================== */
    const hero=document.getElementById('home');

    if(hero){

        const badge=
            hero.querySelector('.bd-hero-badge');

        const lines=
            hero.querySelectorAll('.bd-hero-line>span');

        const desc=
            hero.querySelector('.bd-hero-desc');

        const button=
            hero.querySelector('.bd-wa-btn');

        const visual=
            hero.querySelector('.bd-hero-visual');

        const cards=
            hero.querySelectorAll('.bd-floating-card');

        const orbits=
            hero.querySelectorAll('.bd-hero-orbit');

        const dots=
            hero.querySelector('.bd-hero-dots');

        const background=
            hero.querySelector('.bd-hero-bg');

        const grid=
            hero.querySelector('.bd-hero-grid');

        const glow=
            hero.querySelector('.bd-hero-glow');

        if(lines.length){
            gsap.set(lines,{
                yPercent:110,
                opacity:0
            });
        }

        if(badge){
            gsap.set(badge,{
                opacity:0,
                y:20
            });
        }

        if(desc){
            gsap.set(desc,{
                opacity:0,
                y:22
            });
        }

        if(button){
            gsap.set(button,{
                opacity:0,
                y:20
            });
        }

        if(visual){
            gsap.set(visual,{
                opacity:0,
                x:55,
                scale:.92
            });
        }

        if(cards.length){
            gsap.set(cards,{
                opacity:0
            });
        }

        if(orbits.length){
            gsap.set(orbits,{
                opacity:0
            });
        }

        if(dots){
            gsap.set(dots,{
                opacity:0
            });
        }

        const tl=gsap.timeline({
            defaults:{
                ease:'power4.out'
            }
        });

        if(badge){

            tl.to(badge,{
                opacity:1,
                y:0,
                duration:.6
            });
        }

        if(lines.length){

            tl.to(lines,{
                opacity:1,
                yPercent:0,
                duration:.9,
                stagger:.12
            },'-=.3');
        }

        if(desc){

            tl.to(desc,{
                opacity:1,
                y:0,
                duration:.7
            },'-=.5');
        }

        if(button){

            tl.to(button,{
                opacity:1,
                y:0,
                duration:.6
            },'-=.45');
        }

        if(visual){

            tl.to(visual,{
                opacity:1,
                x:0,
                scale:1,
                duration:1
            },'-=.75');
        }

        if(orbits.length){

            tl.to(orbits,{
                opacity:1,
                duration:.5,
                stagger:.1
            },'-=.55');
        }

        if(cards.length){

            tl.to(cards,{
                opacity:1,
                duration:.45,
                stagger:.1
            },'-=.45');
        }

        if(dots){

            tl.to(dots,{
                opacity:1,
                duration:.4
            },'-=.2');
        }

        if(background){

            gsap.to(background,{
                yPercent:9,
                scale:1.05,
                ease:'none',

                scrollTrigger:{
                    trigger:hero,
                    start:'top top',
                    end:'bottom top',
                    scrub:1.2
                }
            });
        }

        if(grid){

            gsap.to(grid,{
                y:55,
                ease:'none',

                scrollTrigger:{
                    trigger:hero,
                    start:'top top',
                    end:'bottom top',
                    scrub:1.3
                }
            });
        }

        if(glow){

            gsap.to(glow,{
                x:-35,
                y:65,
                scale:1.1,
                ease:'none',

                scrollTrigger:{
                    trigger:hero,
                    start:'top top',
                    end:'bottom top',
                    scrub:1.4
                }
            });
        }

        if(visual){

            hero.addEventListener('pointermove',e=>{

                if(window.innerWidth<1024)return;

                const rect=
                    hero.getBoundingClientRect();

                const x=
                    (e.clientX-rect.left)/rect.width-.5;

                const y=
                    (e.clientY-rect.top)/rect.height-.5;

                gsap.to(visual,{
                    rotationY:x*4,
                    rotationX:-y*3,
                    duration:.8,
                    ease:'power3.out',
                    overwrite:'auto'
                });
            });

            hero.addEventListener('pointerleave',()=>{

                gsap.to(visual,{
                    rotationY:0,
                    rotationX:0,
                    duration:.8,
                    ease:'power3.out',
                    overwrite:'auto'
                });
            });
        }
    }

    /* =====================================================
       ALUR STORYTELLING
       PIN HANYA DI ALUR
    ===================================================== */
    const processSection=
        document.getElementById('alur');

    if(processSection){

        const stage=
            processSection.querySelector('.bd-process-stage');

        const items=[
            ...processSection.querySelectorAll('.bd-process-item')
        ];

        const progress=
            processSection.querySelector('.bd-process-progress');

        const hint=
            processSection.querySelector('.bd-process-scroll-hint');

        const media=
            gsap.matchMedia();

        /* DESKTOP */
        media.add('(min-width:1024px)',()=>{

            if(!stage||!items.length)return;

            gsap.set(items,{
                opacity:.28,
                y:55,
                scale:.94
            });

            if(progress){

                gsap.set(progress,{
                    scaleX:0,
                    transformOrigin:'left center'
                });
            }

            if(hint){

                gsap.set(hint,{
                    opacity:.55
                });
            }

            items.forEach(item=>{

                const card=
                    item.querySelector('.bd-process-card');

                const number=
                    item.querySelector('.bd-process-number');

                const icon=
                    item.querySelector('.bd-process-icon');

                const check=
                    item.querySelector('.bd-process-check');

                if(card){

                    gsap.set(card,{
                        backgroundColor:'#F8FAFC',
                        borderColor:'#F1F5F9',
                        boxShadow:'0 0 0 rgba(36,27,82,0)'
                    });
                }

                if(number){

                    gsap.set(number,{
                        color:'#CBD5E1'
                    });
                }

                if(icon){

                    gsap.set(icon,{
                        scale:.9
                    });
                }

                if(check){

                    gsap.set(check,{
                        opacity:.15,
                        scale:.65
                    });
                }
            });

            const story=
                gsap.timeline({

                    scrollTrigger:{
                        trigger:stage,
                        start:'top 18%',
                        end:'+=850',
                        pin:true,
                        scrub:.8,
                        anticipatePin:1,
                        invalidateOnRefresh:true
                    }
                });

            items.forEach((item,index)=>{

                const card=
                    item.querySelector('.bd-process-card');

                const number=
                    item.querySelector('.bd-process-number');

                const icon=
                    item.querySelector('.bd-process-icon');

                const check=
                    item.querySelector('.bd-process-check');

                const position=
                    index*.9;

                story.to(item,{
                    opacity:1,
                    y:0,
                    scale:1,
                    duration:.65,
                    ease:'power3.out'
                },position);

                if(card){

                    story.to(card,{
                        backgroundColor:'#FFFFFF',
                        borderColor:'rgba(239,88,67,.38)',
                        boxShadow:'0 22px 45px rgba(36,27,82,.10)',
                        duration:.55
                    },position);
                }

                if(number){

                    story.to(number,{
                        color:'#EF5843',
                        duration:.35
                    },position);
                }

                if(icon){

                    story.to(icon,{
                        scale:1.13,
                        rotation:-5,
                        duration:.4,
                        ease:'back.out(2)'
                    },position);

                    story.to(icon,{
                        scale:1,
                        rotation:0,
                        duration:.35
                    },position+.38);
                }

                if(check){

                    story.to(check,{
                        opacity:1,
                        scale:1,
                        duration:.35,
                        ease:'back.out(2)'
                    },position+.2);
                }

                if(progress){

                    story.to(progress,{
                        scaleX:(index+1)/items.length,
                        duration:.6,
                        ease:'none'
                    },position);
                }
            });

            if(hint){

                story.to(hint,{
                    opacity:0,
                    y:8,
                    duration:.35
                },3.2);
            }

            return()=>{

                story.scrollTrigger?.kill();
                story.kill();
            };
        });

        /* MOBILE/TABLET */
        media.add('(max-width:1023px)',()=>{

            items.forEach((item,index)=>{

                const icon=
                    item.querySelector('.bd-process-icon');

                const check=
                    item.querySelector('.bd-process-check');

                const tl=
                    gsap.timeline({

                        scrollTrigger:{
                            trigger:item,
                            start:'top 87%',
                            toggleActions:'play none none reverse'
                        }
                    });

                tl.from(item,{
                    opacity:0,
                    y:42,
                    scale:.96,
                    duration:.7,
                    delay:index*.04,
                    ease:'power3.out'
                });

                if(icon){

                    tl.from(icon,{
                        scale:.7,
                        rotation:-8,
                        duration:.42,
                        ease:'back.out(2)'
                    },'-=.48');
                }

                if(check){

                    tl.to(check,{
                        opacity:1,
                        scale:1,
                        duration:.35,
                        ease:'back.out(2)'
                    },'-=.28');
                }
            });
        });
    }

    /* =====================================================
       KATALOG PREMIUM 3D
       TANPA PIN
    ===================================================== */
    const catalog=
        document.getElementById('katalog');

    if(catalog){

        const slider=
            catalog.querySelector('.bd-book-slider');

        const slides=[
            ...catalog.querySelectorAll('[data-bd-catalog-item]')
        ];

        const prev=
            catalog.querySelector('[data-catalog-prev]');

        const next=
            catalog.querySelector('[data-catalog-next]');

        if(slides.length){

            gsap.from(slides,{
                opacity:0,
                y:60,
                scale:.92,
                rotationY:-10,
                stagger:.09,
                duration:.9,
                ease:'power4.out',

                scrollTrigger:{
                    trigger:catalog,
                    start:'top 82%'
                }
            });
        }

        slides.forEach((slide,index)=>{

            const card=
                slide.querySelector('.bd-home-book');

            const stage=
                slide.querySelector('.bd-book-stage');

            const shine=
                slide.querySelector('.bd-book-shine');

            if(!card||!stage)return;

            gsap.set(stage,{
                transformPerspective:900,
                transformStyle:'preserve-3d'
            });

            const rotateX=
                gsap.quickTo(stage,'rotationX',{
                    duration:.5,
                    ease:'power3.out'
                });

            const rotateY=
                gsap.quickTo(stage,'rotationY',{
                    duration:.5,
                    ease:'power3.out'
                });

            const moveX=
                gsap.quickTo(stage,'x',{
                    duration:.5,
                    ease:'power3.out'
                });

            const moveY=
                gsap.quickTo(stage,'y',{
                    duration:.5,
                    ease:'power3.out'
                });

            card.addEventListener('pointerenter',()=>{

                if(window.innerWidth<768)return;

                gsap.to(stage,{
                    scale:1.07,
                    y:-6,
                    duration:.45,
                    ease:'power3.out'
                });

                if(shine){

                    gsap.fromTo(shine,{
                        xPercent:-180,
                        opacity:0
                    },{
                        xPercent:260,
                        opacity:.8,
                        duration:.9,
                        ease:'power2.out'
                    });
                }
            });

            card.addEventListener('pointermove',e=>{

                if(window.innerWidth<768)return;

                const rect=
                    card.getBoundingClientRect();

                const px=
                    (e.clientX-rect.left)/rect.width-.5;

                const py=
                    (e.clientY-rect.top)/rect.height-.5;

                rotateY(px*18);
                rotateX(-py*11);

                moveX(px*9);
                moveY(py*5-6);
            });

            card.addEventListener('pointerleave',()=>{

                rotateX(0);
                rotateY(0);

                moveX(0);
                moveY(0);

                gsap.to(stage,{
                    scale:1,
                    duration:.6,
                    ease:'elastic.out(1,.45)'
                });
            });

            gsap.to(slide,{
                y:index%2===0?-9:9,
                ease:'none',

                scrollTrigger:{
                    trigger:catalog,
                    start:'top bottom',
                    end:'bottom top',
                    scrub:1.4
                }
            });
        });

        const scrollCatalog=direction=>{

            if(!slider)return;

            const first=
                slider.querySelector('.bd-book-slide');

            const gap=
                parseFloat(getComputedStyle(slider).gap)||18;

            const amount=
                (first?.getBoundingClientRect().width||260)+gap;

            slider.scrollBy({
                left:amount*direction,
                behavior:'smooth'
            });
        };

        prev?.addEventListener('click',()=>{
            scrollCatalog(-1);
        });

        next?.addEventListener('click',()=>{
            scrollCatalog(1);
        });
    }

    /* =====================================================
       INFORMATION PARALLAX
    ===================================================== */
    document.querySelectorAll('.bd-info-card').forEach(card=>{

        const image=
            card.querySelector('.bd-info-image img');

        if(!image)return;

        gsap.fromTo(image,{
            yPercent:-4,
            scale:1.06
        },{
            yPercent:4,
            scale:1.06,
            ease:'none',

            scrollTrigger:{
                trigger:card,
                start:'top bottom',
                end:'bottom top',
                scrub:1.2
            }
        });
    });

    /* =====================================================
       CTA
    ===================================================== */
    const cta=
        document.querySelector('.bd-cta-section');

    if(cta){

        const card=
            cta.querySelector('.bd-publish-card');

        const pills=
            cta.querySelectorAll('.bd-cta-pill');

        const action=
            cta.querySelector('.bd-publish-action');

        const background=
            cta.querySelector('.bd-cta-background');

        if(card){

            gsap.from(card,{
                opacity:0,
                y:55,
                scale:.95,
                duration:1,
                ease:'power4.out',

                scrollTrigger:{
                    trigger:cta,
                    start:'top 80%'
                }
            });
        }

        if(pills.length){

            gsap.from(pills,{
                opacity:0,
                y:15,
                scale:.92,
                stagger:.08,
                duration:.5,
                ease:'back.out(1.6)',

                scrollTrigger:{
                    trigger:cta,
                    start:'top 72%'
                }
            });
        }

        if(action){

            gsap.from(action,{
                opacity:0,
                x:35,
                duration:.8,
                ease:'power3.out',

                scrollTrigger:{
                    trigger:cta,
                    start:'top 72%'
                }
            });
        }

        if(background){

            gsap.to(background,{
                scale:1.1,
                y:30,
                ease:'none',

                scrollTrigger:{
                    trigger:cta,
                    start:'top bottom',
                    end:'bottom top',
                    scrub:1.2
                }
            });
        }
    }

    /* =====================================================
       TESTIMONI GLOW
    ===================================================== */
    const testimonial=
        document.getElementById('testimoni');

    if(testimonial){

        testimonial
            .querySelectorAll('.bdt-glow')
            .forEach((glow,index)=>{

                gsap.to(glow,{
                    y:index===0?60:-60,
                    x:index===0?28:-28,
                    ease:'none',

                    scrollTrigger:{
                        trigger:testimonial,
                        start:'top bottom',
                        end:'bottom top',
                        scrub:1.4
                    }
                });
            });
    }

    /* =====================================================
       AFILIASI INFINITE MARQUEE
    ===================================================== */
    const affiliate=
        document.getElementById('afiliasi');

    if(affiliate){

        const wrap=
            affiliate.querySelector('.bd-affiliate-wrap');

        const track=
            affiliate.querySelector('.bd-affiliate-track');

        if(wrap&&track){

            let marquee=null;
            let settleTimer=null;
            let affiliateResizeTimer=null;
            let currentDirection=1;

            const createMarquee=()=>{

                if(marquee){
                    marquee.kill();
                    marquee=null;
                }

                gsap.killTweensOf(track);

                gsap.set(track,{
                    x:0
                });

                const gap=
                    parseFloat(getComputedStyle(track).gap)||0;

                const distance=
                    track.scrollWidth/2+gap/2;

                if(distance<=0)return;

                marquee=gsap.to(track,{
                    x:-distance,
                    duration:34,
                    ease:'none',
                    repeat:-1
                });

                marquee.timeScale(currentDirection);
            };

            /*
             * Tunggu logo/image selesai dihitung agar
             * scrollWidth marquee benar.
             */
            window.addEventListener('load',()=>{
                createMarquee();
            });

            /*
             * Tetap dibuat saat DOM siap juga,
             * lalu load akan mengoreksi ukurannya.
             */
            requestAnimationFrame(()=>{
                createMarquee();
            });

            ScrollTrigger.create({
                trigger:affiliate,
                start:'top bottom',
                end:'bottom top',

                onUpdate:self=>{

                    if(!marquee)return;

                    currentDirection=
                        self.direction>0?1:-1;

                    gsap.to(marquee,{
                        timeScale:currentDirection*2.2,
                        duration:.2,
                        overwrite:true
                    });

                    if(settleTimer){
                        settleTimer.kill();
                    }

                    settleTimer=
                        gsap.delayedCall(.18,()=>{

                            if(!marquee)return;

                            gsap.to(marquee,{
                                timeScale:currentDirection,
                                duration:.75,
                                ease:'power2.out'
                            });
                        });
                }
            });

            /* HOVER PAUSE */
            wrap.addEventListener('mouseenter',()=>{

                if(!marquee)return;

                gsap.to(marquee,{
                    timeScale:0,
                    duration:.35,
                    ease:'power2.out'
                });
            });

            /* JALAN LAGI */
            wrap.addEventListener('mouseleave',()=>{

                if(!marquee)return;

                gsap.to(marquee,{
                    timeScale:currentDirection,
                    duration:.55,
                    ease:'power2.out'
                });
            });

            window.addEventListener('resize',()=>{

                clearTimeout(affiliateResizeTimer);

                affiliateResizeTimer=setTimeout(()=>{

                    createMarquee();
                    ScrollTrigger.refresh();

                },250);
            });
        }
    }

    /* =====================================================
       GLOBAL 3D TILT
    ===================================================== */
    document.querySelectorAll('[data-bd-tilt]').forEach(card=>{

        gsap.set(card,{
            transformPerspective:1000,
            transformStyle:'preserve-3d'
        });

        const rx=
            gsap.quickTo(card,'rotationX',{
                duration:.4,
                ease:'power3.out'
            });

        const ry=
            gsap.quickTo(card,'rotationY',{
                duration:.4,
                ease:'power3.out'
            });

        card.addEventListener('pointermove',e=>{

            if(window.innerWidth<768)return;

            const rect=
                card.getBoundingClientRect();

            const x=
                (e.clientX-rect.left)/rect.width;

            const y=
                (e.clientY-rect.top)/rect.height;

            rx((.5-y)*4);
            ry((x-.5)*5.5);
        });

        card.addEventListener('pointerleave',()=>{

            rx(0);
            ry(0);
        });
    });

    /* =====================================================
       DEPTH
    ===================================================== */
    gsap.set('.bd-depth-1',{
        z:14
    });

    gsap.set('.bd-depth-2',{
        z:26
    });

    /* =====================================================
       SECTION GLOW
    ===================================================== */
    document.querySelectorAll('.bd-section-glow').forEach(glow=>{

        const section=
            glow.closest('section');

        if(!section)return;

        gsap.to(glow,{
            y:75,
            ease:'none',

            scrollTrigger:{
                trigger:section,
                start:'top bottom',
                end:'bottom top',
                scrub:1.4
            }
        });
    });

    /* =====================================================
       MAGNETIC BUTTON
    ===================================================== */
    document.querySelectorAll(
        '.bd-wa-btn,.bd-book-detail,.bd-info-read,.bd-publish-action>a'
    ).forEach(button=>{

        button.addEventListener('pointermove',e=>{

            if(window.innerWidth<768)return;

            const rect=
                button.getBoundingClientRect();

            const x=
                e.clientX-rect.left-rect.width/2;

            const y=
                e.clientY-rect.top-rect.height/2;

            gsap.to(button,{
                x:x*.08,
                y:y*.1,
                duration:.3,
                ease:'power3.out'
            });
        });

        button.addEventListener('pointerleave',()=>{

            gsap.to(button,{
                x:0,
                y:0,
                duration:.6,
                ease:'elastic.out(1,.45)'
            });
        });
    });

    /* =====================================================
       KALKULATOR MONEY
    ===================================================== */
    window.bdAnimateMoney=(
        element,
        value,
        prefix='Rp '
    )=>{

        if(!element)return;

        if(element._bdMoneyTween){
            element._bdMoneyTween.kill();
        }

        let current=
            Number(element.dataset.value);

        if(!Number.isFinite(current)){

            current=
                Number(
                    String(element.textContent||'')
                        .replace(/[^\d]/g,'')
                )||0;
        }

        const state={
            value:current
        };

        element._bdMoneyTween=
            gsap.to(state,{

                value:Number(value||0),
                duration:.55,
                ease:'power2.out',

                onUpdate:()=>{

                    element.textContent=
                        prefix+
                        Math.round(state.value)
                            .toLocaleString('id-ID');
                },

                onComplete:()=>{

                    element.dataset.value=
                        Number(value||0);

                    element._bdMoneyTween=null;
                }
            });
    };

    /* =====================================================
       REFRESH
    ===================================================== */
    window.addEventListener('load',()=>{

        ScrollTrigger.refresh();
    });

    let resizeTimer=null;

    window.addEventListener('resize',()=>{

        clearTimeout(resizeTimer);

        resizeTimer=setTimeout(()=>{

            ScrollTrigger.refresh();

        },180);
    });

    ScrollTrigger.refresh();
});