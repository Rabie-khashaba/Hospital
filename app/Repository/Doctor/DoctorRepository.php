<?php

namespace App\Repository\Doctor;

use App\Interfaces\Doctor\DoctorRepositoryInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DoctorRepository implements DoctorRepositoryInterface
{

    use UploadImage;

    public function index()
    {
        $doctors = Doctor::all();
        //return  $doctors;
        return view("Dashboard.Doctors.index",compact('doctors'));
    }



    // create Doctor
    public function create(){

        $appointments = Appointment::all();
        $sections = Section::all();
        return view("Dashboard.Doctors.add",compact('appointments','sections'));
    }

    // store Doctor
    public function store($request){


        DB::beginTransaction();
        try {
            //return $request;

            $doctor = new Doctor();
            $doctor->name = $request->name;
            $doctor->email = $request->email;
            $doctor->password = Hash::make($request->password);
            $doctor->phone = $request->phone;
            $doctor->section_id = $request->section_id;
            $doctor->status = 1;

            $doctor->save();

            // insert pivot tABLE
            $doctor->doctorappointments()->attach($request->appointments);

            //Upload image
            $this->StoreImage($request,'Doctors','upload_image',$doctor->id,'App\Models\Doctor');

            DB::commit();

            session()->flash('add');
            return redirect()->route('Doctors.create');



        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    // update Doctor
    public function update($request){
        DB::beginTransaction();
        try {
            //return $request;
            $doctor = Doctor::findOrfail($request->id);

            //Update table doctor
            $doctor->name = $request->name;
            $doctor->email = $request->email;
            $doctor->password = Hash::make("11111111");
            $doctor->phone = $request->phone;
            $doctor->section_id = $request->section_id;
            $doctor->save();

            // Update pivot table
            $doctor->doctorappointments()->sync($request->appointments);


            //Update Image if Exist

            if($request->has('photo')) {

                // Delete old photo
                if ($doctor->image){
                    $old_img = $doctor->image->filename;
                    $this->Delete_attachment('upload_image','Doctors/'.$old_img,$request->id);
                }
                //Upload img
                //$this->StoreImage($request,'photo','Doctors','upload_image',$request->id,'App\Models\Doctor');
                $this->StoreImage($request,'Doctors','upload_image',$doctor->id,'App\Models\Doctor');
            }

            DB::commit();
            session()->flash('edit');
            return redirect()->route('Doctors.index');

        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

    }

    // destroy Doctor
    public function destroy($request){

        if($request->page_id==1){

           // return $request;
            if($request->filename){

                $this->Delete_attachment('upload_image','Doctors/'.$request->filename,$request->id);
            }
            Doctor::destroy($request->id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        }

        //---------------------------------------------------------------

        else{

            // delete selector doctor
            $delete_select_id = explode(",", $request->delete_select_id);
            foreach ($delete_select_id as $ids_doctors){
                $doctor = Doctor::findorfail($ids_doctors);
                if($doctor->image){
                    $this->Delete_attachment('upload_image','doctors/'.$doctor->image->filename,$ids_doctors);
                }
            }

            Doctor::destroy($delete_select_id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        }

    }
    // destroy Doctor
    public function edit($id){
        $doctor = Doctor::findOrFail($id);
        $sections = Section::all();
        $appointments = Appointment::all();
        return view('Dashboard.Doctors.edit',compact('doctor','sections','appointments'));
    }

    // update_password
    public function update_password($request){
        try {

            $doctor = Doctor::findOrFail($request->id);

            $doctor->update([
                'password'=> Hash::make($request->password),
            ]);
            session()->flash('edit');
            return redirect()->route('Doctors.index');


        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // update_status
    public function update_status($request){
        try {

            $doctor = Doctor::findOrFail($request->id);

            $doctor->update([
                'status'=> $request->status,
            ]);
            session()->flash('edit');
            return redirect()->route('Doctors.index');


        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }




}
