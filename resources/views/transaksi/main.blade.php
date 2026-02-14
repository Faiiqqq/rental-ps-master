@extends('layout.main')

@section('page-title', 'DAFTAR TRANSAKSI')

@section('content')

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Transaksi Rental</h2>
            <p class="text-sm text-gray-500 mt-1">Pantau status rental, durasi, dan pembayaran.</p>
        </div>

        {{-- Tombol Tambah (Hanya untuk yang berhak, misal Pelanggan/Operator) --}}
        <a href="{{ route('transaksi.create') }}"
            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i data-feather="plus-circle" class="w-4 h-4 mr-2"></i>
            Rental Baru
        </a>
    </div>

    {{-- Table Card --}}
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
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $t)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">

                            {{-- Info PS --}}
                            <td class="px-6 py-4 uppercase">
                                <span class="font-bold text-gray-800">{{ $t->playstation->tipe }}</span>
                            </td>

                            {{-- Info Pelanggan --}}
                            <td class="px-6 py-4 uppercase">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($t->pelanggan->nama, 0, 1) }}
                                    </div>
                                    <span class="font-medium">{{ $t->pelanggan->nama }}</span>
                                </div>
                            </td>

                            {{-- Jadwal --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded w-fit">
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
                                        'stop' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                        'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span
                                    class="px-3 py-1 text-xs font-bold uppercase tracking-wide rounded-full border {{ $statusColor }}">
                                    {{ $t->status }}
                                </span>
                            </td>

                            {{-- Aksi Buttons --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">

                                    {{-- ROLE OPERATOR --}}
                                    @if (auth()->user()->role == 'operator')
                                        @if ($t->status == 'menunggu')
                                            <form action="{{ route('transaksi.approve', $t->id_transaksi) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button title="Setujui"
                                                    class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition border border-green-200">
                                                    <i data-feather="check" class="w-4 h-4"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('transaksi.reject', $t->id_transaksi) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button title="Tolak"
                                                    class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition border border-red-200">
                                                    <i data-feather="x" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($t->status == 'main')
                                            <a href="{{ route('transaksi.edit', $t->id_transaksi) }}" title="Edit Durasi"
                                                class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition border border-blue-200">
                                                <i data-feather="edit-3" class="w-4 h-4"></i>
                                            </a>
                                        @endif

                                        @if ($t->status == 'stop')
                                            <form action="{{ route('transaksi.approveFinish', $t->id_transaksi) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button title="Konfirmasi Selesai"
                                                    class="p-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-600 hover:text-white transition border border-purple-200">
                                                    <i data-feather="check-square" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($t->status == 'main')
                                            <form action="{{ route('transaksi.stop', $t->id_transaksi) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button title="Selesaikan Rental"
                                                    class="px-3 py-2 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-600 hover:text-white transition text-xs font-bold border border-orange-200">
                                                    Stop Main
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    {{-- ROLE PELANGGAN --}}
                                    @if (auth()->user()->role == 'pelanggan')
                                        @if ($t->status == 'menunggu')
                                            <form action="{{ route('transaksi.destroy', $t->id_transaksi) }}"
                                                method="POST">
                                                @csrf @method('DELETE')
                                                <button title="Batalkan Pesanan" onclick="return confirm('Yakin batalkan?')"
                                                    class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition border border-red-200">
                                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($t->status == 'main')
                                            <form action="{{ route('transaksi.menyelesaikan', $t->id_transaksi) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button title="Selesaikan Rental"
                                                    class="px-3 py-2 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-600 hover:text-white transition text-xs font-bold border border-orange-200">
                                                    Stop Main
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400">
                                        <i data-feather="shopping-cart" class="w-8 h-8"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada transaksi</h3>
                                    <p class="text-sm mt-1">Mulai rental sekarang untuk membuat transaksi baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            {{ $transaksis->links() }}
        </div>
    </div>

@endsection
