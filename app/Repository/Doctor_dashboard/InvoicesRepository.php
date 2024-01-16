<?php

namespace App\Repository\Doctor_dashboard;

use App\Interfaces\Doctor_dashboard\InvoicesRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoicesRepository implements InvoicesRepositoryInterface
{
    // Get Invoices Doctor
    public function index(){
        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status',1)->get();
        return view('Dashboard.Dashboard_doctor.invoice.index',compact('invoices'));
    }

    // Get reviewInvoices Doctor
    public function reviewInvoices(){}

    // Get completedInvoices Doctor
    public function completedInvoices(){}

    // View rays
    public function show($id){}

    // View Laboratories
    public function showLaboratorie($id){}

}
