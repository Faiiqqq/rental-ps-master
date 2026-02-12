<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Playstation;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalUser = User::count();
        $totalPs = Playstation::count();
        $totalUnitPs = Playstation::sum('stok');
        $totalDipakai = Transaksi::where('status', 'main')->count();
        $transaksis = Transaksi::with(['playstation', 'pelanggan'])
            ->latest()
            ->get();

        return view('layout.dashboard', compact(
            'totalUser',
            'totalPs',
            'totalUnitPs',
            'totalDipakai',
            'transaksis'
        ));
    }
}
