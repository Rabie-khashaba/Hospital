<?php

namespace App\Repository\Patient_dashboard;

use App\Models\Invoice;
use App\Models\Laboratorie;
use App\Models\PaymentAccount;
use App\Models\X_rays;

class PatientRepository implements \App\Interfaces\Patient_dashboard\PatientRepositoryInterface
{


    public function invoices()
    {
        $invoices = Invoice::where('patient_id' , auth()->user()->id)->get();
        return view('Dashboard.Dashboard_patient.invoices',compact('invoices'));
    }



    public function ray()
    {
        $rays = X_rays::where('patient_id' , auth()->user()->id)->get();
        return view('Dashboard.Dashboard_patient.rays',compact('rays'));

    }

    public function Laboratorie()
    {
        $laboratories = X_rays::where('patient_id' , auth()->user()->id)->get();
        return view('Dashboard.Dashboard_patient.laboratories',compact('laboratories'));

    }



    public function view_laboratories($id)
    {
        $laboratorie = Laboratorie::findorfail($id);
        return view('Dashboard.Dashboard_laboratorie_employee.invoices.patient_details',compact('laboratorie'));
    }

    public function view_rays($id)
    {

        $rays = X_rays::findorfail($id);
        return view('Dashboard.Dashboard_ray_employee.invoices.patient_details',compact('rays'));

    }

    public function payments(){
        $payments = PaymentAccount::where('patient_id' , auth()->user()->id)->get();
        return view('Dashboard.Dashboard_ray_employee.invoices.payments',compact('payments'));

    }



}
