<?php

namespace App\Notifications\Orders\Updated;

use App\Notifications\Orders\AdminNotification as BaseNotification;
use App\Services\InvoicesService;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;

class AdminNotification extends BaseNotification
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        logs()->info(self::class);
        $invoice = (new InvoicesService)->generate($this->order);

        return (new MailMessage)
            ->greeting("Hello, $notifiable->name $notifiable->surname")
            ->line("Status of order {$this->order->id} has been changed to {$this->order->status->getName()}");
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->user->telegram_id)
            ->content("Hello, $notifiable->name $notifiable->surname")
            ->line("Status of order {$this->order->id} has been changed to {$this->order->status->getName()}");
    }
}
