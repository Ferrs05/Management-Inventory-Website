@extends('layouts.admin', ['heading' => 'Inventory'])

@section('content')
<div class="admin-panel p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form class="d-flex gap-2" method="GET">
            <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari barang">
            <select class="form-select" name="condition">
                <option value="">Semua kondisi</option>
                @foreach(['good', 'minor_damage', 'damaged', 'lost'] as $condition)
                    <option value="{{ $condition }}" @selected(request('condition') === $condition)>{{ str_replace('_', ' ', $condition) }}</option>
                @endforeach
            </select>
            <button class="btn btn-success">Filter</button>
        </form>
        @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.items.create') }}" class="btn btn-success">Tambah Barang</a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Stok</th><th>Kondisi</th><th>Aktif</th><th></th></tr></thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity_available }} / {{ $item->quantity_total }}</td>
                    <td>{{ str_replace('_', ' ', $item->condition) }}</td>
                    <td>{{ $item->is_active ? 'Ya' : 'Tidak' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-outline-success">Edit</a>
                        @if(auth()->user()->isSuperAdmin())
                            <form method="POST" action="{{ route('admin.items.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
</div>
@endsection
