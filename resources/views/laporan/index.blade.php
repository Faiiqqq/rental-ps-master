@extends('layout.main')

@section('page-title', 'LAPORAN KEUANGAN')

@section('content')

    <div class="max-w-xl mx-auto mt-10">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- Header Card --}}
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-200 text-center">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i data-feather="file-text" class="w-6 h-6"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Cetak Laporan</h2>
                <p class="text-sm text-gray-500 mt-1">Pilih periode tanggal untuk melihat pendapatan rental.</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('laporan.process') }}" method="POST" target="_blank" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    {{-- Tanggal Awal --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" required value="{{ date('Y-m-01') }}"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm cursor-pointer">
                    </div>

                    {{-- Tanggal Akhir --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" required value="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-2.5 text-sm shadow-sm cursor-pointer">
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i data-feather="printer" class="w-5 h-5"></i>
                        Generate Laporan PDF
                    </button>
                    <p class="text-xs text-center text-gray-400 mt-3 flex items-center justify-center gap-1">
                        <i data-feather="info" class="w-3 h-3"></i>
                        Laporan akan terbuka di tab baru siap cetak.
                    </p>
                </div>

            </form>
        </div>
    </div>

@endsection