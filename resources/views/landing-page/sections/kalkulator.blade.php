<section id="kalkulator" class="bd-calc-section">

    <div class="bd-calc-ambient bd-calc-ambient-one"></div>
    <div class="bd-calc-ambient bd-calc-ambient-two"></div>

    <div class="bd-calc-wrap">

        {{-- HEADER --}}
        <div class="bd-calc-heading" data-bd-reveal="up">

            <div class="bd-calc-eyebrow">
                <span class="bd-calc-eyebrow-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="4" y="2" width="16" height="20" rx="2"/>
                        <path d="M8 6h8M8 11h2M14 11h2M8 15h2M14 15h2"/>
                    </svg>
                </span>

                <span>Simulasi Biaya</span>
            </div>

            <h2>
                Kalkulator Simulasi
                <span>Penerbitan</span>
            </h2>

            <p>
                Dapatkan gambaran awal biaya penerbitan buku berdasarkan
                paket, jumlah halaman, dan kebutuhan cetak Anda.
            </p>

        </div>


        {{-- CALCULATOR --}}
        <div data-bd-reveal="zoom">

            <div class="bd-calculator" data-bd-tilt>

                <div class="bd-calc-spectrum"></div>


                {{-- LEFT FORM --}}
                <div class="bd-calc-form">

                    <div class="bd-calc-panel-heading">

                        <div>
                            <span class="bd-calc-panel-kicker">
                                Pilih Kebutuhan
                            </span>

                            <h3>
                                Detail Penerbitan
                            </h3>
                        </div>

                    </div>


                    {{-- PAKET --}}
                    <div class="bd-calc-group">

                        <label for="calcPaket">
                            Jenis Paket
                        </label>

                        <div class="bd-calc-field-wrap">

                            <span class="bd-calc-field-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M4 7l8-4 8 4-8 4-8-4z"/>
                                    <path d="M4 12l8 4 8-4"/>
                                    <path d="M4 17l8 4 8-4"/>
                                </svg>
                            </span>

                            <select
                                id="calcPaket"
                                onchange="hitungSimulasi()"
                                class="bd-calc-field"
                            >
                                <option value="500000">
                                    Paket Hemat (E-Book & ISBN) - Rp 500.000
                                </option>

                                <option value="1200000" selected>
                                    Paket Premium (Cetak + ISBN + Layout) - Rp 1.200.000
                                </option>

                                <option value="2500000">
                                    Paket Eksklusif (Cetak + ISBN + HAKI) - Rp 2.500.000
                                </option>
                            </select>

                        </div>

                    </div>


                    {{-- HALAMAN --}}
                    <div class="bd-calc-group">

                        <label for="calcHalaman">
                            Jumlah Halaman Buku
                        </label>

                        <div class="bd-calc-field-wrap">

                            <span class="bd-calc-field-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M6 3h9l3 3v15H6z"/>
                                    <path d="M14 3v4h4"/>
                                    <path d="M9 11h6M9 15h6"/>
                                </svg>
                            </span>

                            <input
                                type="number"
                                id="calcHalaman"
                                oninput="hitungSimulasi()"
                                value="150"
                                min="50"
                                max="1000"
                                class="bd-calc-field"
                            >

                            <span class="bd-calc-unit">
                                Halaman
                            </span>

                        </div>

                    </div>


                    {{-- JUMLAH CETAK --}}
                    <div class="bd-calc-group">

                        <label for="calcCetak">
                            Jumlah Buku Fisik
                        </label>

                        <div class="bd-calc-field-wrap">

                            <span class="bd-calc-field-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M5 4h11v16H5z"/>
                                    <path d="M8 2h11v16"/>
                                </svg>
                            </span>

                            <input
                                type="number"
                                id="calcCetak"
                                oninput="hitungSimulasi()"
                                value="10"
                                min="5"
                                max="500"
                                class="bd-calc-field"
                            >

                            <span class="bd-calc-unit">
                                Buku
                            </span>

                        </div>

                    </div>


                    {{-- INFO --}}
                    <div class="bd-calc-info">

                        <span class="bd-calc-info-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 11v5M12 8h.01"/>
                            </svg>
                        </span>

                        <p>
                            Simulasi ini merupakan estimasi awal.
                            Biaya final disesuaikan setelah pemeriksaan
                            naskah dan kebutuhan produksi.
                        </p>

                    </div>

                </div>


                {{-- RIGHT RESULT --}}
                <div class="bd-calc-result">

                    <div class="bd-calc-result-decoration"></div>


                    <div class="bd-calc-panel-heading">

                        <div class="bd-calc-result-heading-left">

                            <span class="bd-calc-result-heading-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M4 5h16v14H4z"/>
                                    <path d="M8 9h8M8 13h3"/>
                                </svg>
                            </span>

                            <div>
                                <span class="bd-calc-panel-kicker">
                                    Estimasi
                                </span>

                                <h3>
                                    Rincian Biaya
                                </h3>
                            </div>

                        </div>

                    </div>


                    {{-- BREAKDOWN --}}
                    <div class="bd-calc-breakdown">

                        <div class="bd-calc-row">

                            <div class="bd-calc-row-label">
                                <span>
                                    Harga Paket Dasar
                                </span>

                                <small>
                                    Paket penerbitan pilihan Anda
                                </small>
                            </div>

                            <strong
                                id="resPaket"
                                data-value="1200000"
                            >
                                Rp 1.200.000
                            </strong>

                        </div>


                        <div class="bd-calc-row">

                            <div class="bd-calc-row-label">
                                <span>
                                    Tambahan Halaman
                                </span>

                                <small>
                                    Dihitung setelah 100 halaman
                                </small>
                            </div>

                            <strong
                                id="resHalaman"
                                data-value="100000"
                            >
                                Rp 100.000
                            </strong>

                        </div>


                        <div class="bd-calc-row">

                            <div class="bd-calc-row-label">
                                <span>
                                    Tambahan Cetak
                                </span>

                                <small>
                                    Dihitung setelah 10 eksemplar
                                </small>
                            </div>

                            <strong
                                id="resCetak"
                                data-value="0"
                            >
                                Rp 0
                            </strong>

                        </div>

                    </div>


                    {{-- TOTAL --}}
                    <div class="bd-calc-total">

                        <div class="bd-calc-total-head">

                            <div>
                                <span>
                                    Total Estimasi
                                </span>

                                <small>
                                    Perkiraan biaya penerbitan
                                </small>
                            </div>

                            <span class="bd-calc-total-badge">
                                ESTIMASI
                            </span>

                        </div>


                        <h3
                            id="resTotal"
                            data-value="1300000"
                        >
                            Rp 1.300.000
                        </h3>


                        <div class="bd-calc-price-line"></div>


                        <p class="bd-calc-disclaimer">
                            *Harga akhir dapat berubah sesuai jumlah halaman,
                            spesifikasi buku, jenis kertas, finishing, dan
                            kebutuhan penerbitan.
                        </p>


                        {{-- WHATSAPP --}}
                        <a
                            href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku."
                            target="_blank"
                            rel="noopener noreferrer"
                            class="bd-calc-wa"
                        >

                            <span class="bd-calc-wa-icon">

                                <img
                                    src="{{ asset('img/waa.jpg') }}"
                                    alt="WhatsApp"
                                >

                            </span>


                            <span class="bd-calc-wa-text">
                                Konsultasi via WhatsApp
                            </span>


                            <svg
                                class="bd-calc-wa-arrow"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path d="M9 5l7 7-7 7"/>
                            </svg>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<style>
