<?php

namespace App\Http\Controllers;

use App\Models\UserMission;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index()
    {
        $missions = UserMission::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('missions.index', compact('missions'));
    }
}