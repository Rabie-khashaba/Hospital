<?php

namespace App\Repository\Ray_Employee;

use App\Models\RayEmployee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class RayEmployeeRepository implements \App\Interfaces\Ray_Employee\RayEmployeeRepositoryInterface
{

    public function index()
    {
        $ray_employees = RayEmployee::all();
        return view('Dashboard.ray_employee.index',compact('ray_employees'));
    }

    public function store($request)
    {
        //return $request;

        try {

            $ray_employee = new RayEmployee();
            $ray_employee->name = $request->name;
            $ray_employee->email = $request->email;
            $ray_employee->password = Hash::make($request->password);

            $ray_employee->save();

            session()->flash('add');
            return redirect()->route('ray_employee.index');

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request, $id)
    {
        try {


           $input = $request->all();

           if (!empty($input['password'])){
               $input['password'] = Hash::make($input['password']);
           }else{
               $input = Arr::except($input, ['password']);
           }

           $ray_employee = RayEmployee::findorfail($id);
           $ray_employee->update($input);

            session()->flash('edit');
            return redirect()->route('ray_employee.index');

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $ray_employee = RayEmployee::findorfail($id);
            $ray_employee->delete();

            session()->flash('delete');
            return redirect()->route('ray_employee.index');


        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
