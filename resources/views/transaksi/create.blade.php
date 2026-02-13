@extends('layout.main')

@section('page-title', 'TAMBAH TRANSAKSI')

@section('content')

    <div class="max-w-2xl mx-auto mt-6">

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            
            <div class="bg-blue-50 px-8 py-5 border-b border-blue-100">
                <h2 class="text-xl font-bold text-blue-800 flex items-center gap-2">
                    <i data-feather="play-circle" class="w-5 h-5"></i>
                    Booking PlayStation
                </h2>
                <p class="text-sm text-blue-600 mt-1">Isi formulir untuk memulai rental baru.</p>
            </div>

            <form action="{{ route('transaksi.store') }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm border border-red-200">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">
                    
                    {{-- Pilih PS --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Console</label>
                        <div class="relative">
                            <select name="id_ps" id="psSelect" required 
                                class="w-full appearance-none rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm cursor-pointer">
                                <option value="" data-harga="0">-- Pilih PlayStation --</option>
                                @foreach ($playstations as $ps)
                                    <option value="{{ $ps->id_ps }}" data-harga="{{ $ps->hargaPerJam }}">
                                        {{ $ps->tipe }} (Sisa: {{ $ps->stok }}) - Rp {{ number_format($ps->hargaPerJam) }}/jam
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Jam Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                            <input type="datetime-local" name="jam_mulai" required
                                class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm">
                        </div>

                        {{-- Lama Main --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi (Jam)</label>
                            <div class="relative">
                                <input type="number" name="lama_jam" id="lamaJam" min="1" value="1" required
                                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm pl-4">
                                <span class="absolute right-4 top-3 text-gray-400 text-sm font-medium">Jam</span>
                            </div>
                        </div>
                    </div>

                    {{-- Estimasi Total --}}
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Total Bayar</span>
                            <span class="text-sm text-gray-500">Estimasi biaya rental</span>
                        </div>
                        <div class="text-right">
                            <input type="text" id="totalBayar" readonly value="Rp 0"
                                class="bg-transparent border-none text-right font-bold text-2xl text-blue-600 focus:ring-0 p-0 w-40">
                        </div>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('transaksi.index') }}" 
                        class="px-5 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-5 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Booking Sekarang
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Script Hitung Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const psSelect = document.getElementById('psSelect');
            const lamaJam = document.getElementById('lamaJam');
            const totalBayar = document.getElementById('totalBayar');

            function hitungTotal() {
                // Ambil harga dari attribute data-harga option yang dipilih
                let selectedOption = psSelect.options[psSelect.selectedIndex];
                let harga = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) : 0;
                let jam = parseFloat(lamaJam.value) || 0;

                if (isNaN(harga)) harga = 0;

                let total = harga * jam;
                
                // Format Rupiah
                totalBayar.value = "Rp " + total.toLocaleString('id-ID');
            }

            psSelect.addEventListener('change', hitungTotal);
            lamaJam.addEventListener('input', hitungTotal);
            
            // Trigger sekali saat load (opsional)
            hitungTotal();
        });
    </script>

@endsection