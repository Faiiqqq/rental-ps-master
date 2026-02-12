@extends('layout.main')

@section('page-title', 'Edit PlayStation')

@section('content')

<div class="max-w-3xl mx-auto mt-6">

    <div class="bg-white rounded-2xl shadow-sm border">

        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold">Edit PlayStation</h2>
        </div>

        <form action="{{ route('playstation.update', $playstation->id_ps) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="text-sm">Tipe</label>
                    <input type="text" name="tipe"
                        value="{{ $playstation->tipe }}"
                        class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="text-sm">Harga/Jam</label>
                    <input type="number" name="hargaPerJam"
                        value="{{ $playstation->hargaPerJam }}"
                        class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="text-sm">Stok</label>
                    <input type="number" name="stok"
                        value="{{ $playstation->stok }}"
                        class="w-full mt-1 rounded-lg border-gray-300 text-sm">
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">

                <a href="{{ route('playstation.index') }}"
                   class="px-4 py-2 bg-gray-100 rounded-lg">
                    Batal
                </a>

                <button class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>

            </div>

        </form>

    </div>
</div>

@endsection
