@extends('layout.main')

@section('page-title', 'LOG AKTIVITAS')

@section('content')

    <div class="space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Aktivitas</h2>
                <p class="text-sm text-gray-500 mt-1">Memantau tindakan user dan riwayat sistem.</p>
            </div>
        </div>

        {{-- TOOLBAR: FILTER & SEARCH --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('log.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-between items-center">

                {{-- Kiri: Filter Role --}}
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-48">
                        <select name="role" onchange="this.form.submit()"
                            class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-pointer">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                            <option value="pelanggan" {{ request('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                            <i data-feather="filter" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Search --}}
                <div class="flex gap-2 w-full md:w-auto">
                    <div class="relative w-full md:w-72">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-feather="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari user, aksi, deskripsi..."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-md">
                        Cari
                    </button>

                    @if (request('search') || request('role'))
                        <a href="{{ route('log.index') }}"
                            class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-200 transition border border-gray-300">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 w-48">Waktu</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Aksi</th>
                            <th class="px-6 py-4">Deskripsi Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                
                                {{-- Waktu --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 text-gray-700 font-medium">
                                        <i data-feather="clock" class="w-3 h-3 text-gray-400"></i>
                                        {{ $log->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1 pl-5">
                                        {{ $log->created_at->format('H:i:s') }}
                                        ({{ $log->created_at->diffForHumans() }})
                                    </div>
                                </td>

                                {{-- User --}}
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $log->user->nama ?? 'Guest / Terhapus' }}
                                </td>

                                {{-- Role Badge --}}
                                <td class="px-6 py-4">
                                    @php
                                        $role = $log->user->role ?? 'unknown';
                                        $roleClass = match ($role) {
                                            'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'operator' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'pelanggan' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            default => 'bg-gray-50 text-gray-400 border-gray-200',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wide rounded-full border {{ $roleClass }}">
                                        {{ $role }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4">
                                    @php
                                        $aksiColor = match(true) {
                                            str_contains(strtolower($log->aksi), 'login') => 'text-green-600',
                                            str_contains(strtolower($log->aksi), 'logout') => 'text-red-500',
                                            str_contains(strtolower($log->aksi), 'tambah') => 'text-blue-600',
                                            str_contains(strtolower($log->aksi), 'hapus') => 'text-red-600',
                                            str_contains(strtolower($log->aksi), 'edit') => 'text-orange-600',
                                            default => 'text-gray-700'
                                        };
                                    @endphp
                                    <span class="font-bold {{ $aksiColor }}">
                                        {{ $log->aksi }}
                                    </span>
                                </td>

                                {{-- Deskripsi --}}
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $log->deskripsi }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400">
                                            <i data-feather="activity" class="w-8 h-8"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Tidak ada aktivitas</h3>
                                        <p class="text-sm mt-1">Belum ada log yang terekam sesuai filter ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection