<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'daily_profit',
        'total_profit',
        'daily_percentage',
        'duration_days',
        'days_elapsed',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'daily_profit' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'daily_percentage' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the investment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan for the investment.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Scope a query to only include active investments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    /**
     * Scope a query to only include completed investments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    /**
     * Calculate the current profit.
     */
    public function calculateCurrentProfit(): float
    {
        return $this->daily_profit * $this->days_elapsed;
    }

    /**
     * Check if investment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->days_elapsed >= $this->duration_days;
    }

    /**
     * Mark investment as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'COMPLETED',
            'total_profit' => $this->calculateCurrentProfit(),
        ]);
    }

    /**
     * Add a day to the investment.
     */
    public function addDay(): void
    {
        $this->increment('days_elapsed');
        
        if ($this->isCompleted()) {
            $this->markAsCompleted();
        }
    }
}
