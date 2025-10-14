<?php

namespace App\Services;

use App\Models\User;
use App\Models\Commission;
use App\Models\MultiLevelCommission;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    /**
     * Calculate and create referral commission.
     */
    public function calculateReferralCommission(User $user, float $amount): void
    {
        if (!$user->referred_by) {
            return;
        }

        $referrer = $user->referrer;
        if (!$referrer || !$referrer->isActive()) {
            return;
        }

        // 10% referral commission
        $commissionAmount = $amount * 0.10;

        Commission::create([
            'user_id' => $user->id,
            'referrer_id' => $referrer->id,
            'amount' => $commissionAmount,
            'percentage' => 10.00,
            'type' => 'REFERRAL',
            'status' => 'PENDING',
        ]);

        // Calculate multi-level commissions
        $this->calculateMultiLevelCommissions($user, $amount);
    }

    /**
     * Calculate multi-level commissions.
     */
    private function calculateMultiLevelCommissions(User $user, float $amount): void
    {
        $currentUser = $user;
        $level = 1;
        $percentages = [5, 3, 2, 1, 0.5]; // 5 levels: 5%, 3%, 2%, 1%, 0.5%

        while ($currentUser->referred_by && $level <= 5) {
            $referrer = $currentUser->referrer;
            
            if (!$referrer || !$referrer->isActive()) {
                break;
            }

            $commissionAmount = $amount * ($percentages[$level - 1] / 100);

            MultiLevelCommission::create([
                'user_id' => $user->id,
                'referrer_id' => $referrer->id,
                'level' => $level,
                'amount' => $commissionAmount,
                'percentage' => $percentages[$level - 1],
                'status' => 'PENDING',
            ]);

            $currentUser = $referrer;
            $level++;
        }
    }

    /**
     * Process pending commissions.
     */
    public function processPendingCommissions(): void
    {
        DB::beginTransaction();

        try {
            // Process referral commissions
            $referralCommissions = Commission::pending()->get();
            
            foreach ($referralCommissions as $commission) {
                $this->processCommission($commission);
            }

            // Process multi-level commissions
            $multiLevelCommissions = MultiLevelCommission::pending()->get();
            
            foreach ($multiLevelCommissions as $commission) {
                $this->processMultiLevelCommission($commission);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process a single commission.
     */
    private function processCommission(Commission $commission): void
    {
        $referrer = $commission->referrer;
        $wallet = $referrer->wallet;

        if (!$wallet) {
            $wallet = $referrer->wallet()->create([
                'balance' => 0.00,
                'total_deposited' => 0.00,
                'total_withdrawn' => 0.00,
                'total_invested' => 0.00,
                'total_profits' => 0.00,
                'total_commissions' => 0.00,
            ]);
        }

        // Add commission to wallet
        $wallet->addBalance($commission->amount);
        $wallet->addCommission($commission->amount);

        // Create transaction
        Transaction::create([
            'user_id' => $referrer->id,
            'type' => 'COMMISSION',
            'amount' => $commission->amount,
            'status' => 'COMPLETED',
            'description' => "Commission de parrainage - Niveau {$commission->type}",
            'reference' => 'COM_' . time() . '_' . $referrer->id,
        ]);

        // Mark commission as completed
        $commission->markAsCompleted();
    }

    /**
     * Process a single multi-level commission.
     */
    private function processMultiLevelCommission(MultiLevelCommission $commission): void
    {
        $referrer = $commission->referrer;
        $wallet = $referrer->wallet;

        if (!$wallet) {
            $wallet = $referrer->wallet()->create([
                'balance' => 0.00,
                'total_deposited' => 0.00,
                'total_withdrawn' => 0.00,
                'total_invested' => 0.00,
                'total_profits' => 0.00,
                'total_commissions' => 0.00,
            ]);
        }

        // Add commission to wallet
        $wallet->addBalance($commission->amount);
        $wallet->addCommission($commission->amount);

        // Create transaction
        Transaction::create([
            'user_id' => $referrer->id,
            'type' => 'COMMISSION',
            'amount' => $commission->amount,
            'status' => 'COMPLETED',
            'description' => "Commission multi-niveau - Niveau {$commission->level}",
            'reference' => 'MLC_' . time() . '_' . $referrer->id,
        ]);

        // Mark commission as completed
        $commission->markAsCompleted();
    }

    /**
     * Get user's commission statistics.
     */
    public function getUserCommissionStats(User $user): array
    {
        return [
            'total_referral_commissions' => $user->commissions()->completed()->sum('amount'),
            'total_multi_level_commissions' => $user->multiLevelCommissions()->completed()->sum('amount'),
            'pending_referral_commissions' => $user->commissions()->pending()->sum('amount'),
            'pending_multi_level_commissions' => $user->multiLevelCommissions()->pending()->sum('amount'),
            'total_commissions' => $user->commissions()->completed()->sum('amount') + 
                                 $user->multiLevelCommissions()->completed()->sum('amount'),
        ];
    }

    /**
     * Get admin commission statistics.
     */
    public function getAdminCommissionStats(): array
    {
        return [
            'total_referral_commissions' => Commission::completed()->sum('amount'),
            'total_multi_level_commissions' => MultiLevelCommission::completed()->sum('amount'),
            'pending_referral_commissions' => Commission::pending()->sum('amount'),
            'pending_multi_level_commissions' => MultiLevelCommission::pending()->sum('amount'),
            'total_commissions' => Commission::completed()->sum('amount') + 
                                 MultiLevelCommission::completed()->sum('amount'),
            'total_commission_users' => Commission::distinct('referrer_id')->count(),
        ];
    }
}
