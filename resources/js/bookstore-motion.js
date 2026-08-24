import gsap from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/* =====================================================
   GLOBAL
===================================================== */
const CART_KEY='bacadulu_cart';
const WA_NUMBER='6285139461070';
const STORE_PATH='/portofolio/bookstore';

const reduceMotion=window.matchMedia('(prefers-reduced-motion:reduce)').matches;

const bookControllers=new WeakMap();

let motionPromise=null;
let animePromise=null;
let threePromise=null;
let barbaPromise=null;

/* =====================================================
   DYNAMIC LOADERS
===================================================== */
const loadMotion=()=>{
    if(!motionPromise){
        motionPromise=import('motion').catch(()=>null);
    }

    return motionPromise;
};

const loadAnime=()=>{
    if(!animePromise){
        animePromise=import('animejs').catch(()=>null);
    }

    return animePromise;
};

const loadThree=()=>{
    if(!threePromise){
        threePromise=import('three').catch(()=>null);
    }

    return threePromise;
};

const loadBarba=()=>{
    if(!barbaPromise){
        barbaPromise=import('@barba/core')
            .then(module=>module.default||module)
            .catch(()=>null);
    }

    return barbaPromise;
};

/* =====================================================
   UTILITIES
===================================================== */
const rupiah=value=>'IDR '+Number(value||0).toLocaleString('id-ID',{
    minimumFractionDigits:2,
    maximumFractionDigits:2
});

const escapeHtml=value=>{
    const el=document.createElement('div');
    el.textContent=value??'';
    return el.innerHTML;
};

const normalizeCart=data=>{
    if(!Array.isArray(data))return[];

    return data.map((item,index)=>{
        let title=String(item.title??'');
        let format=item.format??'Buku';

        if(!item.format&&title.toLowerCase().includes('e-book')){
            format='E-book';
        }

        if(!item.format&&title.toLowerCase().includes('cetak')){
            format='Buku Cetak';
        }

        return{
            key:String(
                item.key??
                item.productKey??
                `legacy-${item.id??index}-${index}`
            ),

            bookId:item.bookId??item.id??null,

            title:title.replace(
                /\s*-\s*(Buku Cetak|E-book)$/i,
                ''
            ),

            format,
            author:String(item.author??''),
            publisher:String(item.publisher??''),
            cover:String(item.cover??''),
            price:Number(item.price??0),
            qty:Math.max(1,Number(item.qty??1))
        };
    }).filter(item=>item.title&&item.price>0);
};

const loadCart=()=>{
    try{
        return normalizeCart(
            JSON.parse(
                localStorage.getItem(CART_KEY)||'[]'
            )
        );
    }catch{
        return[];
    }
};

const saveCart=cart=>{
    localStorage.setItem(
        CART_KEY,
        JSON.stringify(cart)
    );
};

/* =====================================================
   MOTION SVG
===================================================== */
const drawSvg=async root=>{
    if(reduceMotion||!root)return;

    const paths=[
        ...root.querySelectorAll('.motion-draw')
    ];

    if(!paths.length)return;

    const motion=await loadMotion();

    if(!motion?.animate)return;

    paths.forEach((path,index)=>{
        if(path.dataset.motionDrawn==='1')return;

        path.dataset.motionDrawn='1';

        try{
            motion.animate(
                path,
                {
                    pathLength:[0,1],
                    opacity:[0,1]
                },
                {
                    duration:.7,
                    delay:index*.035,
                    ease:'easeOut'
                }
            );
        }catch{}
    });
};

/* =====================================================
   ANIME JS MICRO FEEDBACK
===================================================== */
const animeFlash=async element=>{
    if(reduceMotion||!element)return;

    const mod=await loadAnime();

    if(!mod)return;

    try{
        if(typeof mod.animate==='function'){
            mod.animate(element,{
                opacity:[1,.68,1],
                duration:320,
                ease:'out(3)'
            });

            return;
        }

        if(typeof mod.default==='function'){
            mod.default({
                targets:element,
                opacity:[1,.68,1],
                duration:320,
                easing:'easeOutQuad'
            });
        }
    }catch{}
};

/* =====================================================
   THREE JS AMBIENT HERO

   - ±30 FPS
   - hanya aktif ketika hero terlihat
   - pause ketika tab tidak aktif
   - dispose ketika Barba meninggalkan halaman
===================================================== */
const initThreeAmbient=async(canvas,host)=>{
    if(
        reduceMotion||
        !canvas||
        !host||
        canvas.dataset.threeReady==='1'
    ){
        return;
    }

    canvas.dataset.threeReady='1';

    const THREE=await loadThree();

    if(!THREE){
        canvas.dataset.threeReady='0';
        return;
    }

    if(!document.documentElement.contains(host)){
        canvas.dataset.threeReady='0';
        return;
    }

    let renderer=null;
    let raf=null;
    let running=false;
    let visible=false;
    let lastFrame=0;

    let intersectionObserver=null;
    let resizeObserver=null;

    try{
        const scene=new THREE.Scene();

        const camera=new THREE.PerspectiveCamera(
            45,
            1,
            .1,
            100
        );

        camera.position.z=5;

        renderer=new THREE.WebGLRenderer({
            canvas,
            alpha:true,
            antialias:false,
            powerPreference:'low-power'
        });

        renderer.setPixelRatio(
            Math.min(
                window.devicePixelRatio||1,
                1.25
            )
        );

        const mobile=window.innerWidth<768;
        const count=mobile?12:30;

        const positions=new Float32Array(count*3);

        for(let i=0;i<count;i++){
            positions[i*3]=(Math.random()-.5)*7;
            positions[i*3+1]=(Math.random()-.5)*4.4;
            positions[i*3+2]=(Math.random()-.5)*2;
        }

        const geometry=new THREE.BufferGeometry();

        geometry.setAttribute(
            'position',
            new THREE.BufferAttribute(
                positions,
                3
            )
        );

        const material=new THREE.PointsMaterial({
            size:mobile?.035:.045,
            color:0xEF5843,
            transparent:true,
            opacity:.24,
            depthWrite:false
        });

        const particles=new THREE.Points(
            geometry,
            material
        );

        scene.add(particles);

        const resize=()=>{
            if(
                !document.documentElement.contains(host)
            ){
                return;
            }

            const rect=host.getBoundingClientRect();

            if(!rect.width||!rect.height)return;

            renderer.setSize(
                rect.width,
                rect.height,
                false
            );

            camera.aspect=
                rect.width/
                rect.height;

            camera.updateProjectionMatrix();
        };

        const frame=time=>{
            if(!running)return;

            if(time-lastFrame>=33){
                lastFrame=time;

                particles.rotation.y+=.001;
                particles.rotation.x+=.00025;

                renderer.render(
                    scene,
                    camera
                );
            }

            raf=requestAnimationFrame(frame);
        };

        const sync=()=>{
            const shouldRun=
                visible&&
                !document.hidden&&
                document.documentElement.contains(host);

            if(shouldRun&&!running){
                running=true;
                lastFrame=0;

                raf=requestAnimationFrame(frame);
            }

            if(!shouldRun&&running){
                running=false;

                if(raf){
                    cancelAnimationFrame(raf);
                    raf=null;
                }
            }
        };

        intersectionObserver=new IntersectionObserver(
            entries=>{
                visible=Boolean(
                    entries[0]?.isIntersecting
                );

                sync();
            },
            {
                threshold:.04
            }
        );

        intersectionObserver.observe(host);

        const onVisibilityChange=()=>{
            sync();
        };

        document.addEventListener(
            'visibilitychange',
            onVisibilityChange
        );

        if('ResizeObserver' in window){
            resizeObserver=new ResizeObserver(resize);
            resizeObserver.observe(host);
        }

        resize();

        canvas.__bdThreeCleanup=()=>{
            running=false;

            if(raf){
                cancelAnimationFrame(raf);
                raf=null;
            }

            intersectionObserver?.disconnect();
            resizeObserver?.disconnect();

            document.removeEventListener(
                'visibilitychange',
                onVisibilityChange
            );

            geometry.dispose();
            material.dispose();

            renderer?.dispose();

            canvas.__bdThreeCleanup=null;
            canvas.dataset.threeReady='0';
        };

    }catch{
        renderer?.dispose?.();
        canvas.dataset.threeReady='0';
    }
};

