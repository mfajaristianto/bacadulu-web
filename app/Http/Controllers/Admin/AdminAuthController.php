<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{
    // Alias untuk rute POST /panel-adminbaca/login
    public function login(Request $request)
    {
        return $this->processLogin($request);
    }

    // 1. Tampilkan Form Login Pertama (Email & Password)
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Proses Cek Email & Password Awal -> Kirim OTP ke Email Pusat
    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('is_admin', true)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah!');
        }

        // Generate Kode OTP 6 Digit
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(15); 
        $user->save();

        // KIRIM OTP KE EMAIL PUSAT
        Mail::raw("Kode OTP untuk akses admin panel adalah: {$otp}. Berlaku selama 15 menit.", function ($message) {
            $message->to('adminbacadulu@gmail.com')
                    ->subject('KODE OTP AKSES ADMIN BACA DULU');
        });

        // Simpan ID user di session sementara
        session(['admin_temp_id' => $user->id]);

        return redirect()->route('admin.otp')->with('success', 'Kode OTP telah dikirim ke email pusat adminbacadulu@gmail.com');
    }

    // 2. Tampilkan Form Input OTP
    public function showOtpForm()
    {
        if (!session()->has('admin_temp_id')) {
            return redirect()->route('admin.login');
        }
        return view('admin.auth.otp');
    }

    // Proses Verifikasi OTP
    public function processOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = User::find(session('admin_temp_id'));

        if (!$user || (string)$user->otp_code !== (string)$request->otp || now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP salah atau sudah kedaluwarsa!');
        }

        // OTP Valid, hapus OTP agar tidak bisa dipakai ulang
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Lanjut ke tahap konfirmasi email & password final
        return redirect()->route('admin.confirm');
    }

    // 3. Tampilkan Form Konfirmasi Final (Ketik Ulang Email & Password)
    public function showConfirmForm()
    {
        if (!session()->has('admin_temp_id')) {
            return redirect()->route('admin.login');
        }
        return view('admin.auth.confirm');
    }

    // Proses Konfirmasi Final -> Sukses Masuk Dashboard
    public function processConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::find(session('admin_temp_id'));

        if (!$user || $user->email !== $request->email || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Konfirmasi email atau password salah!');
        }

        // Hapus session sementara
        session()->forget('admin_temp_id');

        // Login Resmi Masuk Sistem
        Auth::login($user);

        return redirect()->intended('/admin')->with('success', 'Selamat datang di Panel Admin Utama!');
    }
}