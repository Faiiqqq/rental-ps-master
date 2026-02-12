<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rental PS</title>
    {{-- Kita pakai CDN TailwindCSS biar tampilannya bagus saat di-print --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white p-10 text-gray-800" onload="window.print()">

    {{-- KOP LAPORAN --}}
    <div class="text-center border-b-2 border-gray-800 pb-6 mb-6">
        <h1 class="text-3xl font-bold uppercase tracking-wider">RENTAL PLAYSTATION</h1>
        <p class="text-sm text-gray-600 mt-1">Laporan Pendapatan Resmi</p>
    </div>

    {{-- INFO PERIODE --}}
    <div class="flex justify-between mb-6 text-sm">
        <div>
            <p class="text-gray-500">Periode:</p>
            <p class="font-bold">
                {{ \Carbon\Carbon::parse($tglAwal)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($tglAkhir)->format('d M Y') }}
            </p>
        </div>
        <div class="text-right">
            <p class="text-gray-500">Tanggal Cetak:</p>
            <p class="font-bold">{{ now()->format('d F Y, H:i') }}</p>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <table class="w-full text-sm text-left border border-gray-300 mb-6">
        <thead class="bg-gray-100 uppercase text-xs border-b border-gray-300">
            <tr>
                <th class="px-4 py-3 border-r">No</th>
                <th class="px-4 py-3 border-r">Tanggal</th>
                <th class="px-4 py-3 border-r">Pelanggan</th>
                <th class="px-4 py-3 border-r">Unit PS</th>
                <th class="px-4 py-3 border-r text-right">Sewa</th>
                <th class="px-4 py-3 border-r text-right">Denda</th>
                <th class="px-4 py-3 text-right">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($laporan as $index => $t)
            <tr>
                <td class="px-4 py-2 border-r text-center">{{ $index + 1 }}</td>
                <td class="px-4 py-2 border-r">{{ \Carbon\Carbon::parse($t->jam_mulai)->format('d/m/Y') }}</td>
                <td class="px-4 py-2 border-r">{{ $t->pelanggan->nama }}</td>
                <td class="px-4 py-2 border-r uppercase">{{ $t->playstation->tipe }}</td>
                <td class="px-4 py-2 border-r text-right">Rp {{ number_format($t->total_bayar) }}</td>
                <td class="px-4 py-2 border-r text-right text-red-600">Rp {{ number_format($t->denda) }}</td>
                <td class="px-4 py-2 text-right font-bold">
                    Rp {{ number_format($t->total_bayar + $t->denda) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-400 italic">
                    Tidak ada transaksi selesai pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot class="bg-gray-50 font-bold border-t-2 border-gray-300">
            <tr>
                <td colspan="6" class="px-4 py-3 text-right uppercase">Total Pendapatan Bersih</td>
                <td class="px-4 py-3 text-right text-lg text-blue-900">
                    Rp {{ number_format($totalPemasukan) }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="flex justify-end mt-12">
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-20">Mengetahui, Pemilik</p>
            <p class="font-bold border-b border-gray-400 pb-1">
                {{ auth()->user()->nama }}
            </p>
        </div>
    </div>

    {{-- TOMBOL PRINT MANUAL (Disembunyikan saat ngeprint kertas) --}}
    <div class="fixed bottom-5 right-5 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg font-bold hover:bg-blue-700">
            🖨️ Print Sekarang
        </button>
    </div>

</body>
</html>