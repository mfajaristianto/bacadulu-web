<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

class AdminGoogleVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Google Verification Page
    |--------------------------------------------------------------------------
    */

    public function show(Request $request)
    {
        if (
            !$request->session()->has(
                'admin_pending_user_id'
            )
        ) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Silakan login admin terlebih dahulu.'
                );
        }

        return view(
            'admin.auth.google-verify'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Redirect to Google
    |--------------------------------------------------------------------------
    */

    public function redirect(Request $request)
    {
        if (
            !$request->session()->has(
                'admin_pending_user_id'
            )
        ) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi login admin tidak ditemukan.'
                );
        }

        return Socialite::driver('google')
            ->redirectUrl(
                route('admin.google.callback')
            )
            ->scopes([
                'openid',
                'profile',
                'email',
            ])
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();
    }

    /*
    |--------------------------------------------------------------------------
    | Google Callback
    |--------------------------------------------------------------------------
    */

    public function callback(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Check Pending Admin Session
        |--------------------------------------------------------------------------
        */

        $userId = $request->session()->get(
            'admin_pending_user_id'
        );

        if (!$userId) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi login admin tidak ditemukan.'
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
            $this->clearAdminVerificationSession(
                $request
            );

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Akun admin tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Admin Email Configuration
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
            $adminEmail === '' ||
            strtolower(
                trim(
                    $user->email
                )
            ) !== $adminEmail
        ) {
            $this->clearAdminVerificationSession(
                $request
            );

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Konfigurasi akun admin tidak sesuai.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Google Identity
        |--------------------------------------------------------------------------
        */

        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(
                    route('admin.google.callback')
                )
                ->user();
        } catch (InvalidStateException $exception) {
            report(
                $exception
            );

            return redirect()
                ->route('admin.google.verify')
                ->with(
                    'error',
                    'Sesi verifikasi Google sudah berakhir atau tidak valid. Silakan pilih akun Google kembali.'
                );
        } catch (Throwable $exception) {
            report(
                $exception
            );

            return redirect()
                ->route('admin.google.verify')
                ->with(
                    'error',
                    'Verifikasi Google gagal atau dibatalkan. Silakan coba kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Google Email
        |--------------------------------------------------------------------------
        */

        $googleEmail = strtolower(
            trim(
                (string) $googleUser->getEmail()
            )
        );

        if ($googleEmail === '') {
            return redirect()
                ->route('admin.google.verify')
                ->with(
                    'error',
                    'Google tidak memberikan alamat email. Silakan gunakan akun Google lain.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Google Name
        |--------------------------------------------------------------------------
        */

        $googleName = trim(
            (string) (
                $googleUser->getName()
                ?: $googleUser->getNickname()
                ?: 'Pengguna Google'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Google ID
        |--------------------------------------------------------------------------
        */

        $googleId = trim(
            (string) $googleUser->getId()
        );

        /*
        |--------------------------------------------------------------------------
        | Save Google Identity
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'admin_google_name',
            $googleName
        );

        $request->session()->put(
            'admin_google_email',
            $googleEmail
        );

        $request->session()->put(
            'admin_google_id',
            $googleId
        );

        /*
        |--------------------------------------------------------------------------
        | Remove Old OTP
        |--------------------------------------------------------------------------
        |
        | Penting jika sebelumnya pernah ada OTP dari percobaan lain.
        |
        */

        $request->session()->forget([
            'admin_otp_code',
            'admin_otp_expires_at',
            'admin_otp_verified',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate OTP
        |--------------------------------------------------------------------------
        */

        $otp = str_pad(
            random_int(
                0,
                999999
            ),
            6,
            '0',
            STR_PAD_LEFT
        );

        /*
        |--------------------------------------------------------------------------
        | OTP Recipient
        |--------------------------------------------------------------------------
        */

        $otpRecipient = strtolower(
            trim(
                (string) config(
                    'services.admin_auth.otp_email'
                )
            )
        );

        if ($otpRecipient === '') {
            $otpRecipient = strtolower(
                trim(
                    $user->email
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate OTP Recipient
        |--------------------------------------------------------------------------
        */

        if (
            !filter_var(
                $otpRecipient,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            return redirect()
                ->route('admin.google.verify')
                ->with(
                    'error',
                    'Email penerima OTP belum dikonfigurasi dengan benar.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Device Information
        |--------------------------------------------------------------------------
        */

        $userAgent = (string) $request->userAgent();

        $loginInfo = [
            'google_name' => $googleName,
            'google_email' => $googleEmail,

            'account_name' => $user->name,
            'account_email' => $user->email,

            'device' => $this->detectDevice(
                $userAgent
            ),

            'device_model' => $this->detectDeviceModel(
                $userAgent
            ),

            'os' => $this->detectOperatingSystem(
                $userAgent
            ),

            'browser' => $this->detectBrowser(
                $userAgent
            ),

            'ip' => $request->ip()
                ?: 'Tidak diketahui',

            'time' => now()
                ->timezone('Asia/Jakarta')
                ->translatedFormat(
                    'd F Y, H:i'
                ) . ' WIB',

            'user_agent' => $userAgent,
        ];

        /*
        |--------------------------------------------------------------------------
        | Send OTP
        |--------------------------------------------------------------------------
        |
        | OTP BELUM dimasukkan ke session.
        |
        | Jadi apabila SMTP gagal, sistem tidak memiliki OTP aktif
        | yang sebenarnya tidak pernah diterima oleh admin.
        |
        */

        try {
            Mail::to(
                $otpRecipient
            )->send(
                new AdminOtpMail(
                    $otp,
                    $loginInfo
                )
            );
        } catch (Throwable $exception) {
            report(
                $exception
            );

            /*
             * Pastikan tidak ada OTP lama yang masih dianggap valid.
             */
            $request->session()->forget([
                'admin_otp_code',
                'admin_otp_expires_at',
                'admin_otp_verified',
            ]);

            return redirect()
                ->route('admin.google.verify')
                ->with(
                    'error',
                    'Kode OTP belum berhasil dikirim melalui email. Silakan periksa koneksi atau konfigurasi email, lalu coba kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Save OTP Only After Email Successfully Sent
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'admin_otp_code',
            $otp
        );

        $request->session()->put(
            'admin_otp_expires_at',
            now()->addMinutes(5)
        );

        $request->session()->put(
            'admin_otp_verified',
            false
        );

        /*
        |--------------------------------------------------------------------------
        | Redirect to OTP Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.otp');
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Admin Verification Session
    |--------------------------------------------------------------------------
    */

    private function clearAdminVerificationSession(
        Request $request
    ): void {
        $request->session()->forget([
            'admin_pending_user_id',
            'admin_remember',

            'admin_google_name',
            'admin_google_email',
            'admin_google_id',

            'admin_otp_code',
            'admin_otp_expires_at',
            'admin_otp_verified',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Detect Device
    |--------------------------------------------------------------------------
    */

    private function detectDevice(
        ?string $userAgent
    ): string {
        $ua = strtolower(
            $userAgent ?? ''
        );

        if (
            str_contains(
                $ua,
                'ipad'
            ) ||
            str_contains(
                $ua,
                'tablet'
            )
        ) {
            return 'Tablet';
        }

        if (
            str_contains(
                $ua,
                'iphone'
            ) ||
            str_contains(
                $ua,
                'android'
            ) ||
            str_contains(
                $ua,
                'mobile'
            )
        ) {
            return 'Smartphone';
        }

        return 'Desktop / Laptop';
    }

    /*
    |--------------------------------------------------------------------------
    | Detect Device Model
    |--------------------------------------------------------------------------
    */

    private function detectDeviceModel(
        ?string $userAgent
    ): string {
        $ua = $userAgent ?? '';

        if (
            stripos(
                $ua,
                'iPhone'
            ) !== false
        ) {
            return 'Apple iPhone';
        }

        if (
            stripos(
                $ua,
                'iPad'
            ) !== false
        ) {
            return 'Apple iPad';
        }

        if (
            stripos(
                $ua,
                'Android'
            ) !== false
        ) {
            if (
                preg_match(
                    '/Android\s[^;]+;\s*([^;)]+?)(?:\s+Build\/|;|\))/i',
                    $ua,
                    $matches
                )
            ) {
                $model = trim(
                    $matches[1]
                );

                if ($model !== '') {
                    return $model;
                }
            }

            return 'Perangkat Android';
        }

        if (
            stripos(
                $ua,
                'Windows'
            ) !== false
        ) {
            return 'Windows PC / Laptop';
        }

        if (
            stripos(
                $ua,
                'Macintosh'
            ) !== false
        ) {
            return 'Mac';
        }

        if (
            stripos(
                $ua,
                'Linux'
            ) !== false
        ) {
            return 'Linux PC / Laptop';
        }

        return 'Model tidak dapat diketahui';
    }

    /*
    |--------------------------------------------------------------------------
    | Detect Browser
    |--------------------------------------------------------------------------
    */

    private function detectBrowser(
        ?string $userAgent
    ): string {
        $ua = strtolower(
            $userAgent ?? ''
        );

        if (
            str_contains(
                $ua,
                'edg/'
            )
        ) {
            return 'Microsoft Edge';
        }

        if (
            str_contains(
                $ua,
                'opr/'
            ) ||
            str_contains(
                $ua,
                'opera'
            )
        ) {
            return 'Opera';
        }

        if (
            str_contains(
                $ua,
                'samsungbrowser/'
            )
        ) {
            return 'Samsung Internet';
        }

        if (
            str_contains(
                $ua,
                'crios/'
            ) ||
            str_contains(
                $ua,
                'chrome/'
            )
        ) {
            return 'Google Chrome';
        }

        if (
            str_contains(
                $ua,
                'fxios/'
            ) ||
            str_contains(
                $ua,
                'firefox/'
            )
        ) {
            return 'Mozilla Firefox';
        }

        if (
            str_contains(
                $ua,
                'safari/'
            )
        ) {
            return 'Safari';
        }

        return 'Browser tidak diketahui';
    }

    /*
    |--------------------------------------------------------------------------
    | Detect Operating System
    |--------------------------------------------------------------------------
    */

    private function detectOperatingSystem(
        ?string $userAgent
    ): string {
        $ua = strtolower(
            $userAgent ?? ''
        );

        if (
            str_contains(
                $ua,
                'windows nt 10.0'
            )
        ) {
            return 'Windows 10 / 11';
        }

        if (
            str_contains(
                $ua,
                'windows nt 6.3'
            )
        ) {
            return 'Windows 8.1';
        }

        if (
            str_contains(
                $ua,
                'windows nt 6.2'
            )
        ) {
            return 'Windows 8';
        }

        if (
            str_contains(
                $ua,
                'windows nt 6.1'
            )
        ) {
            return 'Windows 7';
        }

        if (
            str_contains(
                $ua,
                'windows'
            )
        ) {
            return 'Windows';
        }

        if (
            preg_match(
                '/Android\s([0-9.]+)/i',
                $userAgent ?? '',
                $matches
            )
        ) {
            return 'Android ' .
                $matches[1];
        }

        if (
            preg_match(
                '/OS\s([0-9_]+)/i',
                $userAgent ?? '',
                $matches
            ) &&
            (
                str_contains(
                    $ua,
                    'iphone'
                ) ||
                str_contains(
                    $ua,
                    'ipad'
                )
            )
        ) {
            return 'iOS / iPadOS ' .
                str_replace(
                    '_',
                    '.',
                    $matches[1]
                );
        }

        if (
            preg_match(
                '/Mac OS X\s([0-9_]+)/i',
                $userAgent ?? '',
                $matches
            )
        ) {
            return 'macOS ' .
                str_replace(
                    '_',
                    '.',
                    $matches[1]
                );
        }

        if (
            str_contains(
                $ua,
                'linux'
            )
        ) {
            return 'Linux';
        }

        return 'Sistem operasi tidak diketahui';
    }
}