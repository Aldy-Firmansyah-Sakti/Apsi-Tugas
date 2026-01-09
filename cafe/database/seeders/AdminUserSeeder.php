<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin users if they don't exist
        if (!User::where('email', 'admin@cafex.com')->exists()) {
            User::create([
                'name' => 'Admin Café X',
                'email' => 'admin@cafex.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        echo "Admin users seeded successfully!\n";
        echo "Login credentials:\n";
        echo "1. Email: admin@cafex.com, Password: admin123\n";
        echo "2. Email: admin@admin.com, Password: password\n";
    }
}