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
