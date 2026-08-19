<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminOtpMail;
use App\Models\User;
use App\Models\TrustedDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    /**
     * STEP 1: Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * STEP 1: Proses email + password
     *
     * Kalau device sudah dipercaya:
     *     langsung login
     *
     * Kalau device belum dipercaya:
     *     kirim OTP
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Cek akun admin
        if (!$user || !$user->is_admin) {
            return back()
                ->withErrors([
                    'email' => 'Akun ini tidak memiliki akses sebagai admin.',
                ])
                ->withInput();
        }

        // Cek password
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | CEK TRUSTED DEVICE
        |--------------------------------------------------------------------------
        */

        $trustedToken = $request->cookie('admin_trusted_device');

        if ($trustedToken) {

            $tokenHash = hash('sha256', $trustedToken);

            $trustedDevice = TrustedDevice::where('user_id', $user->id)
                ->where('token_hash', $tokenHash)
                ->first();

            if ($trustedDevice) {

                // Kalau belum expired
                if (
                    !$trustedDevice->expires_at ||
                    $trustedDevice->expires_at->isFuture()
                ) {

                    Auth::guard('admin')->login(
                        $user,
                        $request->boolean('remember')
                    );

                    $request->session()->regenerate();

                    return redirect()->route('admin.dashboard');
                }

                // Kalau expired, hapus
                $trustedDevice->delete();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DEVICE BELUM DIPERCAYA → KIRIM OTP
        |--------------------------------------------------------------------------
        */

        $otp = str_pad(
            random_int(0, 999999),
            6,
            '0',
            STR_PAD_LEFT
        );

        $request->session()->put(
            'admin_pending_user_id',
            $user->id
        );

        $request->session()->put(
            'admin_otp_code',
            $otp
        );

        $request->session()->put(
            'admin_otp_expires_at',
            now()->addMinutes(5)
        );

        $request->session()->put(
            'admin_remember',
            $request->boolean('remember')
        );

        $otpRecipient = env(
            'ADMIN_OTP_EMAIL',
            $user->email
        );

        Mail::to($otpRecipient)
            ->send(new AdminOtpMail($otp));

        return redirect()->route('admin.otp');
    }

    /**
     * STEP 2: Form OTP
     */
    public function showOtpForm(Request $request)
    {
        dd($request->session()->all()); // <-- DEBUG SEMENTARA, hapus setelah selesai testing

        if (
            !$request->session()->has(
                'admin_pending_user_id'
            )
        ) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.otp');
    }

    /**
     * STEP 2: Verifikasi OTP
     */
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

        // Session OTP tidak ditemukan
        if (!$sessionOtp || !$userId) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi OTP tidak ditemukan, silakan login ulang.'
                );
        }

        // OTP expired
        if (
            !$expiresAt ||
            now()->greaterThan($expiresAt)
        ) {

            $request->session()->forget([
                'admin_otp_code',
                'admin_otp_expires_at',
                'admin_pending_user_id',
                'admin_remember',
            ]);

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Kode OTP sudah kedaluwarsa, silakan login ulang.'
                );
        }

        // OTP salah
        if ($request->otp !== $sessionOtp) {
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

        return redirect()->route('admin.confirm');
    }

    /**
     * STEP 3: Form konfirmasi
     */
    public function showConfirmForm(Request $request)
    {
        if (
            !$request->session()->get('admin_otp_verified') ||
            !$request->session()->has('admin_pending_user_id')
        ) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.confirm');
    }

    /**
     * STEP 3:
     *
     * Konfirmasi email + password.
     *
     * Setelah berhasil:
     * 1. Login
     * 2. Buat trusted device
     * 3. Simpan token hash ke database
     * 4. Simpan token asli ke cookie browser
     */
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

        // Cek session
        if (!$userId || !$otpVerified) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi tidak valid, silakan login ulang.'
                );
        }

        $user = User::find($userId);

        // Cek user
        if (!$user || !$user->is_admin) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Akun admin tidak ditemukan.'
                );
        }

        // Cek email
        if (
            strtolower($user->email) !==
            strtolower($request->email)
        ) {
            return back()
                ->with(
                    'error',
                    'Email konfirmasi tidak cocok.'
                );
        }

        // Cek password
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
        | BUAT TRUSTED DEVICE BARU
        |--------------------------------------------------------------------------
        */

        $trustedToken = Str::random(64);

        TrustedDevice::create([
            'user_id' => $user->id,
            'token_hash' => hash(
                'sha256',
                $trustedToken
            ),
            'user_agent' => $request->userAgent(),
            'expires_at' => now()->addYear(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN ADMIN
        |--------------------------------------------------------------------------
        */

        $remember = $request->session()->get(
            'admin_remember',
            false
        );

        Auth::guard('admin')->login($user, $remember);

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN SESSION OTP
        |--------------------------------------------------------------------------
        */

        $request->session()->forget([
            'admin_pending_user_id',
            'admin_otp_verified',
            'admin_remember',
        ]);

        /*
        |--------------------------------------------------------------------------
        | BUAT COOKIE TRUSTED DEVICE
        |--------------------------------------------------------------------------
        |
        | Cookie ini TIDAK dihapus saat logout.
        |
        */

        $cookie = Cookie::make(
            'admin_trusted_device',
            $trustedToken,
            60 * 24 * 365, // 1 tahun
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
}