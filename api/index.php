<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Vercel writable directories
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
| Laravel writable paths
|--------------------------------------------------------------------------
*/

$vercelEnv = [
    'LARAVEL_STORAGE_PATH' => '/tmp/storage',

    'VIEW_COMPILED_PATH' => '/tmp/views',

    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
];

foreach ($vercelEnv as $key => $value) {
    putenv("$key=$value");

    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

/*
|--------------------------------------------------------------------------
| Request URI
|--------------------------------------------------------------------------
*/

$uri = urldecode(
    parse_url(
        $_SERVER['REQUEST_URI'] ?? '/',
        PHP_URL_PATH
    ) ?: '/'
);

/*
|--------------------------------------------------------------------------
| Serve static files
|--------------------------------------------------------------------------
*/

$publicDirectory = realpath(__DIR__ . '/../public');

if ($uri !== '/' && $publicDirectory !== false) {

    $requestedFile = realpath(
        __DIR__ . '/../public/' . ltrim($uri, '/')
    );

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

        readfile($requestedFile);

        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Composer
|--------------------------------------------------------------------------
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Laravel application
|--------------------------------------------------------------------------
*/

$app = require __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Bootstrap Laravel manually
|--------------------------------------------------------------------------
|
| Ini sengaja dilakukan manual supaya error bootstrap ASLI tidak ditelan
| oleh Laravel Exception Handler.
|
*/

try {

    $app->bootstrapWith([
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ]);

} catch (\Throwable $exception) {

    http_response_code(500);

    header('Content-Type: text/plain; charset=UTF-8');

    echo "========================================\n";
    echo "BacaDulu BOOT ERROR\n";
    echo "========================================\n\n";

    echo "TYPE:\n";
    echo get_class($exception) . "\n\n";

    echo "MESSAGE:\n";
    echo $exception->getMessage() . "\n\n";

    echo "FILE:\n";
    echo $exception->getFile() . "\n\n";

    echo "LINE:\n";
    echo $exception->getLine() . "\n\n";

    echo "----------------------------------------\n";

    $previous = $exception->getPrevious();

    if ($previous) {

        echo "PREVIOUS ERROR\n\n";

        echo "TYPE:\n";
        echo get_class($previous) . "\n\n";

        echo "MESSAGE:\n";
        echo $previous->getMessage() . "\n\n";

        echo "FILE:\n";
        echo $previous->getFile() . "\n\n";

        echo "LINE:\n";
        echo $previous->getLine() . "\n";
    }

    echo "\n========================================\n";

    exit;
}

/*
|--------------------------------------------------------------------------
| Special Vercel health diagnostic
|--------------------------------------------------------------------------
*/

if ($uri === '/up') {

    header('Content-Type: text/plain; charset=UTF-8');

    echo "BacaDulu Laravel BOOT OK\n";
    echo "PHP: " . PHP_VERSION . "\n";
    echo "Environment: " . $app->environment() . "\n";

    echo 'View service: ';
    echo $app->bound('view')
        ? 'OK'
        : 'NOT REGISTERED';

    echo "\n";

    exit;
}

/*
|--------------------------------------------------------------------------
| Handle normal Laravel request
|--------------------------------------------------------------------------
*/

try {

    $app->handleRequest(
        Request::capture()
    );

} catch (\Throwable $exception) {

    http_response_code(500);

    header('Content-Type: text/plain; charset=UTF-8');

    echo "========================================\n";
    echo "BacaDulu REQUEST ERROR\n";
    echo "========================================\n\n";

    echo "TYPE:\n";
    echo get_class($exception) . "\n\n";

    echo "MESSAGE:\n";
    echo $exception->getMessage() . "\n\n";

    echo "FILE:\n";
    echo $exception->getFile() . "\n\n";

    echo "LINE:\n";
    echo $exception->getLine() . "\n";

    echo "\n========================================\n";

    exit;
}