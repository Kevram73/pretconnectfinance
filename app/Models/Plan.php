<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_amount',
        'max_amount',
        'daily_percentage',
        'duration_days',
        'total_percentage',
        'is_active',
        'is_rapid',
        'rapid_days',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'daily_percentage' => 'decimal:2',
        'total_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'is_rapid' => 'boolean',
    ];

    /**
     * Get the investments for the plan.
     */
    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class);
    }

    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include regular plans.
     */
    public function scopeRegular($query)
    {
        return $query->where('is_rapid', false);
    }

    /**
     * Scope a query to only include rapid plans.
     */
    public function scopeRapid($query)
    {
        return $query->where('is_rapid', true);
    }

    /**
     * Calculate the total return for an amount.
     */
    public function calculateTotalReturn(float $amount): float
    {
        return $amount * ($this->total_percentage / 100);
    }

    /**
     * Calculate the daily profit for an amount.
     */
    public function calculateDailyProfit(float $amount): float
    {
        return $amount * ($this->daily_percentage / 100);
    }
}
