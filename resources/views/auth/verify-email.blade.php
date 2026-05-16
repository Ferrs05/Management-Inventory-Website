@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container" style="max-width: 620px;">
        <div class="admin-panel p-4">
            <h1 class="h4">Verifikasi Email</h1>
            <p class="text-muted">Cek inbox email untuk link verifikasi. Jika belum masuk, kirim ulang link.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn btn-success">Kirim Ulang Link</button>
            </form>
        </div>
    </div>
</section>
@endsection
