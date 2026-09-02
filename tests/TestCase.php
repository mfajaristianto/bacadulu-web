<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /*
        |--------------------------------------------------------------------------
        | Jangan bergantung pada Vite saat testing
        |--------------------------------------------------------------------------
        */

        $this->withoutVite();

        /*
        |--------------------------------------------------------------------------
        | Konfigurasi dummy khusus testing
        |--------------------------------------------------------------------------
        |
        | Tidak menggunakan email/credential asli dari .env.
        |
        */

        config([
            'services.admin_auth.email' => 'admin@example.com',
            'services.admin_auth.otp_email' => 'otp@example.com',
            'services.admin_auth.recovery_approver_email' => 'approver@example.com',
        ]);
    }
}