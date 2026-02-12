<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,operator,pelanggan'
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|min:6',
            'role'     => 'required|in:admin,operator,pelanggan'
        ]);

        $data = [
            'nama'   => $request->nama,
            'email'  => $request->email,
            'role'   => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui');
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
