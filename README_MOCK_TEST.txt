TES 8 BUKU BACA PUBLISHER TANPA API KEY
========================================

Patch ini hanya untuk LOCAL.

1. Copy isi folder patch ke root project Laravel.
2. Tambahkan ke .env lokal:

BACAPUBLISHER_API_URL=https://publisher.bacadulu.net/index.php/bacadulu_publisher/api/v1
BACAPUBLISHER_API_KEY=
BACAPUBLISHER_AUTH_MODE=bearer
BACAPUBLISHER_AUTO_SYNC=false
BACAPUBLISHER_MOCK=true
BACAPUBLISHER_DOWNLOAD_COVERS=false

DOWNLOAD_COVERS=false direkomendasikan untuk tes pertama supaya fokus menguji import 8 record dan status pending.

3. Clear config:
php artisan optimize:clear

4. Jalankan:
php artisan publisher:sync

EXPECTED:
Diterima = 8
Buku Baru = 8 (jika belum pernah import)
Gagal = 0

5. Buka Admin > Publisher > Pending.
Harus ada 8 buku dari API fixture dengan Publisher status Pending.
Bookstore status juga Pending.

6. Jalankan publisher:sync sekali lagi.
EXPECTED: tidak membuat duplikat. Biasanya Tetap = 8, Buku Baru = 0.

7. Setelah selesai tes, ubah:
BACAPUBLISHER_MOCK=false

Jangan aktifkan BACAPUBLISHER_MOCK=true di staging/production.
Saat API Key asli sudah ada, isi BACAPUBLISHER_API_KEY dan jalankan sync live.
