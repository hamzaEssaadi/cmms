<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
    public $timestamps=false;
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
