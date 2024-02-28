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

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $sender;
    public $message;
    public $conversation;
    public $receiver;


    public function __construct(Patient $sender ,Conversation $conversation ,Message  $message ,Doctor $receiver )
    {
        //dd($message);
        $this->sender = $sender;
        $this->conversation = $conversation;
        $this->message = $message;
        $this->receiver = $receiver;

    }

    public function broadcastWith()
    {
        return [
            'sender_email' => $this->sender->email,
            'conversation_id' => $this->conversation->id,
            'message' => $this->message->id,
            'receivere_email' => $this->receiver->email,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->receiver->id);
    }
}
