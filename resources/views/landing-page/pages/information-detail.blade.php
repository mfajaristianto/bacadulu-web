@extends('layouts.app')

@section('title', $information->title . ' - Baca Dulu')

@section('content')

@php
    $publishedDate = $information->created_at
        ? $information->created_at
            ->timezone('Asia/Jakarta')
            ->translatedFormat('d F Y')
        : null;

    $hasImage = !empty($information->image);
    $isPinned = (bool) ($information->is_pinned ?? false);

    $titleLength = mb_strlen(trim($information->title));

    $titleSizeClass = match (true) {
        $titleLength >= 120 => 'is-extreme',
        $titleLength >= 75 => 'is-long',
        $titleLength >= 45 => 'is-medium',
        default => '',
    };
@endphp

<style>
.bd-detail {
    --navy: #241B52;
    --orange-dark: #C94F35;
    --orange: #D96A2B;
    --amber: #E58A2B;
    --gold: #F0A52E;
    --yellow: #F2C94C;

    --ink: #29292F;
    --body: #555A63;
    --muted: #858A93;
    --soft-text: #A0A3AA;

    --white: #FFFFFF;
    --warm: #FFFCF8;
    --cream: #FFF7ED;
    --soft: #F7F7F7;
    --border: #E9E3DD;

    min-height: 100vh;
    overflow-x: hidden;
    color: var(--ink);
    background: var(--white);
    font-family: 'Inter', sans-serif;
}

.bd-detail *,
.bd-detail *::before,
.bd-detail *::after {
    box-sizing: border-box;
}

.bd-detail a {
    text-decoration: none;
}

.bd-detail button {
    font-family: inherit;
}

.bd-detail-container {
    width: min(calc(100% - 40px), 980px);
    margin-inline: auto;
}


/* =========================================================
   READING PROGRESS
========================================================= */

.bd-detail-progress {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    pointer-events: none;
}

.bd-detail-progress-bar {
    width: 0;
    height: 100%;
    background: linear-gradient(
        90deg,
        var(--orange-dark),
        var(--orange),
        var(--gold)
    );
}


/* =========================================================
   TOP NAV
========================================================= */

.bd-detail-nav {
    position: relative;
    z-index: 20;
    border-bottom: 1px solid #EFEAE5;
    background: rgba(255,255,255,.96);
    backdrop-filter: blur(12px);
}

.bd-detail-nav-inner {
    min-height: 62px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.bd-detail-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    min-height: 36px;
    padding: 0 12px;

    border: 1px solid #E5DFD9;
    border-radius: 9px;

    color: var(--navy) !important;
    background: #FFFFFF;

    font-size: 10px;
    font-weight: 750;

    box-shadow: 0 3px 10px rgba(36,27,82,.035);

    transition:
        transform .25s ease,
        color .25s ease,
        border-color .25s ease,
        background .25s ease;
}

.bd-detail-back svg {
    width: 13px;
    height: 13px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.9;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: transform .25s ease;
}

.bd-detail-back:hover {
    color: var(--orange) !important;
    border-color: rgba(217,106,43,.32);
    background: #FFF9F3;
    transform: translateY(-1px);
}

.bd-detail-back:hover svg {
    transform: translateX(-3px);
}

.bd-detail-nav-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    color: var(--soft-text);

    font-size: 7px;
    font-weight: 800;
    letter-spacing: .11em;
    text-transform: uppercase;
}

.bd-detail-nav-status::before {
    content: "";
    width: 5px;
    height: 5px;
    flex-shrink: 0;
    border-radius: 50%;

    background: linear-gradient(
        135deg,
        var(--orange),
        var(--gold)
    );
}


/* =========================================================
   HERO
========================================================= */

.bd-detail-hero {
    position: relative;
    overflow: hidden;
    padding: 38px 0 36px;

    background:
        radial-gradient(
            circle at 96% 7%,
            rgba(240,165,46,.10),
            transparent 24%
        ),
        radial-gradient(
            circle at 2% 100%,
            rgba(217,106,43,.045),
            transparent 24%
        ),
        #FFFFFF;
}

