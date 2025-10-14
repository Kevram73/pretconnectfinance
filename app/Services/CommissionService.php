<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\MultiLevelCommission;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    public function processReferralCommission(User $user, float $amount)
    {
        $referrer = $user->referrer;
        $level = 1;

        while ($referrer && $level <= 5) {
            $percentage = $this->getCommissionPercentage($level);
            $commissionAmount = $amount * ($percentage / 100);

            if ($commissionAmount > 0) {
                // Créer la commission
                Commission::create([
                    'user_id' => $user->id,
                    'referrer_id' => $referrer->id,
                    'amount' => $commissionAmount,
                    'percentage' => $percentage,
                    'type' => 'REFERRAL',
                    'status' => 'PENDING',
                ]);

                // Créer la commission multi-niveau
                MultiLevelCommission::create([
                    'user_id' => $user->id,
                    'referrer_id' => $referrer->id,
                    'level' => $level,
                    'amount' => $commissionAmount,
                    'percentage' => $percentage,
                    'status' => 'PENDING',
                ]);

                // Ajouter au portefeuille du parrain
                $referrerWallet = $referrer->wallet;
                if ($referrerWallet) {
                    $referrerWallet->addBalance($commissionAmount);
                    $referrerWallet->addCommission($commissionAmount);
                }

                // Créer la transaction de commission
                Transaction::create([
                    'user_id' => $referrer->id,
                    'type' => 'COMMISSION',
                    'amount' => $commissionAmount,
                    'status' => 'COMPLETED',
                    'description' => 'Commission de parrainage niveau ' . $level . ' de ' . $user->username,
                    'reference' => 'COMM-' . $user->id . '-' . $level,
                ]);

                // Marquer les commissions comme complétées
                Commission::where('user_id', $user->id)
                    ->where('referrer_id', $referrer->id)
                    ->where('type', 'REFERRAL')
                    ->update(['status' => 'COMPLETED']);

                MultiLevelCommission::where('user_id', $user->id)
                    ->where('referrer_id', $referrer->id)
                    ->where('level', $level)
                    ->update(['status' => 'COMPLETED']);
            }

            $referrer = $referrer->referrer;
            $level++;
        }
    }

    private function getCommissionPercentage(int $level): float
    {
        $percentages = [
            1 => 10.0,  // Niveau 1: 10%
            2 => 5.0,   // Niveau 2: 5%
            3 => 3.0,   // Niveau 3: 3%
            4 => 1.5,   // Niveau 4: 1.5%
            5 => 0.5,   // Niveau 5: 0.5%
        ];

        return $percentages[$level] ?? 0.0;
    }

    public function processTeamReward(User $user)
    {
        $directReferrals = $user->referrals()->where('is_active', true)->count();
        $totalTurnover = $user->referrals()->where('is_active', true)
            ->join('wallets', 'users.id', '=', 'wallets.user_id')
            ->sum('wallets.total_invested');

        $rewardLevel = $this->getTeamRewardLevel($directReferrals, $totalTurnover);
        
        if ($rewardLevel) {
            // Créer la récompense d'équipe
            \App\Models\TeamReward::create([
                'user_id' => $user->id,
                'level' => $rewardLevel['level'],
                'title' => $rewardLevel['title'],
                'required_directs' => $rewardLevel['required_directs'],
                'required_turnover' => $rewardLevel['required_turnover'],
                'monthly_salary' => $rewardLevel['monthly_salary'],
                'current_directs' => $directReferrals,
                'current_turnover' => $totalTurnover,
                'status' => 'ACHIEVED',
                'achieved_at' => now(),
            ]);

            // Ajouter au portefeuille
            $wallet = $user->wallet;
            if ($wallet) {
                $wallet->addBalance($rewardLevel['monthly_salary']);
            }

            // Créer la transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'BONUS',
                'amount' => $rewardLevel['monthly_salary'],
                'status' => 'COMPLETED',
                'description' => 'Récompense d\'équipe - ' . $rewardLevel['title'],
                'reference' => 'TEAM-' . $rewardLevel['level'],
            ]);
        }
    }

    private function getTeamRewardLevel(int $directReferrals, float $totalTurnover): ?array
    {
        $levels = [
            [
                'level' => 1,
                'title' => 'Chef d\'équipe',
                'required_directs' => 5,
                'required_turnover' => 5000,
                'monthly_salary' => 150,
            ],
            [
                'level' => 2,
                'title' => 'Superviseur',
                'required_directs' => 10,
                'required_turnover' => 10000,
                'monthly_salary' => 300,
            ],
            [
                'level' => 3,
                'title' => 'Manager',
                'required_directs' => 15,
                'required_turnover' => 15000,
                'monthly_salary' => 450,
            ],
            [
                'level' => 4,
                'title' => 'Directeur',
                'required_directs' => 25,
                'required_turnover' => 25000,
                'monthly_salary' => 1000,
            ],
            [
                'level' => 5,
                'title' => 'Directeur Senior',
                'required_directs' => 50,
                'required_turnover' => 50000,
                'monthly_salary' => 2000,
            ],
            [
                'level' => 6,
                'title' => 'Vice-Président',
                'required_directs' => 110,
                'required_turnover' => 100000,
                'monthly_salary' => 5000,
            ],
            [
                'level' => 7,
                'title' => 'Président',
                'required_directs' => 200,
                'required_turnover' => 1000000,
                'monthly_salary' => 50000,
            ],
        ];

        foreach ($levels as $level) {
            if ($directReferrals >= $level['required_directs'] && $totalTurnover >= $level['required_turnover']) {
                return $level;
            }
        }

        return null;
    }

    /**
     * Get commission statistics for admin dashboard
     */
    public function getAdminCommissionStats(): array
    {
        $totalCommissions = Commission::sum('amount');
        $pendingCommissions = Commission::where('status', 'PENDING')->sum('amount');
        $completedCommissions = Commission::where('status', 'COMPLETED')->sum('amount');
        $totalCommissionCount = Commission::count();
        $pendingCommissionCount = Commission::where('status', 'PENDING')->count();

        return [
            'total_amount' => $totalCommissions,
            'pending_amount' => $pendingCommissions,
            'completed_amount' => $completedCommissions,
            'total_count' => $totalCommissionCount,
            'pending_count' => $pendingCommissionCount,
            'completed_count' => $totalCommissionCount - $pendingCommissionCount,
        ];
    }

    /**
     * Get commission statistics by level
     */
    public function getCommissionStatsByLevel(): array
    {
        $stats = [];
        
        for ($level = 1; $level <= 5; $level++) {
            $levelStats = MultiLevelCommission::where('level', $level)
                ->selectRaw('
                    COUNT(*) as count,
                    SUM(amount) as total_amount,
                    AVG(amount) as average_amount
                ')
                ->first();

            $stats[$level] = [
                'count' => $levelStats->count ?? 0,
                'total_amount' => $levelStats->total_amount ?? 0,
                'average_amount' => $levelStats->average_amount ?? 0,
                'percentage' => $this->getCommissionPercentage($level),
            ];
        }

        return $stats;
    }
}