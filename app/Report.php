<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function from_employee()
    {
        return $this->belongsTo(Employee::class,'from')->withTrashed();
    }
    public function to_employee()
    {
        return $this->belongsTo(Employee::class,'to')->withTrashed();
    }
}
