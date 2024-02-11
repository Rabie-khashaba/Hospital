<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateChat extends Component
{



    public $users ,$auth_email;

    public function render()
    {
        if (Auth::guard('patient')->check()){
            $this->users = Doctor::all();
        }else{
            $this->users = Patient::all();
        }

        //dd($this->users);

        return view('livewire.chat.create-chat')->extends('Dashboard.layouts.master');
    }

    public function mount(){
        $this->auth_email = auth()->user()->email;
    }


    public function createConversation($email){

        $checkConversation = Conversation::checkConversation($this->auth_email , $email)->get();

        if ($checkConversation->isEmpty()){


            DB::beginTransaction();
            try {

                $conversation = new Conversation();
                $conversation->sender_email = $this->auth_email;
                $conversation->receiver_email = $email;
                $conversation->save();

                Message::create([
                    'conversation_id'=> $conversation->id,
                    'sender_email'=> $this->auth_email,
                    'receiver_email'=> $email,
                    'body'=> 'السلام عليكم ورحمه الله',
                ]);

                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }



        }else{

            dd('This Conversation Exsited before');
        }
    }
}
