<?php

namespace App\Http\Controllers\Doctor_dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctor_dashboard\LaboratoriesRepositoryInterface;
use Illuminate\Http\Request;

class LaboratoriesController extends Controller
{

    private $Laboratories;

    public function __construct(LaboratoriesRepositoryInterface $Laboratories){
        $this->Laboratories = $Laboratories;
    }



    public function store(Request $request)
    {
        return $this->Laboratories->store($request);
    }


    public function update(Request $request , $id)
    {
        return $this->Laboratories->update($request , $id);
    }


    public function destroy( $id)
    {
        return $this->Laboratories->delete($id);
    }
}
