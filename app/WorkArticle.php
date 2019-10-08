<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkArticle extends Model
{
    public $timestamps=false;

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
