<?php
namespace App\Channels;
use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Notifications\Notification;

class PaymentReceiptSmsChanel {
    public function send($notifiable,Notification $notification)
    {

        $receptor = $notifiable->cellphone;
        $template = "PaymentRecipt";
        $args = [$notification->orderNumber,$notification->amount,$notification->refId];
         $response = GhasedakFacade::setVerifyType(GhasedakFacade::VERIFY_MESSAGE_TEXT)
            ->Verify(
                $receptor,  // receptor
                $template,  // name of the template which you've created in you account
                $args,      // parameters (supporting up to 10 parameters)

            );

}
}
