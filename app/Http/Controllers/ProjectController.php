<?php

namespace App\Http\Controllers;

use App\Employee_task;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $this->authorize('index',Task::class);
        return view('projects.index');
    }

    public function details()
    {
        $this->authorize('index',Task::class);
        $projects = Task::where('parent', 0)->orderby('start_date', 'desc')->get();
        return view('projects.details.index', compact('projects'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function task(Task $task)
    {
        $this->authorize('index',Task::class);
        return view('projects.details.task', compact('task'));
    }

    public function addParticipant(Request $request, Task $task)
    {
        $this->authorize('index',Task::class);
        $data = $request->all();
        if ($task->isValidParticipant($data['employee']) == 0)
            return back();
        $row = new Employee_task();
        $row->task_id = $task->id;
        $row->employee_id = $data['employee'];
        $row->save();
        session()->flash('success', 'Participant added successfully');
        return back();
    }

    public function detachParticipant($id)
    {
        $this->authorize('index',Task::class);
        $participant = Employee_task::find($id);
        $participant->delete();
        session()->flash('success', 'Participant detached successfully');
        return back();
    }
}
