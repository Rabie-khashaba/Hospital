<?php

namespace App\Http\Controllers\Dashboard\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(){

        $appointments = Appointment::where('type' , 'غير مؤكد')->get();
        return view('Dashboard.Appointments.index',compact('appointments'));
    }


    public function index2(){

        $appointments = Appointment::where('type' , 'مؤكد')->get();
        return view('Dashboard.Appointments.index2',compact('appointments'));
    }
    public function index3(){

        $appointments = Appointment::where('type' , 'منتهي')->get();
        return view('Dashboard.Appointments.index3',compact('appointments'));
    }



    public function approval($id , Request $request){

        $appointment =  Appointment::find($id);
        $appointment->update([
            'type'=>'مؤكد',
            'appointment'=> $request->appointment,
        ]);

        session()->flash('add');
        return back();
    }



    public function finished($id){
        $appointment =  Appointment::find($id);

        $appointment->update([
            'type'=>'منتهي',
        ]);

        session()->flash('delete');
        return back();


    }


}
