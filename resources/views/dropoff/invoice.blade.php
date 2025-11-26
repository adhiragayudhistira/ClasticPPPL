@extends('layouts.app')

@section('content')
<style>
    .fixed, [class*="bottom"], [class*="nav"] { display: none !important; }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        background: #e5f0ee;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow: hidden;
    }

    .invoice-container {
        max-width: 480px;
        margin: 0 auto;
        height: 100vh;
        background: white;
        position: relative;
        z-index: 1;
        overflow-y: auto;
    }

    .invoice-header {
        background: linear-gradient(to right, #14b8a6, #0d9488);
        color: white;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .invoice-header .flex {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .invoice-header a {
        margin-right: 0.75rem;
        color: white;
        text-decoration: none;
    }

    .invoice-header svg {
        width: 24px;
        height: 24px;
    }

    .invoice-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .invoice-header p {
        color: #ccfbf1;
        font-size: 0.875rem;
    }

    .invoice-content {
        padding: 1.75rem 1.5rem 2rem 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
    }

    .card {
        background: #f8fafc;
        border-radius: 14px;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.35rem;
    }

    .label {
        color: #4a5568;
    }

    .value {
        color: #1f2933;
        font-weight: 600;
        text-align: right;
    }

    .badge-points {
        display: inline-block;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        background: #ecfdf5;
        color: #16a34a;
        font-weight: 700;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .footer-note {
        margin-top: 1rem;
        font-size: 0.8rem;
        color: #718096;
        text-align: center;
    }

    .back-btn {
        width: 100%;
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        color: #2d3748;
        padding: 0.9rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        margin-top: 1.2rem;
    }

    .back-btn:hover {
        background: #edf2f7;
    }

    @media (max-width: 480px) {
        .invoice-container { max-width: 100%; }
    }
</style>

<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <div class="flex items-center mb-2">
            <a href="{{ route('dropoff.tracker', $dropoff->id) }}" class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Drop-off Invoice</h1>
        </div>
        <p class="text-teal-100 text-sm">Summary of your latest drop-off</p>
    </div>

    <!-- Content -->
    <div class="invoice-content">
        <h2 class="section-title">Transaction Detail</h2>

        <div class="card">
            <div class="row">
                <span class="label">Transaction Code</span>
                <span class="value">{{ $dropoff->transaction_code }}</span>
            </div>
            <div class="row">
                <span class="label">Location</span>
                <span class="value">{{ $dropoff->address }}</span>
            </div>
            <div class="row">
                <span class="label">Date & Time</span>
                <span class="value">
                    {{ \Carbon\Carbon::parse($dropoff->date)->format('d M Y') }},
                    {{ $dropoff->time_slot }} WIB
                </span>
            </div>
        </div>

        <h2 class="section-title" style="margin-top: 1.2rem;">Waste Detail</h2>
        <div class="card">
            <div class="row">
                <span class="label">HDPE</span>
                <span class="value">{{ $dropoff->hdpe_weight }} Kg</span>
            </div>
            <div class="row">
                <span class="label">PVC</span>
                <span class="value">{{ $dropoff->pvc_weight }} Kg</span>
            </div>
        </div>

        <h2 class="section-title" style="margin-top: 1.2rem;">Points Earned</h2>
        <div class="card" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <div class="label">Total Points</div>
                <div class="value">{{ $dropoff->points }} pts</div>
            </div>
            <span class="badge-points">{{ $dropoff->points }} pts</span>
        </div>

        <a href="{{ url('/home') }}">
            <button class="back-btn">Back to Home</button>
        </a>

        <div class="footer-note">
            Thank you for contributing to a cleaner and greener environment 🌱
        </div>
    </div>
</div>
@endsection
