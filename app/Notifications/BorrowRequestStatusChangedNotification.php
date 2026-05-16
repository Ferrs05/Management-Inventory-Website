<?php

namespace App\Notifications;

use App\Models\BorrowRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BorrowRequestStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(public BorrowRequest $borrowRequest)
    {
        $this->borrowRequest->loadMissing('item');
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $itemName = $this->borrowRequest->item->name;
        $status = $this->borrowRequest->status;
        $wa = config('inventory.staff_whatsapp_number');

        $message = match ($status) {
            BorrowRequest::STATUS_APPROVED => "Request {$itemName} disetujui. Hubungi staff via WA: {$wa} untuk pickup dan jadwal pengembalian.",
            BorrowRequest::STATUS_REJECTED => "Request {$itemName} ditolak. Silakan cek catatan staff.",
            BorrowRequest::STATUS_RETURNED => "Pengembalian {$itemName} sudah diverifikasi staff.",
            default => "Status request {$itemName} berubah menjadi {$status}.",
        };

        return [
            'title' => 'Status peminjaman berubah',
            'message' => $message,
            'status' => $status,
            'borrow_request_id' => $this->borrowRequest->id,
            'url' => route('user.borrow-requests.index'),
        ];
    }
}