.bd-detail-hero::after {
    content: "";
    position: absolute;
    width: 210px;
    height: 210px;
    right: -125px;
    top: -125px;

    border: 1px solid rgba(36,27,82,.05);
    border-radius: 50%;

    pointer-events: none;
}

.bd-detail-hero-grid {
    position: relative;
    z-index: 2;

    display: grid;
    grid-template-columns: minmax(0,1fr) 300px;
    align-items: center;
    gap: 42px;
}

.bd-detail-hero-grid.no-image {
    grid-template-columns: minmax(0,720px);
}


/* =========================================================
   HERO COPY
========================================================= */

.bd-detail-copy {
    position: relative;
    min-width: 0;
    padding-left: 17px;
}

.bd-detail-copy::before {
    content: "";
    position: absolute;
    top: 3px;
    bottom: 3px;
    left: 0;
    width: 3px;

    border-radius: 999px;

    background: linear-gradient(
        180deg,
        var(--orange-dark),
        var(--orange),
        var(--gold)
    );
}


/* META */

.bd-detail-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    margin-bottom: 12px;
}

.bd-detail-category,
.bd-detail-pinned {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    min-height: 25px;
    padding: 0 9px;

    border-radius: 999px;

    font-size: 7px;
    font-weight: 850;
    letter-spacing: .09em;
    text-transform: uppercase;
}

.bd-detail-category {
    border: 1px solid rgba(217,106,43,.16);
    color: var(--orange);
    background: #FFF7EF;
}

.bd-detail-pinned {
    border: 1px solid rgba(240,165,46,.20);
    color: #A76613;
    background: #FFF7DF;
}

.bd-detail-pinned svg {
    width: 10px;
    height: 10px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.9;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.bd-detail-meta-dot {
    width: 4px;
    height: 4px;
    flex: 0 0 4px;
    border-radius: 50%;
    background: var(--gold);
}

.bd-detail-date {
    color: var(--muted);
    font-size: 9px;
    font-weight: 600;
}


/* =========================================================
   TITLE
========================================================= */

.bd-detail-title {
    width: 100%;
    max-width: 620px;
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;
    font-size: clamp(31px,3.4vw,42px);
    font-weight: 700;
    line-height: 1.12;
    letter-spacing: -.038em;

    overflow-wrap: anywhere;
    word-break: break-word;
    white-space: normal;
}

.bd-detail-title.is-medium {
    font-size: clamp(28px,3vw,37px);
    line-height: 1.14;
}

.bd-detail-title.is-long {
    font-size: clamp(24px,2.6vw,32px);
    line-height: 1.17;
    letter-spacing: -.025em;
}

.bd-detail-title.is-extreme {
    font-size: clamp(21px,2.2vw,27px);
    line-height: 1.2;
    letter-spacing: -.015em;
}


/* =========================================================
   HERO SHARE
========================================================= */

.bd-detail-hero-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 18px;
}

.bd-detail-share {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 37px;
    padding: 0 11px;

    border: 1px solid #E5DFDA;
    border-radius: 9px;

    color: var(--navy);
    background: #FFFFFF;

    font-size: 9px;
    font-weight: 750;

    cursor: pointer;

    transition:
        transform .25s ease,
        color .25s ease,
        border-color .25s ease,
        background .25s ease,
        box-shadow .25s ease;
}

.bd-detail-share-icon {
    width: 23px;
    height: 23px;

    display: grid;
    place-items: center;

    border-radius: 6px;

    color: var(--orange);
    background: #FFF3E9;
}

