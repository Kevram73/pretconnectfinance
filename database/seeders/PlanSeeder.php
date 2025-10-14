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
            // Plans Standards (5 plans)
            [
                'name' => 'Plan Standard 1',
                'description' => '100$ à 199$ - Gagner 1,5% par jour pendant 200 jours (300% total)',
                'min_amount' => 100.00,
                'max_amount' => 199.00,
                'daily_percentage' => 1.5,
                'duration_days' => 200,
                'total_percentage' => 300.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan Standard 2',
                'description' => '200$ à 299$ - Gagner 2% par jour pendant 200 jours (400% total)',
                'min_amount' => 200.00,
                'max_amount' => 299.00,
                'daily_percentage' => 2.0,
                'duration_days' => 200,
                'total_percentage' => 400.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan Standard 3',
                'description' => '300$ à 499$ - Gagner 2,3% par jour pendant 200 jours (460% total)',
                'min_amount' => 300.00,
                'max_amount' => 499.00,
                'daily_percentage' => 2.3,
                'duration_days' => 200,
                'total_percentage' => 460.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan Standard 4',
                'description' => '500$ à 999$ - Gagner 2,5% par jour pendant 200 jours (500% total)',
                'min_amount' => 500.00,
                'max_amount' => 999.00,
                'daily_percentage' => 2.5,
                'duration_days' => 200,
                'total_percentage' => 500.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            [
                'name' => 'Plan Standard 5',
                'description' => '1000$ à 5000$ - Gagner 2,8% par jour pendant 180 jours (500% total)',
                'min_amount' => 1000.00,
                'max_amount' => 5000.00,
                'daily_percentage' => 2.8,
                'duration_days' => 180,
                'total_percentage' => 500.0,
                'is_active' => true,
                'is_rapid' => false,
            ],
            // Plans Rapides (2 plans seulement)
            [
                'name' => 'Plan Rapide 1',
                'description' => '100$ à 150$ - Gagner 0,5% chaque 24h avec retour du capital',
                'min_amount' => 100.00,
                'max_amount' => 150.00,
                'daily_percentage' => 0.5,
                'duration_days' => 1,
                'total_percentage' => 0.5,
                'is_active' => true,
                'is_rapid' => true,
                'rapid_days' => 1,
            ],
            [
                'name' => 'Plan Rapide 2',
                'description' => '151$ à 199$ - Gagner 6% à 7 jours avec retour du capital',
                'min_amount' => 151.00,
                'max_amount' => 199.00,
                'daily_percentage' => 6.0,
                'duration_days' => 7,
                'total_percentage' => 42.0,
                'is_active' => true,
                'is_rapid' => true,
                'rapid_days' => 7,
            ],
        ];

        foreach ($plans as $planData) {
            // Check if plan already exists
            $existingPlan = Plan::where('name', $planData['name'])->first();
            
            if (!$existingPlan) {
                Plan::create($planData);
            }
        }

        $this->command->info('Plans created successfully!');
    }
}
