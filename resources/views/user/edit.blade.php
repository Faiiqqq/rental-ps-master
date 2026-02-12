@extends('layout.main')

@section('page-title', 'EDIT USER')

@section('content')

    <form action="/user/{{ $user->id_user }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama
            </label>
            <input type="text" name="nama" value="{{ $user->nama }}"
                class="w-full rounded text-sm p-2
                    bg-linear-to-b from-gray-50 to-gray-100
                    border border-gray-300
                    hover:border-gray-400">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input type="email" name="email" value="{{ $user->email }}"
                class="w-full rounded text-sm p-2
                    bg-linear-to-b from-gray-50 to-gray-100
                    border border-gray-300
                    hover:border-gray-400">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Password
            </label>
            <input type="password" name="password" placeholder="Password"
                class="w-full rounded text-sm p-2
                    bg-linear-to-b from-gray-50 to-gray-100
                    border border-gray-300
                    hover:border-gray-400">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Role
            </label>
            <select name="role"
                class="w-full rounded text-sm p-2
                    bg-linear-to-b from-gray-50 to-gray-100
                    border border-gray-300
                    hover:border-gray-400">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                <option value="pelanggan" {{ $user->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
            </select>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Simpan Perubahan
            </button>

        </div>
    </form>

@endsection
