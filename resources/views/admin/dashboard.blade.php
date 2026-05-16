@extends('layouts.admin', ['heading' => 'Dashboard Admin'])

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Barang <div class="fs-2 fw-bold">{{ $itemCount }}</div></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.items.index') }}">Lihat inventory</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Barang Tersedia <div class="fs-2 fw-bold">{{ $availableCount }}</div></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Siap dipinjam</span>
                <div class="small text-white"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Antrean Pending <div class="fs-2 fw-bold">{{ $pendingCount }}</div></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.borrow-requests.index', ['status' => 'pending']) }}">Proses antrean</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Sedang Dipinjam <div class="fs-2 fw-bold">{{ $activeBorrowCount }}</div></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Menunggu return</span>
                <div class="small text-white"><i class="bi bi-arrow-return-left"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-hourglass-split me-1"></i>
        Antrean Borrow Requests
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Keperluan</th>
                    <th>Diajukan</th>
                    <th class="text-end">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pendingRequests as $request)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $request->user->name }}</div>
                            <div class="small text-muted">{{ $request->user->email }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $request->item->name }}</div>
                            <div class="small text-muted">Stok: {{ $request->item->quantity_available }} / {{ $request->item->quantity_total }}</div>
                        </td>
                        <td>{{ $request->quantity }}</td>
                        <td>{{ str($request->purpose ?: '-')->limit(80) }}</td>
                        <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.borrow-requests.approve', $request) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-success" @disabled($request->item->quantity_available < $request->quantity)>
                                    <i class="bi bi-check-lg"></i> Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.borrow-requests.reject', $request) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-lg"></i> Reject
                                </button>
                            </form>
                            <a href="{{ route('admin.borrow-requests.show', $request) }}" class="btn btn-sm btn-outline-secondary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada request pending.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-clock-history me-1"></i>
        Aktivitas Request Terbaru
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($recentRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->item->name }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>@include('partials.status-badge', ['status' => $request->status])</td>
                        <td class="text-end">
                            <a href="{{ route('admin.borrow-requests.show', $request) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
