<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Vacation;

class NewLeaveApplication extends Notification
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
        return [
            'vacation_id' => $this->vacation->id,
            'user_name' => $this->vacation->user->name,
            'leave_type' => $this->vacation->leaveType->name_en ?? 'Leave',
            'start_date' => $this->vacation->start_date,
            'message' => "{$this->vacation->user->name} submitted a new {$this->vacation->leaveType->name_en} application.",
            'type' => 'new_leave'
        ];
    }
}
