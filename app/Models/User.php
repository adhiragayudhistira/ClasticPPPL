<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'points',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'points' => 'integer',
        ];
    }

    /**
     * Relationships
     */
    
    // User's pickup orders
    public function pickupOrders()
    {
        return $this->hasMany(PickupOrder::class);
    }

    // User's dropoff orders
    public function dropoffOrders()
    {
        return $this->hasMany(DropoffOrder::class);
    }

    // User's transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // User's missions
    public function missions()
    {
        return $this->hasMany(UserMission::class);
    }

    // User's point exchanges
    public function pointExchanges()
    {
        return $this->hasMany(PointExchange::class);
    }

    // User's article views
    public function articleViews()
    {
        return $this->hasMany(UserArticleView::class);
    }

    // User's plastic classifications
    public function plasticClassifications()
    {
        return $this->hasMany(PlasticClassification::class);
    }

    /**
     * Helper Methods
     */

    // Add points to user
    public function addPoints($amount)
    {
        $this->increment('points', $amount);
    }

    // Deduct points from user
    public function deductPoints($amount)
    {
        if ($this->points >= $amount) {
            $this->decrement('points', $amount);
            return true;
        }
        return false;
    }

    // Check if user is recycler
    public function isRecycler()
    {
        return $this->role === 'recycler';
    }

    // Check if user is waste bank
    public function isWasteBank()
    {
        return $this->role === 'waste_bank';
    }

    // Check if user is driver
    public function isDriver()
    {
        return $this->role === 'driver';
    }
}