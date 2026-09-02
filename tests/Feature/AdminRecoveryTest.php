<?php

namespace Tests\Feature;

use App\Mail\AdminRecoveryApprovalMail;
use App\Mail\AdminRecoveryDecisionMail;
use App\Models\AdminAccessPassword;
use App\Models\AdminRecoveryRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AdminRecoveryTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'name' => 'Admin Recovery Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('PrimaryPass123'),
            'is_admin' => true,
        ]);
    }

    private function recoveryPayload(array $override = []): array
    {
        return array_merge([
            'requester_name' => 'Fajar Test',
            'requester_position' => 'Administrator',
            'requester_email' => 'fajar@example.com',
            'requester_phone' => '081234567890',
            'reason' => 'Memerlukan akses admin untuk pengelolaan website.',
            'notes' => 'Permohonan testing.',
        ], $override);
    }

    private function createRecoveryRequest(): AdminRecoveryRequest
    {
        Mail::fake();

        $this->post(
            route('admin.recovery.store'),
            $this->recoveryPayload()
        );

        return AdminRecoveryRequest::latest('id')->firstOrFail();
    }

    private function approveRecovery(
        AdminRecoveryRequest $recovery
    ): AdminRecoveryRequest {
        Mail::fake();

        $url = URL::temporarySignedRoute(
            'admin.recovery.decision',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'approve',
            ]
        );

        $this->post($url);

        return $recovery->fresh();
    }

    public function test_recovery_form_can_be_opened(): void
    {
        $response = $this->get(
            route('admin.recovery.form')
        );

        $response->assertOk();
    }

    public function test_recovery_request_requires_required_fields(): void
    {
        $response = $this
            ->from(route('admin.recovery.form'))
            ->post(
                route('admin.recovery.store'),
                []
            );

        $response->assertRedirect(
            route('admin.recovery.form')
        );

        $response->assertSessionHasErrors([
            'requester_name',
            'requester_position',
            'requester_email',
            'requester_phone',
            'reason',
        ]);

        $this->assertDatabaseCount(
            'admin_recovery_requests',
            0
        );
    }

    public function test_valid_recovery_request_is_saved_and_email_is_sent(): void
    {
        Mail::fake();

        $response = $this->post(
            route('admin.recovery.store'),
            $this->recoveryPayload()
        );

        $recovery = AdminRecoveryRequest::firstOrFail();

        $response->assertRedirect(
            route(
                'admin.recovery.waiting',
                $recovery->public_id
            )
        );

        $this->assertDatabaseHas(
            'admin_recovery_requests',
            [
                'id' => $recovery->id,
                'admin_email' => 'admin@example.com',
                'requester_email' => 'fajar@example.com',
                'status' => 'pending',
            ]
        );

        $this->assertNotEmpty(
            $recovery->public_id
        );

        Mail::assertSent(
            AdminRecoveryApprovalMail::class,
            1
        );
    }

    public function test_duplicate_pending_recovery_is_not_created(): void
    {
        Mail::fake();

        $this->post(
            route('admin.recovery.store'),
            $this->recoveryPayload()
        );

        $first = AdminRecoveryRequest::firstOrFail();

        $response = $this->post(
            route('admin.recovery.store'),
            $this->recoveryPayload()
        );

        $response->assertRedirect(
            route(
                'admin.recovery.waiting',
                $first->public_id
            )
        );

        $this->assertDatabaseCount(
            'admin_recovery_requests',
            1
        );

        /*
         * Email approval hanya dikirim saat request pertama.
         */
        Mail::assertSent(
            AdminRecoveryApprovalMail::class,
            1
        );
    }

    public function test_unsigned_review_link_is_rejected(): void
    {
        $recovery = $this->createRecoveryRequest();

        $response = $this->get(
            route(
                'admin.recovery.review',
                [
                    'publicId' => $recovery->public_id,
                    'decision' => 'approve',
                ]
            )
        );

        $response->assertForbidden();
    }

    public function test_signed_review_link_can_be_opened(): void
    {
        $recovery = $this->createRecoveryRequest();

        $url = URL::temporarySignedRoute(
            'admin.recovery.review',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'approve',
            ]
        );

        $response = $this->get($url);

        $response->assertOk();

        /*
         * Membuka review belum boleh langsung mengubah status.
         */
        $this->assertSame(
            'pending',
            $recovery->fresh()->status
        );
    }

    public function test_recovery_can_be_approved(): void
    {
        Mail::fake();

        $recovery = $this->createRecoveryRequest();

        $url = URL::temporarySignedRoute(
            'admin.recovery.decision',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'approve',
            ]
        );

        $response = $this->post($url);

        $response->assertOk();

        $recovery->refresh();

        $this->assertSame(
            'approved',
            $recovery->status
        );

        $this->assertNotNull(
            $recovery->approved_at
        );

        $this->assertSame(
            'approver@example.com',
            $recovery->approved_by
        );

        Mail::assertSent(
            AdminRecoveryDecisionMail::class,
            1
        );
    }

    public function test_recovery_can_be_rejected(): void
    {
        Mail::fake();

        $recovery = $this->createRecoveryRequest();

        $url = URL::temporarySignedRoute(
            'admin.recovery.decision',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'reject',
            ]
        );

        $response = $this->post($url);

        $response->assertOk();

        $recovery->refresh();

        $this->assertSame(
            'rejected',
            $recovery->status
        );

        $this->assertNotNull(
            $recovery->rejected_at
        );

        Mail::assertSent(
            AdminRecoveryDecisionMail::class,
            1
        );
    }

    public function test_rejected_recovery_cannot_open_password_creation_page(): void
    {
        Mail::fake();

        $recovery = $this->createRecoveryRequest();

        $rejectUrl = URL::temporarySignedRoute(
            'admin.recovery.decision',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'reject',
            ]
        );

        $this->post($rejectUrl);

        $recovery->refresh();

        $passwordUrl = URL::temporarySignedRoute(
            'admin.recovery.password.create',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
            ]
        );

        $response = $this->get(
            $passwordUrl
        );

        $response->assertRedirect(
            route(
                'admin.recovery.waiting',
                $recovery->public_id
            )
        );

        $this->assertDatabaseCount(
            'admin_access_passwords',
            0
        );
    }

    public function test_approved_recovery_can_create_supplemental_password(): void
    {
        $admin = $this->createAdmin();

        $originalPrimaryPassword =
            $admin->password;

        $recovery =
            $this->createRecoveryRequest();

        $recovery =
            $this->approveRecovery(
                $recovery
            );

        $this->assertSame(
            'approved',
            $recovery->status
        );

        $storeUrl = URL::temporarySignedRoute(
            'admin.recovery.password.store',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
            ]
        );

        $response = $this
            ->from(
                URL::temporarySignedRoute(
                    'admin.recovery.password.create',
                    now()->addMinutes(10),
                    [
                        'publicId' =>
                            $recovery->public_id,
                    ]
                )
            )
            ->post(
                $storeUrl,
                [
                    'password' =>
                        'AccessPass123',

                    'password_confirmation' =>
                        'AccessPass123',
                ]
            );

        $response->assertRedirect(
            route('admin.login')
        );

        $this->assertDatabaseHas(
            'admin_access_passwords',
            [
                'user_id' => $admin->id,
                'recovery_request_id' =>
                    $recovery->id,
                'holder_name' =>
                    'Fajar Test',
                'holder_email' =>
                    'fajar@example.com',
                'is_active' => true,
            ]
        );

        $access =
            AdminAccessPassword::firstOrFail();

        $this->assertTrue(
            Hash::check(
                'AccessPass123',
                $access->password_hash
            )
        );

        /*
         * PASSWORD UTAMA ADMIN TIDAK BOLEH BERUBAH.
         */
        $admin->refresh();

        $this->assertSame(
            $originalPrimaryPassword,
            $admin->password
        );

        $recovery->refresh();

        $this->assertNotNull(
            $recovery->password_created_at
        );
    }

    public function test_supplemental_password_cannot_equal_primary_password(): void
    {
        $this->createAdmin();

        $recovery =
            $this->approveRecovery(
                $this->createRecoveryRequest()
            );

        $storeUrl = URL::temporarySignedRoute(
            'admin.recovery.password.store',
            now()->addMinutes(10),
            [
                'publicId' => $recovery->public_id,
            ]
        );

        $response = $this
            ->from(
                route('admin.recovery.form')
            )
            ->post(
                $storeUrl,
                [
                    'password' =>
                        'PrimaryPass123',

                    'password_confirmation' =>
                        'PrimaryPass123',
                ]
            );

        $response->assertSessionHasErrors(
            'password'
        );

        $this->assertDatabaseCount(
            'admin_access_passwords',
            0
        );
    }

    public function test_same_recovery_cannot_create_password_twice(): void
    {
        $this->createAdmin();

        $recovery =
            $this->approveRecovery(
                $this->createRecoveryRequest()
            );

        $firstUrl =
            URL::temporarySignedRoute(
                'admin.recovery.password.store',
                now()->addMinutes(10),
                [
                    'publicId' =>
                        $recovery->public_id,
                ]
            );

        $this->post(
            $firstUrl,
            [
                'password' =>
                    'AccessPass123',

                'password_confirmation' =>
                    'AccessPass123',
            ]
        );

        $recovery->refresh();

        $this->assertNotNull(
            $recovery->password_created_at
        );

        $secondUrl =
            URL::temporarySignedRoute(
                'admin.recovery.password.store',
                now()->addMinutes(10),
                [
                    'publicId' =>
                        $recovery->public_id,
                ]
            );

        $response = $this->post(
            $secondUrl,
            [
                'password' =>
                    'AnotherPass456',

                'password_confirmation' =>
                    'AnotherPass456',
            ]
        );

        $response->assertRedirect(
            route('admin.login')
        );

        $this->assertDatabaseCount(
            'admin_access_passwords',
            1
        );
    }
}