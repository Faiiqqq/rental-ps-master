<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan Eager Loading 'user' untuk performa
        $query = LogActivity::with('user');

        // 1. Filter Role (Jika ada input role)
        $query->when($request->filled('role'), function ($q) use ($request) {
            $q->whereHas('user', function ($u) use ($request) {
                $u->where('role', $request->role);
            });
        });

        // 2. Search (Cari berdasarkan Nama User, Aksi, atau Deskripsi)
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($sub) use ($search) {
                $sub->where('aksi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('nama', 'like', "%{$search}%");
                    });
            });
        });

        // Ambil data terbaru, paginate 10
        $logs = $query->latest()->paginate(10)->withQueryString();

        return view('log_activity', compact('logs'));
    }
}