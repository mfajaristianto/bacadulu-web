<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOtpTest extends TestCase
{
    use RefreshDatabase;

    private const VALID_OTP = '123456';

    private function createAdmin(): User
    {
        return User::factory()->create([
            'name' => 'Admin OTP Test',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
    }

    private function validOtpSession(User $admin): array
    {
        return [
            'admin_pending_user_id' => $admin->id,

            // Credential yang sedang diverifikasi.
            'admin_pending_credential_type' => 'primary',

            // Bukti tahap Google sudah dilewati.
            'admin_google_name' => 'Google Test User',
            'admin_google_email' => 'google-user@example.com',
            'admin_google_id' => 'google-test-123',

            // OTP tidak lagi disimpan plaintext.
            'admin_otp_hash' => hash_hmac(
                'sha256',
                self::VALID_OTP,
                (string) config('app.key')
            ),
            'admin_otp_attempts' => 0,
            'admin_otp_expires_at' => now()->addMinutes(5),

            'admin_remember' => false,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 1. Tidak boleh buka OTP tanpa session
    |--------------------------------------------------------------------------
    */

    public function test_otp_page_cannot_be_opened_without_pending_session(): void
    {
        $response = $this->get(
            route('admin.otp')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Session valid boleh membuka form OTP
    |--------------------------------------------------------------------------
    */

    public function test_otp_page_can_be_opened_with_valid_session(): void
    {
        $admin = $this->createAdmin();

        $response = $this
            ->withSession(
                $this->validOtpSession($admin)
            )
            ->get(
                route('admin.otp')
            );

        $response->assertOk();
    }

    /*
    |--------------------------------------------------------------------------
    | 3. OTP dengan format tidak valid ditolak
    |--------------------------------------------------------------------------
    */

    public function test_otp_must_contain_exactly_six_digits(): void
    {
        $admin = $this->createAdmin();

        $response = $this
            ->withSession(
                $this->validOtpSession($admin)
            )
            ->from(
                route('admin.otp')
            )
            ->post(
                route('admin.otp.submit'),
                [
                    'otp' => '123',
                ]
            );

        $response->assertRedirect(
            route('admin.otp')
        );

        $response->assertSessionHasErrors(
            'otp'
        );

        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | 4. OTP salah ditolak
    |--------------------------------------------------------------------------
    */

    public function test_wrong_otp_is_rejected(): void
    {
        $admin = $this->createAdmin();

        $response = $this
            ->withSession(
                $this->validOtpSession($admin)
            )
            ->from(
                route('admin.otp')
            )
            ->post(
                route('admin.otp.submit'),
                [
                    'otp' => '654321',
                ]
            );

        $response->assertRedirect(
            route('admin.otp')
        );

        $response->assertSessionHas(
            'error'
        );

        $response->assertSessionHas(
            'admin_otp_attempts',
            1
        );

        $response->assertSessionMissing(
            'admin_otp_verified'
        );

        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | 5. OTP expired ditolak
    |--------------------------------------------------------------------------
    */

    public function test_expired_otp_is_rejected(): void
    {
        $admin = $this->createAdmin();

        $session = $this->validOtpSession(
            $admin
        );

        $session['admin_otp_expires_at'] =
            now()->subMinute();

        $response = $this
            ->withSession($session)
            ->from(
                route('admin.otp')
            )
            ->post(
                route('admin.otp.submit'),
                [
                    'otp' => self::VALID_OTP,
                ]
            );

        $response->assertRedirect(
            route('admin.otp')
        );

        $response->assertSessionHas(
            'error'
        );

        // Semua material OTP expired harus dibuang.
        $response->assertSessionMissing(
            'admin_otp_code'
        );

        $response->assertSessionMissing(
            'admin_otp_hash'
        );

        $response->assertSessionMissing(
            'admin_otp_attempts'
        );

        $response->assertSessionMissing(
            'admin_otp_expires_at'
        );

        $response->assertSessionMissing(
            'admin_otp_verified'
        );

        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | 6. OTP benar masuk ke Confirm Access
    |--------------------------------------------------------------------------
    */

    public function test_correct_otp_redirects_to_confirm_access(): void
    {
        $admin = $this->createAdmin();

        $response = $this
            ->withSession(
                $this->validOtpSession($admin)
            )
            ->post(
                route('admin.otp.submit'),
                [
                    'otp' => self::VALID_OTP,
                ]
            );

        $response->assertRedirect(
            route('admin.confirm')
        );

        $response->assertSessionHas(
            'admin_otp_verified',
            true
        );

        // OTP sudah dipakai dan harus dibuang dari session.
        $response->assertSessionMissing(
            'admin_otp_code'
        );

        $response->assertSessionMissing(
            'admin_otp_hash'
        );

        $response->assertSessionMissing(
            'admin_otp_attempts'
        );

        $response->assertSessionMissing(
            'admin_otp_expires_at'
        );

        // Belum login admin. Masih harus melewati Confirm Access.
        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | 7. Tidak bisa POST OTP jika material OTP hilang
    |--------------------------------------------------------------------------
    */

    public function test_otp_cannot_be_processed_when_session_is_missing(): void
    {
        $admin = $this->createAdmin();

        $response = $this
            ->withSession([
                'admin_pending_user_id' => $admin->id,
                'admin_pending_credential_type' => 'primary',
                'admin_google_email' => 'google-user@example.com',

                // Sengaja tidak ada admin_otp_hash dan expires_at.
            ])
            ->from(
                route('admin.otp')
            )
            ->post(
                route('admin.otp.submit'),
                [
                    'otp' => self::VALID_OTP,
                ]
            );

        $response->assertRedirect(
            route('admin.otp')
        );

        $response->assertSessionHas(
            'error'
        );

        $this->assertGuest('admin');
    }
}
