@extends('layout.main')

@section('page-title', 'EDIT CONSOLE')

@section('content')

    <div class="max-w-2xl mx-auto mt-8">

        {{-- Card Container --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Edit Data PlayStation
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui informasi harga atau stok unit.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono bg-blue-100 text-blue-700 px-2 py-1 rounded">ID: #{{ $playstation->id_ps }}</span>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('playstation.update', $playstation->id_ps) }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf
                @method('PUT')

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
                        {{-- Bisa diubah jadi select box jika tipe boleh diubah, atau input text jika tidak --}}
                        <input type="text" name="tipe" value="{{ $playstation->tipe }}" required
                             class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm uppercase font-bold text-gray-600">
                        <p class="text-xs text-gray-400 mt-1">*Pastikan penamaan tipe konsisten (cth: ps3, ps4)</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga Sewa / Jam
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500 font-medium">Rp</span>
                                <input type="number" name="hargaPerJam" value="{{ $playstation->hargaPerJam }}" required
                                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 pl-10 text-sm shadow-sm font-medium">
                            </div>
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Total Stok Unit
                            </label>
                            <input type="number" name="stok" value="{{ $playstation->stok }}" min="0" required
                                class="w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition p-3 text-sm shadow-sm font-medium">
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
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection