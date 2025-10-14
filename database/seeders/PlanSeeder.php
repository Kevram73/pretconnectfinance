<?php

namespace Database\Seeders;

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
                'name' => 'Plan Starter',
                'description' => 'Plan idéal pour débuter dans l\'investissement',
                'min_amount' => 100.00,
                'max_amount' => 1000.00,
                'daily_percentage' => 2.5,
                'duration_days' => 30,
                'total_percentage' => 75.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan Premium',
                'description' => 'Plan premium avec des rendements élevés',
                'min_amount' => 1000.00,
                'max_amount' => 10000.00,
                'daily_percentage' => 3.5,
                'duration_days' => 30,
                'total_percentage' => 105.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan VIP',
                'description' => 'Plan VIP pour les gros investisseurs',
                'min_amount' => 10000.00,
                'max_amount' => 100000.00,
                'daily_percentage' => 5.0,
                'duration_days' => 30,
                'total_percentage' => 150.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan Rapide',
                'description' => 'Plan rapide avec retour en 7 jours',
                'min_amount' => 500.00,
                'max_amount' => 5000.00,
                'daily_percentage' => 7.0,
                'duration_days' => 7,
                'total_percentage' => 49.0,
                'is_active' => true,
                'is_rapid' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::create($planData);
        }

        $this->command->info('Plans created successfully!');
    }
}
