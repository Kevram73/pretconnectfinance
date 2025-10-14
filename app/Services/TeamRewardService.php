<?php

namespace App\Services;

use App\Models\User;
use App\Models\TeamReward;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class TeamRewardService
{
    /**
     * Team reward levels configuration.
     */
    private $levels = [
        1 => [
            'title' => 'Bronze',
            'required_directs' => 5,
            'required_turnover' => 10000,
            'monthly_salary' => 500,
        ],
        2 => [
            'title' => 'Silver',
            'required_directs' => 15,
            'required_turnover' => 50000,
            'monthly_salary' => 1500,
        ],
        3 => [
            'title' => 'Gold',
            'required_directs' => 50,
            'required_turnover' => 200000,
            'monthly_salary' => 5000,
        ],
        4 => [
            'title' => 'Platinum',
            'required_directs' => 150,
            'required_turnover' => 1000000,
            'monthly_salary' => 20000,
        ],
        5 => [
            'title' => 'Diamond',
            'required_directs' => 500,
            'required_turnover' => 5000000,
            'monthly_salary' => 100000,
        ],
    ];

    /**
     * Initialize team rewards for a user.
     */
    public function initializeTeamRewards(User $user): void
    {
        foreach ($this->levels as $level => $config) {
            TeamReward::create([
                'user_id' => $user->id,
                'level' => $level,
                'title' => $config['title'],
                'required_directs' => $config['required_directs'],
                'required_turnover' => $config['required_turnover'],
                'monthly_salary' => $config['monthly_salary'],
                'current_directs' => 0,
                'current_turnover' => 0.00,
                'status' => 'PENDING',
            ]);
        }
    }

    /**
     * Update team reward statistics for a user.
     */
    public function updateTeamRewardStats(User $user): void
    {
        $directs = $this->countDirectReferrals($user);
        $turnover = $this->calculateTeamTurnover($user);

        $teamRewards = $user->teamRewards;

        foreach ($teamRewards as $reward) {
            $reward->updateStats($directs, $turnover);
        }
    }

    /**
     * Count direct referrals for a user.
     */
    private function countDirectReferrals(User $user): int
    {
        return $user->referrals()->count();
    }

    /**
     * Calculate team turnover for a user.
     */
    private function calculateTeamTurnover(User $user): float
    {
        $turnover = 0.00;

        // Get all referrals recursively
        $this->calculateRecursiveTurnover($user, $turnover);

        return $turnover;
    }

    /**
     * Calculate turnover recursively for all team members.
     */
    private function calculateRecursiveTurnover(User $user, float &$turnover): void
    {
        $referrals = $user->referrals;

        foreach ($referrals as $referral) {
            // Add referral's investment amount
            $referralInvestments = $referral->investments()->sum('amount');
            $turnover += $referralInvestments;

            // Recursively calculate for sub-referrals
            $this->calculateRecursiveTurnover($referral, $turnover);
        }
    }

    /**
     * Process monthly team rewards.
     */
    public function processMonthlyTeamRewards(): void
    {
        $achievedRewards = TeamReward::achieved()->get();

        DB::beginTransaction();

        try {
            foreach ($achievedRewards as $reward) {
                $this->processTeamReward($reward);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process a single team reward.
     */
    private function processTeamReward(TeamReward $reward): void
    {
        $user = $reward->user;
        $wallet = $user->wallet;

        if (!$wallet) {
            $wallet = $user->wallet()->create([
                'balance' => 0.00,
                'total_deposited' => 0.00,
                'total_withdrawn' => 0.00,
                'total_invested' => 0.00,
                'total_profits' => 0.00,
                'total_commissions' => 0.00,
            ]);
        }

        // Add monthly salary to wallet
        $wallet->addBalance($reward->monthly_salary);

        // Create transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'BONUS',
            'amount' => $reward->monthly_salary,
            'status' => 'COMPLETED',
            'description' => "Salaire mensuel - {$reward->title} (Niveau {$reward->level})",
            'reference' => 'TEAM_' . time() . '_' . $user->id,
        ]);

        // Mark reward as maintained
        $reward->update(['status' => 'MAINTAINED']);
    }

    /**
     * Get user's team reward statistics.
     */
    public function getUserTeamRewardStats(User $user): array
    {
        $teamRewards = $user->teamRewards;

        return [
            'current_level' => $teamRewards->where('status', '!=', 'PENDING')->max('level') ?? 0,
            'achieved_rewards' => $teamRewards->where('status', '!=', 'PENDING')->count(),
            'pending_rewards' => $teamRewards->where('status', 'PENDING')->count(),
            'total_monthly_salary' => $teamRewards->where('status', '!=', 'PENDING')->sum('monthly_salary'),
            'direct_referrals' => $this->countDirectReferrals($user),
            'team_turnover' => $this->calculateTeamTurnover($user),
            'rewards' => $teamRewards,
        ];
    }

    /**
     * Get admin team reward statistics.
     */
    public function getAdminTeamRewardStats(): array
    {
        return [
            'total_achieved_rewards' => TeamReward::achieved()->count(),
            'total_maintained_rewards' => TeamReward::where('status', 'MAINTAINED')->count(),
            'total_pending_rewards' => TeamReward::pending()->count(),
            'total_monthly_salaries' => TeamReward::where('status', '!=', 'PENDING')->sum('monthly_salary'),
        ];
    }
}
