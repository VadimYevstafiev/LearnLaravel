<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    public $userId;
    public $message;

    public function __construct($message)
    {
        //$this->message = $message;
        $this->userId = $message[0];
        $this->message = $message[1];
        $this->broadcastVia('pusher');
    }
  
    public function broadcastOn()
    {
        
        return [
          new PrivateChannel('my-channel')
          //  new PrivateChannel('App.Models.User.2')
        ];
    }
}
