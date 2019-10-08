<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index()
    {
        if(Auth::user()->role=='super_admin')
            $reports=Report::all();
        else
        {
            $reports=Report::where('from',Auth::user()->employee_id)
                ->orWhere('to',Auth::user()->employee_id)->
                orderby('created_at','desc')->
                get();
        }
        return view('reports.index',compact('reports'));
    }

    public function create()
    {
        $employees=Employee::select('employees.id','name','jb.code')->
            leftJoin('jobpositions as jb','jb.id','=','employees.jobposition_id')->get();
        return view('reports.create',compact('employees'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required',
            'to'=>'required',
            'file'=>'required|max:10000'
        ]);
        $data=$request->all();
        if($data['to']!=0)
        {
            $employee=Employee::find($data['to']);
            if($employee==null)
                return back();
        }
        $report=new Report();
        $report->name=$data['name'];
        $report->description=$data['description'];
        $file_name = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads/reports'), $file_name);
        $report->path=$file_name;
        $report->to=$data['to']==0?0:$data['to'];
        $report->from=Auth::user()->employee_id==null?0:Auth::user()->employee_id;
        $report->save();
        session()->flash('success','Report added successfully');
        return back();

    }

    public function destroy(Report $report)
    {
        $this->authorize('delete',$report);
        if(File::exists(public_path('uploads/reports').'/'.$report->path))
            File::delete(public_path('uploads/reports') . '/'.$report->path);
        $report->delete();
        session()->flash('success','Report deleted successfully');
        return back();
    }
}
