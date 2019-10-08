<?php

namespace App\Http\Controllers;

use App\Equipment_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentTypesController extends Controller
{
    public function create()
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        return view('equipments.types.create');
    }

    public function index()
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $equipmentTypes=Equipment_type::all();
        return view('equipments.types.index',compact('equipmentTypes'));
    }
    public function edit(Equipment_type $equipment_type)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $type=$equipment_type;
        return view('equipments.types.edit',compact('type'));
    }

    public function update(Request $request, Equipment_type $equipment_type)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $id=$equipment_type->id;
        $this->validate($request,['code'=>"required|unique:equipment_types,code,$id",
            'description'=>'required']);
        $equipment_type->code=$request->code;
        $equipment_type->description=$request->description;
        $equipment_type->save();
        session()->flash('success','Equipment type updated successfully');
        return redirect(route('equipment-types.index'));
    }


    public function store(Request $request)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $this->validate($request,['code'=>'required|unique:equipment_types,code',
            'description'=>'required']);
        $data=$request->all();
        $type=new Equipment_type();
        $type->code=$data['code'];
        $type->description=$data['description'];
        $type->save();
        session()->flash('success','Equipment type added successfully');
        return redirect(route('equipment-types.create'));
    }


    public function __construct()
    {
        $this->middleware('auth');
    }
}
