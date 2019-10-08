<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }
}
