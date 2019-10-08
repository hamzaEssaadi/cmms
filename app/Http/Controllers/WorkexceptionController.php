<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Workexception;
use Illuminate\Http\Request;

class WorkexceptionController extends Controller
{
    public function create(Employee $employee)
    {
        $this->authorize('create',Workexception::class);
        return view('employees.workexceptions.create',compact('employee'));
    }

    public function store(Request $request,Employee $employee)
    {
        $this->authorize('create',Workexception::class);
        $this->validate($request,[
            'exception'=>'required',
            'begin_date'=>'date',
            'end_date'=>'date|after:begin_date'
        ]);
        $data=$request->all();
        $exception= new Workexception();
        $exception->begin_date=$data['begin_date'];
        $exception->end_date=$data['end_date'];
        $exception->exception=$data['exception'];
        $exception->employee_id=$employee->id;
        $exception->save();
        session()->flash('success_exception','Work exception added successfully');
        session()->flash('tab', 'exceptions');
        return redirect('exceptions/'.$employee->id);
    }

    public function edit(Workexception $exception)
    {
        $this->authorize('update',$exception);
        return view('employees.workexceptions.edit',compact('exception'));
    }

    public function update(Request $request,Workexception $exception)
    {
        $this->authorize('update',$exception);
        $this->validate($request,[
            'exception'=>'required',
            'begin_date'=>'date',
            'end_date'=>'date|after:begin_date'
        ]);
        $data=$request->all();
        $exception->exception=$data['exception'];
        $exception->begin_date=$data['begin_date'];
        $exception->end_date=$data['end_date'];
        $exception->save();
        session()->flash('success_exception','Work exception updated successfully');
        session()->flash('tab', 'exceptions');
        return redirect('exceptions/'.$exception->id.'/edit');
    }

    public function destroy(Workexception $exception)
    {
        $this->authorize('delete',$exception);
        $id_employee=$exception->employee->id;
        $exception->delete();
        session()->flash('success_exception','Work exception deleted successfully');
        session()->flash('tab', 'exceptions');
        return redirect('employees/'.$id_employee);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
