<?php

namespace App\Http\Controllers;

use App\Models\Dropoff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DropOffController extends Controller
{
    // /dropoff → boleh list history atau redirect ke first step
    public function index()
    {
        // kalau mau list:
        $dropoffs = Dropoff::where('user_id', Auth::id())->latest()->get();

        return redirect()->route('dropoff.location');
        // atau kalau belum ada view index:
        // return redirect()->route('dropoff.location');
    }

    public function create()
    {
        return redirect()->route('dropoff.location');
    }

    // STEP 1 – LOCATION
    public function location()
    {
        return view('dropoff.location');
    }

    // STEP 2 – SCHEDULE
    public function schedule(Request $request)
    {
        // nanti idealnya ambil address dari query / session
        return view('dropoff.schedule');
    }

    // STEP 3 – PLASTIC TYPE
    public function plasticType(Request $request)
    {
        // nanti idealnya ambil address + schedule dari session
        return view('dropoff.plastic_type');
    }

    // SUBMIT – SIMPAN KE DB
    public function store(Request $request)
    {
        // VALIDASI SIMPLE DULU
        $validated = $request->validate([
            'address'      => 'nullable|string|max:255',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'date'         => 'nullable|date',
            'time_slot'    => 'nullable|string|max:50',
            'hdpe_weight'  => 'nullable|numeric|min:0',
            'pvc_weight'   => 'nullable|numeric|min:0',
        ]);

        $hdpe = $validated['hdpe_weight'] ?? 0;
        $pvc  = $validated['pvc_weight'] ?? 0;
        $totalWeight = $hdpe + $pvc;

        if ($totalWeight <= 0) {
            return back()->withErrors('Isi minimal salah satu berat plastik, bro 😅');
        }

        // hitung poin simple: 100 poin/kg HDPE, 80 poin/kg PVC
        $points = $this->calculatePoints($hdpe, $pvc);

        // SIMPAN KE DB TANPA RELASI USER
        $dropoff = Dropoff::create([
            'user_id'        => Auth::id(), // ga perlu relasi di User.php
            'transaction_code' => $this->generateTransactionCode(),
            'address'        => $validated['address'] ?? null,
            'latitude'       => $validated['latitude'] ?? null,
            'longitude'      => $validated['longitude'] ?? null,
            'date'           => $validated['date'] ?? now()->toDateString(),
            'time_slot'      => $validated['time_slot'] ?? '08:00 - 10:00',
            'hdpe_weight'    => $hdpe,
            'pvc_weight'     => $pvc,
            'points'         => $points,
            'status'         => 'processed',
        ]);

        // NOTE: ga usah increment ke users.points dulu, biar aman

        // HABIS SIMPAN → KE TRACKER
        return redirect()->route('dropoff.tracker', $dropoff->id);
    }

    // TRACKER PAGE
    public function tracker($id)
    {
        $dropoff = Dropoff::findOrFail($id);

        return view('dropoff.tracker', compact('dropoff'));
    }

    // INVOICE PAGE
    public function invoice($id)
    {
        $dropoff = Dropoff::findOrFail($id);

        return view('dropoff.invoice', compact('dropoff'));
    }

    // ===== HELPER: KODE TRANSAKSI & POINTS =====

    private function generateTransactionCode(): string
    {
        do {
            $code = 'DO' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        } while (Dropoff::where('transaction_code', $code)->exists());

        return $code;
    }

    private function calculatePoints(float $hdpe, float $pvc): int
    {
        $points = ($hdpe * 100) + ($pvc * 80);
        return max(10, (int) round($points));
    }
}
