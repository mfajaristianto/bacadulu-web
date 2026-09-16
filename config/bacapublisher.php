<?php

return [

    /*
    |--------------------------------------------------------------------------
    | REST API
    |--------------------------------------------------------------------------
    |
    | Isi lewat .env setelah API URL dan API Key dari Baca Dulu Publisher
    | sudah diberikan. Selama salah satunya kosong, tombol sync di admin akan
    | tetap nonaktif dan scheduler tidak akan melakukan request keluar.
    |
    */

    'api_url' => rtrim((string) env('BACAPUBLISHER_API_URL', ''), '/'),
    'api_key' => (string) env('BACAPUBLISHER_API_KEY', ''),

    /*
    | Local mock mode untuk mengetes importer tanpa API Key.
    | JANGAN aktifkan di staging/production.
    */
    'mock' => filter_var(
        env('BACAPUBLISHER_MOCK', false),
        FILTER_VALIDATE_BOOL
    ),
    'mock_file' => storage_path('app/bacapublisher/mock-submissions.json'),

    /*
    | OMP umumnya menerima token lewat Authorization: Bearer <token>.
    | Disediakan mode lain supaya integrasi tidak perlu dirombak kalau server
    | ternyata dikonfigurasi berbeda.
    |
    | bearer : Authorization: Bearer TOKEN
    | header : header khusus (default X-API-Key)
    | query  : query string (default apiToken)
    */
    'auth_mode' => strtolower((string) env('BACAPUBLISHER_AUTH_MODE', 'bearer')),
    'auth_header' => (string) env('BACAPUBLISHER_AUTH_HEADER', 'X-API-Key'),
    'auth_query' => (string) env('BACAPUBLISHER_AUTH_QUERY', 'apiToken'),

    'publisher_name' => (string) env('BACAPUBLISHER_PUBLISHER_NAME', 'Baca Dulu Publisher'),

    'timeout' => (int) env('BACAPUBLISHER_TIMEOUT', 25),
    'connect_timeout' => (int) env('BACAPUBLISHER_CONNECT_TIMEOUT', 8),
    'page_size' => max(1, min(100, (int) env('BACAPUBLISHER_PAGE_SIZE', 50))),

    /* Simpan file cover original apa adanya, tanpa resize/recompress. */
    'download_covers' => filter_var(
        env('BACAPUBLISHER_DOWNLOAD_COVERS', true),
        FILTER_VALIDATE_BOOL
    ),

    'max_cover_bytes' => (int) env('BACAPUBLISHER_MAX_COVER_BYTES', 15 * 1024 * 1024),

    /*
    |--------------------------------------------------------------------------
    | Automatic Sync
    |--------------------------------------------------------------------------
    |
    | Default OFF. Setelah URL + key benar dan sync manual sudah dites, cukup
    | ubah BACAPUBLISHER_AUTO_SYNC=true untuk menjalankan sync setiap jam.
    */
    'auto_sync' => filter_var(
        env('BACAPUBLISHER_AUTO_SYNC', false),
        FILTER_VALIDATE_BOOL
    ),
];
