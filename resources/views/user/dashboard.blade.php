@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="h3 mb-4">Dashboard Peminjam</h1>
        <div class="row g-3 mb-4">
            <div class="col-md-3"><div class="stat-card p-3"><div class="text-muted">Pending</div><div class="h2">{{ $pendingCount }}</div></div></div>
            <div class="col-md-3"><div class="stat-card p-3"><div class="text-muted">Dipinjam</div><div class="h2">{{ $approvedCount }}</div></div></div>
            <div class="col-md-3"><div class="stat-card p-3"><div class="text-muted">Returned</div><div class="h2">{{ $returnedCount }}</div></div></div>
            <div class="col-md-3"><div class="stat-card p-3"><div class="text-muted">Notifikasi Baru</div><div class="h2">{{ $unreadNotifications }}</div></div></div>
        </div>
        <div class="admin-panel p-4">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="h5">Riwayat Terbaru</h2>
                <a href="{{ route('user.borrow-requests.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Barang</th><th>Jumlah</th><th>Status</th><th>Tanggal</th></tr></thead>
                    <tbody>
                    @forelse($recentRequests as $request)
                        <tr>
                            <td>{{ $request->item->name }}</td>
                            <td>{{ $request->quantity }}</td>
                            <td>@include('partials.status-badge', ['status' => $request->status])</td>
                            <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted">Belum ada request.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
