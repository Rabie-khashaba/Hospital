<?php

namespace App\Repository\Doctor_dashboard;

use App\Models\X_rays;

class RaysRepository implements \App\Interfaces\Doctor_dashboard\RaysRepositoryInterface
{

    public function store($request)
    {
        //return $request;

        try {

            X_rays::create([
                'description'=>$request->description,
                'invoice_id'=>$request->invoice_id,
                'patient_id'=>$request->patient_id,
                'doctor_id'=>$request->doctor_id,
            ]);


            session()->flash('add');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request , $id)
    {

        try {

            $xray = X_rays::findorfail($id);
            $xray->update([
                'description'=>$request->description,
            ]);


            session()->flash('edit');
            return redirect()->route('patient_details');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function delete($id)
    {

        try {
            $xray = X_rays::findorfail($id);
            $xray->delete();
            session()->flash('delete');
            return redirect()->route('patient_details');


        }catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
