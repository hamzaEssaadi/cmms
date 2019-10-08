<?php

namespace App\Http\Controllers;

use App\Employee_task;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MytaskController extends Controller
{
    public function index()
    {
        $tasks=Employee_task::where('employee_id',Auth::user()->employee_id)->get();
        return view('projects.mytasks',compact('tasks'));
    }

    public function validation(Employee_task $employee_task)
    {
        $this->authorize('validation',$employee_task);
        if($employee_task->status=='pending')
            $employee_task->status='valid';
        else
            $employee_task->status='pending';
        $employee_task->save();
        session()->flash('success','Operation done successfully');
        return back();
    }
}
