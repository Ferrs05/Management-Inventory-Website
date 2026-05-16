@csrf
@if($method ?? false)
    @method($method)
@endif
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Nama Barang</label>
        <input class="form-control" name="name" value="{{ old('name', $item->name ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kondisi</label>
        <select class="form-select" name="condition">
            @foreach(['good', 'minor_damage', 'damaged', 'lost'] as $condition)
                <option value="{{ $condition }}" @selected(old('condition', $item->condition ?? 'good') === $condition)>{{ str_replace('_', ' ', $condition) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" name="description" rows="4">{{ old('description', $item->description ?? '') }}</textarea>
    </div>
    @if(auth()->user()->isSuperAdmin())
        <div class="col-md-4">
            <label class="form-label">Total Stok</label>
            <input class="form-control" type="number" min="1" name="quantity_total" value="{{ old('quantity_total', $item->quantity_total ?? 1) }}">
        </div>
    @endif
    <div class="col-md-4">
        <label class="form-label">Stok Tersedia</label>
        <input class="form-control" type="number" min="0" name="quantity_available" value="{{ old('quantity_available', $item->quantity_available ?? 1) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Gambar</label>
        <input class="form-control" type="file" name="image">
    </div>
    @if(auth()->user()->isSuperAdmin())
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
                <label class="form-check-label">Tampilkan di katalog publik</label>
            </div>
        </div>
    @endif
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
