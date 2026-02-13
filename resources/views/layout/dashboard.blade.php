@extends('layout.main')

@section('page-title', 'DASHBOARD')

@section('content')

    {{-- STATISTIC CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        {{-- Card 1: Total User Pelanggan --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pelanggan</p>
                <h2 class="text-3xl font-extrabold text-blue-600 mt-2">
                    {{ $totalUser }}
                </h2>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-400">
                <i data-feather="users" class="w-4 h-4 mr-1"></i> Terdaftar
            </div>
        </div>

        {{-- Card 2: Unit Tersedia (Stok) --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Stok Unit</p>
                <h2 class="text-3xl font-extrabold text-green-600 mt-2">
                    {{ $totalUnitPs }}
                </h2>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-400">
                <i data-feather="box" class="w-4 h-4 mr-1"></i> Unit Ready
            </div>
        </div>

        {{-- Card 3: Sedang Main (Dipakai) --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Sedang Main</p>
                <h2 class="text-3xl font-extrabold text-purple-600 mt-2">
                    {{ $totalDipakai }}
                </h2>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-400">
                <i data-feather="activity" class="w-4 h-4 mr-1"></i> Transaksi Aktif
            </div>
        </div>

        {{-- Card 4: Tipe PS --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Tipe Console</p>
                <h2 class="text-3xl font-extrabold text-red-600 mt-2">
                    {{ $totalPs }}
                </h2>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-400">
                <i data-feather="monitor" class="w-4 h-4 mr-1"></i> Varian PS
            </div>
        </div>
    </div>


    {{-- SECTION HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Transaksi Terbaru</h2>
            <p class="text-sm text-gray-500 mt-1">5 transaksi terakhir yang masuk ke sistem.</p>
        </div>

        {{-- Tombol Tambah --}}
        <a href="{{ route('transaksi.create') }}"
            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i data-feather="plus-circle" class="w-4 h-4 mr-2"></i>
            Rental Baru
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Unit PS</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Jadwal Main</th>
                        <th class="px-6 py-4 text-center">Durasi</th>
                        <th class="px-6 py-4">Total & Denda</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $t)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">

                            {{-- Info PS --}}
                            <td class="px-6 py-4 uppercase">
                                <span class="font-bold text-gray-800 block">{{ $t->playstation->tipe }}</span>
                                <span class="text-xs text-gray-400">ID: #{{ $t->playstation->id_ps }}</span>
                            </td>

                            {{-- Info Pelanggan --}}
                            <td class="px-6 py-4 uppercase">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($t->pelanggan->nama, 0, 1) }}
                                    </div>
                                    <span class="font-medium">{{ $t->pelanggan->nama }}</span>
                                </div>
                            </td>

                            {{-- Jadwal --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded w-fit">
                                        Mulai: {{ \Carbon\Carbon::parse($t->jam_mulai)->format('d M H:i') }}
                                    </span>
                                    <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded w-fit">
                                        Batas: {{ \Carbon\Carbon::parse($t->batas_kembali)->format('d M H:i') }}
                                    </span>
                                </div>
                            </td>

                            {{-- Durasi --}}
                            <td class="px-6 py-4 text-center font-medium">
                                {{ $t->lama_jam }} Jam
                            </td>

                            {{-- Keuangan --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700">Rp {{ number_format($t->total_bayar) }}</div>
                                @if ($t->denda > 0)
                                    <div class="text-xs text-red-500 font-semibold mt-1">
                                        + Denda: Rp {{ number_format($t->denda) }}
                                    </div>
                                @endif
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColor = match ($t->status) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'main' => 'bg-blue-100 text-blue-700 border-blue-200 animate-pulse',
                                        'menyelesaikan' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                        'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wide rounded-full border {{ $statusColor }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-feather="shopping-cart" class="w-8 h-8 text-gray-400 mb-3"></i>
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada transaksi</h3>
                                    <p class="text-sm mt-1">Transaksi terbaru akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Card (Ganti Pagination dengan Link 'Lihat Semua') --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-center md:justify-end">
            <a href="{{ route('transaksi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                Lihat Semua Transaksi <i data-feather="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
@endsection