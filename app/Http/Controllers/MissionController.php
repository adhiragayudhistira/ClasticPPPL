<?php

namespace App\Http\Controllers;

use App\Models\Mission; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fixed: Use relationship
        $currentStreak = $user->completedMissions()->count();

        // Fixed: Use full namespace
        $missions = Mission::active()->get();

        return view('missions.index', compact('currentStreak', 'missions'));
    }

    // Optional: Real streak logic later
    private function calculateStreak($userId)
    {
        $activityDates = DB::table('transaction')
            ->where('user_id', $userId)
            ->selectRaw('DATE(created_at) as date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date');

        $streak = 0;
        $today = now()->startOfDay();

        foreach ($activityDates as $date) {
            $date = \Carbon\Carbon::parse($date)->startOfDay();
            $expected = $today->copy()->subDays($streak);

            if ($date->equalTo($expected)) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }
}