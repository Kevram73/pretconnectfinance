<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'total_deposited',
        'total_withdrawn',
        'total_invested',
        'total_profits',
        'total_commissions',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_deposited' => 'decimal:2',
        'total_withdrawn' => 'decimal:2',
        'total_invested' => 'decimal:2',
        'total_profits' => 'decimal:2',
        'total_commissions' => 'decimal:2',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Add amount to balance.
     */
    public function addBalance(float $amount): void
    {
        $this->increment('balance', $amount);
    }

    /**
     * Subtract amount from balance.
     */
    public function subtractBalance(float $amount): void
    {
        $this->decrement('balance', $amount);
    }

    /**
     * Add to total deposited.
     */
    public function addDeposit(float $amount): void
    {
        $this->increment('total_deposited', $amount);
    }

    /**
     * Add to total withdrawn.
     */
    public function addWithdrawal(float $amount): void
    {
        $this->increment('total_withdrawn', $amount);
    }

    /**
     * Add to total invested.
     */
    public function addInvestment(float $amount): void
    {
        $this->increment('total_invested', $amount);
    }

    /**
     * Add to total profits.
     */
    public function addProfit(float $amount): void
    {
        $this->increment('total_profits', $amount);
    }

    /**
     * Add to total commissions.
     */
    public function addCommission(float $amount): void
    {
        $this->increment('total_commissions', $amount);
    }
}
