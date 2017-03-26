<?php

namespace App\Channels;
use Illuminate\Support\Facades\Notification;

/**
 * Class SendcloudChannel
 *
 * @package \app\Channels
 */
class SendcloudChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendcloud($notifiable);

    }
}
