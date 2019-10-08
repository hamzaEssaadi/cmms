<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function scopeAvailableLocations($query,$id_article)
    {
       return $query->select('id','code')->whereRaw(
           "locations.id not in (select location_id from stocks where article_id=$id_article)"
       )->get();
    }

    public function scopeCheckLocation($query,$id_article,$id_location)
    {
        $list=$this->scopeAvailableLocations($query,$id_article);
        foreach ($list as $item)
        {
            if($item->id==$id_location)
                return true;
        }
        return false;
    }
}
