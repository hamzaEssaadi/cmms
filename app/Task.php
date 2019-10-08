<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $appends = ["open"];

    public function getOpenAttribute(){
        return true;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class,'parent')->orderBy('start_date','asc');
    }

    public function task()
    {
        return $this->belongsTo(Task::class,'parent');
    }

    public function availableEmployees()
    {
        return $this->newQuery()->select('employees.id','name','jobpositions.code as job')
            ->from('employees')
            ->leftJoin('jobpositions','jobpositions.id','=','employees.jobposition_id')
            ->whereRaw("employees.id not in (select employee_id from cmms.employee_tasks where task_id=$this->id)")
            ->get();
    }

    public function employees()
    {
        return $this->hasMany(Employee_task::class);
    }

    public function isValidParticipant($employee_id)
    {
        $data= $this->newQuery()->select('employees.id as id')
            ->from('employees')
            ->leftJoin('jobpositions','jobpositions.id','=','employees.jobposition_id')
            ->whereRaw("employees.id not in (select employee_id from cmms.employee_tasks where task_id=$this->id)")
            ->get();
        foreach ($data as $employee)
        {
            if($employee->id==$employee_id)
                return 1;
        }
        return 0;
    }
}
