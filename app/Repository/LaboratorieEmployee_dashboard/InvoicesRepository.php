<?php

namespace App\Repository\LaboratorieEmployee_dashboard;


use App\Models\Laboratorie;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\DB;


class InvoicesRepository implements \App\Interfaces\LaboratorieEmployee_dashboard\InvoicesRepositoryInterface
{

    use UploadImage;


    public function index()
    {
        $invoices = Laboratorie::where('case',0)->get();
        return view('Dashboard.Dashboard_laboratorie_employee.invoices.index',compact('invoices'));
    }

    public function completed_invoices()
    {

        //return "completed";
        $invoices = Laboratorie::where('case',1)->get();
        return view('Dashboard.Dashboard_laboratorie_employee.invoices.completed_invoices',compact('invoices'));
    }

    public function edit($id)
    {
        $invoice = Laboratorie::findorfail($id);
        return view('Dashboard.Dashboard_laboratorie_employee.invoices.add_diagnosis',compact('invoice'));
    }

    public function update($request, $id)
    {

        DB::beginTransaction();
        try {

            $laboratorie = Laboratorie::findorfail($id);

            $laboratorie->update([
                'employee_id'=> auth()->user()->id,
                'description_employee'=>$request->description_employee,
                'case'=> 1,
            ]);

            if( $request->hasFile( 'photos' ) ) {
                foreach ($request->photos as $photo){
                    $this->verifyAndStoreImageForeach($photo ,'Laboratories','upload_image', $laboratorie->id ,'App\Models\Laboratorie');
                }
            }

            DB::commit();
            session()->flash('edit');
            return redirect()->route('invoices_laboratorie_employee.index');

        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function view_laboratories($id)
    {
        $laboratorie = Laboratorie::findorfail($id);
        return view('Dashboard.Dashboard_laboratorie_employee.invoices.patient_details',compact('laboratorie'));
    }
}