/* =====================================================
   BOOK 3D CONTROLLER

   .book-float
   → idle floating

   .book-tilt
   → pointer tilt

   .book-3d
   → visual buku
===================================================== */
const createBookController=(card,index=0)=>{
    if(!card)return null;

    if(bookControllers.has(card)){
        return bookControllers.get(card);
    }

    const floatLayer=card.querySelector('.book-float');
    const tiltLayer=card.querySelector('.book-tilt');
    const book=card.querySelector('.book-3d');

    if(!book)return null;

    const floatTarget=floatLayer||book;
    const tiltTarget=tiltLayer||book;

    let sectionActive=false;
    let interacting=false;
    let resumeCall=null;

    if(tiltLayer){
        gsap.set(tiltLayer,{
            rotationX:0,
            rotationY:0,
            transformPerspective:900,
            transformStyle:'preserve-3d'
        });
    }

    const idle=gsap.to(floatTarget,{
        y:-5,
        duration:3.7+(index%4)*.28,
        repeat:-1,
        yoyo:true,
        ease:'sine.inOut',
        paused:true
    });

    idle.progress((index*.17)%1).pause();

    const rotateX=gsap.quickTo(
        tiltTarget,
        'rotationX',
        {
            duration:.48,
            ease:'power3.out'
        }
    );

    const rotateY=gsap.quickTo(
        tiltTarget,
        'rotationY',
        {
            duration:.48,
            ease:'power3.out'
        }
    );

    const scale=gsap.quickTo(
        tiltTarget,
        'scale',
        {
            duration:.48,
            ease:'power3.out'
        }
    );

    const start=()=>{
        sectionActive=true;

        if(!interacting){
            idle.resume();
        }
    };

    const pause=()=>{
        sectionActive=false;
        idle.pause();
    };

    const pauseForInteraction=()=>{
        idle.pause();

        if(resumeCall){
            resumeCall.kill();
            resumeCall=null;
        }
    };

    const resumeAfterInteraction=()=>{
        if(!sectionActive)return;

        resumeCall=gsap.delayedCall(.22,()=>{
            if(
                sectionActive&&
                !interacting
            ){
                idle.resume();
            }
        });
    };

    card.addEventListener('pointerenter',()=>{
        if(window.innerWidth<768)return;

        interacting=true;

        pauseForInteraction();

        scale(1.035);

        gsap.to(card,{
            y:-5,
            borderColor:'rgba(239,88,67,.28)',
            boxShadow:'0 18px 36px rgba(36,27,82,.11)',
            duration:.3,
            ease:'power3.out',
            overwrite:true
        });
    });

    card.addEventListener('pointermove',e=>{
        if(window.innerWidth<768)return;

        const rect=card.getBoundingClientRect();

        const px=
            (e.clientX-rect.left)/
            rect.width-.5;

        const py=
            (e.clientY-rect.top)/
            rect.height-.5;

        rotateY(px*9);
        rotateX(-py*5);
    });

    card.addEventListener('pointerleave',()=>{
        interacting=false;

        rotateX(0);
        rotateY(0);
        scale(1);

        gsap.to(card,{
            y:0,
            borderColor:'#EAE7DF',
            boxShadow:'0 5px 16px rgba(36,27,82,.045)',
            duration:.42,
            ease:'power3.out',
            overwrite:true
        });

        resumeAfterInteraction();
    });

    const controller={
        start,
        pause,
        pauseForInteraction,
        resumeAfterInteraction
    };

    bookControllers.set(
        card,
        controller
    );

    return controller;
};

const initBookControllers=root=>{
    root.querySelectorAll('.book-card').forEach(
        (card,index)=>{
            createBookController(
                card,
                index
            );
        }
    );
};

const getBookControllers=root=>{
    if(!root)return[];

    return[
        ...root.querySelectorAll('.book-card')
    ]
        .map(
            card=>bookControllers.get(card)
        )
        .filter(Boolean);
};

const startBooks=root=>{
    getBookControllers(root).forEach(
        controller=>{
            controller.start();
        }
    );
};

const pauseBooks=root=>{
    getBookControllers(root).forEach(
        controller=>{
            controller.pause();
        }
    );
};

/* =====================================================
   BOOKSTORE HERO
===================================================== */
const initStoreHero=root=>{
    if(reduceMotion)return;

    const hero=root.querySelector('.store-hero');

    if(!hero)return;

    const badge=hero.querySelector('.eyebrow');
    const title=hero.querySelector('h1');
    const desc=hero.querySelector('.hero-description');
    const stats=hero.querySelectorAll('.hero-stat');
    const canvas=hero.querySelector('[data-store-ambient]');

    const tl=gsap.timeline({
        defaults:{
            ease:'power4.out'
        }
    });

    if(badge){
        tl.from(badge,{
            autoAlpha:0,
            y:20,
            duration:.58
        });
    }

    if(title){
        tl.from(title,{
            autoAlpha:0,
            y:42,
            duration:.88
        },'-=.4');
    }

    if(desc){
        tl.from(desc,{
            autoAlpha:0,
            y:24,
            duration:.68
        },'-=.57');
    }

    if(stats.length){
        tl.from(stats,{
            autoAlpha:0,
            y:22,
            scale:.95,
            duration:.62,
            stagger:.085
        },'-=.48');
    }

    tl.call(()=>{
        drawSvg(hero);
    },null,.38);

    if(canvas){
        tl.call(()=>{
            initThreeAmbient(
                canvas,
                hero
            );
        },null,.25);
    }

    root.querySelectorAll(
        '[data-store-count]'
    ).forEach((el,index)=>{
        const target=Number(
            el.dataset.storeCount||0
        );

        const plus=
            el.dataset.plus==='1';

        const state={
            value:0
        };

        gsap.to(state,{
            value:target,
            duration:.9,
            delay:.58+index*.08,
            ease:'power2.out',

            onUpdate:()=>{
                el.textContent=
                    Math.round(state.value)
                        .toLocaleString('id-ID')+
                    (plus?'+':'');
            }
        });
    });
};

