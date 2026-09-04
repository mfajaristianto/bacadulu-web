@extends('layouts.app')

@section('title', 'Pendaftaran HAKI - Baca Dulu')

@section('content')

<style>
.haki-page {
    --red: #A94332;
    --red-orange: #C94F35;
    --orange: #D96A2B;
    --orange-dark: #B95624;
    --amber: #E58A2B;
    --gold: #D9A62E;
    --yellow: #F2C94C;

    --soft-red: #FBE8E3;
    --soft-orange: #FFF0E3;
    --soft-amber: #FFF4DD;
    --soft-yellow: #FFF8D9;

    --white: #FFFFFF;
    --surface: #FFFCF8;
    --text: #2F3640;
    --muted: #6E737A;
    --border: #E8D6C8;

    min-height: 100vh;
    overflow-x: hidden;
    color: var(--text);
    background: #FFFCF8;
    font-family: 'Inter', system-ui, sans-serif;
}

.haki-page *,
.haki-page *::before,
.haki-page *::after {
    box-sizing: border-box;
}

.haki-container {
    width: min(calc(100% - 48px), 1180px);
    margin: 0 auto;
}


/* HERO */

.haki-hero {
    position: relative;
    overflow: hidden;
    padding: 66px 0 60px;

    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(217,106,43,.20),
            transparent 27%
        ),
        radial-gradient(
            circle at 8% 90%,
            rgba(242,201,76,.13),
            transparent 26%
        ),
        linear-gradient(
            120deg,
            #FFF8F1 0%,
            #FFFFFF 52%,
            #FFFBEA 100%
        );

    border-bottom: 1px solid rgba(217,106,43,.14);
}

.haki-hero-grid {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: minmax(0,1.25fr) minmax(280px,.75fr);
    gap: 42px;
    align-items: center;
}

.haki-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 13px;
    color: var(--red-orange);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
}

.haki-eyebrow::before {
    content: "";
    width: 30px;
    height: 3px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--red-orange), var(--orange), var(--gold));
}

.haki-hero h1 {
    max-width: 760px;
    margin: 0 0 15px;
    font-family: 'Poppins', sans-serif;
    font-size: clamp(40px,5vw,66px);
    line-height: 1.05;
    letter-spacing: -.045em;
    font-weight: 750;
}

