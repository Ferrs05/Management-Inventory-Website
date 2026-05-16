@extends('layouts.admin', ['heading' => 'Items', 'breadcrumb' => 'Items'])

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
        <div>
            <i class="bi bi-box-seam me-1"></i>
            Data Inventory
        </div>
        <div class="d-flex gap-2">
            <form class="d-flex gap-2" method="GET">
                <input class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari barang">
                <select class="form-select form-select-sm" name="condition">
                    <option value="">Semua kondisi</option>
                    @foreach(['good', 'minor_damage', 'damaged', 'lost'] as $condition)
                        <option value="{{ $condition }}" @selected(request('condition') === $condition)>{{ str_replace('_', ' ', $condition) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary">Filter</button>
            </form>
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.items.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-lg"></i> Tambah Item
                </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Total</th>
                    <th>Tersedia</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td class="text-muted">{{ str($item->description ?: '-')->limit(70) }}</td>
                        <td>{{ $item->quantity_total }}</td>
                        <td>
                            <span class="badge {{ $item->quantity_available > 0 ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $item->quantity_available }}
                            </span>
                        </td>
                        <td>{{ str_replace('_', ' ', $item->condition) }}</td>
                        <td>
                            <span class="badge {{ $item->is_active ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                {{ $item->is_active ? 'Aktif' : 'Disembunyikan' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            @if(auth()->user()->isSuperAdmin())
                                <form method="POST" action="{{ route('admin.items.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada item.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection
