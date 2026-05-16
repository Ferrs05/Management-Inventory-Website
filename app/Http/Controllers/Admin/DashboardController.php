<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequest;
use App\Models\Item;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'itemCount' => Item::count(),
            'availableCount' => Item::available()->count(),
            'pendingCount' => BorrowRequest::where('status', BorrowRequest::STATUS_PENDING)->count(),
            'activeBorrowCount' => BorrowRequest::where('status', BorrowRequest::STATUS_APPROVED)->count(),
            'userCount' => User::where('role', User::ROLE_USER)->count(),
            'recentRequests' => BorrowRequest::with(['user', 'item'])->latest()->take(8)->get(),
            'pendingRequests' => BorrowRequest::with(['user', 'item'])
                ->where('status', BorrowRequest::STATUS_PENDING)
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }
}
