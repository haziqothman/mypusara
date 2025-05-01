<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdminSelectionRequest;

class NewSelectionRequest extends Notification
{
    use Queueable;

    protected $request;

    public function __construct(AdminSelectionRequest $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Pelanggan baru memohon bantuan pemilihan pusara',
            'request_id' => $this->request->id,
            'customer_name' => $this->request->user->name,
            'link' => route('admin.selection.request.show', $this->request->id)
        ];
    }
}