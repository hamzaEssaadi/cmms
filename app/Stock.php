<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    public function scopeStocksArticle($query,$id_article)
    {
        return $this->newQuery()->select('site','locations.code as location','qte')->fromRaw('stocks,locations')
            ->whereRaw("locations.id=stocks.location_id and article_id=$id_article")->get();
    }
}
