<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Clastic @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #2e7d32; }
        .navbar { background: var(--primary); }
        .navbar-brand, .nav-link, .btn-link { color: white !important; }
        .btn-primary { background: var(--primary); border: none; }
        body { background-color: #f3f4f6; }  
        .btn-green { background-color: #10b981; color: white; }
        .nav-link.btn-link:hover { color: #c8e6c9 !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Clastic</a>
            <div class="navbar-nav ms-auto d-flex align-items-center">
                @auth
                    <span class="text-white me-3">Hi, {{ Auth::user()->name }}!</span>
                    
                    <a class="nav-link" href="{{ route('pickup.create') }}">Jemput</a>
                    <a class="nav-link" href="{{ route('dropoff.create') }}">Dropoff</a>
                    <a class="nav-link" href="{{ route('points') }}">Poin</a>
                    <a class="nav-link" href="{{ route('missions') }}">Misi</a>

                    <!-- LOGOUT FORM -->
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white p-0 m-0 border-0 bg-transparent">
                            Logout
                        </button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>