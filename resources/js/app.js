import './bootstrap';
import './bookstore-motion';

import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

gsap.registerPlugin(ScrollTrigger);
window.bdGsap = gsap;

document.addEventListener('DOMContentLoaded', () => {
    if (window.__bdMotionReady) return;
    window.__bdMotionReady = true;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
    const home = document.querySelector('.bd-home');

    /* =====================================================
       LENIS
    ===================================================== */
    const lenis = new Lenis({
        autoRaf: false,
        duration: 1.1,
        smoothWheel: true,
        wheelMultiplier: .9,
        touchMultiplier: 1
    });

    window.bdLenis = lenis;

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add(time => {
        lenis.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);

    /* =====================================================
       ANCHOR
    ===================================================== */
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const href = link.getAttribute('href');

            if (!href || href === '#') return;

            const target = document.querySelector(href);

            if (!target) return;

            e.preventDefault();

            lenis.scrollTo(target, {
                offset: -80,
                duration: 1.1
            });
        });
    });

    if (!home) {
        ScrollTrigger.refresh();
        return;
    }

    /* =====================================================
       REDUCED MOTION
    ===================================================== */
    if (reduceMotion) {
        document.querySelectorAll('[data-bd-reveal]').forEach(el => {
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

    /* =====================================================
       GLOBAL REVEAL
    ===================================================== */
    document.querySelectorAll('[data-bd-reveal]').forEach(el => {
        if (el.closest('#home')) return;

        const type = el.dataset.bdReveal || 'up';
        const delay = Number(el.dataset.bdDelay || 0) / 1000;

        const from = {
            opacity: 0,
            x: 0,
            y: 0,
            scale: 1,
            filter: 'blur(4px)'
        };

        if (type === 'up') from.y = 42;
        if (type === 'left') from.x = -48;
        if (type === 'right') from.x = 48;

        if (type === 'zoom') {
            from.scale = .94;
            from.y = 18;
        }

        gsap.fromTo(el, from, {
            opacity: 1,
            x: 0,
            y: 0,
            scale: 1,
            filter: 'blur(0px)',
            duration: .85,
            delay,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    /* =====================================================
       HERO
    ===================================================== */
    const hero = document.getElementById('home');

    if (hero) {
        const badge = hero.querySelector('.bd-hero-badge');
        const lines = hero.querySelectorAll('.bd-hero-line>span');
        const desc = hero.querySelector('.bd-hero-desc');
        const button = hero.querySelector('.bd-wa-btn');
        const visual = hero.querySelector('.bd-hero-visual');
        const cards = hero.querySelectorAll('.bd-floating-card');
        const orbits = hero.querySelectorAll('.bd-hero-orbit');
        const dots = hero.querySelector('.bd-hero-dots');
        const background = hero.querySelector('.bd-hero-bg');
        const grid = hero.querySelector('.bd-hero-grid');
        const glow = hero.querySelector('.bd-hero-glow');

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

        const tl = gsap.timeline({
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
            tl.to(lines, {
                opacity: 1,
                yPercent: 0,
                duration: .9,
                stagger: .12
            }, '-=.3');
        }

        if (desc) {
            tl.to(desc, {
                opacity: 1,
                y: 0,
                duration: .7
            }, '-=.5');
        }

        if (button) {
            tl.to(button, {
                opacity: 1,
                y: 0,
                duration: .6
            }, '-=.45');
        }

        if (visual) {
            tl.to(visual, {
                opacity: 1,
                x: 0,
                scale: 1,
                duration: 1
            }, '-=.75');
        }

        if (orbits.length) {
            tl.to(orbits, {
                opacity: 1,
                duration: .5,
                stagger: .1
            }, '-=.55');
        }

        if (cards.length) {
            tl.to(cards, {
                opacity: 1,
                duration: .45,
                stagger: .1
            }, '-=.45');
        }

        if (dots) {
            tl.to(dots, {
                opacity: 1,
                duration: .4
            }, '-=.2');
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
            hero.addEventListener('pointermove', e => {
                if (window.innerWidth < 1024) return;

                const rect = hero.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - .5;
                const y = (e.clientY - rect.top) / rect.height - .5;

                gsap.to(visual, {
                    rotationY: x * 4,
                    rotationX: -y * 3,
                    duration: .8,
                    ease: 'power3.out',
                    overwrite: 'auto'
                });
            });

            hero.addEventListener('pointerleave', () => {
                gsap.to(visual, {
                    rotationY: 0,
                    rotationX: 0,
                    duration: .8,
                    ease: 'power3.out',
                    overwrite: 'auto'
                });
            });
        }
    }

    /* =====================================================
       ALUR PENERBITAN
       SCROLL → AUTO LOOP → HOVER/CLICK PAUSE
    ===================================================== */
    const processSection = document.getElementById('alur');

    if (processSection) {
        const stage = processSection.querySelector('.bd-process-stage');
        const items = [
            ...processSection.querySelectorAll('[data-process-item], .bd-process-item')
        ];
        const nodes = [
            ...processSection.querySelectorAll('[data-process-node]')
        ];
        const progress = processSection.querySelector('.bd-process-progress');
        const hint = processSection.querySelector('.bd-process-scroll-hint');
        const media = gsap.matchMedia();

        media.add('(min-width:1024px)', () => {
            if (!stage || !items.length) return;

            let currentStep = -1;
            let autoIndex = -1;
            let autoCall = null;
            let autoStartDelay = null;
            let pointerInside = false;
            let manualPause = false;
            let processCompleted = false;
            let processVisible = true;

            const thresholds = [.08, .31, .54, .77];

            const progressValues = items.map((item, index) => {
                if (items.length <= 1) return 1;
                return index / (items.length - 1);
            });

            const stopAuto = () => {
                if (autoCall) {
                    autoCall.kill();
                    autoCall = null;
                }

                if (autoStartDelay) {
                    autoStartDelay.kill();
                    autoStartDelay = null;
                }
            };

            const pulseStep = index => {
                const item = items[index];
                const node = nodes[index];

                if (!item) return;

                const card = item.querySelector('.bd-process-card');
                const icon = node?.querySelector('.bd-process-node-icon');

                if (card) {
                    gsap.timeline()
                        .to(card, {
                            y: -5,
                            duration: .2,
                            ease: 'power2.out',
                            overwrite: true
                        })
                        .to(card, {
                            y: 0,
                            duration: .35,
                            ease: 'back.out(1.7)',
                            clearProps: 'y'
                        });
                }

                if (icon) {
                    gsap.fromTo(icon, {
                        scale: 1
                    }, {
                        scale: 1.14,
                        duration: .22,
                        yoyo: true,
                        repeat: 1,
                        ease: 'power2.out',
                        overwrite: true,
                        clearProps: 'scale'
                    });
                }
            };

            const applyStep = (index, options = {}) => {
                const {
                    pulse = false,
                    animateProgress = true
                } = options;

                currentStep = index;

                items.forEach((item, i) => {
                    item.classList.remove('is-active', 'is-complete');

                    if (index < 0) return;

                    if (i < index) {
                        item.classList.add('is-complete');
                    }

                    if (i === index) {
                        item.classList.add('is-active');
                    }
                });

                nodes.forEach((node, i) => {
                    node.classList.remove('is-active', 'is-complete');

                    if (index < 0) return;

                    if (i < index) {
                        node.classList.add('is-complete');
                    }

                    if (i === index) {
                        node.classList.add('is-active');
                    }
                });

                if (progress) {
                    const target = index < 0 ? 0 : progressValues[index];

                    if (animateProgress) {
                        gsap.to(progress, {
                            scaleX: target,
                            duration: .38,
                            ease: 'power3.out',
                            overwrite: true
                        });
                    } else {
                        gsap.set(progress, {
                            scaleX: target
                        });
                    }
                }

                if (pulse && index >= 0) {
                    pulseStep(index);
                }
            };

            const runAutoLoop = () => {
                if (
                    pointerInside ||
                    manualPause ||
                    !processCompleted ||
                    !processVisible
                ) {
                    return;
                }

                autoIndex = (autoIndex + 1) % items.length;

                applyStep(autoIndex, {
                    pulse: true,
                    animateProgress: true
                });

                autoCall = gsap.delayedCall(1.75, runAutoLoop);
            };

            const scheduleAuto = (delay = 1) => {
                stopAuto();

                if (
                    pointerInside ||
                    manualPause ||
                    !processCompleted ||
                    !processVisible
                ) {
                    return;
                }

                autoStartDelay = gsap.delayedCall(delay, () => {
                    autoStartDelay = null;
                    autoIndex = -1;
                    runAutoLoop();
                });
            };

            const getStepFromProgress = value => {
                let step = -1;

                thresholds.forEach((threshold, index) => {
                    if (value >= threshold) {
                        step = index;
                    }
                });

                return step;
            };

            if (progress) {
                gsap.set(progress, {
                    scaleX: 0,
                    transformOrigin: 'left center'
                });
            }

            applyStep(-1, {
                animateProgress: false
            });

            const processTrigger = ScrollTrigger.create({
                trigger: stage,
                start: 'top 18%',
                end: '+=1150',
                pin: true,
                anticipatePin: 1,
                invalidateOnRefresh: true,

                onEnter: () => {
                    processVisible = true;
                },

                onEnterBack: () => {
                    processVisible = true;
                    stopAuto();
                    processCompleted = false;
                },

                onUpdate: self => {
                    const nextStep = getStepFromProgress(self.progress);

                    if (self.progress < .98) {
                        if (processCompleted) {
                            stopAuto();
                        }

                        processCompleted = false;
                    }

                    if (!processCompleted && nextStep !== currentStep) {
                        applyStep(nextStep, {
                            pulse: nextStep >= 0,
                            animateProgress: true
                        });
                    }

                    if (self.progress >= .98 && !processCompleted) {
                        processCompleted = true;

                        applyStep(items.length - 1, {
                            pulse: true,
                            animateProgress: true
                        });

                        scheduleAuto(1);
                    }
                },

                onLeave: () => {
                    processVisible = false;
                    stopAuto();
                },

                onLeaveBack: () => {
                    processVisible = false;
                    processCompleted = false;
                    manualPause = false;

                    stopAuto();

                    applyStep(-1, {
                        animateProgress: true
                    });
                }
            });

            const handlePointerEnter = () => {
                pointerInside = true;
                stopAuto();
            };

            const handlePointerLeave = () => {
                pointerInside = false;
                manualPause = false;

                if (processCompleted && processVisible) {
                    scheduleAuto(.7);
                }
            };

            stage.addEventListener('pointerenter', handlePointerEnter);
            stage.addEventListener('pointerleave', handlePointerLeave);

            const cardClickHandlers = [];

            items.forEach((item, index) => {
                const handler = () => {
                    if (!processCompleted) return;

                    manualPause = true;
                    autoIndex = index;

                    stopAuto();

                    applyStep(index, {
                        pulse: true,
                        animateProgress: true
                    });
                };

                cardClickHandlers.push(handler);
                item.addEventListener('click', handler);
            });

            return () => {
                stopAuto();
                processTrigger.kill();

                stage.removeEventListener('pointerenter', handlePointerEnter);
                stage.removeEventListener('pointerleave', handlePointerLeave);

                items.forEach((item, index) => {
                    item.removeEventListener('click', cardClickHandlers[index]);
                    item.classList.remove('is-active', 'is-complete');
                });

                nodes.forEach(node => {
                    node.classList.remove('is-active', 'is-complete');
                });

                if (progress) {
                    gsap.killTweensOf(progress);
                    gsap.set(progress, {
                        clearProps: 'transform'
                    });
                }
            };
        });

        /* =================================================
           MOBILE / TABLET
           TETAP SCROLL MANUAL
        ================================================= */
        media.add('(max-width:1023px)', () => {
            items.forEach(item => {
                const card = item.querySelector('.bd-process-card');
                const check = item.querySelector('.bd-process-check');
                const icon = item.querySelector('.bd-process-mobile-icon');

                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 92%',
                        end: 'top 65%',
                        scrub: true
                    }
                });

                tl.fromTo(item, {
                    opacity: .45,
                    y: 28,
                    scale: .98
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 1,
                    ease: 'none'
                });

                if (card) {
                    tl.fromTo(card, {
                        borderColor: '#E8EDF3'
                    }, {
                        borderColor: 'rgba(239,88,67,.28)',
                        duration: 1,
                        ease: 'none'
                    }, 0);
                }

                if (icon) {
                    tl.fromTo(icon, {
                        scale: .88
                    }, {
                        scale: 1,
                        duration: 1,
                        ease: 'none'
                    }, 0);
                }

                if (check) {
                    tl.fromTo(check, {
                        opacity: .15,
                        scale: .72
                    }, {
                        opacity: 1,
                        scale: 1,
                        duration: 1,
                        ease: 'none'
                    }, 0);
                }
            });
        });
    }

    /* =====================================================
       KATALOG PREMIUM 3D
    ===================================================== */
    const catalog = document.getElementById('katalog');

    if (catalog) {
        const slider = catalog.querySelector('.bd-book-slider');
        const slides = [
            ...catalog.querySelectorAll('[data-bd-catalog-item]')
        ];
        const prev = catalog.querySelector('[data-catalog-prev]');
        const next = catalog.querySelector('[data-catalog-next]');

        /* REVEAL AWAL */
        if (slides.length) {
            gsap.from(slides, {
                opacity: 0,
                y: 60,
                scale: .92,
                rotationY: -10,
                stagger: .09,
                duration: .9,
                ease: 'power4.out',
                scrollTrigger: {
                    trigger: catalog,
                    start: 'top 82%'
                }
            });
        }

        /* 3D BOOK HOVER */
        slides.forEach((slide, index) => {
            const card = slide.querySelector('.bd-home-book');
            const stage = slide.querySelector('.bd-book-stage');
            const shine = slide.querySelector('.bd-book-shine');

            if (!card || !stage) return;

            gsap.set(stage, {
                transformPerspective: 900,
                transformStyle: 'preserve-3d'
            });

            const rotateX = gsap.quickTo(stage, 'rotationX', {
                duration: .5,
                ease: 'power3.out'
            });

            const rotateY = gsap.quickTo(stage, 'rotationY', {
                duration: .5,
                ease: 'power3.out'
            });

            const moveX = gsap.quickTo(stage, 'x', {
                duration: .5,
                ease: 'power3.out'
            });

            const moveY = gsap.quickTo(stage, 'y', {
                duration: .5,
                ease: 'power3.out'
            });

            card.addEventListener('pointerenter', () => {
                if (window.innerWidth < 768) return;

                gsap.to(stage, {
                    scale: 1.07,
                    y: -6,
                    duration: .45,
                    ease: 'power3.out'
                });

                if (shine) {
                    gsap.fromTo(shine, {
                        xPercent: -180,
                        opacity: 0
                    }, {
                        xPercent: 260,
                        opacity: .8,
                        duration: .9,
                        ease: 'power2.out'
                    });
                }
            });

            card.addEventListener('pointermove', e => {
                if (window.innerWidth < 768) return;

                const rect = card.getBoundingClientRect();
                const px = (e.clientX - rect.left) / rect.width - .5;
                const py = (e.clientY - rect.top) / rect.height - .5;

                rotateY(px * 18);
                rotateX(-py * 11);
                moveX(px * 9);
                moveY(py * 5 - 6);
            });

            card.addEventListener('pointerleave', () => {
                rotateX(0);
                rotateY(0);
                moveX(0);
                moveY(0);

                gsap.to(stage, {
                    scale: 1,
                    duration: .6,
                    ease: 'elastic.out(1,.45)'
                });
            });

            gsap.to(slide, {
                y: index % 2 === 0 ? -9 : 9,
                ease: 'none',
                scrollTrigger: {
                    trigger: catalog,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.4
                }
            });
        });

        /* FOCUS SLIDER */
        let catalogFrame = null;

        const updateCatalogFocus = () => {
            if (!slider || !slides.length) return;

            const sliderRect = slider.getBoundingClientRect();
            const sliderCenter = sliderRect.left + sliderRect.width / 2;
            const maxDistance = sliderRect.width * .62;

            slides.forEach(slide => {
                const rect = slide.getBoundingClientRect();
                const center = rect.left + rect.width / 2;
                const distance = Math.abs(center - sliderCenter);
                const normalized = Math.min(distance / maxDistance, 1);

                const scale = 1 - normalized * .055;
                const opacity = 1 - normalized * .23;

                const rotation =
                    (center < sliderCenter ? 1 : -1) *
                    normalized *
                    2.8;

                gsap.to(slide, {
                    scale,
                    opacity,
                    rotationY: rotation,
                    duration: .34,
                    ease: 'power3.out',
                    overwrite: 'auto'
                });
            });
        };

        const requestCatalogFocus = () => {
            if (catalogFrame) {
                cancelAnimationFrame(catalogFrame);
            }

            catalogFrame = requestAnimationFrame(updateCatalogFocus);
        };

        if (slider) {
            slider.addEventListener('scroll', requestCatalogFocus, {
                passive: true
            });

            window.addEventListener('resize', requestCatalogFocus);

            requestAnimationFrame(() => {
                updateCatalogFocus();
            });
        }

        /* ACTIVE BOOK */
        const animateNearestBook = direction => {
            if (!slider || !slides.length) return;

            const sliderRect = slider.getBoundingClientRect();
            const sliderCenter = sliderRect.left + sliderRect.width / 2;

            let nearest = null;
            let nearestDistance = Infinity;

            slides.forEach(slide => {
                const rect = slide.getBoundingClientRect();
                const center = rect.left + rect.width / 2;
                const distance = Math.abs(center - sliderCenter);

                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearest = slide;
                }
            });

            if (!nearest) return;

            const stage = nearest.querySelector('.bd-book-stage');
            const card = nearest.querySelector('.bd-home-book');

            if (card) {
                gsap.fromTo(card, {
                    boxShadow: '0 8px 25px rgba(36,27,82,.055)'
                }, {
                    boxShadow: '0 25px 55px rgba(36,27,82,.14)',
                    duration: .32,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.out'
                });
            }

            if (stage) {
                gsap.fromTo(stage, {
                    scale: .94,
                    rotationY: direction > 0 ? -8 : 8
                }, {
                    scale: 1,
                    rotationY: 0,
                    duration: .55,
                    ease: 'back.out(1.7)',
                    overwrite: 'auto'
                });
            }
        };

        /* BUTTON SLIDER */
        let catalogMoving = false;

        const scrollCatalog = direction => {
            if (!slider || catalogMoving) return;

            const first = slider.querySelector('.bd-book-slide');

            if (!first) return;

            const gap = parseFloat(getComputedStyle(slider).gap) || 20;
            const amount = first.getBoundingClientRect().width + gap;
            const current = slider.scrollLeft;
            const maxScroll = Math.max(0, slider.scrollWidth - slider.clientWidth);

            let target = current + amount * direction;

            target = Math.max(
                0,
                Math.min(target, maxScroll)
            );

            if (Math.abs(target - current) < 2) {
                gsap.fromTo(slider, {
                    x: 0
                }, {
                    x: direction > 0 ? -4 : 4,
                    duration: .1,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.out',
                    onComplete: () => {
                        gsap.set(slider, {
                            x: 0
                        });
                    }
                });

                return;
            }

            catalogMoving = true;

            const sliderRect = slider.getBoundingClientRect();

            const currentVisible = slides.filter(slide => {
                const rect = slide.getBoundingClientRect();

                return (
                    rect.right > sliderRect.left &&
                    rect.left < sliderRect.right
                );
            });

            const scrollState = {
                value: current
            };

            const tl = gsap.timeline({
                defaults: {
                    overwrite: 'auto'
                },
                onComplete: () => {
                    catalogMoving = false;
                    updateCatalogFocus();
                    animateNearestBook(direction);
                }
            });

            tl.to(currentVisible, {
                scale: .965,
                opacity: .72,
                x: direction > 0 ? -6 : 6,
                duration: .22,
                stagger: .02,
                ease: 'power2.out'
            });

            tl.to(scrollState, {
                value: target,
                duration: .72,
                ease: 'power4.inOut',
                onUpdate: () => {
                    slider.scrollLeft = scrollState.value;
                    requestCatalogFocus();
                }
            }, '-=.07');

            tl.to(currentVisible, {
                x: 0,
                duration: .25,
                ease: 'power3.out'
            }, '-=.28');

            tl.add(() => {
                const newSliderRect = slider.getBoundingClientRect();

                const newVisible = slides.filter(slide => {
                    const rect = slide.getBoundingClientRect();

                    return (
                        rect.right > newSliderRect.left &&
                        rect.left < newSliderRect.right
                    );
                });

                newVisible.forEach((slide, index) => {
                    gsap.fromTo(slide, {
                        x: direction > 0 ? 22 : -22,
                        scale: .94,
                        opacity: .62
                    }, {
                        x: 0,
                        scale: 1,
                        opacity: 1,
                        duration: .48,
                        delay: index * .025,
                        ease: 'back.out(1.35)',
                        overwrite: 'auto'
                    });
                });
            }, '-=.2');
        };

        prev?.addEventListener('click', () => {
            scrollCatalog(-1);
        });

        next?.addEventListener('click', () => {
            scrollCatalog(1);
        });

        /* TOUCH / DRAG */
        if (slider) {
            let dragStartX = 0;
            let lastX = 0;
            let dragging = false;

            slider.addEventListener('pointerdown', e => {
                dragStartX = e.clientX;
                lastX = e.clientX;
                dragging = true;
            });

            slider.addEventListener('pointermove', e => {
                if (!dragging) return;

                const delta = e.clientX - lastX;
                lastX = e.clientX;

                slides.forEach(slide => {
                    gsap.to(slide, {
                        rotationY: Math.max(
                            -4,
                            Math.min(4, delta * .12)
                        ),
                        duration: .18,
                        ease: 'power2.out',
                        overwrite: 'auto'
                    });
                });
            });

            const finishDrag = e => {
                if (!dragging) return;

                dragging = false;

                const difference = e.clientX - dragStartX;

                slides.forEach(slide => {
                    gsap.to(slide, {
                        rotationY: 0,
                        duration: .45,
                        ease: 'power3.out',
                        overwrite: 'auto'
                    });
                });

                updateCatalogFocus();

                if (Math.abs(difference) > 25) {
                    animateNearestBook(
                        difference < 0 ? 1 : -1
                    );
                }
            };

            slider.addEventListener('pointerup', finishDrag);

            slider.addEventListener('pointercancel', () => {
                dragging = false;
                updateCatalogFocus();
            });
        }
    }

    /* =====================================================
       INFORMATION PARALLAX
    ===================================================== */
    document.querySelectorAll('.bd-info-card').forEach(card => {
        const image = card.querySelector('.bd-info-image img');

        if (!image) return;

        gsap.fromTo(image, {
            yPercent: -4,
            scale: 1.06
        }, {
            yPercent: 4,
            scale: 1.06,
            ease: 'none',
            scrollTrigger: {
                trigger: card,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1.2
            }
        });
    });

    /* =====================================================
       CTA
    ===================================================== */
    const cta = document.querySelector('.bd-cta-section');

    if (cta) {
        const card = cta.querySelector('.bd-publish-card');
        const pills = cta.querySelectorAll('.bd-cta-pill');
        const action = cta.querySelector('.bd-publish-action');
        const background = cta.querySelector('.bd-cta-background');

        if (card) {
            gsap.from(card, {
                opacity: 0,
                y: 55,
                scale: .95,
                duration: 1,
                ease: 'power4.out',
                scrollTrigger: {
                    trigger: cta,
                    start: 'top 80%'
                }
            });
        }

        if (pills.length) {
            gsap.from(pills, {
                opacity: 0,
                y: 15,
                scale: .92,
                stagger: .08,
                duration: .5,
                ease: 'back.out(1.6)',
                scrollTrigger: {
                    trigger: cta,
                    start: 'top 72%'
                }
            });
        }

        if (action) {
            gsap.from(action, {
                opacity: 0,
                x: 35,
                duration: .8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: cta,
                    start: 'top 72%'
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

    /* =====================================================
       TESTIMONI GLOW
    ===================================================== */
    const testimonial = document.getElementById('testimoni');

    if (testimonial) {
        testimonial
            .querySelectorAll('.bdt-glow')
            .forEach((glow, index) => {
                gsap.to(glow, {
                    y: index === 0 ? 60 : -60,
                    x: index === 0 ? 28 : -28,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: testimonial,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 1.4
                    }
                });
            });
    }

    /* =====================================================
       AFILIASI INFINITE MARQUEE
    ===================================================== */
    const affiliate = document.getElementById('afiliasi');

    if (affiliate) {
        const wrap = affiliate.querySelector('.bd-affiliate-wrap');
        const track = affiliate.querySelector('.bd-affiliate-track');

        if (wrap && track) {
            let marquee = null;
            let settleTimer = null;
            let affiliateResizeTimer = null;
            let currentDirection = 1;

            const createMarquee = () => {
                if (marquee) {
                    marquee.kill();
                    marquee = null;
                }

                gsap.killTweensOf(track);

                gsap.set(track, {
                    x: 0
                });

                const gap =
                    parseFloat(
                        getComputedStyle(track).gap
                    ) || 0;

                const distance =
                    track.scrollWidth / 2 +
                    gap / 2;

                if (distance <= 0) return;

                marquee = gsap.to(track, {
                    x: -distance,
                    duration: 34,
                    ease: 'none',
                    repeat: -1
                });

                marquee.timeScale(currentDirection);
            };

            window.addEventListener('load', () => {
                createMarquee();
            });

            requestAnimationFrame(() => {
                createMarquee();
            });

            ScrollTrigger.create({
                trigger: affiliate,
                start: 'top bottom',
                end: 'bottom top',

                onUpdate: self => {
                    if (!marquee) return;

                    currentDirection =
                        self.direction > 0 ? 1 : -1;

                    gsap.to(marquee, {
                        timeScale:
                            currentDirection * 2.2,
                        duration: .2,
                        overwrite: true
                    });

                    if (settleTimer) {
                        settleTimer.kill();
                    }

                    settleTimer = gsap.delayedCall(.18, () => {
                        if (!marquee) return;

                        gsap.to(marquee, {
                            timeScale: currentDirection,
                            duration: .75,
                            ease: 'power2.out'
                        });
                    });
                }
            });

            wrap.addEventListener('mouseenter', () => {
                if (!marquee) return;

                gsap.to(marquee, {
                    timeScale: 0,
                    duration: .35,
                    ease: 'power2.out'
                });
            });

            wrap.addEventListener('mouseleave', () => {
                if (!marquee) return;

                gsap.to(marquee, {
                    timeScale: currentDirection,
                    duration: .55,
                    ease: 'power2.out'
                });
            });

            window.addEventListener('resize', () => {
                clearTimeout(
                    affiliateResizeTimer
                );

                affiliateResizeTimer = setTimeout(() => {
                    createMarquee();
                    ScrollTrigger.refresh();
                }, 250);
            });
        }
    }

    /* =====================================================
       GLOBAL 3D TILT
    ===================================================== */
    document
        .querySelectorAll('[data-bd-tilt]')
        .forEach(card => {
            gsap.set(card, {
                transformPerspective: 1000,
                transformStyle: 'preserve-3d'
            });

            const rx = gsap.quickTo(
                card,
                'rotationX',
                {
                    duration: .4,
                    ease: 'power3.out'
                }
            );

            const ry = gsap.quickTo(
                card,
                'rotationY',
                {
                    duration: .4,
                    ease: 'power3.out'
                }
            );

            card.addEventListener('pointermove', e => {
                if (window.innerWidth < 768) {
                    return;
                }

                const rect =
                    card.getBoundingClientRect();

                const x =
                    (e.clientX - rect.left) /
                    rect.width;

                const y =
                    (e.clientY - rect.top) /
                    rect.height;

                rx((.5 - y) * 4);
                ry((x - .5) * 5.5);
            });

            card.addEventListener('pointerleave', () => {
                rx(0);
                ry(0);
            });
        });

    /* =====================================================
       DEPTH
    ===================================================== */
    gsap.set('.bd-depth-1', {
        z: 14
    });

    gsap.set('.bd-depth-2', {
        z: 26
    });

    /* =====================================================
       SECTION GLOW
    ===================================================== */
    document
        .querySelectorAll('.bd-section-glow')
        .forEach(glow => {
            const section = glow.closest('section');

            if (!section) return;

            gsap.to(glow, {
                y: 75,
                ease: 'none',
                scrollTrigger: {
                    trigger: section,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.4
                }
            });
        });

    /* =====================================================
       MAGNETIC BUTTON
    ===================================================== */
    document.querySelectorAll(
        '.bd-wa-btn,.bd-book-detail,.bd-info-read,.bd-publish-action>a'
    ).forEach(button => {
        button.addEventListener('pointermove', e => {
            if (window.innerWidth < 768) {
                return;
            }

            const rect =
                button.getBoundingClientRect();

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
        });

        button.addEventListener('pointerleave', () => {
            gsap.to(button, {
                x: 0,
                y: 0,
                duration: .6,
                ease: 'elastic.out(1,.45)'
            });
        });
    });

    /* =====================================================
       KALKULATOR MONEY
    ===================================================== */
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
                        element.textContent || ''
                    ).replace(/[^\d]/g, '')
                ) || 0;
        }

        const state = {
            value: current
        };

        element._bdMoneyTween = gsap.to(
            state,
            {
                value: Number(value || 0),
                duration: .55,
                ease: 'power2.out',

                onUpdate: () => {
                    element.textContent =
                        prefix +
                        Math.round(
                            state.value
                        ).toLocaleString('id-ID');
                },

                onComplete: () => {
                    element.dataset.value =
                        Number(value || 0);

                    element._bdMoneyTween = null;
                }
            }
        );
    };

    /* =====================================================
       REFRESH
    ===================================================== */
    window.addEventListener('load', () => {
        ScrollTrigger.refresh();
    });

    let resizeTimer = null;

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(() => {
            ScrollTrigger.refresh();
        }, 180);
    });

    ScrollTrigger.refresh();
});