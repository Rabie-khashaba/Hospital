<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Ray_Employee\RayEmployeeRepositoryInterface;
use App\Models\RayEmployee;
use Illuminate\Http\Request;

class RayEmployeeController extends Controller
{

    private $ray_employee;
    public function __construct(RayEmployeeRepositoryInterface $ray_employee){
        $this->ray_employee = $ray_employee;
    }
    public function index()
    {
        return $this->ray_employee->index();
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        return $this->ray_employee->store($request);


    }



    public function update(Request $request, $id)
    {
        return $this->ray_employee->update($request,$id);

    }


    public function destroy( $id)
    {
        return $this->ray_employee->destroy($id);

    }
}
