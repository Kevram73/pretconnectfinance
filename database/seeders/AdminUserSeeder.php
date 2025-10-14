<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'PretConnectLoan',
            'username' => 'admin',
            'email' => 'admin@pretconnectloan.com',
            'password' => Hash::make('admin123'),
            'referral_code' => 'ADMIN001',
            'role' => 'ADMIN',
            'is_active' => true,
        ]);

        // Create wallet for admin
        Wallet::create([
            'user_id' => $admin->id,
            'balance' => 0.00,
            'total_deposited' => 0.00,
            'total_withdrawn' => 0.00,
            'total_invested' => 0.00,
            'total_profits' => 0.00,
            'total_commissions' => 0.00,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@pretconnectloan.com');
        $this->command->info('Password: admin123');
    }
}
