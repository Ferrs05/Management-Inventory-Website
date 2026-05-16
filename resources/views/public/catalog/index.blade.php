@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3">Katalog Barang</h1>
                <p class="text-muted mb-0">Cek stok sebelum mengajukan peminjaman.</p>
            </div>
            <form class="d-flex gap-2" method="GET">
                <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari barang">
                <select class="form-select" name="availability">
                    <option value="">Semua</option>
                    <option value="available" @selected(request('availability') === 'available')>Tersedia</option>
                </select>
                <button class="btn btn-success">Filter</button>
            </form>
        </div>
        <div class="row g-3">
            @foreach($items as $item)
                <div class="col-md-4">
                    <div class="item-card h-100 p-3">
                        <h2 class="h5">{{ $item->name }}</h2>
                        <p class="text-muted">{{ str($item->description)->limit(120) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $item->isAvailable() ? 'badge-soft-success' : 'text-bg-secondary' }}">{{ $item->isAvailable() ? 'Tersedia '.$item->quantity_available : 'Tidak tersedia' }}</span>
                            <a href="{{ route('catalog.show', $item) }}" class="btn btn-sm btn-outline-success">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
</section>
@endsection
