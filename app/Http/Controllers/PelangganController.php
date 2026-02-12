<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;

class PelangganController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'pelanggan')->get();

        return view('pelanggan.main', compact('users'));
    }
}
