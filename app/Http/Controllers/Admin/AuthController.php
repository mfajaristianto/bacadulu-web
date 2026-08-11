<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm() 
    { 
        return view('admin.auth.login'); 
    }

    public function login(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $username = explode('@', $request->email)[0];
            $user = User::create([
                'name' => ucwords(str_replace(['.', '_'], ' ', $username)),
                'email' => $request->email,
                'password' => bcrypt('password123'), // Password default
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Arahkan admin ke dashboard, user biasa ke halaman blog
        return str_contains($request->email, 'admin') ? redirect('/admin') : redirect('/blog');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect ke halaman home dengan membawa pesan sukses khusus admin
        return redirect('/')->with('admin_logout_success', 'Admin berhasil keluar dari sistem CMS.');
    }
}