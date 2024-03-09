<?php

namespace App\Http\Controllers\Dashboard\Appointment;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

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


        // send email
        Mail::to($appointment->email)->send(new AppointmentConfirmation($appointment->name,$appointment->appointment));

        //send SMS
        $receiverNumber = $appointment->phone; // Replace with the recipient's phone number
        $message = "عزيزي المريض" . " " . $appointment->name . " " . "تم حجز موعدك وعليك التوجهه للمريض في هذاالتوقيت " . $appointment->appointment ;

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $fromNumber = env('TWILIO_FROM');
        $client = new Client($sid, $token);
        $client->messages->create($receiverNumber, [
            'from' => $fromNumber,
            'body' => $message
        ]);


        session()->flash('appointmentConfirm');
        return back();
    }



    public function destroy($id){
        $appointment =  Appointment::find($id);
        $appointment->delete();

        session()->flash('delete');
        return back();

    }





}
