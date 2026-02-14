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
        // FITUR: PAGINATION (Mengganti get() dengan paginate())
        // FITUR: RELASI (with playstation & pelanggan)
        $transaksis = Transaksi::with(['playstation', 'pelanggan'])
            ->latest()
            ->paginate(10); // Menampilkan 10 data per halaman

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

        // FITUR: COMMIT DAN ROLLBACK MANUAL
        DB::beginTransaction(); // Memulai Transaksi Database

        try {
            // Locking row untuk mencegah race condition (Best Practice)
            $ps = Playstation::lockForUpdate()->findOrFail($request->id_ps);

            if ($ps->stok <= 0) {
                // Rollback tidak wajib jika belum ada query insert/update, tapi baik untuk konsistensi
                DB::rollBack(); 
                return back()->with('error', 'Maaf, stok PlayStation ini sedang kosong.');
            }

            $lamaJam = (int) $request->lama_jam;
            $mulai = Carbon::parse($request->jam_mulai);
            $batas = $mulai->copy()->addHours($lamaJam);
            $total = $ps->hargaPerJam * $lamaJam;

            $transaksi = Transaksi::create([
                'id_ps' => $ps->id_ps,
                'id_user' => Auth::id(), // Operator yang input
                'jam_mulai' => $mulai,
                'batas_kembali' => $batas,
                'lama_jam' => $lamaJam,
                'denda' => 0,
                'total_bayar' => $total,
                'status' => 'menunggu'
            ]);

            LogActivity::record('Order Rental', "Membuat pesanan baru ID #{$transaksi->id_transaksi}");

            // FITUR: COMMIT (Simpan permanen jika tidak ada error)
            DB::commit();

            return redirect()->route('transaksi.index')
                ->with('success', 'Pesanan rental berhasil dibuat.');

        } catch (\Exception $e) {
            // FITUR: ROLLBACK (Batalkan semua query jika terjadi error)
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // FITUR: EDIT TRANSAKSI (Hanya durasi, saat status 'main')
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if($transaksi->status !== 'main') {
            return back()->with('error', 'Hanya transaksi yang sedang main yang bisa diedit durasinya.');
        }

        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input baru
        $request->validate([
            'lama_jam_baru' => 'required|integer|min:1'
        ]);

        $t = Transaksi::with('playstation')->findOrFail($id);

        // Mengganti total durasi
        $jamBaru = (int) $request->lama_jam_baru;
        
        // Hitung ulang total bayar & batas kembali berdasarkan jam baru
        $totalBaru = $jamBaru * $t->playstation->hargaPerJam;
        $batasBaru = Carbon::parse($t->jam_mulai)->addHours($jamBaru);

        $t->update([
            'lama_jam' => $jamBaru,
            'total_bayar' => $totalBaru,
            'batas_kembali' => $batasBaru
        ]);

        LogActivity::record('Edit Durasi', "Mengubah durasi menjadi {$jamBaru} jam untuk ID #{$id}");

        return redirect()->route('transaksi.index')->with('success', 'Durasi berhasil diperbarui.');
    }

    public function approve($id)
    {
        $t = Transaksi::findOrFail($id);
        
        // FITUR: TRIGGER (Akan berjalan otomatis di database saat status diupdate ke 'main')
        $t->update(['status' => 'main']); 

        LogActivity::record('Approve Rental', "Operator menyetujui transaksi ID #{$id}");

        return back()->with('success', 'Rental dimulai (Stok berkurang otomatis via Trigger).');
    }

    public function reject($id)
    {
        $t = Transaksi::findOrFail($id);
        $t->update(['status' => 'ditolak']);
        LogActivity::record('Tolak Rental', "Operator menolak transaksi ID #{$id}");
        return back();
    }

    public function stopMain($id)
    {
        // FITUR: STORED FUNCTION (hitung_total_denda)
        $denda = DB::select("SELECT hitung_total_denda(?) AS denda", [$id])[0]->denda;

        $t = Transaksi::findOrFail($id);
        $t->update([
            'status' => 'stop',
            'denda' => $denda
        ]);

        LogActivity::record('Stop Main', "Pelanggan ingin Stop Main ID #{$id}. Denda: " . number_format($denda));

        return back()->with('success', 'Stop Main diajukan.');
    }

    public function approveFinish($id)
    {
        try {
            // FITUR: STORED PROCEDURE (selesaikan_transaksi)
            DB::statement("CALL selesaikan_transaksi(?)", [$id]);

            LogActivity::record('Transaksi Selesai', "Operator menyelesaikan transaksi ID #{$id}");

            return back()->with('success', 'Transaksi selesai (Stok bertambah otomatis via Trigger).');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $t = Transaksi::findOrFail($id);
        if ($t->status === 'menunggu') {
            $t->delete();
            LogActivity::record('Batal Rental', "Pesanan ID #{$id} dibatalkan");
        }
        return back();
    }
}