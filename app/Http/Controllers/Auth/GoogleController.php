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


            /*
            |--------------------------------------------------------------------------
            | 1. CARI USER BERDASARKAN GOOGLE ID
            |--------------------------------------------------------------------------
            */

            $user = User::where(
                'google_id',
                $googleUser->id
            )->first();


            if ($user) {

                /*
                |--------------------------------------------------------------------------
                | UPDATE USER YANG SUDAH ADA
                |--------------------------------------------------------------------------
                */

                $user->update([
                    'avatar' => $googleUser->avatar,
                    'name' => $googleUser->name,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);

            } else {

                /*
                |--------------------------------------------------------------------------
                | 2. CEK EMAIL ADMIN UTAMA
                |--------------------------------------------------------------------------
                */

                $adminEmail = 'adminbacadulu@gmail.com';

                if ($googleUser->email === $adminEmail) {

                    $user = User::where(
                        'email',
                        $adminEmail
                    )->first();


                    if ($user) {

                        $user->update([
                            'google_id' => $googleUser->id,
                            'avatar' => $googleUser->avatar,
                            'name' => $googleUser->name,
                        ]);

                    }
                }


                /*
                |--------------------------------------------------------------------------
                | 3. JIKA USER BELUM ADA, BUAT USER BARU
                |--------------------------------------------------------------------------
                |
                | User baru dari Google selalu dianggap sebagai penulis.
                |
                */

                if (!$user) {

                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar ?? null,
                        'password' => bcrypt(
                            \Illuminate\Support\Str::random(16)
                        ),
                        'is_admin' => false,
                        'email_verified_at' => now(),
                    ]);

                }
            }


            /*
            |--------------------------------------------------------------------------
            | LOGIN USER
            |--------------------------------------------------------------------------
            |
            | Gunakan guard WEB agar login Google benar-benar menjadi
            | login user/penulis, bukan guard admin.
            |
            */

            Auth::guard('web')->login(
                $user,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | REGENERATE SESSION
            |--------------------------------------------------------------------------
            */

            request()->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | ADMIN UTAMA
            |--------------------------------------------------------------------------
            |
            | Bagian ini tetap dipertahankan dari kode sebelumnya.
            |
            */

            if ($user->is_admin) {

                return redirect('/admin');

            }


            /*
            |--------------------------------------------------------------------------
            | USER / PENULIS
            |--------------------------------------------------------------------------
            |
            | PENTING:
            |
            | Jangan menggunakan:
            |
            | redirect()->intended('/blog')
            |
            | karena Laravel dapat mengingat URL /admin/posts sebagai
            | intended URL.
            |
            | User biasa selalu diarahkan ke halaman Blogging.
            |
            */

            return redirect()
                ->route('blog.index');


        } catch (\Exception $e) {

            /*
            |--------------------------------------------------------------------------
            | ERROR LOGIN
            |--------------------------------------------------------------------------
            */

            // Untuk debugging sementara:
            // dd($e->getMessage(), $e->getTraceAsString());


            return redirect('/login')
                ->with(
                    'error',
                    'Login dengan Google gagal. Silakan coba lagi.'
                );
        }
    }
}