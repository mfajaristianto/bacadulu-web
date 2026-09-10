@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - Baca Dulu')

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

            <h1>Syarat dan Ketentuan</h1>

            <p class="bd-legal-updated">
                Terakhir diperbarui: 10 September 2026
            </p>

            <div class="bd-legal-intro">
                Syarat dan Ketentuan ini mengatur penggunaan website dan layanan
                Baca Dulu. Dengan menggunakan layanan Baca Dulu, pengguna dianggap
                telah membaca dan memahami ketentuan yang berlaku.
            </div>
        </header>

        <div class="bd-legal-body">

            <section class="bd-legal-section">
                <h2>1. Tentang Baca Dulu</h2>

                <p>
                    Baca Dulu menyediakan akses terhadap informasi publikasi, jurnal,
                    conference, publisher dan bookstore, blog dan komunitas, layanan
                    HAKI, konsultasi, serta layanan terkait lainnya dalam ekosistem
                    PT Bina Cendikia Academy.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>2. Akun Pengguna</h2>

                <p>
                    Pengguna bertanggung jawab atas penggunaan akun dan aktivitas yang
                    dilakukan melalui akunnya. Pengguna wajib memberikan informasi yang
                    wajar, tidak menyesatkan, dan tidak menggunakan akun untuk melakukan
                    tindakan yang melanggar hukum atau merugikan pihak lain.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>3. Login dengan Google</h2>

                <p>
                    Baca Dulu dapat menyediakan login melalui Google untuk memudahkan
                    autentikasi pengguna. Penggunaan akun Google tetap tunduk pada
                    ketentuan dan kebijakan yang diberlakukan oleh Google.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>4. Penggunaan yang Dilarang</h2>

                <p>Pengguna tidak diperkenankan:</p>

                <ul>
                    <li>menggunakan layanan untuk tindakan yang melanggar hukum;</li>
                    <li>mengunggah malware, script berbahaya, atau konten yang dimaksudkan untuk merusak sistem;</li>
                    <li>melakukan spam, manipulasi interaksi, atau penyalahgunaan fitur;</li>
                    <li>mencoba mengakses akun, data, atau area sistem tanpa izin;</li>
                    <li>menyamar sebagai individu, organisasi, atau pihak lain;</li>
                    <li>mengunggah konten yang melanggar hak kekayaan intelektual atau hak pihak lain.</li>
                </ul>
            </section>

            <section class="bd-legal-section">
                <h2>5. Konten Pengguna dan Moderasi</h2>

                <p>
                    Pengguna bertanggung jawab atas artikel, komentar, komunitas, gambar,
                    dan materi lain yang dikirim melalui akun mereka. Baca Dulu dapat
                    melakukan moderasi, menolak publikasi, mengubah status, membatasi,
                    atau menghapus konten apabila diperlukan untuk menjaga keamanan,
                    kualitas layanan, kepatuhan, dan hak pihak lain.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>6. Hak Kekayaan Intelektual</h2>

                <p>
                    Nama, logo, desain, materi resmi, dan elemen lain yang dimiliki oleh
                    Baca Dulu atau mitra terkait tetap dilindungi sesuai ketentuan yang
                    berlaku. Penggunaan kembali materi tersebut harus memperhatikan izin
                    dan hak pemiliknya.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>7. Bookstore dan Transaksi</h2>

                <p>
                    Informasi buku, format, ketersediaan, harga, dan data terkait lainnya
                    ditampilkan untuk membantu pengguna memahami produk yang tersedia.
                    Apabila proses pembelian dilanjutkan melalui WhatsApp atau kanal resmi
                    lainnya, detail akhir transaksi, ketersediaan, pembayaran, dan tindak
                    lanjut akan dikonfirmasi melalui kanal tersebut.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>8. Layanan HAKI</h2>

                <p>
                    Layanan HAKI Baca Dulu merupakan layanan pendampingan dan konsultasi
                    dalam proses terkait kekayaan intelektual. Baca Dulu tidak menjamin
                    bahwa setiap permohonan pasti diterima atau disetujui oleh instansi
                    yang berwenang karena keputusan akhir berada pada pihak berwenang
                    sesuai ketentuan yang berlaku.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>9. Baca Konsultasi dan Mitra</h2>

                <p>
                    Baca Dulu dapat membantu mengarahkan pengguna kepada mitra profesional
                    yang sesuai dengan kebutuhannya. Ruang lingkup, biaya, metode, hasil,
                    jadwal, dan kesepakatan layanan profesional dapat tunduk pada
                    kesepakatan antara pengguna dan mitra terkait.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>10. Tautan dan Layanan Pihak Ketiga</h2>

                <p>
                    Website dapat memuat tautan menuju Google, WhatsApp, website jurnal,
                    conference, mitra profesional, atau layanan pihak ketiga lainnya.
                    Baca Dulu tidak mengendalikan seluruh isi, kebijakan, maupun
                    ketersediaan layanan eksternal tersebut.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>11. Ketersediaan dan Perubahan Layanan</h2>

                <p>
                    Baca Dulu dapat melakukan pemeliharaan, peningkatan sistem, perubahan
                    tampilan, penambahan, pengurangan, atau penyesuaian fitur dari waktu
                    ke waktu. Dalam kondisi tertentu layanan dapat tidak tersedia untuk
                    sementara waktu.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>12. Pembatasan Tanggung Jawab</h2>

                <p>
                    Informasi dan fitur yang tersedia ditujukan untuk mendukung kebutuhan
                    pengguna. Sepanjang diperbolehkan oleh hukum, Baca Dulu tidak
                    bertanggung jawab atas keputusan pihak ketiga, gangguan di luar
                    kendali layanan, atau hasil layanan profesional pihak lain.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>13. Penangguhan atau Pembatasan Akun</h2>

                <p>
                    Baca Dulu dapat membatasi akses atau mengambil tindakan terhadap akun
                    yang digunakan untuk spam, penyalahgunaan, pelanggaran keamanan,
                    pelanggaran hak pihak lain, atau pelanggaran ketentuan ini.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>14. Hukum yang Berlaku</h2>

                <p>
                    Syarat dan Ketentuan ini tunduk pada hukum yang berlaku di
                    Republik Indonesia.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>15. Perubahan Syarat dan Ketentuan</h2>

                <p>
                    Ketentuan ini dapat diperbarui apabila terdapat perubahan layanan,
                    teknologi, operasional, atau ketentuan yang berlaku. Tanggal
                    pembaruan terbaru akan dicantumkan pada halaman ini.
                </p>
            </section>

            <section class="bd-legal-section">
                <h2>16. Kontak</h2>

                <p>
                    Jika memiliki pertanyaan mengenai ketentuan penggunaan Baca Dulu,
                    silakan hubungi kami melalui
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
