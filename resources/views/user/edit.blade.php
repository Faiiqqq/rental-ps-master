@extends('layout.main')

@section('page-title', 'EDIT USER')

@section('content')

    <div class="max-w-3xl mx-auto mt-10">

        {{-- Card Container --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Edit Data User
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui informasi pengguna ID #{{ $user->id_user }}
                    </p>
                </div>
                <a href="{{ route('user.index') }}" 
                   class="text-sm text-gray-600 hover:text-blue-600 transition flex items-center gap-1">
                    <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Alert Error Validation --}}
                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm border border-red-200">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">
                    
                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required 
                            class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                            class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                    </div>

                    {{-- Divider untuk Ganti Password --}}
                    <div class="border-t border-gray-100 my-4 pt-4">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-feather="lock" class="w-4 h-4"></i> Ganti Password (Opsional)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Password --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">
                                    Password Baru
                                </label>
                                <input type="password" name="password" placeholder="Kosongkan jika tetap"
                                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">
                                    Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">*Biarkan kedua kolom di atas kosong jika tidak ingin mengubah password user.</p>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Role (Hak Akses)
                        </label>
                        <div class="relative">
                            <select name="role" required
                                class="w-full appearance-none rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm cursor-pointer">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                                <option value="pelanggan" {{ $user->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('user.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-1 focus:ring-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection