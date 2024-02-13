<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ChatEvent implements shouldbroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;

    public function __construct($message, $user)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return ['chat-push-notification-channel'];
        return new PrivateChannel('chat-push-notification-channel');
    }

    public function boradcatAs(){
        return 'chat-push-notification-event';
    }
}
