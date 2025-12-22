<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tables')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 10; $i++) {
            DB::table('tables')->insert([
                'nomor_meja' => (string) $i,
                'qr_code' => 'QR-MEJA-' . $i,
                'status' => 'available',
                'kapasitas' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
