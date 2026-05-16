@extends('layouts.public', ['title' => 'Inventaris Ormawa'])

@section('content')
<section class="hero py-5">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge text-bg-light text-success mb-3">Sistem Inventaris Organisasi</span>
                <h1 class="display-5 fw-bold mb-3">Cek ketersediaan dan ajukan peminjaman barang organisasi.</h1>
                <p class="lead mb-4">
                    Anggota dapat melihat katalog barang, mengirim request peminjaman, dan memantau statusnya. Staff memproses approval dan return melalui dashboard admin.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#catalog" class="btn btn-light btn-lg">
                        <i class="bi bi-grid me-1"></i> Lihat Katalog
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login untuk Pinjam</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="fs-2 text-success"><i class="bi bi-boxes"></i></div>
                    <div>
                        <div class="text-muted small">Total Barang Aktif</div>
                        <div class="fs-4 fw-bold">{{ $itemCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="fs-2 text-success"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="text-muted small">Barang Tersedia</div>
                        <div class="fs-4 fw-bold">{{ $availableCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="fs-2 text-success"><i class="bi bi-arrow-left-right"></i></div>
                    <div>
                        <div class="text-muted small">Sedang Dipinjam</div>
                        <div class="fs-4 fw-bold">{{ $borrowedCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="catalog">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
            <div>
                <h2 class="h3 mb-1">Katalog Barang</h2>
                <p class="text-muted mb-0">Indikator stok ditampilkan langsung dari database inventory.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-success">
                Semua Katalog <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($featuredItems as $item)
                @php($available = $item->isAvailable())
                <div class="col-md-6 col-xl-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <h3 class="h5 mb-0">{{ $item->name }}</h3>
                                <span class="badge {{ $available ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $available ? 'Tersedia' : 'Kosong' }}
                                </span>
                            </div>
                            <p class="text-muted flex-grow-1">{{ str($item->description ?: 'Tidak ada deskripsi.')->limit(110) }}</p>
                            <div class="border-top pt-3 mt-2">
                                <div class="d-flex justify-content-between small mb-2">
                                    <span class="text-muted">Stok</span>
                                    <span class="fw-semibold">{{ $item->quantity_available }} / {{ $item->quantity_total }}</span>
                                </div>
                                <div class="d-flex justify-content-between small mb-3">
                                    <span class="text-muted">Kondisi</span>
                                    <span class="fw-semibold">{{ ucwords(str_replace('_', ' ', $item->condition)) }}</span>
                                </div>
                                @auth
                                    @if(auth()->user()->isRegularUser())
                                        <a href="{{ route('catalog.show', $item) }}" class="btn btn-success w-100 {{ $available ? '' : 'disabled' }}">
                                            <i class="bi bi-send me-1"></i> Ajukan Pinjam
                                        </a>
                                    @else
                                        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-outline-success w-100">
                                            Kelola Item
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-success w-100 {{ $available ? '' : 'disabled' }}">
                                        Login untuk Pinjam
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Belum ada barang yang ditampilkan di katalog.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
