@extends('layout.main')

@section('page-title', 'DATA PLAYSTATION')

@section('content')

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center justify-between animate-fade-in-down">
            <div class="flex items-center gap-2">
                <i data-feather="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 transition">
                <i data-feather="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Console</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola unit PlayStation, harga sewa, dan stok ketersediaan.</p>
        </div>

        <a href="{{ route('playstation.create') }}" 
           class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i data-feather="plus-circle" class="w-4 h-4 mr-2"></i>
            Tambah Console
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 w-16 text-center">ID</th>
                        <th class="px-6 py-4">Tipe Console</th>
                        <th class="px-6 py-4">Harga Sewa</th>
                        <th class="px-6 py-4 text-center">Ketersediaan</th>
                        <th class="px-6 py-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($playstations as $ps)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            
                            {{-- ID --}}
                            <td class="px-6 py-4 text-center font-mono text-gray-400">
                                #{{ $ps->id_ps }}
                            </td>

                            {{-- Tipe --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                                        <i data-feather="monitor" class="w-5 h-5"></i>
                                    </div>
                                    <span class="font-bold text-gray-800 uppercase text-base tracking-wide">{{ $ps->tipe }}</span>
                                </div>
                            </td>

                            {{-- Harga --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-700">Rp {{ number_format($ps->hargaPerJam, 0, ',', '.') }} <span class="text-gray-400 text-xs">/jam</span></div>
                            </td>

                            {{-- Stok Badge --}}
                            <td class="px-6 py-4 text-center">
                                @if ($ps->stok > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold uppercase tracking-wide rounded-full bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        {{ $ps->stok }} Unit Ready
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold uppercase tracking-wide rounded-full bg-red-100 text-red-700 border border-red-200">
                                        Stok Habis
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('playstation.edit', $ps->id_ps) }}" 
                                       class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 hover:text-yellow-700 transition border border-yellow-200 shadow-sm"
                                       title="Edit Data">
                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                    </a>

                                    <form action="{{ route('playstation.destroy', $ps->id_ps) }}" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="button" 
                                                onclick="if(confirm('Yakin ingin menghapus data PlayStation tipe {{ $ps->tipe }}?')) this.closest('form').submit()"
                                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 hover:text-red-700 transition border border-red-200 shadow-sm"
                                                title="Hapus Data">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400">
                                        <i data-feather="monitor" class="w-8 h-8"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada unit PlayStation</h3>
                                    <p class="text-sm mt-1">Silakan tambahkan data console baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection