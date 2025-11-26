@extends('layouts.app')

@section('content')
<style>
    /* Sembunyiin bottom nav */
    .fixed, [class*="bottom"], [class*="nav"] { display: none !important; }

    /* Body dikunci 1 layar, gak bisa scroll */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        background: #e5f0ee; /* abu-abu kehijauan, sama kayak schedule */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow: hidden;
    }

    /* Card putih di tengah, yang boleh scroll */
    .plastic-container {
        max-width: 480px;
        margin: 0 auto;
        height: 100vh;
        background: white;
        position: relative;
        z-index: 1;
        overflow-y: auto;
    }

    .plastic-header {
        background: linear-gradient(to right, #14b8a6, #0d9488);
        color: white;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .plastic-header .flex {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .plastic-header a {
        margin-right: 0.75rem;
        color: white;
        text-decoration: none;
    }

    .plastic-header svg {
        width: 24px;
        height: 24px;
    }

    .plastic-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .plastic-header p {
        color: #ccfbf1;
        font-size: 0.875rem;
    }

    .plastic-content {
        padding: 1.5rem 1.5rem 1.75rem 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .section-subtitle {
        color: #7dd3c0;
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
    }

    .summary-card {
        background: #f0f9f7;
        border-radius: 14px;
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
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

    .plastic-card {
        background: white;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        padding: 1rem 1.1rem;
        margin-bottom: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
    }

    .plastic-info {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .plastic-name {
        font-weight: 600;
        color: #2d3748;
    }

    .plastic-desc {
        font-size: 0.85rem;
        color: #718096;
    }

    .plastic-type-tag {
        display: inline-block;
        font-size: 0.75rem;
        padding: 0.1rem 0.5rem;
        border-radius: 999px;
        background: #e6fffa;
        color: #0d9488;
        font-weight: 600;
        margin-top: 0.1rem;
    }

    .weight-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .weight-btn {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        background: #f7fafc;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.2rem;
        cursor: pointer;
    }

    .weight-display {
        min-width: 60px;
        text-align: center;
        font-weight: 600;
        color: #2d3748;
    }

    .weight-unit {
        font-size: 0.85rem;
        color: #718096;
    }

    .confirm-btn {
        width: 100%;
        background: linear-gradient(to right, #14b8a6, #0d9488);
        color: white;
        border: none;
        padding: 0.9rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 1rem;
    }

    .confirm-btn:hover { opacity: 0.9; transform: translateY(-2px); }
    .confirm-btn:disabled { background: #99f6e4; cursor: not-allowed; }

    .error-text {
        color: #e53e3e;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    @media (max-width: 480px) {
        .plastic-container { max-width: 100%; }
    }
</style>

<div class="plastic-container">
    <!-- Header -->
    <div class="plastic-header">
        <div class="flex items-center mb-2">
            <a href="javascript:history.back()" class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Drop-off Order</h1>
        </div>
        <p class="text-teal-100 text-sm">Input your plastic type and weight</p>
    </div>

    <!-- Content -->
    <div class="plastic-content">
        <h2 class="section-title">Plastic Type</h2>
        <p class="section-subtitle">We use this to calculate your points</p>

        <!-- Summary location + schedule -->
        <div class="summary-card">
            <div class="summary-row">
                <span class="summary-label">Location</span>
                <span class="summary-value" id="summaryLocation">-</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Schedule</span>
                <span class="summary-value" id="summarySchedule">-</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="error-text">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('dropoff.store') }}" method="POST" id="plasticForm">
            @csrf

            {{-- hidden fields untuk dikirim ke controller --}}
            <input type="hidden" name="address" id="inputAddress">
            <input type="hidden" name="latitude" id="inputLatitude">
            <input type="hidden" name="longitude" id="inputLongitude">
            <input type="hidden" name="date" id="inputDate" value="{{ now()->toDateString() }}">
            <input type="hidden" name="time_slot" id="inputTimeSlot">

            {{-- HDPE --}}
            <div class="plastic-card">
                <div class="plastic-info">
                    <div class="plastic-name">HDPE</div>
                    <div class="plastic-desc">High-density plastic, usually bottles & containers.</div>
                    <span class="plastic-type-tag">Type 2</span>
                </div>
                <div class="weight-control" data-type="hdpe">
                    <button type="button" class="weight-btn" data-action="minus">-</button>
                    <div class="weight-display">
                        <span class="weight-value" id="hdpeValue">0.0</span>
                        <span class="weight-unit">Kg</span>
                    </div>
                    <button type="button" class="weight-btn" data-action="plus">+</button>
                    <input type="hidden" name="hdpe_weight" id="hdpeInput" value="0">
                </div>
            </div>

            {{-- PVC --}}
            <div class="plastic-card">
                <div class="plastic-info">
                    <div class="plastic-name">PVC</div>
                    <div class="plastic-desc">Polyvinyl chloride, pipes and thicker plastic items.</div>
                    <span class="plastic-type-tag">Type 3</span>
                </div>
                <div class="weight-control" data-type="pvc">
                    <button type="button" class="weight-btn" data-action="minus">-</button>
                    <div class="weight-display">
                        <span class="weight-value" id="pvcValue">0.0</span>
                        <span class="weight-unit">Kg</span>
                    </div>
                    <button type="button" class="weight-btn" data-action="plus">+</button>
                    <input type="hidden" name="pvc_weight" id="pvcInput" value="0">
                </div>
            </div>

            <button type="submit" class="confirm-btn" id="confirmBtn" disabled>
                Confirm Drop-off
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ambil data dari sessionStorage
        const locRaw = sessionStorage.getItem('dropoffLocation');
        const schedule = sessionStorage.getItem('dropoffSchedule');

        const summaryLocation = document.getElementById('summaryLocation');
        const summarySchedule = document.getElementById('summarySchedule');

        const inputAddress = document.getElementById('inputAddress');
        const inputLatitude = document.getElementById('inputLatitude');
        const inputLongitude = document.getElementById('inputLongitude');
        const inputTimeSlot = document.getElementById('inputTimeSlot');

        if (locRaw) {
            try {
                const loc = JSON.parse(locRaw);
                summaryLocation.textContent = loc.address || 'Selected location';
                inputAddress.value = loc.address || 'Selected location';
                inputLatitude.value = loc.lat || '';
                inputLongitude.value = loc.lng || '';
            } catch (e) {
                summaryLocation.textContent = '-';
            }
        } else {
            summaryLocation.textContent = '-';
        }

        if (schedule) {
            summarySchedule.textContent = schedule.replace('-', ' - ');
            inputTimeSlot.value = schedule.replace('-', ' - ');
        } else {
            summarySchedule.textContent = '-';
        }

        // control +/- weight
        const step = 0.1;
        const maxKg = 100;

        function setupWeightControl(type) {
            const wrapper = document.querySelector(`.weight-control[data-type="${type}"]`);
            const minusBtn = wrapper.querySelector('[data-action="minus"]');
            const plusBtn = wrapper.querySelector('[data-action="plus"]');
            const valueSpan = wrapper.querySelector('.weight-value');
            const hiddenInput = document.getElementById(type + 'Input');
            const confirmBtn = document.getElementById('confirmBtn');

            function getCurrent() {
                return parseFloat(hiddenInput.value) || 0;
            }

            function setCurrent(val) {
                const clean = Math.max(0, Math.min(maxKg, val));
                hiddenInput.value = clean.toFixed(1);
                valueSpan.textContent = clean.toFixed(1);
                checkTotal();
            }

            minusBtn.addEventListener('click', function () {
                setCurrent(getCurrent() - step);
            });

            plusBtn.addEventListener('click', function () {
                setCurrent(getCurrent() + step);
            });

            function checkTotal() {
                const hdpe = parseFloat(document.getElementById('hdpeInput').value) || 0;
                const pvc = parseFloat(document.getElementById('pvcInput').value) || 0;
                confirmBtn.disabled = (hdpe + pvc) <= 0;
            }

            checkTotal();
        }

        setupWeightControl('hdpe');
        setupWeightControl('pvc');
    });
</script>
@endsection
