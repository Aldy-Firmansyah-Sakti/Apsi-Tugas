<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Cafe X',
            'email' => 'admin@cafex.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'is_active' => true,
        ]);

        // Staff/Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@cafex.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '08123456788',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Kasir 2',
            'email' => 'kasir2@cafex.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '08123456787',
            'is_active' => true,
        ]);
    }
}