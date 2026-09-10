<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Logout Admin
    |--------------------------------------------------------------------------
    |
    | Proses login admin ditangani oleh AdminAuthController.
    | Controller ini hanya menangani logout supaya tidak ada jalur login lama
    | yang menggunakan guard default secara tidak sengaja.
    |
    */

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'admin_logout_success',
                'Admin berhasil keluar dari sistem CMS.'
            );
    }
}
