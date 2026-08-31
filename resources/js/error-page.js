import gsap from 'gsap';

const initErrorPage = () => {
    const root = document.querySelector('[data-error-page]');

    if (!root) return;

    const card = root.querySelector('[data-error-card]');
    const visual = root.querySelector('[data-error-visual]');
    const icon = root.querySelector('[data-error-icon]');
    const ring = root.querySelector('[data-error-ring]');
    const codeChars = root.querySelectorAll('[data-error-code] span');
    const items = root.querySelectorAll('[data-error-item]');
    const orbs = root.querySelectorAll('[data-error-orb]');
    const buttons = root.querySelectorAll('.error-button');

    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    const finePointer = window.matchMedia(
        '(hover: hover) and (pointer: fine)'
    ).matches;

    if (reducedMotion) {
        gsap.set(
            [
                card,
                visual,
                icon,
                ring,
                ...codeChars,
                ...items
            ],
            {
                clearProps: 'all'
            }
        );

        return;
    }

    const intro = gsap.timeline({
        defaults: {
            ease: 'power4.out'
        }
    });

    intro.from(card, {
        autoAlpha: 0,
        y: 36,
        scale: .965,
        duration: .85
    });

    intro.from(
        visual,
        {
            autoAlpha: 0,
            y: 16,
            scale: .68,
            rotation: -7,
            duration: .7,
            ease: 'back.out(1.8)'
        },
        '-=.5'
    );

    intro.from(
        codeChars,
        {
            autoAlpha: 0,
            y: 48,
            rotationX: -55,
            scale: .8,
            duration: .65,
            stagger: .09,
            ease: 'back.out(1.7)'
        },
        '-=.4'
    );

    intro.from(
        items,
        {
            autoAlpha: 0,
            y: 18,
            duration: .5,
            stagger: .07
        },
        '-=.35'
    );

    gsap.to(icon, {
        y: -7,
        rotation: 2.5,
        duration: 2.5,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

    gsap.to(ring, {
        rotation: 360,
        duration: 18,
        repeat: -1,
        ease: 'none'
    });

    if (orbs[0]) {
        gsap.to(orbs[0], {
            x: 35,
            y: 25,
            duration: 7,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });
    }

    if (orbs[1]) {
        gsap.to(orbs[1], {
            x: -30,
            y: -25,
            duration: 8,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });
    }

    if (orbs[2]) {
        gsap.to(orbs[2], {
            rotation: 360,
            y: 16,
            duration: 12,
            repeat: -1,
            ease: 'none'
        });
    }

    buttons.forEach(button => {
        button.addEventListener('pointerenter', () => {
            gsap.to(button, {
                y: -3,
                scale: 1.02,
                duration: .22,
                ease: 'power3.out',
                overwrite: true
            });
        });

        button.addEventListener('pointerleave', () => {
            gsap.to(button, {
                y: 0,
                scale: 1,
                duration: .3,
                ease: 'power3.out',
                overwrite: true
            });
        });

        button.addEventListener('pointerdown', () => {
            gsap.to(button, {
                scale: .96,
                duration: .09,
                overwrite: true
            });
        });

        button.addEventListener('pointerup', () => {
            gsap.to(button, {
                scale: 1.02,
                duration: .22,
                ease: 'back.out(2)',
                overwrite: true
            });
        });
    });

    if (finePointer && card && icon) {
        const rotateX = gsap.quickTo(
            card,
            'rotationX',
            {
                duration: .65,
                ease: 'power3.out'
            }
        );

        const rotateY = gsap.quickTo(
            card,
            'rotationY',
            {
                duration: .65,
                ease: 'power3.out'
            }
        );

        const moveIconX = gsap.quickTo(
            icon,
            'x',
            {
                duration: .6,
                ease: 'power3.out'
            }
        );

        root.addEventListener('pointermove', event => {
            const rect = root.getBoundingClientRect();

            const x =
                (
                    event.clientX -
                    rect.left
                ) /
                rect.width -
                .5;

            const y =
                (
                    event.clientY -
                    rect.top
                ) /
                rect.height -
                .5;

            rotateY(x * 2.4);
            rotateX(-y * 1.7);
            moveIconX(x * 5);
        });

        root.addEventListener('pointerleave', () => {
            rotateX(0);
            rotateY(0);
            moveIconX(0);
        });
    }
};

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initErrorPage,
        {
            once: true
        }
    );
} else {
    initErrorPage();
}