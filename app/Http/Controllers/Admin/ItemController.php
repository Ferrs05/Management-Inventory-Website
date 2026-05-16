<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $items = Item::query()
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($request->condition, fn ($query, $condition) => $query->where('condition', $condition))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.items.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.items.create');
    }

    public function store(StoreItemRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(5));
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        Item::create($data);

        return redirect()->route('admin.items.index')->with('success', 'Barang baru berhasil dibuat.');
    }

    public function edit(Item $item): View
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $data['image'] = $request->file('image')->store('items', 'public');
        }

        if (! Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)) {
            unset($data['quantity_total'], $data['is_active']);
        }

        if (isset($data['quantity_available']) && ! isset($data['quantity_total'])) {
            $data['quantity_available'] = min((int) $data['quantity_available'], $item->quantity_total);
        }

        if (isset($data['quantity_available'], $data['quantity_total'])) {
            $data['quantity_available'] = min((int) $data['quantity_available'], (int) $data['quantity_total']);
        }

        $item->update($data);

        return redirect()->route('admin.items.index')->with('success', 'Data barang diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        if ($item->borrowRequests()->whereIn('status', ['pending', 'approved'])->exists()) {
            return back()->with('error', 'Barang tidak bisa dihapus karena masih punya request aktif.');
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
