<?php

namespace App\Http\Controllers;

use App\Disfunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisfunctionsController extends Controller
{
    public function index()
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $disfunctions=Disfunction::all();
        return view('equipments.disfunctions.index',compact('disfunctions'));
    }

    public function create()
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        return view('equipments.disfunctions.create');
    }

    public function store(Request $request)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $this->validate($request,['code'=>'required|unique:disfunctions,code',
            'description'=>'required']);
        $data=$request->all();
        $Disfunction=new Disfunction();
        $Disfunction->code=$data['code'];
        $Disfunction->description=$data['description'];
        $Disfunction->save();
        session()->flash('success','Dysfunction cause added successfully');
        return redirect(route('disfunctions.create'));
    }

    public function edit(Disfunction $disfunction)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        return view('equipments.disfunctions.edit',\compact('disfunction'));
    }

    public function update(Request $request, Disfunction $disfunction)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $id=$disfunction->id;
        $this->validate($request,['code'=>"required|unique:disfunctions,code,$id",
            'description'=>'required']);
        $disfunction->code=$request->code;
        $disfunction->description=$request->description;
        $disfunction->save();
        session()->flash('success','Dysfunction cause updated successfully');
        return redirect(route('disfunctions.index'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