/* =====================================================
   BOOKSTORE SECTIONS
===================================================== */
const initStoreSections=root=>{
    const sections=[
        ...root.querySelectorAll(
            '[data-motion-section]'
        )
    ];

    sections.forEach(section=>{
        let played=false;

        const divider=section.querySelector(
            '[data-motion-divider] span'
        );

        const head=section.querySelector(
            '.section-head'
        );

        const controls=section.querySelector(
            '.latest-controls'
        );

        const chips=section.querySelectorAll(
            '.category-chip'
        );

        const slides=section.querySelectorAll(
            '.latest-slide'
        );

        const catalogItems=section.querySelectorAll(
            '.catalog-item'
        );

        const cta=section.querySelector(
            '.cta-banner'
        );

        const play=()=>{
            if(played||reduceMotion)return;

            played=true;

            const tl=gsap.timeline({
                defaults:{
                    ease:'power4.out'
                }
            });

            if(divider){
                tl.fromTo(
                    divider,
                    {
                        scaleX:0,
                        transformOrigin:'left center'
                    },
                    {
                        scaleX:1,
                        duration:.82,
                        ease:'power3.inOut'
                    }
                );
            }

            if(head){
                tl.from(
                    head,
                    {
                        autoAlpha:0,
                        x:-26,
                        y:8,
                        duration:.68
                    },
                    divider?'-=.58':0
                );
            }

            if(controls){
                tl.from(
                    controls,
                    {
                        autoAlpha:0,
                        x:20,
                        duration:.55
                    },
                    '-=.52'
                );
            }

            tl.call(
                ()=>{
                    drawSvg(section);
                },
                null,
                divider ? .3 : .12
            );

            if(chips.length){
                tl.from(
                    chips,
                    {
                        autoAlpha:0,
                        y:12,
                        scale:.96,
                        duration:.46,
                        stagger:.035
                    },
                    '-=.4'
                );
            }

            if(slides.length){
                tl.from(
                    slides,
                    {
                        autoAlpha:0,
                        y:38,
                        scale:.96,
                        duration:.78,
                        stagger:.075,
                        ease:'power4.out'
                    },
                    '-=.38'
                );

                tl.from(
                    section.querySelectorAll(
                        '.latest-slide .book-tilt'
                    ),
                    {
                        rotationY:6,
                        rotationX:-2,
                        duration:.8,
                        stagger:.075,
                        ease:'power3.out'
                    },
                    '<'
                );
            }

            if(catalogItems.length){
                tl.from(
                    catalogItems,
                    {
                        autoAlpha:0,
                        y:34,
                        scale:.97,
                        duration:.72,
                        stagger:.065
                    },
                    '-=.35'
                );

                tl.from(
                    section.querySelectorAll(
                        '.catalog-item .book-tilt'
                    ),
                    {
                        rotationY:6,
                        rotationX:-2,
                        duration:.78,
                        stagger:.065,
                        ease:'power3.out'
                    },
                    '<'
                );
            }

            if(cta){
                const copy=
                    cta.querySelector('.cta-copy')||
                    cta.firstElementChild;

                const button=
                    cta.querySelector('.cta-btn');

                tl.from(
                    cta,
                    {
                        autoAlpha:0,
                        y:28,
                        duration:.68
                    },
                    '-=.25'
                );

                if(copy){
                    tl.from(
                        copy,
                        {
                            x:-22,
                            autoAlpha:0,
                            duration:.55
                        },
                        '-=.48'
                    );
                }

                if(button){
                    tl.from(
                        button,
                        {
                            x:22,
                            autoAlpha:0,
                            duration:.55
                        },
                        '<'
                    );
                }
            }

            tl.call(
                ()=>{
                    startBooks(section);
                },
                null,
                '-=.28'
            );
        };

        ScrollTrigger.create({
            trigger:section,
            start:'top 88%',
            end:'bottom 8%',

            onEnter:()=>{
                if(!played){
                    play();
                }else{
                    startBooks(section);
                }
            },

            onEnterBack:()=>{
                startBooks(section);
            },

            onLeave:()=>{
                pauseBooks(section);
            },

            onLeaveBack:()=>{
                pauseBooks(section);
            }
        });
    });
};

/* =====================================================
   LATEST BOOK SLIDER
===================================================== */
const initLatestSlider=root=>{
    const slider=root.querySelector(
        '#latestSlider'
    );

    const prev=root.querySelector(
        '#latestPrev'
    );

    const next=root.querySelector(
        '#latestNext'
    );

    if(!slider)return;

    const section=slider.closest(
        '[data-motion-section],.store-section'
    );

    let busy=false;
    let dragging=false;
    let moved=false;

    let startX=0;
    let startScroll=0;

    const isInteractiveTarget=target=>{
        if(!(target instanceof Element)){
            return false;
        }

        return Boolean(
            target.closest(
                'a,button,input,select,textarea,label,[role="button"]'
            )
        );
    };

    const getAmount=()=>{
        const slide=slider.querySelector(
            '.latest-slide'
        );

        if(!slide){
            return slider.clientWidth;
        }

        const gap=parseFloat(
            getComputedStyle(slider).gap
        )||18;

        return(
            slide.getBoundingClientRect().width+
            gap
        );
    };

    const getMax=()=>{
        return Math.max(
            0,
            slider.scrollWidth-
            slider.clientWidth
        );
    };

    const updateButtons=()=>{
        const max=getMax();

        if(prev){
            prev.disabled=
                slider.scrollLeft<=2;

            prev.classList.toggle(
                'is-disabled',
                prev.disabled
            );
        }

        if(next){
            next.disabled=
                slider.scrollLeft>=max-2;

            next.classList.toggle(
                'is-disabled',
                next.disabled
            );
        }
    };

    const visibleSlides=()=>{
        const viewport=
            slider.getBoundingClientRect();

        return[
            ...slider.querySelectorAll(
                '.latest-slide'
            )
        ].filter(slide=>{
            const rect=
                slide.getBoundingClientRect();

            return(
                rect.right>viewport.left&&
                rect.left<viewport.right
            );
        });
    };

    const animateIncoming=direction=>{
        if(reduceMotion)return;

        const incoming=
            visibleSlides();

        if(!incoming.length)return;

        gsap.fromTo(
            incoming,
            {
                x:direction>0?24:-24,
                scale:.965
            },
            {
                x:0,
                scale:1,
                duration:.48,
                stagger:.04,
                ease:'power4.out',
                overwrite:true
            }
        );

        const books=incoming
            .map(
                slide=>
                    slide.querySelector(
                        '.book-tilt'
                    )
            )
            .filter(Boolean);

        gsap.fromTo(
            books,
            {
                rotationY:
                    direction>0?5:-5
            },
            {
                rotationY:0,
                duration:.55,
                stagger:.04,
                ease:'power3.out',
                overwrite:true
            }
        );
    };

    const move=direction=>{
        if(busy)return;

        const start=
            slider.scrollLeft;

        const target=Math.max(
            0,
            Math.min(
                start+
                getAmount()*direction,
                getMax()
            )
        );

        if(
            Math.abs(target-start)<2
        ){
            return;
        }

        busy=true;

        pauseBooks(section);

        if(reduceMotion){
            slider.scrollLeft=
                target;

            busy=false;

            updateButtons();
            startBooks(section);

            return;
        }

        const current=
            visibleSlides();

        const state={
            value:start
        };

        const tl=gsap.timeline({
            onComplete:()=>{
                busy=false;

                updateButtons();

                animateIncoming(
                    direction
                );

                gsap.delayedCall(
                    .35,
                    ()=>{
                        startBooks(
                            section
                        );
                    }
                );
            }
        });

        tl.to(
            current,
            {
                scale:.98,
                x:direction>0?-9:9,
                duration:.18,
                stagger:.012,
                ease:'power2.out'
            }
        );

        tl.to(
            state,
            {
                value:target,
                duration:.6,
                ease:'power4.inOut',

                onUpdate:()=>{
                    slider.scrollLeft=
                        state.value;
                }
            },
            '-=.04'
        );

        tl.set(
            current,
            {
                x:0,
                scale:1
            }
        );
    };

    prev?.addEventListener(
        'click',
        ()=>move(-1)
    );

    next?.addEventListener(
        'click',
        ()=>move(1)
    );

    /* =================================================
       DRAG SLIDER

       LINK/BUTTON TIDAK BOLEH
       DIAMBIL POINTER-NYA
    ================================================= */
    slider.addEventListener(
        'pointerdown',
        e=>{
            if(
                isInteractiveTarget(
                    e.target
                )
            ){
                dragging=false;
                moved=false;

                return;
            }

            if(
                e.pointerType==='mouse'&&
                e.button!==0
            ){
                return;
            }

            dragging=true;
            moved=false;

            startX=e.clientX;

            startScroll=
                slider.scrollLeft;

            pauseBooks(section);

            slider.classList.add(
                'is-dragging'
            );

            slider
                .setPointerCapture?.(
                    e.pointerId
                );
        }
    );

    slider.addEventListener(
        'pointermove',
        e=>{
            if(!dragging)return;

            const delta=
                e.clientX-startX;

            if(
                Math.abs(delta)>5
            ){
                moved=true;
            }

            slider.scrollLeft=
                startScroll-delta;

            updateButtons();
        }
    );

    const finishDrag=e=>{
        if(!dragging)return;

        dragging=false;

        slider.classList.remove(
            'is-dragging'
        );

        try{
            slider
                .releasePointerCapture?.(
                    e.pointerId
                );
        }catch{}

        const amount=
            getAmount();

        if(!amount){
            startBooks(section);

            return;
        }

        const current=
            slider.scrollLeft;

        const target=Math.max(
            0,
            Math.min(
                Math.round(
                    current/
                    amount
                )*
                amount,

                getMax()
            )
        );

        const direction=
            target>=current
                ?1
                :-1;

        if(reduceMotion){
            slider.scrollLeft=
                target;

            updateButtons();
            startBooks(section);

            return;
        }

        const state={
            value:current
        };

        gsap.to(
            state,
            {
                value:target,
                duration:.42,
                ease:'power3.out',

                onUpdate:()=>{
                    slider.scrollLeft=
                        state.value;
                },

                onComplete:()=>{
                    updateButtons();

                    animateIncoming(
                        direction
                    );

                    gsap.delayedCall(
                        .32,
                        ()=>{
                            startBooks(
                                section
                            );
                        }
                    );
                }
            }
        );
    };

    slider.addEventListener(
        'pointerup',
        finishDrag
    );

    slider.addEventListener(
        'pointercancel',
        finishDrag
    );

    slider.addEventListener(
        'scroll',
        updateButtons,
        {
            passive:true
        }
    );

    /*
     * Click setelah drag diblok.
     *
     * Tapi klik button/link asli
     * tidak diblok.
     */
    slider.addEventListener(
        'click',
        e=>{
            if(
                isInteractiveTarget(
                    e.target
                )
            ){
                moved=false;
                return;
            }

            if(!moved)return;

            e.preventDefault();
            e.stopPropagation();

            moved=false;
        },
        true
    );

    updateButtons();
};

