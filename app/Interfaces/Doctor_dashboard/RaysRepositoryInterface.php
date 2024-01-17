<?php

namespace App\Interfaces\Doctor_dashboard;

interface RaysRepositoryInterface
{
    public function store($request);
    public function update($request , $id);
    public function delete($id);

}
