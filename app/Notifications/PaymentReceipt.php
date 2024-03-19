<?php

namespace App\Notifications;

use App\Channels\PaymentReceiptSmsChanel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceipt extends Notification
{
    use Queueable;
    public $orderNumber;
    public $amount;
    public $refId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderNumber,$amount,$refId)
    {
        //
        $this->orderNumber = $orderNumber;
        $this->amount = $amount;
        $this->refId = $refId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [PaymentReceiptSmsChanel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toSms($notifiable)
    {
        return [
          'orderNumber'=>$this->orderNumber,
          'amount'=>$this->amount,
           'refId'=>$this->refId
        ];
    }
}
