<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replacement_article extends Model
{
    public function article()
    {
        return $this->belongsTo(Article::class,'article_id');
    }

    public function replacement()
    {
        return $this->belongsTo(Article::class,'replacement_id');
    }
}
