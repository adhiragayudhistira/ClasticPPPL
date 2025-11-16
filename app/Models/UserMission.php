<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMission extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'user_mission'; // Changed from 'user_missions' to match your DB

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'points_reward',
        'is_completed',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'points_reward' => 'integer',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark mission as completed and award points
     */
    public function complete()
    {
        if (!$this->is_completed) {
            $this->update([
                'is_completed' => true,
                'completed_at' => now(),
            ]);

            // Award points to user
            if ($this->points_reward > 0) {
                $this->user->addPoints($this->points_reward);
            }
        }
    }

    /**
     * Check if mission is completed
     */
    public function isCompleted()
    {
        return $this->is_completed;
    }
}