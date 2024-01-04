<?php

namespace App\Repository\Services;

use App\Models\Service;
use http\Env\Request;

class SingleServiceRepository implements \App\Interfaces\Services\SingleServiceRepositoryInterface
{

    public function index()
    {
        $services = Service::all();
        return view('Dashboard.services.Single Service.index',compact('services'));
    }

    public function store($request)
    {
        //return $request;

        try{
             $services = new Service();
             $services->name = $request->name;
             $services->price = $request->price;
             $services->description = $request->description;

             $services->save();
            session()->flash('add');
            return redirect()->route('Service.index');


        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function update($request)
    {
        try{
            $service = Service::findOrFail($request->id);
            $service->name = $request->name;
            $service->price = $request->price;
            $service->description = $request->description;
            $service->status = $request->status;


            $service->save();
            session()->flash('edit');
            return redirect()->route('Service.index');


        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function destroy($request)
    {
        try {

            $service = Service::findOrFail($request->id);
            $service->delete();

            session()->flash('delete');
            return redirect()->route('Service.index');


        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }
}