.bd-detail-share svg {
    width: 12px;
    height: 12px;

    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.bd-detail-share:hover {
    color: #FFFFFF;
    border-color: var(--orange);

    background: linear-gradient(
        105deg,
        var(--orange-dark),
        var(--orange)
    );

    box-shadow: 0 8px 18px rgba(217,106,43,.16);
    transform: translateY(-2px);
}

.bd-detail-share:hover .bd-detail-share-icon {
    color: #FFFFFF;
    background: rgba(255,255,255,.16);
}


/* =========================================================
   HERO IMAGE
========================================================= */

.bd-detail-media-wrap {
    position: relative;
    width: 100%;
    max-width: 300px;
    justify-self: end;
    padding: 8px 8px 0 0;
}

.bd-detail-media-wrap::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;

    width: 52px;
    height: 52px;

    border-top: 2px solid var(--orange);
    border-right: 2px solid var(--gold);
    border-radius: 0 13px 0 0;

    opacity: .75;
}

.bd-detail-media-wrap::after {
    content: "";
    position: absolute;
    right: -5px;
    bottom: -5px;

    width: 56px;
    height: 56px;

    background:
        radial-gradient(
            circle,
            rgba(36,27,82,.13) 1px,
            transparent 1.5px
        );

    background-size: 9px 9px;
    opacity: .62;
}

.bd-detail-media {
    position: relative;
    z-index: 2;

    width: 100%;
    aspect-ratio: 4 / 3;

    overflow: hidden;

    border: 1px solid #EEE8E2;
    border-radius: 13px;

    background: var(--soft);
    box-shadow: 0 13px 30px rgba(36,27,82,.065);
}

.bd-detail-image {
    position: absolute;
    z-index: 2;
    inset: 0;

    width: 100%;
    height: 100%;
    display: block;

    object-fit: cover;

    transition:
        transform .7s
        cubic-bezier(.22,1,.36,1);
}

.bd-detail-media:hover .bd-detail-image {
    transform: scale(1.035);
}

.bd-detail-fallback {
    position: absolute;
    inset: 0;

    display: grid;
    place-items: center;

    background: linear-gradient(
        135deg,
        var(--navy),
        #17132F
    );
}

.bd-detail-fallback-inner {
    display: flex;
    align-items: center;
    gap: 8px;

    color: #FFFFFF;

    font-size: 8px;
    font-weight: 850;
    letter-spacing: .13em;
    text-transform: uppercase;
}

.bd-detail-fallback-mark {
    width: 8px;
    height: 8px;
    transform: rotate(45deg);
    background: var(--gold);
}


/* =========================================================
   SEPARATOR
========================================================= */

.bd-detail-separator {
    position: relative;
    height: 1px;
    background: #EFEAE5;
}

.bd-detail-separator::before {
    content: "";
    position: absolute;
    top: -1px;
    left: 50%;

    width: 46px;
    height: 3px;

    border-radius: 999px;

    transform: translateX(-50%);

    background: linear-gradient(
        90deg,
        var(--orange),
        var(--gold)
    );
}


/* =========================================================
   ARTICLE
========================================================= */

.bd-detail-reading {
    padding: 42px 0 58px;
}

.bd-detail-reading-inner {
    width: min(calc(100% - 32px),700px);
    margin-inline: auto;
}

.bd-detail-content {
    width: 100%;
    min-width: 0;
    max-width: 100%;

    color: var(--body);

    font-size: 15px;
    line-height: 1.86;

    overflow-wrap: anywhere;
    word-break: break-word;
}

.bd-detail-content *,
.bd-detail-content > * {
    min-width: 0 !important;
    max-width: 100% !important;
    overflow-wrap: anywhere !important;
    word-break: break-word !important;
}

.bd-detail-content p,
.bd-detail-content div,
.bd-detail-content span,
.bd-detail-content section,
.bd-detail-content article {
    white-space: normal !important;
}

.bd-detail-content p {
    margin: 0 0 21px;
}

.bd-detail-content > p:first-child {
    color: #363940;
    font-size: 16px;
    line-height: 1.82;
}


/* HEADINGS */

.bd-detail-content h1,
.bd-detail-content h2,
.bd-detail-content h3,
.bd-detail-content h4,
.bd-detail-content h5,
.bd-detail-content h6 {
    clear: both;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    line-height: 1.32;

    letter-spacing: -.025em;
}

.bd-detail-content h1 {
    margin: 42px 0 14px;
    font-size: 28px;
}

