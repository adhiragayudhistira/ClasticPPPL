@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f0f9f7;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .mission-container {
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        background: white;
        padding-bottom: 100px;
    }

    /* Header */
    .mission-header {
        background: #7dd3c0;
        color: #2d3748;
        padding: 1rem 1.5rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    /* Streak Section */
    .streak-section {
        text-align: center;
        padding: 2rem 1.5rem;
        background: white;
    }

    .fire-icon {
        width: 150px;
        height: 150px;
        margin: 0 auto 1.5rem;
        position: relative;
    }

    .fire-icon svg {
        width: 100%;
        height: 100%;
        fill: #f59e0b;
        filter: drop-shadow(0 4px 10px rgba(245, 158, 11, 0.3));
    }

    .streak-number {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .week-flames {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .day-flame {
        width: 50px;
        height: 50px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        z-index: 1;
    }

    .day-flame::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: #e89a3c;
        border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        transform: rotate(-45deg);
        z-index: -1;
        box-shadow: 0 2px 8px rgba(232, 154, 60, 0.3);
    }

    .streak-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .streak-message {
        color: #4a5568;
        font-size: 1rem;
        line-height: 1.5;
    }

    /* Mission Section */
    .mission-content {
        padding: 1.5rem;
        background: white;
    }

    .mission-section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
    }

    .mission-card {
        background: white;
        border: 3px solid #7dd3c0;
        border-radius: 24px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .mission-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(125, 211, 192, 0.15);
    }

    .mission-status {
        font-size: 0.8rem;
        font-weight: 600;
        color: #718096;
        margin-bottom: 0.5rem;
        text-transform: capitalize;
    }

    .mission-card.completed .mission-status {
        color: #2d3748;
    }

    .mission-card.completed {
        border-color: #7dd3c0;
        background: white;
    }

    .mission-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .mission-points {
        font-size: 0.95rem;
        font-weight: 600;
        color: #7dd3c0;
    }

    .mission-card.completed .mission-points {
        color: #7dd3c0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #718096;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Bottom Navigation */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        max-width: 480px;
        width: 100%;
        background: #4a9d8f;
        padding: 1rem;
        display: flex;
        justify-content: space-around;
        border-radius: 30px 30px 0 0;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        z-index: 100;
    }

    .nav-item {
        color: white;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .nav-item.active {
        opacity: 1;
    }

    .nav-item svg {
        width: 24px;
        height: 24px;
    }

    @media (max-width: 480px) {
        .mission-container {
            max-width: 100%;
        }
    }
</style>

<div class="mission-container">
    <!-- Header -->
    <div class="mission-header">
        Mission
    </div>

    <!-- Streak Section -->
    <div class="streak-section">
        <div class="fire-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2c1.6 1.4 3 3.2 4 5.2.8 1.6 1.4 3.3 1.7 5.1.2 1.2.2 2.4 0 3.6-.4 2.3-1.6 4.4-3.4 5.9-1.8 1.5-4.1 2.2-6.4 2.1-2.3-.1-4.5-1.1-6-2.8C.6 19.5 0 17.5 0 15.5c0-1.9.6-3.8 1.7-5.4C2.8 8.5 4.5 7 6.5 6c-.3 1.4-.3 2.9.1 4.3.4 1.4 1.2 2.7 2.3 3.7.8.7 1.7 1.3 2.7 1.6-1.1-.9-1.8-2.1-2.1-3.5-.3-1.3-.1-2.6.5-3.8.6-1.2 1.5-2.2 2.7-2.9.8 1.2 1.4 2.5 1.8 3.9.3 1.1.4 2.3.3 3.5 1.4-1.1 2.4-2.6 3-4.2.5-1.4.6-2.9.3-4.3 1.1.8 2 1.8 2.7 3 1.4 2.4 1.7 5.3.8 7.9-.9 2.6-2.8 4.7-5.3 5.9z"/>
            </svg>
            <div class="streak-number">{{ $currentStreak }}</div>
        </div>

        <div class="week-flames">
            @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $day)
                <div class="day-flame">{{ $day }}</div>
            @endforeach
        </div>

        <div class="streak-title">{{ $currentStreak }} Day Streak</div>
        <div class="streak-message">
            You're on fire. Keep it up<br>for the better world
        </div>
    </div>

    <!-- Mission List -->
    <div class="mission-content">
        <h2 class="mission-section-title">Mission</h2>

        @forelse($missions as $mission)
            <div class="mission-card {{ $mission->is_completed ? 'completed' : '' }}">
                <div class="mission-status">
                    {{ $mission->is_completed ? 'Completed' : 'Uncompleted' }}
                </div>
                <div class="mission-title">{{ $mission->title }}</div>
                <div class="mission-points">+ {{ number_format($mission->points_reward ?? 0) }} pts</div>
            </div>
        @empty
            <div class="mission-card">
                <div class="mission-status">Uncompleted</div>
                <div class="mission-title">Recycle 5 PET Plastic Waste</div>
                <div class="mission-points">+ 4,500 pts</div>
            </div>
            
            <div class="mission-card">
                <div class="mission-status">Uncompleted</div>
                <div class="mission-title">Classify 3 PP Plastic Waste</div>
                <div class="mission-points">+ 4,500 pts</div>
            </div>
            
            <div class="mission-card">
                <div class="mission-status">Uncompleted</div>
                <div class="mission-title">Drop off 10kg of plastic</div>
                <div class="mission-points">+ 5,000 pts</div>
            </div>
        @endforelse
    </div>
</div>

<!-- Bottom Navigation -->
<div class="bottom-nav">
    <a href="/" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
    </a>
    <a href="/classify" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
        </svg>
        <span>Scan</span>
    </a>
    <a href="/pickup" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke-width="2"/>
            <path d="M12 6v6l4 2" stroke-width="2"/>
        </svg>
        <span>Pickup</span>
    </a>
    <a href="/missions" class="nav-item active">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" stroke-width="2"/>
        </svg>
        <span>Mission</span>
    </a>
    <a href="/profile" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-width="2"/>
            <circle cx="12" cy="7" r="4" stroke-width="2"/>
        </svg>
        <span>Profile</span>
    </a>
</div>
@endsection