/* =====================================================
   BUTTON INTERACTION
===================================================== */
const initButtons=root=>{
    if(reduceMotion)return;

    root.querySelectorAll(
        '.format-add,'+
        '.detail-btn,'+
        '.category-chip,'+
        '.cta-btn,'+
        '.latest-arrow,'+
        '.add-format-button,'+
        '.detail-back'
    ).forEach(button=>{
        if(
            button.dataset.motionButton==='1'
        ){
            return;
        }

        button.dataset.motionButton='1';

        button.addEventListener(
            'pointerenter',
            ()=>{
                if(
                    window.innerWidth<768
                ){
                    return;
                }

                gsap.to(
                    button,
                    {
                        y:-2,
                        duration:.22,
                        ease:'power3.out',
                        overwrite:true
                    }
                );
            }
        );

        button.addEventListener(
            'pointerleave',
            ()=>{
                gsap.to(
                    button,
                    {
                        y:0,
                        scale:1,
                        duration:.32,
                        ease:'power3.out',
                        overwrite:true
                    }
                );
            }
        );

        button.addEventListener(
            'pointerdown',
            ()=>{
                if(button.disabled)return;

                gsap.to(
                    button,
                    {
                        scale:.96,
                        duration:.1,
                        ease:'power2.out',
                        overwrite:true
                    }
                );
            }
        );

        const release=()=>{
            gsap.to(
                button,
                {
                    scale:1,
                    duration:.27,
                    ease:'back.out(1.6)',
                    overwrite:true
                }
            );
        };

        button.addEventListener(
            'pointerup',
            release
        );

        button.addEventListener(
            'pointercancel',
            release
        );
    });
};

/* =====================================================
   ADD TO CART FLY ANIMATION

   Cover buku clone akan:
   1. keluar dari card
   2. sedikit naik
   3. melengkung
   4. mengecil
   5. masuk ke cart FAB
===================================================== */
const animateAddToCart=(button,root)=>{
    if(
        !button||
        !root
    ){
        return;
    }

    const fab=
        root.querySelector(
            '#cartFab'
        );

    const count=
        root.querySelector(
            '#cartCount'
        );

    if(
        reduceMotion||
        !fab
    ){
        animeFlash(button);
        return;
    }

    const card=
        button.closest(
            '.book-card'
        );

    const cover=
        card?.querySelector(
            '.book-front'
        )||
        button;

    const sourceRect=
        cover.getBoundingClientRect();

    const cartRect=
        fab.getBoundingClientRect();

    /*
     * Kalau source sedang offscreen,
     * cukup animasikan button/cart.
     */
    if(
        sourceRect.width<=0||
        sourceRect.height<=0
    ){
        animeFlash(button);

        gsap.fromTo(
            fab,
            {
                scale:.85
            },
            {
                scale:1,
                duration:.4,
                ease:'back.out(2.3)'
            }
        );

        return;
    }

    const coverStyle=
        window.getComputedStyle(
            cover
        );

    const ghost=
        document.createElement(
            'div'
        );

    ghost.className=
        'bd-cart-fly-book';

    Object.assign(
        ghost.style,
        {
            position:'fixed',

            left:
                `${sourceRect.left}px`,

            top:
                `${sourceRect.top}px`,

            width:
                `${sourceRect.width}px`,

            height:
                `${sourceRect.height}px`,

            zIndex:'99998',

            pointerEvents:'none',

            overflow:'hidden',

            borderRadius:
                '3px 7px 7px 3px',

            backgroundImage:
                coverStyle
                    .backgroundImage,

            backgroundColor:
                coverStyle
                    .backgroundColor||
                '#EF5843',

            backgroundSize:'cover',

            backgroundPosition:
                'center',

            backgroundRepeat:
                'no-repeat',

            boxShadow:
                '0 20px 45px rgba(36,27,82,.30)',

            transformOrigin:
                'center center',

            willChange:
                'transform,opacity'
        }
    );

    const format=
        button.dataset.format||
        '';

    const isEbook=
        /e-?book/i.test(
            format
        );

    if(
        !coverStyle.backgroundImage||
        coverStyle.backgroundImage===
            'none'
    ){
        ghost.style.background=
            isEbook
                ?'linear-gradient(135deg,#4338CA,#6366F1)'
                :'linear-gradient(135deg,#EF5843,#F7AA35)';
    }

    /*
     * Badge format pada buku yang terbang.
     */
    const badge=
        document.createElement(
            'span'
        );

    badge.textContent=
        isEbook
            ?'E-BOOK'
            :'CETAK';

    Object.assign(
        badge.style,
        {
            position:'absolute',

            left:'8px',

            bottom:'8px',

            padding:'4px 7px',

            borderRadius:'999px',

            background:
                'rgba(255,255,255,.94)',

            color:
                isEbook
                    ?'#4338CA'
                    :'#C2410C',

            fontFamily:
                'Inter,sans-serif',

            fontSize:'7px',

            lineHeight:'1',

            fontWeight:'800',

            letterSpacing:'.05em',

            boxShadow:
                '0 4px 10px rgba(15,23,42,.10)'
        }
    );

    ghost.appendChild(
        badge
    );

    /*
     * Spine visual supaya clone tetap
     * terasa seperti buku.
     */
    const spine=
        document.createElement(
            'span'
        );

    Object.assign(
        spine.style,
        {
            position:'absolute',
            left:'0',
            top:'0',
            bottom:'0',
            width:'6px',

            background:
                'linear-gradient(180deg,rgba(0,0,0,.22),rgba(255,255,255,.08),rgba(0,0,0,.20))',

            opacity:'.6'
        }
    );

    ghost.appendChild(
        spine
    );

    document.body.appendChild(
        ghost
    );

    /*
     * Target = center cart FAB.
     */
    const sourceCenterX=
        sourceRect.left+
        sourceRect.width/2;

    const sourceCenterY=
        sourceRect.top+
        sourceRect.height/2;

    const targetCenterX=
        cartRect.left+
        cartRect.width/2;

    const targetCenterY=
        cartRect.top+
        cartRect.height/2;

    const targetX=
        targetCenterX-
        sourceCenterX;

    const targetY=
        targetCenterY-
        sourceCenterY;

    /*
     * Arc.
     * Buku tidak bergerak lurus secara kaku.
     */
    const middleX=
        targetX*.5;

    const middleY=
        targetY*.46-
        Math.min(
            90,
            Math.abs(targetY)*.1+45
        );

    /*
     * Button reaction.
     */
    gsap.timeline()
        .to(
            button,
            {
                scale:.93,
                duration:.1,
                ease:'power2.out',
                overwrite:true
            }
        )
        .to(
            button,
            {
                scale:1.045,
                duration:.17,
                ease:'back.out(2)',
                overwrite:true
            }
        )
        .to(
            button,
            {
                scale:1,
                duration:.2,
                ease:'power3.out',
                overwrite:true
            }
        );

    /*
     * Sedikit reaction pada cover asli.
     * Hanya scale wrapper tilt, tidak
     * mengubah transform book-front.
     */
    const originalTilt=
        card?.querySelector(
            '.book-tilt'
        );

    if(originalTilt){
        gsap.fromTo(
            originalTilt,
            {
                scale:1
            },
            {
                scale:1.035,
                duration:.16,
                repeat:1,
                yoyo:true,
                ease:'power2.out',
                overwrite:true
            }
        );
    }

    const flyTl=
        gsap.timeline({
            onComplete:()=>{
                ghost.remove();

                /*
                 * Cart mendapat impact
                 * ketika buku sampai.
                 */
                gsap.timeline()
                    .fromTo(
                        fab,
                        {
                            scale:.78,
                            rotation:-9
                        },
                        {
                            scale:1.09,
                            rotation:4,
                            duration:.22,
                            ease:'back.out(2.4)'
                        }
                    )
                    .to(
                        fab,
                        {
                            scale:1,
                            rotation:0,
                            duration:.25,
                            ease:'power3.out',
                            clearProps:'transform'
                        }
                    );

                if(count){
                    gsap.fromTo(
                        count,
                        {
                            scale:.35,
                            rotation:-18
                        },
                        {
                            scale:1,
                            rotation:0,
                            duration:.5,
                            ease:'back.out(3)',
                            clearProps:'transform'
                        }
                    );
                }
            }
        });

    /*
     * STAGE 1
     * Cover keluar dari tempatnya.
     */
    flyTl.fromTo(
        ghost,
        {
            scale:1,
            rotation:-3,
            opacity:1
        },
        {
            scale:1.075,
            rotation:2,
            y:-14,
            duration:.16,
            ease:'power3.out'
        }
    );

    /*
     * STAGE 2
     * Arc menuju setengah perjalanan.
     */
    flyTl.to(
        ghost,
        {
            x:middleX,
            y:middleY,
            scale:.68,
            rotation:
                targetX>=0
                    ?9
                    :-9,

            duration:.3,
            ease:'power2.out'
        }
    );

    /*
     * STAGE 3
     * Masuk ke cart.
     */
    flyTl.to(
        ghost,
        {
            x:targetX,
            y:targetY,
            scale:.1,
            rotation:
                targetX>=0
                    ?20
                    :-20,

            opacity:.18,

            duration:.38,

            ease:'power4.in'
        }
    );

    flyTl.to(
        ghost,
        {
            boxShadow:
                '0 1px 2px rgba(36,27,82,0)',

            duration:.25
        },
        '<'
    );
};

