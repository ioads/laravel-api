<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskNotification implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }

    // Define o canal no qual o evento será transmitido
    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    // Define os dados que serão enviados com o evento
    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}
