<?php

namespace App\Notifications\Orders\Updated;

use App\Notifications\Orders\CustomerNotification as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;

class CustomerNotification extends BaseNotification
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        logs()->info(self::class);

        $invoice = $this->invoicesService->generate($notifiable);

                return (new MailMessage)
                    ->greeting("Hello, $notifiable->name $notifiable->surname")
                    ->line("Your order status has been changed to {$notifiable->status->getName()}");
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->user->telegram_id)
            ->content("Hello, $notifiable->name $notifiable->surname")
            ->line("Your order status has been changed to {$notifiable->status->getName()}");
    }
}
