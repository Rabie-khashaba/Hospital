<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Laboratorie_Emplolyee\LaboratorieEmployeeRepositoryInterface;
use Illuminate\Http\Request;

class LaboratorieEmployeeController extends Controller
{
    private $Laboratorie_employee;
    public function __construct(LaboratorieEmployeeRepositoryInterface $Laboratorie_employee){
        $this->Laboratorie_employee = $Laboratorie_employee;
    }
    public function index()
    {
        return $this->Laboratorie_employee->index();
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        return $this->Laboratorie_employee->store($request);


    }



    public function update(Request $request, $id)
    {
        return $this->Laboratorie_employee->update($request,$id);

    }


    public function destroy( $id)
    {
        return $this->Laboratorie_employee->destroy($id);

    }
}
