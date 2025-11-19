<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StreakController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all dates the user had any activity (pickup, transaction, etc.)
        $activityDates = DB::table('transactions')
            ->where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as date')
            ->pluck('date')
            ->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d'))
            ->toArray();

        // Calculate current streak
        $streak = 0;
        $today = \Carbon\Carbon::today();

        for ($i = 0; $i < 365; $i++) {
            $checkDate = $today->copy()->subDays($i)->format('Y-m-d');
            if (in_array($checkDate, $activityDates)) {
                $streak++;
            } else if ($i > 0) {
                break;
            }
        }

        return view('streak.index', compact('streak', 'activityDates'));
    }
}