/* =====================================================
   STORE CART
===================================================== */
const initStoreCart=root=>{
    let cart=
        loadCart();

    const fab=
        root.querySelector(
            '#cartFab'
        );

    const countEl=
        root.querySelector(
            '#cartCount'
        );

    const drawer=
        root.querySelector(
            '#cartDrawer'
        );

    const overlay=
        root.querySelector(
            '#cartOverlay'
        );

    const close=
        root.querySelector(
            '#cartClose'
        );

    const items=
        root.querySelector(
            '#cartItems'
        );

    const totalEl=
        root.querySelector(
            '#cartTotal'
        );

    const itemCount=
        root.querySelector(
            '#cartItemCount'
        );

    const headerCount=
        root.querySelector(
            '#cartHeaderCount'
        );

    const checkout=
        root.querySelector(
            '#checkoutBtn'
        );

    const clear=
        root.querySelector(
            '#clearCartBtn'
        );

    const toast=
        root.querySelector(
            '#cartToast'
        );

    let toastTimer=null;

    const getCount=()=>{
        return cart.reduce(
            (sum,item)=>
                sum+
                Number(item.qty),
            0
        );
    };

    const getTotal=()=>{
        return cart.reduce(
            (sum,item)=>
                sum+
                Number(item.price)*
                Number(item.qty),
            0
        );
    };

    const showToast=(
        message,
        warning=false
    )=>{
        if(!toast)return;

        toast.textContent=
            message;

        toast.classList.toggle(
            'warning',
            warning
        );

        toast.classList.add(
            'show'
        );

        clearTimeout(
            toastTimer
        );

        toastTimer=setTimeout(
            ()=>{
                toast.classList.remove(
                    'show',
                    'warning'
                );
            },
            1800
        );
    };

    const openCart=()=>{
        drawer?.classList.add(
            'open'
        );

        overlay?.classList.add(
            'show'
        );

        document.body.style.overflow=
            'hidden';

        window.bdLenis?.stop();

        if(
            drawer&&
            !reduceMotion
        ){
            gsap.fromTo(
                drawer,
                {
                    x:20
                },
                {
                    x:0,
                    duration:.35,
                    ease:'power3.out',
                    clearProps:'x'
                }
            );
        }
    };

    const closeCart=()=>{
        drawer?.classList.remove(
            'open'
        );

        overlay?.classList.remove(
            'show'
        );

        document.body.style.overflow=
            '';

        window.bdLenis?.start();
    };

    const render=()=>{
        const count=
            getCount();

        const total=
            getTotal();

        if(countEl){
            countEl.textContent=
                count;

            countEl.classList.toggle(
                'hide',
                count===0
            );
        }

        if(headerCount){
            headerCount.textContent=
                count
                    ?`${count} produk di keranjang`
                    :'Belum ada produk';
        }

        if(itemCount){
            itemCount.textContent=
                `${count} item`;
        }

        if(totalEl){
            totalEl.textContent=
                rupiah(total);
        }

        if(checkout){
            checkout.disabled=
                count===0;
        }

        if(clear){
            clear.classList.toggle(
                'show',
                count>0
            );
        }

        if(!items)return;

        if(!cart.length){
            items.innerHTML=`
                <div class="cart-empty">

                    <div class="cart-empty-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M3 5h2l2 9h10l2-7H6"></path>
                            <circle cx="9" cy="19" r="1"></circle>
                            <circle cx="17" cy="19" r="1"></circle>
                        </svg>

                    </div>

                    <strong>
                        Keranjang masih kosong
                    </strong>

                    <span>
                        Pilih Buku Cetak atau E-book dari katalog.
                    </span>

                </div>
            `;

            return;
        }

        items.innerHTML=
            cart.map(item=>{
                const subtotal=
                    Number(item.price)*
                    Number(item.qty);

                const formatClass=
                    /e-?book/i.test(item.format)
                        ?'ebook'
                        :'print';

                const publisher=
                    item.publisher
                        ?` • ${escapeHtml(item.publisher)}`
                        :'';

                const cover=
                    item.cover
                        ?`
                            <img
                                src="${escapeHtml(item.cover)}"
                                alt="${escapeHtml(item.title)}"
                            >
                        `
                        :`
                            <div class="cart-cover-placeholder">

                                <svg viewBox="0 0 24 24">
                                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"></path>
                                </svg>

                            </div>
                        `;

                return`
                    <article class="cart-product">

                        <div class="cart-product-cover">
                            ${cover}
                        </div>

                        <div class="cart-product-info">

                            <div class="cart-product-top">

                                <span class="cart-format ${formatClass}">
                                    ${escapeHtml(item.format)}
                                </span>

                                <button
                                    type="button"
                                    class="cart-remove"
                                    data-cart-action="remove"
                                    data-key="${escapeHtml(item.key)}"
                                >
                                    ✕
                                </button>

                            </div>

                            <h4 class="cart-product-title">
                                ${escapeHtml(item.title)}
                            </h4>

                            <p class="cart-product-meta">
                                ${escapeHtml(item.author)}
                                ${publisher}
                            </p>

                            <div class="cart-unit-price">
                                ${rupiah(item.price)} / item
                            </div>

                            <div class="cart-product-bottom">

                                <div class="qty-control">

                                    <button
                                        type="button"
                                        data-cart-action="minus"
                                        data-key="${escapeHtml(item.key)}"
                                    >
                                        −
                                    </button>

                                    <span>
                                        ${item.qty}
                                    </span>

                                    <button
                                        type="button"
                                        data-cart-action="plus"
                                        data-key="${escapeHtml(item.key)}"
                                    >
                                        +
                                    </button>

                                </div>

                                <div>

                                    <div class="cart-subtotal-label">
                                        Subtotal
                                    </div>

                                    <div class="cart-subtotal">
                                        ${rupiah(subtotal)}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </article>
                `;
            }).join('');
    };

    const persist=()=>{
        saveCart(cart);
        render();
    };

    /* =================================================
       + CETAK / + EBOOK
    ================================================= */
    root.addEventListener(
        'click',
        e=>{
            const unavailable=
                e.target.closest(
                    '[data-unavailable-message]'
                );

            if(unavailable){
                e.preventDefault();
                e.stopPropagation();

                showToast(
                    unavailable.dataset.unavailableMessage||
                    'Format buku tidak tersedia.',
                    true
                );

                animeFlash(
                    unavailable
                );

                return;
            }

            const button=
                e.target.closest(
                    '[data-cart-add="1"]'
                );

            if(!button)return;

            e.preventDefault();
            e.stopPropagation();

            const product={
                key:
                    button.dataset.key,

                bookId:
                    button.dataset.bookId,

                title:
                    button.dataset.title??
                    '',

                format:
                    button.dataset.format??
                    'Buku',

                author:
                    button.dataset.author??
                    '',

                publisher:
                    button.dataset.publisher??
                    '',

                cover:
                    button.dataset.cover??
                    '',

                price:
                    Number(
                        button.dataset.price??
                        0
                    ),

                qty:1
            };

            if(
                !product.key||
                !product.title||
                product.price<=0
            ){
                showToast(
                    'Harga produk belum tersedia.',
                    true
                );

                return;
            }

            const existing=
                cart.find(
                    item=>
                        item.key===
                        product.key
                );

            if(existing){
                existing.qty++;
            }else{
                cart.push(
                    product
                );
            }

            persist();

            showToast(
                `${product.format} ditambahkan ke keranjang`
            );

            /*
             * Cover terbang ke cart.
             */
            animateAddToCart(
                button,
                root
            );

            const original=
                button.textContent;

            button.textContent=
                '✓ Ditambah';

            setTimeout(
                ()=>{
                    button.textContent=
                        original;
                },
                720
            );
        }
    );

    /* =================================================
       CART ITEM +/- REMOVE
    ================================================= */
    items?.addEventListener(
        'click',
        e=>{
            const button=
                e.target.closest(
                    '[data-cart-action]'
                );

            if(!button)return;

            e.preventDefault();
            e.stopPropagation();

            const item=
                cart.find(
                    row=>
                        row.key===
                        button.dataset.key
                );

            const action=
                button.dataset.cartAction;

            if(
                action==='plus'&&
                item
            ){
                item.qty++;
            }

            if(
                action==='minus'&&
                item
            ){
                item.qty--;
            }

            if(
                action==='remove'||
                (
                    item&&
                    item.qty<=0
                )
            ){
                cart=
                    cart.filter(
                        row=>
                            row.key!==
                            button.dataset.key
                    );
            }

            animeFlash(
                button
            );

            persist();
        }
    );

    /* =================================================
       CLEAR CART
    ================================================= */
    clear?.addEventListener(
        'click',
        ()=>{
            if(!cart.length)return;

            if(
                !confirm(
                    'Kosongkan seluruh isi keranjang?'
                )
            ){
                return;
            }

            cart=[];

            persist();
        }
    );

    /* =================================================
       WHATSAPP CHECKOUT
    ================================================= */
    checkout?.addEventListener(
        'click',
        ()=>{
            if(!cart.length)return;

            const lines=
                cart.map(
                    (item,index)=>{
                        const subtotal=
                            Number(item.price)*
                            Number(item.qty);

                        return`${index+1}. ${item.title}
Format: ${item.format}
Penulis: ${item.author}
Penerbit: ${item.publisher||'-'}
Harga: ${rupiah(item.price)}
Jumlah: ${item.qty}
Subtotal: ${rupiah(subtotal)}`;
                    }
                ).join('\n\n');

            const message=
`Halo Baca Dulu, saya ingin melakukan pemesanan:

${lines}

TOTAL: ${rupiah(getTotal())}

Mohon konfirmasi stok, ongkir/file E-book, serta metode pembayaran. Terima kasih.`;

            window.open(
                `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(message)}`,
                '_blank',
                'noopener,noreferrer'
            );
        }
    );

    fab?.addEventListener(
        'click',
        openCart
    );

    close?.addEventListener(
        'click',
        closeCart
    );

    overlay?.addEventListener(
        'click',
        closeCart
    );

    const handleEscape=e=>{
        if(e.key==='Escape'){
            closeCart();
        }
    };

    document.addEventListener(
        'keydown',
        handleEscape
    );

    root.__bdCartCleanup=()=>{
        document.removeEventListener(
            'keydown',
            handleEscape
        );

        clearTimeout(
            toastTimer
        );

        document.body.style.overflow=
            '';

        window.bdLenis?.start();
    };

    render();
};

