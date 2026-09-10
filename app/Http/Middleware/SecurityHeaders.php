<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | SECURITY HEADERS UMUM
        |--------------------------------------------------------------------------
        |
        | Header berikut aman dipakai untuk halaman publik maupun admin dan tidak
        | mengganggu JavaScript/CSS inline yang saat ini masih banyak digunakan
        | oleh BacaDulu.
        |
        */

        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );

        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );

        $response->headers->set(
            'Content-Security-Policy',
            "frame-ancestors 'self'"
        );

        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=()'
        );

        $response->headers->set(
            'X-Permitted-Cross-Domain-Policies',
            'none'
        );

        /*
        |--------------------------------------------------------------------------
        | HSTS - HANYA PRODUCTION + HTTPS
        |--------------------------------------------------------------------------
        |
        | Tidak dijalankan saat localhost. includeSubDomains sengaja tidak dipakai
        | supaya subdomain lain tidak ikut dipaksa HTTPS sebelum benar-benar siap.
        |
        */

        if (
            app()->environment('production') &&
            $request->isSecure()
        ) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | HALAMAN SENSITIF JANGAN DISIMPAN BROWSER / SEARCH ENGINE
        |--------------------------------------------------------------------------
        |
        | Ini mencegah halaman admin/profil tetap terlihat dari browser cache
        | setelah user logout atau berpindah perangkat bersama.
        |
        */

        $isSensitivePage =
            $request->is('panel-adminbaca') ||
            $request->is('panel-adminbaca/*') ||
            $request->is('admin') ||
            $request->is('admin/*') ||
            $request->is('profil') ||
            $request->is('profil/*');

        if ($isSensitivePage) {
            $response->headers->set(
                'Cache-Control',
                'no-store, no-cache, must-revalidate, private'
            );

            $response->headers->set(
                'Pragma',
                'no-cache'
            );

            $response->headers->set(
                'Expires',
                '0'
            );

            $response->headers->set(
                'X-Robots-Tag',
                'noindex, nofollow, noarchive'
            );
        }

        return $response;
    }
}
