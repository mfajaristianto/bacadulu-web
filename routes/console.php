<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Baca Dulu Automatic Backup
|--------------------------------------------------------------------------
|
| Database dibackup setiap hari pukul 02:00 WIB.
| File upload dibackup setiap hari pukul 02:10 WIB.
|
| Retention backup lama tetap ditangani oleh masing-masing
| command berdasarkan BACKUP_RETENTION_DAYS di .env.
|
*/

Schedule::command('backup:database')
    ->dailyAt('02:00')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();

Schedule::command('backup:files')
    ->dailyAt('02:10')
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();


/*
|--------------------------------------------------------------------------
| BacaPublisher Automatic Sync
|--------------------------------------------------------------------------
|
| Default OFF. Setelah URL + API Key valid dan sync manual berhasil, set
| BACAPUBLISHER_AUTO_SYNC=true untuk menjalankan sync setiap jam.
|
*/

if (config('bacapublisher.auto_sync')) {
    Schedule::command('publisher:sync')
        ->hourly()
        ->withoutOverlapping(30);
}
