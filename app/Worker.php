<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps=false;

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