.bd-detail-content h2 {
    margin: 37px 0 14px;
    font-size: 24px;
}

.bd-detail-content h3 {
    margin: 31px 0 12px;
    font-size: 20px;
}

.bd-detail-content h4 {
    margin: 27px 0 10px;
    font-size: 17px;
}


/* LIST */

.bd-detail-content ul,
.bd-detail-content ol {
    margin: 0 0 22px;
    padding-left: 22px;
}

.bd-detail-content ul {
    list-style: disc;
}

.bd-detail-content ol {
    list-style: decimal;
}

.bd-detail-content li {
    margin-bottom: 7px;
}


/* LINK */

.bd-detail-content a {
    color: var(--orange) !important;
    text-decoration: underline;
    text-decoration-thickness: 1px;
    text-underline-offset: 4px;
}


/* BLOCKQUOTE */

.bd-detail-content blockquote {
    clear: both;

    margin: 29px 0;
    padding: 4px 0 4px 17px;

    border-left: 3px solid var(--orange);

    color: var(--navy);

    font-family: 'Poppins', sans-serif;
    font-size: 17px;
    font-weight: 500;
    line-height: 1.58;
}

.bd-detail-content blockquote p {
    margin: 0;
}


/* IMAGE */

.bd-detail-content img {
    display: block !important;
    float: none !important;

    width: auto !important;
    max-width: 100% !important;

    height: auto !important;
    max-height: 500px;

    margin: 27px auto !important;

    border-radius: 12px;
    object-fit: contain;
}


/* FIGURE */

.bd-detail-content figure {
    float: none !important;
    clear: both;

    width: 100% !important;
    max-width: 100% !important;

    margin: 28px 0 !important;
}

.bd-detail-content figure img {
    margin: 0 auto !important;
}

.bd-detail-content figcaption {
    margin-top: 8px;

    color: #969AA2;

    font-size: 9px;
    line-height: 1.6;
    text-align: center;
}


/* VIDEO */

.bd-detail-content iframe,
.bd-detail-content video {
    display: block;
    float: none !important;
    clear: both;

    width: 100% !important;
    max-width: 100% !important;
    min-height: 340px;

    margin: 28px 0;

    border: 0;
    border-radius: 12px;
}


/* TABLE */

.bd-detail-content table {
    display: block;
    clear: both;

    width: 100% !important;
    max-width: 100% !important;

    overflow-x: auto;

    margin: 28px 0;

    border-collapse: collapse;

    font-size: 12px;
}

.bd-detail-content th,
.bd-detail-content td {
    padding: 10px;
    border-bottom: 1px solid var(--border);
    text-align: left;
    vertical-align: top;
}

.bd-detail-content th {
    color: var(--navy);
    font-weight: 800;
}


/* CODE */

.bd-detail-content pre {
    clear: both;

    max-width: 100%;
    overflow-x: auto;

    margin: 27px 0;
    padding: 15px;

    border: 1px solid var(--border);
    border-radius: 10px;

    background: var(--soft);

    white-space: pre-wrap;
    word-break: break-word;
}


/* =========================================================
   END ARTICLE CTA
========================================================= */

.bd-detail-after {
    position: relative;

    margin-top: 40px;
    padding: 18px;

    overflow: hidden;

    border: 1px solid #EBE1D6;
    border-radius: 13px;

    background:
        radial-gradient(
            circle at 100% 0,
            rgba(240,165,46,.12),
            transparent 32%
        ),
        linear-gradient(
            135deg,
            #FFFDF9,
            #FFF7ED
        );
}

.bd-detail-after::before {
    content: "";

    position: absolute;
    top: 0;
    left: 0;

    width: 100%;
    height: 3px;

    background: linear-gradient(
        90deg,
        var(--orange-dark),
        var(--orange),
        var(--gold)
    );
}

.bd-detail-after-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
}

.bd-detail-after-copy {
    min-width: 0;
}

