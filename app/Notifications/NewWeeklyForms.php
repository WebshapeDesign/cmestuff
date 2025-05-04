<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewWeeklyForms extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Weekly Forms Available')
            ->line('Your weekly forms have been created and are ready for completion.')
            ->action('View Forms', url('/dashboard'))
            ->line('Please complete these forms by the end of the week.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New weekly forms are available for completion',
            'action_url' => '/dashboard',
        ];
    }
} 