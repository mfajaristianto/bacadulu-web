<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminRecoveryApprovalMail;
use App\Mail\AdminRecoveryDecisionMail;
use App\Models\AdminAccessPassword;
use App\Models\AdminRecoveryRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Throwable;

class AdminRecoveryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Recovery Form
    |--------------------------------------------------------------------------
    */

    public function showForm()
    {
        $adminEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.email'
                )
            )
        );

        if ($adminEmail === '') {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Konfigurasi email admin belum tersedia.'
                );
        }

        return view(
            'admin.auth.forgot-password',
            compact('adminEmail')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store Recovery Request
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => [
                'required',
                'string',
                'max:100',
            ],

            'requester_position' => [
                'required',
                'string',
                'max:100',
            ],

            'requester_email' => [
                'required',
                'email',
                'max:150',
            ],

            'requester_phone' => [
                'required',
                'string',
                'max:30',
            ],

            'reason' => [
                'required',
                'string',
                'max:1000',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $adminEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.email'
                )
            )
        );

        $approverEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.recovery_approver_email'
                )
            )
        );

        $requesterEmail = strtolower(
            trim(
                $validated['requester_email']
            )
        );

        if ($adminEmail === '') {
            return back()
                ->with(
                    'error',
                    'Konfigurasi email admin belum tersedia.'
                )
                ->withInput();
        }

        if ($approverEmail === '') {
            return back()
                ->with(
                    'error',
                    'Email approver recovery belum dikonfigurasi.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Pending Request
        |--------------------------------------------------------------------------
        */

        $existingRequest = AdminRecoveryRequest::query()
            ->where(
                'requester_email',
                $requesterEmail
            )
            ->where(
                'admin_email',
                $adminEmail
            )
            ->where(
                'status',
                'pending'
            )
            ->latest()
            ->first();

        if ($existingRequest) {
            return redirect()
                ->route(
                    'admin.recovery.waiting',
                    $existingRequest->public_id
                )
                ->with(
                    'info',
                    'Permohonan Anda masih menunggu persetujuan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Recovery Request
        |--------------------------------------------------------------------------
        */

        $recovery = AdminRecoveryRequest::create([
            'admin_email' => $adminEmail,

            'requester_name' => trim(
                $validated['requester_name']
            ),

            'requester_position' => trim(
                $validated['requester_position']
            ),

            'requester_email' => $requesterEmail,

            'requester_phone' => trim(
                $validated['requester_phone']
            ),

            'reason' => trim(
                $validated['reason']
            ),

            'notes' => !empty($validated['notes'])
                ? trim($validated['notes'])
                : null,

            'status' => 'pending',

            'request_ip' => $request->ip(),

            'request_user_agent' => $request->userAgent(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Approval URLs
        |--------------------------------------------------------------------------
        */

        $approveUrl = URL::temporarySignedRoute(
            'admin.recovery.review',
            now()->addMinutes(60),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'approve',
            ]
        );

        $rejectUrl = URL::temporarySignedRoute(
            'admin.recovery.review',
            now()->addMinutes(60),
            [
                'publicId' => $recovery->public_id,
                'decision' => 'reject',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Send Approval Request Email
        |--------------------------------------------------------------------------
        */

        try {
            Mail::to(
                $approverEmail
            )->send(
                new AdminRecoveryApprovalMail(
                    $recovery,
                    $approveUrl,
                    $rejectUrl
                )
            );
        } catch (Throwable $exception) {
            report(
                $exception
            );

            /*
             * Jangan menyimpan permohonan sebagai pending
             * jika email ke approver bahkan belum terkirim.
             */
            $recovery->delete();

            return back()
                ->with(
                    'error',
                    'Permohonan belum dapat dikirim karena email persetujuan gagal dikirim. Silakan coba kembali.'
                )
                ->withInput();
        }

        return redirect()
            ->route(
                'admin.recovery.waiting',
                $recovery->public_id
            )
            ->with(
                'success',
                'Permohonan akses berhasil dikirim dan sedang menunggu persetujuan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Waiting Page
    |--------------------------------------------------------------------------
    */

    public function waiting(string $publicId)
    {
        $recovery = AdminRecoveryRequest::query()
            ->where(
                'public_id',
                $publicId
            )
            ->firstOrFail();

        return view(
            'admin.auth.recovery-waiting',
            compact('recovery')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Review Approval / Rejection
    |--------------------------------------------------------------------------
    */

    public function review(
        string $publicId,
        string $decision
    ) {
        if (
            !in_array(
                $decision,
                [
                    'approve',
                    'reject',
                ],
                true
            )
        ) {
            abort(404);
        }

        $recovery = AdminRecoveryRequest::query()
            ->where(
                'public_id',
                $publicId
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Already Processed
        |--------------------------------------------------------------------------
        */

        if ($recovery->status !== 'pending') {
            return view(
                'admin.auth.recovery-review',
                [
                    'recovery' => $recovery,
                    'decision' => $decision,
                    'actionUrl' => null,
                    'alreadyProcessed' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Signed POST URL
        |--------------------------------------------------------------------------
        */

        $actionUrl = URL::temporarySignedRoute(
            'admin.recovery.decision',
            now()->addMinutes(15),
            [
                'publicId' => $recovery->public_id,
                'decision' => $decision,
            ]
        );

        return view(
            'admin.auth.recovery-review',
            [
                'recovery' => $recovery,
                'decision' => $decision,
                'actionUrl' => $actionUrl,
                'alreadyProcessed' => false,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Process Approval / Rejection
    |--------------------------------------------------------------------------
    */

    public function decision(
        string $publicId,
        string $decision
    ) {
        if (
            !in_array(
                $decision,
                [
                    'approve',
                    'reject',
                ],
                true
            )
        ) {
            abort(404);
        }

        $recovery = AdminRecoveryRequest::query()
            ->where(
                'public_id',
                $publicId
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Already Processed
        |--------------------------------------------------------------------------
        */

        if ($recovery->status !== 'pending') {
            return view(
                'admin.auth.recovery-decision-result',
                [
                    'recovery' => $recovery,
                    'notificationSent' => null,
                    'retryUrl' => null,
                    'alreadyProcessed' => true,
                    'decision' => $decision,
                ]
            );
        }

        $approverEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.recovery_approver_email'
                )
            )
        );

        if ($approverEmail === '') {
            return view(
                'admin.auth.recovery-decision-result',
                [
                    'recovery' => $recovery,
                    'notificationSent' => false,
                    'retryUrl' => null,
                    'alreadyProcessed' => false,
                    'decision' => $decision,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Decision Temporarily
        |--------------------------------------------------------------------------
        |
        | Status disimpan lebih dulu karena isi email keputusan membaca
        | nilai status dari model recovery.
        |
        | Jika email gagal, status akan dikembalikan ke "pending".
        |
        */

        if ($decision === 'approve') {
            $recovery->update([
                'status' => 'approved',
                'approved_by' => $approverEmail,
                'approved_at' => now(),
                'rejected_at' => null,
            ]);
        } else {
            $recovery->update([
                'status' => 'rejected',
                'approved_by' => $approverEmail,
                'approved_at' => null,
                'rejected_at' => now(),
            ]);
        }

        $recovery->refresh();

        /*
        |--------------------------------------------------------------------------
        | Create Password URL
        |--------------------------------------------------------------------------
        */

        $createPasswordUrl = null;

        if ($recovery->status === 'approved') {
            $createPasswordUrl = URL::temporarySignedRoute(
                'admin.recovery.password.create',
                now()->addMinutes(60),
                [
                    'publicId' => $recovery->public_id,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Send Decision Email
        |--------------------------------------------------------------------------
        */

        try {
            Mail::to(
                $recovery->requester_email
            )->send(
                new AdminRecoveryDecisionMail(
                    $recovery,
                    $createPasswordUrl
                )
            );
        } catch (Throwable $exception) {
            report(
                $exception
            );

            /*
            |--------------------------------------------------------------------------
            | Roll Back Decision
            |--------------------------------------------------------------------------
            |
            | Jangan biarkan halaman pemohon mengatakan "Disetujui,
            | periksa email" jika email tersebut sebenarnya gagal dikirim.
            |
            */

            $recovery->update([
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejected_at' => null,
            ]);

            $recovery->refresh();

            /*
            |--------------------------------------------------------------------------
            | New Retry URL
            |--------------------------------------------------------------------------
            |
            | Admin bisa membuka ulang halaman review tanpa harus meminta
            | pemohon membuat recovery request baru.
            |
            */

            $retryUrl = URL::temporarySignedRoute(
                'admin.recovery.review',
                now()->addMinutes(60),
                [
                    'publicId' => $recovery->public_id,
                    'decision' => $decision,
                ]
            );

            return view(
                'admin.auth.recovery-decision-result',
                [
                    'recovery' => $recovery,
                    'notificationSent' => false,
                    'retryUrl' => $retryUrl,
                    'alreadyProcessed' => false,
                    'decision' => $decision,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.auth.recovery-decision-result',
            [
                'recovery' => $recovery,
                'notificationSent' => true,
                'retryUrl' => null,
                'alreadyProcessed' => false,
                'decision' => $decision,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Show Create Password Form
    |--------------------------------------------------------------------------
    */

    public function showPasswordForm(string $publicId)
    {
        $recovery = AdminRecoveryRequest::query()
            ->where(
                'public_id',
                $publicId
            )
            ->firstOrFail();

        if ($recovery->status !== 'approved') {
            return redirect()
                ->route(
                    'admin.recovery.waiting',
                    $recovery->public_id
                )
                ->with(
                    'error',
                    'Permohonan belum mendapatkan persetujuan.'
                );
        }

        if ($recovery->password_created_at) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'success',
                    'Password akses untuk permohonan ini sudah dibuat. Silakan login.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Signed Store URL
        |--------------------------------------------------------------------------
        */

        $storeUrl = URL::temporarySignedRoute(
            'admin.recovery.password.store',
            now()->addMinutes(30),
            [
                'publicId' => $recovery->public_id,
            ]
        );

        return view(
            'admin.auth.create-access-password',
            [
                'recovery' => $recovery,
                'storeUrl' => $storeUrl,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store Access Password
    |--------------------------------------------------------------------------
    */

    public function storePassword(
        Request $request,
        string $publicId
    ) {
        $recovery = AdminRecoveryRequest::query()
            ->where(
                'public_id',
                $publicId
            )
            ->firstOrFail();

        if ($recovery->status !== 'approved') {
            return back()
                ->with(
                    'error',
                    'Permohonan belum mendapatkan persetujuan.'
                );
        }

        if ($recovery->password_created_at) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'success',
                    'Password akses sudah pernah dibuat. Silakan login.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate New Password
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'password' => [
                'required',
                'confirmed',

                Password::min(10)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find Main Admin
        |--------------------------------------------------------------------------
        */

        $user = User::query()
            ->whereRaw(
                'LOWER(email) = ?',
                [
                    strtolower(
                        trim(
                            $recovery->admin_email
                        )
                    ),
                ]
            )
            ->first();

        if (
            !$user ||
            !$user->is_admin
        ) {
            return back()
                ->with(
                    'error',
                    'Akun admin tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Same Password as Primary Password
        |--------------------------------------------------------------------------
        */

        if (
            Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'password' =>
                        'Password akses pribadi tidak boleh sama dengan password utama admin.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Supplemental Password
        |--------------------------------------------------------------------------
        */

        $existingPasswords = AdminAccessPassword::query()
            ->where(
                'user_id',
                $user->id
            )
            ->where(
                'is_active',
                true
            )
            ->get();

        foreach ($existingPasswords as $accessPassword) {
            if (
                Hash::check(
                    $validated['password'],
                    $accessPassword->password_hash
                )
            ) {
                return back()
                    ->withErrors([
                        'password' =>
                            'Password tersebut sudah digunakan sebagai password akses lain.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create Supplemental Access Password
        |--------------------------------------------------------------------------
        */

        AdminAccessPassword::create([
            'user_id' => $user->id,

            'recovery_request_id' => $recovery->id,

            'holder_name' => $recovery->requester_name,

            'holder_email' => $recovery->requester_email,

            'password_hash' => Hash::make(
                $validated['password']
            ),

            'is_active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Mark Password as Created
        |--------------------------------------------------------------------------
        */

        $recovery->update([
            'password_created_at' => now(),
        ]);

        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'Password akses berhasil dibuat. Silakan login menggunakan password baru Anda.'
            );
    }
}