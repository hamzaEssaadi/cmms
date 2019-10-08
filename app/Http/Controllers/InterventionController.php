<?php

namespace App\Http\Controllers;

use App\Article;
use App\Disfunction;
use App\Employee;
use App\Equipment;
use App\InterventionRequest;
use App\WorkOrder;
use App\WorkOrderType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;

class InterventionController extends Controller
{
    public function index()
    {

        return view('intervention.index'
        );
    }

    public function create()
    {
        $this->authorize('create',InterventionRequest::class);
        $machines=Equipment::select('id','code')->get();
        $causes=Disfunction::select('id','code')->get();
        return view('intervention.create',compact('machines','causes'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'code'=>'required|unique:intervention_requests,code',
            'date'=>'date|required',
            'description'=>'required',
            'machine'=>'required',
            'stopping_hour'=>'date|required',
            'cause'=>'required'
        ]);
        $data=$request->all();
        $machine=Equipment::find($data['machine']);
        if($machine==null)
            return back();
        $cause=Disfunction::find($data['cause']);
        if($cause==null)
            return back();
        $intervention=new InterventionRequest();
        $intervention->code=$data['code'];
        $intervention->date=$data['date'];
        $intervention->description=$data['description'];
        $intervention->employee_id=Auth::user()->role!='super_admin'?Auth::user()->employee_id:null;
        $intervention->equipment_id=$data['machine'];
        $intervention->disfunction_id=$data['cause'];
        $intervention->stopping_hour=$data['stopping_hour'];
        $intervention->status='pending';
        $intervention->save();
        session()->flash('success','Intervention request added successfully');
        return back();
        return $data;
    }


    public function createOrder(InterventionRequest $interventionRequest)
    {

        if($interventionRequest->workOrder!=null)
            return back();
        $this->authorize('createOrder',InterventionRequest::class);
        $types = WorkOrderType::select('id', 'code')->get();
        return view('intervention.createOrder',compact('interventionRequest','types'));
    }

    public function storeOrder(Request $request,InterventionRequest $interventionRequest)
    {
        $this->authorize('create',WorkOrder::class);
        if($interventionRequest->workOrder!=null)
            return back();
        $this->validate($request, [
            'code' => 'required|unique:work_orders,code',
            'description' => 'required',
            'date' => 'date|required',
            'cost' => 'required|numeric',
            'type' => 'required'
        ]);
        $data = $request->all();
        $type = WorkOrderType::find($data['type']);
        if ($type == null)
            return back();
        $order = new WorkOrder();
        $order->code = $data['code'];
        $order->description = $data['description'];
        $order->demand_at = $data['date'];
        $order->cost = $data['cost'];
        $order->work_order_type_id = $data['type'];
        $order->billable = $request->has('billable') ? 1 : 0;
        $order->status = 'pending';
        $order->employee_id = Auth::user()->employee_id;
        $order->intervention_request_id=$interventionRequest->id;
        $order->save();
        $interventionRequest->status='requested';
        $interventionRequest->save();
//        session()->flash('success', 'Work order added successfully');
        return redirect(route('work-orders.show',['workOrder'=>$order->id]));
    }

    public function showOrder(WorkOrder $workOrder)
    {
        $order = $workOrder;
        $workers = Employee::AvailableWorkers($order->id);
        $equipments = Equipment::AvailableEquipment($order->id);
        $articles = Article::AvailbaleArticlesForOrder($order->id);
        return view('intervention.showOrder', compact('order', 'workers', 'equipments', 'articles'));
    }

    public function validationForm(InterventionRequest $interventionRequest)
    {
        $this->authorize('validation',$interventionRequest);
        if(!($interventionRequest->status=='requested' || $interventionRequest->status=='pending'))
            return back();
        return view('intervention.validation',compact('interventionRequest'));
    }

    public function validationStore(Request $request,InterventionRequest $interventionRequest)
    {
        $this->authorize('validation',$interventionRequest);
        if(!($interventionRequest->status=='requested' || $interventionRequest->status=='pending'))
            return back();
        $this->validate($request,[
            'start_hour'=>'required|date',
            'end_hour'=>'required|date|after:start_hour',
            'action'=>'required'
        ]);
        $data= $request->all();
        $interventionRequest->action=$data['action'];
        $interventionRequest->start_hour=$data['start_hour'];
        $interventionRequest->end_hour=$data['end_hour'];
        $interventionRequest->status='valid';
        $interventionRequest->save();
        session()->flash('success','Intervention request validated successfully');
        return redirect(route('interventions-requests.index'));
    }

    public function cancelValidation(InterventionRequest $interventionRequest)
    {
        $this->authorize('validation',$interventionRequest);
        if($interventionRequest->status!='valid')
            return back();
        $interventionRequest->action=null;
        $interventionRequest->start_hour=null;
        $interventionRequest->end_hour=null;
        if($interventionRequest->workOrder==null)
            $interventionRequest->status='pending';
        else
            $interventionRequest->status='requested';
        $interventionRequest->save();
        session()->flash('success','Validation canceled successfully');
        return back();
    }

    public function edit(InterventionRequest $interventions_request)
    {
        $this->authorize('update',$interventions_request);
        $inter=$interventions_request;
        $machines=Equipment::select('id','code')->get();
        $causes=Disfunction::select('id','code')->get();
        return view('intervention.edit',compact('inter','machines','causes'));
    }

    public function updateInfo(Request $request,InterventionRequest $interventionRequest)
    {
        $this->authorize('update',$interventionRequest);
        $this->validate($request,[
            'code'=>"required|unique:intervention_requests,code,$interventionRequest->id",
            'date'=>'date|required',
            'description'=>'required',
            'machine'=>'required',
            'stopping_hour'=>'date|required',
            'cause'=>'required'
        ]);
        $data=$request->all();
        $machine=Equipment::find($data['machine']);
        if($machine==null)
            return back();
        $cause=Disfunction::find($data['cause']);
        if($cause==null)
            return back();
        $interventionRequest->code=$data['code'];
        $interventionRequest->date=$data['date'];
        $interventionRequest->description=$data['description'];
        $interventionRequest->equipment_id=$data['machine'];
        $interventionRequest->stopping_hour=$data['stopping_hour'];
        $interventionRequest->disfunction_id=$data['cause'];
        $interventionRequest->save();
        session()->flash('success_info','Intervention request updated successfully');
        session()->flash('tab','creating-info');
        return back();
    }

    public function updateValidation(Request $request,InterventionRequest $interventionRequest)
    {
        $this->authorize('update',$interventionRequest);
        session()->flash('tab','validation-info');
        $this->validate($request,[
            'start_hour'=>'required|date',
            'end_hour'=>'required|date|after:start_hour',
            'action'=>'required'
        ]);
        $data= $request->all();
        $interventionRequest->action=$data['action'];
        $interventionRequest->start_hour=$data['start_hour'];
        $interventionRequest->end_hour=$data['end_hour'];
        $interventionRequest->save();
        session()->flash('success-validation','Intervention request updated successfully');
        return back();
    }





    public function __construct()
    {
        $this->middleware('auth');
    }
}
