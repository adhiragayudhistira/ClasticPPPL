@extends('layouts.app')

@section('content')
<style>
    /* MAP FIX - Prevent overlap with bottom nav */
    .map-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        height: 250px;
        position: relative;
        z-index: 1;
    }

    #map {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 1;
    }

    /* Make sure bottom nav stays on top */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        max-width: 480px;
        width: 100%;
        background: linear-gradient(to right, #14b8a6, #0d9488);
        display: flex;
        justify-content: space-around;
        border-radius: 30px 30px 0 0;
        box-shadow: 0 -4px 20px rgba(20, 184, 166, 0.3);
        z-index: 100;
    }

    /* Add padding to content so it doesn't hide behind nav */
    .content-section {
        padding: 0 1.5rem 6rem 1.5rem;
        background: white;
    }
</style>

<div class="welcome-card">
    <div class="profile-section">
        <div class="profile-pic">
            👤
        </div>

        <div class="profile-info">
            <h2>
                Hi, <a href="{{ route('profile') }}">
                    <span>{{ explode(' ', Auth::user()->name)[0] }}</span>
                </a>!
            </h2>

            <div class="points-badge">
                <span style="font-size: 0.9rem;">2500</span>
                <span style="font-size: 0.9rem;">PTS</span>
            </div>
        </div>
    </div>

    <p class="mission-text">
        Want to get more points? Complete your mission and streak!
    </p>

    <!-- Streak Calendar -->
    <div class="streak-calendar">
        @for($i = 6; $i >= 0; $i--)
            @php $date = now()->subDays($i); @endphp
            <a href="{{ route('streak') }}" 
               class="day-box {{ $date->isToday() ? 'active' : '' }}">
                <div class="day-name">{{ $date->format('D') }}</div>
                <div>{{ $date->format('d') }}</div>
            </a>
        @endfor
    </div>
</div>


<div class="content-section">
    <!-- Fun Fact -->
    <div class="fun-fact">
        <h3>Today's Fun Fact! 🤓</h3>
        <p>{{ $todaysFunFact }}</p>
    </div>

    <!-- Call to Action -->
    <div class="cta-section">
        <h2>Let's Recycle Now! ♻️</h2>
        <p>Your contribution means a lot to the world</p>
    </div>

    <!-- Map -->
    <div class="map-container">
        <div id="map"></div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('pickup.create') }}" class="action-btn pickup">
            <div class="emoji">🚚</div>
            <div>Pick-Up</div>
        </a>

        <a href="/dropoff" class="action-btn dropoff">
            <div class="emoji">📍</div>
            <div>Drop-Off Point</div>
        </a>
    </div>

    <!-- News Section -->
    <div class="news-section">
        <h3>News & Article 📚</h3>

        <a href="/articles" style="text-decoration: none;">
            <div class="news-card">
                <div class="news-image"></div>
                <div class="news-content">
                    <span>Increase your insight here</span>
                    <span>→</span>
                </div>
            </div>
        </a>

    </div>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" 
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([-7.2575, 112.7521], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    L.marker([-7.2575, 112.7521]).addTo(map)
        .bindPopup('Clastic Drop Point - Surabaya')
        .openPopup();
});
</script>

@endsection