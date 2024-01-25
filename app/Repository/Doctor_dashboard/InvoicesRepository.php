<?php

namespace App\Repository\Doctor_dashboard;

use App\Interfaces\Doctor_dashboard\InvoicesRepositoryInterface;
use App\Models\Invoice;
use App\Models\X_rays;
use Illuminate\Support\Facades\Auth;

class InvoicesRepository implements InvoicesRepositoryInterface
{
    // Get Invoices Doctor
    public function index(){
        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status',1)->get();//1 = فواتير تحت الاجراء
        return view('Dashboard.Dashboard_doctor.invoice.index',compact('invoices'));
    }

    // Get reviewInvoices Doctor
    public function reviewInvoices(){

        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status',2)->get();//1 = فواتير تحت الاجراء
        return view('Dashboard.Dashboard_doctor.invoice.review_invoices',compact('invoices'));
    }

    // Get completedInvoices Doctor
    public function completedInvoices(){
        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status',3)->get();//1 = فواتير تحت الاجراء
        return view('Dashboard.Dashboard_doctor.invoice.completed_invoices',compact('invoices'));
    }

    // View rays
    public function show($id){
        $rays = X_rays::findorfail($id);
        return view('Dashboard.Dashboard_doctor.invoice.view_rays',compact('rays'));
    }

    // View Laboratories
    public function showLaboratorie($id){}

}
