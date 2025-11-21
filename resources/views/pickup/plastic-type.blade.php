@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f0f9f7;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .plastic-container {
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        background: white;
    }

    /* Header */
    .plastic-header {
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

    .plastic-header h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Content */
    .plastic-content {
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

    /* Schedule Box (read-only) */
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

    .time-display {
        color: #4a5568;
        font-size: 0.95rem;
    }

    .day-code {
        font-weight: 600;
        color: #7dd3c0;
        font-size: 0.9rem;
    }

    /* Plastic Type Section */
    .plastic-type-box {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .plastic-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .plastic-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .plastic-option input[type="radio"] {
        width: 20px;
        height: 20px;
        accent-color: #7dd3c0;
        cursor: pointer;
    }

    .plastic-option label {
        cursor: pointer;
        color: #2d3748;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Weight Input */
    .weight-input-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .weight-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
    }

    .weight-btn {
        width: 40px;
        height: 40px;
        background: #7dd3c0;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }

    .weight-btn:hover {
        background: #5eb3a6;
    }

    .weight-display {
        flex: 1;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }

    /* Photo Upload */
    .photo-upload {
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .photo-upload:hover {
        border-color: #7dd3c0;
        background: #f7fafc;
    }

    .photo-upload input {
        display: none;
    }

    .photo-upload-icon {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        color: #7dd3c0;
    }

    .photo-upload-text {
        color: #4a5568;
        font-size: 0.9rem;
    }

    .photo-preview {
        margin-top: 1rem;
        max-width: 100%;
        border-radius: 8px;
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
        .plastic-container {
            max-width: 100%;
        }
    }
</style>

<div class="plastic-container">
    <!-- Header -->
    <div class="plastic-header">
        <button class="back-btn" onclick="window.history.back()">
            ←
        </button>
        <h1>Order</h1>
    </div>

    <!-- Content -->
    <div class="plastic-content">
        <!-- Schedule Section (Read-only) -->
        <h2 class="section-title">Schedule</h2>
        <p class="section-subtitle">Determine your pick up schedule</p>

        <div class="schedule-box">
            <div class="schedule-grid">
                <div class="day-label">Today</div>
                <div class="time-display" id="selectedTime">08:00 - 10:00</div>
                <div class="day-code">WIB</div>
            </div>
        </div>

        <!-- Plastic Type Section -->
        <h2 class="section-title">Plastic Type</h2>
        <p class="section-subtitle">Determine your type of plastic</p>

        <div class="plastic-type-box">
            <div class="plastic-options">
                <div class="plastic-option">
                    <input type="radio" id="pvc" name="plastic" value="PVC">
                    <label for="pvc">PVC</label>
                </div>
                <div class="plastic-option">
                    <input type="radio" id="hdpe" name="plastic" value="HDPE">
                    <label for="hdpe">HDPE</label>
                </div>
                <div class="plastic-option">
                    <input type="radio" id="prbe" name="plastic" value="PRBE">
                    <label for="prbe">PRBE</label>
                </div>
            </div>

            <!-- Weight Input -->
            <div class="weight-input-container">
                <div class="weight-controls">
                    <button class="weight-btn" id="decreaseWeight">-</button>
                    <div class="weight-display" id="weightDisplay">0.0 Kg</div>
                    <button class="weight-btn" id="increaseWeight">+</button>
                </div>
            </div>

            <!-- Photo Upload -->
            <div class="photo-upload" id="photoUploadArea">
                <input type="file" id="photoInput" accept="image/*">
                <div class="photo-upload-icon">📷</div>
                <div class="photo-upload-text">Upload photo of plastic waste</div>
                <img id="photoPreview" class="photo-preview" style="display: none;">
            </div>
        </div>

        <button class="confirm-btn" id="confirmBtn" disabled>Confirm</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let weight = 0.0;
        let selectedPlastic = null;
        let photoUploaded = false;

        // Load schedule from session
        const schedule = sessionStorage.getItem('pickupSchedule');
        if (schedule) {
            document.getElementById('selectedTime').textContent = schedule;
        }

        // Weight controls
        document.getElementById('increaseWeight').addEventListener('click', function() {
            weight += 0.1;
            updateWeight();
        });

        document.getElementById('decreaseWeight').addEventListener('click', function() {
            if (weight > 0) {
                weight -= 0.1;
                updateWeight();
            }
        });

        function updateWeight() {
            document.getElementById('weightDisplay').textContent = weight.toFixed(1) + ' Kg';
            checkFormValidity();
        }

        // Plastic type selection
        const plasticRadios = document.querySelectorAll('input[name="plastic"]');
        plasticRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                selectedPlastic = this.value;
                checkFormValidity();
            });
        });

        // Photo upload
        const photoUploadArea = document.getElementById('photoUploadArea');
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');

        photoUploadArea.addEventListener('click', function() {
            photoInput.click();
        });

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                    photoUploaded = true;
                    checkFormValidity();
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        function checkFormValidity() {
            const confirmBtn = document.getElementById('confirmBtn');
            if (selectedPlastic && weight > 0 && photoUploaded) {
                confirmBtn.disabled = false;
            } else {
                confirmBtn.disabled = true;
            }
        }

        // Confirm button
        document.getElementById('confirmBtn').addEventListener('click', function() {
            const orderData = {
                location: JSON.parse(sessionStorage.getItem('pickupLocation')),
                schedule: sessionStorage.getItem('pickupSchedule'),
                plasticType: selectedPlastic,
                weight: weight,
                photo: photoPreview.src
            };

            sessionStorage.setItem('orderData', JSON.stringify(orderData));
            window.location.href = '/pickup/driver-navigation';
        });
    });
</script>
@endsection