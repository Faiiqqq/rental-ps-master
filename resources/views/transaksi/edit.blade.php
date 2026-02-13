@extends('layout.main')

@section('page-title', 'EDIT TRANSAKSI')

@section('content')

    <div class="max-w-xl mx-auto mt-10">

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">
                    Tambah Durasi Main
                </h2>
                <span class="text-xs font-mono bg-gray-200 text-gray-600 px-2 py-1 rounded">
                    #{{ $transaksi->id_transaksi }}
                </span>
            </div>

            <div class="p-6">
                
                {{-- Info Alert --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-r text-sm flex items-start gap-3">
                    <i data-feather="info" class="w-5 h-5 mt-0.5 flex shrink-0"></i>
                    <div>
                        <p class="font-bold">Info Operator</p>
                        <p>Hanya dapat menambah durasi waktu. Biaya tambahan akan dihitung otomatis ke total bayar.</p>
                    </div>
                </div>

                <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Readonly Info --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tipe PS</label>
                            <div class="bg-gray-100 p-2.5 rounded-lg text-gray-700 text-sm font-medium border border-gray-200">
                                {{ $transaksi->playstation->tipe }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Durasi Saat Ini</label>
                            <div class="bg-gray-100 p-2.5 rounded-lg text-gray-700 text-sm font-medium border border-gray-200">
                                {{ $transaksi->lama_jam }} Jam
                            </div>
                        </div>
                    </div>

                    {{-- Input Tambah Durasi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tambah Durasi (Jam)</label>
                        <input type="number" name="tambah_jam" min="1" required placeholder="Contoh: 1"
                            class="w-full rounded-lg border-gray-300 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">*Masukkan angka jam tambahan saja (bukan total jam).</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 font-medium transition shadow-sm hover:shadow-md">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('transaksi.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection