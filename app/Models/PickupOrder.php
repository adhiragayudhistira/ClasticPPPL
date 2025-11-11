<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupOrder extends Model
{
    protected $table = 'pickup_orders'; 

    protected $fillable = [
        'user_id', 'address', 'estimated_weight', 'status'
    ];
}