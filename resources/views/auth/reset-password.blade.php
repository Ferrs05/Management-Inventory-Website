@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container" style="max-width: 520px;">
        <div class="admin-panel p-4">
            <h1 class="h4">Buat Password Baru</h1>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <input class="form-control mb-3" type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Email" required>
                <input class="form-control mb-3" type="password" name="password" placeholder="Password baru" required>
                <input class="form-control mb-3" type="password" name="password_confirmation" placeholder="Konfirmasi password" required>
                <button class="btn btn-success w-100">Simpan Password</button>
            </form>
        </div>
    </div>
</section>
@endsection
