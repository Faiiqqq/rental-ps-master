<?php

namespace App\Http\Controllers;

use App\Models\Playstation;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaystationController extends Controller
{
    public function index()
    {
        $playstations = Playstation::latest()->get();
        return view('playstation.main', compact('playstations'));
    }

    public function create()
    {
        return view('playstation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required',
            'hargaPerJam' => 'required|numeric',
            'stok' => 'required|integer|min:1'
        ]);

        $ps = Playstation::where('tipe', $request->tipe)->first();

        if ($ps) {
            $ps->update([
                'stok' => $ps->stok + $request->stok,
                'hargaPerJam' => $request->hargaPerJam
            ]);
            // LOG UPDATE
            LogActivity::record('Tambah Stok', "Menambah {$request->stok} unit untuk PS tipe {$ps->tipe}");
        } else {
            Playstation::create($request->all());
            // LOG CREATE
            LogActivity::record('PS Baru', "Menambahkan tipe baru: {$request->tipe}");
        }

        return redirect()->route('playstation.index')
            ->with('success', 'Stok berhasil ditambahkan');
    }

    public function edit($id)
    {
        $playstation = Playstation::findOrFail($id);
        return view('playstation.edit', compact('playstation'));
    }

    public function update(Request $request, $id)
    {
        $playstation = Playstation::findOrFail($id);
        
        $request->validate([
            'tipe' => 'required',
            'hargaPerJam' => 'required|numeric',
        ]);

        $playstation->update($request->all());

        // LOG EDIT
        LogActivity::record('Edit PS', "Mengubah data PS ID #{$id}");

        return redirect()->route('playstation.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $ps = Playstation::findOrFail($id);
        $tipe = $ps->tipe; // simpan nama sebelum dihapus
        
        $ps->delete();

        // LOG HAPUS
        LogActivity::record('Hapus PS', "Menghapus PS Tipe {$tipe}");

        return back()->with('success', 'Data berhasil dihapus');
    }
}