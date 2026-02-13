@extends('layout.main')

@section('page-title', 'TAMBAH USER')

@section('content')

    <div class="max-w-3xl mx-auto mt-10">

        {{-- Card Container --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Tambah User Baru
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Masukan data akun untuk login aplikasi
                    </p>
                </div>
                <a href="{{ route('user.index') }}" 
                    class="text-sm text-gray-600 hover:text-blue-600 transition flex items-center gap-1">
                    <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.store') }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf

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
                            Nama
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required 
                            placeholder="Masukan nama"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            placeholder="contoh@email.com"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                    </div>

                    {{-- Grid untuk Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <input type="password" name="password" required 
                                placeholder="Minimal 4 karakter"
                                class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" required 
                                placeholder="Ketik ulang password"
                                class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm">
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Role (Hak Akses)
                        </label>
                        <div class="relative">
                            <select name="role" required
                                class="w-full appearance-none rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm cursor-pointer">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                                <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                            </select>
                            {{-- Icon Panah Custom --}}
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
                        Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection