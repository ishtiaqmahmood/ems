<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Vacation;

class LeaveStatusUpdated extends Notification
{
    use Queueable;

    protected $vacation;

    public function __construct(Vacation $vacation)
    {
        $this->vacation = $vacation;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $status = ucfirst($this->vacation->status);
        return [
            'vacation_id' => $this->vacation->id,
            'status' => $this->vacation->status,
            'message' => "Your leave application for {$this->vacation->start_date} has been {$status}.",
            'type' => 'status_updated'
        ];
    }
}
