<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function process(Request $request)
    {
        // Validasi Input Tanggal
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
        ]);

        $tglAwal = $request->tgl_awal;
        $tglAkhir = $request->tgl_akhir;

        // Ambil data transaksi 'selesai' dalam rentang tanggal
        // Menggunakan whereDate agar jam tidak mempengaruhi (00:00:00 - 23:59:59)
        $laporan = Transaksi::with(['pelanggan', 'playstation'])
            ->where('status', 'selesai') 
            ->whereDate('created_at', '>=', $tglAwal)
            ->whereDate('created_at', '<=', $tglAkhir)
            ->latest()
            ->get();

        // Hitung total pemasukan (Total Bayar + Denda)
        $totalPemasukan = $laporan->sum(function($t) {
            return $t->total_bayar + $t->denda;
        });

        // Return ke view cetak (bukan download PDF langsung, tapi view HTML yang siap print)
        return view('laporan.cetak', compact('laporan', 'tglAwal', 'tglAkhir', 'totalPemasukan'));
    }
}