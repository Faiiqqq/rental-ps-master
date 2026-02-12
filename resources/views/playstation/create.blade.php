@extends('layout.main')

@section('page-title', 'Tambah PlayStation')

@section('content')

    <div class="max-w-3xl mx-auto mt-6">

        <div class="bg-white rounded-2xl shadow-sm border">

            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold">Tambah PlayStation</h2>
            </div>

            <form action="{{ route('playstation.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- TIPE --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipe
                        </label>
                        <select name="tipe"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                            <option value="ps2">PS 2</option>
                            <option value="ps3">PS 3</option>
                            <option value="ps4">PS 4</option>
                            <option value="ps5">PS 5</option>
                        </select>
                    </div>

                    {{-- HARGA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Harga/Jam
                        </label>
                        <input type="number" name="hargaPerJam" required placeholder="Contoh: 5000"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                    </div>

                    {{-- STOK --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stok
                        </label>
                        <input type="number" name="stok" value="{{ old('stok', 1) }}"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                    </div>

                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('playstation.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">
                        Batal
                    </a>

                    <button class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
