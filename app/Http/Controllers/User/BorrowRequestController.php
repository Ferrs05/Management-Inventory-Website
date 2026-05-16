<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorrowRequestRequest;
use App\Models\BorrowRequest;
use App\Models\Item;
use App\Models\User;
use App\Notifications\BorrowRequestSubmittedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class BorrowRequestController extends Controller
{
    public function index(): View
    {
        $borrowRequests = Auth::user()
            ->borrowRequests()
            ->with('item')
            ->latest()
            ->paginate(10);

        return view('user.borrow-requests.index', compact('borrowRequests'));
    }

    public function store(StoreBorrowRequestRequest $request, Item $item): RedirectResponse
    {
        if (! $item->isAvailable((int) $request->quantity)) {
            return back()->with('error', 'Barang tidak tersedia untuk jumlah yang diminta.');
        }

        $borrowRequest = BorrowRequest::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'quantity' => $request->quantity,
            'purpose' => $request->purpose,
            'status' => BorrowRequest::STATUS_PENDING,
            'requested_at' => now(),
        ]);

        $staff = User::whereIn('role', [User::ROLE_STAFF, User::ROLE_SUPER_ADMIN])->get();
        Notification::send($staff, new BorrowRequestSubmittedNotification($borrowRequest));

        return redirect()
            ->route('user.borrow-requests.index')
            ->with('success', 'Permintaan peminjaman dikirim. Stok belum berubah sampai staff menyetujui.');
    }
}
