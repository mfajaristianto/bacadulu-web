<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrustedDevice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view(
            'admin.auth.login'
        );
    }

    /**
     * Login email + password.
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
        | EMAIL ADMIN CONFIG
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
        | CEK EMAIL LOGIN
        |--------------------------------------------------------------------------
        */

        $loginEmail = strtolower(
            trim(
                $credentials['email']
            )
        );

        if (
            $loginEmail !==
            $adminEmail
        ) {
            return back()
                ->withErrors([
                    'email' =>
                        'Akun ini tidak memiliki akses sebagai admin.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | CARI ADMIN
        |--------------------------------------------------------------------------
        */

        $user = User::whereRaw(
            'LOWER(email) = ?',
            [$adminEmail]
        )->first();

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
        | CEK PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'email' =>
                        'Email atau password salah.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | CEK TRUSTED DEVICE
        |--------------------------------------------------------------------------
        */

        $trustedToken = $request->cookie(
            'admin_trusted_device'
        );

        if ($trustedToken) {
            $tokenHash = hash(
                'sha256',
                $trustedToken
            );

            $trustedDevice =
                TrustedDevice::where(
                    'user_id',
                    $user->id
                )
                    ->where(
                        'token_hash',
                        $tokenHash
                    )
                    ->first();

            if ($trustedDevice) {
                if (
                    !$trustedDevice->expires_at ||
                    $trustedDevice
                        ->expires_at
                        ->isFuture()
                ) {
                    Auth::guard('admin')->login(
                        $user,
                        $request->boolean(
                            'remember'
                        )
                    );

                    $request
                        ->session()
                        ->regenerate();

                    return redirect()
                        ->route(
                            'admin.dashboard'
                        );
                }

                $trustedDevice->delete();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DEVICE BARU
        |--------------------------------------------------------------------------
        |
        | Password sudah benar.
        |
        | Belum kirim OTP.
        | Sekarang minta identitas Google.
        |
        */

        $request->session()->forget([
            'admin_google_name',
            'admin_google_email',
            'admin_google_id',
            'admin_otp_code',
            'admin_otp_expires_at',
            'admin_otp_verified',
        ]);

        $request->session()->put(
            'admin_pending_user_id',
            $user->id
        );

        $request->session()->put(
            'admin_remember',
            $request->boolean(
                'remember'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI GOOGLE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.google.verify'
            );
    }

    /**
     * Form OTP.
     */
    public function showOtpForm(
        Request $request
    ) {
        if (
            !$request->session()->has(
                'admin_pending_user_id'
            ) ||
            !$request->session()->has(
                'admin_google_email'
            ) ||
            !$request->session()->has(
                'admin_otp_code'
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

    /**
     * Proses OTP.
     */
    public function processOtp(
        Request $request
    ) {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);

        $sessionOtp =
            $request->session()->get(
                'admin_otp_code'
            );

        $expiresAt =
            $request->session()->get(
                'admin_otp_expires_at'
            );

        $userId =
            $request->session()->get(
                'admin_pending_user_id'
            );

        $googleEmail =
            $request->session()->get(
                'admin_google_email'
            );

        /*
        |--------------------------------------------------------------------------
        | SESSION TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (
            !$sessionOtp ||
            !$userId ||
            !$googleEmail
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
        | OTP EXPIRED
        |--------------------------------------------------------------------------
        */

        if (
            !$expiresAt ||
            now()->greaterThan(
                $expiresAt
            )
        ) {
            $request->session()->forget([
                'admin_otp_code',
                'admin_otp_expires_at',
                'admin_pending_user_id',
                'admin_remember',
                'admin_otp_verified',
                'admin_google_name',
                'admin_google_email',
                'admin_google_id',
            ]);

            return redirect()
                ->route(
                    'admin.login'
                )
                ->with(
                    'error',
                    'Kode OTP sudah kedaluwarsa, silakan login ulang.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OTP SALAH
        |--------------------------------------------------------------------------
        */

        if (
            $request->otp !==
            $sessionOtp
        ) {
            return back()
                ->with(
                    'error',
                    'Kode OTP salah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OTP BENAR
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

        return redirect()
            ->route(
                'admin.confirm'
            );
    }

    /**
     * Form konfirmasi terakhir.
     */
    public function showConfirmForm(
        Request $request
    ) {
        if (
            !$request->session()->get(
                'admin_otp_verified'
            ) ||
            !$request->session()->has(
                'admin_pending_user_id'
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
            'admin.auth.confirm'
        );
    }

    /**
     * Konfirmasi email + password.
     */
    public function processConfirm(
        Request $request
    ) {
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

        $userId =
            $request->session()->get(
                'admin_pending_user_id'
            );

        $otpVerified =
            $request->session()->get(
                'admin_otp_verified'
            );

        $googleEmail =
            $request->session()->get(
                'admin_google_email'
            );

        /*
        |--------------------------------------------------------------------------
        | CEK SESSION
        |--------------------------------------------------------------------------
        */

        if (
            !$userId ||
            !$otpVerified ||
            !$googleEmail
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
        | USER
        |--------------------------------------------------------------------------
        */

        $user = User::find(
            $userId
        );

        if (
            !$user ||
            !$user->is_admin
        ) {
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
        | EMAIL ADMIN CONFIG
        |--------------------------------------------------------------------------
        */

        $adminEmail = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.email'
                )
            )
        );

        /*
        |--------------------------------------------------------------------------
        | EMAIL DATABASE
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    $user->email
                )
            ) !==
            $adminEmail
        ) {
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
        | EMAIL KONFIRMASI
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    $request->email
                )
            ) !==
            $adminEmail
        ) {
            return back()
                ->with(
                    'error',
                    'Email konfirmasi tidak cocok.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD KONFIRMASI
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {
            return back()
                ->with(
                    'error',
                    'Password konfirmasi tidak cocok.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TRUSTED DEVICE
        |--------------------------------------------------------------------------
        */

        $trustedToken =
            Str::random(64);

        TrustedDevice::create([
            'user_id' =>
                $user->id,

            'token_hash' =>
                hash(
                    'sha256',
                    $trustedToken
                ),

            'user_agent' =>
                $request->userAgent(),

            'expires_at' =>
                now()->addYear(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN ADMIN
        |--------------------------------------------------------------------------
        */

        $remember =
            $request->session()->get(
                'admin_remember',
                false
            );

        Auth::guard('admin')->login(
            $user,
            $remember
        );

        $request
            ->session()
            ->regenerate();

        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->forget([
            'admin_pending_user_id',
            'admin_otp_verified',
            'admin_remember',
            'admin_otp_code',
            'admin_otp_expires_at',
            'admin_google_name',
            'admin_google_email',
            'admin_google_id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | COOKIE TRUSTED DEVICE
        |--------------------------------------------------------------------------
        */

        $cookie = Cookie::make(
            'admin_trusted_device',
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
            ->route(
                'admin.dashboard'
            )
            ->withCookie(
                $cookie
            );
    }
}