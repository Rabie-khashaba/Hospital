<?php

namespace App\Http\Controllers\Doctor_dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctor_dashboard\RaysRepositoryInterface;
use Illuminate\Http\Request;

class RaysController extends Controller
{


    private $Rays;

    public function __construct(RaysRepositoryInterface $Rays){
        $this->Rays = $Rays;
    }



    public function store(Request $request)
    {
       return $this->Rays->store($request);
    }



    public function update(Request $request , $id)
    {
        return $this->Rays->update($request , $id);
    }


    public function destroy( $id)
    {
        return $this->Rays->delete($id);
    }
}
