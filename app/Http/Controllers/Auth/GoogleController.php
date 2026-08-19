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
        return Socialite::driver('google')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->stateless()
            ->redirect();
    }

    /**
     * Callback setelah login dari Google
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();

            // 1. Cari berdasarkan google_id terlebih dahulu
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // Update data jika sudah ada berdasarkan google_id
                $user->update([
                    'avatar' => $googleUser->avatar,
                    'name' => $googleUser->name,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // 2. Jika belum ada google_id, cek apakah emailnya adalah Admin Utama
                $adminEmail = 'adminbacadulu@gmail.com'; // Sesuaikan dengan email admin Anda

                if ($googleUser->email === $adminEmail) {
                    $user = User::where('email', $adminEmail)->first();
                    
                    if ($user) {
                        $user->update([
                            'google_id' => $googleUser->id,
                            'avatar' => $googleUser->avatar,
                            'name' => $googleUser->name,
                        ]);
                    }
                }

                // 3. Jika tetap tidak ada, buat user baru (Dijamin Penulis / is_admin = false)
                if (!$user) {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar ?? null,
                        'password' => bcrypt(\Illuminate\Support\Str::random(16)),
                        'is_admin' => false, // Pastikan selalu false untuk user baru dari Google
                        'email_verified_at' => now(),
                    ]);
                }
            }

            // Login user
            Auth::login($user, true);

            // Regenerate session untuk membersihkan sisa sesi sebelumnya
            request()->session()->regenerate();

            // Redirect berdasarkan status is_admin di database
            if ($user->is_admin) {
                return redirect('/admin');
            }

            // User biasa / penulis
            return redirect()->intended('/blog');

        } catch (\Exception $e) {
            // Aktifkan baris di bawah ini jika ingin melihat detail error saat debugging
            // dd($e->getMessage(), $e->getTraceAsString());

            return redirect('/login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}