<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    public function manufacturer()
    {
        return $this->belongsTo(Provider::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Suppliers_articles::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function replacements()
    {
        return $this->hasMany(Replacement_article::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function purposes()
    {
        return $this->hasMany(Purpose::class);
    }

    public function scopeAvailableArticles($query, $id_article)
    {
        return $this->newQuery()->select('id', 'code')->whereRaw(
            "id not in (select replacement_id from replacement_articles where article_id=$id_article) and id<>$id_article "
        )->get();
    }

    public function scopeIsavailableArticle($query,$id_article,$id_article_to_check)
    {
        $list_articles=$this->scopeAvailableArticles($query,$id_article);
        foreach ($list_articles as $item)
        {
            if($item->id==$id_article_to_check)
                return true;
        }
        return false;
    }

    public function scopeContainStock($query,$stock_id)
    {
        foreach ($this->stocks as $stock)
        {
            if($stock->id==$stock_id) {
                return true;
            }
        }
        return false;
    }

    public function scopeAvailableSpares($query,$id_equipment)
    {
        $data= $this->newQuery()->select('id','code')->whereRaw(
            "id not in (select article_id from spares where equipment_id=$id_equipment)"
        )->get();
       return $data;
    }


    public function test(){
        return $this->costs;
    }

    public function scopeAvailbaleArticlesForOrder($query,$id_order)
    {
        return $this->newQuery()->select('id','code')
            ->whereRaw("id not in (select article_id from work_articles where work_order_id=$id_order)")->get();
    }

    public function scopeIsAvailableArticleForWork($query,$id_article,$id_order)
    {
        $data=$this->newQuery()->select('id')
            ->whereRaw("id not in (select article_id from work_articles where work_order_id=$id_order)")->get();
        foreach ($data as $art)
        {
            if($art->id==$id_article)
                return 1;
        }
        return 0;
    }

    public function scopeAjax($query)
    {
        $query=$this->newQuery()->
        select('articles.id','articles.code','articles.description','weight','model','volume',
            'added_in','providers.code as manufacturer','supply_point')
            ->leftJoin('providers','providers.id',"=",'articles.manufacturer_id');
        return $query;
    }
    public function haveErrorsStock()
    {
        $totalQteCost=$this->costs()->sum('qte');
        $totalQteStock=$this->stocks()->sum('qte');
        return $totalQteCost==$totalQteStock?0:1;
    }
    public function scopeErrorsArticle($query)
    {
        $articles=Article::all();
        $count=0;
        foreach ($articles as $article)
        {
            if($article->haveErrorsStock()==1)
                $count++;
            if($article->haveSupplyPointError()==1)
                $count++;
        }
        return $count;
    }

    public function haveSupplyPointError()
    {
        $totalQteStock=$this->stocks()->sum('qte');
        return $totalQteStock<$this->supply_point?1:0;
    }

}
