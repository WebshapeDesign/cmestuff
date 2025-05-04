<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LateFormsReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lateForms;

    public function __construct($lateForms)
    {
        $this->lateForms = $lateForms;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Late Forms Reminder')
            ->line('You have forms that are overdue:');

        foreach ($this->lateForms as $form) {
            $message->line("- {$form['type']} for week starting {$form['week_start']}");
        }

        return $message
            ->action('Complete Forms', url('/dashboard'))
            ->line('Please complete these forms as soon as possible.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have forms that are overdue',
            'late_forms' => $this->lateForms,
            'action_url' => '/dashboard',
        ];
    }
} 