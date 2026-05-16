@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container" style="max-width: 520px;">
        <div class="admin-panel p-4">
            <h1 class="h4 mb-3">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember">
                        <span class="form-check-label">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
                </div>
                <button class="btn btn-success w-100">Login</button>
            </form>
            <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline-secondary w-100 mt-3">Login dengan Google</a>
            <p class="text-muted mt-3 mb-0">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
        </div>
    </div>
</section>
@endsection
