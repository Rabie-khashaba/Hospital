<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class SingleInvoice extends Component
{


    public $InvoiceSaved,$InvoiceUpdated , $InvoiceDeleted;
    public $show_table = true;
    public $username;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price,$discount_value = 0 ,$patient_id,$doctor_id,$section_name,$type,$Service_id,$single_invoice_id,$catchError;


    public function render()
    {
        return view('livewire.single_invoices.single-invoice',[
            'single_invoices'=>\App\Models\Invoice::where('invoice_type',1)->get(),
            'Patients'=> Patient::all(),
            'Doctors'=> Doctor::all(),
            'Services'=> Service::all(),
            'subtotal' => $Total_after_discount = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'tax_value'=> $Total_after_discount * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100)
        ]);
    }

    public function show_form_add(){
        $this->show_table = false;

    }


    public function get_section(){
        $doctor = Doctor::with('section')->where('id',  $this->doctor_id)->first();
        $this->section_name = $doctor->section->name;
    }

    public function get_price(){
        $Service = Service::where('id',$this->Service_id)->first();
        $this->price = $Service->price;
    }

    public function print($id){
        $single_invoice = \App\Models\Invoice::findorfail($id);
        return Redirect::route('Print_single_invoices',[
            'invoice_date' => $single_invoice->invoice_date,
            'doctor_id' => $single_invoice->Doctor->name,
            'section_id' => $single_invoice->Section->name,
            'Service_id' => $single_invoice->Service->name,
            'type' => $single_invoice->type,
            'price' => $single_invoice->price,
            'discount_value' => $single_invoice->discount_value,
            'tax_rate' => $single_invoice->tax_rate,
            'total_with_tax' => $single_invoice->total_with_tax,
            ]);
    }

    public function edit($id){
        //dd($id);
        $this->updateMode = true;
        $this->show_table = false;

        //get data of this id (SingleInvoice)
        $single_invoice = \App\Models\Invoice::findorfail($id);
        //dd($single_invoice);
        $this->single_invoice_id = $single_invoice->id;
        $this->patient_id = $single_invoice->patient_id;
        $this->doctor_id = $single_invoice->doctor_id;
        $this->section_name = Section::where('id',$single_invoice->section_id)->first()->name;
        $this->Service_id = $single_invoice->Service_id;
        $this->price = $single_invoice->price;
        $this->discount_value = $single_invoice->discount_value;
        $this->type = $single_invoice->type;



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
                    $single_invoices = \App\Models\Invoice::FindorFail($this->single_invoice_id);
                    $single_invoices->invoice_type = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->patient_id = $this->patient_id;
                    $single_invoices->doctor_id = $this->doctor_id;
                    $single_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                    $single_invoices->Service_id = $this->Service_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price - $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = 1;
                    // $single_invoices->invoice_status = 1;
                    $single_invoices->save();


                    //Update in FundAccount
                    $fundAccount = new FundAccount();
                    $fundAccount->date = date('Y-m-d');
                    $fundAccount->invoice_id = $single_invoices->id;
                    $fundAccount->Debit = $single_invoices->total_with_tax;
                    $fundAccount->credit = 0.00;
                    $fundAccount->save();

                    $this->InvoiceUpdated = true;
                    $this->show_table = true;


                }

                //insert (store)
                else{
                    //save in SingleInvoice
                    $single_invoices = new \App\Models\Invoice();
                    $single_invoices->invoice_type = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->patient_id = $this->patient_id;
                    $single_invoices->doctor_id = $this->doctor_id;
                    $single_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                    $single_invoices->Service_id = $this->Service_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price - $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    // $single_invoices->invoice_status = 1;
                    $single_invoices->save();


                    //save in FundAccount
                    $fundAccount = new FundAccount();
                    $fundAccount->date = date('Y-m-d');
                    $fundAccount->invoice_id = $single_invoices->id;
                    $fundAccount->Debit = $single_invoices->total_with_tax;
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
                  $single_invoices = \App\Models\Invoice::FindorFail($this->single_invoice_id);
                  $single_invoices->invoice_type = 1;
                  $single_invoices->invoice_date = date('Y-m-d');
                  $single_invoices->patient_id = $this->patient_id;
                  $single_invoices->doctor_id = $this->doctor_id;
                  $single_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                  $single_invoices->Service_id = $this->Service_id;
                  $single_invoices->price = $this->price;
                  $single_invoices->discount_value = $this->discount_value;
                  $single_invoices->tax_rate = $this->tax_rate;
                  // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                  $single_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                  // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                  $single_invoices->total_with_tax = $single_invoices->price - $single_invoices->discount_value + $single_invoices->tax_value;
                  $single_invoices->type = 2;
                  // $single_invoices->invoice_status = 1;
                  $single_invoices->save();


                  //save in PatientAccount
                  $patientAccount = new PatientAccount();
                  $patientAccount->date = date('Y-m-d');
                  $patientAccount->patient_id = $single_invoices->patient_id;
                  $patientAccount->invoice_id = $single_invoices->id;
                  $patientAccount->Debit =$single_invoices->total_with_tax ;
                  $patientAccount->credit =0.00;
                  $patientAccount->save();



                  $this->InvoiceUpdated = true;
                  $this->show_table = true;



              }else{

                  //save in SingleInvoice
                  $single_invoices = new \App\Models\Invoice();
                  $single_invoices->invoice_type = 1;
                  $single_invoices->invoice_date = date('Y-m-d');
                  $single_invoices->patient_id = $this->patient_id;
                  $single_invoices->doctor_id = $this->doctor_id;
                  $single_invoices->section_id = DB::table('section_translations')->where('name', $this->section_name)->first()->section_id;
                  $single_invoices->Service_id = $this->Service_id;
                  $single_invoices->price = $this->price;
                  $single_invoices->discount_value = $this->discount_value;
                  $single_invoices->tax_rate = $this->tax_rate;
                  // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                  $single_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                  // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                  $single_invoices->total_with_tax = $single_invoices->price - $single_invoices->discount_value + $single_invoices->tax_value;
                  $single_invoices->type = $this->type;
                  // $single_invoices->invoice_status = 1;
                  $single_invoices->save();

                  //save in PatientAccount
                  $patientAccount = new PatientAccount();
                  $patientAccount->date = date('Y-m-d');
                  $patientAccount->patient_id = $single_invoices->patient_id;
                  $patientAccount->invoice_id = $single_invoices->id;
                  $patientAccount->Debit =$single_invoices->total_with_tax ;
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

        $this->single_invoice_id = $id;
    }

    public function destroy(){

        \App\Models\Invoice::destroy($this->single_invoice_id);
        //$this->InvoiceDeleted = true;
        return redirect()->route('SingleServiceInvoice');

    }




}
