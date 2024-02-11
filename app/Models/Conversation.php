<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function scopeCheckConversation($query , $sender_email , $reciever_email){
        return $query->where('sender_email',$sender_email)->where('receiver_email',$reciever_email)->
        orwhere('sender_email',$reciever_email)->where('receiver_email',$sender_email);
    }


    public function messages(){
        return $this->hasMany(Message::class);
    }
}
