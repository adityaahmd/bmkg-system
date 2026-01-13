<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Meteorologi', 'icon' => '🌤️', 'description' => 'Data cuaca dan iklim'],
            ['name' => 'Klimatologi', 'icon' => '🌡️', 'description' => 'Data temperatur dan iklim jangka panjang'],
            ['name' => 'Kelautan & Pesisir', 'icon' => '🌊', 'description' => 'Data maritim dan pesisir'],
            ['name' => 'Geofisika', 'icon' => '🌍', 'description' => 'Data gempa dan geofisika'],
            ['name' => 'Kualitas Udara', 'icon' => '💨', 'description' => 'Monitoring kualitas udara'],
            ['name' => 'Data Historis', 'icon' => '📊', 'description' => 'Arsip data historis lengkap'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])], // Unik berdasarkan slug
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}