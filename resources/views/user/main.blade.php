@extends('layout.main')

@section('page-title', 'USER')

@section('content')

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Data User</h2>

        <a href="/user/create" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            + Tambah User
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">NO</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $user->nama }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">{{ ucfirst($user->role) }}</td>
                        <td class="px-6 py-4 text-center space-x-2">

                            <a href="/user/{{ $user->id_user }}/edit" class="text-blue-600 hover:underline">Edit</a>

                            <form action="/user/{{ $user->id_user }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus user?')">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
