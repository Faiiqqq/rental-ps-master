<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
        ]);

        $tglAwal = $request->tgl_awal;
        $tglAkhir = $request->tgl_akhir;

        // Ambil data transaksi yang SUDAH SELESAI dalam rentang tanggal
        $laporan = Transaksi::with(['pelanggan', 'playstation'])
            ->where('status', 'selesai') 
            ->whereDate('jam_mulai', '>=', $tglAwal)
            ->whereDate('jam_mulai', '<=', $tglAkhir)
            ->latest()
            ->get();

        // Hitung total uang masuk (Sewa + Denda)
        $totalPemasukan = $laporan->sum(function($t) {
            return $t->total_bayar + $t->denda;
        });

        return view('laporan.cetak', compact('laporan', 'tglAwal', 'tglAkhir', 'totalPemasukan'));
    }
}