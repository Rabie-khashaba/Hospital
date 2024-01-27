<?php

namespace App\Http\Controllers\Dashboard_patient;

use App\Http\Controllers\Controller;
use App\Interfaces\Patient_dashboard\PatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientCaontroller extends Controller
{

    private $patientActions;
    public function __construct(PatientRepositoryInterface $patientActions){
        $this->patientActions = $patientActions;
    }


    public function invoices(){
        return $this->patientActions->invoices();
    }

    public function Laboratorie(){
        return $this->patientActions->Laboratorie();
    }

    public function LaboratorieView($id){
        return $this->patientActions->view_laboratories($id);
    }


    public function ray(){
        return $this->patientActions->ray();
    }

    public function raysView($id){
        return $this->patientActions->view_rays($id);

    }

    public function payments(){
        return $this->patientActions->payments();
    }
}
