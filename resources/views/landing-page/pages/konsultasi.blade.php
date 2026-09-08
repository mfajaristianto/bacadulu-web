@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap');

.bd-consultation{
    --navy:#241B52;
    --orange:#EF5843;
    --muted:#96929C;
    --line:#E8E7EC;
    width:100%;
    min-height:100vh;
    overflow-x:hidden;
    background:#fff;
    font-family:'Inter',sans-serif;
}

.bd-consultation *,
.bd-consultation *::before,
.bd-consultation *::after{
    box-sizing:border-box;
}

.bd-consultation-shell{
    width:min(calc(100% - 72px),1260px);
    margin:auto;
}

/* BRAND — UKURAN DAN POSISI SAMA DENGAN BACA JURNAL */
.bd-consultation-brandbar{
    min-height:72px;
    display:flex;
    align-items:center;
    border-bottom:1px solid var(--line);
}

.bd-consultation-brand{
    display:inline-flex;
    align-items:center;
    gap:11px;
}

.bd-consultation-brand-mark{
    width:7px;
    height:27px;
    flex:0 0 7px;
    background:var(--orange);
}

.bd-consultation-brand-name{
    color:var(--navy);
    font-family:'Fraunces',serif;
    font-size:21px;
    font-weight:600;
}

.bd-consultation-brand-type{
    color:var(--muted);
    font-size:10px;
    font-weight:600;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.transition-hover{
    transition:transform .3s ease,box-shadow .3s ease;
}

.transition-hover:hover{
    transform:translateY(-5px);
    box-shadow:0 1rem 3rem rgba(0,0,0,.1)!important;
}

.logo-img{
    transition:transform .3s ease;
}

.transition-hover:hover .logo-img{
    transform:scale(1.05);
}

@media(max-width:800px){
    .bd-consultation-shell{
        width:calc(100% - 40px);
    }
}

@media(max-width:600px){
    .bd-consultation-shell{
        width:calc(100% - 30px);
    }

    .bd-consultation-brand-type{
        display:none;
    }
}
</style>

<section class="bd-consultation">

    <div class="bd-consultation-shell">

        {{-- BRAND --}}
        <div class="bd-consultation-brandbar">
            <div class="bd-consultation-brand">
                <span class="bd-consultation-brand-mark"></span>
                <span class="bd-consultation-brand-name">BacaDulu</span>
                <span class="bd-consultation-brand-type">Consultation</span>
            </div>
        </div>

    </div>

    <div class="container py-5">

        <!-- Header Section -->
        <div class="row justify-content-center text-center mb-5 animate__animated animate__fadeInDown">
            <div class="col-md-8">
                <span class="bg-primary/15 text-primary px-3 py-1 rounded-pill text-xs font-bold uppercase tracking-wider">
                    Layanan Profesional
                </span>

                <h1 class="fw-bold display-5 mt-3 text-dark">
                    Konsultasi Publikasi &amp; Legalitas
                </h1>

                <p class="text-muted lead">
                    Pilih jalur konsultasi terbaik untuk kebutuhan akademik, jurnal internasional, HKI, dan pengembangan bisnis Anda bersama pakar terpercaya.
                </p>
            </div>
        </div>

        <!-- Cards Katalog Konsultasi -->
        <div class="row g-4 justify-content-center">

            <!-- Kartu 1: Fermartian -->
            <div class="col-md-5 animate__animated animate__fadeInLeft">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-hover">

                    <div class="p-4 bg-white d-flex align-items-center justify-content-center border-bottom" style="height:200px;">
                        <img
                            src="{{ asset('img/Fermartian.jpg') }}"
                            alt="Fermartian Konsultasi"
                            class="img-fluid logo-img"
                            style="max-height:120px;object-fit:contain;"
                        >
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-success-subtle text-success mb-2 fw-semibold">
                                Fast Response via WhatsApp
                            </span>

                            <h4 class="fw-bold text-dark mb-2">
                                Konsultasi Langsung Ahli
                            </h4>

                            <p class="text-muted small">
                                Diskusi interaktif terkait hambatan naskah, percepatan jurnal, dan panduan teknis publikasi langsung bersama konsultan kami.
                            </p>
                        </div>

                        <a
                            href="https://wa.me/6285159104469?text=Halo,%20saya%20ingin%20berkonsultasi%20mengenai%20layanan%20bacadulu."
                            target="_blank"
                            class="btn btn-success fw-bold py-2 mt-4 rounded-pill shadow-sm"
                            rel="noopener noreferrer"
                        >
                            <i class="bi bi-whatsapp me-2"></i>
                            View More (Chat WA) &rarr;
                        </a>
                    </div>

                </div>
            </div>

            <!-- Kartu 2: FDI Partners -->
            <div class="col-md-5 animate__animated animate__fadeInRight">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-hover">

                    <div class="p-4 bg-white d-flex align-items-center justify-content-center border-bottom" style="height:200px;">
                        <img
                            src="{{ asset('img/Fdi.jpg') }}"
                            alt="FDI Partners"
                            class="img-fluid logo-img"
                            style="max-height:120px;object-fit:contain;"
                        >
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-2 fw-semibold">
                                Strategic Partner
                            </span>

                            <h4 class="fw-bold text-dark mb-2">
                                FDI Partners Official
                            </h4>

                            <p class="text-muted small">
                                Layanan konsultasi kelembagaan, hukum, dan pengembangan riset strategis bersama mitra profesional FDI Partners.
                            </p>
                        </div>

                        <a
                            href="https://www.fdipartners.co.id/"
                            target="_blank"
                            class="btn btn-primary fw-bold py-2 mt-4 rounded-pill shadow-sm"
                            rel="noopener noreferrer"
                        >
                            <i class="bi bi-globe me-2"></i>
                            View More (Website FDI) &rarr;
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>

@endsection