.bd-detail-after-label {
    display: block;
    margin-bottom: 3px;

    color: var(--orange);

    font-size: 7px;
    font-weight: 850;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.bd-detail-after h3 {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 700;
}

.bd-detail-after p {
    max-width: 350px;

    margin: 4px 0 0;

    color: var(--muted);

    font-size: 8px;
    line-height: 1.55;
}


/* =========================================================
   BOTTOM ACTIONS
========================================================= */

.bd-detail-actions {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    gap: 7px;
}

.bd-detail-more,
.bd-detail-top {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 38px;
    padding: 0 12px;

    border-radius: 9px;

    font-size: 8px;
    font-weight: 800;

    cursor: pointer;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        color .25s ease,
        border-color .25s ease,
        background .25s ease;
}


/* PRIMARY */

.bd-detail-more {
    border: 0;

    color: #FFFFFF !important;

    background: linear-gradient(
        105deg,
        var(--orange-dark),
        var(--orange),
        var(--gold)
    );

    background-size: 170% 100%;

    box-shadow:
        0 8px 18px
        rgba(217,106,43,.17);
}

.bd-detail-more:hover {
    transform: translateY(-2px);

    box-shadow:
        0 11px 22px
        rgba(217,106,43,.22);
}

.bd-detail-more svg {
    transition: transform .25s ease;
}

.bd-detail-more:hover svg {
    transform: translateX(2px);
}


/* SECONDARY */

.bd-detail-top {
    border: 1px solid #E2DCD5;

    color: var(--navy);

    background: rgba(255,255,255,.76);
}

.bd-detail-top:hover {
    color: var(--orange);

    border-color:
        rgba(217,106,43,.30);

    background: #FFFFFF;

    transform: translateY(-2px);
}

.bd-detail-more svg,
.bd-detail-top svg {
    width: 11px;
    height: 11px;

    fill: none;
    stroke: currentColor;
    stroke-width: 1.9;

    stroke-linecap: round;
    stroke-linejoin: round;
}

.bd-detail-top svg {
    transition: transform .25s ease;
}

.bd-detail-top:hover svg {
    transform: translateY(-2px);
}


/* =========================================================
   SHARE TOAST
========================================================= */

.bd-detail-toast {
    position: fixed;
    z-index: 9999;

    right: 18px;
    bottom: 18px;

    display: flex;
    align-items: center;
    gap: 7px;

    padding: 9px 12px;

    border-radius: 8px;

    color: #FFFFFF;
    background: var(--navy);

    font-size: 9px;
    font-weight: 650;

    box-shadow:
        0 12px 28px
        rgba(36,27,82,.18);

    opacity: 0;
    transform: translateY(12px);

    pointer-events: none;
}

.bd-detail-toast-dot {
    width: 5px;
    height: 5px;
    flex: 0 0 5px;

    border-radius: 50%;

    background: var(--gold);
}


/* =========================================================
   MOTION
========================================================= */

.bd-detail-reveal {
    opacity: 0;
    transform: translateY(14px);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 860px) {
    .bd-detail-hero-grid {
        grid-template-columns: minmax(0,1fr) 260px;
        gap: 28px;
    }

    .bd-detail-media-wrap {
        max-width: 260px;
    }

    .bd-detail-title {
        font-size: clamp(29px,4vw,37px);
    }

    .bd-detail-title.is-medium {
        font-size: clamp(27px,3.6vw,33px);
    }

    .bd-detail-title.is-long {
        font-size: clamp(23px,3.1vw,28px);
    }

    .bd-detail-title.is-extreme {
        font-size: clamp(20px,2.7vw,25px);
    }
}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 700px) {
    .bd-detail-container {
        width: calc(100% - 32px);
    }

    .bd-detail-hero-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }

    .bd-detail-media-wrap {
        width: min(100%,460px);
        max-width: none;
        justify-self: start;
    }

    .bd-detail-media {
        aspect-ratio: 16 / 9;
    }

    .bd-detail-after-inner {
        align-items: flex-start;
        flex-direction: column;
        gap: 13px;
    }
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 640px) {
    .bd-detail-container,
    .bd-detail-reading-inner {
        width: calc(100% - 28px);
    }

    .bd-detail-nav-inner {
        min-height: 58px;
    }

    .bd-detail-nav-status {
        display: none;
    }

    .bd-detail-back {
        min-height: 35px;
        padding: 0 10px;
        font-size: 9px;
    }

    .bd-detail-hero {
        padding: 27px 0 28px;
    }

    .bd-detail-copy {
        padding-left: 13px;
    }

    .bd-detail-copy::before {
        width: 2px;
    }

    .bd-detail-category,
    .bd-detail-pinned {
        min-height: 24px;
        font-size: 6.5px;
    }

    .bd-detail-date {
        font-size: 8px;
    }

    .bd-detail-title {
        font-size: clamp(27px,8vw,33px);
        line-height: 1.13;
    }

    .bd-detail-title.is-medium {
        font-size: clamp(25px,7vw,30px);
    }

    .bd-detail-title.is-long {
        font-size: clamp(22px,6vw,26px);
        line-height: 1.17;
    }

    .bd-detail-title.is-extreme {
        font-size: clamp(19px,5.3vw,23px);
        line-height: 1.2;
    }

    .bd-detail-hero-actions {
        margin-top: 15px;
    }

    .bd-detail-share {
        min-height: 36px;
        font-size: 8px;
    }

    .bd-detail-media-wrap {
        width: 100%;
    }

    .bd-detail-media {
        aspect-ratio: 16 / 9;
        border-radius: 11px;
    }

    .bd-detail-reading {
        padding: 32px 0 46px;
    }

    .bd-detail-content {
        font-size: 14px;
        line-height: 1.83;
    }

    .bd-detail-content > p:first-child {
        font-size: 15px;
    }

    .bd-detail-content h1 {
        font-size: 24px;
    }

    .bd-detail-content h2 {
        margin-top: 33px;
        font-size: 22px;
    }

    .bd-detail-content h3 {
        font-size: 18px;
    }

    .bd-detail-content blockquote {
        font-size: 16px;
    }

    .bd-detail-content iframe,
    .bd-detail-content video {
        min-height: 205px;
    }

    .bd-detail-after {
        margin-top: 34px;
        padding: 15px;
    }

    .bd-detail-after h3 {
        font-size: 14px;
    }

    .bd-detail-after p {
        font-size: 8px;
    }

    .bd-detail-actions {
        width: 100%;
        align-items: stretch;
        flex-direction: column;
    }

    .bd-detail-more,
    .bd-detail-top {
        width: 100%;
        min-height: 42px;
    }
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {
    .bd-detail-reveal {
        opacity: 1 !important;
        transform: none !important;
    }

    .bd-detail-image,
    .bd-detail-back,
    .bd-detail-share,
    .bd-detail-more,
    .bd-detail-top {
        transition: none !important;
    }
}
</style>


<div class="bd-detail" id="bdInformationDetail">

    {{-- Reading Progress --}}
    <div class="bd-detail-progress">
        <div
            class="bd-detail-progress-bar"
            id="bdDetailProgress"
        ></div>
    </div>


    {{-- =====================================================
         TOP NAV
    ====================================================== --}}
    <nav class="bd-detail-nav">
        <div class="bd-detail-container">

            <div class="bd-detail-nav-inner">

                <a
                    href="{{ route('informasi') }}"
                    class="bd-detail-back bd-detail-reveal"
                >
                    <svg viewBox="0 0 24 24">
                        <path d="M19 12H5"/>
                        <path d="m10 7-5 5 5 5"/>
                    </svg>

                    Kembali ke Informasi
                </a>


                <span class="bd-detail-nav-status bd-detail-reveal">
                    Detail Informasi
                </span>

            </div>

        </div>
    </nav>


    {{-- =====================================================
         HERO
    ====================================================== --}}
    <header class="bd-detail-hero">

        <div class="bd-detail-container">

            <div class="bd-detail-hero-grid {{ !$hasImage ? 'no-image' : '' }}">

                {{-- Copy --}}
                <div class="bd-detail-copy">

                    <div class="bd-detail-meta bd-detail-reveal">

                        @if($isPinned)
                            <span class="bd-detail-pinned">
                                <svg viewBox="0 0 24 24">
                                    <path d="M14 4l6 6-3 1-4 4-1 5-3-3-4 4-2-2 4-4-3-3 5-1 4-4z"/>
                                </svg>

                                Informasi Pilihan
                            </span>
                        @else
                            <span class="bd-detail-category">
                                Informasi
                            </span>
                        @endif


                        @if($publishedDate)
                            <span class="bd-detail-meta-dot"></span>

                            <time
                                class="bd-detail-date"
                                datetime="{{ $information->created_at->toDateString() }}"
                            >
                                {{ $publishedDate }}
                            </time>
                        @endif

                    </div>


                    <h1
                        class="bd-detail-title {{ $titleSizeClass }}"
                        id="bdDetailTitle"
                    >
                        {{ $information->title }}
                    </h1>


                    {{-- SHARE HANYA SATU --}}
                    <div class="bd-detail-hero-actions bd-detail-reveal">

                        <button
                            type="button"
                            class="bd-detail-share"
                            id="bdDetailShare"
                        >
                            <span class="bd-detail-share-icon">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="18" cy="5" r="2"/>
                                    <circle cx="6" cy="12" r="2"/>
                                    <circle cx="18" cy="19" r="2"/>
                                    <path d="M8 11l8-5"/>
                                    <path d="M8 13l8 5"/>
                                </svg>
                            </span>

                            Bagikan Informasi
                        </button>

                    </div>

                </div>


                {{-- Hero Image --}}
                @if($hasImage)
                    <div class="bd-detail-media-wrap bd-detail-reveal">

                        <div class="bd-detail-media">

                            <div class="bd-detail-fallback">
                                <div class="bd-detail-fallback-inner">
                                    <span class="bd-detail-fallback-mark"></span>
                                    <span>Baca Dulu</span>
                                </div>
                            </div>

                            <img
                                src="{{ asset('storage/' . $information->image) }}"
                                alt="{{ $information->title }}"
                                class="bd-detail-image"
                                loading="eager"
                                fetchpriority="high"
                                onerror="this.style.display='none';"
                            >

                        </div>

                    </div>
                @endif

            </div>

        </div>

    </header>


    <div class="bd-detail-separator"></div>


    {{-- =====================================================
         ARTICLE
    ====================================================== --}}
    <main class="bd-detail-reading">

        <div class="bd-detail-reading-inner">

            <article class="bd-detail-content bd-detail-reveal">
                {!! $information->content !!}
            </article>


            {{-- =================================================
                 BOTTOM ACTION
            ================================================== --}}
            <section class="bd-detail-after bd-detail-reveal">

                <div class="bd-detail-after-inner">

                    <div class="bd-detail-after-copy">

                        <span class="bd-detail-after-label">
                            Selesai Membaca
                        </span>

                        <h3>
                            Mau lihat informasi lainnya?
                        </h3>

                        <p>
                            Jelajahi kabar, agenda, kegiatan, dan
                            pembaruan lain yang diterbitkan Baca Dulu.
                        </p>

                    </div>


                    <div class="bd-detail-actions">

                        {{-- PRIMARY --}}
                        <a
                            href="{{ route('informasi') }}#semua-informasi"
                            class="bd-detail-more"
                        >
                            Informasi Lainnya

                            <svg viewBox="0 0 24 24">
                                <path d="M5 12h14"/>
                                <path d="m14 7 5 5-5 5"/>
                            </svg>
                        </a>


                        {{-- BUKAN SHARE LAGI --}}
                        <button
                            type="button"
                            class="bd-detail-top"
                            id="bdDetailTop"
                        >
                            <svg viewBox="0 0 24 24">
                                <path d="M12 19V5"/>
                                <path d="m7 10 5-5 5 5"/>
                            </svg>

                            Kembali ke Atas
                        </button>

                    </div>

                </div>

            </section>

        </div>

    </main>


    {{-- SHARE TOAST --}}
    <div class="bd-detail-toast" id="bdDetailToast">
        <span class="bd-detail-toast-dot"></span>
        Link berhasil disalin
    </div>

</div>


<script>
(() => {
    const initInformationDetail = () => {
        const page = document.getElementById('bdInformationDetail');

        if (!page || page.dataset.detailReady === '1') {
            return;
        }

        page.dataset.detailReady = '1';

        const gsap = window.bdGsap || window.gsap || null;
        const reducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;


        /* =====================================================
           INTRO
        ====================================================== */

        const title = document.getElementById('bdDetailTitle');
        const revealItems = page.querySelectorAll('.bd-detail-reveal');

        if (gsap && !reducedMotion) {
            if (title) {
                gsap.fromTo(
                    title,
                    {
                        opacity: 0,
                        y: 20
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: .65,
                        ease: 'power3.out'
                    }
                );
            }

            gsap.to(revealItems, {
                opacity: 1,
                y: 0,
                duration: .50,
                stagger: .04,
                delay: .08,
                ease: 'power3.out'
            });
        } else {
            revealItems.forEach(element => {
                element.style.opacity = '1';
                element.style.transform = 'none';
            });

            if (title) {
                title.style.opacity = '1';
                title.style.transform = 'none';
            }
        }


        /* =====================================================
           READING PROGRESS
        ====================================================== */

        const progress = document.getElementById('bdDetailProgress');

        const updateProgress = () => {
            if (!progress) {
                return;
            }

            const scrollTop =
                window.scrollY ||
                document.documentElement.scrollTop;

            const scrollHeight =
                document.documentElement.scrollHeight -
                window.innerHeight;

            const percentage = scrollHeight > 0
                ? Math.min(
                    100,
                    Math.max(
                        0,
                        (scrollTop / scrollHeight) * 100
                    )
                )
                : 0;

            progress.style.width = `${percentage}%`;
        };

        window.addEventListener(
            'scroll',
            updateProgress,
            { passive: true }
        );

        updateProgress();


        /* =====================================================
           SHARE
        ====================================================== */

        const shareButton = document.getElementById('bdDetailShare');
        const toast = document.getElementById('bdDetailToast');

        const showToast = () => {
            if (!toast) {
                return;
            }

            if (gsap && !reducedMotion) {
                gsap.killTweensOf(toast);

                gsap.timeline()
                    .to(toast, {
                        opacity: 1,
                        y: 0,
                        duration: .2
                    })
                    .to(toast, {
                        opacity: 0,
                        y: 12,
                        duration: .2,
                        delay: 1.3
                    });

                return;
            }

            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';

            setTimeout(() => {
                toast.style.opacity = '0';
            }, 1500);
        };


        const copyLink = async () => {
            try {
                if (
                    navigator.clipboard &&
                    window.isSecureContext
                ) {
                    await navigator.clipboard.writeText(
                        window.location.href
                    );

                    showToast();
                    return;
                }

                throw new Error('Clipboard unavailable');
            } catch (error) {
                window.prompt(
                    'Salin link:',
                    window.location.href
                );
            }
        };


        const shareInformation = async () => {
            if (typeof navigator.share === 'function') {
                try {
                    await navigator.share({
                        title: @json($information->title),
                        url: window.location.href
                    });

                    return;
                } catch (error) {
                    if (error?.name === 'AbortError') {
                        return;
                    }
                }
            }

            await copyLink();
        };

        shareButton?.addEventListener(
            'click',
            shareInformation
        );


        /* =====================================================
           BACK TO TOP
        ====================================================== */

        const topButton = document.getElementById('bdDetailTop');

        topButton?.addEventListener('click', () => {
            if (reducedMotion) {
                window.scrollTo(0, 0);
                return;
            }

            if (window.bdLenis) {
                window.bdLenis.scrollTo(0, {
                    duration: 1
                });

                return;
            }

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    };


    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initInformationDetail,
            { once: true }
        );
    } else {
        initInformationDetail();
    }
})();
</script>

@endsection