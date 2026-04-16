<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCredentialsNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $email = $notifiable->email;

        return (new MailMessage)
            ->subject('🎉 Your Account Has Been Created')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Your account has been created and your email has been verified.')
            ->line('To access your account, you need to set up your password first.')
            ->action('Set Up Your Password', url('/forgot-password'))
            ->line('On the password reset page, enter your email: '.$email)
            ->line('You will receive a link to create your password.')
            ->line('After setting your password, you can log in with your credentials.')
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