/* =========================================================
   ROOT
========================================================= */

.bd-calc-section{
    --bd-navy:#241B52;
    --bd-dark:#292A36;

    --bd-red-orange:#C94F35;
    --bd-orange:#D96A2B;
    --bd-amber:#E58A2B;
    --bd-gold:#F0A52E;
    --bd-yellow:#F2C94C;

    --bd-white:#FFFFFF;
    --bd-warm:#FFFCF8;
    --bd-cream:#FFF7ED;
    --bd-soft:#F8F7F5;

    --bd-muted:#74777E;
    --bd-border:#E9E2DA;

    position:relative;
    padding:76px 0;
    overflow:hidden;

    background:
        radial-gradient(
            circle at 95% 10%,
            rgba(242,201,76,.10),
            transparent 24%
        ),
        radial-gradient(
            circle at 3% 88%,
            rgba(217,106,43,.07),
            transparent 25%
        ),
        linear-gradient(
            180deg,
            #FFFFFF 0%,
            #FFFCF8 100%
        );

    font-family:'Inter',sans-serif;
}

.bd-calc-section *,
.bd-calc-section *::before,
.bd-calc-section *::after{
    box-sizing:border-box;
}

.bd-calc-section a{
    text-decoration:none;
}


/* =========================================================
   WRAPPER
========================================================= */

