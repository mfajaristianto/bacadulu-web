<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use RuntimeException;
use Throwable;

class GoogleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Redirect to Google
    |--------------------------------------------------------------------------
    |
    | User diarahkan ke halaman autentikasi Google.
    |
    | Tidak menggunakan stateless() agar proteksi OAuth "state"
    | tetap aktif untuk mencegah request callback yang tidak valid.
    |
    */

    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /*
    |--------------------------------------------------------------------------
    | Google Callback
    |--------------------------------------------------------------------------
    |
    | Callback ini hanya menangani login user / penulis menggunakan
    | guard "web".
    |
    | Login admin tetap menggunakan sistem admin terpisah melalui:
    |
    | /panel-adminbaca/login
    |
    */

    public function callback(): RedirectResponse
    {
        try {
            /*
            |--------------------------------------------------------------------------
            | Get Google User
            |--------------------------------------------------------------------------
            */

            $googleUser = Socialite::driver('google')
                ->user();

            $googleId = trim(
                (string) $googleUser->getId()
            );

            $email = Str::lower(
                trim(
                    (string) $googleUser->getEmail()
                )
            );

            $name = trim(
                (string) $googleUser->getName()
            );

            $avatar = $googleUser->getAvatar();

            $emailVerified = (bool) data_get(
                $googleUser->user,
                'email_verified',
                false
            );

            /*
            |--------------------------------------------------------------------------
            | Validate Google Account
            |--------------------------------------------------------------------------
            */

            if ($googleId === '' || $email === '') {
                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Google tidak memberikan informasi akun yang diperlukan. Silakan coba lagi.'
                    );
            }

            if (!$emailVerified) {
                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Email Google Anda belum terverifikasi. Gunakan akun Google dengan email yang sudah terverifikasi.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Name Fallback
            |--------------------------------------------------------------------------
            */

            if ($name === '') {
                $name = Str::before(
                    $email,
                    '@'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Find or Create User
            |--------------------------------------------------------------------------
            |
            | Urutan:
            |
            | 1. Cari berdasarkan google_id.
            | 2. Jika tidak ditemukan, cari berdasarkan email.
            | 3. Jika email sudah ada, hubungkan akun tersebut ke Google.
            | 4. Jika belum ada sama sekali, buat user baru.
            |
            */

            $user = DB::transaction(
                function () use (
                    $googleId,
                    $email,
                    $name,
                    $avatar
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Existing Google Account
                    |--------------------------------------------------------------------------
                    */

                    $user = User::query()
                        ->where(
                            'google_id',
                            $googleId
                        )
                        ->first();

                    if ($user) {
                        /*
                        |--------------------------------------------------------------------------
                        | Protect Email Uniqueness
                        |--------------------------------------------------------------------------
                        |
                        | Apabila email Google berubah, cek apakah email baru tersebut
                        | sudah digunakan user lain.
                        |
                        */

                        $emailUsedByAnotherUser = User::query()
                            ->where(
                                'email',
                                $email
                            )
                            ->where(
                                'id',
                                '!=',
                                $user->id
                            )
                            ->exists();

                        $updateData = [
                            'name' => $name,
                            'avatar' => $avatar,
                            'email_verified_at' => $user->email_verified_at ?? now(),
                        ];

                        if (!$emailUsedByAnotherUser) {
                            $updateData['email'] = $email;
                        }

                        $user->update(
                            $updateData
                        );

                        return $user;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Existing Email Account
                    |--------------------------------------------------------------------------
                    |
                    | User mungkin sebelumnya sudah tersimpan berdasarkan email,
                    | tetapi belum memiliki google_id.
                    |
                    */

                    $user = User::query()
                        ->where(
                            'email',
                            $email
                        )
                        ->first();

                    if ($user) {
                        /*
                        |--------------------------------------------------------------------------
                        | Google Account Conflict
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !empty($user->google_id) &&
                            $user->google_id !== $googleId
                        ) {
                            throw new RuntimeException(
                                'Email sudah terhubung dengan akun Google lain.'
                            );
                        }

                        $user->update([
                            'google_id' => $googleId,
                            'name' => $name,
                            'avatar' => $avatar,
                            'email_verified_at' => $user->email_verified_at ?? now(),
                        ]);

                        return $user;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Create New User
                    |--------------------------------------------------------------------------
                    |
                    | User Google baru selalu menjadi user / penulis biasa.
                    | Password tidak perlu dibuat karena autentikasi dilakukan Google.
                    |
                    */

                    return User::create([
                        'name' => $name,
                        'email' => $email,
                        'google_id' => $googleId,
                        'avatar' => $avatar,
                        'is_admin' => false,
                        'email_verified_at' => now(),
                    ]);
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Login Using Web Guard
            |--------------------------------------------------------------------------
            |
            | Google login publik TIDAK pernah melakukan login ke guard admin.
            |
            */

            Auth::guard('web')->login(
                $user,
                true
            );

            /*
            |--------------------------------------------------------------------------
            | Regenerate Session
            |--------------------------------------------------------------------------
            |
            | Mencegah session fixation setelah proses login berhasil.
            |
            */

            request()
                ->session()
                ->regenerate();

            /*
            |--------------------------------------------------------------------------
            | Redirect User
            |--------------------------------------------------------------------------
            |
            | Semua login dari halaman login publik diarahkan ke Blogging.
            |
            | Bahkan jika user tersebut memiliki is_admin = true, login Google
            | publik tetap berada pada guard web.
            |
            | Admin panel hanya boleh dimasuki melalui login admin khusus.
            |
            */

            return redirect()
                ->route('blog.index');

        } catch (InvalidStateException $exception) {
            /*
            |--------------------------------------------------------------------------
            | Invalid / Expired OAuth State
            |--------------------------------------------------------------------------
            |
            | Biasanya terjadi jika:
            |
            | - halaman login terlalu lama dibuka,
            | - session berubah,
            | - callback Google dibuka ulang,
            | - proses OAuth tidak dimulai dari website.
            |
            */

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Sesi login Google sudah berakhir atau tidak valid. Silakan coba login kembali.'
                );

        } catch (RuntimeException $exception) {
            /*
            |--------------------------------------------------------------------------
            | Known Account Conflict
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    $exception->getMessage()
                );

        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Unexpected Google Login Error
            |--------------------------------------------------------------------------
            |
            | Detail error tetap dicatat ke Laravel log.
            | Pengunjung hanya menerima pesan yang aman.
            |
            */

            report(
                $exception
            );

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Login dengan Google belum berhasil. Silakan coba kembali beberapa saat lagi.'
                );
        }
    }
}