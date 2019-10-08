<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeAjax($query)
    {
        return $this->newQuery()->select('commands.id','employees.name as delivered_to','articles.code as article','stocks.site as delivered_from','qte_out','cost','date','reason',
            'locations.code as location','status')
            ->leftJoin('employees','employees.id','=','commands.employee_id')
            ->leftJoin('articles','articles.id','=','commands.article_id')
            ->leftJoin('stocks','stocks.id','=','commands.stock_id')
            ->leftJoin('locations','locations.id','=','commands.location_id');
    }

    public function scopeAjax2($query)
    {
//        CONCAT(d_from.code,' (',s.site,')') as delivered_from
        return $this->newQuery()->selectRaw("commands.id,articles.code as article,employees.name as delivered_to,
            d_from.code as location_from,
            s.site as delivered_from
            ,commands.qte_out,commands.cost,commands.date,commands.reason,d_to.code as 'to',commands.status")
            ->leftJoin('employees','employees.id','=','commands.employee_id')
            ->leftJoin('articles','articles.id','=','commands.article_id')
            ->leftJoin('locations as d_to','d_to.id','=','commands.location_id')
            ->leftJoin('stocks as s','s.id','=','commands.stock_id')
            ->leftJoin('locations as d_from','s.location_id','=','d_from.id');
    }

    public function scopePercentagPending($query)
    {
        $pendings=$this->newQuery()->where('status','pending')
            ->count();
        $total=$this->newQuery()->count();
        if($total!=0)
        return $pendings*100/$total;
        return 'not available';
    }

}
