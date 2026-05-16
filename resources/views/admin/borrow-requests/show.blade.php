@extends('layouts.admin', ['heading' => 'Detail Request'])

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-panel p-4">
            <h1 class="h4">{{ $borrowRequest->item->name }}</h1>
            <dl class="row">
                <dt class="col-sm-4">Peminjam</dt><dd class="col-sm-8">{{ $borrowRequest->user->name }} ({{ $borrowRequest->user->email }})</dd>
                <dt class="col-sm-4">Jumlah</dt><dd class="col-sm-8">{{ $borrowRequest->quantity }}</dd>
                <dt class="col-sm-4">Status</dt><dd class="col-sm-8">@include('partials.status-badge', ['status' => $borrowRequest->status])</dd>
                <dt class="col-sm-4">Keperluan</dt><dd class="col-sm-8">{{ $borrowRequest->purpose ?: '-' }}</dd>
                <dt class="col-sm-4">Catatan</dt><dd class="col-sm-8">{{ $borrowRequest->staff_note ?: '-' }}</dd>
                <dt class="col-sm-4">Stok saat ini</dt><dd class="col-sm-8">{{ $borrowRequest->item->quantity_available }} / {{ $borrowRequest->item->quantity_total }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="admin-panel p-4">
            <h2 class="h5">Aksi Staff</h2>
            @if($borrowRequest->isPending())
                <form method="POST" action="{{ route('admin.borrow-requests.approve', $borrowRequest) }}" class="mb-3">
                    @csrf @method('PATCH')
                    <label class="form-label">Catatan untuk user</label>
                    <textarea class="form-control mb-2" name="staff_note" rows="3"></textarea>
                    <button class="btn btn-success w-100">Approve & Kurangi Stok</button>
                </form>
                <form method="POST" action="{{ route('admin.borrow-requests.reject', $borrowRequest) }}">
                    @csrf @method('PATCH')
                    <textarea class="form-control mb-2" name="staff_note" rows="2" placeholder="Alasan penolakan"></textarea>
                    <button class="btn btn-outline-danger w-100">Reject</button>
                </form>
            @elseif($borrowRequest->isApproved())
                <p class="text-muted">Klik setelah barang sudah diterima kembali secara fisik.</p>
                <form method="POST" action="{{ route('admin.borrow-requests.return', $borrowRequest) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-success w-100">Mark as Returned & Pulihkan Stok</button>
                </form>
            @else
                <p class="text-muted mb-0">Request ini sudah final.</p>
            @endif
        </div>
    </div>
</div>
@endsection
