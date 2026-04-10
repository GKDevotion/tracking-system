<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'price' => 'Free',
                'description' => '800-1,000 Points / Month',
                'features' => ['1-2 signals weekly', 'Forex & Gold', 'Entry / SL / TP'],
                'cta' => 'Join Free',
                'link' => 'purchase?plan=free',
                'is_highlighted' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Advanced Trader',
                'price' => '$29 / Month',
                'description' => '2,500-3,500 Points / Month',
                'features' => ['1-2 signals weekly', 'Forex, Gold & Crypto', 'Trade reasoning included'],
                'cta' => 'Subscribe Now',
                'link' => 'purchase?plan=advanced',
                'is_highlighted' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Institutional Trader',
                'price' => '$59 / Month',
                'description' => '6,000-8,000 Points / Month',
                'features' => ['3-5 signals daily', 'Forex, Gold, Crypto & Indices', 'Advanced analysis'],
                'cta' => 'Subscribe Now',
                'link' => 'purchase?plan=institutional',
                'is_highlighted' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
