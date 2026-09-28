<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@shque.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'karyawan01@shque.com',
            ],
            [
                'name' => 'Karyawan My Shque',
                'password' => Hash::make('password123'),
                'role' => 'karyawan',
            ]
        );
    }
}