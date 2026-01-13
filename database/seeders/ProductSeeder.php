<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Prakiraan Cuaca Harian',
                'description' => 'Data prakiraan cuaca harian untuk seluruh wilayah Indonesia. Update 2x sehari pada pagi dan sore hari.',
                'price' => 0,
                'type' => 'gratis',
                'status' => 'published',
                'rating' => 4.8
            ],
            [
                'category_id' => 2,
                'name' => 'Data Temperatur Bulanan',
                'description' => 'Arsip lengkap data temperatur bulanan dari berbagai stasiun meteorologi di Indonesia.',
                'price' => 0,
                'type' => 'gratis',
                'status' => 'published',
                'rating' => 4.5
            ],
            [
                'category_id' => 2,
                'name' => 'Konsultasi Iklim',
                'description' => 'Layanan konsultasi mendalam mengenai analisis iklim untuk keperluan bisnis dan penelitian.',
                'price' => 500000,
                'type' => 'premium',
                'status' => 'published',
                'rating' => 4.9
            ],
            [
                'category_id' => 3,
                'name' => 'Data Angin & Gelombang Laut',
                'description' => 'Data real-time kecepatan angin dan tinggi gelombang untuk keperluan maritim dan pelayaran.',
                'price' => 750000,
                'type' => 'premium',
                'status' => 'published',
                'rating' => 4.7
            ],
            [
                'category_id' => 4,
                'name' => 'Data Gempa Bumi Real-time',
                'description' => 'Sistem alert gempa bumi real-time dengan integrasi API untuk monitoring 24/7.',
                'price' => 1000000,
                'type' => 'premium',
                'status' => 'published',
                'rating' => 4.9
            ],
            [
                'category_id' => 6,
                'name' => 'Paket Data Historis 10 Tahun',
                'description' => 'Dataset lengkap 10 tahun terakhir untuk keperluan riset dan analisis mendalam.',
                'price' => 2000000,
                'type' => 'premium',
                'status' => 'published',
                'rating' => 5.0
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}