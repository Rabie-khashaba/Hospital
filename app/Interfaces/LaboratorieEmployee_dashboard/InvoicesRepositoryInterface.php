<?php

namespace App\Interfaces\LaboratorieEmployee_dashboard;

interface InvoicesRepositoryInterface
{

    public function index();
    public function completed_invoices();
    public function edit($id);
    public function update($request,$id);
    public function view_laboratories($id);

}
