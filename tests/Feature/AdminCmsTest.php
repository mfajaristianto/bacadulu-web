<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    private function createAdmin(): User
    {
        return User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('PasswordAdmin123'),
            'is_admin' => true,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Guest tidak boleh masuk CMS
    |--------------------------------------------------------------------------
    */

    public function test_guest_cannot_access_admin_cms(): void
    {
        $response = $this->get(
            route('admin.informations.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Login guard web tidak memberikan akses CMS
    |--------------------------------------------------------------------------
    */

    public function test_web_guard_does_not_grant_admin_access(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs(
            $admin,
            'web'
        );

        $response = $this->get(
            route('admin.informations.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Non-admin pada guard admin tetap ditolak
    |--------------------------------------------------------------------------
    */

    public function test_non_admin_cannot_access_admin_cms(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs(
            $user,
            'admin'
        );

        $response = $this->get(
            route('admin.informations.index')
        );

        $response->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | Admin dengan guard admin bisa masuk
    |--------------------------------------------------------------------------
    */

    public function test_admin_guard_can_access_admin_cms(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs(
            $admin,
            'admin'
        );

        $response = $this->get(
            route('admin.informations.index')
        );

        $response->assertOk();

        $this->assertAuthenticatedAs(
            $admin,
            'admin'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Password utama tidak langsung login dashboard
    |--------------------------------------------------------------------------
    |
    | Flow:
    |
    | password
    | → Google Verification
    | → OTP
    | → Confirm Access
    | → dashboard
    |
    */

    public function test_primary_password_starts_google_verification(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(
            route('admin.login.submit'),
            [
                'email' => 'admin@example.com',
                'password' => 'PasswordAdmin123',
            ]
        );

        $response->assertRedirect(
            route('admin.google.verify')
        );

        $response->assertSessionHas(
            'admin_pending_user_id',
            $admin->id
        );

        $response->assertSessionHas(
            'admin_pending_credential_type',
            'primary'
        );

        /*
         * Belum login ke guard admin karena Google/OTP
         * belum diselesaikan.
         */
        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | Password salah
    |--------------------------------------------------------------------------
    */

    public function test_wrong_admin_password_is_rejected(): void
    {
        $this->createAdmin();

        $response = $this
            ->from(route('admin.login'))
            ->post(
                route('admin.login.submit'),
                [
                    'email' => 'admin@example.com',
                    'password' => 'PasswordSalah123',
                ]
            );

        $response->assertRedirect(
            route('admin.login')
        );

        $response->assertSessionHasErrors('email');

        $this->assertGuest('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | Email admin salah
    |--------------------------------------------------------------------------
    */

    public function test_wrong_admin_email_is_rejected(): void
    {
        $this->createAdmin();

        $response = $this
            ->from(route('admin.login'))
            ->post(
                route('admin.login.submit'),
                [
                    'email' => 'bukanadmin@example.com',
                    'password' => 'PasswordAdmin123',
                ]
            );

        $response->assertRedirect(
            route('admin.login')
        );

        $response->assertSessionHasErrors('email');

        $this->assertGuest('admin');
    }
}