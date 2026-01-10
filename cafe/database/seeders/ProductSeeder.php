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
            ['nama' => 'Es Kopi Susu', 'harga' => 18000, 'foto' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop'],
            ['nama' => 'Es Kopi Butterscotch', 'harga' => 20000, 'foto' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400&h=300&fit=crop'],
            ['nama' => 'Es Kopi Salted Caramel', 'harga' => 20000, 'foto' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=400&h=300&fit=crop'],
            ['nama' => 'Caffe Americano', 'harga' => 17000, 'foto' => 'https://images.unsplash.com/photo-1551030173-122aabc4489c?w=400&h=300&fit=crop'],
            ['nama' => 'Caffe Latte', 'harga' => 19000, 'foto' => 'https://images.unsplash.com/photo-1570968915860-54d5c301fa9f?w=400&h=300&fit=crop'],
            ['nama' => 'Cappucino', 'harga' => 19000, 'foto' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop'],
            ['nama' => 'Matcha Latte', 'harga' => 25000, 'foto' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?w=400&h=300&fit=crop'],
            ['nama' => 'Signature Chocolate', 'harga' => 23000, 'foto' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=400&h=300&fit=crop'],
        ];

        foreach ($drinkProducts as $product) {
            Product::create([
                'category_id' => $drinks->id,
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'foto' => $product['foto'],
                'deskripsi' => 'Minuman segar untuk menemani hari Anda',
                'is_available' => true,
            ]);
        }

        // Snacks
        $snackProducts = [
            ['nama' => 'Donat Kampoeng', 'harga' => 8000, 'foto' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400&h=300&fit=crop'],
            ['nama' => 'Roti Bakar Caramel', 'harga' => 12000, 'foto' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop'],
            ['nama' => 'Tahu Lada Garam', 'harga' => 15000, 'foto' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop'],
            ['nama' => 'Cireng Bumbu Rujak', 'harga' => 12000, 'foto' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=400&h=300&fit=crop'],
            ['nama' => 'Jamur Crispy', 'harga' => 18000, 'foto' => 'https://images.unsplash.com/photo-1506084868230-bb9d95c24759?w=400&h=300&fit=crop'],
            ['nama' => 'Pisang Goreng', 'harga' => 10000, 'foto' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=400&h=300&fit=crop'],
            ['nama' => 'Pancake', 'harga' => 15000, 'foto' => 'https://images.unsplash.com/photo-1506084868230-bb9d95c24759?w=400&h=300&fit=crop'],
            ['nama' => 'Lumpia Basah', 'harga' => 13000, 'foto' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop'],
        ];

        foreach ($snackProducts as $product) {
            Product::create([
                'category_id' => $snacks->id,
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'foto' => $product['foto'],
                'deskripsi' => 'Camilan lezat untuk menemani minuman Anda',
                'is_available' => true,
            ]);
        }

        // Maincourse
        $maincourseProducts = [
            ['nama' => 'Nasi Goreng Cikur', 'harga' => 20000, 'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=300&fit=crop'],
            ['nama' => 'Nasi Cumi Cabe Ijo', 'harga' => 25000, 'foto' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop'],
            ['nama' => 'Nasi Chiken Katsu', 'harga' => 23000, 'foto' => 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400&h=300&fit=crop'],
            ['nama' => 'Nasi Goreng Kampung', 'harga' => 18000, 'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=300&fit=crop'],
            ['nama' => 'Mie Slebeew', 'harga' => 17000, 'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop'],
            ['nama' => 'Mie Tek-tek Goreng/Kuah', 'harga' => 15000, 'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop'],
            ['nama' => 'Kwetiau Goreng', 'harga' => 22000, 'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop'],
            ['nama' => 'Mie Aceh', 'harga' => 24000, 'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop'],
        ];

        foreach ($maincourseProducts as $product) {
            Product::create([
                'category_id' => $maincourse->id,
                'nama' => $product['nama'],
                'harga' => $product['harga'],
                'foto' => $product['foto'],
                'deskripsi' => 'Makanan berat untuk mengisi perut Anda',
                'is_available' => true,
            ]);
        }
    }
}