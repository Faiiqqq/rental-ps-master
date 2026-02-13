<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Rental PS</title>
    
    {{-- Menggunakan Tailwind CSS via CDN untuk styling cetak --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* CSS Khusus Print */
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; background: white; }
            .print-container { box-shadow: none; border: none; padding: 0; margin: 0; max-width: 100%; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 md:p-12 text-gray-800">

    {{-- Container Kertas --}}
    <div class="print-container max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-lg border border-gray-200 min-h-[29.7cm]">

        {{-- HEADER / KOP --}}
        <div class="flex justify-between items-start border-b-2 border-gray-800 pb-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 uppercase tracking-tight">Rental PlayStation</h1>
                <p class="text-sm text-gray-500 mt-1">Laporan Resmi Pendapatan</p>
            </div>
            <div class="text-right">
                <div class="bg-gray-100 px-4 py-2 rounded-lg inline-block">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Periode Laporan</p>
                    <p class="font-bold text-lg text-gray-800">
                        {{ \Carbon\Carbon::parse($tglAwal)->format('d M') }} - {{ \Carbon\Carbon::parse($tglAkhir)->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-sm text-gray-500 mb-1">Dibuat Oleh:</p>
                <p class="font-bold text-gray-800">{{ auth()->user()->nama ?? 'Administrator' }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ auth()->user()->role ?? 'Admin' }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 mb-1">Tanggal Cetak:</p>
                <p class="font-bold text-gray-800">{{ now()->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-hidden border border-gray-200 rounded-lg mb-8">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-600 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-center w-12 border-r">No</th>
                        <th class="px-4 py-3 border-r">Tanggal</th>
                        <th class="px-4 py-3 border-r">Pelanggan</th>
                        <th class="px-4 py-3 border-r">Unit</th>
                        <th class="px-4 py-3 text-right border-r">Sewa</th>
                        <th class="px-4 py-3 text-right border-r">Denda</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporan as $index => $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5 text-center border-r text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5 border-r font-medium">{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2.5 border-r">{{ $t->pelanggan->nama }}</td>
                        <td class="px-4 py-2.5 border-r uppercase text-xs font-bold text-gray-600">{{ $t->playstation->tipe }}</td>
                        <td class="px-4 py-2.5 text-right border-r text-gray-600">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                        <td class="px-4 py-2.5 text-right border-r text-red-600">
                            {{ $t->denda > 0 ? 'Rp '.number_format($t->denda, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-2.5 text-right font-bold text-gray-800">
                            Rp {{ number_format($t->total_bayar + $t->denda, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 italic bg-gray-50">
                            Tidak ada transaksi selesai pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div class="flex justify-end mb-12">
            <div class="w-64 bg-gray-50 p-4 rounded-xl border border-gray-200">
                <p class="text-xs uppercase font-bold text-gray-500 mb-1">Total Pendapatan Bersih</p>
                <p class="text-2xl font-extrabold text-blue-800">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- TANDA TANGAN --}}
        <div class="flex justify-end mt-16 page-break-inside-avoid">
            <div class="text-center w-48">
                <p class="text-sm text-gray-500 mb-20">Mengetahui, Pemilik</p>
                <div class="border-b border-gray-300 pb-2">
                    <p class="font-bold text-gray-800 uppercase">{{ auth()->user()->nama ?? 'Admin Rental' }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- FLOATING ACTION BUTTON (Print / Close) --}}
    <div class="fixed bottom-8 right-8 flex gap-3 no-print">
        <button onclick="window.close()" 
            class="bg-white border border-gray-300 text-gray-700 w-12 h-12 rounded-full shadow-lg hover:bg-gray-50 flex items-center justify-center transition" title="Tutup">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <button onclick="window.print()" 
            class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-xl hover:bg-blue-700 font-bold flex items-center gap-2 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Sekarang
        </button>
    </div>

    {{-- Auto Print Script --}}
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>