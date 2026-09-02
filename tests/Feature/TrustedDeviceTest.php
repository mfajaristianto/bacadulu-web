<?php

namespace Tests\Feature;

use App\Models\TrustedDevice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TrustedDeviceTest extends TestCase
{
    use RefreshDatabase;

    private string $password = 'PasswordAdmin123';

    private string $userAgent = 'BacaDulu-Test-Browser/1.0';

    private function createAdmin(): User
    {
        return User::factory()->create([
            'name' => 'Admin Trusted Device Test',
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
            'is_admin' => true,
        ]);
    }

    private function createPrimaryTrustedDevice(
        User $admin,
        string $token,
        ?string $userAgent = null,
        $expiresAt = null
    ): TrustedDevice {
        return TrustedDevice::create([
            'user_id' => $admin->id,

            'credential_type' => 'primary',

            'access_password_id' => null,

            /*
             * Token asli tidak disimpan ke DB.
             * DB hanya menyimpan SHA-256.
             */
            'token_hash' => hash(
                'sha256',
                $token
            ),

            'user_agent' =>
                $userAgent ?? $this->userAgent,

            'expires_at' =>
                $expiresAt ?? now()->addYear(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 1. Schema Trusted Device
    |--------------------------------------------------------------------------
    */

    public function test_trusted_devices_table_has_required_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns(
                'trusted_devices',
                [
                    'id',
                    'user_id',
                    'credential_type',
                    'access_password_id',
                    'token_hash',
                    'user_agent',
                    'expires_at',
                    'created_at',
                    'updated_at',
                ]
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Confirm Access membuat Trusted Device
    |--------------------------------------------------------------------------
    */

    public function test_successful_confirm_access_creates_primary_trusted_device(): void
    {
        $admin = $this->createAdmin();

        $response = $this
            ->withHeader(
                'User-Agent',
                $this->userAgent
            )
            ->withSession([
                'admin_pending_user_id' =>
                    $admin->id,

                'admin_pending_credential_type' =>
                    'primary',

                'admin_pending_access_password_id' =>
                    null,

                'admin_google_name' =>
                    'Google Test User',

                'admin_google_email' =>
                    'google-test@example.com',

                'admin_google_id' =>
                    'google-test-id',

                'admin_otp_verified' =>
                    true,

                'admin_remember' =>
                    false,
            ])
            ->post(
                route('admin.confirm.submit'),
                [
                    'email' =>
                        'admin@example.com',

                    'password' =>
                        $this->password,
                ]
            );

        /*
         * Setelah confirm berhasil:
         * admin benar-benar login.
         */
        $response->assertRedirect(
            route('admin.dashboard')
        );

        $this->assertAuthenticatedAs(
            $admin,
            'admin'
        );

        /*
         * Trusted Device harus tercatat.
         */
        $this->assertDatabaseHas(
            'trusted_devices',
            [
                'user_id' =>
                    $admin->id,

                'credential_type' =>
                    'primary',

                'access_password_id' =>
                    null,

                'user_agent' =>
                    $this->userAgent,
            ]
        );

        /*
         * Cookie trusted device harus dikirim.
         */
        $response->assertCookie(
            'admin_trusted_device'
        );

        /*
         * Pending auth session sudah selesai.
         */
        $response->assertSessionMissing(
            'admin_pending_user_id'
        );

        $response->assertSessionMissing(
            'admin_otp_verified'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Trusted Device valid bypass Google + OTP
    |--------------------------------------------------------------------------
    */

    public function test_valid_primary_trusted_device_logs_admin_in_directly(): void
    {
        $admin = $this->createAdmin();

        $token =
            'valid-trusted-device-token-123456789';

        $this->createPrimaryTrustedDevice(
            $admin,
            $token
        );

        $response = $this
            ->withHeader(
                'User-Agent',
                $this->userAgent
            )
            ->withCookie(
                'admin_trusted_device',
                $token
            )
            ->post(
                route('admin.login.submit'),
                [
                    'email' =>
                        'admin@example.com',

                    'password' =>
                        $this->password,
                ]
            );

        /*
         * Device valid:
         * tidak perlu Google / OTP lagi.
         */
        $response->assertRedirect(
            route('admin.dashboard')
        );

        $this->assertAuthenticatedAs(
            $admin,
            'admin'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Token Salah
    |--------------------------------------------------------------------------
    */

    public function test_invalid_trusted_device_token_does_not_bypass_verification(): void
    {
        $admin = $this->createAdmin();

        $this->createPrimaryTrustedDevice(
            $admin,
            'token-yang-benar'
        );

        $response = $this
            ->withHeader(
                'User-Agent',
                $this->userAgent
            )
            ->withCookie(
                'admin_trusted_device',
                'token-yang-salah'
            )
            ->post(
                route('admin.login.submit'),
                [
                    'email' =>
                        'admin@example.com',

                    'password' =>
                        $this->password,
                ]
            );

        /*
         * Token tidak cocok.
         * Harus kembali melewati Google Verification.
         */
        $response->assertRedirect(
            route('admin.google.verify')
        );

        $this->assertGuest('admin');

        $response->assertSessionHas(
            'admin_pending_user_id',
            $admin->id
        );

        $response->assertSessionHas(
            'admin_pending_credential_type',
            'primary'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 5. User-Agent Berbeda
    |--------------------------------------------------------------------------
    */

    public function test_trusted_device_cannot_be_used_from_different_user_agent(): void
    {
        $admin = $this->createAdmin();

        $token =
            'same-token-but-different-browser';

        $this->createPrimaryTrustedDevice(
            $admin,
            $token,
            'Browser-Asli/1.0'
        );

        /*
         * Token sama,
         * tapi browser / User-Agent berbeda.
         */
        $response = $this
            ->withHeader(
                'User-Agent',
                'Browser-Lain/99.0'
            )
            ->withCookie(
                'admin_trusted_device',
                $token
            )
            ->post(
                route('admin.login.submit'),
                [
                    'email' =>
                        'admin@example.com',

                    'password' =>
                        $this->password,
                ]
            );

        /*
         * Tidak boleh langsung login.
         */
        $response->assertRedirect(
            route('admin.google.verify')
        );

        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | 6. Trusted Device Expired
    |--------------------------------------------------------------------------
    */

    public function test_expired_trusted_device_is_deleted_and_cannot_login_directly(): void
    {
        $admin = $this->createAdmin();

        $token =
            'expired-device-token';

        $trustedDevice =
            $this->createPrimaryTrustedDevice(
                $admin,
                $token,
                $this->userAgent,
                now()->subMinute()
            );

        $trustedDeviceId =
            $trustedDevice->id;

        $response = $this
            ->withHeader(
                'User-Agent',
                $this->userAgent
            )
            ->withCookie(
                'admin_trusted_device',
                $token
            )
            ->post(
                route('admin.login.submit'),
                [
                    'email' =>
                        'admin@example.com',

                    'password' =>
                        $this->password,
                ]
            );

        /*
         * Expired device tidak boleh bypass.
         */
        $response->assertRedirect(
            route('admin.google.verify')
        );

        $this->assertGuest('admin');

        /*
         * Controller harus membersihkan
         * record trusted device expired.
         */
        $this->assertDatabaseMissing(
            'trusted_devices',
            [
                'id' => $trustedDeviceId,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 7. Credential Type Harus Cocok
    |--------------------------------------------------------------------------
    */

    public function test_access_credential_trusted_device_cannot_be_used_for_primary_password(): void
    {
        $admin = $this->createAdmin();

        $token =
            'credential-mismatch-token';

        /*
         * Kita sengaja buat record dengan tipe ACCESS.
         *
         * Padahal user nanti login memakai primary password.
         */
        TrustedDevice::create([
            'user_id' =>
                $admin->id,

            'credential_type' =>
                'access',

            'access_password_id' =>
                null,

            'token_hash' =>
                hash(
                    'sha256',
                    $token
                ),

            'user_agent' =>
                $this->userAgent,

            'expires_at' =>
                now()->addYear(),
        ]);

        $response = $this
            ->withHeader(
                'User-Agent',
                $this->userAgent
            )
            ->withCookie(
                'admin_trusted_device',
                $token
            )
            ->post(
                route('admin.login.submit'),
                [
                    'email' =>
                        'admin@example.com',

                    'password' =>
                        $this->password,
                ]
            );

        /*
         * Credential type tidak cocok.
         *
         * Cookie ACCESS tidak boleh membuat
         * PRIMARY login melewati verifikasi.
         */
        $response->assertRedirect(
            route('admin.google.verify')
        );

        $this->assertGuest('admin');

        $response->assertSessionHas(
            'admin_pending_credential_type',
            'primary'
        );
    }
}