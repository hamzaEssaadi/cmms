<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function index()
    {
        $this->authorize('index',Location::class);
        $locations=Location::all();
        return view('locations.index',compact('locations'));
    }

    public function create()
    {
        $this->authorize('create',Location::class);
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create',Location::class);
        $this->validate($request,[
            'code'=>'required|unique:locations,code',
            'description'=>'required'
        ]);
        $data=$request->all();
        $location=new Location();
        $location->code=$data['code'];
        $location->description=$data['description'];
        $location->save();
        session()->flash('success','location added successfully');
        return redirect('locations/create');
    }

    public function edit(Location $location)
    {
        $this->authorize('update',$location);
        return view('locations.edit',compact('location'));
    }

    public function update(Request $request,Location $location)
    {
        $this->authorize('update',$location);
        $this->validate($request,[
            'code'=>'required|unique:locations,code,'.$location->id,
            'description'=>'required'
        ]);
        $data=$request->all();
        $location->code=$data['code'];
        $location->description=$data['description'];
        $location->save();
        session()->flash('success','location updated successfully');
        return redirect('locations/');
    }
}
