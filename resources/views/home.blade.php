@extends('layouts.app')

@section('content')
<style>
    /* MAP */
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
    
    .welcome-card {
        background: linear-gradient(to right, #14b8a6, #0d9488);
        border-radius: 0 0 24px 24px;
        padding: 1rem 1.2rem;        /* smaller */
        color: white;
        margin-bottom: 1rem;         /* smaller */
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.20);
    }

    .profile-section {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 0.75rem;      /* smaller */
    }

    .profile-pic {
        width: 55px;                 /* smaller */
        height: 55px;
        border-radius: 12px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-info h2 {
        margin: 0;
        font-size: 1.2rem;           
        font-weight: 600;
    }

    .profile-info h2 span {
        color: #ffd166;
    }

    .profile-info h2 a {
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
    }

    .points-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: white;
        color: #4a9d8f;
        padding: 0.35rem 0.9rem;     
        border-radius: 15px;
        font-weight: 700;
        font-size: 0.9rem;           
        margin-top: 0.25rem;
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