@extends('layout.main')

@section('page-title', 'EDIT TRANSAKSI')

@section('content')

    <div class="max-w-xl mx-auto mt-10">

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">
                    Ubah Durasi Rental
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
                        <p class="font-bold">Mode Edit</p>
                        <p>Anda sedang mengubah total durasi rental. Harga dan jadwal selesai akan dihitung ulang otomatis.</p>
                    </div>
                </div>

                <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Info Readonly --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Unit PlayStation</label>
                        <div class="bg-gray-100 p-3 rounded-lg text-gray-700 text-sm font-medium border border-gray-200">
                            {{ $transaksi->playstation->tipe }} (Rp {{ number_format($transaksi->playstation->hargaPerJam) }}/jam)
                        </div>
                    </div>

                    {{-- Input Edit Durasi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Total Durasi (Jam)</label>
                        <input type="number" name="lama_jam_baru" min="1" required 
                            value="{{ $transaksi->lama_jam }}" 
                            class="w-full rounded-lg border-gray-300 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm font-bold text-blue-600">
                        <p class="text-xs text-gray-500 mt-2">
                            *Ganti angka di atas sesuai keinginan pelanggan (Misal dari <b>5</b> diubah jadi <b>3</b>).
                        </p>
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