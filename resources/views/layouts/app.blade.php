<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Clastic')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <body class="{{ Request::is('points/success') ? 'success-body' : '' }}">
    <div class="home-container">
        @yield('content')
    </div>

    @include('partials.bottom-nav')
</body>
</html>