.bd-calc-wrap{
    position:relative;
    z-index:3;

    width:min(
        calc(100% - 40px),
        1050px
    );

    margin:0 auto;
}


/* =========================================================
   AMBIENT
========================================================= */

.bd-calc-ambient{
    position:absolute;
    border-radius:50%;
    pointer-events:none;
    filter:blur(105px);
}

.bd-calc-ambient-one{
    width:300px;
    height:300px;

    left:-190px;
    top:70px;

    background:
        rgba(36,27,82,.10);
}

.bd-calc-ambient-two{
    width:340px;
    height:340px;

    right:-210px;
    bottom:0;

    background:
        rgba(229,138,43,.16);
}


/* =========================================================
   HEADER
========================================================= */

.bd-calc-heading{
    max-width:690px;

    margin:
        0 auto
        36px;

    text-align:center;
}

.bd-calc-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;

    color:var(--bd-orange);

    font-size:9px;
    font-weight:850;

    letter-spacing:.15em;
    text-transform:uppercase;
}

.bd-calc-eyebrow-icon{
    width:30px;
    height:30px;

    display:grid;
    place-items:center;

    border:
        1px solid
        rgba(217,106,43,.18);

    border-radius:9px;

    color:var(--bd-orange);

    background:#FFF6EB;
}

