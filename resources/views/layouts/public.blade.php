<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand text-success" href="{{ route('home') }}">Inventaris Ormawa</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Katalog</a></li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ auth()->user()->canAccessAdminDashboard() ? route('admin.dashboard') : route('user.dashboard') }}">Dashboard</a>
                    </li>
                @endauth
            </ul>
            <div class="d-flex gap-2">
                @guest
                    <a class="btn btn-outline-success" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-success" href="{{ route('register') }}">Register</a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-secondary">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>

@include('partials.flash')
@yield('content')

<footer class="border-top bg-white py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
        <span class="text-muted">&copy; {{ date('Y') }} Inventaris Ormawa</span>
        <span class="text-muted">Kontak Staff WA: {{ config('inventory.staff_whatsapp_number') }}</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
