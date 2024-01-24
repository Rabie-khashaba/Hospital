<?php

namespace App\Repository\RayEmployee_dashboard;

use App\Interfaces\RayEmployee_dashboard\InvoicesRepositoryInterface;
use App\Models\X_rays;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class InvoicesRepository implements InvoicesRepositoryInterface
{

    use UploadImage;


    public function index()
    {
        $invoices = X_rays::where('case',0)->get();
        return view('Dashboard.Dashboard_ray_employee.invoices.index',compact('invoices'));
    }

    public function completed_invoices()
    {
        $invoices = X_rays::where('case',1)->where('employee_id',auth()->user()->id)->get();
        return view('Dashboard.Dashboard_ray_employee.invoices.completed_invoices',compact('invoices'));    }

    public function edit($id)
    {
        $invoice = X_rays::findorfail($id);
        return view('Dashboard.Dashboard_ray_employee.invoices.add_diagnosis',compact('invoice'));
    }

    public function update($request, $id)
    {

        //return $request;
        DB::beginTransaction();
        try {

            $ray = X_rays::findorfail($id);
            //return $ray;

            $ray->update([
                'employee_id'=> auth()->user()->id,
                'description_employee'=>$request->description_employee,
                'case'=> 1,
            ]);

            if( $request->hasFile( 'photos' ) ) {
                foreach ($request->photos as $photo){
                    $this->verifyAndStoreImageForeach($photo ,'Rays','upload_image', $ray->id ,'App\Models\X_rays');
                }
            }

            //save one image
            //$this->StoreImage($request, 'Rays', 'upload_image', $ray->id, 'App\Models\X_rays');

            DB::commit();
            session()->flash('edit');
            return redirect()->route('invoices_ray_employee.index');

        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function view_rays($id)
    {
        $rays = X_rays::findorfail($id);
        return view('Dashboard.Dashboard_ray_employee.invoices.patient_details',compact('rays'));

    }
}
