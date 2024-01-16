<?php

namespace App\Repository\Doctor_dashboard;

use App\Models\Diagnostic;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DiagnosisRepository implements \App\Interfaces\Doctor_dashboard\DiagnosisRepositoryInterface
{
    public function store($request){


        // invoice_status  = 1 -----تحت الاجراء
        // invoice_status  = 2 -----مراجعه
        // invoice_status  = 3 -----مكتمله


        DB::beginTransaction();
        try {
            $this->invoice_status($request->invoice_id, 3); // 3 completed
            $diagnosis = new Diagnostic();
            $diagnosis->date = date('y-m-d');
            $diagnosis->invoice_id = $request->invoice_id;
            $diagnosis->patient_id = $request->patient_id;
            $diagnosis->doctor_id = $request->doctor_id;
            $diagnosis->diagnosis = $request->diagnosis;
            $diagnosis->medicine = $request->medicine;
            $diagnosis->save();

            DB::commit();

            session()->flash('add');
            return redirect()->route('invoices.index');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function show($id){

        $patient_records = Diagnostic::where('patient_id',$id)->get();
        return view('Dashboard.Dashboard_doctor.invoice.patient_record',compact('patient_records'));

    }


    public function addReview($request){
        DB::beginTransaction();
        try {
            $this->invoice_status($request->invoice_id, 2); // 2 reviewed
            $diagnosis = new Diagnostic();
            $diagnosis->date = date('y-m-d');
            $diagnosis->review_date = date('Y-m-d H:i:s');
            $diagnosis->invoice_id = $request->invoice_id;
            $diagnosis->patient_id = $request->patient_id;
            $diagnosis->doctor_id = $request->doctor_id;
            $diagnosis->diagnosis = $request->diagnosis;
            $diagnosis->medicine = $request->medicine;
            $diagnosis->save();

            DB::commit();

            session()->flash('add');
            return redirect()->route('invoices.index');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    //function to change invoice status
    public function invoice_status($invoice_id,$id_status){
        $invoice_status = Invoice::findorFail($invoice_id);
        $invoice_status->update([
            'invoice_status'=>$id_status
        ]);
    }






}
