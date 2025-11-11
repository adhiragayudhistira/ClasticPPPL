{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50">

    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-green-700">Clastic</h1>
            <div class="flex items-center space-x-2">
                <div class="bg-green-100 px-4 py-2 rounded-full">
                    <span class="text-green-800 font-bold">{{ number_format($totalPoints) }} PTS</span>
                </div>
                <span class="text-gray-700 font-medium">Hi, {{ Auth::user()->name }}!</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="text-3xl font-bold text-blue-600">{{ number_format($totalPlasticKg, 2) }} kg</div>
                <p class="text-gray-600">Plastic Collected</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="text-3xl font-bold text-green-600">{{ $completedMissions }}</div>
                <p class="text-gray-600">Missions Completed</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="text-3xl font-bold text-orange-600">{{ $activePickups }}</div>
                <p class="text-gray-600">Active Pickups</p>
            </div>
        </div>

        <!-- Streak Calendar -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <h3 class="text-lg font-semibold mb-4">Your Streak</h3>
            <div class="grid grid-cols-7 gap-2 text-center">
                @for($i = 6; $i >= 0; $i--)
                    @php $date = now()->subDays($i) @endphp
                    <div class="p-3 rounded-lg {{ $date->isToday() ? 'bg-green-500 text-white' : 'bg-gray-100' }}">
                        <div class="text-xs">{{ $date->format('D') }}</div>
                        <div class="font-bold">{{ $date->format('d') }}</div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Map -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <h3 class="text-lg font-semibold mb-4">Nearby Drop Points</h3>
            <div id="map" class="h-64 rounded-lg"></div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="/pickup" class="bg-green-600 text-white p-6 rounded-xl text-center font-semibold hover:bg-green-700 transition">
                Request Pickup
            </a>
            <a href="/dropoff" class="bg-blue-600 text-white p-6 rounded-xl text-center font-semibold hover:bg-blue-700 transition">
                Find Drop-off
            </a>
        </div>

        <!-- Recent Transactions -->
        @if($recentTransactions->count() > 0)
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
            <div class="space-y-2">
                @foreach($recentTransactions as $tx)
                <div class="flex justify-between text-sm p-2 border-b">
                    <span>{{ $tx->created_at->format('d M Y') }}</span>
                    <span class="font-medium">{{ $tx->points_earned }} PTS</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('map').setView([-6.2088, 106.8456], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([-6.2088, 106.8456]).addTo(map)
            .setPopupContent('Clastic Drop Point - Jakarta')
            .openPopup();
    });
</script>
@endsection