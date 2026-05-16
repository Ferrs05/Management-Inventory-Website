<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Inventaris' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/css/styles.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">Inventaris Admin</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" type="button">
        <i class="bi bi-list"></i>
    </button>
    <div class="ms-auto me-3 text-white-50 small d-none d-md-block">
        {{ auth()->user()->name }} · {{ auth()->user()->role }}
    </div>
    <form method="POST" action="{{ route('logout') }}" class="me-3">
        @csrf
        <button class="btn btn-sm btn-outline-light">Logout</button>
    </form>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-speedometer2"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Manajemen</div>
                    <a class="nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}" href="{{ route('admin.items.index') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-box-seam"></i></div>
                        Items
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.borrow-requests.*') ? 'active' : '' }}" href="{{ route('admin.borrow-requests.index') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-clipboard-check"></i></div>
                        Borrow Requests
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-bell"></i></div>
                        Notifikasi
                    </a>
                    @if(auth()->user()->isSuperAdmin())
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-people"></i></div>
                            User Roles
                        </a>
                    @endif
                    <div class="sb-sidenav-menu-heading">Akses</div>
                    <a class="nav-link" href="{{ route('home') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-globe"></i></div>
                        Public Site
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Login sebagai:</div>
                {{ auth()->user()->name }}
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">{{ $heading ?? 'Dashboard' }}</h1>
                @if(isset($breadcrumb))
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                    </ol>
                @else
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">{{ $heading ?? 'Dashboard' }}</li>
                    </ol>
                @endif

                @include('partials.flash')
                @yield('content')
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Organizational Inventory System</div>
                    <a href="{{ route('home') }}">Lihat Public Site</a>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/js/scripts.min.js"></script>
</body>
</html>
