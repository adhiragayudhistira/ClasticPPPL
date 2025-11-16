<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_title', 'description', 'points_reward', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points_reward' => 'integer',
    ];

    // Relationship
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_mission')
                    ->withPivot('is_completed', 'completed_at')
                    ->withTimestamps();
    }

    // Scope: Only active missions
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}