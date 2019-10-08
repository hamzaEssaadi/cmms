<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use App\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
   public function create(Employee $employee)
   {
        $this->authorize('create',Salary::class);
        return view('employees.salaries.create',compact('employee'));
   }

   public function store(Request $request,Employee $employee)
   {
       $this->authorize('create',Salary::class);
       $this->validate($request,[
          'type'=>'required',
          'start_date'=>'required|date',
          'end_date'=>'required|date|after:start_date',
          'payment_date'=>'required|date',
           'amount'=>'required|numeric'
       ]);
       $salary=new Salary();
       $data=$request->all();
       $salary->type=$data['type'];
       $salary->start_date=$data['start_date'];
       $salary->end_date=$data['end_date'];
       $salary->payment_date=$data['payment_date'];
       $salary->amount=$data['amount'];
       $salary->employee_id=$employee->id;
       $salary->save();
       session()->flash('success','Salary added successfully');
       session()->flash('tab', 'salaries');
       return redirect('salaries/'.$employee->id);
   }

   public function edit(Salary $salary)
   {
       $this->authorize('update',$salary);
       return view('employees.salaries.edit',compact('salary'));
   }

   public function update(Request $request,Salary $salary)
   {
       $this->authorize('update',$salary);
       $this->validate($request,[
           'type'=>'required',
           'start_date'=>'required|date',
           'end_date'=>'required|date|after:start_date',
           'payment_date'=>'required|date',
           'amount'=>'required|numeric'
       ]);
       $data=$request->all();
       $salary->type=$data['type'];
       $salary->start_date=$data['start_date'];
       $salary->end_date=$data['end_date'];
       $salary->payment_date=$data['payment_date'];
       $salary->amount=$data['amount'];
       $salary->save();
       session()->flash('success_salary','Salary updated successfully');
       session()->flash('tab', 'salaries');
       return redirect('employees/'.$salary->employee->id);
   }

    public function destroy(Salary $salary)
    {
        $this->authorize('delete',$salary);
        $id_employee=$salary->employee->id;
        $salary->delete();
        session()->flash('success_salary','Salary deleted successfully');
        session()->flash('tab', 'salaries');
        return redirect('employees/'.$id_employee);
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
}
