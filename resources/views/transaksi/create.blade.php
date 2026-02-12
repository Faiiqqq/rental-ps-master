@extends('layout.main')

@section('page-title', 'Tambah Transaksi Rental')

@section('content')

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

        <h2 class="text-lg font-semibold mb-5">Form Rental Playstation</h2>

        <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- PILIH PS --}}
            <div>
                <label class="block text-sm font-medium mb-1">Pilih Playstation</label>
                <select name="id_ps" id="psSelect" required class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih --</option>
                    @foreach ($playstations as $ps)
                        <option value="{{ $ps->id_ps }}" data-harga="{{ $ps->hargaPerJam }}">
                            {{ $ps->tipe }} | Stok: {{ $ps->stok }} | Rp {{ number_format($ps->hargaPerJam) }}/jam
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JAM MULAI --}}
            <div>
                <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                <input type="datetime-local" name="jam_mulai" id="jamMulai" required
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- LAMA JAM --}}
            <div>
                <label class="block text-sm font-medium mb-1">Lama Main (Jam)</label>
                <input type="number" name="lama_jam" id="lamaJam" min="1" required
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- TOTAL BAYAR --}}
            <div>
                <label class="block text-sm font-medium mb-1">Total Bayar</label>
                <input type="text" id="totalBayar" readonly class="w-full bg-gray-100 border rounded px-3 py-2">
            </div>

            {{-- BUTTON --}}
            <div class="pt-3">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan Transaksi
                </button>
            </div>

        </form>
    </div>


    {{-- ================= JS HITUNG OTOMATIS ================= --}}
    <script>
        const psSelect = document.getElementById('psSelect');
        const lamaJam = document.getElementById('lamaJam');
        const totalBayar = document.getElementById('totalBayar');

        function hitungTotal() {
            let harga = psSelect.options[psSelect.selectedIndex]?.dataset.harga || 0;
            let jam = lamaJam.value || 0;

            let total = harga * jam;

            totalBayar.value = "Rp " + total.toLocaleString('id-ID');
        }

        psSelect.addEventListener('change', hitungTotal);
        lamaJam.addEventListener('input', hitungTotal);
    </script>

@endsection
