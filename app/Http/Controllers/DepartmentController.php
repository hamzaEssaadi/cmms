<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager') {
            $departments = Department::all();
            return view('equipments.department.index', compact('departments'));
        }
        return back();
    }

    public function create()
    {
        if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager')
            return view('equipments.department.create');
        return back();
    }

    public function store(Request $request)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $this->validate($request, ['code' => 'required|unique:departments,code',
            'description' => 'required']);
        $data = $request->all();
        $department = new Department();
        $department->code = $data['code'];
        $department->description = $data['description'];
        $department->save();
        session()->flash('success', 'Department added successfully');
        return redirect(route('departments.create'));
    }

    public function edit(Department $department)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        return view('equipments.department.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $id = $department->id;
        $this->validate($request, ['code' => "required|unique:departments,code,$id",
            'description' => 'required']);
        $department->code = $request->code;
        $department->description = $request->description;
        $department->save();
        session()->flash('success', 'Department updated successfully');
        return redirect(route('departments.index'));
    }


    public function __construct()
    {
        $this->middleware('auth');
    }
}
