<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = [
            // ADMIN
            [
                'nama' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'nama' => 'operator',
                'email' => 'operator@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'operator',
            ],
            [
                'nama' => 'Faiq',
                'email' => 'faiq@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
