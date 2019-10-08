<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\PreventiveIntervention;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventiveController extends Controller
{
    public function index()
    {

        $pres=PreventiveIntervention::select('id','intervention_start','status')
            ->where('status','=','pending')
            ->where('intervention_start','<=',Carbon::now()->toDateString())
            ->get();
        foreach ($pres as $pre)
        {
            $pre->status='completed';
            $pre->save();
        }
        return view('preventive.index');
    }

    public function create()
    {

        $this->authorize('create',PreventiveIntervention::class);
        $machines=Equipment::select('id','code')->get();
        return view('preventive.create',compact('machines'));
    }
    public function store(Request $request)
    {
        $this->authorize('create',PreventiveIntervention::class);
        $this->validate($request,[
            'machine'=>'required',
            'description'=>'required',
//            'date'=>'date',
            'intervention_start'=>'date',
            'intervention_end'=>'date|after:intervention_start'
        ]);
        $data=$request->all();
        $machine=Equipment::find($data['machine']);
        if($machine==null)
            return back();
        $pre=new PreventiveIntervention();
        if(Carbon::parse($data['intervention_start'])->greaterThanOrEqualTo(Carbon::now()))
            $pre->status='pending';
        else
            $pre->status='completed';
        $pre->equipment_id=$data['machine'];
        $pre->employee_id=Auth::user()->employee_id;
//        $pre->date=$data['date'];
        $pre->intervention_start=$data['intervention_start'];
        $pre->intervention_end=$data['intervention_end'];
        $pre->description=$data['description'];
        $pre->save();
        session()->flash('success','Preventive Intervention added successfully');
        return back();
    }

    public function edit(PreventiveIntervention $preventiveIntervention)
    {
        $this->authorize('update',$preventiveIntervention);
        $preventive=$preventiveIntervention;
        $this->authorize('update',$preventiveIntervention);
        $machines=Equipment::select('id','code')->get();
        return view('preventive.edit',compact('machines','preventive'));
    }

    public function update(Request $request,PreventiveIntervention $preventiveIntervention)
    {
        $this->authorize('update', $preventiveIntervention);
        $this->validate($request,[
            'machine'=>'required',
            'description'=>'required',
//            'date'=>'date',
            'intervention_start'=>'date',
            'intervention_end'=>'date|after:intervention_start'
        ]);
        $data=$request->all();
        $machine=Equipment::find($data['machine']);
        if($machine==null)
            return back();
        $pre=$preventiveIntervention;
        if($pre->status!='canceled') {
            if(Carbon::parse($data['intervention_start'])->greaterThanOrEqualTo(Carbon::now()))
                $pre->status='pending';
            else
                $pre->status='completed';
        }
        $pre->equipment_id=$data['machine'];
//        $pre->date=$data['date'];
        $pre->intervention_start=$data['intervention_start'];
        $pre->intervention_end=$data['intervention_end'];
        $pre->description=$data['description'];
        $pre->save();
        session()->flash('success','Preventive Intervention updated successfully');
        return redirect(route('preventive-interventions.index'));
    }

    public function validation(PreventiveIntervention $preventiveIntervention)
    {
        $this->authorize('validation',$preventiveIntervention);
        if($preventiveIntervention->status=='completed')
        {
            $date=Carbon::parse($preventiveIntervention->date);
            if(!$date->greaterThanOrEqualTo(Carbon::now()))
                $preventiveIntervention->status='canceled';
            else
                $preventiveIntervention->status='pending';
            session()->flash('success','Preventive intervention validation canceled successfully');
        }
        else {
            $preventiveIntervention->status = 'completed';
            session()->flash('success','Preventive intervention validated successfully');
        }
        $preventiveIntervention->save();
        return back();
    }

    public function destroy(PreventiveIntervention $preventiveIntervention)
    {
        $this->authorize('delete',$preventiveIntervention);
        $preventiveIntervention->delete();
        session()->flash('success','Preventive Intervention deleted successfully');
        return back();
    }

    public function calendar()
    {
        return PreventiveIntervention::Calendar();
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
}
