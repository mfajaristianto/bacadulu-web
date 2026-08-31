<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Terjadi Kendala') - Baca Dulu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    @vite('resources/js/error-page.js')

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            background: #F7F8FB;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            background: #F7F8FB;
            color: #241B52;
            font-family: 'Inter', sans-serif;
        }

        .error-page {
            position: relative;
            width: 100%;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 18px;
            overflow: hidden;
            isolation: isolate;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(239, 88, 67, .12),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 85%,
                    rgba(247, 170, 53, .13),
                    transparent 30%
                ),
                #F7F8FB;
        }

        .error-grid {
            position: absolute;
            inset: 0;
            z-index: -4;
            opacity: .32;
            pointer-events: none;
            background-image:
                linear-gradient(
                    rgba(36, 27, 82, .045) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(36, 27, 82, .045) 1px,
                    transparent 1px
                );
            background-size: 42px 42px;
            mask-image: linear-gradient(
                to bottom,
                rgba(0, 0, 0, .55),
                transparent 90%
            );
        }

        .error-orb {
            position: absolute;
            z-index: -3;
            border-radius: 50%;
            pointer-events: none;
            will-change: transform;
        }

        .error-orb.one {
            width: 320px;
            height: 320px;
            left: -140px;
            top: -120px;
            background: radial-gradient(
                circle at 40% 40%,
                rgba(239, 88, 67, .28),
                rgba(239, 88, 67, .06) 55%,
                transparent 72%
            );
        }

        .error-orb.two {
            width: 390px;
            height: 390px;
            right: -190px;
            bottom: -180px;
            background: radial-gradient(
                circle at 40% 40%,
                rgba(247, 170, 53, .27),
                rgba(247, 170, 53, .06) 55%,
                transparent 72%
            );
        }

        .error-orb.three {
            width: 130px;
            height: 130px;
            right: 14%;
            top: 11%;
            border: 26px solid rgba(36, 27, 82, .045);
        }

        .error-decoration {
            position: absolute;
            z-index: -2;
            pointer-events: none;
        }

        .error-decoration.line-one {
            width: 160px;
            height: 2px;
            left: 7%;
            bottom: 16%;
            background: linear-gradient(
                90deg,
                transparent,
                #EF5843,
                #F7AA35
            );
            transform: rotate(-18deg);
        }

        .error-decoration.line-two {
            width: 110px;
            height: 2px;
            right: 10%;
            top: 23%;
            opacity: .16;
            background: linear-gradient(
                90deg,
                #241B52,
                rgba(36, 27, 82, 0)
            );
            transform: rotate(26deg);
        }

        .error-shell {
            position: relative;
            width: min(100%, 760px);
            margin: auto;
            perspective: 1200px;
        }

        .error-card {
            position: relative;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(36, 27, 82, .08);
            border-radius: 28px;
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(16px);
            box-shadow:
                0 30px 80px rgba(36, 27, 82, .13),
                0 5px 18px rgba(36, 27, 82, .04);
            transform-style: preserve-3d;
            will-change: transform;
        }

        .error-card::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            right: -130px;
            top: -130px;
            border-radius: 50%;
            background: radial-gradient(
                circle,
                rgba(247, 170, 53, .13),
                transparent 68%
            );
            pointer-events: none;
        }

        .error-top {
            height: 7px;
            background: linear-gradient(
                90deg,
                #241B52,
                #EF5843,
                #F7AA35
            );
        }

        .error-content {
            position: relative;
            padding: 34px 48px 38px;
            text-align: center;
        }

        .error-visual {
            position: relative;
            width: 130px;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }

        .error-ring {
            position: absolute;
            inset: 0;
            border: 1px solid rgba(36, 27, 82, .08);
            border-radius: 50%;
            will-change: transform;
        }

        .error-ring::before {
            content: "";
            position: absolute;
            width: 9px;
            height: 9px;
            left: 11px;
            top: 32px;
            border-radius: 50%;
            background: #EF5843;
            box-shadow: 0 0 0 6px rgba(239, 88, 67, .08);
        }

        .error-ring::after {
            content: "";
            position: absolute;
            width: 7px;
            height: 7px;
            right: 15px;
            bottom: 28px;
            border-radius: 50%;
            background: #F7AA35;
            box-shadow: 0 0 0 5px rgba(247, 170, 53, .09);
        }

        .error-icon {
            position: relative;
            z-index: 2;
            width: 82px;
            height: 82px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(36, 27, 82, .08);
            border-radius: 24px;
            color: #241B52;
            background: linear-gradient(
                145deg,
                #FFFFFF,
                #F7F5FF
            );
            box-shadow:
                0 16px 34px rgba(36, 27, 82, .12),
                inset 0 1px 0 rgba(255, 255, 255, .9);
            transform-style: preserve-3d;
            will-change: transform;
        }

        .error-icon svg {
            width: 39px;
            height: 39px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.65;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .error-code {
            margin: 4px 0 0;
            color: #241B52;
            font-family: 'Poppins', sans-serif;
            font-size: clamp(64px, 10vw, 92px);
            font-weight: 800;
            line-height: .95;
            letter-spacing: -4px;
        }

        .error-code span {
            display: inline-block;
            will-change: transform;
        }

        .error-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            margin-top: 17px;
            padding: 6px 11px;
            border-radius: 999px;
            background: #F3F0FF;
            color: #51419A;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .error-title {
            max-width: 560px;
            margin: 13px auto 0;
            color: #241B52;
            font-family: 'Poppins', sans-serif;
            font-size: 26px;
            font-weight: 750;
            line-height: 1.3;
            letter-spacing: -.4px;
        }

        .error-description {
            max-width: 520px;
            margin: 9px auto 0;
            color: #6B7280;
            font-size: 11px;
            line-height: 1.75;
        }

        .error-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 23px;
        }

        .error-button {
            position: relative;
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 17px;
            overflow: hidden;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transform: translateZ(0);
        }

        button.error-button {
            appearance: none;
        }

        .error-button::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                110deg,
                transparent 20%,
                rgba(255, 255, 255, .22) 48%,
                transparent 75%
            );
            transform: translateX(-130%);
        }

        .error-button:hover::before {
            animation: errorButtonShine .7s ease forwards;
        }

        .error-button svg {
            width: 15px;
            height: 15px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .error-button-primary {
            border: 1px solid #241B52;
            background: #241B52;
            color: #fff;
        }

        .error-button-secondary {
            border: 1px solid #E2E8F0;
            background: #fff;
            color: #475569;
        }

        .error-note {
            max-width: 500px;
            margin: 20px auto 0;
            color: #A0A3AD;
            font-size: 8.5px;
            line-height: 1.65;
        }

        @keyframes errorButtonShine {
            from {
                transform: translateX(-130%);
            }

            to {
                transform: translateX(130%);
            }
        }

        @media (hover:hover) and (pointer:fine) {
            .error-button-primary:hover {
                background: #30266A;
            }

            .error-button-secondary:hover {
                border-color: #EF5843;
                color: #C6432F;
            }
        }

        /* LAYAR LAPTOP PENDEK */
        @media (max-height: 780px) and (min-width: 601px) {
            .error-page {
                align-items: flex-start;
                padding-top: 20px;
                padding-bottom: 20px;
                overflow: visible;
            }

            .error-content {
                padding: 25px 42px 29px;
            }

            .error-visual {
                width: 105px;
                height: 105px;
                margin-bottom: 4px;
            }

            .error-icon {
                width: 67px;
                height: 67px;
                border-radius: 20px;
            }

            .error-icon svg {
                width: 32px;
                height: 32px;
            }

            .error-ring::before {
                width: 7px;
                height: 7px;
                left: 8px;
                top: 27px;
            }

            .error-ring::after {
                width: 6px;
                height: 6px;
                right: 12px;
                bottom: 23px;
            }

            .error-code {
                font-size: 68px;
                margin-top: 0;
            }

            .error-label {
                margin-top: 13px;
            }

            .error-title {
                margin-top: 10px;
                font-size: 22px;
            }

            .error-description {
                margin-top: 7px;
                line-height: 1.65;
            }

            .error-actions {
                margin-top: 18px;
            }

            .error-note {
                margin-top: 15px;
            }
        }

        /* TABLET / MOBILE */
        @media (max-width: 600px) {
            .error-page {
                align-items: flex-start;
                min-height: 100dvh;
                padding: 18px 14px;
                overflow: visible;
            }

            .error-content {
                padding: 30px 19px 32px;
            }

            .error-card {
                border-radius: 22px;
            }

            .error-visual {
                width: 115px;
                height: 115px;
            }

            .error-icon {
                width: 73px;
                height: 73px;
                border-radius: 21px;
            }

            .error-icon svg {
                width: 35px;
                height: 35px;
            }

            .error-code {
                font-size: 70px;
                letter-spacing: -3px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-description {
                font-size: 10.5px;
            }

            .error-actions {
                flex-direction: column;
                margin-top: 21px;
            }

            .error-button {
                width: 100%;
            }

            .error-orb.three,
            .error-decoration {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .error-orb,
            .error-ring,
            .error-icon,
            .error-card,
            .error-code span {
                transform: none !important;
            }
        }
    </style>
</head>

<body>

@php
    $errorCode = trim($__env->yieldContent('code'));
@endphp

<div class="error-page" data-error-page>

    <div class="error-grid"></div>

    <div class="error-orb one" data-error-orb></div>
    <div class="error-orb two" data-error-orb></div>
    <div class="error-orb three" data-error-orb></div>

    <div class="error-decoration line-one"></div>
    <div class="error-decoration line-two"></div>

    <div class="error-shell">

        <div class="error-card" data-error-card>

            <div class="error-top"></div>

            <main class="error-content">

                <div class="error-visual" data-error-visual>

                    <div class="error-ring" data-error-ring></div>

                    <div class="error-icon" data-error-icon>

                        @if($errorCode === '404')

                            <svg viewBox="0 0 24 24">
                                <circle cx="10.5" cy="10.5" r="6"/>
                                <path d="M15 15l5 5"/>
                                <path d="M8.2 8.2l4.6 4.6"/>
                                <path d="M12.8 8.2l-4.6 4.6"/>
                            </svg>

                        @elseif($errorCode === '403')

                            <svg viewBox="0 0 24 24">
                                <path d="M12 3l7 3v5c0 4.7-2.8 8-7 10-4.2-2-7-5.3-7-10V6l7-3z"/>
                                <path d="M9.5 10.5l5 5"/>
                                <path d="M14.5 10.5l-5 5"/>
                            </svg>

                        @elseif($errorCode === '419')

                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8"/>
                                <path d="M12 7v5l3 2"/>
                                <path d="M5 5l2.2.5-.5 2.2"/>
                            </svg>

                        @elseif($errorCode === '429')

                            <svg viewBox="0 0 24 24">
                                <path d="M4 18h16"/>
                                <path d="M6 15l3-3 3 2 5-6"/>
                                <path d="M14.5 8H17v2.5"/>
                            </svg>

                        @elseif($errorCode === '503')

                            <svg viewBox="0 0 24 24">
                                <path d="M14.7 6.3a4 4 0 01-5 5L4 17l3 3 5.7-5.7a4 4 0 005-5l-2.3 2.3-3-3 2.3-2.3z"/>
                                <path d="M16.5 4.5l3 3"/>
                            </svg>

                        @elseif($errorCode === '500')

                            <svg viewBox="0 0 24 24">
                                <path d="M12 3L2.8 19h18.4L12 3z"/>
                                <path d="M12 9v4"/>
                                <path d="M12 16.5h.01"/>
                            </svg>

                        @else

                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 8v5"/>
                                <path d="M12 16h.01"/>
                            </svg>

                        @endif

                    </div>

                </div>

                <div class="error-code" data-error-code>
                    @foreach(str_split($errorCode) as $character)
                        <span>{{ $character }}</span>
                    @endforeach
                </div>

                <span class="error-label" data-error-item>
                    @yield('label')
                </span>

                <h1 class="error-title" data-error-item>
                    @yield('heading')
                </h1>

                <p class="error-description" data-error-item>
                    @yield('description')
                </p>

                <div class="error-actions" data-error-item>
                    @yield('actions')
                </div>

                <p class="error-note" data-error-item>
                    @yield(
                        'note',
                        'Jika kendala terus terjadi, silakan coba kembali beberapa saat lagi.'
                    )
                </p>

            </main>

        </div>

    </div>

</div>

</body>
</html>