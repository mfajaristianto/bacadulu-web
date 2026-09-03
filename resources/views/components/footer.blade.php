<footer id="main-footer" class="bd-footer">
    <div class="bd-footer-decoration" aria-hidden="true"></div>

    <div class="bd-footer-container">
        <div class="bd-footer-grid">

            {{-- BRAND --}}
            <div class="bd-footer-column">
                <div>
                    <h3 class="bd-footer-title">
                        Baca Dulu,
                        <span>Pahami Kemudian.</span>
                    </h3>

                    <p class="bd-footer-description">
                        Platform edukasi dan pelatihan berbasis informasi yang berkualitas
                        untuk mendukung pembelajaran berkelanjutan.
                    </p>
                </div>

                <div class="bd-footer-company">
                    <img
                        src="{{ asset('img/Bina.jpg') }}"
                        alt="PT. Bina Cendikia Academy"
                        loading="lazy"
                    >
                </div>
            </div>

            {{-- LOCATION --}}
            <div class="bd-footer-column">
                <h4 class="bd-footer-heading">Lokasi Kantor</h4>

                <div class="bd-footer-location">
                    <h5>
                        <span></span>
                        The Manhattan Square
                    </h5>

                    <p>
                        Jl. TB Simatupang, Lt 12, RT.3/RW.3, Cilandak Tim.,
                        Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta.
                    </p>
                </div>

                <div class="bd-footer-map">
                    <iframe
                        src="https://maps.google.com/maps?q=The%20Manhattan%20Square%2C%20Jl.%20TB%20Simatupang%2C%20Jakarta%20Selatan&t=&z=16&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi kantor Baca Dulu"
                    ></iframe>
                </div>
            </div>

            {{-- CONTACT --}}
            <div class="bd-footer-column">
                <h4 class="bd-footer-heading">Hubungi Kami</h4>

                <div class="bd-footer-contact-list">
                    <a
                        href="mailto:admnbacadulu.net@gmail.com"
                        class="bd-footer-contact"
                    >
                        <span class="bd-footer-contact-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </span>

                        <span>admnbacadulu.net@gmail.com</span>
                    </a>

                    <a
                        href="https://wa.me/6285139461070"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="bd-footer-contact"
                    >
                        <span class="bd-footer-contact-icon">
                            <img
                                src="{{ asset('img/waa.jpg') }}"
                                alt=""
                            >
                        </span>

                        <span>+62 851-3946-1070</span>
                    </a>
                </div>

                <div class="bd-footer-social-area">
                    <h5>Ikuti Kami</h5>

                    <div class="bd-footer-socials">
                        <a
                            href="https://www.youtube.com/@Bacaduluofficial"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="YouTube Baca Dulu"
                        >
                            <svg class="bd-social-icon bd-social-icon--fill" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.516 0-9.387.507a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.507 9.387.507 9.387.507s7.517 0 9.387-.507a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>

                        <a
                            href="https://www.instagram.com/bacaduluofficial/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram Baca Dulu"
                        >
                            <svg class="bd-social-icon bd-social-icon--instagram" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="2.5" y="2.5" width="19" height="19" rx="5.5"/>
                                <circle cx="12" cy="12" r="4.25"/>
                                <circle class="bd-social-instagram-dot" cx="17.6" cy="6.45" r="1.15"/>
                            </svg>
                        </a>

                        <a
                            href="https://www.tiktok.com/@mpl.id.official"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="TikTok"
                        >
                            <svg class="bd-social-icon bd-social-icon--fill" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 11-2.88-2.89h.54V9.66h-.54a6.33 6.33 0 106.33 6.33V8.89a8.16 8.16 0 004.25 1.15V6.69z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="bd-footer-bottom">
            <p>
                Copyright © {{ now()->year }} BacaDulu. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<style>
.bd-footer{
    position:relative;
    width:100%;
    max-width:100%;
    overflow:hidden;
    padding:76px 0 22px;
    background:#111122;
    color:#D1D5DB;
}

.bd-footer *{
    box-sizing:border-box;
}

.bd-footer-decoration{
    position:absolute;
    inset:0;
    opacity:.11;
    pointer-events:none;
    background:
        radial-gradient(circle at 100% 0,rgba(255,170,0,.65),transparent 35%),
        radial-gradient(circle at 0 100%,rgba(36,27,82,.8),transparent 42%);
}

.bd-footer-container{
    position:relative;
    z-index:2;
    width:min(calc(100% - 48px),1280px);
    margin:0 auto;
}

.bd-footer-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:60px;
    padding-bottom:52px;
}

.bd-footer-column{
    min-width:0;
}

.bd-footer-title{
    margin:0;
    color:#fff;
    font-size:31px;
    line-height:1.12;
    font-weight:850;
    letter-spacing:-.04em;
}

