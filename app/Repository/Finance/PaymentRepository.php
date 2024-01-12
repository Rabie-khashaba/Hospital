<?php

namespace App\Repository\Finance;

use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\PaymentAccount;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements \App\Interfaces\Finance\PaymentRepositoryInterface
{
    // get All Payment
    public function index(){
        $payments = PaymentAccount::all();
        return view('Dashboard.Payment.index',compact('payments'));
    }

    // show form add
    public function create(){
        $Patients = Patient::all();
        return view('Dashboard.Payment.add',compact('Patients'));
    }

    // store Payment
    public function store($request){
       // return $request;
        DB::beginTransaction();
        try {

            //save سند القبض
            $PaymentAccount = new PaymentAccount();
            $PaymentAccount->date = date('y-m-d');
            $PaymentAccount->patient_id =$request->patient_id;
            $PaymentAccount->amount = $request->credit;
            $PaymentAccount->description = $request->description;
            $PaymentAccount->save();

            //save in patientAccount
            $patientAccount = new PatientAccount();
            $patientAccount->date = date('y-m-d');
            $patientAccount->patient_id = $request->patient_id;
            $patientAccount->Payment_id = $PaymentAccount->id;
            //$patientAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $patientAccount->Debit =$request->credit;   //المريض ال هياخد باقي المبلغ بتاعه
            $patientAccount->credit = 0.00;
            $patientAccount->save();

            //save in FundAccount
            $fundAccount = new FundAccount();
            $fundAccount->date = date('y-m-d');
            $fundAccount->Payment_id = $PaymentAccount->id;
            //$fundAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $fundAccount->Debit = 0.00;
            $fundAccount->credit = $request->credit; // الصندوق ال دافع
            $fundAccount->save();

            DB::commit();
            session()->flash('add');
            return redirect()->route('Payment.index');


        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    // edit Payment
    public function edit($id){

        $Patients = Patient::all();
        $payment_accounts = PaymentAccount::findorfail($id);
        return view('Dashboard.Payment.edit',compact('Patients','payment_accounts'));

    }

    // show Payment
    public function show($id){

    }

    // Update Payment
    public function update($request){
        //return $request;

        DB::beginTransaction();
        try {

            //save سند القبض
            $PaymentAccount = PaymentAccount::findorfail($request->id);
            $PaymentAccount->date = date('y-m-d');
            $PaymentAccount->patient_id =$request->patient_id;
            $PaymentAccount->amount = $request->credit;
            $PaymentAccount->description = $request->description;
            $PaymentAccount->save();

            //save in patientAccount
            $patientAccount = PatientAccount::where('Payment_id',$request->id)->first();
            $patientAccount->date = date('y-m-d');
            $patientAccount->patient_id = $request->patient_id;
            $patientAccount->Payment_id = $PaymentAccount->id;
            //$patientAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $patientAccount->Debit =$request->credit;   //المريض ال هياخد باقي المبلغ بتاعه
            $patientAccount->credit = 0.00;
            $patientAccount->save();

            //save in FundAccount
            $fundAccount = FundAccount::where('Payment_id',$request->id)->first();
            $fundAccount->date = date('y-m-d');
            $fundAccount->Payment_id = $PaymentAccount->id;
            //$fundAccount->Single_invoices_id = SingleInvoice::where('patient_id',$request->patient_id )->first()->id;
            $fundAccount->Debit = 0.00;
            $fundAccount->credit = $request->credit; // الصندوق ال دافع
            $fundAccount->save();

            DB::commit();
            session()->flash('edit');
            return redirect()->route('Payment.index');


        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    // destroy Payment
    public function destroy($request){

        try {

            PaymentAccount::destroy($request->id);
            session()->flash('delete');
            return redirect()->route('Payment.index');

        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
