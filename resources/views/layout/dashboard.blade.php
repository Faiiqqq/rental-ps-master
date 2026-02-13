@extends('layout.main')

@section('page-title', 'DASHBOARD')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">User</p>
        <h2 class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalUser }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">Tersedia</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalUnitPs }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">Dipakai</p>
        <h2 class="text-3xl font-bold text-purple-600 mt-2">
            {{ $totalDipakai }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">Playstation</p>
        <h2 class="text-3xl font-bold text-red-600 mt-2">
            {{ $totalPs }}
        </h2>
    </div>
</div>
{{-- ------ --}}
@auth
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Daftar Transaksi</h2>

        <a href="{{ route('transaksi.create') }}"
            class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            + Rental PS
        </a>
    </div>
    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">PS</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Jadwal</th>
                    <th class="px-6 py-4 text-left">Durasi</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Denda</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4 uppercase">
                            {{ $t->playstation->tipe }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $t->pelanggan->nama }}
                        </td>

                        <td class="px-6 py-4">
                            <div>Mulai: {{ $t->jam_mulai->format('d M Y,H:i') }}</div>
                            <div class="text-xs text-red-500">Batas: {{ $t->batas_kembali->format('d M Y,H:i') }}</div>
                        </td>

                        <td class="px-6 py-4">
                            {{ $t->lama_jam }} jam
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            Rp {{ number_format($t->total_bayar) }}
                        </td>
                        
                        <td class="px-6 py-4 text-red-600 font-semibold">
                            Rp {{ number_format($t->denda) }}
                        </td>


                        {{-- STATUS --}}
                        <td class="px-6 py-4 text-center">
                            @switch($t->status)
                                @case('menunggu')
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">Menunggu</span>
                                @break

                                @case('main')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Main</span>
                                @break

                                @case('menyelesaikan')
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs">Menunggu</span>
                                @break

                                @case('selesai')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Selesai</span>
                                @break

                                @case('ditolak')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Ditolak</span>
                                @break
                            @endswitch
                        </td>


                        {{-- AKSI --}}
                        <td class="px-6 py-4 text-center space-x-2">

                            {{-- OPERATOR --}}
                            @if (auth()->user()->role == 'operator')
                                @if ($t->status == 'menunggu')
                                    <form action="{{ route('transaksi.approve', $t->id_transaksi) }}" method="POST"
                                        class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-green-600 hover:underline">Setujui</button>
                                    </form>

                                    <form action="{{ route('transaksi.reject', $t->id_transaksi) }}" method="POST"
                                        class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-red-600 hover:underline">Tolak</button>
                                    </form>
                                @endif

                                @if ($t->status == 'menyelesaikan')
                                    <form action="{{ route('transaksi.approveFinish', $t->id_transaksi) }}"
                                        method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-blue-600 hover:underline">Selesaikan</button>
                                    </form>
                                @endif
                            @endif


                            {{-- PELANGGAN --}}
                            @if (auth()->user()->role == 'pelanggan')
                                @if ($t->status == 'menunggu')
                                    <form action="{{ route('transaksi.destroy', $t->id_transaksi) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Batal</button>
                                    </form>
                                @endif

                                @if ($t->status == 'main')
                                    <form action="{{ route('transaksi.menyelesaikan', $t->id_transaksi) }}"
                                        method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-orange-600 hover:underline">Sudah Selesai</button>
                                    </form>
                                @endif
                            @endif

                        </td>
                    </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-400">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

@endauth
@endsection
