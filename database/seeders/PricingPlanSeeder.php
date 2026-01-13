<?php
// database/seeders/PricingPlanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingPlan;

class PricingPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'GRATIS',
                'description' => 'Paket gratis untuk akses dasar',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'features' => [
                    'Akses data cuaca publik',
                    'Update harian',
                    'Download CSV',
                    '10 download/bulan'
                ],
                'download_limit' => 10,
                'is_popular' => false,
                'is_active' => true
            ],
            [
                'name' => 'EDUKASI',
                'description' => 'Untuk pelajar dan akademisi',
                'price_monthly' => 50000,
                'price_yearly' => 500000,
                'features' => [
                    'Semua fitur gratis',
                    'Akses data historis',
                    'API key',
                    'Email support',
                    '100 download/bulan'
                ],
                'download_limit' => 100,
                'is_popular' => false,
                'is_active' => true
            ],
            [
                'name' => 'STARTUP',
                'description' => 'Untuk bisnis kecil dan startup',
                'price_monthly' => 500000,
                'price_yearly' => 5000000,
                'features' => [
                    'Semua fitur edukasi',
                    'Real-time data',
                    'Webhook integration',
                    'Dedicated support',
                    'Unlimited download'
                ],
                'download_limit' => null,
                'is_popular' => true,
                'is_active' => true
            ],
            [
                'name' => 'PROFESIONAL',
                'description' => 'Untuk perusahaan menengah',
                'price_monthly' => 2000000,
                'price_yearly' => 20000000,
                'features' => [
                    'Semua fitur startup',
                    'Custom data extraction',
                    'Analytics dashboard',
                    'Priority support',
                    'Custom reports'
                ],
                'download_limit' => null,
                'is_popular' => false,
                'is_active' => true
            ],
            [
                'name' => 'ENTERPRISE',
                'description' => 'Untuk korporat dan pemerintah',
                'price_monthly' => null,
                'price_yearly' => null,
                'features' => [
                    'Semua fitur profesional',
                    'Dedicated account manager',
                    'SLA guarantee',
                    'On-premise option',
                    'Full customization'
                ],
                'download_limit' => null,
                'is_popular' => false,
                'is_active' => true
            ],
        ];

        foreach ($plans as $plan) {
            PricingPlan::create($plan);
        }
    }
}