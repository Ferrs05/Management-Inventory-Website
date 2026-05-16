@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container" style="max-width: 560px;">
        <div class="admin-panel p-4">
            <h1 class="h4 mb-3">Register Peminjam</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor WA</label>
                    <input class="form-control" name="phone" value="{{ old('phone') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
                <button class="btn btn-success w-100">Register</button>
            </form>
            <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline-secondary w-100 mt-3">Register dengan Google</a>
        </div>
    </div>
</section>
@endsection
