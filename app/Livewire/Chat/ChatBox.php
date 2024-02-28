<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{

    public $selected_conversation,$receviverUser , $messages , $auth_email ,$auth_id,
        $event_name , $chat_page;


//    protected $listeners = ['load_conversationDoctor', 'load_conversationPatient' , 'pushMessage'];



    public function mount()
    {
        if (Auth::guard('patient')->check()) {
            $this->auth_email = Auth::guard('patient')->user()->email;
            $this->auth_id = Auth::guard('patient')->user()->id;
        } else {
            $this->auth_email = Auth::guard('doctor')->user()->email;
            $this->auth_id = Auth::guard('doctor')->user()->id;
        }

    }

    public function getListeners()
    {
        if (Auth::guard('patient')->check()) { // if receiver patient
            $auth_id = Auth::guard('patient')->user()->id;
            $this->event_name = "SendMessage2";
            $this->chat_page = "chat2";

        } else {
            $auth_id = Auth::guard('doctor')->user()->id;
            $this->event_name = "SendMessage";
            $this->chat_page = "chat";
        }

        return [
            "echo-private:$this->chat_page.{$auth_id},$this->event_name" => 'broadcastMassage', 'load_conversationDoctor', 'load_conversationPatient' , 'pushMessage'
        ];
    }



    public function broadcastMassage($event) {

        //dd($event);
        $broadcastMessage = Message::find($event['message']);
        $broadcastMessage->read = 1;
        $this->pushMessage($broadcastMessage->id);
    }

    public function pushMessage($messageId){
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);  //add new message to old message
    }



    public function load_conversationDoctor(Conversation $conversation, Doctor $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = $receiver;
        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)->get();
    }

    public function load_conversationPatient(Conversation $conversation, Patient $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = $receiver;
        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)->get();
    }

    public function render()
    {

        return view('livewire.chat.chat-box');

    }




}
