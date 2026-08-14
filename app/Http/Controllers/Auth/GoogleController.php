<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user ke Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback dari Google.
     */
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();

            // Email wajib ada
            if (!$email) {
                return redirect('/login')
                    ->with('error', 'Google tidak memberikan alamat email.');
            }

            /*
            |--------------------------------------------------------------------------
            | Cari user berdasarkan Google ID
            |--------------------------------------------------------------------------
            */

            $user = User::where('google_id', $googleId)->first();

            /*
            |--------------------------------------------------------------------------
            | Kalau belum ketemu, cari berdasarkan email
            |--------------------------------------------------------------------------
            */

            if (!$user) {
                $user = User::where('email', $email)->first();
            }

            /*
            |--------------------------------------------------------------------------
            | Kalau user belum ada → buat user baru
            |--------------------------------------------------------------------------
            */

            if (!$user) {

                $user = User::create([
                    'name' => $googleUser->getName() ?: 'User',
                    'email' => $email,
                    'google_id' => $googleId,
                    'avatar' => $googleUser->getAvatar(),

                    /*
                    |--------------------------------------------------------------------------
                    | Password acak
                    |--------------------------------------------------------------------------
                    |
                    | Database kamu mengharuskan password tidak NULL.
                    | Password ini tidak diketahui user dan tidak digunakan
                    | untuk login Google.
                    |
                    */

                    'password' => Str::random(64),

                    // Google Login = user biasa
                    'is_admin' => false,

                    'email_verified_at' => now(),
                ]);

            } else {

                /*
                |--------------------------------------------------------------------------
                | User sudah ada
                |--------------------------------------------------------------------------
                */

                $user->google_id = $googleId;

                if ($googleUser->getAvatar()) {
                    $user->avatar = $googleUser->getAvatar();
                }

                if ($googleUser->getName()) {
                    $user->name = $googleUser->getName();
                }

                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                }

                $user->save();
            }

            /*
            |--------------------------------------------------------------------------
            | Login user
            |--------------------------------------------------------------------------
            */

            Auth::login($user, true);

            request()->session()->regenerate();

            /*
            |--------------------------------------------------------------------------
            | Google Login selalu masuk ke BLOG
            |--------------------------------------------------------------------------
            */

            return redirect('/blog')
                ->with(
                    'success',
                    'Berhasil masuk! Selamat datang, ' . $user->name . '.'
                );

        } catch (\Throwable $e) {

            Log::error('GOOGLE LOGIN ERROR', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect('/login')
                ->with(
                    'error',
                    'Login Google gagal: ' . $e->getMessage()
                );
        }
    }
}