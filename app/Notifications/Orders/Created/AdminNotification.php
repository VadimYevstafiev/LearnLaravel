<?php

namespace App\Notifications\Orders\Created;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\InvoicesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class AdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Order $order)
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
        return ['mail'];
    }

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

    }
}
