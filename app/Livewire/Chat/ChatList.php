<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatList extends Component
{

    public $conversations ,
        $auth_email,  $receiverUser ,$selectedConversation;

    public function mount()
    {
        $this->auth_email = auth()->user()->email;
    }



    public function render()
    {

        $this->conversations = Conversation::where('sender_email',$this->auth_email)
            ->orwhere('receiver_email',$this->auth_email)
            ->orderBy('created_at','DESC')
            ->get();

        return view('livewire.chat.chat-list')->extends('Dashboard.layouts.master');
    }

    public function getUsers(Conversation $conversation , $request){

        if ($conversation->sender_email == $this->auth_email){
            $this->receiverUser = Doctor::firstwhere('email',$conversation->receiver_email) ?? Patient::firstwhere('email',$conversation->receiver_email) ;

        }else{
            $this->receiverUser = Patient::firstwhere('email',$conversation->sender_email) ?? Doctor::firstwhere('email',$conversation->sender_email);
        }

        if (isset($request)){
            return $this->receiverUser->$request;
        }

    }


    public function chatUserSelected(Conversation $conversation , $receiver_id){

        $this->selectedConversation = $conversation;

        if (Auth::guard('patient')->check()){
            $this->receiverUser = Doctor::findorfail($receiver_id);
            $this->emitTo('chat.chat-box','load_conversationDoctor',$this->selectedConversation, $this->receiverUser);

        }else{
            $this->receiverUser = Patient::findorfail($receiver_id);
            $this->emitTo('chat.chat-box','load_conversationPatient',$this->selectedConversation, $this->receiverUser);

        }

    }


}
