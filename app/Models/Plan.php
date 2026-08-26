<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory, Relations\HasMany};

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name', 'is_default', 'point_per_day', 
        'version', 'earning_rate', 'price', 'duration', 'profit'
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(UserMiningHistory::class);
    }
}
