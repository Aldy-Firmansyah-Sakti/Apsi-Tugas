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
        User::updateOrCreate(
            ['email' => 'admin@cafex.com'],
            [
                'name' => 'Admin Cafe X',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '08123456789',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Staff/Kasir
        User::updateOrCreate(
            ['email' => 'kasir@cafex.com'],
            [
                'name' => 'Kasir 1',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '08123456788',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir2@cafex.com'],
            [
                'name' => 'Kasir 2',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '08123456787',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Additional admin account
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '08123456786',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}