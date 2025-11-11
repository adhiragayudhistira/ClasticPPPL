<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\PickupOrder;
use App\Models\UserMission;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();

        $totalPoints = $user->points ?? 0;

        $totalPlasticKg = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('weight') / 1000;

        $completedMissions = UserMission::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $activePickups = PickupOrder::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'on_the_way'])
            ->count();

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact(
            'totalPoints',
            'totalPlasticKg',
            'completedMissions',
            'activePickups',
            'recentTransactions'
        ));
    }
}