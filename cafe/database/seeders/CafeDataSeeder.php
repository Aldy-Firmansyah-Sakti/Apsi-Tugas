<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table;

class CafeDataSeeder extends Seeder
{
    public function run()
    {
        // Create categories
        $categories = [
            ['nama' => 'Minuman Kopi', 'slug' => 'minuman-kopi'],
            ['nama' => 'Minuman Non-Kopi', 'slug' => 'minuman-non-kopi'],
            ['nama' => 'Makanan', 'slug' => 'makanan'],
            ['nama' => 'Snack', 'slug' => 'snack'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }

        // Get category IDs
        $kopiCategory = Category::where('slug', 'minuman-kopi')->first();
        $nonKopiCategory = Category::where('slug', 'minuman-non-kopi')->first();
        $makananCategory = Category::where('slug', 'makanan')->first();
        $snackCategory = Category::where('slug', 'snack')->first();

        // Create products
        $products = [
            // Minuman Kopi
            [
                'category_id' => $kopiCategory->id,
                'nama' => 'Es Kopi Susu',
                'deskripsi' => 'Kopi hitam dengan susu segar dan es batu',
                'harga' => 17000,
                'is_available' => true,
                'stock' => 50,
            ],
            [
                'category_id' => $kopiCategory->id,
                'nama' => 'Café Latte',
                'deskripsi' => 'Espresso dengan steamed milk dan foam',
                'harga' => 22000,
                'is_available' => true,
                'stock' => 50,
            ],
            [
                'category_id' => $nonKopiCategory->id,
                'nama' => 'Matcha Latte',
                'deskripsi' => 'Matcha premium dengan susu hangat',
                'harga' => 25000,
                'is_available' => true,
                'stock' => 30,
            ],
            // Makanan
            [
                'category_id' => $makananCategory->id,
                'nama' => 'Nasi Goreng Cikur',
                'deskripsi' => 'Nasi goreng spesial dengan bumbu cikur',
                'harga' => 20000,
                'is_available' => true,
                'stock' => 20,
            ],
            [
                'category_id' => $makananCategory->id,
                'nama' => 'Tahu Lada Garam',
                'deskripsi' => 'Tahu goreng dengan bumbu lada garam',
                'harga' => 15000,
                'is_available' => true,
                'stock' => 25,
            ],
            // Snack
            [
                'category_id' => $snackCategory->id,
                'nama' => 'Donat Kampoeng',
                'deskripsi' => 'Donat lembut dengan topping gula halus',
                'harga' => 8000,
                'is_available' => true,
                'stock' => 40,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(['nama' => $productData['nama']], $productData);
        }

        // Create tables (1-10)
        for ($i = 1; $i <= 10; $i++) {
            Table::firstOrCreate(
                ['nomor_meja' => $i],
                [
                    'kapasitas' => 4,
                    'status' => 'available',
                    'qr_code' => 'QR-TABLE-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                ]
            );
        }

        echo "Cafe data seeded successfully!\n";
        echo "Created categories, products, and tables 1-10\n";
    }
}