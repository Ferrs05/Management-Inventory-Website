@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="admin-panel p-4">
                    <h1 class="h3">{{ $item->name }}</h1>
                    <p class="text-muted">{{ $item->description ?: 'Belum ada deskripsi.' }}</p>
                    <dl class="row">
                        <dt class="col-sm-4">Stok tersedia</dt><dd class="col-sm-8">{{ $item->quantity_available }} / {{ $item->quantity_total }}</dd>
                        <dt class="col-sm-4">Kondisi</dt><dd class="col-sm-8">{{ str_replace('_', ' ', $item->condition) }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="admin-panel p-4">
                    <h2 class="h5">Ajukan Peminjaman</h2>
                    @guest
                        <p class="text-muted">Login atau register untuk meminjam barang ini.</p>
                        <a href="{{ route('login') }}" class="btn btn-success">Login</a>
                    @else
                        @if(auth()->user()->isRegularUser())
                            <form method="POST" action="{{ route('user.borrow-requests.store', $item) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" min="1" class="form-control" name="quantity" value="1">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keperluan</label>
                                    <textarea class="form-control" name="purpose" rows="4"></textarea>
                                </div>
                                <button class="btn btn-success" @disabled(! $item->isAvailable())>Kirim Request</button>
                            </form>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-success">Buka Dashboard Admin</a>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
