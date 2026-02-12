@extends('layout.main')

@section('page-title', 'LAPORAN PENDAPATAN')

@section('content')

    <div class="max-w-lg mx-auto mt-10">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Cetak Laporan Keuangan</h2>
                <p class="text-gray-500 text-sm">Pilih periode laporan rental</p>
            </div>

            <form action="{{ route('laporan.process') }}" method="POST" target="_blank">
                @csrf
                <div class="space-y-4">
                    
                    {{-- Tanggal Awal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" required value="{{ date('Y-m-01') }}"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Tanggal Akhir --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" required value="{{ date('Y-m-d') }}"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <button type="submit" 
                        class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition">
                        🖨️ Cetak Laporan PDF
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection