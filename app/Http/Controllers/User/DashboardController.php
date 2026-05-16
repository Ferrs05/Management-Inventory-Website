<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('user.dashboard', [
            'recentRequests' => $user->borrowRequests()->with('item')->latest()->take(5)->get(),
            'pendingCount' => $user->borrowRequests()->where('status', BorrowRequest::STATUS_PENDING)->count(),
            'approvedCount' => $user->borrowRequests()->where('status', BorrowRequest::STATUS_APPROVED)->count(),
            'returnedCount' => $user->borrowRequests()->where('status', BorrowRequest::STATUS_RETURNED)->count(),
            'unreadNotifications' => $user->unreadNotifications()->count(),
        ]);
    }
}
