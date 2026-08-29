import './bootstrap';
import './bookstore-motion';

import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

gsap.registerPlugin(ScrollTrigger);

window.bdGsap = gsap;

const reduceMotion =
    window.matchMedia(
        '(prefers-reduced-motion:reduce)'
    ).matches;

const html =
    document.documentElement;

const qs = (
    selector,
    scope = document
) => scope.querySelector(selector);

const qsa = (
    selector,
    scope = document
) => [
    ...scope.querySelectorAll(selector)
];

function getDevice(){
    if(window.BacaDevice){
        return window.BacaDevice;
    }

    const touch =
        window.matchMedia(
            '(pointer:coarse)'
        ).matches
        ||
        window.matchMedia(
            '(hover:none)'
        ).matches
        ||
        navigator.maxTouchPoints > 0;

    const fine =
        window.matchMedia(
            '(hover:hover) and (pointer:fine)'
        ).matches;

    const width =
        window.innerWidth;

    const type =
        width <= 767
            ? 'phone'
            : (
                width <= 1023
                    ? 'tablet'
                    : 'desktop'
            );

    return {
        type,
        phone:
            type === 'phone',
        tablet:
            type === 'tablet',
        desktop:
            type === 'desktop',
        touch,
        finePointer:
            fine && !touch
    };
}

function syncDeviceClasses(){
    const device =
        getDevice();

    const desktopMotion =
        device.desktop
        &&
        device.finePointer
        &&
        !device.touch
        &&
        !reduceMotion;

    html.classList.toggle(
        'bd-touch-device',
        device.touch
    );

    html.classList.toggle(
        'bd-fine-device',
        device.finePointer
    );

    html.classList.toggle(
        'bd-phone-layout',
        device.phone
    );

    html.classList.toggle(
        'bd-tablet-layout',
        device.tablet
    );

    html.classList.toggle(
        'bd-desktop-motion',
        desktopMotion
    );

    window.bdDevice = {
        ...device,
        desktopMotion
    };

    return window.bdDevice;
}

function clearTransforms(elements){
    elements
        .filter(Boolean)
        .forEach(el=>{
            gsap.killTweensOf(el);

            gsap.set(
                el,
                {
                    clearProps:
                        'transform,x,y,scale,rotation,rotationX,rotationY,opacity,filter'
                }
            );
        });
}

syncDeviceClasses();

window.addEventListener(
    'baca:devicechange',
    syncDeviceClasses
);

/* MONEY */
window.bdAnimateMoney = (
    element,
    value,
    prefix = 'Rp '
) => {
    if(!element){
        return;
    }

    element
        ._bdMoneyTween
        ?.kill();

    let current =
        Number(
            element.dataset.value
        );

    if(!Number.isFinite(current)){
        current =
            Number(
                String(
                    element.textContent
                    ||
                    ''
                ).replace(
                    /[^\d]/g,
                    ''
                )
            )
            ||
            0;
    }

    const state = {
        value:
            current
    };

    element._bdMoneyTween =
        gsap.to(
            state,
            {
                value:
                    Number(
                        value || 0
                    ),

                duration:.5,
                ease:'power2.out',

                onUpdate:()=>{
                    element.textContent =
                        prefix
                        +
                        Math.round(
                            state.value
                        ).toLocaleString(
                            'id-ID'
                        );
                },

                onComplete:()=>{
                    element.dataset.value =
                        Number(
                            value || 0
                        );

                    element._bdMoneyTween =
                        null;
                }
            }
        );
};

