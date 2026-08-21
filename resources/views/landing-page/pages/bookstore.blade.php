@extends('layouts.app')


@section('title', 'Bookstore - Baca Dulu')


@section('content')

<style>

    /*
    |--------------------------------------------------------------------------
    | BOOKSTORE ONLY
    |--------------------------------------------------------------------------
    | Seluruh selector dibuat berada di bawah .bookstore-page
    | agar TIDAK mengubah navbar, footer, blog, atau halaman lain.
    |--------------------------------------------------------------------------
    */

    .bookstore-page {

        --navy: #241B52;
        --navy-deep: #170F38;

        --orange: #EF5843;
        --orange-dark: #C6432F;

        --gold: #F7AA35;

        --cream: #FBF9F5;
        --white: #FFFFFF;

        --ink-muted: #6B7280;

        --border: #EAE7DF;

        --brand-gradient:
            linear-gradient(
                135deg,
                var(--orange) 0%,
                var(--gold) 100%
            );

        width: 100%;

        color: var(--navy);

        background: var(--white);

        font-family: 'Inter', sans-serif;

        overflow-x: hidden;

        -webkit-font-smoothing: antialiased;

    }


    .bookstore-page,
    .bookstore-page * {

        box-sizing: border-box;

    }


    .bookstore-page h1,
    .bookstore-page h2,
    .bookstore-page h3,
    .bookstore-page .btn,
    .bookstore-page button {

        font-family: 'Poppins', sans-serif;

    }


    .bookstore-page a {

        text-decoration: none;

        color: inherit;

    }


    .bookstore-page img {

        display: block;

        max-width: 100%;

    }


    /*
    |--------------------------------------------------------------------------
    | CONTAINER
    |--------------------------------------------------------------------------
    */

    .bookstore-page .wrap {

        width: 100%;

        max-width: 1440px;

        margin-left: auto;

        margin-right: auto;

        padding-left: 32px;

        padding-right: 32px;

    }


    /*
    |--------------------------------------------------------------------------
    | BUTTON
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cta-btn {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        background: var(--brand-gradient);

        color: var(--white);

        font-weight: 600;

        font-size: 14px;

        padding: 12px 22px;

        border-radius: 10px;

        border: none;

        cursor: pointer;

        transition:
            filter 0.15s ease,
            transform 0.15s ease;

        white-space: nowrap;

    }


    .bookstore-page .cta-btn:hover {

        filter: brightness(0.94);

        transform: translateY(-1px);

    }


    /*
    |--------------------------------------------------------------------------
    | HERO
    |--------------------------------------------------------------------------
    */

    .bookstore-page .hero {

        position: relative;

        width: 100%;

        overflow: hidden;

        color: var(--navy);

        padding: 78px 0 64px;

        background-color: var(--white);

        background-image:

            radial-gradient(
                circle at 88% 8%,
                rgba(239, 88, 67, 0.30),
                transparent 52%
            ),

            radial-gradient(
                circle at 100% 55%,
                rgba(247, 170, 53, 0.35),
                transparent 48%
            ),

            radial-gradient(
                circle at 6% 100%,
                rgba(247, 170, 53, 0.20),
                transparent 42%
            );

    }


    .bookstore-page .hero::before {

        content: "";

        position: absolute;

        top: 0;

        left: 0;

        right: 0;

        height: 4px;

        background: var(--brand-gradient);

    }


    .bookstore-page .eyebrow {

        display: inline-flex;

        align-items: center;

        gap: 9px;

        background: #FFF1E4;

        color: var(--orange-dark);

        font-size: 13px;

        font-weight: 700;

        padding: 8px 16px;

        border-radius: 999px;

        margin-bottom: 24px;

        letter-spacing: 0.2px;

    }


    .bookstore-page .eyebrow .dot {

        width: 8px;

        height: 8px;

        flex-shrink: 0;

        border-radius: 50%;

        background: var(--brand-gradient);

    }


    .bookstore-page .hero h1 {

        max-width: 770px;

        margin: 0 0 18px;

        color: var(--navy);

        font-size: clamp(38px, 4.2vw, 58px);

        font-weight: 700;

        line-height: 1.12;

        letter-spacing: -1px;

    }


    .bookstore-page .hero-description {

        max-width: 760px;

        margin: 0 0 28px;

        color: var(--ink-muted);

        font-size: 17px;

        line-height: 1.75;

    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    .bookstore-page .search-bar {

        display: flex;

        align-items: stretch;

        gap: 8px;

        max-width: 700px;

        padding: 8px;

        background: var(--white);

        border: 1px solid var(--border);

        border-radius: 14px;

        box-shadow:
            0 12px 35px rgba(36, 27, 82, 0.10);

    }


    .bookstore-page .search-bar input {

        flex: 1;

        min-width: 0;

        border: none;

        outline: none;

        background: transparent;

        color: var(--navy);

        font-family: 'Inter', sans-serif;

        font-size: 14px;

        padding: 11px 14px;

    }


    .bookstore-page .search-bar input::placeholder {

        color: #9CA3AF;

    }


    .bookstore-page .search-bar button {

        flex-shrink: 0;

        border: none;

        border-radius: 9px;

        padding: 0 24px;

        cursor: pointer;

        background: var(--brand-gradient);

        color: var(--white);

        font-weight: 600;

        font-size: 13px;

        transition:
            filter 0.15s ease,
            transform 0.15s ease;

    }


    .bookstore-page .search-bar button:hover {

        filter: brightness(0.94);

    }


    .bookstore-page .search-status {

        min-height: 18px;

        margin-top: 10px;

        color: var(--ink-muted);

        font-size: 12px;

    }


    /*
    |--------------------------------------------------------------------------
    | HERO STATISTIC
    |--------------------------------------------------------------------------
    */

    .bookstore-page .hero-stats {

        display: flex;

        flex-wrap: wrap;

        gap: 42px;

        margin-top: 38px;

    }


    .bookstore-page .hero-stat {

        min-width: 150px;

        border-left: 2px solid var(--border);

        padding-left: 16px;

    }


    .bookstore-page .hero-stat strong {

        display: block;

        margin-bottom: 4px;

        color: var(--navy);

        font-family: 'Poppins', sans-serif;

        font-size: 23px;

        font-weight: 700;

    }


    .bookstore-page .hero-stat span {

        color: var(--ink-muted);

        font-size: 13px;

    }


    /*
    |--------------------------------------------------------------------------
    | SECTION
    |--------------------------------------------------------------------------
    */

    .bookstore-page .store-section {

        width: 100%;

        padding: 64px 0;

    }


    .bookstore-page .section-head {

        display: flex;

        align-items: flex-end;

        justify-content: space-between;

        gap: 20px;

        margin-bottom: 28px;

    }


    .bookstore-page .section-head h2 {

        display: flex;

        align-items: center;

        gap: 11px;

        margin: 0;

        color: var(--navy);

        font-size: 27px;

        font-weight: 700;

        line-height: 1.25;

    }


    .bookstore-page .section-head h2 .tag {

        display: inline-block;

        width: 11px;

        height: 11px;

        flex-shrink: 0;

        border-radius: 3px;

        background: var(--brand-gradient);

    }


    .bookstore-page .section-head p {

        margin: 7px 0 0 22px;

        color: var(--ink-muted);

        font-size: 14px;

        line-height: 1.5;

    }


    .bookstore-page .see-all {

        flex-shrink: 0;

        color: var(--orange);

        font-size: 14px;

        font-weight: 700;

        transition: color 0.15s ease;

    }


    .bookstore-page .see-all:hover {

        color: var(--orange-dark);

    }


    /*
    |--------------------------------------------------------------------------
    | SHELF
    |--------------------------------------------------------------------------
    */

    .bookstore-page .shelf {

        display: flex;

        gap: 20px;

        width: 100%;

        overflow-x: auto;

        padding: 3px 2px 16px;

        scroll-snap-type: x mandatory;

        scrollbar-width: thin;

    }


    .bookstore-page .shelf::-webkit-scrollbar {

        height: 6px;

    }


    .bookstore-page .shelf::-webkit-scrollbar-track {

        background: #F4F1EB;

        border-radius: 999px;

    }


    .bookstore-page .shelf::-webkit-scrollbar-thumb {

        background: var(--brand-gradient);

        border-radius: 999px;

    }


    .bookstore-page .shelf .book-card {

        min-width: 240px;

        flex: 1 0 240px;

        scroll-snap-align: start;

    }


    /*
    |--------------------------------------------------------------------------
    | BOOK CARD
    |--------------------------------------------------------------------------
    */

    .bookstore-page .book-card {

        overflow: hidden;

        background: var(--white);

        border: 1px solid var(--border);

        border-radius: 16px;

        transition:
            box-shadow 0.22s ease,
            transform 0.22s ease;

    }


    .bookstore-page .book-card:hover {

        transform: translateY(-4px);

        box-shadow:
            0 16px 32px rgba(27, 36, 83, 0.10);

    }


    /*
    |--------------------------------------------------------------------------
    | BOOK COVER
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cover-3d {

        position: relative;

        display: flex;

        align-items: center;

        justify-content: center;

        height: 255px;

        overflow: hidden;

        perspective: 900px;

        background:
            linear-gradient(
                180deg,
                var(--cream) 0%,
                #F1EDE4 100%
            );

    }


    .bookstore-page .cover-3d::after {

        content: "";

        position: absolute;

        left: 50%;

        bottom: 21px;

        width: 120px;

        height: 15px;

        transform: translateX(-50%);

        background:
            radial-gradient(
                ellipse at center,
                rgba(27, 36, 83, 0.18),
                transparent 70%
            );

    }


    .bookstore-page .book3d {

        position: relative;

        z-index: 2;

        width: 150px;

        height: 205px;

        transform-style: preserve-3d;

        transform: rotateY(-25deg);

        transition: transform 0.4s ease;

    }


    .bookstore-page .book-card:hover .book3d {

        transform: rotateY(-7deg);

    }


    .bookstore-page .face {

        position: absolute;

        top: 0;

    }


    .bookstore-page .face.front {

        left: 0;

        width: 150px;

        height: 205px;

        display: flex;

        flex-direction: column;

        justify-content: flex-end;

        padding: 16px;

        overflow: hidden;

        color: var(--white);

        transform: translateZ(9px);

        border-radius: 2px 6px 6px 2px;

        box-shadow:
            8px 14px 26px rgba(18, 25, 59, 0.28);

    }


    .bookstore-page .face.pages {

        top: 2px;

        right: 0;

        width: 18px;

        height: 201px;

        transform-origin: right;

        transform: rotateY(90deg);

        background:
            repeating-linear-gradient(
                to bottom,
                #FDFCF9 0 2px,
                #EAE5DA 2px 3px
            );

        box-shadow:
            inset -2px 0 4px rgba(0, 0, 0, 0.10);

    }


    .bookstore-page .face.spine {

        top: 2px;

        left: 0;

        width: 18px;

        height: 201px;

        transform-origin: left;

        transform: rotateY(-90deg);

        filter: brightness(0.72);

    }


    .bookstore-page .front .spine-title {

        font-family: 'Poppins', sans-serif;

        font-weight: 700;

        font-size: 15px;

        line-height: 1.3;

    }


    .bookstore-page .front .spine-sub {

        margin-top: 4px;

        font-size: 11px;

        line-height: 1.3;

        opacity: 0.85;

    }


    /*
    |--------------------------------------------------------------------------
    | BADGE
    |--------------------------------------------------------------------------
    */

    .bookstore-page .badge {

        position: absolute;

        top: 12px;

        left: 12px;

        z-index: 3;

        padding: 4px 9px;

        border-radius: 999px;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: 0.3px;

    }


    .bookstore-page .badge.baru {

        background: var(--gold);

        color: var(--navy-deep);

    }


    .bookstore-page .badge.best {

        background: var(--brand-gradient);

        color: var(--white);

    }


    .bookstore-page .badge.ebook {

        background: rgba(255, 255, 255, 0.92);

        color: var(--navy);

    }


    /*
    |--------------------------------------------------------------------------
    | BOOK INFORMATION
    |--------------------------------------------------------------------------
    */

    .bookstore-page .book-info {

        padding: 16px 17px 19px;

    }


    .bookstore-page .book-info .penerbit {

        min-height: 16px;

        color: var(--ink-muted);

        font-size: 10.5px;

        text-transform: uppercase;

        letter-spacing: 0.5px;

        font-weight: 700;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;

    }


    .bookstore-page .book-info .title {

        min-height: 42px;

        margin: 6px 0;

        color: var(--navy);

        font-family: 'Poppins', sans-serif;

        font-size: 15px;

        font-weight: 600;

        line-height: 1.4;

        display: -webkit-box;

        -webkit-line-clamp: 2;

        -webkit-box-orient: vertical;

        overflow: hidden;

    }


    .bookstore-page .book-info .author {

        min-height: 18px;

        margin-bottom: 13px;

        color: var(--ink-muted);

        font-size: 12.5px;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;

    }


    .bookstore-page .book-bottom {

        display: flex;

        align-items: flex-end;

        justify-content: space-between;

        gap: 10px;

    }


    .bookstore-page .price {

        color: var(--navy);

        font-size: 15px;

        font-weight: 700;

        white-space: nowrap;

    }


    .bookstore-page .price small {

        display: block;

        margin-bottom: 2px;

        color: var(--ink-muted);

        font-size: 10.5px;

        font-weight: 400;

        text-decoration: line-through;

    }


    .bookstore-page .book-actions {

        display: flex;

        align-items: center;

        gap: 6px;

        flex-shrink: 0;

    }


    .bookstore-page .detail-btn {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        min-height: 34px;

        padding: 7px 10px;

        border: 1px solid #F97316;

        border-radius: 9px;

        color: #C2410C;

        background: var(--white);

        font-size: 10.5px;

        font-weight: 700;

        transition: all 0.15s ease;

    }


    .bookstore-page .detail-btn:hover {

        background: #FFF7ED;

        border-color: #EA580C;

        color: #9A3412;

    }


    .bookstore-page .add-btn {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        width: 34px;

        height: 34px;

        flex-shrink: 0;

        border: none;

        border-radius: 9px;

        background: var(--cream);

        color: var(--orange);

        font-family: 'Inter', sans-serif;

        font-size: 19px;

        font-weight: 700;

        cursor: pointer;

        transition:
            background 0.15s ease,
            color 0.15s ease,
            transform 0.15s ease;

    }


    .bookstore-page .add-btn:hover {

        background: var(--brand-gradient);

        color: var(--white);

    }


    .bookstore-page .add-btn.added {

        transform: scale(0.83);

    }


    /*
    |--------------------------------------------------------------------------
    | CATALOG
    |--------------------------------------------------------------------------
    */

    .bookstore-page .catalog-bg {

        background: var(--cream);

    }


    .bookstore-page .filter-row {

        display: flex;

        flex-wrap: wrap;

        gap: 9px;

        margin-bottom: 30px;

    }


    .bookstore-page .chip {

        padding: 9px 18px;

        border: 1px solid var(--border);

        border-radius: 999px;

        background: var(--white);

        color: var(--navy);

        font-size: 13px;

        font-weight: 600;

        cursor: pointer;

        transition:
            background 0.15s ease,
            border-color 0.15s ease,
            color 0.15s ease,
            transform 0.15s ease;

    }


    .bookstore-page .chip:hover {

        border-color: #D6D0C4;

        transform: translateY(-1px);

    }


    .bookstore-page .chip.active {

        background: var(--navy);

        border-color: var(--navy);

        color: var(--white);

    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTANT
    |--------------------------------------------------------------------------
    | Jangan diberi nama ".grid" karena bentrok dengan Tailwind.
    |--------------------------------------------------------------------------
    */

    .bookstore-page .book-grid {

        display: grid;

        grid-template-columns:
            repeat(
                auto-fill,
                minmax(240px, 1fr)
            );

        gap: 22px;

        width: 100%;

    }


    .bookstore-page .empty-state {

        grid-column: 1 / -1;

        padding: 70px 20px;

        text-align: center;

        color: var(--ink-muted);

        font-size: 14px;

        line-height: 1.7;

    }


    /*
    |--------------------------------------------------------------------------
    | CTA BANNER
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cta-wrapper {

        width: 100%;

        padding: 0 32px 70px;

        background: var(--white);

    }


    .bookstore-page .cta-banner {

        position: relative;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 30px;

        width: 100%;

        max-width: 1376px;

        margin: 0 auto;

        overflow: hidden;

        padding: 46px 52px;

        color: var(--navy);

        background-image:
            linear-gradient(
                120deg,
                #FFF6EC 0%,
                #FFE9D2 45%,
                #FFEFD0 100%
            );

        border: 1px solid var(--border);

        border-radius: 22px;

    }


    .bookstore-page .cta-banner::before {

        content: "";

        position: absolute;

        top: 0;

        left: 0;

        bottom: 0;

        width: 5px;

        background: var(--brand-gradient);

    }


    .bookstore-page .cta-banner h3 {

        margin: 0 0 8px;

        color: var(--navy);

        font-size: 24px;

        font-weight: 700;

        line-height: 1.35;

    }


    .bookstore-page .cta-banner p {

        max-width: 620px;

        margin: 0;

        color: var(--ink-muted);

        font-size: 14px;

        line-height: 1.7;

    }


    /*
    |--------------------------------------------------------------------------
    | FLOATING CART
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cart-fab {

        position: fixed;

        right: 28px;

        bottom: 28px;

        z-index: 1200;

        display: flex;

        align-items: center;

        justify-content: center;

        width: 60px;

        height: 60px;

        border: none;

        border-radius: 50%;

        background: var(--navy);

        color: var(--white);

        font-family: 'Inter', sans-serif;

        font-size: 24px;

        cursor: pointer;

        box-shadow:
            0 12px 30px rgba(36, 27, 82, 0.35);

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease;

    }


    .bookstore-page .cart-fab:hover {

        transform: translateY(-3px);

        box-shadow:
            0 16px 35px rgba(36, 27, 82, 0.40);

    }


    .bookstore-page .cart-count {

        position: absolute;

        top: -4px;

        right: -4px;

        display: flex;

        align-items: center;

        justify-content: center;

        min-width: 23px;

        height: 23px;

        padding: 0 5px;

        border-radius: 999px;

        background: var(--brand-gradient);

        color: var(--white);

        font-size: 11px;

        font-weight: 700;

        box-shadow:
            0 0 0 2px var(--white);

    }


    .bookstore-page .cart-count.hide {

        display: none;

    }


    .bookstore-page .cart-count.pop {

        animation: cartPop 0.3s ease;

    }


    @keyframes cartPop {

        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.35);
        }

        100% {
            transform: scale(1);
        }

    }


    /*
    |--------------------------------------------------------------------------
    | CART OVERLAY
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cart-overlay {

        position: fixed;

        inset: 0;

        z-index: 1300;

        background:
            rgba(23, 15, 56, 0.45);

        opacity: 0;

        pointer-events: none;

        transition:
            opacity 0.25s ease;

    }


    .bookstore-page .cart-overlay.show {

        opacity: 1;

        pointer-events: auto;

    }


    /*
    |--------------------------------------------------------------------------
    | CART DRAWER
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cart-drawer {

        position: fixed;

        top: 0;

        right: 0;

        z-index: 1400;

        display: flex;

        flex-direction: column;

        width: 410px;

        max-width: 94vw;

        height: 100dvh;

        background: var(--white);

        transform: translateX(100%);

        transition:
            transform 0.3s cubic-bezier(.22, 1, .36, 1);

        box-shadow:
            -18px 0 40px rgba(23, 15, 56, 0.18);

    }


    .bookstore-page .cart-drawer.open {

        transform: translateX(0);

    }


    .bookstore-page .cart-drawer-head {

        display: flex;

        align-items: center;

        justify-content: space-between;

        padding: 22px 24px;

        border-bottom: 1px solid var(--border);

    }


    .bookstore-page .cart-drawer-head h3 {

        margin: 0;

        color: var(--navy);

        font-size: 18px;

        font-weight: 700;

    }


    .bookstore-page .cart-close {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 36px;

        height: 36px;

        border: none;

        border-radius: 9px;

        background: transparent;

        color: var(--ink-muted);

        font-family: 'Inter', sans-serif;

        font-size: 18px;

        cursor: pointer;

        transition:
            background 0.15s ease;

    }


    .bookstore-page .cart-close:hover {

        background: var(--cream);

    }


    .bookstore-page .cart-items {

        flex: 1;

        overflow-y: auto;

        padding: 16px 24px;

    }


    .bookstore-page .cart-empty {

        padding: 65px 10px;

        color: var(--ink-muted);

        font-size: 14px;

        line-height: 1.7;

        text-align: center;

    }


    .bookstore-page .cart-item {

        display: flex;

        gap: 12px;

        padding: 15px 0;

        border-bottom: 1px solid var(--border);

    }


    .bookstore-page .ci-info {

        flex: 1;

        min-width: 0;

    }


    .bookstore-page .ci-title {

        margin-bottom: 3px;

        overflow: hidden;

        color: var(--navy);

        font-size: 14px;

        font-weight: 600;

        text-overflow: ellipsis;

        white-space: nowrap;

    }


    .bookstore-page .ci-author {

        margin-bottom: 9px;

        color: var(--ink-muted);

        font-size: 12px;

    }


    .bookstore-page .ci-row {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

    }


    .bookstore-page .qty-ctrl {

        display: flex;

        align-items: center;

        gap: 8px;

    }


    .bookstore-page .qty-ctrl button {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 27px;

        height: 27px;

        border: 1px solid var(--border);

        border-radius: 7px;

        background: var(--cream);

        color: var(--navy);

        font-family: 'Inter', sans-serif;

        font-size: 14px;

        font-weight: 700;

        cursor: pointer;

    }


    .bookstore-page .qty-ctrl span {

        min-width: 16px;

        color: var(--navy);

        font-size: 13px;

        font-weight: 600;

        text-align: center;

    }


    .bookstore-page .ci-price {

        color: var(--navy);

        font-size: 13.5px;

        font-weight: 700;

        white-space: nowrap;

    }


    .bookstore-page .ci-remove {

        margin-top: 8px;

        padding: 0;

        border: none;

        background: none;

        color: var(--orange-dark);

        font-family: 'Inter', sans-serif;

        font-size: 11.5px;

        cursor: pointer;

        text-decoration: underline;

    }


    /*
    |--------------------------------------------------------------------------
    | CART FOOTER
    |--------------------------------------------------------------------------
    */

    .bookstore-page .cart-drawer-foot {

        padding: 20px 24px 24px;

        border-top: 1px solid var(--border);

        background: var(--white);

    }


    .bookstore-page .cart-total-row {

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 14px;

    }


    .bookstore-page .cart-total-row span {

        color: var(--ink-muted);

        font-size: 14px;

    }


    .bookstore-page .cart-total-row strong {

        color: var(--navy);

        font-size: 19px;

    }


    .bookstore-page .checkout-wa-btn {

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        width: 100%;

        padding: 13px;

        border: none;

        border-radius: 11px;

        background: #25D366;

        color: var(--white);

        font-size: 14px;

        font-weight: 700;

        cursor: pointer;

        transition:
            filter 0.15s ease;

    }


    .bookstore-page .checkout-wa-btn:hover:not(:disabled) {

        filter: brightness(0.94);

    }


    .bookstore-page .checkout-wa-btn:disabled {

        opacity: 0.5;

        cursor: not-allowed;

    }


    .bookstore-page .cart-note {

        margin: 11px 0 0;

        color: var(--ink-muted);

        font-size: 11px;

        line-height: 1.55;

        text-align: center;

    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE TABLET
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1024px) {

        .bookstore-page .hero {

            padding: 65px 0 55px;

        }


        .bookstore-page .wrap {

            padding-left: 24px;

            padding-right: 24px;

        }


        .bookstore-page .store-section {

            padding: 54px 0;

        }


        .bookstore-page .cta-wrapper {

            padding-left: 24px;

            padding-right: 24px;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 640px) {

        .bookstore-page .wrap {

            padding-left: 18px;

            padding-right: 18px;

        }


        .bookstore-page .hero {

            padding: 48px 0 44px;

        }


        .bookstore-page .hero h1 {

            font-size: 34px;

            line-height: 1.15;

            letter-spacing: -0.5px;

        }


        .bookstore-page .hero-description {

            font-size: 15px;

            line-height: 1.7;

        }


        .bookstore-page .search-bar {

            flex-direction: column;

            padding: 7px;

        }


        .bookstore-page .search-bar button {

            min-height: 43px;

            padding: 10px 20px;

        }


        .bookstore-page .hero-stats {

            gap: 20px;

            margin-top: 30px;

        }


        .bookstore-page .hero-stat {

            min-width: 130px;

        }


        .bookstore-page .store-section {

            padding: 46px 0;

        }


        .bookstore-page .section-head {

            align-items: flex-start;

        }


        .bookstore-page .section-head h2 {

            font-size: 22px;

        }


        .bookstore-page .section-head p {

            margin-left: 22px;

            font-size: 13px;

        }


        .bookstore-page .see-all {

            display: none;

        }


        .bookstore-page .shelf .book-card {

            min-width: 225px;

            flex-basis: 225px;

        }


        .bookstore-page .book-grid {

            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 12px;

        }


        .bookstore-page .book-grid .cover-3d {

            height: 210px;

        }


        .bookstore-page .book-grid .book3d {

            width: 122px;

            height: 170px;

        }


        .bookstore-page .book-grid .face.front {

            width: 122px;

            height: 170px;

            padding: 12px;

        }


        .bookstore-page .book-grid .face.pages,
        .bookstore-page .book-grid .face.spine {

            height: 166px;

        }


        .bookstore-page .book-grid .book-info {

            padding: 12px;

        }


        .bookstore-page .book-grid .book-info .title {

            min-height: 38px;

            font-size: 13px;

        }


        .bookstore-page .book-grid .book-info .author {

            font-size: 11px;

        }


        .bookstore-page .book-grid .price {

            font-size: 12px;

        }


        .bookstore-page .book-grid .detail-btn {

            display: none;

        }


        .bookstore-page .cta-wrapper {

            padding:
                0
                18px
                50px;

        }


        .bookstore-page .cta-banner {

            flex-direction: column;

            align-items: flex-start;

            padding: 32px 26px;

        }


        .bookstore-page .cta-banner h3 {

            font-size: 21px;

        }


        .bookstore-page .cta-banner .cta-btn {

            width: 100%;

        }


        .bookstore-page .cart-fab {

            right: 18px;

            bottom: 20px;

            width: 56px;

            height: 56px;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE KECIL
    |--------------------------------------------------------------------------
    */

    @media (max-width: 390px) {

        .bookstore-page .book-grid {

            grid-template-columns: 1fr;

        }


        .bookstore-page .book-grid .cover-3d {

            height: 250px;

        }


        .bookstore-page .book-grid .book3d {

            width: 148px;

            height: 200px;

        }


        .bookstore-page .book-grid .face.front {

            width: 148px;

            height: 200px;

        }


        .bookstore-page .book-grid .face.pages,
        .bookstore-page .book-grid .face.spine {

            height: 196px;

        }

    }

</style>



{{-- ============================================================
    BOOKSTORE PAGE WRAPPER
============================================================ --}}

<div class="bookstore-page">


    {{-- ========================================================
        HERO
    ========================================================= --}}

    <section class="hero">

        <div class="wrap">


            <span class="eyebrow">

                <span class="dot"></span>

                Toko resmi Baca Dulu

            </span>


            <h1>
                Temukan buku terbitan penerbit rekan kami
            </h1>


            <p class="hero-description">

                Jelajahi ribuan judul e-book dan buku fisik dari
                para penulis dan penerbit yang telah dipercaya
                Baca Dulu — langsung dari sumbernya.

            </p>

            {{-- STATISTIC --}}

            <div class="hero-stats">

                <div class="hero-stat">

                    <strong>
                        {{ $books->count() }}+
                    </strong>

                    <span>
                        Judul tersedia
                    </span>

                </div>


                <div class="hero-stat">

                    <strong>
                        {{ $books->pluck('publisher')->filter()->unique()->count() }}
                    </strong>

                    <span>
                        Penerbit rekanan
                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- ========================================================
        TERBITAN TERBARU
    ========================================================= --}}

    <section class="store-section">

        <div class="wrap">


            <div class="section-head">

                <div>

                    <h2>

                        <span class="tag"></span>

                        Terbitan terbaru

                    </h2>

                    <p>
                        Baru rilis dari penerbit-penerbit rekan kami
                    </p>

                </div>


                <a
                    href="#catalog"
                    class="see-all"
                >
                    Lihat semua →
                </a>

            </div>


            <div
                class="shelf"
                id="shelf"
            ></div>


        </div>

    </section>


    {{-- ========================================================
        KATALOG
    ========================================================= --}}

    <section
        id="catalog"
        class="store-section catalog-bg"
    >

        <div class="wrap">


            <div class="section-head">

                <div>

                    <h2>

                        <span class="tag"></span>

                        Katalog lengkap

                    </h2>

                    <p>
                        Semua buku yang dijual penerbit di Baca Dulu Bookstore
                    </p>

                </div>

            </div>


            {{-- CATEGORY FILTER --}}

            <div
                class="filter-row"
                id="filters"
            ></div>


            {{-- BOOK GRID --}}

            <div
                class="book-grid"
                id="catalogGrid"
            ></div>


        </div>

    </section>


    {{-- ========================================================
        CTA
    ========================================================= --}}

    <div class="cta-wrapper">

        <div class="cta-banner">

            <div>

                <h3>
                    Penerbit atau penulis? Jual bukumu di sini.
                </h3>

                <p>
                    Gabung sebagai mitra penerbit dan pasarkan
                    judul-judulmu langsung kepada pembaca Baca Dulu.
                </p>

            </div>


            <a
                href="https://wa.me/6281315717719"
                target="_blank"
                rel="noopener noreferrer"
                class="cta-btn"
            >
                Kirim Naskah
            </a>

        </div>

    </div>


    {{-- ========================================================
        FLOATING CART
    ========================================================= --}}

    <button
        type="button"
        class="cart-fab"
        id="cartFab"
        title="Buka keranjang"
        aria-label="Buka keranjang"
    >

        🛒

        <span
            class="cart-count hide"
            id="cartCount"
        >
            0
        </span>

    </button>


    {{-- ========================================================
        CART OVERLAY
    ========================================================= --}}

    <div
        class="cart-overlay"
        id="cartOverlay"
    ></div>


    {{-- ========================================================
        CART DRAWER
    ========================================================= --}}

    <aside
        class="cart-drawer"
        id="cartDrawer"
        aria-label="Keranjang belanja"
    >


        <div class="cart-drawer-head">

            <h3>
                Keranjang Anda
            </h3>


            <button
                type="button"
                class="cart-close"
                id="cartClose"
                aria-label="Tutup keranjang"
            >
                ✕
            </button>

        </div>


        <div
            class="cart-items"
            id="cartItemsWrap"
        ></div>


        <div class="cart-drawer-foot">


            <div class="cart-total-row">

                <span>
                    Total
                </span>

                <strong id="cartTotalText">
                    Rp 0
                </strong>

            </div>


            <button
                type="button"
                class="checkout-wa-btn"
                id="checkoutBtn"
                disabled
            >
                💬 Checkout via WhatsApp
            </button>


            <p class="cart-note">

                Pesanan akan diteruskan ke tim kami lewat
                WhatsApp untuk konfirmasi stok, ongkir,
                dan pembayaran.

            </p>


        </div>

    </aside>


</div>



{{-- ============================================================
    CONVERT LARAVEL COLLECTION TO JAVASCRIPT
============================================================ --}}

@php

    $bookstoreBooks = $books->map(function ($book) {

        return [

            'id' => $book->id,

            'title' => $book->title ?? '',

            'author' => $book->author ?? '',

            'penerbit' => $book->publisher ?? 'Baca Dulu',

            'price' =>
                'Rp ' .
                number_format(
                    (float) $book->effective_price,
                    0,
                    ',',
                    '.'
                ),

            'priceNum' =>
                (float) $book->effective_price,

            'strike' =>
                $book->has_active_discount
                    ? 'Rp ' .
                        number_format(
                            (float) $book->price,
                            0,
                            ',',
                            '.'
                        )
                    : null,

            'cat' =>
                $book->category ?: 'Umum',

            'color' =>
                '#EF5843',

            'badge' =>
                null,

            'cover' =>
                $book->cover
                    ? asset("storage/{$book->cover}")
                    : null,

            'description' =>
                $book->description,

            'pages' =>
                $book->pages,

            'detail_url' =>
                $book->slug
                    ? route(
                        'portofolio.bookstore.show',
                        ['book' => $book->slug]
                    )
                    : null,

        ];

    })->values()->toArray();


    $bookstoreCategories = $books
        ->pluck('category')
        ->filter()
        ->unique()
        ->values()
        ->prepend('Semua')
        ->values()
        ->all();

@endphp



<script>

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    const books = @json($bookstoreBooks);

    const categories = @json($bookstoreCategories);


    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;

    }


    function initials(title) {

        return String(title || '')
            .split(' ')
            .filter(Boolean)
            .slice(0, 3)
            .join(' ');

    }


    function formatRupiah(number) {

        const value = Number(number) || 0;

        return 'Rp ' + value.toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | BOOK CARD
    |--------------------------------------------------------------------------
    */

    function bookCard(book) {

        const badgeMap = {

            baru: 'Baru',

            best: 'Bestseller',

            ebook: 'E-book'

        };


        const badgeHtml = book.badge

            ? `
                <span class="badge ${escapeHtml(book.badge)}">
                    ${escapeHtml(badgeMap[book.badge] || book.badge)}
                </span>
            `

            : '';


        const strikeHtml = book.strike

            ? `
                <small>
                    ${escapeHtml(book.strike)}
                </small>
            `

            : '';


        const coverBg = book.badge === 'best'

            ? 'var(--brand-gradient)'

            : (book.color || '#EF5843');


        const frontStyle = book.cover

            ? `
                background-image:url('${encodeURI(book.cover)}');
                background-size:cover;
                background-position:center;
                background-repeat:no-repeat;
                background-color:${coverBg};
            `

            : `
                background:${coverBg};
            `;


        const coverTextHtml = book.cover

            ? ''

            : `
                <div>

                    <div class="spine-title">
                        ${escapeHtml(initials(book.title))}
                    </div>

                    <div class="spine-sub">
                        ${escapeHtml(book.author)}
                    </div>

                </div>
            `;


        const detailButton = book.detail_url

            ? `
                <a
                    href="${escapeHtml(book.detail_url)}"
                    class="detail-btn"
                >
                    Deskripsi
                </a>
            `

            : '';


        return `

            <article
                class="book-card"
                data-cat="${escapeHtml(book.cat)}"
            >

                <div class="cover-3d">

                    <div class="book3d">


                        <div
                            class="face spine"
                            style="background:${coverBg}"
                        ></div>


                        <div class="face pages"></div>


                        <div
                            class="face front"
                            style="${frontStyle}"
                        >

                            ${badgeHtml}

                            ${coverTextHtml}

                        </div>


                    </div>

                </div>


                <div class="book-info">


                    <div class="penerbit">

                        ${escapeHtml(book.penerbit)}

                    </div>


                    <div class="title">

                        ${escapeHtml(book.title)}

                    </div>


                    <div class="author">

                        ${escapeHtml(book.author)}

                    </div>


                    <div class="book-bottom">


                        <div class="price">

                            ${strikeHtml}

                            ${escapeHtml(book.price)}

                        </div>


                        <div class="book-actions">

                            ${detailButton}

                            <button
                                type="button"
                                class="add-btn"
                                title="Tambah ke keranjang"
                                aria-label="Tambah ${escapeHtml(book.title)} ke keranjang"
                                data-id="${book.id}"
                            >
                                +
                            </button>

                        </div>


                    </div>

                </div>

            </article>

        `;

    }


    /*
    |--------------------------------------------------------------------------
    | SHELF
    |--------------------------------------------------------------------------
    */

    const shelfElement =
        document.getElementById('shelf');


    if (shelfElement) {

        shelfElement.innerHTML =
            books
                .slice(0, 5)
                .map(bookCard)
                .join('');

    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY FILTER
    |--------------------------------------------------------------------------
    */

    const filtersElement =
        document.getElementById('filters');


    if (filtersElement) {

        filtersElement.innerHTML =
            categories
                .map((category, index) => `

                    <button
                        type="button"
                        class="chip ${index === 0 ? 'active' : ''}"
                        data-cat="${escapeHtml(category)}"
                    >
                        ${escapeHtml(category)}
                    </button>

                `)
                .join('');

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER STATE
    |--------------------------------------------------------------------------
    */

    let currentCategory = 'Semua';

    let currentQuery = '';


    function applyFilters() {

        let filteredBooks = [...books];


        /*
        | CATEGORY
        */

        if (currentCategory !== 'Semua') {

            filteredBooks =
                filteredBooks.filter(
                    book =>
                        book.cat === currentCategory
                );

        }


        /*
        | SEARCH
        */

        if (currentQuery) {

            const query =
                currentQuery.toLocaleLowerCase('id-ID');


            filteredBooks =
                filteredBooks.filter(book => {

                    const title =
                        String(book.title || '')
                            .toLocaleLowerCase('id-ID');

                    const author =
                        String(book.author || '')
                            .toLocaleLowerCase('id-ID');

                    const publisher =
                        String(book.penerbit || '')
                            .toLocaleLowerCase('id-ID');


                    return (
                        title.includes(query) ||
                        author.includes(query) ||
                        publisher.includes(query)
                    );

                });

        }


        /*
        | RENDER
        */

        const grid =
            document.getElementById('catalogGrid');


        if (grid) {

            grid.innerHTML =
                filteredBooks.length

                    ? filteredBooks
                        .map(bookCard)
                        .join('')

                    : `
                        <div class="empty-state">

                            Tidak ada buku yang cocok dengan
                            pencarian atau kategori yang dipilih.

                        </div>
                    `;

        }


        /*
        | SEARCH STATUS
        */

        const status =
            document.getElementById('searchStatus');


        if (status) {

            if (currentQuery) {

                status.textContent =
                    `${filteredBooks.length} hasil untuk "${currentQuery}"`;

            } else {

                status.textContent = '';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL CATALOG
    |--------------------------------------------------------------------------
    */

    applyFilters();


    /*
    |--------------------------------------------------------------------------
    | CATEGORY EVENT
    |--------------------------------------------------------------------------
    */

    if (filtersElement) {

        filtersElement.addEventListener(
            'click',
            function (event) {

                const chip =
                    event.target.closest('.chip');


                if (!chip) {
                    return;
                }


                filtersElement
                    .querySelectorAll('.chip')
                    .forEach(item => {

                        item.classList.remove('active');

                    });


                chip.classList.add('active');


                currentCategory =
                    chip.dataset.cat || 'Semua';


                applyFilters();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    const searchInput =
        document.getElementById('searchInput');

    const searchButton =
        document.getElementById('searchBtn');


    function doSearch() {

        if (!searchInput) {
            return;
        }


        currentQuery =
            searchInput.value.trim();


        applyFilters();


        const catalog =
            document.getElementById('catalog');


        if (currentQuery && catalog) {

            catalog.scrollIntoView({

                behavior: 'smooth',

                block: 'start'

            });

        }

    }


    if (searchButton) {

        searchButton.addEventListener(
            'click',
            doSearch
        );

    }


    if (searchInput) {

        searchInput.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    doSearch();

                }

            }
        );


        /*
        | Jika input dikosongkan,
        | tampilkan kembali semua buku.
        */

        searchInput.addEventListener(
            'input',
            function () {

                if (
                    searchInput.value.trim() === '' &&
                    currentQuery !== ''
                ) {

                    currentQuery = '';

                    applyFilters();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CART CONFIGURATION
    |--------------------------------------------------------------------------
    */

    const STORE_WA_NUMBER =
        '6281315717719';

    const CART_KEY =
        'bacadulu_cart';


    let cart = [];


    try {

        const savedCart =
            JSON.parse(
                localStorage.getItem(CART_KEY) || '[]'
            );


        cart =
            Array.isArray(savedCart)
                ? savedCart
                : [];

    } catch (error) {

        cart = [];

    }


    /*
    |--------------------------------------------------------------------------
    | CART HELPERS
    |--------------------------------------------------------------------------
    */

    function saveCart() {

        localStorage.setItem(
            CART_KEY,
            JSON.stringify(cart)
        );


        updateCartBadge();

        renderCartItems();

    }


    function cartItemCount() {

        return cart.reduce(

            (total, item) =>
                total + Number(item.qty || 0),

            0

        );

    }


    function cartTotal() {

        return cart.reduce(

            (total, item) =>
                total +
                (
                    Number(item.priceNum || 0) *
                    Number(item.qty || 0)
                ),

            0

        );

    }


    /*
    |--------------------------------------------------------------------------
    | ADD CART
    |--------------------------------------------------------------------------
    */

    function addToCart(bookId) {

        const numericBookId =
            Number(bookId);


        const book =
            books.find(
                item =>
                    Number(item.id) === numericBookId
            );


        if (!book) {
            return;
        }


        const existing =
            cart.find(
                item =>
                    Number(item.id) === numericBookId
            );


        if (existing) {

            existing.qty =
                Number(existing.qty || 0) + 1;

        } else {

            cart.push({

                id: book.id,

                title: book.title,

                author: book.author,

                priceNum: Number(book.priceNum),

                qty: 1

            });

        }


        saveCart();

        bumpCartCount();

    }


    /*
    |--------------------------------------------------------------------------
    | CHANGE QUANTITY
    |--------------------------------------------------------------------------
    */

    function changeQty(bookId, delta) {

        const numericBookId =
            Number(bookId);


        const item =
            cart.find(
                cartItem =>
                    Number(cartItem.id) === numericBookId
            );


        if (!item) {
            return;
        }


        item.qty =
            Number(item.qty || 0) + delta;


        if (item.qty <= 0) {

            cart =
                cart.filter(
                    cartItem =>
                        Number(cartItem.id) !== numericBookId
                );

        }


        saveCart();

    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE CART
    |--------------------------------------------------------------------------
    */

    function removeFromCart(bookId) {

        const numericBookId =
            Number(bookId);


        cart =
            cart.filter(
                item =>
                    Number(item.id) !== numericBookId
            );


        saveCart();

    }


    /*
    |--------------------------------------------------------------------------
    | CART BADGE
    |--------------------------------------------------------------------------
    */

    function updateCartBadge() {

        const countElement =
            document.getElementById('cartCount');

        const checkoutButton =
            document.getElementById('checkoutBtn');


        const count =
            cartItemCount();


        if (countElement) {

            countElement.textContent =
                count;

            countElement.classList.toggle(
                'hide',
                count === 0
            );

        }


        if (checkoutButton) {

            checkoutButton.disabled =
                count === 0;

        }

    }


    function bumpCartCount() {

        const countElement =
            document.getElementById('cartCount');


        if (!countElement) {
            return;
        }


        countElement.classList.remove('pop');


        void countElement.offsetWidth;


        countElement.classList.add('pop');

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER CART
    |--------------------------------------------------------------------------
    */

    function renderCartItems() {

        const wrapper =
            document.getElementById('cartItemsWrap');

        const totalText =
            document.getElementById('cartTotalText');


        if (!wrapper || !totalText) {
            return;
        }


        if (cart.length === 0) {

            wrapper.innerHTML = `

                <p class="cart-empty">

                    Keranjang masih kosong.
                    <br>

                    Yuk pilih buku dari katalog di atas.

                </p>

            `;

        } else {

            wrapper.innerHTML =
                cart
                    .map(item => `

                        <div class="cart-item">

                            <div class="ci-info">


                                <div class="ci-title">

                                    ${escapeHtml(item.title)}

                                </div>


                                <div class="ci-author">

                                    ${escapeHtml(item.author)}

                                </div>


                                <div class="ci-row">


                                    <div class="qty-ctrl">

                                        <button
                                            type="button"
                                            data-action="dec"
                                            data-id="${item.id}"
                                        >
                                            −
                                        </button>


                                        <span>

                                            ${item.qty}

                                        </span>


                                        <button
                                            type="button"
                                            data-action="inc"
                                            data-id="${item.id}"
                                        >
                                            +
                                        </button>

                                    </div>


                                    <div class="ci-price">

                                        ${formatRupiah(
                                            Number(item.priceNum) *
                                            Number(item.qty)
                                        )}

                                    </div>


                                </div>


                                <button
                                    type="button"
                                    class="ci-remove"
                                    data-action="remove"
                                    data-id="${item.id}"
                                >
                                    Hapus
                                </button>


                            </div>

                        </div>

                    `)
                    .join('');

        }


        totalText.textContent =
            formatRupiah(
                cartTotal()
            );

    }


    /*
    |--------------------------------------------------------------------------
    | CART ITEM EVENT
    |--------------------------------------------------------------------------
    */

    const cartItemsWrapper =
        document.getElementById('cartItemsWrap');


    if (cartItemsWrapper) {

        cartItemsWrapper.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest('[data-action]');


                if (!button) {
                    return;
                }


                const bookId =
                    button.dataset.id;

                const action =
                    button.dataset.action;


                if (action === 'inc') {

                    changeQty(
                        bookId,
                        1
                    );

                }


                if (action === 'dec') {

                    changeQty(
                        bookId,
                        -1
                    );

                }


                if (action === 'remove') {

                    removeFromCart(
                        bookId
                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ADD BUTTON EVENT DELEGATION
    |--------------------------------------------------------------------------
    */

    function bindAddButtons(container) {

        if (!container) {
            return;
        }


        container.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest('.add-btn');


                if (!button) {
                    return;
                }


                addToCart(
                    button.dataset.id
                );


                button.classList.add('added');


                window.setTimeout(
                    function () {

                        button.classList.remove('added');

                    },
                    160
                );

            }
        );

    }


    bindAddButtons(
        document.getElementById('shelf')
    );


    bindAddButtons(
        document.getElementById('catalogGrid')
    );


    /*
    |--------------------------------------------------------------------------
    | OPEN / CLOSE CART
    |--------------------------------------------------------------------------
    */

    function openCart() {

        const drawer =
            document.getElementById('cartDrawer');

        const overlay =
            document.getElementById('cartOverlay');


        if (drawer) {

            drawer.classList.add('open');

        }


        if (overlay) {

            overlay.classList.add('show');

        }


        document.body.style.overflow =
            'hidden';

    }


    function closeCart() {

        const drawer =
            document.getElementById('cartDrawer');

        const overlay =
            document.getElementById('cartOverlay');


        if (drawer) {

            drawer.classList.remove('open');

        }


        if (overlay) {

            overlay.classList.remove('show');

        }


        document.body.style.overflow =
            '';

    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT WHATSAPP
    |--------------------------------------------------------------------------
    */

    function checkoutViaWhatsApp() {

        if (cart.length === 0) {
            return;
        }


        const orderLines =
            cart
                .map(
                    (item, index) => {

                        const subtotal =
                            Number(item.priceNum) *
                            Number(item.qty);


                        return (
                            `${index + 1}. ` +
                            `${item.title} ` +
                            `(${item.qty}x) - ` +
                            `${formatRupiah(subtotal)}`
                        );

                    }
                )
                .join('\n');


        const message =

            `Halo, saya ingin memesan buku berikut dari Baca Dulu Bookstore:\n\n` +

            `${orderLines}\n\n` +

            `Total: ${formatRupiah(cartTotal())}\n\n` +

            `Mohon informasi mengenai stok, ongkir, dan cara pembayarannya. Terima kasih.`;


        const url =

            `https://wa.me/${STORE_WA_NUMBER}` +

            `?text=${encodeURIComponent(message)}`;


        window.open(
            url,
            '_blank',
            'noopener,noreferrer'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | BUTTON EVENTS
    |--------------------------------------------------------------------------
    */

    const cartFab =
        document.getElementById('cartFab');

    const cartClose =
        document.getElementById('cartClose');

    const cartOverlay =
        document.getElementById('cartOverlay');

    const checkoutButton =
        document.getElementById('checkoutBtn');


    if (cartFab) {

        cartFab.addEventListener(
            'click',
            openCart
        );

    }


    if (cartClose) {

        cartClose.addEventListener(
            'click',
            closeCart
        );

    }


    if (cartOverlay) {

        cartOverlay.addEventListener(
            'click',
            closeCart
        );

    }


    if (checkoutButton) {

        checkoutButton.addEventListener(
            'click',
            checkoutViaWhatsApp
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESC CLOSE CART
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeCart();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIALIZE
    |--------------------------------------------------------------------------
    */

    updateCartBadge();

    renderCartItems();

</script>

@endsection