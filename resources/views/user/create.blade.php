@extends('layout.main')

@section('page-title', 'MENAMBAHKAN USER')

@section('content')

    <div class="max-w-3xl mx-auto mt-6">

        {{-- Card --}}
        <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    Tambah User Baru
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Isi data user dengan benar
                </p>
            </div>

            {{-- Form --}}
            <form action="/user" method="POST" class="px-6 py-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama
                        </label>
                        <input type="text" name="nama" required placeholder="Masukan Nama anda"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" required placeholder="Masukan Email anda"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" name="password" required placeholder="Masukan Password anda"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Role
                        </label>
                        <select name="role" required
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                            <option value="pelanggan">Pelanggan</option>
                        </select>
                    </div>
                </div>

                {{-- Action --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">

                    <a href="/user"
                        class="px-5 py-2 text-sm font-medium text-gray-700
                        bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white
                        bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>

                </div>
            </form>

        </div>
    </div>

@endsection
