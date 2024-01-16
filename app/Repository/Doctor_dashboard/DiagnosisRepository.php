<?php

namespace App\Repository\Doctor_dashboard;

use App\Models\Diagnostic;

class DiagnosisRepository implements \App\Interfaces\Doctor_dashboard\DiagnosisRepositoryInterface
{
    public function store($request){

        $diagnosis = new Diagnostic();

        $diagnosis->date = date('y-m-d');
        $diagnosis->invoice_id = $request->invoice_id;
        $diagnosis->patient_id = $request->patient_id;
        $diagnosis->doctor_id = $request->doctor_id;
        $diagnosis->diagnosis = $request->diagnosis;
        $diagnosis->medicine = $request->medicine;
        $diagnosis->save();

        session()->flash('add');
        return redirect()->route('invoices.index');

    }

    public function show($id){


        $patient_records = Diagnostic::where('patient_id',$id)->get();
        return view('Dashboard.Dashboard_doctor.invoice.patient_record',compact('patient_records'));

    }




}
