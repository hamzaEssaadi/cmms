<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(Employee $employee)
    {

    }

    public function create(Employee $employee)
    {
        $this->authorize('create',Training::class);
        return view('employees.trainings.create', compact('employee'));
    }

    public function store(Request $request, Employee $employee)
    {
        $this->authorize('create',Training::class);
        $this->validate($request, ['title' => 'required|max:150',
            'description' => 'required|max:300',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'note'=>'required|max:191'
        ]);
        $data=$request->all();
        $training=new Training();
        $training->title=$data['title'];
        $training->description=$data['description'];
        $training->date_start=$data['date_start'];
        $training->date_end=$data['date_end'];
        $training->note=$data['note'];
        $training->employee_id=$employee->id;
        $training->save();
        session()->flash('success','Training added successfully');
        session()->flash('tab', 'trainings');
        return redirect('trainings/'.$employee->id);
    }
    public function edit(Training $training)
    {
        $this->authorize('update',$training);

        return view('employees.trainings.edit',compact('training'));
    }
    public function update(Request $request,Training $training)
    {
        $this->authorize('update',$training);
        $this->validate($request, ['title' => 'required|max:150',
            'description' => 'required|max:300',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'note'=>'required|max:191'
        ]);
        $data=$request->all();
        $training->title=$data['title'];
        $training->description=$data['description'];
        $training->date_start=$data['date_start'];
        $training->date_end=$data['date_end'];
        $training->note=$data['note'];
        $training->save();
        session()->flash('success','Training updated successfully');
        session()->flash('tab', 'trainings');
        return redirect('trainings/'.$training->employee->id.'/edit');
    }

    public function destroy(Training $training)
    {
        $this->authorize('delete',$training);
        $id_employee=$training->employee->id;
        $training->delete();
        session()->flash('success','Training deleted successfully');
        session()->flash('tab', 'trainings');
        return redirect('employees/'.$id_employee);
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
}
