<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Drinks',
                'icon' => 'fa-mug-hot',
                'urutan' => 1,
            ],
            [
                'nama' => 'Snacks',
                'icon' => 'fa-cookie',
                'urutan' => 2,
            ],
            [
                'nama' => 'Maincourse',
                'icon' => 'fa-utensils',
                'urutan' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}