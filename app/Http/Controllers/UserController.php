<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('user.main', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Pastikan email unik
            'password' => 'required|min:8|confirmed',      // Validasi konfirmasi password
            'role' => 'required'
        ]);

        // SIMPAN KE DATABASE
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role,
        ]);

        // LOG ACTIVITY
        LogActivity::record('Tambah User', "Menambahkan user baru: {$request->nama} ({$request->email})");

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            // Validasi email unique KECUALI untuk user ini sendiri
            'email' => 'required|email|unique:users,email,'.$id.',id_user',
            'role' => 'required',
            // Password boleh kosong (nullable), tapi jika diisi harus confirmed & min 8
            'password' => 'nullable|min:8|confirmed'
        ]);

        // Data dasar yang akan diupdate
        $dataToUpdate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Cek apakah user mengisi password baru?
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        // LOG EDIT
        LogActivity::record('Edit User', "Mengubah data user ID #{$id} ({$user->nama})");

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
