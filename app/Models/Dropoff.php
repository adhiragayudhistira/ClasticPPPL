<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dropoff extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_code',
        'address',
        'latitude',
        'longitude',
        'date',
        'time_slot',
        'hdpe_weight',
        'pvc_weight',
        'points',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
