@extends('layouts.public')

@section('content')
<section class="hero py-5">
    <div class="container py-5">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold">Inventaris Ormawa</h1>
            <p class="lead mt-3">Kelola, cek ketersediaan, dan ajukan peminjaman barang organisasi dalam satu tempat yang rapi.</p>
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg">Lihat Katalog</a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Daftar Peminjam</a>
                @endguest
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-3 mb-5">
            <div class="col-md-4"><div class="stat-card p-4"><div class="text-muted">Total Barang</div><div class="display-6 fw-bold">{{ $itemCount }}</div></div></div>
            <div class="col-md-4"><div class="stat-card p-4"><div class="text-muted">Tersedia</div><div class="display-6 fw-bold">{{ $availableCount }}</div></div></div>
            <div class="col-md-4"><div class="stat-card p-4"><div class="text-muted">Sedang Dipinjam</div><div class="display-6 fw-bold">{{ $borrowedCount }}</div></div></div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Barang Tersedia</h2>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-success">Semua Barang</a>
        </div>
        <div class="row g-3">
            @forelse($featuredItems as $item)
                <div class="col-md-4">
                    <div class="item-card h-100 p-3">
                        <h3 class="h5">{{ $item->name }}</h3>
                        <p class="text-muted">{{ str($item->description)->limit(100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge badge-soft-success">Stok {{ $item->quantity_available }}</span>
                            <a href="{{ route('catalog.show', $item) }}" class="btn btn-sm btn-success">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">Belum ada barang tersedia.</div></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
