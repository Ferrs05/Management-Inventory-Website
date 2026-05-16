@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="h3 mb-4">Riwayat Peminjaman</h1>
        <div class="admin-panel p-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Barang</th><th>Jumlah</th><th>Status</th><th>Catatan Staff</th><th>Diajukan</th></tr></thead>
                    <tbody>
                    @foreach($borrowRequests as $request)
                        <tr>
                            <td>{{ $request->item->name }}</td>
                            <td>{{ $request->quantity }}</td>
                            <td>@include('partials.status-badge', ['status' => $request->status])</td>
                            <td>{{ $request->staff_note ?: '-' }}</td>
                            <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $borrowRequests->links() }}
        </div>
    </div>
</section>
@endsection
