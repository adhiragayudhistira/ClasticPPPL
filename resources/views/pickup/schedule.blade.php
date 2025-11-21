@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f0f9f7;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .schedule-container {
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        background: white;
    }

    /* Header */
    .schedule-header {
        background: #7dd3c0;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: white;
    }

    .back-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .schedule-header h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Content */
    .schedule-content {
        padding: 2rem 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        color: #7dd3c0;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    /* Schedule Box */
    .schedule-box {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1rem;
        align-items: center;
    }

    .day-label {
        font-weight: 600;
        color: #2d3748;
    }

    .time-slots {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .time-slot {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .time-slot input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #7dd3c0;
        cursor: pointer;
    }

    .time-slot label {
        cursor: pointer;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .day-code {
        font-weight: 600;
        color: #7dd3c0;
        font-size: 0.9rem;
    }

    /* Confirm Button */
    .confirm-btn {
        width: 100%;
        background: #7dd3c0;
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 2rem;
    }

    .confirm-btn:hover {
        background: #5eb3a6;
    }

    .confirm-btn:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
    }

    @media (max-width: 480px) {
        .schedule-container {
            max-width: 100%;
        }
    }
</style>

<div class="schedule-container">
    <!-- Header -->
    <div class="schedule-header">
        <button class="back-btn" onclick="window.history.back()">
            ←
        </button>
        <h1>Order</h1>
    </div>

    <!-- Content -->
    <div class="schedule-content">
        <h2 class="section-title">Schedule</h2>
        <p class="section-subtitle">Determine your pick up schedule</p>

        <div class="schedule-box">
            <div class="schedule-grid">
                <div class="day-label">Today</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <input type="radio" id="time1" name="schedule" value="08:00-10:00">
                        <label for="time1">08:00 - 10:00</label>
                    </div>
                    <div class="time-slot">
                        <input type="radio" id="time2" name="schedule" value="12:00-14:00">
                        <label for="time2">12:00 - 14:00</label>
                    </div>
                    <div class="time-slot">
                        <input type="radio" id="time3" name="schedule" value="16:00-20:00">
                        <label for="time3">16:00 - 20:00</label>
                    </div>
                </div>
                <div class="day-code">WIB</div>
            </div>
        </div>

        <button class="confirm-btn" id="confirmBtn" disabled>Confirm</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="schedule"]');
        const confirmBtn = document.getElementById('confirmBtn');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                confirmBtn.disabled = false;
            });
        });

        confirmBtn.addEventListener('click', function() {
            const selectedTime = document.querySelector('input[name="schedule"]:checked');
            if (selectedTime) {
                sessionStorage.setItem('pickupSchedule', selectedTime.value);
                window.location.href = '/pickup/plastic-type';
            }
        });
    });
</script>
@endsection