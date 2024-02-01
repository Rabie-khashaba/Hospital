<?php

namespace App\Repository\Sections;

use App\Events\MyEvent;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Models\Doctor;
use App\Models\Section;

class SectionRepository implements SectionRepositoryInterface
{
    public function index()
    {
        $sections = Section::all();
        return view('Dashboard.section.index',compact('sections'));
    }
    public function store($request){
        Section::create([
           'name'=> $request->name,
        ]);

        session()->flash('add');
        return redirect()->route('sections.index');
    }

    // Update Sections
    public function update($request){

        $section = Section::findOrFail($request->id);
        //return $section;
        $section->update([
           'name'=>$request->name,
        ]);
        session()->flash('edit');
        return redirect()->route('sections.index');
    }

    // destroy Sections
    public function destroy($request){
        $section = Section::findOrFail($request->id);
        $section->delete();
        session()->flash('delete');
        return redirect()->route('sections.index');

    }

    // destroy Sections
    public function show($id){
        //$doctors =Doctor::where('section_id',$id)->get();
        $doctors =Section::findOrFail($id)->doctors;

        $section = Section::findOrFail($id);
        return view('Dashboard.section.show_doctors',compact('doctors','section'));
    }
}
