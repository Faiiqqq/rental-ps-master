<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Playstation;
use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transaksis = Transaksi::with(['playstation', 'pelanggan'])
            ->latest()
            ->get();

        return view('transaksi.main', compact('transaksis'));
    }

    public function create()
    {
        $playstations = Playstation::where('stok', '>', 0)->get();
        $users = User::where('role', 'pelanggan')->get();

        return view('transaksi.create', compact('playstations', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ps' => 'required|exists:playstations,id_ps',
            'jam_mulai' => 'required|date',
            'lama_jam' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $ps = Playstation::lockForUpdate()->findOrFail($request->id_ps);

            if ($ps->stok <= 0) {
                abort(400, 'Maaf, stok PlayStation ini sedang kosong.');
            }

            $lamaJam = (int) $request->lama_jam;
            $mulai = Carbon::parse($request->jam_mulai);
            $batas = $mulai->copy()->addHours($lamaJam);
            $total = $ps->hargaPerJam * $lamaJam;

            $transaksi = Transaksi::create([
                'id_ps' => $ps->id_ps,
                'id_user' => Auth::id(),
                'jam_mulai' => $mulai,
                'batas_kembali' => $batas,
                'lama_jam' => $lamaJam,
                'denda' => 0,
                'total_bayar' => $total,
                'status' => 'menunggu'
            ]);

            // LOG TRANSAKSI BARU
            LogActivity::record('Order Rental', "Membuat pesanan baru ID #{$transaksi->id_transaksi} (Total: Rp " . number_format($total) . ")");
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Pesanan rental berhasil dibuat.');
    }

    public function approve($id)
    {
        $t = Transaksi::findOrFail($id);
        $t->update(['status' => 'main']);

        // LOG APPROVE
        LogActivity::record('Approve Rental', "Operator menyetujui transaksi ID #{$id}");

        return back();
    }

    public function reject($id)
    {
        $t = Transaksi::findOrFail($id);
        $t->update(['status' => 'ditolak']);

        // LOG REJECT
        LogActivity::record('Tolak Rental', "Operator menolak transaksi ID #{$id}");

        return back();
    }

    public function menyelesaikan($id)
    {
        $denda = DB::select("SELECT hitung_total_denda(?) AS denda", [$id])[0]->denda;

        $t = Transaksi::findOrFail($id);
        $t->update([
            'status' => 'menyelesaikan',
            'denda' => $denda
        ]);

        // LOG REQUEST RETURN
        LogActivity::record('Menyelesaikan Rental', "Pelanggan menyelesaikan rentalnya ID #{$id}. Denda: Rp " . number_format($denda));

        return back()->with('success', 'Menyelesaikan diajukan.');
    }

    public function approveFinish($id)
    {
        // Transaksi::findOrFail($id);

        try {
            DB::statement("CALL selesaikan_transaksi(?)", [$id]);

            // LOG SELESAI
            LogActivity::record('Transaksi Selesai', "Operator menyelesaikan transaksi ID #{$id} dan stok dikembalikan.");

            return back()->with('success', 'Transaksi selesai.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $t = Transaksi::findOrFail($id);

        if ($t->status === 'menunggu') {
            $t->delete();
            // LOG BATAL
            LogActivity::record('Batal Rental', "Pelanggan membatalkan pesanan ID #{$id}");
        }

        return back();
    }
    
    // Fungsi selesai manual (jika ada)
    public function selesai($id)
    {
        // logic...
        LogActivity::record('Force Finish', "Finish manual ID #{$id}");
        return back();
    }
}