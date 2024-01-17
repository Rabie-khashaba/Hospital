<?php

namespace App\Http\Controllers\Doctor_dashboard;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;
use App\Models\X_rays;
use Illuminate\Http\Request;

class patientDatialsController extends Controller
{
    public function index($id){

        $patient_records = Diagnostic::where('patient_id',$id)->get();
        $patient_rays = X_rays::where('patient_id',$id)->get();

        return view('Dashboard.Dashboard_doctor.invoice.patient_details',compact('patient_records','patient_rays'));
    }
}
