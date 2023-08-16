<?php

namespace App\Notifications\Orders\Created;

use App\Notifications\Orders\AdminNotification as BaseNotification;
use App\Enums\OrderStatus;
use App\Services\InvoicesService;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;
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
            ->line("Order {$this->order->id} was created by {$this->order->name} {$this->order->surname}")
            ->lineIf(
                $this->order->status->getName() === OrderStatus::Paid->value,
                'And succesfully paid!'
             )
            ->line("You can see the invoice file in attachments")
            ->attach(Storage::disk('public')->path($invoice->filename), [
                'as' => $invoice->filename,
                'mime' => 'application/pdf'
            ]);
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->user->telegram_id)
            ->content("Hello, $notifiable->name $notifiable->surname")
            ->line("Order {$this->order->id} was created by {$this->order->name} {$this->order->surname}")
            ->line('You can see the invoice file in attachments');
    }
}
