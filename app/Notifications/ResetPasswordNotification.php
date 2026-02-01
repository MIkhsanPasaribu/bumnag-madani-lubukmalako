<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi untuk reset password (Bahasa Indonesia)
 */
class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Token reset password
     */
    public string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password - BUMNag Madani')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mereset password akun Anda.')
            ->action('Reset Password', $url)
            ->line('Link ini akan kadaluarsa dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Salam, Tim BUMNag Madani Lubuk Malako');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
