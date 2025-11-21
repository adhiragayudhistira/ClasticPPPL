<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    /**
     * Display the location selection page
     */
    public function create()
    {
        return view('pickup.location');
    }

    /**
     * Display the schedule selection page
     */
    public function schedule()
    {
        return view('pickup.schedule');
    }

    /**
     * Display the plastic type selection page
     */
    public function plasticType()
    {
        return view('pickup.plastic-type');
    }

    /**
     * Display the driver navigation page
     */
    public function driverNavigation()
    {
        return view('pickup.driver-navigation');
    }

    /**
     * Display the invoice page
     */
    public function invoice()
    {
        return view('pickup.invoice');
    }

    /**
     * Store the pickup order in database (optional)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'schedule' => 'required|string',
            'plastic_type' => 'required|string',
            'weight' => 'required|numeric|min:0.1',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Here you would typically:
        // 1. Save the order to database
        // 2. Assign a driver
        // 3. Calculate points
        // 4. Send notifications
        
        // Example:
        // $pickup = Pickup::create([
        //     'user_id' => Auth::id(),
        //     'location' => $validated['location'],
        //     'latitude' => $validated['latitude'],
        //     'longitude' => $validated['longitude'],
        //     'schedule' => $validated['schedule'],
        //     'plastic_type' => $validated['plastic_type'],
        //     'weight' => $validated['weight'],
        //     'status' => 'pending',
        //     'transaction_code' => $this->generateTransactionCode(),
        // ]);

        // if ($request->hasFile('photo')) {
        //     $path = $request->file('photo')->store('pickup-photos', 'public');
        //     $pickup->photo = $path;
        //     $pickup->save();
        // }

        // Calculate and award points
        // $points = $this->calculatePoints($validated['weight'], $validated['plastic_type']);
        // Auth::user()->increment('points', $points);

        return response()->json([
            'success' => true,
            'message' => 'Pickup order created successfully',
            'transaction_code' => $this->generateTransactionCode(),
        ]);
    }

    /**
     * Generate a unique transaction code
     */
    private function generateTransactionCode()
    {
        return 'AHXG' . rand(10000, 99999);
    }

    /**
     * Calculate points based on weight and plastic type
     */
    private function calculatePoints($weight, $plasticType)
    {
        // Example point calculation
        // Different plastic types might have different point values
        $pointsPerKg = [
            'HDPE' => 100,
            'PVC' => 80,
            'PRBE' => 90,
        ];

        $basePoints = $pointsPerKg[$plasticType] ?? 100;
        return round($weight * $basePoints);
    }
}