<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
