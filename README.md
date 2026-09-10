# BacaDulu Runtime Clarity Fix

Patch ini merapikan konfigurasi runtime yang masih tidak konsisten:
- Application Name masih `Laravel`
- Timezone masih `UTC`
- Locale masih `en`

Yang diubah:
- `APP_NAME="Baca Dulu"`
- `APP_TIMEZONE=Asia/Jakarta`
- `APP_LOCALE=id`
- `APP_FALLBACK_LOCALE=en`
- `APP_FAKER_LOCALE=id_ID`
- `config/app.php` dibuat membaca `APP_TIMEZONE`

Script membuat backup `.env` dan `config/app.php` sebelum mengubah apa pun.

Cara pakai:

```powershell
Set-ExecutionPolicy -Scope Process Bypass
.\fix-runtime-config.ps1
```

Lalu cek:

```powershell
& "C:\xampp\php\php.exe" artisan about
```

Target:
- Application Name = Baca Dulu
- Timezone = Asia/Jakarta
- Locale = id

`SESSION_DRIVER` sengaja belum diubah otomatis. Untuk alur admin/OTP, driver `database` lebih mudah dikelola, tetapi perubahan itu sebaiknya dilakukan setelah memastikan tabel `sessions` tersedia dan setelah regression test.
