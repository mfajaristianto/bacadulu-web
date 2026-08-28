<?php

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
| Writable Laravel paths
|--------------------------------------------------------------------------
*/

$runtimeEnv = [
    'LARAVEL_STORAGE_PATH' => '/tmp/storage',
    'VIEW_COMPILED_PATH'    => '/tmp/views',
];

foreach ($runtimeEnv as $key => $value) {
    putenv($key . '=' . $value);
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

/*
|--------------------------------------------------------------------------
| Current request
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
| Serve public static files
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

        header(
            'Content-Length: ' . filesize($requestedFile)
        );

        readfile($requestedFile);

        exit;
    }
}

/*
|--------------------------------------------------------------------------
| SPECIAL DIAGNOSTIC ONLY FOR /up
|--------------------------------------------------------------------------
|
| HANYA /up yang diboot manual.
| Request normal TIDAK melewati bagian ini.
|
*/

if ($uri === '/up') {

    require __DIR__ . '/../vendor/autoload.php';

    $app = require __DIR__ . '/../bootstrap/app.php';

    try {

        $app->bootstrapWith([
            \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
            \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
            \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
            \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
            \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
            \Illuminate\Foundation\Bootstrap\BootProviders::class,
        ]);

        header('Content-Type: text/plain; charset=UTF-8');

        echo "========================================\n";
        echo "BacaDulu Vercel Driver Diagnostic\n";
        echo "========================================\n\n";

        echo "PHP: " . PHP_VERSION . "\n";
        echo "Environment: " . $app->environment() . "\n\n";

        echo "CONFIGURATION\n";
        echo "----------------------------------------\n";

        echo "session.driver       = ";
        var_export(config('session.driver'));
        echo "\n";

        echo "cache.default        = ";
        var_export(config('cache.default'));
        echo "\n";

        echo "queue.default        = ";
        var_export(config('queue.default'));
        echo "\n";

        echo "database.default     = ";
        var_export(config('database.default'));
        echo "\n";

        echo "filesystems.default  = ";
        var_export(config('filesystems.default'));
        echo "\n";

        echo "mail.default         = ";
        var_export(config('mail.default'));
        echo "\n";

        echo "logging.default      = ";
        var_export(config('logging.default'));
        echo "\n";

        echo "auth.defaults.guard  = ";
        var_export(config('auth.defaults.guard'));
        echo "\n\n";

        /*
        |--------------------------------------------------------------------------
        | Driver tests
        |--------------------------------------------------------------------------
        */

        $tests = [

            'SESSION' => function () use ($app) {
                return $app->make('session')->driver();
            },

            'CACHE' => function () use ($app) {
                return $app->make('cache')->driver();
            },

            'HASH' => function () use ($app) {
                return $app->make('hash')->driver();
            },

            'FILESYSTEM' => function () use ($app) {
                return $app->make('filesystem')->disk();
            },

            'QUEUE' => function () use ($app) {
                return $app->make('queue')->connection();
            },

            'MAIL' => function () use ($app) {
                return $app->make('mail.manager')->mailer();
            },

        ];

        echo "DRIVER TESTS\n";
        echo "----------------------------------------\n";

        foreach ($tests as $name => $test) {

            try {

                $result = $test();

                echo $name . ": OK";

                if (is_object($result)) {
                    echo " [" . get_class($result) . "]";
                }

                echo "\n";

            } catch (\Throwable $e) {

                echo $name . ": ERROR\n";
                echo "  Type    : " . get_class($e) . "\n";
                echo "  Message : " . $e->getMessage() . "\n";
                echo "  File    : " . $e->getFile() . "\n";
                echo "  Line    : " . $e->getLine() . "\n";
            }
        }

        echo "\n========================================\n";
        echo "END\n";
        echo "========================================\n";

    } catch (\Throwable $e) {

        http_response_code(500);

        header('Content-Type: text/plain; charset=UTF-8');

        echo "BOOT ERROR\n\n";
        echo "TYPE: " . get_class($e) . "\n";
        echo "MESSAGE: " . $e->getMessage() . "\n";
        echo "FILE: " . $e->getFile() . "\n";
        echo "LINE: " . $e->getLine() . "\n";
    }

    exit;
}

/*
|--------------------------------------------------------------------------
| NORMAL WEBSITE
|--------------------------------------------------------------------------
|
| Untuk SEMUA request selain /up,
| Laravel dijalankan normal melalui public/index.php.
|
*/

require __DIR__ . '/../public/index.php';