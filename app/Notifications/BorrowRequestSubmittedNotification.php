<?php

namespace App\Notifications;

use App\Models\BorrowRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowRequestSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public BorrowRequest $borrowRequest)
    {
        $this->borrowRequest->loadMissing(['user', 'item']);
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Permintaan peminjaman baru')
            ->line($this->borrowRequest->user->name.' mengajukan peminjaman '.$this->borrowRequest->item->name.'.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Permintaan peminjaman baru',
            'message' => $this->borrowRequest->user->name.' meminta '.$this->borrowRequest->quantity.' unit '.$this->borrowRequest->item->name.'.',
            'borrow_request_id' => $this->borrowRequest->id,
            'url' => route('admin.borrow-requests.show', $this->borrowRequest),
        ];
    }
}
