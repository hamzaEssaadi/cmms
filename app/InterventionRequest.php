<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InterventionRequest extends Model
{
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function disfunction()
    {
        return $this->belongsTo(Disfunction::class);
    }

    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class);
    }

    public function scopeAjax($query)
    {
        return $this->newQuery()->select('intervention_requests.id', 'intervention_requests.code', 'employees.name  
             as written_by',
            'intervention_requests.status as status', 'intervention_requests.date', 'intervention_requests.description',
            'equipments.code as machine', 'disfunctions.code as cause', 'intervention_requests.action', 'intervention_requests.stopping_hour',
            'intervention_requests.start_hour', 'intervention_requests.end_hour', 'intervention_requests.employee_id as employee_id',
            'intervention_requests.equipment_id as equipment_id')->
        leftJoin('employees', 'employees.id', '=', 'intervention_requests.employee_id')
            ->leftJoin('equipments', 'equipments.id', '=', 'intervention_requests.equipment_id')
            ->leftJoin('disfunctions', 'disfunctions.id', '=', 'intervention_requests.disfunction_id');
    }

    public function scopeAjaxEmployee($query)
    {
        return $this->newQuery()->select('intervention_requests.id', 'intervention_requests.code', 'employees.name  
             as written_by',
            'intervention_requests.status as status', 'intervention_requests.date', 'intervention_requests.description',
            'equipments.code as machine', 'disfunctions.code as cause', 'intervention_requests.action', 'intervention_requests.stopping_hour',
            'intervention_requests.start_hour', 'intervention_requests.end_hour', 'intervention_requests.employee_id as employee_id',
            'intervention_requests.equipment_id as equipment_id')->
        leftJoin('employees', 'employees.id', '=', 'intervention_requests.employee_id')
            ->leftJoin('equipments', 'equipments.id', '=', 'intervention_requests.equipment_id')
            ->leftJoin('disfunctions', 'disfunctions.id', '=', 'intervention_requests.disfunction_id')
            ->where('intervention_requests.employee_id',Auth::user()->employee_id);
    }

    public function scopeGraphBymachine($query,$idMachine,$year)
    {
        return $this->newQuery()->select('stopping_hour','start_hour','end_hour')
            ->whereRaw("status='valid' and equipment_id=$idMachine and year(end_hour)=$year")
            ->get();
    }

    public function scopeGraphByAll($query,$year)
    {
        return $this->newQuery()->select('stopping_hour','start_hour','end_hour')
            ->whereRaw("status='valid' and year(end_hour)=$year")
            ->get();
    }

    public function scopeNumber($query)
    {
        return $this->newQuery()->select('*')
            ->where('status','pending')
            ->count();
    }
}
