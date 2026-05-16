@csrf
@if($method ?? false)
    @method($method)
@endif

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-card-text me-1"></i>
                Informasi Barang
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input class="form-control" name="name" value="{{ old('name', $item->name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="6">{{ old('description', $item->description ?? '') }}</textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">Gambar</label>
                    <input class="form-control" type="file" name="image">
                    @if(isset($item) && $item->image)
                        <div class="form-text">Gambar saat ini: {{ $item->image }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-sliders me-1"></i>
                Stok & Status
            </div>
            <div class="card-body">
                @if(auth()->user()->isSuperAdmin())
                    <div class="mb-3">
                        <label class="form-label">Total Stok</label>
                        <input class="form-control" type="number" min="1" name="quantity_total" value="{{ old('quantity_total', $item->quantity_total ?? 1) }}" required>
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Stok Tersedia</label>
                    <input class="form-control" type="number" min="0" name="quantity_available" value="{{ old('quantity_available', $item->quantity_available ?? 1) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kondisi</label>
                    <select class="form-select" name="condition">
                        @foreach(['good', 'minor_damage', 'damaged', 'lost'] as $condition)
                            <option value="{{ $condition }}" @selected(old('condition', $item->condition ?? 'good') === $condition)>
                                {{ ucwords(str_replace('_', ' ', $condition)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(auth()->user()->isSuperAdmin())
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
                        <label class="form-check-label">Tampilkan di katalog publik</label>
                    </div>
                @endif
                <div class="d-grid gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
