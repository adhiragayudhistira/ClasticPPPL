<?php

namespace App\Http\Controllers;

use App\Models\PickupOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    public function index()
    {
        $pickups = PickupOrder::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pickup.index', compact('pickups'));
    }

    public function create()
    {
        return view('pickup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'estimated_weight' => 'required|numeric|min:0.1'
        ]);

        PickupOrder::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'estimated_weight' => $request->estimated_weight * 1000, // grams
            'status' => 'pending'
        ]);

        return redirect()->route('pickup')->with('success', 'Pickup berhasil diajukan!');
    }
}