.bd-footer-title span{
    display:block;
    color:#ffaa00;
}

.bd-footer-description{
    max-width:390px;
    margin:17px 0 0;
    color:#9CA3AF;
    font-size:12px;
    line-height:1.75;
}

/* LOGO COMPANY */
.bd-footer-company{
    width:min(200px,100%);
    margin-top:24px;
    margin-left:48px;
}

.bd-footer-company img{
    display:block;
    width:100%;
    height:auto;
    border-radius:13px;
    box-shadow:0 15px 35px rgba(0,0,0,.22);
}

.bd-footer-heading{
    margin:0 0 20px;
    color:#fff;
    font-size:17px;
    font-weight:800;
}

.bd-footer-location h5{
    display:flex;
    align-items:center;
    gap:9px;
    margin:0;
    color:#fff;
    font-size:12px;
    font-weight:750;
}

.bd-footer-location h5 span{
    width:7px;
    height:7px;
    flex:0 0 auto;
    border-radius:50%;
    background:#ffaa00;
}

.bd-footer-location p{
    margin:7px 0 0;
    color:#9CA3AF;
    font-size:10px;
    line-height:1.7;
}

.bd-footer-map{
    width:100%;
    height:240px;
    margin-top:18px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,.1);
    border-radius:14px;
    background:#0F172A;
    box-shadow:0 15px 30px rgba(0,0,0,.2);
}

.bd-footer-map iframe{
    display:block;
    width:100%;
    height:100%;
}

.bd-footer-contact-list{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.bd-footer-contact{
    display:flex;
    align-items:center;
    gap:11px;
    min-width:0;
    color:#D1D5DB!important;
    font-size:11px;
    font-weight:650;
    text-decoration:none!important;
}

.bd-footer-contact>span:last-child{
    min-width:0;
    overflow-wrap:anywhere;
}

.bd-footer-contact-icon{
    width:39px;
    height:39px;
    flex:0 0 auto;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(255,255,255,.1);
    border-radius:50%;
    background:rgba(255,255,255,.05);
}

.bd-footer-contact-icon svg{
    width:17px;
    height:17px;
    fill:currentColor;
}

.bd-footer-contact-icon img{
    width:18px;
    height:18px;
    object-fit:cover;
    border-radius:50%;
}

.bd-footer-social-area{
    margin-top:25px;
}

.bd-footer-social-area h5{
    margin:0 0 12px;
    color:#9CA3AF;
    font-size:9px;
    font-weight:750;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-footer-socials{
    display:flex;
    align-items:center;
    gap:10px;
}

.bd-footer-socials a{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(255,255,255,.1);
    border-radius:50%;
    color:#D1D5DB!important;
    text-decoration:none!important;
    transition:
        color .2s ease,
        background .2s ease,
        border-color .2s ease,
        transform .2s ease;
}

.bd-footer-socials .bd-social-icon{
    width:20px;
    height:20px;
    display:block;
}

.bd-footer-socials .bd-social-icon--fill{
    fill:currentColor;
    stroke:none;
}

.bd-footer-socials .bd-social-icon--instagram{
    fill:none;
    stroke:currentColor;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-footer-socials .bd-social-instagram-dot{
    fill:currentColor;
    stroke:none;
}

.bd-footer-bottom{
    display:flex;
    align-items:center;
    justify-content:center;
    padding-top:21px;
    border-top:1px solid rgba(255,255,255,.06);
}

.bd-footer-bottom p{
    margin:0;
    color:#6B7280;
    font-size:10px;
}

@media(hover:hover) and (pointer:fine){
    .bd-footer-contact:hover{
        color:#ffaa00!important;
    }

    .bd-footer-socials a:hover{
        color:#111122!important;
        border-color:#ffaa00;
        background:#ffaa00;
        transform:translateY(-2px);
    }
}

/* TABLET */
@media(max-width:900px){
    .bd-footer-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:45px;
    }

    .bd-footer-column:first-child{
        grid-column:1/-1;
    }

    .bd-footer-company{
        margin-left:0;
    }
}

/* PHONE */
@media(max-width:600px){
    .bd-footer{
        padding-top:58px;
    }

    .bd-footer-container{
        width:100%;
        padding:0 17px;
    }

    .bd-footer-grid{
        grid-template-columns:1fr;
        gap:38px;
        padding-bottom:40px;
    }

    .bd-footer-column:first-child{
        grid-column:auto;
    }

    .bd-footer-title{
        font-size:29px;
    }

    .bd-footer-description{
        font-size:11px;
    }

    .bd-footer-company{
        width:min(200px,72%);
        margin:24px auto 0;
    }

    .bd-footer-map{
        height:220px;
    }

    .bd-footer-bottom{
        text-align:center;
    }
}
</style>