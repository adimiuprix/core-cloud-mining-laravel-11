<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Relations\HasMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'balance'];

    // Relationships
    public function miningHistories(): HasMany
    {
        return $this->hasMany(UserMiningHistory::class);
    }

    // Query Helpers
    public function activePlans()
    {
        return $this->miningHistories()->active()->with('plan')->get();
    }

    public function getTotalEarningRate(): float
    {
        return (float) $this->miningHistories()->active()->with('plan')->get()
            ->sum(fn($h) => $h->plan->earning_rate);
    }

    // Business Logic
    public function syncBalance(): void
    {
        $time = time();
        $this->miningHistories()->active()->with('plan')->each(function($history) use ($time) {
            $this->increment('balance', $history->calculateEarnings());
            $history->update(['last_sum' => $time]);
        });
    }

    public function expirePlans(): void
    {
        $this->miningHistories()->active()
            ->where('expire_date', '<=', time())
            ->update(['status' => 'inactive']);
    }
}
