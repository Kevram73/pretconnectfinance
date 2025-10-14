<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MultiLevelCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referrer_id',
        'level',
        'amount',
        'percentage',
        'status',
        'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
    ];

    /**
     * Get the user that owns the commission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the referrer that earned the commission.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the transaction that generated the commission.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Scope a query to only include completed commissions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    /**
     * Scope a query to only include pending commissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Scope a query by level.
     */
    public function scopeByLevel($query, int $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Mark commission as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => 'COMPLETED']);
    }

    /**
     * Mark commission as cancelled.
     */
    public function markAsCancelled(): void
    {
        $this->update(['status' => 'CANCELLED']);
    }
}
