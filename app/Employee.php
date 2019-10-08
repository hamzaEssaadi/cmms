<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    public function jobposition()
    {
        return $this->belongsTo(Jobposition::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function workexceptions()
    {
        return $this->hasMany(Workexception::class);
    }

    public function scopeAvailableWorkers($query,$id_order)
    {
        return $this->newQuery()->select('employees.id','name','jb.code')->
        leftJoin('jobpositions as jb','jb.id','=','employees.jobposition_id')
            ->whereRaw("employees.id not in ( select employee_id from workers where work_order_id=$id_order)")
            ->get();
    }

    public function scopeIsAvailbaleWorker($query,$id_order,$id_employee)
    {
        $data= $this->newQuery()->select('employees.id')->
        leftJoin('jobpositions as jb','jb.id','=','employees.jobposition_id')
            ->whereRaw("employees.id not in ( select employee_id from workers where work_order_id=$id_order)")
            ->get();

        foreach ($data as $w)
        {
            if($w->id==$id_employee)
                return 1;
        }
        return 0;
    }

    public function belongToOrder($id_order)
    {
        $data =$this->newQuery()->selectRaw('count(*) as nb')->from('workers')->
        where('work_order_id',$id_order)->where('employee_id',$this->id)->first();
        if($data['nb']>0)
            return 1;
        return 0;
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function scopeListEmployeeToAdd($query)
    {
//        return $this->newQuery()->select('*')->whereRaw('employees.id not in (select employee_id from users')->get();
        return $this->newQuery()->select('employees.id','name','jb.code')->
        leftJoin('jobpositions as jb','jb.id','=','employees.jobposition_id')
            ->whereRaw('employees.id  not in (select employee_id from users where employee_id is not null)')
            ->get();
    }

    public function interventions()
    {
        return $this->hasMany(InterventionRequest::class);
    }

//    public function myTasks()
//    {
//        $employee_id=$this->id;
//        return $this->newQuery()->selectRaw('count(*) as nb')
//            ->from('employee_tasks')->whereRaw("status='pending' and employee_id=$employee_id")
//            ->get();
//    }

    public function scopeJobCount($query){
        return $this->newQuery()->selectRaw('jobpositions.code as job,count(employees.id) as nb')
            ->rightJoin('jobpositions','jobpositions.id','=','employees.jobposition_id')
            ->groupBy('job')
            ->get();
    }

    public function photo()
    {
        if($this->image==null)
            return "profile.png";
        else
            return $this->image;
    }




}
