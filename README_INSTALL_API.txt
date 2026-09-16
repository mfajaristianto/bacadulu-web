BACA DULU - BACAPUBLISHER API READY
====================================

Paket ini melanjutkan workflow Publisher/Bookstore Pending yang sudah terpasang.
API URL dan API Key BELUM WAJIB diisi sekarang. Selama kosong, website tetap
berjalan normal dan tombol Sync API di Admin akan menampilkan status belum siap.

YANG SUDAH DISIAPKAN
--------------------
1. Client REST API OMP/BacaPublisher.
2. Dukungan Authorization Bearer (default), header custom, atau query apiToken.
3. Pagination endpoint /submissions.
4. Hanya submission status Published (status=3) yang diimport.
5. Mapping otomatis:
   - submission ID -> external_id
   - publication ID
   - title
   - authorsString -> author
   - abstract/synopsis jika tersedia
   - datePublished -> publish_year
   - cover metadata / cover URL
   - urlPublished
   - version
   - lastModified/dateLastActivity
   - publicationFormats jika tersedia
6. Cover original didownload apa adanya ke storage BacaDulu, TANPA resize/recompress.
7. Buku baru dari API masuk:
   publisher_status = pending
   store_status     = pending
8. Sync berikutnya TIDAK menimpa hasil edit admin.
   Perubahan sumber masuk ke pending_api_payload + has_pending_sync.
9. Di Edit Publisher ada:
   - lihat perbedaan data sekarang vs data API
   - Terapkan Update API
   - Abaikan Update
10. Admin Publisher punya:
   - status integrasi
   - Tes API
   - Sync BacaPublisher
   - statistik jumlah buku API dan update pending
11. Artisan command:
   php artisan publisher:sync
12. Auto sync per jam sudah disiapkan tetapi DEFAULT OFF.

FILE .ENV NANTI
---------------
Tambahkan ketika API URL + key sudah resmi diberikan:

BACAPUBLISHER_API_URL=
BACAPUBLISHER_API_KEY=
BACAPUBLISHER_AUTH_MODE=bearer
BACAPUBLISHER_PUBLISHER_NAME="Baca Dulu Publisher"
BACAPUBLISHER_DOWNLOAD_COVERS=true
BACAPUBLISHER_AUTO_SYNC=false

Endpoint yang sudah ditemukan saat pengecekan OMP adalah pola:
.../index.php/bacadulu_publisher/api/v1
Tetapi isi BACAPUBLISHER_API_URL hanya setelah endpoint final dikonfirmasi.

AUTH MODE
---------
Default paling aman:
BACAPUBLISHER_AUTH_MODE=bearer

Jika server Apache/OMP ternyata membuang Authorization header dan mendapat 403,
mode compatibility tersedia:
BACAPUBLISHER_AUTH_MODE=query

Mode query menaruh token sebagai apiToken di query string. Gunakan hanya jika
Bearer memang tidak bekerja karena konfigurasi server.

SETELAH API URL + KEY DIISI
---------------------------
LOCAL:
php artisan optimize:clear

Buka Admin -> Publisher -> Tes API.
Jika berhasil, klik Sync BacaPublisher.

Untuk test terminal:
php artisan publisher:sync

AUTO SYNC
---------
Setelah sync manual dipastikan benar:
BACAPUBLISHER_AUTO_SYNC=true

Scheduler akan menjalankan publisher:sync setiap jam melalui Laravel Scheduler.
Pastikan cron schedule:run project memang aktif (project ini sudah menggunakan
scheduler untuk backup database/files).

DEPLOY CPANEL STAGING
---------------------
Workflow normal:
1. edit/commit/push dari LOCAL
2. cPanel hanya git pull

Karena CLI default hosting sebelumnya PHP 7.4, gunakan EA PHP 8.5:

/opt/cpanel/ea-php85/root/usr/bin/php artisan optimize:clear
/opt/cpanel/ea-php85/root/usr/bin/php artisan migrate --force
/opt/cpanel/ea-php85/root/usr/bin/php artisan optimize

Paket API ini sendiri tidak menambah kolom database baru di luar migration
workflow Publisher yang sudah dibuat sebelumnya:
2026_09_14_140000_add_workflow_status_to_books_table.php

PERILAKU UPDATE
---------------
- Buku baru: langsung masuk Pending dan boleh diedit admin.
- Buku API berubah: data live tidak langsung berubah.
- Admin pilih Terapkan Update API: metadata sumber diterapkan lalu status
  Publisher kembali Pending untuk review.
- Admin pilih Abaikan Update: hasil edit admin tetap dipakai dan snapshot API
  tersebut dianggap sudah direview agar tidak muncul lagi pada sync berikutnya.
- Cover yang pernah diupload manual admin tidak ditimpa otomatis oleh API.

CATATAN DATA OMP
----------------
Publication Formats pada sebagian buku Publisher saat ini kosong. Karena itu
ISBN, halaman, jenis buku, format cetak/e-book, harga, dan stok tetap bisa
 dilengkapi di Admin BacaDulu sebelum Approve.
