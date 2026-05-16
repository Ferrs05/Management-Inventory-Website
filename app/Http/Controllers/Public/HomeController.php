<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequest;
use App\Models\Item;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('public.index', [
            'featuredItems' => Item::query()->where('is_active', true)->latest()->take(8)->get(),
            'itemCount' => Item::where('is_active', true)->count(),
            'availableCount' => Item::available()->count(),
            'borrowedCount' => BorrowRequest::where('status', BorrowRequest::STATUS_APPROVED)->count(),
        ]);
    }
}
