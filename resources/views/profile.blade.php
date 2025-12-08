@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gradient-to-br from-teal-100 via-teal-50 to-amber-50">
    <!-- Container utama putih yang full height -->
    <div class="mx-auto bg-white px-6 py-8 shadow-lg max-w-[480px] w-full flex-1 flex flex-col">

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="avatar"></div>
            <h2 class="name">{{ Auth::user()->name }}</h2>
            <p class="email">{{ Auth::user()->email }}</p>
            <a href="{{ route('profile') }}" class="points-badge">Points →</a>
        </div>

        <!-- Menu Container -->
        <div class="menu-card flex-1">

            <!-- Transaction History -->
            <a href="#" class="menu-item">
                <div class="flex items-center gap-3">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span>Transaction History</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <!-- Points Exchange -->
            <a href="{{ url('/points/exchange') }}" class="menu-item">
                <div class="flex items-center gap-3">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span>Points Exchange</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <!-- Share -->
            <a href="#" class="menu-item">
                <div class="flex items-center gap-3">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span>Share</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <!-- Settings -->
            <a href="#" class="menu-item">
                <div class="flex items-center gap-3">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span>Settings</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>

        <!-- Logout Button – tanpa mb-24! -->
        <form action="{{ route('logout') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>

    </div>

    <!-- Safe area bawah biar bottom navbar nggak nutupin logout -->
    <div class="h-[env(safe-area-inset-bottom)] bg-white"></div>
</div>
@endsection