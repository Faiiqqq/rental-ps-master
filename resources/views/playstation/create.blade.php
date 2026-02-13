@extends('layout.main')

@section('page-title', 'TAMBAH CONSOLE')

@section('content')

    <div class="max-w-2xl mx-auto mt-8">

        {{-- Card Container --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Tambah Unit Baru
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Masukkan detail console playstation baru.
                    </p>
                </div>
                <a href="{{ route('playstation.index') }}" 
                   class="text-sm text-gray-600 hover:text-blue-600 transition flex items-center gap-1">
                    <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('playstation.store') }}" method="POST" class="px-8 py-8 space-y-6">
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

                    {{-- Tipe PS --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipe Console
                        </label>
                        <div class="relative">
                            <select name="tipe" class="w-full appearance-none rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm cursor-pointer">
                                <option value="ps2">PlayStation 2</option>
                                <option value="ps3">PlayStation 3</option>
                                <option value="ps4">PlayStation 4</option>
                                <option value="ps5">PlayStation 5</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga Sewa / Jam
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500 font-medium">Rp</span>
                                <input type="number" name="hargaPerJam" required placeholder="5000"
                                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 pl-10 text-sm shadow-sm">
                            </div>
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok Awal
                            </label>
                            <input type="number" name="stok" value="{{ old('stok', 1) }}" min="1" required
                                class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm">
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('playstation.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition hover:shadow-lg transform hover:-translate-y-0.5">
                        Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection