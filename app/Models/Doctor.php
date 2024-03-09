<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['name',];
    public $fillable= ['email','email_verified_at','password','phone','section_id','status','name','number_of_statements'];


    /**
     * Get the Doctor's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function section(){

        return $this->belongsTo('App\Models\Section' , 'section_id');
    }

    public function doctorappointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class ,'appoinment_doctors', 'doctor_id','appointment_id')->withTimestamps();
    }
}

