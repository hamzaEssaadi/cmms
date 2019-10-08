<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function photo()
    {
        if($this->role=='super_admin')
            return "admin.png";
        else
        {
            if($this->employee->image==null)
                return "profile.png";
        }
        return $this->employee->image;
    }
    public function myTasks()
    {
        $employee_id=$this->employee_id;
        return $this->newQuery()->selectRaw('count(*) as nb')
            ->from('employee_tasks')->whereRaw("status='pending' and employee_id=$employee_id")
            ->get();
    }
}
