<?php

namespace App\Http\Controllers;

use App\WorkOrderType;
use Illuminate\Http\Request;

class WorkOrderTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $types=WorkOrderType::all();
        return view('work orders.types.index',compact('types'));
    }

    public function create()
    {
        return view('work orders.types.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,['code'=>'required|unique:work_order_types,code',
            'description'=>'required']);
        $data=$request->all();
        $tyoe=new WorkOrderType();
        $tyoe->code=$data['code'];
        $tyoe->description=$data['description'];
        $tyoe->save();
        session()->flash('success','Work orders type added successfully');
        return back();
    }

    public function edit(WorkOrderType $workOrderType)
    {
        return view('work orders.types.edit',['type'=>$workOrderType]);
    }

    public function update(Request $request,WorkOrderType $workOrderType)
    {
        $id=$workOrderType->id;
        $this->validate($request,['code'=>"required|unique:work_order_types,code,$id",
            'description'=>'required']);
        $workOrderType->code=$request->code;
        $workOrderType->description=$request->description;
        $workOrderType->save();
        session()->flash('success','Department updated successfully');
        return redirect(route('work-order-types.index'));
    }
}
