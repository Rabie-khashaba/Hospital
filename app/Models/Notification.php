<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function scopeCountNotification($query , $username){
        return $query->where('user_id',auth()->user()->id)->count();
    }
}