/* =====================================================
   BOOK DETAIL INTRO
===================================================== */
const initDetailIntro=root=>{
    if(reduceMotion)return;

    const back=
        root.querySelector(
            '.detail-back'
        );

    const stage=
        root.querySelector(
            '.cover-3d-wrapper,'+
            '.detail-cover-panel'
        );

    const motion=
        root.querySelector(
            '.detail-book-motion'
        );

    const spec=
        root.querySelector(
            '.bibliography-card,'+
            '.detail-spec-card'
        );

    const badge=
        root.querySelector(
            '.detail-badge'
        );

    const title=
        root.querySelector(
            '.detail-title'
        );

    const author=
        root.querySelector(
            '.detail-author'
        );

    const info=
        root.querySelectorAll(
            '.detail-info-box'
        );

    const tl=
        gsap.timeline({
            defaults:{
                ease:'power4.out'
            }
        });

    if(back){
        tl.from(
            back,
            {
                autoAlpha:0,
                x:-15,
                duration:.5
            }
        );
    }

    if(stage){
        tl.from(
            stage,
            {
                autoAlpha:0,
                y:26,
                duration:.72
            },
            '-=.28'
        );
    }

    if(motion){
        tl.from(
            motion,
            {
                autoAlpha:0,
                y:35,
                scale:.9,
                rotationY:-8,
                duration:.85,
                ease:'back.out(1.25)'
            },
            '-=.55'
        );
    }

    if(spec){
        tl.from(
            spec,
            {
                autoAlpha:0,
                x:-22,
                duration:.62
            },
            '-=.52'
        );
    }

    if(badge){
        tl.from(
            badge,
            {
                autoAlpha:0,
                y:12,
                duration:.45
            },
            '-=.48'
        );
    }

    if(title){
        tl.from(
            title,
            {
                autoAlpha:0,
                y:30,
                duration:.76
            },
            '-=.3'
        );
    }

    if(author){
        tl.from(
            author,
            {
                autoAlpha:0,
                y:14,
                duration:.55
            },
            '-=.48'
        );
    }

    if(info.length){
        tl.from(
            info,
            {
                autoAlpha:0,
                y:20,
                scale:.96,
                duration:.58,
                stagger:.07
            },
            '-=.35'
        );
    }

    tl.call(
        ()=>{
            drawSvg(root);
        },
        null,
        .45
    );
};

