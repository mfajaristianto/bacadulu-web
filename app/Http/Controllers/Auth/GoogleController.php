<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman login Google
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback setelah login dari Google
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari berdasarkan google_id
            $user = User::where('google_id', $googleUser->id)->first();

            // Kalau belum ada, coba cari berdasarkan email
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
            }

            // Kalau user belum ada, buat user baru
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null,
                    'is_admin' => false,
                    'email_verified_at' => now(),
                ]);
            } else {
                // Update data Google ke user yang sudah ada
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'name' => $googleUser->name,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            }

            // Login user
            Auth::login($user, true);

            // Regenerate session
            request()->session()->regenerate();

            // Kalau user adalah admin
            if ($user->is_admin) {
                return redirect('/admin');
            }

            // User biasa
            return redirect()->intended('/blog');

        } catch (\Exception $e) {
            return redirect('/login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}