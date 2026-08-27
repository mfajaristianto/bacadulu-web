<?php

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

require __DIR__ . '/../public/index.php';