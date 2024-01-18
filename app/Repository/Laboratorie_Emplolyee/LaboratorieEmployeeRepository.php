<?php

namespace App\Repository\Laboratorie_Emplolyee;

use App\Interfaces\Laboratorie_Emplolyee\LaboratorieEmployeeRepositoryInterface;
use App\Models\LaboratorieEmployee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class LaboratorieEmployeeRepository implements LaboratorieEmployeeRepositoryInterface
{

    public function index()
    {
        $laboratorie_employees = LaboratorieEmployee::all();
        return view('Dashboard.laboratorie_employee.index',compact('laboratorie_employees'));
    }

    public function store($request)
    {
        try {

            $laboratorie_employee = new LaboratorieEmployee();
            $laboratorie_employee->name = $request->name;
            $laboratorie_employee->email = $request->email;
            $laboratorie_employee->password = Hash::make($request->password);

            $laboratorie_employee->save();

            session()->flash('add');
            return redirect()->route('laboratorie_employee.index');

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

            $laboratorie_employee = LaboratorieEmployee::findorfail($id);
            $laboratorie_employee->update($input);

            session()->flash('edit');
            return redirect()->route('laboratorie_employee.index');

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function destroy($id)
    {
        try {
            $laboratorie_employee = LaboratorieEmployee::findorfail($id);
            $laboratorie_employee->delete();

            session()->flash('delete');
            return redirect()->route('laboratorie_employee.index');

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
