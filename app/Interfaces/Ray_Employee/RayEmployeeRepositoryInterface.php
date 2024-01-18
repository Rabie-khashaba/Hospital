<?php

namespace App\Interfaces\Ray_Employee;

interface RayEmployeeRepositoryInterface
{

    public function index();

    public function store($request);

    public function update($request,$id);

    public function destroy($id);

}