.haki-hero h1 span {
    background: linear-gradient(90deg, var(--red-orange), var(--orange), var(--amber));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.haki-hero-description {
    max-width: 680px;
    margin: 0;
    color: var(--muted);
    font-size: 13px;
    line-height: 1.8;
}

.haki-hero-card {
    position: relative;
    padding: 23px;
    overflow: hidden;
    border: 1px solid rgba(217,106,43,.22);
    border-radius: 19px;
    background: linear-gradient(145deg, #FFFFFF, #FFF7EC);
    box-shadow: 0 16px 38px rgba(169,67,50,.09);
}

.haki-hero-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 5px;
    background: linear-gradient(
        90deg,
        var(--red),
        var(--red-orange),
        var(--orange),
        var(--amber),
        var(--gold)
    );
}

.haki-hero-icon {
    width: 47px;
    height: 47px;
    display: grid;
    place-items: center;
    margin-bottom: 15px;
    border-radius: 14px;
    color: var(--orange-dark);
    background: var(--soft-orange);
}

.haki-hero-icon svg {
    width: 23px;
    height: 23px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
}

.haki-hero-card small {
    display: block;
    margin-bottom: 5px;
    color: var(--gold);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.haki-hero-card h3 {
    margin: 0 0 7px;
    font-size: 17px;
    font-weight: 800;
}

.haki-hero-card p {
    margin: 0;
    color: var(--muted);
    font-size: 11px;
    line-height: 1.7;
}


/* CONTENT */

.haki-content {
    padding: 50px 0 72px;
}

.haki-section {
    margin-bottom: 50px;
}

.haki-section:last-child {
    margin-bottom: 0;
}

.haki-section-head {
    max-width: 720px;
    margin-bottom: 22px;
}

.haki-section-head.center {
    margin: 0 auto 25px;
    text-align: center;
}

.haki-label {
    display: inline-block;
    margin-bottom: 7px;
    color: var(--red-orange);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.haki-section-head h2 {
    margin: 0 0 8px;
    font-family: 'Poppins', sans-serif;
    font-size: clamp(26px,3vw,36px);
    line-height: 1.25;
    letter-spacing: -.03em;
}

.haki-section-head p {
    margin: 0;
    color: var(--muted);
    font-size: 12px;
    line-height: 1.75;
}


/* EDUCATION */

.haki-education-grid {
    display: grid;
    grid-template-columns: 1.08fr .92fr;
    gap: 17px;
}

.haki-card {
    padding: 22px;
    border: 1px solid var(--border);
    border-radius: 18px;
    background: #FFFFFF;
    box-shadow: 0 9px 26px rgba(78,45,31,.045);
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
}

.haki-card:hover {
    transform: translateY(-3px);
    border-color: rgba(217,106,43,.38);
    box-shadow: 0 17px 35px rgba(169,67,50,.08);
}

.haki-card-head {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
}

.haki-card-icon {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    border-radius: 13px;
    color: var(--red-orange);
    background: var(--soft-red);
}

.haki-card-icon.gold {
    color: #A97B16;
    background: var(--soft-yellow);
}

.haki-card-icon svg {
    width: 21px;
    height: 21px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
}

.haki-card h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 800;
}

.haki-card > p {
    margin: 0 0 15px;
    color: var(--muted);
    font-size: 11px;
    line-height: 1.7;
}

.haki-detail {
    padding-top: 13px;
    border-top: 1px solid rgba(217,106,43,.10);
}

.haki-detail + .haki-detail {
    margin-top: 13px;
}

.haki-detail h4 {
    margin: 0 0 5px;
    color: var(--orange-dark);
    font-size: 11px;
    font-weight: 800;
}

.haki-detail p,
.haki-detail li {
    color: var(--muted);
    font-size: 10.5px;
    line-height: 1.7;
}

.haki-detail p {
    margin: 0;
}

.haki-detail ul {
    margin: 7px 0 0;
    padding-left: 17px;
}


/* SUMMARY */

.haki-summary-grid {
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 15px;
    margin-top: 17px;
}

.haki-summary {
    padding: 19px;
    border-radius: 17px;
    border: 1px solid rgba(217,106,43,.18);
    background: linear-gradient(145deg,#FFFFFF,var(--soft-orange));
}

.haki-summary:nth-child(2) {
    background: linear-gradient(145deg,#FFFFFF,var(--soft-amber));
    border-color: rgba(229,138,43,.22);
}

.haki-summary:nth-child(3) {
    background: linear-gradient(145deg,#FFFFFF,var(--soft-yellow));
    border-color: rgba(217,166,46,.24);
}

.haki-summary-icon {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    margin-bottom: 12px;
    border-radius: 12px;
    color: var(--red-orange);
    background: var(--soft-red);
}

.haki-summary:nth-child(2) .haki-summary-icon {
    color: #B96D1C;
    background: #FFECD0;
}

.haki-summary:nth-child(3) .haki-summary-icon {
    color: #9F7619;
    background: #FFF1B8;
}

.haki-summary-icon svg {
    width: 21px;
    height: 21px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
}

.haki-summary h3 {
    margin: 0 0 6px;
    font-size: 13px;
}

.haki-summary p {
    margin: 0;
    color: var(--muted);
    font-size: 10px;
    line-height: 1.7;
}


/* WORK SECTION */

.haki-work-section {
    position: relative;
    margin-bottom: 50px;
    padding: 34px 24px;
    overflow: hidden;

    border: 1px solid rgba(217,106,43,.14);
    border-radius: 25px;

    background:
        radial-gradient(
            circle at 0% 0%,
            rgba(201,79,53,.08),
            transparent 27%
        ),
        radial-gradient(
            circle at 100% 100%,
            rgba(242,201,76,.11),
            transparent 28%
        ),
        linear-gradient(
            135deg,
            #FFF9F2,
            #FFFFFF 50%,
            #FFFCEB
        );
}

.haki-work-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    width: 120px;
    height: 4px;
    border-radius: 0 0 10px 10px;
    transform: translateX(-50%);

    background:
        linear-gradient(
            90deg,
            var(--red-orange),
            var(--orange),
            var(--amber),
            var(--gold)
        );
}


/* 5 KATEGORI — 3 ATAS + 2 CENTER */

.haki-work-grid {
    display: grid;
    grid-template-columns: repeat(12,minmax(0,1fr));
    gap: 17px;
}

.haki-pick {
    position: relative;
    grid-column: span 4;
    min-width: 0;
    min-height: 205px;
    padding: 21px;
    cursor: pointer;

    border: 1px solid rgba(217,106,43,.22);
    border-radius: 18px;

    background:
        linear-gradient(
            150deg,
            #FFFFFF,
            #FFF4E9
        );

    box-shadow: 0 8px 24px rgba(113,60,35,.045);

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease,
        background .3s ease;
}

.haki-pick:nth-child(2) {
    border-color: rgba(201,79,53,.22);
    background: linear-gradient(150deg,#FFFFFF,#FFF0E9);
}

.haki-pick:nth-child(3) {
    border-color: rgba(229,138,43,.25);
    background: linear-gradient(150deg,#FFFFFF,#FFF4DE);
}

.haki-pick.center-left {
    grid-column: 3 / span 4;
    border-color: rgba(229,138,43,.25);
    background: linear-gradient(150deg,#FFFFFF,#FFF6E3);
}

.haki-pick.center-right {
    grid-column: 7 / span 4;
    border-color: rgba(217,166,46,.25);
    background: linear-gradient(150deg,#FFFFFF,#FFF8DF);
}

.haki-pick:hover {
    transform: translateY(-4px);
    border-color: var(--orange);
    box-shadow: 0 17px 36px rgba(169,67,50,.11);
}

.haki-pick.is-selected {
    transform: translateY(-4px);
    border-color: var(--orange);

    background:
        linear-gradient(
            145deg,
            #FFEBDD,
            #FFFFFF
        );

    box-shadow: 0 18px 40px rgba(217,106,43,.17);
}

.haki-pick-number {
    position: absolute;
    top: 15px;
    right: 16px;
    color: rgba(169,67,50,.34);
    font-size: 10px;
    font-weight: 800;
}

.haki-check {
    position: absolute;
    top: 13px;
    right: 13px;

    width: 27px;
    height: 27px;

    display: grid;
    place-items: center;

    border-radius: 50%;

    color: #FFFFFF;
    background: var(--orange);

    font-size: 10px;
    font-weight: 900;

    opacity: 0;
    transform: scale(.5);

    transition: .2s ease;
}

.haki-pick.is-selected .haki-check {
    opacity: 1;
    transform: scale(1);
}

.haki-pick.is-selected .haki-pick-number {
    opacity: 0;
}

.haki-pick-icon {
    width: 47px;
    height: 47px;

    display: grid;
    place-items: center;

    margin-bottom: 15px;

    border-radius: 14px;

    color: var(--orange-dark);
    background: #FFE7D6;
}

.haki-pick:nth-child(2) .haki-pick-icon {
    color: var(--red);
    background: var(--soft-red);
}

.haki-pick:nth-child(3) .haki-pick-icon {
    color: #BA6B17;
    background: #FFEAC9;
}

.haki-pick.center-left .haki-pick-icon {
    color: #B97819;
    background: #FFF0CD;
}

.haki-pick.center-right .haki-pick-icon {
    color: #9C761B;
    background: #FFF3BC;
}

.haki-pick-icon svg {
    width: 22px;
    height: 22px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
}

.haki-pick h3 {
    margin: 0 0 7px;
    padding-right: 26px;
    font-size: 13px;
    font-weight: 800;
    line-height: 1.4;
}

.haki-pick p {
    margin: 0;
    color: var(--muted);
    font-size: 10.5px;
    line-height: 1.7;
}


/* JURNAL */

.haki-journal {
    position: relative;
    display: grid;
    grid-template-columns: auto minmax(0,1fr) auto;
    gap: 17px;
    align-items: center;

    margin-top: 18px;
    padding: 21px;

    cursor: pointer;

    border: 1px solid rgba(217,106,43,.24);
    border-radius: 18px;

    background:
        linear-gradient(
            105deg,
            #FFE8DC 0%,
            #FFF8F0 42%,
            #FFF4CC 100%
        );

    transition: .3s ease;
}

.haki-journal:hover,
.haki-journal.is-selected {
    transform: translateY(-3px);
    border-color: var(--orange);
    box-shadow: 0 16px 36px rgba(169,67,50,.12);
}

.haki-journal-icon {
    width: 52px;
    height: 52px;

    display: grid;
    place-items: center;

    border-radius: 15px;

    color: var(--orange-dark);
    background: #FFFFFF;

    border: 1px solid rgba(217,106,43,.18);
}

.haki-journal-icon svg {
    width: 25px;
    height: 25px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
}

.haki-journal small {
    display: block;
    margin-bottom: 4px;
    color: var(--gold);
    font-size: 8px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.haki-journal h3 {
    margin: 0 0 5px;
    font-size: 14px;
}

.haki-journal p {
    margin: 0;
    color: var(--muted);
    font-size: 10.5px;
    line-height: 1.65;
}

.haki-journal-action {
    color: var(--red-orange);
    font-size: 9px;
    font-weight: 800;
}


/* BENEFIT */

.haki-benefit {
    display: grid;
    grid-template-columns: .9fr 1.1fr;
    gap: 38px;
    align-items: center;

    padding: 30px;

    border: 1px solid rgba(217,106,43,.18);
    border-radius: 21px;

    background:
        radial-gradient(
            circle at 0% 0%,
            rgba(201,79,53,.10),
            transparent 30%
        ),
        linear-gradient(
            125deg,
            #FFF5EE,
            #FFFFFF 55%,
            #FFF7D9
        );
}

.haki-benefit h2 {
    margin: 0 0 9px;
    font-family: 'Poppins', sans-serif;
    font-size: clamp(24px,3vw,34px);
    letter-spacing: -.03em;
}

.haki-benefit-copy p {
    margin: 0;
    color: var(--muted);
    font-size: 11px;
    line-height: 1.75;
}

.haki-benefit-list {
    display: grid;
    gap: 9px;
}

.haki-benefit-item {
    display: grid;
    grid-template-columns: 30px minmax(0,1fr);
    gap: 10px;
    align-items: start;

    padding: 11px;

    border: 1px solid rgba(217,106,43,.12);
    border-radius: 13px;

    background: rgba(255,255,255,.78);
}

.haki-benefit-check {
    width: 30px;
    height: 30px;

    display: grid;
    place-items: center;

    border-radius: 9px;

    color: #FFFFFF;

    background:
        linear-gradient(
            135deg,
            var(--red-orange),
            var(--orange)
        );

    font-size: 10px;
    font-weight: 900;
}

.haki-benefit-item p {
    margin: 5px 0 0;
    color: var(--text);
    font-size: 10.5px;
    line-height: 1.6;
}


/* CTA */

.haki-cta {
    position: relative;
    overflow: hidden;

    padding: 44px 30px;

    border-radius: 24px;

    background:
        linear-gradient(
            120deg,
            #A94332 0%,
            #C94F35 24%,
            #D96A2B 52%,
            #E58A2B 78%,
            #D9A62E 100%
        );

    box-shadow: 0 20px 44px rgba(169,67,50,.24);

    text-align: center;
}

.haki-cta::before {
    content: "";
    position: absolute;

    width: 270px;
    height: 270px;

    top: -180px;
    right: -65px;

    border-radius: 50%;

    background: rgba(255,255,255,.14);
}

.haki-cta-inner {
    position: relative;
    z-index: 2;
    max-width: 680px;
    margin: 0 auto;
}

.haki-cta small {
    display: block;
    margin-bottom: 8px;
    color: #FFF0D9;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.haki-cta h2 {
    margin: 0 0 10px;
    color: #FFFFFF;
    font-family: 'Poppins', sans-serif;
    font-size: clamp(26px,3vw,38px);
    letter-spacing: -.03em;
}

.haki-cta p {
    margin: 0 auto 20px;
    color: rgba(255,255,255,.84);
    font-size: 11px;
    line-height: 1.7;
}

.haki-cta-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 11px 18px;

    border-radius: 12px;

    color: var(--red) !important;
    background: #FFFFFF;

    font-size: 10px;
    font-weight: 800;

    text-decoration: none !important;

    transition: transform .25s ease, background .25s ease;
}

.haki-cta-button:hover {
    transform: translateY(-2px);
    background: #FFF8E8;
}


/* FLOATING BAR */

.haki-bar {
    position: fixed;

    left: 50%;
    bottom: 16px;

    z-index: 80;

    width: min(calc(100% - 28px),720px);

    opacity: 0;
    pointer-events: none;

    transform:
        translate(
            -50%,
            calc(100% + 40px)
        );

    transition: .35s cubic-bezier(.22,1,.36,1);
}

.haki-bar.show {
    opacity: 1;
    pointer-events: auto;
    transform: translate(-50%,0);
}

.haki-bar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;

    padding: 11px 12px 11px 16px;

    border: 1px solid rgba(229,138,43,.22);
    border-radius: 16px;

    background:
        linear-gradient(
            110deg,
            rgba(74,42,33,.97),
            rgba(47,54,64,.97)
        );

    box-shadow: 0 20px 50px rgba(15,23,42,.22);

    backdrop-filter: blur(16px);
}

.haki-bar-copy small {
    display: block;
    margin-bottom: 2px;
    color: #F2C94C;
    font-size: 8px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.haki-bar-copy strong {
    display: block;
    max-width: 420px;
    overflow: hidden;
    color: #FFFFFF;
    font-size: 11px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.haki-bar-button {
    flex-shrink: 0;

    padding: 10px 14px;

    border-radius: 11px;

    color: #FFFFFF !important;

    background:
        linear-gradient(
            90deg,
            var(--red-orange),
            var(--orange),
            var(--amber)
        );

    font-size: 9px;
    font-weight: 800;

    text-decoration: none !important;
}


/* ANIMATION */

[data-haki-reveal] {
    opacity: 0;
    transform: translateY(20px);

    transition:
        opacity .62s cubic-bezier(.2,.7,.2,1),
        transform .62s cubic-bezier(.2,.7,.2,1);

    transition-delay: var(--delay,0ms);
}

[data-haki-reveal].visible {
    opacity: 1;
    transform: translateY(0);
}


/* TABLET */

@media (max-width: 1024px) {
    .haki-container {
        width: min(calc(100% - 36px),1080px);
    }

    .haki-hero-grid {
        grid-template-columns: 1fr 290px;
        gap: 32px;
    }

    .haki-work-grid {
        grid-template-columns: repeat(2,minmax(0,1fr));
    }

    .haki-pick,
    .haki-pick.center-left,
    .haki-pick.center-right {
        grid-column: auto;
    }

    .haki-pick:last-child {
        grid-column: 1 / -1;
        width: calc(50% - 9px);
        justify-self: center;
    }
}


/* MOBILE */

@media (max-width: 767px) {
    .haki-container {
        width: calc(100% - 28px);
    }

    .haki-hero {
        padding: 50px 0 52px;
    }

    .haki-hero-grid,
    .haki-education-grid,
    .haki-summary-grid,
    .haki-benefit {
        grid-template-columns: 1fr;
    }

    .haki-hero-grid {
        gap: 26px;
    }

    .haki-hero h1 {
        font-size: clamp(36px,11vw,48px);
    }

    .haki-content {
        padding: 44px 0 66px;
    }

    .haki-section {
        margin-bottom: 44px;
    }

    .haki-work-section {
        margin-bottom: 44px;
        padding: 28px 16px;
    }

    .haki-section-head.center {
        text-align: left;
    }

    .haki-work-grid {
        grid-template-columns: 1fr;
    }

    .haki-pick,
    .haki-pick.center-left,
    .haki-pick.center-right,
    .haki-pick:last-child {
        grid-column: auto;
        width: 100%;
    }

    .haki-journal {
        grid-template-columns: auto 1fr;
    }

    .haki-journal-action {
        grid-column: 1 / -1;
        text-align: right;
    }

    .haki-benefit {
        gap: 22px;
        padding: 22px;
    }

    .haki-cta {
        padding: 36px 21px;
    }

    .haki-bar-copy strong {
        max-width: 170px;
    }
}


/* REDUCED MOTION */

@media (prefers-reduced-motion: reduce) {
    [data-haki-reveal] {
        opacity: 1;
        transform: none;
        transition: none;
    }
}
</style>


<div class="haki-page">

    <section class="haki-hero">
        <div class="haki-container">
            <div class="haki-hero-grid">

                <div>
                    <div class="haki-eyebrow" data-haki-reveal>
                        Layanan HAKI Baca Dulu
                    </div>

                    <h1 data-haki-reveal style="--delay:60ms">
                        Lindungi karya akademik
                        <span>secara lebih pasti.</span>
                    </h1>

                    <p class="haki-hero-description" data-haki-reveal style="--delay:120ms">
                        Pendampingan pendaftaran Hak Atas Kekayaan Intelektual untuk buku akademik,
                        karya ilmiah, dan jurnal dengan proses yang lebih terarah, jelas, dan profesional.
                    </p>
                </div>

                <aside class="haki-hero-card" data-haki-reveal style="--delay:180ms">
                    <div class="haki-hero-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3l7 3v5c0 4.6-2.9 8.7-7 10-4.1-1.3-7-5.4-7-10V6l7-3z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>

                    <small>Perlindungan karya</small>

                    <h3>Hak Cipta Buku & Jurnal</h3>

                    <p>
                        Pendampingan pencatatan karya tulis berdasarkan perlindungan hak cipta
                        dalam UU No. 28 Tahun 2014.
                    </p>
                </aside>

            </div>
        </div>
    </section>


    <main class="haki-content">
        <div class="haki-container">

            <section class="haki-section">

                <header class="haki-section-head" data-haki-reveal>
                    <span class="haki-label">Memahami perlindungan</span>

                    <h2>Hak cipta bukan sekadar sertifikat.</h2>

                    <p>
                        Perlindungan karya mencakup hak yang melekat pada pencipta
                        sekaligus hak untuk memperoleh manfaat dari karya tersebut.
                    </p>
                </header>


                <div class="haki-education-grid">

                    <article class="haki-card" data-haki-reveal>

                        <div class="haki-card-head">
                            <div class="haki-card-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 3v18"/>
                                    <path d="M7 8l5-5 5 5"/>
                                    <path d="M3 8l4-3 4 3-4 8-4-8z"/>
                                    <path d="M13 8l4-3 4 3-4 8-4-8z"/>
                                </svg>
                            </div>

                            <h3>Ruang Lingkup Hak Cipta</h3>
                        </div>

                        <p>
                            Hak cipta melindungi pencipta melalui hak moral dan hak ekonomi.
                        </p>

                        <div class="haki-detail">
                            <h4>Hak Moral</h4>

                            <p>
                                Hak yang melekat pada diri penulis dan menjamin identitas pencipta
                                tetap diakui pada karya.
                            </p>
                        </div>

                        <div class="haki-detail">
                            <h4>Hak Ekonomi</h4>

                            <p>
                                Hak eksklusif untuk memperoleh manfaat ekonomi dari karya.
                            </p>

                            <ul>
                                <li>Hak penerbitan dan produksi karya.</li>
                                <li>Hak penggandaan buku, naskah, atau artikel.</li>
                                <li>Hak distribusi dan penerjemahan karya.</li>
                            </ul>
                        </div>

                    </article>


                    <article class="haki-card" data-haki-reveal style="--delay:70ms">

                        <div class="haki-card-head">
                            <div class="haki-card-icon gold">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 3l7 3v5c0 4.6-2.9 8.7-7 10-4.1-1.3-7-5.4-7-10V6l7-3z"/>
                                    <path d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>

                            <h3>Legalitas Penunjang</h3>
                        </div>

                        <p>
                            Identitas dan perlindungan tambahan yang memperkuat posisi sebuah publikasi.
                        </p>

                        <div class="haki-detail">
                            <h4>Perwajahan Karya Tulis</h4>
                            <p>Tata letak dan desain isi buku atau jurnal menjadi bagian penting dari identitas karya.</p>
                        </div>

                        <div class="haki-detail">
                            <h4>ISBN / e-ISSN</h4>
                            <p>Identitas publikasi yang membantu karya dikenali dan ditelusuri.</p>
                        </div>

                        <div class="haki-detail">
                            <h4>Hak Merek</h4>
                            <p>Perlindungan nama, identitas, atau logo penerbit maupun badan usaha.</p>
                        </div>

                    </article>

                </div>


                @php
                    $ringkasan = [
                        [
                            'judul' => 'Hak Cipta',
                            'desc' => 'Melindungi hak moral dan hak ekonomi yang melekat pada pencipta.',
                            'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                        ],
                        [
                            'judul' => 'ISBN / e-ISSN',
                            'desc' => 'Identitas publikasi untuk buku maupun jurnal agar dapat ditelusuri secara resmi.',
                            'icon' => 'M7 7h10M7 11h10M7 15h6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z'
                        ],
                        [
                            'judul' => 'Hak Merek',
                            'desc' => 'Perlindungan nama atau logo yang digunakan sebagai identitas penerbit.',
                            'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5.586 5.586a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z'
                        ]
                    ];
                @endphp


                <div class="haki-summary-grid">
                    @foreach($ringkasan as $r)

                        <article class="haki-summary" data-haki-reveal">

                            <div class="haki-summary-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="{{ $r['icon'] }}"/>
                                </svg>
                            </div>

                            <h3>{{ $r['judul'] }}</h3>

                            <p>{{ $r['desc'] }}</p>

                        </article>

                    @endforeach
                </div>

            </section>


            <section class="haki-work-section">

                <header class="haki-section-head center" data-haki-reveal>

                    <span class="haki-label">Mulai konsultasi</span>

                    <h2>Pilih jenis karya akademik Anda.</h2>

                    <p>
                        Pilih salah satu jenis karya berikut. Setelah dipilih,
                        Anda dapat langsung melanjutkan konsultasi melalui WhatsApp.
                    </p>

                </header>


                @php
                    $jenisKarya = [
                        [
                            'label' => 'Buku Ajar / Buku Teks',
                            'slug' => 'buku-ajar',
                            'desc' => 'Buku pembelajaran yang disusun sesuai kurikulum, mata kuliah, atau RPS.'
                        ],
                        [
                            'label' => 'Buku Referensi',
                            'slug' => 'buku-referensi',
                            'desc' => 'Kajian ilmiah komprehensif yang digunakan sebagai rujukan akademik.'
                        ],
                        [
                            'label' => 'Monograf',
                            'slug' => 'monograf',
                            'desc' => 'Karya ilmiah yang membahas satu topik atau hasil penelitian secara mendalam.'
                        ],
                        [
                            'label' => 'Book Chapter / Bunga Rampai',
                            'slug' => 'book-chapter',
                            'desc' => 'Kumpulan tulisan beberapa penulis dalam satu tema atau rumpun pembahasan.'
                        ],
                        [
                            'label' => 'Modul / Panduan Praktikum',
                            'slug' => 'modul-praktikum',
                            'desc' => 'Panduan pembelajaran atau kegiatan praktis yang disusun secara sistematis.'
                        ]
                    ];
                @endphp


                <div class="haki-work-grid">

                    @foreach($jenisKarya as $index => $jk)

                        @php
                            $positionClass = '';

                            if ($index === 3) {
                                $positionClass = 'center-left';
                            }

                            if ($index === 4) {
                                $positionClass = 'center-right';
                            }
                        @endphp


                        <article
                            class="haki-pick {{ $positionClass }}"
                            role="button"
                            tabindex="0"
                            aria-pressed="false"
                            data-label="{{ $jk['label'] }}"
                            data-slug="{{ $jk['slug'] }}"
                            data-haki-reveal
                        >

                            <span class="haki-pick-number">
                                {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <span class="haki-check">✓</span>

                            <div class="haki-pick-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 6.253v13"/>
                                    <path d="M12 6.253C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                    <path d="M12 6.253C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18S13.168 18.477 12 19.253"/>
                                </svg>
                            </div>

                            <h3>{{ $jk['label'] }}</h3>

                            <p>{{ $jk['desc'] }}</p>

                        </article>

                    @endforeach

                </div>


                <article
                    class="haki-pick haki-journal"
                    role="button"
                    tabindex="0"
                    aria-pressed="false"
                    data-label="Jurnal Ilmiah"
                    data-slug="jurnal"
                    data-haki-reveal
                >

                    <span class="haki-check">✓</span>

                    <div class="haki-journal-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 4h10a2 2 0 012 2v12a2 2 0 002 2"/>
                            <path d="M5 4a2 2 0 00-2 2v12a2 2 0 002 2h16"/>
                            <path d="M7 8h6M7 12h6M7 16h4"/>
                        </svg>
                    </div>

                    <div>
                        <small>Publikasi ilmiah</small>

                        <h3>Jurnal Ilmiah</h3>

                        <p>
                            Jalur konsultasi pendaftaran HAKI untuk artikel jurnal
                            dari berbagai bidang ilmu.
                        </p>
                    </div>

                    <span class="haki-journal-action">
                        Pilih Jurnal →
                    </span>

                </article>

            </section>


            <section class="haki-section haki-benefit" data-haki-reveal>

                <div class="haki-benefit-copy">

                    <span class="haki-label">Manfaat akademik</span>

                    <h2>Mengapa karya akademik perlu dicatatkan?</h2>

                    <p>
                        Pendaftaran HAKI membantu memperkuat bukti kepemilikan karya
                        sekaligus mendukung dokumentasi portofolio akademik.
                    </p>

                </div>


                @php
                    $keuntungan = [
                        'Memberikan legalitas dan bukti perlindungan karya.',
                        'Mendukung dokumentasi portofolio akademik dan profesional.',
                        'Proses konsultasi lebih terarah hingga tahap pengajuan.'
                    ];
                @endphp


                <div class="haki-benefit-list">

                    @foreach($keuntungan as $k)

                        <div class="haki-benefit-item">

                            <span class="haki-benefit-check">✓</span>

                            <p>{{ $k }}</p>

                        </div>

                    @endforeach

                </div>

            </section>


            <section class="haki-cta" data-haki-reveal>

                <div class="haki-cta-inner">

                    <small>Konsultasi HAKI</small>

                    <h2>Sudah memiliki naskah yang siap didaftarkan?</h2>

                    <p>
                        Konsultasikan jenis karya, kebutuhan dokumen,
                        dan proses pengajuan bersama tim Baca Dulu.
                    </p>

                    <a
                        href="https://wa.me/6285139461070?text={{ urlencode('Halo Baca Dulu, saya ingin berkonsultasi mengenai pendaftaran HAKI.') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="haki-cta-button"
                    >
                        Konsultasi via WhatsApp →
                    </a>

                </div>

            </section>

        </div>
    </main>

</div>


<div id="pilihan-bar" class="haki-bar">

    <div class="haki-bar-inner">

        <div class="haki-bar-copy">
            <small>Kategori dipilih</small>
            <strong id="pilihan-label">-</strong>
        </div>

        <a
            id="pilihan-wa"
            href="https://wa.me/6285139461070"
            target="_blank"
            rel="noopener noreferrer"
            class="haki-bar-button"
        >
            Lanjut Konsultasi
        </a>

    </div>

</div>


<script>
(() => {
    const initHaki = () => {
        const page = document.querySelector('.haki-page');

        if (!page || page.dataset.ready === '1') {
            return;
        }

        page.dataset.ready = '1';

        const reduceMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        const reveals = page.querySelectorAll('[data-haki-reveal]');

        if (
            reduceMotion ||
            !('IntersectionObserver' in window)
        ) {
            reveals.forEach(el => {
                el.classList.add('visible');
            });
        } else {
            const observer = new IntersectionObserver(
                entries => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    });
                },
                {
                    threshold: .12,
                    rootMargin: '0px 0px -5% 0px'
                }
            );

            reveals.forEach(el => {
                observer.observe(el);
            });
        }

        const cards = page.querySelectorAll('.haki-pick');
        const bar = document.getElementById('pilihan-bar');
        const label = document.getElementById('pilihan-label');
        const waButton = document.getElementById('pilihan-wa');

        const waNumber = '6285139461070';

        if (!bar || !label || !waButton) {
            return;
        }

        const selectCard = card => {
            const alreadySelected =
                card.classList.contains('is-selected');

            cards.forEach(item => {
                item.classList.remove('is-selected');
                item.setAttribute('aria-pressed', 'false');
            });

            if (alreadySelected) {
                label.textContent = '-';
                bar.classList.remove('show');
                return;
            }

            card.classList.add('is-selected');
            card.setAttribute('aria-pressed', 'true');

            const text =
                card.dataset.label || 'HAKI';

            label.textContent = text;

            const message =
                'Halo Baca Dulu, saya ingin konsultasi pendaftaran HAKI untuk ' +
                text +
                '.';

            waButton.href =
                'https://wa.me/' +
                waNumber +
                '?text=' +
                encodeURIComponent(message);

            bar.classList.add('show');
        };

        cards.forEach(card => {
            card.addEventListener('click', () => {
                selectCard(card);
            });

            card.addEventListener('keydown', event => {
                if (
                    event.key !== 'Enter' &&
                    event.key !== ' '
                ) {
                    return;
                }

                event.preventDefault();
                selectCard(card);
            });
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initHaki,
            { once: true }
        );
    } else {
        initHaki();
    }
})();
</script>

@endsection