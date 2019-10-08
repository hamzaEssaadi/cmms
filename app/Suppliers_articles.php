<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers_articles extends Model
{
    public function Supplier()
    {
        return $this->belongsTo(Provider::class);
    }

    public function Article()
    {
        return $this->belongsTo(Article::class);
    }
}
