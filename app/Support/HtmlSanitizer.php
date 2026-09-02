<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

final class HtmlSanitizer
{
    /*
    |--------------------------------------------------------------------------
    | Purifier Instance
    |--------------------------------------------------------------------------
    |
    | Instance hanya dibuat satu kali selama request berlangsung.
    |
    */

    private static ?HTMLPurifier $purifier = null;


    /*
    |--------------------------------------------------------------------------
    | Clean HTML
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk membersihkan HTML artikel sebelum disimpan
    | maupun sebelum ditampilkan kembali.
    |
    */

    public static function clean(
        ?string $html
    ): string {
        if ($html === null) {
            return '';
        }

        $html = trim($html);

        if ($html === '') {
            return '';
        }

        return self::purifier()
            ->purify($html);
    }


    /*
    |--------------------------------------------------------------------------
    | Purifier Configuration
    |--------------------------------------------------------------------------
    */

    private static function purifier(): HTMLPurifier
    {
        if (self::$purifier instanceof HTMLPurifier) {
            return self::$purifier;
        }

        /*
        |--------------------------------------------------------------------------
        | Cache Directory
        |--------------------------------------------------------------------------
        |
        | HTML Purifier membutuhkan direktori writable untuk cache definisi.
        |
        */

        $cachePath = storage_path(
            'framework/cache/htmlpurifier'
        );

        if (!is_dir($cachePath)) {
            @mkdir(
                $cachePath,
                0775,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Base Configuration
        |--------------------------------------------------------------------------
        */

        $config = HTMLPurifier_Config::createDefault();

        /*
        |--------------------------------------------------------------------------
        | Encoding
        |--------------------------------------------------------------------------
        */

        $config->set(
            'Core.Encoding',
            'UTF-8'
        );

        /*
        |--------------------------------------------------------------------------
        | Allowed HTML
        |--------------------------------------------------------------------------
        |
        | Hanya elemen yang memang diperlukan untuk artikel.
        |
        | Tidak ada:
        |
        | script
        | iframe
        | object
        | embed
        | form
        | input
        | button
        | svg
        | style
        |
        */

        $config->set(
            'HTML.Allowed',
            implode(
                ',',
                [
                    'p',
                    'br',
                    'div',

                    'strong',
                    'b',

                    'em',
                    'i',

                    'u',
                    's',
                    'del',

                    'h2',
                    'h3',
                    'h4',

                    'ul',
                    'ol',
                    'li',

                    'blockquote',

                    'pre',
                    'code',

                    'hr',

                    'a[href|title|target|rel]',
                ]
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Safe URL Schemes
        |--------------------------------------------------------------------------
        |
        | javascript:, data:, vbscript:, dan protocol berbahaya lainnya
        | tidak diizinkan.
        |
        */

        $config->set(
            'URI.AllowedSchemes',
            [
                'http' => true,
                'https' => true,
                'mailto' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Link Target
        |--------------------------------------------------------------------------
        */

        $config->set(
            'Attr.AllowedFrameTargets',
            [
                '_blank',
                '_self',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | External Link Protection
        |--------------------------------------------------------------------------
        */

        $config->set(
            'HTML.TargetBlank',
            true
        );

        $config->set(
            'HTML.Nofollow',
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Disable ID
        |--------------------------------------------------------------------------
        |
        | User tidak perlu membuat ID HTML sendiri.
        |
        */

        $config->set(
            'Attr.EnableID',
            false
        );

        /*
        |--------------------------------------------------------------------------
        | Cache
        |--------------------------------------------------------------------------
        */

        if (is_dir($cachePath)) {
            $config->set(
                'Cache.SerializerPath',
                $cachePath
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Initialize
        |--------------------------------------------------------------------------
        */

        self::$purifier = new HTMLPurifier(
            $config
        );

        return self::$purifier;
    }
}