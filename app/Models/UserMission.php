<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMission extends Model
{
    protected $table = 'user_missions'; 

    protected $fillable = [
        'user_id', 'title', 'description', 'is_completed'
    ];
}