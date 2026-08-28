<?php

/*
|--------------------------------------------------------------------------
| Prepare writable directories for Vercel
|--------------------------------------------------------------------------
*/

$tmpDirectories = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($tmpDirectories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

/*
|--------------------------------------------------------------------------
| Tell Laravel to use Vercel writable storage
|--------------------------------------------------------------------------
*/

putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

/*
|--------------------------------------------------------------------------
| Serve public static files
|--------------------------------------------------------------------------
*/

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'
);

$publicDirectory = realpath(__DIR__ . '/../public');

if ($uri !== '/' && $publicDirectory !== false) {

    $requestedPath = __DIR__ . '/../public/' . ltrim($uri, '/');
    $requestedFile = realpath($requestedPath);

    if (
        $requestedFile !== false &&
        str_starts_with($requestedFile, $publicDirectory) &&
        is_file($requestedFile)
    ) {
        $extension = strtolower(pathinfo($requestedFile, PATHINFO_EXTENSION));

        $mimeTypes = [
            'css'   => 'text/css; charset=UTF-8',
            'js'    => 'application/javascript; charset=UTF-8',
            'json'  => 'application/json; charset=UTF-8',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+xml',
            'webp'  => 'image/webp',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'pdf'   => 'application/pdf',
            'txt'   => 'text/plain; charset=UTF-8',
        ];

        if (isset($mimeTypes[$extension])) {
            header('Content-Type: ' . $mimeTypes[$extension]);
        }

        header('Content-Length: ' . filesize($requestedFile));

        readfile($requestedFile);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Boot Laravel
|--------------------------------------------------------------------------
*/

require __DIR__ . '/../public/index.php';