<?php

namespace App\Repository\Finance;

use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use App\Models\SingleInvoice;
use Illuminate\Support\Facades\DB;

class ReceiptRepository implements \App\Interfaces\Finance\ReceiptRepositoryInterface
{
    // get All Receipt
    public function index(){

        $receipts = ReceiptAccount::all();
        return view('Dashboard.Receipt.index',compact('receipts'));

    }

    // show form add
    public function create(){
        $Patients = Patient::all();
        return view('Dashboard.Receipt.add',compact('Patients'));
    }

    // store Receipt
    public function store($request){



        DB::beginTransaction();
        try {

            //save سند القبض
            $ReceiptAccount = new ReceiptAccount();
            $ReceiptAccount->date = date('y-m-d');
            $ReceiptAccount->patient_id =$request->patient_id;
            $ReceiptAccount->amount = $request->Debit;
            $ReceiptAccount->description = $request->description;
            $ReceiptAccount->save();

            //save in patientAccount
            $patientAccount = new PatientAccount();
            $patientAccount->date = date('y-m-d');
            $patientAccount->patient_id = $request->patient_id;
            $patientAccount->receipt_id = $ReceiptAccount->id;
            //$patientAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $patientAccount->Debit = 0.00;
            $patientAccount->credit = $request->Debit;
            $patientAccount->save();

            //save in FundAccount
            $fundAccount = new FundAccount();
            $fundAccount->date = date('y-m-d');
            $fundAccount->receipt_id = $ReceiptAccount->id;
            //$fundAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $fundAccount->Debit = $request->Debit;
            $fundAccount->credit = 0.00;
            $fundAccount->save();

            DB::commit();
            session()->flash('add');
            return redirect()->route('Receipt.index');


        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // edit Receipt
    public function edit($id){
        $Patients = Patient::all();
        $receipt_accounts = ReceiptAccount::findorfail($id);
        //return  $receipt_accounts;
        return view('Dashboard.Receipt.edit',compact('Patients','receipt_accounts'));
    }

    // show Receipt
    public function show($id){

        $receipt = ReceiptAccount::findorfail($id);
        return view('Dashboard.Receipt.print',compact('receipt'));

    }

    // Update Receipt
    public function update($request){

        DB::beginTransaction();
        try {

            //save سند القبض
            $ReceiptAccount = ReceiptAccount::findorfail($request->id);
            $ReceiptAccount->date = date('y-m-d');
            $ReceiptAccount->patient_id =$request->patient_id;
            $ReceiptAccount->amount = $request->Debit;
            $ReceiptAccount->description = $request->description;
            $ReceiptAccount->save();

            //save in patientAccount
            $patientAccount = PatientAccount::where('receipt_id',$request->id)->first();
            $patientAccount->date = date('y-m-d');
            $patientAccount->patient_id = $request->patient_id;
            $patientAccount->receipt_id = $ReceiptAccount->id;
            //$patientAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $patientAccount->Debit = 0.00;
            $patientAccount->credit = $request->Debit;
            $patientAccount->save();

            //save in FundAccount
            $fundAccount = FundAccount::where('receipt_id',$request->id)->first();
            $fundAccount->date = date('y-m-d');
            $fundAccount->receipt_id = $ReceiptAccount->id;
            //$fundAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $fundAccount->Debit = $request->Debit;
            $fundAccount->credit = 0.00;
            $fundAccount->save();

            DB::commit();
            session()->flash('edit');
            return redirect()->route('Receipt.index');


        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // destroy Receipt
    public function destroy($request){

        ReceiptAccount::destroy($request->id);
        session()->flash('delete');
        return redirect()->route('Receipt.index');

    }

}
