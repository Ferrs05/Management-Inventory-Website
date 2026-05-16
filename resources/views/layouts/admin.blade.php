<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Inventaris' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <aside class="sidebar p-3 text-white" style="width: 260px;">
        <div class="fs-5 fw-bold mb-4">SB Admin Inventaris</div>
        <nav class="d-grid gap-1">
            <a class="rounded px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a class="rounded px-3 py-2 {{ request()->routeIs('admin.items.*') ? 'active' : '' }}" href="{{ route('admin.items.index') }}"><i class="bi bi-box-seam me-2"></i>Inventory</a>
            <a class="rounded px-3 py-2 {{ request()->routeIs('admin.borrow-requests.*') ? 'active' : '' }}" href="{{ route('admin.borrow-requests.index') }}"><i class="bi bi-clipboard-check me-2"></i>Requests</a>
            <a class="rounded px-3 py-2 {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}"><i class="bi bi-bell me-2"></i>Notifikasi</a>
            @if(auth()->user()->isSuperAdmin())
                <a class="rounded px-3 py-2 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Users & Role</a>
            @endif
            <a class="rounded px-3 py-2" href="{{ route('home') }}"><i class="bi bi-globe me-2"></i>Public Site</a>
        </nav>
    </aside>
    <main class="flex-grow-1">
        <nav class="navbar bg-white border-bottom px-4">
            <span class="fw-semibold">{{ $heading ?? 'Dashboard' }}</span>
            <div class="d-flex align-items-center gap-3">
                <span class="small text-muted">{{ auth()->user()->name }} · {{ auth()->user()->role }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">Logout</button>
                </form>
            </div>
        </nav>
        <div class="p-4">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
