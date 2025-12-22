<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $drinks = Category::where('nama', 'Drinks')->first();
        $snacks = Category::where('nama', 'Snacks')->first();
        $maincourse = Category::where('nama', 'Maincourse')->first();

        // Drinks
        $drinkProducts = [
            ['nama' => 'Es Kopi Susu', 'harga' => 18000],
            ['nama' => 'Es Kopi Butterscotch', 'harga' => 20000],
            ['nama' => 'Es Kopi Salted Caramel', 'harga' => 20000],
            ['nama' => 'Caffe Americano', 'harga' => 17000],
            ['nama' => 'Caffe Latte', 'harga' => 19000],
            ['nama' => 'Cappucino', 'harga' => 19000],
            ['nama' => 'Matcha Latte', 'harga' => 25000],
            ['nama' => 'Signature Chocolate', 'harga' => 23000],
        ];

        foreach ($drinkProducts as $product) {
            Product::create([
                'category_id' => $drinks->id,
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'deskripsi' => 'Minuman segar untuk menemani hari Anda',
                'is_available' => true,
            ]);
        }

        // Snacks
        $snackProducts = [
            ['nama' => 'Donat Kampoeng', 'harga' => 8000],
            ['nama' => 'Roti Bakar Caramel', 'harga' => 12000],
            ['nama' => 'Tahu Lada Garam', 'harga' => 15000],
            ['nama' => 'Cireng Bumbu Rujak', 'harga' => 12000],
            ['nama' => 'Jamur Crispy', 'harga' => 18000],
            ['nama' => 'Pisang Goreng', 'harga' => 10000],
            ['nama' => 'Pancake', 'harga' => 15000],
            ['nama' => 'Lumpia Basah', 'harga' => 13000],
        ];

        foreach ($snackProducts as $product) {
            Product::create([
                'category_id' => $snacks->id,
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'deskripsi' => 'Camilan lezat untuk menemani minuman Anda',
                'is_available' => true,
            ]);
        }

        // Maincourse
        $maincourseProducts = [
            ['nama' => 'Nasi Goreng Cikur', 'harga' => 20000],
            ['nama' => 'Nasi Cumi Cabe Ijo', 'harga' => 25000],
            ['nama' => 'Nasi Chiken Katsu', 'harga' => 23000],
            ['nama' => 'Nasi Goreng Kampung', 'harga' => 18000],
            ['nama' => 'Mie Slebeew', 'harga' => 17000],
            ['nama' => 'Mie Tek-tek Goreng/Kuah', 'harga' => 15000],
            ['nama' => 'Kwetiau Goreng', 'harga' => 22000],
            ['nama' => 'Mie Aceh', 'harga' => 24000],
        ];

        foreach ($maincourseProducts as $product) {
            Product::create([
                'category_id' => $maincourse->id,
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'deskripsi' => 'Makanan berat untuk mengisi perut Anda',
                'is_available' => true,
            ]);
        }
    }
}