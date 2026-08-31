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
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $adminEmail = strtolower(
            trim((string) config('services.admin_auth.email'))
        );

        if ($adminEmail === '') {
            return back()
                ->withErrors([
                    'email' => 'Konfigurasi email admin belum tersedia.',
                ])
                ->withInput();
        }

        $loginEmail = strtolower(
            trim($credentials['email'])
        );

        if ($loginEmail !== $adminEmail) {
            return back()
                ->withErrors([
                    'email' => 'Akun ini tidak memiliki akses sebagai admin.',
                ])
                ->withInput();
        }

        $user = User::whereRaw(
            'LOWER(email) = ?',
            [$adminEmail]
        )->first();

        if (!$user || !$user->is_admin) {
            return back()
                ->withErrors([
                    'email' => 'Akun admin tidak ditemukan.',
                ])
                ->withInput();
        }

        $credentialType = null;
        $accessPassword = null;

        if (
            Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {
            $credentialType = 'primary';
        } else {
            $accessPasswords = AdminAccessPassword::where('user_id', $user->id)
                ->where('is_active', true)
                ->whereNull('revoked_at')
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

        if (!$credentialType) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->withInput();
        }

        $cookieName = $this->trustedCookieName(
            $credentialType,
            $accessPassword?->id
        );

        $trustedToken = $request->cookie($cookieName);

        if ($trustedToken) {
            $tokenHash = hash(
                'sha256',
                $trustedToken
            );

            $trustedDevice = TrustedDevice::where('user_id', $user->id)
                ->where('token_hash', $tokenHash)
                ->where('credential_type', $credentialType)
                ->when(
                    $credentialType === 'access',
                    function ($query) use ($accessPassword) {
                        $query->where(
                            'access_password_id',
                            $accessPassword->id
                        );
                    },
                    function ($query) {
                        $query->whereNull('access_password_id');
                    }
                )
                ->first();

            if ($trustedDevice) {
                if (
                    !$trustedDevice->expires_at ||
                    $trustedDevice->expires_at->isFuture()
                ) {
                    Auth::guard('admin')->login(
                        $user,
                        $request->boolean('remember')
                    );

                    if ($accessPassword) {
                        $accessPassword->update([
                            'last_used_at' => now(),
                        ]);
                    }

                    $request->session()->regenerate();

                    return redirect()
                        ->route('admin.dashboard');
                }

                $trustedDevice->delete();
            }
        }

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

        return redirect()
            ->route('admin.google.verify');
    }

    public function showOtpForm(Request $request)
    {
        if (
            !$request->session()->has('admin_pending_user_id') ||
            !$request->session()->has('admin_pending_credential_type') ||
            !$request->session()->has('admin_google_email') ||
            !$request->session()->has('admin_otp_code')
        ) {
            return redirect()
                ->route('admin.login');
        }

        return view('admin.auth.otp');
    }

    public function processOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

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

        if (
            !$sessionOtp ||
            !$userId ||
            !$googleEmail ||
            !in_array($credentialType, ['primary', 'access'], true)
        ) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi OTP tidak ditemukan, silakan login ulang.'
                );
        }

        if (
            !$expiresAt ||
            now()->greaterThan($expiresAt)
        ) {
            $this->clearPendingSession($request);

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Kode OTP sudah kedaluwarsa, silakan login ulang.'
                );
        }

        if ($request->otp !== $sessionOtp) {
            return back()
                ->with(
                    'error',
                    'Kode OTP salah.'
                );
        }

        $request->session()->put(
            'admin_otp_verified',
            true
        );

        $request->session()->forget([
            'admin_otp_code',
            'admin_otp_expires_at',
        ]);

        return redirect()
            ->route('admin.confirm');
    }

    public function showConfirmForm(Request $request)
    {
        $credentialType = $request->session()->get(
            'admin_pending_credential_type'
        );

        if (
            !$request->session()->get('admin_otp_verified') ||
            !$request->session()->has('admin_pending_user_id') ||
            !$request->session()->has('admin_google_email') ||
            !in_array($credentialType, ['primary', 'access'], true)
        ) {
            return redirect()
                ->route('admin.login');
        }

        return view('admin.auth.confirm');
    }

    public function processConfirm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

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

        if (
            !$userId ||
            !$otpVerified ||
            !$googleEmail ||
            !in_array($credentialType, ['primary', 'access'], true)
        ) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi tidak valid, silakan login ulang.'
                );
        }

        if (
            $credentialType === 'access' &&
            !$accessPasswordId
        ) {
            $this->clearPendingSession($request);

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi password akses tidak valid. Silakan login ulang.'
                );
        }

        $user = User::find($userId);

        if (!$user || !$user->is_admin) {
            $this->clearPendingSession($request);

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Akun admin tidak ditemukan.'
                );
        }

        $adminEmail = strtolower(
            trim((string) config('services.admin_auth.email'))
        );

        if (
            strtolower(trim($user->email)) !==
            $adminEmail
        ) {
            $this->clearPendingSession($request);

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Email akun admin tidak sesuai konfigurasi.'
                );
        }

        if (
            strtolower(trim($request->email)) !==
            $adminEmail
        ) {
            return back()
                ->with(
                    'error',
                    'Email konfirmasi tidak cocok.'
                );
        }

        $accessPassword = null;
        $passwordValid = false;

        if ($credentialType === 'primary') {
            $passwordValid = Hash::check(
                $request->password,
                $user->password
            );
        }

        if ($credentialType === 'access') {
            $accessPassword = AdminAccessPassword::where(
                'id',
                $accessPasswordId
            )
                ->where('user_id', $user->id)
                ->where('is_active', true)
                ->whereNull('revoked_at')
                ->first();

            if ($accessPassword) {
                $passwordValid = Hash::check(
                    $request->password,
                    $accessPassword->password_hash
                );
            }
        }

        if (!$passwordValid) {
            return back()
                ->with(
                    'error',
                    'Password konfirmasi tidak cocok.'
                );
        }

        $trustedToken = Str::random(64);

        TrustedDevice::create([
            'user_id' => $user->id,
            'credential_type' => $credentialType,
            'access_password_id' => $accessPassword?->id,
            'token_hash' => hash(
                'sha256',
                $trustedToken
            ),
            'user_agent' => $request->userAgent(),
            'expires_at' => now()->addYear(),
        ]);

        $remember = $request->session()->get(
            'admin_remember',
            false
        );

        Auth::guard('admin')->login(
            $user,
            $remember
        );

        if ($accessPassword) {
            $accessPassword->update([
                'last_used_at' => now(),
            ]);
        }

        $request->session()->regenerate();

        $this->clearPendingSession($request);

        $cookieName = $this->trustedCookieName(
            $credentialType,
            $accessPassword?->id
        );

        $cookie = Cookie::make(
            $cookieName,
            $trustedToken,
            60 * 24 * 365,
            '/',
            null,
            false,
            true,
            false,
            'lax'
        );

        return redirect()
            ->route('admin.dashboard')
            ->withCookie($cookie);
    }

    private function trustedCookieName(
        string $credentialType,
        ?int $accessPasswordId = null
    ): string {
        if (
            $credentialType === 'access' &&
            $accessPasswordId
        ) {
            return 'admin_trusted_device_access_' . $accessPasswordId;
        }

        return 'admin_trusted_device';
    }

    private function clearPendingSession(Request $request): void
    {
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