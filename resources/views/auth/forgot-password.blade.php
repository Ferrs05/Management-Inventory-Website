@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container" style="max-width: 520px;">
        <div class="admin-panel p-4">
            <h1 class="h4">Reset Password</h1>
            <p class="text-muted">Masukkan email akun, sistem akan mengirim link reset.</p>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
                <button class="btn btn-success w-100">Kirim Link</button>
            </form>
        </div>
    </div>
</section>
@endsection
