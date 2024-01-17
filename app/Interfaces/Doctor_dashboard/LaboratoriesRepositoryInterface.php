<?php

namespace App\Interfaces\Doctor_dashboard;

interface LaboratoriesRepositoryInterface
{
    public function store($request);
    public function update($request , $id);
    public function delete($id);


}
