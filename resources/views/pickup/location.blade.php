@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f0f9f7;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .location-container {
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        background: white;
        display: flex;
        flex-direction: column;
    }

    /* Header */
    .location-header {
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

    .location-header h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Search Section */
    .search-section {
        padding: 1.5rem;
        background: white;
        border-bottom: 1px solid #e2e8f0;
    }

    .search-container {
        position: relative;
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .search-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e0;
        border-radius: 8px;
        font-size: 0.95rem;
        outline: none;
    }

    .search-input:focus {
        border-color: #7dd3c0;
    }

    .location-btn {
        background: white;
        border: 1px solid #cbd5e0;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .location-btn svg {
        width: 24px;
        height: 24px;
    }

    /* Suggestions Dropdown */
    .suggestions-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 50px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-top: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 10;
        display: none;
    }

    .suggestions-dropdown.active {
        display: block;
    }

    .suggestion-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f7fafc;
    }

    .suggestion-item:hover {
        background: #f7fafc;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    /* Map Section */
    .map-section {
        flex: 1;
        position: relative;
    }

    #map {
        width: 100%;
        height: 100%;
        min-height: 400px;
    }

    /* Bottom Section */
    .bottom-section {
        padding: 1.5rem;
        background: white;
        border-top: 1px solid #e2e8f0;
    }

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
    }

    .confirm-btn:hover {
        background: #5eb3a6;
    }

    .confirm-btn:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
    }

    @media (max-width: 480px) {
        .location-container {
            max-width: 100%;
        }
    }
</style>

<div class="location-container">
    <!-- Header -->
    <div class="location-header">
        <button class="back-btn" onclick="window.location.href='/'">
            ←
        </button>
        <h1>Location</h1>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <div class="search-container">
            <input 
                type="text" 
                class="search-input" 
                id="addressInput"
                placeholder="Enter Address"
                autocomplete="off"
            >
            <button class="location-btn" id="currentLocationBtn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" stroke-width="2"/>
                </svg>
            </button>
            <div class="suggestions-dropdown" id="suggestionsDropdown"></div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
        <div id="map"></div>
    </div>

    <!-- Bottom Section -->
    <div class="bottom-section">
        <button class="confirm-btn" id="confirmBtn" disabled>Confirm Location</button>
    </div>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map, marker;
    let selectedLocation = null;
    const surabayaCoords = [-7.2575, 112.7521];

    // Sample suggestions for Surabaya
    const suggestions = [
        { name: 'Jl. Kertajaya, Surabaya', lat: -7.2819, lng: 112.7908 },
        { name: 'Jl. Keputih, Surabaya', lat: -7.2916, lng: 112.7957 },
        { name: 'Jl. Dharmawangsa, Surabaya', lat: -7.2845, lng: 112.7387 },
        { name: 'Jl. Raya Darmo, Surabaya', lat: -7.2840, lng: 112.7324 },
        { name: 'Tunjungan Plaza, Surabaya', lat: -7.2636, lng: 112.7384 }
    ];

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize map
        map = L.map('map').setView(surabayaCoords, 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Initialize marker (red pin)
        const redIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        marker = L.marker(surabayaCoords, { 
            icon: redIcon,
            draggable: true 
        }).addTo(map);

        // Update location when marker is dragged
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            updateLocation(position.lat, position.lng);
        });

        // Click on map to place marker
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateLocation(e.latlng.lat, e.latlng.lng);
        });

        // Initial location
        updateLocation(surabayaCoords[0], surabayaCoords[1]);

        // Search input
        const addressInput = document.getElementById('addressInput');
        const suggestionsDropdown = document.getElementById('suggestionsDropdown');

        addressInput.addEventListener('input', function(e) {
            const value = e.target.value.toLowerCase();
            if (value.length > 0) {
                const filtered = suggestions.filter(s => 
                    s.name.toLowerCase().includes(value)
                );
                
                if (filtered.length > 0) {
                    suggestionsDropdown.innerHTML = filtered.map(s => 
                        `<div class="suggestion-item" data-lat="${s.lat}" data-lng="${s.lng}">${s.name}</div>`
                    ).join('');
                    suggestionsDropdown.classList.add('active');
                } else {
                    suggestionsDropdown.classList.remove('active');
                }
            } else {
                suggestionsDropdown.classList.remove('active');
            }
        });

        // Handle suggestion click
        suggestionsDropdown.addEventListener('click', function(e) {
            if (e.target.classList.contains('suggestion-item')) {
                const lat = parseFloat(e.target.dataset.lat);
                const lng = parseFloat(e.target.dataset.lng);
                addressInput.value = e.target.textContent;
                suggestionsDropdown.classList.remove('active');
                
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
                updateLocation(lat, lng);
            }
        });

        // Current location button
        document.getElementById('currentLocationBtn').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                    marker.setLatLng([lat, lng]);
                    updateLocation(lat, lng);
                }, function() {
                    alert('Unable to get your location');
                });
            } else {
                alert('Geolocation is not supported by your browser');
            }
        });

        // Confirm button
        document.getElementById('confirmBtn').addEventListener('click', function() {
            if (selectedLocation) {
                // Store location in session/localStorage
                sessionStorage.setItem('pickupLocation', JSON.stringify(selectedLocation));
                // Redirect to schedule page
                window.location.href = '{{ route('pickup.schedule') }}';
            }
        });
    });

    function updateLocation(lat, lng) {
        selectedLocation = { lat, lng, address: document.getElementById('addressInput').value };
        document.getElementById('confirmBtn').disabled = false;
    }
</script>
@endsection