.bd-calc-eyebrow-icon svg{
    width:15px;
    height:15px;

    fill:none;
    stroke:currentColor;
    stroke-width:1.8;

    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-calc-heading h2{
    margin:10px 0 0;

    color:var(--bd-navy);

    font-family:'Poppins',sans-serif;

    font-size:
        clamp(
            29px,
            4vw,
            38px
        );

    font-weight:750;

    line-height:1.18;

    letter-spacing:-1px;
}

.bd-calc-heading h2 span{
    background:
        linear-gradient(
            90deg,
            var(--bd-red-orange),
            var(--bd-orange),
            var(--bd-amber),
            var(--bd-gold)
        );

    -webkit-background-clip:text;
    background-clip:text;

    color:transparent;
}

.bd-calc-heading p{
    max-width:600px;

    margin:
        10px auto
        0;

    color:var(--bd-muted);

    font-size:12px;

    line-height:1.7;
}


/* =========================================================
   CALCULATOR
========================================================= */

.bd-calculator{
    position:relative;

    display:grid;

    grid-template-columns:
        minmax(0,1fr)
        minmax(0,1fr);

    gap:0;

    overflow:hidden;

    border:
        1px solid
        rgba(36,27,82,.10);

    border-radius:24px;

    background:#FFFFFF;

    box-shadow:
        0 24px 70px
        rgba(36,27,82,.10);

    transform-style:preserve-3d;
}


/* =========================================================
   ANIMATED BACA DULU LINE
========================================================= */

.bd-calc-spectrum{
    position:absolute;

    z-index:20;

    top:0;
    left:0;
    right:0;

    height:4px;

    background:
        linear-gradient(
            90deg,
            #C94F35 0%,
            #D96A2B 18%,
            #E58A2B 35%,
            #F0A52E 52%,
            #F2C94C 66%,
            #E58A2B 80%,
            #D96A2B 100%
        );

    background-size:
        270% 100%;

    animation:
        bdCalcSpectrumMove
        6s linear infinite;
}


/* =========================================================
   FORM
========================================================= */

.bd-calc-form{
    position:relative;

    padding:32px;

    background:
        linear-gradient(
            145deg,
            #FFFFFF 0%,
            #FFFDFC 100%
        );
}


/* =========================================================
   PANEL HEADING
========================================================= */

.bd-calc-panel-heading{
    display:flex;

    align-items:flex-start;

    justify-content:space-between;

    gap:20px;

    margin-bottom:25px;
}

.bd-calc-panel-kicker{
    display:block;

    margin-bottom:4px;

    color:var(--bd-orange);

    font-size:8px;

    font-weight:850;

    letter-spacing:.12em;

    text-transform:uppercase;
}

.bd-calc-panel-heading h3{
    margin:0;

    color:var(--bd-navy);

    font-family:'Poppins',sans-serif;

    font-size:17px;

    font-weight:700;

    letter-spacing:-.25px;
}


/* =========================================================
   FORM GROUP
========================================================= */

.bd-calc-group{
    margin-bottom:18px;
}

.bd-calc-group label{
    display:block;

    margin-bottom:7px;

    color:#60646C;

    font-size:9px;

    font-weight:800;

    letter-spacing:.06em;

    text-transform:uppercase;
}


/* =========================================================
   INPUT
========================================================= */

.bd-calc-field-wrap{
    position:relative;

    display:flex;

    align-items:center;
}

.bd-calc-field-icon{
    position:absolute;

    z-index:3;

    left:12px;

    width:30px;
    height:30px;

    display:grid;
    place-items:center;

    border:
        1px solid
        rgba(217,106,43,.10);

    border-radius:8px;

    color:var(--bd-orange);

    background:#FFF3E7;

    pointer-events:none;
}

.bd-calc-field-icon svg{
    width:15px;
    height:15px;

    fill:none;

    stroke:currentColor;

    stroke-width:1.7;

    stroke-linecap:round;

    stroke-linejoin:round;
}

.bd-calc-field{
    width:100%;

    min-height:52px;

    padding:
        0 82px
        0 52px;

    outline:none;

    border:
        1px solid
        #E7E5E2;

    border-radius:12px;

    color:var(--bd-navy);

    background:#F8F7F5;

    font-family:'Inter',sans-serif;

    font-size:11px;

    font-weight:650;

    transition:
        border-color .25s ease,
        background .25s ease,
        box-shadow .25s ease,
        transform .25s ease;
}

select.bd-calc-field{
    padding-right:38px;

    cursor:pointer;
}

.bd-calc-field:hover{
    border-color:
        rgba(217,106,43,.36);
}

.bd-calc-field:focus{
    border-color:var(--bd-orange);

    background:#FFFFFF;

    box-shadow:
        0 0 0 4px
        rgba(217,106,43,.08);

    transform:
        translateY(-1px);
}

.bd-calc-unit{
    position:absolute;

    z-index:3;

    right:13px;

    color:#95979B;

    font-size:8px;

    font-weight:750;

    pointer-events:none;
}


/* =========================================================
   INFO BOX
========================================================= */

.bd-calc-info{
    display:flex;

    align-items:flex-start;

    gap:9px;

    margin-top:22px;

    padding:
        12px 13px;

    border:
        1px solid
        #F0DECA;

    border-radius:11px;

    background:
        linear-gradient(
            135deg,
            #FFF9F1,
            #FFF4E4
        );
}

.bd-calc-info-icon{
    width:24px;
    height:24px;

    display:grid;
    place-items:center;

    flex:
        0 0 24px;

    border-radius:7px;

    color:var(--bd-orange);

    background:
        rgba(217,106,43,.09);
}

.bd-calc-info-icon svg{
    width:13px;
    height:13px;

    fill:none;

    stroke:currentColor;

    stroke-width:1.8;
}

.bd-calc-info p{
    margin:0;

    color:#77726D;

    font-size:8px;

    line-height:1.6;
}


/* =========================================================
   RESULT
========================================================= */

.bd-calc-result{
    position:relative;

    display:flex;

    flex-direction:column;

    padding:32px;

    overflow:hidden;

    border-left:
        1px solid
        rgba(36,27,82,.08);

    background:
        radial-gradient(
            circle at 100% 100%,
            rgba(242,201,76,.13),
            transparent 34%
        ),
        radial-gradient(
            circle at 0 0,
            rgba(217,106,43,.05),
            transparent 35%
        ),
        linear-gradient(
            145deg,
            #F8F8F7,
            #FFF8EE
        );
}

.bd-calc-result-decoration{
    position:absolute;

    width:190px;
    height:190px;

    right:-120px;
    top:-120px;

    border:
        30px solid
        rgba(229,138,43,.055);

    border-radius:50%;

    pointer-events:none;
}


/* =========================================================
   RESULT HEADING
========================================================= */

.bd-calc-result-heading-left{
    display:flex;

    align-items:center;

    gap:11px;
}

.bd-calc-result-heading-icon{
    width:38px;
    height:38px;

    display:grid;
    place-items:center;

    flex:
        0 0 38px;

    border-radius:11px;

    color:#FFFFFF;

    background:
        linear-gradient(
            135deg,
            #C94F35,
            #D96A2B 52%,
            #EFA02C
        );

    box-shadow:
        0 9px 22px
        rgba(217,106,43,.20);
}

.bd-calc-result-heading-icon svg{
    width:18px;
    height:18px;

    fill:none;

    stroke:currentColor;

    stroke-width:1.8;

    stroke-linecap:round;

    stroke-linejoin:round;
}


/* =========================================================
   BREAKDOWN
========================================================= */

.bd-calc-breakdown{
    position:relative;

    z-index:2;

    overflow:hidden;

    border:
        1px solid
        rgba(36,27,82,.075);

    border-radius:14px;

    background:
        rgba(255,255,255,.78);
}

.bd-calc-row{
    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    min-height:66px;

    padding:
        12px 14px;

    border-bottom:
        1px solid
        rgba(36,27,82,.07);
}

.bd-calc-row:last-child{
    border-bottom:0;
}

.bd-calc-row-label{
    min-width:0;
}

.bd-calc-row-label span{
    display:block;

    color:#50525B;

    font-size:9px;

    font-weight:750;
}

.bd-calc-row-label small{
    display:block;

    margin-top:3px;

    color:#97999E;

    font-size:7px;
}

.bd-calc-row strong{
    flex-shrink:0;

    color:var(--bd-navy);

    font-size:10px;

    font-weight:850;
}


/* =========================================================
   TOTAL
========================================================= */

.bd-calc-total{
    position:relative;

    z-index:2;

    margin-top:21px;
}

.bd-calc-total-head{
    display:flex;

    align-items:flex-end;

    justify-content:space-between;

    gap:16px;
}

.bd-calc-total-head > div > span{
    display:block;

    color:#5A5C63;

    font-size:9px;

    font-weight:850;

    letter-spacing:.07em;

    text-transform:uppercase;
}

.bd-calc-total-head > div > small{
    display:block;

    margin-top:2px;

    color:#A0A1A5;

    font-size:7px;
}

.bd-calc-total-badge{
    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:
        5px 8px;

    border:
        1px solid
        rgba(217,106,43,.14);

    border-radius:999px;

    color:var(--bd-orange);

    background:#FFF4E7;

    font-size:6.5px;

    font-weight:850;

    letter-spacing:.08em;
}


/* =========================================================
   ANIMATED TOTAL
========================================================= */

.bd-calc-total h3{
    display:inline-block;

    margin:
        8px 0
        8px;

    font-family:'Poppins',sans-serif;

    font-size:
        clamp(
            29px,
            4vw,
            37px
        );

    font-weight:850;

    line-height:1;

    letter-spacing:-1.3px;

    background:
        linear-gradient(
            90deg,
            #C94F35 0%,
            #D96A2B 20%,
            #E58A2B 38%,
            #F2C94C 54%,
            #E58A2B 69%,
            #D96A2B 84%,
            #C94F35 100%
        );

    background-size:
        280% auto;

    -webkit-background-clip:text;

    background-clip:text;

    color:transparent;

    animation:
        bdCalcPriceFlow
        5s linear infinite;
}

.bd-calc-price-line{
    width:100%;

    height:3px;

    margin-bottom:10px;

    border-radius:999px;

    background:
        linear-gradient(
            90deg,
            #C94F35,
            #D96A2B,
            #E58A2B,
            #F2C94C,
            #D96A2B
        );

    background-size:
        240% 100%;

    animation:
        bdCalcLineFlow
        5.5s linear infinite;
}

.bd-calc-disclaimer{
    margin:0;

    color:#929398;

    font-size:7.5px;

    line-height:1.55;
}


/* =========================================================
   WHATSAPP BUTTON
========================================================= */

.bd-calc-wa{
    position:relative;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    width:100%;

    min-height:53px;

    margin-top:17px;

    padding:
        9px 16px
        9px 10px;

    overflow:hidden;

    border-radius:12px;

    color:#FFFFFF!important;

    background:
        linear-gradient(
            105deg,
            #C94F35 0%,
            #D96A2B 34%,
            #E58A2B 68%,
            #F0A52E 100%
        );

    background-size:
        210% 100%;

    font-size:10.5px;

    font-weight:850;

    text-decoration:none!important;

    box-shadow:
        0 12px 25px
        rgba(217,106,43,.22);

    animation:
        bdCalcButtonFlow
        6s ease-in-out infinite;

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.bd-calc-wa::before{
    content:"";

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            110deg,
            transparent 23%,
            rgba(255,255,255,.30) 49%,
            transparent 75%
        );

    transform:
        translateX(-125%);

    transition:
        transform .65s ease;
}

.bd-calc-wa:hover::before{
    transform:
        translateX(125%);
}

.bd-calc-wa:hover{
    transform:
        translateY(-2px);

    box-shadow:
        0 17px 32px
        rgba(217,106,43,.28);
}


/* =========================================================
   WHATSAPP LOGO
========================================================= */

.bd-calc-wa-icon{
    position:relative;

    z-index:2;

    width:32px;
    height:32px;

    display:flex;

    align-items:center;

    justify-content:center;

    flex:
        0 0 32px;

    padding:3px;

    border-radius:50%;

    background:#FFFFFF;

    box-shadow:
        0 4px 12px
        rgba(0,0,0,.14);

    transition:
        transform .3s
        cubic-bezier(.22,1,.36,1),
        box-shadow .3s ease;
}

.bd-calc-wa-icon img{
    width:100%;
    height:100%;

    display:block;

    border-radius:50%;

    object-fit:cover;
}

.bd-calc-wa:hover
.bd-calc-wa-icon{
    transform:
        scale(1.08)
        rotate(-4deg);

    box-shadow:
        0 6px 16px
        rgba(0,0,0,.18);
}

.bd-calc-wa-text{
    position:relative;

    z-index:2;

    min-width:0;
}

.bd-calc-wa-arrow{
    position:relative;

    z-index:2;

    width:13px;
    height:13px;

    fill:none;

    stroke:currentColor;

    stroke-width:2;

    stroke-linecap:round;

    stroke-linejoin:round;

    transition:
        transform .25s ease;
}

.bd-calc-wa:hover
.bd-calc-wa-arrow{
    transform:
        translateX(3px);
}


/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes bdCalcSpectrumMove{

    from{
        background-position:
            0% center;
    }

    to{
        background-position:
            270% center;
    }

}

@keyframes bdCalcPriceFlow{

    from{
        background-position:
            0% center;
    }

    to{
        background-position:
            280% center;
    }

}

@keyframes bdCalcLineFlow{

    from{
        background-position:
            0% center;
    }

    to{
        background-position:
            240% center;
    }

}

@keyframes bdCalcButtonFlow{

    0%,
    100%{
        background-position:
            0% center;
    }

    50%{
        background-position:
            100% center;
    }

}


/* =========================================================
   TABLET
========================================================= */

@media(max-width:767px){

    .bd-calc-section{
        padding:
            58px 0;
    }

    .bd-calc-wrap{
        width:
            calc(100% - 28px);
    }

    .bd-calc-heading{
        margin-bottom:28px;
    }

    .bd-calc-heading h2{
        font-size:30px;
    }

    .bd-calculator{
        grid-template-columns:1fr;

        border-radius:19px;
    }

    .bd-calc-form,
    .bd-calc-result{
        padding:23px;
    }

    .bd-calc-result{
        border-left:0;

        border-top:
            1px solid
            rgba(36,27,82,.08);
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:430px){

    .bd-calc-wrap{
        width:
            calc(100% - 24px);
    }

    .bd-calc-heading h2{
        font-size:27px;
    }

    .bd-calc-heading p{
        font-size:11px;
    }

    .bd-calc-form,
    .bd-calc-result{
        padding:19px;
    }

    .bd-calc-panel-heading{
        margin-bottom:21px;
    }

    .bd-calc-field{
        min-height:50px;

        font-size:10px;
    }

    .bd-calc-row{
        min-height:62px;

        gap:10px;

        padding:
            11px 12px;
    }

    .bd-calc-row strong{
        font-size:9px;
    }

    .bd-calc-total-head{
        align-items:flex-start;
    }

    .bd-calc-total h3{
        font-size:29px;
    }

    .bd-calc-wa{
        min-height:52px;

        font-size:10px;
    }

    .bd-calc-wa-icon{
        width:30px;
        height:30px;

        flex-basis:30px;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){

    .bd-calc-spectrum,
    .bd-calc-total h3,
    .bd-calc-price-line,
    .bd-calc-wa{
        animation:none!important;
    }

}
</style>


<script>
function hitungSimulasi(){

    const paket =
        Number(
            document
                .getElementById('calcPaket')
                ?.value || 0
        );

    const halaman =
        Number(
            document
                .getElementById('calcHalaman')
                ?.value || 0
        );

    const cetak =
        Number(
            document
                .getElementById('calcCetak')
                ?.value || 0
        );


    const biayaHalaman =
        halaman > 100
            ? (halaman - 100) * 2000
            : 0;


    const biayaCetak =
        cetak > 10
            ? (cetak - 10) * 45000
            : 0;


    const total =
        paket +
        biayaHalaman +
        biayaCetak;


    const resPaket =
        document.getElementById(
            'resPaket'
        );

    const resHalaman =
        document.getElementById(
            'resHalaman'
        );

    const resCetak =
        document.getElementById(
            'resCetak'
        );

    const resTotal =
        document.getElementById(
            'resTotal'
        );


    if(window.bdAnimateMoney){

        window.bdAnimateMoney(
            resPaket,
            paket
        );

        window.bdAnimateMoney(
            resHalaman,
            biayaHalaman
        );

        window.bdAnimateMoney(
            resCetak,
            biayaCetak
        );

        window.bdAnimateMoney(
            resTotal,
            total
        );

        return;
    }


    const rupiah = value => {

        return 'Rp ' +
            Number(
                value || 0
            ).toLocaleString(
                'id-ID'
            );

    };


    if(resPaket){
        resPaket.textContent =
            rupiah(paket);
    }

    if(resHalaman){
        resHalaman.textContent =
            rupiah(biayaHalaman);
    }

    if(resCetak){
        resCetak.textContent =
            rupiah(biayaCetak);
    }

    if(resTotal){
        resTotal.textContent =
            rupiah(total);
    }

}


if(
    document.readyState ===
    'loading'
){

    document.addEventListener(
        'DOMContentLoaded',
        hitungSimulasi
    );

}
else{

    hitungSimulasi();

}
</script>