<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
{
    // Validasi input email
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Coba Login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Log Aktivitas
        LogActivity::record('Login', 'User berhasil login ke sistem');

        return redirect()->intended('/');
    }

    // Jika Gagal
    return back()->with('error', 'Email atau password salah. Silakan coba lagi.');
}

    public function logout(Request $request)
    {
        // CATAT LOG LOGOUT SEBELUM SESSION HILANG
        if (Auth::check()) {
            LogActivity::record('Logout', 'User ' . Auth::user()->nama . ' logout.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
