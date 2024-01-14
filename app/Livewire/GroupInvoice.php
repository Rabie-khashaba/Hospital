<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\Group;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class GroupInvoice extends Component
{
    public $InvoiceSaved,$InvoiceUpdated , $InvoiceDeleted;
    public $show_table = true;
    public $username;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price,$discount_value = 0 ,$patient_id,$doctor_id,$section_name,$type,$Group_id,$Group_invoice_id,$catchError;



    public function render()
    {
        return view('livewire.Group_Invoices.group-invoice',[
            'group_invoices'=>\App\Models\Invoice::where('invoice_type',2)->get(),
            'Patients'=> Patient::all(),
            'Doctors'=> Doctor::all(),
            'Groups'=> Group::all(),
            'subtotal' => $Total_after_discount = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'tax_value'=> $Total_after_discount * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100)]);

    }


    public function show_form_add(){
       return $this->show_table = false;
    }


    public function get_section(){
        $doctor = Doctor::where('id', $this->doctor_id)->first();
        $this->section_name = $doctor->section->name;
    }


    public function get_price(){
        $group = Group::where('id',$this->Group_id)->first();
        $this->price = $group->Total_with_tax;
    }


    public function edit($id){
        //dd($id);
        $this->updateMode = true;
        $this->show_table = false;

        //get data of this id (SingleInvoice)
        $group_invoice = \App\Models\Invoice::findorfail($id);
        //dd($single_invoice);
        $this->Group_invoice_id = $group_invoice->id;
        $this->patient_id = $group_invoice->patient_id;
        $this->doctor_id = $group_invoice->doctor_id;
        $this->section_name = Section::where('id',$group_invoice->section_id)->first()->name;
        $this->Group_id = $group_invoice->Group_id;
        $this->price = $group_invoice->price;
        $this->tax_rate = $group_invoice->tax_rate;
        $this->tax_value = $group_invoice->tax_value;
        $this->discount_value = $group_invoice->discount_value;
        $this->type = $group_invoice->type;


    }


    public function store()
    {

        DB::beginTransaction();
        try {
            // نقدي
            if ($this->type == 1) {

                //Update
                if($this->updateMode){

                    // Update in SingleInvoice
                    $group_invoices = \App\Models\Invoice::FindorFail($this->Group_invoice_id);
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price - $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = 1;
                    // $single_invoices->invoice_status = 1;
                    $group_invoices->save();


                    //Update in FundAccount
                    $fundAccount = new FundAccount();
                    $fundAccount->date = date('Y-m-d');
                    $fundAccount->invoice_id = $group_invoices->id;
                    $fundAccount->Debit = $group_invoices->total_with_tax;
                    $fundAccount->credit = 0.00;
                    $fundAccount->save();

                    $this->InvoiceUpdated = true;
                    $this->show_table = true;


                }

                //insert (store)
                else{
                    //save in SingleInvoice
                    $group_invoices = new \App\Models\Invoice();
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price - $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    // $single_invoices->invoice_status = 1;
                    $group_invoices->save();


                    //save in FundAccount
                    $fundAccount = new FundAccount();
                    $fundAccount->date = date('Y-m-d');
                    $fundAccount->invoice_id = $group_invoices->id;
                    $fundAccount->Debit = $group_invoices->total_with_tax;
                    $fundAccount->credit = 0.00;
                    $fundAccount->save();

                    $this->InvoiceSaved = true;
                    $this->show_table = true;
                }



            }
            // اجل
            else{

                if($this->updateMode){

                    //Update in SingleInvoice
                    $group_invoices = \App\Models\Invoice::FindorFail($this->Group_invoice_id);
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price - $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = 2;
                    // $single_invoices->invoice_status = 1;
                    $group_invoices->save();


                    //save in PatientAccount
                    $patientAccount = new PatientAccount();
                    $patientAccount->date = date('Y-m-d');
                    $patientAccount->patient_id = $group_invoices->patient_id;
                    $patientAccount->invoice_id = $group_invoices->id;
                    $patientAccount->Debit =$group_invoices->total_with_tax ;
                    $patientAccount->credit =0.00;
                    $patientAccount->save();



                    $this->InvoiceUpdated = true;
                    $this->show_table = true;



                }else{

                    //save in SingleInvoice
                    $group_invoices = new \App\Models\Invoice();
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price - $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    // $single_invoices->invoice_status = 1;
                    $group_invoices->save();

                    //save in PatientAccount
                    $patientAccount = new PatientAccount();
                    $patientAccount->date = date('Y-m-d');
                    $patientAccount->patient_id = $group_invoices->patient_id;
                    $patientAccount->invoice_id = $group_invoices->id;
                    $patientAccount->Debit =$group_invoices->total_with_tax ;
                    $patientAccount->credit =0.00;
                    $patientAccount->save();



                    $this->InvoiceSaved = true;
                    $this->show_table = true;

                }
            }

            DB::commit();


        }catch (\Exception $e) {
            DB::rollback();
            $this->catchError = $e->getMessage();
        }


    }


    public function delete($id){

        $this->Group_invoice_id = $id;
    }

    public function destroy(){

        \App\Models\Invoice::destroy($this->Group_invoice_id);
        //$this->InvoiceDeleted = true;
        return redirect()->route('GroupServiceInvoice');

    }



    public function print($id){

        $group_invoice = \App\Models\Invoice::findorfail($id);
        return Redirect::route('group_Print_single_invoices',[
            'invoice_date' => $group_invoice->invoice_date,
            'doctor_id' => $group_invoice->Doctor->name,
            'section_id' => $group_invoice->Section->name,
            'Group_id' => $group_invoice->Group->name,
            'type' => $group_invoice->type,
            'price' => $group_invoice->price,
            'discount_value' => $group_invoice->discount_value,
            'tax_rate' => $group_invoice->tax_rate,
            'total_with_tax' => $group_invoice->total_with_tax,
        ]);
    }





}
