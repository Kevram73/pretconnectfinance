<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
        'title',
        'required_directs',
        'required_turnover',
        'monthly_salary',
        'current_directs',
        'current_turnover',
        'status',
        'achieved_at',
    ];

    protected $casts = [
        'required_turnover' => 'decimal:2',
        'monthly_salary' => 'decimal:2',
        'current_turnover' => 'decimal:2',
        'achieved_at' => 'date',
    ];

    /**
     * Get the user that owns the team reward.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include achieved rewards.
     */
    public function scopeAchieved($query)
    {
        return $query->where('status', 'ACHIEVED');
    }

    /**
     * Scope a query to only include pending rewards.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Check if the reward requirements are met.
     */
    public function isRequirementsMet(): bool
    {
        return $this->current_directs >= $this->required_directs && 
               $this->current_turnover >= $this->required_turnover;
    }

    /**
     * Mark reward as achieved.
     */
    public function markAsAchieved(): void
    {
        $this->update([
            'status' => 'ACHIEVED',
            'achieved_at' => now(),
        ]);
    }

    /**
     * Update current stats.
     */
    public function updateStats(int $directs, float $turnover): void
    {
        $this->update([
            'current_directs' => $directs,
            'current_turnover' => $turnover,
        ]);

        if ($this->isRequirementsMet() && $this->status === 'PENDING') {
            $this->markAsAchieved();
        }
    }
}
