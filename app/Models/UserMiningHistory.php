<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\BelongsTo, Builder};

class UserMiningHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan_id', 'status', 'last_sum', 'expire_date'];
    protected $casts = ['expire_date' => 'integer', 'last_sum' => 'integer'];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    // Business Logic
    public function calculateEarnings(): float
    {
        return (time() - ($this->last_sum ?? $this->created_at->timestamp)) 
            * ($this->plan->earning_rate / 60);
    }
}
