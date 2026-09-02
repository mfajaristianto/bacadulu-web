<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backup Directory
    |--------------------------------------------------------------------------
    */

    'directory' => storage_path('app/backups'),

    /*
    |--------------------------------------------------------------------------
    | Retention
    |--------------------------------------------------------------------------
    |
    | Backup yang lebih lama dari jumlah hari ini
    | akan dibersihkan otomatis.
    |
    */

    'retention_days' => (int) env(
        'BACKUP_RETENTION_DAYS',
        14
    ),

    /*
    |--------------------------------------------------------------------------
    | MySQL Dump
    |--------------------------------------------------------------------------
    */

    'mysqldump_path' => env(
        'MYSQLDUMP_PATH',
        PHP_OS_FAMILY === 'Windows'
            ? 'C:/xampp/mysql/bin/mysqldump.exe'
            : 'mysqldump'
    ),

    /*
    |--------------------------------------------------------------------------
    | File Upload Sources
    |--------------------------------------------------------------------------
    |
    | storage/app/public:
    | file yang diakses melalui public/storage.
    |
    | public/book-covers:
    | cover buku yang disimpan langsung ke public.
    |
    | Folder yang tidak ada akan dilewati,
    | jadi command tidak gagal hanya karena salah satu belum dipakai.
    |
    | Jangan tambahkan public/storage karena biasanya merupakan
    | symbolic link ke storage/app/public dan akan menduplikasi backup.
    |
    */

    'file_sources' => [

        storage_path('app/public'),

        public_path('book-covers'),

    ],

];