<?php

namespace App\Notifications;

use App\Models\HolidayRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HolidayRequestStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $holidayRequest;

    public function __construct(HolidayRequest $holidayRequest)
    {
        $this->holidayRequest = $holidayRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $status = ucfirst($this->holidayRequest->status);
        $startDate = $this->holidayRequest->start_date->format('d/m/Y');
        $endDate = $this->holidayRequest->end_date->format('d/m/Y');

        return (new MailMessage)
            ->subject("Holiday Request {$status}")
            ->line("Your holiday request from {$startDate} to {$endDate} has been {$status}.")
            ->action('View Holiday Requests', route('holiday-requests.index'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your holiday request has been {$this->holidayRequest->status}",
            'holiday_request_id' => $this->holidayRequest->id,
            'start_date' => $this->holidayRequest->start_date,
            'end_date' => $this->holidayRequest->end_date,
            'status' => $this->holidayRequest->status,
        ];
    }
} 