<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    /**
     * Display a listing of the user's pickup orders (optional dashboard)
     */
    public function index()
    {
        // You can show user's past pickups here later
        return view('pickup.index');
    }

    /**
     * Show the first step: Location selection
     */
    public function location()
    {
        return view('pickup.location');
    }

    /**
     * Show the schedule selection page
     */
    public function schedule()
    {
        return view('pickup.schedule'); 
    }

    /**
     * Show the plastic type & weight input page
     */
    public function plasticType()
    {
        return view('pickup.plastic-type');
    }

    /**
     * Show final invoice / confirmation page
     */
    public function invoice()
    {
        return view('pickup.invoice');
    }

    /**
     * Optional: Driver navigation page (real-time tracking)
     */
    public function driverNavigation()
    {
        return view('pickup.driver-navigation');
    }

    /**
     * Handle the pickup creation form submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address'        => 'required|string|max:255',
            'latitude'       => 'required|numeric|between:-90,90',
            'longitude'      => 'required|numeric|between:-180,180',
            'schedule'       => 'required|string',
            'plastic_type'   => 'required|in:PET,HDPE,LDPE,PP,PS,PVC,Other',
            'weight'         => 'required|numeric|min:0.1|max:100',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'notes'          => 'nullable|string|max:500',
        ]);

        // Store photo if uploaded
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pickup-photos', 'public');
        }

        // Create pickup record (adjust model name if different)
        $pickup = Auth::user()->pickups()->create([
            'address'       => $validated['address'],
            'latitude'      => $validated['latitude'],
            'longitude'     => $validated['longitude'],
            'schedule_time' => $validated['schedule'],
            'plastic_type'  => $validated['plastic_type'],
            'weight_kg'     => $validated['weight'],
            'photo'         => $photoPath,
            'notes'         => $validated['notes'] ?? null,
            'status'        => 'pending',
            'transaction_code' => $this->generateTransactionCode(),
        ]);

        // Calculate and award points
        $points = $this->calculatePoints($validated['weight'], $validated['plastic_type']);
        Auth::user()->increment('points', $points);

        // Clear session data
        session()->forget(['pickup_location', 'pickup_schedule']);

        return redirect()->route('pickup.invoice')
            ->with([
                'success' => true,
                'pickup'  => $pickup,
                'points'  => $points,
            ]);
    }

    /**
     * Generate unique transaction code
     */
    private function generateTransactionCode(): string
    {
        do {
            $code = 'PU' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        } while (\App\Models\Pickup::where('transaction_code', $code)->exists());

        return $code;
    }

    /**
     * Calculate points based on weight and plastic type
     */
    private function calculatePoints(float $weight, string $plasticType): int
    {
        $pointsPerKg = [
            'PET'  => 120,
            'HDPE' => 100,
            'LDPE' => 80,
            'PP'   => 90,
            'PS'   => 70,
            'PVC'  => 60,
            'Other'=> 50,
        ];

        $base = $pointsPerKg[$plasticType] ?? 70;
        $points = round($weight * $base);

        // Bonus for larger amounts
        if ($weight >= 5)  $points = (int) ($points * 1.1);
        if ($weight >= 10) $points = (int) ($points * 1.2);

        return max(10, $points); // minimum 10 points
    }

    /**
     * Optional: Redirect old /pickup/create to new flow
     */
    public function create()
    {
        return redirect()->route('pickup.location');
    }
}