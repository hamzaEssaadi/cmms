<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Result;

class WorkOrder extends Model
{
    public function type()
    {
        return $this->belongsTo(WorkOrderType::class,'work_order_type_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();;
    }

    public function workers()
    {
        return $this->hasMany(Worker::class);
    }

    public function equipments()
    {
        return $this->hasMany(WorkEquipment::class);
    }

    public function articles()
    {
        return $this->hasMany(WorkArticle::class);
    }

    public function intervention()
    {
        return $this->belongsTo(InterventionRequest::class,'intervention_request_id');
    }

    public function belongToEmployee($id_employee)
    {
        $workers=$this->workers;
        foreach ($workers as $worker)
        {
            if($worker->employee_id==$id_employee)
                return 1;
        }
        return 0;
    }

    public function isValid($id_employee)
    {
        $id_order=$this->id;
        $worker=$this->newQuery()->from('workers')
            ->whereRaw("work_order_id=$id_order and employee_id=$id_employee")->first();
        if($worker !=null)
        {
            if($worker->status=='pending')
                return 0;
            else
                return 1;
        }
        return 0;
    }

    public function getWorker()
    {
        $workers=$this->workers;
        foreach ($workers as $worker)
        {
            if($worker->employee_id==Auth::user()->employee_id)
                return $worker;
        }
        return null;
    }

    public function scopeEmployeeOrders($query,$id_employee)
    {

        return $this->newQuery()->from('work_orders')
            ->whereRaw("$id_employee in (select employee_id from workers where work_orders.id=workers.work_order_id) ")
            ->get();
    }

    public function scopeAjaxAll($query)
    {
        return $this->newQuery()->select('work_orders.id','work_orders.code',
            'work_orders.description','work_orders.demand_at','employees.name as written_by','equipments.code as machine',
            'work_order_types.code as type','billable','work_orders.cost','work_orders.status','work_orders.employee_id')
            ->leftJoin('employees','employees.id','=','work_orders.employee_id')
            ->leftJoin('intervention_requests','intervention_requests.id','=','work_orders.intervention_request_id')
            ->leftJoin('equipments','equipments.id','=','intervention_requests.equipment_id')
            ->leftJoin('work_order_types','work_order_types.id','=','work_orders.work_order_type_id');
    }
    public function scopeAjaxEmployee($query)
    {
        $employee_id=Auth::user()->employee_id;
        return $this->newQuery()->select('work_orders.id','work_orders.code',
            'work_orders.description','work_orders.demand_at','employees.name as written_by','equipments.code as machine',
            'work_order_types.code as type','billable','work_orders.cost','work_orders.status','work_orders.employee_id')
            ->leftJoin('employees','employees.id','=','work_orders.employee_id')
            ->leftJoin('intervention_requests','intervention_requests.id','=','work_orders.intervention_request_id')
            ->leftJoin('equipments','equipments.id','=','intervention_requests.equipment_id')
            ->leftJoin('work_order_types','work_order_types.id','=','work_orders.work_order_type_id')
            ->whereRaw("$employee_id in (select employee_id from workers where work_orders.id=workers.work_order_id)");

    }

    public function scopeWorkOrderCount($query)
    {
        $employee_id=Auth::user()->employee_id;
        return $this->newQuery()->selectRaw('count(*) as nb')
            ->from('workers')->whereRaw("employee_id=$employee_id and status<>'valid'")
            ->get();
    }

    public function scopeNumber($query)
    {
        return $this->newQuery()->select('*')->where('status','pending')
            ->count();
    }
}
