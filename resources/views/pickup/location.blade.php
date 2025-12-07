<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup Location - Clastic</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f9f7;
            height: 100vh;                 /* Full screen */
            overflow: hidden;              /* Prevent scrolling */
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .location-container {
            max-width: 480px;
            margin: 0 auto;
            height: 100vh;                 /* Full height */
            background: white;
            display: flex;
            flex-direction: column;
            overflow: hidden;              /* Prevent inner scrolling */
        }

        /* Header */
        .header-gradient {
            background: linear-gradient(to right, #14b8a6, #0d9488);
            color: white;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            flex-shrink: 0;                /* Keep fixed height */
        }

        .header-gradient .flex {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;        /* Make consistent height */
        }

        .header-gradient a {
            display: flex;
            align-items: center;
            margin-right: 0.75rem;
            color: white;
            text-decoration: none;
        }

        /* Search Section */
        .search-section {
            padding: 1.25rem 1.5rem;
            background: white;
            z-index: 999;
            flex-shrink: 0;                /* Fixed */
        }

        .search-container { display: flex; gap: 0.75rem; }
        .input-wrapper { flex: 1; position: relative; }

        .search-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            outline: none;
            transition: .3s;
            background: white;
            color: #2d3748;
        }

        /* Suggestions Dropdown */
        .suggestions-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            max-height: 250px;
            overflow-y: auto;
            z-index: 1001;
            display: none;
        }

        .suggestions-dropdown.active { display: block; }

        .suggestion-item {
            padding: 1rem 1.25rem;
            cursor: pointer;
            border-bottom: 1px solid #f7fafc;
        }

        /* MAP SECTION — fills remaining height */
        .map-section {
            padding: 0 1.5rem 1rem 1.5rem;
            flex: 1;                        /* TAKE ALL REMAINING VERTICAL SPACE */
            display: flex;
        }

        .map-container {
            width: 100%;
            height: 100%;                   /* FIT REMAINING HEIGHT */
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            position: relative;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* Move Leaflet zoom controls to right side */
        .leaflet-control-zoom {
            margin-right: 10px !important;
            margin-left: auto !important;
        }

        .leaflet-left {
            left: auto !important;
            right: 0 !important;
        }

        /* Bottom Section */
        .bottom-section {
            padding: 1rem 1.5rem 1.5rem;
            background: white;
            flex-shrink: 0;                 /* Fixed height */
        }

        .selected-location {
            margin-bottom: 0.75rem;
            padding: 0.875rem 1rem;
            background: #f0f9f7;
            border-radius: 12px;
            display: none;
        }

        .selected-location.active { display: block; }

        .confirm-btn {
            width: 100%;
            background: linear-gradient(to right, #14b8a6, #0d9488);
            color: white;
            border: none;
            padding: 1.1rem;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="location-container">

        <!-- Header -->
        <div class="header-gradient">
            <div class="flex items-center mb-2">
                <a href="javascript:history.back()" class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">Set Your Location</h1>
            </div>
            <p class="text-teal-100 text-sm">Choose your pickup point for plastic collection</p>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <div class="input-wrapper">
                    <input 
                        type="text"
                        class="search-input"
                        id="addressInput"
                        placeholder="Enter Address"
                        autocomplete="off"
                    >
                    <div class="suggestions-dropdown" id="suggestionsDropdown"></div>
                </div>
                <button class="location-btn" id="currentLocationBtn">📍</button>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <div class="map-container" id="mapContainer">
                <div id="map"></div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-section">
            <div class="selected-location" id="selectedLocation">
                <div class="label">Selected Location:</div>
                <div class="address" id="selectedAddress">-</div>
            </div>
            <button class="confirm-btn" id="confirmBtn" disabled>Confirm Location</button>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, marker;
        let selectedLocation = null;

        const defaultCoords = [-7.2575, 112.7521];
        const addressInput = document.getElementById("addressInput");
        const suggestionsDropdown = document.getElementById("suggestionsDropdown");

        const suggestions = [
            { name: 'Jl. Kertajaya, Surabaya', lat: -7.2819, lng: 112.7908 },
            { name: 'Jl. Keputih, Surabaya', lat: -7.2916, lng: 112.7957 },
            { name: 'Jl. Dharmawangsa, Surabaya', lat: -7.2845, lng: 112.7387 },
            { name: 'Jl. Raya Darmo, Surabaya', lat: -7.2840, lng: 112.7324 },
            { name: 'Tunjungan Plaza, Surabaya', lat: -7.2636, lng: 112.7384 },
            { name: 'Kampus ITS Sukolilo, Surabaya', lat: -7.2820, lng: 112.7948 },
            { name: 'Galaxy Mall, Surabaya', lat: -7.3208, lng: 112.7305 }
        ];

        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("confirmBtn").addEventListener("click", function () {
                if (selectedLocation) {
                    sessionStorage.setItem("pickupLocation", JSON.stringify(selectedLocation));
                    window.location.href = "/pickup/schedule";
                }
            });

            map = L.map("map").setView(defaultCoords, 13);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);
            marker = L.marker(defaultCoords, { draggable: true }).addTo(map);

            marker.on("dragend", () => {
                const pos = marker.getLatLng();
                updateLocation(pos.lat, pos.lng, "Selected location");
            });

            map.on("click", (e) => {
                marker.setLatLng(e.latlng);
                updateLocation(e.latlng.lat, e.latlng.lng, "Selected location");
            });

            updateLocation(defaultCoords[0], defaultCoords[1], "Surabaya, East Java");

            addressInput.addEventListener('input', handleSearch);
            addressInput.addEventListener('focus', handleSearch);

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.input-wrapper')) {
                    suggestionsDropdown.classList.remove('active');
                }
            });
        });

        function handleSearch() {
            const query = addressInput.value.toLowerCase().trim();
            const filtered = suggestions.filter(item =>
                item.name.toLowerCase().includes(query)
            );
            renderSuggestions(filtered);
        }

        function renderSuggestions(list) {
            suggestionsDropdown.innerHTML = '';

            if (!list.length) {
                suggestionsDropdown.classList.remove('active');
                return;
            }

            list.forEach(item => {
                const div = document.createElement('div');
                div.className = 'suggestion-item';
                div.textContent = item.name;
                div.addEventListener('click', () => {
                    addressInput.value = item.name;
                    map.setView([item.lat, item.lng], 15);
                    marker.setLatLng([item.lat, item.lng]);
                    updateLocation(item.lat, item.lng, item.name);
                    suggestionsDropdown.classList.remove('active');
                });
                suggestionsDropdown.appendChild(div);
            });

            suggestionsDropdown.classList.add('active');
        }

        function updateLocation(lat, lng, address) {
            selectedLocation = { lat, lng, address };
            document.getElementById("selectedAddress").innerText = address;
            document.getElementById("selectedLocation").classList.add("active");
            document.getElementById("confirmBtn").disabled = false;
        }
    </script>
</body>
</html>