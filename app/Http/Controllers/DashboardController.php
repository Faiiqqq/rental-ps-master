<?php

namespace App\Http\Controllers;

use App\Models\Playstation;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Statistik Card
        $totalUser      = User::where('role', 'pelanggan')->count();
        $totalPs        = Playstation::count();
        $totalUnitPs    = Playstation::sum('stok'); // Total unit stok tersedia (jika mau hitung stok real)
        $totalDipakai   = Transaksi::where('status', 'main')->count();

        // 2. Ambil 5 Transaksi Terakhir (Tanpa Pagination)
        $transaksis = Transaksi::with(['pelanggan', 'playstation'])
            ->latest()
            ->limit(5)
            ->get();

        // Kirim data dengan nama variabel yang sesuai View
        return view('layout.dashboard', compact(
            'totalUser', 
            'totalUnitPs', 
            'totalDipakai', 
            'totalPs', 
            'transaksis'
        ));
    }
}