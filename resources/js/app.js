import './bootstrap';
import './bookstore-motion';

import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

gsap.registerPlugin(ScrollTrigger);

window.bdGsap = gsap;

/* ================================================================
   DEVICE
================================================================ */
const reduceMotion = window.matchMedia('(prefers-reduced-motion:reduce)').matches;

const device = {
    touch:
        window.matchMedia('(pointer:coarse)').matches ||
        window.matchMedia('(hover:none)').matches ||
        navigator.maxTouchPoints > 0,

    fine:
        window.matchMedia('(hover:hover) and (pointer:fine)').matches,

    phone:
        window.matchMedia('(max-width:767px)').matches,

    tablet:
        window.matchMedia('(min-width:768px) and (max-width:1023px)').matches,

    desktop:
        window.matchMedia('(min-width:1024px)').matches
};

device.desktopMotion =
    device.desktop &&
    device.fine &&
    !device.touch &&
    !reduceMotion;

window.bdDevice = device;

const html = document.documentElement;

html.classList.toggle('bd-touch-device', device.touch);
html.classList.toggle('bd-fine-device', device.fine);
html.classList.toggle('bd-phone-layout', device.phone);
html.classList.toggle('bd-tablet-layout', device.tablet);
html.classList.toggle('bd-desktop-motion', device.desktopMotion);

/* ================================================================
   HELPERS
================================================================ */
const qs = (selector, scope = document) =>
    scope.querySelector(selector);

const qsa = (selector, scope = document) =>
    [...scope.querySelectorAll(selector)];

const safeKill = target => {
    if (!target) return;
    gsap.killTweensOf(target);
};

const clearTransforms = elements => {
    elements
        .filter(Boolean)
        .forEach(el => {
            safeKill(el);

            gsap.set(el, {
                clearProps:
                    'transform,x,y,scale,rotation,rotationX,rotationY,opacity,filter'
            });
        });
};

