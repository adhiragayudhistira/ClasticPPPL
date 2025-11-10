<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\PickupOrder;
use App\Models\UserMission;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get total points from user account
        $totalPoints = $user->points ?? 0;

        // Calculate total plastic collected (in kg) from transactions
        $totalPlasticKg = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('weight') / 1000; // Convert grams to kg

        // Count completed missions
        $completedMissions = UserMission::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        // Count active pickup orders
        $activePickups = PickupOrder::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'on_the_way'])
            ->count();

        // Get recent transactions (optional, for future use)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('welcome', compact(
            'totalPoints',
            'totalPlasticKg',
            'completedMissions',
            'activePickups',
            'recentTransactions'
        ));
    }
}