<?php

namespace App\Interfaces\Patient_dashboard;

interface PatientRepositoryInterface
{

    public function invoices();
    public function ray();
    public function Laboratorie();
    public function view_laboratories($id);
    public function view_rays($id);
    public function payments();

}
