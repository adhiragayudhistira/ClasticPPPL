<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clastic @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #2e7d32; }
        .navbar { background: var(--primary); }
        .navbar-brand, .nav-link { color: white !important; }
        .btn-primary { background: var(--primary); border: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Clastic</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('pickup.create') }}">Jemput</a>
                <a class="nav-link" href="{{ route('dropoff.create') }}">Dropoff</a>
                <a class="nav-link" href="{{ route('points') }}">Poin</a>
                <a class="nav-link" href="{{ route('missions') }}">Misi</a>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>