<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use Livewire\Component;

class Create extends Component
{


    public $doctors;
    public $doctor;
    public $sections;
    public $section;
    public $name;
    public $email;
    public $phone;
    public $notes;
    public $appointment_patient;
    public $message = false;
    public $message2 = false;


    public function mount(){
        $this->sections = Section::all();
        $this->doctors = [];  // or [] , collect ()
    }

    public function render()
    {

        return view('livewire.appointments.create',
            [
            'sections' => Section::all(),
            ]);
    }

    public function updatedSection($section_id){  // like onchange()
        $this->doctors = Doctor::where('section_id',$section_id)->get();
    }

    public function store(){


        $appointments_count = Appointment::where('doctor_id',$this->doctor )->where( 'appointment_patient' ,$this->appointment_patient)->where('type','غير مؤكد')->count();

        $doctor_info = Doctor::find($this->doctor );


        if($appointments_count == $doctor_info->number_of_statements){
            $this->message2 = true;
            return back();
        }

        $appointments = new Appointment();
        $appointments->doctor_id = $this->doctor;
        $appointments->section_id = $this->section;
        $appointments->name = $this->name;
        $appointments->email = $this->email;
        $appointments->phone = $this->phone;
        $appointments->appointment_patient = $this->appointment_patient;
        $appointments->notes = $this->notes;
        $appointments->save();
        $this->message =true;

    }

}
