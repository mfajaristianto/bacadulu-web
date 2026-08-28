<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Prepare writable directories for Vercel
|--------------------------------------------------------------------------
*/

$tmpDirectories = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/views',
];

foreach ($tmpDirectories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

/*
|--------------------------------------------------------------------------
| Tell Laravel to use writable Vercel directories
|--------------------------------------------------------------------------
*/

putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

putenv('VIEW_COMPILED_PATH=/tmp/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/views';

/*
|--------------------------------------------------------------------------
| Serve Static Files From /public
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
        $extension = strtolower(
            pathinfo($requestedFile, PATHINFO_EXTENSION)
        );

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
            header(
                'Content-Type: ' . $mimeTypes[$extension]
            );
        }

        header(
            'Content-Length: ' . filesize($requestedFile)
        );

        readfile($requestedFile);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Load Composer
|--------------------------------------------------------------------------
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap Laravel
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Handle Request
|--------------------------------------------------------------------------
|
| Untuk sementara kita bungkus proses Laravel dengan try/catch.
| Tujuannya supaya Vercel menampilkan penyebab error sebenarnya.
|
*/

try {

    $request = Request::capture();

    $app->handleRequest($request);

} catch (Throwable $exception) {

    http_response_code(500);

    header('Content-Type: text/plain; charset=UTF-8');

    echo "========================================\n";
    echo "BacaDulu Laravel Vercel Diagnostic\n";
    echo "========================================\n\n";

    $current = $exception;
    $number = 1;

    while ($current !== null) {

        echo "ERROR #{$number}\n";
        echo "----------------------------------------\n";

        echo "TYPE:\n";
        echo get_class($current) . "\n\n";

        echo "MESSAGE:\n";
        echo $current->getMessage() . "\n\n";

        echo "FILE:\n";
        echo $current->getFile() . "\n\n";

        echo "LINE:\n";
        echo $current->getLine() . "\n\n";

        $current = $current->getPrevious();
        $number++;

        if ($number > 10) {
            break;
        }
    }

    echo "========================================\n";
    echo "END DIAGNOSTIC\n";
    echo "========================================\n";

    exit;
}