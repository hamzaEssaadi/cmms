<?php

namespace App\Http\Controllers;

use App\Article;
use App\Employee;
use App\Equipment;
use App\WorkArticle;
use App\WorkEquipment;
use App\Worker;
use App\WorkOrder;
use App\WorkOrderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $orders = Auth::user()->role == 'average_user' ? WorkOrder::EmployeeOrders(Auth::user()->employee_id) : WorkOrder::all();
        return view('work orders.index');
    }

    public function create()
    {
        $this->authorize('create', WorkOrder::class);
        $types = WorkOrderType::select('id', 'code')->get();
        return view('work orders.create', compact('types'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', WorkOrder::class);
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
        $order->save();
        session()->flash('success', 'Work order added successfully');
        return redirect(route('work-orders.show',['workOrder'=>$order->id]));
        return back();

    }

    public function edit(WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);
        $types = WorkOrderType::select('id', 'code')->get();
        return view('work orders.edit', compact('types', 'workOrder'));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);
        $id = $workOrder->id;
        $this->validate($request, [
            'code' => "required|unique:work_orders,code,$id",
            'description' => 'required',
            'date' => 'date|required',
            'cost' => 'required|numeric',
            'type' => 'required'
        ]);
        $data = $request->all();
        $workOrder->code = $data['code'];
        $workOrder->description = $data['description'];
        $workOrder->demand_at = $data['date'];
        $workOrder->cost = $data['cost'];
        $workOrder->work_order_type_id = $data['type'];
        $workOrder->billable = $request->has('billable') ? 1 : 0;
        $workOrder->save();
        session()->flash('success', 'Work order added successfully');
        return redirect(route('work-orders.index'));
    }

    public function show(WorkOrder $workOrder)
    {
        $order = $workOrder;
        $workers = Employee::AvailableWorkers($order->id);
        $equipments = Equipment::AvailableEquipment($order->id);
        $articles = Article::AvailbaleArticlesForOrder($order->id);
        return view('work orders.show', compact('order', 'workers', 'equipments', 'articles'));
    }

    public function destroy(WorkOrder $workOrder)
    {
        $this->authorize('delete', $workOrder);
        return 'action not available';
        $workers = $workOrder->workers;
        $articles = $workOrder->articles;
        $equipments = $workOrder->equipments;
        foreach ($workers as $worker) {
            $worker->delete();
        }
        foreach ($articles as $article) {
            $article->delete();
        }
        foreach ($equipments as $equipment) {
            $equipment->delete();
        }
        $workOrder->delete();
        if($workOrder->intervention_request_id!=null)
        {
            $workOrder->intervention->status='pending';
            $workOrder->intervention->save();
        }
        session()->flash('success', 'Work order deleted successfully');
        return redirect(route('work-orders.index'));
    }

    public function addWorker(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);
        $data = $request->all();
        if (Employee::IsAvailbaleWorker($workOrder->id, $data['worker']) == 0)
            return back();
        $worker = new Worker();
        $worker->employee_id = $data['worker'];
        $worker->work_order_id = $workOrder->id;
        $worker->status = 'pending';
        $workOrder->status = 'pending';
        $workOrder->save();
        $worker->save();
        session()->flash('success_worker', 'Worker added successfully');
        session()->flash('tab', 'workers');
        return back();
    }

    public function detachWorker(Worker $worker)
    {
        $order = $worker->workOrder;
        $this->authorize('update', $order);
        $worker->delete();
        $this->updateStatus($order);
        session()->flash('success_worker', 'Worker detached successfully');
        session()->flash('tab', 'workers');
        return back();
    }

    public function addEquipment(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);
        $data = $request->all();
        if (Equipment::IsAvailableEquipment($data['equipment'], $workOrder->id) == 0)
            return back();
        $workEquipment = new WorkEquipment();
        $workEquipment->work_order_id = $workOrder->id;
        $workEquipment->equipment_id = $data['equipment'];
        $workEquipment->save();
        session()->flash('success_equipment', 'Equipment added successfully');
        session()->flash('tab', 'equipments');
        return back();
    }

    public function detachEquipment($id)
    {
        $equipment = WorkEquipment::find($id);
        $this->authorize('update', $equipment->workOrder);
        $equipment->delete();
        session()->flash('success_equipment', 'Equipment detached successfully');
        session()->flash('tab', 'equipments');
        return back();
    }

    public function addArticle(Request $request, WorkOrder $workOrder)
    {
        $this->authorize('update', $workOrder);
        $data = $request->all();
        if (Article::IsAvailableArticleForWork($data['article'], $workOrder->id) == 0)
            return back();
        $workArticle = new WorkArticle();
        $workArticle->work_order_id = $workOrder->id;
        $workArticle->article_id = $data['article'];
        $workArticle->save();
        session()->flash('success_article', 'Article added successfully');
        session()->flash('tab', 'articles');
        return back();
    }

    public function detachArticle(WorkArticle $workArticle)
    {
        $this->authorize('update', $workArticle->workOrder);
        $workArticle->delete();
        session()->flash('success_article', 'Article detached successfully');
        session()->flash('tab', 'articles');
        return back();
    }

    public function validateOrder(Worker $worker)
    {
        $this->authorize('validate', $worker->workOrder);
        if ($worker->status == 'pending') {
            $worker->status = 'valid';
            $msg = 'validated';
        } else {
            $worker->status = 'pending';
            $msg = 'invalidated';
        }
        $worker->save();
        $order = WorkOrder::find($worker->workOrder->id);
        $this->updateStatus($order);
        session()->flash('success', "Work order $msg successfully");
        return back();
    }

    public function updateStatus(WorkOrder $workOrder)
    {
        $workers = $workOrder->workers;
        foreach ($workers as $worker) {
            if ($worker->status == 'pending') {
                $workOrder->status = 'pending';
                $workOrder->save();
                return 0;
            }
        }
        $workOrder->status = 'valid';
        $workOrder->save();
        return 1;
    }


}
