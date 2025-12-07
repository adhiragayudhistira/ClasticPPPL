<div class="bottom-nav">
    <a href="{{ route('home') }}" 
       class="nav-item {{ Request::is('/') || Request::is('home') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
    </a>

    <a href="{{ route('articles.index') }}" 
       class="nav-item {{ Request::is('articles*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10M4 18h10" />
        </svg>
        <span>News</span>
    </a>

    <a href="{{ route('classify') }}" 
       class="nav-item {{ Request::is('classify') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
        </svg>
        <span>Scan</span>
    </a>

    <a href="{{ route('missions') }}" 
       class="nav-item {{ Request::is('missions') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" stroke-width="2"/>
        </svg>
        <span>Mission</span>
    </a>

    <a href="{{ route('profile') }}" 
       class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-width="2"/>
            <circle cx="12" cy="7" r="4" stroke-width="2"/>
        </svg>
        <span>Profile</span>
    </a>
</div>
