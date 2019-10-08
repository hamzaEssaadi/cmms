<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table='equipments';
    public function supplier()
    {
        return $this->belongsTo(Provider::class,'supplier_id');
    }
    public function manufacturer()
    {
        return $this->belongsTo(Provider::class,'manufacturer_id');
    }
    public function responsible()
    {
        return $this->belongsTo(Employee::class,'employee_id')->withTrashed();
    }
    public function equipment_type()
    {
        return $this->belongsTo(Equipment_type::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function spares()
    {
        return $this->hasMany(Spare::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class);
    }

    public function rest()
    {
//        $somme=$this->newQuery()->selectRaw('sum(amount)')->from('payments')
//            ->where('equipment_id',$this->id)->get();
        // another way
        $somme=(double)$this->payments->sum('amount');
        $cost=(double)$this->cost;
        return (double)($cost-$somme);
    }

    public function drawings()
    {
        return $this->hasMany(Drawing::class);
    }

    public function scopeAvailableEquipment($query,$id_order)
    {
        return $this->newQuery()->select('id','code')->
            whereRaw("id not in (select equipment_id from work_equipments where work_order_id=$id_order)")
            ->get();
    }

    public function scopeIsAvailableEquipment($query,$id_equipment,$id_order)
    {
        $data= $this->newQuery()->select('id')->
        whereRaw("id not in (select equipment_id from work_equipments where work_order_id=$id_order)")
            ->get();
        foreach ($data as $eq)
        {
            if($eq->id==$id_equipment)
                return 1;
        }
        return 0;
    }

    public function scopeChartByManufacturer($query)
    {
        return $this->newQuery()->selectRaw('providers.code as manufacturer,count(equipments.id)  as nb')
            ->rightJoin('providers','providers.id','=','manufacturer_id')
            ->where('providers.type','manufacturer')
            ->groupBy('manufacturer')
            ->get();
    }
    public function scopeChartBySuppliers($query)
    {
        return $this->newQuery()->selectRaw('providers.code as supplier,count(equipments.id) as nb')
            ->rightJoin('providers','providers.id','=','supplier_id')
            ->where('providers.type','supplier')
            ->groupBy('supplier')
            ->get();
    }


}
