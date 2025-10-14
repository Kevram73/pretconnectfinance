<?php

namespace App\Services;

use App\Models\Investment;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvestmentService
{
    protected $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    /**
     * Process daily profits for all active investments.
     */
    public function processDailyProfits(): void
    {
        $activeInvestments = Investment::active()->get();

        DB::beginTransaction();

        try {
            foreach ($activeInvestments as $investment) {
                $this->processInvestmentProfit($investment);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process profit for a single investment.
     */
    private function processInvestmentProfit(Investment $investment): void
    {
        $user = $investment->user;
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

        // Add daily profit to wallet
        $wallet->addBalance($investment->daily_profit);
        $wallet->addProfit($investment->daily_profit);

        // Create profit transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'PROFIT',
            'amount' => $investment->daily_profit,
            'status' => 'COMPLETED',
            'description' => "Profit quotidien - Investissement #{$investment->id}",
            'reference' => 'PROF_' . time() . '_' . $user->id,
        ]);

        // Add a day to the investment
        $investment->addDay();

        // Check if investment is completed
        if ($investment->isCompleted()) {
            $this->completeInvestment($investment);
        }
    }

    /**
     * Complete an investment.
     */
    private function completeInvestment(Investment $investment): void
    {
        $investment->markAsCompleted();

        // Calculate final profit
        $finalProfit = $investment->calculateCurrentProfit();
        
        // Add final profit to wallet if not already added
        if ($finalProfit > $investment->total_profit) {
            $user = $investment->user;
            $wallet = $user->wallet;
            
            $additionalProfit = $finalProfit - $investment->total_profit;
            
            $wallet->addBalance($additionalProfit);
            $wallet->addProfit($additionalProfit);

            // Create final profit transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'PROFIT',
                'amount' => $additionalProfit,
                'status' => 'COMPLETED',
                'description' => "Profit final - Investissement #{$investment->id}",
                'reference' => 'FINAL_' . time() . '_' . $user->id,
            ]);
        }
    }

    /**
     * Create a new investment.
     */
    public function createInvestment(User $user, $plan, float $amount): Investment
    {
        DB::beginTransaction();

        try {
            // Create investment
            $investment = Investment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'daily_profit' => $plan->calculateDailyProfit($amount),
                'daily_percentage' => $plan->daily_percentage,
                'duration_days' => $plan->duration_days,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration_days),
                'status' => 'ACTIVE',
            ]);

            // Create transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'INVESTMENT',
                'amount' => $amount,
                'status' => 'COMPLETED',
                'description' => "Investissement dans le plan: {$plan->name}",
                'reference' => 'INV_' . time() . '_' . $user->id,
            ]);

            // Update wallet
            $wallet = $user->wallet;
            $wallet->subtractBalance($amount);
            $wallet->addInvestment($amount);

            // Calculate referral commissions
            $this->commissionService->calculateReferralCommission($user, $amount);

            DB::commit();

            return $investment;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get investment statistics for a user.
     */
    public function getUserInvestmentStats(User $user): array
    {
        $investments = $user->investments();

        return [
            'total_invested' => $investments->sum('amount'),
            'active_investments' => $investments->active()->sum('amount'),
            'completed_investments' => $investments->completed()->sum('amount'),
            'total_profits' => $investments->sum('total_profit'),
            'active_count' => $investments->active()->count(),
            'completed_count' => $investments->completed()->count(),
            'daily_profit' => $investments->active()->sum('daily_profit'),
        ];
    }

    /**
     * Get investment statistics for admin.
     */
    public function getAdminInvestmentStats(): array
    {
        return [
            'total_investments' => Investment::sum('amount'),
            'active_investments' => Investment::active()->sum('amount'),
            'completed_investments' => Investment::completed()->sum('amount'),
            'total_profits' => Investment::sum('total_profit'),
            'active_count' => Investment::active()->count(),
            'completed_count' => Investment::completed()->count(),
            'daily_profit' => Investment::active()->sum('daily_profit'),
        ];
    }
}
