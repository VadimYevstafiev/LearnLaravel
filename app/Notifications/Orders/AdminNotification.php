<?php

namespace App\Notifications\Orders;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class AdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Order $order) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $notifiable?->user?->telegram_id ? ['mail', 'telegram'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    abstract public function toMail(object $notifiable): MailMessage;

    /**
     * Get the Telegram representation of the notification.
     */
    abstract public function toTelegram(object $notifiable);
}
