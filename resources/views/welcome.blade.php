@extends('layouts.app')

@section('title', ' - Dashboard')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #4a7c59 0%, #5a9068 100%);
        border-radius: 20px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(74, 124, 89, 0.2);
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hero-section p {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-card .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-card .stat-label {
        font-size: 0.95rem;
        color: #6c757d;
        font-weight: 500;
    }

    .stat-card.primary .stat-number {
        color: #4a7c59;
    }

    .stat-card.success .stat-number {
        color: #28a745;
    }

    .stat-card.info .stat-number {
        color: #17a2b8;
    }

    .stat-card.warning .stat-number {
        color: #ffc107;
    }

    .action-buttons {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-action.primary {
        background: #4a7c59;
        color: white;
    }

    .btn-action.primary:hover {
        background: #3d6849;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 124, 89, 0.3);
    }

    .btn-action.outline {
        background: white;
        color: #4a7c59;
        border: 2px solid #4a7c59;
    }

    .btn-action.outline:hover {
        background: #4a7c59;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 124, 89, 0.2);
    }

    .stats-container {
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 1.8rem;
        }
        
        .hero-section {
            padding: 2rem 1.5rem;
        }

        .stat-card {
            padding: 1.5rem 1rem;
        }

        .stat-card .stat-number {
            font-size: 2rem;
        }

        .btn-action {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }
    }

    /* Icon styles */
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .stat-icon.primary {
        background: rgba(74, 124, 89, 0.1);
        color: #4a7c59;
    }

    .stat-icon.success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .stat-icon.info {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .stat-icon.warning {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
</style>

<div class="container py-4">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Selamat Datang, {{ auth()->user()->name ?? 'Pengguna' }}!</h1>
        <p>Kumpulkan plastik, dapatkan poin, selamatkan bumi.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card primary">
                    <div class="stat-icon primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <div class="stat-number">{{ number_format($totalPoints ?? 0) }}</div>
                    <div class="stat-label">Total Poin</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card success">
                    <div class="stat-icon success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                    </div>
                    <div class="stat-number">{{ number_format($totalPlasticKg ?? 0, 1) }} kg</div>
                    <div class="stat-label">Plastik Terkumpul</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card info">
                    <div class="stat-icon info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <div class="stat-number">{{ $completedMissions ?? 0 }}</div>
                    <div class="stat-label">Misi Selesai</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card warning">
                    <div class="stat-icon warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div class="stat-number">{{ $activePickups ?? 0 }}</div>
                    <div class="stat-label">Pickup Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="action-buttons">
        <a href="{{ route('pickup.create') }}" class="btn-action primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 0.5rem;">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="16"/>
                <line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
            Jemput Plastik
        </a>
        <a href="{{ route('points') }}" class="btn-action outline">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 0.5rem;">
                <circle cx="12" cy="12" r="10"/>
                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                <path d="M12 18V6"/>
            </svg>
            Lihat Poin
        </a>
    </div>
</div>
@endsection