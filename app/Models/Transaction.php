<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'status',
        'description',
        'reference',
        'transaction_hash',
        'payment_method',
        'payment_hash',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include deposits.
     */
    public function scopeDeposits($query)
    {
        return $query->where('type', 'DEPOSIT');
    }

    /**
     * Scope a query to only include withdrawals.
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'WITHDRAWAL');
    }

    /**
     * Scope a query to only include investments.
     */
    public function scopeInvestments($query)
    {
        return $query->where('type', 'INVESTMENT');
    }

    /**
     * Scope a query to only include completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Mark transaction as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => 'COMPLETED']);
    }

    /**
     * Mark transaction as cancelled.
     */
    public function markAsCancelled(): void
    {
        $this->update(['status' => 'CANCELLED']);
    }
}
