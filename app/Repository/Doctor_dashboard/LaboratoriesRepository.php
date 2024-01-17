<?php

namespace App\Repository\Doctor_dashboard;

use App\Models\Laboratorie;

class LaboratoriesRepository implements \App\Interfaces\Doctor_dashboard\LaboratoriesRepositoryInterface
{

    public function store($request)
    {

        //return   $request;
        try {

            Laboratorie::create([
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

    public function update($request, $id)
    {
        try {

            $xray = Laboratorie::findorfail($id);
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
            $xray = Laboratorie::findorfail($id);
            $xray->delete();
            session()->flash('delete');
            return redirect()->route('patient_details');


        }catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
