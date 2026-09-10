@extends('layouts.app')

@section('title', 'Kebijakan Privasi - Baca Dulu')

@section('content')

<style>
.bd-legal{
    --navy:#241B52;
    --orange:#D96A2B;
    --orange-dark:#C94F35;
    --cream:#FFF8F1;
    --warm:#FFFCF8;
    --text:#2F3640;
    --muted:#6E737A;
    --line:#E9E2DA;

    min-height:100vh;
    padding:54px 0 80px;
    background:
        radial-gradient(circle at 100% 0%, rgba(217,106,43,.08), transparent 28%),
        linear-gradient(180deg,#FFFFFF 0%,var(--warm) 100%);
    color:var(--text);
}

.bd-legal *{
    box-sizing:border-box;
}

.bd-legal-shell{
    width:min(calc(100% - 40px),920px);
    margin:0 auto;
}

.bd-legal-head{
    padding-bottom:28px;
    border-bottom:1px solid var(--line);
}

.bd-legal-kicker{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:13px;
    color:var(--orange-dark);
    font-size:11px;
    font-weight:800;
    letter-spacing:.1em;
    text-transform:uppercase;
}

.bd-legal-kicker::before{
    content:"";
    width:28px;
    height:3px;
    border-radius:999px;
    background:var(--orange);
}

.bd-legal h1{
    margin:0;
    color:var(--navy);
    font-family:Georgia,'Times New Roman',serif;
    font-size:clamp(34px,5vw,52px);
    line-height:1.08;
    letter-spacing:-.035em;
}

.bd-legal-updated{
    margin:14px 0 0;
    color:var(--muted);
    font-size:13px;
}

.bd-legal-intro{
    margin:28px 0 0;
    padding:20px 22px;
    border:1px solid rgba(217,106,43,.16);
    border-radius:16px;
    background:var(--cream);
    color:#555B64;
    font-size:14px;
    line-height:1.8;
}

.bd-legal-body{
    padding-top:10px;
}

.bd-legal-section{
    padding:27px 0;
    border-bottom:1px solid var(--line);
}

.bd-legal-section:last-child{
    border-bottom:0;
}

.bd-legal-section h2{
    margin:0 0 11px;
    color:var(--navy);
    font-size:20px;
    line-height:1.35;
}

.bd-legal-section p,
.bd-legal-section li{
    color:var(--muted);
    font-size:14px;
    line-height:1.85;
}

.bd-legal-section p{
    margin:0;
}

.bd-legal-section p + p{
    margin-top:12px;
}

.bd-legal-section ul{
    margin:10px 0 0;
    padding-left:22px;
}

.bd-legal-section li + li{
    margin-top:7px;
}

.bd-legal-link{
    color:var(--orange-dark);
    font-weight:800;
    text-decoration:none;
}

.bd-legal-link:hover{
    text-decoration:underline;
}

.bd-legal-back{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:46px;
    margin-top:28px;
    padding:10px 16px;
    border:1px solid var(--line);
    border-radius:11px;
    background:#fff;
    color:var(--navy);
    font-size:13px;
    font-weight:800;
    text-decoration:none;
}

.bd-legal-back:focus-visible,
.bd-legal-link:focus-visible{
    outline:3px solid rgba(217,106,43,.28);
    outline-offset:3px;
}

@media(max-width:600px){
    .bd-legal{
        padding:38px 0 60px;
    }

    .bd-legal-shell{
        width:calc(100% - 28px);
    }

    .bd-legal-intro{
        padding:17px;
    }

    .bd-legal-section{
        padding:23px 0;
    }
}
</style>


<main class="bd-legal">
    <div class="bd-legal-shell">

        <header class="bd-legal-head">
            <span class="bd-legal-kicker">Baca Dulu</span>

            <h1>Kebijakan Privasi</h1>

            <p class="bd-legal-updated">
                Terakhir diperbarui: 10 September 2026
            </p>

            <div class="bd-legal-intro">
                Kebijakan Privasi ini menjelaskan bagaimana Baca Dulu mengumpulkan,
                menggunakan, menyimpan, dan melindungi informasi pengguna ketika
                menggunakan website dan layanan yang tersedia di dalamnya.
            </div>
        </header>

        <div class="bd-legal-body">

            <section class="bd-legal-section">
                <h2>1. Pengelola Layanan</h2>

                <p>
                    Baca Dulu merupakan layanan digital yang dikelola dalam ekosistem
                    PT Bina Cendikia Academy untuk mendukung layanan publikasi, informasi,
                    komunitas, konsultasi, dan layanan terkait lainnya.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>2. Informasi yang Dapat Kami Kumpulkan</h2>

                <p>
                    Informasi yang dapat diproses bergantung pada fitur yang digunakan.
                    Data tersebut dapat meliputi:
                </p>

                <ul>
                    <li>nama dan alamat email;</li>
                    <li>foto profil;</li>
                    <li>identitas akun Google yang digunakan untuk autentikasi;</li>
                    <li>informasi profil yang diberikan secara sukarela oleh pengguna;</li>
                    <li>artikel, komentar, komunitas, atau konten lain yang dikirim pengguna;</li>
                    <li>data teknis yang diperlukan untuk keamanan, session, log, dan pengoperasian website.</li>
                </ul>
            </section>

            <section class="bd-legal-section">
                <h2>3. Login dengan Google</h2>

                <p>
                    Baca Dulu dapat menggunakan Google sebagai metode autentikasi.
                    Ketika pengguna memilih login dengan Google, Baca Dulu hanya
                    menggunakan informasi yang diizinkan oleh pengguna dan diperlukan
                    untuk membuat atau mengakses akun Baca Dulu.
                </p>

                <p>
                    Baca Dulu tidak menerima dan tidak menyimpan password akun Google pengguna.
                    Proses autentikasi Google dilakukan melalui layanan Google.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>4. Tujuan Penggunaan Informasi</h2>

                <p>Informasi pengguna dapat digunakan untuk:</p>

                <ul>
                    <li>melakukan autentikasi dan mengelola akun pengguna;</li>
                    <li>menampilkan serta mengelola profil pengguna;</li>
                    <li>menjalankan fitur blog, komentar, komunitas, dan layanan interaktif;</li>
                    <li>meningkatkan keamanan dan mencegah penyalahgunaan layanan;</li>
                    <li>memberikan dukungan atau komunikasi terkait layanan yang diminta pengguna;</li>
                    <li>memelihara, mengevaluasi, dan meningkatkan fungsi website.</li>
                </ul>
            </section>

            <section class="bd-legal-section">
                <h2>5. Cookie dan Session</h2>

                <p>
                    Website dapat menggunakan cookie dan session untuk mempertahankan status
                    login, menjalankan fungsi keamanan, menyimpan preferensi tertentu, serta
                    memastikan fitur website bekerja dengan semestinya.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>6. Penyimpanan dan Keamanan Data</h2>

                <p>
                    Baca Dulu menerapkan langkah teknis dan administratif yang wajar untuk
                    membantu melindungi informasi dari akses tidak sah, perubahan, kehilangan,
                    atau penyalahgunaan. Meskipun demikian, tidak ada sistem elektronik yang
                    dapat dijamin sepenuhnya bebas dari risiko keamanan.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>7. Pembagian Informasi</h2>

                <p>
                    Baca Dulu tidak menjual data pribadi pengguna. Informasi dapat diproses
                    bersama penyedia layanan yang diperlukan untuk menjalankan sistem,
                    atau diberikan apabila diwajibkan berdasarkan hukum yang berlaku.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>8. Layanan dan Tautan Pihak Ketiga</h2>

                <p>
                    Website dapat terhubung dengan layanan pihak ketiga seperti Google,
                    WhatsApp, atau website mitra. Ketika pengguna berpindah ke layanan pihak
                    ketiga, penggunaan data juga dapat tunduk pada kebijakan privasi pihak
                    ketiga tersebut.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>9. Hak Pengguna</h2>

                <p>
                    Pengguna dapat menghubungi Baca Dulu untuk meminta informasi, koreksi,
                    atau penghapusan data tertentu yang berada dalam kendali Baca Dulu,
                    sepanjang tidak bertentangan dengan kewajiban hukum atau kebutuhan
                    administratif yang sah.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>10. Retensi Data</h2>

                <p>
                    Informasi dapat disimpan selama akun atau layanan masih digunakan,
                    selama diperlukan untuk tujuan operasional, keamanan, penyelesaian
                    kewajiban layanan, atau selama diwajibkan oleh ketentuan yang berlaku.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>11. Perubahan Kebijakan Privasi</h2>

                <p>
                    Kebijakan ini dapat diperbarui dari waktu ke waktu untuk menyesuaikan
                    perubahan layanan, teknologi, atau ketentuan yang berlaku. Tanggal
                    pembaruan terbaru akan ditampilkan pada halaman ini.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>12. Kontak</h2>

                <p>
                    Untuk pertanyaan mengenai privasi, penggunaan data, atau permintaan
                    terkait data pengguna, silakan hubungi Baca Dulu melalui
                    <a
                        class="bd-legal-link"
                        href="{{ route('tentang.kontak') }}"
                    >
                        halaman Kontak
                    </a>.
                </p>
            </section>

        </div>

        <a href="{{ route('home') }}" class="bd-legal-back">
            ← Kembali ke Beranda
        </a>

    </div>
</main>
@endsection
