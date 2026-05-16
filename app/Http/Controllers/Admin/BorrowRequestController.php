<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequest;
use App\Notifications\BorrowRequestStatusChangedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowRequestController extends Controller
{
    public function index(Request $request): View
    {
        $borrowRequests = BorrowRequest::with(['user', 'item', 'reviewer'])
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.borrow-requests.index', compact('borrowRequests'));
    }

    public function show(BorrowRequest $borrowRequest): View
    {
        $borrowRequest->load(['user', 'item', 'reviewer']);

        return view('admin.borrow-requests.show', compact('borrowRequest'));
    }

    public function approve(Request $request, BorrowRequest $borrowRequest): RedirectResponse
    {
        $request->validate(['staff_note' => ['nullable', 'string', 'max:1000']]);

        return DB::transaction(function () use ($request, $borrowRequest) {
            $borrowRequest->load('item');

            if (! $borrowRequest->isPending()) {
                return back()->with('error', 'Hanya request pending yang bisa disetujui.');
            }

            if (! $borrowRequest->item->isAvailable($borrowRequest->quantity)) {
                return back()->with('error', 'Stok barang tidak cukup untuk menyetujui request ini.');
            }

            $borrowRequest->item->decrement('quantity_available', $borrowRequest->quantity);
            $borrowRequest->update([
                'status' => BorrowRequest::STATUS_APPROVED,
                'staff_note' => $request->staff_note,
                'reviewed_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            $borrowRequest->user->notify(new BorrowRequestStatusChangedNotification($borrowRequest));

            return redirect()->route('admin.borrow-requests.show', $borrowRequest)->with('success', 'Request disetujui dan stok dikurangi.');
        });
    }

    public function reject(Request $request, BorrowRequest $borrowRequest): RedirectResponse
    {
        $request->validate(['staff_note' => ['nullable', 'string', 'max:1000']]);

        if (! $borrowRequest->isPending()) {
            return back()->with('error', 'Hanya request pending yang bisa ditolak.');
        }

        $borrowRequest->update([
            'status' => BorrowRequest::STATUS_REJECTED,
            'staff_note' => $request->staff_note,
            'reviewed_by' => Auth::id(),
            'rejected_at' => now(),
        ]);

        $borrowRequest->user->notify(new BorrowRequestStatusChangedNotification($borrowRequest));

        return redirect()->route('admin.borrow-requests.show', $borrowRequest)->with('success', 'Request ditolak. Stok tidak berubah.');
    }

    public function markAsReturned(BorrowRequest $borrowRequest): RedirectResponse
    {
        return DB::transaction(function () use ($borrowRequest) {
            $borrowRequest->load('item');

            if (! $borrowRequest->isApproved()) {
                return back()->with('error', 'Hanya request approved/borrowed yang bisa ditandai returned.');
            }

            $borrowRequest->item->increment('quantity_available', $borrowRequest->quantity);
            $borrowRequest->update([
                'status' => BorrowRequest::STATUS_RETURNED,
                'reviewed_by' => Auth::id(),
                'returned_at' => now(),
            ]);

            $borrowRequest->user->notify(new BorrowRequestStatusChangedNotification($borrowRequest));

            return redirect()->route('admin.borrow-requests.show', $borrowRequest)->with('success', 'Barang ditandai sudah dikembalikan dan stok dipulihkan.');
        });
    }
}
