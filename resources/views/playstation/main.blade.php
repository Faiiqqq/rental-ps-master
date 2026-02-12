@extends('layout.main')

@section('page-title', 'PLAYSTATION')

@section('content')

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Daftar PlayStation</h2>

            <a href="{{ route('playstation.create') }}"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah PlayStation
            </a>
        </div>


        {{-- ALERT --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif


        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">ID</th>
                        <th class="px-6 py-4 text-left">Tipe</th>
                        <th class="px-6 py-4 text-left">Harga/Jam</th>
                        <th class="px-6 py-4 text-center">Unit</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($playstations as $ps)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 font-medium">
                                {{ $ps->id_ps }}
                            </td>

                            <td class="px-6 py-4 uppercase font-semibold">
                                {{ $ps->tipe }}
                            </td>

                            <td class="px-6 py-4">
                                Rp {{ number_format($ps->hargaPerJam) }}
                            </td>

                            {{-- STOK BADGE --}}
                            <td class="px-6 py-4 text-center">
                                @if ($ps->stok > 0)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        {{ $ps->stok }} tersedia
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center space-x-3">

                                <a href="{{ route('playstation.edit', $ps->id_ps) }}" class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('playstation.destroy', $ps->id_ps) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus data?')"
                                        class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400">
                                Belum ada data PlayStation
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

@endsection
