@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f0f9f7;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navigation-container {
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        background: white;
    }

    /* Header */
    .navigation-header {
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

    .navigation-header h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Content */
    .navigation-content {
        padding: 1.5rem;
    }

    /* Map Section */
    .map-section {
        margin-bottom: 1.5rem;
    }

    .map-section h2 {
        font-size: 1.1rem;
        color: #2d3748;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .map-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        height: 200px;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    /* Driver Details */
    .driver-section {
        margin-bottom: 1.5rem;
    }

    .driver-section h2 {
        font-size: 1.1rem;
        color: #2d3748;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .driver-card {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .driver-info {
        flex: 1;
    }

    .driver-info-row {
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .driver-info-row:last-child {
        margin-bottom: 0;
    }

    .driver-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
    }

    .driver-avatar {
        width: 60px;
        height: 60px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .chat-btn {
        background: #7dd3c0;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .chat-btn:hover {
        background: #5eb3a6;
    }

    /* Transaction Details */
    .transaction-section {
        margin-bottom: 1.5rem;
    }

    .transaction-section h2 {
        font-size: 1.1rem;
        color: #2d3748;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .transaction-card {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
    }

    .transaction-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .transaction-row:last-child {
        margin-bottom: 0;
    }

    .transaction-label {
        color: #4a5568;
    }

    .transaction-value {
        color: #2d3748;
        font-weight: 500;
        text-align: right;
    }

    /* View Invoice Button */
    .invoice-btn {
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
        margin-top: 1.5rem;
    }

    .invoice-btn:hover {
        background: #5eb3a6;
    }

    @media (max-width: 480px) {
        .navigation-container {
            max-width: 100%;
        }
    }
</style>

<div class="navigation-container">
    <!-- Header -->
    <div class="navigation-header">
        <button class="back-btn" onclick="window.location.href='/'">
            ←
        </button>
        <h1>Order</h1>
    </div>

    <!-- Content -->
    <div class="navigation-content">
        <!-- Driver Navigation -->
        <div class="map-section">
            <h2>Driver Navigation</h2>
            <div class="map-container">
                <div id="map"></div>
            </div>
        </div>

        <!-- Driver Details -->
        <div class="driver-section">
            <h2>Driver Details</h2>
            <div class="driver-card">
                <div class="driver-info">
                    <div class="driver-info-row">
                        <strong>Name:</strong> Oleksandr Usyk
                    </div>
                    <div class="driver-info-row">
                        <strong>Service:</strong> 3 Years
                    </div>
                    <div class="driver-info-row">
                        <strong>Ratings:</strong> 5.0 ⭐
                    </div>
                </div>
                <div class="driver-actions">
                    <div class="driver-avatar">👤</div>
                    <button class="chat-btn">Chat</button>
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="transaction-section">
            <h2>Transaction Details</h2>
            <div class="transaction-card">
                <div class="transaction-row">
                    <span class="transaction-label">Transaction Code</span>
                    <span class="transaction-value" id="transactionCode">AHXG87651</span>
                </div>
                <div class="transaction-row">
                    <span class="transaction-label">Location</span>
                    <span class="transaction-value" id="transactionLocation">Kos Bu Yuni 4<br><small>Jl. Jalan No.4, Mulyorejo, Kec. Mulyorejo, Kota Surabaya, Jawa Timur 11210</small></span>
                </div>
                <div class="transaction-row">
                    <span class="transaction-label">Time</span>
                    <span class="transaction-value" id="transactionTime">12 Dec 2024, 13:00-14:00 WIB</span>
                </div>
            </div>
        </div>

        <!-- View Invoice Button -->
        <button class="invoice-btn" onclick="window.location.href='/pickup/invoice'">
            View Invoice
        </button>
    </div>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map with route
        const map = L.map('map').setView([-7.2700, 112.7800], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Driver starting point
        const driverStart = [-7.2650, 112.7750];
        // Customer location
        const customerLocation = [-7.2750, 112.7850];

        // Draw route line
        const routeLine = L.polyline([driverStart, customerLocation], {
            color: '#4a5cb8',
            weight: 4,
            opacity: 0.7
        }).addTo(map);

        // Add markers
        const driverIcon = L.divIcon({
            html: '<div style="font-size: 24px;">🚚</div>',
            className: 'driver-marker',
            iconSize: [30, 30]
        });

        const customerIcon = L.divIcon({
            html: '<div style="font-size: 24px;">📍</div>',
            className: 'customer-marker',
            iconSize: [30, 30]
        });

        L.marker(driverStart, { icon: driverIcon }).addTo(map)
            .bindPopup('Driver Location');
        
        L.marker(customerLocation, { icon: customerIcon }).addTo(map)
            .bindPopup('Your Location');

        // Fit map to show route
        map.fitBounds(routeLine.getBounds(), { padding: [50, 50] });

        // Load order data
        const orderData = JSON.parse(sessionStorage.getItem('orderData'));
        if (orderData) {
            // Update transaction details with actual data
            const today = new Date();
            const dateStr = today.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            document.getElementById('transactionTime').textContent = `${dateStr}, ${orderData.schedule} WIB`;
        }
    });
</script>
@endsection