document.addEventListener(
    'DOMContentLoaded',
    ()=>{
        if(window.__bdMotionReady){
            return;
        }

        window.__bdMotionReady =
            true;

        const device =
            syncDeviceClasses();

        const home =
            qs('.bd-home');

        let lenis =
            null;

        /* LENIS */
        if(device.desktopMotion){
            lenis =
                new Lenis({
                    autoRaf:false,
                    duration:.95,
                    smoothWheel:true,
                    wheelMultiplier:.9
                });

            window.bdLenis =
                lenis;

            lenis.on(
                'scroll',
                ScrollTrigger.update
            );

            gsap.ticker.add(
                time=>{
                    lenis?.raf(
                        time * 1000
                    );
                }
            );

            gsap.ticker.lagSmoothing(0);
        }
        else{
            window.bdLenis =
                null;

            html.classList.add(
                'bd-native-scroll'
            );
        }

        /* ANCHOR */
        qsa('a[href^="#"]')
            .forEach(link=>{
                link.addEventListener(
                    'click',
                    event=>{
                        const href =
                            link.getAttribute(
                                'href'
                            );

                        if(
                            !href||
                            href === '#'
                        ){
                            return;
                        }

                        let target =
                            null;

                        try{
                            target =
                                document.querySelector(
                                    href
                                );
                        }
                        catch{
                            return;
                        }

                        if(!target){
                            return;
                        }

                        event.preventDefault();

                        if(lenis){
                            lenis.scrollTo(
                                target,
                                {
                                    offset:-80,
                                    duration:1
                                }
                            );

                            return;
                        }

                        const top =
                            target
                                .getBoundingClientRect()
                                .top
                            +
                            window.scrollY
                            -
                            80;

                        window.scrollTo({
                            top,
                            behavior:
                                reduceMotion
                                    ? 'auto'
                                    : 'smooth'
                        });
                    }
                );
            });

        if(!home){
            if(!device.touch){
                requestAnimationFrame(
                    ()=>{
                        ScrollTrigger.refresh();
                    }
                );
            }

            return;
        }

        if(reduceMotion){
            qsa(
                '[data-bd-reveal]'
            ).forEach(el=>{
                gsap.set(
                    el,
                    {
                        opacity:1,
                        x:0,
                        y:0,
                        scale:1,
                        filter:'none'
                    }
                );
            });
        }
        else{
            initGlobalReveal(device);
            initHero(device);
            initAlur(device);
            initLegacyCatalog(device);
            initDesktopParallax(device);
            initCtaReveal(device);
            initAffiliate(device);
            initDesktopEffects(device);
        }

        let resizeTimer =
            null;

        window.addEventListener(
            'resize',
            ()=>{
                clearTimeout(
                    resizeTimer
                );

                resizeTimer =
                    setTimeout(
                        ()=>{
                            syncDeviceClasses();

                            if(
                                !getDevice()
                                    .touch
                            ){
                                ScrollTrigger.refresh();
                            }
                        },
                        180
                    );
            },
            {
                passive:true
            }
        );

        window.addEventListener(
            'load',
            ()=>{
                if(
                    !getDevice()
                        .touch
                ){
                    ScrollTrigger.refresh();
                }
            },
            {
                once:true
            }
        );

        if(!device.touch){
            ScrollTrigger.refresh();
        }

        /* ========================================================
           GLOBAL REVEAL
        ======================================================== */
        function initGlobalReveal(
            currentDevice
        ){
            const elements =
                qsa(
                    '[data-bd-reveal]'
                ).filter(
                    el=>
                        !el.closest(
                            '#home'
                        )
                );

            if(currentDevice.touch){
                const observer =
                    new IntersectionObserver(
                        entries=>{
                            entries.forEach(
                                entry=>{
                                    if(
                                        !entry
                                            .isIntersecting
                                    ){
                                        return;
                                    }

                                    const el =
                                        entry.target;

                                    observer.unobserve(
                                        el
                                    );

                                    gsap.fromTo(
                                        el,
                                        {
                                            opacity:0,
                                            y:18
                                        },
                                        {
                                            opacity:1,
                                            y:0,
                                            duration:.5,
                                            ease:'power2.out',
                                            clearProps:
                                                'transform'
                                        }
                                    );
                                }
                            );
                        },
                        {
                            threshold:.08,
                            rootMargin:
                                '0px 0px -5% 0px'
                        }
                    );

                elements.forEach(
                    el=>{
                        observer.observe(el);
                    }
                );

                return;
            }

            elements.forEach(
                el=>{
                    const type =
                        el.dataset.bdReveal
                        ||
                        'up';

                    const delay =
                        Number(
                            el.dataset
                                .bdDelay
                            ||
                            0
                        )
                        /
                        1000;

                    const from = {
                        opacity:0,
                        x:0,
                        y:0,
                        scale:1,
                        filter:'blur(4px)'
                    };

                    if(type === 'up'){
                        from.y = 42;
                    }

                    if(type === 'left'){
                        from.x = -48;
                    }

                    if(type === 'right'){
                        from.x = 48;
                    }

                    if(type === 'zoom'){
                        from.scale = .94;
                        from.y = 18;
                    }

                    gsap.fromTo(
                        el,
                        from,
                        {
                            opacity:1,
                            x:0,
                            y:0,
                            scale:1,
                            filter:
                                'blur(0px)',

                            duration:.8,
                            delay,
                            ease:'power3.out',

                            scrollTrigger:{
                                trigger:el,
                                start:
                                    'top 90%',
                                once:true
                            }
                        }
                    );
                }
            );
        }

        /* ========================================================
           HERO
        ======================================================== */
        function initHero(
            currentDevice
        ){
            const hero =
                document.getElementById(
                    'home'
                );

            if(!hero){
                return;
            }

            const badge =
                qs(
                    '.bd-hero-badge',
                    hero
                );

            const lines =
                qsa(
                    '.bd-hero-line > span',
                    hero
                );

            const desc =
                qs(
                    '.bd-hero-desc',
                    hero
                );

            const button =
                qs(
                    '.bd-wa-btn',
                    hero
                );

            const visual =
                qs(
                    '.bd-hero-visual',
                    hero
                );

            const cards =
                qsa(
                    '.bd-floating-card',
                    hero
                );

            const orbits =
                qsa(
                    '.bd-hero-orbit',
                    hero
                );

            const dots =
                qs(
                    '.bd-hero-dots',
                    hero
                );

            const background =
                qs(
                    '.bd-hero-bg',
                    hero
                );

            const grid =
                qs(
                    '.bd-hero-grid',
                    hero
                );

            const glow =
                qs(
                    '.bd-hero-glow',
                    hero
                );

            if(currentDevice.touch){
                clearTransforms([
                    visual,
                    ...cards,
                    ...orbits,
                    dots
                ]);

                gsap.set(
                    [
                        badge,
                        ...lines,
                        desc,
                        button,
                        visual,
                        ...cards,
                        ...orbits,
                        dots
                    ].filter(Boolean),
                    {
                        opacity:1,
                        visibility:
                            'visible'
                    }
                );

                const timeline =
                    gsap.timeline({
                        defaults:{
                            ease:
                                'power3.out'
                        }
                    });

                if(badge){
                    timeline.fromTo(
                        badge,
                        {
                            opacity:0,
                            y:12
                        },
                        {
                            opacity:1,
                            y:0,
                            duration:.38
                        }
                    );
                }

                if(lines.length){
                    timeline.fromTo(
                        lines,
                        {
                            opacity:0,
                            y:20
                        },
                        {
                            opacity:1,
                            y:0,
                            duration:.5,
                            stagger:.07
                        },
                        '-=.2'
                    );
                }

                if(desc){
                    timeline.fromTo(
                        desc,
                        {
                            opacity:0,
                            y:14
                        },
                        {
                            opacity:1,
                            y:0,
                            duration:.4
                        },
                        '-=.25'
                    );
                }

                if(button){
                    timeline.fromTo(
                        button,
                        {
                            opacity:0,
                            y:12
                        },
                        {
                            opacity:1,
                            y:0,
                            duration:.4
                        },
                        '-=.2'
                    );
                }

                if(visual){
                    timeline.fromTo(
                        visual,
                        {
                            opacity:0,
                            y:18,
                            scale:.97
                        },
                        {
                            opacity:1,
                            y:0,
                            scale:1,
                            duration:.55,
                            clearProps:
                                'transform'
                        },
                        '-=.25'
                    );
                }

                return;
            }

            if(lines.length){
                gsap.set(
                    lines,
                    {
                        yPercent:110,
                        opacity:0
                    }
                );
            }

            if(badge){
                gsap.set(
                    badge,
                    {
                        opacity:0,
                        y:20
                    }
                );
            }

            if(desc){
                gsap.set(
                    desc,
                    {
                        opacity:0,
                        y:22
                    }
                );
            }

            if(button){
                gsap.set(
                    button,
                    {
                        opacity:0,
                        y:20
                    }
                );
            }

            if(visual){
                gsap.set(
                    visual,
                    {
                        opacity:0,
                        x:55,
                        scale:.92
                    }
                );
            }

            if(cards.length){
                gsap.set(
                    cards,
                    {
                        opacity:0
                    }
                );
            }

            if(orbits.length){
                gsap.set(
                    orbits,
                    {
                        opacity:0
                    }
                );
            }

            if(dots){
                gsap.set(
                    dots,
                    {
                        opacity:0
                    }
                );
            }

            const timeline =
                gsap.timeline({
                    defaults:{
                        ease:
                            'power4.out'
                    }
                });

            if(badge){
                timeline.to(
                    badge,
                    {
                        opacity:1,
                        y:0,
                        duration:.6
                    }
                );
            }

            if(lines.length){
                timeline.to(
                    lines,
                    {
                        opacity:1,
                        yPercent:0,
                        duration:.9,
                        stagger:.12
                    },
                    '-=.3'
                );
            }

            if(desc){
                timeline.to(
                    desc,
                    {
                        opacity:1,
                        y:0,
                        duration:.7
                    },
                    '-=.5'
                );
            }

            if(button){
                timeline.to(
                    button,
                    {
                        opacity:1,
                        y:0,
                        duration:.6
                    },
                    '-=.45'
                );
            }

            if(visual){
                timeline.to(
                    visual,
                    {
                        opacity:1,
                        x:0,
                        scale:1,
                        duration:1
                    },
                    '-=.75'
                );
            }

            if(orbits.length){
                timeline.to(
                    orbits,
                    {
                        opacity:1,
                        duration:.5,
                        stagger:.1
                    },
                    '-=.55'
                );
            }

            if(cards.length){
                timeline.to(
                    cards,
                    {
                        opacity:1,
                        duration:.45,
                        stagger:.1
                    },
                    '-=.45'
                );
            }

            if(dots){
                timeline.to(
                    dots,
                    {
                        opacity:1,
                        duration:.4
                    },
                    '-=.2'
                );
            }

            if(background){
                gsap.to(
                    background,
                    {
                        yPercent:9,
                        scale:1.05,
                        ease:'none',

                        scrollTrigger:{
                            trigger:hero,
                            start:
                                'top top',
                            end:
                                'bottom top',
                            scrub:1.2
                        }
                    }
                );
            }

            if(grid){
                gsap.to(
                    grid,
                    {
                        y:55,
                        ease:'none',

                        scrollTrigger:{
                            trigger:hero,
                            start:
                                'top top',
                            end:
                                'bottom top',
                            scrub:1.3
                        }
                    }
                );
            }

            if(glow){
                gsap.to(
                    glow,
                    {
                        x:-35,
                        y:65,
                        scale:1.1,
                        ease:'none',

                        scrollTrigger:{
                            trigger:hero,
                            start:
                                'top top',
                            end:
                                'bottom top',
                            scrub:1.4
                        }
                    }
                );
            }

            if(visual){
                hero.addEventListener(
                    'pointermove',
                    event=>{
                        const rect =
                            hero
                                .getBoundingClientRect();

                        const x =
                            (
                                event.clientX
                                -
                                rect.left
                            )
                            /
                            rect.width
                            -
                            .5;

                        const y =
                            (
                                event.clientY
                                -
                                rect.top
                            )
                            /
                            rect.height
                            -
                            .5;

                        gsap.to(
                            visual,
                            {
                                rotationY:
                                    x * 4,

                                rotationX:
                                    -y * 3,

                                duration:.8,
                                ease:
                                    'power3.out',

                                overwrite:true
                            }
                        );
                    }
                );

                hero.addEventListener(
                    'pointerleave',
                    ()=>{
                        gsap.to(
                            visual,
                            {
                                rotationY:0,
                                rotationX:0,
                                duration:.8,
                                ease:
                                    'power3.out',

                                overwrite:true
                            }
                        );
                    }
                );
            }
        }

        /* ========================================================
           ALUR
        ======================================================== */
        function initAlur(
            currentDevice
        ){
            const section =
                document.getElementById(
                    'alur'
                );

            if(!section){
                return;
            }

            const stage =
                qs(
                    '.bd-process-stage',
                    section
                );

            const items = [
                ...section
                    .querySelectorAll(
                        '[data-process-item],.bd-process-item'
                    )
            ];

            const nodes =
                qsa(
                    '[data-process-node]',
                    section
                );

            const progress =
                qs(
                    '.bd-process-progress',
                    section
                );

            if(!items.length){
                return;
            }

            let currentStep =
                -1;

            const progressValues =
                items.map(
                    (_,index)=>{
                        if(
                            items.length<=1
                        ){
                            return 1;
                        }

                        return (
                            index
                            /
                            (
                                items.length
                                -
                                1
                            )
                        );
                    }
                );

            const applyStep = (
                index,
                animate=true
            )=>{
                if(
                    index===currentStep
                    &&
                    index!==-1
                ){
                    return;
                }

                currentStep=index;

                items.forEach(
                    (item,i)=>{
                        item.classList.remove(
                            'is-active',
                            'is-complete'
                        );

                        if(index<0){
                            return;
                        }

                        if(i<index){
                            item.classList.add(
                                'is-complete'
                            );
                        }

                        if(i===index){
                            item.classList.add(
                                'is-active'
                            );
                        }
                    }
                );

                nodes.forEach(
                    (node,i)=>{
                        node.classList.remove(
                            'is-active',
                            'is-complete'
                        );

                        if(index<0){
                            return;
                        }

                        if(i<index){
                            node.classList.add(
                                'is-complete'
                            );
                        }

                        if(i===index){
                            node.classList.add(
                                'is-active'
                            );
                        }
                    }
                );

                if(progress){
                    const target =
                        index<0
                            ? 0
                            : progressValues[
                                index
                            ];

                    if(animate){
                        gsap.to(
                            progress,
                            {
                                scaleX:target,
                                duration:.3,
                                ease:
                                    'power2.out',

                                overwrite:true
                            }
                        );
                    }
                    else{
                        gsap.set(
                            progress,
                            {
                                scaleX:
                                    target
                            }
                        );
                    }
                }
            };

            if(progress){
                gsap.set(
                    progress,
                    {
                        scaleX:0,
                        transformOrigin:
                            'left center'
                    }
                );
            }

            if(
                currentDevice
                    .desktopMotion
                &&
                stage
            ){
                let autoIndex=-1;
                let autoCall=null;
                let autoStart=null;
                let pointerInside=false;
                let completed=false;

                const thresholds=[
                    .08,
                    .31,
                    .54,
                    .77
                ];

                const stopAuto=()=>{
                    autoCall?.kill();
                    autoStart?.kill();

                    autoCall=null;
                    autoStart=null;
                };

                const runAuto=()=>{
                    if(
                        pointerInside||
                        !completed
                    ){
                        return;
                    }

                    autoIndex=
                        (
                            autoIndex+1
                        )%
                        items.length;

                    applyStep(
                        autoIndex,
                        true
                    );

                    autoCall=
                        gsap.delayedCall(
                            1.75,
                            runAuto
                        );
                };

                const scheduleAuto=()=>{
                    stopAuto();

                    if(
                        pointerInside||
                        !completed
                    ){
                        return;
                    }

                    autoStart=
                        gsap.delayedCall(
                            1,
                            ()=>{
                                autoIndex=-1;
                                runAuto();
                            }
                        );
                };

                const getStep=value=>{
                    let result=-1;

                    thresholds.forEach(
                        (
                            threshold,
                            index
                        )=>{
                            if(
                                value>=
                                threshold
                            ){
                                result=index;
                            }
                        }
                    );

                    return result;
                };

                applyStep(
                    -1,
                    false
                );

                ScrollTrigger.create({
                    trigger:stage,
                    start:'top 18%',
                    end:'+=1100',
                    pin:true,
                    anticipatePin:1,
                    invalidateOnRefresh:true,

                    onUpdate:self=>{
                        if(
                            self.progress<.97
                        ){
                            if(completed){
                                stopAuto();
                            }

                            completed=false;

                            applyStep(
                                getStep(
                                    self.progress
                                )
                            );
                        }

                        if(
                            self.progress>=.97
                            &&
                            !completed
                        ){
                            completed=true;

                            applyStep(
                                items.length-1
                            );

                            scheduleAuto();
                        }
                    },

                    onLeave:
                        stopAuto,

                    onEnterBack:()=>{
                        stopAuto();
                        completed=false;
                    },

                    onLeaveBack:()=>{
                        stopAuto();
                        completed=false;
                        applyStep(-1);
                    }
                });

                stage.addEventListener(
                    'pointerenter',
                    ()=>{
                        pointerInside=true;
                        stopAuto();
                    }
                );

                stage.addEventListener(
                    'pointerleave',
                    ()=>{
                        pointerInside=false;

                        if(completed){
                            scheduleAuto();
                        }
                    }
                );

                items.forEach(
                    (item,index)=>{
                        item.addEventListener(
                            'click',
                            ()=>{
                                if(completed){
                                    stopAuto();

                                    applyStep(
                                        index
                                    );
                                }
                            }
                        );
                    }
                );

                return;
            }

            items.forEach(
                item=>{
                    gsap.set(
                        item,
                        {
                            opacity:1,
                            clearProps:
                                'transform'
                        }
                    );
                }
            );

            let visible=false;
            let ticking=false;

            const sync=()=>{
                ticking=false;

                if(!visible){
                    return;
                }

                const targetY=
                    window.innerHeight
                    *
                    .55;

                let nearestIndex=0;
                let nearestDistance=
                    Infinity;

                items.forEach(
                    (item,index)=>{
                        const rect=
                            item
                                .getBoundingClientRect();

                        const distance=
                            Math.abs(
                                rect.top
                                +
                                rect.height/2
                                -
                                targetY
                            );

                        if(
                            distance<
                            nearestDistance
                        ){
                            nearestDistance=
                                distance;

                            nearestIndex=
                                index;
                        }
                    }
                );

                applyStep(
                    nearestIndex
                );
            };

            const requestSync=()=>{
                if(ticking){
                    return;
                }

                ticking=true;

                requestAnimationFrame(
                    sync
                );
            };

            const observer=
                new IntersectionObserver(
                    entries=>{
                        visible=
                            entries.some(
                                entry=>
                                    entry
                                        .isIntersecting
                            );

                        if(visible){
                            requestSync();
                        }
                    },
                    {
                        rootMargin:
                            '20% 0px 20% 0px'
                    }
                );

            observer.observe(section);

            window.addEventListener(
                'scroll',
                requestSync,
                {
                    passive:true
                }
            );

            window.addEventListener(
                'resize',
                requestSync,
                {
                    passive:true
                }
            );

            requestSync();
        }

        /* ========================================================
           KATALOG LEGACY
        ======================================================== */
        function initLegacyCatalog(
            currentDevice
        ){
            const catalog=
                document.getElementById(
                    'katalog'
                );

            if(!catalog){
                return;
            }

            const slider=
                qs(
                    '.bd-book-slider',
                    catalog
                );

            if(!slider){
                return;
            }

            const slides=
                qsa(
                    '[data-bd-catalog-item]',
                    catalog
                );

            const prev=
                qs(
                    '[data-catalog-prev]',
                    catalog
                );

            const next=
                qs(
                    '[data-catalog-next]',
                    catalog
                );

            const getAmount=()=>{
                const first=
                    qs(
                        '.bd-book-slide',
                        slider
                    )
                    ||
                    slides[0];

                if(!first){
                    return slider.clientWidth;
                }

                const gap=
                    parseFloat(
                        getComputedStyle(
                            slider
                        ).gap
                    )
                    ||
                    16;

                return (
                    first
                        .getBoundingClientRect()
                        .width
                    +
                    gap
                );
            };

            const maxScroll=()=>
                Math.max(
                    0,
                    slider.scrollWidth
                    -
                    slider.clientWidth
                );

            const updateButtons=()=>{
                if(prev){
                    prev.disabled=
                        slider.scrollLeft<=3;

                    prev.classList.toggle(
                        'is-disabled',
                        prev.disabled
                    );
                }

                if(next){
                    next.disabled=
                        slider.scrollLeft
                        >=
                        maxScroll()-3;

                    next.classList.toggle(
                        'is-disabled',
                        next.disabled
                    );
                }
            };

            const move=direction=>{
                const target=
                    Math.max(
                        0,
                        Math.min(
                            slider.scrollLeft
                            +
                            getAmount()
                            *
                            direction,

                            maxScroll()
                        )
                    );

                slider.scrollTo({
                    left:target,
                    behavior:
                        reduceMotion
                            ? 'auto'
                            : 'smooth'
                });
            };

            if(currentDevice.touch){
                slider.style.touchAction=
                    'pan-x pan-y';

                clearTransforms(slides);

                slides.forEach(
                    slide=>{
                        slide.style.opacity='1';
                        slide.style.filter='none';
                    }
                );

                prev?.addEventListener(
                    'click',
                    event=>{
                        event.preventDefault();
                        event.stopPropagation();
                        move(-1);
                    }
                );

                next?.addEventListener(
                    'click',
                    event=>{
                        event.preventDefault();
                        event.stopPropagation();
                        move(1);
                    }
                );

                slider.addEventListener(
                    'scroll',
                    updateButtons,
                    {
                        passive:true
                    }
                );

                updateButtons();
                return;
            }

            if(slides.length){
                gsap.from(
                    slides,
                    {
                        opacity:0,
                        y:60,
                        scale:.92,
                        rotationY:-10,
                        stagger:.09,
                        duration:.9,
                        ease:
                            'power4.out',

                        scrollTrigger:{
                            trigger:
                                catalog,

                            start:
                                'top 82%',

                            once:true
                        }
                    }
                );
            }

            let moving=false;

            const moveDesktop=
                direction=>{
                    if(moving){
                        return;
                    }

                    const current=
                        slider.scrollLeft;

                    const target=
                        Math.max(
                            0,
                            Math.min(
                                current
                                +
                                getAmount()
                                *
                                direction,

                                maxScroll()
                            )
                        );

                    if(
                        Math.abs(
                            target-current
                        )
                        <
                        2
                    ){
                        updateButtons();
                        return;
                    }

                    moving=true;

                    const state={
                        value:current
                    };

                    gsap.to(
                        state,
                        {
                            value:target,
                            duration:.65,
                            ease:
                                'power4.inOut',

                            onUpdate:()=>{
                                slider.scrollLeft=
                                    state.value;
                            },

                            onComplete:()=>{
                                moving=false;
                                updateButtons();
                            }
                        }
                    );
                };

            prev?.addEventListener(
                'click',
                ()=>{
                    moveDesktop(-1);
                }
            );

            next?.addEventListener(
                'click',
                ()=>{
                    moveDesktop(1);
                }
            );

            slider.addEventListener(
                'scroll',
                updateButtons,
                {
                    passive:true
                }
            );

            updateButtons();
        }

        /* ========================================================
           DESKTOP PARALLAX
        ======================================================== */
        function initDesktopParallax(
            currentDevice
        ){
            if(
                !currentDevice
                    .desktopMotion
            ){
                return;
            }

            qsa(
                '.bd-info-card'
            ).forEach(
                card=>{
                    const image=
                        qs(
                            '.bd-info-image img',
                            card
                        );

                    if(!image){
                        return;
                    }

                    gsap.fromTo(
                        image,
                        {
                            yPercent:-4,
                            scale:1.06
                        },
                        {
                            yPercent:4,
                            scale:1.06,
                            ease:'none',

                            scrollTrigger:{
                                trigger:card,
                                start:
                                    'top bottom',

                                end:
                                    'bottom top',

                                scrub:1.2
                            }
                        }
                    );
                }
            );

            const testimonial=
                document.getElementById(
                    'testimoni'
                );

            if(testimonial){
                qsa(
                    '.bd-testi-glow',
                    testimonial
                ).forEach(
                    (
                        glow,
                        index
                    )=>{
                        gsap.to(
                            glow,
                            {
                                y:
                                    index===0
                                        ? 50
                                        : -50,

                                x:
                                    index===0
                                        ? 24
                                        : -24,

                                ease:'none',

                                scrollTrigger:{
                                    trigger:
                                        testimonial,

                                    start:
                                        'top bottom',

                                    end:
                                        'bottom top',

                                    scrub:1.4
                                }
                            }
                        );
                    }
                );
            }
        }

        /* ========================================================
           CTA REVEAL
        ======================================================== */
        function initCtaReveal(
            currentDevice
        ){
            const cta=
                qs(
                    '.bd-cta-section,.bd-publish-section'
                );

            if(!cta){
                return;
            }

            const card=
                qs(
                    '.bd-publish-card',
                    cta
                );

            const action=
                qs(
                    '.bd-publish-action',
                    cta
                );

            const background=
                qs(
                    '.bd-cta-background',
                    cta
                );

            if(currentDevice.touch){
                clearTransforms([
                    card,
                    action,
                    background
                ]);

                if(!card){
                    return;
                }

                const observer=
                    new IntersectionObserver(
                        entries=>{
                            entries.forEach(
                                entry=>{
                                    if(
                                        !entry
                                            .isIntersecting
                                    ){
                                        return;
                                    }

                                    observer.unobserve(
                                        entry.target
                                    );

                                    gsap.fromTo(
                                        card,
                                        {
                                            opacity:0,
                                            y:18
                                        },
                                        {
                                            opacity:1,
                                            y:0,
                                            duration:.5,
                                            ease:
                                                'power3.out',

                                            clearProps:
                                                'transform'
                                        }
                                    );
                                }
                            );
                        },
                        {
                            threshold:.08
                        }
                    );

                observer.observe(card);
                return;
            }

            if(card){
                gsap.from(
                    card,
                    {
                        opacity:0,
                        y:50,
                        scale:.96,
                        duration:.9,
                        ease:
                            'power4.out',

                        scrollTrigger:{
                            trigger:cta,
                            start:
                                'top 82%',

                            once:true
                        }
                    }
                );
            }

            if(action){
                gsap.from(
                    action,
                    {
                        opacity:0,
                        x:30,
                        duration:.7,
                        ease:
                            'power3.out',

                        scrollTrigger:{
                            trigger:cta,
                            start:
                                'top 78%',

                            once:true
                        }
                    }
                );
            }

            if(background){
                gsap.to(
                    background,
                    {
                        scale:1.1,
                        y:30,
                        ease:'none',

                        scrollTrigger:{
                            trigger:cta,
                            start:
                                'top bottom',

                            end:
                                'bottom top',

                            scrub:1.2
                        }
                    }
                );
            }
        }

        /* ========================================================
           AFFILIATE
        ======================================================== */
        function initAffiliate(
            currentDevice
        ){
            const affiliate=
                document.getElementById(
                    'afiliasi'
                );

            if(!affiliate){
                return;
            }

            const wrap=
                qs(
                    '.bd-affiliate-wrap',
                    affiliate
                );

            const track=
                qs(
                    '.bd-affiliate-track',
                    affiliate
                );

            if(
                !wrap||
                !track
            ){
                return;
            }

            let marquee=null;
            let resizeTimer=null;

            const createMarquee=()=>{
                marquee?.kill();

                gsap.killTweensOf(
                    track
                );

                gsap.set(
                    track,
                    {
                        x:0
                    }
                );

                const gap=
                    parseFloat(
                        getComputedStyle(
                            track
                        ).gap
                    )
                    ||
                    0;

                const distance=
                    track.scrollWidth
                    /
                    2
                    +
                    gap
                    /
                    2;

                if(distance<=0){
                    return;
                }

                marquee=
                    gsap.to(
                        track,
                        {
                            x:-distance,

                            duration:
                                currentDevice.touch
                                    ? 42
                                    : 34,

                            ease:'none',
                            repeat:-1
                        }
                    );
            };

            requestAnimationFrame(
                createMarquee
            );

            window.addEventListener(
                'load',
                createMarquee,
                {
                    once:true
                }
            );

            if(
                currentDevice
                    .desktopMotion
            ){
                wrap.addEventListener(
                    'mouseenter',
                    ()=>{
                        if(marquee){
                            gsap.to(
                                marquee,
                                {
                                    timeScale:0,
                                    duration:.3
                                }
                            );
                        }
                    }
                );

                wrap.addEventListener(
                    'mouseleave',
                    ()=>{
                        if(marquee){
                            gsap.to(
                                marquee,
                                {
                                    timeScale:1,
                                    duration:.4
                                }
                            );
                        }
                    }
                );
            }

            window.addEventListener(
                'resize',
                ()=>{
                    clearTimeout(
                        resizeTimer
                    );

                    resizeTimer=
                        setTimeout(
                            createMarquee,
                            250
                        );
                },
                {
                    passive:true
                }
            );
        }

        /* ========================================================
           DESKTOP EFFECTS
        ======================================================== */
        function initDesktopEffects(
            currentDevice
        ){
            if(
                !currentDevice
                    .desktopMotion
            ){
                return;
            }

            qsa(
                '[data-bd-tilt]'
            ).forEach(
                card=>{
                    gsap.set(
                        card,
                        {
                            transformPerspective:
                                1000,

                            transformStyle:
                                'preserve-3d'
                        }
                    );

                    const rx=
                        gsap.quickTo(
                            card,
                            'rotationX',
                            {
                                duration:.4,
                                ease:
                                    'power3.out'
                            }
                        );

                    const ry=
                        gsap.quickTo(
                            card,
                            'rotationY',
                            {
                                duration:.4,
                                ease:
                                    'power3.out'
                            }
                        );

                    card.addEventListener(
                        'pointermove',
                        event=>{
                            const rect=
                                card
                                    .getBoundingClientRect();

                            const x=
                                (
                                    event.clientX
                                    -
                                    rect.left
                                )
                                /
                                rect.width;

                            const y=
                                (
                                    event.clientY
                                    -
                                    rect.top
                                )
                                /
                                rect.height;

                            rx(
                                (.5-y)*4
                            );

                            ry(
                                (x-.5)*5.5
                            );
                        }
                    );

                    card.addEventListener(
                        'pointerleave',
                        ()=>{
                            rx(0);
                            ry(0);
                        }
                    );
                }
            );

            gsap.set(
                '.bd-depth-1',
                {
                    z:14
                }
            );

            gsap.set(
                '.bd-depth-2',
                {
                    z:26
                }
            );

            qsa(
                '.bd-section-glow'
            ).forEach(
                glow=>{
                    const section=
                        glow.closest(
                            'section'
                        );

                    if(!section){
                        return;
                    }

                    gsap.to(
                        glow,
                        {
                            y:75,
                            ease:'none',

                            scrollTrigger:{
                                trigger:
                                    section,

                                start:
                                    'top bottom',

                                end:
                                    'bottom top',

                                scrub:1.4
                            }
                        }
                    );
                }
            );

            qsa(
                '.bd-wa-btn,.bd-book-detail,.bd-info-read,.bd-publish-action > a'
            ).forEach(
                button=>{
                    button.addEventListener(
                        'pointermove',
                        event=>{
                            const rect=
                                button
                                    .getBoundingClientRect();

                            const x=
                                event.clientX
                                -
                                rect.left
                                -
                                rect.width/2;

                            const y=
                                event.clientY
                                -
                                rect.top
                                -
                                rect.height/2;

                            gsap.to(
                                button,
                                {
                                    x:x*.08,
                                    y:y*.1,
                                    duration:.3,
                                    ease:
                                        'power3.out'
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
                                    x:0,
                                    y:0,
                                    duration:.55,
                                    ease:
                                        'elastic.out(1,.45)'
                                }
                            );
                        }
                    );
                }
            );
        }
    }
);