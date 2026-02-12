<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = LogActivity::with('user');

        // 1. Filter Role (Jika ada input role)
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        // 2. Search (Cari berdasarkan Nama User, Aksi, atau Deskripsi)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('aksi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Ambil data terbaru dan dipagination 10 baris per halaman
        $logs = $query->latest()->paginate(10)->withQueryString();

        return view('log_activity', compact('logs'));
    }
}
