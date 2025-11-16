<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'role', 'points'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'points'            => 'integer',
    ];

    public function missions()
    {
        return $this->belongsToMany(Mission::class, 'user_mission')
                    ->withPivot('is_completed', 'completed_at')
                    ->withTimestamps();
    }

    public function completedMissions()
    {
        return $this->missions()->wherePivot('is_completed', true);
    }

    public function getCurrentStreakAttribute()
    {
        return $this->completedMissions()
                    ->orderBy('user_mission.completed_at', 'desc')
                    ->get()
                    ->take(7)
                    ->count();
    }
}