<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity; // <--- Tambahkan ini

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'nama' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($login)) {
            $request->session()->regenerate();

            // CATAT LOG LOGIN
            LogActivity::record('Login', 'User ' . Auth::user()->nama . ' berhasil login.');

            return redirect()->intended('/');
        }
        return redirect()->back()->with('error', 'Nama atau Password Salah');
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