/* =====================================================
   BOOK DETAIL 3D
===================================================== */
const initDetailBook=root=>{
    if(reduceMotion)return;

    const stage=
        root.querySelector(
            '.cover-3d-wrapper,'+
            '.detail-cover-panel'
        );

    const motion=
        root.querySelector(
            '.detail-book-motion'
        );

    if(!stage||!motion)return;

    gsap.set(
        motion,
        {
            transformPerspective:1100,
            transformStyle:'preserve-3d'
        }
    );

    const rotateX=
        gsap.quickTo(
            motion,
            'rotationX',
            {
                duration:.5,
                ease:'power3.out'
            }
        );

    const rotateY=
        gsap.quickTo(
            motion,
            'rotationY',
            {
                duration:.5,
                ease:'power3.out'
            }
        );

    const moveX=
        gsap.quickTo(
            motion,
            'x',
            {
                duration:.5,
                ease:'power3.out'
            }
        );

    const moveY=
        gsap.quickTo(
            motion,
            'y',
            {
                duration:.5,
                ease:'power3.out'
            }
        );

    const scale=
        gsap.quickTo(
            motion,
            'scale',
            {
                duration:.5,
                ease:'power3.out'
            }
        );

    stage.addEventListener(
        'pointerenter',
        ()=>{
            if(
                window.innerWidth<768
            ){
                return;
            }

            scale(1.018);
        }
    );

    stage.addEventListener(
        'pointermove',
        e=>{
            if(
                window.innerWidth<768
            ){
                return;
            }

            const rect=
                stage.getBoundingClientRect();

            const px=
                (e.clientX-rect.left)/
                rect.width-.5;

            const py=
                (e.clientY-rect.top)/
                rect.height-.5;

            rotateY(px*7);
            rotateX(-py*4.5);

            moveX(px*4);
            moveY(py*2-2);
        }
    );

    stage.addEventListener(
        'pointerleave',
        ()=>{
            rotateX(0);
            rotateY(0);

            moveX(0);
            moveY(0);

            scale(1);
        }
    );
};

/* =====================================================
   BOOK DETAIL CONTENT
===================================================== */
const initDetailContent=root=>{
    if(reduceMotion)return;

    const format=
        root.querySelector(
            '.format-grid,'+
            '.format-area'
        );

    if(format){
        const cards=
            format.querySelectorAll(
                '.detail-format-card'
            );

        if(cards.length){
            gsap.from(
                cards,
                {
                    autoAlpha:0,
                    y:28,
                    scale:.97,
                    duration:.68,
                    stagger:.08,
                    ease:'power4.out',

                    scrollTrigger:{
                        trigger:format,
                        start:'top 90%',
                        once:true
                    }
                }
            );
        }
    }

    const description=
        root.querySelector(
            '.description-section,'+
            '[data-detail-scroll]'
        );

    if(description){
        gsap.from(
            description,
            {
                autoAlpha:0,
                y:24,
                duration:.68,
                ease:'power4.out',

                scrollTrigger:{
                    trigger:description,
                    start:'top 91%',
                    once:true
                }
            }
        );
    }

    root.querySelectorAll(
        '.detail-format-card'
    ).forEach(card=>{
        card.addEventListener(
            'pointerenter',
            ()=>{
                if(
                    window.innerWidth<768
                ){
                    return;
                }

                gsap.to(
                    card,
                    {
                        y:-5,

                        boxShadow:
                            '0 16px 30px rgba(36,27,82,.08)',

                        duration:.28,

                        ease:
                            'power3.out',

                        overwrite:true
                    }
                );
            }
        );

        card.addEventListener(
            'pointerleave',
            ()=>{
                gsap.to(
                    card,
                    {
                        y:0,

                        boxShadow:
                            '0 0 0 rgba(36,27,82,0)',

                        duration:.38,

                        ease:
                            'power3.out',

                        overwrite:true
                    }
                );
            }
        );
    });
};

/* =====================================================
   BOOK DETAIL CART
===================================================== */
const initDetailCart=root=>{
    const feedback=
        root.querySelector(
            '#cartFeedback'
        );

    const feedbackText=
        root.querySelector(
            '#cartFeedbackText'
        );

    root.addEventListener(
        'click',
        e=>{
            const button=
                e.target.closest(
                    '.detail-add-cart'
                );

            if(!button)return;

            e.preventDefault();
            e.stopPropagation();

            const product={
                key:
                    button.dataset.key,

                bookId:
                    button.dataset.bookId,

                title:
                    button.dataset.title??
                    '',

                format:
                    button.dataset.format??
                    'Buku',

                author:
                    button.dataset.author??
                    '',

                publisher:
                    button.dataset.publisher??
                    '',

                cover:
                    button.dataset.cover??
                    '',

                price:
                    Number(
                        button.dataset.price??
                        0
                    ),

                qty:1
            };

            if(
                !product.key||
                !product.title||
                product.price<=0
            ){
                return;
            }

            const cart=
                loadCart();

            const existing=
                cart.find(
                    item=>
                        item.key===
                        product.key
                );

            if(existing){
                existing.qty++;
            }else{
                cart.push(
                    product
                );
            }

            saveCart(cart);

            if(feedback){
                feedback.classList.add(
                    'show'
                );

                if(!reduceMotion){
                    gsap.fromTo(
                        feedback,
                        {
                            autoAlpha:0,
                            y:10
                        },
                        {
                            autoAlpha:1,
                            y:0,
                            duration:.35,
                            ease:'power3.out'
                        }
                    );
                }
            }

            if(feedbackText){
                feedbackText.textContent=
                    `${product.format} berhasil ditambahkan ke keranjang.`;
            }

            animeFlash(
                button
            );

            const text=
                button.querySelector(
                    'span'
                );

            const original=
                text?.textContent??
                'Tambah ke Keranjang';

            if(text){
                text.textContent=
                    '✓ Ditambahkan';
            }

            button.disabled=true;

            setTimeout(
                ()=>{
                    if(text){
                        text.textContent=
                            original;
                    }

                    button.disabled=false;
                },
                850
            );
        }
    );
};

/* =====================================================
   STORE INIT
===================================================== */
const initStore=root=>{
    if(
        !root||
        root.dataset.storeMotionReady==='1'
    ){
        return;
    }

    root.dataset.storeMotionReady='1';

    initBookControllers(root);

    initStoreHero(root);
    initStoreSections(root);

    initLatestSlider(root);

    initButtons(root);
    initStoreCart(root);

    /*
     * Motion + Anime baru preload
     * ketika browser lebih santai.
     */
    const preload=()=>{
        loadMotion();
        loadAnime();
    };

    if(
        'requestIdleCallback' in window
    ){
        window.requestIdleCallback(
            preload,
            {
                timeout:1400
            }
        );
    }else{
        setTimeout(
            preload,
            900
        );
    }
};

/* =====================================================
   DETAIL INIT
===================================================== */
const initDetail=root=>{
    if(
        !root||
        root.dataset.detailMotionReady==='1'
    ){
        return;
    }

    root.dataset.detailMotionReady='1';

    initDetailIntro(root);
    initDetailBook(root);
    initDetailContent(root);

    initButtons(root);
    initDetailCart(root);
};

/* =====================================================
   PAGE CLEANUP
===================================================== */
const cleanupPageMotion=container=>{
    if(!container)return;

    const root=
        container.querySelector(
            '.bookstore-page,'+
            '.book-detail-page'
        );

    if(!root)return;

    /*
     * Pause idle book.
     */
    pauseBooks(root);

    /*
     * Destroy ghost cart animation
     * kalau user pindah halaman di tengah animasi.
     */
    document.querySelectorAll(
        '.bd-cart-fly-book'
    ).forEach(ghost=>{
        gsap.killTweensOf(ghost);
        ghost.remove();
    });

    /*
     * Three cleanup.
     */
    root.querySelectorAll(
        '[data-store-ambient]'
    ).forEach(canvas=>{
        canvas.__bdThreeCleanup?.();
    });

    /*
     * Cart global listeners.
     */
    root.__bdCartCleanup?.();

    /*
     * ScrollTriggers halaman ini.
     */
    ScrollTrigger.getAll().forEach(
        trigger=>{
            const el=
                trigger.trigger;

            if(
                el instanceof Element&&
                root.contains(el)
            ){
                trigger.kill();
            }
        }
    );

    /*
     * GSAP tweens halaman ini.
     */
    gsap.killTweensOf([
        root,
        ...root.querySelectorAll('*')
    ]);
};

/* =====================================================
   PAGE INITIALIZER
===================================================== */
const initPageMotion=(
    scope=document
)=>{
    const store=
        scope.querySelector?.(
            '.bookstore-page'
        );

    const detail=
        scope.querySelector?.(
            '.book-detail-page'
        );

    if(store){
        initStore(store);
    }

    if(detail){
        initDetail(detail);
    }

    requestAnimationFrame(
        ()=>{
            ScrollTrigger.refresh();
        }
    );
};

