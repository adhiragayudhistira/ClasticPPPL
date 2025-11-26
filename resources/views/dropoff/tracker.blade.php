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

    .tracker-container {
        max-width: 480px;
        margin: 0 auto;
        height: 100vh;
        background: white;
        position: relative;
        z-index: 1;
        overflow-y: auto;
    }

    .tracker-header {
        background: linear-gradient(to right, #14b8a6, #0d9488);
        color: white;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .tracker-header .flex {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .tracker-header a {
        margin-right: 0.75rem;
        color: white;
        text-decoration: none;
    }

    .tracker-header svg {
        width: 24px;
        height: 24px;
    }

    .tracker-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .tracker-header p {
        color: #ccfbf1;
        font-size: 0.875rem;
    }

    .tracker-content {
        padding: 1.75rem 1.5rem 2rem 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
    }

    .step-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .step-indicator {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        border: 2px solid #cbd5e0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        font-weight: 600;
        background: #f7fafc;
        color: #a0aec0;
    }

    .step-indicator.active {
        background: #14b8a6;
        border-color: #0d9488;
        color: white;
    }

    .step-text-title {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
    }

    .step-text-sub {
        font-size: 0.85rem;
        color: #718096;
    }

    .summary-card {
        background: #f0f9f7;
        border-radius: 14px;
        padding: 1rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.3rem;
    }

    .summary-label {
        color: #4a5568;
    }

    .summary-value {
        font-weight: 600;
        color: #1f2933;
        text-align: right;
    }

    .invoice-btn {
        width: 100%;
        background: linear-gradient(to right, #14b8a6, #0d9488);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 0.5rem;
    }

    .invoice-btn:hover { opacity: 0.9; transform: translateY(-2px); }

    @media (max-width: 480px) {
        .tracker-container { max-width: 100%; }
    }
</style>

@php
    // simple: kalau status != processed, anggap udah accepted
    $status = $dropoff->status; // 'processed', 'accepted', 'converted'
@endphp

    <div class="tracker-container">
        <!-- Header -->
        <div class="tracker-header">
            <div class="flex items-center mb-2">
                <a href="{{ url('/home') }}" class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">Drop-off Tracker</h1>
            </div>
            <p class="text-teal-100 text-sm">Track your drop-off progress</p>
        </div>

        <!-- Content -->
        <div class="tracker-content">
            <h2 class="section-title">Progress</h2>

            <div class="step-list">
        <div class="step-item">
            <div class="step-indicator step-1">1</div>
            <div>
                <div class="step-text-title">Transaction Processed</div>
                <div class="step-text-sub">Your order has been recorded.</div>
            </div>
        </div>

        <div class="step-item">
            <div class="step-indicator step-2">2</div>
            <div>
                <div class="step-text-title">Plastic Accepted</div>
                <div class="step-text-sub">Your plastic has been received by the drop-off point.</div>
            </div>
        </div>

        <div class="step-item">
            <div class="step-indicator step-3">3</div>
            <div>
                <div class="step-text-title">Points Converted</div>
                <div class="step-text-sub">Points have been added to your account.</div>
            </div>
        </div>
    </div>


        <div class="summary-card">
            <div class="summary-row">
                <span class="summary-label">Transaction Code</span>
                <span class="summary-value">{{ $dropoff->transaction_code }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Location</span>
                <span class="summary-value">{{ $dropoff->address }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Schedule</span>
                <span class="summary-value">
                    {{ \Carbon\Carbon::parse($dropoff->date)->format('d M Y') }},
                    {{ $dropoff->time_slot }} WIB
                </span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Points</span>
                <span class="summary-value">{{ $dropoff->points }} pts</span>
            </div>
        </div>

        <div id="invoiceBtnWrapper" style="display:none;">
            <a href="{{ route('dropoff.invoice', $dropoff->id) }}">
                <button class="invoice-btn">View Drop-off Invoice</button>
            </a>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.step-indicator');
        const wrapper = document.getElementById('invoiceBtnWrapper');

        let i = 0;

        function activateNext() {
            if (i < steps.length) {
                steps[i].classList.add('active');
                i++;
                setTimeout(activateNext, 700); // delay antar step
            } else {
                wrapper.style.display = 'block';
            }
        }

        activateNext();
    });
</script>
@endsection
