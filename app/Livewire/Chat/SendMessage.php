<?php

namespace App\Livewire\Chat;

use App\Events\SendMessage2;
use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendMessage extends Component
{


    public $body , $createMessage  ,$auth_email , $sender ,$selected_conversation , $receviverUser;

    public function mount()
    {
        if (Auth::guard('patient')->check()) {
            $this->auth_email = Auth::guard('patient')->user()->email;
            $this->sender = Auth::guard('patient')->user();
        } else {
            $this->auth_email = Auth::guard('doctor')->user()->email;
            $this->sender = Auth::guard('doctor')->user();
        }

    }

    public $listeners = ['updateMessage' , 'updateMessage2','dispatchSendMessage'];


    public function render()
    {
        return view('livewire.chat.send-message');
    }

    public function updateMessage(Conversation $conversation, Doctor $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = $receiver;
    }

    public function updateMessage2(Conversation $conversation, Patient $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = $receiver;
    }



    public function sendMessage(){

        if ($this->body == null){
            return null;
        }

        $this->createMessage = Message::create([
            'conversation_id' => $this->selected_conversation->id,
            'sender_email' => $this->auth_email,
            'receiver_email' => $this->receviverUser->email,
            'body' => $this->body,
        ]);
        $this->selected_conversation->last_time_message = $this->createMessage->created_at;
        $this->selected_conversation->save();
        $this->reset('body');

        $this->emitTo('chat.chat-box','pushMessage',$this->createMessage->id);
        $this->emitTo('chat.chat-list','refresh');
        $this->emitSelf('dispatchSendMessage');

    }


    public function dispatchSendMessage(){

       // dd($this->sender);
       if(Auth::guard('patient')->check()){

           broadcast(new \App\Events\SendMessage(
               $this->sender,
               $this->selected_conversation,
               $this->createMessage,
               $this->receviverUser
           ));

       }else{

           broadcast(new SendMessage2(
               $this->sender,
               $this->selected_conversation,
               $this->createMessage,
               $this->receviverUser
           ));

       }
    }

}
