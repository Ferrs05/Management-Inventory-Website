<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $items = Item::query()
            ->where('is_active', true)
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($request->availability === 'available', fn ($query) => $query->available())
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('public.catalog.index', compact('items'));
    }

    public function show(Item $item): View
    {
        abort_unless($item->is_active, 404);

        return view('public.catalog.show', compact('item'));
    }
}
