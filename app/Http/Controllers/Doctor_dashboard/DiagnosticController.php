<?php

namespace App\Http\Controllers\Doctor_dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctor_dashboard\DiagnosisRepositoryInterface;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{

    private $Diagnostic;
    public function __construct(DiagnosisRepositoryInterface $Diagnostic)
    {
        $this->Diagnostic = $Diagnostic;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function addReview(Request $request){
        return $this->Diagnostic->addReview($request);
    }

    public function store(Request $request)
    {
        return $this->Diagnostic->store($request);
    }


    //patient records...
    public function show($id)
    {
        return $this->Diagnostic->show($id);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