/* =====================================================
   STORE URL CHECK
===================================================== */
const isStoreUrl=href=>{
    if(!href)return false;

    try{
        const url=
            new URL(
                String(href),
                window.location.origin
            );

        if(
            url.origin!==
            window.location.origin
        ){
            return false;
        }

        return(
            url.pathname===
                STORE_PATH||

            url.pathname.startsWith(
                STORE_PATH+'/'
            )
        );

    }catch{
        return false;
    }
};

/* =====================================================
   CURRENT BARBA NAMESPACE
===================================================== */
const getCurrentNamespace=()=>{
    return(
        document.querySelector(
            '[data-barba="container"]'
        )
        ?.dataset
        ?.barbaNamespace||
        ''
    );
};

/* =====================================================
   ROUTE WIPE
===================================================== */
const getRouteWipe=()=>{
    return document.getElementById(
        'bdRouteWipe'
    );
};

/* =====================================================
   SCROLL AFTER BARBA
===================================================== */
const restoreStoreScroll=data=>{
    const href=
        data?.next?.url?.href||
        window.location.href;

    let hash='';

    try{
        hash=
            new URL(
                href,
                window.location.origin
            ).hash;
    }catch{}

    requestAnimationFrame(
        ()=>{
            if(hash){
                /*
                 * Cari dari page baru dulu.
                 */
                const target=
                    data?.next
                        ?.container
                        ?.querySelector?.(
                            hash
                        )||
                    document.querySelector(
                        hash
                    );

                if(target){
                    if(window.bdLenis){
                        window.bdLenis.scrollTo(
                            target,
                            {
                                offset:-80,
                                immediate:true
                            }
                        );
                    }else{
                        target.scrollIntoView();
                    }

                    return;
                }
            }

            if(window.bdLenis){
                window.bdLenis.scrollTo(
                    0,
                    {
                        immediate:true
                    }
                );
            }else{
                window.scrollTo(
                    0,
                    0
                );
            }
        }
    );
};

/* =====================================================
   BARBA
===================================================== */
const initBarba=async()=>{
    const namespace=
        getCurrentNamespace();

    /*
     * Barba hanya dipasang
     * jika pertama kali kita berada
     * di Bookstore / Detail.
     */
    if(
        namespace!=='bookstore'&&
        namespace!=='book-detail'
    ){
        return;
    }

    if(
        window.__bdBarbaReady
    ){
        return;
    }

    const barba=
        await loadBarba();

    if(!barba)return;

    const wipe=
        getRouteWipe();

    if(!wipe){
        console.warn(
            '[BacaDulu] #bdRouteWipe tidak ditemukan.'
        );

        return;
    }

    const panel=
        wipe.querySelector(
            '.bd-route-wipe-panel'
        );

    if(!panel){
        console.warn(
            '[BacaDulu] .bd-route-wipe-panel tidak ditemukan.'
        );

        return;
    }

    window.__bdBarbaReady=true;
    window.bdBarba=barba;

    if(
        'scrollRestoration' in history
    ){
        history.scrollRestoration=
            'manual';
    }

    barba.init({
        timeout:8000,
        sync:false,

        /* =============================================
           LINK FILTER

           false = Barba ambil
           true  = browser normal
        ============================================= */
        prevent:({
            el,
            href
        })=>{
            if(!el)return true;

            const raw=
                el.getAttribute?.(
                    'href'
                )||
                '';

            /*
             * Button seperti +Cetak/+Ebook
             * tidak punya href.
             */
            if(!raw){
                return true;
            }

            if(
                raw.startsWith('#')||
                raw.startsWith(
                    'mailto:'
                )||
                raw.startsWith(
                    'tel:'
                )||
                raw.startsWith(
                    'javascript:'
                )||
                el.target==='_blank'||
                el.hasAttribute?.(
                    'download'
                )
            ){
                return true;
            }

            const targetHref=
                href||
                el.href||
                raw;

            /*
             * Hanya Bookstore/Detail
             * yang ditangani Barba.
             */
            return !isStoreUrl(
                targetHref
            );
        },

        transitions:[
            {
                name:
                    'bacadulu-store-transition',

                /* =====================================
                   BEFORE LEAVE
                ===================================== */
                beforeLeave(data){
                    window.bdLenis?.stop();

                    cleanupPageMotion(
                        data.current.container
                    );

                    gsap.set(
                        wipe,
                        {
                            autoAlpha:1
                        }
                    );

                    gsap.set(
                        panel,
                        {
                            scaleX:0,
                            transformOrigin:
                                'left center'
                        }
                    );
                },

                /* =====================================
                   LEAVE
                ===================================== */
                leave(data){
                    if(reduceMotion){
                        return Promise.resolve();
                    }

                    const tl=
                        gsap.timeline();

                    tl.to(
                        data.current.container,
                        {
                            x:-14,
                            duration:.2,
                            ease:'power2.in'
                        }
                    );

                    tl.to(
                        panel,
                        {
                            scaleX:1,
                            duration:.42,
                            ease:'power4.inOut'
                        },
                        '-=.13'
                    );

                    return tl;
                },

                /* =====================================
                   BEFORE ENTER
                ===================================== */
                beforeEnter(data){
                    gsap.set(
                        data.next.container,
                        {
                            x:
                                reduceMotion
                                    ?0
                                    :18,

                            visibility:
                                'visible'
                        }
                    );

                    restoreStoreScroll(
                        data
                    );
                },

                /* =====================================
                   ENTER
                ===================================== */
                enter(data){
                    if(reduceMotion){
                        gsap.set(
                            panel,
                            {
                                scaleX:0
                            }
                        );

                        gsap.set(
                            data.next.container,
                            {
                                x:0
                            }
                        );

                        return Promise.resolve();
                    }

                    gsap.set(
                        panel,
                        {
                            transformOrigin:
                                'right center'
                        }
                    );

                    const tl=
                        gsap.timeline();

                    tl.to(
                        panel,
                        {
                            scaleX:0,
                            duration:.46,
                            ease:'power4.inOut'
                        }
                    );

                    tl.to(
                        data.next.container,
                        {
                            x:0,
                            duration:.56,
                            ease:'power4.out',
                            clearProps:'x'
                        },
                        '-=.31'
                    );

                    return tl;
                },

                /* =====================================
                   AFTER ENTER
                ===================================== */
                afterEnter(data){
                    const nextTitle=
                        data.next
                            .container
                            .dataset
                            .pageTitle;

                    if(nextTitle){
                        document.title=
                            nextTitle;
                    }

                    gsap.set(
                        wipe,
                        {
                            autoAlpha:0
                        }
                    );

                    initPageMotion(
                        data.next.container
                    );

                    requestAnimationFrame(
                        ()=>{
                            ScrollTrigger.refresh();

                            window.bdLenis?.start();
                        }
                    );
                },

                /* =====================================
                   RESET
                ===================================== */
                after(){
                    gsap.set(
                        panel,
                        {
                            scaleX:0,
                            clearProps:
                                'transformOrigin'
                        }
                    );

                    gsap.set(
                        wipe,
                        {
                            autoAlpha:0
                        }
                    );

                    document.body.style
                        .overflow='';

                    window.bdLenis?.start();
                }
            }
        ]
    });
};

/* =====================================================
   BOOT
===================================================== */
const boot=()=>{
    /*
     * Halaman pertama langsung aktif.
     */
    initPageMotion(
        document
    );

    /*
     * Barba belakangan agar tidak
     * membebani first paint.
     */
    const startBarba=()=>{
        initBarba();
    };

    if(
        'requestIdleCallback' in window
    ){
        window.requestIdleCallback(
            startBarba,
            {
                timeout:1200
            }
        );
    }else{
        setTimeout(
            startBarba,
            500
        );
    }

    window.addEventListener(
        'load',
        ()=>{
            ScrollTrigger.refresh();
        },
        {
            once:true
        }
    );
};

if(
    document.readyState===
    'loading'
){
    document.addEventListener(
        'DOMContentLoaded',
        boot,
        {
            once:true
        }
    );
}else{
    boot();
}