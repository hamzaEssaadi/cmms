<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkEquipment extends Model
{
    public $timestamps=false;

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
