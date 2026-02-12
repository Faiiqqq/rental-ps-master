@extends('layout.main')

@section('page-title', 'LOG AKTIVITAS')

@section('content')

    <div class="space-y-6">

        {{-- TOOLBAR: FILTER & SEARCH --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <form action="{{ route('log.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-between">

                {{-- Kiri: Filter Role --}}
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-600">Filter Role:</span>
                    <select name="role" onchange="this.form.submit()"
                        class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="pelanggan" {{ request('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                    </select>
                </div>

                {{-- Kanan: Search --}}
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari user, aksi, deskripsi..."
                        class="text-sm border-gray-300 rounded-lg border-b focus:ring-blue-500 focus:border-blue-500 p-2 w-full md:w-64">

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                        Cari
                    </button>

                    @if (request('search') || request('role'))
                        <a href="{{ route('log.index') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 uppercase text-xs text-gray-600 font-semibold border-b">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Aksi</th>
                            <th class="px-6 py-4">Deskripsi Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                {{-- Waktu --}}
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                    <span class="text-xs text-gray-400 block">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </td>

                                {{-- User --}}
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $log->user->nama ?? 'Guest / Terhapus' }}
                                </td>

                                {{-- Role (Badge Warna) --}}
                                <td class="px-6 py-4">
                                    @php
                                        $role = $log->user->role ?? 'unknown';
                                        $color = match ($role) {
                                            'admin' => 'bg-purple-100 text-purple-700',
                                            'operator' => 'bg-blue-100 text-blue-700',
                                            'pelanggan' => 'bg-green-100 text-green-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $color }}">
                                        {{ $role }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="font-semibold 
                                    {{ $log->aksi == 'Login' ? 'text-green-600' : ($log->aksi == 'Logout' ? 'text-red-500' : 'text-gray-700') }}">
                                        {{ $log->aksi }}
                                    </span>
                                </td>

                                {{-- Deskripsi --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $log->deskripsi }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                    Tidak ada log aktivitas yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($logs->hasPages())
                <div class="px-6 py-4 border-t bg-gray-50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