/* ================================================================
   BOOT
================================================================ */
document.addEventListener('DOMContentLoaded', () => {
    if (window.__bdMotionReady) return;

    window.__bdMotionReady = true;

    const home = qs('.bd-home');

    /* ============================================================
       LENIS

       HANYA LAPTOP / DESKTOP DENGAN MOUSE
    ============================================================ */
    let lenis = null;

    if (device.desktopMotion) {
        lenis = new Lenis({
            autoRaf: false,
            duration: .95,
            smoothWheel: true,
            wheelMultiplier: .9
        });

        window.bdLenis = lenis;

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add(time => {
            lenis?.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
    } else {
        window.bdLenis = null;
        html.classList.add('bd-native-scroll');
    }

    /* ============================================================
       ANCHOR
    ============================================================ */
    qsa('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const href =
                link.getAttribute('href');

            if (
                !href ||
                href === '#'
            ) {
                return;
            }

            let target = null;

            try {
                target =
                    document.querySelector(href);
            } catch {
                return;
            }

            if (!target) return;

            e.preventDefault();

            if (lenis) {
                lenis.scrollTo(target, {
                    offset: -80,
                    duration: 1
                });

                return;
            }

            const top =
                target.getBoundingClientRect().top +
                window.scrollY -
                80;

            window.scrollTo({
                top,
                behavior:
                    reduceMotion
                        ? 'auto'
                        : 'smooth'
            });
        });
    });

    /* ============================================================
       NON HOME
    ============================================================ */
    if (!home) {
        if (!device.touch) {
            requestAnimationFrame(() => {
                ScrollTrigger.refresh();
            });
        }

        return;
    }

    /* ============================================================
       REDUCED MOTION
    ============================================================ */
    if (reduceMotion) {
        qsa('[data-bd-reveal]').forEach(el => {
            gsap.set(el, {
                opacity: 1,
                x: 0,
                y: 0,
                scale: 1,
                filter: 'none'
            });
        });

        return;
    }

    /* ============================================================
       GLOBAL REVEAL
    ============================================================ */
    const revealElements =
        qsa('[data-bd-reveal]')
            .filter(el => !el.closest('#home'));

    if (device.touch) {
        const revealObserver =
            new IntersectionObserver(
                entries => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        const el = entry.target;

                        revealObserver.unobserve(el);

                        gsap.fromTo(
                            el,
                            {
                                opacity: 0,
                                y: 18
                            },
                            {
                                opacity: 1,
                                y: 0,
                                duration: .5,
                                ease: 'power2.out',
                                clearProps: 'transform'
                            }
                        );
                    });
                },
                {
                    threshold: .08,
                    rootMargin: '0px 0px -5% 0px'
                }
            );

        revealElements.forEach(el => {
            revealObserver.observe(el);
        });
    } else {
        revealElements.forEach(el => {
            const type =
                el.dataset.bdReveal || 'up';

            const delay =
                Number(
                    el.dataset.bdDelay || 0
                ) / 1000;

            const from = {
                opacity: 0,
                x: 0,
                y: 0,
                scale: 1,
                filter: 'blur(4px)'
            };

            if (type === 'up') {
                from.y = 42;
            }

            if (type === 'left') {
                from.x = -48;
            }

            if (type === 'right') {
                from.x = 48;
            }

            if (type === 'zoom') {
                from.scale = .94;
                from.y = 18;
            }

            gsap.fromTo(
                el,
                from,
                {
                    opacity: 1,
                    x: 0,
                    y: 0,
                    scale: 1,
                    filter: 'blur(0px)',
                    duration: .8,
                    delay,
                    ease: 'power3.out',

                    scrollTrigger: {
                        trigger: el,
                        start: 'top 90%',
                        once: true
                    }
                }
            );
        });
    }

    /* ============================================================
       HERO
    ============================================================ */
    const hero =
        document.getElementById('home');

    if (hero) {
        const badge =
            qs('.bd-hero-badge', hero);

        const lines =
            qsa('.bd-hero-line > span', hero);

        const desc =
            qs('.bd-hero-desc', hero);

        const button =
            qs('.bd-wa-btn', hero);

        const visual =
            qs('.bd-hero-visual', hero);

        const cards =
            qsa('.bd-floating-card', hero);

        const orbits =
            qsa('.bd-hero-orbit', hero);

        const dots =
            qs('.bd-hero-dots', hero);

        const background =
            qs('.bd-hero-bg', hero);

        const grid =
            qs('.bd-hero-grid', hero);

        const glow =
            qs('.bd-hero-glow', hero);

        /*
         * TOUCH
         * Motion sederhana.
         * Visual buku jangan sampai hidden.
         */
        if (device.touch) {
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
                    opacity: 1,
                    visibility: 'visible'
                }
            );

            const tl =
                gsap.timeline({
                    defaults: {
                        ease: 'power3.out'
                    }
                });

            if (badge) {
                tl.fromTo(
                    badge,
                    {
                        opacity: 0,
                        y: 12
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: .38
                    }
                );
            }

            if (lines.length) {
                tl.fromTo(
                    lines,
                    {
                        opacity: 0,
                        y: 20
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: .5,
                        stagger: .07
                    },
                    '-=.2'
                );
            }

            if (desc) {
                tl.fromTo(
                    desc,
                    {
                        opacity: 0,
                        y: 14
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: .4
                    },
                    '-=.25'
                );
            }

            if (button) {
                tl.fromTo(
                    button,
                    {
                        opacity: 0,
                        y: 12
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: .4
                    },
                    '-=.2'
                );
            }

            if (visual) {
                tl.fromTo(
                    visual,
                    {
                        opacity: 0,
                        y: 18,
                        scale: .97
                    },
                    {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: .55,
                        clearProps: 'transform'
                    },
                    '-=.25'
                );
            }
        } else {
            if (lines.length) {
                gsap.set(lines, {
                    yPercent: 110,
                    opacity: 0
                });
            }

            if (badge) {
                gsap.set(badge, {
                    opacity: 0,
                    y: 20
                });
            }

            if (desc) {
                gsap.set(desc, {
                    opacity: 0,
                    y: 22
                });
            }

            if (button) {
                gsap.set(button, {
                    opacity: 0,
                    y: 20
                });
            }

            if (visual) {
                gsap.set(visual, {
                    opacity: 0,
                    x: 55,
                    scale: .92
                });
            }

            if (cards.length) {
                gsap.set(cards, {
                    opacity: 0
                });
            }

            if (orbits.length) {
                gsap.set(orbits, {
                    opacity: 0
                });
            }

            if (dots) {
                gsap.set(dots, {
                    opacity: 0
                });
            }

            const tl =
                gsap.timeline({
                    defaults: {
                        ease: 'power4.out'
                    }
                });

            if (badge) {
                tl.to(badge, {
                    opacity: 1,
                    y: 0,
                    duration: .6
                });
            }

            if (lines.length) {
                tl.to(
                    lines,
                    {
                        opacity: 1,
                        yPercent: 0,
                        duration: .9,
                        stagger: .12
                    },
                    '-=.3'
                );
            }

            if (desc) {
                tl.to(
                    desc,
                    {
                        opacity: 1,
                        y: 0,
                        duration: .7
                    },
                    '-=.5'
                );
            }

            if (button) {
                tl.to(
                    button,
                    {
                        opacity: 1,
                        y: 0,
                        duration: .6
                    },
                    '-=.45'
                );
            }

            if (visual) {
                tl.to(
                    visual,
                    {
                        opacity: 1,
                        x: 0,
                        scale: 1,
                        duration: 1
                    },
                    '-=.75'
                );
            }

            if (orbits.length) {
                tl.to(
                    orbits,
                    {
                        opacity: 1,
                        duration: .5,
                        stagger: .1
                    },
                    '-=.55'
                );
            }

            if (cards.length) {
                tl.to(
                    cards,
                    {
                        opacity: 1,
                        duration: .45,
                        stagger: .1
                    },
                    '-=.45'
                );
            }

            if (dots) {
                tl.to(
                    dots,
                    {
                        opacity: 1,
                        duration: .4
                    },
                    '-=.2'
                );
            }

            if (background) {
                gsap.to(background, {
                    yPercent: 9,
                    scale: 1.05,
                    ease: 'none',

                    scrollTrigger: {
                        trigger: hero,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: 1.2
                    }
                });
            }

            if (grid) {
                gsap.to(grid, {
                    y: 55,
                    ease: 'none',

                    scrollTrigger: {
                        trigger: hero,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: 1.3
                    }
                });
            }

            if (glow) {
                gsap.to(glow, {
                    x: -35,
                    y: 65,
                    scale: 1.1,
                    ease: 'none',

                    scrollTrigger: {
                        trigger: hero,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: 1.4
                    }
                });
            }

            if (visual) {
                hero.addEventListener(
                    'pointermove',
                    e => {
                        const rect =
                            hero.getBoundingClientRect();

                        const x =
                            (e.clientX - rect.left) /
                            rect.width -
                            .5;

                        const y =
                            (e.clientY - rect.top) /
                            rect.height -
                            .5;

                        gsap.to(visual, {
                            rotationY: x * 4,
                            rotationX: -y * 3,
                            duration: .8,
                            ease: 'power3.out',
                            overwrite: true
                        });
                    }
                );

                hero.addEventListener(
                    'pointerleave',
                    () => {
                        gsap.to(visual, {
                            rotationY: 0,
                            rotationX: 0,
                            duration: .8,
                            ease: 'power3.out',
                            overwrite: true
                        });
                    }
                );
            }
        }
    }

    /* ============================================================
       ALUR PENERBITAN
    ============================================================ */
    const processSection =
        document.getElementById('alur');

    if (processSection) {
        const stage =
            qs('.bd-process-stage', processSection);

        const items = [
            ...processSection.querySelectorAll(
                '[data-process-item],.bd-process-item'
            )
        ];

        const nodes =
            qsa('[data-process-node]', processSection);

        const progress =
            qs('.bd-process-progress', processSection);

        let currentStep = -1;

        const progressValues =
            items.map((item, index) => {
                if (items.length <= 1) {
                    return 1;
                }

                return (
                    index /
                    (items.length - 1)
                );
            });

        const applyProcessStep = (
            index,
            animate = true
        ) => {
            if (
                index === currentStep &&
                index !== -1
            ) {
                return;
            }

            currentStep = index;

            items.forEach(
                (item, itemIndex) => {
                    item.classList.remove(
                        'is-active',
                        'is-complete'
                    );

                    if (index < 0) return;

                    if (itemIndex < index) {
                        item.classList.add(
                            'is-complete'
                        );
                    }

                    if (itemIndex === index) {
                        item.classList.add(
                            'is-active'
                        );
                    }
                }
            );

            nodes.forEach(
                (node, nodeIndex) => {
                    node.classList.remove(
                        'is-active',
                        'is-complete'
                    );

                    if (index < 0) return;

                    if (nodeIndex < index) {
                        node.classList.add(
                            'is-complete'
                        );
                    }

                    if (nodeIndex === index) {
                        node.classList.add(
                            'is-active'
                        );
                    }
                }
            );

            if (progress) {
                const target =
                    index < 0
                        ? 0
                        : progressValues[index];

                if (animate) {
                    gsap.to(progress, {
                        scaleX: target,
                        duration: .3,
                        ease: 'power2.out',
                        overwrite: true
                    });
                } else {
                    gsap.set(progress, {
                        scaleX: target
                    });
                }
            }

            if (
                animate &&
                index >= 0
            ) {
                const card =
                    qs(
                        '.bd-process-card',
                        items[index]
                    );

                if (card) {
                    gsap.fromTo(
                        card,
                        {
                            y: 6
                        },
                        {
                            y: 0,
                            duration: .35,
                            ease: 'power3.out',
                            clearProps: 'transform'
                        }
                    );
                }
            }
        };

        if (progress) {
            gsap.set(progress, {
                scaleX: 0,
                transformOrigin:
                    'left center'
            });
        }

        /* ========================================================
           DESKTOP ALUR
        ======================================================== */
        if (
            device.desktopMotion &&
            stage &&
            items.length
        ) {
            let autoIndex = -1;
            let autoCall = null;
            let autoStart = null;
            let pointerInside = false;
            let completed = false;

            const thresholds =
                [.08, .31, .54, .77];

            const stopAuto = () => {
                autoCall?.kill();
                autoStart?.kill();

                autoCall = null;
                autoStart = null;
            };

            const runAuto = () => {
                if (
                    pointerInside ||
                    !completed
                ) {
                    return;
                }

                autoIndex =
                    (autoIndex + 1) %
                    items.length;

                applyProcessStep(
                    autoIndex,
                    true
                );

                autoCall =
                    gsap.delayedCall(
                        1.75,
                        runAuto
                    );
            };

            const scheduleAuto = () => {
                stopAuto();

                if (
                    pointerInside ||
                    !completed
                ) {
                    return;
                }

                autoStart =
                    gsap.delayedCall(
                        1,
                        () => {
                            autoIndex = -1;
                            runAuto();
                        }
                    );
            };

            const getStep = value => {
                let result = -1;

                thresholds.forEach(
                    (threshold, index) => {
                        if (
                            value >= threshold
                        ) {
                            result = index;
                        }
                    }
                );

                return result;
            };

            applyProcessStep(
                -1,
                false
            );

            ScrollTrigger.create({
                trigger: stage,
                start: 'top 18%',
                end: '+=1100',
                pin: true,
                anticipatePin: 1,
                invalidateOnRefresh: true,

                onUpdate: self => {
                    if (
                        self.progress < .97
                    ) {
                        if (completed) {
                            stopAuto();
                        }

                        completed = false;

                        applyProcessStep(
                            getStep(self.progress)
                        );
                    }

                    if (
                        self.progress >= .97 &&
                        !completed
                    ) {
                        completed = true;

                        applyProcessStep(
                            items.length - 1
                        );

                        scheduleAuto();
                    }
                },

                onLeave: () => {
                    stopAuto();
                },

                onEnterBack: () => {
                    stopAuto();
                    completed = false;
                },

                onLeaveBack: () => {
                    stopAuto();

                    completed = false;

                    applyProcessStep(
                        -1
                    );
                }
            });

            stage.addEventListener(
                'pointerenter',
                () => {
                    pointerInside = true;
                    stopAuto();
                }
            );

            stage.addEventListener(
                'pointerleave',
                () => {
                    pointerInside = false;

                    if (completed) {
                        scheduleAuto();
                    }
                }
            );

            items.forEach(
                (item, index) => {
                    item.addEventListener(
                        'click',
                        () => {
                            if (!completed) {
                                return;
                            }

                            stopAuto();

                            applyProcessStep(
                                index
                            );
                        }
                    );
                }
            );
        } else {
            /* ====================================================
               TOUCH / HP / TABLET / DESKTOP SITE HP

               Native scroll tracking.
               Tidak pin.
               Tidak scrub berat.
            ==================================================== */
            items.forEach(item => {
                gsap.set(item, {
                    opacity: 1,
                    clearProps:
                        'transform'
                });
            });

            let processVisible = false;
            let ticking = false;

            const syncMobileProcess = () => {
                ticking = false;

                if (
                    !processVisible ||
                    !items.length
                ) {
                    return;
                }

                const targetY =
                    window.innerHeight * .55;

                let nearestIndex = 0;
                let nearestDistance =
                    Infinity;

                items.forEach(
                    (item, index) => {
                        const rect =
                            item.getBoundingClientRect();

                        const center =
                            rect.top +
                            rect.height / 2;

                        const distance =
                            Math.abs(
                                center -
                                targetY
                            );

                        if (
                            distance <
                            nearestDistance
                        ) {
                            nearestDistance =
                                distance;

                            nearestIndex =
                                index;
                        }
                    }
                );

                applyProcessStep(
                    nearestIndex
                );
            };

            const requestSync = () => {
                if (ticking) return;

                ticking = true;

                requestAnimationFrame(
                    syncMobileProcess
                );
            };

            const observer =
                new IntersectionObserver(
                    entries => {
                        processVisible =
                            entries.some(
                                entry =>
                                    entry.isIntersecting
                            );

                        if (
                            processVisible
                        ) {
                            requestSync();
                        }
                    },
                    {
                        rootMargin:
                            '20% 0px 20% 0px'
                    }
                );

            observer.observe(
                processSection
            );

            window.addEventListener(
                'scroll',
                requestSync,
                {
                    passive: true
                }
            );

            window.addEventListener(
                'resize',
                requestSync,
                {
                    passive: true
                }
            );

            requestSync();
        }
    }

    /* ============================================================
       KATALOG
    ============================================================ */
    const catalog =
        document.getElementById('katalog');

    if (catalog) {
        const slider =
            qs('.bd-book-slider', catalog);

        const slides = [
            ...catalog.querySelectorAll(
                '[data-bd-catalog-item]'
            )
        ];

        const prev =
            qs(
                '[data-catalog-prev]',
                catalog
            );

        const next =
            qs(
                '[data-catalog-next]',
                catalog
            );

        if (slider) {
            const getAmount = () => {
                const first =
                    qs('.bd-book-slide', slider) ||
                    slides[0];

                if (!first) {
                    return slider.clientWidth;
                }

                const gap =
                    parseFloat(
                        getComputedStyle(
                            slider
                        ).gap
                    ) || 16;

                return (
                    first
                        .getBoundingClientRect()
                        .width +
                    gap
                );
            };

            const maxScroll = () =>
                Math.max(
                    0,
                    slider.scrollWidth -
                    slider.clientWidth
                );

            const updateButtons = () => {
                if (prev) {
                    prev.disabled =
                        slider.scrollLeft <= 3;

                    prev.classList.toggle(
                        'is-disabled',
                        prev.disabled
                    );
                }

                if (next) {
                    next.disabled =
                        slider.scrollLeft >=
                        maxScroll() - 3;

                    next.classList.toggle(
                        'is-disabled',
                        next.disabled
                    );
                }
            };

            const mobileMove = direction => {
                const target =
                    Math.max(
                        0,
                        Math.min(
                            slider.scrollLeft +
                            getAmount() *
                            direction,

                            maxScroll()
                        )
                    );

                slider.scrollTo({
                    left: target,
                    behavior:
                        reduceMotion
                            ? 'auto'
                            : 'smooth'
                });
            };

            /* ====================================================
               TOUCH KATALOG
            ==================================================== */
            if (device.touch) {
                slider.style.touchAction =
                    'pan-x pan-y';

                clearTransforms(slides);

                slides.forEach(slide => {
                    slide.style.opacity = '1';
                    slide.style.filter = 'none';
                });

                prev?.addEventListener(
                    'click',
                    e => {
                        e.preventDefault();
                        e.stopPropagation();

                        mobileMove(-1);
                    }
                );

                next?.addEventListener(
                    'click',
                    e => {
                        e.preventDefault();
                        e.stopPropagation();

                        mobileMove(1);
                    }
                );

                let scrollTimer = null;

                slider.addEventListener(
                    'scroll',
                    () => {
                        clearTimeout(
                            scrollTimer
                        );

                        scrollTimer =
                            setTimeout(
                                updateButtons,
                                70
                            );
                    },
                    {
                        passive: true
                    }
                );

                updateButtons();
            } else {
                /* =================================================
                   DESKTOP KATALOG
                ================================================= */
                if (slides.length) {
                    gsap.from(
                        slides,
                        {
                            opacity: 0,
                            y: 60,
                            scale: .92,
                            rotationY: -10,
                            stagger: .09,
                            duration: .9,
                            ease: 'power4.out',

                            scrollTrigger: {
                                trigger: catalog,
                                start: 'top 82%',
                                once: true
                            }
                        }
                    );
                }

                slides.forEach(
                    (slide, index) => {
                        const card =
                            qs(
                                '.bd-home-book',
                                slide
                            );

                        const stage =
                            qs(
                                '.bd-book-stage',
                                slide
                            );

                        const shine =
                            qs(
                                '.bd-book-shine',
                                slide
                            );

                        if (
                            !card ||
                            !stage
                        ) {
                            return;
                        }

                        gsap.set(stage, {
                            transformPerspective:
                                900,

                            transformStyle:
                                'preserve-3d'
                        });

                        const rotateX =
                            gsap.quickTo(
                                stage,
                                'rotationX',
                                {
                                    duration: .5,
                                    ease:
                                        'power3.out'
                                }
                            );

                        const rotateY =
                            gsap.quickTo(
                                stage,
                                'rotationY',
                                {
                                    duration: .5,
                                    ease:
                                        'power3.out'
                                }
                            );

                        card.addEventListener(
                            'pointerenter',
                            () => {
                                gsap.to(
                                    stage,
                                    {
                                        scale:
                                            1.06,

                                        y: -6,

                                        duration:
                                            .4,

                                        ease:
                                            'power3.out'
                                    }
                                );

                                if (shine) {
                                    gsap.fromTo(
                                        shine,
                                        {
                                            xPercent:
                                                -180,

                                            opacity:
                                                0
                                        },
                                        {
                                            xPercent:
                                                260,

                                            opacity:
                                                .8,

                                            duration:
                                                .85,

                                            ease:
                                                'power2.out'
                                        }
                                    );
                                }
                            }
                        );

                        card.addEventListener(
                            'pointermove',
                            e => {
                                const rect =
                                    card
                                        .getBoundingClientRect();

                                const px =
                                    (
                                        e.clientX -
                                        rect.left
                                    ) /
                                    rect.width -
                                    .5;

                                const py =
                                    (
                                        e.clientY -
                                        rect.top
                                    ) /
                                    rect.height -
                                    .5;

                                rotateY(
                                    px * 18
                                );

                                rotateX(
                                    -py * 11
                                );
                            }
                        );

                        card.addEventListener(
                            'pointerleave',
                            () => {
                                rotateX(0);
                                rotateY(0);

                                gsap.to(
                                    stage,
                                    {
                                        scale: 1,
                                        y: 0,
                                        duration:
                                            .55,

                                        ease:
                                            'elastic.out(1,.45)'
                                    }
                                );
                            }
                        );

                        gsap.to(slide, {
                            y:
                                index % 2 === 0
                                    ? -9
                                    : 9,

                            ease: 'none',

                            scrollTrigger: {
                                trigger:
                                    catalog,

                                start:
                                    'top bottom',

                                end:
                                    'bottom top',

                                scrub: 1.4
                            }
                        });
                    }
                );

                let moving = false;

                const moveDesktop =
                    direction => {
                        if (moving) return;

                        const current =
                            slider.scrollLeft;

                        const target =
                            Math.max(
                                0,
                                Math.min(
                                    current +
                                    getAmount() *
                                    direction,

                                    maxScroll()
                                )
                            );

                        if (
                            Math.abs(
                                target -
                                current
                            ) < 2
                        ) {
                            updateButtons();
                            return;
                        }

                        moving = true;

                        const state = {
                            value:
                                current
                        };

                        gsap.to(
                            state,
                            {
                                value:
                                    target,

                                duration:
                                    .65,

                                ease:
                                    'power4.inOut',

                                onUpdate:
                                    () => {
                                        slider.scrollLeft =
                                            state.value;
                                    },

                                onComplete:
                                    () => {
                                        moving =
                                            false;

                                        updateButtons();
                                    }
                            }
                        );
                    };

                prev?.addEventListener(
                    'click',
                    () => {
                        moveDesktop(-1);
                    }
                );

                next?.addEventListener(
                    'click',
                    () => {
                        moveDesktop(1);
                    }
                );

                slider.addEventListener(
                    'scroll',
                    updateButtons,
                    {
                        passive: true
                    }
                );

                updateButtons();
            }
        }
    }

    /* ============================================================
       INFORMATION IMAGE PARALLAX

       DESKTOP ONLY
    ============================================================ */
    if (device.desktopMotion) {
        qsa('.bd-info-card').forEach(
            card => {
                const image =
                    qs(
                        '.bd-info-image img',
                        card
                    );

                if (!image) return;

                gsap.fromTo(
                    image,
                    {
                        yPercent: -4,
                        scale: 1.06
                    },
                    {
                        yPercent: 4,
                        scale: 1.06,
                        ease: 'none',

                        scrollTrigger: {
                            trigger: card,
                            start:
                                'top bottom',
                            end:
                                'bottom top',
                            scrub: 1.2
                        }
                    }
                );
            }
        );
    }

    /* ============================================================
       CTA HOME
    ============================================================ */
    const cta =
        qs(
            '.bd-cta-section,' +
            '.bd-publish-section'
        );

    if (cta) {
        const card =
            qs(
                '.bd-publish-card',
                cta
            );

        const action =
            qs(
                '.bd-publish-action',
                cta
            );

        const background =
            qs(
                '.bd-cta-background',
                cta
            );

        if (device.touch) {
            clearTransforms([
                card,
                action,
                background
            ]);

            if (card) {
                const observer =
                    new IntersectionObserver(
                        entries => {
                            entries.forEach(
                                entry => {
                                    if (
                                        !entry.isIntersecting
                                    ) {
                                        return;
                                    }

                                    observer.unobserve(
                                        entry.target
                                    );

                                    gsap.fromTo(
                                        card,
                                        {
                                            opacity:
                                                0,

                                            y: 18
                                        },
                                        {
                                            opacity:
                                                1,

                                            y: 0,

                                            duration:
                                                .5,

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
                            threshold: .08
                        }
                    );

                observer.observe(card);
            }
        } else {
            if (card) {
                gsap.from(card, {
                    opacity: 0,
                    y: 50,
                    scale: .96,
                    duration: .9,
                    ease: 'power4.out',

                    scrollTrigger: {
                        trigger: cta,
                        start: 'top 82%',
                        once: true
                    }
                });
            }

            if (action) {
                gsap.from(action, {
                    opacity: 0,
                    x: 30,
                    duration: .7,
                    ease: 'power3.out',

                    scrollTrigger: {
                        trigger: cta,
                        start: 'top 78%',
                        once: true
                    }
                });
            }

            if (background) {
                gsap.to(background, {
                    scale: 1.1,
                    y: 30,
                    ease: 'none',

                    scrollTrigger: {
                        trigger: cta,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 1.2
                    }
                });
            }
        }
    }

    /* ============================================================
       TESTIMONIAL GLOW
    ============================================================ */
    if (device.desktopMotion) {
        const testimonial =
            document.getElementById(
                'testimoni'
            );

        if (testimonial) {
            qsa(
                '.bdt-glow',
                testimonial
            ).forEach(
                (glow, index) => {
                    gsap.to(glow, {
                        y:
                            index === 0
                                ? 60
                                : -60,

                        x:
                            index === 0
                                ? 28
                                : -28,

                        ease: 'none',

                        scrollTrigger: {
                            trigger:
                                testimonial,

                            start:
                                'top bottom',

                            end:
                                'bottom top',

                            scrub: 1.4
                        }
                    });
                }
            );
        }
    }

    /* ============================================================
       AFFILIATE MARQUEE
    ============================================================ */
    const affiliate =
        document.getElementById(
            'afiliasi'
        );

    if (affiliate) {
        const wrap =
            qs(
                '.bd-affiliate-wrap',
                affiliate
            );

        const track =
            qs(
                '.bd-affiliate-track',
                affiliate
            );

        if (wrap && track) {
            let marquee = null;
            let resizeTimer = null;

            const createMarquee = () => {
                marquee?.kill();

                gsap.killTweensOf(track);

                gsap.set(track, {
                    x: 0
                });

                const gap =
                    parseFloat(
                        getComputedStyle(
                            track
                        ).gap
                    ) || 0;

                const distance =
                    track.scrollWidth / 2 +
                    gap / 2;

                if (distance <= 0) {
                    return;
                }

                marquee =
                    gsap.to(track, {
                        x:
                            -distance,

                        duration:
                            device.touch
                                ? 42
                                : 34,

                        ease: 'none',
                        repeat: -1
                    });
            };

            requestAnimationFrame(
                createMarquee
            );

            window.addEventListener(
                'load',
                createMarquee,
                {
                    once: true
                }
            );

            if (device.desktopMotion) {
                wrap.addEventListener(
                    'mouseenter',
                    () => {
                        if (!marquee) {
                            return;
                        }

                        gsap.to(
                            marquee,
                            {
                                timeScale:
                                    0,

                                duration:
                                    .3
                            }
                        );
                    }
                );

                wrap.addEventListener(
                    'mouseleave',
                    () => {
                        if (!marquee) {
                            return;
                        }

                        gsap.to(
                            marquee,
                            {
                                timeScale:
                                    1,

                                duration:
                                    .4
                            }
                        );
                    }
                );
            }

            window.addEventListener(
                'resize',
                () => {
                    clearTimeout(
                        resizeTimer
                    );

                    resizeTimer =
                        setTimeout(
                            createMarquee,
                            250
                        );
                },
                {
                    passive: true
                }
            );
        }
    }

    /* ============================================================
       GLOBAL 3D TILT

       DESKTOP MOUSE ONLY
    ============================================================ */
    if (device.desktopMotion) {
        qsa('[data-bd-tilt]')
            .forEach(card => {
                gsap.set(card, {
                    transformPerspective:
                        1000,

                    transformStyle:
                        'preserve-3d'
                });

                const rx =
                    gsap.quickTo(
                        card,
                        'rotationX',
                        {
                            duration:
                                .4,

                            ease:
                                'power3.out'
                        }
                    );

                const ry =
                    gsap.quickTo(
                        card,
                        'rotationY',
                        {
                            duration:
                                .4,

                            ease:
                                'power3.out'
                        }
                    );

                card.addEventListener(
                    'pointermove',
                    e => {
                        const rect =
                            card
                                .getBoundingClientRect();

                        const x =
                            (
                                e.clientX -
                                rect.left
                            ) /
                            rect.width;

                        const y =
                            (
                                e.clientY -
                                rect.top
                            ) /
                            rect.height;

                        rx(
                            (.5 - y) *
                            4
                        );

                        ry(
                            (x - .5) *
                            5.5
                        );
                    }
                );

                card.addEventListener(
                    'pointerleave',
                    () => {
                        rx(0);
                        ry(0);
                    }
                );
            });

        gsap.set(
            '.bd-depth-1',
            {
                z: 14
            }
        );

        gsap.set(
            '.bd-depth-2',
            {
                z: 26
            }
        );
    }

    /* ============================================================
       SECTION GLOW
    ============================================================ */
    if (device.desktopMotion) {
        qsa('.bd-section-glow')
            .forEach(glow => {
                const section =
                    glow.closest('section');

                if (!section) return;

                gsap.to(glow, {
                    y: 75,
                    ease: 'none',

                    scrollTrigger: {
                        trigger:
                            section,

                        start:
                            'top bottom',

                        end:
                            'bottom top',

                        scrub: 1.4
                    }
                });
            });
    }

    /* ============================================================
       MAGNETIC BUTTON

       DESKTOP ONLY
    ============================================================ */
    if (device.desktopMotion) {
        qsa(
            '.bd-wa-btn,' +
            '.bd-book-detail,' +
            '.bd-info-read,' +
            '.bd-publish-action > a'
        ).forEach(button => {
            button.addEventListener(
                'pointermove',
                e => {
                    const rect =
                        button
                            .getBoundingClientRect();

                    const x =
                        e.clientX -
                        rect.left -
                        rect.width / 2;

                    const y =
                        e.clientY -
                        rect.top -
                        rect.height / 2;

                    gsap.to(button, {
                        x: x * .08,
                        y: y * .1,
                        duration: .3,
                        ease: 'power3.out'
                    });
                }
            );

            button.addEventListener(
                'pointerleave',
                () => {
                    gsap.to(button, {
                        x: 0,
                        y: 0,
                        duration: .55,
                        ease:
                            'elastic.out(1,.45)'
                    });
                }
            );
        });
    }

    /* ============================================================
       MONEY
    ============================================================ */
    window.bdAnimateMoney = (
        element,
        value,
        prefix = 'Rp '
    ) => {
        if (!element) return;

        if (element._bdMoneyTween) {
            element._bdMoneyTween.kill();
        }

        let current =
            Number(
                element.dataset.value
            );

        if (!Number.isFinite(current)) {
            current =
                Number(
                    String(
                        element.textContent ||
                        ''
                    ).replace(
                        /[^\d]/g,
                        ''
                    )
                ) || 0;
        }

        const state = {
            value: current
        };

        element._bdMoneyTween =
            gsap.to(
                state,
                {
                    value:
                        Number(
                            value || 0
                        ),

                    duration: .5,
                    ease: 'power2.out',

                    onUpdate: () => {
                        element.textContent =
                            prefix +
                            Math.round(
                                state.value
                            ).toLocaleString(
                                'id-ID'
                            );
                    },

                    onComplete: () => {
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

    /* ============================================================
       RESIZE
    ============================================================ */
    let resizeTimer = null;

    window.addEventListener(
        'resize',
        () => {
            clearTimeout(
                resizeTimer
            );

            resizeTimer =
                setTimeout(
                    () => {
                        html.classList.toggle(
                            'bd-phone-layout',
                            window.matchMedia(
                                '(max-width:767px)'
                            ).matches
                        );

                        html.classList.toggle(
                            'bd-tablet-layout',
                            window.matchMedia(
                                '(min-width:768px) and (max-width:1023px)'
                            ).matches
                        );

                        if (
                            !device.touch
                        ) {
                            ScrollTrigger.refresh();
                        }
                    },
                    180
                );
        },
        {
            passive: true
        }
    );

    window.addEventListener(
        'load',
        () => {
            if (
                !device.touch
            ) {
                ScrollTrigger.refresh();
            }
        },
        {
            once: true
        }
    );

    if (!device.touch) {
        ScrollTrigger.refresh();
    }
});