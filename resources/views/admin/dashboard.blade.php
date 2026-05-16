@extends('layouts.admin', ['heading' => 'Dashboard'])

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-2"><div class="stat-card p-3"><div class="text-muted">Barang</div><div class="h2">{{ $itemCount }}</div></div></div>
    <div class="col-md-2"><div class="stat-card p-3"><div class="text-muted">Tersedia</div><div class="h2">{{ $availableCount }}</div></div></div>
    <div class="col-md-2"><div class="stat-card p-3"><div class="text-muted">Pending</div><div class="h2">{{ $pendingCount }}</div></div></div>
    <div class="col-md-3"><div class="stat-card p-3"><div class="text-muted">Sedang Dipinjam</div><div class="h2">{{ $activeBorrowCount }}</div></div></div>
    <div class="col-md-3"><div class="stat-card p-3"><div class="text-muted">Peminjam</div><div class="h2">{{ $userCount }}</div></div></div>
</div>
<div class="admin-panel p-4">
    <h2 class="h5 mb-3">Request Terbaru</h2>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>User</th><th>Barang</th><th>Jumlah</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @foreach($recentRequests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->item->name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>@include('partials.status-badge', ['status' => $request->status])</td>
                    <td><a href="{{ route('admin.borrow-requests.show', $request) }}" class="btn btn-sm btn-outline-success">Detail</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
