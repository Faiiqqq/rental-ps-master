@extends('layout.main')

@section('page-title', 'USER')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Data Pelanggan</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">NO</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $user->nama }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">{{ ucfirst($user->role) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
