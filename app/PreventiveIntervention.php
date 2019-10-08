<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreventiveIntervention extends Model
{
    public $timestamps=false;

    public function scopeAjax($query)
    {
        return $this->newQuery()->select('preventive_interventions.id','status','preventive_interventions.description','intervention_start','intervention_end',
            'employees.name as written_by','equipments.code as machine','preventive_interventions.employee_id')
            ->leftJoin('employees','employees.id','=','preventive_interventions.employee_id')
            ->leftJoin('equipments','equipments.id','=','preventive_interventions.equipment_id');
    }

    public function scopeCalendar($query)
    {
        return $this->newQuery()->selectRaw("preventive_interventions.description as title,intervention_start as start ,intervention_end as end,
        case status when 'completed' then '#5cb85c' when 'pending' then '#777' else '#d9534f' end as color,
        equipments.code as machine,employees.name as written_by,status,equipments.code as machine")
            ->leftJoin('equipments','equipments.id','=','preventive_interventions.equipment_id')
            ->leftJoin('employees','employees.id','=','preventive_interventions.employee_id')
            ->get();
    }

    public function scopeNumber()
    {
        return $this->newQuery()->select('*')
            ->where('status','pending')
            ->count();
    }
}
