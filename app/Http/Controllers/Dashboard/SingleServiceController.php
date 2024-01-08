<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSingleServiceRequest;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use Illuminate\Http\Request;

class SingleServiceController extends Controller
{

    private $Services;

    public function __construct(SingleServiceRepositoryInterface $Services)
    {
        $this->Services = $Services;
    }

    public function index()
    {
        return $this->Services->index();
    }


    public function create()
    {
        //
    }


    public function store(StoreSingleServiceRequest $request)
    {
        return $this->Services->store($request);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(StoreSingleServiceRequest $request)
    {
        return $this->Services->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Services->destroy($request);
    }
}
