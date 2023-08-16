<?php

namespace App\Notifications\Orders;

use App\Services\Contracts\InvoicesServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class CustomerNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected InvoicesServiceContract $invoicesService)
    {
        //
    }

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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    abstract public function toTelegram(object $notifiable);
}
