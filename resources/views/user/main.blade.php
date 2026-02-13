@extends('layout.main')

@section('page-title', 'DATA USER')

@section('content')

    {{-- Alert Success --}}
    @if (session('success'))
        <div
            class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center justify-between animate-fade-in-down">
            <div class="flex items-center gap-2">
                <i data-feather="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 transition">
                <i data-feather="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data pengguna, hak akses, dan password.</p>
        </div>

        <a href="{{ route('user.create') }}"
            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
            Tambah User
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">

                            {{-- Nomor Urut --}}
                            <td class="px-6 py-4 text-center font-medium text-gray-400">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Nama User + Avatar Inisial --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 text-xs border border-blue-200">
                                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-800 group-hover:text-blue-600 transition">
                                        {{ $user->nama }}
                                    </span>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $user->email }}
                            </td>

                            {{-- Badge Role --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                    $roleClasses = match ($user->role) {
                                        'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'operator' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        default => 'bg-gray-100 text-gray-600 border-gray-200',
                                    };
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $roleClasses }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            {{-- Aksi Buttons --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('user.edit', $user->id_user) }}"
                                        class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 hover:text-yellow-700 transition border border-yellow-200 shadow-sm"
                                        title="Edit User">
                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('user.destroy', $user->id_user) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="if(confirm('Yakin ingin menghapus user {{ $user->nama }}?')) this.closest('form').submit()"
                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 hover:text-red-700 transition border border-red-200 shadow-sm"
                                            title="Hapus User">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan Jika Data Kosong --}}
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400">
                                        <i data-feather="users" class="w-8 h-8"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada user</h3>
                                    <p class="text-sm mt-1">Silakan tambahkan user baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (Muncul jika menggunakan paginate() di Controller) --}}
        @if (method_exists($users, 'links') && $users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Script Animasi Alert (Opsional) --}}
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

@endsection
