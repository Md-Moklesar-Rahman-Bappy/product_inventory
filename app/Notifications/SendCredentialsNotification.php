<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendCredentialsNotification extends Notification
{
    use Queueable;

    public string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎉 Your Login Credentials')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your email has been successfully verified.')
            ->line('Here are your login credentials:')
            ->line('📧 Email: ' . $notifiable->email)
            ->line('🔐 Password: ' . $this->password)
            ->action('Login Now', url('/login'))
            ->line('Please change your password after logging in.')
            ->salutation('Warm regards, The Support Team');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'email' => $notifiable->email,
            'sent_at' => now(),
        ];
    }
}
