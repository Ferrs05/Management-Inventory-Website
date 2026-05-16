@extends('layouts.admin', ['heading' => 'Borrow Requests'])

@section('content')
<div class="admin-panel p-4">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4">
            <select class="form-select" name="status">
                <option value="">Semua Status</option>
                @foreach(['pending', 'approved', 'rejected', 'returned'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-success w-100">Filter</button></div>
    </form>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>User</th><th>Barang</th><th>Jumlah</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
            <tbody>
            @foreach($borrowRequests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->item->name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>@include('partials.status-badge', ['status' => $request->status])</td>
                    <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                    <td><a class="btn btn-sm btn-outline-success" href="{{ route('admin.borrow-requests.show', $request) }}">Proses</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $borrowRequests->links() }}
</div>
@endsection
