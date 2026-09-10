# Cara Pasang Privacy Policy + Terms Baca Dulu

1. Extract ZIP ini langsung ke root project:
   D:\Pkl\landing-page

2. File Blade otomatis berada di:
   resources/views/legal/privacy-policy.blade.php
   resources/views/legal/terms.blade.php

3. Buka routes/web.php lalu salin isi `routes-snippet.txt`.
   Tempel pada bagian PUBLIC ROUTES, bukan di dalam middleware auth/admin.

4. Opsional tapi disarankan:
   salin dua link dari `footer-snippet.blade.php` ke footer website.

5. Jalankan:

   & "C:\xampp\php\php.exe" artisan optimize:clear
   & "C:\xampp\php\php.exe" artisan route:list --name=privacy-policy
   & "C:\xampp\php\php.exe" artisan route:list --name=terms

6. Tes lokal:
   http://127.0.0.1:8000/privacy-policy
   http://127.0.0.1:8000/terms

7. Setelah deploy ke staging, URL yang dimasukkan ke Google Auth Platform:
   https://staging.bacadulu.net/privacy-policy
   https://staging.bacadulu.net/terms

Catatan:
- Halaman legal harus bisa dibuka tanpa login.
- Jangan gunakan URL localhost untuk Google Branding.
- Teks ini adalah draft operasional umum untuk website Baca Dulu dan dapat diperbarui bila alur pengumpulan data atau layanan berubah.
