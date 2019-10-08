<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_task extends Model
{
    public $timestamps=false;
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();;
    }
}
