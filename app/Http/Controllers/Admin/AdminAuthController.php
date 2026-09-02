<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccessPassword;
use App\Models\TrustedDevice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Form
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Configured Admin Email
        |--------------------------------------------------------------------------
        */

        $adminEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.email'
                )
            )
        );

        if ($adminEmail === '') {
            return back()
                ->withErrors([
                    'email' =>
                        'Konfigurasi email admin belum tersedia.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Login Email
        |--------------------------------------------------------------------------
        */

        $loginEmail = strtolower(
            trim(
                $credentials['email']
            )
        );

        if ($loginEmail !== $adminEmail) {
            return back()
                ->withErrors([
                    'email' =>
                        'Akun ini tidak memiliki akses sebagai admin.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Find Admin
        |--------------------------------------------------------------------------
        */

        $user = User::query()
            ->whereRaw(
                'LOWER(email) = ?',
                [
                    $adminEmail,
                ]
            )
            ->first();

        if (
            !$user ||
            !$user->is_admin
        ) {
            return back()
                ->withErrors([
                    'email' =>
                        'Akun admin tidak ditemukan.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Identify Credential
        |--------------------------------------------------------------------------
        |
        | Credential dapat berupa:
        |
        | primary = password utama admin
        | access  = password tambahan hasil recovery
        |
        */

        $credentialType = null;
        $accessPassword = null;

        /*
        |--------------------------------------------------------------------------
        | Primary Password
        |--------------------------------------------------------------------------
        */

        if (
            Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {
            $credentialType = 'primary';
        } else {
            /*
            |--------------------------------------------------------------------------
            | Supplemental Access Password
            |--------------------------------------------------------------------------
            */

            $accessPasswords = AdminAccessPassword::query()
                ->where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'is_active',
                    true
                )
                ->whereNull(
                    'revoked_at'
                )
                ->get();

            foreach ($accessPasswords as $candidate) {
                if (
                    Hash::check(
                        $credentials['password'],
                        $candidate->password_hash
                    )
                ) {
                    $credentialType = 'access';
                    $accessPassword = $candidate;

                    break;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Invalid Password
        |--------------------------------------------------------------------------
        */

        if (!$credentialType) {
            return back()
                ->withErrors([
                    'email' =>
                        'Email atau password salah.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Trusted Device Cookie
        |--------------------------------------------------------------------------
        */

        $cookieName = $this->trustedCookieName(
            $credentialType,
            $accessPassword?->id
        );

        $trustedToken = $request->cookie(
            $cookieName
        );

        /*
        |--------------------------------------------------------------------------
        | Trusted Device Login
        |--------------------------------------------------------------------------
        */

        if ($trustedToken) {
            $tokenHash = hash(
                'sha256',
                $trustedToken
            );

            $trustedDevice = TrustedDevice::query()
                ->where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'token_hash',
                    $tokenHash
                )
                ->where(
                    'credential_type',
                    $credentialType
                )
                ->where(
                    'user_agent',
                    (string) $request->userAgent()
                )
                ->when(
                    $credentialType === 'access',
                    function ($query) use ($accessPassword) {
                        $query->where(
                            'access_password_id',
                            $accessPassword->id
                        );
                    },
                    function ($query) {
                        $query->whereNull(
                            'access_password_id'
                        );
                    }
                )
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Valid Trusted Device
            |--------------------------------------------------------------------------
            */

            if ($trustedDevice) {
                if (
                    !$trustedDevice->expires_at ||
                    $trustedDevice->expires_at->isFuture()
                ) {
                    Auth::guard('admin')->login(
                        $user,
                        $request->boolean('remember')
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Record Supplemental Password Usage
                    |--------------------------------------------------------------------------
                    */

                    if ($accessPassword) {
                        $accessPassword->update([
                            'last_used_at' => now(),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Regenerate Session
                    |--------------------------------------------------------------------------
                    */

                    $request->session()->regenerate();

                    return redirect()
                        ->route(
                            'admin.dashboard'
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | Remove Expired Trusted Device
                |--------------------------------------------------------------------------
                */

                $trustedDevice->delete();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Clear Old Verification State
        |--------------------------------------------------------------------------
        */

        $request->session()->forget([
            'admin_google_name',
            'admin_google_email',
            'admin_google_id',

            'admin_otp_code',
            'admin_otp_expires_at',
            'admin_otp_verified',

            'admin_pending_credential_type',
            'admin_pending_access_password_id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Save Pending Admin
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'admin_pending_user_id',
            $user->id
        );

        $request->session()->put(
            'admin_remember',
            $request->boolean('remember')
        );

        $request->session()->put(
            'admin_pending_credential_type',
            $credentialType
        );

        $request->session()->put(
            'admin_pending_access_password_id',
            $accessPassword?->id
        );

        /*
        |--------------------------------------------------------------------------
        | Continue to Google Verification
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.google.verify'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Show OTP Form
    |--------------------------------------------------------------------------
    */

    public function showOtpForm(Request $request)
    {
        if (
            !$request->session()->has(
                'admin_pending_user_id'
            ) ||
            !$request->session()->has(
                'admin_pending_credential_type'
            ) ||
            !$request->session()->has(
                'admin_google_email'
            )
        ) {
            return redirect()
                ->route(
                    'admin.login'
                );
        }

        return view(
            'admin.auth.otp'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Process OTP
    |--------------------------------------------------------------------------
    */

    public function processOtp(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | OTP Session
        |--------------------------------------------------------------------------
        */

        $sessionOtp = $request->session()->get(
            'admin_otp_code'
        );

        $expiresAt = $request->session()->get(
            'admin_otp_expires_at'
        );

        $userId = $request->session()->get(
            'admin_pending_user_id'
        );

        $credentialType = $request->session()->get(
            'admin_pending_credential_type'
        );

        $googleEmail = $request->session()->get(
            'admin_google_email'
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Pending Login Session
        |--------------------------------------------------------------------------
        */

        if (
            !$userId ||
            !$googleEmail ||
            !in_array(
                $credentialType,
                [
                    'primary',
                    'access',
                ],
                true
            )
        ) {
            return redirect()
                ->route(
                    'admin.login'
                )
                ->with(
                    'error',
                    'Sesi OTP tidak ditemukan, silakan login ulang.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OTP Not Available
        |--------------------------------------------------------------------------
        */

        if (
            !$sessionOtp ||
            !$expiresAt
        ) {
            return back()
                ->with(
                    'error',
                    'Kode OTP belum tersedia. Silakan ulangi proses verifikasi Google.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OTP Expired
        |--------------------------------------------------------------------------
        */

        if (
            now()->greaterThan(
                $expiresAt
            )
        ) {
            $request->session()->forget([
                'admin_otp_code',
                'admin_otp_expires_at',
                'admin_otp_verified',
            ]);

            return back()
                ->with(
                    'error',
                    'Kode OTP sudah kedaluwarsa. Silakan ulangi proses verifikasi Google.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OTP Comparison
        |--------------------------------------------------------------------------
        */

        if (
            !hash_equals(
                (string) $sessionOtp,
                (string) $request->otp
            )
        ) {
            return back()
                ->with(
                    'error',
                    'Kode OTP salah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OTP Verified
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'admin_otp_verified',
            true
        );

        $request->session()->forget([
            'admin_otp_code',
            'admin_otp_expires_at',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Continue to Confirm Access
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.confirm'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Show Confirm Form
    |--------------------------------------------------------------------------
    */

    public function showConfirmForm(Request $request)
    {
        $credentialType = $request->session()->get(
            'admin_pending_credential_type'
        );

        if (
            !$request->session()->get(
                'admin_otp_verified'
            ) ||
            !$request->session()->has(
                'admin_pending_user_id'
            ) ||
            !$request->session()->has(
                'admin_google_email'
            ) ||
            !in_array(
                $credentialType,
                [
                    'primary',
                    'access',
                ],
                true
            )
        ) {
            return redirect()
                ->route(
                    'admin.login'
                );
        }

        return view(
            'admin.auth.confirm'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Process Confirm Access
    |--------------------------------------------------------------------------
    */

    public function processConfirm(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pending Session
        |--------------------------------------------------------------------------
        */

        $userId = $request->session()->get(
            'admin_pending_user_id'
        );

        $otpVerified = $request->session()->get(
            'admin_otp_verified'
        );

        $googleEmail = $request->session()->get(
            'admin_google_email'
        );

        $credentialType = $request->session()->get(
            'admin_pending_credential_type'
        );

        $accessPasswordId = $request->session()->get(
            'admin_pending_access_password_id'
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Session
        |--------------------------------------------------------------------------
        */

        if (
            !$userId ||
            !$otpVerified ||
            !$googleEmail ||
            !in_array(
                $credentialType,
                [
                    'primary',
                    'access',
                ],
                true
            )
        ) {
            return redirect()
                ->route(
                    'admin.login'
                )
                ->with(
                    'error',
                    'Sesi tidak valid, silakan login ulang.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Supplemental Password Session
        |--------------------------------------------------------------------------
        */

        if (
            $credentialType === 'access' &&
            !$accessPasswordId
        ) {
            $this->clearPendingSession(
                $request
            );

            return redirect()
                ->route(
                    'admin.login'
                )
                ->with(
                    'error',
                    'Sesi password akses tidak valid. Silakan login ulang.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Find Admin
        |--------------------------------------------------------------------------
        */

        $user = User::find(
            $userId
        );

        if (
            !$user ||
            !$user->is_admin
        ) {
            $this->clearPendingSession(
                $request
            );

            return redirect()
                ->route(
                    'admin.login'
                )
                ->with(
                    'error',
                    'Akun admin tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Email Configuration
        |--------------------------------------------------------------------------
        */

        $adminEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.email'
                )
            )
        );

        if (
            strtolower(
                trim(
                    $user->email
                )
            ) !== $adminEmail
        ) {
            $this->clearPendingSession(
                $request
            );

            return redirect()
                ->route(
                    'admin.login'
                )
                ->with(
                    'error',
                    'Email akun admin tidak sesuai konfigurasi.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Confirm Email
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    $request->email
                )
            ) !== $adminEmail
        ) {
            return back()
                ->with(
                    'error',
                    'Email konfirmasi tidak cocok.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Confirm Password
        |--------------------------------------------------------------------------
        */

        $accessPassword = null;
        $passwordValid = false;

        /*
        |--------------------------------------------------------------------------
        | Primary Credential
        |--------------------------------------------------------------------------
        */

        if (
            $credentialType === 'primary'
        ) {
            $passwordValid = Hash::check(
                $request->password,
                $user->password
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Supplemental Credential
        |--------------------------------------------------------------------------
        */

        if (
            $credentialType === 'access'
        ) {
            $accessPassword = AdminAccessPassword::query()
                ->where(
                    'id',
                    $accessPasswordId
                )
                ->where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'is_active',
                    true
                )
                ->whereNull(
                    'revoked_at'
                )
                ->first();

            if ($accessPassword) {
                $passwordValid = Hash::check(
                    $request->password,
                    $accessPassword->password_hash
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Invalid Confirm Password
        |--------------------------------------------------------------------------
        */

        if (!$passwordValid) {
            return back()
                ->with(
                    'error',
                    'Password konfirmasi tidak cocok.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Trusted Device Token
        |--------------------------------------------------------------------------
        */

        $trustedToken = Str::random(
            64
        );

        /*
        |--------------------------------------------------------------------------
        | Save Trusted Device
        |--------------------------------------------------------------------------
        |
        | Token asli tidak disimpan ke database.
        |
        | Database hanya menyimpan SHA-256 hash token.
        |
        */

        TrustedDevice::create([
            'user_id' => $user->id,

            'credential_type' => $credentialType,

            'access_password_id' =>
                $accessPassword?->id,

            'token_hash' => hash(
                'sha256',
                $trustedToken
            ),

            'user_agent' =>
                (string) $request->userAgent(),

            'expires_at' =>
                now()->addYear(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Remember Login
        |--------------------------------------------------------------------------
        */

        $remember = $request->session()->get(
            'admin_remember',
            false
        );

        /*
        |--------------------------------------------------------------------------
        | Login Admin
        |--------------------------------------------------------------------------
        */

        Auth::guard('admin')->login(
            $user,
            $remember
        );

        /*
        |--------------------------------------------------------------------------
        | Update Supplemental Password Usage
        |--------------------------------------------------------------------------
        */

        if ($accessPassword) {
            $accessPassword->update([
                'last_used_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Clear Pending Verification Data
        |--------------------------------------------------------------------------
        */

        $this->clearPendingSession(
            $request
        );

        /*
        |--------------------------------------------------------------------------
        | Trusted Cookie Name
        |--------------------------------------------------------------------------
        */

        $cookieName = $this->trustedCookieName(
            $credentialType,
            $accessPassword?->id
        );

        /*
        |--------------------------------------------------------------------------
        | Secure Cookie Configuration
        |--------------------------------------------------------------------------
        |
        | Jika SESSION_SECURE_COOKIE di .env memiliki nilai,
        | nilai tersebut digunakan.
        |
        | Jika null:
        |
        | HTTPS → secure cookie = true
        | HTTP  → secure cookie = false
        |
        */

        $secureCookie = config(
            'session.secure'
        );

        if ($secureCookie === null) {
            $secureCookie = $request->isSecure();
        }

        /*
        |--------------------------------------------------------------------------
        | Create Trusted Device Cookie
        |--------------------------------------------------------------------------
        */

        $cookie = Cookie::make(
            $cookieName,
            $trustedToken,

            /*
             * 1 tahun
             */
            60 * 24 * 365,

            /*
             * Path
             */
            config(
                'session.path',
                '/'
            ),

            /*
             * Domain
             */
            config(
                'session.domain'
            ),

            /*
             * Secure
             */
            (bool) $secureCookie,

            /*
             * HttpOnly
             */
            true,

            /*
             * Raw
             */
            false,

            /*
             * SameSite
             */
            config(
                'session.same_site',
                'lax'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.dashboard'
            )
            ->withCookie(
                $cookie
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Trusted Cookie Name
    |--------------------------------------------------------------------------
    */

    private function trustedCookieName(
        string $credentialType,
        ?int $accessPasswordId = null
    ): string {
        if (
            $credentialType === 'access' &&
            $accessPasswordId
        ) {
            return
                'admin_trusted_device_access_' .
                $accessPasswordId;
        }

        return 'admin_trusted_device';
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Pending Session
    |--------------------------------------------------------------------------
    */

    private function clearPendingSession(
        Request $request
    ): void {
        $request->session()->forget([
            'admin_pending_user_id',
            'admin_pending_credential_type',
            'admin_pending_access_password_id',

            'admin_otp_verified',
            'admin_remember',

            'admin_otp_code',
            'admin_otp_expires_at',

            'admin_google_name',
            'admin_google_email',
            'admin_google_id',
        ]);
    }
}