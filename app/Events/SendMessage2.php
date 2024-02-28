<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage2 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $sender;
    public $message;
    public $conversation;
    public $receiver;


    public function __construct(Doctor $sender , Conversation $conversation , Message $message ,Patient $receiver )
    {
        $this->sender = $sender;
        $this->conversation = $conversation;
        $this->message = $message;
        $this->receiver = $receiver;

    }

    public function broadcastWith()
    {
        return [
            'sender_email' => $this->sender->email,
            'message' => $this->message->id,
            'conversation_id' => $this->conversation->id,
            'receivere_email' => $this->receiver->email,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat2.'.$this->receiver->id);

    }
}
